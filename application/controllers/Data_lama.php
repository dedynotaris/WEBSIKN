<?php 
class Data_lama extends CI_Controller{
public function __construct() {
parent::__construct();
$this->load->helper('download');
$this->load->library('session');
$this->load->model('M_data_lama');
$this->load->library('Datatables');
$this->load->library('upload');
$this->load->library('form_validation');
if(!$this->session->userdata('username')){
redirect(base_url('Menu'));
}
}

public function index(){
$nama_notaris = $this->M_data_lama->nama_notaris();
$this->load->view('umum/V_header');
$this->load->view('data_lama/V_data_lama',['nama_notaris'=>$nama_notaris]);
}

public function lihat_rekam_data(){ 
$no_pekerjaan      = base64_decode($this->uri->segment(3));
$data_perekaman    = $this->M_data_lama->data_perekaman_pekerjaan($no_pekerjaan);

$this->load->view('umum/V_header');
$this->load->view('data_lama/V_rekaman_data',['data_perekaman'=>$data_perekaman]);
}

public function data_arsip(){
$this->load->view('umum/V_header');
$this->load->view('data_lama/V_data_arsip');    
}

public function perorangan(){
$this->load->view('umum/V_header');
$this->load->view('data_lama/V_data_arsip_perorangan');    
}

public function badan_hukum(){
$this->load->view('umum/V_header');
$this->load->view('data_lama/V_data_arsip_badan_hukum');    
}

public function rekam_data(){
/*$dokumen_perizinan   = $this->M_data_lama->data_pekerjaan_proses($this->uri->segment(3));    
$dokumen_utama       = $this->M_data_lama->dokumen_utama($this->uri->segment(3));    
$dokumen_persyaratan = $this->M_data_lama->data_persyaratan(base64_decode($this->uri->segment(3)));
*/
    
$no_pekerjaan       = base64_decode($this->uri->segment(3));    
$query              = $this->M_data_lama->data_persyaratan($no_pekerjaan);


$this->load->view('umum/V_header');
$this->load->view('data_lama/V_rekam_data',['query'=>$query]);
        
}

public function json_data_berkas(){
echo $this->M_data_lama->json_data_berkas();       
}

public function json_data_arsip_perorangan(){
echo $this->M_data_lama->json_data_arsip_perorangan();       
}

public function json_data_arsip_badan_hukum(){
echo $this->M_data_lama->json_data_arsip_badan_hukum();       
}

public function json_data_arsip(){
echo $this->M_data_lama->json_data_arsip();       
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
$input = $this->input->post();    
if(!$this->input->post('jenis_pemilik')){
$json[]= array(
'label'                    => "Tentukan jenis pemilik ",   
'no_client'                => NULL,
);   
}else{   
$query = $this->M_data_lama->cari_jenis_client($input);
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

public function cari_jenis_pekerjaan(){
$term = strtolower($this->input->get('term'));    
$query = $this->M_data_lama->cari_jenis_pekerjaan($term);
foreach ($query as $d) {
$json[]= array(
'label'                             => $d->nama_jenis,   
'no_jenis_pekerjaan'                => $d->no_jenis_pekerjaan,
);   
}
echo json_encode($json);
}

function buat_arsip(){
$input = $this->input->post();
$this->form_validation->set_rules('jenis_pekerjaan', 'Jenis pekerjaan', 'required');
$this->form_validation->set_rules('no_jenis_pekerjaan', 'No jenis pekerjaan', 'required');
$this->form_validation->set_rules('jenis_client', 'Jenis Klien', 'required');
$this->form_validation->set_rules('nama_pihak', 'Nama Klien', 'required');
$this->form_validation->set_rules('jenis_kontak', 'Jenis Kontak', 'required');
$this->form_validation->set_rules('contact_person', 'Nama Kontak', 'required');
$this->form_validation->set_rules('contact_number', 'Nomor Kontak', 'required|numeric');
$this->form_validation->set_rules('alamat', 'Alamat', 'required');
$this->form_validation->set_rules('nama_notaris', 'Nama Notaris', 'required');
$this->form_validation->set_rules('no_user_pembuat', 'Nama Notaris', 'required');

if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);
echo json_encode($status);
}else{

if($input['no_client']  == NULL){

if($input['jenis_client'] == "Perorangan"){
$this->simpan_client($input);
$status[] = array(
"status"       => "success",
"messages"     =>"Pekerjaan dan klien baru berhasil dibuat",    
);    
echo json_encode($status);

}else if($input['jenis_client'] == "Badan Hukum"){    
$cek_badan_hukum = $this->db->get_where('data_client',array('nama_client'=>strtoupper($input['nama_pihak'])))->num_rows();        
if($cek_badan_hukum == 0){
$this->simpan_client($input);
$status[] = array(
"status"       => "success",
"messages"     =>"Pekerjaan dan klien baru berhasil dibuat",    
);    
echo json_encode($status);
}else{
$status[] = array(
"status"       => "error_validasi",
"messages"     =>[array("jenis_client"=>"Jenis Badan Hukum Sudah Tersedia","nama_pihak"=>"Nama Badan Hukum Sudah Tersedia")],    
);    
echo json_encode($status);
}
}

}else{    

$h_berkas = $this->M_data_lama->hitung_pekerjaan()->num_rows()+1;
$no_pekerjaan = "P".str_pad($h_berkas,6 ,"0",STR_PAD_LEFT);

$data_r = array(
'no_client'          => $input['no_client'],    
'status_pekerjaan'   => "Arsip",
'no_pekerjaan'       => $no_pekerjaan,    
'tanggal_dibuat'     => date('Y/m/d'),
'no_jenis_pekerjaan' => $input['no_jenis_pekerjaan'],   
'target_kelar'       => date('Y/m/d'),
'no_user'            => $input['no_user_pembuat'],    
'pembuat_pekerjaan'  => $input['nama_notaris'],    
);
$this->db->insert('data_pekerjaan',$data_r);

$tot_pemilik   = $this->M_data_lama->data_pemilik()->row_array();
$no_pemilik    = "PK".str_pad($tot_pemilik['id_data_pemilik'],6 ,"0",STR_PAD_LEFT);

$data_pem = array(
'no_pemilik'    =>$no_pemilik,   
'no_client'     =>$input['no_client'],
'no_pekerjaan'  =>$no_pekerjaan    
);
$this->db->insert('data_pemilik',$data_pem);
    
$status[] = array(
"status"       => "success",
"messages"     =>"Pekerjaan baru berhasil dibuat",    
);    
echo json_encode($status);
}

}
}

public function simpan_client($data){    
$h_client = $this->M_data_lama->data_client()->num_rows()+1;
$no_client    = "C".str_pad($h_client,6 ,"0",STR_PAD_LEFT);

$data_client = array(
'no_client'                 => $no_client,    
'jenis_client'              => ucwords($data['jenis_client']),    
'nama_client'               => strtoupper($data['nama_pihak']),
'alamat_client'             => ucwords($data['alamat']),    
'tanggal_daftar'            => date('Y/m/d'),    
'pembuat_client'            => $this->session->userdata('nama_lengkap'),    
'no_user'                   => $this->session->userdata('no_user'), 
'nama_folder'               =>"Dok".$no_client,
'contact_person'            => ucwords($data['contact_person']),    
'contact_number'            => ucwords($data['contact_number']),    
'jenis_kontak'            => $data['jenis_kontak'],    
);    
$this->db->insert('data_client',$data_client);
if(!file_exists("berkas/"."Dok".$no_client)){
mkdir("berkas/"."Dok".$no_client,0777);
}

$h_berkas = $this->M_data_lama->hitung_pekerjaan()->num_rows()+1;
$no_pekerjaan = "P".str_pad($h_berkas,6 ,"0",STR_PAD_LEFT);

$data_r = array(
'no_client'          => $no_client,    
'status_pekerjaan'   => "Arsip",
'no_pekerjaan'       => $no_pekerjaan,    
'tanggal_dibuat'     => date('Y/m/d'),
'no_jenis_pekerjaan' => $data['no_jenis_pekerjaan'],   
'target_kelar'       => date('Y/m/d'),
'no_user'            => $data['no_user_pembuat'],    
'pembuat_pekerjaan'  => $data['nama_notaris'],    
);
$this->db->insert('data_pekerjaan',$data_r);

$tot_pemilik   = $this->M_data_lama->data_pemilik()->row_array();
$no_pemilik    = "PK".str_pad($tot_pemilik['id_data_pemilik'],6 ,"0",STR_PAD_LEFT);

$data_pem = array(
'no_pemilik'    =>$no_pemilik,   
'no_client'     =>$no_client,
'no_pekerjaan'  =>$no_pekerjaan    
);
$this->db->insert('data_pemilik',$data_pem);


}


public function persyaratan_telah_dilampirkan(){
$data_berkas  = $this->M_data_lama->data_telah_dilampirkan(base64_decode($this->uri->segment(3)));

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
$query     = $this->M_data_lama->data_perekaman($input['no_nama_dokumen'],$input['no_client']);
$query2     = $this->M_data_lama->data_perekaman2($input['no_nama_dokumen'],$input['no_client']);

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



public function upload_utama(){
if($this->input->post()){
$input = $this->input->post();    
$data_pekerjaan = $this->M_data_lama->data_pekerjaan(base64_decode($input['no_pekerjaan']))->row_array();


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
'nama_berkas'  =>$input['jenis']." " .$data_pekerjaan['nama_client']." ".$data_pekerjaan['nama_jenis'],
'no_pekerjaan' =>$data_pekerjaan['no_pekerjaan'],
'waktu'        =>date('Y/m/d'),
'tanggal_akta' =>$input['tanggal_akta'],   
'jenis'        =>$input['jenis'],    
);

$this->db->insert('data_dokumen_utama',$data);    

}


redirect(base_url('Data_lama/rekam_data/'.base64_encode($data_pekerjaan['no_pekerjaan'])));
}else{
redirect(404);    
}
}
public function hapus_file_utama(){
if($this->input->post()){
    $data = $this->db->get_where('data_dokumen_utama',array('id_data_dokumen_utama'=>$this->input->post('id_data_dokumen_utama')))->row_array();    
echo print_r($data);

//unlink('./berkas/'.$data['nama_folder']."/".$data['nama_file']);

//$this->db->delete('data_dokumen_utama',array('id_data_dokumen_utama'=>$this->input->post('id_data_dokumen_utama')));    


$keterangan = $this->session->userdata('nama_lengkap')." Menghapus ".$data['nama_berkas'] ;
$this->histori($keterangan);



}else{
redirect(404);    
}    
}
public function tampilkan_data_perizinan(){
if($this->input->post()){
$input = $this->input->post();
$data = $this->M_data_lama->data_pemilik_where(base64_decode($input['no_pekerjaan']));
echo "<div class='container'><div class='row text-center'>"
. "<div class='col-md-5 card-header'>Nama Badan Hukum / Perorangan</div>"
. "<div class='col card-header'>Pembuat client</div>"
. "<div class='col text-center card-header'>Data Terekam</div>"
. "<div class='col-md-1 card-header'>Aksi</div>"
. "</div>";
foreach ($data->result_array() as $d){
echo "<div class='row'>"
. "<div class='col-md-5 mt-2'>".$d['nama_client']."</div>"
. "<div class='col mt-2'>".$d['pembuat_client']."</div>"
. "<div class='col mt-2 text-center'><button onclick=data_perekaman_user('".$d['no_client']."'); class='btn btn-block btn-dark btn-sm'>Data Terekam ".$this->db->get_where('data_berkas',array('no_client'=>$d['no_client']))->num_rows()." <span class='fa fa-eye'></span></button></div>"
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
    
$total_berkas = $this->M_data_lama->total_berkas()->row_array();

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
"status"     => "success",
"messages"   => "Persyaratan berhasil ditambahkan"    
);
echo json_encode($status);
}


public function data_pencarian(){
if($this->input->post()){
$input = $this->input->post();
$data_dokumen         = $this->M_data_lama->pencarian_data_dokumen($input['kata_kunci']);
$data_client          = $this->M_data_lama->pencarian_data_client($input['kata_kunci']);
$dokumen_utama        = $this->M_data_lama->pencarian_data_dokumen_utama($input['kata_kunci']);

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
public function cari_file(){
$kata_kunci = $this->input->post('kata_kunci');


$data_dokumen           = $this->M_data_lama->pencarian_data_dokumen($kata_kunci);

$data_dokumen_utama     = $this->M_data_lama->pencarian_data_dokumen_utama($kata_kunci);

$data_client            = $this->M_data_lama->pencarian_data_client($kata_kunci);

$this->load->view('umum/V_header');
$this->load->view('data_lama/V_pencarian',['data_dokumen'=>$data_dokumen,'data_dokumen_utama'=>$data_dokumen_utama,'data_client'=>$data_client]);
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
$query     = $this->M_data_lama->data_perekaman(base64_decode($input['no_nama_dokumen']),base64_decode($input['no_client']));
$query2     = $this->M_data_lama->data_perekaman2(base64_decode($input['no_nama_dokumen']),base64_decode($input['no_client']));

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

$data_berkas  = $this->M_data_lama->data_telah_dilampirkan(base64_decode($input['no_client']));
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
$data = $this->M_data_lama->data_berkas_where($this->uri->segment(3))->row_array();

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


public function data_perekaman_user(){
if($this->input->post()){
$input = $this->input->post();    
$data_berkas  = $this->M_data_lama->data_telah_dilampirkan($input['no_client']);
$data_client = $this->db->get_where('data_client',array('no_client'=>$input['no_client']))->row_array();

$data_persyaratan = $this->M_data_lama->nama_persyaratan(base64_decode($input['no_pekerjaan']),$data_client['jenis_client']);
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
echo'<div class=" m-1">
<div class="row">
<div class="col ">'.$u['nama_dokumen'].'</div> 
<div class="col-md-4  text-right">
<button type="button" onclick=lihat_data_perekaman("'.$u['no_nama_dokumen'].'","'.$u['no_pekerjaan'].'","'.$input['no_client'].'") class="btn btn-sm btn-outline-dark btn-block">Lihat data <span class="fa fa-eye"></span></button>';
echo "</div>    
</div>
</div>";
}

echo"</div>";
}else{
redirect(404);    
}    
}

public function buat_pemilik_perekaman(){
if($this->input->post()){
$tot_pemilik   = $this->M_data_lama->data_pemilik()->row_array();
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
public function keluar(){
$this->session->sess_destroy();
redirect (base_url('Login'));
}

function data_para_pihak(){
if($this->input->post()){
$input = $this->input->post();
$data_pihak = $this->M_data_lama->data_para_pihak(base64_decode($input['no_pekerjaan']));
foreach ($data_pihak->result_array() as $data){
echo "<div class='row mt-2 '>"
    . "<div class='col '>".$data['nama_client']."</div>"
    . "<div class='col  text-center'><button onclick=tampilkan_form('".$data['no_client']."','".$input['no_pekerjaan']."'); class='btn btn-success btn-sm' title='Rekam Dokumen Milik ".$data['nama_client']."'><span class='fa fa-plus'></span> Rekam dokumen</button></div>"
    . "</div>";
}
}else{
redirect(404);    
}

}


function form_persyaratan(){
if($this->input->post()){    
$input = $this->input->post();
$data_client      = $this->M_data_lama->data_client_where(base64_encode($input['no_client']))->row_array();
$nama_persyaratan = $this->M_data_lama->nama_persyaratan(base64_decode($input['no_pekerjaan']),$data_client['jenis_client']);

echo '
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel text-center">ISILAH FORM-FORM DATA MILIK '.strtoupper($data_client['nama_client'])." ".$data_client['nama_client'].' DIBAWAH INI <span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body overflow-auto" style="max-height:500px;" >';


foreach ($nama_persyaratan->result_array() as $persyaratan){
$data_meta = $this->M_data_lama->data_meta($persyaratan['no_nama_dokumen']);
echo '<div class="row card-header  m-1">';
echo '<div class="col-md-5">'
. '<div class="text-center h6">'.$persyaratan['nama_dokumen'].'<hr></div>';
echo "<form action='#' id='form".$persyaratan['no_nama_dokumen']."'>";

echo '<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="required"  accept="text/plain">';
echo '<input type="hidden" name="no_client" value="'.$input['no_client'].'" readonly="" class="required"  accept="text/plain">';
echo '<input type="hidden" name="no_pekerjaan" value="'.base64_decode($input['no_pekerjaan']).'" readonly="" class="required"  accept="text/plain">';
echo '<input type="hidden" name="no_nama_dokumen" value="'.$persyaratan['no_nama_dokumen'].'" readonly="" class="required"  accept="text/plain">';

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

$query     = $this->M_data_lama->data_perekaman($persyaratan['no_nama_dokumen'],$input['no_client']);
$query2     = $this->M_data_lama->data_perekaman2($persyaratan['no_nama_dokumen'],$input['no_client']);

echo "<div class='row'>";
foreach ($query->result_array() as $d){
echo "<div class='col'>".str_replace('_', ' ',$d['nama_meta'])."</div>";
}

echo "<div class='col'>Aksi</div>";
echo "</div>";

foreach ($query2->result_array() as $d){
$b = $this->db->get_where('data_meta_berkas',array('no_berkas'=>$d['no_berkas']));
echo "<div class='row' id='".$d['no_berkas']."'>";
foreach ($b->result_array() as $i){
echo "<div class='col' >".$i['value_meta']."</div>";    
}

echo '<div class="col">'
.'<button data-clipboard-action="copy" data-clipboard-target="#'.$d['no_berkas'].'" class="btn btn_copy btn-success btn-sm" title="Copy data ini" ><i class="far fa-copy"></i></button>';
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
$tot_pemilik   = $this->M_data_lama->data_pemilik()->row_array();
$no_pemilik    = "PK".str_pad($tot_pemilik['id_data_pemilik'],6 ,"0",STR_PAD_LEFT);

$h_berkas = $this->M_data_lama->hitung_pekerjaan()->num_rows()+1;
$h_client = $this->M_data_lama->data_client()->num_rows()+1;
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
$tot_pemilik   = $this->M_data_lama->data_pemilik()->row_array();
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
}


