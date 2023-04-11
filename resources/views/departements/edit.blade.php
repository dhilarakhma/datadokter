@extends('app')
@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<form action="{{ route('departements.update',$departement->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Departement Name:</strong>
                <input type="text" name="name" value="{{ $departement->name }}" class="form-control" placeholder="Departement name">
                @error('name')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Lokasi:</strong>
                <input type="location" name="location" class="form-control" placeholder="Lokasi" value="{{ $departement->location }}">
                @error('location')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
          <label for="manager_id" class="form-label"><strong>Manager Id :</strong></label>
          <select id="manager_id" name="manager_id" class="form-control" >
            <option selected>Choose...</option>
            <option value="{{ $departement->manager_id }}"  <?php if (!empty($_GET['id'])) {
                                if ($departement['manager_id'] == 0) {
                                  echo "selected";
                                } else {
                                  echo "";
                                }
                              } ?>>1</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success mt-3 ml-3">Submit</button>
    </div>
</form>
@endsection