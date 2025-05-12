<?php
include '../helpers/isAccessAllowedHelper.php';

// cek apakah user yang mengakses adalah kepala_sekolah?
if (!isAccessAllowed('kepala_sekolah')) :
  session_destroy();
  echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
else :
  include_once '../config/connection.php';
?>


  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php include '_partials/head.php' ?>

    <meta name="description" content="Data Pengumuman" />
    <meta name="author" content="" />
    <title>Pengumuman - <?= SITE_NAME ?></title>
  </head>

  <body class="nav-fixed">
    <!--============================= TOPNAV =============================-->
    <?php include '_partials/topnav.php' ?>
    <!--//END TOPNAV -->
    <div id="layoutSidenav">
      <div id="layoutSidenav_nav">
        <!--============================= SIDEBAR =============================-->
        <?php include '_partials/sidebar.php' ?>
        <!--//END SIDEBAR -->
      </div>
      <div id="layoutSidenav_content">
        <main>
          <!-- Main page content-->
          <div class="container-xl px-4 mt-5">

            <!-- Custom page header alternative example-->
            <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
              <div class="me-4 mb-3 mb-sm-0">
                <h1 class="mb-0">Pengumuman</h1>
                <div class="small">
                  <span class="fw-500 text-primary"><?= date('D') ?></span>
                  &middot; <?= date('M d, Y') ?> &middot; <?= date('H:i') ?> WIB
                </div>
              </div>

              <!-- Date range picker example-->
              <div class="input-group input-group-joined border-0 shadow w-auto">
                <span class="input-group-text"><i data-feather="calendar"></i></span>
                <input class="form-control ps-0 pointer" id="litepickerRangePlugin" value="Tanggal: <?= date('d M Y') ?>" readonly />
              </div>

            </div>

            <!-- Tools Cetak Pengumuman -->
            <div class="card mb-4 mt-5">
              <div class="card-header">
                <div>
                  <i data-feather="settings" class="me-2 mt-1"></i>
                  Data Pengumuman
                </div>
              </div>
              <div class="card-body">
                <div class="row gx-3">
                  <div class="col-md-2 mb-3">
                    <label class="small mb-1" for="xid_tahun_penilaian_filter">Tahun Penilaian</label>
                    <select name="xid_tahun_penilaian_filter" class="form-control" id="xid_tahun_penilaian_filter" required>
                      <option value="">-- Pilih --</option>
                      <?php
                      $query_tahun_penilaian = mysqli_query($connection, 
                        "SELECT a.*, IFNULL(b.jml_penilaian, 0) AS jml_penilaian
                        FROM tbl_tahun_penilaian AS a
                        LEFT JOIN
                        (
                          SELECT  COUNT(*) AS jml_penilaian, id_tahun_penilaian
                          FROM tbl_penilaian_seleksi
                          GROUP BY  id_tahun_penilaian
                        ) AS b
                        ON a.id = b.id_tahun_penilaian
                        ORDER BY a.tahun DESC")
                      ?>
                      <?php while ($tahun_penilaian = mysqli_fetch_assoc($query_tahun_penilaian)): ?>
              
                        <option value="<?= $tahun_penilaian['id'] ?>" data-tahun="<?= $tahun_penilaian['tahun'] ?>"><?= "{$tahun_penilaian['tahun']} ({$tahun_penilaian['jml_penilaian']} data)" ?></option>
              
                      <?php endwhile ?>
                    </select>
                  </div>
                  <div class="col-md-2 mb-3">
                    <label class="small mb-1 invisible" for="xreset_filter_tahun">Reset Filter Tahun</label>
                    <button class="btn btn-dark w-100" id="xreset_filter_tahun" type="button">
                      <i data-feather="repeat" class="me-1"></i>
                      Reset Filter
                    </button>
                  </div>
                  <div class="col-md-2 mb-3">
                    <label class="small mb-1 invisible" for="xcetak_pengumuman">Filter Button</label>
                    <button class="btn btn-primary w-100" id="xcetak_pengumuman" type="button">
                      <i data-feather="printer" class="me-1"></i>
                      Cetak
                    </button>
                  </div>
                </div>
              </div>
            </div>
              
            <!-- Main page content-->
            <div class="card card-header-actions mb-4 mt-5">
              <div class="card-header">
                <div>
                  <i data-feather="flag" class="me-2 mt-1"></i>
                  Data Pengumuman
                </div>
              </div>
              <div class="card-body">
                <table id="datatablesSimple">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Tahun</th>
                      <th>Siswa</th>
                      <th>Kelas</th>
                      <th>Nilai Prestasi</th>
                      <th>Nilai Kompetensi</th>
                      <th>Daftar File Prestasi</th>
                      <th>Daftar File Kompetensi</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $query_pengumuman = mysqli_query($connection, 
                      "SELECT
                        a.id AS id_penilaian, a.nilai_kompetensi, a.nilai_prestasi,
                        b.id AS id_tahun_penilaian, b.tahun,
                        c.id AS id_siswa, c.nisn, c.nama_siswa, c.jk, c.alamat, c.tmp_lahir, c.tgl_lahir, c.no_telp, c.email,
                        IFNULL(d.jml_file_prestasi, 0) AS jml_file_prestasi,
                        IFNULL(e.jml_file_kompetensi, 0) AS jml_file_kompetensi,
                        f.id AS id_pengumuman, f.keterangan_seleksi,
                        i.id AS id_kelas, i.nama_kelas
                      FROM tbl_penilaian_seleksi AS a
                      INNER JOIN tbl_tahun_penilaian AS b
                        ON b.id = a.id_tahun_penilaian
                      INNER JOIN tbl_siswa AS c
                        ON c.id = a.id_siswa
                      LEFT JOIN
                      (
                        SELECT id_siswa, COUNT(id) jml_file_prestasi 
                        FROM tbl_prestasi_siswa 
                        GROUP BY id_siswa
                      ) AS d
                        ON c.id = d.id_siswa
                      LEFT JOIN
                      (
                        SELECT id_siswa, COUNT(id) jml_file_kompetensi
                        FROM tbl_kompetensi_siswa 
                        GROUP BY id_siswa
                      ) AS e
                        ON c.id = e.id_siswa
                      LEFT JOIN tbl_pengumuman_seleksi AS f
                        ON a.id = f.id_penilaian_seleksi
                      LEFT JOIN tbl_kelas AS i
                        ON i.id = c.id_kelas
                      ORDER BY a.id DESC") or die(mysqli_error($connection));

                    while ($pengumuman = mysqli_fetch_assoc($query_pengumuman)):
                    ?>

                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $pengumuman['tahun'] ?></td>
                        <td><?= $pengumuman['nama_siswa'] ?></td>
                        <td><?= $pengumuman['nama_kelas'] ?></td>
                        <td><?= $pengumuman['nilai_prestasi'] ?></td>
                        <td><?= $pengumuman['nilai_kompetensi'] ?></td>
                        <td>
                          <?php if (!$pengumuman['jml_file_prestasi']): ?>

                            <small class="text-muted">Tidak ada</small>

                          <?php else: ?>
                          
                            <button type="button" class="btn btn-xs rounded-pill btn-outline-primary toggle_daftar_prestasi_siswa" data-id_siswa="<?= $pengumuman['id_siswa'] ?>">
                              <i data-feather="list" class="me-1"></i>
                              Daftar
                              <span class="btn btn-sm rounded-pill btn-outline-primary py-0 px-2 ms-1"><?= $pengumuman['jml_file_prestasi'] ?></button>
                            </button>
                          
                          <?php endif ?>
                        </td>
                        <td>
                          <?php if (!$pengumuman['jml_file_kompetensi']): ?>

                            <small class="text-muted">Tidak ada</small>

                          <?php else: ?>
                          
                            <button type="button" class="btn btn-xs rounded-pill btn-outline-primary toggle_daftar_kompetensi_siswa" data-id_siswa="<?= $pengumuman['id_siswa'] ?>">
                              <i data-feather="list" class="me-1"></i>
                              Daftar
                              <span class="btn btn-sm rounded-pill btn-outline-primary py-0 px-2 ms-1"><?= $pengumuman['jml_file_kompetensi'] ?></button>
                            </button>
                          
                          <?php endif ?>
                        </td>
                        <td>
                          <?php if (!$pengumuman['keterangan_seleksi']): ?>

                            <small class="fw-bold text-muted">Belum Di-input</small>
                            
                          <?php elseif ($pengumuman['keterangan_seleksi'] === 'lolos'): ?>

                            <small class="fw-bold text-success">Lolos</small>
                              
                          <?php else: ?>
                            
                            <small class="fw-bold text-danger">Tidak Lolos</small>
                            
                          <?php endif ?>
                        </td>
                      </tr>

                    <?php endwhile ?>
                  </tbody>
                </table>
              </div>
            </div>
            
          </div>
        </main>
        
        <!--============================= FOOTER =============================-->
        <?php include '_partials/footer.php' ?>
        <!--//END FOOTER -->

      </div>
    </div>
    
    <!--============================= MODAL DAFTAR FILE SISWA =============================-->
    <div class="modal fade" id="ModalDaftarFileSiswa" tabindex="-1" role="dialog" aria-labelledby="ModalDaftarFileSiswaTitle" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalDaftarFileSiswaTitle"><i data-feather="book" class="me-2 mt-1"></i>Daftar Jurusan</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form>
            <div class="modal-body">
              
              <table class="table table-striped" id="table_daftar_file_siswa">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Siswa</th>
                    <th>Nama</th>
                    <th>File</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>

            </div>
            <div class="modal-footer">
              <button class="btn btn-light border" type="button" data-bs-dismiss="modal">Tutup</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--/.modal-daftar-file-siswa -->
    
    <?php include '_partials/script.php' ?>
    <?php include '../helpers/sweetalert2_notify.php' ?>
    
    <!-- PAGE SCRIPT -->
    <script>
      $(document).ready(function() {
        
        let tableDaftarFileSiswa = document.getElementById("table_daftar_file_siswa");
  
        if (tableDaftarFileSiswa) {
          var datatableDaftarFileSiswa = new simpleDatatables.DataTable(tableDaftarFileSiswa, {
            fixedHeader: true,
            pageLength: 5,
            lengthMenu: [
              [3, 5, 10, 25, 50, 100],
              [3, 5, 10, 25, 50, 100],
            ]
          });
        }

        const id_tahun_penilaian_filter = $('#xid_tahun_penilaian_filter');

        const datatablesSimple = document.getElementById('datatablesSimple');
        let dataTable = new simpleDatatables.DataTable(datatablesSimple);
        
        initSelect2(id_tahun_penilaian_filter, {
          width: '100%',
          dropdownParent: "body"
        });
        
        
        id_tahun_penilaian_filter.on('change', function() {
          const tahun_penilaian = $(this).find(':selected').data('tahun');

          !tahun_penilaian
            ? dataTable.refresh()
            : dataTable.search(`${tahun_penilaian}`);
        });
        

        $('#xreset_filter_tahun').on('click', function() {
          id_tahun_penilaian_filter.val('').trigger('change');
          dataTable.refresh();
        });


        $('#xcetak_pengumuman').on('click', function() {
          const id_tahun_penilaian = $('#xid_tahun_penilaian_filter').val();
          const url = `laporan_pengumuman.php?id_tahun_penilaian=${id_tahun_penilaian}`;
          
          printExternal(url);
        });

        
        $('.toggle_daftar_prestasi_siswa').on('click', function() {
          const id_siswa = $(this).data('id_siswa');
          
          $('#ModalDaftarFileSiswa .modal-title').html(`<i data-feather="star" class="me-2 mt-1"></i>Daftar Prestasi Siswa`);
        
          $.ajax({
            url: 'get_prestasi_siswa_by_id_siswa.php',
            method: 'POST',
            dataType: 'JSON',
            data: {
              'id_siswa': id_siswa
            },
            success: function(data) {
              // add datatables row
              let i = 1;
              let rowsData = [];
              
              for (key in data) {
                let filePrestasi = data[key]['file_prestasi'];
        
                if (!filePrestasi) {
                  filePrestasiHtml = `<small class="text-muted">Tidak ada</small>`;
                } else {
                  filePrestasiPath = "<?= base_url_return('assets/uploads/file_prestasi_siswa/') ?>" + filePrestasi;
                  
                  // Preview button
                  filePrestasiHtml = 
                    `<a class="btn btn-xs rounded-pill bg-purple-soft text-purple" href="${filePrestasiPath}" target="_blank">
                      <i data-feather="eye" class="me-1"></i>Preview
                    </a>`;
                  
                  // Download button
                  filePrestasiHtml +=
                    `<a class="btn btn-xs rounded-pill bg-blue-soft text-blue" href="${filePrestasiPath}" download>
                      <i data-feather="download-cloud" class="me-1"></i>Download
                    </a>`;
                }
                
                rowsData.push([i++, data[key]['nama_siswa'], data[key]['nama_prestasi'], filePrestasiHtml]);
              }
        
              datatableDaftarFileSiswa.destroy();
              datatableDaftarFileSiswa.init();
              datatableDaftarFileSiswa.insert({
                data: rowsData
              });
        
              // Re-init all feather icons
              feather.replace();
              
              $('#ModalDaftarFileSiswa').modal('show');
            },
            error: function(request, status, error) {
              console.log("ajax call went wrong:" + request.responseText);
              console.log("ajax call went wrong:" + error);
            }
          })
        });
        
        
        $('.toggle_daftar_kompetensi_siswa').on('click', function() {
          const id_siswa = $(this).data('id_siswa');
          
          $('#ModalDaftarFileSiswa .modal-title').html(`<i data-feather="star" class="me-2 mt-1"></i>Daftar Kompetensi Siswa`);
        
          $.ajax({
            url: 'get_kompetensi_siswa_by_id_siswa.php',
            method: 'POST',
            dataType: 'JSON',
            data: {
              'id_siswa': id_siswa
            },
            success: function(data) {
              // add datatables row
              let i = 1;
              let rowsData = [];
              
              for (key in data) {
                let fileKompetensi = data[key]['file_kompetensi'];
        
                if (!fileKompetensi) {
                  fileKompetensiHtml = `<small class="text-muted">Tidak ada</small>`;
                } else {
                  fileKompetensiPath = "<?= base_url_return('assets/uploads/file_kompetensi_siswa/') ?>" + fileKompetensi;
                  
                  // Preview button
                  fileKompetensiHtml = 
                    `<a class="btn btn-xs rounded-pill bg-purple-soft text-purple" href="${fileKompetensiPath}" target="_blank">
                      <i data-feather="eye" class="me-1"></i>Preview
                    </a>`;
                  
                  // Download button
                  fileKompetensiHtml +=
                    `<a class="btn btn-xs rounded-pill bg-blue-soft text-blue" href="${fileKompetensiPath}" download>
                      <i data-feather="download-cloud" class="me-1"></i>Download
                    </a>`;
                }
                
                rowsData.push([i++, data[key]['nama_siswa'], data[key]['nama_kompetensi'], fileKompetensiHtml]);
              }
        
              datatableDaftarFileSiswa.destroy();
              datatableDaftarFileSiswa.init();
              datatableDaftarFileSiswa.insert({
                data: rowsData
              });
        
              // Re-init all feather icons
              feather.replace();
              
              $('#ModalDaftarFileSiswa').modal('show');
            },
            error: function(request, status, error) {
              console.log("ajax call went wrong:" + request.responseText);
              console.log("ajax call went wrong:" + error);
            }
          })
        });
        
      });
    </script>

  </body>

  </html>

<?php endif ?>