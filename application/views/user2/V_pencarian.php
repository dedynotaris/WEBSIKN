<body>
<?php  $this->load->view('umum/V_sidebar_user2'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar_user2'); ?>
<div class="container-fluid mt-2 text-theme1">
<ul class="nav nav-tabs">
<li class="nav-item">
<a class="nav-link active" data-toggle="tab" href="#dokumen">Hasil Pencarian Dokumen <?php echo $data_dokumen->num_rows(); ?> </a>
</li>

<li class="nav-item ml-1">
<a class="nav-link" data-toggle="tab" href="#utama">Hasil Pencarian Dokumen Utama  <?php echo $data_dokumen_utama->num_rows(); ?>    </a>
</li>
<li class="nav-item ml-1">
<a class="nav-link" data-toggle="tab" href="#client">Hasil Pencarian Client <?php echo $data_client->num_rows(); ?>    </a>
</li>

</ul>    

<div class="tab-content">
<div class="tab-pane  active" id="dokumen">
<?php echo print_r($data_dokumen->result_array()) ?>    
    
</div>

<div class="tab-pane" id="utama">
<?php echo print_r($data_dokumen_utama->result_array()) ?>    
</div>

    
<div class="tab-pane" id="client">
<?php echo print_r($data_client->result_array()) ?>    
</div>

</div>    
    

    
</div>
</div>
</html>
