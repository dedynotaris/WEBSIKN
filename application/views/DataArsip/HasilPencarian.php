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

</style>
<div class="col-md-2 text-right d-flex justify-content-start p-2">
<a href="<?php echo base_url() ?>"><img style='width:200px;' class="mx-auto" src='<?php echo base_url('assets/iconc.png') ?>'></a>   
</div>
<div class="col-md-6  align-items-center d-flex justify-content-start">
<form method="get" style="margin-bottom:0; width:100%; " action="<?php echo base_url('DataArsip/Pencarian/') ?>">
<input type="text" name="search" id="project" class="form-search " value="<?php echo $this->input->get('search') ?>" placeholder="Masukan Dokumen yan ingin dicari">
<p style="display:none;" id="project-description"></p>

</form>  
</div>
<div class="col"></div> 

<div class="col-md-2   d-flex justify-content-end ">
<div class="btn-group dropup pull-right ">
<button type="button" class="btn btn-tranparent " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<i class="fas fa-th fa-1x"></i>
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
<div class="col text-center mt-2 text-lowercase" onclick="check_akses('DataArsip','data_lama');" >
<i class="fas fa-people-carry fa-2x"></i><br>Divisi Arsip
</div> 
</div>

<div class="row mt-3 text-theme1 text-center text-lowercase">

<div class="col-md-6 text-center mt-2 text-lowercase" onclick="check_akses('Admin','Dashboard');" >
<i class="fas fa-user-cog fa-2x"></i><br>Administrator
</div> 
<div class="col text-center mt-2 text-lowercase" onclick="check_akses('Level 4','Resepsionis');" >
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
<button class="btn btn-tranparent btn-md rounded">Pengaturan Akun <i class="fas fa-cogs"></i> </button>
<div class="dropdown-divider"></div>
<a href='<?php echo base_url('DataArsip/keluar') ?>'><button class="btn btn-light btn-md btn-block">Keluar <i class="fas fa-sign-out-alt"></i> </button></a>
</div>    

</div>
</div> 
</div>
</div>  
</div>


<div class="container-fluid" style="background-color:#D3D3D3;">
<div class="container">
<div class="row text-theme1">
<div class="col-md-3 mx-auto">
<button class="btn btn-tranparent btn-block text-theme1" onclick="search('dokumen_penunjang');">Dokumen Penunjang <i class="fas fa-file-contract"></i></button>
</div>
<div class="col-md-3 mx-auto">
<button class="btn btn-tranparent btn-block text-theme1" onclick="search('dokumen_utama');">Dokumen Utama <i class="fas fa-file-alt"></i> </button>
</div>
<div class="col-md-3 mx-auto">
<button class="btn btn-tranparent btn-block text-theme1" onclick="search('data_client');">Data Client <i class="fas fa-users"></i></button>
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

</body>

<script>
$( function() {
$( "#project" ).autocomplete({
minLength: 3,
source:'<?php echo site_url('DataArsip/cari_dokumen') ?>',
focus: function( event, ui ) {
$( "#project" ).val( ui.item.value );
return false;
},
select: function( event, ui ) {
$( "#project" ).val(ui.item.label );
$( "#project-description" ).html( ui.item.desc );
$(this).closest("form").submit()

return false;
}
}).autocomplete( "instance" )._renderItem = function( ul, item ) {
return $( "<li>" )
.append( "<div>" + item.label+ "<br>"+item.nama_client+" <br> "+item.nama_dokumen+"<br>" + item.nama_meta + " : "+item.value_meta+ "</div>" )
.appendTo( ul );
};
});
 
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
var kategori          = '<?php echo $this->input->get('kategori') ?>';

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

function search(kat){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
var kata_kunci        = '<?php echo $this->input->get('search') ?>';
var url = "<?php echo base_url('DataArsip/ProsesPencarian/') ?>"; 

if(kat == 'undefined'){
var kategori          = '<?php echo $this->input->get('kategori') ?>';

}else{
var kategori        =kat;
}    

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
</script>