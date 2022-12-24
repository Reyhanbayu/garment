@extends('layouts.main')
@section('container')

    <center>
        <br>
        <hr class="navbar-divider">
        <label class="label">Tabel Material</label>
        <hr class="navbar-divider">
        <br>
    </center>
    <div class="mb-5 flex flex-row justify-between">
        <div class="flex flex-row w-1/3">
            <select name="category" id="selectType" class=" border border-gray-400 p-2">
                <option value="0" selected>Select to filter by Category...</option>
                @foreach ($materialCategory as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    
                @endforeach
            </select>
    
            <select name="type" id="selectSubType" class="border border-gray-400 p-2" disabled>
                <option value="0">Please select category first</option>
            </select>
            <input type="text" name="search" id="search" class="border border-gray-400 p-2" placeholder="Search by name...">
            
        </div>
        
        <a href="/material/create" class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Tambah Material</a>
        
    </div>

    <div>
        
        
    </div>
 
    @if (session('succes'))
        <div class="bg-green-500 text-black p-2">
            {{ session('succes') }}
        </div>
        <script>
            alert('succes');
        </script>
        
    @endif
    <table class="table-auto" id="materialTable">
        <thead>
            <tr>
                <th class="border px-4 py-2 w-1/4">Name</th>
                <th class="border px-4 py-2 w-1/4">Description</th>
                <th class="border px-4 py-2 w-1/4" >Quantity</th>
                <th class="border px-4 py-2 w-1/4">Action</th>
            </tr>
        </thead>
        <tbody id="materialTableBody">
            @foreach ($materials as $material)
                <tr class="{{ $material->material_sub_category_id }}">
                    <td class="border px-4 py-2">{{ $material->material_name }}</td>
                    <td class="border px-4 py-2">{{ $material->material_description }}</td>
                    <td class="border px-4 py-2">{{ $material->material_quantity }} {{ $material->material_measure_unit }}</td>
                    
                    <td class="border px-4 py-2">
                        <a href="/material/{{ $material->id }}" class="bg-green-500 text-white p-2">History</a>
                        <a href="/material/{{ $material->id }}/edit" class="bg-blue-500 text-white p-2">Edit</a>
                        <form action="/material/{{ $material->id }}" method="POST" class="inline" onsubmit="return confirm('are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white p-2">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if (session()->has('success'))
    <div class="bg-green-500 text-black p-2">
        {{ session('success') }}
    </div>
    <script>
        alert('succes');
    </script>
    @endif

    <script src="{{ asset("js/material.js") }}"></script>
    @endsection