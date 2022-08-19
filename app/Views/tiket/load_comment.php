<?php foreach ($pesan as $row) : ?>
	<div class="row mt-3">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="blog-comments__item d-flex p-3">
						<div class="blog-comments__avatar mr-3">
							<?php if ($row['photo'] == NULL) : ?>
								<img src="<?= base_url('assets/images/no-user-image.png') ?>" class="img-responsive" width="100%">
							<?php else : ?>
								<img src="<?= base_url('uploads/photo/' . $row['photo']) ?>" class="img-responsive" width="100%">
							<?php endif; ?>
						</div>
						<div class="blog-comments__content">
							<div class="blog-comments__meta text-muted">
								<a class="text-secondary" href="#"><?= $row['nama_user'] ?></a>
								<span class="text-muted">– <?= $row['created_at'] ?></span>
							</div>
							<p class="m-0 my-1 mb-2 text-muted">
								<?= $row['pesan'] ?>
							</p>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
<?php endforeach; ?>