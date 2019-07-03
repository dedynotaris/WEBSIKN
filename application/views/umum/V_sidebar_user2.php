<div class="d-flex <?php if($this->session->userdata('toggled') == 'Aktif'){ echo "toggled"; } ?>" id="wrapper">
<div class="bg-theme2 " id="sidebar-wrapper">
<div style="" class="sidebar-heading ">
<div class="text-center" style="padding:0.890rem 1rem;">
App Management
   
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

<li class="active">
<a href="#homeSubmenu"  data-toggle="collapse" aria-expanded="false" class="dropdown-toggle list-group-item list-group-item-action ">
<i class="fas fa-users"></i> Client</a>
<ul class="list-unstyled collapse show" id="homeSubmenu">
<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('User2'); ?>">Client Baru <i class="fa fa-plus float-right"></i></a>
</li>
<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('User2/data_client'); ?>">Data Client <i class="fa fa-list-alt float-right"></i></a>
</li>
</ul>
</li>


<li class="active">
<a href="#homeSubmenu"  data-toggle="collapse" aria-expanded="false" class="dropdown-toggle list-group-item list-group-item-action ">
<i class="fa fa-briefcase"></i> Pekerjaan</a>
<ul class="list-unstyled collapse show" id="homeSubmenu">
<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('User2/pekerjaan_antrian') ?>">Pekerjaan Masuk <i class="fa fa-hourglass-start float-right"></i></a>
</li>

<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('User2/pekerjaan_proses') ?>">Pekerjaan dikerjakan<i class="fa fa-hourglass-half float-right"></i></a>
</li>
<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('User2/pekerjaan_selesai') ?>">Pekerjaan  Selesai <i class="fa fa-hourglass-end float-right"></i></a>
</li>

</ul>
</li>
<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('User2/asisten'); ?>">Asisten<i class="fa fa-users float-right"></i></a>
</li>


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