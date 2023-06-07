<?= $this->extend('backend/template') ?>

<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
    <h5 class="card-header">Tabel Menu</h5>
          <div class="card-body">
            <button class="btn btn-success mb-2" id="btn-tambah">Tambah</button>
            <table id='table-pelanggan' class="datatable table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Menu</th>
                  <th>Kategori</th>
                  <th>Harga </th>
                  <th>Foto</th>
                  <th>Aksi</th>
                </tr>
              </thead>
            </table>
          </div>
    </div>
</div>

<!-- Modal -->


<div id="modalForm" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Kategori Produk</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="formMenu" method="post" action="<?= base_url('menu') ?>">
          <input type="hidden" name="id" />
          <input type="hidden" name="_method" />
          <div class="mb-3">
            <label class="form-label">Nama Menu</label>
            <input type="text" name="nama" class="form-control" />
          </div>
          <div class="mb-3">
            <label class="form-label">Kategori</label>
            <select id="defaultSelect" class="form-select" name="kategori_id" class="form-control">
              <option >Pilih Kategori</option>
              <?php foreach ($kategori as $k) : ?>
                <option value='<?= $k['id'] ?>'><?= $k['kategori'] ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Harga</label>
            <input type="number" name="harga" class="form-control" />
          </div>
          <div class="mb-3" id="foto">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" id="btn-kirim">Kirim</button>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="https://cdn.jsdelivr.net/gh/agoenxz2186/submitAjax@develop/submit_ajax.js">
</script>

<script src="//cdn.jsdelivr.net/gh/JeremyFagis/dropify@master/dist/js/dropify.min.js"></script>
<link href="//cdn.jsdelivr.net/gh/JeremyFagis/dropify@master/dist/css/dropify.min.css" rel="stylesheet" />

<link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script>
  $(document).ready(function() {
    function buatDropify(filename = '') {
      $('div#foto').html(`<input type="file"
                                   name="berkas"
                                   data-allowed-file-extensions="png jpg bmp gif"
                                   data-default-file="${filename}">`);
      $('input[name=berkas]').dropify();
    }

    $('select[name=kategori_id]').select2({
      width: '100%',
      dropdownParent: $('form#formMenu')
    });

    $('form#formMenu').submitAjax({
      pre: () => {
        $('button#btn-kirim').hide();
      },
      pasca: () => {
        $('button#btn-kirim').show();
      },
      success: (response, status) => {
        $("#modalForm").modal('hide');
        $("table#table-pelanggan").DataTable().ajax.reload();
        alert('Data berhasil ditambahkan')
      },
      error: (xhr, status) => {
        alert('Maaf, data pengguna gagal direkam');
      }
    });

    $('button#btn-kirim').on('click', function() {
      $('form#formMenu').submit();
    });

    $('button#btn-tambah').on('click', function() {
      $('#modalForm').modal('show');
      $('form#formMenu').trigger('reset');
      $('input[name=_method]').val('');
      buatDropify();
    });

    $('table#table-pelanggan').on('click', '.btn-edit', function() {
      let id = $(this).data('id');
      let baseurl = "<?= base_url() ?>";
      $.get(`${baseurl}/menu/${id}`).done((e) => {
        $('input[name=id]').val(e.id);
        $('input[name=nama]').val(e.nama);
        $('input[name=kategori]').val(e.kategori);
        $('input[name=harga]').val(e.harga);
        buatDropify(e?.filename ?? '');
        $('#modalForm').modal('show');
        $('input[name=_method]').val('patch');
      });
    });

    $('table#table-pelanggan').on('click', '.btn-hapus', function() {
      let konfirmasi = confirm('Data Pelanggan akan dihapus, mau dilanjutkan?');

      if (konfirmasi === true) {
        let _id = $(this).data('id');
        let baseurl = "<?= base_url() ?>";

        $.post(`${baseurl}/menu`, {
          id: _id,
          _method: 'delete'
        }).done(function(e) {
          $('table#table-pelanggan').DataTable().ajax.reload();
        });
      }
    });

    $('table#table-pelanggan').DataTable({
      Processing: true,
      serverSide: true,
      ajax: {
        url: "<?= base_url('menu/all') ?>",
        method: 'GET'
      },
      columns: [{
          data: 'id',
          sortable: false,
          searchable: false,
          render: (data, type, row, meta) => {
            return meta.settings._iDisplayStart + meta.row + 1;
          }
        },
        {
          data: 'nama'
        },
        {
          data: 'kategori'
        },
        {
          data: 'harga'
        },
        {
          data: 'foto',
          render: (data, type, meta, row) => {
            return  `<img src="/uploads/${data}" height="60px">`;
          }
        },
        {
          data: 'id',
          sortable: false,
          searchable: false,
          render: (data, type, meta, row) => {
            var btnEdit = `<button class='btn-edit btn-warning' data-id='${data}'> Edit </button>`;
            var btnHapus = `<button class='btn-hapus btn-danger' data-id='${data}'> Hapus </button>`;
            return btnEdit + btnHapus;
          }
        }
      ]
    });
  });
</script>

<?= $this->endSection() ?>