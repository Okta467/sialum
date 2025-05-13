<?php
include '../helpers/isAccessAllowedHelper.php';

// cek apakah user yang mengakses adalah kepala_sekolah?
if (!isAccessAllowed('kepala_sekolah')) :
  session_destroy();
  echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
else :
  include_once '../config/connection.php';

  $dari_tanggal = $_GET['dari_tanggal'] ?? null;
  $sampai_tanggal = $_GET['sampai_tanggal'] ?? null;

  if (!$dari_tanggal || !$sampai_tanggal) {
    echo 'Input dari dan sampai tanggal harus diisi!';
    return;
  }
?>


  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php include '_partials/head.php' ?>

    <meta name="description" content="Data Pekerjaan Alumni" />
    <meta name="author" content="" />
    <title>Laporan Pekerjaan Alumni <?= "({$dari_tanggal} s.d. {$sampai_tanggal})" ?></title>
  </head>

  <body class="bg-white">
    <?php
    $no = 1;

    $stmt_prestasi = mysqli_stmt_init($connection);
    $query_prestasi = 
      "SELECT
        d.id AS id_prestasi_siswa, d.nama_prestasi, d.file_prestasi,
        a.id AS id_siswa, a.nisn, a.nama_siswa, a.jk, a.alamat, a.tmp_lahir, a.tgl_lahir, a.no_telp, a.email,
        b.id AS id_kelas, b.nama_kelas,
        c.id AS id_wali_kelas, c.nama_guru AS nama_wali_kelas,
        f.id AS id_pengguna, f.username, f.hak_akses
      FROM tbl_prestasi_siswa AS d
      INNER JOIN tbl_siswa AS a
        ON a.id = d.id_siswa
      LEFT JOIN tbl_kelas AS b
        ON b.id = a.id_kelas
      LEFT JOIN tbl_guru AS c
        ON c.id = b.id_wali_kelas
      LEFT JOIN tbl_pengguna AS f
        ON f.id = a.id_pengguna
      WHERE a.created_at BETWEEN ? AND ?
      ORDER BY d.id DESC";
      
    mysqli_stmt_prepare($stmt_prestasi, $query_prestasi);
    mysqli_stmt_bind_param($stmt_prestasi, 'ss', $dari_tanggal, $sampai_tanggal);
    mysqli_stmt_execute($stmt_prestasi);

    $result = mysqli_stmt_get_result($stmt_prestasi);
    $prestasi_siswas = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt_prestasi);
    mysqli_close($connection);
    ?>

    <h4 class="text-center mb-4">Laporan Pekerjaan Alumni <?= "({$dari_tanggal} s.d. {$sampai_tanggal})" ?></h4>

    <table class="table table-striped table-bordered table-sm">
      <thead>
        <tr>
          <th>#</th>
          <th>Siswa</th>
          <th>Prestasi Siswa</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$result->num_rows): ?>

          <tr>
            <td colspan="10"><div class="text-center">Tidak ada data</div></td>
          </tr>
        
        <?php else: ?>

          <?php
          foreach($prestasi_siswas as $prestasi_siswa) :
          ?>
            
            <tr>
              <td><?= $no++ ?></td>
              <td>
                <?= htmlspecialchars($prestasi_siswa['nama_siswa']) ?>
                <?= "<br><small class='text-muted'>({$prestasi_siswa['nisn']})</small>" ?>
              </td>
              <td><?= $prestasi_siswa['nama_prestasi'] ?></td>
            </tr>
              
          <?php endforeach ?>

        <?php endif ?>
      </tbody>
    </table>

  </body>

  </html>

<?php endif ?>