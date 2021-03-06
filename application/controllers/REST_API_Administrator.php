<?php
require APPPATH . '/libraries/REST_Controller.php';
class REST_API_Administrator extends REST_Controller{
function __construct($config = 'rest'){
    parent::__construct($config);
    $this->load->model('M_dashboard_perizinan');
}

function index_get(){
    echo "get";
}

public function index_post(){
if($this->post('status') == 'CekAkses'){

$cek = $this->db->get_where('sublevel_user',array('sublevel'=>'Level 1','no_user'=>$this->post('no_user'))); 
    
if($cek->num_rows() == 0){
$status = array(
'status_response'  =>'error',    
'messages'         =>'Anda Tidak Memiliki Akses Di Menu Ini',
);    
}else{

$status = array(
'status_response'  =>'success',    
'messages'         =>'User Memiliki Akses',
);  
}
$this->response($status,REST_Controller::HTTP_CREATED);   
}else if($this->post('status') == 'DaftarPekerjaan'){
$this->db->select('data_jenis_pekerjaan.nama_jenis as nama_jenis,'
        . 'data_pekerjaan.no_pekerjaan as no_pekerjaan,'
        . 'data_pekerjaan.no_jenis_pekerjaan');
$this->db->from('data_pekerjaan');
$this->db->join('data_jenis_pekerjaan','data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->db->group_by('data_jenis_pekerjaan.no_jenis_pekerjaan');
$this->db->where('data_pekerjaan.status_pekerjaan',$this->post('status_pekerjaan'));  

$data_pekerjaan = $this->db->get();
if($data_pekerjaan->num_rows() == 0){
$status = array(
'status_response'  =>'error',    
'messages'         =>'Pekerjaan '.$this->post('status_pekerjaan').' Tidak Tersedia',
'DaftarPekerjaan'  =>''        
);    
}else{
foreach ($data_pekerjaan->result_array() as $p){
$data[] = array(
'no_jenis_pekerjaan'    =>$p['no_jenis_pekerjaan'],    
'nama_jenis'            =>$p['nama_jenis'],
'jumlah'                =>$this->db->get_where('data_pekerjaan',array('status_pekerjaan'=>$this->post('status_pekerjaan'),'no_jenis_pekerjaan'=>$p['no_jenis_pekerjaan']))->num_rows()    
);    
}


$status = array(
'status_response'  =>'success',    
'messages'         =>'Daftar Pekerjaan Ditemukan',
'DaftarPekerjaan'  =>$data    
);  
}
$this->response($status,REST_Controller::HTTP_CREATED);
   
}else if($this->post('status') == 'DetailPekerjaan'){
$this->db->select('data_jenis_pekerjaan.nama_jenis as nama_jenis,'
        . 'data_pekerjaan.no_pekerjaan as no_pekerjaan,'
        . 'data_pekerjaan.no_jenis_pekerjaan,'
        . 'data_client.nama_client,'
        . 'data_client.no_client,'
        . 'data_pekerjaan.tanggal_dibuat,'
        . 'data_pekerjaan.tanggal_selesai,'
        . 'data_pekerjaan.target_kelar,'
        . 'user.nama_lengkap as nama_asisten,'
        . 'data_pekerjaan.no_pekerjaan');
$this->db->from('data_pekerjaan');
$this->db->join('data_client','data_client.no_client = data_pekerjaan.no_client');
$this->db->join('data_jenis_pekerjaan','data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->db->join('user','user.no_user = data_pekerjaan.no_user');
$this->db->where('data_pekerjaan.status_pekerjaan',$this->post('status_pekerjaan'));  
$this->db->where('data_pekerjaan.no_jenis_pekerjaan',$this->post('no_jenis_pekerjaan'));  

$data_pekerjaan = $this->db->get();
if($data_pekerjaan->num_rows() == 0){
$status = array(
'status_response'  =>'error',    
'messages'         =>'Detail Pekerjaan '.$this->post('status_pekerjaan').' Tidak Tersedia',
'DetailPekerjaan'  =>''        
);    
}else{
foreach ($data_pekerjaan->result_array() as $p){
$data[] = array(
'no_jenis_pekerjaan'    =>$p['no_jenis_pekerjaan'],    
'nama_jenis'            =>$p['nama_jenis'],
'nama_client'           =>$p['nama_client'],
'nama_asisten'          =>$p['nama_asisten'],
'tanggal_dibuat'        =>$p['tanggal_dibuat'],
'target_selesai'        =>$p['target_kelar'],
'tanggal_selesai'       =>$p['tanggal_selesai'],
'no_pekerjaan'          =>$p['no_pekerjaan'],    
'no_client'             =>$p['no_client'],    
);    
}


$status = array(
'status_response'  =>'success',    
'messages'         =>'Detail Pekerjaan Ditemukan',
'DetailPekerjaan'  =>$data    
);  
}
$this->response($status,REST_Controller::HTTP_CREATED);
    
}
else if($this->post('status') == 'DataAsisten'){
$this->db->select('user.nama_lengkap,'
        . 'user.email,'
        . 'user.no_user,'
        . 'user.phone');
$this->db->from('sublevel_user');
$this->db->join('user', 'user.no_user = sublevel_user.no_user');
$this->db->where('sublevel_user.sublevel',$this->post('level'));  
$data_asisten = $this->db->get();

foreach ($data_asisten->result_array() as $a){
    
                     $this->db->where_in('status_pekerjaan',array('Proses','ArsipProses'));
                     $this->db->where('no_user',$a['no_user']);
$pekerjaan_proses  = $this->db->get('data_pekerjaan')->num_rows();
                    
                     $this->db->where_in('status_pekerjaan',array('Masuk','ArsipMasuk'));
                      $this->db->where('no_user',$a['no_user']);
$pekerjaan_masuk  =  $this->db->get('data_pekerjaan')->num_rows();

                      $this->db->where_in('status_pekerjaan',array('Selesai','ArsipSelesai'));
                       $this->db->where('no_user',$a['no_user']);
$pekerjaan_selesai  = $this->db->get('data_pekerjaan')->num_rows();
    
$perizinan_masuk    = $this->db->get_where('data_berkas_perizinan',array('no_user_perizinan'=>$a['no_user'],'status_berkas'=>'Masuk'))->num_rows();
        
$perizinan_proses    = $this->db->get_where('data_berkas_perizinan',array('no_user_perizinan'=>$a['no_user'],'status_berkas'=>'Proses'))->num_rows();

$perizinan_selesai    = $this->db->get_where('data_berkas_perizinan',array('no_user_perizinan'=>$a['no_user'],'status_berkas'=>'Selesai'))->num_rows();

if($a['nama_lengkap'] !='Admin' && $this->post('nama_asisten') != $a['nama_lengkap']){
$data[] =array(
'no_user'               =>$a['no_user'],
'nama_asisten'          =>$a['nama_lengkap'],
'email'                 =>$a['email'],
'phone'                 =>$a['phone'],
'pekerjaan_masuk'       =>$pekerjaan_masuk,    
'pekerjaan_proses'      =>$pekerjaan_proses,    
'pekerjaan_selesai'     =>$pekerjaan_selesai,
'perizinan_proses'      =>$perizinan_proses,   
'perizinan_masuk'       =>$perizinan_masuk,  
'perizinan_selesai'     =>$perizinan_selesai,     
);    
}
}

$status = array(
'status_response'  =>'success',    
'messages'         =>'Data Asisten Ditemukan',
'DataAsisten'       =>$data    
);
$this->response($status,REST_Controller::HTTP_CREATED);

}else if($this->post('status') == 'DataProgressPekerjaan'){
                $this->db->order_by('id_data_progress_pekerjaan','DESC');
$data_laporan = $this->db->get_where('data_progress_pekerjaan',array('no_pekerjaan'=>$this->post('no_pekerjaan')));
if($data_laporan->num_rows() != 0){
foreach ($data_laporan->result_array() as $l){
$data[] = array(
'laporan' =>$l['laporan_pekerjaan'],
'waktu'   =>$l['waktu']    
);
}

$status = array(
'status_response'  =>'success',    
'messages'         =>'Laporan Tersedia',
'DataLaporan'      =>$data    
);
}else{
$status = array(
'status_response'  =>'error',    
'messages'         =>'Belum ada laporan yang diberikan',
);    
}

$this->response($status,REST_Controller::HTTP_CREATED);
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
$this->db->where('data_berkas.no_pekerjaan',$this->post('no_pekerjaan'));
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

}elseif($this->post('status') == 'DokumenUtama'){


$this->db->select('data_dokumen_utama.tanggal_akta,'
        . 'data_dokumen_utama.no_akta,'
        . 'data_dokumen_utama.waktu,'
        . 'data_dokumen_utama.mime-type,'
        . 'data_dokumen_utama.jenis,'
        . 'data_dokumen_utama.nama_file,'
        . 'data_client.nama_folder');
$this->db->from('data_dokumen_utama');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_dokumen_utama.no_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');

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
'tanggal_upload'        =>$p['waktu'],
'nama_folder'           =>$p['nama_folder']    
);    
}

$status = array(
'status_response'  =>'success',    
'messages'         =>'Dokumen Utama Ditemukan',
'DokumenUtama'     =>$data    
);        
}
    
  

$this->response($status,REST_Controller::HTTP_CREATED);   
}elseif($this->post('status') == 'DaftarPerizinan'){

$this->db->select('data_jenis_pekerjaan.nama_jenis,'
        . 'nama_dokumen.nama_dokumen,'
        . 'nama_dokumen.no_nama_dokumen,'
        . 'data_berkas_perizinan.no_berkas_perizinan,'
        . 'data_pekerjaan.no_pekerjaan');
$this->db->from('data_berkas_perizinan');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_berkas_perizinan.no_pekerjaan');
$this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->db->join('nama_dokumen','nama_dokumen.no_nama_dokumen = data_berkas_perizinan.no_nama_dokumen');
$this->db->group_by('data_berkas_perizinan.no_nama_dokumen');
$this->db->where('data_berkas_perizinan.status_berkas',$this->post('status_perizinan'));    

$data_perizinan = $this->db->get();

if($data_perizinan->num_rows() == 0){
$status = array(
'status_response'  =>'error',    
'messages'         =>'Dokumen Perizinan Tidak Tersedia',
'DaftarPerizinan'  =>''    
);      
}else{
foreach ($data_perizinan->result_array() as $p){
$data[] = array(
'nama_dokumen'         =>$p['nama_dokumen'],    
'no_pekerjaan'         =>$p['no_pekerjaan'],    
'no_nama_dokumen'      =>$p['no_nama_dokumen'],
'jumlah'               =>$this->db->get_where('data_berkas_perizinan',array('status_berkas'=>$this->post('status_perizinan'),'no_nama_dokumen'=>$p['no_nama_dokumen']))->num_rows()    
);    
}

$status = array(
'status_response'  =>'success',    
'messages'         =>'Dokumen Perizinan Ditemukan',
'DaftarPerizinan'  =>$data    
); 
}
$this->response($status,REST_Controller::HTTP_CREATED);
}else if($this->post('status') == 'DetailDataPerizinan'){

$this->db->select('data_jenis_pekerjaan.nama_jenis,'
        . 'nama_dokumen.nama_dokumen,'
        . 'data_client.nama_client,'
        . 'data_client.no_client,'
        . 'petugas.nama_lengkap,'
        . 'penugas.nama_lengkap as nama_penugas,'
        . 'data_berkas_perizinan.tanggal_penugasan,'
        . 'data_berkas_perizinan.target_selesai_perizinan,'
        . 'data_berkas_perizinan.status_berkas as status_perizinan,'
        . 'data_berkas_perizinan.tanggal_selesai,'
        . 'data_berkas_perizinan.no_berkas_perizinan,'
        . 'data_pekerjaan.no_pekerjaan');
$this->db->from('data_berkas_perizinan');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_berkas_perizinan.no_pekerjaan');
$this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->db->join('nama_dokumen','nama_dokumen.no_nama_dokumen = data_berkas_perizinan.no_nama_dokumen');
$this->db->join('data_client','data_client.no_client = data_berkas_perizinan.no_client');
$this->db->join('user as petugas', 'petugas.no_user = data_berkas_perizinan.no_user_perizinan');
$this->db->join('user as penugas', 'penugas.no_user = data_berkas_perizinan.no_user_penugas');
$this->db->where('data_berkas_perizinan.no_pekerjaan',$this->post('no_pekerjaan'));    
$this->db->where('data_berkas_perizinan.no_client',$this->post('no_client'));    

$data_perizinan = $this->db->get();

if($data_perizinan->num_rows() == 0){
$status = array(
'status_response'  =>'error',    
'messages'         =>'Detail Perizinan Tidak Tersedia',
'DetailPerizinan'  =>''    
);      
}else{
foreach ($data_perizinan->result_array() as $p){
$data[] = array(
'nama_client'          =>$p['nama_client'],    
'nama_dokumen'         =>$p['nama_dokumen'],    
'jenis_pekerjaan'      =>$p['nama_jenis'],    
'petugas'              =>$p['nama_lengkap'],    
'penugas'              =>$p['nama_penugas'],    
'tanggal_penugasan'    =>$p['tanggal_penugasan'],    
'target_selesai'       =>$p['target_selesai_perizinan'],    
'tanggal_selesai'      =>$p['tanggal_selesai'],
'no_berkas_perizinan'  =>$p['no_berkas_perizinan'],
'no_pekerjaan'         =>$p['no_pekerjaan'],
'no_client'            =>$p['no_client'],
'status_perizinan'     =>$p['status_perizinan']    
);    
}

$status = array(
'status_response'  =>'success',    
'messages'         =>'Dokumen Perizinan Ditemukan',
'DetailPerizinan'  =>$data    
); 
}
$this->response($status,REST_Controller::HTTP_CREATED);    
}else if($this->post('status') == 'DataProgressPerizinan'){
                $this->db->order_by('id_laporan','DESC');
$data_laporan = $this->db->get_where('data_progress_perizinan',array('no_berkas_perizinan'=>$this->post('no_berkas_perizinan')));
if($data_laporan->num_rows() != 0){
foreach ($data_laporan->result_array() as $l){
$data[] = array(
'laporan' =>$l['laporan'],
'waktu'   =>$l['waktu']    
);
}

$status = array(
'status_response'  =>'success',    
'messages'         =>'Laporan Tersedia',
'DataLaporan'      =>$data    
);
}else{
$status = array(
'status_response'  =>'error',    
'messages'         =>'Belum ada laporan yang diberikan',
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
$this->db->select('nama_dokumen.nama_dokumen,'
        . 'data_berkas_perizinan.status_berkas,'
        . 'data_berkas_perizinan.no_berkas_perizinan,'
        . 'data_berkas_perizinan.target_selesai_perizinan,'
        . 'petugas.nama_lengkap,'
        . 'penugas.nama_lengkap as nama_penugas'
        );
$this->db->from('data_berkas_perizinan');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas_perizinan.no_nama_dokumen');
$this->db->join('user as petugas', 'petugas.no_user = data_berkas_perizinan.no_user_perizinan');
$this->db->join('user as penugas', 'penugas.no_user = data_berkas_perizinan.no_user_penugas');
$this->db->where('data_berkas_perizinan.no_pekerjaan',$this->post('no_pekerjaan'));    
$this->db->where('data_berkas_perizinan.no_client',$t['no_client']);    
$data_perizinan = $this->db->get(); 

$per = array();
foreach ($data_perizinan->result_array() as $perizinan){
$per[]=array(
'nama_dokumen'              =>$perizinan['nama_dokumen'],
'status_dokumen'            =>$perizinan['status_berkas'],
'no_berkas_perizinan'       =>$perizinan['no_berkas_perizinan'],
'petugas'                   =>$perizinan['nama_lengkap'],
'penugas'                   =>$perizinan['nama_penugas'],
'target_selesai'            =>$perizinan['target_selesai_perizinan'],
);    
}

$data[] = array(
'no_client'             =>$t['no_client'],    
'nama_client'           =>$t['nama_client'],
'jenis_client'          =>$t['jenis_client'],
'no_client'             =>$t['no_client'],
'pembuat_client'        =>$t['pembuat_client'],
'contact_number'        =>$t['contact_number'],
'contact_person'        =>$t['contact_person'],
'data_perizinan'        =>$per    
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

public function index_put(){
if($this->put('status') == 'UpdateDataPekerjaan'){
$data = array(
'no_user' =>$this->put('no_user')    
);
$this->db->update('data_pekerjaan',$data,array('no_pekerjaan'=>$this->put('no_pekerjaan')));
    
$status = array(
'status_response'  =>'success',    
'messages'         =>'Data Pekerjaan Berhasil Di Alihkan',
);
$this->response($status,REST_Controller::HTTP_CREATED);
 
}else if($this->put('status') == 'UpdateDataPerizinan'){
$data = array(
'no_user_perizinan' =>$this->put('no_user'),    
'status_lihat' =>null,    
'status_berkas' =>'Masuk'    
);
$this->db->update('data_berkas_perizinan',$data,array('no_berkas_perizinan'=>$this->put('no_berkas_perizinan')));
    
$status = array(
'status_response'  =>'success',    
'messages'         =>'Data Perizinan Berhasil Di Alihkan',
);
$this->response($status,REST_Controller::HTTP_CREATED);
} 
}    

}