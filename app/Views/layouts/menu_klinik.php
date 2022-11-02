<ul class="nav flex-column">
      <li class="nav-item">
            <a class="nav-link " href="<?= base_url('/') ?>">
                  <i class="material-icons">dashboard</i>
                  <span>Dashboard</span>
            </a>
      </li>
      <li class="nav-item">
            <a class="nav-link " href="<?= base_url('treatment_schedule') ?>">
                  <i class="material-icons">today</i>
                  <span>Jadwal Treatment</span>
            </a>
      </li>


      <li class="nav-item">
            <a class="nav-link " href="<?= base_url('treatment') ?>">
                  <i class="material-icons">medical_services</i>
                  <span>Data Treatment</span>
            </a>
      </li>

      <!--  <li class="nav-item dropdown ">
            <a class="nav-link dropdown-toggle " data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="true">
                  <i class="material-icons">medical_services</i>
            <span>Treatment</span>
            </a>
            <div class="dropdown-menu dropdown-menu-small " x-placement="bottom-start">
                  <a class="dropdown-item btn-treatment " href="#" data-toggle="modal" data-target="#form-modals">Tambah Treatment</a>
                  <a class="dropdown-item " href="<?= base_url('treatment') ?>">Daftar Treatment</a>
            </div>
      </li> -->
      <!-- <li class="nav-item">
            <a class="nav-link " href="<?= base_url('patient') ?>">
                  <i class="material-icons">group</i>
                  <span>Data Pasien</span>
            </a>
      </li> -->


      <!--   <li class="nav-item">
            <a class="nav-link " href="<?= base_url('report/klinik') ?>">
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