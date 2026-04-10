<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
	}

	public function index($offset = 0)
	{


		$this->load->library('pagination');
		$limit = 10;

		$total_rows = $this->db->count_all('employes');

		$config['base_url'] = site_url('welcome/index');
		$config['total_rows'] = $total_rows;
		$config['per_page'] = $limit;
		$config['uri_segment'] = 3;

		$config['full_tag_open'] = '<nav><ul class="pagination pagination-sm justify-content-center">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] = '</span></li>';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['attributes'] = array('class' => 'page-link');

		$this->pagination->initialize($config);

		$this->db->limit($limit, $offset);
		$data['users'] = $this->db->get('employes')->result_array();

		$data['title'] = 'Pegawai';
		$data['konten'] = 'pegawai/main';
		$data['pagination_links'] = $this->pagination->create_links();
		$data['start_no'] = $offset;

		$this->load->view('layout/template', $data);
	}
}
