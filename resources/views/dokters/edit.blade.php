@extends('app')
@section('content')
<form action="{{ route('dokters.update', $dokter->id ) }}" method="POST" enctype="multipart/form-data">
  @method('PUT')
  @csrf
  <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
              <strong>ID Dokter:</strong>
              <input type="text" name="id_dokter" class="form-control" placeholder="ID Dokter" value="{{ $dokter->id_dokter }}" disabled>
              @error('id_dokter')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
          </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
              <strong>Bulan & Tahun Praktik:</strong>
              <input type="text" name="bulan" class="form-control" placeholder="Bulan & Tahun Praktik" value="{{ $dokter->bulan }}" >
              @error('bulan')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
          </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
              <strong>Nama Dokter :</strong>
              <select name="nama_dokter" id="nama_dokter" class="form-select">
                <option value="">Pilih</option>
                @foreach ($managers as $item)
                <option value="{{ $item->id }}" {{ ($item->id==$dokter->nama_dokter)? 'selected': ''}}>{{ $item->name }}</option>
                @endforeach
              </select>
              @error('id_nama_dokter')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
          </div>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
              <strong>Spesialisasi:</strong>
              <input type="text" name="spesialisasi" class="form-control" placeholder="Spesialisasi" value="{{ $dokter->spesialisasi }}" >
              @error('spesialisasi')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
          </div>
      </div>
      <div class="row col-xs-12 col-sm-12 col-md-12 mt-3">
          <div class="form-group col-10">
              <input type="text" name="search" id="search" class="form-control" placeholder="Masukan Hari">
              @error('search')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
          </div>
          <div class="form-group col-2">
              <button type="text" class="btn btn-secondary"> Tambah </button>
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
                <?php $no=0; ?>
                @foreach($detail as $item)
                <?php $no++?>
                <tr>
                    <td>
                        <input type="hidden" name="jadwalId{{$no}}" class="form-control" value="{{$item->id_jadwal}}">
                        <span>{{$no}}</span>
                    </td>
                    <td>
                        <input type="text" name="hari{{$no}}" class="form-control" value="{{$item->getJadwal->hari}}">
                    </td>
                    <td>
                        <input type="time" name="jamMulai{{$no}}" class="form-control" value="{{$item->jam_mulai}}" >
                    </td>
                    <td>
                        <input type="time" name="jamSelesai{{$no}}" class="form-control" value="{{$item->jam_selesai}}">
                    </td>
                    <td>
                        <input type="text" name="tempatPraktik{{$no}}" class="form-control" value="{{$item->tempat_praktik}}" >
                    </td>
                    <td>
                        <input type="text" name="keterangan{{$no}}" class="form-control" value="{{$item->keterangan}}" >
                    </td>
                    <td>
                        <a href="#" class="btn btn-sm btn-danger">X</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="col-xs-12 col-sm-12 col-md-12">
        <input type="hidden" name="jml" class="form-control" value="{{count($detail)}}" >
          <div class="form-group">
              <strong>Jumlah Jadwal:</strong>
              <input type="text" name="total" class="form-control" placeholder="Jumlah Jadwal" value="{{$dokter->hari}}">
              @error('bulan')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
          </div>
      </div>
      </div>
      <button type="submit" class="btn btn-primary mt-3 ml-3">Submit</button>
  </div>
</form>
@endsection
@section('js')
<script type="text/javascript">
    var path = "{{ route('search.jadwal') }}";
  
    $( "#search" ).autocomplete({
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
        //    console.log($("input[name=jml]").val());
            if($("input[name=jml]").val() > 0){
                for (let i = 1; i <=  $("input[name=jml]").val(); i++) {
                    id = $("input[name=jadwalId"+i+"]").val();
                    if(id==ui.item.id){
                        alert(ui.item.value+' sudah ada!');
                        break;
                    }else{
                        add(ui.item.id);
                    }
                }
            }else{
                add(ui.item.id);
            } 
           return false;
        }
      });

    function add(id){
        // console.log(id);
        const path = "{{ route('jadwals.index') }}/"+id;
        var html = "";
        var no=0;
        $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            
            success: function( data ) {
                if($('#detail tr').length > no){
                    html = $('#detail').html();
                    no = $('#detail tr').length;
                }
                no++;
                html+='<tr>'+
                        '<td>'+
                            '<input type="hidden" name="jadwalId'+no+'" class="form-control" value="'+data.id+'">'+
                            '<span>'+no+'</span>'+
                        '</td>'+
                        '<td>'+
                            '<input type="text" name="hari'+no+'" class="form-control" value="'+data.hari+'" >'+
                        '</td>'+
                        '<td>'+
                            '<input type="time" name="jamMulai'+no+'" class="form-control" value="'+data.jam_mulai+'" >'+
                        '</td>'+
                        '<td>'+
                            '<input type="time" name="jamSelesai'+no+'" class="form-control" value="'+data.jam_selesai+'" >'+
                        '</td>'+
                        '<td>'+
                            '<input type="text" name="tempatPraktik'+no+'" class="form-control" >'+
                        '</td>'+
                        '<td>'+
                            '<input type="text" name="keterangan'+no+'" class="form-control" >'+
                        '</td>'+
                        '<td>'+
                            '<a href="#" class="btn btn-sm btn-danger">Delete</a>'+
                        '</td>'+
                    '</tr>';

                    $('#detail').html(html);
                    $("input[name=jml]").val(no);
            }
          });
    }

    // function sumQty(no, q){
    //     var price = $("input[name=price"+no+"]").val();
    //     var subtotal = q*parseInt(price);
    //     $("input[name=sub_total"+no+"]").val(subtotal);
    //     console.log(q+"*"+price+"="+subtotal);
    //     sumTotal();
    // }

    // function sumTotal(){
    // var total = 0;
    //    for (let i = 1; i <=  $("input[name=jml]").val(); i++) {
    //     var sub = $("input[name=sub_total"+i+"]").val();
    //     total = total + parseInt(sub);
    //    }
    //    $("input[name=total]").val(total);
    // }
  
</script>
@endsection