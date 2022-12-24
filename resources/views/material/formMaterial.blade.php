@extends('layouts.main')
@section('container')
@if (session()->has('success'))
<div class="bg-green-500 text-black p-2">
    {{ session('success') }}
</div>
<script>
    alert('succes');
</script>
@endif
    <center>
        <br>
        <hr class="navbar-divider">
        <label class="label">Form Material</label>
        <hr class="navbar-divider">
        <br>
    </center>

    @if ($errors->any())

        <script>
            alert($errors);
        </script>

    @endif
    
    <form action="/material" method="POST" id="createMaterial" class="flex flex-col m-12">
        
        @csrf
        <label class="label">Material Name</label>
            <div class="control">
                <input class="input" type="text" name="name" id="name" placeholder="Material Name">
            </div>
        <label class="label">Material Description</label>
            <div class="control">
              <textarea class="textarea" name="description" id="description" placeholder="Material Description"></textarea>
            </div>
        <label class="label">Material Quantity</label>
        <div class="flex">
            <input type="number" name="quantity" id="quantity" class="input">
<<<<<<< HEAD
            <div>
                <select name="measure_unit" id="measure_unit" class="input">
                    <option value="kg">kg</option>
                    <option value="l">l</option>
                    <option value="m">m</option>
                    <option value="piece">piece</option>
=======
            <br>
            <select name="measure_unit" id="measure_unit" class="input">
                <option value="kg">kg</option>
                <option value="l">l</option>
                <option value="m">m</option>
                <option value="piece">piece</option>
            </select>
        </div>
        <label class="label">Material</label>
            <div class="control">
              <div class="select" name="type" id="type">
                <select>
                    <option value="Raw Material">Raw</option>
                    <option value="Finished">Finished</option>
>>>>>>> 0a7e8d57910934ea413da2993820286648752b49
                </select>
            </div>
        </div>
        
        <label class="label">Material Category</label>
        <div class="select" name="category" id="category">
            <select name="category" id="selectType" class=" border border-gray-400 p-2">
                <option value="0" selected>Select to filter by Category...</option>
                @foreach ($materialCategory as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                    
                @endforeach
            </select>
    
            <select name="sub_category_id" id="selectSubType" class="border border-gray-400 p-2" disabled>
                <option value="0">Please select category first</option>
            </select>

        </div>

        <br>
        <button type="submit" class="button green">Submit</button>
    </form>

    <script src="{{ asset("js/formMaterial.js") }}"></script>
@endsection