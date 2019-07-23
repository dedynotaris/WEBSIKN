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
}
?>