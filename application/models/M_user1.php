<?php
class M_user1 extends CI_Model{
public function data_tugas($status){
$this->db->select('*');
$this->db->order_by('data_pekerjaan.target_kelar','ASC');
$this->db->from('data_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->where('data_pekerjaan.status_pekerjaan',$status);
$query = $this->db->get();
return $query;
}


function data_persyaratan_pekerjaan_where($no_pekerjaan){
$this->db->select('*');
$this->db->from('data_persyaratan_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_persyaratan_pekerjaan.no_client');
$this->db->where('data_persyaratan_pekerjaan.no_pekerjaan_syarat',$no_pekerjaan);
$query = $this->db->get();    
return $query;
}


function json_data_pekerjaan_selesai(){   
$this->datatables->select('id_data_pekerjaan,'
.'data_pekerjaan.no_pekerjaan as no_pekerjaan,'
.'data_jenis_pekerjaan.nama_jenis as jenis_perizinan,'
.'data_pekerjaan.pembuat_pekerjaan as pembuat_pekerjaan,'
.'data_pekerjaan.tanggal_selesai as tanggal_selesai,'
.'data_client.nama_client as nama_client,'
);

$this->datatables->from('data_pekerjaan');
$this->datatables->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->datatables->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->datatables->add_column('view',"<button class='btn btn-sm btn-success '  onclick=lihat_berkas('$1'); >Lihat Berkas  <i class='fa fa-list'></i></button>",'base64_encode(no_pekerjaan)');
$this->datatables->where('data_pekerjaan.status_pekerjaan','Selesai');
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

public function data_user(){
$this->db->select('no_user');
$this->db->select('nama_lengkap');
$this->db->order_by('user.nama_lengkap','ASC');
$query= $this->db->get_where('user',array('level'=>'User','status'=>'Aktif')); 

return $query;
}

public function data_level2($proses,$no_user){
$this->db->select('*');
$this->db->from('data_pekerjaan');
$this->db->join('user','user.no_user = data_pekerjaan.no_user');
$this->db->join('data_jenis_pekerjaan','data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->where(array('data_pekerjaan.status_pekerjaan'=>$proses,'data_pekerjaan.no_user'=>$no_user));
$data = $this->db->get();
return $data;    
}


public function user_level2(){
$this->db->select('*');
$this->db->from('sublevel_user');
$this->db->join('user','user.no_user = sublevel_user.no_user');
$this->db->where('sublevel_user.sublevel','Level 2');
$this->db->group_by('sublevel_user.no_user');
$data = $this->db->get();
return $data;    
}

public function data_berkas_pekerjaan($no_pekerjaan){
$this->db->select('*');
$this->db->from('data_berkas');
$this->db->join('data_pekerjaan','data_pekerjaan.no_pekerjaan = data_berkas.no_pekerjaan');
$this->db->join('nama_dokumen','nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
$this->db->join('user','user.no_user = data_berkas.pengupload');
$this->db->where('data_berkas.no_pekerjaan',$no_pekerjaan);
$this->db->group_by('data_berkas.no_nama_dokumen');
$data = $this->db->get();
return $data;    
    
}


public function data_berkas_utama($no_pekerjaan){
$this->db->select('*');
$this->db->from('data_dokumen_utama');
$this->db->join('data_pekerjaan','data_pekerjaan.no_pekerjaan = data_dokumen_utama.no_pekerjaan');
$this->db->join('user','user.no_user = data_pekerjaan.no_user');
$this->db->where('data_dokumen_utama.no_pekerjaan',$no_pekerjaan);
$data = $this->db->get();
return $data;        
}

public function data_level3($proses,$no_user){
$this->db->select('*');
$this->db->from('data_berkas_perizinan');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_berkas_perizinan.no_pekerjaan');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas_perizinan.no_nama_dokumen');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->join('user', 'user.no_user = data_berkas_perizinan.no_user_perizinan');
$this->db->where(array('data_berkas_perizinan.status_berkas'=>$proses,'data_berkas_perizinan.no_user_perizinan'=>$no_user));
$data = $this->db->get();

return $data;
}
public function data_perekaman($no_nama_dokumen,$no_client){
$this->db->select("data_meta_berkas.nama_meta,"
                    ."data_meta_berkas.value_meta,"
                    ."data_berkas.no_berkas,"
                    ."data_client.nama_client,"
                    ."nama_dokumen.nama_dokumen");
$this->db->from('data_berkas');
$this->db->join('data_meta_berkas', 'data_meta_berkas.no_berkas = data_berkas.no_berkas');
$this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
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
                ."data_berkas.id_data_berkas,"
                ."data_meta_berkas.no_nama_dokumen,"
                ."data_meta_berkas.no_pekerjaan,"
                ."data_berkas.no_client");
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
        public function data_meta($no_nama_dokumen){
                $query = $this->db->get_where('data_meta',array('no_nama_dokumen'=>$no_nama_dokumen));
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
                public function data_edit($no_berkas,$nama_meta){
                        $this->db->select('data_meta_berkas.value_meta');
                        $this->db->from('data_meta_berkas');
                        $this->db->where('data_meta_berkas.no_berkas',$no_berkas);
                        $this->db->where('data_meta_berkas.nama_meta',$nama_meta);
                        
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
                        .'data_berkas.no_nama_dokumen as no_nama_dokumen,'
                        .'nama_dokumen.nama_dokumen as jenis_dokumen,'
                        .'data_berkas.pengupload as pengupload,'
                        .'data_berkas.no_berkas as no_berkas'
                        );
                        $this->datatables->from('data_berkas');
                        $this->datatables->join('nama_dokumen','nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
                        $this->datatables->join('data_client','data_client.no_client = data_berkas.no_client');
                        $this->datatables->where('data_berkas.no_client',base64_decode($no_client));
                        $this->datatables->add_column('view',"<button class='btn btn-dark btn-sm btn-success '  onclick=lihat_meta('$1','$2','$3'); >Lihat data <i class='fa fa-eye'></i></button>",'no_berkas,no_nama_dokumen,no_pekerjaan');
                        return $this->datatables->generate();
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



public function laporan_pekerjaan($range1,$range2,$input){
$this->db->select('data_pekerjaan.tanggal_dibuat,'
        . 'data_pekerjaan.tanggal_selesai,'
        . 'data_jenis_pekerjaan.nama_jenis,'
        . 'data_pekerjaan.no_pekerjaan,'
        . 'user.nama_lengkap,'
        . 'data_pekerjaan.status_pekerjaan,'
        . 'data_client.nama_client');
$this->db->where('data_pekerjaan.tanggal_dibuat >=',$range1);
$this->db->where('data_pekerjaan.tanggal_dibuat <=',$range2);
$this->db->where('data_pekerjaan.status_pekerjaan !=','ArsipMasuk');
$this->db->where('data_pekerjaan.status_pekerjaan !=','ArsipProses');
$this->db->where('data_pekerjaan.status_pekerjaan !=','ArsipSelesai');
$this->db->where('data_pekerjaan.no_user',$input['asisten']);
$this->db->from('data_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->join('user', 'user.no_user = data_pekerjaan.no_user');
$this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$query = $this->db->get();

return$query;
} 
public function laporan_utama($range1,$range2,$input){
$this->db->select('data_pekerjaan.tanggal_dibuat,'
        . 'data_pekerjaan.tanggal_selesai,'
        . 'data_jenis_pekerjaan.nama_jenis,'
        . 'data_pekerjaan.no_pekerjaan,'
        . 'user.nama_lengkap,'
        . 'data_pekerjaan.status_pekerjaan,'
        . 'data_client.nama_client,'
        . 'data_dokumen_utama.nama_berkas,'
        . 'data_dokumen_utama.no_akta,'
        . 'data_dokumen_utama.jenis,'
        . 'data_dokumen_utama.tanggal_akta');
$this->db->where('data_dokumen_utama.waktu >=',$range1);
$this->db->where('data_dokumen_utama.waktu <=',$range2);
$this->db->where('data_pekerjaan.no_user',$input['asisten']);
$this->db->from('data_dokumen_utama');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_dokumen_utama.no_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->join('user', 'user.no_user = data_pekerjaan.no_user');
$this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$query = $this->db->get();

return$query;
} 
public function laporan_pendukung($range1,$range2,$input){
$this->db->select('data_pekerjaan.tanggal_dibuat,'
        . 'data_pekerjaan.tanggal_selesai,'
        . 'data_jenis_pekerjaan.nama_jenis,'
        . 'data_pekerjaan.no_pekerjaan,'
        . 'user.nama_lengkap,'
        . 'data_pekerjaan.status_pekerjaan,'
        . 'data_client.nama_client,'
        . 'nama_dokumen.nama_dokumen,'
        . 'data_berkas.nama_berkas');
$this->db->where('data_berkas.tanggal_upload >=',$range1);
$this->db->where('data_berkas.tanggal_upload <=',$range2);
$this->db->where('data_pekerjaan.no_user',$input['asisten']);
$this->db->from('data_berkas');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_berkas.no_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->join('user', 'user.no_user = data_pekerjaan.no_user');
$this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$query = $this->db->get();
return$query;
}

public function BerkasMilikAsisten($no_user){
$this->db->select('');
$this->db->from('data_berkas');
$this->db->where('data_pekerjaan.no_user',$no_user);
$this->db->where_in('data_pekerjaan.status_pekerjaan',array('ArsipSelesai','Selesai'));
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_berkas.no_pekerjaan');
$query = $this->db->get();
return$query;    
}

public function PekerjaanMilikAsisten($no_user){
$this->db->select('');
$this->db->from('data_pekerjaan');
$this->db->where('data_pekerjaan.no_user',$no_user);
$this->db->where_in('status_pekerjaan',array('ArsipSelesai','Selesai'));
$query = $this->db->get();
return$query;    
}

public function PekerjaanMilikPerizinan($no_user){
$this->db->select('');
$this->db->from('data_berkas_perizinan');
$this->db->where('data_berkas_perizinan.no_user_perizinan',$no_user);
$this->db->where_in('status_berkas',array('Selesai'));
$query = $this->db->get();
return$query;    
}

}
?>
