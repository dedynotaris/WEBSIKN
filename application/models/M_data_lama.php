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
if($query->num_rows() >0 ){
return $query->result();
}
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

public function cari_jenis_client($input){
$this->db->from("data_client");
$this->db->limit(15);
$this->db->where('data_client.jenis_client',$input['jenis_pemilik']);
$array = array('nama_client' => $input['term']);
$this->db->like($array);
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

function json_data_arsip(){
$this->datatables->select('id_data_pekerjaan,'
        . 'data_pekerjaan.no_pekerjaan as no_pekerjaan,'
        . 'data_client.nama_client as nama_client,'
        . 'data_jenis_pekerjaan.nama_jenis as nama_jenis,'
        . 'user.nama_lengkap as nama_lengkap');
$this->datatables->from('data_pekerjaan');
$this->datatables->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->datatables->join('user', 'user.no_user = data_pekerjaan.no_user');
$this->datatables->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->datatables->add_column('view','<a href="'.base_url('Data_lama/lihat_rekam_data/$1').'"><button  class="btn btn-sm btn-outline-dark">Lihat rekaman <span class="fa fa-eye"></span></button></a>','base64_encode(no_pekerjaan)');
return $this->datatables->generate();
}

function json_data_arsip_perorangan(){
$this->datatables->select('id_data_pekerjaan,'
        . 'data_pekerjaan.no_pekerjaan as no_pekerjaan,'
        . 'data_client.nama_client as nama_client,'
        . 'data_jenis_pekerjaan.nama_jenis as nama_jenis,'
        . 'user.nama_lengkap as nama_lengkap');
$this->datatables->from('data_pekerjaan');
$this->datatables->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->datatables->join('user', 'user.no_user = data_pekerjaan.no_user');
$this->datatables->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->datatables->where('data_client.jenis_client','Perorangan');
$this->datatables->add_column('view','<a href="'.base_url('Data_lama/rekam_data/$1').'"><button  class="btn btn-sm btn-outline-dark">Rekam Data <span class="fa fa-pencil-alt"></span></button></a>','base64_encode(no_pekerjaan)');
return $this->datatables->generate();
}
function json_data_arsip_badan_hukum(){
$this->datatables->select('id_data_pekerjaan,'
        . 'data_pekerjaan.no_pekerjaan as no_pekerjaan,'
        . 'data_client.nama_client as nama_client,'
        . 'data_jenis_pekerjaan.nama_jenis as nama_jenis,'
        . 'user.nama_lengkap as nama_lengkap');
$this->datatables->from('data_pekerjaan');
$this->datatables->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->datatables->join('user', 'user.no_user = data_pekerjaan.no_user');
$this->datatables->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->datatables->where('data_client.jenis_client','Badan Hukum');
$this->datatables->add_column('view','<a href="'.base_url('Data_lama/rekam_data/$1').'"><button  class="btn btn-sm btn-outline-dark">Rekam Data <span class="fa fa-pencil-alt"></span></button></a>','base64_encode(no_pekerjaan)');
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

public function data_pekerjaan($no_pekerjaan){
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
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_dokumen_utama.no_pekerjaan','left');
$this->db->join('user', 'user.no_user = data_pekerjaan.no_user','left');
$this->db->where('data_dokumen_utama.no_pekerjaan',base64_decode($no_pekerjaan));
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
$this->db->limit(3);
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

public function data_persyaratan($no_pekerjaan){
$this->db->select('data_client.nama_client,'
        . 'data_client.no_client,'
        . 'data_client.jenis_client,'
        . 'data_client.alamat_client,'
        . 'data_client.contact_person,'
        . 'data_client.contact_number,'
        . 'data_client.jenis_kontak,'
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
if($jenis_client == "Badan Hukum"){
$this->db->where('nama_dokumen.badan_hukum',$jenis_client);    
}else if($jenis_client == "Perorangan"){
$this->db->where('nama_dokumen.perorangan',$jenis_client);        
}

$query = $this->db->get();  
return $query;
}


public function data_client_where($no_client){
$query = $this->db->get_where('data_client',array('no_client'=> base64_decode($no_client)));
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
}
?>