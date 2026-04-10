<?php if ($this->session->flashdata('success')): ?>
	<div class="alert alert-success alert-dismissible fade show" role="alert">
		<?= $this->session->flashdata('success'); ?>
		<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
	</div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
	<div class="alert alert-danger alert-dismissible fade show" role="alert">
		<?= $this->session->flashdata('error'); ?>
		<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
	</div>
<?php endif; ?>

<div class="card shadow-sm border-dark m-3" style="background-color: #81c784;">
	<div class="card-body">
		<div class="d-flex justify-content-between align-items-center mb-3">
			<h5 class="mb-0">Data Pegawai</h5>
			<button type="button" class="btn btn-dark" onclick="tambahUser()">
				+ Tambah User
			</button>
		</div>
		<div class="table-responsive">
			<table class="table table-hover align-middle bg-white rounded shadow-sm">
				<thead class="table-dark">
					<tr>
						<th style="width: 50px;">No</th>
						<th>NIK</th>
						<th>Nama</th>
						<th>No. HP</th>
						<th class="d-none d-md-table-cell">Email</th>
						<th class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = $start_no + 1;
					foreach ($users as $user): ?>
						<tr>
							<td><?= $no++; ?></td>
							<td><?= $user['nik']; ?></td>
							<td><?= $user['nama']; ?></td>
							<td><?= $user['no_hp']; ?></td>
							<td class="d-none d-md-table-cell"><?= $user['email']; ?></td>
							<td class="text-center">
								<div class="btn-group" role="group">
									<button type="button" class="btn btn-sm btn-info text-white" onclick="detailUser('<?= $user['nik']; ?>')">Detail</button>
									<button type="button" class="btn btn-sm btn-warning" onclick="editUser('<?= $user['nik']; ?>')">Edit</button>
									<button class="btn btn-danger btn-sm" onclick="hapusUser('<?= $user['nik'] ?>')">
										Hapus
									</button>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<div class="mt-3">
			<?= $pagination_links; ?>
		</div>
	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
	function hapusUser(nik) {
		Swal.fire({
			title: 'Yakin?',
			text: "Data akan dihapus permanen!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Ya, hapus!',
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = "<?= base_url('index.php/employes/delete/') ?>" + nik;
			}
		});
	}

	setTimeout(() => {
		let alerts = document.querySelectorAll('.alert');
		alerts.forEach(alert => {
			let bsAlert = new bootstrap.Alert(alert);
			bsAlert.close();
		});
	}, 3000);
</script>

<?php $this->load->view('components/modal_detail'); ?>
<?php $this->load->view('components/modal_form'); ?>