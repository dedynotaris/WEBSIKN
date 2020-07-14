<div class="d-flex <?php if($this->session->userdata('toggled') == 'Aktif'){ echo "toggled"; } ?>" id="wrapper">
<div class="bg-theme2" id="sidebar-wrapper">
<div style="" class="sidebar-heading ">
<div class="text-center" style="padding:0.890rem 1rem; background-color:#17a2b8; font-size:16px">
<a href="<?php echo base_url(); ?>"><span style="color:#fff;">Divisi Administrator</span></a>
</div>

<div class="p-2 text-center bg-light">
<?php if(!file_exists('./uploads/user/'.$this->session->userdata('foto'))){ ?>
<img style="width:130px; height: 130px;  border:3px solid #343a40;" src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class=" img rounded-circle" ><br>    
<?php }else{ ?>
<?php if($this->session->userdata('foto') != NULL){ ?>
<img style="width:130px; height: 130px;  border:3px solid #343a40;" src="<?php echo base_url('uploads/user/'.$this->session->userdata('foto')) ?>" img="" class="img rounded-circle mb-3" ><br>    
<?php }else{ ?>
<img style="width:130px; height: 130px;  border:3px solid #343a40;" src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class="img rounded-circle" ><br>        
<?php } ?> 

<?php } ?>
<p style="font-size:15px; color:#343a40;">Welcome<br>    
<?php echo $this->session->userdata('nama_lengkap') ?></p>
</div>

</div>
<div class="list-group list-group-flush">

<ul class="list-unstyled components">


<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('Dashboard/data_client_hukum'); ?>">Client Badan Hukum<i class="fa fa-list-alt float-right"></i></a>
</li>
<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('Dashboard/data_client_perorangan'); ?>">Client Perorangan <i class="fa fa-list-alt float-right"></i></a>
</li>


<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('Dashboard/data_berkas'); ?>">Keseluruhan Berkas<i class="fa fa-list-alt float-right"></i></a>
</li>
<!--<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('Dashboard/data_client_perorangan'); ?>">Tidak ada lampiran<i class="float-right"> 404 </i></a>
</li>-->



<li><a class="list-group-item list-group-item-action " href="<?php echo base_url('Dashboard/pekerjaan_proses'); ?>"><i class="fa fa-exchange-alt"></i> Pekerjaan </a></li>
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
