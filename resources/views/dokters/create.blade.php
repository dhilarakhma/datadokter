@extends('app')
@section('content')
<form action="{{ route('dokters.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>ID Dokter:</strong>
                <input type="text" name="id_dokter" class="form-control" placeholder="ID Dokter">
                @error('name')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Bulan & Tahun Praktik:</strong>
                <input type="text" name="bulan" class="form-control" placeholder="Bulan & Tahun Praktik">
                @error('location')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nama Dokter:</strong>
                <select name="nama_dokter" id="nama_dokter" class="form-select" >
                        <option value="">Pilih</option>
                        @foreach($managers as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                </select>
                @error('alias')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Spesialisasi:</strong>
                <input type="text" name="spesialisasi" class="form-control" placeholder="Spesialisasi">
                @error('name')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row col-xs-12 col-sm-12 col-md-12 mt-3">
            <div class="col-md-10 form-group">
                <input type="text" name="search" id="search" class="form-control" placeholder="Masukan Hari">
                @error('name')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-2 form-group text-center">
                <button class="btn btn-secondary" type="button" name="btnAdd" id="btnAdd"><i class="fa fa-plus"></i>Tambah</button>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Hari</th>
                    <th scope="col">Jam Mulai</th>
                    <th scope="col">Jam Selesai</th>
                    <th scope="col">Tempat Praktik</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="detail">
                    
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-primary mt-3 ml-3">Submit</button>
    </div>
</form>
@endsection
@section('js')
<script type="text/javascript">
    var path = "{{ route('search.jadwal') }}";
  
    $("#search").autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term
            },
            success: function( data ) {
               response( data );
            }
          });
        },
        select: function (event, ui) {
           $('#search').val(ui.item.label);
        //    console.log(ui.item); 
           add(ui.item.id);
           return false;
        }
      });
      function add(id){
        const path = "{{ route('jadwals.index') }}/" + id;
        var html = "";
        var no=0;
        if($('#detail tr').length > 0){
            var html = $('#detail').html();
            no = no+$('#detail tr').length;
        }
        
        $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            success: function( data ) {
                console.log(data); 
                no++;
                html += '<tr>' +
                   '<td>'+no+'<input type="hidden" name="id_jadwal'+no+'" class="form-control" value="'+data.id+'"></td>' +
                    '<td><input type="text" name="hari'+no+'" class="form-control" value="'+data.hari+'"></td>' +
                    '<td><input type="text" name="jam_mulai'+no+'" class="form-control" value="'+data.jam_mulai+'"></td>' +
                    '<td><input type="text" name="jam_selesai'+no+'" class="form-control" value="'+data.jam_selesai+'"></td>' +
                    '<td><input type="text" name="tempat_praktik'+no+'" class="form-control"></td>' +
                    '<td><input type="text" name="keterangan'+no+'" class="form-control"></td>' +
                    '<td><a href="#" class="btn btn-sm btn-danger">X</a></td>' +
                '</tr>';
             $('#detail').html(html);
            }
        });
        
    }
</script>
@endsection