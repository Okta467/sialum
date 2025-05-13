<?php
    include_once '../helpers/isAccessAllowedHelper.php';

    // cek apakah user yang mengakses adalah admin?
    if (!isAccessAllowed('admin')) {
        session_destroy();
        echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
        return;
    }

    include_once '../config/connection.php';
    include_once '../helpers/fetchJsonApiHelper.php';

    $stmt = mysqli_stmt_init($connection);
    $query_pekerjaan_alumni = 
        "SELECT alamat_perusahaan_provinsi, COUNT(alamat_perusahaan_provinsi) AS jml_provinsi
        FROM `tbl_pekerjaan_alumni`
        GROUP BY alamat_perusahaan_provinsi";

    mysqli_stmt_prepare($stmt, $query_pekerjaan_alumni);
    mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

    $pekerjaan_alumnis = !$result
        ? array()
        : mysqli_fetch_all($result, MYSQLI_ASSOC);

    // 1. Load all provinces only ONCE (avoid repeating API calls)
    $all_provinsi = fetchApiJson('https://okta467.github.io/api-wilayah-indonesia/api/provinces.json', [], 'GET');
    
    // 2. Create a lookup table by province ID
    $provinsi_map = [];
    foreach ($all_provinsi as $provinsi) {
        $provinsi_map[$provinsi['id']] = $provinsi['name'];
    }
    
    // 3. Iterate alumni and enrich data using local lookup (no repeated API calls)
    foreach ($pekerjaan_alumnis as $i => $pekerjaan_alumni) {
        $prov_id = $pekerjaan_alumni['alamat_perusahaan_provinsi'];
        $pekerjaan_alumnis[$i]['nama_alamat_perusahaan_provinsi'] = $provinsi_map[$prov_id] ?? 'Unknown provinsi';
        $pekerjaan_alumnis[$i]['slug_geojson'] = 'indonesia-' . strtolower(str_replace(' ', '', $provinsi_map[$prov_id]));
    }

    // mysqli_stmt_close($stmt);
    // mysqli_close($connection);

    return $pekerjaan_alumnis;
    // echo json_encode($pekerjaan_alumnis);
    // echo "<pre>";
    // print_r($pekerjaan_alumnis);

?>