<body>
<?php  $this->load->view('umum/V_sidebar'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar'); ?>
<?php $static = $DataClient->row_array(); ?>   
<div class="container-fluid mt-3">
<div class="row">
<div class="col">
<div class="card p-2">
<p class="text-center"> DATA CLIENT <?php echo  $static['nama_client']?></p>

<div class="row">
<div class="col-md-4">No Identitas</div>
<div class="col">: <?php echo  $static['no_identitas']?></div>
</div>
<div class="row">
<div class="col-md-4">Nama Client</div>
<div class="col">: <?php echo  $static['nama_client']?></div>
</div>
<div class="row">
<div class="col-md-4">Jenis Client</div>
<div class="col">: <?php echo  $static['jenis_client']?></div>
</div>
<div class="row">
<div class="col-md-4">Alamat Client</div>
<div class="col">: <?php echo  $static['alamat_client']?></div>
</div>
<div class="row">
<div class="col-md-4">Pembuat Client</div>
<div class="col">: <?php echo  $static['pembuat_client']?></div>
</div>
<div class="row">
<div class="col-md-4">Kontak Yang Bisa Dihubungi</div>
<div class="col">: <?php echo  $static['contact_person']?></div>
</div>
<div class="row">
<div class="col-md-4">Nomor Kontak</div>
<div class="col">: <?php echo  $static['contact_number']?></div>
</div>

</div>
</div>
<div class="col">
<div class="card p-2">
<p class="text-center"> DATA PEKERJAAN <?php echo  $static['nama_client']?></p>

<div class="row">
<div class="col-md-4">Jumlah Pekerjaan</div>
<div class="col">: <?php echo  $this->db->get_where('data_pekerjaan',array('no_client'=>base64_decode($this->uri->segment(3))))->num_rows();?></div>
</div>
<div class="row">
<div class="col-md-4">Jumlah Berkas</div>
<div class="col">: <?php echo  $static['nama_client']?></div>
</div>
<div class="row">
<div class="col-md-4">Jumlah Pihak Terlibat</div>
<div class="col">: <?php echo  $static['jenis_client']?></div>
</div>

</div>
</div>

</div>
</div>

    
</body>    