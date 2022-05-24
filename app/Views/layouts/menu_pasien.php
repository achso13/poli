<ul class="nav flex-column">
	<li class="nav-item">
	    <a class="nav-link " href="<?=base_url('dashboard')?>">
	          <i class="material-icons">dashboard</i>
	          <span>Dashboard</span>
	    </a>
	</li>

	<li class="nav-item dropdown ">
		<a class="nav-link dropdown-toggle " data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="true">
			<i class="material-icons">medication</i>
            <span>Appointment </span><br/>
            <span class="ml-4">&nbsp;Periksa Offline</span>
		</a>
		<div class="dropdown-menu dropdown-menu-small " x-placement="bottom-start">
			<a class="dropdown-item " href="<?=base_url('appointment/form')?>">Tambah Periksa Offline</a>
			<a class="dropdown-item " href="<?=base_url('appointment')?>">Daftar Periksa Offline</a>
		</div>
	</li>

	<li class="nav-item dropdown ">
		<a class="nav-link dropdown-toggle " data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="true">
			<i class="material-icons">medication</i>
           	<span>Tiket </span><br/>
            <span class="ml-4">&nbsp;Konsultasi Online</span>
		</a>
		<div class="dropdown-menu dropdown-menu-small " x-placement="bottom-start">
			<a class="dropdown-item " href="<?=base_url('tiket/form')?>">Tambah Tiket</a>
			<a class="dropdown-item " href="<?=base_url('tiket')?>">Daftar Tiket</a>
		</div>
	</li>

	<li class="nav-item">
	    <a class="nav-link " href="<?=base_url('schedule/treatment')?>">
	          <i class="material-icons">summarize</i>
	          <span>Rekam Medis</span>
	    </a>
	</li>

	<li class="nav-item">
	    <a class="nav-link " href="<?=base_url('schedule/treatment')?>">
	          <i class="material-icons">today</i>
	          <span>Jadwal Treatment</span>
	    </a>
	</li>

	<li class="nav-item">
	    <a class="nav-link " href="<?=base_url('schedule/pickup')?>">
	          <i class="material-icons">today</i>
	          <span>Ambil Obat</span>
	    </a>
	</li>

</ul>