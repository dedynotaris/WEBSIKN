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
$this->load->view('umum/V_header');
$this->load->view('data_lama/V_data_lama');


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
'label'                    => $d->nama_jenis,   
'no_jenis_pekerjaan'                => $d->no_jenis_dokumen,
);   
}
echo json_encode($json);
}

public function create_client(){
  if($this->input->post()){
$data = $this->input->post();

$h_client = $this->M_data_lama->data_client()->num_rows()+1;

$no_client    = str_pad($h_client,6 ,"0",STR_PAD_LEFT);

$data_client = array(
'no_client'                 => "C_".$no_client,    
'jenis_client'              => ucwords($data['jenis_client']),    
'nama_client'               => strtoupper($data['badan_hukum']),
'alamat_client'             => ucwords($data['alamat_badan_hukum']),    
'tanggal_daftar'            => date('Y/m/d H:i:s'),    
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

public function opsi_nama_dokumen(){
         $this->db->order_by('nama_dokumen.nama_dokumen','ASC');
$query = $this->db->get('nama_dokumen');
echo "<option>---Pilih Jenis dokumen----</option";
foreach ($query->result_array() as $d){
echo "><option value=".$d['no_nama_dokumen'].">".$d['nama_dokumen']."</option>";    
}

}

public function data_meta(){
if($this->input->post()){
$input = $this->input->post();

$data_meta = $this->db->get_where('data_meta',array('no_nama_dokumen'=>$input['no_nama_dokumen']));

$static = $data_meta->row_array();
if($static['nama_meta']  == 'Informasi'){
echo "<label>Informasi</label>"
    ."<textarea id='informasi' class='form-control informasi'></textarea>";    
}else{
    $h=1;
    foreach ($data_meta->result_array() as $meta){
        echo "<label>".$meta['nama_meta']."</label>"
         . "<input type='text' id='data_meta".$h++."' name='".$meta['nama_meta']."' class='form-control meta_data required' accept='text/plain'>";
        
    }    
    
}

}else{
redirect(404);    
}
    
}

public function simpan_berkas(){
if($this->input->post()){
$input = $this->input->post();
$query     = $this->M_data_lama->data_client_where($input['no_client']);
$static    = $query->row_array();
$config['upload_path']          = './berkas/'.$static['nama_folder'];
$config['allowed_types']        = 'gif|jpg|png|pdf|docx|doc|xlxs|';
$config['encrypt_name']         = TRUE;

if($input['nama_dokumen'] == "Draft" || $input['nama_dokumen'] == "Minuta" || $input['nama_dokumen'] == "Salinan" ){
$this->upload->initialize($config);    

if (!$this->upload->do_upload('file_berkas')){
$status = array(
"status"     => "error",
"pesan"      => $this->upload->display_errors()    
);

}else{

$data = array(
'nama_file'    =>$this->upload->data('file_name'),
'nama_berkas'  =>$input['nama_dokumen'],
'nama_folder'  =>$static['nama_folder'],
'no_client'    =>$input['no_client'],
'waktu'        =>date('Y/m/d'),
);

$this->db->insert('data_dokumen_utama',$data);    
$status = array(
"status"     => "success",
"pesan"      => "Dokumen utama berhasil ditambahkan"    
);

}
}else{
$this->upload->initialize($config);    

if (!$this->upload->do_upload('file_berkas')){  
$status = array(
"status"     => "error",
"pesan"      => $this->upload->display_errors()    
);
echo json_encode($status);
}else{
}

    
if(!empty($input['data_informasi'])){
$this->simpan_data_informasi($input,$static,$this->upload->data());
}else if(!empty($input['data_meta'])){
$this->simpan_data_meta($input,$static,$this->upload->data());
}
$status = array(
"status"     => "success",
"pesan"      => "Dokumen Lama berhasil diupload"    
);
}
echo json_encode($status);
}else{
redirect(404);    
}

}

public function simpan_data_meta($input,$static,$lampiran){
$data_berkas = array(
'no_client'         => $static['no_client'],
'no_nama_dokumen'   => $input['no_nama_dokumen'],
'pemberi_pekerjaan' => $this->session->userdata('no_user'),
'nama_folder'       => $static['nama_folder'],
'nama_berkas'       => $lampiran['file_name'],
'nama_file'         => $input['nama_dokumen'],    
'status_berkas'     => 'Data lama',
'Pengupload'        => $this->session->userdata('nama_lengkap'),
'tanggal_upload'    => date('Y/m/d H:is' ),  
);    
$this->db->insert('data_berkas',$data_berkas);

    
$data_meta = json_decode($input['data_meta']);
foreach ($data_meta as $key=>$value){
$meta = array(
'nama_berkas'    => $lampiran['file_name'],
'no_client'      => $input['no_client'],
'no_nama_dokumen'=> $input['no_nama_dokumen'],
'nama_folder'    => $static['nama_folder'],
'nama_meta'      => $key,
'value_meta'     => $value,    
);
$this->db->insert('data_meta_berkas',$meta);

}   
}

public function simpan_data_informasi($input,$static,$lampiran){
$data = array(
'data_informasi'   => $input['data_informasi'],
'no_client'        => $input['no_client'],
'nama_informasi'   => $input['nama_dokumen'],    
'nama_folder'      => $static['nama_folder'],
'lampiran'         => $lampiran['file_name']   
);

$this->db->insert('data_informasi_pekerjaan',$data);

}

}


