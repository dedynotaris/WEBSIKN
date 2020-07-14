<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH.'libraries/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

class Data_lama extends CI_Controller{
public function __construct() {
parent::__construct();
$this->load->helper('download');
$this->load->library('session');
$this->load->model('M_data_lama');
$this->load->library('Datatables');
$this->load->library('upload');
$this->load->library('form_validation');
$this->load->library('Breadcrumbs');

if(!$this->session->userdata('username')){
redirect(base_url('Menu'));
}
}

public function index(){
$nama_notaris = $this->M_data_lama->nama_notaris();
$this->load->view('umum/V_header');
$this->load->view('data_lama/V_data_lama',['nama_notaris'=>$nama_notaris]);
}


public function BuatArsip(){
        
    $this->breadcrumbs->push('Beranda', '/Data_lama');
    $this->breadcrumbs->push('Membuat Arsip Pekerjaan', '/Data_lama/BuatArsip');  

        $nama_notaris = $this->M_data_lama->nama_notaris();
        $this->load->view('umum/V_header');
        $this->load->view('data_lama/V_BuatArsip',['nama_notaris'=>$nama_notaris]);
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

public function DataArsipClient(){

$query = $this->M_data_lama->data_pekerjaan_arsip('ArsipMasuk');

$this->breadcrumbs->push('Beranda', '/Data_lama');
$this->breadcrumbs->push('Membuat Arsip Pekerjaan', '/Data_lama/BuatArsip');  
$this->breadcrumbs->push('Daftar Arsip Masuk', '/Data_lama/DataArsipClient');  


$this->load->view('umum/V_header');
$this->load->view('data_lama/V_DataArsipClient',['query'=>$query]);    
}

public function DataArsipProses(){

        $this->breadcrumbs->push('Beranda', '/Data_lama');
        $this->breadcrumbs->push('Membuat Arsip Pekerjaan', '/Data_lama/BuatArsip');  
        $this->breadcrumbs->push('Daftar Arsip Masuk', '/Data_lama/DataArsipClient');  
        $this->breadcrumbs->push('Daftar Arsip Proses', '/Data_lama/DataArsipProses');  
        

$query = $this->M_data_lama->data_pekerjaan_arsip('ArsipProses');
$this->load->view('umum/V_header');
$this->load->view('data_lama/V_DataArsipProses',['query'=>$query]);    
}

public function DataArsipSelesai(){

        $this->breadcrumbs->push('Beranda', '/Data_lama');
        $this->breadcrumbs->push('Membuat Arsip Pekerjaan', '/Data_lama/BuatArsip');  
        $this->breadcrumbs->push('Daftar Arsip Masuk', '/Data_lama/DataArsipClient');  
        $this->breadcrumbs->push('Daftar Arsip Proses', '/Data_lama/DataArsipProses');  
        $this->breadcrumbs->push('Daftar Arsip Selesai', '/Data_lama/DataArsipSelesasi');  
        
        
$query = $this->M_data_lama->data_pekerjaan_arsip('ArsipSelesai');
$this->load->view('umum/V_header');
$this->load->view('data_lama/V_DataArsipSelesai',['query'=>$query]);    
}

public function perorangan(){

        $this->breadcrumbs->push('Beranda', '/Data_lama');
        $this->breadcrumbs->push('Daftar Arsip Perorangan', '/Data_lama/Perorangan');          
$this->load->view('umum/V_header');
$this->load->view('data_lama/V_data_arsip_perorangan');    
}

public function badan_hukum(){

        $this->breadcrumbs->push('Beranda', '/Data_lama');
        $this->breadcrumbs->push('Daftar Arsip Badan Hukum', '/Data_lama/badan_hukum');  

$this->load->view('umum/V_header');
$this->load->view('data_lama/V_data_arsip_badan_hukum');    
}

public function rekam_data(){
        $this->breadcrumbs->push('Beranda', '/Data_lama');
        $this->breadcrumbs->push('Membuat Arsip Pekerjaan', '/Data_lama/BuatArsip');  
        $this->breadcrumbs->push('Daftar Arsip Masuk', '/Data_lama/DataArsipClient');  
        $this->breadcrumbs->push('Daftar Arsip Proses', '/Data_lama/DataArsipProses');  
        $this->breadcrumbs->push('Upload Dokumen Arsip', '/Data_lama/rekam_data');  
        


$no_pekerjaan       = base64_decode($this->uri->segment(3));    
$query              = $this->M_data_lama->data_persyaratan($no_pekerjaan);
$this->load->view('umum/V_header');
$this->load->view('data_lama/V_rekam_data',['query'=>$query]);        
}

public function json_data_berkas(){
echo $this->M_data_lama->json_data_berkas();       
}

public function JsonDataPekerjaanArsipSelesai(){
echo $this->M_data_lama->JsonDataPekerjaanArsipSelesai();       
}

public function json_data_berkas_client($no_client){
echo $this->M_data_lama->json_data_berkas_client($no_client);  
}
public function json_data_lampiran_client($no_client){
echo $this->M_data_lama->json_data_lampiran_client($no_client);  
}

public function json_data_utama_client($no_client){
echo $this->M_data_lama->json_data_utama_client($no_client);  
}

public function json_data_pekerjaan_client($no_client){
echo $this->M_data_lama->json_data_pekerjaan_client($no_client);  
}

public function json_daftar_lemari(){
echo $this->M_data_lama->json_daftar_lemari();  
}

public function json_daftar_pekerjaan_selesai(){
echo $this->M_data_lama->json_daftar_pekerjaan_selesai();  
}
public function json_daftar_arsip(){
echo $this->M_data_lama->json_daftar_arsip();  
}
public function json_daftar_arsip_pinjam(){
echo $this->M_data_lama->json_daftar_arsip_pinjam();  
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

function cari_nama_client(){
        if($this->input->post()){
        $search         = strtolower($this->input->post('search'));
        $jenis_client   = strtolower($this->input->post('jenis_client'));
        
        $query = $this->M_data_lama->cari_jenis_client($search,$jenis_client);
        if($query->num_rows() >0 ){
        foreach ($query->result_array() as $d) {
        $json[]= array(
        'text'                    => $d['nama_client'],   
        'id'                      => $d['no_client'],
        'no_identitas'            => $d['no_identitas']    
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
        }else{
        redirect(404);    
        }
            
        }


        function cari_kontak(){
    
                $term  = strtolower($this->input->post('search'));
                $query = $this->M_data_lama->cari_kontak($term);
                if($query->num_rows() >0 ){
                foreach ($query->result() as $d) {
                $json[] = array(
                'text'                          => $d->nama_kontak,   
                'id'                            => $d->id_kontak,
                'no_kontak'                     => $d->no_kontak,
                'email'                         => $d->email,
                'jabatan'                       => $d->jabatan,
                    
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
                function cari_dokumen(){
    
                        $term  = strtolower($this->input->post('search'));
                        $query = $this->M_data_lama->cari_dokumen($term);
                        
                        if($query->num_rows() >0 ){
                        foreach ($query->result() as $d) {
                        $json[] = array(
                        'text'                          => $d->nama_dokumen,   
                        'id'                            => $d->no_nama_dokumen,
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

public function cari_jenis_pekerjaan(){
$term = strtolower($this->input->post('search'));    
$query = $this->M_data_lama->cari_jenis_pekerjaan($term);
if($query->num_rows() >0){
foreach ($query->result() as $d) {
$json[]= array(
'text'                    => $d->nama_jenis,   
'id'                      => $d->no_jenis_pekerjaan,
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

function SimpanArsip(){
        $input = $this->input->post();

        $this->form_validation->set_rules('jenis_pekerjaan', 'Jenis Pekerjaan', 'required',array('required' => 'Data ini tidak boleh kosong'));
        $this->form_validation->set_rules('nama_client', 'Nama Client', 'required',array('required' => 'Data ini tidak boleh kosong'));
        $this->form_validation->set_rules('target_selesai', 'Target Selesai', 'required',array('required' => 'Data ini tidak boleh kosong'));
        $this->form_validation->set_rules('nama_asisten', 'Nama Asisten', 'required',array('required' => 'Data ini tidak boleh kosong'));
        
        if ($this->form_validation->run() == FALSE){
        $status_input = $this->form_validation->error_array();
        $status[] = array(
        'status'   => 'error_validasi',
        'messages' => array($status_input),    
        );
        echo json_encode($status);
        
        }else{
                
$input = $this->input->post();
//Membuat Penomoran pekerjaan//

$this->db->limit(1);
$this->db->order_by('data_pekerjaan.no_pekerjaan','desc');
$h_pekerjaan       = $this->db->get('data_pekerjaan')->row_array();


if(isset($h_pekerjaan['no_pekerjaan'])){
$pekerjaan =  (int) substr($h_pekerjaan['no_pekerjaan'],1)+1;
}else{
$pekerjaan = 1;
}

$no_pekerjaan   = "P".str_pad($pekerjaan,6 ,"0",STR_PAD_LEFT);

$data_r = array(
        'no_client'          => $input['nama_client'],    
        'status_pekerjaan'   => "ArsipMasuk",
        'no_pekerjaan'       => $no_pekerjaan,    
        'tanggal_dibuat'     => date('Y/m/d'),
        'no_jenis_pekerjaan' => $input['jenis_pekerjaan'],   
        'target_kelar'       => date('Y/m/d'),
        'no_user'            => $this->session->userdata('no_user'),    
        'pembuat_pekerjaan'  => $input['nama_asisten'],    
        );

      $this->db->insert('data_pekerjaan',$data_r);

        $data_pem = array(
        'no_client'     =>$input['nama_client'],
        'no_pekerjaan'  =>$no_pekerjaan    
        );
        $this->db->insert('data_pemilik',$data_pem);

                
        $status[] = array(
                "status"       => "success",
                "messages"     =>"Arsip baru berhasil dibuat",
                "no_pekerjaan" => $no_pekerjaan,   
                );    
                echo json_encode($status);    

}

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



function data_para_pihak(){
if($this->input->post()){
$input = $this->input->post();
$data_pihak = $this->M_data_lama->data_para_pihak($input['no_pekerjaan']);
$h=1;
echo "<table class='table table-striped'>"
. "<tr class='text-center text-info'>"
. "<td>No</td>"
. "<td>Nama Pihak Terlibat</td>"
. "<td>Aksi</td>"
. "</tr>";
if($data_pihak->num_rows() > 1 ){
foreach ($data_pihak->result_array() as $data){
if($input['no_client'] != $data['no_client']){
echo "<tr>";
echo "<td align='center'>".$h++."</td>";
echo "<td>".$data['nama_client']."</td>";
echo "<td style='width:30%;'><button onclick=tampilkan_form('".$data['no_client']."','".$input['no_pekerjaan']."'); class='btn btn-block  btn-dark btn-sm' title='Upload Penunjang'>Penunjang <span class='fa fa-upload'></span> </button>";
//echo  "<button  onclick=tampilkan_form_utama('".$data['no_client']."','".$input['no_pekerjaan']."'); class='btn  btn-block btn-dark btn-sm   ' title='Rekam dokumen utama ".$data['nama_client']."'>Rekam Utama <span class='fa fa-plus'></span> </button>";
echo  "<button onclick=form_edit_client('".$data['no_client']."','".$input['no_pekerjaan']."'); class='btn  btn-block btn-dark  btn-sm' title='Detail Client'> Detail Client <span class='fa fa-user'></span></button>";
echo  "<button onclick=hapus_keterlibatan('".$data['no_client']."','".$input['no_pekerjaan']."'); class='btn  btn-block btn-danger  btn-sm' title='Hapus keterlibatan '> Hapus <span class='fa fa-trash'></span></button>";
}
echo "</td></tr>";
}

}else{
echo "<tr><td align='center' colspan='3'>Pihak Terlbiat Belum Dimasukan <br> Untuk Menambahkan Silahkan Cari Pihak Terlibat dahulu</td></tr>";    
}

echo "</table>";
}else{
redirect(404);    
}
}

//FUNCTION/METHOD BARU 

function form_edit_client(){
if($this->input->post()){    

$input              = $this->input->post(); 
$data_kontak        = $this->M_data_lama->data_kontak_client($input['no_client']);
$data_client        = $this->M_data_lama->data_client_where($input['no_client'])->row_array();

echo '<div class="modal-content">
<div class="modal-header bg-info">
<h6 class="modal-title text-white" >Detail Client '.ucwords(strtolower($data_client['nama_client'])).' <span id="title"></span> </h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body " >
<div class="row">
<div class="col-md-4">';
echo'<form id="form_update_client">
<input type="hidden" name="'.$this->security->get_csrf_token_name().'"value="'.$this->security->get_csrf_hash().'" readonly="" class="form-control required"  accept="text/plain">
<input type="hidden" name="no_client" value="'.$data_client['no_client'].'" readonly="" class="form-control required"  accept="text/plain">
<label>Pilih Jenis client</label>
<select name="jenis_client" id="jenis_client" class="form-control required" accept="text/plain">
<option></option>
<option ';if($data_client['jenis_client'] == "Perorangan"){echo "selected ";} echo' value="Perorangan">Perorangan</option>
<option ';if($data_client['jenis_client'] == "Badan Hukum"){echo "selected ";}echo 'value="Badan Hukum">Badan Hukum</option>	
</select>    

<label  id="label_nama_perorangan">Nama </label>
<input type="text" value="'.$data_client['nama_client'].'" placeholder="Nama" name="badan_hukum" id="badan_hukum" class="form-control  required"  accept="text/plain">

<label  id="label_nama_perorangan">No Identitas </label>
<input type="text" value="'.$data_client['no_identitas'].'" placeholder="No Identitas" name="no_identitas" id="no_identitas" class="form-control  required"  accept="text/plain">

<label  id="label_alamat_perorangan">Alamat </label>
<textarea  rows="6" placeholder="Alamat" name="alamat" id="alamat" class="form-control  required" required="" accept="text/plain">'.$data_client['alamat_client'].'</textarea>

<label >Nomor Kontak '.$data_client['jenis_client'].' </label>
<input type="text" value="'.$data_client['contact_number'].'" placeholder="contact number" name="contact_number" id="contact_number" class="form-control  required"  accept="text/plain">

<label >Email Client '.$data_client['jenis_client'].' </label>
<input type="text" value="'.$data_client['email'].'" placeholder="Email" name="email" id="email" class="form-control  required"  accept="text/plain">

</div>';

echo "<div class='col'>";

echo '<table class="table  table-striped">
<thead>
    <tr><td align="center" colspan="5">Data Kontak</td></tr>   
   <tr>
   <th>Nama</th>
   <th>Jabatan</th>
   <th>Email</th>
   <th>No Kontak</th>
   </tr>
</thead>
<tbody>';

foreach ($data_kontak->result_array() as $d){
            echo "<tr>"
            . "<td>".$d['nama_kontak']."</td>"
            . "<td>".$d['jabatan']."</td>"
            . "<td>".$d['email']."</td>"
            . "<td>".$d['no_kontak']."</td>"
           . "</tr>";
}
echo "</tbody></table>";
echo "</div></div>";
echo "</div>"
. "<div class='modal-footer'>"
. "<button onclick=update_client(); class='btn btn-md btn-dark update_client btn-block'>Simpan Perubahan <span class='fa fa-save'</button></form>"
. "</div>"
. "</div>";

}else{
redirect(404);  
}
}


public function update_client(){
if($this->input->post()){    
$input = $this->input->post();
$this->form_validation->set_rules('jenis_client', 'Jenis Client', 'required');
$this->form_validation->set_rules('badan_hukum', 'Badan Hukum', 'required');
if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);
echo json_encode($status);
}else{
$data = array(
'jenis_client'          =>$input['jenis_client'],
'nama_client'           =>$input['badan_hukum'],
'alamat_client'         =>$input['alamat'],    
'contact_number'        =>$input['contact_number'],    
'email'                 =>$input['email']    
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

function update_pekerjaan(){
if($this->input->post()){
$input = $this->input->post();
$this->form_validation->set_rules('jenis_pekerjaan', 'Jenis pekerjaan ', 'required');
if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);
echo json_encode($status);
}else{
$data = array(
'no_jenis_pekerjaan' =>$input['jenis_pekerjaan']
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
echo print_r($this->input->post());
//redirect(404);    
}    
}

function form_persyaratan(){
if($this->input->post()){    
$input                    = $this->input->post();

$data_lampiran            = $this->M_data_lama->data_lampiran_client($input['no_client']);
$data_client              = $this->M_data_lama->data_client_where($input['no_client'])->row_array();
echo '
<div class="modal-header bg-info">
<h6 class="modal-title text-white" id="exampleModalLabel">Upload Dokumen Penunjang Milik '.ucwords(strtolower($data_client['nama_client'])).'  <span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body overflow-auto"  style="max-heigth:300px;">';
echo "<div class='row'>"
."<div class='col'>"
."<form  class=' ' id='form_berkas'>"
."<input type='hidden' class='no_client' name='no_client'    value='".$input['no_client']."'>"
."<input type='hidden' class='no_pekerjaan' name='no_pekerjaan' value='".$input['no_pekerjaan']."'>";

echo '<div class="input-group">
  <div class="custom-file">
    <input onchange="upload_file()" type="file" class="custom-file-input"  id="file_berkas" name="file_berkas[]" multiple aria-describedby="file_berkas">
    <label class="custom-file-label" for="file_berkas">Pilih Dokumen Penunjang</label>
  </div>
 </div>';

echo '<div class="progress" style="display:none"> 
<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
</div>'
. "</form>";

echo '<div class="m-2 data_terupload"></div></div>';


echo  "<div class='col-md-4 '>
<div class='justify-content-start'>
<table class='table table-striped table-hover'>
<th colspan='2' class='text-center '>Dokumen Perusahaan yang dimiliki</th></tr>";
if($data_lampiran->num_rows() >0){
foreach($data_lampiran->result_array() as $data){
echo "<tr class='data".$data['no_berkas']."' onclick=FormLihatMeta('".$data['no_berkas']."','".$data['nama_folder']."','".$data['nama_berkas']."') class='text-info'>";
echo "<td colspan='2'  >".$data['nama_dokumen']."</td></tr>";
}
echo "<tr id='LihatSemua'><td><button onclick=LihatSemuaDokumen('".$input['no_client']."'); class='btn btn-sm btn-success btn-block'>Lihat Semua Dokumen <span class='fa fa-eye'></span></button></td></tr>";
}else{
echo "<tr ><td colspan='2' align='center' colspan='2'>Dokumen Perusahaan Tidak Tersedia</td></tr>";
echo "<tr id='LihatSemua'><td colspan='2'><button onclick=LihatSemuaDokumen('".$input['no_client']."'); class='btn btn-sm btn-success btn-block'>Lihat Semua Dokumen <span class='fa fa-eye'></span></button></td></tr>";
}

echo "</table>
</div>
</div>";
echo  "</div>";
echo '</div>';
echo "</div>";
echo'</div>';   
}else{
redirect(404);    
}
}
public function data_terupload(){
if($this->input->post()){    
$input              = $this->input->post();  
$data_upload        = $this->db->get_where('data_berkas',array('no_client'=>$input['no_client'],'no_pekerjaan'=> $input['no_pekerjaan'],'status_berkas !='=>'selesai'));
$data_client        = $this->M_data_lama->data_client_where($input['no_client'])->row_array();
                     
echo "<div class='row card-header rounded text-center'>"
. "<div class='col'><b>Dokumen Penunjang</div>"
. "<div class='col-md-5'>Jenis dokumen</div>"
. "<div class='col-md-2'>Aksi</b></div>"
. "</div>";
if($data_upload->num_rows() != 0){   
echo "<div class='DataLampiran '> ";
foreach ($data_upload->result_array() as $data){
echo "<div class='row  mt-1 text-dark card-footer data".$data['no_berkas']."'>";
echo "<div class='col'>".substr($data['nama_berkas'],0,28)."</div>";
echo "<div class='col-md-5'>"
. "<select onchange=set_jenis_dokumen('".$input['no_client']."','".$input['no_pekerjaan']."','".$data['no_berkas']."') class='form-control nama_dokumen  form-control-md no_berkas".$data['no_berkas']."'>";
echo "<option></option>";
echo "</select></div>";
echo '<div class="col-md-2 text-center">';
echo '<button  onclick=hapus_berkas_persyaratan("'.$data['no_berkas'].'"); class="btn btn-md mx-auto  btn-danger  btnhapus'.$data['no_berkas'].'"  title="Hapus data ini" ><i class="fa fa-trash"></i></button>';
echo '<button  onclick=LihatLampiran("'.$data_client['nama_folder'].'","'.$data['nama_berkas'].'"); class="btn btn-md mx-auto ml-3  btn-info   title="Lihat File" ><i class="fa fa-eye"></i></button>';
echo '</div>';
echo "</div>";    
}

echo "</div>";
}else{
echo "<div class='text-center  text-dark '>Belum Terdapat Dokumen Penunjang<br>Silahkan pilih dokumen penunjang terlebih dahulu</div>";    
}
}else{
redirect(404);    
}        
}

public function utama_terupload(){
        if($this->input->post()){    
        $input              = $this->input->post();  
       
        $this->db->select('data_dokumen_utama.nama_file,'
        . 'data_dokumen_utama.id_data_dokumen_utama,'
        . 'data_client.nama_folder');

        $this->db->from('data_dokumen_utama');
        $this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_dokumen_utama.no_pekerjaan');
        $this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
        $this->db->where('data_dokumen_utama.no_pekerjaan', $input['no_pekerjaan']);
        $this->db->where('data_dokumen_utama.jenis', '');
        $data_upload= $this->db->get();  
                              
        echo "<div class='row card-header rounded text-center'>"
        . "<div class='col'><b>Dokumen Utama</div>"
        . "<div class='col-md-5'>Jenis dokumen</div>"
        . "<div class='col-md-2'>Aksi</b></div>"
        . "</div>";
        if($data_upload->num_rows() != 0){   
        echo "<div class='DataLampiran '> ";
        foreach ($data_upload->result_array() as $data){
        echo "<div class='row  mt-1 text-dark card-footer data".$data['id_data_dokumen_utama']."'>";
        echo "<div class='col'>".substr($data['nama_file'],0,20)."</div>";
        echo "<div class='col-md-5'>"
        . "<select onchange=set_jenis_utama('".$input['no_pekerjaan']."','".$data['id_data_dokumen_utama']."'); class='form-control nama_dokumen  form-control-md no_utama".$data['id_data_dokumen_utama']."'>";
        echo "<option></option>";
        echo "<option>Salinan</option>";
        echo "<option>Minuta</option>";
        echo "<option>SKMHT</option>";
        echo "<option>APHT</option>";
        echo "</select></div>";
        echo '<div class="col-md-2 text-center">';
        echo '<button type="button"  onclick=hapus_utama("'.$data['id_data_dokumen_utama'].'"); class="btn btn-md mx-auto  btn-danger  btnhapus'.$data['id_data_dokumen_utama'].'"  title="Hapus data ini" ><i class="fa fa-trash"></i></button>';
        echo '<button type="button"  onclick=LihatLampiran("'.$data['nama_folder'].'","'.$data['nama_file'].'"); class="btn btn-md mx-auto ml-3  btn-info   title="Lihat File" ><i class="fa fa-eye"></i></button>';
        echo '</div>';
        echo "</div>";    
        }
        
        echo "</div>";
        }else{
        echo "<div class='text-center  text-dark '>Belum Terdapat Dokumen Penunjang<br>Silahkan pilih dokumen penunjang terlebih dahulu</div>";    
        }
        }else{
        redirect(404);    
        }        
        }

public function upload_berkas(){
$input = $this->input->post(); 
$data_client = $this->db->get_where('data_client',array('no_client'=>$input['no_client']))->row_array();
$status = array();

for($i =0; $i<count($_FILES); $i++){
$config['upload_path']          = './berkas/'.$data_client['nama_folder'];
$config['allowed_types']        = 'jpg|jpeg|png|pdf|docx|doc|xlxs|pptx|';
$config['encrypt_name']         = FALSE;
$config['max_size']             = 1000000000;
$this->upload->initialize($config);   

if (!$this->upload->do_upload('file_berkas'.$i)){  
$status[] = array(
"status"        => "error",
"messages"      => $this->upload->display_errors(),    
'name_file'     => $this->upload->data('file_name')
);
}else{
$lampiran = $this->upload->data();    
$this->simpan_data_persyaratan($input,$lampiran);
$status[] = array(
"status"        => "success",
"messages"      => "File berhasil di upload",
'name_file'     =>$this->upload->data('file_name')
);
}
}
echo json_encode($status);

}
public function simpan_data_persyaratan($input,$lampiran){
       $this->db->limit(1);
                        $this->db->order_by('data_berkas.no_berkas','desc');
                        $h_berkas       = $this->db->get('data_berkas')->row_array();
                        
                        if(isset($h_berkas['no_berkas'])){
                        $urutan = (int) substr($h_berkas['no_berkas'],10)+1;
                        }else{
                        $urutan =1;
                        }
        $no_berkas = "BK".date('Ymd' ).str_pad($urutan,10,0,STR_PAD_LEFT);
        
        
$data_berkas = array(
'no_berkas'         => $no_berkas,    
'no_client'         => $input['no_client'],    
'no_pekerjaan'      => $input['no_pekerjaan'],
'no_nama_dokumen'   => NULL,
'nama_berkas'       => $lampiran['file_name'],
'mime-type'         => $lampiran['file_type'],   
'Pengupload'        => $this->session->userdata('no_user'),
'tanggal_upload'    => date('Y/m/d' )
);    
$this->db->insert('data_berkas',$data_berkas); 
}

public function SimpanPenunjang(){
if($this->input->post()){
$input = $this->input->post();
foreach ($input as $key=>$value){
if($key != "ci_csrf_token"){
$this->form_validation->set_rules($key, $key, 'required',array('required' => 'Data ini tidak boleh kosong'));
}
}

if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);
echo json_encode($status);
}else{
        $data = array(
        'no_nama_dokumen' => $input['no_nama_dokumen'],
        'status_berkas'   =>'selesai'    
        );
        $this->db->update('data_berkas',$data,array('no_berkas'=>$input['no_berkas']));
               
                
                foreach ($input as $key=>$value){
                        if($key != "no_berkas" && $key != "ci_csrf_token" && $key !='no_pekerjaan' && $key !='no_client' && $key !='no_nama_dokumen'){
                        $data = array(
                                'no_berkas'=>$input['no_berkas'],    
                                'nama_meta'=>$key,   
                                'value_meta'=>$value    
                        );
                        $this->db->insert('data_meta_berkas',$data,array('no_berkas'=>$input['no_berkas']));
                        }
                }

                        $response [] =array(
                                'status'   =>'success',
                                'messages' =>'Dokumen Penunjang Disimpan'   
                                );
                                echo json_encode($response);
                
}
}else{
redirect(404);    
} 
}



public function hapus_berkas_persyaratan(){
if($this->input->post()){
$input = $this->input->post();
$data = $this->M_data_lama->hapus_berkas($input['no_berkas'])->row_array();
$filename = './berkas/'.$data['nama_folder']."/".$data['nama_berkas'];
if(file_exists($filename)){
unlink($filename);
}
$this->db->delete('data_berkas',array('no_berkas'=>$input['no_berkas']));    
$status[] = array(
"status"     => "success",
"messages"      => "Dokumen lampiran telah di hapus",    
);
echo json_encode($status);
}else{
redirect(404);    
} 



}


public function keluar(){
$this->session->sess_destroy();
redirect (base_url('Login'));
}

public function download_berkas(){
$data = $this->M_data_lama->data_berkas_where($this->uri->segment(3))->row_array();
$file_path = "./berkas/".$data['nama_folder']."/".$data['nama_berkas']; 
$info = new SplFileInfo($data['nama_berkas']);
force_download($data['nama_dokumen'].".".$info->getExtension(), file_get_contents($file_path));
}


function FormEditMetaDokumen($input){
$data_meta = $this->db->get_where('data_meta_berkas',array('no_berkas'=>$input['no_berkas']));    
echo "<div class='row  bg-info p-2 data_edit".$input['no_berkas']."'>"
. "<div class='col-md-6 text-white'>";
foreach ($data_meta->result_array()  as $d ){
echo str_replace('_', ' ',$d['nama_meta'])." : ".$d['value_meta'] ."<br>";   
}
echo "<hr>"
. "<button type='button' onclick=hapus_meta('".$input['no_berkas']."','".$input['no_nama_dokumen']."','".$input['no_client']."','".$input['no_pekerjaan']."') class='btn  btn-sm btn-warning btn-block '>Ubah Meta Dokumen <i class='fa fa-edit'></i></button>"
. "</form>"
. "</div></div>";
}
 
function FormMasukanMetaDokumen(){
$input = $this->input->post();        
if($this->input->post('no_nama_dokumen')){
$cek  = $this->db->get_where('data_berkas',array('no_client'=>$input['no_client'],'no_nama_dokumen'=>$input['no_nama_dokumen']));
if($cek->num_rows() > 0){
        $status[] = array(
                'status'  => 'warning',
                'messages'=> "Duplikasi Dokumen ",    
                );
                echo json_encode($status);
}else{

$data_meta = $this->M_data_lama->data_meta($input['no_nama_dokumen']);
$form = '<div class="modal-content">
<div class="modal-header bg-dark text-white">
<h6 class="modal-title" >Masukan Identifikasi File Untuk Mempermudah Pencarian</h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body " >';
$form .= "<form id='FormMeta'>";
$form .= '<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="required"  accept="text/plain">';
$form .= '<input type="hidden" name="no_berkas" value="'.$input['no_berkas'].'" readonly="" class="required"  accept="text/plain">';
$form .= '<input type="hidden" id="no_pekerjaan" name="no_pekerjaan" value="'.$input['no_pekerjaan'].'" readonly="" class="required"  accept="text/plain">';
$form .= '<input type="hidden" id="no_client" name="no_client" value="'.$input['no_client'].'" readonly="" class="required"  accept="text/plain">';
$form .= '<input type="hidden" name="no_nama_dokumen" value="'.$input['no_nama_dokumen'].'" readonly="" class="required"  accept="text/plain">';
foreach ($data_meta->result_array()  as $d ){
//INPUTAN SELECT   
if($d['jenis_inputan'] == 'select'){
$data_option = $this->db->get_where('data_input_pilihan',array('id_data_meta'=>$d['id_data_meta']));   
$form .= "<label>".$d['nama_meta']."</label>"
."<select id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' class='form-control form_meta form-control-md meta required' required='' accept='text/plain'>";
foreach ($data_option->result_array() as $option){
$form .= "<option ";

$form .= ">".$option['jenis_pilihan']."</option>";
}
$form.="</select>";
//INPUTAN DATE
}else if($d['jenis_inputan'] == 'date'){
$form .= "<label>".$d['nama_meta']."</label>"
."<input value=''  type='text' id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-md ".$d['jenis_inputan']." meta required ' required='' accept='text/plain' >";    
///INPUTAN NUMBER
}else if($d['jenis_inputan'] == 'number'){
$form .= "<label>".$d['nama_meta']."</label>"
."<input value='' type='text' id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-md ".$d['jenis_bilangan']." meta required ' required='' accept='text/plain' >";        
//INPUTAN TEXTAREA
}else if($d['jenis_inputan'] == 'textarea'){
$form .= "<label>".$d['nama_meta']."</label>"
. "<textarea  id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-md ".$d['jenis_bilangan']." meta required ' required='' accept='text/plain'></textarea>";
}else{
$form .= "<label>".$d['nama_meta']."</label>"
."<input  type='".$d['jenis_inputan']."' value='' id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-md  meta required ' required='' accept='text/plain' >";    
}


}
$form .="<hr>"
. "<button type='button' onclick=SimpanPenunjang() class='btn  btn-md btn-dark btn-block '>Simpan Penunjang <i class='fa fa-save'></i></button>"
. "</form>"
. "</div></div>";

$status[] = array(
'status'  => 'success',
'data'=> $form,    
);
echo json_encode($status);  
} 
}else{
    
$status[] = array(
'status'  => 'error',
'messages'=> "Anda Harus Memilih Jenis Dokumen Penunjang",    
);
echo json_encode($status);    


}
}

function FormMasukanMetaUtama(){
        $input = $this->input->post();
        $form = '<div class="modal-content">
<div class="modal-header bg-dark text-white">
<h6 class="modal-title" >Masukan Detail Dokumen Utama</h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body " >
<form id="FormUtama" >';

$form .='<input type="hidden" class="form-control jenis_dokumen" id="jenis_dokumen" name="jenis_dokumen" value="'.$input['jenis_dokumen'].'">';

$form .='<input type="hidden" class="form-control id_dokumen" id="id_dokumen" name="id_dokumen" value="'.$input['id_dokumen_utama'].'">';

$form .='<label>Masukan No Akta</label>
<input type="text" class="form-control no_akta" id="no_akta" name="no_akta">';

$form .='<label>Masukan Tanggal Akta</label>
<input type="text" class="form-control tanggal_akta date" id="tanggal_akta" name="tanggal_akta">';


$form .="<hr>"
. "<button type='button' onclick=SimpanUtama() class='btn  btn-md btn-dark btn-block '>Simpan Dokumen Utama <i class='fa fa-save'></i></button>"
. "</form>"
. "</div></div>";

        $status[] = array(
                'status'  => 'success',
                'data'=> $form,    
                );
                echo json_encode($status);  
}

function FormMasukanMetaDokumenDuplicate(){
        $input = $this->input->post();        
        if($this->input->post('no_nama_dokumen')){
    
        
        $data_meta = $this->M_data_lama->data_meta($input['no_nama_dokumen']);
        $form = '<div class="modal-content">
        <div class="modal-header bg-dark text-white">
        <h6 class="modal-title" >Masukan Identifikasi File Untuk Mempermudah Pencarian</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body " >';
        $form .= "<form id='FormMeta'>";
        $form .= '<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="required"  accept="text/plain">';
        $form .= '<input type="hidden" name="no_berkas" value="'.$input['no_berkas'].'" readonly="" class="required"  accept="text/plain">';
        $form .= '<input type="hidden" id="no_pekerjaan" name="no_pekerjaan" value="'.$input['no_pekerjaan'].'" readonly="" class="required"  accept="text/plain">';
        $form .= '<input type="hidden" id="no_client" name="no_client" value="'.$input['no_client'].'" readonly="" class="required"  accept="text/plain">';
        $form .= '<input type="hidden" name="no_nama_dokumen" value="'.$input['no_nama_dokumen'].'" readonly="" class="required"  accept="text/plain">';
        foreach ($data_meta->result_array()  as $d ){
        //INPUTAN SELECT   
        if($d['jenis_inputan'] == 'select'){
        $data_option = $this->db->get_where('data_input_pilihan',array('id_data_meta'=>$d['id_data_meta']));   
        $form .= "<label>".$d['nama_meta']."</label>"
        ."<select id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' class='form-control form_meta form-control-md meta required' required='' accept='text/plain'>";
        foreach ($data_option->result_array() as $option){
        $form .= "<option ";
        
        $form .= ">".$option['jenis_pilihan']."</option>";
        }
        $form.="</select>";
        //INPUTAN DATE
        }else if($d['jenis_inputan'] == 'date'){
        $form .= "<label>".$d['nama_meta']."</label>"
        ."<input value=''  type='text' id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-md ".$d['jenis_inputan']." meta required ' required='' accept='text/plain' >";    
        ///INPUTAN NUMBER
        }else if($d['jenis_inputan'] == 'number'){
        $form .= "<label>".$d['nama_meta']."</label>"
        ."<input value='' type='text' id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-md ".$d['jenis_bilangan']." meta required ' required='' accept='text/plain' >";        
        //INPUTAN TEXTAREA
        }else if($d['jenis_inputan'] == 'textarea'){
        $form .= "<label>".$d['nama_meta']."</label>"
        . "<textarea  id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-md ".$d['jenis_bilangan']." meta required ' required='' accept='text/plain'></textarea>";
        }else{
        $form .= "<label>".$d['nama_meta']."</label>"
        ."<input  type='".$d['jenis_inputan']."' value='' id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-md  meta required ' required='' accept='text/plain' >";    
        }
        
        
        }
        $form .="<hr>"
        . "<button type='button' onclick=SimpanPenunjang() class='btn  btn-md btn-dark btn-block '>Simpan Penunjang <i class='fa fa-save'></i></button>"
        . "</form>"
        . "</div></div>";
        
        $status[] = array(
        'status'  => 'success',
        'data'=> $form,    
        );
        echo json_encode($status);  
        
        }else{
            
        $status[] = array(
        'status'  => 'error',
        'messages'=> "Anda Harus Memilih Jenis Dokumen Penunjang",    
        );
        echo json_encode($status);    
        
        
        }
        }

public function  simpan_meta(){
$input = $this->input->post();

foreach ($input as $key=>$value){
if($key == 'no_berkas' || $key == "no_nama_dokumen" || $key == 'no_client' || $key == 'no_pekerjaan' || $key == 'file_berkas' || $key == "ci_csrf_token"){
}else{
$meta = array(
'no_pekerjaan'      => $input['no_pekerjaan'],
'no_nama_dokumen'   => $input['no_nama_dokumen'],
'no_berkas'         => $input['no_berkas'],    
'nama_meta'         => $key,
'value_meta'        => $value,    
);
$this->db->insert('data_meta_berkas',$meta);
}
}
$status[] = array(
"status"        => "success",
"messages"      => "Meta Berhasil disimpan",
);
echo json_encode($status);

}

function tampilkan_form_utama(){
if($this->input->post()){    
$input = $this->input->post();

echo '<div class="modal-content">
<div class="modal-header bg-info text-white">
<h6 class="modal-title" >Masukan Dokumen Utama Pekerjaan</h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>';


echo '<div class="modal-body">';
echo  '<div class="row">
<div class="col-md-8">'
."<form  class=' ' id='form_utama'>"
."<input type='hidden' class='no_client' name='no_client'    value='".$input['no_client']."'>"
."<input type='hidden' class='no_pekerjaan' name='no_pekerjaan' value='".$input['no_pekerjaan']."'>";

echo '<div class="input-group">
  <div class="custom-file">
    <input onchange="upload_utama()" type="file" class="custom-file-input"  id="file_utama" name="file_utama[]" multiple aria-describedby="file_utama">
    <label class="custom-file-label" for="file_utama">Masukan Dokumen Utama</label>
  </div>
 ';
 echo '</div><div class="m-2 utama_terupload"></div>';


echo '<div class="progress" style="display:none"> 
<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
</div></form>
</div>

<div class="col overflow-auto" style="max-height:100%;">';
$dokumen_utama = $this->M_data_lama->dokumen_utama($input['no_pekerjaan']);
echo '<table class="table table-striped text-center ">
<tr><td colspan="2">Dokumen Utama yang dimasukan</td></tr>
<tr class="text-info">
<th>Jenis Utama </th>
<th>Aksi</th>
</tr>';
foreach ($dokumen_utama->result_array() as $utama){ 
echo '<tr>
<td>'.$utama['jenis'] .' No '. $utama['no_akta'] .' ('.$utama['tanggal_akta'] .')</td>   
<td>
<button  onclick=hapus_utama("'.$utama['id_data_dokumen_utama'].'","'.$input['no_client'].'","'.$input['no_pekerjaan'].'"); class="btn btn-sm btn-danger "><i class="fa fa-trash"></i></button>
<button  onclick=download_utama("'.$utama['id_data_dokumen_utama'].'"); class="btn btn-sm btn-dark "><i class="fa fa-download"></i></button>
<button  onclick=LihatLampiran("'.$utama['nama_folder'].'","'.$utama['nama_file'].'"); class="btn btn-sm btn-primary "><i class="fa fa-eye"></i></button>
</td>   
</tr>';
} 
echo ' 
</table>';
echo '</div>
</div></div>';
}else{
redirect(404);    
}    
}

public function upload_utama(){
if($this->input->post()){
        
$input = $this->input->post();
$input = $this->input->post(); 
$data_client = $this->db->get_where('data_client',array('no_client'=>$input['no_client']))->row_array();
$status = array();

for($i =0; $i<count($_FILES); $i++){
$config['upload_path']          = './berkas/'.$data_client['nama_folder'];
$config['allowed_types']        = 'jpg|jpeg|png|pdf|docx|doc|xlxs|pptx|xlx|';
$config['encrypt_name']         = FALSE;
$config['max_size']             = 1000000000;
$this->upload->initialize($config);   

if (!$this->upload->do_upload('file_utama'.$i)){  
$status[] = array(
"status"        => "error",
"messages"      => $this->upload->display_errors(),    
'name_file'     => $this->upload->data('file_name')
);
}else{
$lampiran = $this->upload->data();    
$this->db->limit(1);
$this->db->order_by('data_dokumen_utama.id_data_dokumen_utama','desc');
$h_utama = $this->db->get('data_dokumen_utama')->row_array();

if(isset($h_utama['id_data_dokumen_utama'])){
$urutan = $h_utama['id_data_dokumen_utama']+1;
}else{
$urutan =1;
}
            $data = array(
                'id_data_dokumen_utama' =>$urutan,        
                'nama_file'             =>$this->upload->data('file_name'),
                'mime-type'             =>$this->upload->data('file_type'),
                'no_pekerjaan'          =>$input['no_pekerjaan'],
                'waktu'                 =>date('Y/m/d H:i:s')
                );
                $this->db->insert('data_dokumen_utama',$data); 

$status[] = array(
"status"        => "success",
"messages"      => "Dokumen Utama berhasil di upload",
'name_file'     => $this->upload->data('file_name')
);
}
}
echo json_encode($status);


}else{
redirect(404);    
}
}

public function hapus_file_utama(){
if($this->input->post()){
$input = $this->input->post();
$data = $this->M_data_lama->data_dokumen_utama_where($input['id_data_dokumen_utama'])->row_array();
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

function simpan_pihak_terlibat(){
        $input          = $this->input->post();
        $cek            = $this->db->get_where('data_pemilik',array('no_client'=>$input['no_client'],'no_pekerjaan'=>base64_decode($input['no_pekerjaan'])));
        if($cek->num_rows() > 0){
        $status[] =array(
        'status'    => 'error',
        'messages'  => 'Pihak terkait sudah ditambahkan' 
        ); 
        echo json_encode($status);    
        }else{
        $data_pem = array(
        'no_client'     =>$input['no_client'],
        'no_pekerjaan'  => base64_decode($input['no_pekerjaan'])   
        );
        $this->db->insert('data_pemilik',$data_pem);
        $status[] =array(
        'status'    => 'success',
        'messages'  => 'Pihak terkait berhasil ditambahkan' 
        ); 
        echo json_encode($status);    
        }
        }                
                


public function hapus_keterlibatan(){
if($this->input->post()){
$input = $this->input->post();
$this->db->delete('data_pemilik',array('no_client'=>$input['no_client'],'no_pekerjaan'=> $input['no_pekerjaan']));

$status[] = array(
'status'  => 'success',
'messages'=> "Keterlibatan dihapus",    
);
echo json_encode($status);

}else{
redirect(404);    
}    
}

function TambahkanProsesArsip(){
if($this->input->post()){    
$data = array(
'status_pekerjaan' =>'ArsipProses'    
);
$this->db->update('data_pekerjaan',$data,array('no_pekerjaan'=>base64_decode($this->input->post('no_pekerjaan'))));

$status[] = array(
'status'  => 'success',
'messages'=> "Berhasil Dimasukan Kedalam Proses Arsip",    
);
echo json_encode($status);

}else{
redirect(404);    
}
}
function cari_client2(){
if($this->input->post()){
$no_identitas       = $this->input->post('no_identitas');
$cek                = $this->db->get_where('data_client',array('no_identitas'=>$no_identitas));
$no_client          = $cek->row_array();
if($cek->num_rows() != 0){
$data = array(
'no_client'        =>$no_client['no_client'],
'no_identitas'     =>$no_client['no_identitas'],
'nama_client'      =>$no_client['nama_client'],
'contact_person'   =>$no_client['contact_person'],
'contact_number'   =>$no_client['contact_number'],
'jenis_kontak'     =>$no_client['jenis_kontak']       
);
$s    = "success";
}else{
$data ="Tidak Tersedia";
$s    = "error";
}
$status[] = array(
'message' =>$data,
'status'  => $s    
);
echo json_encode($status);

}else{
redirect(404);    
}    
}


public function lihat_berkas_client(){    
$data_client = $this->M_data_lama->data_client_where($this->uri->segment(3));       

$this->load->view('umum/V_header');
$this->load->view('data_lama/V_lihat_berkas_client',['data_client'=>$data_client]);   
}
public function lihat_client(){    
$data_client = $this->M_data_lama->data_client_where($this->uri->segment(3));       

$this->load->view('umum/V_header');
$this->load->view('data_lama/V_lihat_client',['data_client'=>$data_client]);   
}

function lihat_meta(){
if($this->input->post()){ 
$input = $this->input->post();
$data = $this->db->get_where('data_meta_berkas',array('no_berkas'=>$input['no_berkas']));
$this->db->select('data_meta_berkas.nama_meta,'
. 'data_meta_berkas.value_meta,'
. 'nama_dokumen.nama_dokumen,'
. 'data_berkas.no_berkas,'
. 'data_client.nama_client,'
. 'data_client.nama_folder,'
. 'data_berkas.nama_berkas');
$this->db->from('data_berkas');
$this->db->join('data_meta_berkas', 'data_meta_berkas.no_berkas = data_berkas.no_berkas','left');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_berkas.no_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
$this->db->group_by('data_meta_berkas.no_berkas');
$this->db->where('data_berkas.no_berkas',$input['no_berkas']);
$query = $this->db->get()->row_array();



echo "<tr class='hasil".$input['no_berkas']."'><td colspan='4'>";
foreach ($data->result_array() as $d){
echo str_replace('_', ' ',$d['nama_meta'])." : ".$d['value_meta']."<br>";    
}
echo "<br>";
$ext = pathinfo($query['nama_berkas'], PATHINFO_EXTENSION);
if($ext =="docx" || $ext =="doc" || $ext =="pptx" ){
echo '<div class="text-center">'
. '<H5 class="text-danger">Maaf Kami tidak dapat menampilkan file silahkan klik tombol dibawah ini</H5>'
. '<button onclick=cek_download("'.base64_encode($input['no_berkas']).'") class="btn btn-success btn-sm">Download file <i class="fa fa-download"></i></button>'
. '</div>';

}else if($ext == "JPG"  || $ext == "jpg" || $ext == "png"  || $ext == "PNG" ||$ext == "PDF" ||$ext == "pdf"){
echo '<div class="embed-responsive embed-responsive-16by9">'
. '<iframe cols="100%" class="embed-responsive-item " src="'.base_url("berkas/".$query['nama_folder']."/".$query['nama_berkas']).'" ></iframe>'
. '</div>';
}

echo"</td></tr>";

}else{
redirect(404);
}    
}
function FormLihatMeta(){
if($this->input->post()){ 
$input = $this->input->post();  
$data_meta = $this->db->get_where('data_meta_berkas',array('no_berkas'=>$input['no_berkas']));    
echo "<div class='row  data_edit".$input['no_berkas']."'>"
. "<div class='col-12 text-white text-center'>"
. "<div class='text-left boder-bottom text-dark'>";

foreach ($data_meta->result_array()  as $d ){
echo "<div class='row mt-1'>"
."<div class='col-7'>".str_replace('_', ' ',$d['nama_meta'])."</div>" 
."<div class='col'>: ".$d['value_meta'] ."</div></div>";   
}

echo "</div><hr>"
."<button type='button' onclick=hapus_berkas_persyaratan('".$input['no_berkas']."') class='btn  btn-md col-3 btn-danger m-1  '> <i class='fa fa-trash'></i></button>"
."<button type='button' onclick=LihatLampiran('".$input['nama_folder']."','".$input['nama_berkas']."') class='btn  btn-md col-3 btn-dark m-1'> <i class='fa fa-eye'></i></button>"
."<button type='button' onclick=ShareDokumen('".$input['no_berkas']."') class='btn  btn-md col-3 btn-primary m-1'> <i class='fa fa-share-alt'></i></button>"
."</div>
</div>";

}else{
redirect(404);
}    
}
function FormLihatMetaDuplicate(){
        if($this->input->post()){ 
        $input = $this->input->post();  
        $data_meta = $this->db->get_where('data_meta_berkas',array('no_berkas'=>$input['no_berkas']));    
        echo "<div class='row  data_edit".$input['no_berkas']."'>"
        . "<div class='col-12 text-white text-center'>"
        . "<div class='text-left boder-bottom text-dark'>";
        
        foreach ($data_meta->result_array()  as $d ){
        echo "<div class='row mt-1'>"
        ."<div class='col-7'>".str_replace('_', ' ',$d['nama_meta'])."</div>" 
        ."<div class='col'>: ".$d['value_meta'] ."</div></div>";   
        }
        
        echo "</div><hr>"
        ."<button type='button' onclick=hapus_berkas_persyaratan('".$input['no_berkas']."') class='btn  btn-md col-3 btn-danger m-1  '> <i class='fa fa-trash'></i></button>"
        ."<button type='button' onclick=LihatLampiran('".$input['nama_folder']."','".$input['nama_berkas']."') class='btn  btn-md col-3 btn-dark m-1'> <i class='fa fa-eye'></i></button>"
        ."<button type='button' onclick=ShareDokumen('".$input['no_berkas']."') class='btn  btn-md col-3 btn-primary m-1'> <i class='fa fa-share-alt'></i></button>"
        ."</div>
        </div>";
        
        }else{
        redirect(404);
        }    
        }

public function hapus_lampiran(){
if($this->input->post()){
$input = $this->input->post();    
$data = $this->M_data_lama->hapus_lampiran(base64_decode($input['no_berkas']))->row_array();

$filename = './berkas/'.$data['nama_folder']."/".$data['nama_berkas'];

if(file_exists($filename)){
unlink($filename);
}
$this->db->delete('data_berkas',array('no_berkas'=> base64_decode($input['no_berkas'])));    

$status[] = array(
"status"        => "success",
"messages"      => "Data persyaratan dihapus",    
);
echo json_encode($status);

$keterangan = $this->session->userdata('nama_lengkap')." Menghapus File dokumen".$data['nama_dokumen'];  
$this->histori($keterangan);


}else{
redirect(404);    
}
}
public function histori($keterangan){
   
        $this->db->order_by('id_data_histori_pekerjaan','DESC');
        $this->db->limit(1);  
$data = $this->db->get('data_histori_pekerjaan')->row_array();

if(isset($data['id_data_histori_pekerjaan'])){
        $urutan = $data['id_data_histori_pekerjaan']+1;
        }else{
        $urutan =1;
        }

        $id_data_histori_pekerjaan      =  str_pad($urutan,6 ,"0",STR_PAD_LEFT);
                  
$data = array(
'id_data_histori_pekerjaan'  =>$id_data_histori_pekerjaan,        
'no_user'                    => $this->session->userdata('no_user'),
'keterangan'                 =>$keterangan,
'tanggal'                    =>date('Y/m/d H:i:s'),
);
$this->db->insert('data_histori_pekerjaan',$data);
}

public function data_perekaman(){
if($this->input->post()){
$input = $this->input->post();
$query     = $this->M_data_lama->data_perekaman2($input['no_nama_dokumen'],$input['no_client']);
echo "<table class='table table-sm table-striped table-bordered'>";
echo "<thead>"
. "<th>Nama Dokumen</th>"
. "<th>Jenis Dokumen</th>"
. "<th>Aksi</th>"
. "</thead>";
foreach ($query->result_array() as $d){
echo "<tr>"
. "<td>".$d['nama_berkas']."</td>"
. "<td>".$d['nama_dokumen']."</td>"
. "<td><button class='btn btn-success btn-sm' onclick=cek_download('". base64_encode($d['no_berkas'])."')><span class='fa fa-download'></span></button></td>"    
. "</tr>";
}

echo "<tbody></tbody>";
echo"</table>";  
}else{
redirect(404);    
}    
}
public function profil(){
$no_user = $this->session->userdata('no_user');
$data_user = $this->M_data_lama->data_user_where($no_user);
$this->load->view('umum/V_header');
$this->load->view('data_lama/V_profil',['data_user'=>$data_user]);
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
$this->session->set_userdata($data);
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
public function update_selesaikan_pekerjaan(){
if($this->input->post()){
$input = $this->input->post();
$data = array(
'status_pekerjaan'  =>'ArsipSelesai',    
'tanggal_selesai'    =>date('d/m/Y')    
);
$this->db->update('data_pekerjaan',$data,array('no_pekerjaan'=> base64_decode($input['no_pekerjaan'])));
$status[] = array(
"status"     => "success",
"messages"      => "Perizinan berhasil diselesaikan"    
);
echo json_encode($status);
}else{
redirect(404);    
}
}



function data_perekaman_utama(){
if($this->input->post()){
$input              = $this->input->post();
$data_utama = $this->M_data_lama->DataDokumenUtama($input['id_data_dokumen_utama']);
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

public function data_perekaman_pencarian(){
if($this->input->post()){
$input              = $this->input->post();
$DokumenPenunjang   = $this->M_data_lama->DokumenPenunjang($input['no_berkas']);
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
public function modal_cek_dokumen(){

if($this->input->post()){    
$input = $this->input->post();

$this->db->select('data_berkas.no_berkas,'
. 'nama_dokumen.nama_dokumen,'
. 'nama_dokumen.no_nama_dokumen,'
. 'data_berkas.tanggal_upload,'
. 'data_berkas.nama_berkas,'
. 'user.nama_lengkap');
$this->db->from('data_berkas');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
$this->db->join('user', 'user.no_user = data_berkas.pengupload');
$this->db->where('data_berkas.no_nama_dokumen',$input['no_nama_dokumen']);
$this->db->where('data_berkas.no_client',$input['no_client']);
$data = $this->db->get();


echo '<div class="modal-content ">
<div class="modal-header bg-danger text-white">
<h6 class="modal-title" id="exampleModalLabel text-center">Jenis Dokumen ini sudah tersedia <span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body ">
<table class="table table-bordered table-striped">
<tr>
<td>Dokumen lama</td>
<td>Pengupload</td>
<td>Tgl upload</td>
<td>Aksi</td>
</tr>';
foreach ($data->result_array() as $d){
echo "<tr id='tersedia".$d['no_berkas']."'>"
. "<td>".$d['nama_dokumen']."</td>"
. "<td>".$d['nama_lengkap']."</td>"
. "<td>".$d['tanggal_upload']."</td>"
. "<td style='width:25%;' class='text-center'>"
. "<button  onclick=FormLihatMetaDuplicate('".$input['no_client']."','".$input['no_pekerjaan']."','".$d['no_berkas']."','".$d['no_nama_dokumen']."'); class='btn btn-sm  btn-warning btn_tersedia".$d['no_berkas']."'>Lihat Meta </button>"
. "<button onclick=hapus_berkas_persyaratan('".$input['no_client']."','".$input['no_pekerjaan']."','".$d['no_berkas']."') class='btn btn-sm ml-1 btn-danger'>Replace </button>"
. "</td>"
. "</tr>";    
}
echo'</table></div>';    
echo "<div class='card-footer text-center'>"
. "<button onclick=DuplicateDokumen('".$input['no_client']."','".base64_decode($input['no_pekerjaan'])."','".$input['no_berkas']."','".$input['no_nama_dokumen']."') class='btn btn-md  btn-info btn-block '>Tambahkan Dokumen Baru </button>"
. "</div></div></div>";

}else{
redirect(404);    
}
}
public function hapus_meta(){
if($this->input->post()){    
$input = $this->input->post();
$response [] =array(
'status'   =>'success',
'messages' =>'Meta Dokumen Terhapus'   
);
$this->db->delete('data_meta_berkas',array('no_berkas'=> $input['no_berkas']));
echo json_encode($response);    
}
}

public function DuplikasiDokumen(){
if($this->input->post()){
$input = $this->input->post();
$data = array(
'no_nama_dokumen' => $input['no_nama_dokumen'],
'status_berkas'   =>'Selesai'    
);
$response [] =array(
'status'   =>'success',
'messages' =>'Dokumen Terduplikasi'   
);
$this->db->update('data_berkas',$data,array('no_berkas'=> $input['no_berkas']));
echo json_encode($response);    
}else{
redirect(404);    
}    
}

function lihat_utama(){
if($this->input->post()){ 
$input = $this->input->post();
echo print_r($input);

$this->db->select('data_dokumen_utama.nama_file,'
. 'data_client.nama_folder'
. '');
$this->db->from('data_dokumen_utama');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_dokumen_utama.no_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->where('data_dokumen_utama.id_data_dokumen_utama',$input['id_data_dokumen_utama']);
$query = $this->db->get()->row_array();


echo "<tr class='utama".$input['id_data_dokumen_utama']."'><td colspan='6'>";

$ext = pathinfo($query['nama_file'], PATHINFO_EXTENSION);
if($ext =="docx" || $ext =="doc" || $ext =="pptx" ){
echo '<div class="text-center">'
. '<H5 class="text-danger">Maaf Kami tidak dapat menampilkan file silahkan klik tombol dibawah ini</H5>'
. '<button onclick=cek_download_utama("'.base64_encode($input['id_data_dokumen_utama']).'") class="btn btn-success btn-sm">Download file <i class="fa fa-download"></i></button>'
. '</div>';

}else if($ext == "JPG"  || $ext == "jpg" || $ext == "png"  || $ext == "PNG" ||$ext == "PDF" ||$ext == "pdf"){
echo '<div class="embed-responsive embed-responsive-16by9">'
. '<iframe cols="100%" class="embed-responsive-item " src="'.base_url("berkas/".$query['nama_folder']."/".$query['nama_file']).'" ></iframe>'
. '</div>';
}

echo"</td></tr>";

}else{
redirect(404);
}    
}

function lihat_terlibat(){
if($this->input->post()){ 
$input = $this->input->post();


$pihak = $this->db->get_where('data_pemilik',array('no_pekerjaan'=>$input['no_pekerjaan']));

echo "<tr class='pekerjaan".$input['no_pekerjaan']."'><td colspan='7'>";
echo "<table class='table table-bordered table-hover'>"
. "<tr>"
. "<td align='center'>Nama Pihak Terlibat</td>"
. "<td>Aksi</td>"
. "</tr>";
foreach ($pihak->result_array() as $client){
$terlibat = $this->db->get_where('data_client',array('no_client'=>$client['no_client']))->row_array();
echo "<tr>"
. "<td>".$terlibat['nama_client']."</td>"
. "<td><button onclick=PindahClient('".$client['no_client']."') class='btn btn-sm btn-dark btn-block'>Lihat Pihak Terlibat</button></td>"
. "</tr>";    
}
echo "</table>";

echo"</td></tr>";

}else{
redirect(404);
}    
}
public function PengaturanArsipLoker(){
        $this->breadcrumbs->push('Beranda', '/Data_lama');
        $this->breadcrumbs->push('Pengaturan Arsip Loker', '/Data_lama/PengaturanArsipLoker');  

        
$this->load->view('umum/V_header');
$this->load->view('data_lama/V_pengaturan_arsip_loker');
}
public function simpanlemari(){
if($this->input->post()){
$input = $this->input->post();
$this->form_validation->set_rules('nama_tempat', 'Nama Tempat', 'required',array('required' => 'Data ini tidak boleh kosong'));
if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);
echo json_encode($status);

}else{
$tot_lemari = $this->db->get_where('data_daftar_lemari')->num_rows();    
$no_lemari    = "LM".str_pad($tot_lemari+1,3 ,"0",STR_PAD_LEFT);    

$data = array(
'no_lemari'     =>$no_lemari,
'nama_tempat'   =>$input['nama_tempat']
);

$this->db->insert('data_daftar_lemari',$data);
$status_input = $this->form_validation->error_array();

$status[] = array(
'status'   => 'success',
'messages' => 'Tempat penyimpanan arsip fisik berhasil dibuat',    
);
echo json_encode($status);

}    
}else{
redirect(404);    
}    
}
public function simpanloker(){
if($this->input->post()){
$input = $this->input->post();

$h_loker     =$this->db->get('data_daftar_loker')->num_rows()+1;
$no_loker = "LK".str_pad($h_loker,3 ,"0",STR_PAD_LEFT);

$data =array(
'id_no_loker'   =>$no_loker,
'no_loker'      =>$input['no_loker'],    
'no_lemari'     =>$input['no_lemari'],    
'status_loker'  =>$input['status_loker'],    
);

$this->db->insert('data_daftar_loker',$data);

$status[] = array(
'status'   => 'success',
'messages' => 'Loker baru berhasil ditambahkan',    
);
echo json_encode($status);

}else{
redirect(404);    
}    
}

public function PekerjaanBaruSelesai(){
        $this->breadcrumbs->push('Beranda', '/Data_lama');
        $this->breadcrumbs->push('Membuat Arsip Pekerjaan', '/Data_lama/BuatArsip');  
        $this->breadcrumbs->push('Daftar Arsip Masuk', '/Data_lama/DataArsipClient');  
        $this->breadcrumbs->push('Daftar Arsip Proses', '/Data_lama/DataArsipProses');  
        $this->breadcrumbs->push('Daftar Arsip Selesai', '/Data_lama/DataArsipSelesai');  
        $this->breadcrumbs->push('Buat Arsip Bantex', '/Data_lama/PekerjaanBaruSelesai');  
        

$this->load->view('umum/V_header');
$this->load->view('data_lama/V_pekerjaan_baru_selesai');
}

public function setting_lemari(){
if($this->input->post()){
$input      = $this->input->post();

$loker = $this->db->get_where('data_daftar_loker',array('no_lemari'=>$input['no_lemari']));
$no_loker = $loker->num_rows()+1;
echo "<tr class='text-dark bg-light lemari".$input['no_lemari']."'><td colspan='7'>";
echo "<div class='row'>"
.    "<div class='col-md-5'>"
. "<form id='formbuatloker".$input['no_lemari']."'>";
echo '<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="required"  accept="text/plain">';
echo "<label>No Loker</label>";
echo "<input name='no_lemari' class='form-control form-control-sm' readonly type='hidden' value='".$input['no_lemari']."' >";
echo "<input name='no_loker' class='form-control form-control-sm' readonly type='text' value='".$no_loker."'>";
echo "<label>Status Loker</label>";
echo "<select name='status_loker' class='form-control form-control-sm'>";
echo "<option>Tersedia</option>";
echo "<option>Penuh</option>";
echo "</select>"
. "<hr></form>"
. "<button type='button' onclick=simpanloker('".$input['no_lemari']."'); class='btn btn-sm btn-block btn-dark'>Buat Loker Baru <i class='fa fa-save'></i></button>";
echo "</div>";
echo "<div class='col'>";
echo "<table class='table table-sm table-bordered table-hover'>"
. "<tr >"
. "<td class='text-center'>No Loker </td>"
. "<td class='text-center' >Update status loker</td>"
. "<td class='text-center' >Print Label</td>"
. "</tr>";
foreach ($loker->result_array() as $d){
echo"<tr>"
. "<td>".$d['no_loker']."</td>"
. "<td><select  onchange=UpdateLoker('".$d['id_loker']."') class='form-control status_loker".$d['id_loker']." form-control-sm'>"
. "<option ";
if($d['status_loker'] =='Tersedia'){echo "selected";}
echo ">Tersedia</option>"
. "<option ";
if($d['status_loker'] =='Penuh'){echo "selected";}
echo">Penuh</option>"
. "</select></td>"
. "<td><button onclick=printlabelloker('".$d['id_no_loker']."'); class='btn btn-success btn-sm btn-light btn-block'>Print <i class='fa fa-print'></i></button></td>"
. "</tr>";
}
echo "</table></div></div>";

echo "</td></tr>";

}else{
redirect(404);    
}    

}

public function setting_loker(){
if($this->input->post()){
$input      = $this->input->post();

$data_bantek = $this->db->get_where('data_bantek',array('status_bantek'=>'Tersedia'));
echo "<tr class='text-dark bg-light settingloker".$input['no_pekerjaan']."'><td colspan='8'>";
echo "<div class='row'>"
.    "<div class='col-md-7 mx-auto'>";
echo "<label>Pilih Bantek Tersedia</label>";
echo '<div class="input-group mb-3">
<select onchange=DetailBantek("'.$input['no_pekerjaan'].'"); class="form-control no_bantex'.$input['no_pekerjaan'].'">
<option></option>'; 
foreach ($data_bantek->result_array() as $bantek){
        echo "<option value=".$bantek['no_bantek'].">".$bantek['no_bantek']." ".$bantek['judul']."</option>";    
        }

echo'</select>
<div class="input-group-append">
  <button class="btn btn-dark" onclick=BuatBantek("'.$input['no_pekerjaan'].'"); type="button">Buat Bantex Baru</button>
</div>
</div>';

echo "<div class='text-center  DetailBantek".$input['no_pekerjaan']."'></div>"
. "</div>";
echo "</td></tr>";

}else{
redirect(404);    
}    
}

public function EditBantek(){
        if($this->input->post()){
        $input = $this->input->post();
        $this->db->select('data_daftar_loker.no_loker,
        data_bantek.no_bantek,
        data_daftar_lemari.nama_tempat,
        data_bantek.judul,
        data_bantek.status_bantek,
        data_daftar_lemari.no_lemari');
        $this->db->from('data_bantek');
        $this->db->join('data_daftar_loker', 'data_daftar_loker.id_no_loker = data_bantek.id_no_loker');
        $this->db->join('data_daftar_lemari', 'data_daftar_lemari.no_lemari = data_daftar_loker.no_lemari');
        $this->db->where('data_bantek.no_bantek',$input['no_bantek']);
        $query = $this->db->get()->row_array();  
        
        $this->db->select('data_jenis_pekerjaan.nama_jenis,
        data_client.nama_client');
        $this->db->from('data_pekerjaan');
        $this->db->join('data_client','data_client.no_client = data_pekerjaan.no_client');
        $this->db->join('data_jenis_pekerjaan','data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
        $this->db->where('data_pekerjaan.no_bantek',$input['no_bantek']);
        $data_pekerjaan = $this->db->get();

        echo "<tr class='text-dark bg-light settingloker".$input['no_bantek']."'>
        <td colspan='8'>";
          echo "<div class='row'>"
        .    "<div  class='col-md-4 mx-auto text-center'>";
         echo "<table  border='1' cellspacing='0' cellpadding='0' id='print".$input['no_bantek']."'  class=''>
        
        <tr>
        <td align='center' >Detail Penyimpanan Bantek</td>
        </tr>
        <tr>
        <td  >".$query['judul']."</td>
        </tr>
        <tr>
        <td>".$query['nama_tempat']."</td>
        </tr>
        
        <tr>
        <td>".$query['no_bantek']."(".$query['no_loker'].")</td>
        </tr>

        <tr>
        <tr>
        <td align='center' colspan='2'>Detail Isi Bantex </td>
        </tr>";
  foreach($data_pekerjaan->result_array() as $p){
          echo "<tr>
          <td>".$p['nama_client']."<br>(".$p['nama_jenis']." )</td>
          </tr>";

  }


        echo"<table>
        <button  style='width:320px;' onclick=PrintLabel('".$input['no_bantek']."') class='btn btn-dark btn-block  mt-2  btn-sm'>Label Bantek <span class='fa fa-print'></span></button>";

        if($query['status_bantek'] =='Tersedia'){
        echo "<button  style='width:320px;' onclick=PinjamBantek('".$input['no_bantek']."') class='btn btn-dark btn-block btn-sm'>Pinjam Bantek </button>";
        }else if($query['status_bantek'] =='Dipinjam'){
        echo "<button  style='width:320px;' onclick=BalikanLoker('".$input['no_bantek']."') class='btn btn-warning btn-block btn-sm'>Balikan Ke Loker</button>";
        }
        echo "</div></td></tr>";
     
        }else{
        redirect(404);    
        }    
        
        }

public function pinjamarsip(){
if($this->input->post()){
$input      = $this->input->post();
$data_user = $this->db->get_where('user',array('level'=>'User','status'=>'Aktif'));
echo "<tr class='text-dark bg-light pinjamarsip".$input['no_pekerjaan']."'><td colspan='8'>";
echo "<div class='row'>"
.    "<div class='col-md-4'>";
echo "<label>Nama Asisten yang akan meminjam arsip</label>";
echo "<select onchange=simpan_peminjam('".$input['no_pekerjaan']."'); class='form-control no_peminjam".$input['no_pekerjaan']." form-control-sm'>";
echo "<option></option>";
foreach ($data_user->result_array() as $user){
echo "<option value=".$user['no_user'].">".$user['nama_lengkap']."</option>";    
}
echo "</select>";
echo "</div>"
. "</div>";
echo "</td></tr>";

}else{
redirect(404);    
}    

}
public function update_loker(){
if($this->input->post()){
$input      = $this->input->post();

$data = array(
'status_loker' =>$input['status_loker']    
);
$this->db->update('data_daftar_loker',$data,array('id_loker'=>$input['id_loker']));

$status[] = array(
'status'   => 'success',
'messages' => 'status loker diperbaharui',    
);
echo json_encode($status);

}else{
redirect(404);    
}       
}

function tampilkan_loker(){
if($this->input->post()){
$input        = $this->input->post();
$daftar_loker = $this->db->get_where('data_daftar_loker',array('no_lemari' =>$input['no_lemari']));
if($daftar_loker->num_rows() >0){
echo "Pilih Loker Penyimpanan Fisik";
echo "<div class='row'>";
foreach ($daftar_loker->result_array() as $arsip){
echo "<div class='col-md-3'>";
if($arsip['status_loker'] == 'Penuh'){    
echo "<div class='card m-3 bg-danger text-center text-white'>";
echo "Loker ".$arsip['no_loker']."<br>";  
echo $arsip['status_loker'];  
}else{
echo "<div onclick=pilihloker('".$arsip['id_no_loker']."','".$arsip['no_loker']."','".$input['no_pekerjaan']."'); class='card m-3 bg-success text-center text-white'>";
echo "Loker ".$arsip['no_loker']."<br>";  
echo $arsip['status_loker'];      
}

echo "</div></div>";
}

}else{
   
echo "Anda Belum Memilih Nama Lemari";

}
echo "</div>";
}else{
redirect(404);    
}    
}
public function simpan_arsip_bantek(){
if($this->input->post()){
$input        = $this->input->post();

$data = array(
'id_no_loker'      => $input['id_no_loker'],
'no_bantek'        => $input['no_bantek'],
'judul'            =>$input['judul'],
'status_bantek'            =>'Tersedia',
);

$this->db->insert('data_bantek',$data);
$status[] = array(
'status'   => 'success',
'messages' => 'Bantek Baru Berhasil dibuat',    
);
echo json_encode($status);

}else{
redirect(404);    
}     
}

public function DokumenArsip(){
       
        $this->breadcrumbs->push('Beranda', '/Data_lama');
        $this->breadcrumbs->push('Membuat Arsip Pekerjaan', '/Data_lama/BuatArsip');  
        $this->breadcrumbs->push('Daftar Arsip Masuk', '/Data_lama/DataArsipClient');  
        $this->breadcrumbs->push('Daftar Arsip Proses', '/Data_lama/DataArsipProses');  
        $this->breadcrumbs->push('Daftar Arsip Selesai', '/Data_lama/DataArsipSelesai');  
        $this->breadcrumbs->push('Buat Arsip Bantex', '/Data_lama/PekerjaanBaruSelesai');  
        $this->breadcrumbs->push('Daftar Arsip Bantex', '/Data_lama/DokumenArsip');  
              

$this->load->view('umum/V_header');
$this->load->view('data_lama/V_dokumen_arsip');    
}
public function PeminjamanArsip(){
$this->load->view('umum/V_header');
$this->load->view('data_lama/V_arsip_dipinjam');    
}

public function  PrintLabelLoker(){
$id_no_loker = base64_decode($this->uri->segment(3));

$this->db->select('data_daftar_loker.no_loker,'
        . 'data_daftar_lemari.no_lemari,'
        . 'data_daftar_lemari.nama_tempat');
$this->db->from('data_daftar_loker');
$this->db->join('data_daftar_lemari', 'data_daftar_lemari.no_lemari = data_daftar_loker.no_lemari');
$this->db->where('data_daftar_loker.id_no_loker',$id_no_loker);
$query = $this->db->get();
$static = $query->row_array();
$html  = '<link href="'.base_url().'assets/bootstrap-4.1.3/dist/css/bootstrap.css" rel="stylesheet" type="text/css"/>';
$html .= "<table class='table table-bordered table-striped table-sm   text-center'>"
                . "<tr><td colspan='4'  align='center' ><b style='font-size:20px;'>NOTARIS DEWANTARI HANDAYANI SH.MPA</b></h4></td><td><h4><b style='font-size:30px;'>No Loker</b><h4></td></tr>"
                . "<tr><td colspan='4'><b style='font-size:40px;'>".$static['nama_tempat']."</b></td><td><b style='font-size:40px;'>".$static['no_loker']."</b></td></tr>";

$html   .='<tr>'
        . '<td>No Urut</td>'
        . '<td>Nama Client</td>'
        . '<td>Asisten</td>'
        . '<td>Tanggal</td>'
        . '<td>Petugas Arsip</td>'
        . '</tr>';

$this->db->select('data_client.nama_client,'
        . 'asisten.nama_lengkap as asisten,'
        . 'petugas.nama_lengkap as petugas,'
       . 'data_pekerjaan.tanggal_arsip');
$this->db->from('data_daftar_loker');
$this->db->join('data_pekerjaan','data_pekerjaan.id_no_loker = data_daftar_loker.id_no_loker');
$this->db->join('data_client','data_client.no_client = data_pekerjaan.no_client');
$this->db->join('user as asisten','asisten.no_user = data_pekerjaan.no_user');
$this->db->join('user as petugas','petugas.no_user = data_pekerjaan.no_petugas_arsip');

$this->db->where('data_daftar_loker.id_no_loker',$id_no_loker);
$data_client = $this->db->get();
$h =1;
foreach ($data_client->result_array() as $d){
$html.="<tr>"
    . "<td>".$h++."</td>"
    . "<td>".$d['nama_client']."</td>"
     . "<td>".$d['asisten']."</td>"
     . "<td>".$d['tanggal_arsip']."</td>"
     . "<td>".$d['petugas']."</td>"
   . "</tr>";    
}


$dompdf = new Dompdf(array('enable_remote'=>true));
$dompdf->loadHtml($html);
$dompdf->setPaper('A4','landscape');
$dompdf->render();
$dompdf->stream('INV.pdf',array('Attachment'=>0));
}


function simpan_peminjam(){
if($this->input->post()){
$input = $this->input->post();
$data2 = $this->db->get_where('user',array('no_user'=>$input['no_peminjam']))->row_array();

$data = array(
'no_user_peminjam'      => $input['no_peminjam'],
'status_bantek'         => 'Dipinjam'    
);

$this->db->update('data_bantek',$data,array('no_bantek'=>$input['no_bantek']));

$status[] = array(
'status'   => 'success',
'messages' => 'Arsip Berhasil Dipinjamkan ke '.$data2['nama_lengkap'],    
);
echo json_encode($status);


}else{
redirect(404);    
}     
}

function balikan_arsip(){
if($this->input->post()){
$input = $this->input->post();
        $data = array(
        'no_user_peminjam'      => NULL,
        'status_bantek'         => 'Tersedia'    
        );
        
        $this->db->update('data_bantek',$data,array('no_bantek'=>$input['no_bantek']));
        
        $status[] = array(
        'status'   => 'success',
        'messages' => 'Arsip Berhasil dikembalikan'    
        );
        echo json_encode($status);
        
        

}else{
redirect(404);    
}     
}
function SetKontak(){
        $input = $this->input->post();
        
        $data = $this->db->get_where('data_daftar_kontak',array('id_kontak'=>$input['id_kontak']));
        
        $data_kontak = array();
        foreach ($data->result_array() as $d){
        $data_kontak =array(
        'nama_kontak'   =>$d['nama_kontak'],
        'no_kontak'     =>$d['no_kontak'],
        'jabatan'       =>$d['jabatan'],
        'email'         =>$d['email'],    
        'id_kontak'     =>$d['id_kontak'],    
        );    
        }
        $status[] = array(
        "status"        => "success",
        "messages"      => "Kontak Person Berhasil Ditambahkan",
        "DaftarKontak"  =>$data_kontak    
        );
        
        echo json_encode($status);
        }
        public function FormTambahClient(){
                $input = $this->input->post();  
                $data_dokumen = $this->db->get_where('nama_dokumen',array('persyaratan_daftar' =>$input['jenis_client']));  
              echo '<div class="modal-content">
                <div class="modal-header bg-info text-white">
                <h6 class="modal-title" >Membuat Data Client '.$input['jenis_client'].'</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
              
                <div class="modal-body overflow-auto" style="max-height:450px;" >';
                echo '<form id="FormClientBaru">
                <input type="hidden" name="'. $this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="form-control required"  accept="text/plain">';
                echo "<div class='row'>
                <div class='col'>";
             
            if($this->input->post('jenis_client') =='Badan Hukum'){    
                echo '
                <input type="hidden" value="Badan Hukum" name="jenis_client" id="jenis_client" class="form-control  required"  accept="text/plain" placeholder="Masukan Jenis">
               
                <label>* Nama Badan Hukum</label>
                <input onkeyup=CekNamaBadanHukum();  type="text" name="nama_client" id="nama_client" class="form-control  required nama_client2"  accept="text/plain" placeholder="Masukan Nama Badan Hukum">
                
                <label>* Pilih Jenis Dokumen </label>
                <select class="form-control nama_dokumen" name="nama_dokumen" id="nama_dokumen">';
                
                foreach($data_dokumen->result_array() as  $n){
                    echo "<option value=".$n['no_nama_dokumen'].">".$n['nama_dokumen']."</option>";    
                }
                
                echo'</select> 
                <label>* Masukan File NPWP </label>
                <input type="file" name="file_berkas" id="file_berkas" class="form-control  required"   rows="5" placeholder="Masukan  File Berkas">
                
                <label>* No NPWP <span style="font-size:12px;">( Anda dapat mengenerate no npwp jika npwp belum tersedia)</span></label>
                <div class="input-group mb-3">
                <input type="text" name="no_identitas" id="no_identitas" class="form-control  required"  accept="text/plain" placeholder="Masukan No NPWP">
                <div class="input-group-append">
                <button onclick=GenerateNPWP(); type="button" class="input-group-text" id="basic-addon2">Generate NPWP</button>
                </div>
                </div>

                <label>* Alamat Client </label>
                <textarea name="alamat_client" id="alamat_client" class="form-control  required"  accept="text/plain" rows="5" placeholder="Masukan Alamat Client"></textarea>
                
                <label>* Nomor Telepon </label>
                <input type="number" name="no_contact" id="no_contact" class="form-control  required"  accept="text/plain" rows="5" placeholder="Masukan No Telepon Badan Hukum">
                
                <label>* Email Badan Hukum </label>
                <input type="text" name="email" id="email" class="form-control  required"  accept="text/plain"  placeholder="Masukan Email Badan Hukum">';    
                
           
                }else{
                
                echo '
                <input type="hidden" value="Perorangan" name="jenis_client" id="jenis_client" class="form-control  required"  accept="text/plain" placeholder="Masukan Jenis">
               
                <label>* Nama Perorangan</label>
                <input onkeyup=CekNamaPerorangan(); value="" type="text" name="nama_client" id="nama_client" class="form-control  required nama_client2"  accept="text/plain" placeholder="Masukan Nama Perorangan">
                <label>* Pilih Jenis Dokumen </label>
                <select onchange="SetJenisDokumen()" class="form-control nama_dokumen" name="nama_dokumen" id="nama_dokumen">';
                
                foreach($data_dokumen->result_array() as  $n){
                    echo "<option value=".$n['no_nama_dokumen'].">".$n['nama_dokumen']."</option>";    
                }
                
                echo'</select> 
                <label>* Masukan File <span id="nm_file"></span> </label>
                <input type="file" name="file_berkas" id="file_berkas" class="form-control  required"   rows="5" placeholder="Masukan  File Berkas">
                
                <label>*<span id="nmr_file">NIK KTP</span></label>
                <input type="text" name="no_identitas" id="no_identitas" class="form-control  required"  accept="text/plain" placeholder="Masukan NIK KTP">
                
                <label>* Alamat Client</label>
                <textarea name="alamat_client" id="alamat_client" class="form-control  required"  accept="text/plain" rows="5" placeholder="Masukan Alamat Client"></textarea>
                
                <label>* Nomor Telepon </label>
                <input type="number" name="no_contact" id="no_contact" class="form-control  required"  accept="text/plain" rows="5" placeholder="Masukan No Telepon Perseorangan">
              
                
                <label>* Email Badan Hukum </label>
                <input type="text" name="email" id="email" class="form-control  required"  accept="text/plain"  placeholder="Masukan Email Badan Hukum">';
                
               }
                
                echo ' </div> 
                <div class="col-md-7">

 <label>*Nama Kontak</label>
    <select  onchange=SetKontak() name="nama_kontak" id="nama_kontak" class="form-control nama_kontak"></select>
<table class="table table-striped table-condensed dataTable no-footerr">
    <thead>
        <thead>
            <th>Nama Kontak</th>
            <th>No Kontak </th>
            <th>Email</th>
            <th>Jabatan</th>
            <th>Aksi</th>
        </thead>
    </thead>    
    <tbody id="DataKontak">
        <tr id="KontakKosong">
            <td align="center" colspan="5">Nama Kontak Belum Tersedia Silahkan Pilih Diatas</td>
        </tr>
    </tbody>  
</table>
</div>
                </div>';

                echo '</div> 
                <div class="modal-footer">
                <button onclick=SimpanClient(); class="btn btn-dark simpan_pekerjaan btn-block">Simpan Client Baru <span class="fa fa-save"></span> </button>
                </form>
                </div>
                </div>
                ';
                }

        public function SimpanClient(){
                        $input = $this->input->post();
                        $z = json_decode($input['data_kontak'],true);
                        $this->form_validation->set_rules('jenis_client', 'Jenis Client', 'required',array('required' => 'Data ini tidak boleh kosong'));
                        $this->form_validation->set_rules('nama_client', 'Nama Client', 'required',array('required' => 'Data ini tidak boleh kosong'));
                        if($input['jenis_client'] == 'Badan Hukum'){
                        $this->form_validation->set_rules(
                                'no_identitas', 'no_identias',
                                'required|min_length[15]|max_length[15]|numeric',
                                array(
                                        'required'      => 'Data Ini Tidak Boleh Kosong ',
                                        'min_length'    => 'No npwp terdiri dari 15 Angka',
                                        'max_length'    => 'No npwp tidak lebih dari 15 Angka',
                                        'numeric'       => 'No npwp hanya berisi angka saja'
                                )
                        );    
                        }else{
                        if($input['jenis_dokumen'] == 'Passport'){
                        $this->form_validation->set_rules('no_identitas', 'no_identitas', 'required',array('required' => 'Data ini tidak boleh kosong'));
                        }else if(empty($_FILES['file_penunjang'])){
                                $this->form_validation->set_rules('file_berkas', 'file_berkas', 'required',array('required' => 'Data ini tidak boleh kosong'));
                        }else{
                        $this->form_validation->set_rules(
                                'no_identitas', 'no_identias',
                                'required|min_length[16]|max_length[16]|numeric',
                                array(
                                        'required'      => 'Data Ini Tidak Boleh Kosong',
                                        'min_length'    => 'NIK KTP terdiri dari 16 Angka',
                                        'max_length'    => 'NIK KTP terdiri tidak lebih dari 16 Angka',
                                        'numeric'       => 'NIK KTP hanya berisi angka saja'
                                )
                        );
                        }
                        }
                        
                        if ($this->form_validation->run() == FALSE){
                        $status_input = $this->form_validation->error_array();
                        $status[] = array(
                        'status'  => 'error_validasi',
                        'messages'=>array($status_input),    
                        );
                        echo json_encode($status);
                        }else{
         
                $data    = $this->input->post();
                        $cek_client = $this->db->get_where('data_client',array('no_identitas'=>$data['no_identitas']))->num_rows();
                        if($cek_client >0){
                        
                        $status[] = array(
                        'status'  => 'error_validasi',
                        'messages'=>[array('no_identitas'=>'No Identitas Ini Sudah Digunakan Client Lain')],    
                        );
                        echo json_encode($status);
                            
                        }else{
                        //pembuatan no_client//
                                          $this->db->limit(1);
                                          $this->db->order_by('data_client.no_client','desc');
                        $h_client       = $this->db->get('data_client')->row_array();
                        if(isset($h_client['no_client'])){
                        $urutan = (int) substr($h_client['no_client'],1)+1;
                        }else{
                        $urutan =1;
                        }
                        $no_client      =  "C".str_pad($urutan,6 ,"0",STR_PAD_LEFT);
                        //pembuatan id_kontak_pekerjaan//
                   
                        $data_client = array(
                        'no_client'                 => $no_client,    
                        'jenis_client'              => ucfirst($data['jenis_client']),    
                        'nama_client'               => strtoupper($data['nama_client']),
                        'no_identitas'              => ucfirst($data['no_identitas']),    
                        'tanggal_daftar'            => date('Y/m/d H:i:s'),    
                        'pembuat_client'            => $this->session->userdata('nama_lengkap'),    
                        'no_user'                   => $this->session->userdata('no_user'), 
                        'nama_folder'               =>"Dok".$no_client,
                        'contact_number'            =>$data['no_contact'],
                        'alamat_client'             =>$data['alamat_client'],
                        'email'                     =>$data['email']
                        );
                        $this->db->insert('data_client',$data_client);
                        
                        if(!file_exists("berkas/"."Dok".$no_client)){
                        mkdir("berkas/"."Dok".$no_client,0777);
                        }
                                       
           if(count($z[0]) == 0){
                
                }else{
                        $data_kontak2 = json_decode($input['data_kontak'],true);
                        for($a=0; $a<count($data_kontak2); $a++){
                        $this->db->limit(1);
                        $this->db->order_by('data_kontak_client.id_kontak_client','desc');
                        $h_kontak = $this->db->get('data_kontak_client')->row_array();
      
                        if(isset($h_kontak['id_kontak_client'])){
                        $hkontak = (int) substr($h_kontak['id_kontak_client'],1)+1;
                        }else{
                        $hkontak =1;
                        }
                        $id_kontak_client      =  "K".str_pad($hkontak,6 ,"0",STR_PAD_LEFT);
                       
                        
                       
                        $data_kontak = array(
                        'id_kontak_client'     =>$id_kontak_client,
                        'id_kontak'            =>$data_kontak2[$a]['id_kontak'],
                        'no_client'            =>$no_client,    
                        );
                        $this->db->insert('data_kontak_client',$data_kontak);       
                        }
                }
                        $config['upload_path']          = './berkas/'."Dok".$no_client;
                        $config['allowed_types']        = 'jpg|jpeg|png|pdf|docx|doc|xlxs|pptx|';
                        $config['encrypt_name']         = FALSE;
                        $config['max_size']             = 1000000000;
                        $this->upload->initialize($config);   

                        if (!$this->upload->do_upload('file_penunjang')){  
                        /*$status[] = array(
                        "status"        => "error",
                        "messages"      => $this->upload->display_errors(),    
                        'name_file'     => $this->upload->data('file_name')
                        );*/
                        }else{
                                $this->db->limit(1);
                                $this->db->order_by('data_berkas.no_berkas','desc');
                                $h_berkas       = $this->db->get('data_berkas')->row_array();
                                
                                if(isset($h_berkas['no_berkas'])){
                                $urutan = (int) substr($h_berkas['no_berkas'],10)+1;
                                }else{
                                $urutan =1;
                                }
                        
                                $no_berkas = "BK".date('Ymd' ).str_pad($urutan,10,0,STR_PAD_LEFT);
                                $data_berkas = array(
                                'no_berkas'         => $no_berkas,    
                                'no_client'         => $no_client,    
                                'no_pekerjaan'      => NULL,
                                'no_nama_dokumen'   => $input['nama_dokumen'],
                                'nama_berkas'       => $this->upload->data('file_name'),
                                'mime-type'         => $this->upload->data('file_type'),   
                                'Pengupload'        => $this->session->userdata('no_user'),
                                'tanggal_upload'    => date('Y/m/d' )
                                );    
                                $this->db->insert('data_berkas',$data_berkas); 
                        }
                        $keterangan = $this->session->userdata('nama_lengkap')." Membuat Client ".$data['nama_client'];
                        $this->histori($keterangan);
                        $status[] = array(
                        "status"        => "success",
                        "no_client"     => base64_encode($no_client),
                        "messages"      => "Jenis Client Baru Berhasil Ditambahkan"    
                        );
                        echo json_encode($status);        
                        }
                        }
                        
                        
                        }                
                        public function FormTambahKontak(){
                                echo '<div class="modal-content">
                                <div class="modal-header bg-info text-white">
                                <h6 class="modal-title" >Membuat Kontak Person</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body " >';
                                
                                echo '<form id="FormTambahKontak">
                                <input type="hidden" name="'. $this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="form-control required"  accept="text/plain">
                                
                                <label>* Nama Kontak</label>
                                <input  type="text" name="nama_kontak" id="nama_kontak" class="form-control  required nama_kontak"  accept="text/plain" placeholder="Masukan Nama Kontak">
                                
                                <label>* No Telepon / HP</label>
                                <input type="number" name="no_kontak" id="no_kontak" class="form-control  required"  accept="text/plain" placeholder="Masukan No Telepon / HP">
                                
                                <label>* Email </label>
                                <input name="email" id="email" class="form-control  required"  accept="text/plain" placeholder="Masukan Alamat Email">
                                
                                <label>* Jabatan </label>
                                <input name="jabatan" id="jabatan" class="form-control  required"  accept="text/plain" placeholder="Masukan Status Jabatan">
                                
                                </div> 
                                <div class="modal-footer">
                                <button type="button" onclick=SimpanKontak(); class="btn btn-dark simpan_pekerjaan btn-block">Simpan Kontak Baru <span class="fa fa-save"></span> </button>
                                </form>
                                </div>
                                </div>
                                ';    
                                }

                                public function SimpanKontak(){
                                        $input = $this->input->post();
                                        $this->form_validation->set_rules('nama_kontak', 'nama kontak', 'required',array('required' => 'Data ini tidak boleh kosong'));
                                        $this->form_validation->set_rules('no_kontak', 'no kontak', 'required|numeric',array('required' => 'Data ini tidak boleh kosong'));
                                        $this->form_validation->set_rules('email', 'email', 'required|valid_email',array('required' => 'Data ini tidak boleh kosong'));
                                        $this->form_validation->set_rules('jabatan', 'jabatan', 'required',array('required' => 'Data ini tidak boleh kosong'));
                                        if ($this->form_validation->run() == FALSE){
                                        $status_input = $this->form_validation->error_array();
                                        $status[] = array(
                                        'status'  => 'error_validasi',
                                        'messages'=>array($status_input),    
                                        );
                                        echo json_encode($status);
                                        }else{
                                            
                                        $cek_kontak = $this->db->get_where("data_daftar_kontak",array('no_kontak'=>$input['no_kontak']));
                                        
                                        if($cek_kontak->num_rows() > 0){
                                        $status[] = array(
                                        'status'  => 'error_validasi',
                                        'messages'=>[array('no_kontak'=>'No Kontak Ini Sudah Ditambahkan')],    
                                        );
                                        
                                        echo json_encode($status);
                                        }else{
                                                $this->db->order_by('id_kontak','DESC');
                                                $this->db->limit(1);  
                                                $datak = $this->db->get('data_daftar_kontak')->row_array();
                                                
                                                if(isset($datak['id_kontak'])){
                                                        $urutan = (int) substr($datak['id_kontak'],6)+1;
                                                }else{
                                                $urutan = 1;
                                                }
                                               
                                      
                                        $id_kontak   ="Kontak".str_pad($urutan,6,"0",STR_PAD_LEFT);
                                        $data_kontak = array(
                                        'id_kontak'     => $id_kontak,    
                                        'nama_kontak'   => $input['nama_kontak'],
                                        'no_kontak'     => $input['no_kontak'],
                                        'email'         => $input['email'], 
                                        'jabatan'       => $input['jabatan']
                                        );
                                        
                                        $this->db->insert('data_daftar_kontak',$data_kontak);
                                        
                                        $keterangan                  = $this->session->userdata('nama_lengkap')." Membuat Kontak Person ".$input['nama_kontak'];
                                        $this->histori($keterangan);
                                        $status[] = array(
                                        "status"        => "success",
                                        "messages"      => "Kontak Person Baru Berhasil Ditambahkan"    
                                        );
                                        
                                        echo json_encode($status); 
                                        }    
                                        }
                                        }
                                        public function FormEditKontak(){
       
                                                $data = $this->db->get_where('data_daftar_kontak',array('id_kontak'=>$this->input->post('id_kontak')))->row_array();    

                                                echo '<div class="modal-content">
                                                <div class="modal-header bg-info text-white">
                                                <h6 class="modal-title" >Edit Kontak Person '.$data['nama_kontak'].'</h6>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                                </div>
                                                <div class="modal-body ">';
                                                
                                                echo '<form id="FormEditKontak">
                                                <input  type="hidden" name="'. $this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="form-control required"  accept="text/plain">
                                                <input  type="hidden" name="id_kontak"  id="id_kontak" value="'.$this->input->post('id_kontak').'" readonly="" class="form-control required"  accept="text/plain">
                                                
                                                <label>* Nama Kontak</label>
                                                <input value="'.$data['nama_kontak'].'"  type="text" name="nama_kontak" id="nama_kontak" class="form-control  required nama_kontak"  accept="text/plain" placeholder="Masukan Nama Kontak">
                                                
                                                <label>* No Kontak</label>
                                                <input value="'.$data['no_kontak'].'"  type="number" name="no_kontak" id="no_kontak" class="form-control  required"  accept="text/plain" placeholder="Masukan No Kontak">
                                                
                                                <label>* Email </label>
                                                <input value="'.$data['email'].'"  name="email" id="email" class="form-control  required"  accept="text/plain" placeholder="Masukan Alamat Email">
                                                
                                                <label>* Jabatan </label>
                                                <input value="'.$data['jabatan'].'"  name="jabatan" id="jabatan" class="form-control  required"  accept="text/plain" placeholder="Masukan Status Jabatan">
                                                
                                                </div> 
                                                <div class="modal-footer">
                                                <button type="button" onclick=UpdateKontak("'.$this->input->post('id_kontak').'"); class="btn btn-dark simpan_pekerjaan btn-block">Update Kontak  <span class="fa fa-save"></span> </button>
                                                </form>
                                                </div>
                                                </div>
                                                ';    
                                                
                                                }
                                                
                public function SimpanEditKontak(){
$input = $this->input->post();

$this->form_validation->set_rules('nama_kontak', 'nama kontak', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('no_kontak', 'no kontak', 'required|numeric',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('email', 'email', 'required|valid_email',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('jabatan', 'jabatan', 'required',array('required' => 'Data ini tidak boleh kosong'));
if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);
echo json_encode($status);
}else{
    
 
$data_kontak = array(
'nama_kontak'   => $input['nama_kontak'],
'no_kontak'     => $input['no_kontak'],
'email'         => $input['email'], 
'jabatan'       => $input['jabatan']
);

$this->db->update('data_daftar_kontak',$data_kontak,array('id_kontak'=>$input['id_kontak']));


$keterangan = $this->session->userdata('nama_lengkap')." Merubah Kontak Person".$input['nama_kontak'];
$this->histori($keterangan);

$status[] = array(
"status"        => "success",
"messages"      => "Proses Edit Berhasil",
'DataKontak'    => $data_kontak
);

echo json_encode($status); 
    
}
}                 

public function GenerateNPWP(){
        $this->db->select('data_client.no_identitas');
        $this->db->like('data_client.no_identitas',"99999");
        $this->db->limit(1);
        $this->db->order_by('no_identitas','desc');
        $data   = $this->db->get('data_client')->row_array();
        $urutan = (int) substr($data['no_identitas'],5)+1;
        $no_npwp      =  "99999".str_pad($urutan,10 ,0,STR_PAD_LEFT);
        $status[] = array(
                "status"        => "success",
                "messages"      => "Generate NPWP Berhasil",
                'no_npwp'    => $no_npwp
                );
                
                echo json_encode($status); 
}
     

public function FormBuatBantek(){

        $this->db->limit(1);
        $this->db->order_by('data_bantek.no_bantek','desc');
        $h_bantek  = $this->db->get('data_bantek')->row_array();
       
       if(isset($h_bantek['no_bantek'])){
       $urutan = (int) substr($h_bantek['no_bantek'],7)+1;
       }else{
       $urutan =1;
       }
       $no_bantek      =  "Bantex-".str_pad($urutan,4,"0",STR_PAD_LEFT);  

        $data_lemari = $this->db->get('data_daftar_lemari');
        echo '<div class="modal-content">
        <div class="modal-header bg-info text-white">
        <h6 class="modal-title" >Pembuatan Bantek</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>
      
        <div class="modal-body overflow-auto" style="max-height:450px;" >';
        echo "<label>No Bantex</label>
        <input type='text' value=".$no_bantek." readonly name='no_bantek' class='form-control no_bantek' ";
        
        echo "<label>Judul Bantex</label>
        <input type='text' name='judul' class='form-control judul' ";
              
        echo "<label>Pilih Lokasi Penyimpanan Bantek</label>";
        echo "<select onchange=tampilkanloker(); class='form-control no_lemari'>";
        echo "<option></option>";
        
        foreach ($data_lemari->result_array() as $lemari){
        echo "<option value=".$lemari['no_lemari'].">".$lemari['nama_tempat']."</option>";    
        }
        
        echo "</select>";
        echo "<div class='daftarloker'> </div>";
        echo "</div>
        </div>
        </div>";
}
public function DetailBantek(){
$input = $this->input->post();

$this->db->select('data_daftar_loker.no_loker,
data_bantek.no_bantek,
data_daftar_lemari.nama_tempat,
data_daftar_lemari.no_lemari');
$this->db->from('data_bantek');
$this->db->join('data_daftar_loker', 'data_daftar_loker.id_no_loker = data_bantek.id_no_loker');
$this->db->join('data_daftar_lemari', 'data_daftar_lemari.no_lemari = data_daftar_loker.no_lemari');
$this->db->where('data_bantek.no_bantek',$input['no_bantek']);
$query = $this->db->get()->row_array();  
echo "<table style=width:100%; class'table table-striped'>

<tr>
<td align='center' colspan='2'>Detail Penyimpanan Bantek</td>
</tr>

<tr>
<td>Nama Lemari</td>
<td>".$query['nama_tempat']."</td>
</tr>

<tr>
<td>No loker</td>
<td>".$query['no_loker']."</td>
</tr>
<tr>
<td align='center' colspan='2'>
<button onclick=SimpanArsipFisik('".$input['no_bantek']."','".$input['no_pekerjaan']."') class='btn btn-dark btn-block btn-sm'>Simpan Pekerjaan Kedalam Bantek</button>
</td>
</tr>

<table>";


}
public function SimpanArsipFisik(){
$input = $this->input->post();
$data = array(
'no_bantek'             =>$input['no_bantek'],
'tanggal_arsip'         =>date('Y/m/d'),
'no_petugas_arsip'      =>$this->session->userdata('no_user')
);
$this->db->update('data_pekerjaan',$data,array('no_pekerjaan'=>$input['no_pekerjaan']));
$status[] = array(
        "status"        => "success",
        "messages"      => "Pekerjaan Berhasil diarsipkan"
        );
        
        echo json_encode($status); 
}

public function DataAsisten(){
$data_asisten = $this->db->get_where('user',array('level'=>'User'));
$da = array();
foreach($data_asisten->result_array() as $d){
$da += array($d['no_user']=>$d['nama_lengkap']);        
}
echo json_encode($da);
}

public function DataClientShare(){
if($this->input->post()){
$input = $this->input->post();
$this->db->select('data_client.nama_client,
data_client.no_client,
data_jenis_pekerjaan.nama_jenis,
data_pekerjaan.no_pekerjaan');
$this->db->from('data_pekerjaan');
$this->db->join('data_client','data_client.no_client = data_pekerjaan.no_client');
$this->db->join('data_jenis_pekerjaan','data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->db->where_in('data_pekerjaan.status_pekerjaan',array('ArsipProses','Proses'));
$this->db->where('data_pekerjaan.no_client',$input['no_client']);
$query = $this->db->get(); 

echo '<div class="modal-content ">
<div class="modal-header bg-dark">
<h6 class="modal-title text-white" id="exampleModalLabel text-center ">Pilih Jenis Pekerjaan <span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<form id="PihakTerlibat">';
foreach($query->result_array() as $d){
  if($input['no_pekerjaan']  != $d['no_pekerjaan']){      
        echo'<div class="form-check form-check border-bottom mb-4">
        <input class="form-check-input" name="pihak"  type="checkbox" id="'.$d['nama_jenis'].'" value="'.$d['no_pekerjaan'].'">
        <label class="form-check-label" for="'.$d['nama_jenis'].'">'.$d['nama_jenis'].'</label>
       </div>';
  }
}     
        

echo "</form></div>";

echo "<div class='modal-footer'>
<button type='button' onclick=ProsesBagikan('".$input['no_berkas']."','".$input['no_pekerjaan']."'); class='btn btn-info btn-md btn-block'>Bagikan <span class='fa fa-share-alt'></span></button>
</div>";
echo"</div></div>";
}else{
redirect(404);        
}        
}

public function ProsesBagikan(){
if($this->input->post()){
$input = $this->input->post();

if(!$this->input->post('pihak')){
        $status_messages=array(
                'status'   =>'warning',
                'messages'   =>'Pilih minimal 1 pihak terlibat untuk membagikan file',
                );        
}else{
$data_berkas = $this->db->get_where('data_berkas',array('no_berkas'=>$input['no_berkas']));

$this->db->select('data_client.nama_folder,
data_client.no_client,
data_berkas.nama_berkas,
data_berkas.nama_berkas,
data_berkas.no_nama_dokumen,
data_berkas.mime-type');

$this->db->from('data_berkas');
$this->db->join('data_client','data_client.no_client = data_berkas.no_client');
$this->db->where('data_berkas.no_berkas',$input['no_berkas']);
$data_awal = $this->db->get()->row_array(); 

$status = array();
for($a=0; $a<count($input['pihak']); $a++){

$this->db->limit(1);
$this->db->order_by('data_berkas.no_berkas','desc');
$h_berkas       = $this->db->get('data_berkas')->row_array();

if(isset($h_berkas['no_berkas'])){
$urutan = (int) substr($h_berkas['no_berkas'],10)+1;
}else{
$urutan =1;
}

$no_berkas = "BK".date('Ymd' ).str_pad($urutan,10,0,STR_PAD_LEFT);


$data_berkas = array(
'no_berkas'         => $no_berkas,    
'no_client'         => $data_awal['no_client'],    
'no_pekerjaan'      => $input['pihak'][$a],
'no_nama_dokumen'   => $data_awal['no_nama_dokumen'],
'nama_berkas'       => $data_awal['nama_berkas'],
'mime-type'         => $data_awal['mime-type'],   
'Pengupload'        => $this->session->userdata('no_user'),
'tanggal_upload'    => date('Y/m/d' ),
'status_berkas'     => 'Selesai',
); 
$this->db->insert('data_berkas',$data_berkas); 

$data_meta = $this->db->get_where('data_meta_berkas',array('no_berkas'=>$input['no_berkas']));
foreach($data_meta->result_array() as $d){
$meta = array(
'no_berkas'     =>$no_berkas,
'nama_meta'     =>$d['nama_meta'],
'value_meta'    =>$d['value_meta']        
);
$this->db->insert('data_meta_berkas',$meta);
}
                
                
                
             

$status[] = array(
            'messages'=>"Proses Link File Ke Pekerjaan Berhasil",
            'status'  =>'success'
             ); 
}

}
$status_messages=array(
'data_kopi' =>$status,
'status'   =>'success',
);


echo json_encode($status_messages);
}else{
redirect(404);        
}

}

public function LihatSemuaDokumen(){
if($this->input->post('no_client')){


$input = $this->input->post();
$this->db->select('data_jenis_pekerjaan.nama_jenis,data_pekerjaan.no_pekerjaan,data_pekerjaan.status_pekerjaan');
$this->db->from('data_pemilik');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_pemilik.no_pekerjaan');
$this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->db->where('data_pemilik.no_client',$input['no_client']);
$query = $this->db->get();  
foreach($query->result_array() as $d){

        $this->db->select('data_client.nama_folder,'
        . 'data_berkas.nama_berkas,'
        . 'data_berkas.no_berkas,'
        . 'data_client.nama_folder,'
        . 'nama_dokumen.nama_dokumen');
        $this->db->from('data_berkas');
        $this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
        $this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
        $this->db->where('data_berkas.no_pekerjaan',$d['no_pekerjaan']);
        $this->db->where('data_berkas.no_client',$input['no_client']);
        $this->db->where('nama_dokumen.penunjang_client',NULL);
        $dokumenpekerjaan = $this->db->get();  
        
        $this->db->select('data_dokumen_utama.jenis,'
        . 'data_dokumen_utama.tanggal_akta,'
        . 'data_dokumen_utama.id_data_dokumen_utama,'
        . 'data_dokumen_utama.nama_file,'
        . 'data_client.nama_folder,'
        . 'data_dokumen_utama.no_akta');
        $this->db->from('data_dokumen_utama');
        $this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_dokumen_utama.no_pekerjaan');
        $this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
        $this->db->where('data_dokumen_utama.no_pekerjaan',$d['no_pekerjaan']);
        $utama = $this->db->get();  
if($d['status_pekerjaan'] == 'ArsipSelesai' || $d['status_pekerjaan'] == 'Selesai'){
echo "<tr class='bg-success ' ><td colspan='2'>".$d['nama_jenis']."</td></tr>";        
}else{
echo "<tr class='bg-warning' ><td colspan='2'>".$d['nama_jenis']."</td></tr>";        
}
 $n=1;
foreach($dokumenpekerjaan->result_array() as $p){
        echo "<tr class='data".$p['no_berkas']."' onclick=FormLihatMeta('".$p['no_berkas']."','".$p['nama_folder']."','".$p['nama_berkas']."')>
        <td>".$n++."</td>
        <td>".$p['nama_dokumen']."</td>
        </tr>";        
        }

        foreach ($utama->result_array() as $u){
            echo "<tr>"
                ."<td>".$n++."</td>"
                ."<td colspan='2'>".$u['jenis']." No ".$u['no_akta'].""
                ."<button  onclick=LihatLampiran('".$u['nama_folder']."','".$u['nama_file']."') class='btn float-right btn-primary btn-sm'><span class='fa fa-eye'></span></button>
                <button    onclick=download_utama('".$u['id_data_dokumen_utama']."') class='btn mr-1 float-right btn-primary btn-sm'><span class='fa fa-download'></span></button></td>
                </tr>";    
           }

}
}else{
redirect(404);        
}

}
public function SimpanUtama(){

if($this->input->post()){
$input = $this->input->post();
                
                $data = array(
                'tanggal_akta'          =>$input['tanggal_akta'],   
                'nama_berkas'                 =>$input['jenis_dokumen'],
                'jenis'                 =>$input['jenis_dokumen'],
                'no_akta'               =>$input['no_akta']   
                );
          
                   $this->db->update('data_dokumen_utama',$data,array('id_data_dokumen_utama'=>$input['id_dokumen']));   
                $status[] = array(
                "status"        => "success",
                "messages"      => "File utama berhasil ditambahkan"    
                );
               
                echo json_encode($status);        

}else{
redirect(404);        
}

            
}

public function ShowGrafikBerkas(){
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
        
        }

/*
public function DetailDokumenPekerjaan(){
if($this->input->post('no_pekerjaan')){
  $input = $this->input->post();

        $this->db->select('data_client.nama_folder,'
        . 'data_berkas.nama_berkas,'
        . 'data_berkas.no_berkas,'
        . 'data_client.nama_folder,'
        . 'nama_dokumen.nama_dokumen');
        $this->db->from('data_berkas');
        $this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
        $this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
        $this->db->where('data_berkas.no_pekerjaan',$input['no_pekerjaan']);
        $this->db->where('data_berkas.no_client',$input['no_client']);
        $this->db->where('nama_dokumen.penunjang_client',NULL);
        $dokumenpekerjaan = $this->db->get();  

        $this->db->select('data_dokumen_utama.jenis,'
        . 'data_dokumen_utama.tanggal_akta,'
        . 'data_dokumen_utama.id_data_dokumen_utama,'
        . 'data_dokumen_utama.nama_file,'
        . 'data_client.nama_folder,'
        . 'data_dokumen_utama.no_akta');
        $this->db->from('data_dokumen_utama');
        $this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_dokumen_utama.no_pekerjaan');
        $this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
        $this->db->where('data_dokumen_utama.no_pekerjaan',$input['no_pekerjaan']);
        $utama = $this->db->get();  
  
        
echo '<div class="modal-content ">
<div class="modal-header bg-dark">
<h6 class="modal-title text-white" id="exampleModalLabel text-center ">Detail Dokumen Pekerjaan<span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">';
echo "<div class='row'>
<div class='col'>";
echo "<table class='table table-striped table-bordered'>
<tr><th class=' bg-info text-center text-white' colspan='2'>Dokumen Penunjang Pekerjaan</th></tr>";
if($dokumenpekerjaan->num_rows() > 0 ){
foreach($dokumenpekerjaan->result_array() as $p){
echo "<tr class='data".$p['no_berkas']."' onclick=FormLihatMeta('".$p['no_berkas']."','".$p['nama_folder']."','".$p['nama_berkas']."')>
<td>".$p['nama_dokumen']."</td>
</tr>";        
}
}else{
echo "<tr><td colspan='2'>Dokumen Penunjang Pekerjaan Tidak Tersedia</td></tr>";
}

echo "</table>";
echo"</div>
<div class='col'>";
echo "<table class='table table-striped table-bordered'>
<tr><th class='bg-info text-center text-white' colspan='4'>Dokumen Utama Pekerjaan</th></tr>
<tr>
<th class='text-center' >Jenis</th>
<th class='text-center' >No Akta</th>
<th class='text-center' >Tanggal Akta</th>
<th class='text-center' >Aksi</th>
</tr>";
if($utama->num_rows() > 0 ){
        foreach($utama->result_array() as $u){
        echo "<tr class='data".$u['id_data_dokumen_utama']."'>
        <td>".$u['jenis']."</td>
        <td>".$u['no_akta']."</td>
        <td >".$u['tanggal_akta']."</td>
        <td style='width:28%;' class='text-center'>
        <button onclick=LihatLampiran('".$u['nama_folder']."','".$u['nama_file']."') class='btn btn-md btn-info'><span class='fa fa-eye'></span></button>
        <button onclick=download_utama('".$u['id_data_dokumen_utama']."') class='btn btn-md btn-info'><span class='fa fa-download'></span></button></td>
        </tr>";        
        }
        }else{
        echo "<tr><td colspan='4'>Dokumen Utama Pekerjaan Tidak Tersedia</td></tr>";
        }

echo "</table>";
echo"</div>";
echo"</div>
</div>";
echo"</div></div>";
}
}*/
}

