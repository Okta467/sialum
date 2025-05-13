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

    <meta name="description" content="Data Kelas" />
    <meta name="author" content="" />
    <title>Kelas - <?= SITE_NAME ?></title>
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
                <h1 class="mb-0">Kelas</h1>
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
                  <i data-feather="book-open" class="me-2 mt-1"></i>
                  Data Kelas
                </div>
                <button class="btn btn-sm btn-primary toggle_modal_tambah" type="button"><i data-feather="plus-circle" class="me-2"></i>Tambah Data</button>
              </div>
              <div class="card-body">
                <table id="datatablesSimple">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nama Kelas</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    $query_kelas = mysqli_query($connection, "SELECT *  FROM tbl_kelas ORDER BY id DESC");

                    while ($kelas = mysqli_fetch_assoc($query_kelas)):
                    ?>

                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= $kelas['nama_kelas'] ?></td>
                        <td>
                          <button class="btn btn-datatable btn-icon btn-transparent-dark me-2 toggle_modal_ubah"
                            data-id_kelas="<?= $kelas['id'] ?>" 
                            data-nama_kelas="<?= $kelas['nama_kelas'] ?>">
                            <i class="fa fa-pen-to-square"></i>
                          </button>
                          <button class="btn btn-datatable btn-icon btn-transparent-dark me-2 toggle_swal_hapus"
                            data-id_kelas="<?= $kelas['id'] ?>" 
                            data-nama_kelas="<?= $kelas['nama_kelas'] ?>">
                            <i class="fa fa-trash-can"></i>
                          </button>
                        </td>
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
    
    <!--============================= MODAL INPUT KELAS =============================-->
    <div class="modal fade" id="ModalInputKelas" tabindex="-1" role="dialog" aria-labelledby="ModalInputKelasTitle" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ModalInputKelasTitle">Modal title</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form>
            <div class="modal-body">
              
              <input type="hidden" id="xid_kelas" name="xid_kelas">
            
              <div class="mb-3">
                <label class="small mb-1" for="xnama_kelas">Kelas</label>
                <input type="text" name="xnama_kelas" class="form-control" id="xnama_kelas" placeholder="Enter kelas" required />
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
        $('.toggle_modal_tambah').on('click', function() {
          $('#ModalInputKelas .modal-title').html(`<i data-feather="plus-circle" class="me-2 mt-1"></i>Tambah Kelas`);
          $('#ModalInputKelas form').attr({action: 'kelas_tambah.php', method: 'post'});

          // Re-init all feather icons
          feather.replace();
          
          $('#ModalInputKelas').modal('show');
        });


        $('.toggle_modal_ubah').on('click', function() {
          const id_kelas   = $(this).data('id_kelas');
          const nama_kelas = $(this).data('nama_kelas');
          
          $('#ModalInputKelas .modal-title').html(`<i data-feather="edit" class="me-2 mt-1"></i>Ubah Kelas`);
          $('#ModalInputKelas form').attr({action: 'kelas_ubah.php', method: 'post'});

          $('#ModalInputKelas #xid_kelas').val(id_kelas);
          $('#ModalInputKelas #xnama_kelas').val(nama_kelas);

          // Re-init all feather icons
          feather.replace();
          
          $('#ModalInputKelas').modal('show');
        });
        

        $('#datatablesSimple').on('click', '.toggle_swal_hapus', function() {
          const id_kelas   = $(this).data('id_kelas');
          const nama_kelas = $(this).data('nama_kelas');
          
          Swal.fire({
            title: "Konfirmasi Tindakan?",
            html: `Hapus data kelas: <strong>${nama_kelas}?</strong>`,
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
                window.location = `kelas_hapus.php?xid_kelas=${id_kelas}`;
              });
            }
          });
        });
        
      });
    </script>

  </body>

  </html>

<?php endif ?>