<body>
<?php  $this->load->view('umum/V_sidebar_user3'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar_user3'); ?>
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
<div class="tab-pane  active " id="dokumen">
    <div class="container-fluid overflow-auto " style="max-height:1000px;">
        <?php if($data_dokumen->num_rows() != 0){ ?>
    <div class="row card-header rounded">
            <div class="col">Nama client</div>
            <div class="col">Nama Dokumen</div>
            <div class="col">Hasil</div>
            <div class="col-sm-2">Aksi</div>
       
        </div>   
        
 <?php foreach ($data_dokumen->result_array() as $dokumen){
echo "<div class='row mt-1 rounded card-header'>";
echo "<div class='col'>".$dokumen['nama_client']."</div>"
    ."<div class='col'>".$dokumen['nama_dokumen']."</div>"
    ."<div class='col'>".$dokumen['nama_meta'].": ".$dokumen['value_meta']."</div>"
    . "<div class='col-sm-2'>"
    . "<button class='btn  col-md-6 btn-success btn-sm'><span class='fa fa-download'></span></button>"
    . "<button class='btn   col-md-5 ml-1 btn-success btn-sm'><span class='fa fa-eye'></span></button>"
    . "</div>"   
    . "</div>";    
}
        }
?>
</div>    
</div>

<div class="tab-pane " id="utama"> 
    <div class="container-fluid overflow-auto " style="max-height:1000px;">
    <?php if($data_dokumen_utama->num_rows() != 0){ ?>

        <div class="row card-header rounded">
            <div class="col">Nama Berkas</div>
            <div class="col-sm-2">Tanggal akta</div>
            <div class="col-sm-2 text-center">Aksi</div>
        </div>   
    
   
<?php foreach ($data_dokumen_utama->result_array() as $utama){
echo "<div class='row mt-1 card-header rounded'>"
    . "<div class='col'>".$utama['nama_berkas']."</div>"
    ."<div class='col-sm-2'>".$utama['tanggal_akta']."</div>"
    . "<div class='col-sm-2 text-center'>"
    . "<button class='btn  col-md-6 btn-success btn-sm'>File <span class='fa fa-download'></span></button>"
    . "</div>"
        . "</div>";    
}
    }
?>
</div>
    
</div>

    
<div class="tab-pane" id="client">
  <div class="container-fluid overflow-auto " style="max-height:1000px;">
  
<?php if($data_client->num_rows() != 0){ ?>
      <div class="row card-header rounded">
            <div class="col">Nama Client</div>
            <div class="col-sm-2 text-center">Aksi</div>
        </div>   
      
      
     <?php foreach ($data_client->result_array() as $client){ 
       echo "<div class='row card-header rounded mt-1'>"
    . "<div class='col'>".$client['nama_client']."</div>"
    . "<div class='col-sm-2'>"
    . "<button class='btn  bt-block btn-success btn-sm'> Lihat berkas <span class='fa fa-eye'></span></button>"
    . "</div>"
    . "</div>";
      
      }
}?>
      
      
</div>
</div>    
    

    
</div>
</div>
</html>
