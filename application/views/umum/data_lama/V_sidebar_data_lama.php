<div class="d-flex <?php if($this->session->userdata('toggled') == 'Aktif'){ echo "toggled"; } ?>" id="wrapper">
<div class="bg-theme2" id="sidebar-wrapper">
<div style="" class="sidebar-heading ">
<div class="text-center" style="padding:0.890rem 1rem; background-color:darkcyan; font-size:16px">
    <a href="<?php echo base_url('User2'); ?>"><span style="color:#fff;">Divisi Arsip</span></a>
   
</div>

<div class="p-2 text-center bg-light">
<?php if(!file_exists('./uploads/user/'.$this->session->userdata('foto'))){ ?>
<img style="width:130px; height: 130px;  border:3px solid darkcyan;" src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class=" img rounded-circle" ><br>    
<?php }else{ ?>
<?php if($this->session->userdata('foto') != NULL){ ?>
<img style="width:130px; height: 130px;  border:3px solid darkcyan;" src="<?php echo base_url('uploads/user/'.$this->session->userdata('foto')) ?>" img="" class="img rounded-circle mb-3" ><br>    
<?php }else{ ?>
<img style="width:130px; height: 130px;  border:3px solid darkcyan;" src="<?php echo base_url('uploads/user/no_profile.jpg') ?>" img="" class="img rounded-circle" ><br>        
<?php } ?> 

<?php } ?>
<p style="font-size:15px; color:darkcyan;">Welcome<br>    
<?php echo $this->session->userdata('nama_lengkap') ?></p>
</div>

</div>
<div class="list-group list-group-flush">
     
<ul class="list-unstyled components">
<li><a class="list-group-item list-group-item-action " href="<?php echo base_url('Data_lama'); ?>"><i class="fas fa-pen"></i> Buat File Arsip</a></li>

<li class="">
<a href="#arsipSubmenu"  data-toggle="collapse" aria-expanded="false" class="dropdown-toggle list-group-item list-group-item-action ">
<i class="fas fa-folder"></i> Proses Arsip</a>
<ul class="list-unstyled collapse " id="arsipSubmenu">
<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('Data_lama/DataArsipClient'); ?>">Arsip Masuk <i class="fas fa-arrow-circle-right  float-right"></i></a>
</li>
<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('Data_lama/DataArsipProses'); ?>">Arsip Proses <i class="fas fa-arrow-circle-right float-right"></i></a>
</li>
<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('Data_lama/DataArsipSelesai'); ?>">Arsip Selesai <i class="fas fa-flag-checkered  float-right"></i></a>
</li>
</ul>
</li>

<li class="">
<a href="#homeSubmenu"  data-toggle="collapse" aria-expanded="false" class="dropdown-toggle list-group-item list-group-item-action ">
<i class="fas fa-users"></i> Client</a>
<ul class="list-unstyled collapse " id="homeSubmenu">
<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('Data_lama/perorangan'); ?>">Client Perorangan <i class="fa fa-users float-right"></i></a>
</li>
<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('Data_lama/badan_hukum'); ?>">Client Badan Hukum <i class="far fa-building float-right"></i></a>
</li>
</ul>
</li>


<li class="">
<a href="#arsiploker"  data-toggle="collapse" aria-expanded="false" class="dropdown-toggle list-group-item list-group-item-action ">
<i class="fas fa-folder"></i> Arsip Loker</a>
<ul class="list-unstyled collapse " id="arsiploker">
<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('Data_lama/PekerjaanBaruSelesai'); ?>">Pekerjaan Baru Selesai <i class="fas fa-flag-checkered  float-right"></i></a>
</li>
<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('Data_lama/PeminjamanArsip'); ?>">Peminjaman Arsip <i class="fas fa-retweet float-right"></i></a>
</li>
<li>
<a class="list-group-item list-group-item-action " href="<?php echo base_url('Data_lama/PengaturanArsipLoker'); ?>">Pengaturan Arsip Loker <i class="fas fa-cogs  float-right"></i></a>
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
