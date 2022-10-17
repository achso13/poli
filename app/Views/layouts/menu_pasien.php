<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link " href="<?= base_url() ?>">
			<i class="material-icons">dashboard</i>
			<span>Dashboard</span>
		</a>
	</li>

	<li class="nav-item dropdown ">
		<a class="nav-link dropdown-toggle " data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="true">
			<i class="material-icons">medication</i>
			<span>&nbsp;Kunjungan</span>
		</a>
		<div class="dropdown-menu dropdown-menu-small " x-placement="bottom-start">
			<a class="dropdown-item " href="<?= base_url('appointment/add') ?>">Tambah Kunjungan</a>
			<a class="dropdown-item " href="<?= base_url('appointment') ?>">Daftar Kunjungan</a>
		</div>
	</li>

	<li class="nav-item dropdown ">
		<a class="nav-link dropdown-toggle " data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="true">
			<i class="material-icons">medication</i>
			<span>&nbsp;Konsultasi Online</span>
		</a>
		<div class="dropdown-menu dropdown-menu-small " x-placement="bottom-start">
			<a class="dropdown-item " href="<?= base_url('tiket/add') ?>">Tambah Tiket</a>
			<a class="dropdown-item " href="<?= base_url('tiket') ?>">Daftar Tiket</a>
		</div>
	</li>

	<li class="nav-item">
		<a class="nav-link " href="<?= base_url('rekam_medis') ?>">
			<i class="material-icons">summarize</i>
			<span>Rekam Medis</span>
		</a>
	</li>

	<li class="nav-item">
		<a class="nav-link " href="<?= base_url('treatment_schedule') ?>">
			<i class="material-icons">today</i>
			<span>Jadwal Treatment</span>
		</a>
	</li>

	<li class="nav-item">
		<a class="nav-link " href="<?= base_url('resep') ?>">
			<i class="material-icons">today</i>
			<span>Status Resep</span>
		</a>
	</li>

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