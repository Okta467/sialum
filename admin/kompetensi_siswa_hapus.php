<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    
    $id_kompetensi_siswa = $_GET['xid_kompetensi_siswa'];
    
    // Get kompetensi siswa to delete current file_kompetensi after data deletion
    $stmt_kompetensi_siswa = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt_kompetensi_siswa, 'SELECT file_kompetensi FROM tbl_kompetensi_siswa WHERE id=?');
    mysqli_stmt_bind_param($stmt_kompetensi_siswa, 'i', $id_kompetensi_siswa);
    mysqli_stmt_execute($stmt_kompetensi_siswa);

    $result = mysqli_stmt_get_result($stmt_kompetensi_siswa);
    $kompetensi_siswa = mysqli_fetch_assoc($result);

    // tbl_kompetensi_siswa data statement and execution
    $stmt_hapus = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt_hapus, "DELETE FROM tbl_kompetensi_siswa WHERE id=?");
    mysqli_stmt_bind_param($stmt_hapus, 'i', $id_kompetensi_siswa);

    $delete = mysqli_stmt_execute($stmt_hapus);
    
    // Delete file_kompetensi_siswa if data deletio is success
    if ($delete) {
        $target_dir = '../assets/uploads/file_kompetensi_siswa/';
        $old_file_kompetensi_siswa = $kompetensi_siswa['file_kompetensi'];
        $file_path_to_unlink = $target_dir . $old_file_kompetensi_siswa;
        
        // Delete the old file_kompetensi
        if (file_exists($file_path_to_unlink)) {
            unlink("{$target_dir}{$old_file_kompetensi_siswa}");
        }
    }

    !$delete
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'delete_success';

    mysqli_stmt_close($stmt_kompetensi_siswa);
    mysqli_stmt_close($stmt_hapus);
    mysqli_close($connection);

    echo "<meta http-equiv='refresh' content='0;kompetensi_siswa.php?go=kompetensi_siswa'>";
?>