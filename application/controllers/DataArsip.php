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
$this->load->library('pagination');
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
if($this->input->get('search') && $this->input->get('kategori')){    

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
$total                  = $this->M_data_arsip->pencarian_data_dokumen($input['search'])->num_rows();    
$config['base_url']     = base_url('DataArsip/ProsesPencarian/');
$config['total_rows']   = $total;
$config['per_page']     = 15;
$config['display_pages'] = TRUE;


$from = $this->uri->segment(3);    

// Membuat Style pagination untuk BootStrap v4
$config['first_link']       = 'Awal';
$config['last_link']        = 'Terakhir';
$config['next_link']        = 'Selanjutnya';
$config['prev_link']        = 'Sebelumnya';
$config['full_tag_open']    = '<div class="pagging text-center text-white"><nav><ul class="pagination justify-content-left">';
$config['full_tag_close']   = '</ul></nav></div>';
$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
$config['num_tag_close']    = '</span></li>';
$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
$config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
$config['prev_tagl_close']  = '</span>Next</li>';
$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
$config['first_tagl_close'] = '</span></li>';
$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
$config['last_tagl_close']  = '</span></li>';

$this->pagination->initialize($config);   

$data_dokumen_penunjang  = $this->M_data_arsip->HasilPencarianDokumenPenunjang($input,$config['per_page'],$from);
if($data_dokumen_penunjang->num_rows() > 0){
foreach ($data_dokumen_penunjang->result_array() as $penunjang){
$ext = pathinfo($penunjang['nama_berkas'], PATHINFO_EXTENSION);
echo "<div class='row  mt-2 mb-2'>
<div class='col'>
<div class='row'>
<div class='col-md-9'  onclick=LihatFile('dokumen_penunjang','".$penunjang['no_berkas']."');>
Nama Dokumen    : ".$penunjang['nama_dokumen']."<br>
Nama Client     : ".$penunjang['nama_client']."</br>
Hasil Pencarian : ".str_replace('_', ' ',$penunjang['nama_meta'])."  ".str_replace('_', ' ',$penunjang['value_meta'])."</br>
</div>
<div class='col text-center'>
";
if($ext =="docx" || $ext =="doc" ){
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/wordicon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}else if($ext == "xlx"  || $ext == "xlsx"){
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/excelicon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}else if($ext == "PDF"  || $ext == "pdf"){
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/pdficon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}else if($ext == "JPG"  || $ext == "jpg" || $ext == "png"  || $ext == "PNG"){
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/imageicon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}else{
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/wordicon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}
echo "
</div>
</div>
</div>
</div>
<hr>";

}
echo " <div id='pagination'>".$this->pagination->create_links()."</div>";
echo "</div>";
}else{
echo "<div class='row  mt-2 mb-2'>
<div class='col mt-5 text-center justify-content-center'>";
echo "<img style='width:auto; height:100px;' src=". base_url('assets/404.png').">";    
echo"</div></div>";

}
}

public function HasilPencarianDokumenUtama($input){
$total = $this->M_data_arsip->pencarian_data_dokumen_utama($input['search'])->num_rows();

$config['base_url']     = base_url('DataArsip/ProsesPencarian/');
$config['total_rows']   = $total;
$config['per_page']     = 15;
$config['display_pages'] = TRUE;


$from = $this->uri->segment(3);    

// Membuat Style pagination untuk BootStrap v4
$config['first_link']       = 'Awal';
$config['last_link']        = 'Terakhir';
$config['next_link']        = 'Selanjutnya';
$config['prev_link']        = 'Sebelumnya';
$config['full_tag_open']    = '<div class="pagging text-white text-center"><nav><ul class="pagination justify-content-left">';
$config['full_tag_close']   = '</ul></nav></div>';
$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
$config['num_tag_close']    = '</span></li>';
$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
$config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
$config['prev_tagl_close']  = '</span>Next</li>';
$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
$config['first_tagl_close'] = '</span></li>';
$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
$config['last_tagl_close']  = '</span></li>';

$this->pagination->initialize($config);       

$dokumen_utama = $this->M_data_arsip->HasilPencarianDokumenUtama($input,$config['per_page'],$from);
if($dokumen_utama->num_rows() > 0){
foreach ($dokumen_utama->result_array() as $utama){
echo "<div class='row  mt-2 mb-2'>
<div class='col'>
<div class='row'>
<div class='col-md-9'>
Jenis Dokumen    : ".$utama['jenis']."<br>
Nama Client     : ".$utama['nama_client']."</br>
Hasil Pencarian : ".$utama['nama_berkas']."</br>
</div>
<div class='col text-center' onclick=LihatFile('dokumen_utama','".$utama['id_data_dokumen_utama']."') >
";

$ext = pathinfo($utama['nama_file'], PATHINFO_EXTENSION);

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
</div><hr>";
}
echo " <div id='pagination'>".$this->pagination->create_links()."</div>";
echo "</div>";    
}else{
echo "<div class='row  mt-2 mb-2'>
<div class='col mt-5 text-center justify-content-center'>";
echo "<img style='width:auto; height:100px;' src=". base_url('assets/404.png').">";    
echo"</div></div>";

}
}

public function HasilPencarianClient($input){
$total = $this->M_data_arsip->pencarian_data_client($input['search'])->num_rows();

$config['base_url']     = base_url('DataArsip/ProsesPencarian/');
$config['total_rows']   = $total;
$config['per_page']     = 24;
$config['display_pages'] = TRUE;


$from = $this->uri->segment(3);    

// Membuat Style pagination untuk BootStrap v4
$config['first_link']       = 'Awal';
$config['last_link']        = 'Terakhir';
$config['next_link']        = 'Selanjutnya';
$config['prev_link']        = 'Sebelumnya';
$config['full_tag_open']    = '<div class="pagging text-white text-center"><nav><ul class="pagination justify-content-left">';
$config['full_tag_close']   = '</ul></nav></div>';
$config['num_tag_open']     = '<li class="page-item"><span class="page-link">';
$config['num_tag_close']    = '</span></li>';
$config['cur_tag_open']     = '<li class="page-item active"><span class="page-link">';
$config['cur_tag_close']    = '<span class="sr-only">(current)</span></span></li>';
$config['next_tag_open']    = '<li class="page-item"><span class="page-link">';
$config['next_tagl_close']  = '<span aria-hidden="true">&raquo;</span></span></li>';
$config['prev_tag_open']    = '<li class="page-item"><span class="page-link">';
$config['prev_tagl_close']  = '</span>Next</li>';
$config['first_tag_open']   = '<li class="page-item"><span class="page-link">';
$config['first_tagl_close'] = '</span></li>';
$config['last_tag_open']    = '<li class="page-item"><span class="page-link">';
$config['last_tagl_close']  = '</span></li>';

$this->pagination->initialize($config);    


$data_client = $this->M_data_arsip->HasilPencarianDataClient($input,$config['per_page'],$from);
if($data_client->num_rows() > 0){
echo "<div class='row  '>";
foreach ($data_client->result_array() as $client){

echo '<div class="col-md-2 text-center p-3 "  onclick=LihatClient("'.$client['no_client'].'")>

<svg class="text-info hover" width="5em" height="5em" viewBox="0 0 16 16" class="bi bi-folder-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M9.828 3h3.982a2 2 0 0 1 1.992 2.181l-.637 7A2 2 0 0 1 13.174 14H2.826a2 2 0 0 1-1.991-1.819l-.637-7a1.99 1.99 0 0 1 .342-1.31L.5 3a2 2 0 0 1 2-2h3.672a2 2 0 0 1 1.414.586l.828.828A2 2 0 0 0 9.828 3zm-8.322.12C1.72 3.042 1.95 3 2.19 3h5.396l-.707-.707A1 1 0 0 0 6.172 2H2.5a1 1 0 0 0-1 .981l.006.139z"/>
</svg><br>
'.$client['nama_client'].'</br>
</div>';
}
echo "</div>";    
echo " <div id='pagination' class='mt-3'>".$this->pagination->create_links()."</div>";
echo "</div>";    
}else{
echo "<div class='row  mt-2 mb-2'>
<div class='col mt-5 text-center justify-content-center'>";
echo '<svg class="text-info m-2" width="10em" height="10em" viewBox="0 0 16 16" class="bi bi-emoji-frown" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
<path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
<path fill-rule="evenodd" d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.498 3.498 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.498 4.498 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683z"/>
<path d="M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
</svg> <br> Pencarian Tidak Ditemukan';    
echo"</div>";

}

}

public function BukaFile(){
if($this->input->post()){
$input = $this->input->post();
/* dokumen penunjang */
if($input['jenis_dokumen']== "dokumen_penunjang"){
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
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_berkas.no_pekerjaan','left');
$this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
$this->db->group_by('data_meta_berkas.no_berkas');
$this->db->where('data_berkas.no_berkas',$input['no_dokumen']);
$query = $this->db->get()->row_array();

$ext = pathinfo($query['nama_berkas'], PATHINFO_EXTENSION);
if($ext =="docx" || $ext =="doc" || $ext =="pptx" ){
$data[] =array(
'status'   =>'Dokumen Download',
'messages' =>$query['nama_dokumen'].' Dokumen Berhasil di download',
'link'     =>base_url("berkas/".$query['nama_folder']."/".$query['nama_berkas']),
);
}else if($ext == "JPG"  || $ext == "jpg" || $ext == "png"  || $ext == "PNG"){
$data[] = array(
'titel'  =>$query['nama_dokumen']." ".$query['nama_client'],
'link'   =>'<iframe class="embed-responsive-item " src="'.base_url('DataArsip/BukaGambar/dokumen_penunjang/'.$query['no_berkas']).'"></iframe>',
'status' =>'Dokumen Lihat'
);
}else{    
$data[] = array(
'titel'  =>$query['nama_dokumen']." ".$query['nama_client'],
'link'   =>'<iframe class="embed-responsive-item " src="'.base_url("berkas/".$query['nama_folder']."/".$query['nama_berkas']).'" ></iframe>',
'status' =>'Dokumen Lihat'
);
}
/* dokumen utama */

}else if($input['jenis_dokumen'] == 'dokumen_utama'){
$this->db->select('data_dokumen_utama.nama_berkas,'
. 'data_dokumen_utama.tanggal_akta,'
. 'data_dokumen_utama.nama_file,'
. 'data_client.nama_client,'
. 'data_client.nama_folder,'
. 'data_dokumen_utama.id_data_dokumen_utama,'
. 'data_dokumen_utama.jenis');
$this->db->from('data_dokumen_utama');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_dokumen_utama.no_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->where('data_dokumen_utama.id_data_dokumen_utama',$input['no_dokumen']);
$query = $this->db->get()->row_array();

$ext = pathinfo($query['nama_file'], PATHINFO_EXTENSION);

if($ext =="docx" || $ext =="doc" || $ext =="pptx" ){
$data[] =array(
'status'   =>'Dokumen Download',
'messages' =>$query['jenis'].' Dokumen Berhasil di download',
'link'     =>base_url("berkas/".$query['nama_folder']."/".$query['nama_file']),
);
}else if($ext == "JPG"  || $ext == "jpg" || $ext == "png"  || $ext == "PNG"){
$data[] = array(
'titel'  =>$query['jenis']." ".$query['nama_client'],
'link'   =>'<iframe class="embed-responsive-item " src="'.base_url("berkas/".$query['nama_folder']."/".$query['nama_file']).'"></iframe>',
'status' =>'Dokumen Lihat'
);
}else{    
$data[] = array(
'titel'  =>$query['jenis']." ".$query['nama_client'],
'link'   =>'<iframe class="embed-responsive-item " src="'.base_url("berkas/".$query['nama_folder']."/".$query['nama_file']).'" ></iframe>',
'status' =>'Dokumen Lihat'
);
}

}
echo json_encode($data);
}else{
redirect(404);
}
}

public function BukaGambar(){
$jenis_dokumen = $this->uri->segment(3);
$no_berkas     = $this->uri->segment(4);

if($jenis_dokumen == 'dokumen_penunjang'){
$this->db->select('data_meta_berkas.nama_meta,'
. 'data_meta_berkas.value_meta,'
. 'nama_dokumen.nama_dokumen,'
. 'data_meta_berkas.no_berkas,'
. 'data_client.nama_client,'
. 'data_client.nama_folder,'
. 'data_berkas.nama_berkas');
$this->db->from('data_berkas');
$this->db->join('data_meta_berkas', 'data_meta_berkas.no_berkas = data_berkas.no_berkas','left');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_berkas.no_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->where('data_berkas.no_berkas',$no_berkas);
$query = $this->db->get()->row_array();    
echo '​<div class="container" >'
. '<div class="row">'
. '<div class="col-md-6">'
. '<img  src="'.base_url("berkas/".$query['nama_folder']."/".$query['nama_berkas']).'">'
. '​</div></div></div>';


}
}

public function LihatClient(){
if($this->input->post()){
$input  = $this->input->post();

$this->db->select('data_client.nama_client,'
. 'data_client.nama_folder,'
. 'data_client.no_client,'
. 'data_pekerjaan.no_bantek,'
. 'data_pekerjaan.no_pekerjaan,'
. 'data_pekerjaan.status_pekerjaan,'
. 'data_pekerjaan.tanggal_selesai,'
. 'user.nama_lengkap as asisten,'
. 'data_daftar_lemari.nama_tempat,'
. 'data_daftar_loker.no_loker,'
. 'data_jenis_pekerjaan.nama_jenis,'
. 'data_bantek.status_bantek');
$this->db->from('data_pemilik');
$this->db->join('data_client', 'data_client.no_client = data_pemilik.no_client','left');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_pemilik.no_pekerjaan','left');
$this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan','left');
$this->db->join('user', 'user.no_user = data_pekerjaan.no_user','left');
$this->db->join('data_bantek', 'data_bantek.no_bantek = data_pekerjaan.no_bantek','left');
$this->db->join('data_daftar_loker', 'data_daftar_loker.id_no_loker = data_bantek.id_no_loker','left');
$this->db->join('data_daftar_lemari', 'data_daftar_lemari.no_lemari = data_daftar_loker.no_lemari','left');
$this->db->where('data_pemilik.no_client',$input['no_client']);
$query = $this->db->get();    
$static  = $query->row_array();    


$this->db->select('nama_dokumen.nama_dokumen,'
. 'data_berkas.no_berkas,'
. 'data_client.nama_folder,'
. 'data_berkas.nama_berkas');
$this->db->from('data_client');
$this->db->join('data_berkas', 'data_berkas.no_client = data_client.no_client');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
$this->db->where('data_client.no_client',$input['no_client']);
$this->db->where('nama_dokumen.penunjang_client','penunjang_client');

$penunjang = $this->db->get();    
$html = "<div class='row'>"
. "<div class='col-md-8 detail_pekerjaan'>
<div class='row'>";
foreach ($query->result_array() as $pekerjaan){
    
     if(!isset($pekerjaan['tanggal_selesai'])){
          $tanggal = "-";
         }else{
          $date = str_replace('/', '-', $pekerjaan['tanggal_selesai']);
          $tanggal =date('d F Y', strtotime($date));
         }    
                  
if($pekerjaan['status_pekerjaan'] =='ArsipSelesai' || $pekerjaan['status_pekerjaan'] =='Selesai'){
 
  

$html .="<div class='col-md-3  text-center p-2' onclick=LihatDetailPekerjaan('".$pekerjaan['no_pekerjaan']."','".$pekerjaan['no_client']."');>";
$html .='<i class="fa fa-4x  hover text-info fa-briefcase" aria-hidden="true"></i>';
$html .='<br><span>'.$pekerjaan['nama_jenis'].'<br> ('.$tanggal.')</span>';
$html .="</div>";     
}else{
     $html .="<div class='col-md-3 text-center p-2' onclick=LihatDetailPekerjaan('".$pekerjaan['no_pekerjaan']."','".$pekerjaan['no_client']."');>";
     $html .='<i class="fa fa-4x   hover text-danger fa-briefcase" aria-hidden="true"></i>';
     $html .='<br><span>'.$pekerjaan['nama_jenis'].'<br> (Dalam Proses)</span>';
     $html .="</div>";           
}

}
$html.="</div></div><div class='col'>";
$html .="<table class='table   table-bordered table-hover table-striped'>"
. "<tr>"
. "<th  class='text-center'>Dokumen Client</th>"
. "</tr>";
foreach ($penunjang->result_array() as $penunjang){
$ext = pathinfo($penunjang['nama_berkas'], PATHINFO_EXTENSION);

$html .="<tr class=' sortable data".$penunjang['no_berkas']."' onclick=FormLihatMeta('".$penunjang['no_berkas']."','".$penunjang['nama_folder']."','".$penunjang['nama_berkas']."')>"
."<td>".$penunjang['nama_dokumen']."</td>"
."</tr>";    
}

$html.="<tr id='LihatSemua'><td colspan='2'><button onclick=LihatSemuaDokumen('".$input['no_client']."'); class='btn btn-info btn-block'>Lihat Semua Dokumen <span class='fa fa-eye'></span></button></td></tr>";


$html .="</table></div></div></div>";
$data[] =array(
'titel'     =>$static['nama_client'],    
'linkhtml'  => $html,
);

echo json_encode($data);

}else{
redirect(404);    
}
}

public function PengaturanAkun(){
$this->load->view('umum/V_header');
$this->load->view('DataArsip/PengaturanAkun');
}

public function PengaturanPersonal(){
$no_user    = $this->session->userdata('no_user');
$static     = $this->db->get_where('user',array('no_user'=>$no_user))->row_array();    


echo "<div class='mt-5 '>"
. "<div class='row'><div class='col text-bottom p-4'>";    
echo "<button onclick=BukaFile(); class='btn btn-warning btn-sm btn-block m-1'>Edit Foto</button>";
echo "<button onclick=EditFile(); class='btn btn-warning btn-sm btn-block m-1'>Edit Akun</button>";
echo "<button onclick=UpdatePassword(); class='btn btn-warning btn-sm btn-block m-1'>Perbaharui Password</button>";
echo "</div>"
. "<div class='col text-center'>";
if(!file_exists('./uploads/user/'.$static['foto'])){ 
echo '<img style="width:150px; height: 150px;" src="'.base_url('uploads/user/no_profile.jpg').'" img="" class="img " >';    
}else{ 
if($static['foto'] != NULL){
echo '<img style="width:150px; height: 150px;" src="'.base_url('uploads/user/'.$static['foto']).'" img="" class="img " >';    
}else{ 
echo '<img style="width:150px; height: 150px;" src="'.base_url('uploads/user/no_profile.jpg').'" img="" class="img " >';    
} 
}
echo "<br>".$this->session->userdata('nama_lengkap');
echo"</div></div>";

echo "<form id='edit_akun'>";
echo '<input type="hidden" name="'. $this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="form-control required"  accept="text/plain">';
echo "<label>Username : </label>"
     ."<input type='text' name='username' id='username' class='form-control form-control-sm' disabled value='".$static['username']."'>";

echo "<label>Nama Lengkap : </label>"
     ."<input type='text' name='nama_lengkap' id='nama_lengkap' class='form-control edit form-control-sm' disabled value='".$static['nama_lengkap']."'>";

echo "<label>Email : </label>"
     ."<input type='text' name='email' id='email' class='form-control edit form-control-sm' disabled value='".$static['email']."'>";

echo "<label>Nomor Kontak : </label>"
     ."<input type='text' name='nomor_kontak' id='nomor_kontak' class='form-control edit form-control-sm' disabled value='".$static['phone']."'>";

 echo "<hr><button style='display:none;'  onclick=SimpanPerubahan(); type='button' class='btn btn-success btn-sm btn-block edit-button'>Simpan Perubahan</button> </form>";

 
echo "<form id='update_password' style='display:none;'>";
echo '<input type="hidden" name="'. $this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="form-control required"  accept="text/plain">';
echo "<label>Masukan Password Lama : </label>"
     ."<input type='password' name='password_lama' id='password_lama' placeholder='password lama' class='form-control form-control-sm' >";

echo "<label>Masukan Password Baru : </label>"
     ."<input type='password' name='password_baru' id='password_baru' placeholder='password baru' class='form-control edit form-control-sm' >";

echo "<label>Ulangi Password baru : </label>"
     ."<input type='password' name='ulangi_password' id='ulangi_password' placeholder='ulangi password' class='form-control edit form-control-sm' >";

echo "<hr><button   onclick=SimpanPassword(); type='button' class='btn btn-success btn-sm btn-block edit-button'>Simpan Perubahan</button> </form>";
 
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

public function UpdateAkun(){
if($this->input->post()){
$input = $this->input->post();
$this->form_validation->set_rules('nama_lengkap', 'nama lengkap', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('email', 'email', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('nomor_kontak', 'nomor_kontak', 'required',array('required' => 'Data ini tidak boleh kosong'));

if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);
echo json_encode($status);
}else{
$data = array(
'nama_lengkap'=>$input['nama_lengkap'],
'email'       =>$input['email'],
'phone'       =>$input['nomor_kontak']    
);
$this->session->set_userdata($data);
$this->db->update('user',$data,array('no_user'=>$this->session->userdata('no_user')));
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

public function UpdatePassword(){
if($this->input->post()){
$input = $this->input->post();
$this->form_validation->set_rules('password_lama', 'password lama', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('password_baru', 'password baru', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('ulangi_password', 'ulangi password', 'required',array('required' => 'Data ini tidak boleh kosong'));

if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);
echo json_encode($status);
}else{
    
$cek_password_lama = $this->db->get_where('user',array('no_user'=>$this->session->userdata('no_user'),'password'=>md5($input['password_lama'])));    
if($cek_password_lama->num_rows() == 1 ){

if($input['password_baru'] != $input['ulangi_password']){    
$status[] = array(
"status"    =>"error_validasi",
"messages"  =>[array('password_baru'=>'Password baru tidak sama','ulangi_password'=>'Password baru tidak sama')],
);
echo json_encode($status);

}else{
$data = array('password'=> md5($input['password_baru']));    
$this->db->update('user',$data,array('no_user'=>$this->session->userdata('no_user')));    
$status[] = array(
"status"    =>"success",
"messages"  =>"Password berhasil diperbaharui",
);
echo json_encode($status);     
}
}else{
$status[] = array(
"status"    =>"error_validasi",
"messages"  =>[array('password_lama'=>'Password yang dimasukan tidaklah sama dengan password sebelumnya')],
);
echo json_encode($status);
}

}    
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
     $this->db->where('data_berkas.no_berkas',$input['no_berkas']);
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

     public function download_berkas(){
          $data = $this->M_data_arsip->data_berkas_where($this->uri->segment(3))->row_array();
          $file_path = "./berkas/".$data['nama_folder']."/".$data['nama_berkas']; 
          $info = new SplFileInfo($data['nama_berkas']);
          force_download($data['nama_dokumen'].".".$info->getExtension(), file_get_contents($file_path));
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
               echo "<tr class='text-success' ><td>".$d['nama_jenis']."</td></tr>";        
               }else{
               echo "<tr class='text-danger' ><td>".$d['nama_jenis']."</td></tr>";        
               }
               
               foreach($dokumenpekerjaan->result_array() as $p){
                       echo "<tr class='data".$p['no_berkas']."' onclick=FormLihatMeta('".$p['no_berkas']."','".$p['nama_folder']."','".$p['nama_berkas']."')>
                       <td>".$p['nama_dokumen']."</td>
                       </tr>";        
                       }
               
                       foreach ($utama->result_array() as $u){
                    
                               echo "<tr>"
                               ."<td>".$u['jenis']." No ".$u['no_akta'].""
                               ."<button  onclick=LihatLampiran('".$u['nama_folder']."','".$u['nama_file']."') class='btn float-right btn-primary btn-sm'><span class='fa fa-eye'></span></button>
                               <button    onclick=download_utama('".$u['id_data_dokumen_utama']."') class='btn mr-1 float-right btn-primary btn-sm'><span class='fa fa-download'></span></button></td>
                               </tr>";    
                          }
               
               }
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
                    ."<button onclick=LihatFile('dokumen_penunjang','".$input['no_berkas']."'); class='btn btn-primary col-5  btn-md'><span class='fa fa-eye'></span></button>"
                    ."<button onclick=cek_download('".$input['no_berkas']."'); class='btn  btn-primary ml-1 btn-md col-5'><span class='fa fa-download'></span></button>"
                    ."</div>
                    </div>";
                    
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

                        function MenuHasilPencarian($no_pekerjaan,$no_client){
                         $data = "<div class='text-center mb-3 bg-gray'>
                         <button onclick=LihatDokumenUtama('".$no_pekerjaan."','".$no_client."') class='btn  btn-sm btn-info m-1 '>Dokumen Utama <i class='fa fa-eye'></i></button>
                         <button onclick=LihatDokumenPenunjang('".$no_pekerjaan."','".$no_client."') class='btn  btn-sm btn-info  m-1'>Dokumen Penunjang <i class='fa fa-eye'></i></button>
                         <button onclick=LihatLaporanPekerjaan('".$no_pekerjaan."','".$no_client."') class='btn  btn-sm btn-info m-1'>Laporan Pekerjaan <i class='fa fa-eye'></i></button>
                         <button onclick=LihatLaporanPerizinan('".$no_pekerjaan."','".$no_client."') class='btn  btn-sm btn-info m-1'>Laporan Perizinan <i class='fa fa-eye'></i></button>
                        
                         </div><hr>";
                         
                         return $data;
                        }

                         function LihatDetailPekerjaan(){
                              if($this->input->post()){
                              $input = $this->input->post();
                              $this->db->select('');
                              $this->db->from('data_pemilik');
                              $this->db->join('data_client', 'data_client.no_client = data_pemilik.no_client');
                              $this->db->join('data_kontak_client', 'data_kontak_client.no_client = data_client.no_client','left');
                              $this->db->join('data_daftar_kontak', 'data_daftar_kontak.id_kontak = data_kontak_client.id_kontak','left');
                              $this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_pemilik.no_pekerjaan');
                              $this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
                              $this->db->join('data_bantek', 'data_bantek.no_bantek = data_pekerjaan.no_bantek','left');
                              $this->db->join('data_daftar_loker', 'data_daftar_loker.id_no_loker = data_bantek.id_no_loker','left');
                              $this->db->join('data_daftar_lemari', 'data_daftar_lemari.no_lemari = data_daftar_loker.no_lemari','left');
                              $this->db->join('user', 'user.no_user = data_pekerjaan.no_user');
                              $this->db->where('data_pemilik.no_pekerjaan',$input['no_pekerjaan']);
                              $this->db->where('data_pemilik.no_client',$input['no_client']);
                              $data_pemilik = $this->db->get(); 
                              $static = $data_pemilik->row_array();  
                              $data ='<nav aria-label="breadcrumb">
                              <ol class="breadcrumb">
                                <li class="breadcrumb-item" onclick=LihatClient("'.$input['no_client'].'")><a href="#">'.$static['nama_client'].'</a></li>
                                <li class="breadcrumb-item active" aria-current="page">'.$static['nama_jenis'].'</li>
                              </ol>
                             </nav>';
                             $data .= $this->MenuHasilPencarian($input['no_pekerjaan'],$input['no_client']);
                             $data .="<table class='table table-bordered table-striped'>";
                            
                             $data .="<tr>
                             <td colspan ='4' class='bg-info text-white  text-center'>Detail Pekerjaan ".$static['nama_jenis']."</td>
                             </tr>";
                        
                             $data .="<tr>
                             <td >Alamat Client</td>
                             <td colspan ='3'>: ".$static['alamat_client']."</td>
                             </tr>";

                             $data .="<tr>
                             <td >No Telepon</td>
                             <td colspan ='3'>: ".$static['contact_number']."</td>
                             </tr>";

                             $data .="<tr>
                             <td >Nama Pekerjaan</td>
                             <td colspan ='3'>:  ".$static['nama_jenis']."</td>
                             </tr>";
                            
                             $data .="<tr>
                             <td >Pembuat Pekerjaan</td>
                             <td colspan ='3'>:  ".$static['nama_lengkap']."</td>
                             </tr>";
                            
                             if(!isset($static['tanggal_selesai'])){
                              $tanggal = "";
                             }else{
                              $date = str_replace('/', '-', $static['tanggal_selesai']);
                              $tanggal =date('d F Y', strtotime($date));
                             }    
                                
                             $data .="<tr>
                             <td style='width:30%;'>Tanggal Selesai</td>
                             <td colspan ='3'>: ".
                             $tanggal
                             ."</td>
                             </tr>";
                             
                               
                        
                             $data .="<tr>
                             <td colspan ='4' class='bg-info text-white  text-center'>Lokasi Fisik Pekerjaan</td>
                             </tr>";
                             if(!isset($static['no_bantek'])){
                               
                              $data .="<tr>
                              <td colspan='4' class='text-center'>Lokasi Fisik Belum Ditentukan Atau Tidak Tersedia</td>
                              </tr>";
                             }else{
                             
                             $data .="<tr>
                             <td style='width:40%;'>Nama Tempat</td>
                             <td colspan ='3'>: " .$static['nama_tempat']."</td>
                             </tr>";
                             
                             
                             $data .="<tr>
                             <td style='width:40%;'>No Loker</td>
                             <td colspan ='3'>: " .$static['no_loker']."</td>
                             </tr>";

                             
                             $data .="<tr>
                             <td style='width:40%;'>No bantex</td>
                             <td colspan ='3'>: " .$static['no_bantek']."</td>
                             </tr>";
                             }
 
                               
                             $data .="<tr>
                             <td colspan ='4' class='bg-info text-white  text-center'>Daftar Kontak </td>
                             </tr>";
                             $data .="<tr>
                             <td >Nama Kontak</td>
                             <td >No Kontak</td>
                             <td >Email</td>
                             <td >Jabatan</td>
                             </tr>";
                             foreach($data_pemilik->result_array() as $kontak){
                              $data .="<tr>
                              <td >".$kontak['nama_kontak']."</td>
                              <td >".$kontak['no_kontak']."</td>
                              <td >".$kontak['email']."</td>
                              <td >".$kontak['jabatan']."</td>
                              </tr>";    
                             }
                        

                             $data .="</table>";
                              
                             echo $data;
                              }else{
                              redirect(404);    
                              }    
                              }


                    public function LihatDokumenUtama(){
                         $input = $this->input->post();
                         $this->db->select('data_dokumen_utama.jenis,'
                         . 'data_dokumen_utama.tanggal_akta,'
                         . 'data_dokumen_utama.id_data_dokumen_utama,'
                         . 'data_dokumen_utama.nama_file,'
                         . 'data_client.nama_client,'
                         . 'data_jenis_pekerjaan.nama_jenis,'
                         . 'data_dokumen_utama.no_akta');
                         $this->db->from('data_client');
                         $this->db->join('data_pekerjaan', 'data_pekerjaan.no_client = data_client.no_client');
                         $this->db->join('data_dokumen_utama', 'data_dokumen_utama.no_pekerjaan= data_pekerjaan.no_pekerjaan','left');
                         $this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan','left');
                         $this->db->where('data_pekerjaan.no_pekerjaan',$input['no_pekerjaan']);
                         $data_pemilik = $this->db->get(); 
                         $static = $data_pemilik->row_array();  
                         
                         $data ='<nav aria-label="breadcrumb">
                         <ol class="breadcrumb">
                           <li class="breadcrumb-item" onclick=LihatDetailPekerjaan("'.$input['no_pekerjaan'].'","'.$input['no_client'].'")><a href="#">'.$static['nama_jenis'].'</a></li>
                           <li class="breadcrumb-item active" aria-current="page">Dokumen Utama</li>
                         </ol>
                        </nav>';
                        $data .= $this->MenuHasilPencarian($input['no_pekerjaan'],$input['no_client']);

                        $data .= "<div class='row'>"
                         . "<div class='col detail_pekerjaan'>
                         <div class='row m-2'>";
                         if($static['nama_file'] ==NULL){
                              $data .="<div class='col text-center p-2 ' >Dokumen Utama Tidak Tersedia </div>"; 
                         }else{

                         foreach ($data_pemilik->result_array() as $a){  
                              

                              $data .="<div class='col-md-3 m-1 bg-light   text-center p-2 rounded' >
                              <button style='position:absoulute;' onclick=download_utama('".$a['id_data_dokumen_utama']."'); class='btn float-right  btn-sm btn-transparent  ')><span class='fa fa-download'></span></button>
                             <br>
                              <i    onclick=LihatFile('dokumen_utama','".$a['id_data_dokumen_utama']."'); class='fa fa-3x   ".$this->CekLogoFile($a['nama_file'])."  hover' aria-hidden='true'></i><br>".$a['jenis']." No ".$a['no_akta']."
                              </div>";
                      

                             
                              }
                      $data .="</div>";
                         }
                 echo $data;

                    }  
                    
                    
                    public function LihatDokumenPenunjang(){
                         $input = $this->input->post();
                         $this->db->select('data_client.nama_client,'
                              . 'data_client.no_client,'
                              . 'data_jenis_pekerjaan.nama_jenis,'
                              . 'data_client.no_identitas');
                              $this->db->from('data_pemilik');
                              $this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_pemilik.no_pekerjaan','left');
                              $this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan','left');
                              $this->db->join('data_client', 'data_client.no_client = data_pemilik.no_client');
                              $this->db->where('data_pemilik.no_pekerjaan',$input['no_pekerjaan']);
                              $data_pemilik = $this->db->get(); 
                              $static = $data_pemilik->row_array();
 
                         
                         $data ='<nav aria-label="breadcrumb">
                         <ol class="breadcrumb">
                           <li class="breadcrumb-item" onclick=LihatDetailPekerjaan("'.$input['no_pekerjaan'].'","'.$input['no_client'].'")><a href="#">'.$static['nama_jenis'].'</a></li>
                           <li class="breadcrumb-item active" aria-current="page">Dokumen Penunjang</li>
                         </ol>
                        </nav>';
                        $data .= $this->MenuHasilPencarian($input['no_pekerjaan'],$input['no_client']);

                        $data .= "<div class='row'>"
                         . "<div class='col detail_pekerjaan'>";
                         foreach ($data_pemilik->result_array() as $a){  
                               

                              $this->db->select('nama_dokumen.nama_dokumen,
                              data_berkas.no_berkas,
                              data_berkas.nama_berkas');
                              $this->db->from('data_berkas');
                              $this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_berkas.no_pekerjaan');
                              $this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
                              $this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
                              $this->db->where('data_berkas.no_client',$a['no_client']);
                              $this->db->where('data_pekerjaan.no_pekerjaan',$input['no_pekerjaan']);
                              $this->db->where('nama_dokumen.penunjang_client =',NULL);
                              $penunjang = $this->db->get();  

                              $data .='<div class="card mt-1">
                              <h5 class="card-header p-1  hasil_data text-center bg-info  " onclick=BukaClientBaru("'.$a['no_client'].'","'.$input['no_pekerjaan'].'"); >'.$a['nama_client'].'</h5>
                              <div class="card-body">
                              <div class="row">
                              ';
                            
                              foreach ($penunjang->result_array() as $d){    
                                  
                    ;                                 
                    $data .="<div class='col-md-3 m-1 bg-light   text-center p-2 rounded' >
                    <button style='position:absoulute;' onclick=cek_download('".$d['no_berkas']."'); class='btn float-right  btn-sm btn-transparent  ')><span class='fa fa-download'></span></button>
                   <br>
                    <i    onclick=LihatFile('dokumen_penunjang','".$d['no_berkas']."'); class='fa fa-3x   ".$this->CekLogoFile($d['nama_berkas'])."  hover' aria-hidden='true'></i> <br>".$d['nama_dokumen']."
                    </div>";
            
                              }
                             
                              $data .='</div></div></div>';
                             
                              }
                      $data .="</div>";

                 echo $data;

                    }   

public function CekLogoFile($nama_berkas){
$ext = pathinfo($nama_berkas, PATHINFO_EXTENSION);
if($ext =="docx" || $ext =="doc" ){
     $logo = "fa-file-word text-primary";
     }else if($ext == "xlx"  || $ext == "xlsx"){
          $logo = "fa-file-excel text-success";
     }else if($ext == "PDF"  || $ext == "pdf"){
          $logo = "fa-file-pdf text-danger";
     }else if($ext == "JPG"  || $ext == "jpg" ||$ext == "jpeg" || $ext == "png"  || $ext == "PNG"){
          $logo = "fa-file-image text-secondary";
     }else if($ext == "pptx" || $ext == "ppt"){
          $logo = "fa-file-powerpoint text-warning";
    }else{
          $logo = "fa-file text-dark";
     }

     return $logo;
} 


public function LihatLaporanPekerjaan(){
     $input = $this->input->post();
    $this->db->select('data_client.nama_client,'
          . 'data_client.no_client,'
          . 'data_jenis_pekerjaan.nama_jenis,'
          . 'data_progress_pekerjaan.waktu,'
          . 'data_progress_pekerjaan.laporan_pekerjaan,'
          . 'data_client.no_identitas');
          $this->db->from('data_pekerjaan');
          $this->db->join('data_progress_pekerjaan', 'data_progress_pekerjaan.no_pekerjaan = data_pekerjaan.no_pekerjaan','left');
          $this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan','left');
          $this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
          $this->db->where('data_pekerjaan.no_pekerjaan',$input['no_pekerjaan']);
          $laporan = $this->db->get(); 
          $static = $laporan->row_array();

     $data ='<nav aria-label="breadcrumb">
     <ol class="breadcrumb">
       <li class="breadcrumb-item" onclick=LihatDetailPekerjaan("'.$input['no_pekerjaan'].'","'.$input['no_client'].'")><a href="#">'.$static['nama_jenis'].'</a></li>
       <li class="breadcrumb-item active" aria-current="page">Laporan Pekerjaan</li>
     </ol>
    </nav>';
    $data .= $this->MenuHasilPencarian($input['no_pekerjaan'],$input['no_client']);

    $data .= "<div class='row'>"
     . "<div class='col detail_pekerjaan'>";
     $data.="<table class='table table-striped table-bordered '>
     <tr class='bg-info text-white'>
     <th style='width:30%;'>Tanggal</th>
     <th>Laporan</th>
     </tr>
     ";

     if($static['laporan_pekerjaan'] ==NULL){
          $data .="<tr >
          <td colspan='2' class='text-center'>Belum Ada Laporan Yang di Berikan</td>
          </tr>";
         
     }else{
    foreach($laporan->result_array() as $l){
     $data .="<tr >
     <td style='width:30%;'>".$l['waktu']."</td>
     <td>".$l['laporan_pekerjaan']."</td>
     </tr>";
    }

     }
  $data .="</table></div></div>";

echo $data;

}   


public function LihatLaporanPerizinan(){
     $input = $this->input->post();
    $this->db->select('data_client.nama_client,'
          . 'data_client.no_client,'
          . 'nama_dokumen.nama_dokumen,'
          . 'user.nama_lengkap,'
          . 'data_berkas_perizinan.no_berkas,'
          . 'data_berkas_perizinan.no_berkas_perizinan,'
          . 'data_jenis_pekerjaan.nama_jenis,'
          . 'data_client.no_identitas');
          $this->db->from('data_pekerjaan');
          $this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
          $this->db->join('data_berkas_perizinan', 'data_berkas_perizinan.no_pekerjaan = data_pekerjaan.no_pekerjaan','left');
          $this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas_perizinan.no_nama_dokumen','left');
          $this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan','left');
          $this->db->join('user', 'user.no_user = data_berkas_perizinan.no_user_perizinan','left');
          $this->db->where('data_pekerjaan.no_pekerjaan',$input['no_pekerjaan']);
          $this->db->where('data_berkas_perizinan.no_client',$input['no_client']);
          $perizinan = $this->db->get(); 
          $static = $perizinan->row_array();

     $data ='<nav aria-label="breadcrumb">
     <ol class="breadcrumb">
       <li class="breadcrumb-item" onclick=LihatDetailPekerjaan("'.$input['no_pekerjaan'].'","'.$input['no_client'].'")><a href="#">'.$static['nama_jenis'].'</a></li>
       <li class="breadcrumb-item active" aria-current="page">Laporan Perizinan</li>
      </ol>
    </nav>';
    $data .= $this->MenuHasilPencarian($input['no_pekerjaan'],$input['no_client']);

    $data .= "<div class='row'>"
     . "<div class='col detail_pekerjaan'>";
     $data.="<table class='table table-striped table-bordered '>
     <tr class='bg-info text-white'>
     <th>Nama Dokumen</th>
     <th>Nama Petugas</th>
     <th>Aksi</th>
     </tr>
     ";
   
     foreach($perizinan->result_array() as $d){
          $data .="<tr class='".$d['no_berkas_perizinan']."'>
          <td>".$d['nama_dokumen']."</td>
          <td>".$d['nama_lengkap']."</td>
          <td style='width:19%;' class='text-center'>
          <button"; if($d['no_berkas'] == NULL) {$data.=" disabled ";}else{ $data.=" onclick=LihatFile('dokumen_penunjang','".$d['no_berkas']."') "; }   $data.=" title='Lihat File Perizinan' class='btn btn-sm btn-info'><i class='fa fa-eye'></i></button>
          <button  onclick=LihatDetailLaporanPerizinan('".$input['no_pekerjaan']."','".$input['no_client']."','".$d['no_berkas_perizinan']."') Title='Lihat Laporan'class='btn btn-sm btn-info'><i class='fa fa-list'></i></button>
          <button "; if($d['no_berkas'] == NULL){$data.=" disabled ";}else{ $data.=" onclick=cek_download('".$d['no_berkas']."') "; }  $data .="Title='Download File Perizinan'class='btn btn-sm btn-info'><i class='fa fa-download'></i></button>
          </td>
          </tr>";
     }

  $data .="</table></div></div>";

echo $data;

}



public function LihatDetailLaporanPerizinan(){
     $input = $this->input->post();
     $this->db->select('data_client.nama_client,'
     . 'data_client.no_client,'
     . 'nama_dokumen.nama_dokumen,'
     . 'data_berkas_perizinan.no_berkas,'
     . 'data_berkas_perizinan.no_berkas_perizinan,'
     . 'data_progress_perizinan.laporan,'
     . 'data_progress_perizinan.waktu,'
     . 'data_jenis_pekerjaan.nama_jenis,'
     . 'data_client.no_identitas');
     $this->db->from('data_berkas_perizinan');
     $this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_berkas_perizinan.no_pekerjaan');
     $this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
     $this->db->join('data_progress_perizinan', 'data_progress_perizinan.no_berkas_perizinan = data_berkas_perizinan.no_berkas_perizinan','left');
     $this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas_perizinan.no_nama_dokumen','left');
     $this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan','left');
     $this->db->where('data_berkas_perizinan.no_berkas_perizinan',$input['no_berkas_perizinan']);
     $laporan = $this->db->get(); 
     $static = $laporan->row_array();
         
     $data ='<nav aria-label="breadcrumb">
     <ol class="breadcrumb">
        <li class="breadcrumb-item active" onclick=LihatLaporanPerizinan("'.$input['no_pekerjaan'].'","'.$input['no_client'].'") ><a href="#">Laporan Perizinan</a></li>
       <li class="breadcrumb-item " >'.$static['nama_dokumen'].'</li>
       </ol>
    </nav>';
    $data .= $this->MenuHasilPencarian($input['no_pekerjaan'],$input['no_client']);

    $data .= "<div class='row'>"
     . "<div class='col detail_pekerjaan'>";
     $data.="<table class='table table-striped table-bordered '>
     <tr class='bg-info text-white'>
     <th>Waktu</th>
     <th>Laporan</th>
     </tr>
     ";
     if($static['laporan'] ==NULL){
          $data .="<tr >
          <td colspan='2' class='text-center'>Belum Ada Laporan Yang di Berikan</td>
          </tr>";
         
     }else{
     foreach($laporan->result_array() as $l){
          $data .="<tr >
          <td style='width:30%;'>".$l['waktu']."</td>
          <td>".$l['laporan']."</td>
          </tr>";
         }
     }
  $data .="</table></div></div>";

echo $data;

}

}