<?php
$current_page = $_GET['go'] ?? '';
$user_logged_in = $_SESSION['nama_pegawai'] ?? $_SESSION['nama_guest'] ?? $_SESSION['username'];
?>

<nav class="sidenav shadow-right sidenav-light">
  <div class="sidenav-menu">
    <div class="nav accordion" id="accordionSidenav">
      <!-- Sidenav Menu Heading (Core)-->
      <div class="sidenav-menu-heading">Core</div>
      
      <a class="nav-link <?php if ($current_page === 'dashboard') echo 'active' ?>" href="index.php?go=dashboard">
        <div class="nav-link-icon"><i data-feather="activity"></i></div>
        Dashboard
      </a>

      <div class="sidenav-menu-heading">Pengguna</div>
      
      <a class="nav-link <?php if ($current_page === 'pengguna') echo 'active' ?>" href="pengguna.php?go=pengguna">
        <div class="nav-link-icon"><i data-feather="users"></i></div>
        Pengguna
      </a>

      <a class="nav-link <?php if ($current_page === 'siswa') echo 'active' ?>" href="siswa.php?go=siswa">
        <div class="nav-link-icon"><i data-feather="user"></i></div>
        Siswa
      </a>

      <a class="nav-link <?php if ($current_page === 'guru') echo 'active' ?>" href="guru.php?go=guru">
        <div class="nav-link-icon"><i data-feather="user"></i></div>
        Guru
      </a>
      
      <div class="sidenav-menu-heading">Data Siswa</div>
      
      <a class="nav-link <?php if ($current_page === 'pemetaan') echo 'active' ?>" href="pemetaan.php?go=pemetaan">
        <div class="nav-link-icon"><i data-feather="map"></i></div>
        Pemetaan
      </a>
      
      <a class="nav-link <?php if ($current_page === 'pekerjaan_alumni') echo 'active' ?>" href="pekerjaan_alumni.php?go=pekerjaan_alumni">
        <div class="nav-link-icon"><i data-feather="award"></i></div>
        Pekerjaan
      </a>
      
      <a class="nav-link <?php if ($current_page === 'kompetensi_siswa') echo 'active' ?>" href="kompetensi_siswa.php?go=kompetensi_siswa">
        <div class="nav-link-icon"><i data-feather="star"></i></div>
        Kompetensi
      </a>
      
      <a class="nav-link <?php if ($current_page === 'prestasi_siswa') echo 'active' ?>" href="prestasi_siswa.php?go=prestasi_siswa">
        <div class="nav-link-icon"><i data-feather="star"></i></div>
        Prestasi
      </a>

      <a class="nav-link <?php if ($current_page === 'kelas') echo 'active' ?>" href="kelas.php?go=kelas">
        <div class="nav-link-icon"><i data-feather="book-open"></i></div>
        Kelas
      </a>
      
      <div class="sidenav-menu-heading">Lainnya</div>

      <a class="nav-link <?php if ($current_page === 'informasi') echo 'active' ?>" href="informasi.php?go=informasi">
        <div class="nav-link-icon"><i data-feather="info"></i></div>
        Informasi
      </a>
      
      <div class="sidenav-menu-heading">Detail Guru</div>

      <a class="nav-link <?php if ($current_page === 'jabatan') echo 'active' ?>" href="jabatan.php?go=jabatan">
        <div class="nav-link-icon"><i data-feather="briefcase"></i></div>
        Jabatan
      </a>

      <a class="nav-link <?php if ($current_page === 'pangkat_golongan') echo 'active' ?>" href="pangkat_golongan.php?go=pangkat_golongan">
        <div class="nav-link-icon"><i data-feather="briefcase"></i></div>
        Pangkat / Golongan
      </a>

      <a class="nav-link <?php if ($current_page === 'pendidikan') echo 'active' ?>" href="pendidikan.php?go=pendidikan">
        <div class="nav-link-icon"><i data-feather="book"></i></div>
        Pendidikan
      </a>

      <a class="nav-link <?php if ($current_page === 'jurusan_pendidikan') echo 'active' ?>" href="jurusan_pendidikan.php?go=jurusan_pendidikan">
        <div class="nav-link-icon"><i data-feather="book"></i></div>
        Jurusan
      </a>

    </div>
  </div>
  <!-- Sidenav Footer-->
  <div class="sidenav-footer">
    <div class="sidenav-footer-content">
      <div class="sidenav-footer-subtitle">Anda masuk sebagai:</div>
      <div class="sidenav-footer-title"><?= ucwords($user_logged_in) ?></div>
    </div>
  </div>
</nav>