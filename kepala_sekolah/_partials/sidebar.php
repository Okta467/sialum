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

      <div class="sidenav-menu-heading">Akun</div>

      <a class="nav-link <?php if ($current_page === 'profil') echo 'active' ?>" href="profil.php?go=profil">
        <div class="nav-link-icon"><i data-feather="user"></i></div>
        Profil
      </a>
      
      <div class="sidenav-menu-heading">Data Alumni</div>
      
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

      <a class="nav-link <?php if ($current_page === 'informasi') echo 'active' ?>" href="informasi.php?go=informasi">
        <div class="nav-link-icon"><i data-feather="info"></i></div>
        Informasi
      </a>
      
      <div class="sidenav-menu-heading">Lainnya</div>
      
      <a class="nav-link" href="<?= base_url('logout.php') ?>">
        <div class="nav-link-icon"><i data-feather="log-out"></i></div>
        Keluar
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