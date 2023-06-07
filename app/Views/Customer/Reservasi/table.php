<?= $this->extend('backend/template') ?>

<?= $this->section('content') ?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
    <h5 class="card-header">Tabel User</h5>
          <div class="card-body">
        <button class="btn btn-success mb-2" id="btn-tambah">Tambah</button>
        <table id='table-pelanggan' class="datatable table table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Tanggal Booking</th>
              <th>Waktu Booking</th>
              <th>Meja</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
</div>

<div id="modalForm" class="modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Reservasi</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="formReservasi" method="post" action="<?= base_url('reservasi') ?>">
          <input type="hidden" name="id" />
          <input type="hidden" name="_method" />
          <div class="mb-3">
            <div class="mb-3">
              <label class="form-label">Tanggal Booking</label>
              <input type="date" name="tgl_booking" class="form-control" />
            </div>
            <div class="mb-3">
              <label class="form-label">Waktu Booking</label>
              <input type="time" name="waktu_booking" class="form-control" />
            </div>
            <div class="mb-3">
              <label class="form-label">meja</label>
              <select name="meja_id" class="form-control">
                <option>Pilih meja</option>
                <?php foreach ($meja as $k) : ?>
                  <option value='<?= $k['id'] ?>'><?= $k['meja'] ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Status</label>
              <select name="status" class="form-control">
                <option value="1">Konfirmasi</option>
                <option value="2">Reservasi Di Terima</option>
                <option value="3">Reservasi Di tolak</option>
                <option value="4">Reservasi Batal</option>
              </select>
            </div>
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
  <link href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
  <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

<script>
  $(document).ready(function() {
    $('select[name=pelanggan_id]').select2({
      width: '100%',
      dropdownParent: $('form#formReservasi')
    });

    $('form#formReservasi').submitAjax({
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
      $('form#formReservasi').submit();
    });

    $('button#btn-tambah').on('click', function() {
      $('#modalForm').modal('show');
      $('form#formReservasi').trigger('reset');
      $('input[name=_method]').val('');
    });

    $('table#table-pelanggan').on('click', '.btn-edit', function() {
      let id = $(this).data('id');
      let baseurl = "<?= base_url() ?>";
      $.get(`${baseurl}/reservasi/${id}`).done((e) => {
        $('input[name=id]').val(e.id);
        $('input[name=user]').val(e.user);
        $('input[name=tgl_booking]').val(e.tgl_booking);
        $('input[name=waktu_booking]').val(e.waktu_booking);
        $('input[name=meja]').val(e.meja);
        $('input[name=status]').val(e.status);
        $('#modalForm').modal('show');
        $('input[name=_method]').val('patch');
      });
    });

    $('table#table-pelanggan').on('click', '.btn-hapus', function() {
      let konfirmasi = confirm('Data Pelanggan akan dihapus, mau dilanjutkan?');

      if (konfirmasi === true) {
        let _id = $(this).data('id');
        let baseurl = "<?= base_url() ?>";

        $.post(`${baseurl}/reservasi`, {
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
        url: "<?= base_url('reservasi/all') ?>",
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
          data: 'user'
        },
        {
          data: 'tgl_booking'
        },
        {
          data: 'waktu_booking'
        },
        {
          data: 'meja'
        },
        { data: 'status',
            render: (data, type, row, meta)=>{
              if( data === '1')
                return '<span class="text-dark">Menunggu Konfirmasi</span>';
              else if( data === '2' ){
                return '<span class="text-success">Reservasi Diterima</span>';
              }
              else if(data === '3'){
              return '<span class="text-danger">Reservasi Ditolak</span>';
              }
              else if(data === '4'){
              return '<span class="text-danger">Reservasi Dibatalkan</span>';
              }
              return data;
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