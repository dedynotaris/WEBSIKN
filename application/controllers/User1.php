<?php
class User1 extends CI_Controller{
public function __construct() {
parent::__construct();
$this->load->helper('download');
$this->load->library('session');
$this->load->model('M_user1');
$this->load->library('Datatables');
$this->load->library('form_validation');
$this->load->library('upload');

if($this->session->userdata('sublevel')  != 'Level 1' ){
redirect(base_url('Menu'));
}

}

public function index(){
$data_tugas = $this->M_user1->data_tugas('Masuk');    
$this->load->view('umum/V_header');
$this->load->view('user1/V_user1',['data_tugas'=>$data_tugas]); 
}

public function download_berkas(){
$data = $this->db->get_where('data_berkas',array('id_data_berkas'=>$this->uri->segment(3)))->row_array();    
$file_path = "./berkas/".$data['nama_folder']."/".$data['nama_berkas']; 
$info = new SplFileInfo($data['nama_berkas']);
force_download($data['nama_file'].".".$info->getExtension(), file_get_contents($file_path));
}

public function download_berkas_informasi(){
$data = $this->db->get_where('data_informasi_pekerjaan',array('id_data_informasi_pekerjaan'=>$this->uri->segment(3)))->row_array();    
$file_path = "./berkas/".$data['nama_folder']."/".$data['lampiran']; 
$info = new SplFileInfo($data['lampiran']);
force_download($data['nama_informasi'].".".$info->getExtension(), file_get_contents($file_path));
}

public function download_utama(){
$data = $this->db->get_where('data_dokumen_utama',array('id_data_dokumen_utama'=>$this->uri->segment(3)))->row_array();    
$file_path = "./berkas/".$data['nama_folder']."/".$data['nama_file']; 
$info = new SplFileInfo($data['nama_file']);
force_download($data['nama_berkas'].".".$info->getExtension(), file_get_contents($file_path));
}
public function keluar(){
$this->session->sess_destroy();
redirect (base_url('Login'));
}


public function proses_tugas(){
if($this->input->post()){
$data = array(
'tanggal_proses_tugas'  =>date('d/m/Y H:i:s'),
'target_kelar_perizinan' =>$this->input->post('target_kelar'),
'status_berkas'        =>'Proses'    
);
$this->db->update('data_syarat_jenis_dokumen',$data,array('id_syarat_dokumen'=>$this->input->post('id_syarat_dokumen')));

$status = array(
'status' =>"success",
'pesan'  =>"Dokumen masuk kedalam proses perizinan"    
);
echo json_encode($status);

}else{
redirect(404);    
}

}
public function halaman_proses(){
$data_tugas = $this->M_user1->data_tugas('Proses');    
$this->load->view('umum/V_header');
$this->load->view('user1/V_halaman_proses',['data_tugas'=>$data_tugas]);
}

public function halaman_selesai(){
$data_tugas = $this->M_user1->data_tugas('Selesai');    
    
$this->load->view('umum/V_header');
$this->load->view('user1/V_halaman_selesai',['data_tugas'=>$data_tugas]);
    
}
public function json_data_pekerjaan_selesai(){
echo $this->M_user1->json_data_pekerjaan_selesai();       
}

public function tampilkan_modal(){
if($this->input->post()){
    
$input = $this->input->post();

if($input['jenis_modal'] == 'tolak'){
echo "tolak";        
}else if($input['jenis_modal'] == 'alihkan'){
echo "alihkan";    
}
    
}else{
redirect(404);    
}
}

public function lihat_karyawan(){
$karyawan = $this->M_user1->data_user();               
$this->load->view('umum/V_header');
$this->load->view('user1/V_lihat_karyawan',['karyawan'=>$karyawan]);    
}


public function lihat_pekerjaan(){
$no_user = base64_decode($this->uri->segment(3));
$proses  = base64_decode($this->uri->segment(4));
$level  = base64_decode($this->uri->segment(5));

if($no_user && $proses){
$karyawan = $this->db->get_where('user',array('no_user'=>$no_user));    
$sublevel = $karyawan->row_array();
$this->load->view('umum/V_header');
if($level == 'Level 2'){
$data_level2 = $this->M_user1->data_level2($proses,$no_user);
$data_user   = $this->M_user1->user_level2();   
$this->load->view('user1/V_lihat_pekerjaan_level2',['data'=>$data_level2,'data_user'=>$data_user]);
}else{    
$data_level2   = $this->M_user1->data_level3($proses,$no_user);   
$this->load->view('user1/V_lihat_pekerjaan_level3',['data'=>$data_level2]);    
}

}else{
redirect(404);    
}
}
public function berkas_dikerjakan(){
$no_pekerjaan               = base64_decode($this->uri->segment(3));
$data_berkas                = $this->M_user1->data_berkas_pekerjaan($no_pekerjaan);
$data_utama                 = $this->M_user1->data_berkas_utama($no_pekerjaan);

$this->load->view('umum/V_header');
$this->load->view('user1/V_lihat_berkas_dikerjakan',['data_utama'=>$data_utama,'data_berkas'=>$data_berkas]);        


}

public function lihat_laporan_pekerjaan(){
if($this->input->post()){
$input = $this->input->post();

$data = $this->db->get_where('data_progress_pekerjaan',array('no_pekerjaan'=> base64_decode($input['no_pekerjaan'])));
echo "<table class='table table-striped table-bordered text-center table-hover table-sm'>"
. "<tr>"
. "<th>Tanggal </th>"
. "<th>laporan</th>"
. "</tr>";
foreach ($data->result_array() as $d){
echo "<tr>"
    . "<td>".$d['waktu']."</td>"
    . "<td>".$d['laporan_pekerjaan']."</td>"
    . "</tr>";    
}
echo "</table>";    
}else{
redirect(404);    
}    
}
public function cari_file(){
if($this->input->post()){
$input = $this->input->post();
$dalam_bentuk_lampiran  = $this->M_user1->cari_lampiran($input);
$dalam_bentuk_informasi = $this->M_user1->cari_informasi($input);

$this->load->view('umum/V_header');
$this->load->view('user1/V_pencarian',['dalam_bentuk_lampiran'=>$dalam_bentuk_lampiran,'dalam_bentuk_informasi'=>$dalam_bentuk_informasi]);

}else{
redirect(404);    
}    
}
public function lihat_informasi(){
if($this->input->post()){
$input = $this->input->post();    
$query = $this->db->get_where('data_informasi_pekerjaan',array('id_data_informasi_pekerjaan'=>$input['id_data_informasi_pekerjaan']))->row_array();

echo $query['data_informasi'];


}else{
redirect(404);    
}
}

public function alihkan_pekerjaan(){
if($this->input->post()){
$input = $this->input->post();    
$data = array(
'no_user'           =>$input['no_user'],
'pembuat_pekerjaan' =>$input['pembuat_pekerjaan'],   
);
$this->db->update('data_pekerjaan',$data,array('no_pekerjaan'=> base64_decode($input['no_pekerjaan'])));

$status = array(
'status' =>"success",
'pesan'  =>"Pengalihan tugaske ".$input['pembuat_pekerjaan']." Berhasil"    
);
echo json_encode($status);

}else{
redirect(404);    
}
    
}
public function profil(){
$no_user = $this->session->userdata('no_user');
$data_user = $this->M_user1->data_user_where($no_user);
$this->load->view('umum/V_header');
$this->load->view('user1/V_profil',['data_user'=>$data_user]);

}

public function simpan_profile(){
$foto_lama = $this->db->get_where('user',array('no_user'=>$this->session->userdata('no_user')))->row_array();
if(!file_exists('./uploads/user/'.$foto_lama['foto'])){
    
}else{
if($foto_lama['foto'] != NULL){
unlink('./uploads/user/'.$foto_lama['foto']);    
}   
}

$img =  $this->input->post();
define('UPLOAD_DIR', './uploads/user/');
$image_parts = explode(";base64,", $img['image']);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];
$image_base64 = base64_decode($image_parts[1]);
$file_name = uniqid() . '.png';
$file = UPLOAD_DIR .$file_name;
file_put_contents($file, $image_base64);
$data = array(
'foto' =>$file_name,    
);
$this->db->update('user',$data,array('no_user'=>$this->session->userdata('no_user')));
 
$status = array(
"status"     => "success",
"pesan"      => "Foto profil berhasil diperbaharui"    
);
echo json_encode($status);

}


public function update_user(){
if($this->input->post()){
$input= $this->input->post();

$data =array(
'email'         =>$input['email'],
'username'      =>$input['username'],
'nama_lengkap'  =>$input['nama_lengkap'],
'phone'         =>$input['phone']    
);
$this->db->where('no_user',$input['id_user']);
$this->db->update('user',$data);


$status = array(
"status"     => "success",
"pesan"      => "Data profil berhasil diperbaharui"    
);
echo json_encode($status);

}else{
redirect(404);    
}

}
public function update_password(){
if($this->input->post()){
$data = array(
'password' => md5($this->input->post('password'))
);
$this->db->update('user',$data,array('no_user'=>$this->input->post('no_user')));
 
$status = array(
"status"     => "success",
"pesan"      => "Password diperbaharui"    
);
echo json_encode($status);

}else{
redirect(404);    
}    
}
public function riwayat_pekerjaan(){
$this->load->view('umum/V_header');
$this->load->view('user1/V_riwayat_pekerjaan');
}

public function json_data_riwayat(){
echo $this->M_user1->json_data_riwayat();       
}


public function lihat_laporan(){
if($this->input->post()){
$input = $this->input->post();

$data = $this->db->get_where('data_progress_perizinan',array('no_berkas_perizinan'=>$input['no_berkas_perizinan']));
if($data->num_rows() == 0){
echo "<h5 class='text-center'>Belum ada laporan yang dimasukan<br>"
    . "<span class='fa fa-list-alt fa-3x'></span></h5>";
    
}else{echo "<table class='table table-bordered table-striped table-hover table-sm'>"
. "<tr>"
. "<th>Tanggal </th>"
. "<th>laporan</th>"
. "</tr>";
foreach ($data->result_array() as $d){
echo "<tr>"
    . "<td>".$d['waktu']."</td>"
    . "<td>".$d['laporan']."</td>"
    . "</tr>";    
}
echo "</table>";    

}
}else{
redirect(404);    
}    
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
public function data_perekaman(){
if($this->input->post()){
$input = $this->input->post();
$query     = $this->M_user1->data_perekaman($input['no_nama_dokumen'],$input['no_pekerjaan']);
$query2     = $this->M_user1->data_perekaman2($input['no_nama_dokumen'],$input['no_pekerjaan']);

echo "<table class='table table-sm table-striped table-bordered'>";
echo "<thead>
    <tr>";
foreach ($query->result_array() as $d){
echo "<th>".$d['nama_meta']."</th>";
}
echo "<th>Pengupload</th>";
echo "<th>Aksi</th>";
echo "</tr>"

. "</thead>";

echo "<tbody>";
foreach ($query2->result_array() as $d){
$b = $this->db->get_where('data_meta_berkas',array('no_berkas'=>$d['no_berkas']));
echo "<tr>";

foreach ($b->result_array() as $i){
echo "<td>".$i['value_meta']."</td>";    
}
echo '<td class="text-center">'.$d['pengupload'].'</td>';

echo '<td class="text-center">'
.'<button class="btn btn-success btn-sm" onclick="cek_download('. $d['id_data_berkas'].')"><span class="fa fa-download"></span></button>
</td>';
echo "</tr>";
    
    
}
echo "</tbody>";


echo"</table>";   
}else{
redirect(404);    
}    
}

}

