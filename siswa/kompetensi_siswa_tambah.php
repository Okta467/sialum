<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah siswa?
    if (!isAccessAllowed('siswa')) {
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
    
    $id_siswa        = $_SESSION['id_siswa'];
    $nama_kompetensi = htmlspecialchars($purifier->purify($_POST['xnama_kompetensi']));
    $file_kompetensi = $_FILES['xfile_kompetensi'];

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
    
    $stmt = mysqli_stmt_init($connection);

    mysqli_stmt_prepare($stmt, "INSERT INTO tbl_kompetensi_siswa (id_siswa, nama_kompetensi, file_kompetensi) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'iss', $id_siswa, $nama_kompetensi, $nama_berkas);

    $insert = mysqli_stmt_execute($stmt);

    !$insert
        ? $_SESSION['msg'] = 'other_error'
        : $_SESSION['msg'] = 'save_success';

    mysqli_stmt_close($stmt);
    mysqli_close($connection);
    
    echo "<meta http-equiv='refresh' content='0;kompetensi_siswa.php?go=kompetensi_siswa'>";
?>