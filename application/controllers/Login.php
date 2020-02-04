<?php
class Login extends CI_Controller{

public function __construct() {
parent::__construct();
$this->load->library('Session');      
$this->load->model('M_proses_login');
$this->load->library('form_validation');


if($this->session->userdata('username')){
redirect(base_url('DataArsip'));
}


}

public function index(){   
$this->load->view('umum/V_header');    
$this->load->view('V_login');
}

public function proses_login(){
if($this->input->post()){
$this->form_validation->set_rules('username', 'Username', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('password', 'Password', 'required',array('required' => 'Data ini tidak boleh kosong'));

if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);
echo json_encode($status);
}else{
 
$input = $this->input->post();
$query = $this->M_proses_login->proses_login($input['username'],$input['password']);
$data_sesi = $query->row_array();
if($query->num_rows() > 0){
$set_sesi = array(
'no_user'       => $data_sesi['no_user'],
'username'      => $data_sesi['username'],
'nama_lengkap'  => $data_sesi['nama_lengkap'],
'level'         => $data_sesi['level'],
'status'        => $data_sesi['status'],
'foto'          => $data_sesi['foto'],
'email'         => $data_sesi['email'],
);
$this->session->set_userdata($set_sesi);

$status[] = array(
"status"     => "success",       
"messages"   => "Selamat anda berhasil masuk",
"level"      => $data_sesi['level'],    
);
echo json_encode($status);
}else{
$status[] = array(
"status"=>"error_validasi",
"messages" =>[array("username"=>"Username yang anda masukan salah","password"=>"Password yang anda masukan salah")]
);
echo json_encode($status);

}
}
}else{
redirect(404);	
}
}

public function berkas(){
}

}

