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

public function UbahMimeUtama(){
$this->db->select('data_client.nama_folder,'
        . 'data_dokumen_utama.nama_file,'
        . 'data_dokumen_utama.id_data_dokumen_utama');
$this->db->from('data_dokumen_utama');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_dokumen_utama.no_pekerjaan');
$this->db->join('data_client','data_client.no_client = data_pekerjaan.no_client');
$dokumen_utama = $this->db->get();
foreach ($dokumen_utama->result_array() as $c){
$url = './berkas/'.$c['nama_folder']."/".$c['nama_file'];
if(file_exists($url)){
$data = array(
'mime-type' =>mime_content_type($url)    
);
$this->db->update('data_dokumen_utama',$data,array('id_data_dokumen_utama'=>$c['id_data_dokumen_utama']));
}
echo "selesai";    
}
}

public function UbahMimePenunjang(){
$this->db->select('data_client.nama_folder,'
                  .'data_berkas.nama_berkas,'
                  .'data_berkas.no_berkas');
$this->db->from('data_berkas');
$this->db->join('data_client','data_client.no_client = data_berkas.no_client');
$dokumen_utama = $this->db->get();
foreach ($dokumen_utama->result_array() as $c){
$url = './berkas/'.$c['nama_folder']."/".$c['nama_berkas'];
if(file_exists($url)){
$data = array(
'mime-type' =>mime_content_type($url)    
);
$this->db->update('data_berkas',$data,array('no_berkas'=>$c['no_berkas']));
}
echo "selesai";    
}

}

}

