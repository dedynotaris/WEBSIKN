<body  style="background: url(<?php echo base_url('assets') ?>/bg_login.jpg) no-repeat center center fixed; 
-webkit-background-size: cover;
-moz-background-size: cover;
-o-background-size: cover;
background-size: cover;
font-family: 'fontweb'; " class="bg_login">
<style>
.form-search {
display: block;
width: 90%;
height: calc(2.5rem + 2px);
padding:0.375rem 1.75rem;
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
            max-height: 200px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
            /* add padding to account for vertical scrollbar */
            padding-right: 20px;
        } 
.input-group-append {
    margin-left: -37px;
}        
</style>

<div class="container-fluid">
<div class="row ">

<div class="col text-right bg-transparent   m-2">
<div class="btn-group dropup mr-1">
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

<div class="btn-group">
<?php if(!file_exists('./uploads/user/'.$this->session->userdata('foto'))){ ?>
<img style="width:40px; height: 40px;  border:2px solid darkcyan;" src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class=" img rounded-circle dropdown-toggle pull-right"  id="dropdownMenuButton" data-toggle="dropdown"  ><br>    
<?php }else{ ?>
<?php if($this->session->userdata('foto') != NULL){ ?>
<img style="width:40px; height: 40px;  border:2px solid darkcyan;" src="<?php echo base_url('uploads/user/'.$this->session->userdata('foto')) ?>" img="" class="img rounded-circle  dropdown-toggle pull-right" id="dropdownMenuButton" data-toggle="dropdown"  ><br>    
<?php }else{ ?>
<img style="width:40px; height: 40px;  border:2px solid darkcyan;" src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class="img rounded-circle dropdown-toggle pull-right"  id="dropdownMenuButton" data-toggle="dropdown"  ><br>        
<?php } ?> 
<?php } ?>


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

<div class="container">

<div class="row align-items-center " style="height:80%;">
<div class="col text-center">


<div class="row">
<div class="col text-center">
<img style='width:180px;'  src='<?php echo base_url('assets/icon.png') ?>'>      
<p>Pencarian Dokumen Arsip </p>
</div>
</div>
    <form method="get" action="<?php echo base_url('DataArsip/Pencarian/') ?>">
<div class="row mt-1">
<div class="col-md-2"></div>
<div class="col mx-auto">
    <form class="input-group">
     <div class="input-group col-md-11 mx-auto ">
         <input name="search" minlength="1" class="form-search py-2 border-right-0 border" type="text" placeholder="Masukan Nama Perorangan atau Badan Hukum" id="example-search-input">
           <input type="hidden" name="kategori" value="dokumen_penunjang">
           <span class="input-group-append">
              <button type="submit" class="btn form-search btn-tranparent border-left-0 border" type="button">
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
</script> 