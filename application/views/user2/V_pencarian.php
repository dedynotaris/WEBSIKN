<body>
<?php  $this->load->view('umum/V_sidebar_user2'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar_user2'); ?>
<div class="container-fluid mt-2">
		

<table class="table table-sm table-bordered table-striped table-condensed">
        <tr>
            <td>No</td>  
            <td>Jenis Lampiran</td>  
            <td>Aksi</td>  
        </tr>   
<?php $h=1; foreach ($dalam_bentuk_lampiran->result_array() as $lampiran){ ?>
        <tr>
            <td> <?php echo $h++ ?></td>
            <td><?php echo str_replace("_"," ",$lampiran['nama_meta']) ?> : <?php echo $lampiran['value_meta'] ?></td>
            <td class="text-center">
                <button onclick="download_berkas('<?php echo $lampiran['id_data_berkas'] ?>')" class="btn btn-sm btn-success">Download Lampiran <span class="fa fa-download"></span></button> 
            
            </td> 
             
        </tr>
<?php } ?>
</table>
    
</div>
</div>
    
    
    
    
<script type="text/javascript">
function download_berkas(id_data_berkas){
window.location.href="<?php echo base_url('User2/download_berkas/') ?>"+id_data_berkas;
}

function download_berkas_informasi(id_data_berkas_informasi){
window.location.href="<?php echo base_url('User2/download_berkas_informasi/') ?>"+id_data_berkas_informasi;
}

function lihat_informasi(id_data_berkas_informasi){
var token    = "<?php echo $this->security->get_csrf_hash() ?>";

$.ajax({
type:"post",
url:"<?php echo base_url('User2/lihat_informasi')?>",
data:"token="+token+"&id_data_informasi_pekerjaan="+id_data_berkas_informasi,
success:function(data){
$('#modal_informasi').modal('show');
$(".data_informasi").html(data);

}
});    
}

</script> 

</div>
<div class="modal fade" id="modal_informasi" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-body data_informasi">
       
      </div>
      
    </div>
  </div>
</div>


</body>
</html>
