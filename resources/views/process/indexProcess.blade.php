@extends('layouts.main')

@section('container')

<center>
    <hr class="navbar-divider">
    <label class="label">Table Process</label>
    <hr class="navbar-divider">
    <br>
</center>

<div class="">
    
    <!--<a href="/processtype/create" class="bg-blue-500 text-white px-4 py-3 rounded font-medium" style="padding: 0.5rem">Tambah Proses</a>-->
</div>
@if (session('succes'))
    <div class="bg-green-500 text-black p-2">
        {{ session('succes') }}
    </div>
    <script>
        alert('succes');
    </script>
@endif
<table class="table-auto">
    <thead>
        <tr>
            <th class="border px-4 py-2">Name</th>
            <th class="border px-4 py-2">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($processTypes as $process)
            <tr>
                <td class="border px-4 py-2">{{ $process->process_type_name }}</td>
                <td class="border px-4 py-2">
                    <a href="/processtype/{{ $process->id }}/edit" class="bg-blue-500 text-white p-2">Edit</a>
                    <!--<form action="/processtype/{{ $process->id }}" method="POST" class="inline">-->
                    <!--    @csrf-->
                    <!--    @method('DELETE')-->
                    <!--    <button type="submit" class="bg-red-500 text-white p-2">Delete</button>-->
                    <!--</form>-->
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="font-bold">
    Nb: Jalannya proses urut dari atas ke bawah
    
</div>

<center>
    <br>
    <hr class="navbar-divider">
    <label class="label">Table Production Types</label>
    <hr class="navbar-divider">
    <br>
</center>
<div class="mb-5">
    <a href="/productiontype/create" class="bg-blue-500 text-white px-4 py-3 rounded font-medium" style="padding: 0.5rem">Create</a>
</div>

@if (session('succes'))
    <div class="bg-green-500 text-black p-2">
        {{ session('succes') }}
    </div>
    <script>
        alert('succes');
    </script>
@endif

<table class="table-auto">
    <thead>
        <tr>
            <th class="border px-4 py-2">Name</th>
            <th class="border px-4 py-2">Description</th>
            <th class="border px-4 py-2">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($productionProcessTypes as $production)
            <tr>
                <td class="border px-4 py-2">{{ $production[0]->production_type->production_type_name }}</td>
                <td class="border px-4 py-2">
                    @foreach ($production as $ps)
                        @if($ps->process_type_id == 1 || $ps->process_type_id ==5)
                            @continue
                        @else
                        {{ $ps->process_type->process_type_name }} <br>
                        @endif

                        
                    @endforeach
                </td>
                {{-- Link Benerin --}}
                <td class="border px-4 py-2">
                    <a href="/productiontype/{{ $production[0]->production_type->id }}/edit" class="bg-blue-500 text-white p-2">Edit</a>
                    <!--<form action="/productiontype/{{ $production[0]->production_type->id }}" method="POST" class="inline">-->
                    <!--    @csrf-->
                    <!--    @method('DELETE')-->
                    <!--    <button type="submit" class="bg-red-500 text-white p-2">Delete</button>-->
                    <!--</form>-->
            </tr>
        @endforeach
    </tbody>
</table>

<center>
    <br>
    <hr class="navbar-divider">
    <label class="label">Table Person Process</label>
    <hr class="navbar-divider">
    <br>
</center>
<div class="mb-5">
    <a href="/user/create" class="bg-blue-500 text-white px-4 py-3 rounded font-medium" style="padding: 0.5rem">Create</a>
</div>

@if (session('succes'))
    <div class="bg-green-500 text-black p-2">
        {{ session('succes') }}
    </div>
    <script>
        alert('succes');
    </script>
@endif

<table class="table-auto">
    <thead>
        <tr>
            <th class="border px-4 py-2">Name</th>
            <th class="border px-4 py-2">Description</th>
            <th class="border px-4 py-2">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($personProcesses as $person)
            <tr>
                <td class="border px-4 py-2">{{ $person[0]->user->name }}</td>
                <td class="border px-4 py-2">
                    @foreach ($person as $ps)
                        {{ $ps->process_type->process_type_name }} <br>
                        
                    @endforeach
                </td>
                {{-- Link Benerin --}}
                <td class="border px-4 py-2">
                    <a href="/user/{{ $person[0]->user->id }}/edit" class="bg-blue-500 text-white p-2">Edit</a>
                    <!--<form action="/user/{{ $person[0]->user->id }}" method="POST" class="inline">-->
                    <!--    @csrf-->
                    <!--    @method('DELETE')-->
                    <!--    <button type="submit" class="bg-red-500 text-white p-2">Delete</button>-->
                    <!--</form>-->
            </tr>
        @endforeach
    </tbody>
@endsection