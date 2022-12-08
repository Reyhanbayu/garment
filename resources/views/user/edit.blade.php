@extends('layouts.main')
@section('container')

<center>
    <br>
    <hr class="navbar-divider">
    <label class="label">Create ser</label>
    <hr class="navbar-divider">
    <br>
</center>

<form action="/user/{{ $user->id }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label for="name" class="sr-only">Name</label>
        <input type="text" name="name" id="name" placeholder="Your Name" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('name') border-red-500 @enderror" value="{{ $user->name }}">
        @error('name')
            <div class="text-red-500 mt-2 text-sm">
                {{ $message }}
            </div>
        @enderror
    </div>



    <div class="mb-4">
        <label class="label">Role</label>
        <select name="process_type_name" id="role" class="bg-gray-100 border-2 w-full p-4 rounded-lg">
            @foreach ($processTypes as $process)
            @if ($process->id == $process->process_type_name)
                <option value="{{ $process->id }}" selected>{{ $process->process_type_name }}</option>
            @else
                <option value="{{ $process->id }}">{{ $process->process_type_name  }}</option>    
            @endif

            @endforeach
        </select>
    </div>

    <h2>Isi untuk mendaftar sebagai user</h2>
    <div class="mb-4">
        <label for="email" class="sr-only">Email</label>
        <input type="text" name="email" id="email" placeholder="Your Email" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('email') border-red-500 @enderror" value="{{ $user->email }}">
        @error('email')
            <div class="text-red-500 mt-2 text-sm">
                {{ $message }}
            </div>
        @enderror
    </div>
    
    
    <div class="mb-4">
        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" id="password" placeholder="Choose a password" class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('password') border-red-500 @enderror" value="">
        @error('password')
            <div class="text-red-500 mt-2 text-sm">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium w-full">Register</button>
    </div>
</form>
@endsection