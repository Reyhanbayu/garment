@extends('layouts.main')
@section('container')
    <center>
        <br>
        <hr class="navbar-divider">
        <label class="label">Form Produksi</label>
        <hr class="navbar-divider">
        <br>
    </center>
    {{-- {!! QrCode::size(100)->generate(Request::url()); !!} --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            
        </div>
        <script>
            alert('Please fill all the fields');
        </script>
    @endif
    <form action="/production" method="POST" id="createProduction" class="flex flex-col m-12">
        @csrf
        <label class="label">Production Name</label>
        <input class="input" type="text" name="name" id="name" placeholder="Production Name">
        <label class="label">Production Type</label>
        <select name="production_type" id="production_type" class="border border-gray-400 p-2">
            @foreach ($productionType as $type)
            <option value="{{ $type->id }}">{{ $type->production_type_name }}</option>
            @endforeach
        </select>
        <label class="label">Production Description</label>
        <textarea class="textarea" name="description" id="description" placeholder="Production Description"></textarea>
        <label for="end_date" class="label">Production End Date</label>
        <input type="date" name="end_date" id="end_date" class="border border-gray-400 p-2" value="{{ date('Y-m-d') }}">
        <div class="flex mt-2">
            <div class="label">Material</div>

        </div>
        <div class="materialContainer">
            <div class="flex h-20">
                <div class="flex flex-col w-1/3">
                    <label for="input_quantity" class="label">Quantity Material</label>
                    <input type="number" name="input_quantity_1" id="input_quantity_1" class="border border-gray-400 rounded-sm p-3 h-12" min="0" value="{{ $materials[0]->material_quantity }}">
                </div>
                <div class="flex flex-col w-2/3">
                    <label for="material_id" class="label">Material Type</label>
                    <select name="material_id_1" id="material_id_1" class="border border-gray-400 rounded-sm p-3 h-12" onchange="inputQuantity(1)">
                        @foreach ($materials as $material)
                            <option value="{{ $material->id }}">{{ $material->material_name }}</option>
                        @endforeach
                    </select>
                </div>
                
            </div>

        </div>
        <button id="materialButton" type="button" class="bg-blue-500 w-full m-0 p-2 text-white rounded-sm">Add</button>
        <input type="hidden" name="totalMaterial" id="totalMaterial" value="1">
        <label for="output_quantity" class="label mt-2">Projected Output</label>
        <div class="flex">
            @foreach ($ukurans as $ukuran)
            <div class="flex flex-col">
                <label for="output_quantity">{{ $ukuran->name }}</label>
                <input type="number" name="output_quantity_{{ $ukuran->id }}" id="output_quantity_{{ $ukuran->id }}" class="border border-gray-400 p-2" value="0" min="0">
            </div>
            @endforeach
        </div>
       <br>
        <button type="submit" class="button green">Submit</button>

    </form>
    @if (session('succes'))
        <div class="bg-green-500 text-white p-2">
            {{ session('succes') }}
            
        </div>
        <script>
            console.log('succes');
        </script>
    @endif

    <script src="{{ asset('js/production.js') }}"></script>

@endsection