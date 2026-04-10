<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-white" style="background-color: #81c784;">
				<h5 class="modal-title" id="detailModalLabel"><i class="bi bi-person-lines-fill"></i> Detail Pegawai</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-4 text-center mb-3">
						<h6>KTP Pegawai</h6>
						<img id="detail_preview_ktp" src="" alt="KTP" class="img-fluid rounded shadow-sm" style="max-height: 200px; border: 1px solid #ddd;">
						<p id="no_image_text" class="text-muted mt-2" style="display:none;">Tidak ada foto KTP</p>
					</div>
					<div class="col-md-8">
						<table class="table table-striped">
							<tr>
								<th style="width: 35%;">NIK</th>
								<td id="detail_nik"></td>
							</tr>
							<tr>
								<th>Nama Lengkap</th>
								<td id="detail_nama"></td>
							</tr>
							<tr>
								<th>Email</th>
								<td id="detail_email"></td>
							</tr>
							<tr>
								<th>No. HP</th>
								<td id="detail_no_hp"></td>
							</tr>
							<tr>
								<th>Tempat, Tgl Lahir</th>
								<td id="detail_ttl"></td>
							</tr>
							<tr>
								<th>Alamat</th>
								<td id="detail_alamat"></td>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

<script>
	document.addEventListener("DOMContentLoaded", function() {
		window.detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
	});

	function detailUser(nik) {
		fetch("<?= base_url('employes/get_employe/') ?>" + nik)
			.then(response => response.json())
			.then(data => {
				document.getElementById('detail_nik').innerText = data.nik;
				document.getElementById('detail_nama').innerText = data.nama;
				document.getElementById('detail_email').innerText = data.email;
				document.getElementById('detail_no_hp').innerText = data.no_hp;
				document.getElementById('detail_alamat').innerText = data.alamat || '-';

				const ttl = (data.tempat_lahir || '-') + ', ' + (data.tanggal_lahir || '-');
				document.getElementById('detail_ttl').innerText = ttl;

				const img = document.getElementById('detail_preview_ktp');
				const noText = document.getElementById('no_image_text');

				if (data.ktp) {
					img.src = "<?= base_url() ?>" + "assets/" + data.ktp;
					img.style.display = 'inline-block';
					noText.style.display = 'none';
				} else {
					img.style.display = 'none';
					noText.style.display = 'block';
				}

				detailModal.show();
			})
			.catch(() => alert('Gagal memuat detail pegawai'));
	}
</script>