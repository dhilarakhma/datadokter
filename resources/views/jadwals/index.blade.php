@extends('app')
@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="text-end mb-2">
                    <a class="btn btn-light" href="{{ route('jadwals.exportExcel') }}"> Export</a>
                    <a class="btn btn-success" href="{{ route('jadwals.create') }}"> Add Jadwal</a>
                </div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Hari</th>
            <th scope="col">Jam Mulai</th>
            <th scope="col">Jam Selesai</th>
            <th width="280px">Action</th>
        </tr>
    </thead>
    @foreach ($jadwals as $jadwal)
    <tr>
        <td>{{ $jadwal->id }}</td>
        <td>{{ $jadwal->hari }}</td>
        <td>{{ $jadwal->jam_mulai }}</td>
        <td>{{ $jadwal->jam_selesai }}</td>
        <td>
            <form action="{{ route('jadwals.destroy',$jadwal->id) }}" method="Post">
                <a class="btn btn-primary" href="{{ route('jadwals.edit',$jadwal->id) }}">Edit</a>
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
    </tbody>
</table>
@endsection