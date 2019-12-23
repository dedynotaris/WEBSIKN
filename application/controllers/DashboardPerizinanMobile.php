<?php 
require APPPATH . '/libraries/REST_Controller.php';
class DashboardPerizinanMobile extends REST_Controller{
function __construct($config = 'rest'){
    parent::__construct($config);
    $this->load->model('M_dashboard_perizinan');
}

function index_get(){
echo "get";
}

function index_post(){
$json   = file_get_contents('php://input');
$input  = json_decode($json,true);

if($input['status'] =='Masuk'  || $input['status']  == 'Proses' || $input['status'] == 'Selesai'){

$data_perizinan_masuk = $this->M_dashboard_perizinan->data_pekerjaan_perizinan($input['status'],$input['no_user']);

if($data_perizinan_masuk->num_rows() == 0){
$perizinan_masuk[] = array(
    'status_data'  => "kosong"
);
echo json_encode($perizinan_masuk);        

}else{
foreach($data_perizinan_masuk->result_array() as $dm){
$target_selesai_perizinan = $dm['target_selesai_perizinan'];
$tanggal_penugasan        = $dm['tanggal_penugasan'];
      
$perizinan_masuk[] = array(
'nama_dokumen'              => $dm['nama_dokumen'],
'no_nama_dokumen'           => $dm['no_nama_dokumen'],
'nama_petugas'              => $dm['nama_lengkap'],
'nama_client'               => $dm['nama_client'],
'tanggal_penugasan'         => $tanggal_penugasan,
'target_selesai_perizinan'  => $target_selesai_perizinan,
'no_berkas_perizinan'       => $dm['no_berkas_perizinan']
);
}
echo json_encode($perizinan_masuk);
}

}else if($input['status'] == 'SimpanProsesPerizinan'){

$data = array(
'status_lihat'              =>'Dilihat',
'status_berkas'             =>'Proses',
'target_selesai_perizinan'  =>$input['target_selesai']
); 

$this->db->where('no_berkas_perizinan',$input['no_berkas']);
$this->db->update('data_berkas_perizinan',$data);
echo json_encode("success");
}else if($input['status'] == "SimpanPenolakan"){
$alasan_penolakan = array(
'no_berkas_perizinan'   =>$input['no_berkas'], 
'laporan'               =>$input['alasan_penolakan'],
'waktu'                 =>date('Y/m/d')
);
$this->db->update('data_progress_perizinan',$alasan_penolakan,array('no_berkas_perizinan'=>$input['no_berkas']));  
$status = array(
'status_berkas' =>'Ditolak'
);
$this->db->update('data_berkas_perizinan',$status,array('no_berkas_perizinan'=>$input['no_berkas']));  

echo json_encode("success");
}else if($input['status'] =='DataJumlah'){
$jumlah_masuk = $this->db->get_where('data_berkas_perizinan',array('no_user_perizinan'=>$input['no_user'],'status_berkas'=>'Masuk'))->num_rows();
$jumlah_proses = $this->db->get_where('data_berkas_perizinan',array('no_user_perizinan'=>$input['no_user'],'status_berkas'=>'Proses'))->num_rows();
$jumlah_selesai = $this->db->get_where('data_berkas_perizinan',array('no_user_perizinan'=>$input['no_user'],'status_berkas'=>'Selesai'))->num_rows();


        $data_jumlah = array(
        'jumlah_masuk'      => $jumlah_masuk,
        'jumlah_proses'     => $jumlah_proses,
        'jumlah_selesai'    => $jumlah_selesai,
        );
        
        echo json_encode($data_jumlah);
        
}else if($input['status'] == 'ambil_meta'){
        $this->db->select('nama_meta');
        $this->db->select('jenis_inputan');
$data = $this->db->get_where('data_meta',array('no_nama_dokumen'=>$input['no_nama_dokumen']));

echo json_encode($data->result());


}

}
function index_put(){
    echo "put";
}

function index_delete(){
    echo "delete";
}

}
