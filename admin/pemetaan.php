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
                  <i data-feather="map" class="me-2 mt-1"></i>
                  Data Sebaran Alumni (di Indonesia)
                </div>
                <button class="btn btn-sm btn-primary toggle_modal_tambah" type="button"><i data-feather="plus-circle" class="me-2"></i>Tambah Data</button>
              </div>
              <div class="card-body">

                <div class="row">
                  <div class="col-md-9">
                    <div id="map" style="height: 500px"></div>
                  </div>
                  <div class="col-md-3">
                    <div class="card mb-4">
                      <div class="card-header">Sebaran Alumni</div>
                      <div class="list-group list-group-flush small">
                        <a class="list-group-item list-group-item-action" href="#!">
                          <i class="fas fa-location-dot fa-fw text-blue me-2"></i>
                          Sumatera Selatan: 1 Orang
                        </a>
                        <a class="list-group-item list-group-item-action" href="#!">
                          <i class="fas fa-location-dot fa-fw text-blue me-2"></i>
                          Sumatera Selatan: 1 Orang
                        </a>
                        <a class="list-group-item list-group-item-action" href="#!">
                          <i class="fas fa-location-dot fa-fw text-blue me-2"></i>
                          Sumatera Selatan: 1 Orang
                        </a>
                        <a class="list-group-item list-group-item-action" href="#!">
                          <i class="fas fa-location-dot fa-fw text-blue me-2"></i>
                          Sumatera Selatan: 1 Orang
                        </a>
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
    
    <!--============================= MODAL INPUT PEMETAAN =============================-->
    <div class="modal fade" id="ModalInputPemetaan" tabindex="-1" role="dialog" aria-labelledby="ModalInputPemetaanTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalInputPemetaanTitle">Modal title</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form>
            <div class="modal-body">
              
              <input type="hidden" id="xid_pemetaan" name="xid_pemetaan">
            
              <div class="mb-3">
                <label class="small mb-1" for="xnama_pemetaan">Pemetaan</label>
                <input type="text" name="xnama_pemetaan" class="form-control" id="xnama_pemetaan" placeholder="Enter pemetaan" required />
              </div>

            </div>
            <div class="modal-footer">
              <button class="btn btn-light border" type="button" data-bs-dismiss="modal">Batal</button>
              <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--/.modal-input-jurusan -->
    
    <?php include '_partials/script.php' ?>
    <?php include '../helpers/sweetalert2_notify.php' ?>
    
    <!-- PAGE SCRIPT -->
    <script>
      $(document).ready(function() {
        
        // 
        fetch('https://okta467.github.io/api-wilayah-indonesia/api/provinces.json')
          .then(response => response.json())
          .then(data => {
            console.log(data)
          });
        
        
        $('.toggle_modal_tambah').on('click', function() {
          $('#ModalInputPemetaan .modal-title').html(`<i data-feather="plus-circle" class="me-2 mt-1"></i>Tambah Pemetaan`);
          $('#ModalInputPemetaan form').attr({action: 'pemetaan_tambah.php', method: 'post'});

          // Re-init all feather icons
          feather.replace();
          
          $('#ModalInputPemetaan').modal('show');
        });


        $('.toggle_modal_ubah').on('click', function() {
          const id_pemetaan   = $(this).data('id_pemetaan');
          const nama_pemetaan = $(this).data('nama_pemetaan');
          
          $('#ModalInputPemetaan .modal-title').html(`<i data-feather="edit" class="me-2 mt-1"></i>Ubah Pemetaan`);
          $('#ModalInputPemetaan form').attr({action: 'pemetaan_ubah.php', method: 'post'});

          $('#ModalInputPemetaan #xid_pemetaan').val(id_pemetaan);
          $('#ModalInputPemetaan #xnama_pemetaan').val(nama_pemetaan);

          // Re-init all feather icons
          feather.replace();
          
          $('#ModalInputPemetaan').modal('show');
        });
        

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
            return feature.properties && feature.properties.active_status === "not-active";
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
            return feature.properties && feature.properties.active_status === "active";
          },
          onEachFeature: function (feature, layer) {
            console.log(feature.properties.active_status === 'active');
            if (feature.properties && feature.properties.state) {
              layer.bindPopup(feature.properties.state);
            }
          }
        }).addTo(map);
        
        // Load GeoJSON dynamically
        fetch(`<?= base_url('assets/json/indonesia.geojson') ?>`)
          .then(response => response.json())
          .then(data => {
            indonesiaLayer.addData(data);
            sebaranAlumni.addData(data);
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