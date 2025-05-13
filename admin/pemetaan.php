<?php
include '../helpers/isAccessAllowedHelper.php';

// cek apakah user yang mengakses adalah admin?
if (!isAccessAllowed('admin')) :
  session_destroy();
  echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
else :
  include_once '../config/connection.php';
?>


  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php include '_partials/head.php' ?>

    <meta name="description" content="Data Pemetaan" />
    <meta name="author" content="" />
    <title>Pemetaan - <?= SITE_NAME ?></title>
  </head>

  <body class="nav-fixed">
    <!--============================= TOPNAV =============================-->
    <?php include '_partials/topnav.php' ?>
    <!--//END TOPNAV -->
    <div id="layoutSidenav">
      <div id="layoutSidenav_nav">
        <!--============================= SIDEBAR =============================-->
        <?php include '_partials/sidebar.php' ?>
        <!--//END SIDEBAR -->
      </div>
      <div id="layoutSidenav_content">
        <main>
          <!-- Main page content-->
          <div class="container-xl px-4 mt-5">

            <!-- Custom page header alternative example-->
            <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
              <div class="me-4 mb-3 mb-sm-0">
                <h1 class="mb-0">Pemetaan</h1>
                <div class="small">
                  <span class="fw-500 text-primary"><?= date('D') ?></span>
                  &middot; <?= date('M d, Y') ?> &middot; <?= date('H:i') ?> WIB
                </div>
              </div>

              <!-- Date range picker example-->
              <div class="input-group input-group-joined border-0 shadow w-auto">
                <span class="input-group-text"><i data-feather="calendar"></i></span>
                <input class="form-control ps-0 pointer" id="litepickerRangePlugin" value="Tanggal: <?= date('d M Y') ?>" readonly />
              </div>

            </div>
            
            <!-- Main page content-->
            <div class="card card-header-actions mb-4 mt-5">
              <div class="card-header">
                <div>
                  <i data-feather="map" class="me-2 mt-4 mt-md-0"></i>
                  Peta Sebaran Alumni (di Indonesia)
                </div>
                <button class="btn btn-sm btn-primary toggle_modal_tambah" type="button"><i data-feather="plus-circle" class="me-2"></i>Tambah Data</button>
              </div>
              <div class="card-body">

                <div class="row">
                  <div class="col-md-9">
                    <div id="map" style="height: 500px"></div>
                  </div>
                  <div class="col-md-3">
                    <div class="card mb-4 mt-sm-4">
                      <div class="card-header">Sebaran Alumni</div>
                      <div class="list-group list-group-flush small" id="data-sebaran-alumni">
                      </div>
                    </div>
                  </div>
                
              </div>
            </div>
            
          </div>
        </main>
        
        <!--============================= FOOTER =============================-->
        <?php include '_partials/footer.php' ?>
        <!--//END FOOTER -->

      </div>
    </div>
    
    <?php include '_partials/script.php' ?>
    <?php include '../helpers/sweetalert2_notify.php' ?>
    
    <!-- PAGE SCRIPT -->
    <script>
      $(document).ready(function() {
        $('#datatablesSimple').on('click', '.toggle_swal_hapus', function() {
          const id_pemetaan   = $(this).data('id_pemetaan');
          const nama_pemetaan = $(this).data('nama_pemetaan');
          
          Swal.fire({
            title: "Konfirmasi Tindakan?",
            html: `Hapus data pemetaan: <strong>${nama_pemetaan}?</strong>`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, konfirmasi!"
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire({
                title: "Tindakan Dikonfirmasi!",
                text: "Halaman akan di-reload untuk memproses.",
                icon: "success",
                timer: 3000
              }).then(() => {
                window.location = `pemetaan_hapus.php?xid_pemetaan=${id_pemetaan}`;
              });
            }
          });
        });

        const dataSebaranAlumni = <?= json_encode(include 'get_sebaran_alumni.php'); ?>; 
        const allowedSlugs = <?= json_encode(array_column(include 'get_sebaran_alumni.php', 'slug_geojson')); ?>;

        $.each(dataSebaranAlumni, function (i) {
          let provinsi = dataSebaranAlumni[i].nama_alamat_perusahaan_provinsi;
          let jml_alumni = dataSebaranAlumni[i].jml_provinsi;
          
          let htmlSebaranAlumni = `<a class="list-group-item list-group-item-action" href="#!">`
            + `<i class="fas fa-location-dot fa-fw text-blue me-2"></i>`
            + `${provinsi}: ${jml_alumni} Orang</a>`

          $('#data-sebaran-alumni').append(htmlSebaranAlumni)
        });


        
        //-----------------
        // Leaflet
        //-----------------
        // Initialize the map
        var map = L.map('map', {zoomSnap: 0.25}).setView([-2.5, 117], 4.75);
        
        // Base layer (OpenStreetMap)
        var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        
        // GeoJSON overlay
        var indonesiaLayer = L.geoJSON(null, {
          style: {
            color: "blue",
            weight: 2,
            fillOpacity: 0.3
          },
          filter: function (feature) {
            // Check if the feature's slug_geojson exists and is NOT in allowedSlugs array
            return feature.properties && !allowedSlugs.includes(feature.properties.slug);
          },
          onEachFeature: function (feature, layer) {
            if (feature.properties && feature.properties.state) {
              layer.bindPopup(feature.properties.state);
            }
          }
        }).addTo(map);
        
        // GeoJSON overlay
        var sebaranAlumni = L.geoJSON(null, {
          style: {
            color: 'red',
            weight: 2,
            fillOpacity: 0.3
          },
          filter: function (feature) {
            // Check if the feature's slug_geojson exists and is in allowedSlugs array
            return feature.properties && allowedSlugs.includes(feature.properties.slug);
          },
          onEachFeature: function (feature, layer) {
            // console.log(dataSebaranAlumni)
            if (feature.properties && feature.properties.state) {
              layer.bindPopup(`${feature.properties.state}: ${feature.properties.jml_provinsi} Orang`);
            }
          }
        }).addTo(map);
        
        // Load GeoJSON dynamically
        fetch(`<?= base_url('assets/json/indonesia.geojson') ?>`)
          .then(response => response.json())
          .then(data => {
            // Step 1: filter features that have a matching slug in allowedSlugs
            const filteredFeatures = data.features
              .filter(feature =>
                dataSebaranAlumni.some(item => item.slug_geojson === feature.properties.slug)
              )
              .map(feature => {
                // Step 2: enrich with jml_provinsi if found
                const match = dataSebaranAlumni.find(item => item.slug_geojson === feature.properties.slug);
                return {
                  ...feature,
                  properties: {
                    ...feature.properties,
                    jml_provinsi: match ? match.jml_provinsi : null,
                    alamat_perusahaan_provinsi: match ? match.alamat_perusahaan_provinsi : null
                  }
                };
              });
              
            // Step 3: create the final object
            const filteredData = {
              ...data,
              features: filteredFeatures
            };

            indonesiaLayer.addData(data);
            sebaranAlumni.addData(filteredData);
          });
        
        // Layer controls
        var baseLayers = {
          "OpenStreetMap": osm
        };
        
        var overlays = {
          "Provinsi di Indonesia": indonesiaLayer,
          "Sebaran Alumni": sebaranAlumni,
        };
        
        // Add layer control to the map
        L.control.layers(baseLayers, overlays, {
          collapsed: false
        }).addTo(map);
        
      });
    </script>

  </body>

  </html>

<?php endif ?>