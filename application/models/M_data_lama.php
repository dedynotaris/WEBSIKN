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


}
?>