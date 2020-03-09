<body >    
<div class="container-fluid bg-light " id='navbar'>
<div class="row">
<style>
.form-search {
display: block;
height: calc(2.5rem + 2px);
width: 100%;
padding: 0.375rem 0.75rem;
font-size: 1rem;
font-weight: 400;
line-height: 1.5;
color: #495057;
background-color: #fff;
background-clip: padding-box;
border: 1px solid #ced4da;
border-radius: 2.25rem;
transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
.form-search:hover {
-webkit-box-shadow: 1px 1px 4px 1px rgba(0,0,0,0.30);
-moz-box-shadow: 1px 1px 4px 1px rgba(0,0,0,0.30);
box-shadow: 1px 1px 4px 1px rgba(0,0,0,0.30);
}
.ui-autocomplete {
max-height: 500px;
overflow-y: auto;
/* prevent horizontal scrollbar */
overflow-x: hidden;
/* add padding to account for vertical scrollbar */
padding-right: 20px;
}
.shadow-sticky{
box-shadow: 0 1px 6px 0 rgba(32,33,36,0.28);
}        
.input-group-append {
margin-left: -41px;
} 
form {
display: block;
margin-top: 0em;
margin-block-end: 0em;
}
.btn:focus, .btn.focus {
outline: 0;
box-shadow: 0 0 0 0.1rem cornflowerblue;
}
.btn:hover {
color: cornflowerblue;
text-decoration: none;
}
.bg-lightaktif {
background-color: #f8f9fa !important; 
color: cornflowerblue;
}

.bg-lightaktif .btn {
color: cornflowerblue;
}


</style>
<div class="col-md-2 text-right d-flex justify-content-start p-2">
<a href="<?php echo base_url() ?>"><img style='width:200px;' class="mx-auto" src='<?php echo base_url('assets/iconc.png') ?>'></a>   
</div>
<div class="col-md-6  align-items-center d-flex justify-content-start">
<form class="input-group " method="get" style="margin-bottom:0; width:100%; " action="<?php echo base_url('DataArsip/Pencarian/') ?>">
<div class="input-group col">
<input name="search" class="form-search py- border-right-0 border" value="<?php echo $this->input->get('search') ?>" type="text" placeholder="Masukan Nama Peroranngan atau Badan Hukum" id="example-search-input">
<input type="hidden" name="kategori" value="dokumen_penunjang">
<span class="input-group-append">
<button type="submit" class="btn form-search btn-tranparent border-left-0 border" type="button">
<i class="fa fa-search"></i>
</button>
</span>
</div>
</form>
</div>
<div class="col"></div> 
<div class="col-md-2   d-flex justify-content-end ">
<div class="btn-group dropup pull-right ">
<button type="button" class="btn btn-tranparent " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<i style="font-size: 1.4em;" class="fas fa-th text-theme1"></i>
</button>
<div class="dropdown-menu dropdown-menu-right p-3"  style="width:300px;">
<div class="row text-theme1 text-center text-lowercase">
<div class="col text-center mt-2 text-lowercase" onclick="check_akses('Level 1','User1');" >
<i class="fas fa-user-tie fa-2x"></i><br>Notaris
</div> 

<div class="col-md-6 text-center mt-2" onclick="check_akses('Level 2','User2');" >
<i class="fas fa-user-edit fa-2x"></i><br>Divisi Asisten
</div>

</div>
<div class="row mt-3 text-theme1 text-center text-lowercase">
<div class="col-md-6 text-center mt-2 text-lowercase"  onclick="check_akses('Level 3','User3');" >
<i class="fas fa-user-check fa-2x"></i><br>Divisi Perizinan
</div> 
<div class="col text-center mt-2 text-lowercase" onclick="check_akses('Level 4','data_lama');" >
<i class="fas fa-people-carry fa-2x"></i><br>Divisi Arsip
</div> 
</div>

<div class="row mt-3 text-theme1 text-center text-lowercase">

<div class="col-md-6 text-center mt-2 text-lowercase" onclick="check_akses('Admin','Dashboard');" >
<i class="fas fa-user-cog fa-2x"></i><br>Administrator
</div> 
<div class="col text-center mt-2 text-lowercase" onclick="check_akses('Level 5','Resepsionis');" >
<i class="fas fa-concierge-bell fa-2x"></i><br>Resepsionis
</div> 

</div>
</div>
</div>

<div class="btn-group pull-right  ">
<button class="btn btn-tranparent  pull-right"  id="dropdownMenuButton" data-toggle="dropdown">    
<?php if(!file_exists('./uploads/user/'.$this->session->userdata('foto'))){ ?>
<img style="width:40px; height: 40px;  border:2px solid darkcyan;" src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class=" img rounded-circle dropdown-toggle pull-right"  id="dropdownMenuButton" data-toggle="dropdown"  ><br>    
<?php }else{ ?>
<?php if($this->session->userdata('foto') != NULL){ ?>
<img style="width:40px; height: 40px;  border:2px solid darkcyan;" src="<?php echo base_url('uploads/user/'.$this->session->userdata('foto')) ?>" img="" class="img rounded-circle  dropdown-toggle pull-right" id="dropdownMenuButton" data-toggle="dropdown"  ><br>    
<?php }else{ ?>
<img style="width:40px; height: 40px;  border:2px solid darkcyan;" src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class="img rounded-circle dropdown-toggle pull-right"  id="dropdownMenuButton" data-toggle="dropdown"  ><br>        
<?php } ?> 
<?php } ?>
</button>

<div class="dropdown-menu dropdown-menu-right" style="width:300px;" >
<div class="text-center px-6 py-6 ">
<?php if(!file_exists('./uploads/user/'.$this->session->userdata('foto'))){ ?>
<img style="width:100px; height: 100px;  border:2px solid darkcyan;" src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class=" img rounded-circle dropdown-toggle"  id="dropdownMenuButton" data-toggle="dropdown"  ><br>    
<?php }else{ ?>
<?php if($this->session->userdata('foto') != NULL){ ?>
<img style="width:100px; height: 100px;  border:2px solid darkcyan;" src="<?php echo base_url('uploads/user/'.$this->session->userdata('foto')) ?>" img="" class=" img rounded-circle dropdown-toggle"  id="dropdownMenuButton" data-toggle="dropdown" ><br>    
<?php }else{ ?>
<img style="width:100px; height: 100px;  border:2px solid darkcyan;" src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class="img rounded-circle dropdown-toggle"  id="dropdownMenuButton" data-toggle="dropdown"  ><br>        
<?php } ?> 
<?php } ?>
<b><?php echo $this->session->userdata('nama_lengkap'); ?></b><br>
<?php echo $this->session->userdata('email'); ?>
<div class="dropdown-divider"></div>
<button onclick=PengaturanAkun(); class="btn btn-tranparent btn-md rounded">Pengaturan Akun <i class="fas fa-cogs"></i> </button>
<div class="dropdown-divider"></div>
<a href='<?php echo base_url('DataArsip/keluar') ?>'><button class="btn btn-light btn-md btn-block">Keluar <i class="fas fa-sign-out-alt"></i> </button></a>
</div>    
</div>
</div> 
</div>
</div>  
</div>



<div class="container " >
<div class="row mt-5">
<div class="col-md-12 text-center ">
<h3 class="text-success">Selamat Datang <?php echo $this->session->userdata('nama_lengkap') ?></h3>
<h5 class="text-dark">Berikut ini adalah menu untuk kamu dapat mengatur berkas, pekerjaan, dan informasi mengenai kamu </h5>
</div>    

<div class="col">    
<div class="row">    

<div class="data_menu col-sm-6 mt-5" onclick="PengaturanPersonal()">
<div class='card'>
<div class='card-body'>
<div class="row">
<div class="col">Pengaturan data personal berisi nama lengkap email dll</div>
<div class="col-md-5 text-center"><img style="width:100px; height: 100px;" src="<?php echo base_url() ?>assets/icon/setting.png" alt=""/></div>

</div>     
</div>
<div class="card-footer text-center">Pengaturan Mengenai Info Pribadi</div>
</div>
</div>

<div class="data_menu col-sm-6 mt-5">
<div class='card'>
<div class='card-body'>
<div class="row">
<div class="col">Pengaturan data pekerjaan yang telah kamu buat</div>
<div class="col-md-5 text-center"><img style="width:100px; height: 100px;" src="<?php echo base_url() ?>assets/icon/pekerjaan.png" alt=""/></div>

</div>    
</div>
<div class="card-footer text-center">Pengaturan tentang pekerjaan kamu</div>
</div>

</div>
<div class="data_menu col-sm-6 mt-5">
<div class='card'>
<div class='card-body'>
<div class="row">
<div class="col">Pengaturan data berkas yang kamu miliki</div>
<div class="col-md-5 text-center"><img style="width:100px; height: 100px;" src="<?php echo base_url() ?>assets/icon/berkas.png" alt=""/></div>

</div>    
</div>
<div class="card-footer text-center">Pengaturan Berkas yang kamu miliki</div>
</div>
</div>

<div class="data_menu col-sm-6 mt-5" >
<div class='card'>
<div class='card-body'>
<div class="row">
<div class="col">Pengaturan data pekerjaan yang telah kamu buat</div>
<div class="col-md-5 text-center"><img style="width:100px; height: 100px;" src="<?php echo base_url() ?>assets/icon/sharing.png" alt=""/></div>

</div>    
</div>
<div class="card-footer text-center">File Sharing</div>
</div>
</div>

</div>
</div>
<div class="hasil_click"></div>

</div>
</div>    

<div class="container-fluid bg-light p-3  " style="margin-top:7%;">
<div class="container">
<div class ="row p-2 " style="background-color:'#ccc;'">
<div class="col-md-7 ">Total Dokumen Penunjang<hr>
<h1><?php echo number_format($this->db->get('data_berkas')->num_rows()); ?></h1>
</div>
<div class="col">Total Dokumen Utama<hr>
<h1><?php echo number_format($this->db->get('data_dokumen_utama')->num_rows()); ?></h1>
</div>
<div class="col">Total Data Client<hr>
<h1><?php echo number_format($this->db->get('data_client')->num_rows()); ?></h1>
</div>
</div>
</div>
</div>
<div class="container-fluid" style="background-color:#D3D3D3;">
<div class="container">       
<div class="row " >
<div class="col p-2 m-2 text-theme1">
&COPY; 2020 
Notaris Dewantari Handayani SH.MPA
</div>
</div>
</div>  
</div>


<div class="modal fade" id="modal_ubah_profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Crop profile picture</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<img id="my-image" src="#" />
</div>
<div class="modal-footer">
<button id="use" class="btn btn-success btn-sm btn-block btn_upload">Upload</button>
</div>
</div>
</div>
</div>
    

<script type="text/javascript">
function PengaturanPersonal(){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token,
url:"<?php echo base_url('DataArsip/PengaturanPersonal'); ?>",
success:function(data){
$(".hasil_click").addClass("col-md-7").html(data);
$(".data_menu").addClass('col-sm-12').removeClass('col-sm-6');
}
}); 
}    


window.onscroll = function() {myFunction()};

var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;

function myFunction() {
if (window.pageYOffset > sticky) {
navbar.classList.add("sticky-top")
navbar.classList.add("shadow-sticky")
} else {
navbar.classList.remove("sticky-top")
navbar.classList.remove("shadow-sticky")
}
}

function BukaFile(){
$('#foto-input').trigger('click');
$("#foto-input").change(function() {
$('#modal_ubah_profile').modal('show');  
readURL(this);
});

}


function readURL(input) {
if (input.files ){
    
var reader = new FileReader();
reader.onload = function(e) {
$('#my-image').attr('src',e.target.result);
var resize = new Croppie($('#my-image')[0], {
enableExif: true,
 zoom: 0,
viewport: { width: 300, height: 300, type: 'circle' },
boundary: { width: 400, height: 400 },
maxZoomedCropWidth: 400,
showZoomer: true,
enableResize:true,
enableOrientation:true
});

$('.btn_upload').on('click', function() {
resize.result('base64').then(function(dataImg) {
var data = [{ image: dataImg }, { name: 'myimgage.jpg' }];
var token    = "<?php echo $this->security->get_csrf_hash() ?>";
formData = new FormData();
formData.append('token',token);
formData.append('image',dataImg);
formData.append('name',"myimage.jpg");

$.ajax({
type:"post",
processData: false,
contentType: false,
url:"<?php echo base_url('DataArsip/simpan_profile'); ?>",
data:formData,
success:function(data){
$('#modal_ubah_profile').modal('hide');  

var r = JSON.parse(data);
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated bounceInDown'
});

Toast.fire({
type: r.status,
title: r.pesan
}).then(function(){
PengaturanPersonal();
});   
}
}); 
});
});
},
reader.readAsDataURL(input.files[0]);
}
}

</script>
</body>

