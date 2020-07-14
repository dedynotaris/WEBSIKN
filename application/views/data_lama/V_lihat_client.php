<body>
<?php  $this->load->view('umum/data_lama/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/data_lama/V_navbar_data_lama'); ?>
<?php  $this->load->view('umum/data_lama/V_data_data_lama'); ?>
<?php $static = $data_client->row_array(); ?>
    <style>
 .nav-tabs .nav-link {
    background-color:#212529;
    border: 1px solid transparent;
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
   
}
.nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
    color: #fff;
    background-color: #17a2b8;
    border-color: #dee2e6 #dee2e6 #fff;
}

 a {
   color: #fff;
   
}
a:hover {
  color: #fff;
  text-decoration: underline;
}
    </style>   
<div class="container-fluid mt-2">
    
    <h4 class='text-center text-info'><i class="fa fa-3x fa-list-alt"></i><br>DATA DETAIL <?php echo $static['nama_client'] ?></h4>    
<ul class="nav nav-tabs">
<li class="nav-item">
<a class="nav-link active" data-toggle="tab" href="#jenis">Detail Dokumen Penunjang </a>
</li>
<li class="nav-item ml-1">
<a class="nav-link " data-toggle="tab" href="#dokumen">Detail Dokumen Utama </a>
</li>
<li class="nav-item ml-1">
<a class="nav-link " data-toggle="tab" href="#pekerjaan">Detail Pekerjaan </a>
</li>
</ul>

<div class="tab-content">

<div class="tab-pane  container-fluid active" id="jenis">
<div class="row ">
<div class="col mt-2">
<?php $this->load->view('data_lama/V_dokumen_penunjang'); ?>
</div>
</div>
</div>
<!----------------------------Dokumen------------------------------>
<div class="tab-pane  container-fluid fade" id="dokumen">
<div class="row">
<div class="col mt-2">
<?php $this->load->view('data_lama/V_dokumen_utama'); ?>
</div>
</div>
</div>

<!----------------------------Pekerjaan------------------------------>
<div class="tab-pane  container-fluid fade" id="pekerjaan">
<div class="row">
<div class="col mt-2">
<?php $this->load->view('data_lama/V_pekerjaan_client'); ?>
</div>
</div>
</div>

</div>
</div>    
    

</body>    