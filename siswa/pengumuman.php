<?php
include '../helpers/isAccessAllowedHelper.php';

// cek apakah user yang mengakses adalah siswa?
if (!isAccessAllowed('siswa')) :
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
                      <th>Nilai Prestasi</th>
                      <th>Nilai Kompetensi</th>
                      <th>File Prestasi</th>
                      <th>File Kompetensi</th>
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
                        d.id AS id_prestasi_siswa, d.nama_prestasi, d.file_prestasi,
                        e.id AS id_kompetensi_siswa, e.nama_kompetensi, e.file_kompetensi,
                        f.id AS id_pengumuman, f.keterangan_seleksi
                      FROM tbl_penilaian_seleksi AS a
                      INNER JOIN tbl_tahun_penilaian AS b
                        ON b.id = a.id_tahun_penilaian
                      INNER JOIN tbl_siswa AS c
                        ON c.id = a.id_siswa
                      LEFT JOIN tbl_prestasi_siswa AS d
                        ON c.id = d.id_siswa
                      LEFT JOIN tbl_kompetensi_siswa AS e
                        ON c.id = e.id_siswa
                      LEFT JOIN tbl_pengumuman_seleksi AS f
                        ON a.id = f.id_penilaian_seleksi
                      WHERE c.id = {$_SESSION['id_siswa']}");

                    while ($pengumuman = mysqli_fetch_assoc($query_pengumuman)):
                      $link_file_prestasi = !$pengumuman['file_prestasi'] 
                        ? null 
                        : base_url_return('assets/uploads/file_prestasi_siswa/') . $pengumuman['file_prestasi'];

                      $link_file_kompetensi = !$pengumuman['file_kompetensi'] 
                        ? null 
                        : base_url_return('assets/uploads/file_kompetensi_siswa/') . $pengumuman['file_kompetensi'];
                    ?>

                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $pengumuman['tahun'] ?></td>
                        <td><?= $pengumuman['nama_siswa'] ?></td>
                        <td><?= $pengumuman['nilai_prestasi'] ?></td>
                        <td><?= $pengumuman['nilai_kompetensi'] ?></td>
                        <td>
                          <?php if (!$link_file_prestasi): ?>

                            <small class="text-muted">Tidak ada</small>

                          <?php else: ?>

                            <a class="btn btn-xs rounded-pill bg-purple-soft text-purple" href="<?= $link_file_prestasi ?>" target="_blank">
                              <i data-feather="eye" class="me-1"></i>Preview
                            </a>
                            <a class="btn btn-xs rounded-pill bg-blue-soft text-blue" href="<?= $link_file_prestasi ?>" download>
                              <i data-feather="download-cloud" class="me-1"></i>Download
                            </a>
                          
                          <?php endif ?>
                        </td>
                        <td>
                          <?php if (!$link_file_kompetensi): ?>

                            <small class="text-muted">Tidak ada</small>

                          <?php else: ?>
                          
                            <a class="btn btn-xs rounded-pill bg-purple-soft text-purple" href="<?= $link_file_kompetensi ?>" target="_blank">
                              <i data-feather="eye" class="me-1"></i>Preview
                            </a>
                            <a class="btn btn-xs rounded-pill bg-blue-soft text-blue" href="<?= $link_file_kompetensi ?>" download>
                              <i data-feather="download-cloud" class="me-1"></i>Download
                            </a>
                          
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
    
    <?php include '_partials/script.php' ?>
    <?php include '../helpers/sweetalert2_notify.php' ?>

  </body>

  </html>

<?php endif ?>