<?php 
class M_user2 extends CI_model{
function json_data_client($jenis){
    
$this->datatables->select('data_client.no_client as no_client,'
.'data_client.no_identitas as no_identitas,'
.'data_client.pembuat_client as pembuat_client,'
.'data_client.jenis_client as jenis_client,'
.'data_client.nama_client as nama_client,'
);
$this->datatables->from('data_client');
$this->datatables->where('jenis_client',$jenis);

$this->datatables->add_column('view',""
        . "<button onclick=lihat_berkas('$1') class='btn  btn-block btn-sm btn-dark' title='lihat berkas client'>Lihat Client <span class='fa fa-eye'></span></button>"
        . "",'base64_encode(no_client)');
return $this->datatables->generate();
}



public function simpan_syarat($data){
$this->db->insert('data_syarat_jenis_dokumen',$data);    
}

public function cari_jenis_pekerjaan($term){
$this->db->from("data_jenis_pekerjaan");
$this->db->limit(15);
$array = array('nama_jenis' => $term);
$this->db->like($array);
$query = $this->db->get();
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

public function cari_kontak($input){
$this->db->from("data_daftar_kontak");
$this->db->limit(15);
$array = array('nama_kontak' => $input);
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
$query = $this->db->get_where('data_client',array('no_client'=>$no_client));
return $query;
}

function json_data_berkas_client($no_client){
$this->datatables->select('data_berkas.no_client as no_client,'
.'data_berkas.no_berkas as no_berkas,'
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
$this->datatables->add_column('view',"<button class='btn btn-dark btn-sm btn-success btn-block '  onclick=lihat_data_perekaman('$1','$2','$3'); >Lihat data <i class='fa fa-eye'></i></button>",'no_nama_dokumen,no_pekerjaan,no_client');
return $this->datatables->generate();
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
$awal  = date('Y/m/d',strtotime("first day of this month"));
$akhir = date('Y/m/d',strtotime("last day of this month"));
    
$this->datatables->select('data_pekerjaan.no_pekerjaan as no_pekerjaan,'
.'data_client.nama_client as nama_client,'
.'data_client.no_client as no_client,'
.'data_jenis_pekerjaan.nama_jenis as pekerjaan,'
.'data_pekerjaan.tanggal_selesai as tanggal_selesai'
);

$this->datatables->from('data_pekerjaan');
$this->datatables->join('data_client', 'data_client.no_client = data_pekerjaan.no_client','Left');
$this->datatables->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan','Left');
$this->datatables->where('data_pekerjaan.no_user',$this->session->userdata('no_user'));
$this->datatables->where('data_pekerjaan.status_pekerjaan','Selesai');
$this->datatables->where('data_pekerjaan.tanggal_selesai >=',$awal);
$this->datatables->where('data_pekerjaan.tanggal_selesai <=',$akhir);
$this->datatables->add_column('view',""
        . "<button class='btn btn-dark btn-sm' onclick=proses_ulang('$1'); title='Proses ulang pekerjaan'><span class='fa fa-retweet'></span></button>"
        . "<button class='btn btn-dark btn-sm ml-1' onclick=lihat_berkas('$2'); title='lihat berkas'><span class='fa fa-eye'></span></button>"
       
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

public function nama_persyaratan($no_pekerjaan,$jenis_client){
$this->db->select('nama_dokumen.nama_dokumen,'
        . 'nama_dokumen.no_nama_dokumen,'
        . 'data_jenis_pekerjaan.nama_jenis,'
        . 'data_pekerjaan.no_pekerjaan,'
        . 'data_persyaratan.no_nama_dokumen');

$this->db->from('data_pekerjaan');
$this->db->join('data_persyaratan', 'data_persyaratan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_persyaratan.no_nama_dokumen');
$this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
$this->db->where('data_pekerjaan.no_pekerjaan',$no_pekerjaan);
$this->db->where('nama_dokumen.penunjang_client !=',NULL);
$this->db->order_by('nama_dokumen.nama_dokumen','ASC');
if($jenis_client == "Badan Hukum"){
$this->db->where('nama_dokumen.badan_hukum',$jenis_client);    
}else if($jenis_client == "Perorangan"){
$this->db->where('nama_dokumen.perorangan',$jenis_client);        
}

$query = $this->db->get();  
return $query;
}

public function nama_persyaratan_pekerjaan($no_pekerjaan,$jenis_client){
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
        $this->db->where('nama_dokumen.penunjang_client =',NULL);
        $this->db->order_by('nama_dokumen.nama_dokumen','ASC');
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




public function hapus_berkas($no_berkas){
$this->db->select('data_client.nama_folder,'
        . 'data_berkas.nama_berkas');

$this->db->from('data_berkas');
$this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
$this->db->where('data_berkas.no_berkas',$no_berkas);
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

public function data_berkas_where($no_berkas){
$this->db->select('data_client.nama_folder,'
        . 'data_berkas.nama_berkas,'
        . 'nama_dokumen.nama_dokumen');
$this->db->from('data_berkas');
$this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen','left');
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
$this->db->join('data_meta_berkas', 'data_meta_berkas.no_berkas = data_berkas.no_berkas','left');
$this->db->join('data_client', 'data_client.no_client = data_berkas.no_client','left');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen','left');
$this->db->order_by('data_meta_berkas.id_data_meta_berkas','ASC');
$this->db->group_by('data_meta_berkas.nama_meta');
$this->db->where('data_berkas.no_client',$no_client);
$this->db->where('data_berkas.no_nama_dokumen',$no_nama_dokumen);
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

public function simpan_perizinan($data){
$this->db->insert('data_berkas_perizinan',$data);    
}

public function data_perizinan($no_pekerjaan,$no_client){
$this->db->select("nama_dokumen.nama_dokumen,"
        . "data_berkas_perizinan.no_berkas_perizinan,"
        ."data_berkas_perizinan.status_berkas,"
        ."data_berkas_perizinan.no_nama_dokumen,"
        ."data_berkas_perizinan.target_selesai_perizinan,"
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

public function upload_utama(){
        if($this->input->post()){
                
        $input = $this->input->post();
        $input = $this->input->post(); 
        $data_client = $this->db->get_where('data_client',array('no_client'=>$input['no_client']))->row_array();
        $status = array();
        
        for($i =0; $i<count($_FILES); $i++){
        $config['upload_path']          = './berkas/'.$data_client['nama_folder'];
        $config['allowed_types']        = 'jpg|jpeg|png|pdf|docx|doc|xlxs|pptx|xlx|';
        $config['encrypt_name']         = FALSE;
        $config['max_size']             = 1000000000;
        $this->upload->initialize($config);   
        
        if (!$this->upload->do_upload('file_utama'.$i)){  
        $status[] = array(
        "status"        => "error",
        "messages"      => $this->upload->display_errors(),    
        'name_file'     => $this->upload->data('file_name')
        );
        }else{
        $lampiran = $this->upload->data();    
        $this->db->limit(1);
        $this->db->order_by('data_dokumen_utama.id_data_dokumen_utama','desc');
        $h_utama = $this->db->get('data_dokumen_utama')->row_array();
        
        if(isset($h_utama['id_data_dokumen_utama'])){
        $urutan = $h_utama['id_data_dokumen_utama']+1;
        }else{
        $urutan =1;
        }
                    $data = array(
                        'id_data_dokumen_utama' =>$urutan,        
                        'nama_file'             =>$this->upload->data('file_name'),
                        'mime-type'             =>$this->upload->data('file_type'),
                        'no_pekerjaan'          =>$input['no_pekerjaan'],
                        'waktu'                 =>date('Y/m/d H:i:s')
                        );
                        $this->db->insert('data_dokumen_utama',$data); 
        
        $status[] = array(
        "status"        => "success",
        "messages"      => "Dokumen Utama berhasil di upload",
        'name_file'     => $this->upload->data('file_name')
        );
        }
        }
        echo json_encode($status);
        
        
        }else{
        redirect(404);    
        }
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

public function cari_dokumen($input){
        $this->db->from("nama_dokumen");
        $this->db->limit(15);
        $array = array('nama_dokumen' => $input);
        $this->db->like($array);
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
public function data_kontak_client($param){
        $this->db->select('*');
        $this->db->from('data_kontak_client');
        $this->db->join('data_daftar_kontak', 'data_daftar_kontak.id_kontak = data_kontak_client.id_kontak');
        $this->db->where('data_kontak_client.no_client',$param);
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
public function data_edit($no_berkas,$nama_meta){
$this->db->select('data_meta_berkas.value_meta');
$this->db->from('data_meta_berkas');
$this->db->where('data_meta_berkas.no_berkas',$no_berkas);
$this->db->where('data_meta_berkas.nama_meta',$nama_meta);

$query = $this->db->get();
return $query;    
}
public function jumlah_dokumen_dimiliki($no_client){
        $this->db->group_by('no_nama_dokumen');
$query = $this->db->get_where('data_berkas',array('no_client'=>$no_client));
return $query;   
}

public function jumlah_lampiran($no_client){
$query = $this->db->get_where('data_berkas',array('no_client'=>$no_client));
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