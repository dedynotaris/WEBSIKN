<?php 
class DataArsip extends CI_Controller{
public function __construct() {
parent::__construct();
$this->load->helper('download');
$this->load->library('session');
$this->load->model('M_data_arsip');
$this->load->library('Datatables');
$this->load->library('upload');
$this->load->library('form_validation');
if(!$this->session->userdata('username')){
redirect(base_url('Menu'));
}
}

public function index(){
$this->load->view('umum/V_header');
$this->load->view('DataArsip/Search');
}


public function cari_dokumen(){
if($this->input->get()){
$input = $this->input->get();
if(strlen($input['term']) > 0){
$data_dokumen         = $this->M_data_arsip->pencarian_data_dokumen($input['term']);

if($data_dokumen->num_rows() == 0){
$json_data_dokumen[] = array(
"Tidak ditemukan data dokumen"    
);
    
}else{
     
foreach ($data_dokumen->result_array() as $d){
$json_data_dokumen[] = array(    
'value'               =>$input['term'],
'label'               =>$d['value_meta'],
'nama_dokumen'        =>$d['nama_dokumen'],
'nama_meta'           =>str_replace('_', ' ',$d['nama_meta']),
'value_meta'          =>str_replace('_', ' ',$d['value_meta']),
'nama_client'         =>$d['nama_client'],
);  
}
echo json_encode($json_data_dokumen);

}
}
}else{
redirect(404);    
}
}


public function check_akses(){
if($this->input->post()){

$data = $this->db->get_where('sublevel_user',array('no_user'=>$this->session->userdata('no_user'),'sublevel'=>$this->input->post('model')));

if($data->num_rows() == 1){
$status = array(
"status"=>"success",
"pesan"=>"Success Dashboard "
);
$this->session->set_userdata(array('sublevel'=>$this->input->post('model')));
}else if($this->session->userdata('level') == 'Super Admin'){

$status = array(
"status"=>"success",
"pesan"=>"Success Dashboard "
);

}else{
$status = array(
"status"=>"error",
"pesan"=>"Anda tidak memiliki akses kemenu tersebut "
);

}
echo json_encode($status);


}else{
redirect(404);	
}
}

public function Pencarian(){
$this->load->view('umum/V_header');
$this->load->view('DataArsip/HasilPencarian');
    
}

public function keluar(){
$this->session->sess_destroy();
redirect (base_url('Login'));
}

}