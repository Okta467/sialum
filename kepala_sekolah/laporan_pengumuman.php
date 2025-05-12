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

  <body class="bg-white">
    <?php
    $no = 1;
    $id_tahun_penilaian = $_GET['id_tahun_penilaian'] ?? null;

    $stmt_tahun_penilaian = mysqli_stmt_init($connection);

    if (!$id_tahun_penilaian) {
      mysqli_stmt_prepare($stmt_tahun_penilaian, "SELECT '(Tidak ada)' AS tahun");
    } else {
      mysqli_stmt_prepare($stmt_tahun_penilaian, "SELECT * FROM tbl_tahun_penilaian WHERE id=?");
      mysqli_stmt_bind_param($stmt_tahun_penilaian, 'i', $id_tahun_penilaian);
    }

    mysqli_stmt_execute($stmt_tahun_penilaian);

    $result = mysqli_stmt_get_result($stmt_tahun_penilaian);
    $tahun_penilaian = mysqli_fetch_assoc($result);


    $stmt_pengumuman = mysqli_stmt_init($connection);
    $query_pengumuman =
      "SELECT
        a.id AS id_penilaian, a.nilai_kompetensi, a.nilai_prestasi,
        b.id AS id_tahun_penilaian, b.tahun,
        c.id AS id_siswa, c.nisn, c.nama_siswa, c.jk, c.alamat, c.tmp_lahir, c.tgl_lahir, c.no_telp, c.email,
        d.id AS id_prestasi_siswa, d.nama_prestasi, d.file_prestasi,
        e.id AS id_kompetensi_siswa, e.nama_kompetensi, e.file_kompetensi,
        f.id AS id_pengumuman, f.keterangan_seleksi,
        g.id AS id_kelas, g.nama_kelas
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
      LEFT JOIN tbl_kelas AS g
        ON g.id = c.id_kelas";

    if (!$id_tahun_penilaian) {
      $query_pengumuman .= " ORDER BY a.id DESC";
      mysqli_stmt_prepare($stmt_pengumuman, $query_pengumuman);
    } else {
      $query_pengumuman .= " WHERE a.id_tahun_penilaian=? ORDER BY a.id DESC";

      mysqli_stmt_prepare($stmt_pengumuman, $query_pengumuman);
      mysqli_stmt_bind_param($stmt_pengumuman, 'i', $id_tahun_penilaian);
    }

    mysqli_stmt_execute($stmt_pengumuman);
    $result = mysqli_stmt_get_result($stmt_pengumuman);

    $pengumumans = mysqli_fetch_all($result, MYSQLI_ASSOC);


    mysqli_stmt_close($stmt_tahun_penilaian);
    mysqli_stmt_close($stmt_pengumuman);
    mysqli_close($connection);
    ?>

    <h4 class="text-center mb-4">Laporan Seleksi Pendaftaran Lomba LKS Tahun <?= $tahun_penilaian['tahun'] ?></h4>

    <table class="table table-striped table-bordered table-sm" id="datatablesSimple">
      <thead>
        <tr>
          <th>#</th>
          <th>Tahun</th>
          <th>Siswa</th>
          <th>Kelas</th>
          <th>Nilai Prestasi</th>
          <th>Nilai Kompetensi</th>
          <th>Keterangan</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!$result->num_rows): ?>

          <tr>
            <td colspan="6"><div class="text-center">Tidak ada data</div></td>
          </tr>
        
        <?php else: ?>

          <?php foreach($pengumumans as $pengumuman) : ?>

            <tr>
              <td><?= $no++ ?></td>
              <td>
                <div class="text-center">
                  <?= $pengumuman['tahun'] ?>
                </div>
              </td>
              <td><?= $pengumuman['nama_siswa'] ?></td>
              <td>
                <div class="text-center">
                  <?= $pengumuman['nama_kelas'] ?>
                </div>
              </td>
              <td>
                <div class="text-center">
                  <?= $pengumuman['nilai_prestasi'] ?>
                </div>
              </td>
              <td>
                <div class="text-center">
                  <?= $pengumuman['nilai_kompetensi'] ?>
                </div>
              </td>
              <td>
                <?php if (!$pengumuman['keterangan_seleksi']) : ?>

                  <small class="fw-bold text-muted">Belum Di-input</small>

                <?php elseif ($pengumuman['keterangan_seleksi'] === 'lolos') : ?>

                  <small class="fw-bold text-success">Lolos</small>

                <?php else : ?>

                  <small class="fw-bold text-danger">Tidak Lolos</small>

                <?php endif ?>
              </td>
            </tr>

          <?php endforeach ?>

        <?php endif ?>
      </tbody>
    </table>

  </body>

  </html>

<?php endif ?>