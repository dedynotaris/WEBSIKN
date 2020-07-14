<body style="background: url(<?php echo base_url('assets') ?>/bg_login.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover; ">
<style>
.form-search {
display: block;
width: 98%;
height: calc(2.5rem + 2px);
padding:0.375rem 1.75rem;
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
            max-height: 200px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
            /* add padding to account for vertical scrollbar */
            padding-right: 20px;
        } 
.input-group-append {
    margin-left: -55px;
}  

.hover:hover {
  
  cursor: pointer;  
    background-color: #f8f9fa !important;
  }
</style>

<div class="container-fluid">
<div class="row ">

<div class="col text-right bg-transparent   p-3">
<div class="btn-group dropup mr-1">
<button type="button" class="btn btn-tranparent " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<i style="font-size: 1.4em;" class="fas fa-th  text-theme1"></i>
</button>
<div class="dropdown-menu dropdown-menu-right pb-0 pt-0 bg-white"  style="width:320px;">
<div class="row text-theme1 text-center text-lowercase">
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

<div class="btn-group">

<?php if(!file_exists('./uploads/user/'.$this->session->userdata('foto'))){ ?>
<img style="width:50px; height: 50px;  " src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class=" img rounded-circle border border-white" id="dropdownMenuButton" data-toggle="dropdown" ><br>    
<?php }else{ ?>
<?php if($this->session->userdata('foto') != NULL){ ?>
<img style="width:50px; height: 50px;  " src="<?php echo base_url('uploads/user/'.$this->session->userdata('foto')) ?>" img="" class="img rounded-circle border border-white" id="dropdownMenuButton" data-toggle="dropdown" ><br>    
<?php }else{ ?>
<img style="width:50px; height: 50px;  " src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class="img rounded-circle border border-white" id="dropdownMenuButton" data-toggle="dropdown" ><br>        
<?php } ?> 
<?php } ?>


<div class="dropdown-menu dropdown-menu-right" style="width:300px;" >
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

<div class="container">

<div class="row align-items-center " >
<div class="col text-center">


<div class="row">
<div class="col text-center">
<img style='width:180px;   '   class='bg-light rounded-circle '   src='<?php echo base_url('assets/icon.png') ?>'>      
<p class="m-3 text-white h5 ">Pencarian Dokumen Arsip </p>
</div>
</div>
    <form method="get" action="<?php echo base_url('DataArsip/Pencarian/') ?>">
<div class="row ">
<div class="col-md-2"></div>
<div class="col mx-auto">
    <form class="input-group">
     <div class="input-group col-md-11 mx-auto ">
         <input name="search" required minlength="1" class="form-search py-2 border-right-0 border" type="text" placeholder="Masukan Nama Perorangan atau Badan Hukum" id="example-search-input">
           <input type="hidden" class="form-control" name="<?php echo  $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
        <input type="hidden" name="kategori" value="data_client">
           <span class="input-group-append">
              <button type="submit" class="btn  btn-tranparent mr-3" type="button">
                    <i class="fa fa-search"></i>
              </button>
            </span>
        </div>
    </form>     
</div>

<div class="col-md-2"></div>

    </form>
</div>
</div>
</div>
</div>
<div class="container-fluid mt-5  p-3 text-info  ">
<div class ="row p-2 text-center" >
    <div class="col-md-3 m-2 p-2 mx-auto card shadow-lg  bg-white rounded">Total Dokumen Penunjang<hr>
        <h1><?php echo number_format($this->db->get('data_berkas')->num_rows()); ?></h1>
    </div>
    <div class="col-md-3 m-2 p-2 mx-auto card shadow-lg   bg-white rounded">Total Dokumen Utama<hr>
         <h1><?php echo number_format($this->db->get('data_dokumen_utama')->num_rows()); ?></h1>
   </div>
    <div class="col-md-3 m-2 p-2 mx-auto card shadow-lg   bg-white rounded">Total Data Client<hr>
         <h1><?php echo number_format($this->db->get('data_client')->num_rows()); ?></h1>
   </div>
</div>
</div>
</body>
<script>
/*$( function() {
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
  } );*/
  </script>


<script type="text/javascript">
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

function PengaturanAkun(){
window.location.href="<?php echo base_url('DataArsip/PengaturanAkun') ?>";    
}

</script> 