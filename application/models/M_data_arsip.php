<?php 
Class M_data_arsip extends CI_Model{
public function pencarian_data_client($input){
$this->db->select('data_client.nama_client,'
        . 'data_client.jenis_client,'
        . 'data_client.no_client');
$this->db->from('data_client');
$this->db->like('data_client.nama_client',$input);
$query = $this->db->get();
return $query;
}

public function pencarian_data_dokumen($input){
$this->db->select('data_meta_berkas.nama_meta,'
        . 'data_meta_berkas.value_meta,'
        . 'nama_dokumen.nama_dokumen,'
        . 'data_meta_berkas.no_berkas,'
        . 'data_client.nama_client');
$this->db->from('data_meta_berkas');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_meta_berkas.no_nama_dokumen');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_meta_berkas.no_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->group_by('data_meta_berkas.no_berkas');
$this->db->like('data_meta_berkas.value_meta',$input);
$query = $this->db->get();
return $query;
}

public function pencarian_data_dokumen_utama($input){
$this->db->select('data_dokumen_utama.nama_berkas,'
        . 'data_dokumen_utama.tanggal_akta,'
        . 'data_dokumen_utama.nama_file,'
        . 'data_client.nama_client,'
        . 'data_dokumen_utama.id_data_dokumen_utama,'
        . 'data_dokumen_utama.jenis');
$this->db->from('data_dokumen_utama');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_dokumen_utama.no_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');

$this->db->like('data_dokumen_utama.nama_berkas',$input);

$query = $this->db->get();
return $query;
}
    
    
}