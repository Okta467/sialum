<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah siswa?
    if (!isAccessAllowed('siswa')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    require_once '../vendors/htmlpurifier/HTMLPurifier.auto.php';
    include_once '../config/connection.php';

    // to sanitize user input
    $config   = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
    
    $id_pekerjaan_alumni         = $_POST['xid_pekerjaan_alumni'];
    $id_alumni_logged_in         = $_SESSION['id_siswa'];
    $nama_perusahaan             = htmlspecialchars($purifier->purify($_POST['xnama_perusahaan']));
    $jabatan                     = htmlspecialchars($purifier->purify($_POST['xjabatan']));
    $deskripsi_pekerjaan         = htmlspecialchars($purifier->purify($_POST['xdeskripsi_pekerjaan']));
    $tanggal_masuk               = htmlspecialchars($purifier->purify($_POST['xtanggal_masuk']));
    $tanggal_keluar              = htmlspecialchars($purifier->purify($_POST['xtanggal_keluar']));
    $alamat_simpel               = htmlspecialchars($purifier->purify($_POST['xalamat_simpel']));
    $alamat_perusahaan_provinsi  = $_POST['xalamat_perusahaan_provinsi'];
    $alamat_perusahaan_kab_kota  = $_POST['xalamat_perusahaan_kab_kota'];
    $alamat_perusahaan_kecamatan = $_POST['xalamat_perusahaan_kecamatan'];
    $alamat_perusahaan_kelurahan = $_POST['xalamat_perusahaan_kelurahan'];
    $status_pekerjaan            = $_POST['xstatus_pekerjaan'] ?? NULL;
    $is_allowed_status_pekerjaan = in_array($_POST['xstatus_pekerjaan'], ['masih_bekerja', 'resign', 'magang']); 

    if (!$is_allowed_status_pekerjaan) {
        $_SESSION['msg'] = 'Status pekerjaan yang diinput tidak diperbolehkan!';
        echo "<meta http-equiv='refresh' content='0;pekerjaan_alumni.php?go=pekerjaan_alumni'>";
        return;
    }
    
    $stmt_current_pekerjaan_alumni = mysqli_stmt_init($connection);
    $query_current_pekerjaan_alumni = 
        "SELECT a.id_pekerjaan_alumni, a.id_alumni, b.id AS id_siswa
        FROM tbl_pekerjaan_alumni AS a
        LEFT JOIN tbl_siswa AS b
            ON a.id_alumni = b.id
        WHERE a.id_pekerjaan_alumni=?";

    mysqli_stmt_prepare($stmt_current_pekerjaan_alumni, $query_current_pekerjaan_alumni);
    mysqli_stmt_bind_param($stmt_current_pekerjaan_alumni, 'i', $id_pekerjaan_alumni);
    mysqli_stmt_execute($stmt_current_pekerjaan_alumni);

	$result_current_pekerjaan_alumni = mysqli_stmt_get_result($stmt_current_pekerjaan_alumni);
    $pekerjaan_alumni = mysqli_fetch_assoc($result_current_pekerjaan_alumni);
    $id_alumni_in_current_pekerjaan_alumni = $pekerjaan_alumni['id_alumni'];

    if ($id_alumni_logged_in != $id_alumni_in_current_pekerjaan_alumni) {
        $_SESSION['msg'] = 'Alumni yang diinput tidak sama dengan yang login saat ini!';
        echo "<meta http-equiv='refresh' content='0;pekerjaan_alumni.php?go=pekerjaan_alumni'>";
        return;
    }

    $stmt_pekerjaan_alumni = mysqli_stmt_init($connection);
    $query_pekerjaan_alumni = "UPDATE tbl_pekerjaan_alumni SET
        id_alumni = ?
        , nama_perusahaan = ?
        , jabatan = ?
        , deskripsi_pekerjaan = ?
        , tanggal_masuk = ?
        , tanggal_keluar = ?
        , alamat_simpel = ?
        , alamat_perusahaan_provinsi = ?
        , alamat_perusahaan_kab_kota = ?
        , alamat_perusahaan_kecamatan = ?
        , alamat_perusahaan_kelurahan = ?
        , status_pekerjaan = ?
    WHERE id_pekerjaan_alumni = ?";

    mysqli_stmt_prepare($stmt_pekerjaan_alumni, $query_pekerjaan_alumni);
    mysqli_stmt_bind_param($stmt_pekerjaan_alumni, 'issssssiiiisi', $id_alumni_logged_in, $nama_perusahaan, $jabatan, $deskripsi_pekerjaan, $tanggal_masuk, $tanggal_keluar, $alamat_simpel, $alamat_perusahaan_provinsi, $alamat_perusahaan_kab_kota, $alamat_perusahaan_kecamatan, $alamat_perusahaan_kelurahan, $status_pekerjaan, $id_pekerjaan_alumni);

    $insert = mysqli_stmt_execute($stmt_pekerjaan_alumni);

    !$insert
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'update_success';

    mysqli_stmt_close($stmt_current_pekerjaan_alumni);
    mysqli_stmt_close($stmt_pekerjaan_alumni);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;pekerjaan_alumni.php?go=pekerjaan_alumni'>";
?>