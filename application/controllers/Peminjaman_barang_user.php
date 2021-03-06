<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Peminjaman_barang_user extends CI_Controller {

  public function index(){
    
  $data['barang'] = $this->User_model->get_inventory();

  $inventori = $data['barang'];

  for($i=0; $i < count($inventori); $i++){
    $dipinjam = $this->db->where('id_inventory', $inventori[$i]['id_inventory'])->select_sum('jumlahDipinjam')->get('datapeminjaman')->result_array();

    $inventori[$i]['jumlah_inventory'] = $inventori[$i]['jumlah_inventory'] - $dipinjam[0]['jumlahDipinjam'];
  }
  $data['barang'] = $inventori;

  $query = $this->db->query('SELECT * FROM peminjaman WHERE status_permintaan <> "penyusunan"');
  $data['peminjam'] = $query->result_array();

  $data['admin'] = $this->db->get('admin')->result_array();
 
  $this->load->library('pagination');

  $config['base_url'] = base_url();
  $config['total_rows'] = 
  $config['per_page'] = 5;

  $this->pagination->initialize($config);

	$this->load->view('template_user/header');
	$this->load->view('user/daftar_peminjaman_barang',$data);
	$this->load->view('template_user/footer');
  }
}

/* End of file Peminjaman_barang_user.php */
