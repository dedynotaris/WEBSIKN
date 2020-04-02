<body onload="search();">    
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
-webkit-box-shadow: 1px 1px 1px 1px #dc3545;
-moz-box-shadow: 1px 1px 1px 1px #dc3545;
box-shadow: 1px 1px 4px 1px #dc3545;

}
.ui-autocomplete {
max-height: 500px;
overflow-y: auto;
overflow-x: hidden;
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
box-shadow: 0 0 0 0.1rem #fd7e14;
}
.btn:hover {
color: cornflowerblue;
text-decoration: none;
}
.bg-lightaktif {
background-color: #fd7e14 !important; 
color: #000;
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
<button type="submit" class="btn  btn-tranparent border-left-0" type="button">
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
<img style="width:40px; height: 40px;  border:2px solid #dc3545;" src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class=" img rounded-circle dropdown-toggle pull-right"  id="dropdownMenuButton" data-toggle="dropdown"  ><br>    
<?php }else{ ?>
<?php if($this->session->userdata('foto') != NULL){ ?>
<img style="width:40px; height: 40px;  border:2px solid #dc3545;" src="<?php echo base_url('uploads/user/'.$this->session->userdata('foto')) ?>" img="" class="img rounded-circle  dropdown-toggle pull-right" id="dropdownMenuButton" data-toggle="dropdown"  ><br>    
<?php }else{ ?>
<img style="width:40px; height: 40px;  border:2px solid #dc3545;" src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class="img rounded-circle dropdown-toggle pull-right"  id="dropdownMenuButton" data-toggle="dropdown"  ><br>        
<?php } ?> 
<?php } ?>
</button>

<div class="dropdown-menu dropdown-menu-right" style="width:300px;" >
<div class="text-center px-6 py-6 ">
<?php if(!file_exists('./uploads/user/'.$this->session->userdata('foto'))){ ?>
<img style="width:100px; height: 100px;  border:2px solid #dc3545;" src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class=" img rounded-circle dropdown-toggle"  id="dropdownMenuButton" data-toggle="dropdown"  ><br>    
<?php }else{ ?>
<?php if($this->session->userdata('foto') != NULL){ ?>
<img style="width:100px; height: 100px;  border:2px solid #dc3545;" src="<?php echo base_url('uploads/user/'.$this->session->userdata('foto')) ?>" img="" class=" img rounded-circle dropdown-toggle"  id="dropdownMenuButton" data-toggle="dropdown" ><br>    
<?php }else{ ?>
<img style="width:100px; height: 100px;  border:2px solid #dc3545;" src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class="img rounded-circle dropdown-toggle"  id="dropdownMenuButton" data-toggle="dropdown"  ><br>        
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

<div class="container-fluid" style="background-color:#dc3545; color:#fff;">
<div class="container">
<div class="row ">
<div class="col-md-3 mx-auto <?php if($this->input->get('kategori') == 'dokumen_penunjang'){echo "bg-lightaktif"; } ?>">
<form method="get" action="<?php echo base_url('DataArsip/Pencarian/') ?>">
<input type="hidden" class="form-control" name="<?php echo  $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
<input type="hidden" name="search" value="<?php echo $this->input->get('search') ?>">    
<input type="hidden" name="kategori" value="dokumen_penunjang">    
<button type="submit" class="btn btn-tranparent btn-block "  style="color:#fff;">Dokumen Penunjang <i class="fas fa-file-contract"></i></button>
</form>
</div>
<div class="col-md-3 mx-auto <?php if($this->input->get('kategori') == 'dokumen_utama'){echo "bg-lightaktif"; } ?>">

<form method="get" action="<?php echo base_url('DataArsip/Pencarian/') ?>">
<input type="hidden" class="form-control" name="<?php echo  $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
<input type="hidden" name="search" value="<?php echo $this->input->get('search') ?>">    
<input type="hidden" name="kategori" value="dokumen_utama">    
<button type="submit" class="btn btn-tranparent btn-block " style="color:#fff;">Dokumen Utama <i class="fas fa-file-alt"></i> </button>
</form>

</div>
<div class="col-md-3 mx-auto <?php if($this->input->get('kategori') == 'data_client'){echo "bg-lightaktif"; } ?>">
<form method="get" action="<?php echo base_url('DataArsip/Pencarian/') ?>">
<input type="hidden" class="form-control" name="<?php echo  $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
<input type="hidden" name="search" value="<?php echo $this->input->get('search') ?>">    
<input type="hidden" name="kategori" value="data_client">    
<button type="submit" class="btn btn-tranparent btn-block " style="color:#fff;">Data Client <i class="fas fa-users"></i></button>
</form>
</div>
</div>
</div>
</div>    
<div class="container">
<div class="row mt-2">
<div class="col-md-8  hasil_pencarian">
</div>
<div class="col">
<div class='card'>
<div class="card-header text-center">Detail Hasil Pencarian</div>
<div class='card-body'>
Jumlah Dokumen Penujang  : 
<?php 
$this->db->select('data_meta_berkas.nama_meta,'
.'data_meta_berkas.value_meta');
$this->db->from('data_meta_berkas');
$this->db->group_by('data_meta_berkas.no_berkas');
$this->db->like('data_meta_berkas.value_meta',$this->input->get('search'));
echo $this->db->get()->num_rows();
?>
<br><hr>
Jumlah Dokumen Utama     : 
<?php 
$this->db->select('data_dokumen_utama.nama_berkas');
$this->db->from('data_dokumen_utama');
$this->db->like('data_dokumen_utama.nama_berkas',$this->input->get('search'));
echo $this->db->get()->num_rows();
?>
<br><hr>
Jumlah Client            : 
<?php 
$this->db->select('data_client.nama_client');
$this->db->from('data_client');
$this->db->like('data_client.nama_client',$this->input->get('search'));
echo  $this->db->get()->num_rows();
?>
<br>
</div>
</div>
</div>    
</div>
</div>    

    <div class="container-fluid  p-3  " style="margin-top:7%; background-color: #fd7e14; color:#fff; ">
<div class="container">
<div class ="row p-2 " >
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
    <div class="container-fluid" style="background-color:#dc3545;">
        <div class="container">       
<div class="row " >
    <div class="col p-2 m-2 " style="color:#fff;">
&COPY; 2020 
SIKN Notaris Dewantari Handayani,SH, MPA
</div>
</div>
</div>  
</div>
    
</div>
<!-- Modal -->
<div class="modal fade" id="LihatClient" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl" role="document">
<div class="modal-content">
<div class="modal-header ">
<h6 class="modal-title" id="titelclient"></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
    <div class="modal-body lihat_client overflow-auto" style="max-height:500px;">

</div>
</div>
</div>
</div>        

<!-- Modal keterlibatan -->
<div class="modal fade" id="ModalKeterlibatan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl" role="document">
<div class="modal-content">
<div class="modal-header ">
<h6 class="modal-title" id="titelterlibat"></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
    <div class="modal-body lihat_keterlibatan overflow-auto" style="max-height:500px;">

</div>
</div>
</div>
</div>        


<!-- Modal -->
<div class="modal fade" id="DataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl" role="document">
<div class="modal-content">
<div class="modal-header">
<h6 class="modal-title" id="judul">Modal title</h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<div class="embed-responsive embed-responsive-16by9 data_link">

</div>
</div>
</div>
</div>
</div>   


</body>

<script>

function LihatFile(jenis_dokumen,no_dokumen){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&jenis_dokumen="+jenis_dokumen+"&no_dokumen="+no_dokumen,
url:"<?php echo base_url('DataArsip/BukaFile'); ?>",
success:function(data){
var r = JSON.parse(data);
if(r[0].status == 'Dokumen Lihat'){
$("#judul").html(r[0].titel);
$(".data_link").html(r[0].link);
$('#DataModal').modal('show');
}else{
window.location.href=r[0].link;
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated zoomInDown'
});

Toast.fire({
type: 'success',
title: r[0].messages,
});
}

}
});
} 

function set_page(){   
$('#pagination').on('click','a',function(e){
e.preventDefault(); 
var pageno = $(this).attr('href');
next_page(pageno);
});
}



function next_page(url){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
var kata_kunci        = '<?php echo $this->input->get('search') ?>';
var kategori          = "<?php echo $this->input->get('kategori') ?>";
$.ajax({
type:"get",
data:"token="+token+"&search="+kata_kunci+"&kategori="+kategori,
url:url,
success:function(data){
$(".hasil_pencarian").html(data);
set_page();
}
});
}

function search(){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
var kata_kunci        = '<?php echo $this->input->get('search') ?>';
var url               = "<?php echo base_url('DataArsip/ProsesPencarian/') ?>"; 
var kategori          = "<?php echo $this->input->get('kategori') ?>";
$.ajax({
type:"get",
data:"token="+token+"&search="+kata_kunci+"&kategori="+kategori,
url:url,
success:function(data){
$(".hasil_pencarian").html(data);
set_page();
}
});

}

function check_akses(model,model2){
var token = "<?php echo $this->security->get_csrf_hash(); ?>";      

$.ajax({
type:"post",
url:"<?php echo base_url('DataArsip/check_akses') ?>",
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

function LihatClient(no_client){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_client="+no_client,
url:"<?php echo base_url('DataArsip/LihatClient'); ?>",
success:function(data){
var r = JSON.parse(data);

$("#titelclient").html(r[0].titel);
$(".lihat_client").html(r[0].linkhtml);
$('#LihatClient').modal('show');

}
});
}
function LihatDokumenUtama(no_pekerjaan,no_client){
var $attrib = $("#"+no_pekerjaan);
if($('#toggle'+no_pekerjaan).length > 0 ){
$('#toggle'+no_pekerjaan).slideUp("slow").remove();
$(".btnutama"+no_pekerjaan).addClass("btn-light").removeClass( "btn-info" ).html("Lihat <i class='fa fa-eye'></i>");
}else{
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('DataArsip/LihatDokumenUtama'); ?>",
success:function(data){
$("#"+no_pekerjaan).slideDown().after(data);
$(".btnutama"+no_pekerjaan).addClass("btn-info").removeClass( "btn-light" ).html("Tutup <i class='fa fa-times-circle'></i>");
}
});
}    
}


function LihatTerlibat(no_pekerjaan,no_client){
var $attrib = $("#"+no_pekerjaan);
if($('#terlibat'+no_pekerjaan).length > 0 ){
$('#terlibat'+no_pekerjaan).slideUp("slow").remove();
$(".btnterlibat"+no_pekerjaan).addClass("btn-light").removeClass( "btn-primary" ).html("Lihat <i class='fa fa-eye'></i>");
}else{
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('DataArsip/LihatPihakTerlibat'); ?>",
success:function(data){
$("#"+no_pekerjaan).slideDown().after(data);
$(".btnterlibat"+no_pekerjaan).addClass("btn-primary").removeClass( "btn-light" ).html("Tutup <i class='fa fa-times-circle'></i>");
}
});
}    

}
function LihatKeterlibatan(no_client,no_client_awal){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_client="+no_client+"&no_client_awal="+no_client_awal,
url:"<?php echo base_url('DataArsip/LihatKeterlibatan'); ?>",
success:function(data){
var r = JSON.parse(data);

$("#titelterlibat").html(r[0].titel);
$(".lihat_keterlibatan").html(r[0].linkhtml);
$('#ModalKeterlibatan').modal('show');

}
});

}
function LihatClientBaru(no_pekerjaan,no_client){
        
var $attrib = $("#"+no_pekerjaan);
if($('#terlibat'+no_pekerjaan).length > 0 ){
$('#terlibat'+no_pekerjaan).slideUp("slow").remove();
$(".btnterlibat"+no_pekerjaan).addClass("btn-light").removeClass( "btn-primary" ).html("Lihat <i class='fa fa-eye'></i>");
}else{
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('DataArsip/LihatPihakTerlibatKedua'); ?>",
success:function(data){
$("#"+no_pekerjaan).slideDown().after(data);
$(".btnterlibat"+no_pekerjaan).addClass("btn-primary").removeClass( "btn-light" ).html("Tutup <i class='fa fa-times-circle'></i>");
}
});
}    
}
function BukaClientBaru(no_client){
Swal.fire({
  text: "kamu yakin ingin berpindah client ?",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Ya, Yakin!'
}).then((result) => {
  if (result.value) {
    LihatClient(no_client);
  $('#ModalKeterlibatan').modal('hide');
}
});
}

function PengaturanAkun(){
window.location.href="<?php echo base_url('DataArsip/PengaturanAkun') ?>";    
}


</script>