@extends('app')
@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  {{session('success')}}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button>
</div>
@endif
<div class="text-end mb-2">
<a class="btn btn-warning" href="{{ route('dokters.chartLine') }}"> Chart</a>
  <a class="btn btn-success" href="{{ route('dokters.create') }}"> Add Dokter</a>
</div>
<table id="example" class="table table-striped" style="width:100%">
  <thead>
    <tr>
      <th scope="col">No</th>
      <th scope="col">Kode Dokter</th>
      <th scope="col">Jadwal Pelayanan</th>
      <th scope="col">Nama Dokter</th>
      <th scope="col">Jumlah</th>
      <th scope="col">Spesialisasi</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    @php $no = 1 @endphp
    @foreach ($dokters as $data)
    <tr>
      <td>{{ $no ++ }}</td>
      <!-- <td>{{ $data->id }}</td> -->
      <td>{{ $data->id_dokter }}</td>
      <td>{{ $data->bulan }}</td>
      <td>{{ 
            (isset($data->getManager->name)) ?
            $data->getManager->name :
            'Tidak Ada'
            }}
        </td>
        <td>{{ $data->detail->count() }}</td>
        <td>{{ $data->spesialisasi }}</td>
      <td>
        <form action="{{ route('dokters.destroy',$data->id) }}" method="Post">
          <a class="btn btn-primary" href="{{ route('dokters.edit',$data->id) }}">Edit</a>
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
@section('js')
<script>
  $(document).ready(function() {
    $('#example').DataTable();
  });
</script>
@endsection