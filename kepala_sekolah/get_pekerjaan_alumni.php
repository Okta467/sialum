<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah kepala_sekolah?
    if (!isAccessAllowed('kepala_sekolah')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    include_once '../helpers/fetchJsonApiHelper.php';
    
    $id_pekerjaan_alumni = $_POST['id_pekerjaan_alumni'];
    $get_nama_alamat_perusahaan = $_POST['get_nama_alamat_perusahaan'] ?? false;

    $stmt1 = mysqli_stmt_init($connection);
    $query = 
        "SELECT
            a.*,
            b.id AS id_siswa, b.nisn, b.nama_siswa AS nama_alumni, b.jk, b.alamat, b.tmp_lahir, b.tgl_lahir, b.no_telp, b.email,
            c.id AS id_kelas, c.nama_kelas,
            f.id AS id_pengguna, f.username, f.hak_akses
        FROM tbl_pekerjaan_alumni AS a
        LEFT JOIN tbl_siswa AS b
            ON a.id_alumni = b.id
        LEFT JOIN tbl_kelas AS c
            ON b.id_kelas = c.id
        LEFT JOIN tbl_pengguna AS f
            ON b.id_pengguna = f.id
        WHERE a.id_pekerjaan_alumni=?";

    mysqli_stmt_prepare($stmt1, $query) or die (mysqli_stmt_error($stmt1));
    mysqli_stmt_bind_param($stmt1, 'i', $id_pekerjaan_alumni);
    mysqli_stmt_execute($stmt1);

	$result = mysqli_stmt_get_result($stmt1);

    $pekerjaan_alumnis = !$result
        ? array()
        : mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    if ($get_nama_alamat_perusahaan) {
        $url_provinsi = "https://okta467.github.io/api-wilayah-indonesia/api/province/{$pekerjaan_alumnis[0]['alamat_perusahaan_provinsi']}.json";
        $url_kab_kota = "https://okta467.github.io/api-wilayah-indonesia/api/regency/{$pekerjaan_alumnis[0]['alamat_perusahaan_kab_kota']}.json";
        $url_kecamatan = "https://okta467.github.io/api-wilayah-indonesia/api/district/{$pekerjaan_alumnis[0]['alamat_perusahaan_kecamatan']}.json";
        $url_kelurahan = "https://okta467.github.io/api-wilayah-indonesia/api/village/{$pekerjaan_alumnis[0]['alamat_perusahaan_kelurahan']}.json";

        $provinsi = fetchApiJson($url_provinsi, [], 'GET');
        $kab_kota = fetchApiJson($url_kab_kota, [], 'GET');
        $kecamatan = fetchApiJson($url_kecamatan, [], 'GET');
        $kelurahan = fetchApiJson($url_kelurahan, [], 'GET');

        $pekerjaan_alumnis[0]['nama_alamat_perusahaan_provinsi'] = $provinsi['name'];
        $pekerjaan_alumnis[0]['nama_alamat_perusahaan_kab_kota'] = $kab_kota['name'];
        $pekerjaan_alumnis[0]['nama_alamat_perusahaan_kecamatan'] = $kecamatan['name'];
        $pekerjaan_alumnis[0]['nama_alamat_perusahaan_kelurahan'] = $kelurahan['name'];
    }

    mysqli_stmt_close($stmt1);
    mysqli_close($connection);

    echo json_encode($pekerjaan_alumnis);

?>