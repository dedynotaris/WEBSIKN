<body >
<?php $this->load->view('umum/user3/V_sidebar_user3'); ?>
<div id="page-content-wrapper">
    
<?php $this->load->view('umum/user3/V_navbar_user3'); ?>
<?php $this->load->view('umum/user3/V_data_user3'); ?>
<div class="container-fluid ">
<div class="mt-2  text-center  ">
<h5 align="center " class="text-theme1">Data Perizinan masuk<br><span class="fa-2x far fa-share-square"></span></h5>
</div>
<div class="row ">
<div class="col">    
<?php if($data_tugas->num_rows() == 0){ ?>
<h5 class="text-center text-theme1">Data perizinan yang masuk belum tersedia <br>
</h5>
<?php } else{ ?> 
<table class="table mt-2 text-theme1 table-hover table-sm table-bordered text-center table-striped ">
<tr>
<th>No</th>    
<th>Nama client</th>
<th>Nama Tugas</th>
<th>Tugas Dari</th>
<th>Tanggal penugasan</th>
<th>Aksi</th>
</tr>
<?php $no=1; foreach ($data_tugas->result_array() as    $data){  ?>
<tr>
<td><?php echo $no++ ?></td>    
<td><?php echo $data['nama_client'] ?></td>
<td id="nama_file<?php echo $data['no_berkas_perizinan']?>"><?php echo $data['nama_dokumen'] ?></td>
<td ><?php echo $data['nama_lengkap'] ?></td>
<td><?php echo $data['tanggal_penugasan'] ?></td>
<td>

<button onclick="terima_perizinan('<?php echo $data['no_berkas_perizinan']?>');" class="btn btn-sm btn-success" title="Terima tugas">Terima tugas <i class="fa fa-check"></i></button>    
<button onclick="tolak_perizinan('<?php echo $data['no_berkas_perizinan']?>','<?php echo $data['no_pekerjaan']?>');" class="btn btn-sm btn-danger" title="Tolak tugas">Tolak tugas <i class="fa fa-arrow-circle-left"></i></button>    
<button onclick="lihat_dokumen_client('<?php echo $data['no_client']?>');"class="btn btn-sm btn-primary mt-2" title="Dokumen Pemilik">Dokumen Penunjang <i class="fa fa-archive"></i></button>    
</td>
</tr>
<?php } ?>
</table>
<?php } ?>

</div>

</div>
</div>
</div>
    
<!-------------modal--------------------->
<div class="modal fade" id="data_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalScrollableTitle"></h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
     
      </div>
    </div>
  </div>
</div>

<style>
.swal2-overflow {
overflow-x: visible;
overflow-y: visible;
}    
</style>    

</body>

<script type="text/javascript">
function lihat_data_perekaman(no_nama_dokumen,no_pekerjaan,no_client){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_nama_dokumen="+no_nama_dokumen+"&no_pekerjaan="+no_pekerjaan+"&no_client="+no_client,
url:"<?php echo base_url('User3/data_perekaman') ?>",
success:function(data){
//$("#data_modal").html(data);    
$('#data_modal').modal('show');
}

});
}
    
function tolak_perizinan(no_berkas_perizinan,no_pekerjaan){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_berkas_perizinan="+no_berkas_perizinan+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('User3/form_tolak_perizinan') ?>",
success:function(data){
$("#data_modal").html(data);    
$('#data_modal').modal('show');
}
});
}    
    
    


function terima_perizinan(no_berkas_perizinan){
swal.fire({
title: 'Target Selesai Perizinan',
html: '<input class="form-control" readonly="" id="target_kelar">',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Simpan target',
customClass: 'swal2-overflow',
onOpen: function() {
$('#target_kelar').datepicker(
{ minDate:0,
dateFormat: 'yy/mm/dd'
}
);
}
}).then((result) => {

if($("#target_kelar").val() == ''){
}else{
var target_kelar = $("#target_kelar").val();
var token           = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
url:"<?php echo base_url('User3/proses_tugas') ?>",
data:"token="+token+"&no_berkas_perizinan="+no_berkas_perizinan+"&target_kelar="+target_kelar,
success:function(data){
var r  = JSON.parse(data);
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated zoomInDown'
});
Toast.fire({
type: r.status,
title: r.pesan
}).then(function() {
window.location.href = "<?php echo base_url('User3/halaman_proses'); ?>";
});
}
});
}
});
}

function lihat_dokumen_client(no_client){
//window.location.href ="<?php echo base_url('User3/lihat_lampiran_client/') ?>"+btoa(no_client);
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_client="+no_client,
url:"<?php echo base_url('User3/lihat_dokumen_client') ?>",
success:function(data){
var r  =JSON.parse(data);
$(".modal-title").html(r[0].title);
$(".modal-body").html(r[0].data);
$('#data_modal').modal('show');
}
});

}

function download(id_data_berkas){
window.location.href="<?php echo base_url('User3/download_berkas/') ?>"+id_data_berkas;
}


function simpan_penolakan(){
    
$(".btn_tolak_tugas").attr("disabled", true);
$("#form_penolakan_tugas").find(".form-control").removeClass("is-invalid").addClass("is-valid");
$('.form-control + p').remove();
$.ajax({
url  : "<?php echo base_url("User3/tolak_tugas") ?>",
type : "post",
data : $("#form_penolakan_tugas").serialize(),
success: function(data) {
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#form_penolakan_tugas").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#form_penolakan_tugas").find("#"+key).removeClass("is-valid");
});
});
}else{
read_response(data);
}
$(".btn_tolak_tugas").attr("disabled", false);
}
});   
}

$(function() {
$("input[name='target_kelar']").datepicker({ minDate:0});
});
</script>


</html>
