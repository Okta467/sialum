<?php
include '../helpers/isAccessAllowedHelper.php';

// cek apakah user yang mengakses adalah kepala_sekolah?
if (!isAccessAllowed('kepala_sekolah')) :
  session_destroy();
  echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
else :
  include_once '../config/connection.php';
  include_once '../helpers/fetchJsonApiHelper.php';

  $id_provinsi = $_GET['id_provinsi'] ?? null;
  $cetak_semua = $_GET['cetak_semua'] ?? null;

  if (!$id_provinsi && !$cetak_semua) {
    echo 'Data id provinsi atau cetak semua harus diisi!';
    return;
  }
?>


  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php include '_partials/head.php' ?>

    <meta name="description" content="Data Pekerjaan Alumni" />
    <meta name="author" content="" />
    <title>Laporan Pekerjaan Alumni</title>
  </head>

  <body class="bg-white">
    <?php
    $no = 1;
    $url_provinsi = "https://okta467.github.io/api-wilayah-indonesia/api/provinces.json";
    $provinsi = fetchApiJson($url_provinsi, [], 'GET');

    $stmt_pekerjaan_alumni = mysqli_stmt_init($connection);

    if ($id_provinsi) {
      $query_pekerjaan_alumni = 
        "SELECT
          a.*,
          b.id AS id_alumni, b.nisn, b.nama_siswa AS nama_alumni, b.jk, b.alamat AS alamat_alumni, b.tmp_lahir, b.tgl_lahir, b.no_telp, b.email, b.tahun_lulus,
          c.id AS id_kelas, c.nama_kelas
        FROM tbl_pekerjaan_alumni AS a
        LEFT JOIN tbl_siswa AS b
          ON a.id_alumni = b.id
        LEFT JOIN tbl_kelas AS c
          ON b.id_kelas = c.id
        WHERE a.alamat_perusahaan_provinsi = ?
        ORDER BY a.id_pekerjaan_alumni DESC";
        
      mysqli_stmt_prepare($stmt_pekerjaan_alumni, $query_pekerjaan_alumni);
      mysqli_stmt_bind_param($stmt_pekerjaan_alumni, 's', $id_provinsi);
    } else {
      $query_pekerjaan_alumni = 
        "SELECT
          a.*,
          b.id AS id_alumni, b.nisn, b.nama_siswa AS nama_alumni, b.jk, b.alamat AS alamat_alumni, b.tmp_lahir, b.tgl_lahir, b.no_telp, b.email, b.tahun_lulus,
          c.id AS id_kelas, c.nama_kelas
        FROM tbl_pekerjaan_alumni AS a
        LEFT JOIN tbl_siswa AS b
          ON a.id_alumni = b.id
        LEFT JOIN tbl_kelas AS c
          ON b.id_kelas = c.id
        ORDER BY a.id_pekerjaan_alumni DESC";
        
      mysqli_stmt_prepare($stmt_pekerjaan_alumni, $query_pekerjaan_alumni);
    }

    mysqli_stmt_execute($stmt_pekerjaan_alumni);

    $result = mysqli_stmt_get_result($stmt_pekerjaan_alumni);
    $pekerjaan_alumnis = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_stmt_close($stmt_pekerjaan_alumni);
    mysqli_close($connection);
    ?>

    <h4 class="text-center mb-4">Laporan Pekerjaan Alumni</h4>

    <table class="table table-striped table-bordered table-sm">
      <thead>
        <tr>
          <th>#</th>
          <th>Alumni</th>
          <th>Tahun Lulus</th>
          <th>Perusahaan</th>
          <th>Jabatan</th>
          <th>Status</th>
          <th>Lokasi</th>
          <th>Tanggal Masuk</th>
          <th>Tanggal Keluar</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$result->num_rows): ?>

          <tr>
            <td colspan="10"><div class="text-center">Tidak ada data</div></td>
          </tr>
        
        <?php else: ?>

          <?php
          foreach($pekerjaan_alumnis as $pekerjaan_alumni) :
            // Filter the array
            $id_api_provinsi = $pekerjaan_alumni['alamat_perusahaan_provinsi'];

            $filtered = array_filter($provinsi, function($prov) use ($id_api_provinsi) {
              return $prov['id'] == $id_api_provinsi;
            });
            
            // Get the first (and only) match
            $nama_provinsi = reset($filtered)['name'] ?? null;
          ?>
            
            <tr>
              <td><?= $no++ ?></td>
              <td>
                <?= $pekerjaan_alumni['nama_alumni'] ?>
                <?= "<br><small class='text-muted'>({$pekerjaan_alumni['nisn']})</small>" ?>
              </td>
              <td><?= $pekerjaan_alumni['tahun_lulus'] ?? '<small class="text-muted">Tidak ada</small>' ?></td>
              <td><?= $pekerjaan_alumni['nama_perusahaan'] ?></td>
              <td><?= $pekerjaan_alumni['jabatan'] ?></td>
              <td><?= $pekerjaan_alumni['status_pekerjaan'] ?></td>
              <td><?= $nama_provinsi ?></td>
              <td><?= $pekerjaan_alumni['tanggal_masuk'] ?></td>
              <td><?= $pekerjaan_alumni['tanggal_keluar'] ?? '<small class="text-muted">Tidak ada</small>' ?></td>
            </tr>
              
          <?php endforeach ?>

        <?php endif ?>
      </tbody>
    </table>

  </body>

  </html>

<?php endif ?>