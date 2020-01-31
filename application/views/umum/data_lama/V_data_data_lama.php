<div class="container-fluid">
<div class="row">
<div class="col-md-4 "><a   style="text-decoration:none;" href="<?php echo base_url('data_lama/DataArsipClient') ?>">
<div class="bg_data rounded-top">
<div class="p-2">
<span class="fas fa-inbox float-right fa-3x sticky-top"></span>
In <br>
<h4>&nbsp;</h4>
</div>
<div class="footer p-2 bg_data_bawah" >Data Arsip Client  <div class="float-right">
<?php echo $this->db->get_where('data_pekerjaan',array('status_pekerjaan'=>"ArsipMasuk" ))->num_rows(); ?>   
   
</div></div>
</div></a>	
</div>	


<div class="col-md-4  "><a  style="text-decoration:none;" href="<?php echo base_url('data_lama/DataArsipProses') ?>">
<div class="bg_data rounded-top">
<div class="p-2">
<span class="fas fa-archive float-right fa-3x sticky-top"></span>
Proses <br>
<h4>&nbsp;</h4>
</div>
<div class="footer p-2 bg_data_bawah">Upload Data Arsip
<div class="float-right">
<?php echo $this->db->get_where('data_pekerjaan',array('status_pekerjaan'=>"ArsipProses" ))->num_rows(); ?>   
</div>
</div>
</div>
</a>
</div>

<div class="col-md-4 "><a  style="text-decoration:none;" href="<?php echo base_url('data_lama/DataArsipSelesai') ?>">
<div class="bg_data rounded-top">
<div class="p-2">
<span class="fas fa-box float-right fa-3x sticky-top"></span>
Out <br>
<h4>&nbsp;</h4>
</div>
<div class="footer p-2 bg_data_bawah" >Data Arsip Selesai <div class="float-right">
<?php echo $this->db->get_where('data_pekerjaan',array('status_pekerjaan'=>"ArsipSelesai" ))->num_rows(); ?>   

</div></div>
</div></a>	
</div>	

</div>	
</div>