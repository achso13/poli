<ul class="nav flex-column">
      <li class="nav-item">
            <a class="nav-link " href="<?= base_url('/') ?>">
                  <i class="material-icons">dashboard</i>
                  <span>Dashboard</span>
            </a>
      </li>

      <h6 class="main-sidebar__nav-title">Transaksi</h6>

      <li class="nav-item">
            <a class="nav-link " href="<?= base_url('appointment') ?>">
                  <i class="material-icons">medication</i>
                  <span>&nbsp;Kunjungan</span>
            </a>
      </li>

      <li class="nav-item">
            <a class="nav-link " href="<?= base_url('tiket') ?>">
                  <i class="material-icons">medication</i>
                  <span>&nbsp;Konsultasi Online</span>
            </a>
      </li>

      <li class="nav-item">
            <a class="nav-link " href="<?= base_url('laporan') ?>">
                  <i class="material-icons">summarize</i>
                  <span>Laporan</span>
            </a>
      </li>

      <h6 class="main-sidebar__nav-title">Data Master</h6>

      <li class="nav-item dropdown ">
            <a class="nav-link dropdown-toggle " data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="true">
                  <i class="material-icons">group</i>
                  <span>Dokter</span>
            </a>
            <div class="dropdown-menu dropdown-menu-small " x-placement="bottom-start">
                  <a class="dropdown-item " href="<?= base_url('doctor') ?>">Data Dokter</a>
                  <a class="dropdown-item " href="<?= base_url('doctor/jadwal') ?>">Jadwal Dokter</a>
            </div>
      </li>

      <li class="nav-item">

      </li>

      <li class="nav-item">
            <a class="nav-link " href="<?= base_url('clinic') ?>">
                  <i class="material-icons">medical_services</i>
                  <span>Klinik</span>
            </a>
      </li>


      <li class="nav-item">
            <a class="nav-link " href="<?= base_url('medicine') ?>">
                  <i class="material-icons">medication</i>
                  <span>Obat</span>
            </a>
      </li>

      <li class="nav-item">
            <a class="nav-link " href="<?= base_url('treatment') ?>">
                  <i class="material-icons">medical_services</i>
                  <span>Treatment</span>
            </a>
      </li>

      <li class="nav-item">
            <a class="nav-link " href="<?= base_url('patient') ?>">
                  <i class="material-icons">group</i>
                  <span>Pasien</span>
            </a>
      </li>



      <li class="nav-item">
            <a class="nav-link " href="<?= base_url('users') ?>">
                  <i class="material-icons">manage_accounts</i>
                  <span>User Management</span>
            </a>
      </li>

      <li class="nav-item">
            <a class="nav-link " href="<?= base_url('unitkerja') ?>">
                  <i class="material-icons">work</i>
                  <span>Unit Kerja</span>
            </a>
      </li>

      <!-- <h6 class="main-sidebar__nav-title">Report</h6> -->

      <!--  <li class="nav-item">
            <a class="nav-link " href="<?= base_url('report') ?>">
                  <i class="material-icons">summarize</i>
                  <span>Report</span>
            </a>
      </li> -->

      <h6 class="main-sidebar__nav-title">Profile</h6>

      <li class="nav-item">
            <a class="nav-link " href="<?= base_url('profile') ?>">
                  <i class="material-icons">person</i>
                  <span>Profile</span>
            </a>
      </li>

      <li class="nav-item">
            <a class="nav-link " href="<?= base_url('auth/logout') ?>">
                  <i class="material-icons">logout</i>
                  <span>Logout</span>
            </a>
      </li>
</ul>