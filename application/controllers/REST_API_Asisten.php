<?php
require APPPATH . '/libraries/REST_Controller.php';
class REST_API_Asisten extends REST_Controller{
function __construct($config = 'rest'){
    parent::__construct($config);
 }

function index_get(){
    echo "get";
}


public function index_post(){
if($this->post('status') == 'CekAkses'){

$cek = $this->db->get_where('sublevel_user',array('sublevel'=>'Level 2','no_user'=>$this->post('no_user'))); 
    
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
        $this->db->select('data_jenis_pekerjaan.no_jenis_pekerjaan,'
                . 'data_jenis_pekerjaan.nama_jenis');
$this->db->order_by('data_jenis_pekerjaan.nama_jenis','ASC');        
$this->db->from('data_jenis_pekerjaan');
$data_pekerjaan = $this->db->get();

if($data_pekerjaan->num_rows() != 0){

foreach ($data_pekerjaan->result_array() as $d){
$data[]=array(
'no_jenis_pekerjaan' =>$d['no_jenis_pekerjaan'],
'nama_jenis'         =>$d['nama_jenis']    
);    
}

$status = array(
'status_response'  =>'error',    
'messages'         =>'Daftar Pekerjaan Ditemukan',
'DaftarPekerjaan'   =>$data   
);    
}else{

$status = array(
'status_response'  =>'success',    
'messages'         =>'Daftar Pekerjaan Tidak Ditemukan',
'DaftarPekerjaan'  =>''    
);  
}
$this->response($status,REST_Controller::HTTP_CREATED);   

}
}

}