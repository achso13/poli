<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<!-- Page Header -->
<div class="page-header row no-gutters py-4">
	<div class="col-12 col-sm-6 text-center text-sm-left mb-4 mb-sm-0">
		<span class="text-uppercase page-subtitle">List</span>
		<h3 class="page-title">Rekam Medis</h3>
	</div>
</div>
<!-- End Page Header -->

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				Informasi Pasien
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table">
						<tr>
							<td>ID Number / Nama Pasien</td>
							<td>:</td>
							<td><?= $pasien['id_pasien'] .  " / " . $pasien['nama'] ?></td>
							<td>Unit Kerja</td>
							<td>:</td>
							<td><?= $pasien['nama_biro'] .  " / " . $pasien['nama_bagian'] ?></td>
						</tr>
						<tr>
							<td>Jenis Kelamin</td>
							<td>:</td>
							<td><?= $pasien['jenis_kelamin'] ?></td>
							<td>No. Telephone</td>
							<td>:</td>
							<td><?= $pasien['telepon'] ?></td>
						</tr>
						<tr>
							<td>Tempat Lahir</td>
							<td>:</td>
							<td><?= $pasien['tempat_lahir'] ?></td>
							<td>Tanggal Lahir</td>
							<td>:</td>
							<td><?= time_format($pasien['tanggal_lahir'], 'd M Y') ?></td>
						</tr>
					</table>
				</div>

			</div>
		</div>
	</div>
</div>


<div class="row mt-2">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				Riwayat
			</div>
			<div class="card-body load-data pt-0">
				<?= $this->include('rekam_medis/content') ?>
			</div>
		</div>
	</div>
</div>

<?= $this->endSection(); ?>