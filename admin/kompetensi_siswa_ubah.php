<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    require_once '../vendors/htmlpurifier/HTMLPurifier.auto.php';
    require_once '../helpers/fileUploadHelper.php';
    require_once '../helpers/getHashedFileNameHelper.php';
    include_once '../config/connection.php';

    // to sanitize user input
    $config   = HTMLPurifier_Config::createDefault();
    $purifier = new HTMLPurifier($config);
    
    $id_kompetensi_siswa = $_POST['xid_kompetensi_siswa'];
    $nama_kompetensi     = htmlspecialchars($purifier->purify($_POST['xnama_kompetensi']));
    $file_kompetensi     = $_FILES['xfile_kompetensi'];
    $file_kompetensi_old = $_POST['xfile_kompetensi_old'];
    $is_uploading        = $file_kompetensi['name'] ? true : false;

    if ($is_uploading) {
        // Set upload configuration
        $target_dir    = '../assets/uploads/file_kompetensi_siswa/';
        $max_file_size = 200 * 1024; // 200KB in bytes
        $allowed_types = ['pdf'];
    
        // Upload surat lamaran using the configuration
        $upload_file_kompetensi = fileUpload($file_kompetensi, $target_dir, $max_file_size, $allowed_types);
        $nama_berkas       = $upload_file_kompetensi['hashedFilename'];
        $is_upload_success = $upload_file_kompetensi['isUploaded'];
        $upload_messages   = $upload_file_kompetensi['messages'];
    
        // Check is file uploaded?
        if (!$is_upload_success) {
            $_SESSION['msg'] = $upload_messages;
            echo "<meta http-equiv='refresh' content='0;kompetensi_siswa.php?go=kompetensi_siswa'>";
            return;
        }
        
        $stmt_kompetensi_siswa = mysqli_stmt_init($connection);

        mysqli_stmt_prepare($stmt_kompetensi_siswa, 'SELECT file_kompetensi FROM tbl_kompetensi_siswa WHERE id=?');
        mysqli_stmt_bind_param($stmt_kompetensi_siswa, 'i', $id_kompetensi_siswa);
        mysqli_stmt_execute($stmt_kompetensi_siswa);

        $result = mysqli_stmt_get_result($stmt_kompetensi_siswa);
        $kompetensi_siswa = mysqli_fetch_assoc($result);
        
        $old_file_kompetensi = $kompetensi_siswa['file_kompetensi'];
        $file_path_to_unlink  = $target_dir . $old_file_kompetensi;
        
        // Delete the old bukti pembayaran
        if (file_exists($file_path_to_unlink)) {
            unlink("{$target_dir}{$old_file_kompetensi}");
        }
    }
    
    $stmt_update = mysqli_stmt_init($connection);

    $nama_berkas = $is_uploading ? $nama_berkas : $file_kompetensi_old;
    
    $query_update = "UPDATE tbl_kompetensi_siswa SET
        nama_kompetensi = ?
        , file_kompetensi = ?
    WHERE id = ?";

    mysqli_stmt_prepare($stmt_update, $query_update);
    mysqli_stmt_bind_param($stmt_update, 'ssi', $nama_kompetensi, $nama_berkas, $id_kompetensi_siswa);

    $update = mysqli_stmt_execute($stmt_update);

    !$update
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'update_success';

    !$is_uploading
        ? ''
        : mysqli_stmt_close($stmt_kompetensi_siswa);
        
    mysqli_stmt_close($stmt_update);
    
    mysqli_close($connection);
    
    echo "<meta http-equiv='refresh' content='0;kompetensi_siswa.php?go=kompetensi_siswa'>";
?>