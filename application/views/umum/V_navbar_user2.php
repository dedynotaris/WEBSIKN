<nav class="navbar navbar-expand-lg navbar-light bg-theme border-bottom">
<div class="row col-md-12 align-items-center">
<div class="col-md-2">
<button class="btn btn-success" id="menu-toggle"><span id="z" class="fa fa-chevron-left"> </span> Menu</button>
<button class="navbar-toggler float-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
</div>
        
<div class="col-md-7 mx-auto ">
<div class="input-group">
<input type="text" id="pencarian" class="form-control" placeholder="Cari Dokumen ..." aria-label="Recipient's username" aria-describedby="button-addon2">
  <div class="input-group-append">
      <button class="btn btn-success" type="button" id="button-addon2"><span class="fa fa-search"</button>
  </div>
</div>


</div>

<div class="col-md-3 float-right">
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
<a class="dropdown-item" href="<?php echo base_url('User2/profil') ?>">Profil</a>
<a class="dropdown-item" href="<?php echo base_url('User2/riwayat_pekerjaan') ?>">Histori pekerjaan</a>
<div class="dropdown-divider"></div>
<a class="dropdown-item" href="<?php echo base_url('User2/keluar') ?>">Keluar</a>
</div>
</li>
</ul>
</div> 
</div>
    
</div>
</nav>


<div class="container-fluid">
<div class="row">
<div class="col-md-4 "><a   style="text-decoration:none;" href="<?php echo base_url('User2/pekerjaan_antrian') ?>">
<div class="bg_data rounded-top">
<div class="p-2">
<span class="	fa fa-hourglass-start float-right fa-3x sticky-top"></span>
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
<span class="fa fa-hourglass-half float-right fa-3x sticky-top"></span>
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
<span class="fa fa-hourglass-end float-right fa-3x sticky-top"></span>
Out <br>
<h4>&nbsp;</h4>
</div>
<div class="footer p-2 bg_data_bawah" >Dokumen Diselesaikan <div class="float-right">
<?php echo $this->db->get_where('data_pekerjaan',array('no_user'=>$this->session->userdata('no_user'),'status_pekerjaan'=>"Selesai" ))->num_rows(); ?>   

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
url:'<?php echo base_url('User2/set_toggled') ?>',
data:"token="+token,
success:function(data){
console.log(data);    
}    
});
        
}
</script> 