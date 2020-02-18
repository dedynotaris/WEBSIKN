<div class="container-fluid">
<div class="row">
<div class="col-md-4 "><a   style="text-decoration:none;" href="<?php echo base_url('User2/pekerjaan_antrian') ?>">
<div class="bg_data rounded-top">
<div class="p-2">
<span class="	fa fa-share-square float-right fa-3x sticky-top"></span>
In <br>
<h4>&nbsp;</h4>
</div>
<div class="footer p-2 bg_data_bawah" >Pekerjaan Masuk  <div class="float-right">
<?php echo $this->db->get_where('data_pekerjaan',array('no_user'=>$this->session->userdata('no_user'),'status_pekerjaan'=>"Masuk" ))->num_rows(); ?>   
   
</div></div>
</div></a>	
</div>	


<div class="col-md-4  "><a  style="text-decoration:none;" href="<?php echo base_url('User2/pekerjaan_proses') ?>">
<div class="bg_data rounded-top">
<div class="p-2">
<span class="fa fa-retweet  float-right fa-3x sticky-top"></span>
Proses <br>
<h4>&nbsp;</h4>
</div>
<div class="footer p-2 bg_data_bawah" >Pekerjaan Dikerjakan
<div class="float-right">
<?php echo $this->db->get_where('data_pekerjaan',array('no_user'=>$this->session->userdata('no_user'),'status_pekerjaan'=>"Proses" ))->num_rows(); ?>   
    
</div>
</div>
</div>	</a>
</div>

<div class="col-md-4 "><a  style="text-decoration:none;" href="<?php echo base_url('User2/pekerjaan_selesai') ?>">
<div class="bg_data rounded-top">
<div class="p-2">
<span class="fab fa-font-awesome-flag float-right fa-3x sticky-top"></span>
Out <br>
<h4>&nbsp;</h4>
</div>
<div class="footer p-2 bg_data_bawah" >Pekerjaan Diselesaikan Bulan Ini <div class="float-right">
<?php //echo $this->db->get_where('data_pekerjaan',array('no_user'=>$this->session->userdata('no_user'),'status_pekerjaan'=>"Selesai" ))->num_rows(); ?>   
<?php 
$awal  = date('Y/m/d',strtotime("first day of this month"));
$akhir = date('Y/m/d',strtotime("last day of this month"));


$this->db->select('*');
$this->db->where('data_pekerjaan.tanggal_selesai >=',$awal);
$this->db->where('data_pekerjaan.tanggal_selesai <=',$akhir);
$this->db->from('data_pekerjaan');
$query2 = $this->db->get()->num_rows() ;
echo $query2;

?>
</div></div>
</div></a>	
</div>	

</div>	
</div>