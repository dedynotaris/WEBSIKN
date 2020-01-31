<div class="container-fluid">
<div class="row">

<div class="col-md-4 mb-1 "><a  style="text-decoration:none;" href="<?php echo base_url('User1/pekerjaan_masuk') ?>">
<div class="bg_data rounded-top">
<div class="p-2">
<span class="fa fa-share-square float-right fa-3x sticky-top"></span>
In <br>
<h4>&nbsp;</h4>
</div>
<div class="footer p-2 bg_data_bawah" >Pekerjaan Masuk  <div class="float-right">
<?php echo $this->db->get_where('data_pekerjaan',array('status_pekerjaan'=>'Masuk'))->num_rows(); ?>   
</div>
</div>
</div></a>	
</div>	


	

<div class="col-md-4  mb-1"><a  style="text-decoration:none;" href="<?php echo base_url('User1/halaman_proses') ?>">
<div class="bg_data rounded-top">
<div class="p-2">
<span class="fa fa-retweet float-right fa-3x sticky-top"></span>
 <br>
<h4>&nbsp;</h4>
</div>
<div class="footer p-2 bg_data_bawah" >Pekerjaan diproses 
<div class="float-right">
<?php echo $this->db->get_where('data_pekerjaan',array('status_pekerjaan'=>'Proses'))->num_rows(); ?>   
</div>
</div>
</div></a>	
</div>	


<div class="col-md-4 mb-1"><a  style="text-decoration:none;" href="<?php echo base_url('User1/halaman_selesai') ?>">
<div class="bg_data rounded-top">
<div class="p-2">
<span class="fa fa-flag float-right fa-3x sticky-top"></span>
Out <br>
<h4>&nbsp;</h4>
</div>
<div class="footer p-2 bg_data_bawah" >Pekerjaan diselesaikan <div class="float-right">
<?php echo $this->db->get_where('data_pekerjaan',array('status_pekerjaan'=>'Selesai'))->num_rows(); ?>   
</div>
</div>
</div></a>	
</div>	
</div>
  <style>
    .active{
      color: #116466 !important;
    }
    .noactive{
      color: #116466 !important
    }
    .divider{
        color:#116466 !important;  
        
    }    
</style>
  
<nav aria-label="breadcrumb">
	  <?php echo $this->breadcrumbs->show(); ?>

</nav>    
</div>
