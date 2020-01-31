<?php

require('vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class User1 extends CI_Controller{
public function __construct() {
parent::__construct();
$this->load->helper('download');
$this->load->library('session');
$this->load->model('M_user1');
$this->load->library('Datatables');
$this->load->library('form_validation');
$this->load->library('upload');
$this->load->library('breadcrumbs');
if($this->session->userdata('sublevel')  != 'Level 1' ){
redirect(base_url('Menu'));
}

}

public function index(){
$this->breadcrumbs->push('Beranda', '/User1');
$asisten = $this->db->get_where('user',array('level'=>'User'));    
$this->load->view('umum/V_header');
$this->load->view('user1/V_Dashboard',['asisten'=>$asisten]);    
}

public function pekerjaan_masuk(){
$this->breadcrumbs->push('Beranda', '/User1');
$this->breadcrumbs->push('Pekerjaan Masuk', '/User1/pekerjaan_masuk');   
$data_tugas = $this->M_user1->data_tugas('Masuk');    
$this->load->view('umum/V_header');
$this->load->view('user1/V_pekerjaan_masuk',['data_tugas'=>$data_tugas]);    
}

public function download_berkas_informasi(){
$data = $this->db->get_where('data_informasi_pekerjaan',array('id_data_informasi_pekerjaan'=>$this->uri->segment(3)))->row_array();    
$file_path = "./berkas/".$data['nama_folder']."/".$data['lampiran']; 
$info = new SplFileInfo($data['lampiran']);
force_download($data['nama_informasi'].".".$info->getExtension(), file_get_contents($file_path));
}

public function keluar(){
$this->session->sess_destroy();
redirect (base_url('Login'));
}


public function proses_tugas(){
if($this->input->post()){
$data = array(
'tanggal_proses_tugas'  =>date('d/m/Y H:i:s'),
'target_kelar_perizinan' =>$this->input->post('target_kelar'),
'status_berkas'        =>'Proses'    
);
$this->db->update('data_syarat_jenis_dokumen',$data,array('id_syarat_dokumen'=>$this->input->post('id_syarat_dokumen')));

$status = array(
'status' =>"success",
'pesan'  =>"Dokumen masuk kedalam proses perizinan"    
);
echo json_encode($status);

}else{
redirect(404);    
}

}
public function halaman_proses(){
$this->breadcrumbs->push('Beranda', '/User1');
$this->breadcrumbs->push('Pekerjaan Diproses', '/User1/halaman_proses');   
    
$data_tugas = $this->M_user1->data_tugas('Proses');    
$this->load->view('umum/V_header');
$this->load->view('user1/V_halaman_proses',['data_tugas'=>$data_tugas]);
}

public function halaman_selesai(){
$this->breadcrumbs->push('Beranda', '/User1');
$this->breadcrumbs->push('Pekerjaan Selesai', '/User1/halaman_selesai');   
    
    
$data_tugas = $this->M_user1->data_tugas('Selesai');       
$this->load->view('umum/V_header');
$this->load->view('user1/V_halaman_selesai',['data_tugas'=>$data_tugas]);
    
}
public function json_data_pekerjaan_selesai(){
echo $this->M_user1->json_data_pekerjaan_selesai();       
}

public function tampilkan_modal(){
if($this->input->post()){
    
$input = $this->input->post();

if($input['jenis_modal'] == 'tolak'){
echo "tolak";        
}else if($input['jenis_modal'] == 'alihkan'){
echo "alihkan";    
}
    
}else{
redirect(404);    
}
}

public function lihat_karyawan(){
$this->breadcrumbs->push('Beranda', '/User1');
$this->breadcrumbs->push('Lihat Asisten', '/User1/lihat_karyawan');
    
$karyawan = $this->M_user1->data_user();               
$this->load->view('umum/V_header');
$this->load->view('user1/V_lihat_karyawan',['karyawan'=>$karyawan]);    
}


public function lihat_pekerjaan(){
$no_user = base64_decode($this->uri->segment(3));
$proses  = base64_decode($this->uri->segment(4));
$level  = base64_decode($this->uri->segment(5));

if($no_user && $proses){
$karyawan = $this->db->get_where('user',array('no_user'=>$no_user));    
$sublevel = $karyawan->row_array();
$this->load->view('umum/V_header');
if($level == 'Level 2'){
$data_level2 = $this->M_user1->data_level2($proses,$no_user);
$data_user   = $this->M_user1->user_level2();   
$this->load->view('user1/V_lihat_pekerjaan_level2',['data'=>$data_level2,'data_user'=>$data_user]);
}else{    
$data_level2   = $this->M_user1->data_level3($proses,$no_user);   
$this->load->view('user1/V_lihat_pekerjaan_level3',['data'=>$data_level2]);    
}

}else{
redirect(404);    
}
}
public function berkas_dikerjakan(){
$no_pekerjaan               = base64_decode($this->uri->segment(3));
$data_berkas                = $this->M_user1->data_berkas_pekerjaan($no_pekerjaan);
$data_utama                 = $this->M_user1->data_berkas_utama($no_pekerjaan);

$this->load->view('umum/V_header');
$this->load->view('user1/V_lihat_berkas_dikerjakan',['data_utama'=>$data_utama,'data_berkas'=>$data_berkas]);        


}

public function lihat_laporan_pekerjaan(){
if($this->input->post()){
$input = $this->input->post();

$data = $this->db->get_where('data_progress_pekerjaan',array('no_pekerjaan'=> base64_decode($input['no_pekerjaan'])));
if($data->num_rows() != 0){
echo "<table class='table table-striped table-bordered text-center table-hover table-sm'>"
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
}else{
echo "<div class='text-center text-theme1 h5'> <i class='far fa-clipboard fa-3x'></i><br>Belum ada laporan yang diberikan</div>";    
}

}else{
redirect(404);    
}    
}
public function cari_file(){
$kata_kunci = $this->input->post('kata_kunci');


$data_dokumen           = $this->M_user1->pencarian_data_dokumen($kata_kunci);
$data_dokumen_utama     = $this->M_user1->pencarian_data_dokumen_utama($kata_kunci);
$data_client            = $this->M_user1->pencarian_data_client($kata_kunci);

$this->load->view('umum/V_header');
$this->load->view('user1/V_pencarian',['data_dokumen'=>$data_dokumen,'data_dokumen_utama'=>$data_dokumen_utama,'data_client'=>$data_client]);

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

public function alihkan_pekerjaan(){
if($this->input->post()){
$input = $this->input->post();    
$data = array(
'no_user'           =>$input['no_user'],
'pembuat_pekerjaan' =>$input['pembuat_pekerjaan'],   
);
$this->db->update('data_pekerjaan',$data,array('no_pekerjaan'=> base64_decode($input['no_pekerjaan'])));

$status = array(
'status' =>"success",
'pesan'  =>"Pengalihan tugaske ".$input['pembuat_pekerjaan']." Berhasil"    
);
echo json_encode($status);

}else{
redirect(404);    
}
    
}
public function profil(){
$no_user = $this->session->userdata('no_user');
$data_user = $this->M_user1->data_user_where($no_user);
$this->load->view('umum/V_header');
$this->load->view('user1/V_profil',['data_user'=>$data_user]);

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
$this->load->view('user1/V_riwayat_pekerjaan');
}

public function json_data_riwayat(){
echo $this->M_user1->json_data_riwayat();       
}


public function lihat_laporan(){
if($this->input->post()){
$input = $this->input->post();

$data = $this->db->get_where('data_progress_perizinan',array('no_berkas_perizinan'=>$input['no_berkas_perizinan']));
if($data->num_rows() == 0){
echo "<div class='text-center text-theme1 h5'> <i class='far fa-clipboard fa-3x'></i><br>Belum ada laporan yang diberikan</div>";    
    
}else{echo "<table text-theme1 class='table table-bordered table-striped table-hover table-sm'>"
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
$query     = $this->M_user1->data_perekaman($input['no_nama_dokumen'],$input['no_client']);
$query2     = $this->M_user1->data_perekaman2($input['no_nama_dokumen'],$input['no_client']);

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
.'<button class="btn btn-success btn-sm" onclick=cek_download("'. base64_encode($d['no_berkas']).'")><span class="fa fa-download"></span></button>';
    echo '</td>';
echo "</tr>";
    
    
}
echo "</tbody>";


echo"</table>";  
}else{
redirect(404);    
}  
}

public function data_pencarian(){
if($this->input->post()){
$input = $this->input->post();
$data_dokumen         = $this->M_user1->pencarian_data_dokumen($input['kata_kunci']);
$data_client          = $this->M_user1->pencarian_data_client($input['kata_kunci']);
$dokumen_utama        = $this->M_user1->pencarian_data_dokumen_utama($input['kata_kunci']);

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



public function data_perekaman_user_client(){
if($this->input->post()){
$input = $this->input->post();    

$data_berkas  = $this->M_user1->data_telah_dilampirkan(base64_decode($input['no_client']));
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
$data = $this->M_user1->data_berkas_where($this->uri->segment(3))->row_array();

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
$this->db->where('id_data_dokumen_utama',$id_data_dokumen_utama);
$data= $this->db->get()->row_array();    


$file_path = "./berkas/".$data['nama_folder']."/".$data['nama_file']; 
$info = new SplFileInfo($data['nama_file']);
force_download($data['nama_berkas'].".".$info->getExtension(), file_get_contents($file_path));
}

public function data_perekaman_pencarian(){
    if($this->input->post()){
    $input              = $this->input->post();
    $DokumenPenunjang   = $this->M_user1->DokumenPenunjang($input['no_berkas']);
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
    
function data_perekaman_utama(){
    if($this->input->post()){
        $input              = $this->input->post();
        $data_utama = $this->M_user1->DataDokumenUtama($input['id_data_dokumen_utama']);
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

    public function lihat_lampiran_client(){    
        $data_client = $this->M_user1->data_client_where($this->uri->segment(3));       
        
        $this->load->view('umum/V_header');
        $this->load->view('user1/V_lihat_lampiran_client',['data_client'=>$data_client]);   
        }
        
        public function json_data_lampiran_client($no_client){
            echo $this->M_user1->json_data_lampiran_client($no_client);  
        }

        function lihat_meta(){
            if($this->input->post()){ 
            $input = $this->input->post(); 
            $data = $this->db->get_where('data_meta_berkas',array('no_berkas'=>$input['no_berkas']));    
                
            echo '<div class="modal-content ">
            <div class="modal-header">
            <h6 class="modal-title" id="exampleModalLabel text-center">Data yang telah direkam<span class="i"><span></h6>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body data_perekaman">';
            if($data->num_rows() == 0){
            echo "<p class='text-center'>Meta Data Tidak Tersedia</p><hr>";    
            }else{
            echo '<table class="table table-sm table-bordered ">';
            
            foreach ($data->result_array() as $d){
            echo "<tr><td>".str_replace('_', ' ',$d['nama_meta'])."</td><td>".$d['value_meta']."</td></tr>";    
            }
            
            echo "<table>"
            . "<hr>";
            }
            echo "<button onclick=cek_download('".base64_encode($input['no_berkas'])."') class='btn btn-sm  mr-2 btn-success '>Download lampiran <span class='fa fa-save'></span></button>";
            
            
            echo "<button onclick=edit_meta('".$input['no_berkas']."','".$input['no_nama_dokumen']."','".$input['no_pekerjaan']."') class='btn btn-sm  mr-2  btn-warning  '>Meta lampiran <span class='fa fa-edit'></span></button>";
            
            echo "<button  onclick=hapus_lampiran('".base64_encode($input['no_berkas'])."') class='btn btn-sm  mr-2 btn-danger  '>Hapus lampiran <span class='fa fa-trash'></span></button>";
            echo'</div>'
            . '</div>';    
            
            
            }else{
            redirect(404);
            }    
            }
            
            function form_meta(){
                if($this->input->post()){ 
                $input = $this->input->post();    
                $this->db->get_where('data_meta_berkas',array('no_berkas'=>$input['no_berkas']));    
                
                $data_meta = $this->M_user1->data_meta($input['no_nama_dokumen']);
                
                echo '<div class="modal-content ">
                <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel text-center">Data yang telah direkam<span class="i"><span></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body data_perekaman">
                <form id="form_edit_meta">';
                echo '<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="required"  accept="text/plain">';
                echo '<input type="hidden" name="no_berkas" value="'.$input['no_berkas'].'" readonly="" class="required"  accept="text/plain">';
                echo '<input type="hidden" name="no_pekerjaan" value="'.$input['no_pekerjaan'].'" readonly="" class="required"  accept="text/plain">';
                echo '<input type="hidden" name="no_nama_dokumen" value="'.$input['no_nama_dokumen'].'" readonly="" class="required"  accept="text/plain">';
                
                
                foreach ($data_meta->result_array()  as $d ){
                $val = $this->M_user1->data_edit($input['no_berkas'],str_replace(' ', '_',$d['nama_meta']))->row_array();
                //INPUTAN SELECT   
                if($d['jenis_inputan'] == 'select'){
                $data_option = $this->db->get_where('data_input_pilihan',array('id_data_meta'=>$d['id_data_meta']));   
                echo "<label>".$d['nama_meta']."</label>"
                ."<select id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' class='form-control form_meta form-control-sm meta required' required='' accept='text/plain'>";
                foreach ($data_option->result_array() as $option){
                echo "<option ";
                if($val['value_meta'] == $option['jenis_pilihan']){
                echo "selected";    
                }
                echo ">".$option['jenis_pilihan']."</option>";
                }
                echo "</select>";
                //INPUTAN DATE
                }else if($d['jenis_inputan'] == 'date'){
                echo "<label>".$d['nama_meta']."</label>"
                ."<input value='".$val['value_meta']."'  type='text' id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-sm ".$d['jenis_inputan']." meta required ' required='' accept='text/plain' >";    
                ///INPUTAN NUMBER
                }else if($d['jenis_inputan'] == 'number'){
                echo "<label>".$d['nama_meta']."</label>"
                ."<input value='".$val['value_meta']."' type='text' id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-sm ".$d['jenis_bilangan']." meta required ' required='' accept='text/plain' >";        
                //INPUTAN TEXTAREA
                }else if($d['jenis_inputan'] == 'textarea'){
                echo "<label>".$d['nama_meta']."</label>"
                . "<textarea  id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-sm ".$d['jenis_bilangan']." meta required ' required='' accept='text/plain'>".$val['value_meta']."</textarea>";
                }else{
                echo "<label>".$d['nama_meta']."</label>"
                ."<input  type='".$d['jenis_inputan']."' value='".$val['value_meta']."' id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-sm  meta required ' required='' accept='text/plain' >";    
                }
                }
                echo "</form><hr>";
                echo "<button onclick=update_meta('".base64_encode($input['no_berkas'])."') class='btn btn-block btn-sm  mr-2 btn-success '>Simpan Meta <span class='fa fa-save'></span></button>";
                echo'</div>'
                . '</div>';    
                
                }else{
                redirect(404);
                }    
                }


                function update_meta(){
                    if($this->input->post()){
                    $input = $this->input->post();
                    $cek_meta = $this->db->get_where('data_meta_berkas',array('no_berkas'=>$input['no_berkas']));
                    if($cek_meta->num_rows() == 0){
                    $this->simpan_meta($input);    
                    }else{
                    foreach ($input as $key=>$value){
                    if($key != "no_berkas"){
                    $data = array(
                    'value_meta'=>$value    
                    );
                    $this->db->update('data_meta_berkas',$data,array('no_berkas'=>$input['no_berkas'],'nama_meta'=>$key));
                    }
                    }
                    $status[] = array(
                    'status'  => 'success',
                    'messages'=> "Meta Data diperbaharui",    
                    );
                    echo json_encode($status);
                    }
                    }else{
                    redirect(404);    
                    }
                    


                        
                    }
                    
                    public function hapus_lampiran(){
if($this->input->post()){
$input = $this->input->post();    
$data = $this->M_user1->hapus_lampiran(base64_decode($input['no_berkas']))->row_array();

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
    $data = array(
    'no_user'   => $this->session->userdata('no_user'),
    'keterangan'=>$keterangan,
    'tanggal'   =>date('Y/m/d H:i:s'),
    );
    
    $this->db->insert('data_histori_pekerjaan',$data);
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
$data_pekerjaan = $this->M_user1->laporan_pekerjaan($range1,$range2,$input);
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
$data_utama = $this->M_user1->laporan_utama($range1,$range2,$input);
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
$data_pendukung = $this->M_user1->laporan_pendukung($range1,$range2,$input);
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
$BerkasMilikAsisten = $this->M_user1->BerkasMilikAsisten($as->no_user)->num_rows();
$jumlah_berkas[] = $BerkasMilikAsisten;
}

foreach ($namaasisten->result()  as $as) {
$PekerjaanMilikAsisten = $this->M_user1->PekerjaanMilikAsisten($as->no_user)->num_rows();
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
$JumlahPerizinan      = $this->M_user1->PekerjaanMilikPerizinan($as->no_user)->num_rows();
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

