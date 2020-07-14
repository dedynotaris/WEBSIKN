
<div class="container-fluid">
<div class="row">
	
    <div class="col-md-4 "><a  style="text-decoration:none;" href="<?php echo base_url('User3/') ?>">
<div class="bg-info mt-2 text-white rounded-top">
<div class="p-2">

<svg class='float-right' width="4.5em" height="4.5em" viewBox="0 0 16 16" class="bi bi-clipboard-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
  <path fill-rule="evenodd" d="M9.5 1h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3zM8 7a.5.5 0 0 1 .5.5V9H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V10H6a.5.5 0 0 1 0-1h1.5V7.5A.5.5 0 0 1 8 7z"/>
</svg>

Daftar Dokumen Perizinan yang baru masuk <br>
<h4>&nbsp;</h4>
</div>
<div class="text-dark bg-light p-2"  >Total Perizinan dalam antrian  <div class="float-right">
<?php echo $this->db->get_where('data_berkas_perizinan',array('no_user_perizinan'=>$this->session->userdata('no_user'),'status_berkas'=>'Masuk'))->num_rows(); ?>   
</div></div>
</div></a>	
</div>	


    <div class="col-md-4  " ><a   style="text-decoration:none;"  href="<?php echo base_url('User3/halaman_proses') ?>">
<div class="bg-info mt-2 text-white rounded-top">
<div class="p-2">
<svg class='float-right' width="4.5em" height="4.5em" viewBox="0 0 16 16" class="bi bi-clipboard-data" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
  <path fill-rule="evenodd" d="M9.5 1h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
  <path d="M4 11a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0v-1zm6-4a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0V7zM7 9a1 1 0 0 1 2 0v3a1 1 0 1 1-2 0V9z"/>
</svg>
Daftar dokumen perizinan  sedang dalam proses <br>
<h4>&nbsp;</h4>
</div>
<div class="text-dark bg-light p-2"  >Total Perizinan sedang di kerjakan
<div class="float-right">
<?php echo $this->db->get_where('data_berkas_perizinan',array('no_user_perizinan'=>$this->session->userdata('no_user'),'status_berkas'=>'Proses'))->num_rows(); ?>   
    
</div>
</div>
</div>	</a>
</div>

<div class="col-md-4 ">
<a  style="text-decoration:none;" href="<?php echo base_url('User3/halaman_selesai') ?>">
<div class="bg-info mt-2 text-white rounded-top">
<div class="p-2">
<svg  class='float-right' width="4.5em" height="4.5em" viewBox="0 0 16 16" class="bi bi-clipboard-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
  <path fill-rule="evenodd" d="M9.5 1h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3zm4.354 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
</svg>
Daftar Dokumen Perizinan yang telah selesai<br>
<h4>&nbsp;</h4>
</div>
<div class="text-dark bg-light p-2"  >Total Perizinan selesai di kerjakan <div class="float-right">
<?php echo $this->db->get_where('data_berkas_perizinan',array('no_user_perizinan'=>$this->session->userdata('no_user'),'status_berkas'=>'Selesai'))->num_rows(); ?>   

</div></div>
</div>	
</div></a>	
</div>	
</div>