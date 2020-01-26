<div class="d-flex <?php if($this->session->userdata('toggled') == 'Aktif'){ echo "toggled"; } ?>" id="wrapper">
<div class="bg-theme2" id="sidebar-wrapper">
<div style="" class="sidebar-heading ">
<div class="text-center" style="padding:0.890rem 1rem; background-color:#2F4F4F; font-size:16px">
App Management Document
   
</div>

<div class="p-2 text-center" style="background-color:#116466 !important;">
<?php if(!file_exists('./uploads/user/'.$this->session->userdata('foto'))){ ?>
<img style="width:130px; height: 130px;  border:3px solid #FFF;" src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class=" img rounded-circle" ><br>    
<?php }else{ ?>
<?php if($this->session->userdata('foto') != NULL){ ?>
<img style="width:130px; height: 130px;  border:3px solid #FFF;" src="<?php echo base_url('uploads/user/'.$this->session->userdata('foto')) ?>" img="" class="img rounded-circle mb-3" ><br>    
<?php }else{ ?>
<img style="width:130px; height: 130px;  border:3px solid #FFF;" src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class="img rounded-circle" ><br>        
<?php } ?> 

<?php } ?>
<p style="font-size:14px;">Welcome<br>    
<?php echo $this->session->userdata('nama_lengkap') ?></p>
</div>

</div>
<div class="list-group list-group-flush">
      
<ul class="list-unstyled components">

    
<li><a class="list-group-item list-group-item-action " href="<?php echo base_url('Dashboard/data_berkas'); ?>"><i class="fa fa-file-word"></i> Data berkas</a></li>
<li class="active">
<a href="#homeSubmenu"  data-toggle="collapse" aria-expanded="false" class="dropdown-toggle list-group-item list-group-item-action ">
<i class="fas fa-users"></i> Client</a>
<ul class="list-unstyled collapse show" id="homeSubmenu">
<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('Dashboard/data_client_hukum'); ?>">Client Badan Hukum<i class="fa fa-list-alt float-right"></i></a>
</li>
<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('Dashboard/data_client_perorangan'); ?>">Client Perorangan <i class="fa fa-list-alt float-right"></i></a>
</li>

</ul>
</li>


<li><a class="list-group-item list-group-item-action " href="<?php echo base_url('Dashboard/pekerjaan_proses'); ?>"><i class="fa fa-exchange-alt"></i> Pekerjaan diproses</a></li>
<li><a class="list-group-item list-group-item-action " href="<?php echo base_url('Dashboard/data_user'); ?>"><i class="fas fa-users"></i> Data user</a></li>
<li><a class="list-group-item list-group-item-action " href="<?php echo base_url('Dashboard/setting'); ?>"><i class="fas fa-cogs"></i> Setting</a></li>
</ul>
</div>
</div>


<script type="text/javascript">
$(document).ready(function () {
$('#sidebarCollapse').on('click', function () {
$('#sidebar').toggleClass('active');
});
});
</script>
