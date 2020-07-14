<?php 
require('vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
$asisten = $this->db->get_where('user',array('level'=>'User'));    
$this->load->view('umum/V_header');
$this->load->view('dashboard/V_Dashboard',['asisten'=>$asisten]);    
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

public function HapusJenisPekerjaan(){
if($this->input->post()){
$input = $this->input->post();
$this->db->delete('data_jenis_pekerjaan',array('no_jenis_pekerjaan'=>$input['no_jenis_pekerjaan']));
}else{
redirect(404);    
}    
}
public function HapusJenisDokumen(){
  if($this->input->post()){
  $input = $this->input->post();
  $this->db->delete('nama_dokumen',array('no_nama_dokumen'=>$input['no_dokumen']));
  }else{
  redirect(404);    
  }    
  }

public function DetailPekerjaan(){
if($this->input->post()){
$input                        = $this->input->post();
$DataPekerjaan                = $this->db->get_where('data_jenis_pekerjaan',array('no_jenis_pekerjaan'=>$input['no_jenis_pekerjaan']))->row_array();
$DataPersyaratan              = $this->M_dashboard->data_persyaratan($input['no_jenis_pekerjaan']);

                                $this->db->group_by('data_pekerjaan.no_client');  
$JumlahClient                 = $this->db->get_where('data_pekerjaan',array('no_jenis_pekerjaan'=>$input['no_jenis_pekerjaan']))->num_rows();

$JumlahDokumenPenunjangPekerjaan = $this->M_dashboard->JumlahDokumenPenunjangPekerjaan($input['no_jenis_pekerjaan'])->num_rows();
$JumlahDokumenUtamaPekerjaan     = $this->M_dashboard->JumlahDokumenUtamaPekerjaan($input['no_jenis_pekerjaan'])->num_rows();

echo '<div class="modal-content">
<div class="modal-header bg-info text-white">
<h6 class="modal-title" id="tambah_syarat1">Detail Pekerjaan '.$DataPekerjaan['nama_jenis'].' <span id="title"> </span> </h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body overflow-auto" style="max-height:500px;">
<div class="row">
<div class="col text-center">
<div class="card">
Jumlah Klien yang telah menggunakan pekerjaan ini
<div class="card-footer">'.$JumlahClient.'</div>
</div>
</div>

<div class="col text-center">
<div class="card">
 Jumlah Dokumen Penunjang yang ada dalam pekerjaan ini
<div class="card-footer">'.$JumlahDokumenPenunjangPekerjaan.'</div>
</div>
</div>

<div class="col text-center">
<div class="card">
Jumlah Dokumen Utama yang ada dalam pekerjaan ini
<div class="card-footer">'.$JumlahDokumenUtamaPekerjaan.'</div>
</div>
</div>

</div>
<hr>
<div class="row">
<form id="FormUpdatePekerjaan">
<div class="col">
<input type="hidden" name="'. $this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="form-control required"  accept="text/plain">
<input  name="no_jenis_pekerjaan" type="hidden" value="'.$input['no_jenis_pekerjaan'].'" class="form-control form-control-sm block">
<label>*Nama Pekerjaan </label>
<input name="nama_jenis" type="text" value="'.$DataPekerjaan['nama_jenis'].'" id="nama_jenis" class="form-control nama_jenis form-control-sm block">
</div>

<div class="col">
<label>* Pekerjaan Milik</label>
<Select  id="pekerjaan"  name="pekerjaan"  class="form-control pekerjaan form-control-sm">
<option value="NOTARIS">NOTARIS</option>
<option value="PPAT">PPAT</option>
</Select>
</div>

<div class="col">
<label>&nbsp;</label>
<button type="button"  onclick="UpdatePekerjaan()" class="btn BtnUpdatePekerjaan btn-sm btn-dark btn-block">Update <i class="fa fa-save"></i></button>
</form>
</div>

</div>
<hr>

<div class="row">
<form id="FormTambahPersyaratan">
<div class="col">
<Label>* Tambahkan Dokumen Persyaratan</Label>
<input type="hidden" name="'. $this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="form-control required"  accept="text/plain">
<input  name="no_jenis_pekerjaan" type="hidden" value="'.$input['no_jenis_pekerjaan'].'" class="form-control form-control-sm block">
<select onchange="TambahPersyaratan()" name="jenis_dokumen" id="jenis_dokumen" class="form-control form-control-sm  jenis_dokumen"></select>
</div>
<div class="col">
<label>&nbsp;</label>
<button type="button" onclick="FormTambahDokumen()"  class="btn BtnTambahPersyaratan btn-md btn-dark btn-block">Tambahkan Dokumen Penunjang<i class="fa fa-plus"></i></button>
</form>
</div>
</div>

<hr>
<div class="row">
<div class="col">';

echo "<table class='table table-striped '>"
. "<tr  class='text-info'>"
."<th>No</th>"
."<th>Nama Dokumen Persyaratan</th>"
."<th class='text-center'>Aksi</th>"
. "</tr>";
$h =1;
foreach ($DataPersyaratan->result_array() as $d){
echo  "<tr class='hapus_syarat".$d['id_data_persyaratan']."'>"
."<td >".$h++."</td>"
."<td >".$d['nama_dokumen']."</td>"
."<td  class='text-center'><button onclick=hapus_syarat('".$d['id_data_persyaratan']."','".$input['no_jenis_pekerjaan']."'); class='btn btn-sm btn-danger'><span class='fa fa-trash'></span></button></td>"
. "</tr>";    
}
echo "</table>";
echo '</div>
</div>
<hr>

</div>
<div class="modal-footer">
<button ';
if($JumlahClient == 0 ){
  echo 'onclick=HapusJenisPekerjaan("'.$input['no_jenis_pekerjaan'].'")'; 
  }else{
  echo "disabled";  
  }
echo ' class="btn btn-sm btn-danger btn-block">Hapus Jenis Pekerjaan Ini <i class="fa fa-trash"></i></button>
</div>
</div>
';
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

public function SimpanPekerjaanBaru(){
if($this->input->post()){
$input = $this->input->post();
$this->form_validation->set_rules('nama_jenis', 'jenis pekerjaan', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('pekerjaan', 'pekerjaan_milik', 'required',array('required' => 'Data ini tidak boleh kosong'));

if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);
echo json_encode($status);
}else{
    
    //Pembuatan No Jenis Pekerjaan
    $this->db->limit(1);
    $this->db->order_by('data_jenis_pekerjaan.no_jenis_pekerjaan','desc');
    $h_pekerjaan       = $this->db->get('data_jenis_pekerjaan')->row_array();
    if(isset($h_pekerjaan['no_jenis_pekerjaan'])){
    $urutan = (int) substr($h_pekerjaan['no_jenis_pekerjaan'],3)+1;
    }else{
    $urutan =1;
    }
    $no_jenis    =  "J_".str_pad($urutan,4 ,"0",STR_PAD_LEFT);
    //

$data = array(
'no_jenis_pekerjaan'  =>$no_jenis,
'pekerjaan'           =>$this->input->post('pekerjaan'),
'nama_jenis'          =>$this->input->post('nama_jenis'),
'pembuat_jenis'       => $this->session->userdata('nama_lengkap'),  
);

$this->M_dashboard->simpan_jenis($data);


foreach ($input as $key=>$value){
   //Pembuatan id_persyaratan
   $this->db->limit(1);
   $this->db->order_by('data_persyaratan.id_data_persyaratan','desc');
   $h_syarat       = $this->db->get('data_persyaratan')->row_array();
   if(isset($h_syarat['id_data_persyaratan'])){
   $urutan = (int) substr($h_syarat['id_data_persyaratan'],3)+1;
   }else{
   $urutan =1;
   }
   $id_syarat    =  "S_".str_pad($urutan,5 ,"0",STR_PAD_LEFT);
   //  
if($key != 'ci_csrf_token' && $key != 'nama_jenis' && $key != 'pekerjaan'){
$data2 = array(
  'id_data_persyaratan'       =>$id_syarat,
  'no_nama_dokumen'           =>$key,
  'no_jenis_pekerjaan'        =>$no_jenis    
);
$this->db->insert('data_persyaratan',$data2);    
}
}

$status[] = array(
"status"    =>"success",
"messages"  =>"Jenis Pekerjaan Baru Berhasil Ditambahkan",
);
echo json_encode($status);

}
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
public function CariJenisDokumen(){
$term  = strtolower($this->input->post('search'));    
$query = $this->M_dashboard->cari_nama_dokumen($term);

if($query->num_rows() >0){
foreach ($query->result() as $d) {
  $json[]= array(
  'text'                    => $d->nama_dokumen,   
  'id'                      => $d->no_nama_dokumen,
  );   
  }
$data = array(
  'results'=>$json,
);
}else{
$data = array(
  'results'=>[array('error'=>'Pencarian Tidak Ditemukan')],
);    
}
  echo json_encode($data);
  
}


public function JsonDataJenisPekerjaan(){
echo $this->M_dashboard->JsonDataJenisPekerjaan();       
}


public function JsonDataPekerjaanClient($no_client){
echo $this->M_dashboard->JsonDataPekerjaanClient($no_client);       
}


public function JsonDokumenPenunjangClient($no_client){
echo $this->M_dashboard->JsonDokumenPenunjangClient($no_client);       
}
public function JsonDokumenPenunjangPekerjaan($no_pekerjaan){
echo $this->M_dashboard->JsonDokumenPenunjangPekerjaan($no_pekerjaan);       
}


public function JsonDokumenUtamaPekerjaan($no_pekerjaan){
echo $this->M_dashboard->JsonDokumenUtamaPekerjaan($no_pekerjaan);       
}

public function JsonPihakTerlibat($no_pekerjaan){
echo $this->M_dashboard->JsonPihakTerlibat($no_pekerjaan);       
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

public function json_data_client_hukum(){
echo $this->M_dashboard->json_data_client_hukum();       
}

public function json_data_client_perorangan(){
echo $this->M_dashboard->json_data_client_perorangan();       
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
public function UpdatejenisPekerjaan(){
if($this->input->post()){
  $this->form_validation->set_rules('pekerjaan', 'Pekerjaan Milik', 'required',array('required' => 'Data ini tidak boleh kosong'));
  $this->form_validation->set_rules('nama_jenis', 'Jenis Dokumen', 'required',array('required' => 'Data ini tidak boleh kosong'));
  
if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);
echo json_encode($status);
}else{
$input = $this->input->post();

$data = array(
'pekerjaan'          =>$input['pekerjaan'],
'nama_jenis'         =>$input['nama_jenis'],
'pembuat_jenis'      => $this->session->userdata('nama_lengkap'),  
);

$this->db->update('data_jenis_pekerjaan',$data,array('no_jenis_pekerjaan'=>$input['no_jenis_pekerjaan']));

$status[] = array(
"status"=>"success",
"messages"=>"Data pekerjaan berhasil diperbaharui"
);

echo json_encode($status);
}  
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




public function data_client_hukum(){
$this->load->view('umum/V_header');
$this->load->view('dashboard/V_data_client_hukum');
}

public function data_client_perorangan(){
$this->load->view('umum/V_header');
$this->load->view('dashboard/V_data_client_perorangan');
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

public function SimpanPersyaratan(){
if($this->input->post()){
$input = $this->input->post();
$this->form_validation->set_rules('jenis_dokumen', 'No Identitas NIK/NPWP', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('no_jenis_pekerjaan', 'Email Client', 'required',array('required' => 'Data ini tidak boleh kosong'));

if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);
echo json_encode($status);

}else{
$cek_jenis_dokumen = $this->db->get_where('data_persyaratan',array('no_nama_dokumen'=>$input['jenis_dokumen'],'no_jenis_pekerjaan'  =>$input['no_jenis_pekerjaan']))->num_rows();
if($cek_jenis_dokumen == 0){
$data = array(
'no_nama_dokumen'     =>$input['jenis_dokumen'], 
'no_jenis_pekerjaan'  =>$input['no_jenis_pekerjaan']   
);
$this->db->insert('data_persyaratan',$data);
$status[] = array(
'status'                => 'success',
'messages'              => "Dokumen Persyaratan Berhasil Ditambahkan",    
'no_jenis_pekerjaan'    => $input['no_jenis_pekerjaan'],    
);
echo json_encode($status);
}else{
$status[] = array(
'status'                => 'error',
'messages'              => "Jenis Dokumen Ini Sudah Tersedia",    
'no_jenis_pekerjaan'    => $input['no_jenis_pekerjaan'],    
);
echo json_encode($status);    
}

}

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
$id_data_meta = $this->M_dashboard->id_data_meta()->row_array();
$id_meta = $id_data_meta['id_meta']+1;

$data = array(
'id_data_meta'      => 'M_'.$id_meta,   
'no_nama_dokumen'   => $input['no_nama_dokumen'],
'nama_meta'         => $input['nama_meta'],
'jenis_inputan'     => $input['jenis_input'],
'maksimal_karakter' => $input['maksimal_karakter'],
'jenis_bilangan'    => $input['jenis_bilangan'] 
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









public function data_berkas(){
$this->load->view('umum/V_header');
$this->load->view('dashboard/V_data_berkas');
    
}


public function json_data_berkas_client($no_client){
echo $this->M_dashboard->json_data_berkas_client($no_client);       
}

public function lihatDetailPekerjaan($no_pekerjaan){
$DetailPekerjaan = $this->M_dashboard->DetailPekerjaanWhere(base64_decode($no_pekerjaan));    

$this->load->view('umum/V_header');
$this->load->view('dashboard/V_DetailPekerjaan',['DetailPekerjaan'=>$DetailPekerjaan]);

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
$input              = $this->input->post();
$DokumenPenunjang   = $this->M_dashboard->DokumenPenunjang($input['no_berkas']);
$data = $DokumenPenunjang->row_array();
echo '<div class="modal-content ">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel text-center">'.$data['nama_dokumen'].'<span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">';
echo "<table class='table table-hover table-sm table-stripped table-bordered'>";
echo "<tr><td class='text-center' colspan='2'>".$data['nama_client']."</td></tr>";
foreach($DokumenPenunjang->result_array() as $d){
echo "<tr><td>".str_replace('_', ' ',$d['nama_meta'])."</td>";    
echo "<td>".$d['value_meta']."</td></tr>";    
}
echo"</table></div>";
echo"<div class='card-footer'>";
$ext = pathinfo($data['nama_berkas'], PATHINFO_EXTENSION);
if($ext =="docx" || $ext =="doc" ){
echo "<button onclick=cek_download_berkas('".base64_encode($data['no_berkas'])."') class='btn btn-success btn-sm mx-auto btn-block '>Lihat Dokumen <i class='fa fa-eye'></i></button>";
}else if($ext == "xlx"  || $ext == "xlsx"){
echo "<button onclick=cek_download_berkas('".base64_encode($data['no_berkas'])."') class='btn btn-success btn-sm mx-auto btn-block '>Lihat Dokumen <i class='fa fa-eye'></i></button>";
}else if($ext == "PDF"  || $ext == "pdf"){
echo "<button onclick=lihat_pdf('".$data['nama_folder']."','".$data['nama_berkas']."'); class='btn btn-success btn-sm mx-auto btn-block '>Lihat Dokumen <i class='fa fa-eye'></i></button>";
}else if($ext == "JPG"  || $ext == "jpg" || $ext == "png"  || $ext == "PNG"){
echo "<button onclick=lihat_gambar('".$data['nama_folder']."','".$data['nama_berkas']."');  class='btn btn-success btn-sm mx-auto btn-block '>Lihat File <i class='fa fa-eye'></i></button>";
}else{
echo "<button  onclick=cek_download_berkas('".base64_encode($data['no_berkas'])."') class='btn btn-success btn-sm mx-auto btn-block '>Lihat File <i class='fa fa-eye'></i></button>";
}
echo "</div></div>";

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
/*$cek_aplikasi = $this->db->get('status_aplikasi')->row_array();
    
    
echo '<link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/css/bootstrap4-toggle.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.5.0/js/bootstrap4-toggle.min.js"></script>  <div class="container-fluid">
';    
echo '<div class="container mt-2"><div class="row ">
<div class="col">
                <div class="card text-center">
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
            
            ';/*<div class="col">
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
            </div>*/
     /*                      
         echo '<div class="col text-center">
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

</div></div>';    
*/
                           
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
public function FormTambahJenisPekerjaan(){
if($this->input->post()){

echo '<div class="modal-content">
<div class="modal-header bg-info text-white">
<h6 class="modal-title" >Tambahkan Jenis Pekerjaan Dan Persyaratannya </h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body overflow-auto" style="max-height:400px;">

<div class="row">
<form id="FormTambahPekerjaan">
<div class="col">
<input type="hidden" name="'. $this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="form-control required"  accept="text/plain">
<label>*Nama Pekerjaan </label>
<input name="nama_jenis" type="text" value="" id="nama_jenis" class="form-control nama_jenis  block">
</div>

<div class="col">
<label>* Pekerjaan Milik</label>
<Select id="pekerjaan"  name="pekerjaan"  class="form-control pekerjaan ">
<option value="NOTARIS">NOTARIS</option>
<option value="PPAT">PPAT</option>
</Select>
</div>

</form>

</div>
<hr>

<div class="row">
<div class="col">
<Label>*Dokumen Penunjang</Label>
<select onchange=BuatPersyaratan(); name="jenis_dokumen" id="jenis_dokumen" class="form-control form-control-sm  jenis_dokumen"></select>
</div>
</div>

<hr>
<div class="row">
<div class="col">';

echo "<table id='persyaratan' class='table table-striped '>"
."<thead>"
."<tr  class='text-info'>"
."<th>No</th>"
."<th>Nama Dokumen Persyaratan</th>"
."<th class='text-center'>Aksi</th>"
."</tr>"
."</thead>";

echo "<tbody class='data_persyaratan'> </tbody>";
echo "</table>";
echo '</div>
</div>
<hr>

</div>
<div class="modal-footer">
<Button type="button" onclick=BuatPekerjaanBaru() class="btn btn-dark btn-md btn-block">Simpan Pekerjaan Baru <span class="fa fa-save"></span></Button>
</div>
</div>
';
}else{
redirect(4);    
}    
  
}

function DetailDokumen(){
if($this->input->post()){  
$input          = $this->input->post();
$DataDokumen    = $this->db->get_where('nama_dokumen',array('no_nama_dokumen'=>$input['no_dokumen']))->row_array();
$jumlahlampiran = $this->db->get_where('data_berkas',array('no_nama_dokumen'=>$input['no_dokumen']))->num_rows();  

echo '<div class="modal-content">
<div class="modal-header bg-info text-white">
<h6 class="modal-title" id="tambah_syarat1">Buat Jenis Dokumen Penunjang</h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body overflow-auto" style="max-height:500px;">';
     
  
echo '
<form id="FormUpdateDokumen">
<div class="row">

<div class="col p-3 m-2 card text-center">
<div class="checkbox-inline">
<label class="checkbox-inline">
* Dokumen ini Akan diminta pada saat pendaftaran client</label></label>
<input ';if($DataDokumen['persyaratan_daftar'] == 'Perorangan' ){ echo'checked '; } echo' value="Perorangan"  name="syarat_daftar" type="radio" >
<br>
<span style="font-size:12px;">Jadikan Persyaratan Wajib Pendaftaran Client Perorangan</span> 
</div>
</div>

<div class="col p-3 m-2 card text-center">
<div class="checkbox-inline">
<label class="checkbox-inline">
* Dokumen ini Akan diminta pada saat pendaftaran client</label>
<input  ';if($DataDokumen['persyaratan_daftar'] == 'Badan Hukum' ){ echo'checked '; } echo' value="Badan Hukum"  name="syarat_daftar" type="radio">
<br>
<span style="font-size:12px;">Jadikan Persyaratan Wajib Pendaftaran Client Badan Hukum</span>
</div>
</div>

</div>
<div class="row">
<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="form-control required"  accept="text/plain">
<div class="col p-2 m-2 card text-center">
<div class="checkbox-inline">
<label class="checkbox-inline">
Klasifikasi Sebagai Dokumen Penunjang Client</label>
<input ';if($DataDokumen['penunjang_client'] == 'penunjang_client' ){ echo'checked '; } echo ' value="penunjang_client" id="penunjang_client" name="penunjang_client" type="checkbox" class="penunjang_client">
</div>
</div>

<div class="col p-2 m-2 card  text-center">
<div class="checkbox-inline">
<label class="checkbox-inline">
Klasifikasi Sebagai Penunjang Pekerjaan Badan Hukum</label>
<input ';if($DataDokumen['badan_hukum'] == 'Badan Hukum' ){ echo'checked '; } echo' value="Badan Hukum" id="badan_hukum" name="badan_hukum" type="checkbox" class="  badan_hukum">
</div>
</div>

<div class="col p-2 m-2 card text-center">
<div class="checkbox-inline">
<label class="checkbox-inline" >
Klasifikasi Sebagai Penunjang Pekerjaan Perseorangan</label>
<input ';if($DataDokumen['perorangan'] == 'Perorangan' ){ echo'checked '; } echo' value="Perorangan" id="perorangan" name="perorangan" type="checkbox" class=" perorangan">
</div>
</div>
</div>
<hr>

<div class="row">
<div class="col">
<input type="hidden" name="'. $this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="form-control required"  accept="text/plain">
<Label>Nama Dokumen</label>
<input type="hidden" name="no_dokumen" value="'.$input['no_dokumen'].'" readonly="" class="form-control required"  accept="text/plain">
<input type="text" name="nama_dokumen" id="nama_dokumen" value="'.$DataDokumen['nama_dokumen'].'" class="form-control ">
</div>

</form>
</div>

<div class="row mt-3">
<div class="col">
<form id="FormMeta">
';
$this->LihatDataMeta($input['no_dokumen']);
echo '</form></div>
</div>
<div class="modal-footer">
<button type="button" onclick="UpdateNamaDokumen()" class="btn btn-md btn-dark btn-block">Update Dokumen Penunjang <span class="fa fa-save"></span></button>
</div>
<div class="modal-footer">
<button '; 
if($jumlahlampiran == 0 ){
echo 'onclick=HapusJenisDokumen("'.$input['no_dokumen'].'")'; 
}else{
echo "disabled";  
}
echo ' class="btn btn-md btn-danger btn-block">Hapus Jenis Dokumen Ini <i class="fa fa-trash"></i></button>
</div>
</div>';
}else{
redirect(404);  
}
}


public function LihatDataMeta($no_dokumen){
  $data = $this->db->get_where('data_meta',array('no_nama_dokumen'=>$no_dokumen));
    echo'
    <table class="table table-striped ">
    <thead class="text-info"> 
    <tr>
    <td align="center" colspan="4">Daftar Nama identifikasi yang mempermudah pencarian Dokumen</td>
    </tr>
    <tr>
    <td>Nama Identifikasi</th>
    <th>Jumlah Karakter</th>
    <th>Jenis Inputan</th>
    <th>Aksi </th>
    </tr>
    </thead>
    <tbody id="data_identifikasi">
    <tr >
    <td>
    <input type="hidden" name="no_dokumen" value="'.$no_dokumen.'" readonly="" class="form-control required"  accept="text/plain">
    <input type="text" name="nama_meta" id="nama_meta"  placeholder="nama identifikasi" class="form-control form-meta form-control-sm nama_meta"></td>
    <td><input type="number" name="maxlength" id="maxlength" maxlength="3" placeholder="maksimal karakter" class="form-control form-meta maksimal_karakter form-control-sm"></td>
    <td><select name="jenis_inputan" id="jenis_inputan" onchange="check_inputan();"  class="form-control form-control-sm  form-meta jenis_inputan">
    <option value="text">text</option>    
    <option value="number">angka</option>
    <option value="select">pilihan</option>
    <option value="date">tanggal</option>
    <option value="textarea">textarea</option>
    </select>
    <select style="display:none;" disabled name="jenis_bilangan" id="jenis_bilangan" class="form-control form-meta form-control-sm jenis_bilangan">
    <option>Bulat</option>    
    <option>Desimal</option>
    </select>
    </td>
    <td><button type="button"  onclick=SimpanFormMeta("'.$no_dokumen.'") class="btn btn-md btn-dark "><span class="fa fa-plus"></span></button></td>
    </tr>';
      foreach ($data->result_array() as $d){
    echo "<tr id=form".$d['id_data_meta'].">"
      . "<td>".$d['nama_meta']."</td>"
      . "<td>".$d['maksimal_karakter']."</td>"
      . "<td>".$d['jenis_inputan']."</td>"
      . "<td class='text-center'>"
          . "<button type=button title='hapus meta' class='btn btn-danger m-1 btn-md' onclick=hapus_meta('".$d['id_data_meta']."','".$no_dokumen."')><span class='fa fa-trash'></span></button>";
          if($d['jenis_inputan'] == 'select'){
              echo "<button type=button onclick=TambahkanOpsi('".$d['id_data_meta']."','".$no_dokumen."') title='Tambahkan option' class='btn TmbhOpsi".$d['id_data_meta']." btn-success btn-sm'><span class='fa fa-plus'</button>";
          }
          echo "</td>"
    . "</tr>";
    }
    echo'
    </tbody>
    </table>';

   
  }

  public function UpdateNamaDokumen(){
      
    if($this->input->post()){    
    $input = $this->input->post();
   

$this->form_validation->set_rules('nama_dokumen', 'nama_dokumen', 'required',array('required' => 'Data ini tidak boleh kosong'));

if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);
echo json_encode($status);
}else{

if(!$this->input->post('badan_hukum') && !$this->input->post('perorangan')){
$status[] = array(
'status'  => 'error_validasi',
'messages'=>[array(
'badan_hukum'=> "Tentukan Entitas Dokumen Ini",  
'perorangan'=>"Tentukan Entitas Dokumen Ini",  
)]    
);
echo json_encode($status);
    
}else{
  $data = array(
    'no_nama_dokumen'     =>$input['no_dokumen'],
    'nama_dokumen'        =>$input['nama_dokumen'],
    'pembuat'             =>$this->session->userdata('nama_lengkap'),   
    'badan_hukum'         =>$this->input->post('badan_hukum'),
    'perorangan'          =>$this->input->post('perorangan'),
    'penunjang_client'    =>$this->input->post('penunjang_client'),
    'persyaratan_daftar'  =>$this->input->post('syarat_daftar')
    );
    $this->db->update('nama_dokumen',$data,array('no_nama_dokumen'=>$input['no_dokumen']));
    
    $status[] = array(
    "status"=>"success",
    "messages"=>"Nama dokumen berhasil diperbaharui"
    );
    
    echo json_encode($status);

}
}
    }else{
    redirect(404);    
    }    
    }
    

    public function SimpanMeta(){
      if($this->input->post()){
      $input = $this->input->post();

$this->form_validation->set_rules('nama_meta', 'nama_meta', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('maxlength', 'maksimal karakter', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('jenis_inputan', 'jenis inputan', 'required',array('required' => 'Data ini tidak boleh kosong'));

if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);
echo json_encode($status);
}else{
    //Pembuatan Id data_meta//
    $this->db->limit(1);
    $this->db->order_by('data_meta.id_data_meta','desc');
    $h_meta       = $this->db->get('data_meta')->row_array();
    if(isset($h_meta['id_data_meta'])){
    $urutan2 = (int) substr($h_meta['id_data_meta'],3)+1;
    }else{
    $urutan2 =1;
    }
    $id_meta    =  "M_".str_pad($urutan2,4 ,"0",STR_PAD_LEFT);
    // 
  $data = array(
  'id_data_meta'      => $id_meta,   
  'no_nama_dokumen'   => $input['no_dokumen'],
  'nama_meta'         => $input['nama_meta'],
  'jenis_inputan'     => $input['jenis_inputan'],
  'maksimal_karakter' => $input['maxlength'],
  'jenis_bilangan'    => $this->input->post('jenis_bilangan')
  );
  $this->db->insert('data_meta',$data);    
  
  $status[] = array(
  "status"        =>"success",
  "messages"       =>"Form Meta dokumen berhasil ditambahkan" 
  );
  
  echo json_encode($status);
}
      
          
      }else{
      redirect(404);    
      }       
      }
      
      public function HapusDataMeta(){
        if($this->input->post()){
        $this->db->delete('data_meta',array('id_data_meta'=>$this->input->post('id_data_meta')));
        $status[] = array(
        "status"        =>"success",
        "messages"      =>"Data meta Berhasil dihapus" 
        );
          
          echo json_encode($status);
            
        }else{
        redirect(404);    
        }    
        }
  
 function FormTambahOpsi(){
if($this->input->post()){

$input = $this->input->post();
echo "<tr id=FormOpsi".$input['id_data_meta'].">
<td colspan='2'>
<form id=TambahOpsi".$input['id_data_meta'].">
<input type='hidden' name='". $this->security->get_csrf_token_name()."' value='".$this->security->get_csrf_hash()."' readonly='' class='form-control required'  accept='text/plain'>
<input type='hidden' name='id_data_meta' value='".$input['id_data_meta']."' readonly='' class='form-control required'  accept='text/plain'>
<Label>Masukan Pilihan</label>
<input type='text' name='pilihan'  id='pilihan' class='form-control form-control-sm pilihan'>
<hr>
<button type='button' onclick=SimpanOpsiBaru('".$input['id_data_meta']."','".$input['no_dokumen']."') class='btn btn-sm btn-success btn-block'>Simpan pilihan <span class='fa fa-save'></span></button>
<button type=button onclick=HideFormOpsi('".$input['id_data_meta']."') class='btn btn-sm btn-warning btn-block'>Cancel </button>
</form></td>
";

$data_option = $this->db->get_where('data_input_pilihan',array('id_data_meta'=>$input['id_data_meta']));
echo "<td colspan='2'><ol>";
foreach ($data_option->result_array() as $d){
echo "<li>".$d['jenis_pilihan']."</li> <button type=button onclick=HapusPilihan('".$d['id_data_input_pilihan']."','".$input['no_dokumen']."') class='btn btn-sm btn-danger'><span class='fa fa-trash'></span></button>";    
}
echo "</ol></td>";
echo "</tr>";

}else{
redirect("404");  
}
}

function SimpanOpsi(){
if($this->input->post()){

  $this->form_validation->set_rules('id_data_meta', 'id data meta', 'required',array('required' => 'Data ini tidak boleh kosong'));
  $this->form_validation->set_rules('pilihan', 'pilihan', 'required',array('required' => 'Data ini tidak boleh kosong'));
  
  if ($this->form_validation->run() == FALSE){
  $status_input = $this->form_validation->error_array();
  $status[] = array(
  'status'  => 'error_validasi',
  'messages'=>array($status_input),    
  );
  echo json_encode($status);
  }else{

$input = $this->input->post();
$data = array(
'id_data_meta'    =>$input['id_data_meta'],
'jenis_pilihan'   =>$input['pilihan'], 
);
$this->db->insert('data_input_pilihan',$data);

$status[] = array(
  "status"        =>"success",
  "messages"      =>"Data Pilhan Berhasil ditambahkan" 
  );
    
    echo json_encode($status);
  }
}else{
redirect(404);  
}
  
}

function HapusPilihan(){
if($this->input->post()){
 $input = $this->input->post();
$this->db->delete('data_input_pilihan',array('id_data_input_pilihan'=>$input['id_data_input_pilihan']));
$status[] = array(
  "status"        =>"success",
  "messages"      =>"Pilihan Berhasil dihapus" 
  );
    
    echo json_encode($status);
  
}else{
redirect("404");  
}
}

function FormTambahDokumen(){
  if($this->input->post()){
 echo '<div class="modal-content">
    <div class="modal-header bg-info text-white">
    <h6 class="modal-title" id="tambah_syarat1">Buat Jenis Dokumen Penunjang</h6>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body overflow-auto" style="max-height:500px;">';
echo '<form id="FormBuatDokumen">
<div class="row">

<div class="col p-3 m-2 card text-center">
<div class="checkbox-inline">
<label class="checkbox-inline">
* Dokumen ini Akan diminta pada saat pendaftaran client</label></label>
<input value="Perorangan" id="penunjang_client" name="syarat_daftar" type="radio" class="penunjang_client">
<br>
<span style="font-size:12px;">Jadikan Persyaratan Wajib Pendaftaran Client Perorangan</span> 
</div>
</div>

<div class="col p-3 m-2 card text-center">
<div class="checkbox-inline">
<label class="checkbox-inline">
*Dokumen ini Akan diminta pada saat pendaftaran client</label>
<input value="Badan Hukum" id="penunjang_client" name="syarat_daftar" type="radio" class="penunjang_client">
<br>
<span style="font-size:12px;">Jadikan Persyaratan Wajib Pendaftaran Client Badan Hukum</span>
</div>
</div>

</div>
<div class="row">
<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="form-control required"  accept="text/plain">

<div class="col m-2 P-1 card text-center">
<div class="checkbox-inline">
<label class="checkbox-inline">
Klasifikasi Sebagai Dokumen Penunjang Client</label>
<input value="penunjang_client" id="penunjang_client" name="penunjang_client" type="checkbox" class="penunjang_client">
</div>
</div>

<div class="col m-2 P-1 card text-center">
<div class="checkbox-inline">
<label class="checkbox-inline">
Klasifikasi Sebagai Penunjang Pekerjaan Badan Hukum</label>
<input value="Badan Hukum" id="badan_hukum" name="badan_hukum" type="checkbox" class="  badan_hukum">
</div>
</div>

<div class="col m-2 P-1 card text-center">
<div class="checkbox-inline">
<label class="checkbox-inline" >
Klasifikasi Sebagai Penunjang Pekerjaan Perseorangan</label>
<input value="Perorangan" id="perorangan" name="perorangan" type="checkbox" class=" perorangan">
</div>
</div>
</div>

<hr>
<div class="row">
<div class="col">
<Label>Nama Dokumen</label>
<input type="text" name="nama_dokumen" id="nama_dokumen" value="" class="form-control " placeholder="Masukan Nama Dokumen">
</div>
</div>
</div>

<div class="row mt-3">
<div class="col">
<table class="table table-striped ">
<thead class="text-info"> 
<tr>
<td align="center" colspan="4">Masukan nama identifikasi untuk mempermudah pencarian dokumen</td>
</tr>
<tr>
<th>Nama Identifikasi</th>
<th>Jumlah Karakter</th>
<th>Jenis Inputan</th>
<th>Aksi </th>
</tr>
</thead>
<tbody id="data_identifikasi">

<tr>
<td><input type="text" name="nama_meta" id="nama_meta"  placeholder="nama identifikasi" class="form-control form-meta form-control-sm nama_meta"></td>
<td><input type="number" name="maxlength" id="maxlength" maxlength="3" placeholder="maksimal karakter" class="form-control form-meta maksimal_karakter form-control-sm"></td>
<td><select name="jenis_inputan" id="jenis_inputan" onchange="check_inputan();"  class="form-control form-control-sm  form-meta jenis_inputan">
<option value="text">text</option>    
<option value="number">angka</option>
<option value="select">pilihan</option>
<option value="date">tanggal</option>
<option value="textarea">textarea</option>
</select>
<select style="display:none;" disabled name="jenis_bilangan" id="jenis_bilangan" class="form-control form-meta form-control-sm jenis_bilangan">
<option>Bulat</option>    
<option>Desimal</option>
</select>
</td>
<td><button type="button" onclick=SimpanIdentifikasi(); class="btn btn-md btn-dark "><span class="fa fa-plus"></span></button></td>
</tr>

</tbody>
</table>
</div>
</div>
<div class="modal-footer">
<button type="button" onclick=SimpanDokumenBaru(); class="btn btn-md btn-dark btn-block"> Simpan Dokumen Penunjang <span class="fa fa-save"></span></button>
</form>
</div>
</div>';
 
}else{
  redirect(404);    
  }
  
}

public function SimpanNamaDokumen(){
  if($this->input->post()){
        $input =$this->input->post(); 
        $this->form_validation->set_rules('nama_dokumen', 'nama_dokumen', 'required',array('required' => 'Data ini tidak boleh kosong'));
  
  if($this->form_validation->run() == FALSE){
        
        $status_input = $this->form_validation->error_array();
            $status[] = array(
            'status'  => 'error_validasi',
            'messages'=>array($status_input),    
        );
        
        echo json_encode($status);
  }else{
    
    if(!$this->input->post('identifikasi')){
            
          $status[] = array(
            'status'   => 'error_validasi',
            'messages' =>[array(
            'nama_meta'=>'Masukan Data Identifikasi',
            'maxlength'=>'Masukan Data Identifikasi',
            )]);
          echo json_encode($status);

    }else if($this->input->post('badan_hukum') || $this->input->post('perorangan')){
          
            //Pembuatan No Dokumen 
            $this->db->limit(1);
            $this->db->order_by('nama_dokumen.no_nama_dokumen','desc');
            $h_dokumen       = $this->db->get('nama_dokumen')->row_array();
            if(isset($h_dokumen['no_nama_dokumen'])){
            $urutan = (int) substr($h_dokumen['no_nama_dokumen'],3)+1;
            }else{
            $urutan =1;
            }
            $no_nama_dokumen    =  "N_".str_pad($urutan,4 ,"0",STR_PAD_LEFT);
            //

            $data = array(
            'no_nama_dokumen'         => $no_nama_dokumen,
            'nama_dokumen'            => $this->input->post('nama_dokumen'),
            'pembuat'                 => $this->session->userdata('nama_lengkap'),
            'badan_hukum'             => $this->input->post('badan_hukum'),
            'perorangan'              => $this->input->post('perorangan'),
            'penunjang_client'        => $this->input->post('penunjang_client'),
            'persyaratan_daftar'           => $this->input->post('syarat_daftar')
            );
            $this->M_dashboard->SimpanNamaDokumen($data);
            
  for($a=0; $a<count($input['identifikasi']); $a++){
            //Pembuatan Id data_meta//
            $this->db->limit(1);
            $this->db->order_by('data_meta.id_data_meta','desc');
            $h_meta       = $this->db->get('data_meta')->row_array();
            if(isset($h_meta['id_data_meta'])){
            $urutan2 = (int) substr($h_meta['id_data_meta'],3)+1;
            }else{
            $urutan2 =1;
            }
            $id_meta    =  "M_".str_pad($urutan2,4 ,"0",STR_PAD_LEFT);
            //

            $data_meta = array(
            'id_data_meta'      => $id_meta,   
            'no_nama_dokumen'   => $no_nama_dokumen,
            'nama_meta'         => $input['identifikasi'][$a]['nama_meta'],
            'jenis_inputan'     => $input['identifikasi'][$a]['jenis_inputan'],
            'maksimal_karakter' => $input['identifikasi'][$a]['max_length'],
            'jenis_bilangan'    => $input['identifikasi'][$a]['jenis_bilangan']
            );
            $this->db->insert('data_meta',$data_meta);    
    }
  
          $status[] = array(
          "status"    =>"success",
          "messages"  =>"Jenis Dokumen Baru Berhasil ditambahkan"
          );
          echo json_encode($status);
  }else{
      $status[] = array(
      'status'   => 'error_validasi',
      'messages' =>[array(
      'badan_hukum' =>'Pilih Entitas Dokumen',
      'perorangan' =>'Pilih Entitas Dokumen',
      )]);
    echo json_encode($status);
  }
}
  }else{    
  redirect(404);    
    
  }    
  
  }

 function FormTambahUser(){
 echo '<div class="modal-content">
 <div class="modal-header">
 <h6 class="modal-title" >Form Untuk Menambahkan User Baru <span id="title"> </span> </h6>
 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
 <span aria-hidden="true">&times;</span>
 </button>
 </div>
 <div class="modal-body p-3 " style="max-height:500px;">
 <div class="row">
 <form id="FormUserBaru">
 <div class="col">
 <input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="form-control required"  accept="text/plain">
 <label>Username</label>
 <input type="text" name="username" class=" username form-control form-control-sm" id="username" placeholder="Username ">
 <label>Nama Lengkap</label>
 <input type="text" name="nama_lengkap" class="nama_lengkap form-control form-control-sm" id="nama_lengkap" placeholder="Nama Lengkap ">
 
 <label>Email</label>
 <input type="text" name="email" class="email form-control form-control-sm" id="email" placeholder="Email ">
 <label>Phone</label>
 <input type="text" name="phone" class="phone form-control form-control-sm" id="phone" placeholder="Phone ">
 </div>

 <div class="col">
 <label>Level</label>
 <select name="level" class="level form-control form-control-sm" id="level">
 <option value="User">User</option>
 <option value="Admin">Admin</option>
 <option Value="Super Admin">Super Admin</option>
 </select>
 
 
 <label>Status</label>
 <select name="status"  class=" status form-control form-control-sm" id="status">
 <option value="Admin">Aktif</option>
 <option Value="Super Admin">Tidak Aktif</option>
 </select>
 <label>Password</label>
 <input type="password" name="password1" id="password1" class="password1 form-control form-control-sm" placeholder="Masukan Password ">
 <label>Ulangi Password</label>
 <input type="password" name="password2" id="password2" class="password2 form-control form-control-sm" placeholder="Ulangi Password ">
 </div>
 </div>
 </div>

 <div class="modal-footer">
 <button type="button" onclick="SimpanUserBaru()" class="btn btn-block  btn-sm btn-success" id="simpan_user">Simpan <span class="fa fa-save"></span></button> 
 </form>
 </div>
 </div>
 '; 
 } 

 public function SimpanUser(){
  if($this->input->post()){
  $input = $this->input->post();
  $this->form_validation->set_rules('username', 'username', 'required',array('required' => 'Data ini tidak boleh kosong'));
  $this->form_validation->set_rules('nama_lengkap', 'nama_lengkap', 'required',array('required' => 'Data ini tidak boleh kosong'));
  $this->form_validation->set_rules('email', 'email', 'required|valid_email',array('required' => 'Data ini tidak boleh kosong'));
  $this->form_validation->set_rules('phone', 'phone', 'required',array('required' => 'Data ini tidak boleh kosong'));
  $this->form_validation->set_rules('level', 'level', 'required',array('required' => 'Data ini tidak boleh kosong'));
  $this->form_validation->set_rules('status', 'status', 'required',array('required' => 'Data ini tidak boleh kosong'));
  $this->form_validation->set_rules('password1', 'password1', 'required',array('required' => 'Data ini tidak boleh kosong'));
  $this->form_validation->set_rules('password2', 'password2', 'required',array('required' => 'Data ini tidak boleh kosong'));
  
  if ($this->form_validation->run() == FALSE){
  $status_input = $this->form_validation->error_array();
  $status[] = array(
  'status'  => 'error_validasi',
  'messages'=>array($status_input),    
  );
  echo json_encode($status);
  }else{
  $CekUsername = $this->db->get_where('user',array('username'=>$input['username']))->row_array();
  if($CekUsername > 0 ){
    $status[] = array(
      'status'  => 'error_validasi',
      'messages'=>[array('username'=>'Username Sudah Tersedia Gunakan Username Lain')],    
      );
      echo json_encode($status);
  }else if($input['password1'] != $input['password2']){
    $status[] = array(
      'status'  => 'error_validasi',
      'messages'=>[array('password1'=>'Password yang dimasukan tidak sama','password2'=>'Password yang dimasukan tidak sama')],    
      );
      echo json_encode($status);
  }else{
    $jumlah_user        = $this->M_dashboard->data_user()->row_array();
    $no_user            = str_pad($jumlah_user['id_user']+1, 4 ,"0",STR_PAD_LEFT);
    $data = array(
      'no_user'      => $no_user,  
      'username'     => $input['username'],  
      'nama_lengkap' => $input['nama_lengkap'],
      'level'        => $input['level'],
      'status'       => $input['status'],
      'email'        => $input['email'],
      'phone'        => $input['phone'],
      'password'     => md5($input['password1'])
      );
  $this->M_dashboard->simpan_user($data);     
      $status[] = array(
        "status"    =>"success",
        "messages"  =>'User Baru Berhasil Ditambahkan'
        );
        echo json_encode($status);
  }

  } 
  
  
  
  
 }else{
  redirect(404);    
  }
  }

 
  function DetailDataUser(){
 if($this->input->post()){

$input              = $this->input->post();
$DataUser           = $this->db->get_where('user',array('no_user'=>$input['no_user']))->row_array();
$TotDataPekerjaan   = $this->db->get_where('data_pekerjaan',array('no_user'=>$input['no_user']))->num_rows();
$TotJumlahLampiran  = $this->M_dashboard->TotJumlahLampiranUser($input['no_user'])->num_rows();
$TotJumlahUtama     = $this->M_dashboard->TotJumlahUtamaUser($input['no_user'])->num_rows();
$Sublevel           = $this->db->get_where('sublevel_user',array('no_user'=>$input['no_user']));

echo '<div class="modal-content">
    <div class="modal-header">
    <h6 class="modal-title" >Data User '.$DataUser['nama_lengkap'].' <span id="title"> </span> </h6>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body p-3 overflow-auto " style="max-height:500px;" >
    <div class="row">
    <div class="col-md-9">
    
    <div class="row">
    <div class="col-sm-4">Username</div>
    <div class="col"> : '.$DataUser['username'].'</div>
    </div>
    
    <div class="row">
    <div class="col-sm-4">Nama Lengkap</div>
    <div class="col"> : '.$DataUser['nama_lengkap'].'</div>
    </div>

    <div class="row">
    <div class="col-sm-4">Email</div>
    <div class="col"> : '.$DataUser['email'].'</div>
    </div>

    <div class="row">
    <div class="col-sm-4">No Hp</div>
    <div class="col"> : '.$DataUser['phone'].'</div>
    </div>

    <div class="row">
    <div class="col-sm-4">Level</div>
    <div class="col"> : '.$DataUser['level'].'</div>
    </div>

    <div class="row">
    <div class="col-sm-4">Status Akun</div>
    <div class="col"> : '.$DataUser['status'].'</div>
    </div>
   
    </div>
    <div class="col text-center">';
    if(!file_exists('./uploads/user/'.$DataUser['foto'])){ 
      echo '<img style="width:130px; height: 130px;  border:3px solid #FFF;" src="'.base_url('uploads/user/no_profile.jpg').'" img="" class=" img rounded-circle" >';    
      }else{ 
      if($DataUser['foto'] != NULL){ 
        echo '<img style="width:130px; height: 130px;  border:3px solid #FFF;" src="'.base_url('uploads/user/'.$DataUser['foto']).'" img="" class="img rounded-circle mb-3" >';    
      }else{ 
      echo '<img style="width:130px; height: 130px;  border:3px solid #FFF;" src="'.base_url('uploads/user/no_profile.jpg').'" img="" class="img rounded-circle" >';        
      }  
      
      } 
      
    echo '</div>
    </div>
    <hr>
    <div class="row">
    <div class="col text-center">
     <div class="card">
     Jumlah Pekerjaan yang diselesaikan
    <div class="card-footer">'.$TotDataPekerjaan.'</div>
    </div>
   </div>
   <div class="col text-center">
   <div class="card">
   Jumlah Dokumen Penunjang yang diselesaikan
  <div class="card-footer">'.$TotJumlahLampiran.'</div>
  </div>
 </div>
  
 <div class="col text-center">
 <div class="card">
 Jumlah Dokumen Utama Yang diselesaikan
<div class="card-footer">'.$TotJumlahUtama.'</div>
</div>
</div>
</div>
<hr>
<div class="row">
<div class="col">
<p class="text-center">Update User</p>
<hr>
<form id="FormUpdateUser">
 <input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="form-control required"  accept="text/plain">
 <input type="hidden" name="no_user" value="'.$input['no_user'].'" readonly="" class="form-control required"  accept="text/plain">
 <label>Username</label>
 <input type="text" disabled name="username" value="'.$DataUser['username'].'" class=" username form-control form-control-sm" id="username" placeholder="Username ">
 <label>Nama Lengkap</label>
 <input type="text" name="nama_lengkap" value="'.$DataUser['nama_lengkap'].'" class="nama_lengkap form-control form-control-sm" id="nama_lengkap" placeholder="Nama Lengkap ">
 
 <label>Email</label>
 <input type="text" name="email" value="'.$DataUser['email'].'" class="email form-control form-control-sm" id="email" placeholder="Email ">
 <label>Phone</label>
 <input type="text" name="phone" value="'.$DataUser['phone'].'" class="phone form-control form-control-sm" id="phone" placeholder="Phone ">
 

 <label>Level</label>
 <select name="level" class="level form-control form-control-sm" id="level">
 <option value="User">User</option>
 <option value="Admin">Admin</option>
 <option Value="Super Admin">Super Admin</option>
 </select>
 
 
 <label>Status</label>
 <select name="status"  class=" status form-control form-control-sm" id="status">
 <option value="Aktif">Aktif</option>
 <option Value="Tidak Aktif">Tidak Aktif</option>
 </select>

 <label>Password</label>
 <input type="password" name="password1" id="password1" class="password1 form-control form-control-sm" placeholder="Masukan Password ">
 <label>Ulangi Password</label>
 <input type="password" name="password2" id="password2" class="password2 form-control form-control-sm" placeholder="Ulangi Password ">
 
<hr>
<button type="button" onclick="UpdateUser();" class="btn btn-sm btn-success btn-block">Update User <span class="fa fa-save"></span></button>
</form>
</div>
<div class="col">
<p class="text-center">Update Sublevel</p>
<hr>
<form id="FormSubLevel">
<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="form-control required"  accept="text/plain">
<input type="hidden" name="no_user" value="'.$input['no_user'].'" readonly="" class="form-control required"  accept="text/plain">
 <label>Pilih Pekerjaan yang dikerjakan</label>    
<select name="sublevel" id="sublevel" class="form-control form-control-sm sublevel">
    <option value="Level 1" >Pengurus Admin </option>    
    <option value="Level 2" >Pengurus Dokumen Utama </option>    
    <option value="Level 3" >Pengurus Dokumen Perizinan </option>    
    <option value="Level 4" >Pengurus Data Arsip</option>    
</select>
<hr>
<button type="button" onclick=SimpanSubLevel("'.$input['no_user'].'"); class="btn btn-success btn-sm btn-block">Simpan Pekerjaan <span class="fa fa-save"></span></button>
</form>
<hr>';

echo "<table class='table table-striped table-hover table-sm'><tr>
<td>Tugas Pekerjaan</td>
<td class='text-center'>Aksi</td>
</tr>";
foreach ($Sublevel->result_array() as $d){
if($d['sublevel'] =="Level 1"){
  echo "<tr><td>Pengurus Admin</td>
  <td class='text-center'><button onclick=hapus_sublevel('".$d['id_sublevel_user']."','".$input['no_user']."') class='btn btn-sm btn-danger'><span class='fa fa-trash'></span></button></td>
  </tr>";
  
}else if($d['sublevel'] =="Level 2"){
  echo "<tr><td>Pengurus Dokumen Utama</td>
  <td class='text-center'><button onclick=hapus_sublevel('".$d['id_sublevel_user']."','".$input['no_user']."') class='btn btn-sm btn-danger'><span class='fa fa-trash'></span></button></td>
  </tr>";
  
}else if($d['sublevel'] =="Level 3"){
  echo "<tr><td>Pengurus Dokumen Perizinan</td>
  <td class='text-center'><button onclick=hapus_sublevel('".$d['id_sublevel_user']."','".$input['no_user']."') class='btn btn-sm btn-danger'><span class='fa fa-trash'></span></button></td>
  </tr>";
  
}else if($d['sublevel'] =="Level 4"){
  echo "<tr><td>Pengurus Data Arsip</td>
  <td class='text-center'><button onclick=hapus_sublevel('".$d['id_sublevel_user']."','".$input['no_user']."') class='btn btn-sm btn-danger'><span class='fa fa-trash'></span></button></td>
  </tr>";
  
}

}
echo "</table>";

echo '</div>
</div>
</div>

<div class="modal-footer">
    <button type="button"';
    if($TotDataPekerjaan == 0 ){
      echo 'onclick=HapusUser("'.$input['no_user'].'")'; 
      }else{
      echo "disabled";  
      }
    echo ' class="btn btn-block  btn-sm btn-danger" id="simpan_user">Hapus User <span class="fa fa-trash"></span></button> 
    </form>
    </div>
</div>
</div>
    
    '; 
 }else{
 redirect(404);  
 }
} 

public function UpdateUser(){
  if($this->input->post()){
  $input = $this->input->post();
  $this->form_validation->set_rules('nama_lengkap', 'nama_lengkap', 'required',array('required' => 'Data ini tidak boleh kosong'));
  $this->form_validation->set_rules('email', 'email', 'required|valid_email',array('required' => 'Data ini tidak boleh kosong'));
  $this->form_validation->set_rules('phone', 'phone', 'required',array('required' => 'Data ini tidak boleh kosong'));
  $this->form_validation->set_rules('level', 'level', 'required',array('required' => 'Data ini tidak boleh kosong'));
  $this->form_validation->set_rules('status', 'status', 'required',array('required' => 'Data ini tidak boleh kosong'));
  $this->form_validation->set_rules('password1', 'password1', 'required',array('required' => 'Data ini tidak boleh kosong'));
  $this->form_validation->set_rules('password2', 'password2', 'required',array('required' => 'Data ini tidak boleh kosong'));
  
  if ($this->form_validation->run() == FALSE){
  $status_input = $this->form_validation->error_array();
  $status[] = array(
  'status'  => 'error_validasi',
  'messages'=>array($status_input),    
  );
  echo json_encode($status);
  }else{
  if($input['password1'] != $input['password2']){
    $status[] = array(
      'status'  => 'error_validasi',
      'messages'=>[array('password1'=>'Password yang dimasukan tidak sama','password2'=>'Password yang dimasukan tidak sama')],    
      );
      echo json_encode($status);
  }else{
    $data = array(
      'nama_lengkap' => $input['nama_lengkap'],
      'level'        => $input['level'],
      'status'       => $input['status'],
      'email'        => $input['email'],
      'phone'        => $input['phone'],
      'password'     => md5($input['password1'])
      );
  $this->M_dashboard->UpdateUser($data,$input['no_user']);     
      $status[] = array(
        "status"    =>"success",
        "messages"  =>'User Berhasil Di Perbaharui'
        );
        echo json_encode($status);
  }
 }
}else{
 redirect("404"); 
} 
} 

public function SimpanSubLevel(){
  if($this->input->post()){
  $input = $this->input->post();
  $data = array(
  'no_user'	  =>$input['no_user'],
  'sublevel'	=>$input['sublevel'],
  );
  $query = $this->db->get_where('sublevel_user',$data);
  if($query->num_rows() == 0){
  $status[] = array(
  "status"     => "success",
  "messages"      => "Sublevel berhasil disimpan"    
  );
  $this->db->insert('sublevel_user',$data);
  }else{
  $status[] = array(
  "status"     => "warning",
  "messages"      => "Sublevel Jenis Tersebut Sudah Ditambahkan"    
  );
  }
  echo json_encode($status);
  }else{
  redirect(404);	
  }
  }

 public function HapusUser(){
if($this->input->post()){
 $input = $this->input->post();

$this->db->delete('user',array('no_user'=>$input['no_user']));
$status[] = array(
  "status"     => "success",
  "messages"      => "User Berhasil Dihapus"    
  );
  
  echo json_encode($status);

}else{
 redirect("404"); 
}
}

public function DetailClient(){
  $data_client      = $this->M_dashboard->data_client_where($this->uri->segment(3));
  
  $this->load->view('umum/V_header');
  $this->load->view('dashboard/V_DetailClient',['DataClient'=>$data_client]);
  }
  function data_perekaman_utama(){
if($this->input->post()){
    $input              = $this->input->post();
    $data_utama = $this->M_dashboard->DataDokumenUtama($input['id_data_dokumen_utama']);
    $data = $data_utama->row_array();
    echo '<div class="modal-content ">
    <div class="modal-header">
    <h6 class="modal-title" id="exampleModalLabel text-center">'.$data['nama_berkas'].'<span class="i"><span></h6>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body">';
    echo "<table class='table table-hover table-sm table-stripped table-bordered'>";
    echo "<tr><td class='text-center' colspan='2'>".$data['nama_client']."</td></tr>";
    foreach($data_utama->result_array() as $d){
    echo "<tr><td>Jenis</td>";    
    echo "<td>".$d['jenis']."</td></tr>";    
    echo "<tr><td>Tanggal Akta</td>";    
    echo "<td>".$d['tanggal_akta']."</td></tr>";    
    }
    echo"</table></div>";
    echo"<div class='card-footer'>";
    $ext = pathinfo($data['nama_file'], PATHINFO_EXTENSION);
  
    if($ext =="docx" || $ext =="doc" ){
    echo "<button onclick=download_utama('".base64_encode($data['id_data_dokumen_utama'])."') class='btn btn-success btn-sm mx-auto btn-block '>Lihat Dokumen <i class='fa fa-eye'></i></button>";
    }else if($ext == "xlx"  || $ext == "xlsx"){
    echo "<button onclick=download_utama('".base64_encode($data['id_data_dokumen_utama'])."') class='btn btn-success btn-sm mx-auto btn-block '>Lihat Dokumen <i class='fa fa-eye'></i></button>";
    }else if($ext == "PDF"  || $ext == "pdf"){
    echo "<button onclick=lihat_pdf('".$data['nama_folder']."','".$data['nama_file']."'); class='btn btn-success btn-sm mx-auto btn-block '>Lihat Dokumen <i class='fa fa-eye'></i></button>";
    }else if($ext == "JPG"  || $ext == "jpg" || $ext == "png"  || $ext == "PNG"){
    echo "<button onclick=lihat_gambar('".$data['nama_folder']."','".$data['nama_file']."');  class='btn btn-success btn-sm mx-auto btn-block '>Lihat File <i class='fa fa-eye'></i></button>";
    }else{
    echo "<button onclick=download_utama('".base64_encode($data['id_data_dokumen_utama'])."') class='btn btn-success btn-sm mx-auto btn-block '>Lihat File <i class='fa fa-eye'></i></button>";
    }
    echo "</div></div>";
    
    }else{
    redirect(404);    
    }
}
public function buat_laporan(){
 if($this->input->post()){
     $input = $this->input->post();

$tanggal = $this->input->post('daterange');
$range = explode(' ', $tanggal);
$range1 = $range[0];
$range2 = $range[2];

if($this->input->post('output') == "Pdf"){

$this->buat_laporan_pdf($range1, $range2,$input);
}else{
$this->buat_laporan_excel($range1, $range2,$input);    
}    
   
}else{
     redirect(404);   
 }   
}

public function buat_laporan_pdf(){
echo "maaf fungsi laporan pdf ini belum tersedia";    
}

public function buat_laporan_excel($range1,$range2,$input){
    
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

if($input['jenis_laporan'] == "Pekerjaan"){
$data_pekerjaan = $this->M_dashboard->laporan_pekerjaan($range1,$range2,$input);
if($data_pekerjaan->num_rows() == 0){
echo "Tidak Ada Data Rentang Waktu Tersebut";  
}else{
$static = $data_pekerjaan->row_array();
$judul = array("Laporan Jenis ".$input['jenis_laporan']." Milik Asisten".$static['nama_lengkap']." Periode ".$range1." Sampai ".$range2); 
$sheet->fromArray([$judul], NULL, 'A1')->mergeCells('A1:H1');

$header = array("No ","Nama Pekerjaan","Nama Client","Tanggal  Pekerjaan","Tanggal Selesai","Status", "Dokumen Utama","Dokumen Penunjang");
$sheet->fromArray([$header], NULL, 'A2');
$no =3;
$h =1;
foreach ($data_pekerjaan->result_array() as $pekerjaan){
$jumlah_penunjang           = $this->db->get_where('data_berkas',array('no_pekerjaan'=>$pekerjaan['no_pekerjaan'],'no_pekerjaan !='=>NULL,'no_nama_dokumen !='=>NULL))->num_rows();
$jumlah_utama               = $this->db->get_where('data_dokumen_utama',array('no_pekerjaan'=>$pekerjaan['no_pekerjaan']))->num_rows();   

$dataarray = array(
$h++,    
$pekerjaan['nama_jenis'],    
$pekerjaan['nama_client'],    
$pekerjaan['tanggal_dibuat'],    
$pekerjaan['tanggal_selesai'],    
$pekerjaan['status_pekerjaan'],
$jumlah_utama,
$jumlah_penunjang    
);    
$sheet->fromArray([$dataarray], NULL, 'A'.$no++.'');    
}
$writer = new Xlsx($spreadsheet);
ob_end_clean();
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="Laporan Jenis '.$input['jenis_laporan'].' '.$static['nama_lengkap'].'.xlsx"');
header("Pragma: no-cache");
header("Expires: 0");
$writer->save('php://output');
}
}else if($input['jenis_laporan'] == "Dokumen Utama"){
$data_utama = $this->M_dashboard->laporan_utama($range1,$range2,$input);
if($data_utama->num_rows() == 0){
echo "Tidak Ada Data Rentang Waktu Tersebut";  
}else{
$static = $data_utama->row_array();
$judul = array("Laporan Jenis ".$input['jenis_laporan']." Milik Asisten".$static['nama_lengkap']." Periode ".$range1." Sampai ".$range2); 
$sheet->fromArray([$judul], NULL, 'A1')->mergeCells('A1:G1');

$header = array("No ","Nama Dokumen","Nama Client","Jenis Pekerjaan","Jenis File","No Akta ", "Tanggal Akta");
$sheet->fromArray([$header], NULL, 'A2');
$no =3;
$h =1;
foreach ($data_utama->result_array() as $utama){

$dataarray = array(
$h++,    
$utama['nama_berkas'],    
$utama['nama_client'],    
$utama['nama_jenis'],    
$utama['jenis'],    
$utama['no_akta'],
$utama['tanggal_akta'],
);    
$sheet->fromArray([$dataarray], NULL, 'A'.$no++.'');    
}
$writer = new Xlsx($spreadsheet);
ob_end_clean();
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="Laporan Jenis '.$input['jenis_laporan'].' '.$static['nama_lengkap'].'.xlsx"');
header("Pragma: no-cache");
header("Expires: 0");
$writer->save('php://output');
}
}else if($input['jenis_laporan'] == "Dokumen Pendukung"){
$data_pendukung = $this->M_dashboard->laporan_pendukung($range1,$range2,$input);
if($data_pendukung->num_rows() == 0){
echo "Tidak Ada Data Rentang Waktu Tersebut";  
}else{
$static = $data_pendukung->row_array();
$judul = array("Laporan Jenis ".$input['jenis_laporan']." Milik Asisten".$static['nama_lengkap']." Periode ".$range1." Sampai ".$range2); 
$sheet->fromArray([$judul], NULL, 'A1')->mergeCells('A1:D1');

$header = array("No ","Nama Berkas","Jenis Dokumen","Jenis Pekerjaan");
$sheet->fromArray([$header], NULL, 'A2');
$no =3;
$h =1;
foreach ($data_pendukung->result_array() as $utama){

$dataarray = array(
$h++,    
$utama['nama_berkas'],    
$utama['nama_dokumen'],    
$utama['nama_jenis']
);    
$sheet->fromArray([$dataarray], NULL, 'A'.$no++.'');    
}
$writer = new Xlsx($spreadsheet);
ob_end_clean();
header('Content-type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="Laporan Jenis '.$input['jenis_laporan'].' '.$static['nama_lengkap'].'.xlsx"');
header("Pragma: no-cache");
header("Expires: 0");
$writer->save('php://output');
  
}
}
}

function ShowGrafik(){    
$this->db->select('user.nama_lengkap,'
        . 'user.no_user,'
        . 'user.username');
$this->db->where('user.level','User');
$this->db->where('user.status','Aktif');
$this->db->where('sublevel_user.sublevel','Level 2');
$this->db->from('user');
$this->db->join('sublevel_user', 'sublevel_user.no_user = user.no_user');
$namaasisten = $this->db->get();

$data_asisten = array();
$jumlah_berkas = array();
$jumlah_pekerjaan = array();

foreach ($namaasisten->result()  as $as) {
$data_asisten[] = $as->nama_lengkap;
}

foreach ($namaasisten->result()  as $as) {
$BerkasMilikAsisten = $this->M_dashboard->BerkasMilikAsisten($as->no_user)->num_rows();
$jumlah_berkas[] = $BerkasMilikAsisten;
}

foreach ($namaasisten->result()  as $as) {
$PekerjaanMilikAsisten = $this->M_dashboard->PekerjaanMilikAsisten($as->no_user)->num_rows();
$jumlah_pekerjaan[] = $PekerjaanMilikAsisten;
}

$data = array(
'asisten'   =>$data_asisten,    
'jumlah'    =>$jumlah_berkas,
'pekerjaan' =>$jumlah_pekerjaan    
);

echo json_encode($data);    
}

public function ShowGrafikBerkas(){
if($this->input->post()){
$input = $this->input->post();
if($this->input->post('range')){
$tanggal        = $this->input->post('range');
$range          = explode(' ', $tanggal);
$awal           = $range[0];
$akhir          = $range[2];

}else{
$akhir   = date('Y/m/d');
$c       = strtotime($akhir);
$awal    = date("Y/m/d", strtotime("-1 month", $c));
}

$this->db->select('data_berkas.tanggal_upload');
$this->db->group_by('data_berkas.tanggal_upload');
$this->db->where('data_berkas.tanggal_upload >=', $awal);
$this->db->where('data_berkas.tanggal_upload <=', $akhir);
$this->db->from('data_berkas');
$query = $this->db->get();

$data_tanggal = array();
$data_jumlah  = array();

foreach ($query->result_array() as $t){
$jumlah = $this->db->get_where('data_berkas',array('tanggal_upload'=>$t['tanggal_upload']))->num_rows(); 
$data_jumlah[]  = $jumlah;    
$data_tanggal[] = $t['tanggal_upload'];     
}

$data = array(
'tanggal' =>$data_tanggal,
'jumlah'  =>$data_jumlah,    
);

echo json_encode($data);

}else{
redirect(404);    
}
}

function ShowGrafikPerizinan(){    
$this->db->select('user.nama_lengkap,'
        . 'user.no_user,'
        . 'user.username');
$this->db->where('user.level','User');
$this->db->where('user.status','Aktif');
$this->db->where('sublevel_user.sublevel','Level 3');
$this->db->from('user');
$this->db->join('sublevel_user', 'sublevel_user.no_user = user.no_user');
$namaasisten = $this->db->get();

$jumlah_perizinan = array();
$nama              = array();
foreach ($namaasisten->result()  as $as) {
$JumlahPerizinan      = $this->M_dashboard->PekerjaanMilikPerizinan($as->no_user)->num_rows();
$jumlah_perizinan[]   = $JumlahPerizinan;
$nama[]               = $as->nama_lengkap;

}

$data = array(
'nama'   =>$nama,
'jumlah'  =>$jumlah_perizinan,    
);

echo json_encode($data);

}

}
