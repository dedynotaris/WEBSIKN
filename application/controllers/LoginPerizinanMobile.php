<?php 
require APPPATH . '/libraries/REST_Controller.php';
class LoginPerizinanMobile extends REST_Controller{
function __construct($config = 'rest'){
    parent::__construct($config);
}


function index_get(){
echo "get";
}

function index_post(){
$json   = file_get_contents('php://input');
$input  = json_decode($json,true);


$query = $this->db->get_where('user',array('username'=>$input['usernamed'],'password'=>md5($input['passwordd'])));
$data = $query->row_array();
if($query->num_rows() == 1){
$cek_level  = $this->db->get_where('sublevel_user',array('no_user'=>$data['no_user'],'sublevel'=>'Level 3'));

if($cek_level->num_rows() == 1){
$r  = array(
'status'        =>'Success',
'no_user'       =>$data['no_user'],
'nama_lengkap'  =>$data['nama_lengkap'],
'email'         =>$data['email'],
'phone'         =>$data['phone'],
'foto'          =>$data['foto']
);
echo json_encode($r);
}else{
echo json_encode('Anda tidak memiliki akses ke aplikasi ini');    
}
}else{
echo json_encode('Username atau password salah');    
}

}

function index_put(){
    echo "put";

}

function index_delete(){
    echo "delete";

}

}
