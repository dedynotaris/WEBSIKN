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

public function data_client_hukum(){
$this->load->view('umum/V_header');
$this->load->view('user2/V_data_client_hukum');
}

public function data_client_perorangan(){
$this->load->view('umum/V_header');
$this->load->view('user2/V_data_client_perorangan');
}

public function json_data_client(){

if($this->uri->segment(3) == "Badan_hukum"){
$jenis  ="Badan Hukum";   
}else{
$jenis  ="Perorangan";    
}    
    
echo $this->M_user2->json_data_client($jenis);       
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
if(!$this->input->post('jenis_pemilik')){
$json[]= array(
'label'                    => "Tentukan jenis pemilik ",   
'no_client'                => NULL,
);   
}else{   
$query = $this->M_user2->cari_jenis_client($input);
$query2 = $query->result();
if($query->num_rows() == 0){
$json[]= array(
'label'                    => "Data client tidak tersedia",   
'no_client'                => NULL,
);   
    
}else{
foreach ($query2 as $d) {
$json[]= array(
'label'              => $d->nama_client,   
'no_client'          => $d->no_client,
'alamat_pihak'       => $d->alamat_client,
'jenis_kontak'       => $d->jenis_kontak,
'contact_person'     => $d->contact_person,
'contact_number'     => $d->contact_number,
);   
}
}
}
echo json_encode($json);
}


public function create_client(){
$input = $this->input->post();
$this->form_validation->set_rules('jenis_pekerjaan', 'Jenis pekerjaan', 'required');
$this->form_validation->set_rules('target_kelar', 'Target kelar', 'required');
$this->form_validation->set_rules('contact_person', 'Contact Person', 'required');
$this->form_validation->set_rules('contact_number', 'Contact Number', 'required|numeric');
$this->form_validation->set_rules('jenis_client', 'Jenis Client', 'required');
$this->form_validation->set_rules('jenis_kontak', 'Jenis Kontak', 'required');
$this->form_validation->set_rules('badan_hukum', 'Badan Hukum', 'required');
$this->form_validation->set_rules('alamat_badan_hukum', 'Alamat', 'required');
if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);
echo json_encode($status);

}else{
if($input['jenis_client'] == "Perorangan"){
$this->simpan_client($input);
}else if($input['jenis_client'] == "Badan Hukum"){    
$cek_badan_hukum = $this->db->get_where('data_client',array('nama_client'=>strtoupper($input['badan_hukum'])))->num_rows();        
if($cek_badan_hukum == 0){
$this->simpan_client($input);
}else{
$status[] = array(
"status"       => "error_validasi",
"messages"     =>[array("jenis_client"=>"Jenis Badan Hukum Sudah Tersedia","badan_hukum"=>"Nama Badan Hukum Sudah Tersedia")],    
);    
echo json_encode($status);
}   
}

}
}
public function simpan_client($data){
    
$h_berkas = $this->M_user2->hitung_pekerjaan()->num_rows()+1;
$h_client = $this->M_user2->data_client()->num_rows()+1;
$no_client    = "C".str_pad($h_client,6 ,"0",STR_PAD_LEFT);
$no_pekerjaan = "P".str_pad($h_berkas,6 ,"0",STR_PAD_LEFT);

$data_client = array(
'no_client'                 => $no_client,    
'jenis_client'              => ucfirst($data['jenis_client']),    
'nama_client'               => strtoupper($data['badan_hukum']),
'alamat_client'             => ucfirst($data['alamat_badan_hukum']),    
'tanggal_daftar'            => date('Y/m/d'),    
'pembuat_client'            => $this->session->userdata('nama_lengkap'),    
'no_user'                   => $this->session->userdata('no_user'), 
'nama_folder'               =>"Dok".$no_client,
'contact_person'            => ucfirst($data['contact_person']),    
'contact_number'            => ucfirst($data['contact_number']),    
'jenis_kontak'              => ucfirst($data['jenis_kontak']),    
);    
$this->db->insert('data_client',$data_client);

$data_r = array(
'no_client'          => $no_client,    
'status_pekerjaan'   => "Masuk",
'no_pekerjaan'       => $no_pekerjaan,    
'tanggal_dibuat'     => date('Y/m/d'),
'no_jenis_pekerjaan' => $data['id_jenis_pekerjaan'],   
'target_kelar'       => $data['target_kelar'],
'no_user'            => $this->session->userdata('no_user'),    
'pembuat_pekerjaan'  => $this->session->userdata('nama_lengkap'),    
);

$this->db->insert('data_pekerjaan',$data_r);

$tot_pemilik   = $this->M_user2->data_pemilik()->row_array();

$no_pemilik    = "PK".str_pad($tot_pemilik['id_data_pemilik'],6 ,"0",STR_PAD_LEFT);

$data_pem = array(
'no_pemilik'    =>$no_pemilik,   
'no_client'     =>$no_client,
'no_pekerjaan'  =>$no_pekerjaan   
);

$this->db->insert('data_pemilik',$data_pem);


if(!file_exists("berkas/"."Dok".$no_client)){
mkdir("berkas/"."Dok".$no_client,0777);
}

$keterangan = $this->session->userdata('nama_lengkap')." Membuat client ".$data['badan_hukum'];
$this->histori($keterangan);

$status[] = array(
"status"        => "success",
"no_client"     => base64_encode($no_client),
"messages"      => "Telah dimasukan kedalam agenda kerja"    
);

echo json_encode($status);        
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
"status"        => "success",
"no_pekerjaan"  => base64_encode($input['no_pekerjaan']),
"messages"      => "Persyaratan berhasil ditambahkan",    
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
$no_pekerjaan       = base64_decode($this->uri->segment(3));    
$query              = $this->M_user2->data_persyaratan($no_pekerjaan);

$this->load->view('umum/V_header');
$this->load->view('user2/V_buat_perizinan',['query'=>$query]);    

}else{
redirect(404);    
}
}

public function lengkapi_persyaratan(){    
$no_pekerjaan       = base64_decode($this->uri->segment(3));    
$query              = $this->M_user2->data_persyaratan($no_pekerjaan);

$this->load->view('umum/V_header');
$this->load->view('user2/V_lengkapi_persyaratan',['query'=>$query]);    
}


public function simpan_persyaratan(){
if($this->input->post()){
$input = $this->input->post();

foreach ($_POST as $key=>$val) {
$this->form_validation->set_rules($key,str_replace('_', ' ', $key), 'required');
}

if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);

echo json_encode($status);
}else{
    
$total_berkas = $this->M_user2->total_berkas()->row_array();

$no_berkas = "BK".date('Ymd').str_pad($total_berkas['id_data_berkas'],6,"0",STR_PAD_LEFT);

$data_client = $this->db->get_where('data_client',array('no_client'=>$input['no_client']))->row_array();

if(!empty($_FILES['file_berkas'])){
$config['upload_path']          = './berkas/'.$data_client['nama_folder'];
$config['allowed_types']        = 'gif|jpg|png|pdf|docx|doc|xlxs|';
$config['encrypt_name']         = TRUE;
$config['max_size']             = 50000;
$this->upload->initialize($config);   

if (!$this->upload->do_upload('file_berkas')){  
$status[] = array(
"status"     => "error",
"messages"      => $this->upload->display_errors()    
);
echo json_encode($status);

}else{
$lampiran = $this->upload->data('file_name');    
$this->simpan_data_persyaratan($no_berkas,$input,$lampiran);
}

}else{
$lampiran = NULL;
$this->simpan_data_persyaratan($no_berkas,$input,$lampiran);
}

    
//echo "validasi _berhasil";    


}
}else{
redirect(404);    
}
    
}

public function simpan_data_persyaratan($no_berkas,$input,$lampiran){

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
    
foreach ($input as $key=>$value){
if($key == "no_nama_dokumen" || $key == 'no_client' || $key == 'no_pekerjaan' || $key == 'file_berkas'){
}else{
$meta = array(
'no_pekerjaan'      => $input['no_pekerjaan'],
'no_nama_dokumen'   => $input['no_nama_dokumen'],
'no_berkas'         => $no_berkas,    
'nama_meta'         => $key,
'value_meta'        => $value,    
);
$this->db->insert('data_meta_berkas',$meta);
}
}

$status[] = array(
"status"      => "success",
"messages"    => "Persyaratan berhasil ditambahkan",
"no_client"   =>$input['no_client'],
"no_pekerjaan"=>$input['no_pekerjaan']    
);
echo json_encode($status);
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

$query     = $this->M_user2->data_perekaman($input['no_nama_dokumen'],$input['no_client']);
$query2     = $this->M_user2->data_perekaman2($input['no_nama_dokumen'],$input['no_client']);

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
.'<button class="btn btn-success btn-sm" onclick=cek_download_berkas("'. base64_encode($d['no_berkas']).'")><span class="fa fa-download"></span></button>';
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
$status[] = array(
"status"     => "success",
"messages"      => "Perizinan berhasil diproses"    
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
"pesan"      => "Perizinan berhasil diselesaikan"    
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

if(!empty($data['nama_berkas'])){
if(file_exists($filename)){
unlink($filename);
}
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

public function lihat_laporan_perizinan(){
if($this->input->post()){
$input = $this->input->post();

$data = $this->db->get_where('data_progress_perizinan',array('no_berkas_perizinan'=>$input['no_berkas_perizinan']));
if($data->num_rows() == 0){
echo "<h5 class='text-center text-theme1'>Belum ada laporan yang dimasukan<br>"
    . "<span class=' far fa-clipboard fa-3x'></span></h5>";
    
}else{echo "<table class='table table-bordered text-theme1 table-striped table-hover table-sm'>"
. "<tr>"
. "<th>Tanggal </th>"
. "<th class='text-center'>Laporan</th>"
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
$kata_kunci = $this->input->post('kata_kunci');


$data_dokumen           = $this->M_user2->pencarian_data_dokumen($kata_kunci);

$data_dokumen_utama     = $this->M_user2->pencarian_data_dokumen_utama($kata_kunci);

$data_client            = $this->M_user2->pencarian_data_client($kata_kunci);

$this->load->view('umum/V_header');
$this->load->view('user2/V_pencarian',['data_dokumen'=>$data_dokumen,'data_dokumen_utama'=>$data_dokumen_utama,'data_client'=>$data_client]);

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
echo "<h5 class='text-center text-theme1'>"
    . "<span class='far fa-clipboard fa-3x'></span><br>Belum ada laporan yang anda masukan</h5>";
    
}else{
echo "<table class='table text-theme1 table-bordered table-striped table-hover table-sm'>"
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

$this->form_validation->set_rules('no_pekerjaan', 'No pekerjaan', 'required');
$this->form_validation->set_rules('tanggal_akta', 'Tanggal akta', 'required');
$this->form_validation->set_rules('no_akta', 'Nomor Akta', 'required');
$this->form_validation->set_rules('jenis_utama', 'Jenis file utama', 'required');

$data_pekerjaan = $this->M_user2->data_pekerjaan(base64_decode($input['no_pekerjaan']))->row_array();

$config['upload_path']          = './berkas/'.$data_pekerjaan['nama_folder'];
$config['allowed_types']        = 'jpg|png|pdf|docx|doc|xlxs|';
$config['encrypt_name']         = TRUE;
$config['max_size']             = 50000;
$this->upload->initialize($config);   

if ($this->form_validation->run() == FALSE){

$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);
echo json_encode($status);


}else{

if (!$this->upload->do_upload('file_utama')){
$status[] = array(
'status'  => 'error_validasi',
'messages'=>[array("file_utama"=>$this->upload->display_errors('', ''))],    
);
echo json_encode($status);
}else{

$data = array(
'nama_file'    =>$this->upload->data('file_name'),
'nama_berkas'  =>$input['jenis_utama']." " .$data_pekerjaan['nama_client']." ".$data_pekerjaan['nama_jenis'],
'no_pekerjaan' =>$data_pekerjaan['no_pekerjaan'],
'waktu'        =>date('Y/m/d'),
'tanggal_akta' =>$input['tanggal_akta'],   
'jenis'        =>$input['jenis_utama'],
'no_akta'      =>$input['no_akta']   
);

$this->db->insert('data_dokumen_utama',$data);    
$status[] = array(
"status"        => "success",
"messages"      => "File utama berhasil ditambahkan"    
);
echo json_encode($status);
}
    
}



}else{
redirect(404);    
}
}

public function hapus_file_utama(){
if($this->input->post()){
$input = $this->input->post();

$data = $this->M_user2->data_dokumen_utama_where($input['id_data_dokumen_utama'])->row_array();


unlink('./berkas/'.$data['nama_folder']."/".$data['nama_file']);

$this->db->delete('data_dokumen_utama',array('id_data_dokumen_utama'=>$this->input->post('id_data_dokumen_utama')));    


$status[] = array(
"status"        => "success",
"messages"      => "File berhasil dihapus"    
);
echo json_encode($status);



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
$this->form_validation->set_rules('jenis_akta', 'Jenis akta', 'required');
$this->form_validation->set_rules('target_kelar', 'Target selesai', 'required');
if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);
echo json_encode($status);

}else{
$h_berkas = $this->M_user2->hitung_pekerjaan()->num_rows()+1;

$no_pekerjaan = "P".str_pad($h_berkas,6 ,"0",STR_PAD_LEFT);

$data_r = array(
'no_client'          => $input['no_client'],    
'status_pekerjaan'   => "Masuk",
'no_pekerjaan'       => $no_pekerjaan,    
'tanggal_dibuat'     => date('Y/m/d'),
'no_jenis_pekerjaan' => $input['id_jenis_akta'],   
'target_kelar'       => $input['target_kelar'],
'no_user'            => $this->session->userdata('no_user'),    
'pembuat_pekerjaan'  => $this->session->userdata('nama_lengkap'),    
);
$this->db->insert('data_pekerjaan',$data_r);

$status[] = array(
"status"        => "success",
"no_pekerjaan"  => base64_encode($no_pekerjaan),
"messages"      => "Telah dimasukan kedalam agenda kerja"    
);
echo json_encode($status);
    
}

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
. "<div class='col mt-2'><button onclick=data_perekaman_user('".$d['no_client']."'); class='btn btn-block btn-success btn-sm'>Proses Perekaman <span class='fa fa-retweet'></span></button></div>"
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

public function lihat_data_meta(){
$no_pekerjaan = $this->input->post();

$data_client = $this->M_user2->data_berkas_where_no_pekerjaan(base64_decode($no_pekerjaan['no_pekerjaan']));
echo "<input type='hidden' value='".$no_pekerjaan['no_pekerjaan']."' id='no_pekerjaan' class='form-control'>";
echo "<label>Pilih data client yang ingin ditampilkan</label>";
echo "<select onchange='tampilkan_data()' class='form-control form-control-sm' id='no_client'>"
. "<option>Pilih client yang ingin ditampilkan</option>";
foreach ($data_client->result_array() as $data){
echo "<option value='".$data['no_client']."'>".$data['nama_client']."</option>";   
}
echo "</select><hr>";

echo "<div class='tampilkan_data overflow-auto' style='max-height:380px;'></div>";
}




public function buat_client(){
if($this->input->post()){
$data = $this->input->post();
if($data['jenis_client'] == "Perorangan"){
$this->client_baru($data);
}else if($data['jenis_client'] == "Badan Hukum"){
$cek_badan_hukum = $this->db->get_where('data_client',array('nama_client'=>strtoupper($data['badan_hukum'])))->num_rows();        
if($cek_badan_hukum == 0){
$this->client_baru($data);
}else{
$status = array(
"status"     => "error",
"pesan"      => "Nama Badan Hukum sudah tersedia"    
);    
echo json_encode($status);
}
}
}else{
redirect(404);    
}
}
public function client_baru($data){

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
    
}

public function simpan_perizinan(){
if($this->input->post()){
$input = $this->input->post();
$cek_dokumen = $this->db->get_where('data_berkas_perizinan',array('no_nama_dokumen'=>$input['no_nama_dokumen'],'no_pekerjaan'=>$input['no_pekerjaan'],'no_client'=>$input['no_client']));
if($cek_dokumen->num_rows() == 1){
$status[] = array(
"status"     => "error",
"messages"   => "Perizinan tersebut sudah dibuat sebelumnya"    
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
'tanggal_penugasan'        => date('Y/m/d'),    
'status_lihat'             =>NULL,
'status_berkas'            =>'Masuk',
'target_selesai_perizinan' =>NULL    
);

$this->M_user2->simpan_perizinan($data);
$status[] = array(
"status"     => "success",
"messages"      => "Perizinan berhasil ditambahkan"    
);
}
echo json_encode($status);
}else{
redirect(404);    
}
    
}
public function hapus_perizinan(){
if($this->input->post()){
$this->db->delete('data_berkas_perizinan',array('no_berkas_perizinan'=>$this->input->post('no_berkas_perizinan')));    

$status[] = array(
"status"     => "success",
"messages"   => "Perizinan berhasil dihapus"    
);
echo json_encode($status);
}else{
redirect(404);    
}    
}
public function modal_alihkan_tugas(){
$input = $this->input->post();
$data_user = $this->M_user2->data_user_perizinan('Level 3');

echo "<label>Alihkan Tugas</label>"
. "<select onchange=tentukan_pengurus('".$input['no_berkas_perizinan']."','".$input['no_pekerjaan']."','".$input['no_client']."','".$input['no_pemilik']."'); class='form-control tentukan_pengurus".$input['no_berkas_perizinan']." data_nama_dokumen form-control-sm'>";
foreach ($data_user->result_array() as $u){        
echo "<option value=".$u['no_user'].">".$u['nama_lengkap']."</option>";
}                
echo "</select>";

}
public function simpan_petugas_perizinan(){
if($this->input->post()){
$input = $this->input->post();
$data = array(
    'no_user_perizinan'  => $input['no_user'],
    'tanggal_penugasan'  => date('Y/m/d'),
    'target_selesai_perizinan'  => NULL,
    'status_berkas'      => 'Masuk',
    'status_lihat'       => NULL
);
$this->db->update('data_berkas_perizinan',$data,array('no_berkas_perizinan'=>$input['no_berkas_perizinan']));
$status[] = array(
"status"        => "success",
"messages"      => "Pengalihan perizinan berhasil"    
);      
echo json_encode($status);

}else{
redirect(404);    
}
    
}
public function data_pencarian(){
if($this->input->post()){
$input = $this->input->post();
$data_dokumen         = $this->M_user2->pencarian_data_dokumen($input['kata_kunci']);
$data_client          = $this->M_user2->pencarian_data_client($input['kata_kunci']);
$dokumen_utama        = $this->M_user2->pencarian_data_dokumen_utama($input['kata_kunci']);

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
$query     = $this->M_user2->data_perekaman(base64_decode($input['no_nama_dokumen']),base64_decode($input['no_client']));
$query2     = $this->M_user2->data_perekaman2(base64_decode($input['no_nama_dokumen']),base64_decode($input['no_client']));

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

$data_berkas  = $this->M_user2->data_telah_dilampirkan(base64_decode($input['no_client']));
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
public function tampilkan_data(){
if($this->input->post()){
$input = $this->input->post();
$data_berkas = $this->M_user2->data_berkas_where_no_client($input['no_client']);

foreach ($data_berkas->result_array() as $d){
 
$query     = $this->M_user2->data_perekaman($d['no_nama_dokumen'],$d['no_client']);
$query2     = $this->M_user2->data_perekaman2($d['no_nama_dokumen'],$d['no_client']);
$cols = $query->num_rows()+1;
echo "<table class='table table-sm table-striped table-bordered'>";
echo "<thead>
    <tr><th class='text-center' colspan='".$cols."'>".$d['nama_dokumen']."</th></tr>";

echo  "<tr>";
foreach ($query->result_array() as $d){
echo "<th>".str_replace('_', ' ',$d['nama_meta'])."</th>";
}
echo "<th style='width:50px;'>Aksi</th>";
echo "</tr>"

. "</thead>";

echo "<tbody>";

foreach ($query2->result_array() as $d){
$b = $this->db->get_where('data_meta_berkas',array('no_berkas'=>$d['no_berkas']));
echo "<tr id='".$d['no_berkas']."'>";
foreach ($b->result_array() as $i){
echo "<td >".$i['value_meta']."</td>";    
}
echo '<td class="text-center">'
.'<button data-clipboard-action="copy" data-clipboard-target="#'.$d['no_berkas'].'" class="btn btn_copy btn-success btn-sm" title="Copy data ini" ><i class="far fa-copy"></i></button>';
        echo '</td>';
echo "</tr>";
    
    
}
echo "</tbody>";


echo"</table>";      
    
}

}else{
redirect(404);    
}
}

function simpan_pihak_terlibat(){
$input = $this->input->post();

$this->form_validation->set_rules('jenis_client', 'Jenis Pihak', 'required');
$this->form_validation->set_rules('nama_pihak', 'Nama Pihak', 'required');
$this->form_validation->set_rules('alamat_pihak', 'Alamat Pihak', 'required');
$this->form_validation->set_rules('jenis_kontak', 'Jenis Kontak', 'required');
$this->form_validation->set_rules('contact_person', 'Nama Kontak', 'required');
$this->form_validation->set_rules('contact_number', 'Nomor Kontak', 'required|numeric');
if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);

echo json_encode($status);

}else{
    
if($input['no_client']  == NULL){
$tot_pemilik   = $this->M_user2->data_pemilik()->row_array();

$h_berkas = $this->M_user2->hitung_pekerjaan()->num_rows()+1;
$h_client = $this->M_user2->data_client()->num_rows()+1;
$no_client    = "C".str_pad($h_client,6 ,"0",STR_PAD_LEFT);

$data_client = array(
'no_client'                 => $no_client,    
'jenis_client'              => ucfirst($input['jenis_client']),    
'nama_client'               => strtoupper($input['nama_pihak']),
'alamat_client'             => ucfirst($input['alamat_pihak']),    
'tanggal_daftar'            => date('Y/m/d'),    
'pembuat_client'            => $this->session->userdata('nama_lengkap'),    
'no_user'                   => $this->session->userdata('no_user'), 
'nama_folder'               =>"Dok".$no_client,
'contact_person'            => ucfirst($input['contact_person']),    
'contact_number'            => ucfirst($input['contact_number']),    
'jenis_kontak'              => ucfirst($input['jenis_kontak']),    
);   
$this->db->insert('data_client',$data_client);
$no_pemilik    = "PK".str_pad($tot_pemilik['id_data_pemilik'],6 ,"0",STR_PAD_LEFT);

$data_pem = array(
'no_pemilik'    =>$no_pemilik,   
'no_client'     =>$no_client,
'no_pekerjaan'  => base64_decode($input['no_pekerjaan'])   
);

$this->db->insert('data_pemilik',$data_pem);

if(!file_exists("berkas/"."Dok".$no_client)){
mkdir("berkas/"."Dok".$no_client,0777);
}


$status[] =array(
'status'    => 'success',
'messages'  => 'Pihak terkait berhasil ditambahkan' 
); 
echo json_encode($status);    

    
}else{
$tot_pemilik   = $this->M_user2->data_pemilik()->row_array();
$no_pemilik    = "PK".str_pad($tot_pemilik['id_data_pemilik'],6 ,"0",STR_PAD_LEFT);    
$cek_selaku = $this->db->get_where('data_pemilik',array('no_client' =>$input['no_client'],'no_pekerjaan'=>base64_decode($input['no_pekerjaan'])));
if($cek_selaku->num_rows() == 0){
$data_pem = array(
'no_pemilik'    =>$no_pemilik,   
'no_client'     =>$input['no_client'],
'no_pekerjaan'  => base64_decode($input['no_pekerjaan']),   
);
$this->db->insert('data_pemilik',$data_pem);
$status[] =array(
'status'    => 'success',
'messages'  => 'Pihak terkait berhasil ditambahkan' 
); 
echo json_encode($status);    
}else{
$status[] =array(
'status'    => 'error',
'messages'  => 'Pihak terkait sudah ditambahkan' 
); 
echo json_encode($status);    
}

}
}
}
function data_para_pihak(){
if($this->input->post()){
$input = $this->input->post();
$data_pihak = $this->M_user2->data_para_pihak(base64_decode($input['no_pekerjaan']));
foreach ($data_pihak->result_array() as $data){
echo "<div class='row mt-2 '>"
    . "<div class='col '>".$data['nama_client']."</div>"
    . "<div class='col  text-center'>"
    . "<button onclick=tampilkan_form('".$data['no_client']."','".$input['no_pekerjaan']."'); class='btn btn-success btn-sm' title='Rekam Dokumen Milik ".$data['nama_client']."'><span class='fa fa-plus'></span> Rekam penunjang</button>";
    if($input['proses'] == 'perizinan'){
    echo  "<button  onclick=tampilkan_form_utama('".$data['no_client']."','".$input['no_pekerjaan']."'); class='btn btn-success btn-sm ml-1' title='Rekam dokumen utama ".$data['nama_client']."'><span class='fa fa-plus'></span> Rekam utama</button>";
    echo  "<button onclick=tampilkan_form_perizinan('".$data['no_client']."','".$input['no_pekerjaan']."'); class='btn btn-success btn-sm mt-1' title='Buat Perizinan ".$data['nama_client']."'><span class='fa fa-pencil-alt'></span> Buat perizinan</button>";
    } 
    echo "</div>"
    . "</div><hr>";
}
}else{
redirect(404);    
}

}

function form_persyaratan(){
if($this->input->post()){    
$input = $this->input->post();
$data_client      = $this->M_user2->data_client_where(base64_encode($input['no_client']))->row_array();
$nama_persyaratan = $this->M_user2->nama_persyaratan(base64_decode($input['no_pekerjaan']),$data_client['jenis_client']);

echo '
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel text-center">ISILAH FORM-FORM DATA MILIK '.strtoupper($data_client['nama_client'])." ".$data_client['nama_client'].' DIBAWAH INI <span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body overflow-auto" style="max-height:500px;" >';


foreach ($nama_persyaratan->result_array() as $persyaratan){
echo '<div class="row card-header  m-1">';
echo '<div class="col-md-5">'
. '<div class="text-center h6">'.$persyaratan['nama_dokumen'].'<hr></div>';
echo "<form action='#' id='form".$persyaratan['no_nama_dokumen']."'>";

echo '<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="required"  accept="text/plain">';
echo '<input type="hidden" name="no_client" value="'.$input['no_client'].'" readonly="" class="required"  accept="text/plain">';
echo '<input type="hidden" name="no_pekerjaan" value="'.base64_decode($input['no_pekerjaan']).'" readonly="" class="required"  accept="text/plain">';
echo '<input type="hidden" name="no_nama_dokumen" value="'.$persyaratan['no_nama_dokumen'].'" readonly="" class="required"  accept="text/plain">';
$data_meta = $this->M_user2->data_meta($persyaratan['no_nama_dokumen']);

foreach ($data_meta->result_array() as $d){
/*INPUTAN SELECT*/
if($d['jenis_inputan'] == 'select'){
$data_option = $this->db->get_where('data_input_pilihan',array('id_data_meta'=>$d['id_data_meta']));   
echo "<label>".$d['nama_meta']."</label>"
."<select id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' class='form-control form_meta form-control-sm meta required' required='' accept='text/plain'>";
foreach ($data_option->result_array() as $option){
echo "<option>".$option['jenis_pilihan']."</option>";
}
echo "</select>";

/*INPUTAN DATE*/
}else if($d['jenis_inputan'] == 'date'){
echo "<label>".$d['nama_meta']."</label>"
."<input  type='text' id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-sm ".$d['jenis_inputan']." meta required ' required='' accept='text/plain' >";    

/*INPUTAN NUMBER*/
}else if($d['jenis_inputan'] == 'number'){
echo "<label>".$d['nama_meta']."</label>"
."<input  type='text' id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-sm ".$d['jenis_bilangan']." meta required ' required='' accept='text/plain' >";        

/*INPUTAN TEXTAREA*/
}else if($d['jenis_inputan'] == 'textarea'){
echo "<label>".$d['nama_meta']."</label>"
. "<textarea  id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-sm ".$d['jenis_bilangan']." meta required ' required='' accept='text/plain'></textarea>";
}else{
echo "<label>".$d['nama_meta']."</label>"
."<input  type='".$d['jenis_inputan']."' id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-sm  meta required ' required='' accept='text/plain' >";    
}

}
echo "<label>Lampiran</label>"
. "<input type='file' id='file".$persyaratan['no_nama_dokumen']."' class='form-control'>";
echo "<hr>"
. "<button type='button' onclick=upload_data('".$persyaratan['no_nama_dokumen']."','".$input['no_client']."') class='btn btn-sm btn-success btn-block '>Simpan dan rekam</button>"
. "</form>";


echo  '</div>';

/*DATA YANG AKAN DITAMPILKAN*/
echo '<div class="col " >'
    .'<div class="text-center  h6">'.$persyaratan['nama_dokumen'].'<hr></div>';

$query     = $this->M_user2->data_perekaman($persyaratan['no_nama_dokumen'],$input['no_client']);
$query2     = $this->M_user2->data_perekaman2($persyaratan['no_nama_dokumen'],$input['no_client']);

echo "<div class='row '>";
foreach ($query->result_array() as $d){
echo "<div class='col-sm-3 text-center'><b>".str_replace('_', ' ',$d['nama_meta'])."</b></div>";
}
if($query->num_rows() > 0){
echo "<div class='col text-center'><b>Aksi</b></div>";
}
echo "</div>";

foreach ($query2->result_array() as $d){
    $this->db->limit(3);
$b = $this->db->get_where('data_meta_berkas',array('no_berkas'=>$d['no_berkas']));
echo "<div class='row mt-2' id='".$d['no_berkas']."'>";
foreach ($b->result_array() as $i){
echo "<div class='col-sm-3' >".$i['value_meta']."</div>";    
}

echo '<div class="col text-center">'
.'<button  onclick=form_edit_meta("'.$input['no_client'].'","'.$input['no_pekerjaan'].'","'.$d['no_berkas'].'","'.$d['no_nama_dokumen'].'"); class="btn  btn-warning ml-1 btn-sm" title="Edit data ini" ><i class="far fa-edit"></i></button>'
.'<button  onclick=hapus_berkas_persyaratan("'.$input['no_client'].'","'.$input['no_pekerjaan'].'","'.$d['id_data_berkas'].'"); class="btn  btn-danger ml-1 btn-sm" title="Hapus data ini" ><i class="fa fa-trash"></i></button>'
.'<button  onclick=cek_download("'.base64_encode($d['no_berkas']).'"); class="btn  btn-primary ml-1 mt-1 btn-sm" title="Download lampiran ini" ><i class="fa fa-download"></i></button>';
echo '</div>';
echo '</div>';
}

echo "</div>";

echo'</div>';   
}

echo'</div>';    
}else{
redirect(404);    
}
}
public function form_tambah_pekerjaan(){
if($this->input->post()){    
$input = $this->input->post();    
$data_client = $this->M_user2->data_client_where($input['no_client'])->row_array();    
echo '<div class="modal-content">
<div class="modal-header">
<h6 class="modal-title" >Buat Pekerjaan Baru untuk '.$data_client['nama_client'].' <span id="title"></span> </h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body " >';

echo '<form id="form_pekerjaan_baru">
<label>Jenis Pekerjaan</label>
<input type="hidden" name="'. $this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="form-control required"  accept="text/plain">

<input type="hidden" name="no_client"  id="no_client" value='. base64_decode($input['no_client']).' class="form-control form-control-sm required"  accept="text/plain">
<input type="text" name="jenis_akta"  id="jenis_akta" class="form-control form-control-sm required"  accept="text/plain">
<input type="hidden" name="id_jenis_akta" readonly="" id="id_jenis_akta" class="form-control form-control-sm required"  accept="text/plain">
<label>Target selesai</label>
<input type="text" name="target_kelar" readonly="" id="target_kelar" class="form-control form-control-sm required"  accept="text/plain">

</div> 
<div class="modal-footer">
<button onclick=simpan_pekerjaan_baru(); class="btn btn-sm btn-success simpan_pekerjaan btn-block">Simpan Pekerjaan <span class="fa fa-save"></span> </button>
</form>
</div>
</div>
';    
}else{
redirect(404);    
}

}

function form_edit_client(){
if($this->input->post()){    
$input = $this->input->post();    
$data_client = $this->M_user2->data_client_where($input['no_client'])->row_array();    
echo '<div class="modal-content">
<div class="modal-header">
<h6 class="modal-title" >Edit Client '.$data_client['nama_client'].' <span id="title"></span> </h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body " >';

echo '<form id="form_update_client">
    <input type="hidden" name="'. $this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="form-control required"  accept="text/plain">

    <label>Kontak yang bisa dihubungi</label>
<input type="text" value="'.$data_client['contact_person'].'" placeholder="Kontak yang bisa dihubungi" class="form-control form-control-sm required" id="contact_person" name="contact_person" accept="text/plain">
<input type="hidden" name="no_client" value="'.$data_client['no_client'].'" readonly="" class="form-control required"  accept="text/plain">

<label>Nomor Kontak Telephone / HP</label>
<input type="text" value="'.$data_client['contact_number'].'" placeholder="Nomor Kontak Telephone  / HP" class="form-control form-control-sm required" id="contact_number" name="contact_number" accept="text/plain">

<label>Jenis Kontak</label>
<select name="jenis_kontak" id="jenis_kontak" class="form-control form-control-sm required" accept="text/plain">
<option></option>
<option ';if($data_client['jenis_kontak'] == "Staff"){echo "selected ";} echo 'value="Staff">Staff</option>
<option ';if($data_client['jenis_kontak'] == "Pribadi"){echo "selected ";} echo' value="Pribadi">Pribadi</option>	
</select>  

<label>Pilih Jenis client</label>
<select name="jenis_client" id="jenis_client" class="form-control form-control-sm required" accept="text/plain">
<option></option>
<option ';if($data_client['jenis_client'] == "Perorangan"){echo "selected ";} echo' value="Perorangan">Perorangan</option>
<option ';if($data_client['jenis_client'] == "Badan Hukum"){echo "selected ";}echo 'value="Badan Hukum">Badan Hukum</option>	
</select>    

<label  id="label_nama_perorangan">Nama </label>
<input type="text" value="'.$data_client['nama_client'].'" placeholder="Nama" name="badan_hukum" id="badan_hukum" class="form-control form-control-sm required"  accept="text/plain">

<label  id="label_alamat_perorangan">Alamat </label>
<textarea name="alamat_badan_hukum" rows="6" placeholder="Alamat " id="alamat_badan_hukum" class="form-control form-control-sm required" required="" accept="text/plain">'.$data_client['alamat_client'].'</textarea>
';

echo "</div>"
. "<div class='modal-footer'>"
        . "<button onclick=update_client(); class='btn btn-sm btn-success update_client btn-block'>Simpan Perubahan <span class='fa fa-save'</button></form>"
        . "</div>"
. "</div>";
    

}else{
redirect(404);  
}
}

public function update_client(){
if($this->input->post()){    
$input = $this->input->post();

$this->form_validation->set_rules('contact_person', 'Contact Person', 'required');
$this->form_validation->set_rules('contact_number', 'Contact Number', 'required|numeric');
$this->form_validation->set_rules('jenis_client', 'Jenis Client', 'required');
$this->form_validation->set_rules('jenis_kontak', 'Jenis Kontak', 'required');
$this->form_validation->set_rules('badan_hukum', 'Badan Hukum', 'required');
$this->form_validation->set_rules('alamat_badan_hukum', 'Alamat', 'required');
if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);
echo json_encode($status);

}else{
$data = array(
'contact_person'        =>$input['contact_person'], 
'contact_number'        =>$input['contact_number'],
'jenis_kontak'          =>$input['jenis_kontak'],
'jenis_client'          =>$input['jenis_client'],
'nama_client'           =>$input['badan_hukum'],
'alamat_client'         =>$input['alamat_badan_hukum']     
);    
$this->db->where('no_client',$input['no_client']);
$this->db->update('data_client',$data);
$status[] = array(
'status'  => 'success',
'messages'=> "Klien ".$input['badan_hukum']." Berhasil diupdate",    
);
echo json_encode($status);

}
}else{
redirect(404);  
}
}
function form_edit_pekerjaan(){
if($this->input->post()){
$input = $this->input->post();    
$data_client = $this->M_user2->data_client_where($input['no_client'])->row_array();    

echo '<div class="modal-content">
<div class="modal-header">
<h6 class="modal-title" >Edit Pekerjaan '.$data_client['nama_client'].' <span id="title"></span> </h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body " >';
echo ""
. "<form id='form_update_pekerjaan'>"
. "<label>Cari Pekerjaan Baru</label>"
. "<input type='text' name='cari_pekerjaan' id='cari_pekerjaan' class='form-control form-control-sm nama_pekerjaan'>"
. "<input type='hidden' name='no_pekerjaan' id='no_pekerjaan' value=".$input['no_pekerjaan']." class='form-control form-control-sm form-control-sm no_pekerjaan'>"
. "<input type='hidden' name='id_jenis_pekerjaan' id='id_jenis_pekerjaan' class='form-control form-control-sm id_jenis_pekerjaan)'>";
echo '<input type="hidden" name="'. $this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="form-control required"  accept="text/plain">
';
echo "</div>"
. "<div class='modal-footer'>"
        . "<button onclick=update_pekerjaan(); class='btn btn-sm btn-success update_pekerjaan btn-block'>Simpan Perubahan <span class='fa fa-save'</button></form>"
        . "</form></div>"
. "</div>";

}else{
    redirect(404);    
}    
}

function update_pekerjaan(){
if($this->input->post()){
$input = $this->input->post();

$this->form_validation->set_rules('cari_pekerjaan', 'Jenis pekerjaan ', 'required');
if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);
echo json_encode($status);

}else{
$data = array(
'no_jenis_pekerjaan' =>$input['id_jenis_pekerjaan']
); 
$this->db->where('no_pekerjaan', base64_decode($input['no_pekerjaan']));
$this->db->update('data_pekerjaan',$data);

$status[] = array(
'status'  => 'success',
'messages'=> "anda berhasil merubah pekerjaan",    
);
echo json_encode($status);

}    
}else{
    redirect(404);    
}    
}
function form_data_perizinan(){
if($this->input->post()){
$input = $this->input->post();

$data_client = $this->M_user2->data_client_where(base64_encode($input['no_client']))->row_array();    
$data_user = $this->M_user2->data_user_perizinan('Level 3');
$data_persyaratan = $this->M_user2->nama_persyaratan(base64_decode($input['no_pekerjaan']),$data_client['jenis_client']);
$data = $this->M_user2->data_perizinan($input['no_pekerjaan'],$input['no_client']);

echo '<div class="modal-content">
<div class="modal-header">
<h6 class="modal-title" >BUAT PERIZINAN UNTUK'.$data_client['nama_client'].' <span id="title"></span> </h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body " >';


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
        . "<button onclick=simpan_perizinan('".base64_decode($input['no_pekerjaan'])."','".$input['no_client']."'); class='btn btn-sm btn-success btn-block'>Simpan perizinan <span class='fa fa-save'></span></button>"
        . "</div>"
. "</div><hr>";
   

echo "<div class='row card-header'>"
        . "<div class='col-md-4'>Nama File Perizinan</div>"
        . "<div class='col-md-1'>Status</div>"
        . "<div class='col-md-2'>Target selesai</div>"
        . "<div class='col-md-2'>Pengurus perizinan</div>"
        . "<div class='col-md-3 text-center'>Aksi</div>"
        . "</div>";


foreach ($data->result_array() as $form){
echo "<div class='row'>"
    . "<div class='col-md-4 mt-2'>".$form['nama_dokumen']."</div>"
    . "<div class='col-md-1 mt-2'>".$form['status_berkas']."</div>"
    . "<div class='col-md-2 mt-2'>";
   if( $form['target_selesai_perizinan'] == NULL ){
   
echo "<b><span class='text-dark'>Belum tersedia</span></b>";    
   }else if(  $form['target_selesai_perizinan'] == date('Y/m/d')){
echo "<b><span class='text-warning'>Hari ini</span></b>";    
}else if(  $form['target_selesai_perizinan'] <= date('Y/m/d')){
$startTimeStamp = strtotime(date('Y/m/d'));
$endTimeStamp = strtotime(  $form['target_selesai_perizinan']);
$timeDiff = abs($endTimeStamp - $startTimeStamp);
$numberDays = $timeDiff/86400; 
$numberDays = intval($numberDays);
echo "<b><span class='text-danger'> Terlewat ".$numberDays." Hari </span></b>" ;
}else{
$startTimeStamp = strtotime(date('Y/m/d'));
$endTimeStamp = strtotime($form['target_selesai_perizinan']);
$timeDiff = abs($endTimeStamp - $startTimeStamp);
$numberDays = $timeDiff/86400; 
$numberDays = intval($numberDays);
echo "<b><span class='text-success'>".$numberDays." Hari lagi </span></b>" ;
}    

           echo "</div>"
    . "<div class='col-md-2 mt-2' id='".$form['no_berkas_perizinan']."'>".$form['nama_lengkap']."</div>"
    . "<div class='col-md-3 mt-2 text-center'>"
    . "<button onclick=hapus_perizinan('".$form['no_berkas_perizinan']."','".$input['no_client']."','".$input['no_pekerjaan']."'); class='btn btn-sm ml-1 btn-danger' title='Hapus perizinan'> <i class='fas fa-trash'></i></button>"
    . "<button onclick=alihkan_perizinan('".$form['no_berkas_perizinan']."','".$input['no_client']."','".$input['no_pekerjaan']."'); class='btn btn-sm ml-1 btn-warning' title='Alihkan perizinan'> <i class='fas fa-exchange-alt'></i></button>"
    . "<button onclick=lihat_laporan_perizinan('".$form['no_berkas_perizinan']."'); class='btn btn-sm ml-1  btn-success' title='Lihat laporan perizinan'> <i class='fas fa-eye'></i></button>"
    . "<button onclick=tampilkan_form('".$input['no_client']."','".$input['no_pekerjaan']."'); class='btn btn-sm  ml-1 btn-primary' title='Lihat file perizinan'> <i class='fas fa-eye'></i></button>"
    . "</div>"
    . "</div>";
    
}

echo "</div>"
. "</div>";
    
}else{
    redirect(404);    
}    
}

function option_user_level3(){
if($this->input->post()){    
$input = $this->input->post();

$data_user = $this->M_user2->data_user_perizinan('Level 3');
echo "<select  onclick=simpan_alihan_perizinan('".$input['no_berkas_perizinan']."','".$input['no_client']."','".$input['no_pekerjaan']."') class='form-control ".$input['no_berkas_perizinan']."  form-control-sm'>";

foreach ($data_user->result_array() as $u){        
echo "<option value=".$u['no_user'].">".$u['nama_lengkap']."</option>";
}                
echo  "</select>";

}else{
redirect(404);    
}    
}
function tampilkan_form_utama(){
if($this->input->post()){    
$input = $this->input->post();


echo '<div class="modal-body">';


echo  '<div class="row">
<div class="col-md-4">    
<h5 class ="text-center"> Upload dokumen utama </h5>
<hr>
<form id="form_utama">
<input type="hidden" value="'.$input['no_pekerjaan'].'" name="no_pekerjaan">
<input type="hidden" value="'.$this->security->get_csrf_hash().'" name="token">

<label>Tanggal akta</label>
<input type="text" name="tanggal_akta" id="tanggal_akta"   class="form-control date form-control-sm" name="tanggal_akta">
<label>No akta</label>
<input type="text" name="no_akta" id="no_akta"  class="form-control form-control-sm " name="tanggal_akta">

<label>Jenis file utama</label>
<select name="jenis_utama" id="jenis_utama" class="form-control form-control-sm">
<option></option>    
<option value="Draft">Draft</option>    
<option value="Minuta">Minuta</option>    
<option value="Salinan">Salinan</option>    
</select>
<label>Upload lampiran</label>
<input type="file" required="" name="file_utama" id="file_utama" class="form-control form-control-sm">
<hr>
    <button type="button" onclick=upload_utama("'.$input['no_client'].'","'.$input['no_pekerjaan'].'"); class="btn btn-block btn-sm btn-success">Upload File <span class="fa fa-upload"></span></button>

</div>

<div class="col overflow-auto" style="max-height:355px;">    
<h5 class ="text-center">Daftar dokumen utama  yang sudah diupload</h5>
<hr>';
$dokumen_utama = $this->M_user2->dokumen_utama($input['no_pekerjaan']);

echo '<table class="table text-theme1 table-sm table-striped table-bordered text-center table-hover">
<tr>
<th>nama file</th>
<th>No akta</th>
<th>tanggal akta</th>
<th>aksi</th>
</tr>';
foreach ($dokumen_utama->result_array() as $utama){ 
echo '<tr>
<td>'.$utama['nama_berkas'] .'</td>   
<td>'. $utama['no_akta'] .'</td>   
<td>'.$utama['tanggal_akta'] .'</td>   
<td>
<button  onclick=download_utama("'.$utama['id_data_dokumen_utama'].'"); class="btn btn-sm btn-success "><i class="fa fa-download"></i></button>
<button  onclick=hapus_utama("'.$utama['id_data_dokumen_utama'].'","'.$input['no_client'].'","'.$input['no_pekerjaan'].'"); class="btn btn-sm btn-danger "><i class="fa fa-trash"></i></button>
</td>   
</tr>';
 } 
echo ' 
</table>';
echo '</div>
</div>';

}else{
redirect(404);    
}    
    
}
function form_edit_meta(){
if($this->input->post()){
$input = $this->input->post();

//echo print_r($input);
$data_meta = $this->M_user2->data_meta($input['no_nama_dokumen'])->result();
$data_meta_berkas = $this->db->get_where('data_meta_berkas',array('no_berkas'=>$input['no_berkas']))->result();;

$array_merged = array_merge($data_meta_berkas,$data_meta);

foreach ($array_merged  as $d ){
//INPUTAN SELECT

if(isset($d->jenis_inputan) ){
    
if($d->jenis_inputan == 'select'){
/*$data_option = $this->db->get_where('data_input_pilihan',array('id_data_meta'=>$d['id_data_meta']));   
echo "<label>".$d['nama_meta']."</label>"
."<select id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' class='form-control form_meta form-control-sm meta required' required='' accept='text/plain'>";
foreach ($data_option->result_array() as $option){
echo "<option>".$option['jenis_pilihan']."</option>";
}
echo "</select>";

*///INPUTAN DATE
}else if($d->jenis_inputan == 'date'){
/*echo "<label>".$d['nama_meta']."</label>"
."<input  type='text' id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-sm ".$d['jenis_inputan']." meta required ' required='' accept='text/plain' >";    

*///INPUTAN NUMBER
}else if($d->jenis_inputan == 'number'){
/*echo "<label>".$d['nama_meta']."</label>"
."<input  type='text' id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-sm ".$d['jenis_bilangan']." meta required ' required='' accept='text/plain' >";        
*/
//INPUTAN TEXTAREA
}else if($d->jenis_inputan == 'textarea'){
/*echo "<label>".$d['nama_meta']."</label>"
. "<textarea  id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-sm ".$d['jenis_bilangan']." meta required ' required='' accept='text/plain'></textarea>";
*/}else{
echo "<label>".$d->nama_meta."</label>"
."<input  type='".$d->jenis_inputan."' value='' id='".str_replace(' ', '_',$d->nama_meta)."' name='".$d->nama_meta."' placeholder='".$d->nama_meta."'  maxlength='".$d->maksimal_karakter."' class='form-control form_meta form-control-sm  meta required ' required='' accept='text/plain' >";    
echo $d->value_meta;  
}

}else{
    
}

}


    
}else{
redirect(404);    
} 
}


}