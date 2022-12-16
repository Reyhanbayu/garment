<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
  <link rel="stylesheet" href="{{ url('css/main.css?v=1628755089081')}}">
  <link rel="stylesheet" href="{{ url('https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css')}}">

</head>
<body class=" p-4">
    <div class=" p-0">
        <h1>User {{ $subProses->subProcess->user->name }}</h1>
        <h2>Proses {{ $subProses->subProcess->process->process_name }}</h2>
        <table>
            <thead>
                <tr>
                    <th>Sub Process Material</th>
                    <th>Sisa Target</th>
                    <th>Selesai</th>
                    <th>Diserahkan</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                <tr >
                    <td class=" border border-black">{{ $subProses->subProcess->processMaterial->process_material_name }}</td>
                    <td class=" border border-black">{{ $subProses->subProcess->sub_proses_projected }}</td>
                    <td class=" border border-black">{{ $subProses->subProcess->sub_proses_actual }}</td>
                    <td class=" border border-black">{{ $subProses->quantity }}</td>
                    <td class=" border border-black">{{ $subProses->subProcess->updated_at }}</td>
                </tr>
                
            </tbody>
        </table>
        <br>
        @if ($subProses->is_done == 1)
            <h1>Sub Process Selesai dan telah dikonfirmasi</h1>
        @else
        <form action="/subproses/update/{{ $subProses->subProcess->id }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="quantity" value="{{ $subProses->quantity }}">
            <input type="hidden" name="sph_id" value="{{ $subProses->id }}">
            <input type="hidden" name="user_id" value="{{ $subProses->subProcess->user_id }}">
            <input type="hidden" name="process_id" value="{{ $subProses->subProcess->process_id }}">
            <input type="hidden" name="process_material_id" value="{{ $subProses->subProcess->process_material_id }}">
            <button type="submit" class="bg-blue-500 text-white px-4 py-3 rounded font-medium">Konfirmasi</button>
        
        </form>
        @endif
    </div>
</body>
<script src="{{ url('https://cdn.tailwindcss.com') }}"></script>
<script type="text/javascript" src="{{ url('js/main.min.js?v=1628755089081')}}"></script>
</html>


