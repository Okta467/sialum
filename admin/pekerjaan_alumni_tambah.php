<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        // echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    require_once '../vendors/htmlpurifier/HTMLPurifier.auto.php';
    include_once '../config/connection.php';

    // to sanitize user input
    $config   = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
    
    $id_alumni                   = $_POST['xid_alumni'];
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
        // echo "<meta http-equiv='refresh' content='0;pekerjaan_alumni.php?go=pekerjaan_alumni'>";
        return;
    }
    

    $stmt = mysqli_stmt_init($connection);
    $query_pekerjaan_alumni = "INSERT INTO tbl_pekerjaan_alumni
    (
        id_alumni
        , nama_perusahaan
        , jabatan
        , deskripsi_pekerjaan
        , tanggal_masuk
        , tanggal_keluar
        , alamat_simpel
        , alamat_perusahaan_provinsi
        , alamat_perusahaan_kab_kota
        , alamat_perusahaan_kecamatan
        , alamat_perusahaan_kelurahan
        , status_pekerjaan
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    mysqli_stmt_prepare($stmt, $query_pekerjaan_alumni);
    mysqli_stmt_bind_param($stmt, 'issssssiiiis', $id_alumni, $nama_perusahaan, $jabatan, $deskripsi_pekerjaan, $tanggal_masuk, $tanggal_keluar, $alamat_simpel, $alamat_perusahaan_provinsi, $alamat_perusahaan_kab_kota, $alamat_perusahaan_kecamatan, $alamat_perusahaan_kelurahan, $status_pekerjaan);

    $insert = mysqli_stmt_execute($stmt);

    !$insert
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'save_success';

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;pekerjaan_alumni.php?go=pekerjaan_alumni'>";
?>