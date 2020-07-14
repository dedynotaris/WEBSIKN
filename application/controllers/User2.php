<?php class user2 extends CI_Controller {

public function __construct() {
        parent::__construct();
            $this->load->helper('download');
            $this->load->library('session');
            $this->load->library('Datatables');
            $this->load->library('form_validation');
            $this->load->library('upload');
            $this->load->model('M_user2');
            $this->load->library('Breadcrumbs');
            
            if($this->session->userdata('sublevel')  != 'Level 2' ){
                redirect(base_url('Menu'));
            }
}

public function index(){
    $this->load->view('umum/V_header');
    $this->load->view('user2/V_dashboarduser2');
}

public function buat_pekerjaan(){
    $this->breadcrumbs->push('Beranda', '/User2');
    $this->breadcrumbs->push('Membuat Pekerjaan', '/User2/buat_pekerjaan');  
    $this->load->view('umum/V_header');
    $this->load->view('user2/V_buat_pekerjaan');
    
}

//Daftar Fungsi Membuat Pekerjaan//
function cari_jenis_pekerjaan(){
    $term  = strtolower($this->input->post('search'));    
        $query = $this->M_user2->cari_jenis_pekerjaan($term);
            if($query->num_rows() >0){
                foreach ($query->result() as $d) {
                    $json[]= array(
                    'text'                    => $d->nama_jenis,   
                    'id'                      => $d->no_jenis_pekerjaan,
                    );   
                }
            $data =array(
            'results'=>$json,
            );
    }else{
            $data =array(
                    'results'=>[array('error'=>'Pencarian Tidak Ditemukan')],
                    );  
    }
        echo json_encode($data);
}

function cari_nama_client(){
if($this->input->post()){
    $search         = strtolower($this->input->post('search'));
    $jenis_client   = strtolower($this->input->post('jenis_client'));
        
        $query = $this->M_user2->cari_jenis_client($search,$jenis_client);
            if($query->num_rows() >0 ){
                 foreach ($query->result_array() as $d) {
                            $json[]= array(
                            'text'          => $d['nama_client'],   
                            'id'            => $d['no_client'],
                            'no_identitas'  => $d['no_identitas']    
                            );   
                }
        $data = array(
                'results'=>$json,
                );
    }else{
      $data =array(
        'results'=>[array('error'=>'Pencarian Tidak Ditemukan')],
      );    
    }
    echo json_encode($data);
    }else{
    redirect(404);    
    }
        
}

public function FormTambahClient(){
    $input = $this->input->post();  
    $data_dokumen = $this->db->get_where('nama_dokumen',array('persyaratan_daftar' =>$input['jenis_client']));  
  
    echo '<div class="modal-content">
    <div class="modal-header bg-info text-white">
    <h6 class="modal-title" >Membuat Data Client '.$input['jenis_client'].'</h6>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
  
    <div class="modal-body overflow-auto" style="max-height:450px;" >';
    
    echo '<form id="FormClientBaru">
    <input type="hidden" name="'. $this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="form-control required"  accept="text/plain">';
    echo "<div class='row'>
    <div class='col'>";
 
    if($this->input->post('jenis_client') =='Badan Hukum'){    
            echo '<input type="hidden" value="Badan Hukum" name="jenis_client" id="jenis_client" class="form-control  required"  accept="text/plain" placeholder="Masukan Jenis">
   
            <label>* Nama Badan Hukum</label>
            <input onkeyup=CekNamaBadanHukum();  type="text" name="nama_client" id="nama_client" class="form-control  required nama_client2"  accept="text/plain" placeholder="Masukan Nama Badan Hukum">
            
            <label>* Pilih Jenis Dokumen </label>
            <select class="form-control nama_dokumen" name="nama_dokumen" id="nama_dokumen">';
            
            foreach($data_dokumen->result_array() as  $n){
                echo "<option value=".$n['no_nama_dokumen'].">".$n['nama_dokumen']."</option>";    
            }
            
            echo'</select> 
            <label>* Masukan File NPWP </label>
            <input type="file" name="file_berkas" id="file_berkas" class="form-control  required"   rows="5" placeholder="Masukan  File Berkas">
            
            <label>* No NPWP <span style="font-size:12px;">( Anda dapat mengenerate no npwp jika npwp belum tersedia)</span></label>
            <div class="input-group mb-3">
            <input type="text" name="no_identitas" id="no_identitas" class="form-control  required"  accept="text/plain" placeholder="Masukan No NPWP">
            <div class="input-group-append">
            <button onclick=GenerateNPWP(); type="button" class="input-group-text" id="basic-addon2">Generate NPWP</button>
            </div>
            </div>

            <label>Alamat Client </label>
            <textarea name="alamat_client" id="alamat_client" class="form-control  required"  accept="text/plain" rows="5" placeholder="Masukan Alamat Client"></textarea>
            
            <label>Nomor Telepon </label>
            <input type="number" name="no_contact" id="no_contact" class="form-control  required"  accept="text/plain" rows="5" placeholder="Masukan No Telepon Badan Hukum">
            
            <label>Email Badan Hukum </label>
            <input type="text" name="email" id="email" class="form-control  required"  accept="text/plain"  placeholder="Masukan Email">';    
            
  }else{
    
            echo '<input type="hidden" value="Perorangan" name="jenis_client" id="jenis_client" class="form-control  required"  accept="text/plain" placeholder="Masukan Jenis">
            <label>* Nama Perorangan</label>
            <input onkeyup=CekNamaPerorangan(); value="" type="text" name="nama_client" id="nama_client" class="form-control  required nama_client2"  accept="text/plain" placeholder="Masukan Nama Perorangan">
            <label>* Pilih Jenis Dokumen </label>
            <select onchange="SetJenisDokumen()" class="form-control nama_dokumen" name="nama_dokumen" id="nama_dokumen">';
            foreach($data_dokumen->result_array() as  $n){
                echo "<option value=".$n['no_nama_dokumen'].">".$n['nama_dokumen']."</option>";    
            }
            
            echo'</select> 
            <label>* Masukan File <span id="nm_file"></span> </label>
            <input type="file" name="file_berkas" id="file_berkas" class="form-control  required"   rows="5" placeholder="Masukan  File Berkas">
            
            <label>*<span id="nmr_file">NIK KTP</span></label>
            <input type="text" name="no_identitas" id="no_identitas" class="form-control  required"  accept="text/plain" placeholder="Masukan NIK KTP">
            
            <label>Alamat Client</label>
            <textarea name="alamat_client" id="alamat_client" class="form-control  required"  accept="text/plain" rows="5" placeholder="Masukan Alamat Client"></textarea>
            
            <label>Nomor Telepon </label>
            <input type="number" name="no_contact" id="no_contact" class="form-control  required"  accept="text/plain" rows="5" placeholder="Masukan No Telepon Perseorangan">
        
            
            <label>Email Perseorangan</label>
            <input type="text" name="email" id="email" class="form-control  required"  accept="text/plain"  placeholder="Masukan Email">';
            
    }
    
            echo ' </div> 
            <div class="col-md-7">

            <label>*Nama Kontak</label>
            <select  onchange=SetKontak() name="nama_kontak" id="nama_kontak" class="form-control nama_kontak"></select>
            <table class="table table-striped table-condensed dataTable no-footerr">
            <thead>
            <thead>
            <th>Nama Kontak</th>
            <th>No Kontak </th>
            <th>Email</th>
            <th>Jabatan</th>
            <th>Aksi</th>
            </thead>
            </thead>    
            <tbody id="DataKontak">
            <tr id="KontakKosong">
            <td align="center" colspan="5">Nama Kontak Belum Tersedia Silahkan Pilih Diatas</td>
            </tr>
            </tbody>  
            </table>
            </div>
            </div>';

            echo '</div> 
            <div class="modal-footer">
            <button onclick=SimpanClient(); class="btn btn-dark simpan_pekerjaan btn-block">Simpan Client Baru <span class="fa fa-save"></span> </button>
            </form>
            </div>
            </div>';
}

public function SimpanClient(){
    $input = $this->input->post();
        $z = json_decode($input['data_kontak'],true);
            $this->form_validation->set_rules('jenis_client', 'Jenis Client', 'required',array('required' => 'Data ini tidak boleh kosong'));
            $this->form_validation->set_rules('nama_client', 'Nama Client', 'required',array('required' => 'Data ini tidak boleh kosong'));
    if($input['jenis_client'] == 'Badan Hukum'){
            $this->form_validation->set_rules(
                                    'no_identitas', 'no_identias',
                                    'required|min_length[15]|max_length[15]|numeric',
                                        array(
                                            'required'      => 'Data Ini Tidak Boleh Kosong ',
                                            'min_length'    => 'No npwp terdiri dari 15 Angka',
                                            'max_length'    => 'No npwp tidak lebih dari 15 Angka',
                                            'numeric'       => 'No npwp hanya berisi angka saja'
                                        )
            );    
    }else{
        
        if($input['jenis_dokumen'] == 'Passport'){
                $this->form_validation->set_rules('no_identitas', 'no_identitas', 'required',array('required' => 'Data ini tidak boleh kosong'));
        }else if(empty($_FILES['file_penunjang'])){
                $this->form_validation->set_rules('file_berkas', 'file_berkas', 'required',array('required' => 'Data ini tidak boleh kosong'));
        }else{
                $this->form_validation->set_rules(
                                        'no_identitas', 'no_identias',
                                        'required|min_length[16]|max_length[16]|numeric',
                                        array(
                                                'required'      => 'Data Ini Tidak Boleh Kosong',
                                                'min_length'    => 'NIK KTP terdiri dari 16 Angka',
                                                'max_length'    => 'NIK KTP terdiri tidak lebih dari 16 Angka',
                                                'numeric'       => 'NIK KTP hanya berisi angka saja'
                                        )
                );
        }
    }
    
    if ($this->form_validation->run() == FALSE){
        $status_input     = $this->form_validation->error_array();
                $status[] = array(
                'status'  => 'error_validasi',
                'messages'=>array($status_input),    
                );
                echo json_encode($status);
    }else{
        $data       = $this->input->post();
        $cek_client = $this->db->get_where('data_client',array('no_identitas'=>$data['no_identitas']))->num_rows();
        
        if($cek_client >0){
            $status[] = array(
            'status'  => 'error_validasi',
            'messages'=>[array('no_identitas'=>'No Identitas Ini Sudah Digunakan Client Lain')],    
            );
        echo json_encode($status);
        
    }else{
        $this->db->limit(1);
        $this->db->order_by('data_client.no_client','desc');
        $h_client = $this->db->get('data_client')->row_array();
        
        if(isset($h_client['no_client'])){
            $urutan = (int) substr($h_client['no_client'],1)+1;
        }else{
            $urutan =1;
        }
            $no_client      =  "C".str_pad($urutan,6 ,"0",STR_PAD_LEFT);
            //pembuatan id_kontak_pekerjaan//
            $data_client = array(
            'no_client'                 => $no_client,    
            'jenis_client'              => ucfirst($data['jenis_client']),    
            'nama_client'               => strtoupper($data['nama_client']),
            'no_identitas'              => ucfirst($data['no_identitas']),    
            'tanggal_daftar'            => date('Y/m/d H:i:s'),    
            'pembuat_client'            => $this->session->userdata('nama_lengkap'),    
            'no_user'                   => $this->session->userdata('no_user'), 
            'nama_folder'               =>"Dok".$no_client,
            'contact_number'            =>$data['no_contact'],
            'alamat_client'             =>$data['alamat_client'],
            'email'                     =>$data['email']
            );
            $this->db->insert('data_client',$data_client);
    
            if(!file_exists("berkas/"."Dok".$no_client)){
                mkdir("berkas/"."Dok".$no_client,0777);
            }
                   
            if(count($z[0]) == 0){

            }else{
                $data_kontak2 = json_decode($input['data_kontak'],true);
                for($a=0; $a<count($data_kontak2); $a++){
                $this->db->limit(1);
                $this->db->order_by('data_kontak_client.id_kontak_client','desc');
                $h_kontak = $this->db->get('data_kontak_client')->row_array();

                if(isset($h_kontak['id_kontak_client'])){
                $hkontak = (int) substr($h_kontak['id_kontak_client'],1)+1;
                }else{
                $hkontak =1;
                }
                $id_kontak_client      =  "K".str_pad($hkontak,6 ,"0",STR_PAD_LEFT);
            
                
   
                $data_kontak = array(
                'id_kontak_client'     =>$id_kontak_client,
                'id_kontak'            =>$data_kontak2[$a]['id_kontak'],
                'no_client'            =>$no_client,    
                );
                $this->db->insert('data_kontak_client',$data_kontak);       
            }
        }
            $config['upload_path']          = './berkas/'."Dok".$no_client;
            $config['allowed_types']        = 'jpg|jpeg|png|pdf|docx|doc|xlxs|pptx|';
            $config['encrypt_name']         = FALSE;
            $config['max_size']             = 1000000000;
            $this->upload->initialize($config);   

    if (!$this->upload->do_upload('file_penunjang')){  
        $status[] = array(
        "status"        => "error",
        "messages"      => $this->upload->display_errors(),    
        'name_file'     => $this->upload->data('file_name')
        );
    }else{
            $this->db->limit(1);
            $this->db->order_by('data_berkas.no_berkas','desc');
            $h_berkas       = $this->db->get('data_berkas')->row_array();
            
            if(isset($h_berkas['no_berkas'])){
            $urutan = (int) substr($h_berkas['no_berkas'],10)+1;
            }else{
            $urutan =1;
            }
    
            $no_berkas = "BK".date('Ymd' ).str_pad($urutan,10,0,STR_PAD_LEFT);
            $data_berkas = array(
            'no_berkas'         => $no_berkas,    
            'no_client'         => $no_client,    
            'no_pekerjaan'      => NULL,
            'no_nama_dokumen'   => $input['nama_dokumen'],
            'nama_berkas'       => $this->upload->data('file_name'),
            'mime-type'         => $this->upload->data('file_type'),   
            'Pengupload'        => $this->session->userdata('no_user'),
            'tanggal_upload'    => date('Y/m/d' )
            );    
            $this->db->insert('data_berkas',$data_berkas); 
        }
   
        $keterangan =   $this->session->userdata('nama_lengkap')." Membuat Client ".$data['nama_client'];
                    $this->histori($keterangan);
                $status[] = array(
                "status"        => "success",
                "no_client"     => base64_encode($no_client),
                "messages"      => "Jenis Client Baru Berhasil Ditambahkan"    
                );
        echo json_encode($status);        
        }
    }
}
public function GenerateNPWP(){
    $this->db->select('data_client.no_identitas');
    $this->db->like('data_client.no_identitas',"99999");
    $this->db->limit(1);
    $this->db->order_by('no_identitas','desc');
    $data   = $this->db->get('data_client')->row_array();
    $urutan = (int) substr($data['no_identitas'],5)+1;
    $no_npwp      =  "99999".str_pad($urutan,10 ,0,STR_PAD_LEFT);
    $status[] = array(
            "status"        => "success",
            "messages"      => "Generate NPWP Berhasil",
            'no_npwp'    => $no_npwp
            );
            echo json_encode($status); 
}

function SimpanArsip(){
    $input = $this->input->post();

        $this->form_validation->set_rules('jenis_pekerjaan', 'Jenis Pekerjaan', 'required',array('required' => 'Data ini tidak boleh kosong'));
    $this->form_validation->set_rules('nama_client', 'Nama Client', 'required',array('required' => 'Data ini tidak boleh kosong'));
    $this->form_validation->set_rules('target_selesai', 'Target Selesai', 'required',array('required' => 'Data ini tidak boleh kosong'));
    
    if ($this->form_validation->run() == FALSE){
    $status_input = $this->form_validation->error_array();
    $status[] = array(
    'status'   => 'error_validasi',
    'messages' => array($status_input),    
    );
    echo json_encode($status);
    
    }else{
            
$input = $this->input->post();
//Membuat Penomoran pekerjaan//

$this->db->limit(1);
$this->db->order_by('data_pekerjaan.no_pekerjaan','desc');
$h_pekerjaan       = $this->db->get('data_pekerjaan')->row_array();


if(isset($h_pekerjaan['no_pekerjaan'])){
$pekerjaan =  (int) substr($h_pekerjaan['no_pekerjaan'],1)+1;
}else{
$pekerjaan = 1;
}

$no_pekerjaan   = "P".str_pad($pekerjaan,6 ,"0",STR_PAD_LEFT);

$data_r = array(
    'no_client'          => $input['nama_client'],    
    'status_pekerjaan'   => "Masuk",
    'no_pekerjaan'       => $no_pekerjaan,    
    'tanggal_dibuat'     => date('Y/m/d'),
    'no_jenis_pekerjaan' => $input['jenis_pekerjaan'],   
    'target_kelar'       => $input['target_selesai'],
    'no_user'            => $this->session->userdata('no_user'),    
    'pembuat_pekerjaan'  => $this->session->userdata('no_user'),    
    );

  $this->db->insert('data_pekerjaan',$data_r);

    $data_pem = array(
    'no_client'     =>$input['nama_client'],
    'no_pekerjaan'  =>$no_pekerjaan    
    );
    $this->db->insert('data_pemilik',$data_pem);

            
    $status[] = array(
            "status"       => "success",
            "messages"     =>"Arsip baru berhasil dibuat",
            "no_pekerjaan" => $no_pekerjaan,   
            );    
            echo json_encode($status);    

}

}

function data_para_pihak(){
    if($this->input->post()){
        $input = $this->input->post();
        $data_pihak = $this->M_user2->data_para_pihak($input['no_pekerjaan']);
        $h=1;
            echo "<table class='table table-striped'>"
            . "<tr class='text-center text-info'>"
            . "<td >Nama Pihak Terlibat</td>"
             . "</tr>";
            if($data_pihak->num_rows() > 1 ){
                foreach ($data_pihak->result_array() as $data){
                    if($input['no_client'] != $data['no_client']){
                        echo "<tr>";
                        echo "<td>".$data['nama_client']."</td></tr>";
                        echo "<tr><td align='center'><button onclick=tampilkan_form('".$data['no_client']."','".$input['no_pekerjaan']."'); class='btn m-1   btn-dark btn-sm' title='Upload Penunjang'>Penunjang <span class='fa fa-upload'></span> </button>";
                        echo  "<button onclick=form_edit_client('".$data['no_client']."','".$input['no_pekerjaan']."'); class='btn m-1  btn-dark  btn-sm' title='Detail Client'> Detail Client <span class='fa fa-user'></span></button>";
                        echo  "<button onclick=hapus_keterlibatan('".$data['no_client']."','".$input['no_pekerjaan']."'); class='btn m-1  btn-danger  btn-sm' title='Hapus keterlibatan '> Hapus <span class='fa fa-trash'></span></button>";
                            if($this->input->post('proses') =='perizinan'){
                        echo "<button  onclick=tampilkan_form_perizinan('".$data['no_client']."','".base64_encode($input['no_pekerjaan'])."'); class='btn m-1  btn-dark  btn-sm ' title='Rekam dokumen utama' > Buat Penunjang <span class='fa fa-plus'></span> </button></td></tr>";  
                            }
                    }
                        
            }
    
    }else{
            echo "<tr><td align='center' colspan='3'>Pihak Terlbiat Belum Dimasukan <br> Untuk Menambahkan Silahkan Cari Pihak Terlibat dahulu</td></tr>";    
    }    
            echo "</table>";
    }else{
            redirect(404);    
    }
}

public function LihatSemuaDokumen(){
    if($this->input->post('no_client')){
    
    
    $input = $this->input->post();
    $this->db->select('data_jenis_pekerjaan.nama_jenis,data_pekerjaan.no_pekerjaan,data_pekerjaan.status_pekerjaan');
    $this->db->from('data_pemilik');
    $this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_pemilik.no_pekerjaan');
    $this->db->join('data_jenis_pekerjaan', 'data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
    $this->db->where('data_pemilik.no_client',$input['no_client']);
    $query = $this->db->get();  
    foreach($query->result_array() as $d){
    
            $this->db->select('data_client.nama_folder,'
            . 'data_berkas.nama_berkas,'
            . 'data_berkas.no_berkas,'
            . 'data_client.nama_folder,'
            . 'nama_dokumen.nama_dokumen');
            $this->db->from('data_berkas');
            $this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
            $this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
            $this->db->where('data_berkas.no_pekerjaan',$d['no_pekerjaan']);
            $this->db->where('data_berkas.no_client',$input['no_client']);
            $this->db->where('nama_dokumen.penunjang_client',NULL);
            $dokumenpekerjaan = $this->db->get();  
            
            $this->db->select('data_dokumen_utama.jenis,'
            . 'data_dokumen_utama.tanggal_akta,'
            . 'data_dokumen_utama.id_data_dokumen_utama,'
            . 'data_dokumen_utama.nama_file,'
            . 'data_client.nama_folder,'
            . 'data_dokumen_utama.no_akta');
            $this->db->from('data_dokumen_utama');
            $this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_dokumen_utama.no_pekerjaan');
            $this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
            $this->db->where('data_dokumen_utama.no_pekerjaan',$d['no_pekerjaan']);
            $utama = $this->db->get();  
    if($d['status_pekerjaan'] == 'ArsipSelesai' || $d['status_pekerjaan'] == 'Selesai'){
    echo "<tr class='bg-success ' ><td colspan='2'>".$d['nama_jenis']."</td></tr>";        
    }else{
    echo "<tr class='bg-warning' ><td colspan='2'>".$d['nama_jenis']."</td></tr>";        
    }
     $n=1;
    foreach($dokumenpekerjaan->result_array() as $p){
            echo "<tr class='data".$p['no_berkas']."' onclick=FormLihatMeta('".$p['no_berkas']."','".$p['nama_folder']."','".$p['nama_berkas']."')>
            <td>".$n++."</td>
            <td>".$p['nama_dokumen']."</td>
            </tr>";        
            }
    
            foreach ($utama->result_array() as $u){
                echo "<tr>"
                    ."<td>".$n++."</td>"
                    ."<td colspan='2'>".$u['jenis']." No ".$u['no_akta'].""
                    ."<button  onclick=LihatLampiran('".$u['nama_folder']."','".$u['nama_file']."') class='btn float-right btn-primary btn-sm'><span class='fa fa-eye'></span></button>
                    <button    onclick=download_utama('".$u['id_data_dokumen_utama']."') class='btn mr-1 float-right btn-primary btn-sm'><span class='fa fa-download'></span></button></td>
                    </tr>";    
               }
    
    }
    }else{
    redirect(404);        
    }
    
    }

public function keluar(){
$this->session->sess_destroy();
redirect (base_url('Login'));
}

public function asisten(){  
$asisten = $this->M_user2->data_asisten($this->session->userdata('no_user'));
$this->load->view('umum/V_header');
$this->load->view('user2/V_data_asisten',['asisten'=>$asisten]);    
}

public function data_client_hukum(){
    $this->breadcrumbs->push('Beranda', '/User2');
    $this->breadcrumbs->push('Daftar Client Badan Hukum','/User2/data_client_hukum');  
    
$this->load->view('umum/V_header');
$this->load->view('user2/V_data_client_hukum');
}

public function data_client_perorangan(){
    $this->breadcrumbs->push('Beranda', '/User2');
    $this->breadcrumbs->push('Daftar Client Perorangan','/User2/data_client_perorangan');  
     
$this->load->view('umum/V_header');
$this->load->view('user2/V_data_client_perorangan');
}

public function json_data_client(){
if($this->uri->segment(3) == "Badan_hukum"){
$jenis  ="Badan Hukum";   
}else{
$jenis  ="Perorangan";    
}       
echo $this->M_user2->json_data_client($jenis);       
}

public function SimpanPekerjaan(){
$input = $this->input->post();

$this->form_validation->set_rules('jenis_pekerjaan', 'Jenis Pekerjaan', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('nama_client', 'Nama Client', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('target_selesai', 'Target Selesai', 'required',array('required' => 'Data ini tidak boleh kosong'));

if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'   => 'error_validasi',
'messages' => array($status_input),    
);
echo json_encode($status);

}else{

if(!$this->input->post('data_kontak')){
$status[] = array(
'status'   => 'error_validasi',
'messages' => [array('nama_kontak'=>'Masukan Minimal Satu Kontak Person')],    
);
echo json_encode($status);
    
}else{

    
$h_berkas       = $this->M_user2->hitung_pekerjaan()->num_rows()+1;
$no_pekerjaan = "P".str_pad($h_berkas,6 ,"0",STR_PAD_LEFT);



$data_r = array(
'no_client'          => $input['nama_client'],    
'status_pekerjaan'   => "Masuk",
'no_pekerjaan'       => $no_pekerjaan,    
'tanggal_dibuat'     => date('Y/m/d'),
'no_jenis_pekerjaan' => $input['jenis_pekerjaan'],   
'target_kelar'       => $input['target_selesai'],
'no_user'            => $this->session->userdata('no_user'),    
'pembuat_pekerjaan'  => $this->session->userdata('nama_lengkap'),    
);
$this->db->insert('data_pekerjaan',$data_r);


for($a=0; $a<count($input['data_kontak']); $a++){
$data_kontak = array(
'id_kontak'     =>$input['data_kontak'][$a]['id_kontak'],
'no_pekerjaan'  =>$no_pekerjaan,    
'nama_kontak'   =>$input['data_kontak'][$a]['nama_kontak'],
'no_kontak'     =>$input['data_kontak'][$a]['no_kontak'],
'email'         =>$input['data_kontak'][$a]['email'],
'jabatan'       =>$input['data_kontak'][$a]['jabatan']    
);
$this->db->insert('data_kontak_pekerjaan',$data_kontak);
}


        $this->db->order_by('id_data_pemilik','DESC');
        $this->db->limit(1);  
$tot_pemilik = $this->db->get('data_pemilik')->row_array();
    
$no_pemilik    = "PK".str_pad(isset($tot_pemilik['id_data_pemilik']) ? 0 : 0 ,6 ,"0",STR_PAD_LEFT);
$data_pem = array(
'no_pemilik'    =>$no_pemilik,   
'no_client'     =>$input['nama_client'],
'no_pekerjaan'  =>$no_pekerjaan   
);
$this->db->insert('data_pemilik',$data_pem);

$keterangan = $this->session->userdata('nama_lengkap')." Membuat Pekerjaan Baru ";
$this->histori($keterangan);
$status[] = array(
"status"        => "success",
"messages"      => "Pekerjaan Baru Berhasil Dibuat"    
);
echo json_encode($status);
   
}
   
}
}


public function json_data_pekerjaan_selesai(){
echo $this->M_user2->json_data_pekerjaan_selesai();       
}
public function pekerjaan_baru(){
$query = $this->M_user2->data_berkas('Baru');
    
$this->load->view('umum/V_header');
$this->load->view('user2/V_pekerjaan_baru',['query' =>$query]);
    
}
public function pekerjaan_antrian(){

    $this->breadcrumbs->push('Beranda', '/User2');
    $this->breadcrumbs->push('Membuat Pekerjaan','/User2/buat_pekerjaan');  
    $this->breadcrumbs->push('Pekerjaan Masuk', '/User2/pekerjaan_antrian');  
    
$query = $this->M_user2->data_pekerjaan_user('Masuk');
$this->load->view('umum/V_header');
$this->load->view('user2/V_antrian',['query' =>$query]);

    
}
public function pekerjaan_proses(){
$query = $this->M_user2->data_pekerjaan_user('Proses');

$this->breadcrumbs->push('Beranda', '/User2');
$this->breadcrumbs->push('Membuat Pekerjaan','/User2/buat_pekerjaan');  
$this->breadcrumbs->push('Pekerjaan Masuk', '/User2/pekerjaan_antrian');  
$this->breadcrumbs->push('Pekerjaan Proses', '/User2/pekerjaan_proses');  

$this->load->view('umum/V_header');
$this->load->view('user2/V_pekerjaan_proses',['query' =>$query]);
    
}

public function pekerjaan_selesai(){

    $this->breadcrumbs->push('Beranda', '/User2');
    $this->breadcrumbs->push('Membuat Pekerjaan','/User2/buat_pekerjaan');  
    $this->breadcrumbs->push('Pekerjaan Masuk', '/User2/pekerjaan_antrian');  
    $this->breadcrumbs->push('Pekerjaan Proses', '/User2/pekerjaan_proses');  
    $this->breadcrumbs->push('Pekerjaan Selesai', '/User2/pekerjaan_selesai');  
        
$this->load->view('umum/V_header');
$this->load->view('user2/V_pekerjaan_selesai');
    
}
public function tambahkan_kedalam_antrian(){
if($this->input->post()){
$data = array(
'status_berkas'   => 'Masuk',    
'tanggal_antrian' => date('Y/m/d H:i:s')    
);
$this->db->update('data_berkas',$data,array('no_berkas'=>$this->input->post('no_berkas')));
$status = array(
"status"=>"success",
'pesan'=>"Dokumen berhasil dimasukan kedalam antrian"   
);
echo json_encode($status);
}else{
redirect(404);    
}
    
}
public function tambahkan_kedalam_proses(){
if($this->input->post()){
$data = array(
'status_berkas'   => 'Proses',    
'tanggal_proses' => date('d/m/Y H:i:s')    
);
$this->db->update('data_berkas',$data,array('no_berkas'=>$this->input->post('no_berkas')));
$status = array(
"status"=>"success",
'pesan'=>"Dokumen berhasil dimasukan kedalam proses"   
);
echo json_encode($status);
}else{
redirect(404);    
}
}
public function proses_pekerjaan(){
if(!empty($this->uri->segment(3))){
$no_pekerjaan       = base64_decode($this->uri->segment(3));    
$query              = $this->M_user2->data_persyaratan($no_pekerjaan);

$this->breadcrumbs->push('Beranda', '/User2');
$this->breadcrumbs->push('Membuat Pekerjaan','/User2/buat_pekerjaan');  
$this->breadcrumbs->push('Pekerjaan Masuk', '/User2/pekerjaan_antrian');  
$this->breadcrumbs->push('Pekerjaan Proses', '/User2/pekerjaan_proses');  
$this->breadcrumbs->push('Membuat Penunjang', '/User2/proses_pekerjaaan');  

$this->load->view('umum/V_header');
$this->load->view('user2/V_buat_perizinan',['query'=>$query]);    
}else{
redirect(404);    
}
}
public function lengkapi_persyaratan(){    
$no_pekerjaan       = base64_decode($this->uri->segment(3));    
$query              = $this->M_user2->data_persyaratan($no_pekerjaan);

$this->breadcrumbs->push('Beranda', '/User2');
$this->breadcrumbs->push('Membuat Pekerjaan','/User2/buat_pekerjaan');  
$this->breadcrumbs->push('Pekerjaan Masuk', '/User2/pekerjaan_antrian');  
$this->breadcrumbs->push('Melengkapi Persyaratan', '/User2/lengkapi_persyaratan');  

$this->load->view('umum/V_header');
$this->load->view('user2/V_lengkapi_persyaratan',['query'=>$query]);    
}

public function persyaratan_telah_dilampirkan(){
$data_berkas  = $this->M_user2->data_telah_dilampirkan(base64_decode($this->uri->segment(3)));
if($data_berkas->num_rows() != 0){
foreach ($data_berkas->result_array() as $u){  
echo'<div class="card m-1">
<div class="row">
<div class="col card-header">'.$u['nama_dokumen'].'</div> 
<div class="col-md-4 card-header text-right">
<button type="button" onclick=lihat_data_perekaman("'.$u['no_nama_dokumen'].'","'.$u['no_pekerjaan'].'") class="btn btn-sm btn-dark btn-block">Lihat data <span class="fa fa-eye"></span></button>';
echo "</div>    
</div>
</div>";
}
}
}

public function data_perekaman(){
if($this->input->post()){
$input = $this->input->post();
$query     = $this->M_user2->data_perekaman2($input['no_nama_dokumen'],$input['no_client']);
echo "<table class='table table-striped '>";
echo "<thead class='text-info'>"
. "<th>Nama Dokumen</th>"
. "<th>Jenis Dokumen</th>"
. "<th>Aksi</th>"
. "</thead>";
foreach ($query->result_array() as $d){
echo "<tr>"
    . "<td>".$d['nama_berkas']."</td>"
    . "<td>".$d['nama_dokumen']."</td>"
    . "<td><button class='btn btn-dark btn-block btn-sm' onclick=cek_download('". base64_encode($d['no_berkas'])."')> Download File <span class='fa fa-download'></span></button></td>"    
    . "</tr>";
}

echo "<tbody></tbody>";
echo"</table>";  
}else{
redirect(404);    
}    
}
public function lanjutkan_proses_perizinan(){
if($this->input->post()){
$input  = $this->input->post();
$histori   = $this->M_user2->data_pekerjaan_histori(base64_decode($input['no_pekerjaan']))->row_array();
$data = array(
'status_pekerjaan'  =>'Proses',    
'tanggal_proses'    => date('Y/m/d')    
);
$this->db->update('data_pekerjaan',$data,array('no_pekerjaan'=> base64_decode($input['no_pekerjaan'])));
$keterangan = $this->session->userdata('nama_lengkap')." Memproses perizinan ".$histori['pekerjaan']." client ". $histori['nama_client'];
$this->histori($keterangan);
$status[] = array(
"status"     => "success",
"messages"      => "Pekerjaan Dimasukan kedalam proses pembuatan penunjang"    
);
echo json_encode($status);
}else{
redirect(404);    
}
}

public function update_selesaikan_pekerjaan(){
if($this->input->post()){
$input = $this->input->post();
$data = array(
'status_pekerjaan'  =>'Selesai',    
'tanggal_selesai'    => date('Y/m/d')    
);
$this->db->update('data_pekerjaan',$data,array('no_pekerjaan'=> base64_decode($input['no_pekerjaan'])));
$status[] = array(
"status"     => "success",
"messages"      => "Perizinan berhasil diselesaikan"    
);
echo json_encode($status);
}else{
redirect(404);    
}
}
public function hapus_berkas_persyaratan(){
if($this->input->post()){
$input = $this->input->post();
$data = $this->M_user2->hapus_berkas($input['no_berkas'])->row_array();
$filename = './berkas/'.$data['nama_folder']."/".$data['nama_berkas'];
if(file_exists($filename)){
unlink($filename);
}
$this->db->delete('data_berkas',array('no_berkas'=>$input['no_berkas']));    
$status[] = array(
"status"     => "success",
"messages"      => "Dokumen lampiran telah di hapus",    
);
echo json_encode($status);
}else{
redirect(404);    
} 
}
public function download_berkas(){
$data = $this->M_user2->data_berkas_where($this->uri->segment(3))->row_array();
$file_path = "./berkas/".$data['nama_folder']."/".$data['nama_berkas']; 
$info = new SplFileInfo($data['nama_berkas']);
force_download($data['nama_dokumen'].".".$info->getExtension(), file_get_contents($file_path));
}

public function download_utama($id_data_dokumen_utama){
$this->db->select('data_dokumen_utama.nama_file,'
        . 'data_client.nama_folder,'
        . 'data_dokumen_utama.nama_berkas');    
$this->db->from('data_dokumen_utama');
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_dokumen_utama.no_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->where('id_data_dokumen_utama',base64_decode($id_data_dokumen_utama));
$data= $this->db->get()->row_array();    
$file_path = "./berkas/".$data['nama_folder']."/".$data['nama_file']; 
$info = new SplFileInfo($data['nama_file']);
force_download($data['nama_berkas'].".".$info->getExtension(), file_get_contents($file_path));
}
public function lihat_laporan_perizinan(){
if($this->input->post()){
$input = $this->input->post();
$data = $this->db->get_where('data_progress_perizinan',array('no_berkas_perizinan'=>$input['no_berkas_perizinan']));
if($data->num_rows() == 0){
    echo '<div class="modal-content">
    <div class="modal-header bg-dark text-white">
    <h6 class="modal-title" >Masukan Detail Dokumen Utama</h6>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body " >';  
echo "<h5 class='text-center text-dark'>"
    . "<span class=' far fa-clipboard fa-3x'></span> <br>Belum ada laporan yang dimasukan</h5>";
echo "</div>";    
}else{
echo'<div class="modal-header bg-dark">
<h6 class="modal-title text-white" >Laporan Perizinan <span id="title"></span> </h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body p-0" >';
echo "<table class='table  table-striped '>"
. "<tr class='text-info'>"
. "<th>No </th>"
. "<th class='text-center'>Laporan Perizinan</th>"
. "</tr>";
$h=1;
foreach ($data->result_array() as $d){
echo "<tr>"
    . "<td>".$h++."</td>"
    . "<td s>".$d['laporan']." <br><span class='text-info'>".$d['waktu']."</span></td>"
    . "</tr>";    
}
echo "</table>";
echo"</div>";

echo '<div class="modal-footer " >'
. '<butto class="btn btn-dark btn-block">Lihat File Perizinan  <span class="fa fa-eye"></span></button>'
. '</div></div>';

}
}else{
redirect(404);    
}    
}

public function cari_file(){
$kata_kunci = $this->input->post('kata_kunci');
$data_dokumen           = $this->M_user2->pencarian_data_dokumen($kata_kunci);
$data_dokumen_utama     = $this->M_user2->pencarian_data_dokumen_utama($kata_kunci);
$data_client            = $this->M_user2->pencarian_data_client($kata_kunci);
$this->load->view('umum/V_header');
$this->load->view('user2/V_pencarian',['data_dokumen'=>$data_dokumen,'data_dokumen_utama'=>$data_dokumen_utama,'data_client'=>$data_client]);
}

public function lihat_pekerjaan_asisten(){
$proses = base64_decode($this->uri->segment(4));    
$no_user = base64_decode($this->uri->segment(3));
$this->db->select('*');
$this->db->from('data_berkas_perizinan');
$this->db->join('data_pekerjaan','data_pekerjaan.no_pekerjaan = data_berkas_perizinan.no_pekerjaan');
$this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
$this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas_perizinan.no_nama_dokumen');
$this->db->where(array('data_berkas_perizinan.status_berkas'=>$proses,'data_berkas_perizinan.no_user_perizinan'=>$no_user));
$data = $this->db->get();
$this->load->view('umum/V_header');
$this->load->view('user2/V_lihat_pekerjaan_level3',['data'=>$data]);    
    
}
public function simpan_progress_pekerjaan(){
if($this->input->post()){

    $this->db->limit(1);
    $this->db->order_by('data_progress_pekerjaan.id_data_progress_pekerjaan','desc');
    $h_lp = $this->db->get('data_progress_pekerjaan')->row_array();
    
    if(isset($h_lp['id_data_progress_pekerjaan'])){
        $urutan = (int) substr($h_lp['id_data_progress_pekerjaan'],2)+1;
    }else{
        $urutan =1;
    }
  
        $id      =  "LP".str_pad($urutan,6 ,"0",STR_PAD_LEFT);    
$input = $this->input->post();    
$data = array(
'id_data_progress_pekerjaan'    => $id,   
'laporan_pekerjaan'             => $input['laporan'],
'no_pekerjaan'                  => base64_decode($input['no_pekerjaan']),
'waktu'                         => date('Y/m/d H:i:s')    
);
$this->db->insert('data_progress_pekerjaan',$data);
$status = array(
"status"     => "success",
"pesan"      => "Laporan berhasil dibuat"    
);
echo json_encode($status);
}else{
redirect(404);    
}    
}
function lihat_laporan_pekerjaan(){
if($this->input->post()){
$input = $this->input->post();
$data = $this->db->get_where('data_progress_pekerjaan',array('no_pekerjaan'=> base64_decode($input['no_pekerjaan'])));
if($data->num_rows() == 0){
echo "<h5 class='text-center '>"
    . "<span class='far fa-clipboard fa-3x'></span><br>Belum ada laporan yang anda masukan</h5>";
    
}else{
echo "<table class='table  table-bordered table-striped table-hover '>"
. "<tr class='text-info'>"
. "<th>Tanggal </th>"
. "<th>Laporan</th>"
. "</tr>";
foreach ($data->result_array() as $d){
echo "<tr>"
    . "<td>".$d['waktu']."</td>"
    . "<td>".$d['laporan_pekerjaan']."</td>"
    . "</tr>";    
}
echo "</table>";
}
}else{
redirect(404);    
}
    
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

    function FormMasukanMetaUtama(){
        $input = $this->input->post();
        $form = '<div class="modal-content">
<div class="modal-header bg-dark text-white">
<h6 class="modal-title" >Masukan Detail Dokumen Utama</h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body " >
<form id="FormUtama" >';

$form .='<input type="hidden" class="form-control jenis_dokumen" id="jenis_dokumen" name="jenis_dokumen" value="'.$input['jenis_dokumen'].'">';

$form .='<input type="hidden" class="form-control id_dokumen" id="id_dokumen" name="id_dokumen" value="'.$input['id_dokumen_utama'].'">';

$form .='<label>Masukan No Akta</label>
<input type="text" class="form-control no_akta" id="no_akta" name="no_akta">';

$form .='<label>Masukan Tanggal Akta</label>
<input type="text" class="form-control tanggal_akta date" id="tanggal_akta" name="tanggal_akta">';


$form .="<hr>"
. "<button type='button' onclick=SimpanUtama() class='btn  btn-md btn-dark btn-block '>Simpan Dokumen Utama <i class='fa fa-save'></i></button>"
. "</form>"
. "</div></div>";

        $status[] = array(
                'status'  => 'success',
                'data'=> $form,    
                );
                echo json_encode($status);  
}

public function SimpanUtama(){

    if($this->input->post()){
    $input = $this->input->post();
                    
                    $data = array(
                    'tanggal_akta'          =>$input['tanggal_akta'],   
                    'nama_berkas'                 =>$input['jenis_dokumen'],
                    'jenis'                 =>$input['jenis_dokumen'],
                    'no_akta'               =>$input['no_akta']   
                    );
              
                       $this->db->update('data_dokumen_utama',$data,array('id_data_dokumen_utama'=>$input['id_dokumen']));   
                    $status[] = array(
                    "status"        => "success",
                    "messages"      => "File utama berhasil ditambahkan"    
                    );
                   
                    echo json_encode($status);        
    
    }else{
    redirect(404);        
    }
    
                
    }

public function hapus_file_utama(){
if($this->input->post()){
$input = $this->input->post();
$data = $this->M_user2->data_dokumen_utama_where($input['id_data_dokumen_utama'])->row_array();
unlink('./berkas/'.$data['nama_folder']."/".$data['nama_file']);
$this->db->delete('data_dokumen_utama',array('id_data_dokumen_utama'=>$this->input->post('id_data_dokumen_utama')));    
$status[] = array(
"status"        => "success",
"messages"      => "File berhasil dihapus"    
);
echo json_encode($status);
}else{
redirect(404);    
}    
}
public function hapus_data_berkas(){
if($this->input->post()){
$input = $this->input->post();    
$data = $this->db->get_where('data_berkas',array('id_data_berkas'=>$this->input->post('id_data_berkas')))->row_array();    
unlink('./berkas/'.$data['nama_folder']."/".$data['nama_berkas']);
$this->db->delete('data_berkas',array('id_data_berkas'=>$this->input->post('id_data_berkas')));    
$status = array(
"status"     => "success",
"no_pekerjaan"  => base64_encode($input['no_pekerjaan']),
"pesan"      => "Persyaratan berhasil ditambahkan",    
);
echo json_encode($status);
$keterangan = $this->session->userdata('nama_lengkap')." Menghapus File Dokumen ".$data['nama_file'];  
$this->histori($keterangan);
}else{
redirect(404);    
}    
}
public function buat_pekerjaan_baru(){
if($this->input->post()){    
$input = $this->input->post();
$this->form_validation->set_rules('jenis_pekerjaan', 'Jenis pekerjaan', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('target_kelar', 'Target selesai', 'required',array('required' => 'Data ini tidak boleh kosong'));

if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);
echo json_encode($status);
}else{
$h_berkas = $this->M_user2->hitung_pekerjaan()->num_rows()+1;
$no_pekerjaan = "P".str_pad($h_berkas,6 ,"0",STR_PAD_LEFT);
$data_r = array(
'no_client'          => $input['no_client'],    
'status_pekerjaan'   => "Masuk",
'no_pekerjaan'       => $no_pekerjaan,    
'tanggal_dibuat'     => date('Y/m/d'),
'no_jenis_pekerjaan' => $input['jenis_pekerjaan'],   
'target_kelar'       => $input['target_kelar'],
'no_user'            => $this->session->userdata('no_user'),    
'pembuat_pekerjaan'  => $this->session->userdata('nama_lengkap'),    
);
$this->db->insert('data_pekerjaan',$data_r);

$tot_pemilik   = $this->M_user2->data_pemilik()->row_array();
$no_pemilik    = "PK".str_pad($tot_pemilik['id_data_pemilik'],6 ,"0",STR_PAD_LEFT);
$data_pem = array(
'no_pemilik'    =>$no_pemilik,   
'no_client'     =>$input['no_client'],
'no_pekerjaan'  =>$no_pekerjaan   
);

$this->db->insert('data_pemilik',$data_pem);
$status[] = array(
"status"        => "success",
"no_pekerjaan"  => base64_encode($no_pekerjaan),
"messages"      => "Telah dimasukan kedalam agenda kerja"    
);
echo json_encode($status);
    
}
}else{
redirect(404);    
}    
}

public function profil(){
$no_user = $this->session->userdata('no_user');
$data_user = $this->M_user2->data_user_where($no_user);
$this->load->view('umum/V_header');
$this->load->view('user2/V_profil',['data_user'=>$data_user]);
}
public function simpan_profile(){
$foto_lama = $this->db->get_where('user',array('no_user'=>$this->session->userdata('no_user')))->row_array();
if(!file_exists('./uploads/user/'.$foto_lama['foto'])){
    
}else{
if($foto_lama['foto'] != NULL){
unlink('./uploads/user/'.$foto_lama['foto']);    
}   
}
$img =  $this->input->post();
define('UPLOAD_DIR', './uploads/user/');
$image_parts = explode(";base64,", $img['image']);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];
$image_base64 = base64_decode($image_parts[1]);
$file_name = uniqid() . '.png';
$file = UPLOAD_DIR .$file_name;
file_put_contents($file, $image_base64);
$data = array(
'foto' =>$file_name,    
);
$this->db->update('user',$data,array('no_user'=>$this->session->userdata('no_user')));
$this->session->set_userdata($data);
$status = array(
"status"     => "success",
"pesan"      => "Foto profil berhasil diperbaharui"    
);
echo json_encode($status);
}
public function update_user(){
if($this->input->post()){
$input= $this->input->post();
$data =array(
'email'         =>$input['email'],
'username'      =>$input['username'],
'nama_lengkap'  =>$input['nama_lengkap'],
'phone'         =>$input['phone']    
);
$this->db->where('no_user',$input['id_user']);
$this->db->update('user',$data);
$status = array(
"status"     => "success",
"pesan"      => "Data profil berhasil diperbaharui"    
);
echo json_encode($status);
}else{
redirect(404);    
}
}
public function update_password(){
if($this->input->post()){
$data = array(
'password' => md5($this->input->post('password'))
);
$this->db->update('user',$data,array('no_user'=>$this->input->post('no_user')));
 
$status = array(
"status"     => "success",
"pesan"      => "Password diperbaharui"    
);
echo json_encode($status);
}else{
redirect(404);    
}    
}
public function histori($keterangan){
   
    $this->db->order_by('id_data_histori_pekerjaan','DESC');
    $this->db->limit(1);  
$data = $this->db->get('data_histori_pekerjaan')->row_array();

if(isset($data['id_data_histori_pekerjaan'])){
    $urutan = $data['id_data_histori_pekerjaan']+1;
    }else{
    $urutan =1;
    }

    $id_data_histori_pekerjaan      =  str_pad($urutan,6 ,"0",STR_PAD_LEFT);
              
$data = array(
'id_data_histori_pekerjaan'  =>$id_data_histori_pekerjaan,        
'no_user'                    => $this->session->userdata('no_user'),
'keterangan'                 =>$keterangan,
'tanggal'                    =>date('Y/m/d H:i:s'),
);
$this->db->insert('data_histori_pekerjaan',$data);
}
public function riwayat_pekerjaan(){
$this->load->view('umum/V_header');
$this->load->view('user2/V_riwayat_pekerjaan');
}
public function json_data_riwayat(){
echo $this->M_user2->json_data_riwayat();       
}
public function json_data_berkas_client($no_client){
echo $this->M_user2->json_data_berkas_client($no_client);  
}

public function json_data_lampiran_client($no_client){
echo $this->M_user2->json_data_lampiran_client($no_client);  
}

public function lihat_berkas_client(){    
$data_client = $this->M_user2->data_client_where($this->uri->segment(3));       

$this->load->view('umum/V_header');
$this->load->view('user2/V_lihat_berkas_client',['data_client'=>$data_client]);   
}
public function lihat_lampiran_client(){    
$data_client = $this->M_user2->data_client_where($this->uri->segment(3));       

$this->load->view('umum/V_header');
$this->load->view('user2/V_lihat_lampiran_client',['data_client'=>$data_client]);   
}

public function proses_ulang(){
if($this->input->post()){
$data = array(
'status_pekerjaan' =>'Proses'    
);
$this->db->update('data_pekerjaan',$data,array('id_data_pekerjaan'=>$this->input->post('id_data_pekerjaan')));
$status[] = array(
"status"     => "success",
"messages"      => "Pekerjaan berhasil dimasukan kedalam tahap proses"    
);
echo json_encode($status);
}else{
redirect(404);    
}    
}
public function lihat_informasi(){
if($this->input->post()){
$input = $this->input->post();    
$query = $this->db->get_where('data_informasi_pekerjaan',array('id_data_informasi_pekerjaan'=>$input['id_data_informasi_pekerjaan']))->row_array();
echo $query['data_informasi'];
}else{
redirect(404);    
}
}
public function set_toggled(){
if(!$this->session->userdata('toggled')){
$array = array(
'toggled' => 'Aktif',    
);
$this->session->set_userdata($array);    
}else{
unset($_SESSION['toggled']);   
}
echo print_r($this->session->userdata()); 
}
public function print_persyaratan() {
 $data = array(
        "dataku" => array(
            "nama" => "Petani Kode",
            "url" => "http://petanikode.com"
        )
    );
    $this->load->library('pdf');
    $this->pdf->setPaper('A4', 'potrait');
    $this->pdf->filename = "laporan-petanikode.pdf";
    $this->pdf->load_view('laporan_pdf', $data);
    
}
public function buat_pemilik_perekaman(){
if($this->input->post()){
$tot_pemilik   = $this->M_user2->data_pemilik()->row_array();
$no_pemilik    = "PK".str_pad($tot_pemilik['id_data_pemilik'],6 ,"0",STR_PAD_LEFT);
$input = $this->input->post();
if(!$input['no_client']){
$status = array(
"status"     => "error",
"pesan"      => "Tentukan pemilik dokumen terlebih dahulu"    
);
echo json_encode($status);    
}else{
$cek = $this->db->get_where('data_pemilik',array('no_client'=>$input['no_client'],'no_pekerjaan'=>base64_decode($input['no_pekerjaan'])));
if($cek->num_rows() == 1){
$status = array(
"status"     => "error",
"pesan"      => "Tidak Boleh Ada Nama Badan Hukum atau perorangan sama dalam satu jenis pekerjaan"    
);
echo json_encode($status);
    
}else{
$data = array(
'no_pemilik'    =>$no_pemilik,   
'no_client'     =>$input['no_client'],
'no_pekerjaan'  => base64_decode($input['no_pekerjaan'])    
);
$this->db->insert('data_pemilik',$data);
$status = array(
"status"     => "success",
"pesan"      => "Pemilik Dokumen Berhasil ditambahkan"    
);
echo json_encode($status);
}
}
}else{
redirect(404);    
}
}
public function tampilkan_data_client(){
if($this->input->post()){
$input = $this->input->post();
$data = $this->M_user2->data_pemilik_where(base64_decode($input['no_pekerjaan']));
echo "<div class='container'><div class='row'>"
. "<div class='col-md-6 card-header'>Nama Badan Hukum / Perorangan</div>"
. "<div class='col card-header'>Pembuat client</div>"
. "<div class='col card-header'>Data Terekam</div>"
. "<div class='col-md-1 card-header'>Aksi</div>"
. "</div>";
foreach ($data->result_array() as $d){
echo "<div class='row'>"
. "<div class='col-md-6 mt-2'>".$d['nama_client']."</div>"
. "<div class='col mt-2'>".$d['pembuat_client']."</div>"
. "<div class='col mt-2'><button onclick=data_perekaman_user('".$d['no_client']."'); class='btn btn-block btn-success btn-sm'>Proses Perekaman <span class='fa fa-retweet'></span></button></div>"
. "<div class='col-md-1 mt-2'><button onclick = hapus_pemilik('".$d['no_pemilik']."'); class='btn btn-danger btn-block btn-sm'><span class='fa fa-trash'></span></button></div>"
. "</div>";     
}
echo "</div>";
}else{
redirect(404);    
}    
}
public function hapus_pemilik(){
if($this->input->post()){
$this->db->delete('data_pemilik',array('no_pemilik'=> $this->input->post('no_pemilik')));
$status = array(
"status"     => "success",
"pesan"      => "Data perekaman terhapus"    
);
echo json_encode($status);
}else{
redirect(404);    
}    
}
public function lihat_data_meta(){
$no_pekerjaan = $this->input->post();
$data_client = $this->M_user2->data_berkas_where_no_pekerjaan(base64_decode($no_pekerjaan['no_pekerjaan']));
echo "<input type='hidden' value='".$no_pekerjaan['no_pekerjaan']."' id='no_pekerjaan' class='form-control'>";
echo "<label>Pilih data client yang ingin ditampilkan</label>";
echo "<select onchange='tampilkan_data()' class='form-control form-control-sm' id='no_client'>"
. "<option>Pilih client yang ingin ditampilkan</option>";
foreach ($data_client->result_array() as $data){
echo "<option value='".$data['no_client']."'>".$data['nama_client']."</option>";   
}
echo "</select><hr>";
echo "<div class='tampilkan_data overflow-auto' style='max-height:380px;'></div>";
}
public function buat_client(){
if($this->input->post()){
$data = $this->input->post();
if($data['jenis_client'] == "Perorangan"){
$this->client_baru($data);
}else if($data['jenis_client'] == "Badan Hukum"){
$cek_badan_hukum = $this->db->get_where('data_client',array('nama_client'=>strtoupper($data['badan_hukum'])))->num_rows();        
if($cek_badan_hukum == 0){
$this->client_baru($data);
}else{
$status = array(
"status"     => "error",
"pesan"      => "Nama Badan Hukum sudah tersedia"    
);    
echo json_encode($status);
}
}
}else{
redirect(404);    
}
}
public function client_baru($data){
$h_client = $this->M_user2->data_client()->num_rows()+1;
$no_client    = "C".str_pad($h_client,6 ,"0",STR_PAD_LEFT);
$data_client = array(
'no_client'                 => $no_client,    
'jenis_client'              => ucwords($data['jenis_client']),    
'nama_client'               => strtoupper($data['badan_hukum']),
'alamat_client'             => ucwords($data['alamat_badan_hukum']),    
'tanggal_daftar'            => date('Y/m/d'),    
'pembuat_client'            => $this->session->userdata('nama_lengkap'),    
'no_user'                   => $this->session->userdata('no_user'), 
'nama_folder'               =>"Dok".$no_client,
'contact_person'            => ucwords($data['contact_person']),    
'contact_number'            => ucwords($data['contact_number']),    
);    
$this->db->insert('data_client',$data_client);
if(!file_exists("berkas/"."Dok".$no_client)){
mkdir("berkas/"."Dok".$no_client,0777);
}
$status = array(
"status"     => "success",
"pesan"      => "Client Berhasil ditambahkan"    
);
echo json_encode($status);
    
}
public function simpan_perizinan(){
if($this->input->post()){
$input = $this->input->post();
$cek_dokumen = $this->db->get_where('data_berkas_perizinan',array('no_nama_dokumen'=>$input['no_nama_dokumen'],'no_pekerjaan'=>$input['no_pekerjaan'],'no_client'=>$input['no_client']));
if($cek_dokumen->num_rows() == 1){
$status[] = array(
"status"     => "error",
"messages"   => "Perizinan tersebut sudah dibuat sebelumnya"    
);
    
}else{    
                        $this->db->limit(1);
                        $this->db->order_by('data_berkas_perizinan.no_berkas_perizinan','DESC');
$total_berkas           = $this->db->get('data_berkas_perizinan')->row_array();

if(isset($total_berkas['no_berkas_perizinan'])){
    $urutan = (int) substr($total_berkas['no_berkas_perizinan'],3)+1;
}else{
    $urutan =1;
}

$no_berkas_perizinan    = "PRZ".str_pad($urutan,6,"0",STR_PAD_LEFT);
$data = array(
'no_berkas_perizinan'      => $no_berkas_perizinan,  
'no_nama_dokumen'          => $input['no_nama_dokumen'],
'no_pekerjaan'             => $input['no_pekerjaan'],
'no_client'                => $input['no_client'],   
'no_user_perizinan'        => $input['no_petugas'],
'no_user_penugas'          => $this->session->userdata('no_user'),
'tanggal_penugasan'        => date('Y/m/d'),    
'status_lihat'             =>NULL,
'status_berkas'            =>'Masuk',
'target_selesai_perizinan' =>NULL    
);
$this->M_user2->simpan_perizinan($data);
$status[] = array(
"status"     => "success",
"messages"      => "Perizinan berhasil ditambahkan"    
);
}
echo json_encode($status);
}else{
redirect(404);    
}
    
}
public function hapus_perizinan(){
if($this->input->post()){
$this->db->delete('data_berkas_perizinan',array('no_berkas_perizinan'=>$this->input->post('no_berkas_perizinan')));    
$status[] = array(
"status"     => "success",
"messages"   => "Perizinan berhasil dihapus"    
);
echo json_encode($status);
}else{
redirect(404);    
}    
}
public function modal_alihkan_tugas(){
$input = $this->input->post();
$data_user = $this->M_user2->data_user_perizinan('Level 3');
echo "<label>Alihkan Tugas</label>"
. "<select onchange=tentukan_pengurus('".$input['no_berkas_perizinan']."','".$input['no_pekerjaan']."','".$input['no_client']."','".$input['no_pemilik']."'); class='form-control tentukan_pengurus".$input['no_berkas_perizinan']." data_nama_dokumen form-control-sm'>";
foreach ($data_user->result_array() as $u){        
echo "<option value=".$u['no_user'].">".$u['nama_lengkap']."</option>";
}                
echo "</select>";
}
public function simpan_petugas_perizinan(){
if($this->input->post()){
$input = $this->input->post();
$data = array(
    'no_user_perizinan'  => $input['no_user'],
    'tanggal_penugasan'  => date('Y/m/d'),
    'target_selesai_perizinan'  => NULL,
    'status_berkas'      => 'Masuk',
    'status_lihat'       => NULL
);
$this->db->update('data_berkas_perizinan',$data,array('no_berkas_perizinan'=>$input['no_berkas_perizinan']));
$status[] = array(
"status"        => "success",
"messages"      => "Pengalihan perizinan berhasil"    
);      
echo json_encode($status);
}else{
redirect(404);    
}
    
}
public function data_pencarian(){
if($this->input->post()){
$input = $this->input->post();
$data_dokumen         = $this->M_user2->pencarian_data_dokumen($input['kata_kunci']);
$data_client          = $this->M_user2->pencarian_data_client($input['kata_kunci']);
$dokumen_utama        = $this->M_user2->pencarian_data_dokumen_utama($input['kata_kunci']);
if($data_dokumen->num_rows() == 0){
$json_data_dokumen[] = array(
"Tidak ditemukan data dokumen"    
);
    
}else{   
foreach ($data_dokumen->result_array()as $d){
$json_data_dokumen[] = array(    
$d['value_meta']
);
}
}
if($data_client->num_rows() == 0){
$json_data_client[] = array(
"Tidak ditemukan data client"
);    
}else{
foreach ($data_client->result_array()as $data_client){
$json_data_client[] = array(
$data_client['nama_client']    
);
}
}
if($dokumen_utama->num_rows() == 0){
$data_dokumen_utama[] = array(
"Tidak ditemukan dokumen utama"
);    
}else{
foreach ($dokumen_utama->result_array()as $dokut){
$data_dokumen_utama[] = array(
$dokut['nama_berkas']    
);
}
}
$data = array(
 'data_dokumen'         => $json_data_dokumen,
 'data_client'          => $json_data_client,  
 'data_dokumen_utama'   => $data_dokumen_utama   
);
echo json_encode($data);
}else{
redirect(404);    
}
}
public function cek_download_berkas(){
if($this->input->post()){
$input =  $this->input->post();    
$this->db->select('data_berkas.nama_berkas,'
        . 'data_client.nama_folder');    
$this->db->from('data_berkas');
$this->db->join('data_client', 'data_client.no_client = data_berkas.no_client');
$this->db->where('data_berkas.no_berkas', base64_decode($input['no_berkas']));
$query= $this->db->get()->row_array();    
if($query['nama_berkas'] == NULL){
$status = array(
"status"     => "warning",
"pesan"      => "Lampiran file tidak dimasukan hanya meta data"    
);    
}else if(!file_exists('./berkas/'.$query['nama_folder']."/".$query['nama_berkas'])){
$status = array(
"status"     => "error",
"pesan"      => "File tidak tersedia"    
);      
}else{
$status = array(
"status"     => "success",
);      
}
echo json_encode($status);
}else{
redirect(404);    
}
}
public function data_perekaman_pencarian(){
if($this->input->post()){
$input              = $this->input->post();
$DokumenPenunjang   = $this->M_user2->DokumenPenunjang($input['no_berkas']);
$data = $DokumenPenunjang->row_array();
echo '<div class="modal-content ">
<div class="modal-header bg-info">
<h6 class="modal-title text-white" id="exampleModalLabel text-center">'.$data['nama_dokumen'].'<span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">';
echo "<table class='table table-hover table-sm table-stripped table-bordered'>";
echo "<tr><td class='text-center' colspan='2'>".$data['nama_client']."</td></tr>";
foreach($DokumenPenunjang->result_array() as $d){
echo "<tr><td>".str_replace('_', ' ',$d['nama_meta'])."</td>";    
echo "<td>".$d['value_meta']."</td></tr>";    
}
echo"</table></div>";
echo"<div class='card-footer'>";
$ext = pathinfo($data['nama_berkas'], PATHINFO_EXTENSION);
if($ext =="docx" || $ext =="doc" ){
echo "<button onclick=cek_download_berkas('".base64_encode($data['no_berkas'])."') class='btn btn-success btn-sm mx-auto btn-block '>Lihat Dokumen <i class='fa fa-eye'></i></button>";
}else if($ext == "xlx"  || $ext == "xlsx"){
echo "<button onclick=cek_download_berkas('".base64_encode($data['no_berkas'])."') class='btn btn-success btn-sm mx-auto btn-block '>Lihat Dokumen <i class='fa fa-eye'></i></button>";
}else if($ext == "PDF"  || $ext == "pdf"){
echo "<button onclick=lihat_pdf('".$data['nama_folder']."','".$data['nama_berkas']."'); class='btn btn-success btn-sm mx-auto btn-block '>Lihat Dokumen <i class='fa fa-eye'></i></button>";
}else if($ext == "JPG"  || $ext == "jpg" || $ext == "png"  || $ext == "PNG"){
echo "<button onclick=lihat_gambar('".$data['nama_folder']."','".$data['nama_berkas']."');  class='btn btn-success btn-sm mx-auto btn-block '>Lihat File <i class='fa fa-eye'></i></button>";
}else{
echo "<button  onclick=cek_download_berkas('".base64_encode($data['no_berkas'])."') class='btn btn-success btn-sm mx-auto btn-block '>Lihat File <i class='fa fa-eye'></i></button>";
}
echo "</div></div>";

}else{
redirect(404);    
}
}
public function data_perekaman_user_client(){
if($this->input->post()){
$input = $this->input->post();    
$data_berkas  = $this->M_user2->data_telah_dilampirkan(base64_decode($input['no_client']));
foreach ($data_berkas->result_array() as $u){  
echo'<div class=" m-1">
<div class="row">
<div class="col ">'.$u['nama_dokumen'].'</div> 
<div class="col-md-4  text-right">
<button type="button" onclick=lihat_meta_berkas("'.base64_encode($u['no_nama_dokumen']).'","'.$input['no_client'].'") class="btn btn-sm btn-outline-dark btn-block">Lihat data <span class="fa fa-eye"></span></button>';
echo "</div>    
</div>
</div>";
}
}
else{
redirect(404);    
}
}
public function tampilkan_data(){
if($this->input->post()){
$input = $this->input->post();
$data_berkas = $this->M_user2->data_berkas_where_no_client($input['no_client']);
foreach ($data_berkas->result_array() as $d){
 
$query      = $this->M_user2->data_perekaman($d['no_nama_dokumen'],$d['no_client']);
$query2     = $this->M_user2->data_perekaman2($d['no_nama_dokumen'],$d['no_client']);
$cols = $query->num_rows()+1;
echo "<table class='table table-sm table-striped table-bordered'>";
echo "<thead>
    <tr><th class='text-center' colspan='".$cols."'>".$d['nama_dokumen']."</th></tr>";
echo  "<tr>";
foreach ($query->result_array() as $d){
echo "<th>".str_replace('_', ' ',$d['nama_meta'])."</th>";
}
echo "<th style='width:50px;'>Aksi</th>";
echo "</tr>"
. "</thead>";
echo "<tbody>";
foreach ($query2->result_array() as $d){
$b = $this->db->get_where('data_meta_berkas',array('no_berkas'=>$d['no_berkas']));
echo "<tr id='".$d['no_berkas']."'>";
foreach ($b->result_array() as $i){
echo "<td >".$i['value_meta']."</td>";    
}
echo '<td class="text-center">'
.'<button data-clipboard-action="copy" data-clipboard-target="#'.$d['no_berkas'].'" class="btn btn_copy btn-success btn-sm" title="Copy data ini" ><i class="far fa-copy"></i></button>';
        echo '</td>';
echo "</tr>";
    
    
}
echo "</tbody>";
echo"</table>";      
    
}
}else{
redirect(404);    
}
}
function simpan_pihak_terlibat(){
    $input          = $this->input->post();
    $cek            = $this->db->get_where('data_pemilik',array('no_client'=>$input['no_client'],'no_pekerjaan'=>base64_decode($input['no_pekerjaan'])));
    if($cek->num_rows() > 0){
    $status[] =array(
    'status'    => 'error',
    'messages'  => 'Pihak terkait sudah ditambahkan' 
    ); 
    echo json_encode($status);    
    }else{
    $data_pem = array(
    'no_client'     =>$input['no_client'],
    'no_pekerjaan'  => base64_decode($input['no_pekerjaan'])   
    );
    $this->db->insert('data_pemilik',$data_pem);
    $status[] =array(
    'status'    => 'success',
    'messages'  => 'Pihak terkait berhasil ditambahkan' 
    ); 
    echo json_encode($status);    
    }
    }   

    function form_persyaratan(){
        if($this->input->post()){    
        $input                    = $this->input->post();

        $data_lampiran            = $this->M_user2->data_lampiran_client($input['no_client']);
        $data_client              = $this->M_user2->data_client_where($input['no_client'])->row_array();
        $syarat_minimal           =  $this->M_user2->nama_persyaratan($input['no_pekerjaan'],$data_client['jenis_client']);
        $syarat_pekerjaan           =  $this->M_user2->nama_persyaratan_pekerjaan($input['no_pekerjaan'],$data_client['jenis_client']);
        echo '
        <div class="modal-header bg-info">
        <h6 class="modal-title text-white" id="exampleModalLabel">Upload Dokumen Penunjang Milik '.ucwords(strtolower($data_client['nama_client'])).'  <span class="i"><span></h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body overflow-auto"  style="max-height:500px;">';
        
        echo "<div class='row'>";
       
        echo "<div class='col-md-3 p-0'>
        <table class='table table-striped table-hover p-1'>
        <th colspan='2' class='text-center '>Syarat  Pekerjaan</th></tr>";
        
        foreach($syarat_minimal->result_array() as $s){
             $cek = $this->db->get_where('data_berkas',array('no_pekerjaan'=>$input['no_pekerjaan'],'no_client'=>$input['no_client'],'no_nama_dokumen'=>$s['no_nama_dokumen'],));

            echo '<tr>
            <td>'.$s['nama_dokumen'].' </td>
            <td class="text-success">
            ';if($cek->num_rows() >0){
                echo '<svg  width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-check2-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M15.354 2.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L8 9.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                <path fill-rule="evenodd" d="M1.5 13A1.5 1.5 0 0 0 3 14.5h10a1.5 1.5 0 0 0 1.5-1.5V8a.5.5 0 0 0-1 0v5a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V3a.5.5 0 0 1 .5-.5h8a.5.5 0 0 0 0-1H3A1.5 1.5 0 0 0 1.5 3v10z"/>
              </svg>';
               
            }   
            echo '</td>
            </tr>';      
        }

        foreach($syarat_pekerjaan->result_array() as $p){
            $cek = $this->db->get_where('data_berkas',array('no_nama_dokumen'=>$p['no_nama_dokumen'],'no_pekerjaan'=>$input['no_pekerjaan'],'no_client'=>$input['no_client'],));

           echo '<tr>
           <td>'.$p['nama_dokumen'].' </td>
           <td class="text-success">
           ';if($cek->num_rows() >0){
               echo '<svg  width="1.5em" height="1.5em" viewBox="0 0 16 16" class="bi bi-check2-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
               <path fill-rule="evenodd" d="M15.354 2.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3-3a.5.5 0 1 1 .708-.708L8 9.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
               <path fill-rule="evenodd" d="M1.5 13A1.5 1.5 0 0 0 3 14.5h10a1.5 1.5 0 0 0 1.5-1.5V8a.5.5 0 0 0-1 0v5a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5V3a.5.5 0 0 1 .5-.5h8a.5.5 0 0 0 0-1H3A1.5 1.5 0 0 0 1.5 3v10z"/>
             </svg>';
              
           }   
           echo '</td>
           </tr>';      
       }


        echo "</table>
        </div>";

        echo"<div class='col-md-6 pr-1 pl-1'>"
        ."<form  class=' ' id='form_berkas'>"
        ."<input type='hidden' class='no_client' name='no_client'    value='".$input['no_client']."'>"
        ."<input type='hidden' class='no_pekerjaan' name='no_pekerjaan' value='".$input['no_pekerjaan']."'>";
        
        echo '<div class="input-group" style="display:none;">
          <div class="custom-file">
            <input onchange="upload_file()" type="file" class="custom-file-input"  id="file_berkas" name="file_berkas[]" multiple aria-describedby="file_berkas">
            <label class="custom-file-label" for="file_berkas">Pilih Dokumen Penunjang</label>
          </div>
         </div>';
        echo"</form>";
        
        echo '<div class="data_terupload"></div></div>';
       
        
        echo  "<div class='col-md-3  p-0'>
        <div class='justify-content-start'>
        <table class='table table-striped table-hover'>
        <th colspan='2' class='text-center '>Dokumen Perusahaan</th></tr>";
        if($data_lampiran->num_rows() >0){
        foreach($data_lampiran->result_array() as $data){
        echo "<tr class='data".$data['no_berkas']."' onclick=FormLihatMeta('".$data['no_berkas']."','".$data['nama_folder']."','".$data['nama_berkas']."') class='text-info'>";
        echo "<td colspan='2'  >".$data['nama_dokumen']."</td></tr>";
        }
        echo "<tr id='LihatSemua'><td><button onclick=LihatSemuaDokumen('".$input['no_client']."'); class='btn btn-md btn-info btn-block text-white'>Lihat Semua Dokumen <span class='fa fa-eye'></span></button></td></tr>";
        }else{
        echo "<tr ><td colspan='2' align='center' colspan='2'>Dokumen Perusahaan Tidak Tersedia</td></tr>";
        echo "<tr id='LihatSemua'><td colspan='2'><button onclick=LihatSemuaDokumen('".$input['no_client']."'); class='btn btn-md btn-info btn-block text-white'>Lihat Semua Dokumen <span class='fa fa-eye'></span></button></td></tr>";
        }
        
        echo "</table>
        </div>
        </div>";
        echo  "</div>";
        echo '</div>';
        echo "</div>";
        echo'</div>';   
        }else{
        redirect(404);    
        }
        }

public function data_terupload(){
    if($this->input->post()){    
    $input              = $this->input->post();  
    $data_upload        = $this->db->get_where('data_berkas',array('no_client'=>$input['no_client'],'no_pekerjaan'=> $input['no_pekerjaan'],'status_berkas !='=>'selesai'));
    $data_client        = $this->M_user2->data_client_where($input['no_client'])->row_array();
                         
    echo "<table class='table table-striped table-hover p-0'>
        <th  class='text-center '>Penunjang</th>
        <th  class='text-center '>Jenis</th>
        <th  class='text-center '>Aksi</th>
        </tr>";
    if($data_upload->num_rows() != 0){   
    foreach ($data_upload->result_array() as $data){
    echo "<tr>";
    echo "<td style='width:20%;'>".substr($data['nama_berkas'],0,10)."</td>";
    echo "<td>"
    . "<select onchange=set_jenis_dokumen('".$input['no_client']."','".$input['no_pekerjaan']."','".$data['no_berkas']."') class='form-control nama_dokumen  form-control-md no_berkas".$data['no_berkas']."'>";
    echo "<option></option>";
    echo "</select></td>";
    echo '<td style="width:20%;">';
    echo '<button  onclick=hapus_berkas_persyaratan("'.$data['no_berkas'].'"); class="btn btn-md mx-auto  btn-danger  btnhapus'.$data['no_berkas'].'"  title="Hapus data ini" ><i class="fa fa-trash"></i></button>';
    echo '<button  onclick=LihatLampiran("'.$data_client['nama_folder'].'","'.$data['nama_berkas'].'"); class="btn btn-md  btn-info   title="Lihat File" ><i class="fa fa-eye"></i></button>';
    echo '</td>';
    echo "</tr>";    
    }
    
    }else{
    echo "<tr><td colspan='3' align='center'>Belum Terdapat Dokumen Penunjang<br>Silahkan pilih dokumen penunjang terlebih dahulu</tr></td>";    
    }
    echo '<tr>
    <td colspan="3">
 
    <button onclick=TambahkanFile();  class="btn btn-md btn-info text-white btn-block">Tambahkan Dokumen Penunjang <span class="fa fa-plus"></span></button> 
    <div class="progress mt-2" style="display:none;"> 
        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="22" aria-valuemax="100" style="width: 0%"><span class="persen"></span></div> </td>
        </div>
        
        </tr>';
   
    }else{
    redirect(404);    
    }        
    }

    function FormLihatMeta(){
        if($this->input->post()){ 
        $input = $this->input->post();  
        $data_meta = $this->db->get_where('data_meta_berkas',array('no_berkas'=>$input['no_berkas']));    
        echo "<div class='row  data_edit".$input['no_berkas']."'>"
        . "<div class='col-12 text-white text-center'>"
        . "<div class='text-left boder-bottom text-dark'>";
        
        foreach ($data_meta->result_array()  as $d ){
        echo "<div class='row mt-1'>"
        ."<div class='col-7'>".str_replace('_', ' ',$d['nama_meta'])."</div>" 
        ."<div class='col'>: ".$d['value_meta'] ."</div></div>";   
        }
        
        echo "</div><hr>"
        ."<button type='button' onclick=hapus_berkas_persyaratan('".$input['no_berkas']."') class='btn  btn-md col-3 btn-danger m-1  '> <i class='fa fa-trash'></i></button>"
        ."<button type='button' onclick=LihatLampiran('".$input['nama_folder']."','".$input['nama_berkas']."') class='btn  btn-md col-3 btn-dark m-1'> <i class='fa fa-eye'></i></button>"
        ."<button type='button' onclick=ShareDokumen('".$input['no_berkas']."') class='btn  btn-md col-3 btn-primary m-1'> <i class='fa fa-share-alt'></i></button>"
        ."</div>
        </div>";
        
        }else{
        redirect(404);
        }    
}
public function DataClientShare(){
    if($this->input->post()){
    $input = $this->input->post();
    $this->db->select('data_client.nama_client,
    data_client.no_client,
    data_jenis_pekerjaan.nama_jenis,
    data_pekerjaan.no_pekerjaan');
    $this->db->from('data_pekerjaan');
    $this->db->join('data_client','data_client.no_client = data_pekerjaan.no_client');
    $this->db->join('data_jenis_pekerjaan','data_jenis_pekerjaan.no_jenis_pekerjaan = data_pekerjaan.no_jenis_pekerjaan');
    $this->db->where('data_pekerjaan.no_client',$input['no_client']);
    $query = $this->db->get(); 
    
    echo '<div class="modal-content ">
    <div class="modal-header bg-dark">
    <h6 class="modal-title text-white" id="exampleModalLabel text-center ">Pilih Jenis Pekerjaan <span class="i"><span></h6>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body">
    <form id="PihakTerlibat">';
    foreach($query->result_array() as $d){
      if($input['no_pekerjaan'] == $d['no_pekerjaan']){      
            echo'<div class="form-check form-check border-bottom mb-4">
            <input class="form-check-input" name="pihak"  type="checkbox" id="'.$d['nama_jenis'].'" value="'.$d['no_pekerjaan'].'">
            <label class="form-check-label" for="'.$d['nama_jenis'].'">'.$d['nama_jenis'].'</label>
           </div>';
      }
    }     
            
    
    echo "</form></div>";
    
    echo "<div class='modal-footer'>
    <button type='button' onclick=ProsesBagikan('".$input['no_berkas']."','".$input['no_pekerjaan']."'); class='btn btn-info btn-md btn-block'>Bagikan <span class='fa fa-share-alt'></span></button>
    </div>";
    echo"</div></div>";
    }else{
    redirect(404);        
    }        
    }

    
    function form_edit_client(){
        if($this->input->post()){    
        
        $input              = $this->input->post(); 
        $data_kontak        = $this->M_user2->data_kontak_client($input['no_client']);
        $data_client        = $this->M_user2->data_client_where($input['no_client'])->row_array();
        
        echo '<div class="modal-content">
        <div class="modal-header bg-info">
        <h6 class="modal-title text-white" >Detail Client '.ucwords(strtolower($data_client['nama_client'])).' <span id="title"></span> </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body " >
        <div class="row">
        <div class="col-md-4">';
        echo'<form id="form_update_client">
        <input type="hidden" name="'.$this->security->get_csrf_token_name().'"value="'.$this->security->get_csrf_hash().'" readonly="" class="form-control required"  accept="text/plain">
        <input type="hidden" name="no_client" value="'.$data_client['no_client'].'" readonly="" class="form-control required"  accept="text/plain">
        <label>Pilih Jenis client</label>
        <select name="jenis_client" id="jenis_client" class="form-control required" accept="text/plain">
        <option></option>
        <option ';if($data_client['jenis_client'] == "Perorangan"){echo "selected ";} echo' value="Perorangan">Perorangan</option>
        <option ';if($data_client['jenis_client'] == "Badan Hukum"){echo "selected ";}echo 'value="Badan Hukum">Badan Hukum</option>	
        </select>    
        
        <label  id="label_nama_perorangan">Nama </label>
        <input type="text" value="'.$data_client['nama_client'].'" placeholder="Nama" name="badan_hukum" id="badan_hukum" class="form-control  required"  accept="text/plain">
        
        <label  id="label_nama_perorangan">No Identitas </label>
        <input type="text" value="'.$data_client['no_identitas'].'" placeholder="No Identitas" name="no_identitas" id="no_identitas" class="form-control  required"  accept="text/plain">
        
        <label  id="label_alamat_perorangan">Alamat </label>
        <textarea  rows="6" placeholder="Alamat" name="alamat" id="alamat" class="form-control  required" required="" accept="text/plain">'.$data_client['alamat_client'].'</textarea>
        
        <label >Nomor Kontak '.$data_client['jenis_client'].' </label>
        <input type="text" value="'.$data_client['contact_number'].'" placeholder="contact number" name="contact_number" id="contact_number" class="form-control  required"  accept="text/plain">
        
        <label >Email Client '.$data_client['jenis_client'].' </label>
        <input type="text" value="'.$data_client['email'].'" placeholder="Email" name="email" id="email" class="form-control  required"  accept="text/plain">
        
        </div>';
        
        echo "<div class='col'>";
        
        echo '<table class="table  table-striped">
        <thead>
            <tr><td align="center" colspan="5">Data Kontak</td></tr>   
           <tr>
           <th>Nama</th>
           <th>Jabatan</th>
           <th>Email</th>
           <th>No Kontak</th>
           </tr>
        </thead>
        <tbody>';
        
        foreach ($data_kontak->result_array() as $d){
                    echo "<tr>"
                    . "<td>".$d['nama_kontak']."</td>"
                    . "<td>".$d['jabatan']."</td>"
                    . "<td>".$d['email']."</td>"
                    . "<td>".$d['no_kontak']."</td>"
                   . "</tr>";
        }
        echo "</tbody></table>";
        echo "</div></div>";
        echo "</div>"
        . "<div class='modal-footer'>"
        . "<button onclick=update_client(); class='btn btn-md btn-dark update_client btn-block'>Simpan Perubahan <span class='fa fa-save'</button></form>"
        . "</div>"
        . "</div>";
        
        }else{
        redirect(404);  
        }
        }

        public function update_client(){
            if($this->input->post()){    
            $input = $this->input->post();
            $this->form_validation->set_rules('jenis_client', 'Jenis Client', 'required');
            $this->form_validation->set_rules('badan_hukum', 'Badan Hukum', 'required');
            if ($this->form_validation->run() == FALSE){
            $status_input = $this->form_validation->error_array();
            $status[] = array(
            'status'  => 'error_validasi',
            'messages'=>array($status_input),    
            );
            echo json_encode($status);
            }else{
            $data = array(
            'jenis_client'          =>$input['jenis_client'],
            'nama_client'           =>$input['badan_hukum'],
            'alamat_client'         =>$input['alamat'],    
            'contact_number'        =>$input['contact_number'],    
            'email'                 =>$input['email']    
            );    
            $this->db->where('no_client',$input['no_client']);
            $this->db->update('data_client',$data);
            $status[] = array(
            'status'  => 'success',
            'messages'=> "Klien ".$input['badan_hukum']." Berhasil diupdate",    
            );
            echo json_encode($status);
            }
            }else{
            redirect(404);  
            }
            }

function update_pekerjaan(){
if($this->input->post()){
$input = $this->input->post();
$this->form_validation->set_rules('jenis_pekerjaan', 'Jenis pekerjaan ', 'required',array('required' => 'Data ini tidak boleh kosong'));
if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);
echo json_encode($status);
}else{
$data = array(
'no_jenis_pekerjaan' =>$input['jenis_pekerjaan']
); 
$this->db->where('no_pekerjaan', base64_decode($input['no_pekerjaan']));
$this->db->update('data_pekerjaan',$data);
$status[] = array(
'status'  => 'success',
'messages'=> "anda berhasil merubah pekerjaan",    
);
echo json_encode($status);
}    
}else{
    echo print_r($this->input->post());
    //redirect(404);    
}    
}
function form_data_perizinan(){
if($this->input->post()){
$input              = $this->input->post();
$data_client        = $this->M_user2->data_client_where($input['no_client'])->row_array();    
$data_user          = $this->M_user2->data_user_perizinan('Level 3');
$data               = $this->M_user2->data_perizinan($input['no_pekerjaan'],$input['no_client']);

echo '<div class="modal-content">
<div class="modal-header bg-info">
<h6 class="modal-title text-white" >Halaman Membuat Dokumen Penunjang '.ucwords(strtolower($data_client['nama_client'])).' <span id="title"></span> </h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body " >';
echo "<div class='row card-header'>"
. "<div class='col'><label>Nama Dokumen</label>"
        . "<select class='form-control data_nama_dokumen  nama_dokumen'>";
                    
        echo "</select>"
        . "</div>"
. "<div class='col'><label>Nama Petugas</label>"
        . "<select class='form-control data_nama_petugas '>";
       foreach ($data_user->result_array() as $u){        
        echo "<option value=".$u['no_user'].">".$u['nama_lengkap']."</option>";
        }                
        
        echo  "</select>"
        . "</div>"
        . "<div class='col'><label>Aksi</label>"
        . "<button onclick=simpan_perizinan('".base64_decode($input['no_pekerjaan'])."','".$input['no_client']."'); class='btn btn-md btn-dark btn-block'>Simpan Pembuatan Penunjang <span class='fa fa-save'></span></button>"
        . "</div>"
. "</div><hr>";
   
echo "<div class='row card-header  '>"
        . "<div class='col-md-4'>Nama Dokumen</div>"
        . "<div class='col-md-1'>Status</div>"
        . "<div class='col-md-2'>Target selesai</div>"
        . "<div class='col-md-2'>Pengurus</div>"
        . "<div class='col-md-3 text-center'>Aksi</div>"
        . "</div>";
foreach ($data->result_array() as $form){
echo "<div class='row'>"
    . "<div class='col-md-4 mt-2'>".$form['nama_dokumen']."</div>"
    . "<div class='col-md-1 mt-2'>".$form['status_berkas']."</div>"
    . "<div class='col-md-2 mt-2'>";
   if( $form['target_selesai_perizinan'] == NULL ){
   
echo "<b><span class='text-dark'>Belum tersedia</span></b>";    
   }else if(  $form['target_selesai_perizinan'] == date('Y/m/d')){
echo "<b><span class='text-warning'>Hari ini</span></b>";    
}else if(  $form['target_selesai_perizinan'] <= date('Y/m/d')){
$startTimeStamp = strtotime(date('Y/m/d'));
$endTimeStamp = strtotime(  $form['target_selesai_perizinan']);
$timeDiff = abs($endTimeStamp - $startTimeStamp);
$numberDays = $timeDiff/86400; 
$numberDays = intval($numberDays);
echo "<b><span class='text-danger'> Terlewat ".$numberDays." Hari </span></b>" ;
}else{
$startTimeStamp = strtotime(date('Y/m/d'));
$endTimeStamp = strtotime($form['target_selesai_perizinan']);
$timeDiff = abs($endTimeStamp - $startTimeStamp);
$numberDays = $timeDiff/86400; 
$numberDays = intval($numberDays);
echo "<b><span class='text-success'>".$numberDays." Hari lagi </span></b>" ;
}    
           echo "</div>"
    . "<div class='col-md-2 mt-2' id='".$form['no_berkas_perizinan']."'>".$form['nama_lengkap']."</div>"
    . "<div class='col-md-3 mt-2 text-center'>"
    . "<button onclick=hapus_perizinan('".$form['no_berkas_perizinan']."','".$input['no_client']."','".$input['no_pekerjaan']."'); class='btn btn-sm ml-1 btn-danger' title='Hapus perizinan'> <i class='fas fa-trash'></i></button>"
    . "<button onclick=alihkan_perizinan('".$form['no_berkas_perizinan']."','".$input['no_client']."','".$input['no_pekerjaan']."'); class='btn btn-sm ml-1 btn-warning' title='Alihkan perizinan'> <i class='fas fa-exchange-alt'></i></button>"
    . "<button onclick=lihat_laporan_perizinan('".$form['no_berkas_perizinan']."'); class='btn btn-sm ml-1  btn-success' title='Lihat laporan perizinan'> <i class='fas fa-eye'></i></button>"
    . "</div>"
    . "</div>";
    
}
echo "</div>"
. "</div>";
    
}else{
    redirect(404);    
}    
}
function option_user_level3(){
if($this->input->post()){    
$input = $this->input->post();
$data_user = $this->M_user2->data_user_perizinan('Level 3');
echo "<select  onchange=simpan_alihan_perizinan('".$input['no_berkas_perizinan']."','".$input['no_client']."','".$input['no_pekerjaan']."') class='form-control ".$input['no_berkas_perizinan']."  '>";
foreach ($data_user->result_array() as $u){        
echo "<option value=".$u['no_user'].">".$u['nama_lengkap']."</option>";
}                
echo  "</select>";
}else{
redirect(404);    
}    
}
function tampilkan_form_utama(){
if($this->input->post()){    
$input = $this->input->post();

echo '<div class="modal-content">
<div class="modal-header bg-info text-white">
<h6 class="modal-title" >Masukan Dokumen Utama Pekerjaan</h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>';


echo '<div class="modal-body">';
echo  '<div class="row">
<div class="col-md-8">'
."<form  class=' ' id='form_utama'>"
."<input type='hidden' class='no_client' name='no_client'    value='".$input['no_client']."'>"
."<input type='hidden' class='no_pekerjaan' name='no_pekerjaan' value='".$input['no_pekerjaan']."'>";

echo '<div class="input-group">
  <div class="custom-file">
    <input onchange="upload_utama()" type="file" class="custom-file-input"  id="file_utama" name="file_utama[]" multiple aria-describedby="file_utama">
    <label class="custom-file-label" for="file_utama">Masukan Dokumen Utama</label>
  </div>
 ';
 echo '</div><div class="m-2 utama_terupload"></div>';


echo '<div class="progress" style="display:none"> 
<div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
</div></form>
</div>

<div class="col overflow-auto" style="max-height:100%;">';
$dokumen_utama = $this->M_user2->dokumen_utama($input['no_pekerjaan']);
echo '<table class="table table-striped text-center ">
<tr><td colspan="2">Dokumen Utama yang dimasukan</td></tr>
<tr class="text-info">
<th>Jenis Utama </th>
<th>Aksi</th>
</tr>';
foreach ($dokumen_utama->result_array() as $utama){ 
echo '<tr>
<td>'.$utama['jenis'] .' No '. $utama['no_akta'] .' ('.$utama['tanggal_akta'] .')</td>   
<td>
<button  onclick=hapus_utama("'.$utama['id_data_dokumen_utama'].'","'.$input['no_client'].'","'.$input['no_pekerjaan'].'"); class="btn btn-sm btn-danger "><i class="fa fa-trash"></i></button>
<button  onclick=download_utama("'.$utama['id_data_dokumen_utama'].'"); class="btn btn-sm btn-dark "><i class="fa fa-download"></i></button>
<button  onclick=LihatLampiran("'.$utama['nama_folder'].'","'.$utama['nama_file'].'"); class="btn btn-sm btn-primary "><i class="fa fa-eye"></i></button>
</td>   
</tr>';
} 
echo ' 
</table>';
echo '</div>
</div></div>';
}else{
redirect(404);    
}    
}

public function utama_terupload(){
    if($this->input->post()){    
    $input              = $this->input->post();  
   
    $this->db->select('data_dokumen_utama.nama_file,'
    . 'data_dokumen_utama.id_data_dokumen_utama,'
    . 'data_client.nama_folder');

    $this->db->from('data_dokumen_utama');
    $this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_dokumen_utama.no_pekerjaan');
    $this->db->join('data_client', 'data_client.no_client = data_pekerjaan.no_client');
    $this->db->where('data_dokumen_utama.no_pekerjaan', $input['no_pekerjaan']);
    $this->db->where('data_dokumen_utama.jenis', '');
    $data_upload= $this->db->get();  
                          
    echo "<div class='row card-header rounded text-center'>"
    . "<div class='col'><b>Dokumen Utama</div>"
    . "<div class='col-md-5'>Jenis dokumen</div>"
    . "<div class='col-md-2'>Aksi</b></div>"
    . "</div>";
    if($data_upload->num_rows() != 0){   
    echo "<div class='DataLampiran '> ";
    foreach ($data_upload->result_array() as $data){
    echo "<div class='row  mt-1 text-dark card-footer data".$data['id_data_dokumen_utama']."'>";
    echo "<div class='col'>".substr($data['nama_file'],0,20)."</div>";
    echo "<div class='col-md-5'>"
    . "<select onchange=set_jenis_utama('".$input['no_pekerjaan']."','".$data['id_data_dokumen_utama']."'); class='form-control nama_dokumen  form-control-md no_utama".$data['id_data_dokumen_utama']."'>";
    echo "<option></option>";
    echo "<option>Salinan</option>";
    echo "<option>Minuta</option>";
    echo "<option>SKMHT</option>";
    echo "<option>APHT</option>";
    echo "</select></div>";
    echo '<div class="col-md-2 text-center">';
    echo '<button type="button"  onclick=hapus_utama("'.$data['id_data_dokumen_utama'].'"); class="btn btn-md mx-auto  btn-danger  btnhapus'.$data['id_data_dokumen_utama'].'"  title="Hapus data ini" ><i class="fa fa-trash"></i></button>';
    echo '<button type="button"  onclick=LihatLampiran("'.$data['nama_folder'].'","'.$data['nama_file'].'"); class="btn btn-md mx-auto ml-3  btn-info   title="Lihat File" ><i class="fa fa-eye"></i></button>';
    echo '</div>';
    echo "</div>";    
    }
    
    echo "</div>";
    }else{
    echo "<div class='text-center  text-dark '>Belum Terdapat Dokumen Penunjang<br>Silahkan pilih dokumen penunjang terlebih dahulu</div>";    
    }
    }else{
    redirect(404);    
    }        
    }

function form_edit_meta(){
if($this->input->post()){
$input = $this->input->post();
$data_meta = $this->M_user2->data_meta($input['no_nama_dokumen']);
$cek_meta  = $this->db->get_where('data_meta_berkas',array('no_berkas'=>$input['no_berkas']));
if($cek_meta->num_rows() > 0){
$this->DataMeta($input,$data_meta);    
}else{
$this->FormMasukanMetaDokumen($input,$data_meta);
}   
}else{
redirect(404);    
} 
}
function DataMeta($input){
$data_meta = $this->db->get_where('data_meta_berkas',array('no_berkas'=>$input['no_berkas']));    
echo "<div class='row  bg-info p-2 data_edit".$input['no_berkas']."'>"
. "<div class='col-md-6 text-white'>";
foreach ($data_meta->result_array()  as $d ){
echo str_replace('_', ' ',$d['nama_meta'])." : ".$d['value_meta'] ."<br>";   
}

echo "<hr>"
. "<button type='button' onclick=hapus_meta('".$input['no_berkas']."','".$input['no_nama_dokumen']."','".$input['no_client']."','".$input['no_pekerjaan']."') class='btn  btn-sm btn-danger btn-block '>Hapus meta dokumen <i class='fa fa-trash'></i></button>"
. "</form>"
. "</div></div>";
}

function FormMasukanMetaDokumen(){
    $input = $this->input->post();        
    if($this->input->post('no_nama_dokumen')){
    $cek  = $this->db->get_where('data_berkas',array('no_client'=>$input['no_client'],'no_nama_dokumen'=>$input['no_nama_dokumen']));
    if($cek->num_rows() > 0){
            $status[] = array(
                    'status'  => 'warning',
                    'messages'=> "Duplikasi Dokumen ",    
                    );
                    echo json_encode($status);
    }else{
    
    $data_meta = $this->M_user2->data_meta($input['no_nama_dokumen']);
    $form = '<div class="modal-content">
    <div class="modal-header bg-dark text-white">
    <h6 class="modal-title" >Masukan Identifikasi File Untuk Mempermudah Pencarian</h6>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body " >';
    $form .= "<form id='FormMeta'>";
    $form .= '<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="required"  accept="text/plain">';
    $form .= '<input type="hidden" name="no_berkas" value="'.$input['no_berkas'].'" readonly="" class="required"  accept="text/plain">';
    $form .= '<input type="hidden" id="no_pekerjaan" name="no_pekerjaan" value="'.$input['no_pekerjaan'].'" readonly="" class="required"  accept="text/plain">';
    $form .= '<input type="hidden" id="no_client" name="no_client" value="'.$input['no_client'].'" readonly="" class="required"  accept="text/plain">';
    $form .= '<input type="hidden" name="no_nama_dokumen" value="'.$input['no_nama_dokumen'].'" readonly="" class="required"  accept="text/plain">';
    foreach ($data_meta->result_array()  as $d ){
    //INPUTAN SELECT   
    if($d['jenis_inputan'] == 'select'){
    $data_option = $this->db->get_where('data_input_pilihan',array('id_data_meta'=>$d['id_data_meta']));   
    $form .= "<label>".$d['nama_meta']."</label>"
    ."<select id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' class='form-control form_meta form-control-md meta required' required='' accept='text/plain'>";
    foreach ($data_option->result_array() as $option){
    $form .= "<option ";
    
    $form .= ">".$option['jenis_pilihan']."</option>";
    }
    $form.="</select>";
    //INPUTAN DATE
    }else if($d['jenis_inputan'] == 'date'){
    $form .= "<label>".$d['nama_meta']."</label>"
    ."<input value=''  type='text' id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-md ".$d['jenis_inputan']." meta required ' required='' accept='text/plain' >";    
    ///INPUTAN NUMBER
    }else if($d['jenis_inputan'] == 'number'){
    $form .= "<label>".$d['nama_meta']."</label>"
    ."<input value='' type='text' id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-md ".$d['jenis_bilangan']." meta required ' required='' accept='text/plain' >";        
    //INPUTAN TEXTAREA
    }else if($d['jenis_inputan'] == 'textarea'){
    $form .= "<label>".$d['nama_meta']."</label>"
    . "<textarea  id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-md ".$d['jenis_bilangan']." meta required ' required='' accept='text/plain'></textarea>";
    }else{
    $form .= "<label>".$d['nama_meta']."</label>"
    ."<input  type='".$d['jenis_inputan']."' value='' id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-md  meta required ' required='' accept='text/plain' >";    
    }
    
    
    }
    $form .="<hr>"
    . "<button type='button' onclick=SimpanPenunjang() class='btn  btn-md btn-dark btn-block '>Simpan Penunjang <i class='fa fa-save'></i></button>"
    . "</form>"
    . "</div></div>";
    
    $status[] = array(
    'status'  => 'success',
    'data'=> $form,    
    );
    echo json_encode($status);  
    } 
    }else{
        
    $status[] = array(
    'status'  => 'error',
    'messages'=> "Anda Harus Memilih Jenis Dokumen Penunjang",    
    );
    echo json_encode($status);    
    
    
    }
    }

    public function SimpanPenunjang(){
        if($this->input->post()){
        $input = $this->input->post();
        foreach ($input as $key=>$value){
        if($key != "ci_csrf_token"){
        $this->form_validation->set_rules($key, $key, 'required',array('required' => 'Data ini tidak boleh kosong'));
        }
        }
        
        if ($this->form_validation->run() == FALSE){
        $status_input = $this->form_validation->error_array();
        $status[] = array(
        'status'  => 'error_validasi',
        'messages'=>array($status_input),    
        );
        echo json_encode($status);
        }else{
                $data = array(
                'no_nama_dokumen' => $input['no_nama_dokumen'],
                'status_berkas'   =>'selesai'    
                );
                $this->db->update('data_berkas',$data,array('no_berkas'=>$input['no_berkas']));
                       
                        
                        foreach ($input as $key=>$value){
                                if($key != "no_berkas" && $key != "ci_csrf_token" && $key !='no_pekerjaan' && $key !='no_client' && $key !='no_nama_dokumen'){
                                $data = array(
                                        'no_berkas'=>$input['no_berkas'],    
                                        'nama_meta'=>$key,   
                                        'value_meta'=>$value    
                                );
                                $this->db->insert('data_meta_berkas',$data,array('no_berkas'=>$input['no_berkas']));
                                }
                        }
        
                                $response [] =array(
                                        'status'   =>'success',
                                        'messages' =>'Dokumen Penunjang Disimpan'   
                                        );
                                        echo json_encode($response);
                        
        }
        }else{
        redirect(404);    
        } 
        }    

function update_meta(){
if($this->input->post()){
$input = $this->input->post();
$cek_meta = $this->db->get_where('data_meta_berkas',array('no_berkas'=>$input['no_berkas']));
if($cek_meta->num_rows() == 0){
$this->simpan_meta($input);    
}else{
foreach ($input as $key=>$value){
if($key != "no_berkas" && $key != "ci_csrf_token"){
$data = array(
'value_meta'=>$value    
);
$this->db->update('data_meta_berkas',$data,array('no_berkas'=>$input['no_berkas'],'nama_meta'=>$key));
}
}
$status[] = array(
'status'  => 'success',
'messages'=> "Meta Data diperbaharui",    
);
echo json_encode($status);
}
}else{
redirect(404);    
}
    
}
public function hapus_keterlibatan(){
    if($this->input->post()){
    $input = $this->input->post();
    $this->db->delete('data_pemilik',array('no_client'=>$input['no_client'],'no_pekerjaan'=> $input['no_pekerjaan']));
    
    $status[] = array(
    'status'  => 'success',
    'messages'=> "Keterlibatan dihapus",    
    );
    echo json_encode($status);
    
    }else{
    redirect(404);    
    }    
    }
public function upload_berkas(){
    $input = $this->input->post(); 
    $data_client = $this->db->get_where('data_client',array('no_client'=>$input['no_client']))->row_array();
    $status = array();
    
    for($i =0; $i<count($_FILES); $i++){
    $config['upload_path']          = './berkas/'.$data_client['nama_folder'];
    $config['allowed_types']        = 'jpg|jpeg|png|pdf|docx|doc|xlxs|pptx|';
    $config['encrypt_name']         = FALSE;
    $config['max_size']             = 1000000000;
    $this->upload->initialize($config);   
    
    if (!$this->upload->do_upload('file_berkas'.$i)){  
    $status[] = array(
    "status"        => "error",
    "messages"      => $this->upload->display_errors(),    
    'name_file'     => $this->upload->data('file_name')
    );
    }else{
    $lampiran = $this->upload->data();    
    $this->simpan_data_persyaratan($input,$lampiran);
    $status[] = array(
    "status"        => "success",
    "messages"      => "File berhasil di upload",
    'name_file'     =>$this->upload->data('file_name')
    );
    }
    }
    echo json_encode($status);
    
    }
    public function simpan_data_persyaratan($input,$lampiran){
           $this->db->limit(1);
                            $this->db->order_by('data_berkas.no_berkas','desc');
                            $h_berkas       = $this->db->get('data_berkas')->row_array();
                            
                            if(isset($h_berkas['no_berkas'])){
                            $urutan = (int) substr($h_berkas['no_berkas'],10)+1;
                            }else{
                            $urutan =1;
                            }
            $no_berkas = "BK".date('Ymd' ).str_pad($urutan,10,0,STR_PAD_LEFT);
            
            
    $data_berkas = array(
    'no_berkas'         => $no_berkas,    
    'no_client'         => $input['no_client'],    
    'no_pekerjaan'      => $input['no_pekerjaan'],
    'no_nama_dokumen'   => NULL,
    'nama_berkas'       => $lampiran['file_name'],
    'mime-type'         => $lampiran['file_type'],   
    'Pengupload'        => $this->session->userdata('no_user'),
    'tanggal_upload'    => date('Y/m/d' )
    );    
    $this->db->insert('data_berkas',$data_berkas); 
    }

    function cari_dokumen(){
    
        $term  = strtolower($this->input->post('search'));
        $query = $this->M_user2->cari_dokumen($term);
        
        if($query->num_rows() >0 ){
        foreach ($query->result() as $d) {
        $json[] = array(
        'text'                          => $d->nama_dokumen,   
        'id'                            => $d->no_nama_dokumen,
        );   
        }
        
        $data = array(
            'results'=>$json,
            );
        }else{
              $data = array(
                'results'=>[array('error'=>'Pencarian Tidak Ditemukan')],
              );    
        }
        echo json_encode($data);
        }

public function  simpan_meta(){
$input = $this->input->post();
foreach ($input as $key=>$value){
if($key == 'no_berkas' || $key == "no_nama_dokumen" || $key == 'no_client' || $key == 'no_pekerjaan' || $key == 'file_berkas' || $key == "ci_csrf_token"){
}else{
$meta = array(
'no_pekerjaan'      => $input['no_pekerjaan'],
'no_nama_dokumen'   => $input['no_nama_dokumen'],
'no_berkas'         => $input['no_berkas'],    
'nama_meta'         => $key,
'value_meta'        => $value,    
);
$this->db->insert('data_meta_berkas',$meta);
}
}
$status[] = array(
"status"        => "success",
"messages"      => "Meta Berhasil disimpan",
);
echo json_encode($status);
}

public function set_jenis_dokumen(){
if($this->input->post()){
$input = $this->input->post();
$cek  = $this->db->get_where('data_berkas',array('no_client'=>$input['no_client'],'no_nama_dokumen'=>$input['no_nama_dokumen']));
if($cek->num_rows() > 0){
 $response [] =array(
  'status'   =>'warning',
   'messages' =>'Jenis Dokumen Ini Tersedia'
);
}else{
$data = array(
'no_nama_dokumen' => $input['no_nama_dokumen']    
);
$response [] =array(
  'status'   =>'success',
    'messages' =>'Jenis dokumen ini sudah tersedia silahkan click info dokumen yang sudah dimiliki'   
  );
$this->db->update('data_berkas',$data,array('no_berkas'=>$input['no_berkas']));
}

echo json_encode($response);
}else{
redirect(404);    
} 
}

function cari_client(){
if($this->input->post()){
$search         = strtolower($this->input->post('search'));
$jenis_client   = strtolower($this->input->post('jenis_client'));

$query = $this->M_user2->cari_jenis_client($search,$jenis_client);
if($query->num_rows() >0 ){
foreach ($query->result_array() as $d) {
$json[]= array(
'text'                    => $d['nama_client'],   
'id'                      => $d['no_client'],
'no_identitas'            => $d['no_identitas']    
);   
}
$data = array(
'results'=>$json,
);

}else{
  $data = array(
    'results'=>[array('error'=>'Pencarian Tidak Ditemukan')],
  );    
}

echo json_encode($data);
}else{
redirect(404);    
}
    
}
function cari_client2(){
if($this->input->post()){
$no_identitas       = $this->input->post('no_identitas');
$cek                = $this->db->get_where('data_client',array('no_identitas'=>$no_identitas));
$no_client          = $cek->row_array();
if($cek->num_rows() != 0){
$data = array(
'no_client'        =>$no_client['no_client'],
'no_identitas'     =>$no_client['no_identitas'],
'nama_client'      =>$no_client['nama_client'],
'contact_person'   =>$no_client['contact_person'],
'contact_number'   =>$no_client['contact_number'],
'jenis_kontak'     =>$no_client['jenis_kontak']       
);
$s    = "success";
}else{
$data ="Tidak Tersedia";
$s    = "error";
}

$status[] = array(
'message' =>$data,
'status'  => $s    
);

echo json_encode($status);

}else{
redirect(404);    
}    
}
function simpan_lampiran(){
$input = $this->input->post();
$data = $this->db->get_where('data_berkas',array('no_client'=>$input['no_client'],'no_pekerjaan'=> base64_decode($input['no_pekerjaan']),'no_nama_dokumen !='=>''));

foreach ($data->result_array() as $d){
$data = array(
'status_berkas' =>'selesai'    
);
$this->db->update('data_berkas',$data,array('no_berkas'=>$d['no_berkas']));
}
}


function lihat_meta(){
if($this->input->post()){ 
$input = $this->input->post(); 
$data = $this->db->get_where('data_meta_berkas',array('no_berkas'=>$input['no_berkas']));    
    
echo '<div class="modal-content ">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel text-center">Data yang telah direkam<span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body data_perekaman">';
if($data->num_rows() == 0){
echo "<p class='text-center'>Meta Data Tidak Tersedia</p><hr>";    
}else{
echo '<table class="table table-sm table-bordered ">';

foreach ($data->result_array() as $d){
echo "<tr><td>".str_replace('_', ' ',$d['nama_meta'])."</td><td>".$d['value_meta']."</td></tr>";    
}

echo "<table>"
. "<hr>";
}
echo "<button onclick=cek_download('".base64_encode($input['no_berkas'])."') class='btn btn-sm  mr-2 btn-success '>Download lampiran <span class='fa fa-save'></span></button>";


echo "<button onclick=edit_meta('".$input['no_berkas']."','".$input['no_nama_dokumen']."','".$input['no_pekerjaan']."') class='btn btn-sm  mr-2  btn-warning  '>Meta lampiran <span class='fa fa-edit'></span></button>";

echo "<button  onclick=hapus_lampiran('".base64_encode($input['no_berkas'])."') class='btn btn-sm  mr-2 btn-danger  '>Hapus lampiran <span class='fa fa-trash'></span></button>";
echo'</div>'
. '</div>';    


}else{
redirect(404);
}    
}


public function hapus_lampiran(){
if($this->input->post()){
$input = $this->input->post();    
$data = $this->M_user2->hapus_lampiran(base64_decode($input['no_berkas']))->row_array();

$filename = './berkas/'.$data['nama_folder']."/".$data['nama_berkas'];

if(file_exists($filename)){
unlink($filename);
}
$this->db->delete('data_berkas',array('no_berkas'=> base64_decode($input['no_berkas'])));    

$status[] = array(
"status"        => "success",
"messages"      => "Data persyaratan dihapus",    
);
echo json_encode($status);

$keterangan = $this->session->userdata('nama_lengkap')." Menghapus File dokumen".$data['nama_dokumen'];  
$this->histori($keterangan);


}else{
redirect(404);    
}
}


function form_meta(){
if($this->input->post()){ 
$input = $this->input->post();    
$this->db->get_where('data_meta_berkas',array('no_berkas'=>$input['no_berkas']));    

$data_meta = $this->M_user2->data_meta($input['no_nama_dokumen']);

echo '<div class="modal-content ">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel text-center">Data yang telah direkam<span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body data_perekaman">
<form id="form_edit_meta">';
echo '<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="required"  accept="text/plain">';
echo '<input type="hidden" name="no_berkas" value="'.$input['no_berkas'].'" readonly="" class="required"  accept="text/plain">';
echo '<input type="hidden" name="no_pekerjaan" value="'.$input['no_pekerjaan'].'" readonly="" class="required"  accept="text/plain">';
echo '<input type="hidden" name="no_nama_dokumen" value="'.$input['no_nama_dokumen'].'" readonly="" class="required"  accept="text/plain">';


foreach ($data_meta->result_array()  as $d ){
$val = $this->M_user2->data_edit($input['no_berkas'],str_replace(' ', '_',$d['nama_meta']))->row_array();
//INPUTAN SELECT   
if($d['jenis_inputan'] == 'select'){
$data_option = $this->db->get_where('data_input_pilihan',array('id_data_meta'=>$d['id_data_meta']));   
echo "<label>".$d['nama_meta']."</label>"
."<select id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' class='form-control form_meta form-control-sm meta required' required='' accept='text/plain'>";
foreach ($data_option->result_array() as $option){
echo "<option ";
if($val['value_meta'] == $option['jenis_pilihan']){
echo "selected";    
}
echo ">".$option['jenis_pilihan']."</option>";
}
echo "</select>";
//INPUTAN DATE
}else if($d['jenis_inputan'] == 'date'){
echo "<label>".$d['nama_meta']."</label>"
."<input value='".$val['value_meta']."'  type='text' id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-sm ".$d['jenis_inputan']." meta required ' required='' accept='text/plain' >";    
///INPUTAN NUMBER
}else if($d['jenis_inputan'] == 'number'){
echo "<label>".$d['nama_meta']."</label>"
."<input value='".$val['value_meta']."' type='text' id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-sm ".$d['jenis_bilangan']." meta required ' required='' accept='text/plain' >";        
//INPUTAN TEXTAREA
}else if($d['jenis_inputan'] == 'textarea'){
echo "<label>".$d['nama_meta']."</label>"
. "<textarea  id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-sm ".$d['jenis_bilangan']." meta required ' required='' accept='text/plain'>".$val['value_meta']."</textarea>";
}else{
echo "<label>".$d['nama_meta']."</label>"
."<input  type='".$d['jenis_inputan']."' value='".$val['value_meta']."' id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-sm  meta required ' required='' accept='text/plain' >";    
}
}

echo "</form><hr>";
echo "<button onclick=update_meta('".base64_encode($input['no_berkas'])."') class='btn btn-block btn-sm  mr-2 btn-success '>Simpan Meta <span class='fa fa-save'></span></button>";
echo '</div>'
     .'</div>';    

}else{
redirect(404);
}    
}
function data_perekaman_utama(){
if($this->input->post()){
    $input              = $this->input->post();
    $data_utama = $this->M_user2->DataDokumenUtama($input['id_data_dokumen_utama']);
    $data = $data_utama->row_array();
    echo '<div class="modal-content ">
    <div class="modal-header">
    <h6 class="modal-title" id="exampleModalLabel text-center">'.$data['nama_berkas'].'<span class="i"><span></h6>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body">';
    echo "<table class='table table-hover table-sm table-stripped table-bordered'>";
    echo "<tr><td class='text-center' colspan='2'>".$data['nama_client']."</td></tr>";
    foreach($data_utama->result_array() as $d){
    echo "<tr><td>Jenis</td>";    
    echo "<td>".$d['jenis']."</td></tr>";    
    echo "<tr><td>Tanggal Akta</td>";    
    echo "<td>".$d['tanggal_akta']."</td></tr>";    
    }
    echo"</table></div>";
    echo"<div class='card-footer'>";
    $ext = pathinfo($data['nama_file'], PATHINFO_EXTENSION);
  
    if($ext =="docx" || $ext =="doc" ){
    echo "<button onclick=download_utama('".base64_encode($data['id_data_dokumen_utama'])."') class='btn btn-success btn-sm mx-auto btn-block '>Lihat Dokumen <i class='fa fa-eye'></i></button>";
    }else if($ext == "xlx"  || $ext == "xlsx"){
    echo "<button onclick=download_utama('".base64_encode($data['id_data_dokumen_utama'])."') class='btn btn-success btn-sm mx-auto btn-block '>Lihat Dokumen <i class='fa fa-eye'></i></button>";
    }else if($ext == "PDF"  || $ext == "pdf"){
    echo "<button onclick=lihat_pdf('".$data['nama_folder']."','".$data['nama_file']."'); class='btn btn-success btn-sm mx-auto btn-block '>Lihat Dokumen <i class='fa fa-eye'></i></button>";
    }else if($ext == "JPG"  || $ext == "jpg" || $ext == "png"  || $ext == "PNG"){
    echo "<button onclick=lihat_gambar('".$data['nama_folder']."','".$data['nama_file']."');  class='btn btn-success btn-sm mx-auto btn-block '>Lihat File <i class='fa fa-eye'></i></button>";
    }else{
    echo "<button onclick=download_utama('".base64_encode($data['id_data_dokumen_utama'])."') class='btn btn-success btn-sm mx-auto btn-block '>Lihat File <i class='fa fa-eye'></i></button>";
    }
    echo "</div></div>";
    
    }else{
    redirect(404);    
    }
}


function ShowGrafik(){    
$this->db->select('user.nama_lengkap,'
        . 'user.no_user,'
        . 'user.username');
$this->db->where('user.level','User');
$this->db->where('user.status','Aktif');
$this->db->where('sublevel_user.sublevel','Level 2');
$this->db->from('user');
$this->db->join('sublevel_user', 'sublevel_user.no_user = user.no_user');
$namaasisten = $this->db->get();

$data_asisten = array();
$jumlah_berkas = array();
$jumlah_pekerjaan = array();

foreach ($namaasisten->result()  as $as) {
$data_asisten[] = $as->nama_lengkap;
}

foreach ($namaasisten->result()  as $as) {
$BerkasMilikAsisten = $this->M_user2->BerkasMilikAsisten($as->no_user)->num_rows();
$jumlah_berkas[] = $BerkasMilikAsisten;
}

foreach ($namaasisten->result()  as $as) {
$PekerjaanMilikAsisten = $this->M_user2->PekerjaanMilikAsisten($as->no_user)->num_rows();
$jumlah_pekerjaan[] = $PekerjaanMilikAsisten;
}

$data = array(
'asisten'   =>$data_asisten,    
'jumlah'    =>$jumlah_berkas,
'pekerjaan' =>$jumlah_pekerjaan    
);

echo json_encode($data);    
}
public function ShowGrafikBerkas(){
if($this->input->post()){
$input = $this->input->post();
if($this->input->post('range')){
$tanggal        = $this->input->post('range');
$range          = explode(' ', $tanggal);
$awal           = $range[0];
$akhir          = $range[2];

}else{
$akhir   = date('Y/m/d');
$c       = strtotime($akhir);
$awal    = date("Y/m/d", strtotime("-1 month", $c));
}

$this->db->select('data_berkas.tanggal_upload,'
                 .'data_pekerjaan.no_user');
$this->db->from('data_pekerjaan');
$this->db->join('data_berkas', 'data_berkas.no_pekerjaan = data_pekerjaan.no_pekerjaan');
$this->db->group_by('data_berkas.tanggal_upload');
$this->db->where('data_berkas.tanggal_upload >=', $awal);
$this->db->where('data_berkas.tanggal_upload <=', $akhir);
$this->db->where('data_pekerjaan.no_user',$this->session->userdata('no_user'));
$query = $this->db->get();

$data_tanggal = array();
$data_jumlah  = array();

foreach ($query->result_array() as $t){

$this->db->select('data_berkas.tanggal_upload,'
                 .'data_pekerjaan.no_user');
$this->db->from('data_pekerjaan');
$this->db->join('data_berkas', 'data_berkas.no_pekerjaan = data_pekerjaan.no_pekerjaan');
$this->db->where('data_berkas.tanggal_upload ', $t['tanggal_upload']);
$this->db->where('data_pekerjaan.no_user',$this->session->userdata('no_user'));
$jumlah = $this->db->get()->num_rows();

$data_jumlah[]  = $jumlah;    
$data_tanggal[] = $t['tanggal_upload'];     
}

$data = array(
'tanggal' =>$data_tanggal,
'jumlah'  =>$data_jumlah,    
);

echo json_encode($data);

}else{
redirect(404);    
}
}

public function modal_cek_dokumen(){

    if($this->input->post()){    
    $input = $this->input->post();
    
    $this->db->select('data_berkas.no_berkas,'
    . 'nama_dokumen.nama_dokumen,'
    . 'nama_dokumen.no_nama_dokumen,'
    . 'data_berkas.tanggal_upload,'
    . 'data_berkas.nama_berkas,'
    . 'user.nama_lengkap');
    $this->db->from('data_berkas');
    $this->db->join('nama_dokumen', 'nama_dokumen.no_nama_dokumen = data_berkas.no_nama_dokumen');
    $this->db->join('user', 'user.no_user = data_berkas.pengupload');
    $this->db->where('data_berkas.no_nama_dokumen',$input['no_nama_dokumen']);
    $this->db->where('data_berkas.no_client',$input['no_client']);
    $data = $this->db->get();
    
    
    echo '<div class="modal-content ">
    <div class="modal-header bg-danger text-white">
    <h6 class="modal-title" id="exampleModalLabel text-center">Jenis Dokumen ini sudah tersedia <span class="i"><span></h6>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body ">
    <table class="table table-bordered table-striped">
    <tr>
    <td>Dokumen lama</td>
    <td>Pengupload</td>
    <td>Tgl upload</td>
    <td>Aksi</td>
    </tr>';
    foreach ($data->result_array() as $d){
    echo "<tr id='tersedia".$d['no_berkas']."'>"
    . "<td>".$d['nama_dokumen']."</td>"
    . "<td>".$d['nama_lengkap']."</td>"
    . "<td>".$d['tanggal_upload']."</td>"
    . "<td style='width:25%;' class='text-center'>"
    . "<button  onclick=FormLihatMetaDuplicate('".$input['no_client']."','".$input['no_pekerjaan']."','".$d['no_berkas']."','".$d['no_nama_dokumen']."'); class='btn btn-sm  btn-warning btn_tersedia".$d['no_berkas']."'>Lihat Meta </button>"
    . "<button onclick=hapus_berkas_persyaratan('".$input['no_client']."','".$input['no_pekerjaan']."','".$d['no_berkas']."') class='btn btn-sm ml-1 btn-danger'>Replace </button>"
    . "</td>"
    . "</tr>";    
    }
    echo'</table></div>';    
    echo "<div class='card-footer text-center'>"
    . "<button onclick=DuplicateDokumen('".$input['no_client']."','".base64_decode($input['no_pekerjaan'])."','".$input['no_berkas']."','".$input['no_nama_dokumen']."') class='btn btn-md  btn-info btn-block '>Tambahkan Dokumen Baru </button>"
    . "</div></div></div>";
    
    }else{
    redirect(404);    
    }
    }

public function DuplikasiDokumen(){
if($this->input->post()){
$input = $this->input->post();
$data = array(
'no_nama_dokumen' => $input['no_nama_dokumen']    
);
$response [] =array(
'status'   =>'success',
'messages' =>'Dokumen Terduplikasi'   
);

$this->db->update('data_berkas',$data,array('no_berkas'=> $input['no_berkas']));
echo json_encode($response);    
}else{
redirect(404);    
}    
}
public function hapus_meta(){
if($this->input->post()){    
$input = $this->input->post();
$response [] =array(
'status'   =>'success',
'messages' =>'Meta Dokumen Terhapus'   
);
$this->db->delete('data_meta_berkas',array('no_berkas'=> $input['no_berkas']));
echo json_encode($response);    
}
}

public function FormTambahKontak(){
echo '<div class="modal-content">
<div class="modal-header bg-info text-white">
<h6 class="modal-title" >Membuat Kontak Person</h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body " >';

echo '<form id="FormTambahKontak">
<input type="hidden" name="'. $this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="form-control required"  accept="text/plain">

<label>* Nama Kontak</label>
<input  type="text" name="nama_kontak" id="nama_kontak" class="form-control  required nama_kontak"  accept="text/plain" placeholder="Masukan Nama Kontak">

<label>* No Kontak</label>
<input type="number" name="no_kontak" id="no_kontak" class="form-control  required"  accept="text/plain" placeholder="Masukan No Kontak">

<label>* Email </label>
<input name="email" id="email" class="form-control  required"  accept="text/plain" placeholder="Masukan Alamat Email">

<label>* Jabatan </label>
<input name="jabatan" id="jabatan" class="form-control  required"  accept="text/plain" placeholder="Masukan Status Jabatan">

</div> 
<div class="modal-footer">
<button type="button" onclick=SimpanKontak(); class="btn btn-dark simpan_pekerjaan btn-block">Simpan Kontak Baru <span class="fa fa-save"></span> </button>
</form>
</div>
</div>
';    
}

function FormMasukanMetaDokumenDuplicate(){
    $input = $this->input->post();        
    if($this->input->post('no_nama_dokumen')){

    
    $data_meta = $this->M_user2->data_meta($input['no_nama_dokumen']);
    $form = '<div class="modal-content">
    <div class="modal-header bg-dark text-white">
    <h6 class="modal-title" >Masukan Identifikasi File Untuk Mempermudah Pencarian</h6>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body " >';
    $form .= "<form id='FormMeta'>";
    $form .= '<input type="hidden" name="'.$this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="required"  accept="text/plain">';
    $form .= '<input type="hidden" name="no_berkas" value="'.$input['no_berkas'].'" readonly="" class="required"  accept="text/plain">';
    $form .= '<input type="hidden" id="no_pekerjaan" name="no_pekerjaan" value="'.$input['no_pekerjaan'].'" readonly="" class="required"  accept="text/plain">';
    $form .= '<input type="hidden" id="no_client" name="no_client" value="'.$input['no_client'].'" readonly="" class="required"  accept="text/plain">';
    $form .= '<input type="hidden" name="no_nama_dokumen" value="'.$input['no_nama_dokumen'].'" readonly="" class="required"  accept="text/plain">';
    foreach ($data_meta->result_array()  as $d ){
    //INPUTAN SELECT   
    if($d['jenis_inputan'] == 'select'){
    $data_option = $this->db->get_where('data_input_pilihan',array('id_data_meta'=>$d['id_data_meta']));   
    $form .= "<label>".$d['nama_meta']."</label>"
    ."<select id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' class='form-control form_meta form-control-md meta required' required='' accept='text/plain'>";
    foreach ($data_option->result_array() as $option){
    $form .= "<option ";
    
    $form .= ">".$option['jenis_pilihan']."</option>";
    }
    $form.="</select>";
    //INPUTAN DATE
    }else if($d['jenis_inputan'] == 'date'){
    $form .= "<label>".$d['nama_meta']."</label>"
    ."<input value=''  type='text' id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-md ".$d['jenis_inputan']." meta required ' required='' accept='text/plain' >";    
    ///INPUTAN NUMBER
    }else if($d['jenis_inputan'] == 'number'){
    $form .= "<label>".$d['nama_meta']."</label>"
    ."<input value='' type='text' id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-md ".$d['jenis_bilangan']." meta required ' required='' accept='text/plain' >";        
    //INPUTAN TEXTAREA
    }else if($d['jenis_inputan'] == 'textarea'){
    $form .= "<label>".$d['nama_meta']."</label>"
    . "<textarea  id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-md ".$d['jenis_bilangan']." meta required ' required='' accept='text/plain'></textarea>";
    }else{
    $form .= "<label>".$d['nama_meta']."</label>"
    ."<input  type='".$d['jenis_inputan']."' value='' id='".str_replace(' ', '_',$d['nama_meta'])."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-md  meta required ' required='' accept='text/plain' >";    
    }
    
    
    }
    $form .="<hr>"
    . "<button type='button' onclick=SimpanPenunjang() class='btn  btn-md btn-dark btn-block '>Simpan Penunjang <i class='fa fa-save'></i></button>"
    . "</form>"
    . "</div></div>";
    
    $status[] = array(
    'status'  => 'success',
    'data'=> $form,    
    );
    echo json_encode($status);  
    
    }else{
        
    $status[] = array(
    'status'  => 'error',
    'messages'=> "Anda Harus Memilih Jenis Dokumen Penunjang",    
    );
    echo json_encode($status);    
    
    
    }
    }

public function FormEditKontak(){
$data = $this->db->get_where('data_daftar_kontak',array('id_kontak'=>$this->input->post('id_kontak')))->row_array();    
    
echo '<div class="modal-content">
<div class="modal-header bg-info text-white">
<h6 class="modal-title" >Edit Kontak Person '.$data['nama_kontak'].'</h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body " >';

echo '<form id="FormEditKontak">
<input  type="hidden" name="'. $this->security->get_csrf_token_name().'" value="'.$this->security->get_csrf_hash().'" readonly="" class="form-control required"  accept="text/plain">
<input  type="hidden" name="id_kontak"  id="id_kontak" value="'.$this->input->post('id_kontak').'" readonly="" class="form-control required"  accept="text/plain">

<label>* Nama Kontak</label>
<input value='.$data['nama_kontak'].'  type="text" name="nama_kontak" id="nama_kontak" class="form-control  required nama_kontak"  accept="text/plain" placeholder="Masukan Nama Kontak">

<label>* No Kontak</label>
<input value='.$data['no_kontak'].'  type="number" name="no_kontak" id="no_kontak" class="form-control  required"  accept="text/plain" placeholder="Masukan No Kontak">

<label>* Email </label>
<input value='.$data['email'].'  name="email" id="email" class="form-control  required"  accept="text/plain" placeholder="Masukan Alamat Email">

<label>* Jabatan </label>
<input value='.$data['jabatan'].'  name="jabatan" id="jabatan" class="form-control  required"  accept="text/plain" placeholder="Masukan Status Jabatan">

</div> 
<div class="modal-footer">
<button type="button" onclick=UpdateKontak("'.$this->input->post('id_kontak').'"); class="btn btn-dark simpan_pekerjaan btn-block">Update Kontak  <span class="fa fa-save"></span> </button>
</form>
</div>
</div>
';    
}

public function SimpanKontak(){
    $input = $this->input->post();
    $this->form_validation->set_rules('nama_kontak', 'nama kontak', 'required',array('required' => 'Data ini tidak boleh kosong'));
    $this->form_validation->set_rules('no_kontak', 'no kontak', 'required|numeric',array('required' => 'Data ini tidak boleh kosong'));
    $this->form_validation->set_rules('email', 'email', 'required|valid_email',array('required' => 'Data ini tidak boleh kosong'));
    $this->form_validation->set_rules('jabatan', 'jabatan', 'required',array('required' => 'Data ini tidak boleh kosong'));
    if ($this->form_validation->run() == FALSE){
    $status_input = $this->form_validation->error_array();
    $status[] = array(
    'status'  => 'error_validasi',
    'messages'=>array($status_input),    
    );
    echo json_encode($status);
    }else{
        
    $cek_kontak = $this->db->get_where("data_daftar_kontak",array('no_kontak'=>$input['no_kontak']));
    
    if($cek_kontak->num_rows() > 0){
    $status[] = array(
    'status'  => 'error_validasi',
    'messages'=>[array('no_kontak'=>'No Kontak Ini Sudah Ditambahkan')],    
    );
    
    echo json_encode($status);
    }else{
            $this->db->order_by('id_kontak','DESC');
            $this->db->limit(1);  
            $datak = $this->db->get('data_daftar_kontak')->row_array();
            
            if(isset($datak['id_kontak'])){
                    $urutan = (int) substr($datak['id_kontak'],6)+1;
            }else{
            $urutan = 1;
            }
           
  
    $id_kontak   ="Kontak".str_pad($urutan,6,"0",STR_PAD_LEFT);
    $data_kontak = array(
    'id_kontak'     => $id_kontak,    
    'nama_kontak'   => $input['nama_kontak'],
    'no_kontak'     => $input['no_kontak'],
    'email'         => $input['email'], 
    'jabatan'       => $input['jabatan']
    );
    
    $this->db->insert('data_daftar_kontak',$data_kontak);
    
    $keterangan                  = $this->session->userdata('nama_lengkap')." Membuat Kontak Person ".$input['nama_kontak'];
    $this->histori($keterangan);
    $status[] = array(
    "status"        => "success",
    "messages"      => "Kontak Person Baru Berhasil Ditambahkan"    
    );
    
    echo json_encode($status); 
    }    
    }
    }

public function SimpanEditKontak(){
$input = $this->input->post();

$this->form_validation->set_rules('nama_kontak', 'nama kontak', 'required',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('no_kontak', 'no kontak', 'required|numeric',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('email', 'email', 'required|valid_email',array('required' => 'Data ini tidak boleh kosong'));
$this->form_validation->set_rules('jabatan', 'jabatan', 'required',array('required' => 'Data ini tidak boleh kosong'));
if ($this->form_validation->run() == FALSE){
$status_input = $this->form_validation->error_array();
$status[] = array(
'status'  => 'error_validasi',
'messages'=>array($status_input),    
);
echo json_encode($status);
}else{
    
 
$data_kontak = array(
'nama_kontak'   => $input['nama_kontak'],
'no_kontak'     => $input['no_kontak'],
'email'         => $input['email'], 
'jabatan'       => $input['jabatan']
);

$this->db->update('data_daftar_kontak',$data_kontak,array('id_kontak'=>$input['id_kontak']));


$keterangan = $this->session->userdata('nama_lengkap')." Merubah Kontak Person".$input['nama_kontak'];
$this->histori($keterangan);

$status[] = array(
"status"        => "success",
"messages"      => "Proses Edit Berhasil",
'DataKontak'    => $data_kontak
);

echo json_encode($status); 
    
}
} 


function cari_kontak(){
    
$term  = strtolower($this->input->post('search'));
$query = $this->M_user2->cari_kontak($term);
if($query->num_rows() >0 ){
foreach ($query->result() as $d) {
$json[] = array(
'text'                          => $d->nama_kontak,   
'id'                            => $d->id_kontak,
'no_kontak'                     => $d->no_kontak,
'email'                         => $d->email,
'jabatan'                       => $d->jabatan,
    
);   
}

$data = array(
    'results'=>$json,
    );
    
}else{
      $data = array(
        'results'=>[array('error'=>'Pencarian Tidak Ditemukan')],
      );    
}
echo json_encode($data);
}
function SetKontak(){
$input = $this->input->post();

$data = $this->db->get_where('data_daftar_kontak',array('id_kontak'=>$input['id_kontak']));

$data_kontak = array();
foreach ($data->result_array() as $d){
$data_kontak =array(
'nama_kontak'   =>$d['nama_kontak'],
'no_kontak'     =>$d['no_kontak'],
'jabatan'       =>$d['jabatan'],
'email'         =>$d['email'],    
'id_kontak'     =>$d['id_kontak'],    
);    
}
$status[] = array(
"status"        => "success",
"messages"      => "Kontak Person Berhasil Ditambahkan",
"DaftarKontak"  =>$data_kontak    
);

echo json_encode($status);
}


public function ProsesBagikan(){
    if($this->input->post()){
    $input = $this->input->post();
    
    if(!$this->input->post('pihak')){
            $status_messages=array(
                    'status'   =>'warning',
                    'messages'   =>'Pilih minimal 1 pihak terlibat untuk membagikan file',
                    );        
    }else{
    $data_berkas = $this->db->get_where('data_berkas',array('no_berkas'=>$input['no_berkas']));
    
    $this->db->select('data_client.nama_folder,
    data_client.no_client,
    data_berkas.nama_berkas,
    data_berkas.nama_berkas,
    data_berkas.no_nama_dokumen,
    data_berkas.mime-type');
    
    $this->db->from('data_berkas');
    $this->db->join('data_client','data_client.no_client = data_berkas.no_client');
    $this->db->where('data_berkas.no_berkas',$input['no_berkas']);
    $data_awal = $this->db->get()->row_array(); 
    
    $status = array();
    for($a=0; $a<count($input['pihak']); $a++){
    
    $this->db->limit(1);
    $this->db->order_by('data_berkas.no_berkas','desc');
    $h_berkas       = $this->db->get('data_berkas')->row_array();
    
    if(isset($h_berkas['no_berkas'])){
    $urutan = (int) substr($h_berkas['no_berkas'],10)+1;
    }else{
    $urutan =1;
    }
    
    $no_berkas = "BK".date('Ymd' ).str_pad($urutan,10,0,STR_PAD_LEFT);
    
    
    $data_berkas = array(
    'no_berkas'         => $no_berkas,    
    'no_client'         => $data_awal['no_client'],    
    'no_pekerjaan'      => $input['pihak'][$a],
    'no_nama_dokumen'   => $data_awal['no_nama_dokumen'],
    'nama_berkas'       => $data_awal['nama_berkas'],
    'mime-type'         => $data_awal['mime-type'],   
    'Pengupload'        => $this->session->userdata('no_user'),
    'tanggal_upload'    => date('Y/m/d' ),
    'status_berkas'     => 'Selesai',
    ); 
    $this->db->insert('data_berkas',$data_berkas); 
    
    $data_meta = $this->db->get_where('data_meta_berkas',array('no_berkas'=>$input['no_berkas']));
    foreach($data_meta->result_array() as $d){
    $meta = array(
    'no_berkas'     =>$no_berkas,
    'nama_meta'     =>$d['nama_meta'],
    'value_meta'    =>$d['value_meta']        
    );
    $this->db->insert('data_meta_berkas',$meta);
    }
                    
                    
                    
                 
    
    $status[] = array(
                'messages'=>"Proses Link File Ke Pekerjaan Berhasil",
                'status'  =>'success'
                 ); 
    }
    
    }
    $status_messages=array(
    'data_kopi' =>$status,
    'status'   =>'success',
    );
    
    
    echo json_encode($status_messages);
    }else{
    redirect(404);        
    }
    
    }
    

}