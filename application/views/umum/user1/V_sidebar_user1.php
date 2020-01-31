<div class="d-flex <?php if($this->session->userdata('toggled') == 'Aktif'){ echo "toggled"; } ?>" id="wrapper">
<div class="bg-theme2 " id="sidebar-wrapper">
<div style="" class="sidebar-heading ">
<a style="text-decoration:none;" href="<?php echo base_url($this->uri->segment(1)) ?>"><div class="text-center" style="padding:0.890rem 1rem; background-color:#FF8C00; font-size:16px">
App Management Document
</div></a>


<div class="p-2 text-center" style="background-color:#116466 !important;">
<?php if(!file_exists('./uploads/user/'.$this->session->userdata('foto'))){ ?>
<img style="width:130px; height: 130px;  border:3px solid #FF8C00;" src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class=" img rounded-circle" ><br>    
<?php }else{ ?>
<?php if($this->session->userdata('foto') != NULL){ ?>
<img style="width:130px; height: 130px;  border:3px solid #FF8C00;" src="<?php echo base_url('uploads/user/'.$this->session->userdata('foto')) ?>" img="" class="img rounded-circle mb-3" ><br>    
<?php }else{ ?>
<img style="width:130px; height: 130px;  border:3px solid #FF8C00;" src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class="img rounded-circle" ><br>        
<?php } ?> 

<?php } ?>
<p style="font-size:14px;">Welcome<br>    
<?php echo $this->session->userdata('nama_lengkap') ?></p>
</div>

</div>
<div class="list-group list-group-flush">
      
<ul class="list-unstyled components">
<li>
<a class="list-group-item list-group-item-action" href="<?php echo base_url('User1') ?>">Beranda <i class="fas fa-home float-right"></i></a>
</li>

<li>
<a class="list-group-item list-group-item-action" href="<?php echo base_url('User1/lihat_karyawan') ?>">Lihat Asisten<i class="fas fa-user-friends float-right"></i></a>
</li>
<li class="active">
<a href="#homeSubmenu"  data-toggle="collapse" aria-expanded="false" class="dropdown-toggle list-group-item list-group-item-action ">
<i class="fa fa-briefcase"></i> Pekerjaan</a>
<ul class="list-unstyled collapse show" id="homeSubmenu">
<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('User1/pekerjaan_masuk') ?>">Pekerjaan masuk<i class="far fa-share-square float-right"></i></a>
</li>
<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('User1/halaman_proses') ?>">Pekerjaan diproses<i class="fas fa-retweet float-right"></i></a>
</li>
<li>
<a class="list-group-item list-group-item-action" href="<?php echo base_url('User1/halaman_selesai') ?>">Pekerjaan diselesaikan<i class="far fa-flag float-right"></i></a>
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

