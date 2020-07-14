<body >
<?php  $this->load->view('umum/user3/V_sidebar_user3'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/user3/V_navbar_user3'); ?>

<div class="container-fluid ">
<div class="mt-2  text-center  ">
<h5 align="center " class="text-info"><span class="fa-3x fas fa-retweet"></span><br>Pekerjaan Proses</h5>
</div>   
<div class="row">
<div class="col">    
<table class="table  table-striped text-center table-bordered">
<tr>
<th>No</th>
<th>Nama client</th>
<th>Nama Dokumen</th>
<th>Tugas Dari</th>
<th >Target selesai perizinan</th>
<th>Aksi</th>
</tr>
<?php $h=1; foreach ($data_tugas->result_array() as    $data){  ?>
<tr>
<td><?php echo $h++ ?></td>
<td><?php echo $data['nama_client'] ?></td>
<td><?php echo $data['nama_dokumen'] ?></td>
<td><?php echo $data['nama_lengkap'] ?></td>
<td class="text-center"><?php echo $data['target_selesai_perizinan'] ?></td>
<td>

<button onclick="form_laporan('<?php echo $data['no_berkas_perizinan']?>','<?php echo $data['no_pekerjaan']?>');" class="btn btn-sm btn-info " title="Buat laporan"><i class="far fa-clipboard"></i></button>    
<button onclick="form_rekam_dokumen('<?php echo $data['no_berkas_perizinan']?>','<?php echo $data['no_pekerjaan']?>','<?php echo $data['no_client']?>');" class="btn btn-sm btn-info " title="Rekam perizinan"> <i class="fa fa-upload"></i></button>    
<button onclick="lihat_dokumen_client('<?php echo $data['no_client']?>');" class="btn btn-sm btn-info" title="Rekam perizinan"> <i class="fa fa-file"></i></button>    
    
</td>
</tr>

<?php } ?>
</table>
</div>
</div>
</div>
<!-------------modal--------------------->
<div class="modal fade text-theme1" id="data_modal" tabindex="-1" role="dialog" aria-labelledby="modal_dinamis" aria-hidden="true">
</div>






<script type="text/javascript">
function lihat_dokumen_client(no_client){
window.location.href ="<?php echo base_url('User3/lihat_lampiran_client/') ?>"+btoa(no_client);
}
    
    
function response(data){
var r = JSON.parse(data);
if(r.status == "success"){

const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated bounceInDown'
});

Toast.fire({
type: r.status,
title: r.pesan
});
$(".form-control").val("");
}else{
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated bounceInDown'
});

Toast.fire({
type: r.status,
title: r.pesan
});

}

}    

function form_laporan(no_berkas_perizinan,no_pekerjaan){
var token           = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
url:"<?php echo base_url('User3/form_laporan') ?>",
data:"token="+token+"&no_berkas_perizinan="+no_berkas_perizinan+"&no_pekerjaan="+no_pekerjaan,
success:function(data){
$("#data_modal").html(data);    
$('#data_modal').modal('show');
}
});    
}
function simpan_laporan(){

$(".btn_simpan_laporan").attr("disabled", true);
$("#form_laporan").find(".form-control").removeClass("is-invalid").addClass("is-valid");
$('.form-control + p').remove();
$.ajax({
url  : "<?php echo base_url("User3/simpan_laporan") ?>",
type : "post",
data : $("#form_laporan").serialize(),
success: function(data) {
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#form_laporan").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#form_laporan").find("#"+key).removeClass("is-valid");
});
});
}else{
read_response(data);

$('#data_modal').modal('hide');
}
$(".btn_simpan_laporan").attr("disabled", false);
}
});
}

function selesaikan_perizinan(no_berkas_perizinan){
var token           = "<?php echo $this->security->get_csrf_hash() ?>";

Swal.fire({
text: 'Anda yakin ingin menyelesaikan perizinan tersebut ?',
type: 'warning',
showCancelButton: true,
confirmButtonColor: '#FF8C00',
cancelButtonColor: '#2F4F4F',
confirmButtonText: 'Ya, Selesaikan!'
}).then((result) => {
if (result.value) {

$.ajax({
type:"post",
data:"token="+token+"&no_berkas_perizinan="+no_berkas_perizinan,
url:"<?php echo base_url('User3/selesaikan_tugas') ?>",
success:function(data){
var r = JSON.parse(data);

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
title: "Perizinan berhasil diselesaikan"
}).then(function(){
window.location.href="<?php echo base_url('User3/Halaman_proses') ?>";    
});

}
});



}
});    
}

function lihat_persyaratan(no_client){
var token           = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
url:"<?php echo base_url('User3/lihat_persyaratan') ?>",
data:"token="+token+"&no_client="+no_client,
success:function(data){
$("#data_modal").html(data);    
$('#data_modal').modal('show');
}
});
}
function form_rekam_dokumen(no_berkas_perizinan,no_pekerjaan,no_client){
var token           = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
url:"<?php echo base_url('User3/form_rekam_dokumen') ?>",
data:"token="+token+"&no_berkas_perizinan="+no_berkas_perizinan+"&no_pekerjaan="+no_pekerjaan+"&no_client="+no_client,
success:function(data){
$("#data_modal").html(data);    
$('#data_modal').modal('show');
regis_js();

}
});
}

function regis_js(){
$(".Desimal").keyup(function(){
var string = numeral(this.value).format('0,0');
$("#"+this.id).val(string);
});
$(".Bulat").keyup(function(){
var string = numeral(this.value).format('0');
$("#"+this.id).val(string);
});

$(function() {
$(".date").daterangepicker({ 
    singleDatePicker: true,
    dateFormat: 'yy/mm/dd',
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10),
    "locale": {
        "format": "YYYY/MM/DD",
        "separator": "-",
      }
});
});

}
function form_tolak_tugas(no_pekerjaan,id_data_berkas){
}

function download(id_data_berkas){
window.location.href="<?php echo base_url('User3/download_berkas/') ?>"+id_data_berkas;
}


function lihat_data_perekaman(no_nama_dokumen,no_pekerjaan,no_client){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_nama_dokumen="+no_nama_dokumen+"&no_client="+no_client,
url:"<?php echo base_url('User3/data_perekaman') ?>",
success:function(data){
$("#data_modal").html(data);    
$('#data_modal').modal('show');
}
});
}

function upload_data(no_nama_dokumen,no_client){

$("#form"+no_nama_dokumen).find(".form-control").removeClass("is-invalid").addClass("is-valid");
$("#form"+no_nama_dokumen).find('.form-control + p').remove();


var <?php echo $this->security->get_csrf_token_name();?>  = "<?php echo $this->security->get_csrf_hash(); ?>" ;      
formdata = new FormData();
var x = $('#form'+no_nama_dokumen).serializeArray();
$.each(x,function(prop,obj){
formdata.append(obj.name, obj.value);
});
formdata.append("file_berkas", $("#file"+no_nama_dokumen).prop('files')[0]);

$.ajax({
type:"post",
data:formdata,
processData: false,
contentType: false,
url:"<?php echo base_url('User3/simpan_persyaratan') ?>",
success:function(data){
var r = JSON.parse(data); 

if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#form"+no_nama_dokumen).find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#form"+no_nama_dokumen).find("#"+key).removeClass("is-valid");
});
});
}else if(r[0].status == 'success'){
$("#form"+no_nama_dokumen).find(".form-control").val("");
$('#data_modal').modal('hide');
read_response(data);
}else{
read_response(data);
}    
}
});
}
</script>    
</html>
