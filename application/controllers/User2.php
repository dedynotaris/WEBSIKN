<?php
class user2 extends CI_Controller{
public function __construct() {
parent::__construct();
$this->load->helper('download');
$this->load->library('session');
$this->load->library('Datatables');
$this->load->library('form_validation');
$this->load->library('upload');
$this->load->model('M_user2');
if($this->session->userdata('sublevel')  != 'Level 2' ){
redirect(base_url('Menu'));
}
}

public function index(){
$this->load->view('umum/V_header');
$this->load->view('user2/V_buat_pekerjaan');
}
 
public function keluar(){
$this->session->sess_destroy();
redirect (base_url('Login'));
}

public function asisten(){  
$asisten = $this->M_user2->data_asisten($this->session->userdata('no_user'));
$this->load->view('umum/V_header');
$this->load->view('user2/V_data_asisten',['asisten'=>$asisten]);    
}

public function data_client(){
$this->load->view('umum/V_header');
$this->load->view('user2/V_data_client');
}

public function json_data_client(){
echo $this->M_user2->json_data_client();       
}

public function cari_jenis_pekerjaan(){
$term = strtolower($this->input->get('term'));    
$query = $this->M_user2->cari_jenis_dokumen($term);
foreach ($query as $d) {
$json[]= array(
'label'                    => $d->nama_jenis,   
'no_jenis_pekerjaan'       => $d->no_jenis_pekerjaan,
);   
}
echo json_encode($json);
}

public function cari_nama_client(){
$input = $this->input->post();    
$query = $this->M_user2->cari_jenis_client($input);
foreach ($query as $d) {
$json[]= array(
'label'                    => $d->nama_client,   
'no_client'                => $d->no_client,
);   
}
echo json_encode($json);
}


public function create_client(){
if($this->input->post()){
$data = $this->input->post();
$h_berkas = $this->M_user2->hitung_pekerjaan()->num_rows()+1;
$h_client = $this->M_user2->data_client()->num_rows()+1;
$no_client    = "C".str_pad($h_client,6 ,"0",STR_PAD_LEFT);
$no_pekerjaan = "P".str_pad($h_berkas,6 ,"0",STR_PAD_LEFT);

$data_client = array(
'no_client'                 => $no_client,    
'jenis_client'              => ucwords($data['jenis_client']),    
'nama_client'               => strtoupper($data['badan_hukum']),
'alamat_client'             => ucwords($data['alamat_badan_hukum']),    
'tanggal_daftar'            => date('Y/m/d'),    
'pembuat_client'            => $this->session->userdata('nama_lengkap'),    
'no_user'                   => $this->session->userdata('no_user'), 
'nama_folder'               =>"Dok".$no_client,
'contact_person'            => ucwords($data['contact_person']),    
'contact_number'            => ucwords($data['contact_number']),    
);    
$this->db->insert('data_client',$data_client);

$data_r = array(
'no_client'          => $no_client,    
'status_pekerjaan'   => "Masuk",
'no_pekerjaan'       => $no_pekerjaan,    
'tanggal_dibuat'     => date('Y/m/d'),
'no_jenis_pekerjaan' => $data['no_jenis_pekerjaan'],   
'target_kelar'       => $data['target_kelar'],
'no_user'            => $this->session->userdata('no_user'),    
'pembuat_pekerjaan'  => $this->session->userdata('nama_lengkap'),    
);

$this->db->insert('data_pekerjaan',$data_r);



if(!file_exists("berkas/"."Dok".$no_client)){
mkdir("berkas/"."Dok".$no_client,0777);
}

$keterangan = $this->session->userdata('nama_lengkap')." Membuat client ".$data['badan_hukum'];
$this->histori($keterangan);

$status = array(
"status"     => "success",
"no_client"  => base64_encode($no_client),
"pesan"      => "Telah dimasukan kedalam agenda kerja"    
);
echo json_encode($status);

}else{
redirect(404);    

}
}


public function tambah_persyaratan(){
if($this->input->post()){

$input = $this->input->post();

$syarat = array(
'no_client'                 => $input['no_client'],    
'no_pekerjaan_syarat'       => $input['no_pekerjaan'],    
'no_nama_dokumen'           => $input['no_nama_dokumen'],    
'nama_dokumen'              => $input['nama_dokumen'],
'no_jenis_dokumen'          => $input['no_jenis_dokumen'], 
);

$this->db->insert('data_persyaratan_pekerjaan',$syarat);

$keterangan = $this->session->userdata('nama_lengkap')." Menambahkan persyaratan ".$input['nama_dokumen'];  
$this->histori($keterangan);

$status = array(
"status"     => "success",
"no_pekerjaan"  => base64_encode($input['no_pekerjaan']),
"pesan"      => "Persyaratan berhasil ditambahkan",    
);

echo json_encode($status);
}else{
redirect(404);    
}   
}


public function json_data_pekerjaan_selesai(){
echo $this->M_user2->json_data_pekerjaan_selesai();       
}

public function pekerjaan_baru(){
$query = $this->M_user2->data_berkas('Baru');
    
$this->load->view('umum/V_header');
$this->load->view('user2/V_pekerjaan_baru',['query' =>$query]);
    
}
public function pekerjaan_antrian(){
$query = $this->M_user2->data_pekerjaan_user('Masuk');
    
$this->load->view('umum/V_header');
$this->load->view('user2/V_antrian',['query' =>$query]);
    
}
public function pekerjaan_proses(){
$query = $this->M_user2->data_pekerjaan_user('Proses');
    
$this->load->view('umum/V_header');
$this->load->view('user2/V_pekerjaan_proses',['query' =>$query]);
    
}public function pekerjaan_selesai(){
    
$this->load->view('umum/V_header');
$this->load->view('user2/V_pekerjaan_selesai');
    
}

public function tambahkan_kedalam_antrian(){
if($this->input->post()){

$data = array(
'status_berkas'   => 'Masuk',    
'tanggal_antrian' => date('Y/m/d H:i:s')    
);
$this->db->update('data_berkas',$data,array('no_berkas'=>$this->input->post('no_berkas')));

$status = array(
"status"=>"success",
'pesan'=>"Dokumen berhasil dimasukan kedalam antrian"   
);
echo json_encode($status);
}else{
redirect(404);    
}
    
}
public function tambahkan_kedalam_proses(){
if($this->input->post()){

$data = array(
'status_berkas'   => 'Proses',    
'tanggal_proses' => date('d/m/Y H:i:s')    
);
$this->db->update('data_berkas',$data,array('no_berkas'=>$this->input->post('no_berkas')));

$status = array(
"status"=>"success",
'pesan'=>"Dokumen berhasil dimasukan kedalam proses"   
);
echo json_encode($status);
}else{
redirect(404);    
}
}

public function proses_pekerjaan(){
if(!empty($this->uri->segment(3))){
$dokumen_perizinan   = $this->M_user2->data_pekerjaan_proses($this->uri->segment(3));    
$dokumen_utama       = $this->M_user2->dokumen_utama($this->uri->segment(3));    
$dokumen_persyaratan = $this->M_user2->data_persyaratan(base64_decode($this->uri->segment(3)));

$this->load->view('umum/V_header');
$this->load->view('user2/V_proses_perizinan',['data'=>$dokumen_perizinan,'dokumen_utama'=>$dokumen_utama,'dokumen_persyaratan'=>$dokumen_persyaratan]);    

}else{
redirect(404);    
}
}

public function lengkapi_persyaratan(){    
$no_pekerjaan = base64_decode($this->uri->segment(3));    
$query = $this->M_user2->data_persyaratan($no_pekerjaan);
$this->load->view('umum/V_header');
$this->load->view('user2/V_lengkapi_persyaratan',['query'=>$query]);    
}

public function form_persyaratan(){
if($this->input->post()){
$input = $this->input->post();
$query = $this->M_user2->data_meta($input['no_nama_dokumen']);

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
$total_berkas = $this->M_user2->total_berkas()->row_array();

$no_berkas = date('Ymd').str_pad($total_berkas['id_data_berkas'],6,"0",STR_PAD_LEFT);

$static = $this->M_user2->data_pekerjaan($input['no_pekerjaan'])->row_array();


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
'Pengupload'        => $this->session->userdata('no_user'),
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

public function persyaratan_telah_dilampirkan(){
$data_berkas  = $this->M_user2->data_telah_dilampirkan(base64_decode($this->uri->segment(3)));

if($data_berkas->num_rows() != 0){
foreach ($data_berkas->result_array() as $u){  
echo'<div class="card m-1">
<div class="row">
<div class="col card-header">'.$u['nama_dokumen'].'</div> 
<div class="col-md-4 card-header text-right">
<button type="button" onclick=lihat_data_perekaman("'.$u['no_nama_dokumen'].'","'.$u['no_pekerjaan'].'") class="btn btn-sm btn-dark btn-block">Lihat data <span class="fa fa-eye"></span></button>';

echo "</div>    
</div>
</div>";
}
}
}
public function data_perekaman(){
if($this->input->post()){
$input = $this->input->post();
$query     = $this->M_user2->data_perekaman($input['no_nama_dokumen'],$input['no_pekerjaan']);
$query2     = $this->M_user2->data_perekaman2($input['no_nama_dokumen'],$input['no_pekerjaan']);

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
.'<button class="btn btn-success btn-sm" onclick="cek_download('. $d['id_data_berkas'].')"><span class="fa fa-download"></span></button>';
if($d['pengupload'] == $this->session->userdata('no_user')){
echo ' || <button onclick=hapus_berkas_persyaratan("'.$d['id_data_berkas'].'","'.$d['no_nama_dokumen'].'","'.$d['no_pekerjaan'].'","'.$d['no_client'].'"); class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></button>';
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






public function lanjutkan_proses_perizinan(){
if($this->input->post()){
$input  = $this->input->post();
$histori   = $this->M_user2->data_pekerjaan_histori(base64_decode($input['no_pekerjaan']))->row_array();

$data = array(
'status_pekerjaan'  =>'Proses',    
'tanggal_proses'    => date('Y/m/d')    
);

$this->db->update('data_pekerjaan',$data,array('no_pekerjaan'=> base64_decode($input['no_pekerjaan'])));

$keterangan = $this->session->userdata('nama_lengkap')." Memproses perizinan ".$histori['pekerjaan']." client ". $histori['nama_client'];
$this->histori($keterangan);
$status = array(
"status"     => "success",
"pesan"      => "Perizinan berhasil diproses"    
);
echo json_encode($status);

}else{
redirect(404);    
}
}
public function update_selesaikan_pekerjaan(){
if($this->input->post()){
$input = $this->input->post();

$data = array(
'status_pekerjaan'  =>'Selesai',    
'tanggal_selesai'    =>date('d/m/Y')    
);
$this->db->update('data_pekerjaan',$data,array('no_pekerjaan'=> base64_decode($input['no_pekerjaan'])));


$status = array(
"status"     => "success",
"pesan"      => "Perizinan berhasil diproses"    
);
echo json_encode($status);

}else{
redirect(404);    
}
}


public function hapus_berkas_persyaratan(){
if($this->input->post()){
$input = $this->input->post();    

$data = $this->M_user2->hapus_berkas($input['id_data_berkas'])->row_array();

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
public function download_berkas(){
$data = $this->M_user2->data_berkas_where($this->uri->segment(3))->row_array();

$file_path = "./berkas/".$data['nama_folder']."/".$data['nama_berkas']; 
$info = new SplFileInfo($data['nama_berkas']);
force_download($data['nama_dokumen'].".".$info->getExtension(), file_get_contents($file_path));
}


public function download_utama(){
$data = $this->db->get_where('data_dokumen_utama',array('id_data_dokumen_utama'=>$this->uri->segment(3)))->row_array();    
$file_path = "./berkas/".$data['nama_folder']."/".$data['nama_file']; 
$info = new SplFileInfo($data['nama_file']);
force_download($data['nama_berkas'].".".$info->getExtension(), file_get_contents($file_path));
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

public function cari_file(){
if($this->input->post()){
$input = $this->input->post();
$dalam_bentuk_lampiran  = $this->M_user2->cari_lampiran($input['cari_dokumen']);

$this->load->view('umum/V_header');
$this->load->view('user2/V_pencarian',['dalam_bentuk_lampiran'=>$dalam_bentuk_lampiran]);

}else{
redirect(404);    
}    
}


public function lihat_pekerjaan_asisten(){
$proses = base64_decode($this->uri->segment(4));    
$no_user = base64_decode($this->uri->segment(3));
$this->db->select('*');
$this->db->from('data_berkas_perizinan');
$this->db->join('data_pekerjaan','data_pekerjaan.no_pekerjaan = data_berkas_perizinan.no_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas_perizinan.no_nama_dokumen');
$this->db->where(array('data_berkas_perizinan.status_berkas'=>$proses,'data_berkas_perizinan.no_user_perizinan'=>$no_user));
$data = $this->db->get();
$this->load->view('umum/V_header');

$this->load->view('user2/V_lihat_pekerjaan_level3',['data'=>$data]);    
    
}

public function simpan_progress_pekerjaan(){
if($this->input->post()){
$input = $this->input->post();    

$data = array(
'laporan_pekerjaan'       => $input['laporan'],
'no_pekerjaan'            => base64_decode($input['no_pekerjaan']),
'waktu'                   => date('Y/m/d')    
);
$this->db->insert('data_progress_pekerjaan',$data);
$status = array(
"status"     => "success",
"pesan"      => "Laporan berhasil dibuat"    
);
echo json_encode($status);

}else{
redirect(404);    
}    
}

function lihat_laporan_pekerjaan(){
if($this->input->post()){
$input = $this->input->post();

$data = $this->db->get_where('data_progress_pekerjaan',array('no_pekerjaan'=> base64_decode($input['no_pekerjaan'])));
if($data->num_rows() == 0){
echo "<h5 class='text-center'>Belum ada laporan yang dimasukan<br>"
    . "<br><br><span class='fa fa-list-alt fa-3x'></span></h5>";
    
}else{
echo "<table class='table table-bordered table-striped table-hover table-sm'>"
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
}
}else{
redirect(404);    
}
    
}


public function upload_utama(){
if($this->input->post()){
$input = $this->input->post();    
$data_pekerjaan = $this->M_user2->data_pekerjaan(base64_decode($input['no_pekerjaan']))->row_array();


$config['upload_path']          = './berkas/'.$data_pekerjaan['nama_folder'];
$config['allowed_types']        = 'gif|jpg|png|pdf|docx|doc|xlxs|';
$config['encrypt_name']         = TRUE;
$this->upload->initialize($config);


if (!$this->upload->do_upload('file')){
$error = array('error' => $this->upload->display_errors());
echo print_r($error);
}else{

$data = array(
'nama_file'    =>$this->upload->data('file_name'),
'nama_berkas'  =>$input['nama_file'],
'no_pekerjaan' =>$data_pekerjaan['no_pekerjaan'],
'waktu'        =>date('Y/m/d'),
'jenis'        =>$input['jenis'],    
);

$this->db->insert('data_dokumen_utama',$data);    

}


redirect(base_url('User2/proses_pekerjaan/'.base64_encode($data_pekerjaan['no_pekerjaan'])));
}else{
redirect(404);    
}
}

public function hapus_file_utama(){
if($this->input->post()){
$data = $this->db->get_where('data_dokumen_utama',array('id_data_dokumen_utama'=>$this->input->post('id_data_dokumen_utama')))->row_array();    

unlink('./berkas/'.$data['nama_folder']."/".$data['nama_file']);

$this->db->delete('data_dokumen_utama',array('id_data_dokumen_utama'=>$this->input->post('id_data_dokumen_utama')));    


$keterangan = $this->session->userdata('nama_lengkap')." Menghapus ".$data['nama_berkas'] ;
$this->histori($keterangan);



}else{
redirect(404);    
}    
}

public function hapus_data_berkas(){
if($this->input->post()){
$input = $this->input->post();    
$data = $this->db->get_where('data_berkas',array('id_data_berkas'=>$this->input->post('id_data_berkas')))->row_array();    

unlink('./berkas/'.$data['nama_folder']."/".$data['nama_berkas']);

$this->db->delete('data_berkas',array('id_data_berkas'=>$this->input->post('id_data_berkas')));    
$status = array(
"status"     => "success",
"no_pekerjaan"  => base64_encode($input['no_pekerjaan']),
"pesan"      => "Persyaratan berhasil ditambahkan",    
);

echo json_encode($status);

$keterangan = $this->session->userdata('nama_lengkap')." Menghapus File Dokumen ".$data['nama_file'];  

$this->histori($keterangan);



}else{
redirect(404);    
}    
}



public function buat_pekerjaan_baru(){

if($this->input->post()){    
$input = $this->input->post();

$h_berkas = $this->M_user2->hitung_pekerjaan()->num_rows()+1;

$no_pekerjaan = "P".str_pad($h_berkas,6 ,"0",STR_PAD_LEFT);

$data_r = array(
'no_client'          => base64_decode($input['no_client']),    
'status_pekerjaan'   => "Masuk",
'no_pekerjaan'       => $no_pekerjaan,    
'tanggal_dibuat'     => date('Y/m/d'),
'no_jenis_pekerjaan' => $input['id_jenis'],   
'target_kelar'       => $input['target_kelar'],
'no_user'            => $this->session->userdata('no_user'),    
'pembuat_pekerjaan'  => $this->session->userdata('nama_lengkap'),    
);
$this->db->insert('data_pekerjaan',$data_r);


$status = array(
"status"     => "success",
"no_client"  => base64_decode($input['no_client']),
"pesan"      => "Telah dimasukan kedalam agenda kerja"    
);
echo json_encode($status);

}else{
redirect(404);    
}    
}

public function profil(){
$no_user = $this->session->userdata('no_user');
$data_user = $this->M_user2->data_user_where($no_user);
$this->load->view('umum/V_header');
$this->load->view('user2/V_profil',['data_user'=>$data_user]);

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

public function histori($keterangan){

$data = array(
'no_user'   => $this->session->userdata('no_user'),
'keterangan'=>$keterangan,
'tanggal'   =>date('Y/m/d H:i:s'),
);

$this->db->insert('data_histori_pekerjaan',$data);
}

public function riwayat_pekerjaan(){
$this->load->view('umum/V_header');
$this->load->view('user2/V_riwayat_pekerjaan');
}

public function json_data_riwayat(){
echo $this->M_user2->json_data_riwayat();       
}

public function json_data_berkas_client($no_client){
echo $this->M_user2->json_data_berkas_client($no_client);  
}

public function lihat_berkas_client(){    
$data_client = $this->M_user2->data_client_where($this->uri->segment(3));       

$this->load->view('umum/V_header');
$this->load->view('user2/V_lihat_berkas_client',['data_client'=>$data_client]);   
}

public function proses_ulang(){
if($this->input->post()){
$data = array(
'status_pekerjaan' =>'Proses'    
);
$this->db->update('data_pekerjaan',$data,array('id_data_pekerjaan'=>$this->input->post('id_data_pekerjaan')));

$status = array(
"status"     => "success",
"pesan"      => "Pekerjaan berhasil dimasukan kedalam tahap proses"    
);
echo json_encode($status);

$d = $this->db->get_where('data_pekerjaan',array('id_data_pekerjaan'=>$this->input->post('id_data_pekerjaan')))->row_array();

$keterangan = $this->session->userdata('nama_lengkap')." Memproses ulang pekerjaan ".$d['jenis_perizinan']  ;
$this->histori($keterangan);

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


public function print_persyaratan() {
 $data = array(
        "dataku" => array(
            "nama" => "Petani Kode",
            "url" => "http://petanikode.com"
        )
    );

    $this->load->library('pdf');

    $this->pdf->setPaper('A4', 'potrait');
    $this->pdf->filename = "laporan-petanikode.pdf";
    $this->pdf->load_view('laporan_pdf', $data);
    
}

public function buat_pemilik_perekaman(){
if($this->input->post()){
$tot_pemilik   = $this->M_user2->data_pemilik()->row_array();
$no_pemilik    = "PK".str_pad($tot_pemilik['id_data_pemilik'],6 ,"0",STR_PAD_LEFT);
$input = $this->input->post();

if(!$input['no_client']){
$status = array(
"status"     => "error",
"pesan"      => "Tentukan pemilik dokumen terlebih dahulu"    
);
echo json_encode($status);    
}else{
$cek = $this->db->get_where('data_pemilik',array('no_client'=>$input['no_client'],'no_pekerjaan'=>base64_decode($input['no_pekerjaan'])));
if($cek->num_rows() == 1){
$status = array(
"status"     => "error",
"pesan"      => "Tidak Boleh Ada Nama Badan Hukum atau perorangan sama dalam satu jenis pekerjaan"    
);
echo json_encode($status);
    
}else{
$data = array(
'no_pemilik'    =>$no_pemilik,   
'no_client'     =>$input['no_client'],
'no_pekerjaan'  => base64_decode($input['no_pekerjaan'])    
);
$this->db->insert('data_pemilik',$data);

$status = array(
"status"     => "success",
"pesan"      => "Pemilik Dokumen Berhasil ditambahkan"    
);
echo json_encode($status);
}
}
}else{
redirect(404);    
}

}

public function tampilkan_data_client(){
if($this->input->post()){
$input = $this->input->post();
$data = $this->M_user2->data_pemilik_where(base64_decode($input['no_pekerjaan']));
echo "<div class='container'><div class='row'>"
. "<div class='col-md-6 card-header'>Nama Badan Hukum / Perorangan</div>"
. "<div class='col card-header'>Pembuat client</div>"
. "<div class='col card-header'>Data Terekam</div>"
. "<div class='col-md-1 card-header'>Aksi</div>"
. "</div>";
foreach ($data->result_array() as $d){
echo "<div class='row'>"
. "<div class='col-md-6 mt-2'>".$d['nama_client']."</div>"
. "<div class='col mt-2'>".$d['pembuat_client']."</div>"
. "<div class='col mt-2'><button onclick=data_perekaman_user('".$d['no_client']."'); class='btn btn-block btn-dark btn-sm'>Data Terekam ".$this->db->get_where('data_berkas',array('no_client'=>$d['no_client']))->num_rows()." <span class='fa fa-eye'></span></button></div>"
. "<div class='col-md-1 mt-2'><button onclick = hapus_pemilik('".$d['no_pemilik']."'); class='btn btn-danger btn-block btn-sm'><span class='fa fa-trash'></span></button></div>"
. "</div>";     
}
echo "</div>";
}else{
redirect(404);    
}    
}
public function tampilkan_data_perizinan(){
if($this->input->post()){
$input = $this->input->post();
$data = $this->M_user2->data_pemilik_where(base64_decode($input['no_pekerjaan']));
echo "<div class='container'><div class='row text-center'>"
. "<div class='col-md-5 card-header'>Nama Badan Hukum / Perorangan</div>"
. "<div class='col card-header'>Pembuat client</div>"
. "<div class='col text-center card-header'>Data Terekam</div>"
. "<div class='col text-center card-header'>Perizinan</div>"
. "<div class='col-md-1 card-header'>Aksi</div>"
. "</div>";
foreach ($data->result_array() as $d){
echo "<div class='row'>"
. "<div class='col-md-5 mt-2'>".$d['nama_client']."</div>"
. "<div class='col mt-2'>".$d['pembuat_client']."</div>"
. "<div class='col mt-2 text-center'><button onclick=data_perekaman_user('".$d['no_client']."'); class='btn btn-block btn-dark btn-sm'>Data Terekam ".$this->db->get_where('data_berkas',array('no_client'=>$d['no_client']))->num_rows()." <span class='fa fa-eye'></span></button></div>"
. "<div class='col mt-2 text-center'><button onclick=buat_perizinan('".$input['no_pekerjaan']."','".$d['no_client']."','".$d['no_pemilik']."'); class='btn btn-block btn-dark btn-sm'>Buat Perizinan  <span class='fa fa-plus'></span></button></div>"
. "<div class='col-md-1 mt-2'><button onclick = hapus_pemilik('".$d['no_pemilik']."'); class='btn btn-danger btn-block btn-sm'><span class='fa fa-trash'></span></button></div>"
. "</div>";     
}
echo "</div>";
}else{
redirect(404);    
}    
}
public function hapus_pemilik(){
if($this->input->post()){
$this->db->delete('data_pemilik',array('no_pemilik'=> $this->input->post('no_pemilik')));

$status = array(
"status"     => "success",
"pesan"      => "Data perekaman terhapus"    
);
echo json_encode($status);
}else{
redirect(404);    
}    
}

public function data_perekaman_user(){
if($this->input->post()){
$input = $this->input->post();    
$data_berkas  = $this->M_user2->data_telah_dilampirkan($input['no_client']);
$data_client = $this->db->get_where('data_client',array('no_client'=>$input['no_client']))->row_array();

$data_persyaratan = $this->M_user2->nama_persyaratan(base64_decode($input['no_pekerjaan']),$data_client['jenis_client']);
echo "<div class='row'>";
echo "<div class='col text-center'>"
. "<b>Nama Dokumem yang harus direkam</b><hr>";
foreach ($data_persyaratan->result_array() as $nama_dokumen){
echo "<div class='row'>";
echo "<div class='col text-left card-footer'>";
echo $nama_dokumen['nama_dokumen'];
echo"</div>";
echo "<div class='col-md-4 text-left card-footer'>";
echo '<button class="btn btn-block btn-dark m-1 btn-sm" onclick=tampil_modal_upload("'.$nama_dokumen['no_pekerjaan'].'","'.$nama_dokumen['no_nama_dokumen'].'","'.$input['no_client'].'");> Rekam Data <span class="fa fa-eye"></span> </button>';
echo"</div>";
echo"</div>";
}
echo"</div>";
echo "<div class='col text-center'>"
."<b>Nama Dokumem yang sudah direkam</b><hr>";

foreach ($data_berkas->result_array() as $u){  
echo'<div class="card m-1">
<div class="row">
<div class="col ">'.$u['nama_dokumen'].'</div> 
<div class="col-md-4  text-right">
<button type="button" onclick=lihat_data_perekaman("'.$u['no_nama_dokumen'].'","'.$u['no_pekerjaan'].'") class="btn btn-sm btn-dark btn-block">Lihat data <span class="fa fa-eye"></span></button>';
echo "</div>    
</div>
</div>";
}

echo"</div>";
}else{
redirect(404);    
}    
}



public function buat_client(){
if($this->input->post()){
$data = $this->input->post();

$h_client = $this->M_user2->data_client()->num_rows()+1;

$no_client    = "C".str_pad($h_client,6 ,"0",STR_PAD_LEFT);

$data_client = array(
'no_client'                 => $no_client,    
'jenis_client'              => ucwords($data['jenis_client']),    
'nama_client'               => strtoupper($data['badan_hukum']),
'alamat_client'             => ucwords($data['alamat_badan_hukum']),    
'tanggal_daftar'            => date('Y/m/d'),    
'pembuat_client'            => $this->session->userdata('nama_lengkap'),    
'no_user'                   => $this->session->userdata('no_user'), 
'nama_folder'               =>"Dok".$no_client,
'contact_person'            => ucwords($data['contact_person']),    
'contact_number'            => ucwords($data['contact_number']),    
);    


$this->db->insert('data_client',$data_client);

if(!file_exists("berkas/"."Dok".$no_client)){
mkdir("berkas/"."Dok".$no_client,0777);
}


$status = array(
"status"     => "success",
"pesan"      => "Client Berhasil ditambahkan"    
);
echo json_encode($status);

}else{
redirect(404);    
}}

public function modal_buat_perizinan(){
if($this->input->post()){
$input = $this->input->post();
$data_user = $this->M_user2->data_user_perizinan('Level 3');
$data_client = $this->db->get_where('data_client',array('no_client'=>$input['no_client']))->row_array();
$data_persyaratan = $this->M_user2->nama_persyaratan(base64_decode($input['no_pekerjaan']),$data_client['jenis_client']);
$data = $this->M_user2->data_perizinan($input['no_pekerjaan'],$input['no_client']);

echo "<div class='row card-header'>"
. "<div class='col'><label>Nama Dokumen</label>"
        . "<select class='form-control data_nama_dokumen form-control-sm'>";
        foreach ($data_persyaratan->result_array() as $p){        
        echo "<option value=".$p['no_nama_dokumen'].">".$p['nama_dokumen']."</option>";
        }                
        echo "</select>"
        . "</div>"
. "<div class='col'><label>Nama Petugas</label>"
        . "<select class='form-control data_nama_petugas form-control-sm'>";
       foreach ($data_user->result_array() as $u){        
        echo "<option value=".$u['no_user'].">".$u['nama_lengkap']."</option>";
        }                
        
        echo  "</select>"
        . "</div>"
        . "<div class='col'><label>Aksi</label>"
        . "<button onclick=simpan_perizinan('".base64_decode($input['no_pekerjaan'])."','".$input['no_client']."'); class='btn btn-sm btn-dark btn-block'>Buat Perizinan <span class='fa fa-save'></span></button>"
        . "</div>"
. "</div><hr>";
   

echo "<div class='row card-header'>"
        . "<div class='col-md-4'>Nama File Perizinan</div>"
        . "<div class='col-md-1'>Status</div>"
        . "<div class='col-md-2'>Target selesai</div>"
        . "<div class='col-md-2'>Pengurus</div>"
        . "<div class='col-md-3 text-center'>Aksi</div>"
        . "</div>";


foreach ($data->result_array() as $form){
echo "<div class='row'>"
    . "<div class='col-md-4 mt-2'>".$form['nama_dokumen']."</div>"
    . "<div class='col-md-1 mt-2'>".$form['status_berkas']."</div>"
    . "<div class='col-md-2 mt-2'>".$form['target_selesai_perizinan']."</div>"
    . "<div class='col-md-2 mt-2'>".$form['nama_lengkap']."</div>"
    . "<div class='col-md-3 mt-2'><select onchange=option_aksi('".$form['no_berkas_perizinan']."','".$form['no_nama_dokumen']."','".$input['no_pekerjaan']."','".$input['no_client']."') class='form-control option_aksi".$form['no_berkas_perizinan']." '>"
."<option>-- Klik untuk lihat menu --</option>"
."<option value='1'>Hapus Syarat</option>"
."<option value='2'>Alihkan Tugas</option>"
."<option value='3'>Lihat laporan</option>"
."<option value='4'>Lihat Rekaman Data</option>"
."<select></div>"
    . "</div>";
    
}
        
}else{
redirect(404);    
}    
}
public function simpan_perizinan(){
if($this->input->post()){
$input = $this->input->post();
$cek_dokumen = $this->db->get_where('data_berkas_perizinan',array('no_nama_dokumen'=>$input['no_nama_dokumen'],'no_pekerjaan'=>$input['no_pekerjaan'],'no_client'=>$input['no_client']));
if($cek_dokumen->num_rows() == 1){
$status = array(
"status"     => "error",
"pesan"      => "Tidak boleh lebih dari satu nama dokumen perizinan dalam satu pekerjaan"    
);
    
}else{    
                        $this->db->limit(1);
                        $this->db->order_by('data_berkas_perizinan.id_perizinan','DESC');
$total_berkas           = $this->db->get('data_berkas_perizinan')->row_array();
$no_berkas_perizinan    = "PRZ".str_pad($total_berkas['id_perizinan'],6,"0",STR_PAD_LEFT);

$data = array(
'no_berkas_perizinan'      => $no_berkas_perizinan,  
'no_nama_dokumen'          => $input['no_nama_dokumen'],
'no_pekerjaan'             => $input['no_pekerjaan'],
'no_client'                => $input['no_client'],   
'no_user_perizinan'        => $input['no_petugas'],
'no_user_penugas'          => $this->session->userdata('no_user'),
'status_lihat'             =>NULL,
'status_berkas'            =>NULL,
'target_selesai_perizinan' =>NULL    
);

$this->M_user2->simpan_perizinan($data);
$status = array(
"status"     => "success",
"pesan"      => "Perizinan berhasil ditambahkan"    
);
}
echo json_encode($status);
}else{
redirect(404);    
}
    
}
public function hapus_syarat(){
if($this->input->post()){
$this->db->delete('data_berkas_perizinan',array('no_berkas_perizinan'=>$this->input->post('no_berkas_perizinan')));    
}else{
redirect(404);    
}    
}
public function modal_alihkan_tugas(){
$input = $this->input->post();
$data_user = $this->M_user2->data_user_perizinan('Level 3');

echo "<label>Alihkan Tugas</label>"
. "<select onchange=tentukan_pengurus('".$input['no_berkas_perizinan']."'); class='form-control tentukan_pengurus".$input['no_berkas_perizinan']." data_nama_dokumen form-control-sm'>";
foreach ($data_user->result_array() as $u){        
echo "<option value=".$u['no_user'].">".$u['nama_lengkap']."</option>";
}                
echo "</select>";

}
public function simpan_pekerjaan_user(){
if($this->input->post()){
$input = $this->input->post();
$data = array(
    'no_user_perizinan'  => $input['no_user'],
    'tanggal_penugasan'  => date('Y/m/d'),
    'status_berkas'      => 'Masuk',
    'status_lihat'       => NULL
);
$this->db->update('data_berkas_perizinan',$data,array('no_berkas_perizinan'=>$input['no_berkas_perizinan']));
}else{
redirect(404);    
} 
    
}
}