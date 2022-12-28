@extends('layouts.main')

@section('container')

<center>
    <br>
    <hr class="navbar-divider">
    <label class="label">Tabel Produksi</label>
    <hr class="navbar-divider">
    <br>
</center>

<div class="mb-5">
    <a href="/production/create" class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Tambah Produksi</a>
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
            <th class="border px-4 py-2">Projected End Date</th>
            <th class="border px-4 py-2">Projected Output Quantity</th>
            <th class="border px-4 py-2">Actual Output Quantity</th>
            <th class="border px-4 py-2">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($productions as $production)
            <tr>
                <td class="border px-4 py-2">{{ $production->production_name }}</td>
                <td class="border px-4 py-2">{{ $production->production_description }}</td>
                <td class="border px-4 py-2">{{ $production->production_projected_end_date }} 
                    @php
                        date_default_timezone_set('Asia/Jakarta');
                        $date1 = date_create($production->production_projected_end_date);
                        $date2 = date_create(date('Y-m-d'));
                        $diff = date_diff($date1,$date2);

                    @endphp
                @if ($diff->format('%a') < 0)
                    <span class="text-red-600 p-2">( {{ $diff->format('%a') }} Hari Telat )</span>
                @else
                    
                    <span class=" text-green-600 p-2">( {{ $diff->format('%a') }} Hari Lagi )</span>

                @endif
                </td>
                <td class="border px-4 py-2"> @foreach ($production->process as $pp)
                    <ul>
                    @if (in_array($pp->process_type,[1]))
                        @foreach ($pp->processMaterial as $ppm)
                           <li>  {{ $ppm->process_material_name }} / {{ $ppm->process_material_quantity }} </li>
                        @endforeach
                    @endif
                </ul>
                @endforeach</td>
                <td class="border px-4 py-2"> @foreach ($production->process as $pp)
                    <ul>
                    @if (in_array($pp->process_type,[5]))
                        @foreach ($pp->processMaterial as $ppm)
                            @if($ppm->material->material_quantity == 0)
                                @continue
                            @else
                           <li>  {{ $ppm->process_material_name }} / {{ $ppm->material->material_quantity }} </li>
                           @endif
                        @endforeach
                    @endif
                </ul>
                @endforeach</td>
                <td class="border px-4 py-2">
                    <a href="/production/{{ $production->id }}" class="bg-green-500 text-white p-2">Detail</a>
                    <a href="/production/{{ $production->id }}/edit" class="bg-blue-500 text-white p-2">Edit</a>
                    <form action="/production/{{ $production->id }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white p-2">Delete</button>
                    </form>
               
            </tr>
        @endforeach
    </tbody>
</table>

@endsection