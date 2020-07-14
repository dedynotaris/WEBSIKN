            <table class="table  table-striped mt-2">
                <thead class="text-info">
                    <tr>
                        <th>No</th>
                        <th>No pekerjaan</th>
                        <th>Nama dokumen penunjang</th>
                        <th>Pengupload</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                
            <?php $no=1; foreach ($data_berkas->result_array() as $data){ ?>
    <tr>
        <td><?php echo $no++ ?></td>  
        <td><?php echo $data['no_pekerjaan'] ?></td>
        <td><?php echo $data['nama_dokumen'] ?></td>
        <td><?php echo $data['nama_lengkap'] ?></td>
        <td><button onclick="lihat_data_perekaman('<?php echo $data['no_berkas'] ?>')" class="btn btn-sm btn-dark btn-block" titl="Lihat rekaman data"><span class="fa fa-eye"></span></button></td>
    </tr> 
            <?php } ?>
        </table>

 
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

<script type="text/javascript">
function lihat_data_perekaman(no_berkas){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_berkas="+no_berkas,
url:"<?php echo base_url('User1/data_perekaman') ?>",
success:function(data){
$(".data_perekaman").html(data);    
$('#data_perekaman').modal('show');
}

});
}
</script>