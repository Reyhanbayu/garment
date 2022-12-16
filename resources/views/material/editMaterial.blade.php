@extends('layouts.main')
@section('container')
    <center>
        <br>
        <hr class="navbar-divider">
        <label class="label">Form Material</label>
        <hr class="navbar-divider">
        <br>
    </center>

    <form action="/material/{{ $material->id }}" method="POST" id="createMaterial" class="flex flex-col m-12">
        @csrf
        @method('PUT')
        <label class="label">Material Name</label>
            <div class="control">
                <input class="input" type="text" name="name" id="name" value="{{ $material->material_name }}">
            </div>
        <label class="label">Material Description</label>
            <div class="control">
              <textarea class="textarea" name="description" id="description">{{ $material->material_description }}</textarea>
            </div>
        <label class="label">Material Quantity</label>
        <div>
            <input type="number" name="quantity" id="quantity" class="input" value="{{ $material->material_quantity }}">
            
        </div>
        <label class="label">Material Measures</label>
        <select name="measure_unit" id="measure_unit" class="input">
                <option value="kg" {{ $material->material_measure_unit == 'kg' ? 'selected' : '' }}>kg</option>
                <option value="l" {{ $material->material_measure_unit == 'l' ? 'selected' : '' }}>l</option>
                <option value="m" {{ $material->material_measure_unit == 'm' ? 'selected' : '' }}>m</option>
                <option value="piece" {{ $material->material_measure_unit == 'piece' ? 'selected' : '' }}>piece</option>
            </select>
            <!--<div class="control">-->
            <!--  <div class="select" name="type" id="type">-->
            <!--    <select>-->
            <!--        <<option value="Raw Material" {{ $material->material_type == 'Raw Material' ? 'selected' : '' }}>Raw</option>-->
            <!--        <option value="Finished" {{ $material->material_type == 'Finished' ? 'selected' : '' }}>Finished</option>-->
            <!--    </select>-->
            <!--  </div>-->
            <!--</div>-->
        <br>
        <button type="submit" class="button green">Submit</button>
    </form>
@endsection