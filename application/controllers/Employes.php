<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Employes extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function store()
	{
		$config['upload_path']   = FCPATH . 'assets/uploads/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size']      = 2048;
		$config['file_name']     = $this->input->post('nik');
		$config['overwrite']     = true;

		$this->load->library('upload', $config);

		$nik   = $this->input->post('nik');
		$email = $this->input->post('email');
		$phone = $this->input->post('no_hp');
		$ktp = null;

		$cek = $this->db->get_where('employes', ['nik' => $nik])->row();

		if ($cek) {
			$this->session->set_flashdata('error', 'NIK sudah terdaftar');
			redirect('/');
			return;
		}

		if (!preg_match("/^[0-9]{16}$/", $nik)) {
			$this->session->set_flashdata('error', 'NIK harus 16 digit');
			redirect('/');
			return;
		}

		if (!preg_match("/^(?:\+62|62|0)8[1-9][0-9]{6,10}$/", $phone)) {
			$this->session->set_flashdata('error', 'Nomor HP tidak valid');
			redirect('/');
			return;
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->session->set_flashdata('error', 'Email tidak valid');
			redirect('/');
			return;
		}

		$data = [
			'nik' => $nik,
			'nama' => $this->input->post('nama'),
			'alamat' => $this->input->post('alamat'),
			'tempat_lahir' => $this->input->post('tempat_lahir'),
			'tanggal_lahir' => $this->input->post('tanggal_lahir'),
			'no_hp' => $phone,
			'email' => $email
		];

		$this->db->trans_begin();
		$this->db->insert('employes', $data);
		$id = $this->db->insert_id();

		if (!empty($_FILES['ktp']['name'])) {
			if ($this->upload->do_upload('ktp')) {
				$uploadData = $this->upload->data();
				$ktp = 'uploads/' . $uploadData['file_name'];

				$this->db->where('id', $id);
				$this->db->update('employes', ['ktp' => $ktp]);
			} else {
				$this->db->trans_rollback();
				$this->session->set_flashdata('error', $this->upload->display_errors());
				redirect('/');
				return;
			}
		}
		$this->db->trans_commit();

		$this->session->set_flashdata('success', 'Data berhasil ditambahkan');
		redirect('/');
	}

	public function update()
	{
		$nik = $this->input->post('nik');
		$user = $this->db->get_where('employes', ['nik' => $nik])->row_array();

		if (!$user) {
			$this->session->set_flashdata('error', 'Data tidak ditemukan');
			redirect('/');
			return;
		}

		$email = $this->input->post('email');
		$phone = $this->input->post('no_hp');

		if (!preg_match("/^(?:\+62|62|0)8[1-9][0-9]{6,10}$/", $phone)) {
			$this->session->set_flashdata('error', 'Nomor HP tidak valid');
			redirect('/');
			return;
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->session->set_flashdata('error', 'Email tidak valid');
			redirect('/');
			return;
		}

		$config['upload_path']   = FCPATH . 'assets/uploads/';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size']      = 2048;
		$config['file_name']     = $nik;
		$config['overwrite']     = true;

		$this->load->library('upload', $config);

		$ktp = $user['ktp'];

		$this->db->trans_begin();
		if (!empty($_FILES['ktp']['name'])) {
			if ($this->upload->do_upload('ktp')) {

				if (!empty($user['ktp']) && file_exists(FCPATH . $user['ktp'])) {
					unlink(FCPATH . "assets/" . $user['ktp']);
				}

				$uploadData = $this->upload->data();
				$ktp = 'uploads/' . $uploadData['file_name'];
			} else {
				$this->db->trans_rollback();
				$this->session->set_flashdata('error', $this->upload->display_errors());
				redirect('/');
				return;
			}
		}

		$data = [
			'nama'  => $this->input->post('nama'),
			'no_hp' => $phone,
			'email' => $email,
			'alamat' => $this->input->post('alamat'),
			'tempat_lahir' => $this->input->post('tempat_lahir'),
			'tanggal_lahir' => $this->input->post('tanggal_lahir'),
			'ktp'   => $ktp
		];

		$this->db->where('nik', $nik);
		$this->db->update('employes', $data);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->session->set_flashdata('error', 'Gagal update data');
		} else {
			$this->db->trans_commit();
			$this->session->set_flashdata('success', 'Data berhasil diupdate');
		}

		redirect('/');
	}

	public function get_employe($nik)
	{
		$user = $this->db->get_where('employes', ['nik' => $nik])->row_array();

		if ($user) {
			echo json_encode($user);
		} else {
			echo json_encode([]);
		}
	}

	public function delete($nik)
	{
		$user = $this->db->get_where('employes', ['nik' => $nik])->row_array();

		if (!$user) {
			$this->session->set_flashdata('error', 'Data tidak ditemukan');
			redirect('employes');
			return;
		}

		if (!empty($user['ktp'])) {
			$file_path = FCPATH . 'assets/' . $user['ktp'];

			if (file_exists($file_path)) {
				unlink($file_path);
			}
		}

		$this->db->where('nik', $nik);
		$this->db->delete('employes');

		$this->session->set_flashdata('success', 'Data berhasil dihapus');

		redirect('/');
	}
}
