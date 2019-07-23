<?php 
class M_data_lama extends CI_model{

public function cari_nama_client($term){
$this->db->from("data_client");
$this->db->limit(15);
$array = array('nama_client' => $term);
$this->db->like($array);
$query = $this->db->get();
if($query->num_rows() >0 ){
return $query->result();
}

}
public function cari_jenis_pekerjaan($term){
$this->db->from("data_jenis_dokumen");
$this->db->limit(15);
$array = array('nama_jenis' => $term);
$this->db->like($array);
$query = $this->db->get();
if($query->num_rows() >0 ){
return $query->result();
}
}

public function data_client(){
$query = $this->db->get('data_client');

return $query;
}

public function data_client_where($no_client){

$this->db->from('data_client');
$this->db->where('data_client.no_client',$no_client);
$query = $this->db->get();  
return $query;         
}

function json_data_berkas(){
    
$this->datatables->select('id_data_berkas,'
.'data_berkas.nama_file as nama_file,'
.'data_berkas.pengupload as pengupload,'
.'data_berkas.tanggal_upload as tanggal_upload,'
.'data_client.nama_client as nama_client,'
);
$this->datatables->from('data_berkas');
$this->datatables->join('data_client', 'data_client.no_client = data_berkas.no_client');
$this->datatables->where('data_berkas.pengupload !=',NULL);
$this->datatables->add_column('view','<button onclick="download($1)" class="btn btn-sm btn-success"><span class="fa fa-download"></span></button>', 'id_data_berkas,base64_encode(no_berkas)');
return $this->datatables->generate();
}

}
?>