<body>
<?php  $this->load->view('umum/V_sidebar_user2'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar_user2'); ?>
<div class="container-fluid mt-2 text-theme1">   
 <div id="accordion">
 
<?php foreach ($data->result_array() as $data_berkas){ ?>
     <div class="card">
    <div class="card-header" id="<?php echo $data_berkas['id_data_berkas'] ?>">
        <div class="row">
            <div class="col">
              <?php echo $data_berkas['nama_dokumen'] ?>  
            </div>
            <div class="col text-right">
                <button class="btn btn-success btn-sm" data-toggle="collapse" data-target="#collapse<?php echo $data_berkas['id_data_berkas'] ?>" aria-expanded="true" aria-controls="collapseOne">
                    Lihat Data <span class="fa fa-arrow-down"></span>
        </button>
            </div>
        </div>
        
   
    </div>

    <div id="collapse<?php echo $data_berkas['id_data_berkas'] ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
<?php } ?>
    

 
</div>
    
</div>
</div>
    
    
    
    

</html>
