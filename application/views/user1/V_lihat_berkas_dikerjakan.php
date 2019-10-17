<body>
<?php  $this->load->view('umum/user1/V_sidebar_user1'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/user1/V_navbar_user1'); ?>
<div class="container-fluid ">


<ul class="nav nav-tabs">
<li class="nav-item">
<a class="nav-link active" data-toggle="tab" href="#utama"> Dokumen Utama <i class="fas fa-file"></i></a>
</li>
<li class="nav-item ml-1">
<a class="nav-link " data-toggle="tab" href="#perizinan"> Dokumen Penunjang <i class="fas fa-file"></i></a>
</li>

</ul>    

<div class="tab-content">
<div class="tab-pane card container-fluid active" id="utama">
<?php $this->load->view('user1/V_dokumen_utama'); ?>
</div>

<div class="tab-pane card container-fluid " id="perizinan">
<?php $this->load->view('user1/V_dokumen_penunjang'); ?>
</div>
    
</div>    
</div>    
</div>
    
</div>

    
</div>
</div>
</div>

<!-------------------modal laporan--------------------->
<div class="modal fade" id="modal_tampil_lampiran" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-body" id="lihat_data_lampiran">

</div>
</div>
</div>
</div>

<script type="text/javascript">
function lihat_data_perekaman(no_nama_dokumen,no_client){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_nama_dokumen="+no_nama_dokumen+"&no_client="+no_client,
url:"<?php echo base_url('User1/data_perekaman') ?>",
success:function(data){
$(".data_perekaman").html(data);    
$('#data_perekaman').modal('show');
}

});
}
</script>

<script type="text/javascript">
$(function () {
  $('[data-toggle="popover"]').popover({
    container: 'body',
    html :true
  });
$('.btn').on('click', function (e) {
$('.btn').not(this).popover('hide');
});
}); 
    
function aksi_opsi(id_data_persyaratan_pekerjaan,no_pekerjaan,no_nama_dokumen){
var val =  $(".aksi"+id_data_persyaratan_pekerjaan+" option:selected").val();   

if(val == 1){
tampilkan_lampiran(no_pekerjaan,no_nama_dokumen);
}

$(".aksi"+id_data_persyaratan_pekerjaan).val(""); 
}    

function tampilkan_lampiran(no_pekerjaan,no_nama_dokumen){
var token           = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
url:"<?php echo base_url('User1/data_lampiran_persyaratan') ?>",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan+"&no_nama_dokumen="+no_nama_dokumen,
success:function(data){
$('#modal_tampil_lampiran').modal('show');
$("#lihat_data_lampiran").html(data);
}

});
        
}


function download_utama(id_data_berkas){
window.location.href="<?php  echo base_url('User1/download_utama/')?>"+id_data_berkas;
}

    
function lihat_status_sekarang(id_data_berkas){
$('#modal_laporan').modal('show');
var token           = "<?php echo $this->security->get_csrf_hash() ?>";

$.ajax({
type:"post",
url:"<?php echo base_url('User1/lihat_laporan') ?>",
data:"token="+token+"&id_data_berkas="+id_data_berkas,
success:function(data){
$("#lihat_status_sekarang").html(data);
}

});
}        
</script>   
</html>
