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

}public function hitung_pekerjaan(){
$query = $this->db->get('data_pekerjaan');
return $query;
}
public function data_pemilik(){
$this->db->limit(1);
$this->db->order_by('data_pemilik.id_data_pemilik','DESC');
$query = $this->db->get_where('data_pemilik');
return $query;
}
public function cari_jenis_pekerjaan($term){
$this->db->from("data_jenis_pekerjaan");
$this->db->limit(15);
$array = array('nama_jenis' => $term);
$this->db->like($array);
$query = $this->db->get();
return $query;
}
public function data_perekaman_pekerjaan($no_pekerjaan){
$this->db->select('*');
$this->db->from('data_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->db->join('data_berkas','data_berkas.no_pekerjaan = data_pekerjaan.no_pekerjaan');
$this->db->join('nama_dokumen','nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
$this->db->join('user', 'user.no_user = data_pekerjaan.no_user');
$this->db->group_by('nama_dokumen.no_nama_dokumen');
$this->db->where('data_pekerjaan.no_pekerjaan',$no_pekerjaan);
$query = $this->db->get();    

return $query;      
}
public function data_client(){
$query = $this->db->get('data_client');

return $query;
}

public function cari_jenis_client($search,$jenis_client){
        $this->db->from("data_client");
        $this->db->limit(15);
        $this->db->where('data_client.jenis_client',$jenis_client);
        $array = array('nama_client' => $search);
        $this->db->like($array);
        $query = $this->db->get();
        return $query;
        }


        public function cari_dokumen($input){
                $this->db->from("nama_dokumen");
                $this->db->limit(15);
                $array = array('nama_dokumen' => $input);
                $this->db->like($array);
                $query = $this->db->get();
                return $query;
                }
       


        public function cari_kontak($input){
                $this->db->from("data_daftar_kontak");
                $this->db->limit(15);
                $array = array('nama_kontak' => $input);
                $this->db->like($array);
                $query = $this->db->get();
                return $query;
                }
function json_data_berkas(){

$this->datatables->select('data_berkas.no_berkas,'
.'data_berkas.nama_file as nama_file,'
.'data_berkas.pengupload as pengupload,'
.'data_berkas.tanggal_upload as tanggal_upload,'
.'data_client.nama_client as nama_client,'
);
$this->datatables->from('data_berkas');
$this->datatables->join('data_client', 'data_client.no_client = data_berkas.no_client');
$this->datatables->where('data_berkas.pengupload !=',NULL);
$this->datatables->add_column('view','<button onclick="download($1)" class="btn btn-sm btn-success"><span class="fa fa-download"></span></button>', 'no_berkas,base64_encode(no_berkas)');
return $this->datatables->generate();
}

function json_daftar_lemari(){

$this->datatables->select('no_lemari,'
        . 'data_daftar_lemari.no_lemari,'
        . 'data_daftar_lemari.nama_tempat');
$this->datatables->from('data_daftar_lemari');
$this->datatables->add_column('view','<button onclick=buatlokerlemari("$1") class="btn btn-sm btn-dark btn-block btn-lemari$1">Buat Loker  <span class="fa fa-cogs"></span></button>', 'no_lemari');
return $this->datatables->generate();
}


function json_data_arsip(){
$this->datatables->select('id_data_pekerjaan,'
.'data_pekerjaan.no_pekerjaan as no_pekerjaan,'
.'data_client.nama_client as nama_client,'
.'data_jenis_pekerjaan.nama_jenis as nama_jenis,'
.'user.nama_lengkap as nama_lengkap');
$this->datatables->from('data_pekerjaan');
$this->datatables->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->datatables->join('user', 'user.no_user = data_pekerjaan.no_user');
$this->datatables->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->datatables->add_column('view','<a href="'.base_url('Data_lama/lihat_rekam_data/$1').'"><button  class="btn btn-sm btn-outline-dark">Lihat rekaman <span class="fa fa-eye"></span></button></a>','base64_encode(no_pekerjaan)');
return $this->datatables->generate();
}

function json_data_arsip_perorangan(){
$this->datatables->select('data_client.nama_client as nama_client,'
. 'data_client.no_identitas as no_identitas,'
. 'data_client.no_client as no_client,'
. 'user.nama_lengkap as nama_lengkap');
$this->datatables->from('data_client');
$this->datatables->join('user', 'user.no_user = data_client.no_user');
$this->datatables->where('data_client.jenis_client','Perorangan');
$this->datatables->add_column('view','<a href="'.base_url('Data_lama/lihat_client/$1').'"><button  class="btn btn-sm btn-dark btn-block">Lihat Detail <span class="fas fa-eye"></span></button></a>','base64_encode(no_client)');
return $this->datatables->generate();
}

function JsonDataPekerjaanArsipSelesai(){
$this->datatables->select('no_pekerjaan,'
. 'data_pekerjaan.no_pekerjaan as no_pekerjaan,'
. 'data_jenis_pekerjaan.nama_jenis as nama_jenis,'
. 'data_client.nama_client as nama_client,'
. 'data_client.no_identitas as no_identitas,'
. 'data_client.no_client as no_client,'
. 'user.nama_lengkap as nama_lengkap');
$this->datatables->from('data_pekerjaan');
$this->datatables->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->datatables->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->datatables->join('user', 'user.no_user = data_pekerjaan.no_user');
$this->datatables->where('data_pekerjaan.status_pekerjaan','ArsipSelesai');
return $this->datatables->generate();
}


function json_data_arsip_badan_hukum(){
$this->datatables->select('data_client.nama_client as nama_client,'
. 'data_client.no_identitas as no_identitas,'
. 'data_client.no_client as no_client,'
. 'user.nama_lengkap as nama_lengkap');
$this->datatables->from('data_client');
$this->datatables->join('user', 'user.no_user = data_client.no_user');
$this->datatables->where('data_client.jenis_client','Badan Hukum');
$this->datatables->add_column('view','<a href="'.base_url('Data_lama/lihat_client/$1').'"><button  class="btn btn-sm btn-dark btn-block">Lihat Detail <span class="fas fa-eye"></span></button></a>','base64_encode(no_client)');
return $this->datatables->generate();
}

function nama_notaris(){
$this->db->select('user.no_user,'
. 'user.nama_lengkap');
$this->db->from('sublevel_user');
$this->db->join('user', 'user.no_user = sublevel_user.no_user');
$this->db->group_by('sublevel_user.no_user');
$this->db->where('sublevel_user.sublevel','Level 2');
$this->db->where('user.level','User');
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

public function data_pekerjaan($no_pekerjaan,$no_client){
$this->db->select('data_client.nama_folder,'
. 'data_client.no_client,'
. 'data_pekerjaan.no_pekerjaan,'
. 'data_jenis_pekerjaan.nama_jenis,'
. 'data_client.nama_client');
$this->db->from('data_pekerjaan');
$this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->where('data_pekerjaan.no_pekerjaan',$no_pekerjaan);
$query = $this->db->get();  
return $query;
}





public function data_pekerjaan_proses($no_pekerjaan){

$this->db->select('nama_dokumen.nama_dokumen,'
. 'nama_dokumen.no_nama_dokumen,'
. 'data_client.nama_client');
$this->db->from('data_pekerjaan');
$this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->join('data_persyaratan', 'data_persyaratan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_persyaratan.no_nama_dokumen');
$this->db->where('data_pekerjaan.no_pekerjaan',base64_decode($no_pekerjaan));
$query = $this->db->get();   
return $query;
}

public function dokumen_utama($no_pekerjaan){
$this->db->select("*");
$this->db->from('data_dokumen_utama');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_dokumen_utama.no_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->join('user', 'user.no_user = data_pekerjaan.no_user');
$this->db->where('data_dokumen_utama.no_pekerjaan',$no_pekerjaan);
$this->db->where('data_dokumen_utama.jenis != ','');
$query = $this->db->get();  
return $query;    
}


public function data_pemilik_where($no_pekerjaan){
$this->db->select('data_client.nama_client,'
. 'data_client.no_client,'
. 'data_client.pembuat_client,'
. 'data_pemilik.no_pemilik');    
$this->db->from('data_pemilik');
$this->db->join('data_client', 'data_client.no_client = data_pemilik.no_client');
$this->db->where('data_pemilik.no_pekerjaan',$no_pekerjaan);
$query= $this->db->get();    
return $query;

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
$this->db->limit(3);
$query = $this->db->get();  
return $query;
}
public function data_perekaman2($no_nama_dokumen,$no_client){
$this->db->select("data_berkas.no_berkas,"
."data_berkas.pengupload,"
."data_berkas.tanggal_upload,"
."data_berkas.nama_berkas,"
."data_berkas.no_client,"
. "nama_dokumen.nama_dokumen");
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
$this->db->from('data_berkas');
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


public function data_persyaratan($no_pekerjaan){
$this->db->select('data_client.nama_client,'
. 'data_client.no_client,'
. 'data_client.jenis_client,'
. 'data_client.alamat_client,'
. 'data_client.no_identitas,'
. 'data_client.contact_number,'
. 'data_client.pembuat_client,'
. 'data_jenis_pekerjaan.nama_jenis,'
. 'data_pekerjaan.no_pekerjaan,'
. 'data_pekerjaan.target_kelar,'
. 'data_pekerjaan.pembuat_pekerjaan,'
. 'data_pekerjaan.tanggal_dibuat');
$this->db->from('data_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->db->where('data_pekerjaan.no_pekerjaan',$no_pekerjaan);

$query = $this->db->get();  
return $query;
}
public function data_para_pihak($no_pekerjaan){
$this->db->select('data_client.nama_client,'
. 'data_client.no_client');
$this->db->from('data_pemilik');
$this->db->join('data_client', 'data_client.no_client = data_pemilik.no_client');

$this->db->where('data_pemilik.no_pekerjaan',$no_pekerjaan);

$query = $this->db->get();
return $query;    
}

public function nama_persyaratan($no_pekerjaan,$jenis_client){
$this->db->select('nama_dokumen.nama_dokumen,'
. 'nama_dokumen.no_nama_dokumen,'
. 'data_client.nama_client,'
. 'data_client.no_client,'
. 'data_client.jenis_client,'
. 'data_jenis_pekerjaan.nama_jenis,'
. 'data_pekerjaan.no_pekerjaan,'
. 'data_persyaratan.no_nama_dokumen');
$this->db->from('data_pekerjaan');
$this->db->join('data_persyaratan', 'data_persyaratan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_persyaratan.no_nama_dokumen');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->db->where('data_pekerjaan.no_pekerjaan',$no_pekerjaan);
$this->db->order_by('nama_dokumen.nama_dokumen','ASC');
if($jenis_client == "Badan Hukum"){
$this->db->where('nama_dokumen.badan_hukum',$jenis_client);    
}else if($jenis_client == "Perorangan"){
$this->db->where('nama_dokumen.perorangan',$jenis_client);        
}

$query = $this->db->get();  
return $query;
}


public function data_client_where($no_client){
$query = $this->db->get_where('data_client',array('no_client'=> $no_client));
return $query;
}
public function hapus_berkas($no_berkas){
$this->db->select('data_client.nama_folder,'
. 'data_berkas.nama_berkas');
$this->db->from('data_berkas');
$this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
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
public function data_dokumen_utama_where($id_data_dokumen_utama){
$this->db->select("data_client.nama_folder,"
. "data_dokumen_utama.nama_file");
$this->db->from('data_dokumen_utama');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_dokumen_utama.no_pekerjaan','left');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->where('data_dokumen_utama.id_data_dokumen_utama',$id_data_dokumen_utama);
$query = $this->db->get();  
return $query;    
}


public function data_pekerjaan_arsip($param){
$this->db->select('*');
$this->db->from('data_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->db->where('data_pekerjaan.status_pekerjaan',$param);
$query = $this->db->get();

return $query;
}
public function data_kontak_client($param){
        $this->db->select('*');
        $this->db->from('data_kontak_client');
        $this->db->join('data_daftar_kontak', 'data_daftar_kontak.id_kontak = data_kontak_client.id_kontak');
        $this->db->where('data_kontak_client.no_client',$param);
        $query = $this->db->get();
        
        return $query;
}


public function data_lampiran_client($no_client){
        $this->db->select('data_client.nama_folder,'
        . 'data_berkas.nama_berkas,'
        . 'data_berkas.no_berkas,'
        . 'data_client.nama_folder,'
        . 'nama_dokumen.nama_dokumen');
        $this->db->from('data_berkas');
        $this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
        $this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
        $this->db->where('data_berkas.no_client',$no_client);
        $this->db->where('nama_dokumen.penunjang_client !=',NULL);
        $query = $this->db->get();  
        return $query;
}

function json_data_berkas_client($no_client){
$this->datatables->select('id_data_berkas,'
.'data_berkas.no_client as no_client,'
.'data_berkas.no_pekerjaan as no_pekerjaan,'
.'data_berkas.no_nama_dokumen as no_nama_dokumen,'
.'nama_dokumen.nama_dokumen as nama_file,'
.'data_berkas.pengupload as pengupload,'
. 'data_client.nama_client as nama_client'
);
$this->datatables->from('data_berkas');
$this->datatables->join('nama_dokumen','nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
$this->datatables->join('data_client','data_client.no_client = data_berkas.no_client');
$this->datatables->group_by('data_berkas.no_nama_dokumen');
$this->datatables->where('data_berkas.no_client',base64_decode($no_client));
$this->datatables->add_column('view',"<button class='btn btn-dark btn-block btn-sm btn-success '  onclick=lihat_data_perekaman('$1','$2','$3'); >Lihat data <i class='fa fa-eye'></i></button>",'no_nama_dokumen,no_pekerjaan,no_client');
return $this->datatables->generate();
}

function json_data_lampiran_client($no_client){
$this->datatables->select('data_berkas.no_berkas,'
.'data_berkas.nama_berkas as nama_lampiran,'
.'data_berkas.no_pekerjaan as no_pekerjaan,'
.'data_berkas.no_nama_dokumen as no_nama_dokumen,'
.'nama_dokumen.nama_dokumen as jenis_dokumen,'
.'data_berkas.pengupload as pengupload,'
.'data_client.no_client as no_client,'
.'data_berkas.no_berkas as no_berkas'
);
$this->datatables->from('data_berkas');
$this->datatables->join('nama_dokumen','nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
$this->datatables->join('data_client','data_client.no_client = data_berkas.no_client');
$this->datatables->where('data_berkas.no_client',base64_decode($no_client));
$this->datatables->add_column('view',"<button class='btn btn-dark btn-sm btn-success btn-block btn-lihat$2'  onclick=lihat_meta('$1','$2','$3'); >Lihat </button>",'no_pekerjaan,no_berkas,no_client');
return $this->datatables->generate();
}

function json_data_pekerjaan_client($no_client){
$this->datatables->select('no_pekerjaan,'
        . 'data_pekerjaan.no_pekerjaan,'
        . 'data_pekerjaan.no_client,'
        . 'data_pekerjaan.status_pekerjaan,'
        . 'data_pekerjaan.tanggal_dibuat,'
        . 'user.nama_lengkap,'
        . 'data_jenis_pekerjaan.nama_jenis');
$this->datatables->from('data_pekerjaan');
$this->datatables->join('data_jenis_pekerjaan','data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->datatables->join('user','user.no_user = data_pekerjaan.no_user');
$this->datatables->where('data_pekerjaan.no_client',base64_decode($no_client));
$this->datatables->add_column('view',"<button class='btn btn-dark btn-sm btn-success btn-block btn-lihat$2'  onclick=lihat_terlibat('$1','$2'); >Lihat Terlibat </button>",'no_client,no_pekerjaan');
return $this->datatables->generate();
}

function json_data_utama_client($no_client){
$this->datatables->select('id_data_dokumen_utama,'
        . 'data_jenis_pekerjaan.nama_jenis,'
        . 'data_dokumen_utama.id_data_dokumen_utama,'
        . 'data_dokumen_utama.no_akta,'
        . 'data_dokumen_utama.tanggal_akta,'
        . 'data_dokumen_utama.jenis,');
$this->datatables->from('data_pekerjaan');
$this->datatables->join('data_jenis_pekerjaan','data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->datatables->join('data_dokumen_utama','data_dokumen_utama.no_pekerjaan = data_pekerjaan.no_pekerjaan');
$this->datatables->join('data_client','data_client.no_client = data_pekerjaan.no_client');
$this->datatables->where('data_pekerjaan.no_client',base64_decode($no_client));
$this->datatables->add_column('view',"<button class='btn btn-dark btn-sm btn-success btn-block btn-utama$1'  onclick=lihat_utama('$1'); >Lihat </button>",'id_data_dokumen_utama');
return $this->datatables->generate();
}

function json_daftar_pekerjaan_selesai(){
$this->datatables->select('no_pekerjaan,'
        .'data_pekerjaan.no_pekerjaan,'
            .'user.nama_lengkap as asisten,'
       .'data_jenis_pekerjaan.nama_jenis,'
        .'data_client.nama_client');
$this->datatables->from('data_pekerjaan');
$this->datatables->join('data_jenis_pekerjaan','data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->datatables->join('data_client','data_client.no_client = data_pekerjaan.no_client');
$this->datatables->join('user','user.no_user = data_pekerjaan.no_user');
$this->datatables->add_column('penunjang',"<button class='btn btn-dark btn-sm btn-success btn-block btn-utama$1'  onclick=lihat_utama('$1'); >Lihat <i class='fa fa-eye'></i></button>",'no_pekerjaan');
$this->datatables->add_column('utama',"<button class='btn btn-dark btn-sm btn-success btn-block btn-utama$1'  onclick=lihat_utama('$1'); >Lihat <i class='fa fa-eye'></i></button>",'no_pekerjaan');
$this->datatables->add_column('terlibat',"<button class='btn btn-dark btn-sm btn-success btn-block btn-utama$1'  onclick=lihat_utama('$1'); >Lihat <i class='fa fa-eye'></i></button>",'no_pekerjaan');
$this->datatables->add_column('view',"<button class='btn btn-dark btn-sm btn-success btn-block btn-loker$1'  onclick=settingloker('$1'); >Loker <i class='fa fa-cogs'></i></button>",'no_pekerjaan');
$this->datatables->where_in('data_pekerjaan.status_pekerjaan',array('Selesai','ArsipSelesai'));
$this->datatables->where('data_pekerjaan.no_bantek',NULL);
return $this->datatables->generate();
}

function json_daftar_arsip(){
$this->datatables->select('data_bantek.no_bantek,'
        .'data_bantek.judul,'
        .'data_bantek.id_no_loker,'
        .'user.nama_lengkap as asisten,'
        .'data_daftar_loker.no_loker,'
        .'data_daftar_lemari.nama_tempat');
$this->datatables->from('data_pekerjaan');
$this->datatables->join('data_bantek','data_bantek.no_bantek = data_pekerjaan.no_bantek');
$this->datatables->join('data_daftar_loker','data_daftar_loker.id_no_loker = data_bantek.id_no_loker');
$this->datatables->join('data_daftar_lemari','data_daftar_lemari.no_lemari = data_daftar_loker.no_lemari');
$this->datatables->join('user','user.no_user = data_pekerjaan.no_petugas_arsip');

$this->datatables->add_column('penunjang',"<button class='btn btn-dark btn-sm btn-success btn-block btn-utama$1'  onclick=lihat_utama('$1'); >Lihat <i class='fa fa-eye'></i></button>",'no_pekerjaan');
$this->datatables->add_column('utama',"<button class='btn btn-dark btn-sm btn-success btn-block btn-utama$1'  onclick=lihat_utama('$1'); >Lihat <i class='fa fa-eye'></i></button>",'no_pekerjaan');
$this->datatables->add_column('terlibat',"<button class='btn btn-dark btn-sm btn-success btn-block btn-utama$1'  onclick=lihat_utama('$1'); >Lihat <i class='fa fa-eye'></i></button>",'no_pekerjaan');
$this->datatables->add_column('view',""
      //  . "<button class='btn btn-dark btn-sm btn-success btn-block btn-pinjam$1'  onclick=pinjamarsip('$1'); >Pinjam Arsip</button>"
        . "<button class='btn btn-dark btn-sm btn-success btn-block btn-loker$1'  onclick=EditBantex('$1'); >Detail Bantek</button>"
        . "",'no_bantek');
$this->datatables->group_by('data_pekerjaan.no_bantek');
$this->datatables->where_in('data_pekerjaan.status_pekerjaan',array('Selesai','ArsipSelesai'));
$this->datatables->where('data_pekerjaan.no_bantek !=',NULL);
return $this->datatables->generate();
}

function json_daftar_arsip_pinjam(){
$this->datatables->select('no_pekerjaan,'
        .'data_pekerjaan.no_pekerjaan,'
        .'data_jenis_pekerjaan.nama_jenis,'
        .'asisten.nama_lengkap as asisten,'
        .'peminjam.nama_lengkap as nama_peminjam,'
        .'data_daftar_loker.no_loker,'
        .'data_daftar_lemari.nama_tempat,'
        .'data_client.nama_client');
$this->datatables->from('data_pekerjaan');
$this->datatables->join('data_jenis_pekerjaan','data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->datatables->join('data_client','data_client.no_client = data_pekerjaan.no_client');
$this->datatables->join('data_daftar_loker','data_daftar_loker.id_no_loker = data_pekerjaan.id_no_loker');
$this->datatables->join('data_daftar_lemari','data_daftar_lemari.no_lemari = data_daftar_loker.no_lemari');
$this->datatables->join('user as asisten','asisten.no_user = data_pekerjaan.no_user');
$this->datatables->join('user as peminjam','peminjam.no_user = data_pekerjaan.no_user_peminjam');
$this->datatables->add_column('penunjang',"<button class='btn btn-dark btn-sm btn-success btn-block btn-utama$1'  onclick=lihat_utama('$1'); >Lihat <i class='fa fa-eye'></i></button>",'no_pekerjaan');
$this->datatables->add_column('utama',"<button class='btn btn-dark btn-sm btn-success btn-block btn-utama$1'  onclick=lihat_utama('$1'); >Lihat <i class='fa fa-eye'></i></button>",'no_pekerjaan');
$this->datatables->add_column('terlibat',"<button class='btn btn-dark btn-sm btn-success btn-block btn-utama$1'  onclick=lihat_utama('$1'); >Lihat <i class='fa fa-eye'></i></button>",'no_pekerjaan');
$this->datatables->add_column('view',""
        . "<button class='btn btn-dark btn-sm btn-success btn-block btn-balikan$1'  onclick=balikanarsip('$1'); >Balikan Arsip</button>"
        . "",'no_pekerjaan');
$this->datatables->group_by('data_client.no_client');
$this->datatables->where_in('data_pekerjaan.status_pekerjaan',array('Selesai','ArsipSelesai'));
$this->datatables->where('data_pekerjaan.id_no_loker !=',NULL);
$this->datatables->where('data_pekerjaan.no_user_peminjam !=',NULL);
return $this->datatables->generate();
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
public function data_user_where($no_user){
$query = $this->db->get_where('user',array('no_user'=>$no_user));
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