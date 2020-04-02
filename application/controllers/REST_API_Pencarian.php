<?php
require APPPATH . '/libraries/REST_Controller.php';
class REST_API_Pencarian extends REST_Controller{
function __construct($config = 'rest'){
    parent::__construct($config);
    $this->load->model('M_dashboard_perizinan');
}

function index_get(){
    echo "get";
}


public function index_post(){
//Cari Client    
if($this->post('status') == 'CariClient'){       
$this->db->select('data_client.nama_client,'
        . 'user.nama_lengkap as pembuat_client,'
        . 'data_client.jenis_client,'
        . 'data_client.contact_person,'
        . 'data_client.contact_number,'
        . 'data_client.alamat_client,'
        . 'data_client.nama_folder,'
        . 'data_client.no_client');
$this->db->from('data_client');
$this->db->join('user', 'user.no_user = data_client.no_user');
$this->db->like('data_client.nama_client',$this->post('kata_kunci'));
$query = $this->db->get();
if($query->num_rows() == 0){
$status = array(
'status_response'  =>'error',    
'messages'         =>'Pencarian tidak ditemukan',
);
}else{
foreach ($query->result_array() as $client){
                      $this->db->where_in('status_pekerjaan',array('Proses','ArsipProses'));
                     $this->db->where('no_client',$client['no_client']);
$pekerjaan_proses  = $this->db->get('data_pekerjaan')->num_rows();
                    
                      $this->db->where_in('status_pekerjaan',array('Masuk','ArsipMasuk'));
                     $this->db->where('no_client',$client['no_client']);
$pekerjaan_masuk  = $this->db->get('data_pekerjaan')->num_rows();

                      $this->db->where_in('status_pekerjaan',array('Selesai','ArsipSelesai'));
                     $this->db->where('no_client',$client['no_client']);
$pekerjaan_selesai  = $this->db->get('data_pekerjaan')->num_rows();


$perizinan_masuk    = $this->db->get_where('data_berkas_perizinan',array('no_client'=>$client['no_client'],'status_berkas'=>'Masuk'))->num_rows();
        
$perizinan_proses    = $this->db->get_where('data_berkas_perizinan',array('no_client'=>$client['no_client'],'status_berkas'=>'Proses'))->num_rows();

$perizinan_selesai    = $this->db->get_where('data_berkas_perizinan',array('no_client'=>$client['no_client'],'status_berkas'=>'Selesai'))->num_rows();

$data[] = array(
'nama_client'    =>$client['nama_client'],
'jenis_client'   =>$client['jenis_client'],
'no_client'      =>$client['no_client'],
'pembuat_client' =>$client['pembuat_client'],
'contact_number' =>$client['contact_number'],
'contact_person' =>$client['contact_person'],
'alamat_client' =>$client['alamat_client'],
'pekerjaan_proses'  =>$pekerjaan_proses,   
'pekerjaan_masuk'   =>$pekerjaan_masuk,  
'pekerjaan_selesai' =>$pekerjaan_selesai,   
'perizinan_proses'  =>$perizinan_proses,   
'perizinan_masuk'   =>$perizinan_masuk,  
'perizinan_selesai' =>$perizinan_selesai,   
);    
}

$status = array(
'status_response'  =>'success',    
'messages'         =>'Pencarian ditemukan',
'hasil'            =>$data    
);
}
$this->response($status,REST_Controller::HTTP_CREATED);
//Cari Client 
}elseif($this->post('status') == 'DokumenPenunjang'){

$this->db->select('data_berkas.nama_berkas,'
. 'nama_dokumen.nama_dokumen,'
. 'nama_dokumen.no_nama_dokumen,'
. 'data_client.nama_folder,'
. 'data_berkas.mime-type,'
. 'data_berkas.no_berkas');
$this->db->from('data_berkas');
$this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
$this->db->join('nama_dokumen','nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
$this->db->where('data_berkas.no_client',$this->post('no_client'));
$data_dokumen_penunjang = $this->db->get();


if($data_dokumen_penunjang->num_rows() == 0){$status = array(
'status_response'  =>'error',    
'messages'         =>'Dokumen Penunjang tidak tersedia',
);
    
}else{    
foreach ($data_dokumen_penunjang->result_array() as $penunjang){

$this->db->select('data_meta_berkas.nama_meta,'
        . 'data_meta_berkas.value_meta');
$this->db->from('data_meta_berkas');
$this->db->where('data_meta_berkas.no_berkas',$penunjang['no_berkas']);
$meta = $this->db->get();

$met = array();
foreach ($meta->result_array() as $m){
$met[] = array(
'nama_meta'   =>str_replace('_', ' ',$m['nama_meta']),    
'value_meta'  =>str_replace('_', ' ',$m['value_meta']),    
);    
}

$data[] = array(
'no_berkas'         =>$penunjang['no_berkas'],
'nama_berkas'       =>$penunjang['nama_berkas'],
'nama_folder'       =>$penunjang['nama_folder'],
'title'             =>$penunjang['nama_dokumen'],
'mime_type'         =>$penunjang['mime-type'],      
'isi'               =>$met
    
);    
}

$status = array(
'status_response'  =>'success',    
'messages'         =>'Dokumen Ditemukan',
'DokumenPenunjang' =>$data    
);    
}
$this->response($status,REST_Controller::HTTP_CREATED);

}elseif($this->post('status') == 'DaftarPekerjaan'){

$this->db->select('data_jenis_pekerjaan.nama_jenis as nama_jenis,'
        . 'user.nama_lengkap as pembuat_pekerjaan,'
        . 'data_pekerjaan.no_pekerjaan as no_pekerjaan,'
        . 'data_pekerjaan.tanggal_dibuat as tanggal_dibuat,'
        . 'data_client.nama_folder as nama_folder,'
        . 'data_pekerjaan.target_kelar as target_selesai,'
        . 'data_pekerjaan.tanggal_selesai as tanggal_selesai,'
        . 'data_daftar_loker.no_loker as no_loker,'
        . 'data_daftar_lemari.nama_tempat as nama_tempat');
$this->db->from('data_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->join('data_jenis_pekerjaan','data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->db->join('user', 'user.no_user = data_pekerjaan.no_user');
$this->db->join('data_daftar_loker', 'data_daftar_loker.id_no_loker = data_pekerjaan.id_no_loker','left');
$this->db->join('data_daftar_lemari', 'data_daftar_lemari.no_lemari = data_daftar_loker.no_lemari','left');
$this->db->where('data_pekerjaan.no_client',$this->post('no_client'));    
$data_pekerjaan = $this->db->get();

if($data_pekerjaan->num_rows() == 0){
$status = array(
'status_response'  =>'error',    
'messages'         =>'Pekerjaan Tidak Ditemukan',
);    
}else{
foreach ($data_pekerjaan->result_array() as $p){
$data[] = array(
'no_pekerjaan'          =>$p['no_pekerjaan'],    
'nama_folder'           =>$p['nama_folder'],    
'nama_jenis'            =>$p['nama_jenis'],    
'tanggal_dibuat'        =>$p['tanggal_dibuat'],    
'tanggal_selesai'       =>$p['tanggal_selesai'],    
'target_selesai'        =>$p['target_selesai'],    
'pembuat_pekerjaan'     =>$p['pembuat_pekerjaan'],
'no_loker'              =>$p['no_loker'],
'nama_tempat'           =>$p['nama_tempat'],
    
);    
}

$status = array(
'status_response'  =>'success',    
'messages'         =>'Daftar Pekerjaan Ditemukan',
'DaftarPekerjaan'  =>$data    
);    
}
$this->response($status,REST_Controller::HTTP_CREATED);
    
}elseif($this->post('status') == 'DokumenUtama'){


$this->db->select('data_dokumen_utama.tanggal_akta,'
        . 'data_dokumen_utama.no_akta,'
        . 'data_dokumen_utama.waktu,'
        . 'data_dokumen_utama.mime-type,'
        . 'data_dokumen_utama.jenis,'
        . 'data_dokumen_utama.nama_file');
$this->db->from('data_dokumen_utama');
$this->db->where('data_dokumen_utama.no_pekerjaan',$this->post('no_pekerjaan'));    
$dokumen_utama = $this->db->get();

if($dokumen_utama->num_rows() == 0){
$status = array(
'status_response'  =>'error',    
'messages'         =>'Dokumen Utama Tidak Tersedia',
);      
}else{
foreach ($dokumen_utama->result_array() as $p){
$data[] = array(
'tanggal_akta'          =>$p['tanggal_akta'],    
'no_akta'               =>$p['no_akta'],    
'jenis'                 =>$p['jenis'],    
'nama_file'             =>$p['nama_file'],    
'mime_type'             =>$p['mime-type'],    
'tanggal_upload'        =>$p['waktu']    
);    
}

$status = array(
'status_response'  =>'success',    
'messages'         =>'Dokumen Utama Ditemukan',
'DokumenUtama'     =>$data    
);        
}
    
  

$this->response($status,REST_Controller::HTTP_CREATED);   
}elseif($this->post('status') == 'PihakTerlibat'){
$this->db->select('data_client.nama_client,'
        . 'data_client.jenis_client,'
        . 'data_client.contact_person,'
        . 'data_client.contact_number,'
        . 'user.nama_lengkap as pembuat_client,'
        . 'data_client.alamat_client,'
        . 'data_client.no_client');
$this->db->from('data_pemilik');
$this->db->join('data_client', 'data_client.no_client = data_pemilik.no_client');
$this->db->join('user', 'user.no_user = data_client.no_user');

$this->db->where('data_pemilik.no_pekerjaan',$this->post('no_pekerjaan'));    
$data_terlibat = $this->db->get();    

if($data_terlibat->num_rows() == 0){
$status = array(
'status_response'  =>'success',    
'messages'         =>'Pihak Terlibat Tidak Tersedia'    
);     
}else{
foreach ($data_terlibat->result_array() as $t){
                     $this->db->where_in('status_pekerjaan',array('Proses','ArsipProses'));
                     $this->db->where('no_client',$t['no_client']);
$pekerjaan_proses  = $this->db->get('data_pekerjaan')->num_rows();
                    
                      $this->db->where_in('status_pekerjaan',array('Masuk','ArsipMasuk'));
                     $this->db->where('no_client',$t['no_client']);
$pekerjaan_masuk  = $this->db->get('data_pekerjaan')->num_rows();

                      $this->db->where_in('status_pekerjaan',array('Selesai','ArsipSelesai'));
                     $this->db->where('no_client',$t['no_client']);
$pekerjaan_selesai  = $this->db->get('data_pekerjaan')->num_rows();


$perizinan_masuk    = $this->db->get_where('data_berkas_perizinan',array('no_client'=>$t['no_client'],'status_berkas'=>'Masuk'))->num_rows();
        
$perizinan_proses    = $this->db->get_where('data_berkas_perizinan',array('no_client'=>$t['no_client'],'status_berkas'=>'Proses'))->num_rows();

$perizinan_selesai    = $this->db->get_where('data_berkas_perizinan',array('no_client'=>$t['no_client'],'status_berkas'=>'Selesai'))->num_rows();
    
    
$data[] = array(
'no_client'             =>$t['no_client'],    
'nama_client'           =>$t['nama_client'],
'jenis_client'          =>$t['jenis_client'],
'no_client'             =>$t['no_client'],
'pembuat_client'        =>$t['pembuat_client'],
'contact_number'        =>$t['contact_number'],
'contact_person'        =>$t['contact_person'],
'pekerjaan_proses'  =>$pekerjaan_proses,   
'pekerjaan_masuk'   =>$pekerjaan_masuk,  
'pekerjaan_selesai' =>$pekerjaan_selesai,   
'perizinan_proses'  =>$perizinan_proses,   
'perizinan_masuk'   =>$perizinan_masuk,  
'perizinan_selesai' =>$perizinan_selesai,     
    
);    
}

$status = array(
'status_response'  =>'success',    
'messages'         =>'Pihak Terlibat Tersedia',
'PihakTerlibat'     =>$data    
);        
}
 
$this->response($status,REST_Controller::HTTP_CREATED);   
}
}
}