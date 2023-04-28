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
        <th>Kode Produk</th>
        <th>Nama Produk</th>
        <th>Deskripsi</th>
        <th>Kategori</th>
        <th>Status</th>
        <th>Harga Jual</th>
        <th>Diskon</th>
        <th>Harga Standar</th>
        <th>Foto</th>
        <th>Terjual</th>
        <th>Aksi</th>
      </tr>
    </thead>
  </table>
</div>

<div id="modalForm" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Kategori Produk</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="formProduk"  method="post" action="<?=base_url('produk')?>" >
        <input type="hidden" name="id" />
        <input type="hidden" name="_method" />
        <div class="mb-3">
          <label class="form-label">Kode produk</label>
          <input type="text" name="kode" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Nama produk</label>
          <input type="text" name="nama" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Deskripsi</label>
          <input type="text" name="deskripsi" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Kategori</label>
          <input type="text" name="kategori_id" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Status</label>
            <select name="status" class="form-control">
              <option value="T">Tersedia</option>
              <option value="H">Habis</option>
            </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Harga Jual</label>
          <input type="number" name="harga_jual" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Diskon</label>
          <input type="number" name="diskon" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Harga Standar</label>
          <input type="number" name="harga_standar" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Foto</label>
          <input type="image" name="foto" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Terjual</label>
          <input type="number" name="terjual" class="form-control" />
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
    $('form#formProduk').submitAjax({
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
        $('form#formProduk').submit();
    });

    $('button#btn-tambah').on('click', function(){
      $('#modalForm').modal('show');
      $('form#formProduk').trigger('reset');
      $('input[name=_method]').val('');
    });

    $('table#table-pelanggan').on('click', '.btn-edit', function(){
        let id = $(this).data('id');
        let baseurl = "<?=base_url()?>";
        $.get(`${baseurl}/produk/${id}`).done((e)=>{
          $('input[name=id]').val(e.id);
          $('input[name=kode]').val(e.kode);
          $('input[name=nama]').val(e.nama);
          $('input[name=deskripsi]').val(e.deskripsi);
          $('input[name=kategori_id]').val(e.kategori_id);
          $('input[name=status]').val(e.status);
          $('input[name=harga_jual]').val(e.harga_jual);
          $('input[name=diskon]').val(e.diskon);
          $('input[name=harga_standar]').val(e.harga_standar);
          $('input[name=foto]').val(e.foto);
          $('input[name=terjual]').val(e.terjual);
          $('#modalForm').modal('show');
          $('input[name=_method]').val('patch');
        });
    });

    $('table#table-pelanggan').on('click', '.btn-hapus', function(){
      let konfirmasi = confirm('Data Pelanggan akan dihapus, mau dilanjutkan?');

      if(konfirmasi === true){
        let _id = $(this).data('id');
        let baseurl = "<?=base_url()?>";

        $.post(`${baseurl}/produk`, {id:_id, _method:'delete'}).done(function(e){
          $('table#table-pelanggan').DataTable().ajax.reload();
        });
      }
    });

      $('table#table-pelanggan').DataTable({
        Processing: true,
        serverSide: true,
        ajax:{
          url: "<?=base_url('produk/all')?>",
          method: 'GET'
        },
        columns: [
          { data: 'id', sortable:false, searchable:false,
          render: (data,type,row,meta)=>{
            return meta.settings._iDisplayStart + meta.row + 1;
          }
        },
          { data: 'kode'},
          { data: 'nama'},
          { data: 'deskripsi'},
          { data: 'kategori_id'},
          { data: 'status',
            render: (data, type, row, meta)=>{
              if( data === 'T')
                return 'Tersedia';
              else if( data === 'H' ){
                return 'Habis';
              }
              return data;
            }
          },
          { data: 'harga_jual'},
          { data: 'diskon'},
          { data: 'harga_standar'},
          { data: 'foto'},
          { data: 'terjual'},
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