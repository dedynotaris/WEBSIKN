<?php 
require APPPATH . '/libraries/REST_Controller.php';
class REST_API_Login extends REST_Controller{
function __construct($config = 'rest'){
    parent::__construct($config);
}


function index_get(){
echo "get";
}

function index_post(){

$query = $this->db->get_where('user',array('username'=>$this->post('username'),'password'=>md5($this->post('password'))));
$data = $query->row_array();

if(!file_exists('./uploads/user/'.$data['foto'])){ 
$foto = 'no_profile.jpg';
}else{ 
if($data['foto'] != NULL){ 
$foto = $data['foto'];
}else{ 
$foto = 'no_profile.jpg';
}
}

if($query->num_rows() == 1){
$r  = array(
'status'        =>'Success',
'no_user'       =>$data['no_user'],
'nama_lengkap'  =>$data['nama_lengkap'],
'email'         =>$data['email'],
'phone'         =>$data['phone'],
'foto'          =>$foto
);
echo json_encode($r);
}else{
echo json_encode("Username atau password salah");    
}
}

function index_put(){
echo "put";
}

function index_delete(){
echo "delete";
}


}
