
<div class="container-fluid">
<div class="row">
	
    <div class="col-md-4 "><a  style="text-decoration:none;" href="<?php echo base_url('User3/') ?>">
<div class="bg_data rounded-top">
<div class="p-2">
<span class="fa fa-share-square float-right fa-3x sticky-top"></span>
In <br>
<h4>&nbsp;</h4>
</div>
<div class="footer p-2 bg_data_bawah" >Perizinan dalam antrian  <div class="float-right">
<?php echo $this->db->get_where('data_berkas_perizinan',array('no_user_perizinan'=>$this->session->userdata('no_user'),'status_berkas'=>'Masuk'))->num_rows(); ?>   
</div></div>
</div></a>	
</div>	


    <div class="col-md-4  " ><a   style="text-decoration:none;"  href="<?php echo base_url('User3/halaman_proses') ?>">
<div class="bg_data rounded-top">
<div class="p-2">
<span class="fa fa-retweet float-right fa-3x sticky-top"></span>
Proses <br>
<h4>&nbsp;</h4>
</div>
<div class="footer p-2 bg_data_bawah" >Perizinan sedang dikerjakan
<div class="float-right">
<?php echo $this->db->get_where('data_berkas_perizinan',array('no_user_perizinan'=>$this->session->userdata('no_user'),'status_berkas'=>'Proses'))->num_rows(); ?>   
    
</div>
</div>
</div>	</a>
</div>

<div class="col-md-4 "><a  style="text-decoration:none;" href="<?php echo base_url('User3/halaman_selesai') ?>">
        <div class="bg_data rounded-top" style="text-decoration:none;">
<div class="p-2">
<span class="fab fa-font-awesome-flag float-right fa-3x sticky-top"></span>
Out <br>
<h4>&nbsp;</h4>
</div>
<div class="footer p-2 bg_data_bawah" >Perizinan selesai dikerjakan <div class="float-right">
<?php echo $this->db->get_where('data_berkas_perizinan',array('no_user_perizinan'=>$this->session->userdata('no_user'),'status_berkas'=>'Selesai'))->num_rows(); ?>   

</div></div>
</div>	
</div></a>	
</div>	
</div>