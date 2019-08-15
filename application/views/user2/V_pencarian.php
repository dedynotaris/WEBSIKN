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
         <?php 
         
$query     = $this->M_user2->data_perekaman($data_berkas['no_nama_dokumen'],$data_berkas['no_client']);
         $query2     = $this->M_user2->data_perekaman2($data_berkas['no_nama_dokumen'],$data_berkas['no_client']);
        
         echo "<div class=''>";
echo "<div class='row mb-1'>";
foreach ($query->result_array() as $d){
echo "<div class='col border '>".$d['nama_meta']."</div>";
}
echo "<div class='col border '>Tanggal Input</div>";
echo "<div class='col-md-2  border text-center'>Aksi</div>";
echo "</div>";

foreach ($query2->result_array() as $d){
$b = $this->db->get_where('data_meta_berkas',array('no_berkas'=>$d['no_berkas']));
echo "<div class='row mb-3'>";

foreach ($b->result_array() as $i){
echo "<div class='col border p-2'>".$i['value_meta']."</div>";    
}
echo "<div class='col border p-2'>".$d['tanggal_upload']."</div>";    

echo '<div class="col-md-2 p-2 border text-center">'
.'<button class="btn btn-success btn-sm" onclick="cek_download('. $d['id_data_berkas'].')">Download berkas <span class="fa fa-download"></span></button>';
echo '</div>';
echo "</div>";
    
    
}


echo"</div>";  
         ?>
      </div>
    </div>
  </div>
<?php } ?>
    

 
</div>
    
</div>
</div>
    
    
    
    

</html>
