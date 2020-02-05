<?php 
class DataArsip extends CI_Controller{
public function __construct() {
parent::__construct();
$this->load->helper('download');
$this->load->library('session');
$this->load->model('M_data_arsip');
$this->load->library('Datatables');
$this->load->library('upload');
$this->load->library('form_validation');
if(!$this->session->userdata('username')){
redirect(base_url('Menu'));
}
}

public function index(){
$this->load->view('umum/V_header');
$this->load->view('DataArsip/Search');
}


public function cari_dokumen(){
if($this->input->get()){
$input = $this->input->get();
if(strlen($input['term']) > 0){
$data_dokumen         = $this->M_data_arsip->pencarian_data_dokumen($input['term']);

if($data_dokumen->num_rows() == 0){
$json_data_dokumen[] = array(
"Tidak ditemukan data dokumen"    
);
    
}else{
     
foreach ($data_dokumen->result_array() as $d){
$json_data_dokumen[] = array(    
'value'               =>$input['term'],
'label'               =>$d['value_meta'],
'nama_dokumen'        =>$d['nama_dokumen'],
'nama_meta'           =>str_replace('_', ' ',$d['nama_meta']),
'value_meta'          =>str_replace('_', ' ',$d['value_meta']),
'nama_client'         =>$d['nama_client'],
);  
}
echo json_encode($json_data_dokumen);

}
}
}else{
redirect(404);    
}
}


public function check_akses(){
if($this->input->post()){

$data = $this->db->get_where('sublevel_user',array('no_user'=>$this->session->userdata('no_user'),'sublevel'=>$this->input->post('model')));

if($data->num_rows() == 1){
$status = array(
"status"=>"success",
"pesan"=>"Success Dashboard "
);
$this->session->set_userdata(array('sublevel'=>$this->input->post('model')));
}else if($this->session->userdata('level') == 'Super Admin'){

$status = array(
"status"=>"success",
"pesan"=>"Success Dashboard "
);

}else{
$status = array(
"status"=>"error",
"pesan"=>"Anda tidak memiliki akses kemenu tersebut "
);

}
echo json_encode($status);


}else{
redirect(404);	
}
}

public function Pencarian(){
if($this->input->get('search')){    
    
$this->load->view('umum/V_header');
$this->load->view('DataArsip/HasilPencarian');
}else{
    redirect(base_url());    
}    
}

public function keluar(){
$this->session->sess_destroy();
redirect (base_url('Login'));
}

public function ProsesPencarian(){
$input = $this->input->get();
if($input['kategori'] == "dokumen_penunjang"){
$this->HasilPencarianDokumenPenunjang($input);
}else if($input['kategori'] == "dokumen_utama"){
$this->HasilPencarianDokumenUtama($input);    
}else if($input['kategori'] == "data_client"){
$this->HasilPencarianClient($input);        
}else{
$this->HasilPencarianDokumenPenunjang($input);    
}

}


public function HasilPencarianDokumenPenunjang($input){
    
$this->db->select('data_meta_berkas.nama_meta,'
. 'data_meta_berkas.value_meta,'
. 'data_client.nama_client,'
. 'data_client.no_client,'
. 'data_berkas.nama_berkas,'
. 'nama_dokumen.nama_dokumen,'
. 'nama_dokumen.no_nama_dokumen,'
. 'data_meta_berkas.no_berkas,');
$this->db->from('data_meta_berkas');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_meta_berkas.no_pekerjaan');
$this->db->join('data_berkas', 'data_berkas.no_berkas = data_meta_berkas.no_berkas');
$this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_meta_berkas.no_nama_dokumen');
$this->db->group_by('data_meta_berkas.no_berkas');
$this->db->like('data_meta_berkas.value_meta',$input['search']);
$data_dokumen_penunjang = $this->db->get();

foreach ($data_dokumen_penunjang->result_array() as $penunjang){
$ext = pathinfo($penunjang['nama_berkas'], PATHINFO_EXTENSION);
echo "<div onclick=LihatDokumenPenunjang('".$penunjang['no_berkas']."'); class='col hasil  m-1 d-flex justify-content-center text-center'>
<div style='width:210px; height:210px;' class='card'>
<div class='card-body'>";
if($ext =="docx" || $ext =="doc" ){
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/wordicon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}else if($ext == "xlx"  || $ext == "xlsx"){
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/excelicon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}else if($ext == "PDF"  || $ext == "pdf"){
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/pdficon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}else if($ext == "JPG"  || $ext == "jpg" || $ext == "png"  || $ext == "PNG"){
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/imageicon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}else{
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/othericon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}
echo "
</div>
<div class='card-footer'><span style='font-size:12px;'>".$penunjang['nama_dokumen']."<br>".$penunjang['nama_client']."</span></div>
</div>
</div>";
}

echo "</div>";
}

public function HasilPencarianDokumenUtama($input){
$this->db->select('data_dokumen_utama.nama_berkas,'
. 'data_dokumen_utama.tanggal_akta,'
. 'data_dokumen_utama.nama_file,'
. 'data_client.nama_client,'
. 'data_dokumen_utama.id_data_dokumen_utama,'
. 'data_dokumen_utama.jenis');
$this->db->from('data_dokumen_utama');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_dokumen_utama.no_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');

$this->db->like('data_dokumen_utama.nama_berkas',$input['search']);

$dokumen_utama= $this->db->get();

foreach ($dokumen_utama->result_array() as $utama){
$ext = pathinfo($utama['nama_file'], PATHINFO_EXTENSION);
echo "<div onclick=LihatDokumenPenunjang('".$utama['id_data_dokumen_utama']."'); class='col hasil  m-1 d-flex justify-content-center text-center'>
<div style='width:210px; height:210px;' class='card'>
<div class='card-body'>";
if($ext =="docx" || $ext =="doc" ){
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/wordicon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}else if($ext == "xlx"  || $ext == "xlsx"){
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/excelicon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}else if($ext == "PDF"  || $ext == "pdf"){
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/pdficon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}else if($ext == "JPG"  || $ext == "jpg" || $ext == "png"  || $ext == "PNG"){
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/imageicon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}else{
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/othericon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}
echo "
</div>
<div class='card-footer'><span style='font-size:12px;'>".$utama['nama_berkas']."<br>".$utama['nama_client']."</span></div>
</div>
</div>";
}

echo "</div>";    
}

public function HasilPencarianClient($input){
$this->db->select('data_client.nama_client,'
. 'data_client.jenis_client,'
. 'data_client.no_client');
$this->db->from('data_client');
$this->db->like('data_client.nama_client',$input['search']);
$data_client = $this->db->get();
 foreach ($data_client->result_array() as $client){
        echo "<div onclick=lihat_berkas_client('".base64_encode($client['no_client'])."'); class='col hasil  m-1 d-flex justify-content-center text-center'>
        <div style='width:210px; height:210px;' class='card'>
         <div class='card-body'>";
         if($client['jenis_client'] =="Badan Hukum" ){
          echo"<img style='width:80px; height:80px;'  src='".base_url('assets/badanhukumicon.png')."' alt='MS WORD' class='  img-thumbnail'>";
        }else if($client['jenis_client'] =="Perorangan"){
            echo"<img style='width:80px; height:80px;'  src='".base_url('assets/peroranganicon.png')."' alt='MS WORD' class='  img-thumbnail'>";
          }

        echo "
        </div>
        <div class='card-footer'><span style='font-size:12px;'>".$client['nama_client']."</span></div>
        </div></div>";
 
      }   
}

}