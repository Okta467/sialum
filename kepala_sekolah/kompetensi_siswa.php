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

    <meta name="description" content="Data Kompetensi Siswa" />
    <meta name="author" content="" />
    <title>Kompetensi Siswa - <?= SITE_NAME ?></title>
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
                <h1 class="mb-0">Kompetensi Siswa</h1>
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
                  Tools Cetak Laporan
                </div>
              </div>
              <div class="card-body">
                <div class="row gx-3">
                  <div class="col-md-2 mb-3">
                    <label class="small mb-1" for="xdari_tanggal">Dari Tanggal</label>
                    <input class="form-control" id="xdari_tanggal" type="date" name="xdari_tanggal" required>
                  </div>
                  <div class="col-md-2 mb-3">
                    <label class="small mb-1" for="xsampai_tanggal">Sampai Tanggal</label>
                    <input class="form-control" id="xsampai_tanggal" type="date" name="xsampai_tanggal" required>
                  </div>
                  <div class="col-md-2 mb-3">
                    <label class="small mb-1 invisible" for="xcetak_laporan">Filter Button</label>
                    <button class="btn btn-primary w-100" id="xcetak_laporan" type="button">
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
                  <i data-feather="star" class="me-2 mt-1"></i>
                  Data Kompetensi Siswa
                </div>
              </div>
              <div class="card-body">
                <table id="datatablesSimple">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Siswa</th>
                      <th>Kompetensi Siswa</th>
                      <th>Berkas</th>
                      <th>Tanggal Dibuat</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $query_kompetensi_siswa = mysqli_query($connection, 
                      "SELECT
                        d.id AS id_kompetensi_siswa, d.nama_kompetensi, d.file_kompetensi, d.created_at AS created_at_kompetensi_siswa,
                        a.id AS id_siswa, a.nisn, a.nama_siswa, a.jk, a.alamat, a.tmp_lahir, a.tgl_lahir, a.no_telp, a.email,
                        b.id AS id_kelas, b.nama_kelas,
                        c.id AS id_wali_kelas, c.nama_guru AS nama_wali_kelas,
                        f.id AS id_pengguna, f.username, f.hak_akses
                      FROM tbl_kompetensi_siswa AS d
                      INNER JOIN tbl_siswa AS a
                        ON a.id = d.id_siswa
                      LEFT JOIN tbl_kelas AS b
                        ON b.id = a.id_kelas
                      LEFT JOIN tbl_guru AS c
                        ON c.id = b.id_wali_kelas
                      LEFT JOIN tbl_pengguna AS f
                        ON f.id = a.id_pengguna
                      ORDER BY d.id DESC");

                    while ($kompetensi_siswa = mysqli_fetch_assoc($query_kompetensi_siswa)):
                      $path_file_kompetensi_siswa = base_url_return('assets/uploads/file_kompetensi_siswa/');
                      $file_kompetensi = $kompetensi_siswa['file_kompetensi'] ?? null;
                      $link_file_kompetensi = $path_file_kompetensi_siswa . $file_kompetensi;
                      $tanggal_dibuat = $kompetensi_siswa['created_at_kompetensi_siswa'];
                    ?>

                      <tr>
                        <td><?= $no++ ?></td>
                        <td>
                          <?= htmlspecialchars($kompetensi_siswa['nama_siswa']) ?>
                          <?= "<br><small class='text-muted'>({$kompetensi_siswa['nisn']})</small>" ?>
                        </td>
                        <td><?= $kompetensi_siswa['nama_kompetensi'] ?></td>
                        <td>
                          <?php if ($file_kompetensi): ?>

                            <a class="btn btn-xs rounded-pill bg-purple-soft text-purple" href="<?= $link_file_kompetensi ?>" target="_blank">
                              <i data-feather="eye" class="me-1"></i>Preview
                            </a>

                            <a class="btn btn-xs rounded-pill bg-blue-soft text-blue" href="<?= $link_file_kompetensi ?>" download>
                              <i data-feather="download-cloud" class="me-1"></i>Download
                            </a>
                            
                          <?php else: ?>
                            
                            <small class="text-muted">Tidak ada</small>
                            
                          <?php endif ?>
                        </td>
                        <td><?= date('Y-m-d', strtotime($tanggal_dibuat)) ?></td>
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
    
    <?php include '_partials/script.php' ?>
    <?php include '../helpers/sweetalert2_notify.php' ?>
    
    <!-- PAGE SCRIPT -->
    <script>
      $(document).ready(function() {
        $('#xcetak_laporan').on('click', function() {
          const dari_tanggal = $('#xdari_tanggal').val();
          const sampai_tanggal = $('#xsampai_tanggal').val();
          
          const url = `laporan_kompetensi_siswa.php?dari_tanggal=${dari_tanggal}&sampai_tanggal=${sampai_tanggal}`;
          
          printExternal(url);
        });
        
      });
    </script>

  </body>

  </html>

<?php endif ?>