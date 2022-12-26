@extends('layouts.main')
@section('container')

<center>
    <br><br>
    <hr class="navbar-divider">
    <label class="label">Cretae Process Form</label>
    <hr class="navbar-divider">
    <br>
</center>
<form action="/process" method="POST" >
    @csrf
    <h1></h1>
    <div class="mb-4">
        <input type="hidden" name="production_id" id="production_id" value="{{ $production->id }}">
        
        <input type="hidden" name="process_status" id="process_status" value="menunggu">
    </div>
    
    <div class="mb-4">
        <input type="hidden" name="process_name" id="process_name" placeholder="Name" class="bg-gray-100 border-2 w-full p-4 rounded-lg" value="">
    </div>
    <div class="mb-4">
        <label for="process_id" >Pilih Prosess</label>
        <select id="process_id" name="process_id" class="bg-gray-100 border-2 w-full p-4 rounded-lg ">
            @foreach ($processes as $process)
            @if ($process->process_type == 1 || $process->process_type == 5)
                @continue
            @else
            <option value="{{ $process->id }}" class="{{ $process->process_type }}">{{ $process->process_name }}</option>
            @endif
                
                
            @endforeach
        </select>
    </div>
    <div class="mb-4">
        <label for="user_id">Pilih User</label>
        <select name="user_id" id="user_id" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
            @foreach ($person as $user)
                <option value="{{ $user->user->id }}">{{ $user->user->name }}</option>
            @endforeach
        </select>
    </div>
    


    <div class="mb-4" id="potongOutput">
        <div>
            <label for="process_output_material_id" >Pilih Output</label>
            <select name="process_output_material_id" id="process_output_material_id" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
                <option value="0">Potong Baju</option>
                @foreach ($materials as $material)
                    <option value="{{ $material->id }}">{{ $material->material_name }}</option>
                @endforeach
            </select>
            <input type="number" name="process_output_quantity" id="process_output_quantity" placeholder="Quantity" class="flex bg-gray-100 border-2 w-full p-4 rounded-lg" value="{{ old('process_output_quantity') }}">
        </div>
        <div class="hidden flex-wrap" id="ukuranBagian">
            @foreach ($ukuranBagian as $item)
            <div class="flex flex-col w-1/4 mt-2">
                <h1>{{$item->material_name}}</h1>
                <input type="number" class="border border-gray-400 p-2" name="{{ "process_output_bagian_".$item->id }}" value=0 >
            </div>
        @endforeach
        </div>
    </div>
    <div>
        <button type="submit" id="submitProcess" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Create</button>
    </div>

</form>


<center>
    <br><br>
    <hr class="navbar-divider">
    <label class="label">Sub Process Table</label>
    <hr class="navbar-divider">
</center>
@foreach ($processes->whereNotIn('process_type',[1]) as $p)
    <br><br>
    <h1 class=" font-bold">{{ $p->process_name }}</h1>
    <h1>Input Quantity</h1>
    @foreach ($p->processMaterial->where('process_material_status','Input Produksi') as $pm)
    - {{ $pm->process_material_name }}/{{ $pm->process_material_quantity }} 
    <br>
    @endforeach

    @foreach ($p->subProses->GroupBy('user_id') as $subGroup)
        <div class=" border border-black">
            <h1 class="">Proses Dikerjakan oleh user {{ $subGroup[0]->user->name }}</h1>
            
            @foreach ($subGroup as $sp)
            <br>
            <form action="/subproses/{{ $sp->id }}" method="POST">
                <div class="grid grid-cols-8 gap-6 font-bold">
                <h3>Nama Material</h3>
                <h3>Projected</h3>
                <h3>Actual</h3>
                <h3>Sisa</h3>
                <h3>Ambil</h3>
                </div>
                @csrf
                @method('PUT')
                <div class="grid grid-cols-8 gap-6">
                    {{ $sp->processMaterial->process_material_name }} 
                    <input type="hidden" name="user_id" value="{{ $sp->user_id }}">
                    <input type="hidden" name="process_id" value="{{ $sp->process_id }}">
                    <p>Target : {{ $sp->sub_proses_projected }}</p>
                    <p>Target : {{ $sp->sub_proses_actual }}</p>
                    <p>Target : {{ $sp->sub_proses_projected - $sp->sub_proses_actual }}</p>
                    <input type="number" name="quantityAmbil" id="quantityAmbil" class=" border border-black" value="0" max="{{ $sp->sub_proses_projected - $sp->sub_proses_actual }}">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Update</button>
                    @if (!$sp->subProcessHistories->isEmpty())
                    <button type="button" class="bg-red-500 text-white px-4 py-3 rounded font-medium" id="button_{{$sp->id}}" onclick="openDetail({{$sp->id}})"  >Check Detail</button>
                    
                    
                    @endif
                    </form>
                    <form action="/subproses/{{ $sp->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-3 rounded font-medium">Delete</button>
                    </form>
                </div>
                <br>
                <hr class="navbar-divider">
                @if (!$sp->subProcessHistories->isEmpty())
                <div id="detail_{{ $sp->id }}" class=" mb-4 hidden">
                    <h3 class="font-bold">Detail Pengambilan</h3>
                    <div class="grid grid-cols-8 gap-6">
                    
                        <h3>Quantity</h3>
                        <h3>Time</h3>
                    </div>
                    @foreach ($sp->subProcessHistories as $history)
                       
                        <div class="grid grid-cols-8 gap-6">
                            <p>{{ $history->quantity }}</p>
                            <p>{{ $history->created_at }}</p>
                            @if ($history->is_done != 1)
                            <a href="/subproses/{{ $history->id }}" class="bg-blue-500 text-white px-4 py-3 rounded font-medium" target="_blank">Check</a>
                            <form action="/subproses/history/{{ $history->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-3 rounded font-medium">Delete</button>
                            </form>
                            <a href="/generate/{{ $history->id }}" class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Generate QR</a>
                            <button type="button" class="bg-red-500 text-white px-4 py-3 rounded font-medium" onclick="printExternal('{{ '/print/'.$history->id }}')">Print</button>
                            @else
                            <a href="/subproses/{{ $history->id }}" class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Check</a>
                            <p>Telah dikonfimasi</p>
                            @endif
                            
                        </div>
                        <br>
                        <hr class="navbar-divider">
                        <br>
                    @endforeach
                </div>
               
                
                @endif

        @endforeach
        
        </div>
    @endforeach
    
@endforeach


<script src="{{ asset("js/process.js") }}"></script>

<script>
function closeDetail(id){
    let detail=document.getElementById('detail_'+id);     
    detail.classList.add("hidden");
    
    let button=document.getElementById('button_'+id);
    button.onclick = function () { openDetail(id); };
}

function openDetail(id){
    let detail=document.getElementById('detail_'+id);     
    detail.classList.remove("hidden");
    
    let button=document.getElementById('button_'+id);
    button.onclick = function () { closeDetail(id); };
}


</script>

@endsection