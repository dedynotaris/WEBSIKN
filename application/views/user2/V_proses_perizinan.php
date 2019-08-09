<body onload="refresh();">
<?php  $this->load->view('umum/V_sidebar_user2'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar_user2'); ?>
<?php  $static = $data->row_array();?>  
<div class="container-fluid">
<div class="card-header mt-2 mb-2 text-center">
Lengkapi pekerjaan <?php echo $static['nama_client'] ?>
<button class="btn btn-success btn-sm  float-right "  onclick="update_selesaikan_pekerjaan('<?php echo $this->uri->segment(3) ?>');">Update selesaikan pekerjaan <span class="fa fa-hourglass-end"></span></button>
</div>

<ul class="nav nav-tabs">
<li class="nav-item">
<a class="nav-link active" data-toggle="tab" href="#utama"> Dokumen Utama <i class="fas fa-file"></i></a>
</li>
<li class="nav-item ml-1">
<a class="nav-link " data-toggle="tab" href="#perizinan"> Dokumen perizinan <i class="fas fa-file-word"></i></a>
</li>
<li class="nav-item ml-1">
<a class="nav-link" data-toggle="tab" href="#persyaratan"> Dokumen penunjang <i class="fas fa-file"></i></a>
</li>
</ul>    

<div class="tab-content">
<div class="tab-pane  active" id="utama">
<?php $this->load->view('user2/V_dokumen_utama') ?>   
</div>

<div class="tab-pane " id="perizinan">
<?php $this->load->view('user2/V_dokumen_perizinan') ?>   
</div>

<div class="tab-pane" id="persyaratan">
<?php $this->load->view('user2/V_dokumen_persyaratan') ?>       
</div>
</div>    
</div>    
</div>
    
</div>    
<div class="modal fade" id="data_perekaman" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl" role="document">
<div class="modal-content ">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel text-center">Data yang telah direkam<span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>

<div class="modal-body data_perekaman">


</div>
</div>
</div>
</div>




</body>
<script type="text/javascript">
$('#myTab a:first').tab('show');
</script>
