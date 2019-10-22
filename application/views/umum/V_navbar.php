<style>
form {
    display: inherit;
    width: inherit;
    margin-bottom: 0;
}    
</style>    
<nav class="navbar navbar-expand-lg navbar-light bg-theme border-bottom">
<div class="row col-md-12 align-items-center">
<div class="col-xs-2">
<button class="btn btn-success" id="menu-toggle"><span id="z" class="fa fa-chevron-left"> </span> Menu</button>
</div>
<div class="col mx-auto ">
<div class="input-group">
    <form id="button_cari" action="<?php echo base_url($this->uri->segment(1)."/cari_file/") ?>" method="post" >       
        <input type="hidden" class="form-control" name="<?php echo  $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
        <input type="text" required="" name="kata_kunci" id="pencarian" class="form-control" placeholder="Cari Dokumen, Client, dan Akta" aria-label="Recipient's username" aria-describedby="button-addon2">
  <div class="input-group-append">
      <button   class="btn btn-success" type="submit" ><span class="fa fa-search"</button>
  </form>
</div>
</div>
</div>

<div class="col-xs-2 float-right"><button class="navbar-toggler float-md-right float-xs-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="navbar-nav ml-auto mt-2 mt-lg-0">
<li class="nav-item active">
<a class="nav-link" href="<?php echo base_url() ?>">Beranda <span class="fa fa-home "></span></a>
</li>
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
Pilihan
</a>
<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
<a class="dropdown-item" href="<?php echo base_url('Dashboard/profil') ?>">Profil</a>
<a class="dropdown-item" href="<?php echo base_url('Dashboard/riwayat_pekerjaan') ?>">Histori pekerjaan</a>
<div class="dropdown-divider"></div>
<a class="dropdown-item" href="<?php echo base_url('Dashboard/keluar') ?>">Keluar</a>
</div>
</li>
</ul>
</div> 
</div>
    
</div>
</nav>


<div class="container-fluid">
<div class="row">
<div class="col-md-3"><a   style="text-decoration:none;" href="<?php echo base_url('Dashboard/data_berkas') ?>">
<div class="bg_data rounded-top">
<div class="p-2">
<span class="fa fa-file-word float-right fa-3x sticky-top"></span>
Data berkas <br>
<h4>&nbsp;</h4>
</div>
<div class="footer p-2 bg_data_bawah">total data berkas<div class="float-right">
    <?php 
$query3 = $this->db->get_where('data_berkas',array('pengupload !='=>NULL))->num_rows();

echo $query3;
?>
</div></div>
</div></a>	
</div>	
<div class="col-md-3 "><a  style="text-decoration:none;" href="<?php echo base_url('Dashboard/data_client') ?>">
<div class="bg_data rounded-top">
<div class="p-2">
<span class="fa fa-user-tie float-right fa-3x sticky-top"></span>
Data client <br>
<h4>&nbsp;</h4>
</div>
<div class="footer p-2 bg_data_bawah">Total data client  <div class="float-right">
    <?php 
$query1 = $this->db->get('data_client')->num_rows();

echo $query1;
?>
</div></div>
</div></a>	
</div>	


<div class="col-md-3  "><a  style="text-decoration:none;" href="<?php echo base_url('Dashboard/pekerjaan_proses') ?>">
<div class="bg_data rounded-top">
<div class="p-2">
<span class="fa fa-exchange-alt float-right fa-3x sticky-top"></span>
Pekerjaan diproses<br>
<h4>&nbsp;</h4>
</div>
<div class="footer p-2 bg_data_bawah">Total pekerjaan diproses 
<div class="float-right"><?php 
$query = $this->db->get_where('data_pekerjaan',array('status_pekerjaan'=>"Proses"))->num_rows();

echo $query;
?>
</div>
</div>
</div>	</a>
</div>

<div class="col-md-3 "><a  style="text-decoration:none;" href="<?php echo base_url('Dashboard/data_user') ?>">
<div class="bg_data rounded-top">
<div class="p-2">
<span class="fa fa-users float-right fa-3x sticky-top"></span>
Data user <br>
<h4>&nbsp;</h4>
</div>
<div class="footer p-2 bg_data_bawah" >Total data user <div class="float-right">
<?php 
$query2 = $this->db->get('user')->num_rows();
echo $query2;
?>
</div></div>
</div></a>	
</div>	

</div>	
</div>

<script type="text/javascript">
$("#menu-toggle").click(function(e) {
e.preventDefault();
$("#wrapper").toggleClass("toggled");
var cek_icon = $(".fa-chevron-left").html();
if(cek_icon != undefined){
$("#z").addClass("fa-chevron-right");
set_toggled();
}else{
$("#z").addClass("fa-chevron-left");
set_toggled();
}



});
function set_toggled(){
var <?php echo $this->security->get_csrf_token_name();?>  = "<?php echo $this->security->get_csrf_hash(); ?>";      
    
$.ajax({
type:"post",
url:'<?php echo base_url('Dashboard/set_toggled') ?>',
data:"token="+token,
success:function(data){
console.log(data);    
}    
});
        
}
</script> 