<?php 
Class M_dashboard_perizinan extends CI_Model{

public function data_pekerjaan_perizinan($status,$no_user){
    
    $this->db->select('nama_dokumen.nama_dokumen,
    user.nama_lengkap,
    data_client.nama_client,
    data_berkas_perizinan.tanggal_penugasan,
    data_berkas_perizinan.target_selesai_perizinan,
    data_berkas_perizinan.no_berkas_perizinan,
    nama_dokumen.no_nama_dokumen
    ');
    $this->db->from('data_berkas_perizinan');
    $this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas_perizinan.no_nama_dokumen');
    $this->db->join('user', 'user.no_user = data_berkas_perizinan.no_user_penugas');
    $this->db->join('data_client', 'data_client.no_client = data_berkas_perizinan.no_client');
    $this->db->where('data_berkas_perizinan.status_berkas',$status);
    $this->db->where('data_berkas_perizinan.no_user_perizinan',$no_user);
    $query = $this->db->get();

    return $query;

}

}
?>
