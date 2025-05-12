<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $id_penilaian       = $_POST['xid_penilaian'];
    $nilai_prestasi     = $_POST['xnilai_prestasi'];
    $nilai_kompetensi   = $_POST['xnilai_kompetensi'];

    $stmt = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt, "UPDATE tbl_penilaian_seleksi SET nilai_prestasi=?, nilai_kompetensi=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, 'iddi', $nilai_prestasi, $nilai_kompetensi, $id_penilaian);

    $update = mysqli_stmt_execute($stmt);

    !$update
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'update_success';

    mysqli_stmt_close($stmt);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;penilaian.php?go=penilaian'>";
?>