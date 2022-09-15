<ul class="nav flex-column">
      <li class="nav-item">
            <a class="nav-link " href="<?= base_url('/') ?>">
                  <i class="material-icons">dashboard</i>
                  <span>Dashboard</span>
            </a>
      </li>


      <li class="nav-item">
            <a class="nav-link " href="<?= base_url('appointment') ?>">
                  <i class="material-icons">medication</i>
                  <span>Appointment </span><br />
                  <span class="ml-4">&nbsp;Periksa Offline</span>
            </a>
      </li>

      <li class="nav-item">
            <a class="nav-link " href="<?= base_url('tiket') ?>">
                  <i class="material-icons">medication</i>
                  <span>Tiket </span><br />
                  <span class="ml-4">&nbsp;Konsultasi Online</span>
            </a>
      </li>

      <h6 class="main-sidebar__nav-title">Data Master</h6>

      <li class="nav-item">
            <a class="nav-link " href="<?= base_url('patient') ?>">
                  <i class="material-icons">group</i>
                  <span>Pasien</span>
            </a>
      </li>

      <!--  <li class="nav-item">
            <a class="nav-link " href="<?= base_url('treatment') ?>">
                  <i class="material-icons">medical_services</i>
                  <span>Treatment</span>
            </a>
      </li> -->

      <!-- <li class="nav-item">
            <a class="nav-link " href="<?= base_url('report/doctor') ?>">
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