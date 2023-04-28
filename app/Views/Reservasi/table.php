<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.6.1.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/gh/agoenxz2186/submitAjax@develop/submit_ajax.js">
  </script>
  <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
  <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<div class="container">
  <button class="btn btn-success mb-2" id="btn-tambah">Tambah</button>

  <table id='table-pelanggan' class="datatable table table-bordered">
    <thead>
      <tr>
        <th>No</th>
        <th>No Reservasi</th>
        <th>Nama Pelanggan</th>
        <th>Tanggal Booking</th>
        <th>Waktu Booking</th>
        <th>Aksi</th>
      </tr>
    </thead>
  </table>
</div>

<div id="modalForm" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Reservasi</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="formReservasi"  method="post" action="<?=base_url('reservasi')?>" >
        <input type="hidden" name="id" />
        <input type="hidden" name="_method" />
        <div class="mb-3">
          <label class="form-label">No Reservasi</label>
          <input type="text" name="no_reservasi" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Nama Pelanggan</label>
          <input type="text" name="pelanggan_id" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Tanggal Booking</label>
          <input type="date" name="tgl_booking" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Waktu Booking</label>
          <input type="time" name="waktu_booking" class="form-control" />
        </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" id="btn-kirim">Kirim</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
    $('form#formReservasi').submitAjax({
      pre:()=>{
        $('button#btn-kirim').hide();
      },
      pasca:()=>{
        $('button#btn-kirim').show();
      },
      success:(response, status)=>{
          $("#modalForm").modal('hide');
          $("table#table-pelanggan").DataTable().ajax.reload();
          alert('Data berhasil ditambahkan')
      },
      error: (xhr, status)=>{
          alert('Maaf, data pengguna gagal direkam');
      }
    });

    $('button#btn-kirim').on('click', function(){
        $('form#formReservasi').submit();
    });

    $('button#btn-tambah').on('click', function(){
      $('#modalForm').modal('show');
      $('form#formReservasi').trigger('reset');
      $('input[name=_method]').val('');
    });

    $('table#table-pelanggan').on('click', '.btn-edit', function(){
        let id = $(this).data('id');
        let baseurl = "<?=base_url()?>";
        $.get(`${baseurl}/reservasi/${id}`).done((e)=>{
          $('input[name=id]').val(e.id);
          $('input[name=no_reservasi]').val(e.no_reservasi);
          $('input[name=pelanggan_id]').val(e.pelanggan_id);
          $('input[name=tgl_booking]').val(e.tgl_booking);
          $('input[name=waktu_booking]').val(e.waktu_booking);
          $('#modalForm').modal('show');
          $('input[name=_method]').val('patch');
        });
    });

    $('table#table-pelanggan').on('click', '.btn-hapus', function(){
      let konfirmasi = confirm('Data Pelanggan akan dihapus, mau dilanjutkan?');

      if(konfirmasi === true){
        let _id = $(this).data('id');
        let baseurl = "<?=base_url()?>";

        $.post(`${baseurl}/reservasi`, {id:_id, _method:'delete'}).done(function(e){
          $('table#table-pelanggan').DataTable().ajax.reload();
        });
      }
    });

      $('table#table-pelanggan').DataTable({
        Processing: true,
        serverSide: true,
        ajax:{
          url: "<?=base_url('reservasi/all')?>",
          method: 'GET'
        },
        columns: [
          { data: 'id', sortable:false, searchable:false,
          render: (data,type,row,meta)=>{
            return meta.settings._iDisplayStart + meta.row + 1;
          }
        },
          { data: 'no_reservasi'},
          { data: 'pelanggan_id'},
          { data: 'tgl_booking'},
          { data: 'waktu_booking'},
          { data: 'id', sortable:false, searchable:false,
            render: (data, type, meta, row)=>{
            var btnEdit  = `<button class='btn-edit btn-warning' data-id='${data}'> Edit </button>`;
            var btnHapus = `<button class='btn-hapus btn-danger' data-id='${data}'> Hapus </button>`;
            return btnEdit + btnHapus;
          } 
        }
        ]
      });
  });
</script>