<ul class="nav flex-column">
	<li class="nav-item">
		<a class="nav-link " href="<?= base_url() ?>">
			<i class="material-icons">dashboard</i>
			<span>Dashboard</span>
		</a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="<?= base_url("appointment") ?>">
			<i class="material-icons">medication</i>
			<span>&nbsp;Kunjungan</span>
		</a>
	</li>

	<li class="nav-item">
		<a class="nav-link" href="<?= base_url("tiket") ?>">
			<i class="material-icons">medication</i>
			<span>&nbsp;Konsultasi Online</span>
		</a>
	</li>

	<!-- <li class="nav-item">
		<a class="nav-link " href="<?= base_url('rekam_medis') ?>">
			<i class="material-icons">summarize</i>
			<span>Rekam Medis</span>
		</a>
	</li> -->

	<li class="nav-item">
		<a class="nav-link " href="<?= base_url('treatment_schedule') ?>">
			<i class="material-icons">today</i>
			<span>Jadwal Treatment</span>
		</a>
	</li>

	<li class="nav-item">
		<a class="nav-link " href="<?= base_url('resep') ?>">
			<i class="material-icons">today</i>
			<span>Resep</span>
		</a>
	</li>

	<h6 class="main-sidebar__nav-title">Informasi</h6>

	<li class="nav-item">
		<a class="nav-link " href="<?= base_url('informasi') ?>">
			<i class="material-icons">info</i>
			<span>Informasi Dokter</span>
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