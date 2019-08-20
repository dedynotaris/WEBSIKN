<?php 
class Data_lama extends CI_Controller{
public function __construct() {
parent::__construct();
$this->load->helper('download');
$this->load->library('session');
$this->load->model('M_data_lama');
$this->load->library('Datatables');
$this->load->library('upload');
if(!$this->session->userdata('username')){
redirect(base_url('Menu'));
}
}

public function index(){
$nama_notaris = $this->M_data_lama->nama_notaris();
$this->load->view('umum/V_header');
$this->load->view('data_lama/V_data_lama',['nama_notaris'=>$nama_notaris]);
}

public function data_arsip(){
$this->load->view('umum/V_header');
$this->load->view('data_lama/V_data_arsip');    
}

public function rekam_data(){
$dokumen_perizinan   = $this->M_data_lama->data_pekerjaan_proses($this->uri->segment(3));    
$dokumen_utama       = $this->M_data_lama->dokumen_utama($this->uri->segment(3));    
$dokumen_persyaratan = $this->M_data_lama->data_persyaratan(base64_decode($this->uri->segment(3)));

$this->load->view('umum/V_header');
$this->load->view('data_lama/V_rekam_data',['data'=>$dokumen_perizinan,'dokumen_utama'=>$dokumen_utama,'dokumen_persyaratan'=>$dokumen_persyaratan]);    
}

public function json_data_berkas(){
echo $this->M_data_lama->json_data_berkas();       
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
$term = strtolower($this->input->get('term'));    
$query = $this->M_data_lama->cari_nama_client($term);

foreach ($query as $d) {
$json[]= array(
'label'                    => $d->nama_client,   
'no_client'                => $d->no_client,
);   
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

public function create_client(){
if($this->input->post()){
$data = $this->input->post();

$h_client = $this->M_data_lama->data_client()->num_rows()+1;

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
}
}




public function simpan_pekerjaan_arsip(){
if($this->input->post()){
$input = $this->input->post();

$h_berkas = $this->M_data_lama->hitung_pekerjaan()->num_rows()+1;
$no_pekerjaan = "P".str_pad($h_berkas,6 ,"0",STR_PAD_LEFT);



$data_r = array(
'no_client'          => $input['no_client'],    
'status_pekerjaan'   => "Arsip",
'no_pekerjaan'       => $no_pekerjaan,    
'tanggal_dibuat'     => date('Y/m/d'),
'no_jenis_pekerjaan' => $input['no_jenis_pekerjaan'],   
'target_kelar'       => date('Y/m/d'),
'no_user'            => $input['no_user'],    
'pembuat_pekerjaan'  => $input['pembuat_pekerjaan'],    
);

$this->db->insert('data_pekerjaan',$data_r);
$status = array(
"status"     => "success",
"pesan"      => "Arsip Berhasil dibuat"    
);
echo json_encode($status);

}else{
redirect(404);    
}
}

public function form_persyaratan(){
if($this->input->post()){
$input = $this->input->post();
$query = $this->M_data_lama->data_meta($input['no_nama_dokumen']);

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
$query     = $this->M_data_lama->data_perekaman($input['no_nama_dokumen'],$input['no_pekerjaan']);
$query2     = $this->M_data_lama->data_perekaman2($input['no_nama_dokumen'],$input['no_pekerjaan']);

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
$total_berkas = $this->M_data_lama->total_berkas()->row_array();

$no_berkas = date('Ymd').str_pad($total_berkas['id_data_berkas'],6,"0",STR_PAD_LEFT);

$static = $this->M_data_lama->data_pekerjaan($input['no_pekerjaan'])->row_array();


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

}


