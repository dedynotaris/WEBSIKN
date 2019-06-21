<div class="d-flex <?php if($this->session->userdata('toggled') == 'Aktif'){ echo "toggled"; } ?>" id="wrapper">
<div class="bg-theme2" id="sidebar-wrapper">
<div class="sidebar-heading text-center">App Management </div>
<div class="list-group list-group-flush">
      
<ul class="list-unstyled components">
<li><a class="list-group-item list-group-item-action " href="<?php echo base_url('Data_lama'); ?>"><i class="fa fa-upload"></i> Upload data lama</a></li>
<li><a class="list-group-item list-group-item-action " href="<?php echo base_url('Data_lama/data_berkas'); ?>"><i class="fas fa-book"></i> Data berkas</a></li>
<li><a class="list-group-item list-group-item-action " href="<?php echo base_url('Data_lama/data_client'); ?>"><i class="fas fa-book"></i> Data client</a></li>

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
