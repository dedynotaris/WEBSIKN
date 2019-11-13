<body >
<?php  $this->load->view('umum/data_lama/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/data_lama/V_navbar_data_lama'); ?>
<div class="container-fluid ">
<?php $static = $data_perekaman->row_array() ?>
<div class="mt-2  text-center  ">
<h5 align="center " class="text-theme1"><span class="fa-2x fas fas fa-clipboard-list"></span><br><?php echo $static['nama_client']."<br>".$static['nama_jenis'] ?></h5>
</div>
    <div class="row m-1">
        <div class="col card-header">
            <table class="table table-bordered table-striped table-sm">
                <tr>
                    <th>Nama Dokumen</th>
                    <th>Aksi</th>
                </tr>
                
                
                <?php foreach ($data_perekaman->result_array() as $data){?>
                <tr>
                    <td><?php echo $data['nama_dokumen'] ?></td>
                    <td><button onclick=lihat_data_perekaman("<?php echo $data['no_nama_dokumen'] ?>","<?php echo $data['no_pekerjaan'] ?>","<?php echo $data['no_client'] ?>"); class="btn btn-sm btn-outline-dark">Lihat data <span class="fa fa-eye"></span></button></td>
                </tr>
                    
                 <?php } ?>
            </table>
        </div>
    </div>
</div>
</div>
    <!------------------modal data perekaman------------->
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
    function lihat_data_perekaman(no_nama_dokumen,no_pekerjaan,no_client){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_nama_dokumen="+no_nama_dokumen+"&no_pekerjaan="+no_pekerjaan+"&no_client="+no_client,
url:"<?php echo base_url('Data_lama/data_perekaman') ?>",
success:function(data){
$(".data_perekaman").html(data);    
$('#data_perekaman').modal('show');
}

});
}
    </script>    
    
</body>    