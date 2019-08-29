<?php 
class Dashboard extends CI_Controller{
public function __construct() {
parent::__construct();
$this->load->helper('download');
$this->load->library('session');
$this->load->model('M_dashboard');
$this->load->library('Datatables');
$this->load->library('form_validation');
$this->load->library('upload');
if($this->session->userdata('level') != 'Super Admin'){
redirect(base_url('Menu'));
}
} 


public function index(){
$this->setting();    
} 

public function hapus_persyaratan(){
if($this->input->post()){
$input = $this->input->post();
echo print_r($input);
$this->db->delete('data_persyaratan',array('id_data_persyaratan'=>$input['id_data_persyaratan']));
}else{
redirect(404);    
}    
}

public function get_persyaratan(){
if($this->input->post()){
$input = $this->input->post();
$data = $this->M_dashboard->data_persyaratan($input['no_jenis_pekerjaan']);
        
echo "<table class='table table-sm table-bordered table-striped table-hover'>"
. "<tr>"
."<th>Nama File</th>"
."<th class='text-center'>Aksi</th>"
. "</tr>";
foreach ($data->result_array() as $d){
echo  "<tr class='hapus_syarat".$d['id_data_persyaratan']."'>"
."<td >".$d['nama_dokumen']."</td>"
."<td  class='text-center'><button onclick=hapus_syarat(".$d['id_data_persyaratan']."); class='btn btn-sm btn-danger'><span class='fa fa-trash'></span></button></td>"
. "</tr>";    
}

echo "</table>";


}else{
redirect(4);    
}    
    
}

public function keluar(){
$this->session->sess_destroy();
redirect (base_url('Login'));
}

public function setting(){
if($this->session->userdata('level') == "Super Admin"){    
$user           = $this->M_dashboard->data_user();
$nama_dokumen   = $this->M_dashboard->data_nama_dokumen();
$nama_jenis     = $this->M_dashboard->data_jenis();

$this->load->view('umum/V_header');
$this->load->view('dashboard/V_setting',['user'=>$user,'nama_dokumen'=>$nama_dokumen,'nama_jenis'=>$nama_jenis]);
}else{
redirect(404);    
}

}

public function simpan_jenis_dokumen(){
if($this->input->post()){

$jumlah_jenis        = $this->M_dashboard->data_jenis()->num_rows()+1;
$no_jenis            = str_pad($jumlah_jenis,4,"0",STR_PAD_LEFT);


$data = array(
'no_jenis_pekerjaan' =>"J_".$no_jenis,
'pekerjaan'        =>$this->input->post('pekerjaan'),
'nama_jenis'       =>$this->input->post('jenis_dokumen'),
'pembuat_jenis'    => $this->session->userdata('nama_lengkap'),  
);    
$this->M_dashboard->simpan_jenis($data);

$status = array(
"status"=>"Berhasil"
);
echo json_encode($status);

}else{
redirect(404);    
}
}

public function simpan_user(){
if($this->input->post()){
$input = $this->input->post();


$jumlah_user        = $this->M_dashboard->data_user()->num_rows()+1;
$angka              = 4;
$no_user            = str_pad($jumlah_user, $angka ,"0",STR_PAD_LEFT);

$data = array(
'no_user'      => $no_user,  
'username'     => $input['username'],  
'nama_lengkap' => $input['nama_lengkap'],
'level'        => $input['level'],
'status'       => $input['status'],
'email'        => $input['email'],
'phone'        => $input['phone'],
'password'     => md5($input['password'])
);

$this->M_dashboard->simpan_user($data);

$status = array(
"status"=>"Berhasil"
);
echo json_encode($status);
}else{
redirect(404);    
}
}
public function getUser(){
if($this->input->post()){
$query = $this->M_dashboard->ambil_user($this->input->post('id_user'))->row_array();
echo json_encode($query);

}else{
redirect(404);    
}  

}

public function update_user(){
if($this->input->post()){
$input = $this->input->post();

$data = array(
'username'      => $input['username'],
'nama_lengkap'  => $input['nama_lengkap'],
'level'         => $input['level'],
'status'        => $input['status'],        
'email'         => $input['email'],        
'phone'         => $input['phone'],        
);

$this->M_dashboard->update_user($data,$this->input->post('id_user'));
$status = array(
"status"=>"Berhasil"
);
echo json_encode($status);
}else{
redirect(404);    
}
}


public function simpan_nama_dokumen(){
if($this->input->post()){

$jumlah_nama_dokumen        = $this->M_dashboard->hitung_nama_dokumen()->row_array();
$no_nama_dokumen            = str_pad($jumlah_nama_dokumen['id_nama_dokumen'],4 ,"0",STR_PAD_LEFT);

$data = array(
'no_nama_dokumen'   => "N_".$no_nama_dokumen,
'nama_dokumen'      => $this->input->post('nama_dokumen'),
'pembuat'           => $this->session->userdata('nama_lengkap'),   
);
$this->M_dashboard->simpan_nama_dokumen($data);

$status = array(
"status"=>"Berhasil"
);
echo json_encode($status);

}else{    
redirect(404);    
}    

}
public function getJenis(){
if($this->input->post()){
$data_jenis = $this->M_dashboard->getJenis($this->input->post('id_jenis_dokumen'))->row_array();

$data = array(
'id_jenis_dokumen' => $data_jenis['id_jenis_dokumen'],    
'no_jenis_dokumen' => $data_jenis['no_jenis_dokumen'],
'nama_jenis'       => $data_jenis['nama_jenis'],   
);
echo json_encode($data);

}else{
redirect(404);    
}
}
public function getSyarat(){
if($this->input->post()){
$query= $this->M_dashboard->getSyarat($this->input->post('no_jenis_dokumen'));

if($query->num_rows() > 0){

foreach ($query->result_array() as $data_jenis){
$data[] = array(
'id_syarat_dokumen' => $data_jenis['id_syarat_dokumen'],    
'no_jenis_dokumen'  => $data_jenis['no_jenis_dokumen'],
'no_nama_dokumen'   => $data_jenis['no_nama_dokumen'],
'nama_syarat'       => $data_jenis['nama_syarat'],   
'status_syarat'     => $data_jenis['status_syarat'],   
);
}
echo json_encode($data);
}else{
$status = array(
"status"=>"null"
);
echo json_encode($status);   

}
}else{
redirect(404);    
}

}
public function cari_nama_dokumen(){
$term = strtolower($this->input->get('term'));    
$query = $this->M_dashboard->cari_nama_dokumen($term);

foreach ($query as $d) {
$json[]= array(
'label'                    => $d->nama_dokumen,   
'id_nama_dokumen'          => $d->id_nama_dokumen,
'no_nama_dokumen'          => $d->no_nama_dokumen,
'nama_dokumen'             => $d->nama_dokumen,
);   
}
echo json_encode($json);
}


public function json_data_jenis_pekerjaan(){
echo $this->M_dashboard->json_data_jenis_pekerjaan();       
}
public function json_data_daftar_persyaratan(){
echo $this->M_dashboard->json_data_daftar_persyaratan();       
}

public function json_data_user(){
echo $this->M_dashboard->json_data_user();       
}
public function json_data_jenis(){
echo $this->M_dashboard->json_data_jenis();       
}

public function json_data_client(){
echo $this->M_dashboard->json_data_client();       
}
public function json_data_perorangan(){
echo $this->M_dashboard->json_data_perorangan();       
}

public function json_dokumen_proses(){
echo $this->M_dashboard->json_dokumen_proses();       
}

public function json_data_nama_dokumen(){
echo $this->M_dashboard->json_data_nama_dokumen();       
}
public function json_data_berkas(){
echo $this->M_dashboard->json_data_berkas();       
}
public function json_data_pekerjaan(){
echo $this->M_dashboard->json_data_pekerjaan();       
}

public function data_dokumen(){
$query = $this->db->get_where('nama_dokumen',array('id_nama_dokumen'=>$this->input->post('id_nama_dokumen')))->row_array();

echo '<input type="hidden" class="id_nama_dokumen_edit form-control" value="'.$query['id_nama_dokumen'].'">
<label>No Nama Dokumen</label>    
<input type="text" class="no_nama_dokumen_edit  form-control" value="'.$query['no_nama_dokumen'].'">

<label>Nama Dokumen</label>    
<input type="text" class="nama_dokumen_edit form-control" value="'.$query['nama_dokumen'].'">

<label>Jenis dokumen badan hukum</label>
<input value="Badan Hukum" name="badan_hukum" type="checkbox"'; if($query['badan_hukum'] == 'Badan Hukum' ){ echo'checked '; } echo 'class="form-check badan_hukum">

<label>Jenis dokumen perorangan</label>
<input value="Perorangan" name="perorangan" type="checkbox"'; if($query['perorangan'] == 'Perorangan'){ echo'checked '; } echo'class="form-check perorangan">
';

}

public function data_pekerjaan(){
if($this->input->post()){
$input = $this->input->post();    
$query = $this->db->get_where('data_jenis_pekerjaan',array('id_jenis_pekerjaan'=>$input['id_jenis_pekerjaan']))->row_array();

$data = array(
'no_jenis_pekerjaan' => $query['no_jenis_pekerjaan'],
'pekerjaan'          => $query['pekerjaan'],
'nama_jenis'         => $query['nama_jenis'],
);    

echo json_encode($data);
}else{
redirect(404);    
}

}
public function update_jenis_pekerjaan(){
if($this->input->post()){
$input = $this->input->post();

$data = array(
'no_jenis_pekerjaan' =>$input['no_jenis_pekerjaan'],
'pekerjaan'          =>$input['pekerjaan'],
'nama_jenis'         =>$input['nama_jenis'],
'pembuat_jenis'      => $this->session->userdata('nama_lengkap'),  
);

$this->db->update('data_jenis_pekerjaan',$data,array('id_jenis_pekerjaan'=>$input['id_jenis_pekerjaan']));

$status = array(
"status"=>"success",
"pesan"=>"Data pekerjaan berhasil diperbaharui"
);

echo json_encode($status);
    
}else{
redirect(404);    
}       
}

public function update_nama_dokumen(){
if($this->input->post()){    
$input = $this->input->post();

$data = array(
'no_nama_dokumen'   => $input['no_nama_dokumen'],
'nama_dokumen'      => $input['nama_dokumen'],
'pembuat'           => $this->session->userdata('nama_lengkap'),   
'badan_hukum'       => $input['badan_hukum'],
'perorangan'        => $input['perorangan']   
);
$this->db->update('nama_dokumen',$data,array('id_nama_dokumen'=>$input['id_nama_dokumen']));

$status = array(
"status"=>"success",
"pesan"=>"Nama dokumen berhasil diperbaharui"
);

echo json_encode($status);
    
}else{
redirect(404);    
}    
}


public function jenis_dokumen(){
$this->load->view('umum/V_header');
$this->load->view('dashboard/V_jenis_dokumen');
}

public function  data_user(){
$this->load->view('umum/V_header');
$this->load->view('dashboard/V_data_user');    
}

public function nama_dokumen(){
$this->load->view('umum/V_header');
$this->load->view('dashboard/V_nama_dokumen');

}

public function create_client(){
if($this->input->post()){
if($this->session->userdata('level') == "User"){    
$status = array(
"status"     =>"error",
"pesan"  => "Anda tidak memiliki akses untuk membuat pekerjaan" 
);
echo json_encode($status);
}else{   
$data = $this->input->post();

$h_berkas = $this->M_dashboard->hitung_berkas()->num_rows()+1;
$h_client = $this->M_dashboard->data_client()->num_rows()+1;

$no_client= str_pad($h_client,6 ,"0",STR_PAD_LEFT);
$no_berkas= str_pad($h_berkas,6 ,"0",STR_PAD_LEFT);

$id_berkas =  date("Ymd")."/".$this->session->userdata('no_user')."/".$no_berkas; 
if(file_exists("berkas/".$no_berkas)){
$status = array(
"status"     =>"Gagal",
"pesan"     =>"File direktori sudah dibuat"   
);
echo json_encode($status);    


}else{

$data_client = array(
'no_client'                 => "C_".$no_client,    
'jenis_client'              => $data['data'][0]['jenis_client'],    
'nama_client'               => $data['data'][3]['badan_hukum'],
'alamat_client'             => $data['data'][4]['alamat_badan_hukum'],    
'tanggal_daftar'            => date('Y/m/d'),    
'pembuat_client'            => $this->session->userdata('nama_lengkap'),    
'no_user'                   => $this->session->userdata('no_user'),    
);    

$this->db->insert('data_client',$data_client);


$data_r = array(
'no_client'          => "C_".$no_client,    
'id_berkas'          => $id_berkas,
'no_berkas'          => $no_berkas,    
'folder_berkas'      => "file_".$no_berkas,    
'status_berkas'      => "Proses",    
'tanggal_dibuat'     => date('Y/m/d'),
'count_up'           => date('M,d,Y,H:i:s'),        
'no_user'            => $this->session->userdata('no_user'),    
'pembuat_berkas'     => $this->session->userdata('nama_lengkap'),    
'jenis_perizinan'    => $data['data'][1]['jenis_akta'],
'id_jenis'           => $data['data'][2]['id_jenis'],
);

$this->db->insert('data_berkas',$data_r);


$data_utama = array(
'no_client'          => "C_".$no_client,    
'no_berkas'          => $no_berkas,    
'file_berkas'        => "file_".$no_berkas,    
'draft'              => NULL,
'minuta'             => NULL,
'salinan'             => NULL,
);

$this->db->insert('data_dokumen_utama',$data_utama);



}

mkdir("berkas/"."file_".$no_berkas,0755);

$status = array(
"status"     =>"Berhasil",
"no_berkas"  => base64_encode($no_berkas) 
);
echo json_encode($status);
}

}else{
redirect(404);    
}

}

public function proses_berkas(){
$data           = $this->M_dashboard->data_berkas($this->uri->segment(3));    

$this->load->view('umum/V_header');
$this->load->view('dashboard/V_proses_berkas',['data'=>$data]);
}

public function pekerjaan_proses(){
$this->load->view('umum/V_header');
$this->load->view('dashboard/V_pekerjaan_proses');
}




public function data_client(){
$this->load->view('umum/V_header');
$this->load->view('dashboard/V_data_client');

}


public function getCLient(){
if($this->input->post()){
$query = $this->M_dashboard->cari_client($this->input->post('no_client'))->row_array();

$data = array(
'no_client'         =>  $query['no_client'],
'nama_client'       =>  $query['nama_client'],
'alamat_client'     =>  $query['alamat_client'],    
);

echo json_encode($data);
}else{
redirect(404);
}    
}


public function data_perorangan(){
$this->load->view('umum/V_header');
$this->load->view('dashboard/V_data_perorangan');

}

public function simpan_persyaratan(){
if($this->input->post()){
$input = $this->input->post();

$data = array(
'no_nama_dokumen'     =>$input['no_nama_dokumen'], 
'no_jenis_pekerjaan'  =>$input['no_jenis_pekerjaan']   
);

$this->db->insert('data_persyaratan',$data);

$status = array(
"status"      =>"success",
"pesan"       =>"Persyaratan berhasil ditambahkan" 
);

echo json_encode($status);
}else{
redirect(404);    
} 
    
}


public function simpan_pekerjaan_user(){
if($this->input->post()){
$input = $this->input->post();

$data_syarat = $this->db->get_where('data_syarat_jenis_dokumen',array('id_syarat_dokumen'=>$input['id_syarat_dokumen']))->row_array();    

$data = array (
'perizinan' =>$input['nama_user'],
'no_user'   =>$input['no_user']        
);
$this->db->update('data_syarat_jenis_dokumen',$data,array('id_syarat_dokumen'=>$input['id_syarat_dokumen']));

$data2 = array(
'nama_lengkap'      => $input['nama_user'],
'no_user'           => $input['no_user'],
'no_nama_dokumen'   => $data_syarat['no_nama_dokumen'],
'no_berkas'         => $data_syarat['no_berkas'],
);
$this->db->insert('data_pengurus_perizinan',$data2);


}else{
redirect(404);    
}
}

public function simpan_meta(){
if($this->input->post()){
$input = $this->input->post();
$data = array(
'no_nama_dokumen' =>$input['no_nama_dokumen'],
'nama_meta'       =>$input['nama_meta'], 
);
$this->db->insert('data_meta',$data);    
$status = array(
"status"      =>"success",
"pesan"       =>"Meta dokumen berhasil ditambahkan" 
);
echo json_encode($status);    
}else{
redirect(404);    
}       
}

public function lihat_data_meta(){
if($this->input->post()){
$data = $this->db->get_where('data_meta',array('no_nama_dokumen'=>$this->input->post('no_nama_dokumen')));
if($data->num_rows() >0){
echo "<table class='table table-sm table-bordered table-striped table-hover'>"
        . "<tr>"
        . "<th>No</th>"
        . "<th>Nama meta</th>"
        . "<th>Jenis Inputan</th>"
        . "<th>Maksimal karakter</th>"
        . "<th>Aksi</th>"
        . "</tr>";
$h =1;
foreach ($data->result_array() as $d){
echo "<tr>"
    . "<td>".$h++."</td>"
    . "<td>".$d['nama_meta']."</td>"
    . "<td>"
    . "<select onchange=simpan_jenis_inputan('".$d['id_data_meta']."'); class='form-control jenis_inputan".$d['id_data_meta']."'>"
    . "<option>".$d['jenis_inputan']."</option>"
    . "<option>Numeric dan Text</option>"
    . "<option>Numeric</option>"
    . "</select>"
    . "</td>"
    . "<td><input  onchange=simpan_maksimal_karakter('".$d['id_data_meta']."'); type='text' value='".$d['maksimal_karakter']."' class='form-control maksimal_karakter".$d['id_data_meta']."'></td>"
    . "<td><button class='btn btn-danger btn-sm' onclick=hapus_meta('".$d['id_data_meta']."')><span class='fa fa-trash'></span></button></td>"
. "</tr>";
}
echo "</table>";
}else{
echo "<h3 align='center'>Tidak ada data meta yang bisa ditampilkan</h3>";    
}   
    
}else{
redirect(404);    
}    
}

public function hapus_data_meta(){
if($this->input->post()){
$this->db->delete('data_meta',array('id_data_meta'=>$this->input->post('id_data_meta')));    
}else{
redirect(404);    
}    
}



public function data_berkas(){
$this->load->view('umum/V_header');
$this->load->view('dashboard/V_data_berkas');
    
}


public function json_data_berkas_client($no_client){
echo $this->M_dashboard->json_data_berkas_client($no_client);       
}

public function lihat_berkas_client(){
$data_client = $this->M_dashboard->data_client_where($this->uri->segment(3));    

$this->load->view('umum/V_header');
$this->load->view('dashboard/V_lihat_berkas_client',['data_client'=>$data_client]);

}
public function download_berkas_informasi(){
$data = $this->db->get_where('data_informasi_pekerjaan',array('id_data_informasi_pekerjaan'=>$this->uri->segment(3)))->row_array();    
$file_path = "./berkas/".$data['nama_folder']."/".$data['lampiran']; 
$info = new SplFileInfo($data['lampiran']);
force_download($data['nama_informasi'].".".$info->getExtension(), file_get_contents($file_path));
}


public function profil(){
$no_user = $this->session->userdata('no_user');
$data_user = $this->M_dashboard->data_user_where($no_user);
$this->load->view('umum/V_header');
$this->load->view('dashboard/V_profil',['data_user'=>$data_user]);

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


public function update_user_profile(){
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
$this->load->view('dashboard/V_riwayat_pekerjaan');
}

public function json_data_riwayat(){
echo $this->M_dashboard->json_data_riwayat();       
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

public function simpan_sublevel(){
if($this->input->post()){
$input = $this->input->post();

$data = array(
'no_user'	=>$input['no_user'],
'sublevel'	=>$input['sublevel'],
);

$query = $this->db->get_where('sublevel_user',$data);

if($query->num_rows() == 0){
$status = array(
"status"     => "success",
"pesan"      => "Sublevel berhasil disimpan"    
);
$this->db->insert('sublevel_user',$data);

}else{

$status = array(
"status"     => "warning",
"pesan"      => "Sublevel ".$input['sublevel']." Sudah dimasukan"    
);

}

echo json_encode($status);


}else{
redirect(404);	
}

}
public function data_sublevel(){
if($this->input->post()){

$data = $this->db->get_where('sublevel_user',array('no_user'=>$this->input->post('no_user')));

echo "<table class='table table-striped table-hover table-sm'><tr>
<td>Sublevel</td>
<td class='text-center'>Aksi</td>
</tr>";
foreach ($data->result_array() as $d){

echo "<tr><td>".$d['sublevel']."</td>
<td class='text-center'><button onclick=hapus_sublevel('".$d['id_sublevel_user']."') class='btn btn-sm btn-danger'><span class='fa fa-trash'></span></button></td>
</tr>";
}
echo "</table>";


}else{
redirect(404);	
}

}

public function hapus_sublevel(){
if($this->input->post()){
$this->db->delete('sublevel_user',array('id_sublevel_user'=>$this->input->post('id_sublevel_user')));

$status = array(
"status"     => "success",
"pesan"      => "Sublevel terhapus",    
);


echo json_encode($status);



}else{
redirect(404);	
}

}

public function simpan_jenis_inputan(){
if($this->input->post()){
$inputan = array('jenis_inputan'=> $this->input->post('jenis_inputan'));

$this->db->update('data_meta',$inputan,array('id_data_meta'=>$this->input->post('id_data_meta')));
$status = array(
"status"     => "success",
"pesan"      => "Jenis Inputan Tersimpan",    
);


echo json_encode($status);


    
}else{
redirect(404);    
}    
}

public function simpan_maksimal_karakter(){
if($this->input->post()){
$inputan = array('maksimal_karakter'=> $this->input->post('maksimal_karakter'));

$this->db->update('data_meta',$inputan,array('id_data_meta'=>$this->input->post('id_data_meta')));
$status = array(
"status"     => "success",
"pesan"      => "Maskismal Inputan Tersimpan",    
);


echo json_encode($status);


    
}else{
redirect(404);    
}    
}

public function pencarian_data_client($input){
$this->db->select('data_client.nama_client,'
        . 'data_client.no_client');
$this->db->from('data_client');
$this->db->like('data_client.nama_client',$input);
$query = $this->db->get();
return $query;
}

public function pencarian_data_dokumen($input){
$this->db->select('data_meta_berkas.nama_meta,'
        . 'data_meta_berkas.value_meta,'
        . 'data_client.nama_client,'
        . 'data_client.no_client,'
        . 'nama_dokumen.nama_dokumen');
$this->db->from('data_meta_berkas');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_meta_berkas.no_pekerjaan');
$this->db->join('data_berkas', 'data_berkas.no_berkas = data_meta_berkas.no_berkas');
$this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_meta_berkas.no_nama_dokumen');
$this->db->group_by('data_meta_berkas.no_berkas');

$this->db->like('data_meta_berkas.value_meta',$input);
$this->db->or_like('data_meta_berkas.nama_meta',$input);

$query = $this->db->get();
return $query;
}

public function pencarian_data_dokumen_utama($input){
$this->db->select('data_dokumen_utama.nama_berkas,'
        . 'data_dokumen_utama.tanggal_akta,'
        . 'data_client.nama_client');
$this->db->from('data_dokumen_utama');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_dokumen_utama.no_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');

$this->db->like('data_dokumen_utama.nama_berkas',$input);

$query = $this->db->get();
return $query;
}


public function cari_file(){
$kata_kunci = $this->input->post('kata_kunci');


$data_dokumen           = $this->M_dashboard->pencarian_data_dokumen($kata_kunci);

$data_dokumen_utama     = $this->M_dashboard->pencarian_data_dokumen_utama($kata_kunci);

$data_client            = $this->M_dashboard->pencarian_data_client($kata_kunci);

$this->load->view('umum/V_header');
$this->load->view('dashboard/V_pencarian',['data_dokumen'=>$data_dokumen,'data_dokumen_utama'=>$data_dokumen_utama,'data_client'=>$data_client]);

}

public function data_pencarian(){
if($this->input->post()){
$input = $this->input->post();
$data_dokumen         = $this->M_dashboard->pencarian_data_dokumen($input['kata_kunci']);
$data_client          = $this->M_dashboard->pencarian_data_client($input['kata_kunci']);
$dokumen_utama        = $this->M_dashboard->pencarian_data_dokumen_utama($input['kata_kunci']);

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
$query     = $this->M_dashboard->data_perekaman(base64_decode($input['no_nama_dokumen']),base64_decode($input['no_client']));
$query2     = $this->M_dashboard->data_perekaman2(base64_decode($input['no_nama_dokumen']),base64_decode($input['no_client']));

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

$data_berkas  = $this->M_dashboard->data_telah_dilampirkan(base64_decode($input['no_client']));
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
$data = $this->M_dashboard->data_berkas_where($this->uri->segment(3))->row_array();

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

public function feature(){
$this->load->view('umum/V_header');
$this->load->view('dashboard/V_feature');
}
public function setting_feature(){
$cek_aplikasi = $this->db->get('status_aplikasi')->row_array();
    
    
echo '<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/js/bootstrap4-toggle.min.js"></script>  <div class="container-fluid">
';    
echo '<div class="row mt-2 text-theme">
<div class="col text-center">
                <div class="card">
                  <div class="card-header rounded ">
                      STATUS WORKFLOW </div>
                    <div class="card-body">
                    <div class="checkbox">
                        <label>
                            <input ';
                           if($cek_aplikasi['app_workflow'] == "on"){ echo 'checked';};
                           echo ' onchange=toogle("app_workflow") type="checkbox" data-toggle="toggle" data-onstyle="dark">
                        </label>
                    </div>
                 </div>
               </div>
            </div>
            <div class="col text-center">
                <div class="card">
                  <div class="card-header rounded ">
                     APP  MANAGEMENT </div>
                    <div class="card-body">
                    <div class="checkbox">
                        <label>
                            <input ';
                           if($cek_aplikasi['app_managemen'] == "on"){ echo 'checked';};
                           echo ' onchange=toogle("app_managemen") type="checkbox" data-toggle="toggle" data-onstyle="dark">
                        </label>
                    </div>
                 </div>
               </div>
            </div>
            <div class="col text-center">
                <div class="card">
                  <div class="card-header rounded ">
                      STATUS APP RECEPTIONIST </div>
                    <div class="card-body">
                    <div class="checkbox">
                        <label>
                             <input ';
                           if($cek_aplikasi['app_resepsionis'] == "on"){ echo 'checked';};
                           echo ' onchange=toogle("app_resepsionis") type="checkbox" data-toggle="toggle" data-onstyle="dark">
                       </label>
                    </div>
                 </div>
               </div>
            </div>
         <div class="col text-center">
                <div class="card">
                  <div class="card-header rounded ">
                      STATUS APP ADMIN </div>
                    <div class="card-body">
                    <div class="checkbox">
                        <label>
                              <input ';
                           if($cek_aplikasi['app_admin'] == "on"){ echo 'checked';};
                           echo ' onchange=toogle("app_admin") type="checkbox" data-toggle="toggle" data-onstyle="dark">
                      </label>
                    </div>
                 </div>
               </div>
            </div>

</div>';    
}

function on_off_feature(){
if($this->input->post()){
$input = $this->input->post();
$cek_aplikasi = $this->db->get('status_aplikasi')->row_array();

if($input['app'] == "app_managemen"){

if($cek_aplikasi['app_managemen'] == "off"){
$data = array('app_managemen'=>"on");     
$this->db->update('status_aplikasi',$data,array('app_managemen'=>"off"));    
}else{
$data = array('app_managemen'=>"off");         
$this->db->update('status_aplikasi',$data,array('app_managemen'=>"on"));   
}
    
}elseif($input['app'] == "app_admin"){

if($cek_aplikasi['app_admin'] == "off"){
$data = array('app_admin'=>"on");     
$this->db->update('status_aplikasi',$data,array('app_admin'=>"off"));    
}else{
$data = array('app_admin'=>"off");     
$this->db->update('status_aplikasi',$data,array('app_admin'=>"on"));        
}

}elseif($input['app'] == "app_workflow"){
    
if($cek_aplikasi['app_workflow'] == "off"){
$data = array('app_workflow'=>"on");     
$this->db->update('status_aplikasi',$data,array('app_workflow'=>"off"));    
}else{
$data = array('app_workflow'=>"off");     
$this->db->update('status_aplikasi',$data,array('app_workflow'=>"on"));    
}


}elseif($input['app'] == "app_resepsionis"){

if($cek_aplikasi['app_resepsionis'] == "off"){
$data = array('app_resepsionis'=>"on");        
$this->db->update('status_aplikasi',$data,array('app_resepsionis'=>"off"));
}else{
$data = array('app_resepsionis'=>"off");        
$this->db->update('status_aplikasi',$data,array('app_resepsionis'=>"on"));
}

}


    
}else{
redirect(404);    
}
}

public function hapus_nama_dokumen(){
if($this->input->post()){
$input = $this->input->post();

$this->db->delete('nama_dokumen',array('id_nama_dokumen'=>$input['id_nama_dokumen']));    
    
}else{
    redirect(404);    
}    
}

}

