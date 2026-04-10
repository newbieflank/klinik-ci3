<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="userModalLabel">Form Pegawai</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form id="userForm" method="POST" enctype="multipart/form-data">
				<div class="modal-body">
					<div class="mb-3">
						<label>NIK</label>
						<input type="number" name="nik" id="form_nik" class="form-control" required>
					</div>
					<div class="mb-3">
						<label>Nama</label>
						<input type="text" name="nama" id="form_nama" class="form-control" required>
					</div>
					<div class="mb-3">
						<label>Alamat</label>
						<textarea name="alamat" id="form_alamat" class="form-control" required></textarea>
					</div>

					<div class="mb-3">
						<label>Tempat Lahir</label>
						<input type="text" name="tempat_lahir" id="form_tempat_lahir" class="form-control" required>
					</div>

					<div class="mb-3">
						<label>Tanggal Lahir</label>
						<input type="date" name="tanggal_lahir" id="form_tanggal_lahir" class="form-control" required>
					</div>
					<div class="mb-3">
						<label>No. HP</label>
						<input type="number" name="no_hp" id="form_no_hp" class="form-control" required>
					</div>
					<div class="mb-3">
						<label>Email</label>
						<input type="email" name="email" id="form_email" class="form-control" required>
					</div>
					<div class="mb-3">
						<label>Upload KTP</label>
						<input type="file" name="ktp" id="form_ktp" class="form-control" accept="image/*" readonly>
					</div>
					<div class="mb-3 text-center">
						<img id="preview_ktp" src="" alt="Preview KTP" style="max-width: 100%; display:none; border-radius:10px;">
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
					<button type="submit" class="btn btn-primary" id="btnSave">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	document.addEventListener("DOMContentLoaded", function() {
		window.userModal = new bootstrap.Modal(document.getElementById('userModal'));
	});

	function tambahUser() {
		document.getElementById('userForm').reset();
		document.getElementById('form_nik').readOnly = false;
		document.getElementById('userModalLabel').innerText = 'Tambah User Baru';
		document.getElementById('userForm').action = '<?= base_url("employes/store") ?>';
		document.getElementById('preview_ktp').style.display = 'none';

		userModal.show();
	}

	document.getElementById('form_ktp').addEventListener('change', function(e) {
		const file = e.target.files[0];
		if (file) {
			const reader = new FileReader();
			reader.onload = function(e) {
				const img = document.getElementById('preview_ktp');
				img.src = e.target.result;
				img.style.display = 'block';
			}
			reader.readAsDataURL(file);
		}
	});

	function editUser(nik) {
		document.getElementById('userForm').reset();
		document.getElementById('userModalLabel').innerText = 'Edit Data User';
		document.getElementById('form_nik').readOnly = true;
		document.getElementById('userForm').action = '<?= base_url("employes/update") ?>';

		fetch("<?= base_url('employes/get_employe/') ?>" + nik)
			.then(response => response.json())
			.then(data => {
				document.getElementById('form_nik').value = data.nik;
				document.getElementById('form_nama').value = data.nama;
				document.getElementById('form_no_hp').value = data.no_hp;
				document.getElementById('form_email').value = data.email;
				document.getElementById('form_alamat').value = data.alamat || '';
				document.getElementById('form_tempat_lahir').value = data.tempat_lahir || '';
				document.getElementById('form_tanggal_lahir').value = data.tanggal_lahir || '';

				if (data.ktp) {
					document.getElementById('preview_ktp').src = "<?= base_url() ?>" + "assets/" + data.ktp;
					console.log(data.ktp)
					document.getElementById('preview_ktp').style.display = 'block';
				} else {
					document.getElementById('preview_ktp').style.display = 'none';
				}

				userModal.show();
			})
			.catch(() => {
				alert('Gagal mengambil data');
			});
	}
</script>