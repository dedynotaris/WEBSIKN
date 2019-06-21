<?php 
class Data_lama extends CI_Controller{
public function __construct() {
    parent::__construct();

$this->load->helper('download');
$this->load->library('session');
$this->load->model('M_data_lama');
$this->load->library('Datatables');
$this->load->library('upload');

if(!$this->session->userdata('username')){
redirect(base_url('Menu'));
}
}

public function index(){
$this->load->view('umum/V_header');
$this->load->view('data_lama/V_data_lama');


}

public function set_toggled(){
if(!$this->session->userdata('toggled')){
$array = array(
'toggled' => 'Aktif',    
);
$this->session->set_userdata($array);    
}else{
unset($_SESSION['toggled']);   
}
echo print_r($this->session->userdata());
}
public function cari_nama_client(){
$term = strtolower($this->input->get('term'));    
$query = $this->M_data_lama->cari_nama_client($term);

foreach ($query as $d) {
$json[]= array(
'label'                    => $d->nama_client,   
'no_client'                => $d->no_client,
);   
}
echo json_encode($json);
}
public function cari_jenis_pekerjaan(){
$term = strtolower($this->input->get('term'));    
$query = $this->M_data_lama->cari_jenis_pekerjaan($term);

foreach ($query as $d) {
$json[]= array(
'label'                    => $d->nama_jenis,   
'no_jenis_pekerjaan'                => $d->no_jenis_dokumen,
);   
}
echo json_encode($json);
}

}
