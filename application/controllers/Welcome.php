<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function BackupDataClient(){
		$strJsonFileContents = file_get_contents("./backup/data_client.json");
// Convert to array 
$array = json_decode($strJsonFileContents, true);
for($a=0; $a<count($array); $a++){
	if($array[$a]['no_identitas'] == '' || $array[$a]['no_identitas'] == '-'){
		$data_client = array(
			'no_client'                 => $array[$a]['no_client'],    
			'jenis_client'              => $array[$a]['jenis_client'],    
			'nama_client'               => $array[$a]['nama_client'],
			'no_identitas'              => $no_npwp,    
			'tanggal_daftar'            => $array[$a]['tanggal_daftar'],    
			'pembuat_client'            => $array[$a]['pembuat_client'],    
			'no_user'                   => $array[$a]['no_user'], 
			'nama_folder'               => $array[$a]['nama_folder'],
			'contact_number'            => $array[$a]['contact_number'],
			'alamat_client'             => $array[$a]['alamat_client'],
			'email'                     => $array[$a]['email']
			);
			$this->db->insert('data_client',$data_client);

	}else{
		$cek_no = $this->db->get_where('data_client',array('no_identitas'=>$array[$a]['no_identitas']));
	  if($cek_no->num_rows() > 0){

	  }else{
		$data_client = array(
			'no_client'                 => $array[$a]['no_client'],    
			'jenis_client'              => $array[$a]['jenis_client'],    
			'nama_client'               => $array[$a]['nama_client'],
			'no_identitas'              => $array[$a]['no_identitas'],    
			'tanggal_daftar'            => $array[$a]['tanggal_daftar'],    
			'pembuat_client'            => $array[$a]['pembuat_client'],    
			'no_user'                   => $array[$a]['no_user'], 
			'nama_folder'               => $array[$a]['nama_folder'],
			'contact_number'            => $array[$a]['contact_number'],
			'alamat_client'             => $array[$a]['alamat_client'],
			'email'                     => $array[$a]['email']
			);
			$this->db->insert('data_client',$data_client);

		}
	}
    

}
}

public function BackupDataPekerjaan(){
$strJsonFileContents = file_get_contents("./backup/data_pekerjaan.json");
$array = json_decode($strJsonFileContents, true);

for($a=0; $a<count($array); $a++){	

$data_pekerjaan = array(
	'no_client'          => $array[$a]['no_client'],    
	'status_pekerjaan'   => $array[$a]['status_pekerjaan'],
	'no_pekerjaan'       => $array[$a]['no_pekerjaan'],    
	'tanggal_dibuat'     => $array[$a]['tanggal_dibuat'],
	'no_jenis_pekerjaan' => $array[$a]['no_jenis_pekerjaan'],   
	'target_kelar'       => $array[$a]['target_kelar'],
	'no_user'            => $array[$a]['no_user'],    
	'pembuat_pekerjaan'  => $array[$a]['pembuat_pekerjaan'],    
	);
	$this->db->insert('data_pekerjaan',$data_pekerjaan);
}

}

public function BackupDataPemilik(){
	$strJsonFileContents = file_get_contents("./backup/data_pemilik.json");
	$array = json_decode($strJsonFileContents, true);
	
	for($a=0; $a<count($array); $a++){	
	
	$data_pemilik = array(
		'no_client'          => $array[$a]['no_client'],    
		'no_pekerjaan'       => $array[$a]['no_pekerjaan'],    
		);

		$this->db->insert('data_pemilik',$data_pemilik);
	}
	
	}
	public function BackupDataBerkas(){
		$strJsonFileContents = file_get_contents("./backup/data_berkas.json");
		$array = json_decode($strJsonFileContents, true);
		
		for($a=0; $a<count($array); $a++){	
		 $cek_pekerjaan = $this->db->get_where('data_client',array('no_client'=>$array[$a]['no_client']));
         if($cek_pekerjaan->num_rows() > 0){
		 $data_berkas = array(
				'no_berkas'          	=> $array[$a]['no_berkas'],    
				'no_client'       		=> $array[$a]['no_client'],    
				'no_pekerjaan'    		=> $array[$a]['no_pekerjaan'],    
				'no_nama_dokumen' 		=> $array[$a]['no_nama_dokumen'],    
				'nama_berkas'       	=> $array[$a]['nama_berkas'],    
				'mime-type'       		=> $array[$a]['mime-type'],    
				'pengupload'       		=> $array[$a]['pengupload'],    
				'tanggal_upload'       	=> $array[$a]['tanggal_upload'],    
				'status_berkas'       	=> $array[$a]['status_berkas']    
				);
	     $this->db->insert('data_berkas',$data_berkas);
			}
		}
		
		}
		public function BackupDataMetaBerkas(){
			$strJsonFileContents = file_get_contents("./backup/data_meta_berkas.json");
			$array = json_decode($strJsonFileContents, true);
			
			for($a=0; $a<count($array); $a++){	
			 $cek_pekerjaan = $this->db->get_where('data_berkas',array('no_berkas'=>$array[$a]['no_berkas']));
			 if($cek_pekerjaan->num_rows() > 0){
			 $data_meta = array(
					'no_berkas'          	=> $array[$a]['no_berkas'],    
					'nama_meta'       	=> $array[$a]['nama_meta'],    
					'value_meta'       	=> $array[$a]['value_meta']    
					);
			 $this->db->insert('data_meta_berkas',$data_meta);
				}
			}
			
			}

			public function BackupDataDokumenUtama(){
				$strJsonFileContents = file_get_contents("./backup/data_dokumen_utama.json");
				$array = json_decode($strJsonFileContents, true);
				
				for($a=0; $a<count($array); $a++){	
				 $data_utama = array(
						'id_data_dokumen_utama'		=> $array[$a]['id_data_dokumen_utama'],    
						'no_pekerjaan'          	=> $array[$a]['no_pekerjaan'],    
						'nama_berkas'       		=> $array[$a]['nama_berkas'],    
						'nama_file'       			=> $array[$a]['nama_file'],    
						'mime-type'       			=> $array[$a]['mime-type'],    
						'waktu'       				=> $array[$a]['waktu'],   
						'tanggal_akta'       		=> $array[$a]['tanggal_akta'],    
						'no_akta'       			=> $array[$a]['no_akta'],    
						'jenis'       			    => $array[$a]['jenis']    
						);
				 $this->db->insert('data_dokumen_utama',$data_utama);
				}
				
				}


				public function BackupNamaDokumen(){
					$strJsonFileContents = file_get_contents("./backup/nama_dokumen.json");
					$array = json_decode($strJsonFileContents, true);
					for($a=0; $a<count($array); $a++){	
					 $dokumen = array(
							'no_nama_dokumen'	          	=> $array[$a]['no_nama_dokumen'],    
							'nama_dokumen'       			=> $array[$a]['nama_dokumen'],    
							'tanggal_dibuat'       			=> $array[$a]['tanggal_dibuat'],    
							'pembuat'       				=> $array[$a]['pembuat'],   
							'badan_hukum'       			=> $array[$a]['badan_hukum'],    
							'perorangan'       				=> $array[$a]['perorangan']  
					 );  
					 $this->db->insert('nama_dokumen',$dokumen);
					}
				}
				
				public function BackupDataPersyaratan(){
					$strJsonFileContents = file_get_contents("./backup/data_persyaratan.json");
					$array = json_decode($strJsonFileContents, true);
					for($a=0; $a<count($array); $a++){	
					 $dokumen = array(
							'id_data_persyaratan'	          	=> "S_".str_pad($array[$a]['id_data_persyaratan'], 5 ,"0",STR_PAD_LEFT),    
							'no_nama_dokumen'       			=> $array[$a]['no_nama_dokumen'],    
							'no_jenis_pekerjaan'       			=> $array[$a]['no_jenis_pekerjaan']    
					 );  
					 $this->db->insert('data_persyaratan',$dokumen);
					}
				}


				public function BackupDataJenisPekerjaan(){
					$strJsonFileContents = file_get_contents("./backup/data_jenis_pekerjaan.json");
					$array = json_decode($strJsonFileContents, true);
					for($a=0; $a<count($array); $a++){	
					 $dokumen = array(
							'no_jenis_pekerjaan'	          	=> $array[$a]['no_jenis_pekerjaan'],    
							'pekerjaan'       					=> $array[$a]['pekerjaan'],    
							'nama_jenis'       					=> $array[$a]['nama_jenis'],    
							'tanggal_dibuat'       				=> $array[$a]['tanggal_dibuat'],    
							'pembuat_jenis'       				=> $array[$a]['pembuat_jenis']    
					 );  
					 $this->db->insert('data_jenis_pekerjaan',$dokumen);
					}
				}

				public function BackupInputPilihan(){
					$strJsonFileContents = file_get_contents("./backup/data_input_pilihan.json");
					$array = json_decode($strJsonFileContents, true);
					for($a=0; $a<count($array); $a++){	
						$id_meta =  str_replace("M_","",$array[$a]['id_data_meta']);
						$dokumen = array(
							'id_data_input_pilihan'	          		=> "O_".str_pad($array[$a]['id_data_input_pilihan'], 4 ,"0",STR_PAD_LEFT),    
							'id_data_meta'       					=> "M_".str_pad($id_meta, 4 ,"0",STR_PAD_LEFT),    
							'jenis_pilihan'       					=> $array[$a]['jenis_pilihan']    
					 );  
					 $this->db->insert('data_input_pilihan',$dokumen);
					}
				}

				public function BackupDataMeta(){
					$strJsonFileContents = file_get_contents("./backup/data_meta.json");
					$array = json_decode($strJsonFileContents, true);
					for($a=0; $a<count($array); $a++){	
						$id_meta =  str_replace("M_","",$array[$a]['id_data_meta']);
						$dokumen = array(
						   'id_data_meta'       					=> "M_".str_pad($id_meta, 4 ,"0",STR_PAD_LEFT),    
							'no_nama_dokumen'       				=> $array[$a]['no_nama_dokumen'],    
							'nama_meta'       						=> $array[$a]['nama_meta'],    
							'jenis_inputan'       					=> $array[$a]['jenis_inputan'],    
							'maksimal_karakter'       				=> $array[$a]['maksimal_karakter'],    
							'jenis_bilangan'       					=> $array[$a]['jenis_bilangan']    
					 );  
					$this->db->insert('data_meta',$dokumen);
					}
				}

public function UpdateNoIdentitas(){
	   $this->db->select('data_client.no_client,
	   data_client.nama_client,
	   data_client.no_identitas');
	   $this->db->like('data_client.no_identitas','no_identitas');
	   $this->db->or_like('data_client.no_identitas','tidak ada npwp');
	   $this->db->or_like('data_client.no_identitas','gak ada npwp');
	   $data = $this->db->get('data_client');
$n=1;
foreach($data->result_array() as $d){
	$no_npwp      =  "99999".str_pad($n++,10 ,0,STR_PAD_LEFT);
	$datae = array(
	'no_identitas' =>$no_npwp
	);

	 $this->db->update('data_client',$datae,array('no_client'=>$d['no_client']));

	}
}	

public function UpdatePekerjaan(){
	$data = $this->db->get_where('data_pekerjaan',array('no_bantek !='=>NULL));

	foreach($data->result_array() as $z){
		
		$d = array('no_bantek'		=>NULL,
		'no_petugas_arsip'=>NULL,
		'tanggal_arsip'	=>NULL
	
	   );
	   $this->db->update('data_pekerjaan',$d,array('no_client'=>$z['no_client']));

	}


}
				

}
