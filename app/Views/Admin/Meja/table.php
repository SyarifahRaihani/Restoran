<?=$this->extend('backend/template')?>
  
  <?=$this->section('content')?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
    <h5 class="card-header">Tabel Meja</h5>
          <div class="card-body">
          <button class="btn btn-success mb-2" id="btn-tambah">Tambah</button>
          <div class="table-responsive">
            <table id='table-pelanggan' class="datatable table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Meja</th>
                  <th>Kapasitas</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
            </table>
          </div>
          </div>
    </div>
</div>

<!-- Modal -->

<div id="modalForm" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Meja </h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="formMeja"  method="post" action="<?=base_url('meja')?>" >
        <input type="hidden" name="id" />
        <input type="hidden" name="_method" />
        <div class="mb-3">
          <label class="form-label">Nama Meja</label>
          <input type="text" name="meja" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Kapasitas</label>
          <input type="number" name="kapasitas" class="form-control" />
        </div>
        <div class="mb-3">
          <label class="form-label">Status</label>
            <select name="status" class="form-control">
              <option value="1">Tersedia</option>
              <option value="2">Sudah Direservasi</option>
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
<?=$this->endSection()?>

<?=$this->section('script')?>
<script src="https://cdn.jsdelivr.net/gh/agoenxz2186/submitAjax@develop/submit_ajax.js">
  </script>
  <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
  <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script>
  $(document).ready(function(){

    $('form#formMeja').submitAjax({
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
        $('form#formMeja').submit();
    });

    $('button#btn-tambah').on('click', function(){
      $('#modalForm').modal('show');
      $('form#formMeja').trigger('reset');
      $('input[name=_method]').val('');
    });

    $('table#table-pelanggan').on('click', '.btn-edit', function(){
        let id = $(this).data('id');
        let baseurl = "<?=base_url()?>";
        $.get(`${baseurl}/meja/${id}`).done((e)=>{
          $('input[name=id]').val(e.id);
          $('input[name=meja]').val(e.meja);
          $('input[name=kapasitas]').val(e.kapasitas);
          $('input[name=status]').val(e.status);
          $('#modalForm').modal('show');
          $('input[name=_method]').val('patch');
        });
    });

    $('table#table-pelanggan').on('click', '.btn-hapus', function(){
      let konfirmasi = confirm('Data Pelanggan akan dihapus, mau dilanjutkan?');

      if(konfirmasi === true){
        let _id = $(this).data('id');
        let baseurl = "<?=base_url()?>";

        $.post(`${baseurl}/meja`, {id:_id, _method:'delete'}).done(function(e){
          $('table#table-pelanggan').DataTable().ajax.reload();
        });
      }
    });

      $('table#table-pelanggan').DataTable({
        Processing: true,
        serverSide: true,
        ajax:{
          url: "<?=base_url('meja/all')?>",
          method: 'GET'
        },
        columns: [
          { data: 'id', sortable:false, searchable:false,
          render: (data,type,row,meta)=>{
            return meta.settings._iDisplayStart + meta.row + 1;
          }
        },
          { data: 'meja'},
          { data: 'kapasitas'},
          { data: 'status',
            render: (data, type, row, meta)=>{
              if( data === '1')
                return 'Tersedia';
              else if( data === '2' ){
                return 'Sudah direservasi';
              }
              return data;
            }
          },
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
<?=$this->endSection()?>