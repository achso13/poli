<?php if (isset($result)) : ?>

	<div class="row mx-1">
		<div class="table-responsive">
			<table class="table table-bordered table-hover" width="100%" cellspacing="0" id="dataTable">
				<thead>
					<tr class="bg-light">
						<td class="text-primary text-center">No.</td>
						<td class="text-primary text-center">Tanggal Kunjungan</td>
						<td class="text-primary text-center">Diagnosa</td>
						<td class="text-primary text-center">Anamnesa</td>
						<td class="text-primary text-center">Tindakan/Terapi</td>
						<td class="text-primary text-center">Resep Yang diberikan</td>
					</tr>
				</thead>
				<tbody>
					<?php $no = 1; ?>
					<?php foreach ($result as $row) : ?>
						<tr>
							<td><?= $no ?></td>
							<td><?= time_format($row['tanggal_kunjungan'], 'd M Y') ?></td>
							<td><?= $row['diagnosa'] ?></td>
							<td><?= $row['anamnesa'] ?></td>
							<td><?= $row['tindakan'] ?></td>
							<td><?= $row['resep_dokter'] ?></td>
						</tr>
						<?php $no++; ?>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>

<?php else : ?>

	<div class="alert alert-warning alert-dismissible fade show mb-0 text-center" role="alert">Empty..</div>

<?php endif; ?>

<script text="text/javascript">
	$(document).ready(function() {
		var table = $('#dataTable').DataTable({
			"columnDefs": [{
				"searchable": false,
				"orderable": false,
				"targets": 0
			}],
		});
		table.on('order.dt search.dt', function() {
			table.column(0, {
				search: 'applied',
				order: 'applied'
			}).nodes().each(function(cell, i) {
				cell.innerHTML = i + 1;
			});
		}).draw();
	});
</script>