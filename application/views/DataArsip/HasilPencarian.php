<body>
<div class="container-fluid bg-light">
<div class="row">
<style>
.easy-autocomplete input {
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


.easy-autocomplete input:hover {
-webkit-box-shadow: 1px 1px 4px 1px rgba(0,0,0,0.30);
-moz-box-shadow: 1px 1px 4px 1px rgba(0,0,0,0.30);
box-shadow: 1px 1px 4px 1px rgba(0,0,0,0.30);

}


.easy-autocomplete {
position: relative;
width: 100%;
margin-left: auto !important;
margin-right: auto !important;
}
</style>

<div class="col-md-2 text-right d-flex justify-content-start p-2">
    <img style='width:200px;' class="mx-auto" src='<?php echo base_url('assets/iconc.png') ?>'>    
</div>

<div class="col-md-6  align-items-center d-flex justify-content-start">
    <input type="text" id="pencarian" class="form-search " placeholder="Masukan Dokumen yan ingin dicari">
</div>
<div class="col"></div> 

<div class="col-md-1   d-flex justify-content-start p-2">
<div class="btn-group dropup ">
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

<div class="btn-group ">
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
<div class="container-fluid bg-light">
<div class="container">
<div class="row p-2">
<div class="col-md-1"></div>    
<div class="col-md-2 ">Dokumen Penunjang</div>
<div class="col-md-2 ">Dokumen Utama</div>
<div class="col-md-2 ">Data Client</div>
</div>
</div>
</div>
</body>