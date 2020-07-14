<div class="container-fluid">
<div class="row">
<div class="col-md-4 "><a   style="text-decoration:none;" href="<?php echo base_url('User2/pekerjaan_antrian') ?>">
<div class="bg-info mt-2 text-white rounded-top">
<div class="p-2">
<svg  class="float-right" width="4.5em" height="4.5em" viewBox="0 0 16 16" class="bi bi-cloud-plus-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2zm.5 4a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V10a.5.5 0 0 0 1 0V8.5H10a.5.5 0 0 0 0-1H8.5V6z"/>
</svg>
Tahapan Persyaratan Dokumen Penunjang <br>
<h4>&nbsp;</h4>
</div>
<div class="text-dark bg-light p-2" >Upload Dokumen Penunjang  <div class="float-right">
<?php echo $this->db->get_where('data_pekerjaan',array('no_user'=>$this->session->userdata('no_user'),'status_pekerjaan'=>"Masuk" ))->num_rows(); ?>   
   
</div></div>
</div></a>	
</div>	


<div class="col-md-4  "><a  style="text-decoration:none;" href="<?php echo base_url('User2/pekerjaan_proses') ?>">
<div class="bg-info mt-2 text-white rounded-top">
<div class="p-2">
<svg class="float-right" width="4.5em" height="4.5em" viewBox="0 0 16 16" class="bi bi-cloud-upload-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M8 0a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 4.095 0 5.555 0 7.318 0 9.366 1.708 11 3.781 11H7.5V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11h4.188C14.502 11 16 9.57 16 7.773c0-1.636-1.242-2.969-2.834-3.194C12.923 1.999 10.69 0 8 0zm-.5 14.5V11h1v3.5a.5.5 0 0 1-1 0z"/>
</svg>
Tahapan Membuat Dokumen Penunjang <br>
<h4>&nbsp;</h4>
</div>
<div class="text-dark bg-light p-2" >Membuat Dokumen Penunjang 
<div class="float-right">
<?php echo $this->db->get_where('data_pekerjaan',array('no_user'=>$this->session->userdata('no_user'),'status_pekerjaan'=>"Proses" ))->num_rows(); ?>   
    
</div>
</div>
</div>	</a>
</div>

<div class="col-md-4 "><a  style="text-decoration:none;" href="<?php echo base_url('User2/pekerjaan_selesai') ?>">
<div class="bg-info mt-2 text-white rounded-top">
<div class="p-2 ">
<svg class='float-right' width="4.5em" height="4.5em" viewBox="0 0 16 16" class="bi bi-cloud-check-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2zm2.354 4.854a.5.5 0 0 0-.708-.708L7 8.793 5.854 7.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>
</svg>
Daftar Pekerjaan yang sudah diselesaikan <br>
<h4>&nbsp;</h4>
</div>
<div class="text-dark bg-light p-2" >Pekerjaan  Bulan Ini <div class="float-right">
<?php 
$awal  = date('Y/m/d',strtotime("first day of this month"));
$akhir = date('Y/m/d',strtotime("last day of this month"));


$this->db->select('*');
$this->db->where('data_pekerjaan.status_pekerjaan','Selesai');
$this->db->where('data_pekerjaan.tanggal_selesai >=',$awal);
$this->db->where('data_pekerjaan.tanggal_selesai <=',$akhir);
$this->db->where('data_pekerjaan.no_user',$this->session->userdata('no_user'));

$this->db->from('data_pekerjaan');
$query2 = $this->db->get()->num_rows() ;
echo $query2;

?>
</div></div>
</div></a>	
</div>	

</div>	
</div>