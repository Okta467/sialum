<?php
include '../helpers/isAccessAllowedHelper.php';

// cek apakah user yang mengakses adalah siswa?
if (!isAccessAllowed('siswa')) :
  session_destroy();
  echo "<meta http-equiv='refresh' content='0;" . base_url_return('index.php?msg=other_error') . "'>";
else :
  include_once '../config/connection.php';
?>


  <!DOCTYPE html>
  <html lang="en">

  <head>
    <?php include '_partials/head.php' ?>

    <meta name="description" content="Data Pekerjaan Alumni" />
    <meta name="author" content="" />
    <title>Pekerjaan Alumni - <?= SITE_NAME ?></title>
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
                <h1 class="mb-0">Pekerjaan Alumni</h1>
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
                  <i data-feather="award" class="me-2 mt-1"></i>
                  Data Pekerjaan Alumni
                </div>
                <button class="btn btn-sm btn-primary toggle_modal_tambah" type="button"><i data-feather="plus-circle" class="me-2"></i>Tambah Data</button>
              </div>
              <div class="card-body">
                <table id="datatablesSimple">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Aksi</th>
                      <th>Alumni</th>
                      <th>Tahun Lulus</th>
                      <th>Perusahaan</th>
                      <th>Jabatan</th>
                      <th>Status</th>
                      <th>Tanggal Masuk</th>
                      <th>Tanggal Keluar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $id_alumni = $_SESSION['id_siswa'];
                    $query_pekerjaan_alumni = mysqli_query($connection, 
                      "SELECT
                        a.*,
                        b.id AS id_alumni, b.nisn, b.nama_siswa AS nama_alumni, b.jk, b.alamat AS alamat_alumni, b.tmp_lahir, b.tgl_lahir, b.no_telp, b.email, b.tahun_lulus,
                        c.id AS id_kelas, c.nama_kelas
                      FROM tbl_pekerjaan_alumni AS a
                      LEFT JOIN tbl_siswa AS b
                        ON a.id_alumni = b.id
                      LEFT JOIN tbl_kelas AS c
                        ON b.id_kelas = c.id
                      WHERE b.id = {$id_alumni}
                      ORDER BY a.id_pekerjaan_alumni DESC");

                    while ($pekerjaan_alumni = mysqli_fetch_assoc($query_pekerjaan_alumni)):
                    ?>

                      <tr>
                        <td><?= $no++ ?></td>
                        <td>
                          <div class="dropdown">
                            <button class="btn btn-sm btn-outline-blue dropdown-toggle" id="dropdownFadeIn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aksi</button>
                            <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownFadeIn">

                              <button class="dropdown-item toggle_modal_ubah" type="button"
                                data-id_pekerjaan_alumni="<?= $pekerjaan_alumni['id_pekerjaan_alumni'] ?>">
                                <i data-feather="edit" class="me-1"></i>
                                Ubah
                              </button>

                              <button class="dropdown-item text-danger toggle_swal_hapus" type="button"
                                data-id_pekerjaan_alumni="<?= $pekerjaan_alumni['id_pekerjaan_alumni'] ?>"
                                data-nama_alumni="<?= $pekerjaan_alumni['nama_alumni'] ?>"
                                data-nama_perusahaan="<?= $pekerjaan_alumni['nama_perusahaan'] ?>">
                                <i data-feather="trash-2" class="me-1"></i>
                                Hapus
                              </button>

                              <div class="dropdown-divider"></div>
                              
                              <button class="dropdown-item toggle_modal_detail_pekerjaan_alumni" type="button"
                                data-id_pekerjaan_alumni="<?= $pekerjaan_alumni['id_pekerjaan_alumni'] ?>"
                                data-nama_alumni="<?= $pekerjaan_alumni['nama_alumni'] ?>"
                                data-nama_perusahaan="<?= $pekerjaan_alumni['nama_perusahaan'] ?>">
                                <i data-feather="list" class="me-1"></i>
                                Detail
                              </button>

                            </div>
                          </div>
                        </td>
                        <td>
                          <?= $pekerjaan_alumni['nama_alumni'] ?>
                          <?= "<br><small class='text-muted'>({$pekerjaan_alumni['nisn']})</small>" ?>
                        </td>
                        <td><?= $pekerjaan_alumni['tahun_lulus'] ?? '<small class="text-muted">Tidak ada</small>' ?></td>
                        <td><?= $pekerjaan_alumni['nama_perusahaan'] ?></td>
                        <td><?= $pekerjaan_alumni['jabatan'] ?></td>
                        <td><?= $pekerjaan_alumni['status_pekerjaan'] ?></td>
                        <td><?= $pekerjaan_alumni['tanggal_masuk'] ?></td>
                        <td><?= $pekerjaan_alumni['tanggal_keluar'] ?? '<small class="text-muted">Tidak ada</small>' ?></td>
                      </tr>

                    <?php endwhile ?>
                  </tbody>
                </table>
              </div>
            </div>
            
          </div>
        </main>
        
        <!--============================= FOOTER =============================-->
        <?php include '_partials/footer.php' ?>
        <!--//END FOOTER -->

      </div>
    </div>
    
    <!--============================= MODAL DETAIL ALUMNI =============================-->
    <div class="modal fade" id="ModalDetailAlumni" tabindex="-1" role="dialog" aria-labelledby="ModalDetailAlumni" aria-hidden="true">
      <div class="modal-dialog" role="document" style="max-width: 600px;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title"><i data-feather="award" class="me-2"></i>Detail Pekerjaan Alumni</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            
            <div class="p-4">
              <h4><i data-feather="star" class="me-2"></i>Alumni</h4>
              <p class="mb-0 xalumni"></p>
            </div>
            
            <div class="p-4">
              <h4><i data-feather="pie-chart" class="me-2"></i>Perusahaan</h4>
              <p class="mb-0 xnama_perusahaan"></p>
            </div>
            
            <div class="p-4">
              <h4><i data-feather="tag" class="me-2"></i>Jabatan</h4>
              <p class="mb-0 xjabatan"></p>
            </div>
            
            <div class="p-4">
              <h4><i data-feather="pocket" class="me-2"></i>Status Pekerjaan</h4>
              <p class="mb-0 xstatus_pekerjaan"></p>
            </div>
            
            <div class="p-4">
              <h4><i data-feather="calendar" class="me-2"></i>Tanggal Masuk dan Keluar</h4>
              <p class="mb-0">
                <span class="xtanggal_masuk"></span> - <span class="xtanggal_keluar"></span>
              </p>
            </div>
            
            <div class="p-4">
              <h4><i data-feather="map-pin" class="me-2"></i>Alamat Perusahaan</h4>
              <p class="mb-0 xalamat_perusahaan"></p>
            </div>
          
          </div>
          <div class="modal-footer">
            <button class="btn btn-light border" type="button" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
    <!--/.modal-detail-pekerjaan_alumni -->
    
    <!--============================= MODAL INPUT PEKERJAAN ALUMNI =============================-->
    <div class="modal fade" id="ModalInputPekerjaanAlumni" tabindex="-1" role="dialog" aria-labelledby="ModalInputPekerjaanAlumniTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalInputPekerjaanAlumniTitle">Modal title</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form>
            <div class="modal-body">
              
              <input type="hidden" id="xid_pekerjaan_alumni" name="xid_pekerjaan_alumni">
    
              <div class="mb-3">
                <label class="small mb-1" for="xid_alumni">Alumni</label>
                <select name="xid_alumni" class="form-control select2" id="xid_alumni" required>
                  <option value="">-- Pilih --</option>
                  <?php $query_siswa = mysqli_query($connection, "SELECT * FROM tbl_siswa WHERE id = {$id_alumni}") ?>
                  <?php while ($siswa = mysqli_fetch_assoc($query_siswa)) : ?>
    
                    <option value="<?= $siswa['id'] ?>"><?= $siswa['nama_siswa'] ?></option>
    
                  <?php endwhile ?>
                </select>
              </div>
            
              <div class="mb-3">
                <label class="small mb-1" for="xnama_perusahaan">Nama Perusahaan <span class="text-danger fw-bold">*</span></label>
                <input type="text" name="xnama_perusahaan" maxlength="128" class="form-control" id="xnama_perusahaan" placeholder="Enter Nama Perusahaan" required />
              </div>
            
              <div class="mb-3">
                <label class="small mb-1" for="xjabatan">Jabatan <span class="text-danger fw-bold">*</span></label>
                <input type="text" name="xjabatan" maxlength="128" class="form-control" id="xjabatan" placeholder="Enter Nama Perusahaan" required />
              </div>
              
              <div class="mb-3">
                <label class="small mb-1" for="xstatus_pekerjaan">Status Pekerjaan <span class="text-danger fw-bold">*</span></label>
                <select name="xstatus_pekerjaan" class="form-control select2" id="xstatus_pekerjaan" required>
                  <option value="">-- Pilih --</option>
                  <option value="masih_bekerja">Masih Bekerja</option>
                  <option value="resign">Resign</option>
                  <option value="magang">Magang</option>
                </select>
              </div>
            
              <div class="mb-3">
                <label class="small mb-1" for="xdeskripsi_pekerjaan">Deskripsi Pekerjaan <span class="text-danger fw-bold">*</span></label>
                <textarea name="xdeskripsi_pekerjaan" class="form-control" id="xdeskripsi_pekerjaan" rows="3" placeholder="Enter Deskripsi Pekerjaan"></textarea>
              </div>
    
    
              <div class="row gx-3">
    
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="small mb-1" for="xtanggal_masuk">Tanggal Masuk <span class="text-danger fw-bold">*</span></label>
                    <input type="date" name="xtanggal_masuk" class="form-control" id="xtanggal_masuk" placeholder="Enter Nama Perusahaan" required />
                  </div>
                </div>
    
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="small mb-1" for="xtanggal_keluar">Tanggal Keluar</label>
                    <input type="date" name="xtanggal_keluar" class="form-control" id="xtanggal_keluar" placeholder="Enter Nama Perusahaan" />
                    <small class="text-danger">Kosongkan jika masih bekerja</small>
                  </div>
                </div>
                
                <div class="mb-3">
                  <label class="small mb-1" for="xalamat_simpel">Alamat Perusahaan <span class="text-danger fw-bold">*</span></label>
                  <input type="text" name="xalamat_simpel" maxlength="255" class="form-control" id="xalamat_simpel" placeholder="Enter Nama Jalan, No-Rumah, Lorong, dll." required />
                </div>
    
              </div>
              
              <div class="mb-3">
                <label class="small mb-1" for="xalamat_perusahaan_provinsi">Provinsi <span class="text-danger fw-bold">*</span></label>
                <select name="xalamat_perusahaan_provinsi" class="form-control select2" id="xalamat_perusahaan_provinsi" required>
                  <option value="">-- Pilih --</option>
                </select>
              </div>
              
              <div class="mb-3">
                <label class="small mb-1" for="xalamat_perusahaan_kab_kota">Kabupaten/Kota <span class="text-danger fw-bold">*</span></label>
                <select name="xalamat_perusahaan_kab_kota" class="form-control select2" id="xalamat_perusahaan_kab_kota" required>
                  <option value="">-- Pilih --</option>
                </select>
              </div>
              
              <div class="mb-3">
                <label class="small mb-1" for="xalamat_perusahaan_kecamatan">Kecamatan <span class="text-danger fw-bold">*</span></label>
                <select name="xalamat_perusahaan_kecamatan" class="form-control select2" id="xalamat_perusahaan_kecamatan" required>
                  <option value="">-- Pilih --</option>
                </select>
              </div>
              
              <div class="mb-3">
                <label class="small mb-1" for="xalamat_perusahaan_kelurahan">Kelurahan <span class="text-danger fw-bold">*</span></label>
                <select name="xalamat_perusahaan_kelurahan" class="form-control select2" id="xalamat_perusahaan_kelurahan" required>
                  <option value="">-- Pilih --</option>
                </select>
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
        
        const selectModalInputPekerjaanAlumni = $('#ModalInputPekerjaanAlumni .select2');
        initSelect2(selectModalInputPekerjaanAlumni, {
          width: '100%',
          dropdownParent: "#ModalInputPekerjaanAlumni .modal-content .modal-body"
        });

        function delaySetValue(selector, value) {
          return $.Deferred(function (defer) {
            setTimeout(function () {
              $(selector).val(value).trigger('change');
              defer.resolve();
            }, 500);
          }).promise();
        }

        const getWilayahIndonesia = function(apiUrl) {
          $.ajax({
            url: apiUrl,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
              return data;
            },
            error: function(request, status, error) {
              console.log("ajax call went wrong:" + request.responseText);
              // console.log("ajax call went wrong:" + error);
            }
          });
        }

        const populateSelectWilayahIndonesia = function(apiUrl, selectElementIdToApply, clearFirstOption = true) {
          data = getWilayahIndonesia(apiUrl);
          $.ajax({
            url: apiUrl,
            method: 'GET',
            dataType: 'json',
            success: function (data) {
              // Clear existing options except the first
              if (clearFirstOption) {
                $(selectElementIdToApply).find('option:not(:first)').remove();
              }

              // Populate from JSON response
              $.each(data, function (index, item) {
                $(selectElementIdToApply).append(
                  $('<option>', {
                    value: item.id,
                    text: item.name
                  })
                );
              });
            },
            error: function(request, status, error) {
              console.log("ajax call went wrong:" + request.responseText);
              // console.log("ajax call went wrong:" + error);
            }
          });
        }


        // Populate province select option from API URL
        populateSelectWilayahIndonesia(
          'https://okta467.github.io/api-wilayah-indonesia/api/provinces.json'
          , '#xalamat_perusahaan_provinsi'
        );


        // Populate kabupaten/kota select option from API URL
        $('#xalamat_perusahaan_provinsi').on('change', function() {
          const id_provinsi = $(this).val();
          const url = `https://okta467.github.io/api-wilayah-indonesia/api/regencies/${id_provinsi}.json`;
          
          populateSelectWilayahIndonesia(url, '#xalamat_perusahaan_kab_kota');
        });


        // Populate kecamatan select option from API URL
        $('#xalamat_perusahaan_kab_kota').on('change', function() {
          const id_kab_kota = $(this).val();
          const url = `https://okta467.github.io/api-wilayah-indonesia/api/districts/${id_kab_kota}.json`;
          
          populateSelectWilayahIndonesia(url, '#xalamat_perusahaan_kecamatan');
        });


        // Populate kelurahan select option from API URL
        $('#xalamat_perusahaan_kecamatan').on('change', function() {
          const id_kecamatan = $(this).val();
          const url = `https://okta467.github.io/api-wilayah-indonesia/api/villages/${id_kecamatan}.json`;
          
          populateSelectWilayahIndonesia(url, '#xalamat_perusahaan_kelurahan');
        });


        $('.toggle_modal_tambah').on('click', function() {
          $('#ModalInputPekerjaanAlumni .modal-title').html(`<i data-feather="plus-circle" class="me-2 mt-1"></i>Tambah Pekerjaan Alumni`);
          $('#ModalInputPekerjaanAlumni form').attr({action: 'pekerjaan_alumni_tambah.php', method: 'post'});

          // Re-init all feather icons
          feather.replace();
          
          $('#ModalInputPekerjaanAlumni').modal('show');
        });


        $('.toggle_modal_ubah').on('click', function() {
          const id_pekerjaan_alumni = $(this).data('id_pekerjaan_alumni');
          
          $('#ModalInputPekerjaanAlumni .modal-title').html(`<i data-feather="edit" class="me-2 mt-1"></i>Ubah Pekerjaan Alumni`);
          $('#ModalInputPekerjaanAlumni form').attr({action: 'pekerjaan_alumni_ubah.php', method: 'post'});
        
          $.ajax({
            url: 'get_pekerjaan_alumni.php',
            method: 'POST',
            dataType: 'JSON',
            data: {
              'id_pekerjaan_alumni': id_pekerjaan_alumni,
              'get_nama_alamat_perusahaan': false,
            },
            success: function(datas) {
              const data = datas[0];
                
              $('#ModalInputPekerjaanAlumni #xid_pekerjaan_alumni').val(data.id_pekerjaan_alumni);
              $('#ModalInputPekerjaanAlumni #xid_alumni').val(data.id_alumni).trigger('change');
              $('#ModalInputPekerjaanAlumni #xnama_perusahaan').val(data.nama_perusahaan);
              $('#ModalInputPekerjaanAlumni #xjabatan').val(data.jabatan);
              $('#ModalInputPekerjaanAlumni #xstatus_pekerjaan').val(data.status_pekerjaan).trigger('change');
              $('#ModalInputPekerjaanAlumni #xdeskripsi_pekerjaan').val(data.deskripsi_pekerjaan);
              $('#ModalInputPekerjaanAlumni #xtanggal_masuk').val(data.tanggal_masuk);
              $('#ModalInputPekerjaanAlumni #xtanggal_keluar').val(data.tanggal_keluar);
              $('#ModalInputPekerjaanAlumni #xalamat_simpel').val(data.alamat_simpel);
              $('#ModalInputPekerjaanAlumni #xalamat_perusahaan_provinsi').val(data.alamat_perusahaan_provinsi).trigger('change');

              delaySetValue('#ModalInputPekerjaanAlumni #xalamat_perusahaan_kab_kota', data.alamat_perusahaan_kab_kota)
              .then(function(){
                return delaySetValue('#ModalInputPekerjaanAlumni #xalamat_perusahaan_kecamatan', data.alamat_perusahaan_kecamatan);
              })
              .then(function(){
                return delaySetValue('#ModalInputPekerjaanAlumni #xalamat_perusahaan_kelurahan', data.alamat_perusahaan_kelurahan);
              });
                
              
              // Re-init all feather icons
              feather.replace();
              
              $('#ModalInputPekerjaanAlumni').modal('show');
            },
            error: function(request, status, error) {
              // console.log("ajax call went wrong:" + request.responseText);
              console.log("ajax call went wrong:" + error);
            }
          });
        });

        
        $('.toggle_modal_detail_pekerjaan_alumni').on('click', function() {
          const id_pekerjaan_alumni = $(this).data('id_pekerjaan_alumni');
        
          $.ajax({
            url: 'get_pekerjaan_alumni.php',
            method: 'POST',
            dataType: 'JSON',
            data: {
              'id_pekerjaan_alumni': id_pekerjaan_alumni,
              'get_nama_alamat_perusahaan': true,
            },
            success: function(datas) {
              const data = datas[0];
              
              const alumni = data.nisn
                ? `${data.nama_alumni} (${data.nisn})`
                : `${data.nama_alumni}`;
              
              const alamat_perusahaan = `${data.alamat_simpel}`
                + `, ${data.nama_alamat_perusahaan_kecamatan}`
                + `,  ${data.nama_alamat_perusahaan_kelurahan}`
                + `,  ${data.nama_alamat_perusahaan_kab_kota}`
                + `,  ${data.nama_alamat_perusahaan_provinsi}.`;
              
              $('#ModalDetailAlumni .xalumni').html(alumni);
              $('#ModalDetailAlumni .xnama_perusahaan').html(data.nama_perusahaan);
              $('#ModalDetailAlumni .xjabatan').html(data.jabatan);
              $('#ModalDetailAlumni .xstatus_pekerjaan').html(data.status_pekerjaan);
              $('#ModalDetailAlumni .xtanggal_keluar').html(data.tanggal_keluar);
              $('#ModalDetailAlumni .xtanggal_masuk').html(data.tanggal_masuk);
              $('#ModalDetailAlumni .xalamat_perusahaan').html(alamat_perusahaan);
              
              $('#ModalDetailAlumni').modal('show');
            },
            error: function(request, status, error) {
              // console.log("ajax call went wrong:" + request.responseText);
              console.log("ajax call went wrong:" + error);
            }
          });
        });
        

        $('#datatablesSimple').on('click', '.toggle_swal_hapus', function() {
          const id_pekerjaan_alumni = $(this).data('id_pekerjaan_alumni');
          const nama_alumni         = $(this).data('nama_alumni');
          const nama_perusahaan     = $(this).data('nama_perusahaan');
          
          Swal.fire({
            title: "Konfirmasi Tindakan?",
            html: `Hapus data pekerjaan alumni: <strong>${nama_alumni} - ${nama_perusahaan}?</strong>`,
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
                window.location = `pekerjaan_alumni_hapus.php?xid_pekerjaan_alumni=${id_pekerjaan_alumni}`;
              });
            }
          });
        });
        
      });
    </script>

  </body>

  </html>

<?php endif ?>