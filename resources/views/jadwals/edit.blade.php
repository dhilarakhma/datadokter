@extends('app')
@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<form action="{{ route('jadwals.update',$jadwal->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Hari :</strong>
                <input type="text" name="hari" value="{{ $jadwal->hari }}" class="form-control" placeholder="Hari">
                @error('hari')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Jam Mulai:</strong>
                <input type="time" name="jam_mulai" class="form-control" placeholder="jam_mulai" value="{{ $jadwal->jam_mulai }}">
                @error('jam_mulai')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Jam Selesai:</strong>
                <input type="time" name="jam_selesai" value="{{ $jadwal->jam_selesai }}" class="form-control" placeholder="jam_selesai">
                @error('jam_selesai')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-success mt-3 ml-3">Submit</button>
    </div>
</form>
@endsection