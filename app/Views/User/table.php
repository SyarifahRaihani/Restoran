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
        <th>Nama</th>
        <th>Gender</th>
        <th>Email</th>
        <th>Level</th>
        <th>Aksi</th>
      </tr>
    </thead>
  </table>
</div>

<div id="modalForm" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form User</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="formUser"  method="post" action="<?=base_url('user')?>" >
        <input type="hidden" name="id" />
        <input type="hidden" name="_method" />
        <div class="mb-3">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" name="nama" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Jenis Kelamin</label>
            <select name="gender" class="form-control">
              <option value="L">Laki-Laki</option>
              <option value="P">Perempuan</option>
            </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Sandi</label>
          <input type="password" name="sandi" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Level</label>
          <select name="level" class="form-control">
            <option value="P">Petugas</option>
            <option value="C">Customer</option>
            <option value="A">Administrator</option>
          </select>
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
    $('form#formUser').submitAjax({
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
        $('form#formUser').submit();
    });

    $('button#btn-tambah').on('click', function(){
      $('#modalForm').modal('show');
      $('form#formUser').trigger('reset');
      $('input[name=_method]').val('');
    });

    $('table#table-pelanggan').on('click', '.btn-edit', function(){
        let id = $(this).data('id');
        let baseurl = "<?=base_url()?>";
        $.get(`${baseurl}/user/${id}`).done((e)=>{
          $('input[name=id]').val(e.id);
          $('input[name=nama]').val(e.nama);
          $('input[name=gender]').val(e.gender);
          $('input[name=email]').val(e.email);
          $('input[name=level]').val(e.level);
          $('#modalForm').modal('show');
          $('input[name=_method]').val('patch');
        });
    });

    $('table#table-pelanggan').on('click', '.btn-hapus', function(){
      let konfirmasi = confirm('Data Pelanggan akan dihapus, mau dilanjutkan?');

      if(konfirmasi === true){
        let _id = $(this).data('id');
        let baseurl = "<?=base_url()?>";

        $.post(`${baseurl}/user`, {id:_id, _method:'delete'}).done(function(e){
          $('table#table-pelanggan').DataTable().ajax.reload();
        });
      }
    });

    $('table#table-pelanggan').DataTable({
      processing: true,
      serverSide: true,
      ajax:{
        url: "<?=base_url('user/all')?>",
        method: 'GET'
      },
      columns: [
        { data: 'id', sortable:false, searchable:false,
          render: (data,type,row,meta)=>{
            return meta.settings._iDisplayStart + meta.row + 1;
          }
        },
        { data: 'nama' },
        { data: 'gender',
          render: (data, type, row, meta)=>{
            if( data === 'L'){
                return 'Laki-Laki';
              }else if( data === 'P' ){
                return 'Perempuan';
              }
              return data;
            }
          },
        { data: 'email' },
        { data: 'level', 
          render: (data, type, row, meta)=>{
              if( data === 'P')
                return 'Petugas';
              else if( data === 'C' ){
                return 'Customer';
              }else if( data === 'A' ){
                return 'Admin';
              }
              return data;
            }
        },
        { data: 'id',
          render: (data, type, meta, row)=>{
            var btnEdit  = `<button class='btn-edit btn-primary' data-id='${data}'> Edit </button>`;
            var btnHapus = `<button class='btn-hapus btn-danger' data-id='${data}'> Hapus </button>`;
            return btnEdit + btnHapus;
          }
        },
      ]
    });
  });
</script>