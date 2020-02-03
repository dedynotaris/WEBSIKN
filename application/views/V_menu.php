<style>
      @font-face {
font-family: "fontweb";
src: url("<?php echo base_url('assets/fontku')?>/breeserif-regular-webfont.woff");
}

</style>

<body  style="background: url(<?php echo base_url('assets') ?>/bg_login.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
  font-family: 'fontweb', Arial, sans-serif;
                                " >
    
<div class="container">
    <div class="row text-center mt-1 pt-5" style="color: #116466 ;"  >
        <div class="col"><p><h3 style="color:#FF8C00; 
                                font-size: 35px; "> Selamat Datang <?php echo $this->session->userdata("nama_lengkap"); ?></h3><h5>Aplikasi Management Document Tempat penyimpanan dokumen  untuk mempermudah anda <br> dalam mengelola dan mencari dokumen<h5> </p></div>
    </div>
    
    <?php $status_app = $status_aplikasi->row_array(); ?>
    <div class="row text-center mt-5 " >
      
        <?php if($status_app['app_workflow'] == "on"){ ?>
        <div class="col-md-2 mt-5 mx-auto">
            <a class="menu_utama" onclick="check_akses('Level 2','User2');"> 
           <i class="fas fa-file fa-5x"></i><br>Dokumen Utama
        </a>
        </div>
        
        <div class="col-md-2 mt-5 mx-auto" >
        <a  class="menu_utama" onclick="check_akses('Level 3','User3');"> 
            <i class="fas fa-folder-open fa-5x"></i><br>Dokumen Penunjang
        </a>
        </div>   
      <?php } ?>
       
        
        <?php if($status_app['app_resepsionis'] == "on"){ ?>
        <div class="col-md-2 mt-5 mx-auto">
        <a class="menu_utama" onclick="check_akses('Level 4','Resepsionis');"> 
            <span class="fa fa-address-book fa-5x"></span><br>Receptionist
         </a>    
       </div>
       <?php } ?>
        
        <div class="col-md-2 mt-5 mx-auto">
        <a  class="menu_utama" href="<?php echo base_url('DataArsip'); ?>"> 
            <span class="fa fa-upload fa-5x"></span><br>Data Arsip
        </a>    
        </div>
        
       
         <?php if($status_app['app_admin'] == "on"){ ?>
        <div class="col-md-2 mt-5 mx-auto">
        <a class="menu_utama" onclick="check_akses('Level 1','User1');"> 
            <span class="fa fa-user-cog fa-5x"></span><br>Admin
         </a>    
       </div>
       <?php } ?>
         
       <?php if($this->session->userdata('level') == "Super Admin"){ ?>  
        <div class="col-md-2 mt-5 mx-auto">
        <a  class="menu_utama" onclick="check_akses('Admin','Dashboard');"> 
            <span class="fa fa-cogs fa-5x"></span><br>Setting
        </a>    
        </div>
       <?php } ?>
        
      
    </div>
    <div class="mt-5 pt-5">
<div class="row mt-5">
<div class="mx-auto">    
    <p class="text-center">App Management Document <br> V.2.1</p>
</div>
</div>
</div>
 </div>

<script type="text/javascript">
function check_akses(model,model2){
var token = "<?php echo $this->security->get_csrf_hash(); ?>";      
    
$.ajax({
type:"post",
url:"<?php echo base_url('Menu/check_akses') ?>",
data:"token="+token+"&model="+model,
success:function(data){
var r = JSON.parse(data);

if(r.status == 'error'){
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated zoomInDown'
});

Toast.fire({
type: r.status,
title: r.pesan,
});

}else{
window.location.href="<?php  echo base_url()?>"+model2
}

}

});


}
</script>    


<style>


.menu_utama {
color: #116466  !important;
cursor:pointer;
}

.menu_utama:hover{
color: #FF8C00 !important;  
text-decoration: none;
}

</style>

</body>


  