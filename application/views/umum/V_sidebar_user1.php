<div class="d-flex <?php if($this->session->userdata('toggled') == 'Aktif'){ echo "toggled"; } ?>" id="wrapper">
<div class="bg-theme2 " id="sidebar-wrapper">
<div class="sidebar-heading text-center">App Management 
    <hr>
<?php if(!file_exists('./uploads/user/'.$this->session->userdata('foto'))){ ?>
<img style="width:100px; height: 100px;" src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class=" img rounded-circle" ><br>    
<?php }else{ ?>
<?php if($this->session->userdata('foto') != NULL){ ?>
<img style="width:100px; height: 100px;" src="<?php echo base_url('uploads/user/'.$this->session->userdata('foto')) ?>" img="" class="img rounded-circle" ><br>    
<?php }else{ ?>
<img style="width:100px; height: 100px;" src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class="img rounded-circle" ><br>        
<?php } ?> 

<?php } ?>
<p style="font-size:17px;">Welcome<br>    
    <?php echo $this->session->userdata('nama_lengkap') ?></p>

</div>
<div class="list-group list-group-flush">
      
<ul class="list-unstyled components">
<li>
<a class="list-group-item list-group-item-action" href="<?php echo base_url('User1/lihat_karyawan') ?>">Lihat karyawan<i class="fa fa-user-tie float-right"></i></a>
</li>

    
<li class="active">
<a href="#homeSubmenu"  data-toggle="collapse" aria-expanded="false" class="dropdown-toggle list-group-item list-group-item-action ">
<i class="fa fa-briefcase"></i> Pekerjaan</a>
<ul class="list-unstyled collapse show" id="homeSubmenu">
<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('User1/') ?>">Pekerjaan masuk<i class="fa fa-suitcase	 float-right"></i></a>
</li>
<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('User1/halaman_proses') ?>">Pekerjaan diproses<i class="fa fa-suitcase float-right"></i></a>
</li>
<li>
<a class="list-group-item list-group-item-action" href="<?php echo base_url('User1/halaman_selesai') ?>">Pekerjaan diselesaikan<i class="fa fa-suitcase float-right"></i></a>
</li>
</ul>

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
