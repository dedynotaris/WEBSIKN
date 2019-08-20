<?php 
class Resepsionis extends CI_Controller{
public function __construct() {
    parent::__construct();

$this->load->helper('download');
$this->load->library('session');
$this->load->model('M_resepsionis');
$this->load->library('Datatables');
$this->load->library('upload');
if($this->session->userdata('sublevel') != 'Level 4'){
redirect(base_url('Menu'));
}  
}
public function riwayat_pekerjaan(){
$this->load->view('umum/V_header');
$this->load->view('resepsionis/V_riwayat_pekerjaan');
}

public function index(){
$this->buku_tamu();    
}

public function keluar(){
$this->session->sess_destroy();
redirect (base_url('Login'));
}

public function profil(){
$no_user = $this->session->userdata('no_user');
$data_user = $this->M_resepsionis->data_user_where($no_user);
$this->load->view('umum/V_header');
$this->load->view('resepsionis/V_profil',['data_user'=>$data_user]);

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

public function buku_tamu(){
$data_karyawan = $this->M_resepsionis->data_karyawan();    
$this->load->view('umum/V_header');
$this->load->view('resepsionis/V_buku_tamu',['data_karyawan'=>$data_karyawan]);
}
public function notaris_rekanan(){
$data_karyawan = $this->M_resepsionis->data_karyawan();    
$this->load->view('umum/V_header');
$this->load->view('resepsionis/V_notaris_rekanan',['data_karyawan'=>$data_karyawan]);
}

public function simpan_tamu(){
if($this->input->post()){
$input = $this->input->post();

$data = array(
'keperluan_dengan'  => $input['keperluan_dengan'],
'nomor_telepon'     => $input['nomor_telepon'],
'nama_klien'        => $input['nama_klien'],
'alasan_keperluan'  => $input['alasan_keperluan'],
'tanggal'           => date('Y/m/d H:i:s'),
'penginput'         => $this->session->userdata('nama_lengkap'),
'no_user_penginput'  => $this->session->userdata('no_user') 
);

$this->db->insert('data_buku_tamu',$data);


$status = array(
"status" => "success",
'pesan'  => 'Data Tamu berhasil disimpan'    
);

echo json_encode($status);

}else{
redirect(404);    
}    
    
}

public function simpan_notaris_rekanan(){
if($this->input->post()){
$input = $this->input->post();

$data = array(
'no_telpon'             => $input['no_telpon'],
'nama_notaris'          => $input['nama_notaris'],
'alamat'                => $input['alamat'],
'tanggal_input'         => date('Y/m/d H:i:s'),
'penginput'             => $this->session->userdata('nama_lengkap'),
'no_user_penginput'     => $this->session->userdata('no_user') 
);


$this->db->insert('data_notaris_rekanan',$data);


$status = array(
"status" => "success",
'pesan'  => 'Data Tamu berhasil disimpan'    
);

echo json_encode($status);

}else{
redirect(404);    
}    
    
}

public function json_data_tamu(){
echo $this->M_resepsionis->json_data_tamu();       
}
public function json_data_absen(){
echo $this->M_resepsionis->json_data_absen();       
}

public function json_data_notaris_rekanan(){
echo $this->M_resepsionis->json_data_notaris_rekanan();       
}

public function absen(){
$data_karyawan = $this->M_resepsionis->data_karyawan();    
$this->load->view('umum/V_header');
$this->load->view('resepsionis/V_absen',['data_karyawan'=>$data_karyawan]);
    
    
}

public function simpan_absen(){
if($this->input->post()){
$input = $this->input->post();


$data = array(
'tugas'                 => $input['tugas'],
'nama_karyawan'         => $input['nama_karyawan'],
'jam_datang'            => $input['jam_datang'],
'jam_pulang'            => $input['jam_pulang'],
'penginput'             => $this->session->userdata('nama_lengkap'),
'no_user_penginput'     => $this->session->userdata('no_user') 
);

$this->db->insert('data_buku_absen',$data);


$status = array(
"status" => "success",
'pesan'  => 'Data Absen berhasil disimpan'    
);

echo json_encode($status);

}else{
redirect(404);    
}    
    
}
public function lihat_tugas(){
if($this->input->post()){
$data  = $this->db->get_where('data_buku_absen',array('id_data_buku_absen'=>$this->input->post('id_data_buku_absen')))->row_array();

echo $data['tugas'];
}else{
redirect(404);    
}

}
public function cari_file(){
$kata_kunci = $this->input->post('kata_kunci');


$data_dokumen           = $this->M_resepsionis->pencarian_data_dokumen($kata_kunci);

$data_dokumen_utama     = $this->M_resepsionis->pencarian_data_dokumen_utama($kata_kunci);

$data_client            = $this->M_resepsionis->pencarian_data_client($kata_kunci);

$this->load->view('umum/V_header');
$this->load->view('resepsionis/V_pencarian',['data_dokumen'=>$data_dokumen,'data_dokumen_utama'=>$data_dokumen_utama,'data_client'=>$data_client]);

}
public function data_pencarian(){
if($this->input->post()){
$input = $this->input->post();
$data_dokumen         = $this->M_resepsionis->pencarian_data_dokumen($input['kata_kunci']);
$data_client          = $this->M_resepsionis->pencarian_data_client($input['kata_kunci']);
$dokumen_utama        = $this->M_resepsionis->pencarian_data_dokumen_utama($input['kata_kunci']);

if($data_dokumen->num_rows() == 0){
$json_data_dokumen[] = array(
"Tidak ditemukan data dokumen"    
);
    
}else{   
foreach ($data_dokumen->result_array()as $d){
$json_data_dokumen[] = array(    
$d['value_meta']
);
}
}

if($data_client->num_rows() == 0){
$json_data_client[] = array(
"Tidak ditemukan data client"
);    
}else{
foreach ($data_client->result_array()as $data_client){
$json_data_client[] = array(
$data_client['nama_client']    
);
}
}

if($dokumen_utama->num_rows() == 0){
$data_dokumen_utama[] = array(
"Tidak ditemukan dokumen utama"
);    
}else{
foreach ($dokumen_utama->result_array()as $dokut){
$data_dokumen_utama[] = array(
$dokut['nama_berkas']    
);
}

}

$data = array(
 'data_dokumen'         => $json_data_dokumen,
 'data_client'          => $json_data_client,  
 'data_dokumen_utama'   => $data_dokumen_utama   
);


echo json_encode($data);

}else{
redirect(404);    
}

}
    
}
