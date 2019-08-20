<body onload="refresh();">
<?php  $this->load->view('umum/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar_data_lama'); ?>
<div class="container-fluid ">
<div class=" text-center mt-3 mb-3">
<h5 align="center " class="text-theme1">Rekam Data<br><span class="fa-2x fas fa-pencil-alt"></span></h5>
</div>
    
    <ul class="nav nav-tabs">
<li class="nav-item">
<a class="nav-link active" data-toggle="tab" href="#utama">Rekam Dokumen Utama <i class="fas fa-file-word"></i></a>
</li>
<li class="nav-item ml-1">
<a class="nav-link " data-toggle="tab" href="#perizinan">Rekam Dokumen Penunjang <i class="fas fa-file"></i></a>
</li>
</ul>    
   

<div class="tab-content">
<div class="tab-pane  active" id="utama">
<?php $this->load->view('data_lama/V_rekam_utama'); ?>
</div>

<div class="tab-pane  " id="perizinan">
<?php $this->load->view('data_lama/V_rekam_penunjang'); ?>
</div>
    
</div>    
</div>
</body>
