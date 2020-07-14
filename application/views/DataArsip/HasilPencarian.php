<body  class="d-flex flex-column" onload="search();">    
<div class="container-fluid bg-light " id='navbar' style="background: url(<?php echo base_url('assets') ?>/bg_login.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;" >
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
color:#17a2b8;
background-color: #fff;
background-clip: padding-box;
border: 1px solid #ced4da;
border-radius: 2.25rem;
transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}

.form-search:hover {
-webkit-box-shadow: 1px 1px 1px 1px #17a2b8;
-moz-box-shadow: 1px 1px 1px 1px #17a2b8;
box-shadow: 1px 1px 4px 1px #17a2b8;

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
box-shadow: 0 0 0 0.1rem #343a40;
}
.btn:hover {
color: cornflowerblue;
text-decoration: none;
}
.bg-lightaktif {
background-color: #343a40 !important; 
color: #000;
}

.sortable{
    cursor: pointer;
}

.hasil_data {
cursor: pointer;  
background-color:"#f60";  
}

.hasil_data:hover {
  background-color: #f8f9fa !important;
}
.hover:hover {
  -webkit-transform: scale(1.3);
        -ms-transform: scale(1.3);
        transform: scale(1.3);
cursor: pointer;  
color:"#f60";
}


body {
  height: 100%;
}

#page-content {
  flex: 1 0 auto;
}

#sticky-footer {
  flex-shrink: none;
}

</style>
<div class="col-md-2 p-3" >
<a href="<?php echo base_url() ?>"><img style='width:200px;' class="mx-auto bg-light rounded p-1" src='<?php echo base_url('assets/iconc.png') ?>'></a>   
</div>

<div class="col align-items-center d-flex ">
<form class="input-group " method="get" style="margin-bottom:0; width:100%; " action="<?php echo base_url('DataArsip/Pencarian/') ?>">
<div class="input-group col">
<input name="search" class="form-search py- border-right-0 border" value="<?php echo $this->input->get('search') ?>" type="text" placeholder="Masukan Nama Peroranngan atau Badan Hukum" id="example-search-input">
<input type="hidden" name="kategori" value="data_client">
<span class="input-group-append">
<button type="submit" class="btn  btn-tranparent border-left-0" type="button">
<i class="fa fa-search"></i>
</button>
</span>
</div>
</form>
</div>

<div class="col-md-2  d-flex justify-content-end ">
<div class="btn-group dropup pull-right ">
<button type="button" class="btn btn-tranparent " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<i style="font-size: 1.4em;" class="fas fa-th text-theme1"></i>
</button>
<div class="dropdown-menu dropdown-menu-right pb-0 pt-0 bg-white "  style="width:320px;">
<div class="row ">

<div class="col-6 text-center text-lowercase" onclick="check_akses('Level 1','User1');" >
<div class='
<?php 

$notaris = $this->db->get_where('sublevel_user',array('no_user'=>$this->session->userdata('no_user'),'sublevel'=>'Level 1'));
if($notaris->num_rows() >0){
  echo "text-info hover";
}else{
  echo "text-dark";  
}
?>

p-3'>
<i class=" fas fa-user-tie fa-2x"></i>
<br>Notaris
</div>
</div> 

<div class="col-6 text-center  text-lowercase" onclick="check_akses('Level 2','User2');" >
<div class='

<?php 

$asisten = $this->db->get_where('sublevel_user',array('no_user'=>$this->session->userdata('no_user'),'sublevel'=>'Level 2'));
if($asisten->num_rows() >0){
  echo "text-info hover";
}else{
  echo "text-dark";  
}
?>

 p-3'>
<i class="fas fa-user-edit fa-2x"></i>
<br>Divisi Asisten
</div>
</div>

<div class="col-6 text-center  text-lowercase"  onclick="check_akses('Level 3','User3');" >
<div class='<?php 

$perizinan = $this->db->get_where('sublevel_user',array('no_user'=>$this->session->userdata('no_user'),'sublevel'=>'Level 3'));
if($perizinan->num_rows() >0){
  echo " text-info hover ";
}else{
  echo " text-dark ";  
}
?>
 p-3 '><i class="fas fa-user-check fa-2x"></i><br>Divisi Perizinan</div>
</div> 

<div class="col  text-center text-lowercase" onclick="check_akses('Level 4','data_lama');" >
<div class='

<?php 

$arsip = $this->db->get_where('sublevel_user',array('no_user'=>$this->session->userdata('no_user'),'sublevel'=>'Level 4'));
if($arsip->num_rows() >0){
  echo " text-info hover ";
}else{
  echo " text-dark ";  
}
?>

 p-3  '><i class="fas fa-people-carry fa-2x"></i><br>Divisi Arsip</div>
</div> 

<div class="col-6 
 text-center  text-lowercase" onclick="check_akses('Admin','Dashboard');" >
<div class='

<?php 

$arsip = $this->db->get_where('user',array('no_user'=>$this->session->userdata('no_user'),'level'=>'Super Admin'));

if($arsip->num_rows() >0){
  echo " text-info hover ";
}else{
  echo " text-dark ";  
}
?>
 p-3 '><i class="fas fa-user-cog fa-2x"></i><br>Administrator</div>
</div> 

</div>
</div>
</div>

<div class="btn-group pull-right  ">
<button type="button" class="btn btn-transparent pull-right"  id="dropdownMenuButton" data-toggle="dropdown">    
<?php if(!file_exists('./uploads/user/'.$this->session->userdata('foto'))){ ?>
<img style="width:50px; height: 50px;  " src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class=" img rounded-circle border border-white" ><br>    
<?php }else{ ?>
<?php if($this->session->userdata('foto') != NULL){ ?>
<img style="width:50px; height: 50px;  " src="<?php echo base_url('uploads/user/'.$this->session->userdata('foto')) ?>" img="" class="img rounded-circle border border-white" ><br>    
<?php }else{ ?>
<img style="width:50px; height: 50px;  " src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class="img rounded-circle border border-white" ><br>        
<?php } ?> 
<?php } ?>

</button>

<div class="dropdown-menu dropdown-menu-right " style="width:300px;" >
<div class="text-center px-6 py-6 ">
<?php if(!file_exists('./uploads/user/'.$this->session->userdata('foto'))){ ?>
<img style="width:130px; height: 130px;  " src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class=" img rounded-circle border border-white" ><br>    
<?php }else{ ?>
<?php if($this->session->userdata('foto') != NULL){ ?>
<img style="width:130px; height: 130px;  " src="<?php echo base_url('uploads/user/'.$this->session->userdata('foto')) ?>" img="" class="img rounded-circle border border-white" ><br>    
<?php }else{ ?>
<img style="width:130px; height: 130px;  " src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class="img rounded-circle border border-white" ><br>        
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

<div id="page-content">
<div class="container" >
<div class="row mt-2">
<div class="col hasil_pencarian">
</div>
</div>
</div>
</div>

<footer id="sticky-footer" >
    <div class="container-fluid  p-3 bg-info text-white  " style="background: url(<?php echo base_url('assets') ?>/bg_login.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;">
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
    <div class="container-fluid "  >
        <div class="container">       
<div class="row " >
    <div class="col p-2 m-2 text-white" >
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
<div class="modal-header bg-info ">
<h6 class="modal-title text-white" id="titelclient"></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
    <div class="modal-body lihat_client overflow-auto" style="max-height:500px;">

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

function LihatDetailLaporanPerizinan(no_pekerjaan,no_client,no_berkas_perizinan){
  var token             = "<?php echo $this->security->get_csrf_hash() ?>";
  $.ajax({
  type:"post",
  data:"token="+token+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan+"&no_berkas_perizinan="+no_berkas_perizinan,
  url:"<?php echo base_url('DataArsip/LihatDetailLaporanPerizinan'); ?>",
  success:function(data){
  $(".detail_pekerjaan").html(data);
  }
  });
}

function LihatLaporanPerizinan(no_pekerjaan,no_client){
  var token             = "<?php echo $this->security->get_csrf_hash() ?>";
  $.ajax({
  type:"post",
  data:"token="+token+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
  url:"<?php echo base_url('DataArsip/LihatLaporanPerizinan'); ?>",
  success:function(data){
  $(".detail_pekerjaan").html(data);
  }
  });
}

function LihatLaporanPekerjaan(no_pekerjaan,no_client){
  
  var token             = "<?php echo $this->security->get_csrf_hash() ?>";
  $.ajax({
  type:"post",
  data:"token="+token+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
  url:"<?php echo base_url('DataArsip/LihatLaporanPekerjaan'); ?>",
  success:function(data){
  $(".detail_pekerjaan").html(data);
  }
  });
  }


function LihatDokumenUtama(no_pekerjaan,no_client){
  
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('DataArsip/LihatDokumenUtama'); ?>",
success:function(data){
$(".detail_pekerjaan").html(data);
}
});
}

function LihatDokumenPenunjang(no_pekerjaan,no_client){
  
  var token             = "<?php echo $this->security->get_csrf_hash() ?>";
  $.ajax({
  type:"post",
  data:"token="+token+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
  url:"<?php echo base_url('DataArsip/LihatDokumenPenunjang'); ?>",
  success:function(data){
  $(".detail_pekerjaan").html(data);
  }
  });
  }

function LihatDetailPekerjaan(no_pekerjaan,no_client){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('DataArsip/LihatDetailPekerjaan'); ?>",
success:function(data){
$(".detail_pekerjaan").html(data);
}
});
}


function LihatLampiran(nama_folder,nama_berkas){
window.open( 
  "<?php echo base_url('berkas/') ?>"+nama_folder+"/"+nama_berkas+"","_blank"); 
}

function download_utama(id_data_dokumen_utama){
window.location.href="<?php echo base_url('DataArsip/download_utama/') ?>"+btoa(id_data_dokumen_utama);
}


function FormLihatMeta(no_berkas,nama_folder,nama_berkas){

if($(".data_edit"+no_berkas).length > 0 ){
$('.'+no_berkas).slideUp("slow").remove();
}else{
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_berkas="+no_berkas+"&nama_folder="+nama_folder+"&nama_berkas="+nama_berkas,
url:"<?php echo base_url('DataArsip/FormLihatMeta') ?>",
success:function(data){
$(".data"+no_berkas).slideDown().after("<tr class="+no_berkas+"><td colspan='2'>"+data+"</tr></td>"); 

}
});
}
}

function LihatSemuaDokumen(no_client){
var token           = "<?php echo $this->security->get_csrf_hash(); ?>";
$.ajax({
type:"post",
url:"<?php echo base_url('DataArsip/LihatSemuaDokumen') ?>",
data:"token="+token+"&no_client="+no_client,
success:function(data){
$("#LihatSemua").slideUp().before(data);

}
});
}

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
navbar.classList.add("fixed-top")
navbar.classList.add("shadow-sticky")
} else {
navbar.classList.remove("fixed-top")
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





function BukaClientBaru(no_client){
Swal.fire({
  text: "Fungsi Ini Akan menampilkan client tersebut,kamu yakin ingin berpindah client ?",
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