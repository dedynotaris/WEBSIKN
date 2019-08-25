<?php
class user3 extends CI_Controller{
    
public function __construct() {
parent::__construct();
$this->load->helper('download');
$this->load->library('session');
$this->load->model('M_user3');
$this->load->library('Datatables');
$this->load->library('form_validation');
$this->load->library('upload');

if($this->session->userdata('sublevel')  != 'Level 3' ){
redirect(base_url('Menu'));
}
}

public function index(){
$data_tugas = $this->M_user3->data_tugas('Masuk');

$this->load->view('umum/V_header');
$this->load->view('user3/V_user3',['data_tugas'=>$data_tugas]);
}
 
public function keluar(){
$this->session->sess_destroy();
redirect (base_url('Login'));
}


public function proses_tugas(){
if($this->input->post()){

 $data = array(
'target_selesai_perizinan' =>$this->input->post('target_kelar'),
'status_berkas'                 =>'Proses'    
);
$this->db->update('data_berkas_perizinan',$data,array('no_berkas_perizinan'=>$this->input->post('no_berkas_perizinan')));

$status = array(
'status' =>"success",
'pesan'  =>"Dokumen masuk kedalam proses perizinan"    
);
echo json_encode($status);

}else{
redirect(404);    
}

}
public function selesaikan_tugas(){
if($this->input->post()){

 $data = array(
'tanggal_selesai'               => date('Y/m/d'),     
'status_berkas'                 =>'Selesai'    
);
$this->db->update('data_berkas_perizinan',$data,array('no_berkas_perizinan'=>$this->input->post('no_berkas_perizinan')));

$status = array(
'status' =>"success",
);
echo json_encode($status);

}else{
redirect(404);    
}

}
public function halaman_proses(){
$data_tugas = $this->M_user3->data_tugas('Proses');    
$this->load->view('umum/V_header');
$this->load->view('user3/V_halaman_proses',['data_tugas'=>$data_tugas]);
}



public function halaman_selesai(){ 
$this->load->view('umum/V_header');
$this->load->view('user3/V_halaman_selesai');  
}

public function json_data_perizinan_selesai(){
echo $this->M_user3->json_data_perizinan_selesai();       
}



public function lihat_persyaratan(){
if($this->input->post()){
$input = $this->input->post();

$data = $this->M_user3->data_persyaratan($input['no_pemilik']);

echo "<table class='table text-center table-sm table-bordered table-striped'>"
. "<thead>"
        . "<tr>"
        . "<th>Dokumen penunjang yang diberikan client</th>"
        . "<th>Aksi</th>"
        . "<tr>"
        . "</thead>";
foreach ($data->result_array() as $d){
echo "<tr>"
    . "<td>".$d['nama_dokumen']."</td>"
    . "<td><button onclick=lihat_data_perekaman('".$d['no_nama_dokumen']."','".$d['no_pekerjaan']."','".$d['no_client']."'); class='btn btn-dark btn-sm'>Lihat data <span class='fa fa-eye'></span></button></td>"
    . "</tr>";  
}

echo"</table>";


}else{
redirect(404);    
}
}



public function form_persyaratan(){
if($this->input->post()){
$input = $this->input->post();
$query = $this->M_user3->data_meta($input['no_nama_dokumen']);

echo "<div class='row'>";
echo "<div class='col'>";
echo "<input type='hidden' class='form-control no_nama_dokumen'  value='".$input['no_nama_dokumen']."' >";
echo "<input type='hidden' class='form-control no_pekerjaan' value='".$input['no_pekerjaan']."'>";
echo "<input type='hidden' class='form-control no_client' value='".$input['no_client']."'>";

$i = 1;
foreach ($query->result_array() as $d){
    
echo "<label>".$d['nama_meta']."</label>"
    ."<input    ";
    if($d['jenis_inputan'] == 'Numeric'){
      echo "type='number' maxlength='".$d['maksimal_karakter']."'  class='form-control quantity meta required' required='' accept='text/plain'";  
    }else{
      echo "maxlength='".$d['maksimal_karakter']."' type='text'  class='form-control meta required' required='' accept='text/plain'";  
    }echo "id='data_meta".$i++."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."' >";    
}

echo "<label>Lampiran</label>"
. "<input type='file' id='file_berkas' class='form-control'>";
echo "</div>";
echo "</div>";
}
}

public function simpan_persyaratan(){
if($this->input->post()){
$input = $this->input->post();
$total_berkas = $this->M_user3->total_berkas()->row_array();

$no_berkas = date('Ymd').str_pad($total_berkas['id_data_berkas'],6,"0",STR_PAD_LEFT);

$static = $this->M_user3->data_pekerjaan($input['no_pekerjaan'])->row_array();


if(!empty($_FILES['file_berkas'])){
$config['upload_path']          = './berkas/'.$static['nama_folder'];
$config['allowed_types']        = 'gif|jpg|png|pdf|docx|doc|xlxs|';
$config['encrypt_name']         = TRUE;
$this->upload->initialize($config);    

if (!$this->upload->do_upload('file_berkas')){  
$status = array(
"status"     => "error",
"pesan"      => $this->upload->display_errors()    
);
}else{
$lampiran = $this->upload->data('file_name');    
}   
}else{
$lampiran = NULL;        
}

$data_berkas = array(
'no_berkas'         => $no_berkas,    
'no_client'         => $input['no_client'],    
'no_pekerjaan'      => $input['no_pekerjaan'],
'no_nama_dokumen'   => $input['no_nama_dokumen'],
'nama_berkas'       => $lampiran,
'Pengupload'        => $this->session->userdata('nama_lengkap'),
'tanggal_upload'    => date('Y/m/d' ),  
);    

$this->db->insert('data_berkas',$data_berkas);
    
$data_meta = json_decode($input['data_meta']);
foreach ($data_meta as $key=>$value){
$meta = array(
'no_pekerjaan'      => $input['no_pekerjaan'],
'no_nama_dokumen'   => $input['no_nama_dokumen'],
'no_berkas'         => $no_berkas,    
'nama_meta'         => $key,
'value_meta'        => $value,    
);
$this->db->insert('data_meta_berkas',$meta);

}
$status = array(
"status"     => "success",
"pesan"      => "Persyaratan berhasil ditambahkan"    
);

echo json_encode($status);


}else{
redirect(404);    
}
    
}

public function simpan_laporan(){
if($this->input->post()){
$input = $this->input->post();
$data = array(
'no_berkas_perizinan'    => $input['no_berkas_perizinan'],
'laporan'                => $input['laporan'],
'waktu'                  => date('Y/m/d')    
);
$this->db->insert('data_progress_perizinan',$data);

$status = array(
"status"=>"success",
"pesan" =>"laporan berhasil tersimpan",
);
echo json_encode($status);
   
}else{
redirect(404);    
}    
}
public function download_berkas_informasi(){
$data = $this->db->get_where('data_informasi_pekerjaan',array('id_data_informasi_pekerjaan'=>$this->uri->segment(3)))->row_array();    
$file_path = "./berkas/".$data['nama_folder']."/".$data['lampiran']; 
$info = new SplFileInfo($data['lampiran']);
force_download($data['nama_informasi'].".".$info->getExtension(), file_get_contents($file_path));
}
public function cari_file(){
if($this->input->post()){
$kata_kunci = $this->input->post('kata_kunci');


$data_dokumen           = $this->M_user3->pencarian_data_dokumen($kata_kunci);

$data_dokumen_utama     = $this->M_user3->pencarian_data_dokumen_utama($kata_kunci);

$data_client            = $this->M_user3->pencarian_data_client($kata_kunci);

$this->load->view('umum/V_header');
$this->load->view('user3/V_pencarian',['data_dokumen'=>$data_dokumen,'data_dokumen_utama'=>$data_dokumen_utama,'data_client'=>$data_client]);

}else{
redirect(404);    
}    
}

public function tolak_tugas(){
if($this->input->post()){
$input = $this->input->post();    
$data = array(
'no_berkas_perizinan'       => $input['no_berkas_perizinan'],
'laporan'                   => $this->session->userdata('nama_lengkap')." Menolak Tugas ".$input['nama_tugas']." dengan alasan ".$input['alasan_penolakan'],
'waktu'                     => date('Y/m/d')    
);
$this->db->insert('data_progress_perizinan',$data);

$update = array(
'status_berkas' => 'Ditolak',    
);
$this->db->update('data_berkas_perizinan',$update,array('no_berkas_perizinan'=>$input['no_berkas_perizinan']));


$status = array(
"status"=>"success",
"pesan" =>"Penolakan tugas berhasil",
);
echo json_encode($status);
  
}else{
redirect(404);    
}
    
}
public function profil(){
$no_user = $this->session->userdata('no_user');
$data_user = $this->M_user3->data_user_where($no_user);
$this->load->view('umum/V_header');
$this->load->view('user3/V_profil',['data_user'=>$data_user]);

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
$this->load->view('user3/V_riwayat_pekerjaan');
}

public function json_data_riwayat(){
echo $this->M_user3->json_data_riwayat();       
}

public function histori($keterangan){
$data = array(
'no_user'   => $this->session->userdata('no_user'),
'keterangan'=>$keterangan,
'tanggal'   =>date('Y/m/d H:i:s'),
);

$this->db->insert('data_histori_pekerjaan',$data);
}

public function data_pekerjaan_baru(){
$this->db->select('nama_dokumen.nama_dokumen,'
        . 'data_berkas_perizinan.id_perizinan');
$this->db->from('data_berkas_perizinan');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas_perizinan.no_nama_dokumen');
$this->db->where('data_berkas_perizinan.no_user_perizinan',$this->session->userdata('no_user'));
$this->db->where('data_berkas_perizinan.status_lihat',NULL);
$query = $this->db->get();

echo json_encode($query->result());
    
}
public function dilihat(){
if($this->input->post()){
$input = $this->input->post();
    
$data = array(
'status_lihat'=>'Dilihat'
);

$this->db->update('data_berkas_perizinan',$data,array('id_perizinan'=>$input['id_perizinan']));

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
$query     = $this->M_user3->data_perekaman($input['no_nama_dokumen'],$input['no_client']);
$query2     = $this->M_user3->data_perekaman2($input['no_nama_dokumen'],$input['no_client']);

echo "<table class='table table-sm table-striped table-bordered'>";
echo "<thead>
    <tr>";
foreach ($query->result_array() as $d){
echo "<th>".$d['nama_meta']."</th>";
}
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
echo '<td class="text-center">'
.'<button class="btn btn-success btn-sm" onclick=cek_download("'.base64_encode($d['no_berkas']).'")><span class="fa fa-download"></span></button>
</td>';
echo "</tr>";
    
    
}
echo "</tbody>";


echo"</table>";   
}else{
redirect(404);    
}    
}


public function hapus_berkas_persyaratan(){
if($this->input->post()){
$input = $this->input->post();    

$data = $this->M_user3->hapus_berkas($input['id_data_berkas'])->row_array();

$filename = './berkas/'.$data['nama_folder']."/".$data['nama_berkas'];

if(!file_exists($filename)){
unlink($filename);
}

$this->db->delete('data_berkas',array('id_data_berkas'=>$this->input->post('id_data_berkas')));    

$status = array(
"status"     => "success",
"pesan"      => "Data persyaratan dihapus",    
);

echo json_encode($status);

$keterangan = $this->session->userdata('nama_lengkap')." Menghapus File Persyaratan ".$data['nama_dokumen'];  
$this->histori($keterangan);

}else{
redirect(404);    
} 


}
public function data_pencarian(){
if($this->input->post()){
$input = $this->input->post();
$data_dokumen         = $this->M_user3->pencarian_data_dokumen($input['kata_kunci']);
$data_client          = $this->M_user3->pencarian_data_client($input['kata_kunci']);
$dokumen_utama        = $this->M_user3->pencarian_data_dokumen_utama($input['kata_kunci']);

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


public function cek_download_berkas(){
if($this->input->post()){
$input =  $this->input->post();    
$this->db->select('data_berkas.nama_berkas,'
        . 'data_client.nama_folder');    
$this->db->from('data_berkas');
$this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
$this->db->where('data_berkas.no_berkas', base64_decode($input['no_berkas']));
$query= $this->db->get()->row_array();    

if($query['nama_berkas'] == NULL){
$status = array(
"status"     => "warning",
"pesan"      => "Lampiran file tidak dimasukan hanya meta data"    
);    
}else if(!file_exists('./berkas/'.$query['nama_folder']."/".$query['nama_berkas'])){
$status = array(
"status"     => "error",
"pesan"      => "File tidak tersedia"    
);      
}else{
$status = array(
"status"     => "success",
);      
}

echo json_encode($status);
}else{
redirect(404);    
}

}


public function data_perekaman_pencarian(){
if($this->input->post()){
$input = $this->input->post();
$query     = $this->M_user3->data_perekaman(base64_decode($input['no_nama_dokumen']),base64_decode($input['no_client']));
$query2     = $this->M_user3->data_perekaman2(base64_decode($input['no_nama_dokumen']),base64_decode($input['no_client']));

echo "<table class='table table-sm table-striped table-bordered'>";
echo "<thead>
    <tr>";
foreach ($query->result_array() as $d){
echo "<th>".$d['nama_meta']."</th>";
}
echo "</tr>"

. "</thead>";

echo "<tbody>";
foreach ($query2->result_array() as $d){
$b = $this->db->get_where('data_meta_berkas',array('no_berkas'=>$d['no_berkas']));
echo "<tr>";

foreach ($b->result_array() as $i){
echo "<td>".$i['value_meta']."</td>";    
}

        echo '</td>';
echo "</tr>";
    
    
}
echo "</tbody>";


echo"</table>";   
}else{
redirect(404);    
}
}

public function data_perekaman_user_client(){
if($this->input->post()){
$input = $this->input->post();    

$data_berkas  = $this->M_user3->data_telah_dilampirkan(base64_decode($input['no_client']));
foreach ($data_berkas->result_array() as $u){  
echo'<div class=" m-1">
<div class="row">
<div class="col ">'.$u['nama_dokumen'].'</div> 
<div class="col-md-4  text-right">
<button type="button" onclick=lihat_meta_berkas("'.base64_encode($u['no_nama_dokumen']).'","'.$input['no_client'].'") class="btn btn-sm btn-outline-dark btn-block">Lihat data <span class="fa fa-eye"></span></button>';
echo "</div>    
</div>
</div>";
}


}
else{
redirect(404);    
}
}
public function download_berkas(){
$data = $this->M_user3->data_berkas_where($this->uri->segment(3))->row_array();

$file_path = "./berkas/".$data['nama_folder']."/".$data['nama_berkas']; 
$info = new SplFileInfo($data['nama_berkas']);
force_download($data['nama_dokumen'].".".$info->getExtension(), file_get_contents($file_path));
}


public function download_utama($id_data_dokumen_utama){

$this->db->select('data_dokumen_utama.nama_file,'
        . 'data_client.nama_folder,'
        . 'data_dokumen_utama.nama_berkas');    
$this->db->from('data_dokumen_utama');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_dokumen_utama.no_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->where('id_data_dokumen_utama',base64_decode($id_data_dokumen_utama));
$data= $this->db->get()->row_array();    


$file_path = "./berkas/".$data['nama_folder']."/".$data['nama_file']; 
$info = new SplFileInfo($data['nama_file']);
force_download($data['nama_berkas'].".".$info->getExtension(), file_get_contents($file_path));
}

}