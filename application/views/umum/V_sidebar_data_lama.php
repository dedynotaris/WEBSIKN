<div class="d-flex <?php if($this->session->userdata('toggled') == 'Aktif'){ echo "toggled"; } ?>" id="wrapper">
<div class="bg-theme2" id="sidebar-wrapper">
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
<li><a class="list-group-item list-group-item-action " href="<?php echo base_url('Data_lama'); ?>"><i class="fa fa-upload"></i> Upload data lama</a></li>
<li><a class="list-group-item list-group-item-action " href="<?php echo base_url('Data_lama/data_berkas_lama'); ?>"><i class="fas fa-book"></i> Data berkas lama</a></li>

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
