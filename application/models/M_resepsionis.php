<?php 
class M_resepsionis extends CI_model{

public function data_user_where($no_user){

$query = $this->db->get_where('user',array('no_user'=>$no_user));

return $query;
}

public function data_karyawan(){
$query = $this->db->get('user');
return $query;   
}

function json_data_tamu(){
    
$this->datatables->select('id_data_buku_tamu,'
.'data_buku_tamu.tanggal as tanggal,'
.'data_buku_tamu.penginput as penginput,'
.'data_buku_tamu.keperluan_dengan as keperluan_dengan,'
.'data_buku_tamu.nomor_telepon as nomor_telepon,'
.'data_buku_tamu.nama_klien as nama_klien,'
.'data_buku_tamu.alasan_keperluan as alasan_keperluan,'
);
$this->datatables->from('data_buku_tamu');
return $this->datatables->generate();
}

function json_data_absen(){
    
$this->datatables->select('id_data_buku_absen,'
.'data_buku_absen.nama_karyawan as nama_karyawan,'
.'data_buku_absen.jam_datang as jam_datang,'
.'data_buku_absen.jam_pulang as jam_pulang,'
.'data_buku_absen.penginput as penginput,'
);
$this->datatables->from('data_buku_absen');
$this->datatables->add_column('view',""
        . "<button class='btn btn-sm btn-success '  onclick=lihat_tugas('$1'); > Lihat Tugas <i class='fa fa-eye'></i></button> || "
        . "<button class='btn btn-sm btn-success '  onclick=edit_absen('$1'); > Edit Absen <i class='fa fa-eye'></i></button>"
        . "",'id_data_buku_absen');

return $this->datatables->generate();
}
function json_data_notaris_rekanan(){
    
$this->datatables->select('id_notaris_rekanan,'
.'data_notaris_rekanan.no_telpon as no_telpon,'
.'data_notaris_rekanan.nama_notaris as nama_notaris,'
.'data_notaris_rekanan.alamat as alamat,'
.'data_notaris_rekanan.penginput as penginput,'
.'data_notaris_rekanan.tanggal_input as tanggal_input,'
);
$this->datatables->from('data_notaris_rekanan');
return $this->datatables->generate();
}


public function data_perekaman($no_nama_dokumen,$no_client){
$this->db->select("data_meta_berkas.nama_meta,"
                ."data_meta_berkas.value_meta,"
                ."data_berkas.no_berkas");
$this->db->from('data_berkas');
$this->db->join('data_meta_berkas', 'data_meta_berkas.no_berkas = data_berkas.no_berkas');
$this->db->order_by('data_meta_berkas.id_data_meta_berkas','ASC');
$this->db->group_by('data_meta_berkas.nama_meta');
$this->db->where('data_berkas.no_client',$no_client);
$this->db->where('data_berkas.no_nama_dokumen',$no_nama_dokumen);
$query = $this->db->get();  
return $query;
}
public function data_perekaman2($no_nama_dokumen,$no_client){
$this->db->select("data_meta_berkas.nama_meta,"
                ."data_meta_berkas.value_meta,"
                ."data_berkas.no_berkas,"
                ."data_berkas.pengupload,"
                ."data_berkas.tanggal_upload,"
                . "data_berkas.id_data_berkas,"
                . "data_meta_berkas.no_nama_dokumen,"
                 . "data_meta_berkas.no_pekerjaan,"
        . "data_berkas.no_client");
$this->db->from('data_berkas');
$this->db->join('data_meta_berkas', 'data_meta_berkas.no_berkas = data_berkas.no_berkas','inner');
$this->db->group_by('data_berkas.no_berkas');
$this->db->where('data_berkas.no_client',$no_client);
$this->db->where('data_berkas.no_nama_dokumen',$no_nama_dokumen);
$query = $this->db->get();  
return $query;
}
public function pencarian_data_client($input){
$this->db->select('data_client.nama_client,'
        . 'data_client.no_client');
$this->db->from('data_client');
$this->db->like('data_client.nama_client',$input);
$query = $this->db->get();
return $query;
}

public function pencarian_data_dokumen($input){
$this->db->select('data_meta_berkas.nama_meta,'
        . 'data_meta_berkas.value_meta,'
        . 'data_client.nama_client,'
        . 'data_client.no_client,'
        . 'nama_dokumen.nama_dokumen,'
        . 'nama_dokumen.no_nama_dokumen,'
        . 'data_meta_berkas.no_berkas,');
$this->db->from('data_meta_berkas');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_meta_berkas.no_pekerjaan');
$this->db->join('data_berkas', 'data_berkas.no_berkas = data_meta_berkas.no_berkas');
$this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_meta_berkas.no_nama_dokumen');
$this->db->group_by('data_meta_berkas.no_berkas');

$this->db->like('data_meta_berkas.value_meta',$input);
$this->db->or_like('data_meta_berkas.nama_meta',$input);

$query = $this->db->get();
return $query;
}

public function pencarian_data_dokumen_utama($input){
$this->db->select('data_dokumen_utama.nama_berkas,'
        . 'data_dokumen_utama.tanggal_akta,'
        . 'data_client.nama_client,'
        . 'data_dokumen_utama.id_data_dokumen_utama');
$this->db->from('data_dokumen_utama');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_dokumen_utama.no_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');

$this->db->like('data_dokumen_utama.nama_berkas',$input);

$query = $this->db->get();
return $query;
}

public function data_berkas_where($no_berkas){
$this->db->select('data_client.nama_folder,'
        . 'data_berkas.nama_berkas,'
        . 'nama_dokumen.nama_dokumen');
$this->db->from('data_berkas');
$this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
$this->db->where('data_berkas.no_berkas', base64_decode($no_berkas));
$query = $this->db->get();  
return $query;
}

public function data_telah_dilampirkan($no_client){
$this->db->select('data_client.nama_folder,'
        . 'data_client.no_client,'
        . 'data_pekerjaan.no_pekerjaan,'
        . 'data_berkas.nama_berkas,'
        . 'data_berkas.no_nama_dokumen,'
        . 'data_berkas.no_berkas,'
        . 'nama_dokumen.nama_dokumen,'
        . 'data_berkas.id_data_berkas');
$this->db->from('data_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->join('data_berkas', 'data_berkas.no_pekerjaan = data_pekerjaan.no_pekerjaan');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
$this->db->where('data_berkas.no_client',$no_client);
$this->db->group_by('nama_dokumen.no_nama_dokumen');
$query = $this->db->get();  
return $query;
}
}
?>