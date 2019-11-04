<?php 
class M_user2 extends CI_model{
function json_data_client($jenis){
    
$this->datatables->select('id_data_client,'
.'data_client.no_client as no_client,'
.'data_client.pembuat_client as pembuat_client,'
.'data_client.jenis_client as jenis_client,'
.'data_client.nama_client as nama_client,'
);
$this->datatables->from('data_client');
$this->datatables->where('jenis_client',$jenis);

$this->datatables->add_column('view',""
        . "<button onclick=lihat_berkas('$1') class='btn ml-1 btn-sm btn-success' title='lihat berkas client'><span class='fa fa-eye'></span></button>"
        . "<button onclick=form_tambah_pekerjaan('$1') class='btn ml-1 btn-sm btn-success' title='Tambahkan pekerjaan baru'><span class='fa fa-plus'></span></button>"
        . "<button onclick=form_edit_client('$1') class='btn ml-1 btn-sm btn-success' title='Edit Client'><span class='fa fa-edit'></span></button>"
        . "",'base64_encode(no_client)');
return $this->datatables->generate();
}



public function simpan_syarat($data){
$this->db->insert('data_syarat_jenis_dokumen',$data);    
}

public function cari_jenis_dokumen($term){
$this->db->from("data_jenis_pekerjaan");
$this->db->limit(15);
$array = array('nama_jenis' => $term);
$this->db->like($array);
$query = $this->db->get();
if($query->num_rows() >0 ){
return $query->result();
}
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


public function hitung_pekerjaan(){
       $query = $this->db->get('data_pekerjaan');
return $query;
}
public function data_client(){
$query = $this->db->get('data_client');  
return $query;
}
public function data_client_where($no_client){
$query = $this->db->get_where('data_client',array('no_client'=> base64_decode($no_client)));
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
$this->datatables->add_column('view',"<button class='btn btn-dark btn-sm btn-success '  onclick=lihat_data_perekaman('$1','$2','$3'); >Lihat data <i class='fa fa-eye'></i></button>",'no_nama_dokumen,no_pekerjaan,no_client');
return $this->datatables->generate();
}

function json_data_perorangan(){   
$this->datatables->select('id_perorangan,'
.'data_perorangan.id_perorangan as id_perorangan,'
.'data_perorangan.no_nama_perorangan as no_nama_perorangan,'
.'data_perorangan.nama_identitas as nama_identitas,'
.'data_perorangan.no_identitas as no_identitas,'
.'data_perorangan.jenis_identitas as jenis_identitas,'
.'data_perorangan.status_jabatan as status_jabatan,'
);
$this->datatables->from('data_perorangan');
//$this->datatables->where('no_user',$this->session->userdata('no_user'));
$this->datatables->add_column('view',"<button class='btn btn-sm btn-success '  onclick=download_lampiran('$1'); > Download lampiran <i class='fa fa-download'></i></button>",'id_perorangan');
return $this->datatables->generate();
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

function json_data_pekerjaan_selesai(){
    
$this->datatables->select('id_data_pekerjaan,'
.'data_pekerjaan.id_data_pekerjaan as id_data_pekerjaan,'
.'data_pekerjaan.no_pekerjaan as no_pekerjaan,'
.'data_client.nama_client as nama_client,'
.'data_client.no_client as no_client,'
.'data_jenis_pekerjaan.nama_jenis as pekerjaan,'
.'data_pekerjaan.tanggal_selesai as tanggal_selesai'
);

$this->datatables->from('data_pekerjaan');
$this->datatables->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->datatables->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->datatables->where('data_pekerjaan.no_user',$this->session->userdata('no_user'));
$this->datatables->where('data_pekerjaan.status_pekerjaan','Selesai');
$this->datatables->add_column('view',""
        . "<button class='btn btn-success btn-sm' onclick=proses_ulang('$1'); title='Proses ulang pekerjaan'><span class='fa fa-retweet'></span></button>"
        . "<button class='btn btn-success btn-sm ml-1' onclick=lihat_berkas('$2'); title='lihat berkas'><span class='fa fa-eye'></span></button>"
       
        . "",'id_data_pekerjaan, base64_encode(no_client)');

return $this->datatables->generate();
}



public function data_pekerjaan_histori($no_pekerjaan){
$this->db->select('*');
$this->db->from('data_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->db->where('data_pekerjaan.no_pekerjaan',$no_pekerjaan);
$query = $this->db->get();

return $query;
}
public function data_pekerjaan_user($param){
$this->db->select('*');
$this->db->from('data_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->db->where('data_pekerjaan.status_pekerjaan',$param);
$this->db->where('data_pekerjaan.no_user',$this->session->userdata('no_user'),FALSE);
$query = $this->db->get();

return $query;
}


public function data_pekerjaan_persyaratan($param){
$this->db->select('*');
$this->db->from('data_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->where('data_pekerjaan.no_pekerjaan',$param);
$query = $this->db->get();

return $query;
}

public function data_dokumen_utama($no_berkas){
 $query = $this->db->get_where('data_dokumen_utama',array('no_berkas'=> base64_decode($no_berkas)));
 return $query;
    
}

public function  data_form_perorangan($no_berkas){
         $this->db->order_by('id_data_syarat_perorangan',"DESC");
$query = $this->db->get_where('data_syarat_perorangan',array('no_berkas'=> base64_decode($no_berkas)));    
    
return $query;    
}

public function data_user(){
$query = $this->db->get('user');   
return $query;    
}
public function  data_form_perizinan($no_berkas){

$this->db->order_by('id_syarat_dokumen',"DESC");
$query = $this->db->get_where('data_syarat_jenis_dokumen',array('no_berkas'=> base64_decode($no_berkas)));       
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



public function data_perorangan(){
$query = $this->db->get('data_perorangan');    
    
return $query;    
    
}



public function hapus_data_syarat_perorangan($id_data_syarat_perorangan){
$this->db->delete('data_syarat_perorangan',array('id_data_syarat_perorangan'=>$id_data_syarat_perorangan));    
}
public function hapus_syarat_dokumen($id_syarat_dokumen){
$this->db->delete('data_syarat_jenis_dokumen',array('id_syarat_dokumen'=>$id_syarat_dokumen));    
}

public function cari_data_perorangan($term){
$this->db->from("data_perorangan");
$this->db->limit(15);
$array = array('nama_identitas' => $term);
$this->db->like($array);
$query = $this->db->get();
if($query->num_rows() >0 ){
return $query->result();
}
}

public function data_persyaratan_upload($no_pekerjaan){
$this->db->select('*');
$this->db->group_by('data_meta_berkas.nama_berkas');
$this->db->from('data_meta_berkas');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_meta_berkas.no_nama_dokumen');
$this->db->where('data_meta_berkas.no_pekerjaan',base64_decode($no_pekerjaan));
$query = $this->db->get();  
return $query;    
}

public function data_user_where($no_user){
$query = $this->db->get_where('user',array('no_user'=>$no_user));
return $query;
}

public function data_form_persyaratan($no_pekerjaan,$id_data_persyaratan){

$this->db->select('data_persyaratan_pekerjaan.nama_dokumen,'
                . 'data_persyaratan_pekerjaan.no_nama_dokumen,'
                . 'data_client.nama_folder,'
                . 'data_client.no_client,'
                . 'data_pekerjaan.no_pekerjaan');
$this->db->from('data_persyaratan_pekerjaan');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_persyaratan_pekerjaan.no_pekerjaan_syarat');
$this->db->join('data_client', 'data_client.no_client = data_persyaratan_pekerjaan.no_client');
$this->db->where('data_persyaratan_pekerjaan.id_data_persyaratan_pekerjaan',$id_data_persyaratan);
$query = $this->db->get();  
return $query;      
    
    
}

public function data_meta_where($no_nama_dokumen){
$query       = $this->db->get_where('data_meta',array('no_nama_dokumen'=>$no_nama_dokumen));
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

public function data_berkas(){
$this->db->select('data_client.nama_folder,'
        . 'data_berkas.nama_berkas');
$this->db->from('data_berkas');
$this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
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
public function data_berkas_where_no_pekerjaan($no_pekerjaan){
$this->db->select('data_client.nama_folder,'
        . 'data_berkas.nama_berkas,'
        . 'data_berkas.no_nama_dokumen,'
        . 'data_berkas.no_client,'
        . 'data_client.nama_client,'
        . 'nama_dokumen.nama_dokumen');
$this->db->from('data_berkas');
$this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
$this->db->where('data_berkas.no_pekerjaan',$no_pekerjaan);
$this->db->group_by('data_berkas.no_client');
$query = $this->db->get();  
return $query;
}

public function data_berkas_where_no_client($no_client){
$this->db->select('data_client.nama_folder,'
        . 'data_berkas.nama_berkas,'
        . 'data_berkas.no_nama_dokumen,'
        . 'data_berkas.no_client,'
        . 'data_client.nama_client,'
        . 'nama_dokumen.nama_dokumen');
$this->db->from('data_berkas');
$this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
$this->db->where('data_berkas.no_client',$no_client);
$this->db->group_by('data_berkas.no_nama_dokumen');
$query = $this->db->get();  
return $query;
}


public function total_berkas(){
        $this->db->select('data_berkas.id_data_berkas');
        $this->db->from('data_berkas');
        $this->db->order_by('data_berkas.id_data_berkas',"DESC");
        $query = $this->db->get();
        return $query;    
}

public function data_meta($no_nama_dokumen){
$query = $this->db->get_where('data_meta',array('no_nama_dokumen'=>$no_nama_dokumen));
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

public function simpan_perizinan($data){
$this->db->insert('data_berkas_perizinan',$data);    
}

public function data_perizinan($no_pekerjaan,$no_client){
$this->db->select("nama_dokumen.nama_dokumen,"
        . "data_berkas_perizinan.no_berkas_perizinan,"
        ."data_berkas_perizinan.status_berkas,"
        ."data_berkas_perizinan.no_nama_dokumen,"
        ."data_berkas_perizinan.target_selesai_perizinan,"
        . "data_pemilik.no_pemilik,"
        . "user.nama_lengkap");
$this->db->from('data_berkas_perizinan');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas_perizinan.no_nama_dokumen');
$this->db->join('data_pemilik', 'data_pemilik.no_pekerjaan = data_berkas_perizinan.no_pekerjaan');
$this->db->join('user', 'user.no_user = data_berkas_perizinan.no_user_perizinan','left');
$this->db->where('data_berkas_perizinan.no_pekerjaan',base64_decode($no_pekerjaan));
$this->db->where('data_berkas_perizinan.no_client',$no_client);
$this->db->where('data_pemilik.no_client',$no_client);
$query = $this->db->get();  
return $query;
}

public function data_user_perizinan($level){
$this->db->select("*");
$this->db->from('sublevel_user');
$this->db->join('user', 'user.no_user = sublevel_user.no_user');
$this->db->group_by('sublevel_user.no_user');
$this->db->where('sublevel_user.sublevel',$level);
$this->db->where('user.level','User');
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

public function data_asisten($no_user){
$this->db->from('data_berkas_perizinan');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_berkas_perizinan.no_pekerjaan');
$this->db->join('user', 'user.no_user = data_berkas_perizinan.no_user_perizinan');
$this->db->group_by('user.no_user');
$query= $this->db->get();    

return $query;
}

public function data_pemilik(){
         $this->db->limit(1);
         $this->db->order_by('data_pemilik.id_data_pemilik','DESC');
$query = $this->db->get_where('data_pemilik');
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

public function data_berkas_client_where($no_client){
$this->db->select('*');    
$this->db->from('data_berkas');
$this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
$this->db->group_by('data_berkas.no_nama_dokumen');
$this->db->where('data_berkas.no_client',$no_client);
$query= $this->db->get();    
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

public function data_para_pihak($no_pekerjaan){
$this->db->select('data_client.nama_client,'
        . 'data_client.no_client');
$this->db->from('data_pemilik');
$this->db->join('data_client', 'data_client.no_client = data_pemilik.no_client');
$this->db->order_by('data_pemilik.id_data_pemilik','ASC');
$this->db->where('data_pemilik.no_pekerjaan',$no_pekerjaan);

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


}
?>