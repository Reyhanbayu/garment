@extends('layouts.main')
@section('container')
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
        <div >
            <input type="number" name="quantity" id="quantity" class="input">
            
        </div>
        <label class="label">Material Measure</label>
        <div>
            <select name="measure_unit" id="measure_unit" class="input">
                <option value="kg">kg</option>
                <option value="l">l</option>
                <option value="m">m</option>
                <option value="piece">piece</option>
            </select>
        </div>
        
        <!--<label class="label">Material</label>-->
        <!--    <div class="control">-->
        <!--      <div class="select" name="type" id="type">-->
        <!--        <select>-->
        <!--            <option value="Raw Material" selected>Raw</option>-->
        <!--            <option value="Finished">Finished</option>-->
        <!--        </select>-->
        <!--      </div>-->
        <!--    </div>-->
        <br>
        <button type="submit" class="button green">Submit</button>
    </form>
    @if (session()->has('success'))
        <div class="bg-green-500 text-black p-2">
            {{ session('success') }}
        </div>
        <script>
            alert('succes');
        </script>
    @endif
    
@endsection