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

public function DataArsipClient(){

    $query = $this->M_data_lama->data_pekerjaan_arsip('ArsipMasuk');
   
    $this->load->view('umum/V_header');
    $this->load->view('data_lama/V_DataArsipClient',['query'=>$query]);    
    }

    public function DataArsipProses(){
    
        $query = $this->M_data_lama->data_pekerjaan_arsip('ArsipProses');
       
        $this->load->view('umum/V_header');
        $this->load->view('data_lama/V_DataArsipProses',['query'=>$query]);    
        }

        public function DataArsipSelesai(){
            $query = $this->M_data_lama->data_pekerjaan_arsip('ArsipSelesai');
            $this->load->view('umum/V_header');
            $this->load->view('data_lama/V_DataArsipSelesai',['query'=>$query]);    
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
$term = strtolower($this->input->post('search'));    
$query = $this->M_data_lama->cari_jenis_pekerjaan($term);

foreach ($query as $d) {
$json[]= array(
'text'                    => $d->nama_jenis,   
'id'                      => $d->no_jenis_pekerjaan,
);   
}
$data = array(
'results'=>$json,
);
echo json_encode($data);
}
function buat_arsip(){
$input = $this->input->post();
$this->form_validation->set_rules('jenis_pekerjaan', 'Jenis pekerjaan', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('jenis_client', 'Jenis Klien', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('badan_hukum', 'Nama Klien', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('jenis_kontak', 'Jenis Kontak', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('contact_person', 'Nama Kontak', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('contact_number', 'Nomor Kontak', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('no_user_pembuat', 'Nama Notaris', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('no_identitas', 'NIK / NPWP', 'required',array('required' => 'Data ini tidak boleh kosong'));

if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);
echo json_encode($status);

}else{
$cek_badan_hukum = $this->db->get_where('data_client',array('no_identitas'=>strtoupper($input['no_identitas'])));        

$h_berkas = $this->M_data_lama->hitung_pekerjaan()->num_rows()+1;
$no_pekerjaan = "P".str_pad($h_berkas,6 ,"0",STR_PAD_LEFT);

$tot_pemilik   = $this->M_data_lama->data_pemilik()->row_array();
$no_pemilik    = "PK".str_pad($tot_pemilik['id_data_pemilik'],6 ,"0",STR_PAD_LEFT);


if($cek_badan_hukum->num_rows() == 0){
$h_client = $this->M_data_lama->data_client()->num_rows()+1;
$no_client    = "C".str_pad($h_client,6 ,"0",STR_PAD_LEFT);
    
    //buatpekerjaandanclienbaru
$this->SimpanPekerjaanDanClienBaru($input,$no_pekerjaan,$no_client,$no_pemilik);
}else{
//buatpekerjaansaja
$this->BuatPekerjaanSaja($input,$no_pekerjaan,$cek_badan_hukum,$no_pemilik);
}

}
}

public function SimpanPekerjaanDanClienBaru($input,$no_pekerjaan,$no_client,$no_pemilik){    
$data_client = array(
'no_client'                 => $no_client,    
'no_identitas'              => $input['no_identitas'],    
'jenis_client'              => ucwords($input['jenis_client']),    
'nama_client'               => strtoupper($input['badan_hukum']),
'tanggal_daftar'            => date('Y/m/d'),    
'pembuat_client'            => $input['nama_notaris'],    
'no_user'                   => $input['no_user_pembuat'], 
'nama_folder'               => "Dok".$no_client,
'contact_person'            => ucwords($input['contact_person']),    
'contact_number'            => ucwords($input['contact_number']),    
'jenis_kontak'              => $input['jenis_kontak'],    
); 

$this->db->insert('data_client',$data_client);

if(!file_exists("berkas/"."Dok".$no_client)){
mkdir("berkas/"."Dok".$no_client,0777);
}


$data_r = array(
'no_client'          => $no_client,    
'status_pekerjaan'   => "ArsipMasuk",
'no_pekerjaan'       => $no_pekerjaan,    
'tanggal_dibuat'     => date('Y/m/d'),
'no_jenis_pekerjaan' => $input['jenis_pekerjaan'],   
'target_kelar'       => date('Y/m/d'),
'no_user'            => $input['no_user_pembuat'],    
'pembuat_pekerjaan'  => $input['nama_notaris'],    
);
$this->db->insert('data_pekerjaan',$data_r);


$data_pem = array(
'no_pemilik'    =>$no_pemilik,   
'no_client'     =>$no_client,
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

public function BuatPekerjaanSaja($input,$no_pekerjaan,$cek_badan_hukum,$no_pemilik){
$no_client = $cek_badan_hukum->row_array();
    $data_r = array(
        'no_client'          => $no_client['no_client'],    
        'status_pekerjaan'   => "ArsipMasuk",
        'no_pekerjaan'       => $no_pekerjaan,    
        'tanggal_dibuat'     => date('Y/m/d'),
        'no_jenis_pekerjaan' => $input['jenis_pekerjaan'],   
        'target_kelar'       => date('Y/m/d'),
        'no_user'            => $input['no_user_pembuat'],    
        'pembuat_pekerjaan'  => $input['nama_notaris'],    
        );

$this->db->insert('data_pekerjaan',$data_r);

$data_pem = array(
'no_pemilik'    =>$no_pemilik,   
'no_client'     =>$no_client['no_client'],
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

$data_pihak = $this->M_data_lama->data_para_pihak(base64_decode($input['no_pekerjaan']));
foreach ($data_pihak->result_array() as $data){
echo "<div class='row mt-2 '>"
    . "<div class='col '>".$data['nama_client']."</div>"
    . "<div class='col  text-center'>"
    . "<button onclick=tampilkan_form('".$data['no_client']."','".$input['no_pekerjaan']."'); class='btn btn-success btn-sm' title='Rekam Dokumen Milik ".$data['nama_client']."'><span class='fa fa-plus'></span> Rekam penunjang</button>";
    
    if($input['no_client'] != $data['no_client']){
    echo  "<button onclick=hapus_keterlibatan('".$data['no_client']."','".$input['no_pekerjaan']."'); class='btn btn-danger ml-1 btn-sm' title='Hapus keterlibatan ".$data['nama_client']."'><span class='fa fa-trash'></span> Hapus</button>";
    }
    
    if($input['proses'] == 'perizinan'){
    echo  "<button  onclick=tampilkan_form_utama('".$data['no_client']."','".$input['no_pekerjaan']."'); class='btn btn-success btn-sm  ml-1 mt-1' title='Rekam dokumen utama ".$data['nama_client']."'><span class='fa fa-plus'></span> Rekam utama</button>";
    } 
    echo "</div>"
    . "</div><hr>";
}
}else{
redirect(404);    
}
}

//FUNCTION/METHOD BARU 

function form_edit_client(){
if($this->input->post()){    

$input = $this->input->post();    

$data_client = $this->M_data_lama->data_client_where($input['no_client'])->row_array();

echo '<div class="modal-content">
<div class="modal-header">
<h6 class="modal-title" >Edit Client '.$data_client['nama_client'].' <span id="title"></span> </h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body " >';
echo'<form id="form_update_client">
<input type="hidden" name="'.$this->security->get_csrf_token_name().'"value="'.$this->security->get_csrf_hash().'" readonly="" class="form-control required"  accept="text/plain">
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
    $input = $this->input->post();
    $jumlah_dokumen_dimiliki    = $this->M_data_lama->jumlah_dokumen_dimiliki($input['no_client']);
    $jumlah_lampiran            = $this->M_data_lama->jumlah_lampiran($input['no_client']);
    $data_client                = $this->M_data_lama->data_client_where(base64_encode($input['no_client']))->row_array();
    echo '
    <div class="modal-header">
    <h6 class="modal-title" id="exampleModalLabel text-center">UPLOAD DOKUMEN PENUNJANG MILIK '.strtoupper($data_client['nama_client']).' DIBAWAH INI <span class="i"><span></h6>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body overflow-auto" style="max-height:500px;" >';
    echo "<div class=''>"
    . "<div class='row'>"
    . "<div class='col-md-6 '>"
    . "<form  class='card-header ' id='form_berkas'>"
    . "<input type='hidden' class='no_client' name='no_client'    value='".$input['no_client']."'>"
    . "<input type='hidden' class='no_pekerjaan' name='no_pekerjaan' value='".$input['no_pekerjaan']."'>"
    . "<label h6>Upload dokumen penunjang</label>"
    . "<input type='file' id='file_berkas' name='file_berkas[]' multiple class='form-control form-control-sm '>"
    .'<div class="progress" style="display:none">
    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
    </div>'
    . "<label>&nbsp;</label>"
    . "<button type='button'  onclick='upload_file()' class='btn btn-success btn-block btn-sm'> Upload berkas  </button>"
    . "</form>";
    echo  "</div><div class='col-md-6'>
    <div class='card-header'>
    <table class='table table-sm  table-bordered'>
    <tr><td>Jumlah Dokumen Dimiliki</td> <td>".$jumlah_dokumen_dimiliki->num_rows()."</td><td><button onclick=lihat_berkas_client('".$input['no_client']."'); class='btn btn-success btn-sm'> <span class='fa fa-eye'></span></button></td></tr>
    <tr><td>Jumlah Lampiran yang ada</td> <td>".$jumlah_lampiran->num_rows()."</td><td><button onclick=lihat_lampiran_client('".$input['no_client']."'); class='btn btn-success btn-sm'> <span class='fa fa-eye'></span></button></td></tr>
    </table>
    </div>
    </div>";
    echo  "</div>";
    echo '<div class="row">';
    echo '<div class="col data_terupload"></div>';
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
        $data_upload        = $this->db->get_where('data_berkas',array('no_client'=>$input['no_client'],'no_pekerjaan'=> base64_decode($input['no_pekerjaan']),'status_berkas !='=>'selesai'));
        $data_client        = $this->M_data_lama->data_client_where(base64_encode($input['no_client']))->row_array();
        $nama_persyaratan   = $this->M_data_lama->nama_persyaratan(base64_decode($input['no_pekerjaan']),$data_client['jenis_client']);
        echo "<b><div class='row card-header mt-1 text-center'>"
        . "<div class='col-md-1'>No</div>"
        . "<div class='col'>Nama Lampiran</div>"
        . "<div class='col'>Jenis dokumen</div>"
        . "<div class='col'>Aksi</div>"
        . "</div></b>";
        $n=1;
        if($data_upload->num_rows() != 0){   
        echo "<div class='DataLampiran'> ";
        foreach ($data_upload->result_array() as $data){
        echo "<div class='row mt-1 card-header data".$data['no_berkas']."'>";
        echo "<div class='col-md-1 text-center'>".$n++."</div>";
        echo "<div class='col'>".substr($data['nama_berkas'],0,30)."</div>";
        echo "<div class='col'>"
        . "<select onchange=set_jenis_dokumen('".$input['no_client']."','".$input['no_pekerjaan']."','".$data['no_berkas']."') class='form-control   form-control-sm no_berkas".$data['no_berkas']."'>";
        echo "<option></option>";
        foreach ($nama_persyaratan->result_array() as  $persyartan){     
        echo "<option "; if($data['no_nama_dokumen'] == $persyartan['no_nama_dokumen']){ echo "selected ";}  echo "value='".$persyartan['no_nama_dokumen']."'>".$persyartan['nama_dokumen']."</option>";
        }
        echo "</select></div>";
        echo '<div class="col text-center">';
        if($data['no_nama_dokumen']){
        echo '<button  onclick=form_edit_meta("'.$input['no_client'].'","'.$input['no_pekerjaan'].'","'.$data['no_berkas'].'","'.$data['no_nama_dokumen'].'"); class="btn btn_edit'.$data['no_berkas'].'  btn-warning ml-1 btn-sm" title="Edit data ini" ><i class="far fa-edit"></i></button>';
        echo '<button  onclick=cek_download("'.base64_encode($data['no_berkas']).'"); class="btn  btn-primary ml-1 mt-1 btn-sm" title="Download lampiran ini" ><i class="fa fa-download"></i></button>';
        }
        echo '<button  onclick=hapus_berkas_persyaratan("'.$input['no_client'].'","'.$input['no_pekerjaan'].'","'.$data['id_data_berkas'].'"); class="btn  btn-danger ml-1 btn-sm" title="Hapus data ini" ><i class="fa fa-trash"></i></button>';
        echo '</div>';
        echo "</div>";    
        }
        echo "<div class='row mt-1 card-header'>"
        . "<div class='col'></div>"
        . "<div class='col'></div>"
        . "<div class='col'><button onclick=simpan_lampiran('".$input['no_client']."','".$input['no_pekerjaan']."') class='btn btn-sm btn-block btn-success'>Simpan lampiran <span class='fa fa-save'></span></button></div>"
        . "</div>"
        . "</div>";
        }else{
        echo "<div class='text-center  text-theme1 h5'>BELUM TERDAPAT FILE YANG DI UPLOAD <br> <span class='fa fa-file fa-3x'></span></div>";    
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
$config['max_size']             = 50000;
$this->upload->initialize($config);   

if (!$this->upload->do_upload('file_berkas'.$i)){  
$status[] = array(
"status"        => "error",
"messages"      => $this->upload->display_errors(),    
'name_file'     => $this->upload->data('file_name')
);
}else{
$lampiran = $this->upload->data('file_name');    
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
$total_berkas = $this->M_data_lama->total_berkas()->row_array();
$no_berkas = "BK".date('Ymd').str_pad($total_berkas['id_data_berkas'],6,"0",STR_PAD_LEFT);
    
$data_berkas = array(
'no_berkas'         => $no_berkas,    
'no_client'         => $input['no_client'],    
'no_pekerjaan'      => base64_decode($input['no_pekerjaan']),
'no_nama_dokumen'   => NULL,
'nama_berkas'       => $lampiran,
'Pengupload'        => $this->session->userdata('no_user'),
'tanggal_upload'    => date('Y/m/d' )
);    
$this->db->insert('data_berkas',$data_berkas); 
}

public function set_jenis_dokumen(){
if($this->input->post()){
$input = $this->input->post();
$data = array(
'no_nama_dokumen' => $input['no_nama_dokumen']    
);

$this->db->update('data_berkas',$data,array('no_berkas'=>$input['no_berkas']));
}else{
redirect(404);    
} 
    
}


public function hapus_berkas_persyaratan(){
if($this->input->post()){
$input = $this->input->post();    
$data = $this->M_data_lama->hapus_berkas($input['id_data_berkas'])->row_array();
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

function form_edit_meta(){
if($this->input->post()){
$input = $this->input->post();
$data_meta = $this->M_data_lama->data_meta($input['no_nama_dokumen']);

echo "<div class='row border-top-0 mb-2 card border border-success p-3 data_edit".$input['no_berkas']."'>"
. "<div class='col-md-6'>"
. "<form id='form".$input['no_berkas']."'>";
echo '<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="required"  accept="text/plain">';
echo '<input type="hidden" name="no_berkas" value="'.$input['no_berkas'].'" readonly="" class="required"  accept="text/plain">';
echo '<input type="hidden" name="no_pekerjaan" value="'.base64_decode($input['no_pekerjaan']).'" readonly="" class="required"  accept="text/plain">';
echo '<input type="hidden" name="no_nama_dokumen" value="'.$input['no_nama_dokumen'].'" readonly="" class="required"  accept="text/plain">';

foreach ($data_meta->result_array()  as $d ){

$val = $this->M_data_lama->data_edit($input['no_berkas'],str_replace(' ', '_',$d['nama_meta']))->row_array();

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
echo "<hr>"
. "<button type='button' onclick=cancel_edit('".$input['no_berkas']."') class='btn col-md-3  btn-sm btn-danger  '>Cancel <i class='fas fa-arrow-up'></i></button>"
. "<button type='button' onclick=update_meta('".$input['no_berkas']."','".$input['no_nama_dokumen']."','".$input['no_client']."','".$input['no_pekerjaan']."') class='btn col-md-8  float-right ml-1 btn-sm btn-success '>Simpan Perubahahan <i class='fa fa-save'></i></button>"
. "</form>"
. "</div></div>";
    
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

public function  simpan_meta(){
$input = $this->input->post();

foreach ($input as $key=>$value){
if($key == 'no_berkas' || $key == "no_nama_dokumen" || $key == 'no_client' || $key == 'no_pekerjaan' || $key == 'file_berkas'){
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
$dokumen_utama = $this->M_data_lama->dokumen_utama($input['no_pekerjaan']);
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

public function upload_utama(){
if($this->input->post()){
$input = $this->input->post();
$this->form_validation->set_rules('no_pekerjaan', 'No pekerjaan', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('tanggal_akta', 'Tanggal akta', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('no_akta', 'Nomor Akta', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('jenis_utama', 'Jenis file utama', 'required',array('required' => 'Data ini tidak boleh kosong'));
$data_pekerjaan = $this->M_data_lama->data_pekerjaan(base64_decode($input['no_pekerjaan']))->row_array();

$config['upload_path']          = './berkas/'.$data_pekerjaan['nama_folder'];
$config['allowed_types']        = 'pdf|docx|doc|xlxs';
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
    $input = $this->input->post();
    $this->form_validation->set_rules('jenis_client', 'Jenis Pihak', 'required',array('required' => 'Data ini tidak boleh kosong'));
    $this->form_validation->set_rules('badan_hukum', 'Nama Pihak', 'required',array('required' => 'Data ini tidak boleh kosong'));
    $this->form_validation->set_rules('jenis_kontak', 'Jenis Kontak', 'required',array('required' => 'Data ini tidak boleh kosong'));
    $this->form_validation->set_rules('contact_person', 'Nama Kontak', 'required',array('required' => 'Data ini tidak boleh kosong'));
    $this->form_validation->set_rules('contact_number', 'Nomor Kontak', 'required',array('required' => 'Data ini tidak boleh kosong'));
    $this->form_validation->set_rules('no_identitas', 'No identitas NIK/NPWP', 'required',array('required' => 'Data ini tidak boleh kosong'));
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
    $h_berkas = $this->M_data_lama->hitung_pekerjaan()->num_rows()+1;
    $h_client = $this->M_data_lama->data_client()->num_rows()+1;
    $no_client    = "C".str_pad($h_client,6 ,"0",STR_PAD_LEFT);
    
    $data_client = array(
    'no_client'                 => $no_client,    
    'jenis_client'              => ucfirst($input['jenis_client']),    
    'no_identitas'              => $input['no_identitas'],    
    'nama_client'               => strtoupper($input['badan_hukum']),
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


public function hapus_keterlibatan(){
if($this->input->post()){
$input = $this->input->post();
$this->db->delete('data_pemilik',array('no_client'=>$input['no_client'],'no_pekerjaan'=> base64_decode($input['no_pekerjaan'])));

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
    function simpan_lampiran(){
        $input = $this->input->post();
        $data = $this->db->get_where('data_berkas',array('no_client'=>$input['no_client'],'no_pekerjaan'=> base64_decode($input['no_pekerjaan']),'no_nama_dokumen !='=>''));
        
        foreach ($data->result_array() as $d){
        $data = array(
        'status_berkas' =>'selesai'    
        );
        $this->db->update('data_berkas',$data,array('no_berkas'=>$d['no_berkas']));
        }
        }
        
        public function lihat_berkas_client(){    
            $data_client = $this->M_data_lama->data_client_where($this->uri->segment(3));       
            
            $this->load->view('umum/V_header');
            $this->load->view('data_lama/V_lihat_berkas_client',['data_client'=>$data_client]);   
            }
            public function lihat_lampiran_client(){    
            $data_client = $this->M_data_lama->data_client_where($this->uri->segment(3));       
            
            $this->load->view('umum/V_header');
            $this->load->view('data_lama/V_lihat_lampiran_client',['data_client'=>$data_client]);   
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
                    
                    $data_meta = $this->M_data_lama->data_meta($input['no_nama_dokumen']);
                    
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
                    $val = $this->M_data_lama->data_edit($input['no_berkas'],str_replace(' ', '_',$d['nama_meta']))->row_array();
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
                            $data = array(
                            'no_user'   => $this->session->userdata('no_user'),
                            'keterangan'=>$keterangan,
                            'tanggal'   =>date('Y/m/d H:i:s'),
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
}


