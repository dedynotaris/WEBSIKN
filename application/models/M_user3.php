<?php
class M_user3 extends CI_Model{
public function data_tugas($status){

$this->db->select('data_client.nama_client,'
        . 'nama_dokumen.nama_dokumen,'
        . 'data_client.nama_client,'
        . 'user.nama_lengkap,'
        . 'data_berkas_perizinan.tanggal_penugasan,'
        . 'data_berkas_perizinan.target_selesai_perizinan,'
        . 'data_berkas_perizinan.no_berkas_perizinan,'
        . 'data_berkas_perizinan.no_pekerjaan,'
        . 'data_berkas_perizinan.no_client,'
        . 'data_berkas_perizinan.no_nama_dokumen,'
        );
$this->db->from('data_berkas_perizinan');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas_perizinan.no_nama_dokumen');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_berkas_perizinan.no_pekerjaan');
$this->db->join('user', 'user.no_user = data_berkas_perizinan.no_user_penugas');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->order_by('data_berkas_perizinan.id_perizinan','DESC');
$this->db->where('data_berkas_perizinan.status_berkas',$status);
$this->db->where('data_berkas_perizinan.no_user_perizinan',$this->session->userdata('no_user'));
$query = $this->db->get();

return $query;
}

public function data_client_where($no_client){
$query = $this->db->get_where('data_client',array('no_client'=> base64_decode($no_client)));
return $query;
}

function json_data_lampiran_client($no_client){
$this->datatables->select('id_data_berkas,'
.'data_berkas.nama_berkas as nama_lampiran,'
.'data_berkas.no_pekerjaan as no_pekerjaan,'
.'data_berkas.tanggal_upload as tanggal_upload,'
.'data_berkas.no_nama_dokumen as no_nama_dokumen,'
.'nama_dokumen.nama_dokumen as jenis_dokumen,'
.'user.nama_lengkap as pengupload,'
.'data_berkas.no_berkas as no_berkas'
);
$this->datatables->from('data_berkas');
$this->datatables->join('nama_dokumen','nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
$this->datatables->join('data_client','data_client.no_client = data_berkas.no_client');
$this->datatables->join('user','user.no_user = data_berkas.pengupload');
$this->datatables->where('data_berkas.no_client',base64_decode($no_client));
$this->datatables->add_column('view',"<button class='btn btn-dark btn-block btn-sm btn-success btn-lihat$1'  onclick=lihat_meta('$1','$2','$3'); >Lihat Lampiran <i class='fa fa-eye'></i></button>",'no_berkas,no_nama_dokumen,no_pekerjaan');
return $this->datatables->generate();
}

public function data_edit($no_berkas,$nama_meta){
$this->db->select('data_meta_berkas.value_meta');
$this->db->from('data_meta_berkas');
$this->db->where('data_meta_berkas.no_berkas',$no_berkas);
$this->db->where('data_meta_berkas.nama_meta',$nama_meta);

$query = $this->db->get();
return $query;    
}


function json_data_perizinan_selesai(){
$this->datatables->select('no_berkas_perizinan,'
.'data_client.nama_client as nama_client,'
.'nama_dokumen.nama_dokumen as nama_dokumen,'
.'data_jenis_pekerjaan.nama_jenis as jenis_pekerjaan,'
);

$this->datatables->from('data_berkas_perizinan');
$this->datatables->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_berkas_perizinan.no_pekerjaan');
$this->datatables->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->datatables->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas_perizinan.no_nama_dokumen');
$this->datatables->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->datatables->where('data_berkas_perizinan.status_berkas','Selesai');
$this->datatables->where('data_berkas_perizinan.no_user_perizinan',$this->session->userdata('no_user'));

$this->datatables->add_column('view',"<button class='btn btn-sm btn-success '  onclick=buat_pekerjaan('$1'); >EDIT</button>",'no_client');
return $this->datatables->generate();
}
public function data_user_where($no_user){

$query = $this->db->get_where('user',array('no_user'=>$no_user));

return $query;
}

function json_data_riwayat(){  
$this->datatables->select('id_data_histori_pekerjaan,'
.'data_histori_pekerjaan.keterangan as keterangan,'
.'data_histori_pekerjaan.tanggal as tanggal,'
);
$this->datatables->from('data_histori_pekerjaan');
$this->datatables->where('no_user',$this->session->userdata('no_user'));
return $this->datatables->generate();
}


public function cari_lampiran($input){
$this->db->select('*');
$this->db->from('data_meta_berkas');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_meta_berkas.no_pekerjaan');
$this->db->join('data_berkas', 'data_berkas.nama_berkas = data_meta_berkas.nama_berkas');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_meta_berkas.no_nama_dokumen');
$array = array('data_meta_berkas.value_meta' => $input['cari_dokumen']);
$this->db->like($array);

$query = $this->db->get();
return $query;
}
public function cari_informasi($input){
$this->db->select('*');
$this->db->from('data_informasi_pekerjaan');
$array = array('data_informasi_pekerjaan.data_informasi' => $input['cari_dokumen']);
$this->db->like($array);

$query = $this->db->get();
return $query;
}
public function hapus_lampiran($no_berkas){
$this->db->select('data_client.nama_folder,'
        . 'data_berkas.nama_berkas,'
        . 'nama_dokumen.nama_dokumen');
$this->db->from('data_berkas');
$this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
$this->db->where('data_berkas.no_berkas',$no_berkas);
$query = $this->db->get();  
return $query;
}
public function data_persyaratan($no_client){
$this->db->select('*');
$this->db->from('data_pemilik');
$this->db->join('data_client','data_client.no_client = data_pemilik.no_client');
$this->db->join('data_berkas','data_berkas.no_client = data_client.no_client');
$this->db->join('nama_dokumen','nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
$this->db->group_by('data_berkas.no_nama_dokumen');
$this->db->where('data_client.no_client',$no_client);
$query = $this->db->get();
return $query;    
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

public function data_meta($no_nama_dokumen){
$query = $this->db->get_where('data_meta',array('no_nama_dokumen'=>$no_nama_dokumen));
return $query;
}
public function total_berkas(){
        $this->db->select('data_berkas.id_data_berkas');
        $this->db->from('data_berkas');
        $this->db->order_by('data_berkas.id_data_berkas',"DESC");
        $query = $this->db->get();
        return $query;    
}

public function data_pekerjaan($no_pekerjaan){
$this->db->select('data_client.nama_folder,'
        . 'data_client.no_client,'
        . 'data_pekerjaan.no_pekerjaan');
$this->db->from('data_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->where('data_pekerjaan.no_pekerjaan',$no_pekerjaan);
$query = $this->db->get();  
return $query;
}

public function hapus_berkas($id_data_berkas){
$this->db->select('data_client.nama_folder,'
        . 'data_berkas.nama_berkas,'
        . 'nama_dokumen.nama_dokumen');
$this->db->from('data_berkas');
$this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
$this->db->where('data_berkas.id_data_berkas',$id_data_berkas);
$query = $this->db->get();  

return $query;

}



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
                . 'data_client.nama_client,'
                . 'data_client.no_client,'
                . 'data_berkas.nama_berkas,'
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

public function nama_persyaratan($no_berkas_perizinan,$jenis_client){
$this->db->select('nama_dokumen.nama_dokumen,'
        . 'nama_dokumen.no_nama_dokumen,'
        . 'data_client.nama_client,'
        . 'data_client.no_client,'
        . 'data_client.jenis_client,'
        . 'data_jenis_pekerjaan.nama_jenis,'
        . 'data_pekerjaan.no_pekerjaan');

$this->db->from('data_berkas_perizinan');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_berkas_perizinan.no_pekerjaan');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas_perizinan.no_nama_dokumen');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->db->where('data_berkas_perizinan.no_berkas_perizinan',$no_berkas_perizinan);
if($jenis_client == "Badan Hukum"){
$this->db->where('nama_dokumen.badan_hukum',$jenis_client);    
}else if($jenis_client == "Perorangan"){
$this->db->where('nama_dokumen.perorangan',$jenis_client);        
}

$query = $this->db->get();  
return $query;
}

public function DokumenPenunjang($no_berkas){
        $this->db->select("data_berkas.no_berkas,"
                        ."data_berkas.pengupload,"
                        ."data_berkas.tanggal_upload,"
                        ."data_berkas.nama_berkas,"
                        ."data_berkas.no_client,"
                        ."data_meta_berkas.nama_meta,"
                        ."data_meta_berkas.value_meta,"
                        ."data_client.nama_client,"
                        ."data_client.nama_folder,"
                        ."nama_dokumen.nama_dokumen");
        $this->db->from('data_berkas');
        $this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
        $this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
        $this->db->join('data_meta_berkas', 'data_meta_berkas.no_berkas = data_berkas.no_berkas');
        $this->db->where('data_berkas.no_berkas',$no_berkas);
        $query = $this->db->get();  
        return $query;
        }

        public function DataDokumenUtama($input){
                $this->db->select('data_dokumen_utama.nama_berkas,'
                        . 'data_dokumen_utama.tanggal_akta,'
                        . 'data_dokumen_utama.nama_file,'
                        . 'data_client.nama_client,'
                        . 'data_client.nama_folder,'
                        . 'data_dokumen_utama.id_data_dokumen_utama,'
                        . 'data_dokumen_utama.jenis');
                $this->db->from('data_dokumen_utama');
                $this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_dokumen_utama.no_pekerjaan');
                $this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
                
                $this->db->where('data_dokumen_utama.id_data_dokumen_utama',$input);
                
                $query = $this->db->get();
                return $query;
                }


}
?>
