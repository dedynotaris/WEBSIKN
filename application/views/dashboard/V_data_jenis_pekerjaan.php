<table style="width:100%;"  id="DataJenisPekerjaan" class="table  table-striped"><thead>
        <tr class="text-info" role="row">
<th  aria-controls="datatable-fixed-header">  No</th>
<th  aria-controls="datatable-fixed-header">  No Jenis Pekerjaan</th>
<th  aria-controls="datatable-fixed-header">  Pekerjaan</th>
<th  aria-controls="datatable-fixed-header">  Nama Pekerjaan</th>
<th  sclass='text-center' style="width: 1%;"  aria-controls="datatable-fixed-header"  >Aksi</th>
</thead>
<tbody >
</table>





<script type="text/javascript">
$(document).ready(function() {
$.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
{
return {
"iStart": oSettings._iDisplayStart,
"iEnd": oSettings.fnDisplayEnd(),
"iLength": oSettings._iDisplayLength,
"iTotal": oSettings.fnRecordsTotal(),
"iFilteredTotal": oSettings.fnRecordsDisplay(),
"iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
"iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
};
};

var t = $("#DataJenisPekerjaan").dataTable({
initComplete: function() {
var api = this.api();
$('#DataJenisPekerjaan')
.off('.DT')
.on('keyup.DT', function(e) {
if (e.keyCode == 13) {
api.search(this.value).draw();
}
});
},
oLanguage: {
sProcessing: "loading..."
},
processing: true,
serverSide: true,
ajax: {"url": "<?php echo base_url('Dashboard/JsonDataJenisPekerjaan') ?> ", 
"type": "POST",
data: function ( d ) {
d.token = '<?php echo $this->security->get_csrf_hash(); ?>';
}
},
columns: [
{
"data": "no_jenis_pekerjaan",
"orderable": false
},
{"data": "no_jenis_pekerjaan"},
{"data": "pekerjaan"},
{"data": "nama_jenis"},
{"data": "view"}


],"columnDefs": [
    { "width": "14%", "targets": 4 }
  ], 
   "autoWidth": false,  
order: [[0, 'desc']],
rowCallback: function(row, data, iDisplayIndex) {
var info = this.fnPagingInfo();
var page = info.iPage;
var length = info.iLength;
var index = page * length + (iDisplayIndex + 1);
$('td:eq(0)', row).html(index);
}
});
});


function DetailPekerjaan(no_jenis_pekerjaan){
var token           = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:'post',
url:'<?php echo base_url('Dashboard/DetailPekerjaan') ?>',
data:"token="+token+"&no_jenis_pekerjaan="+no_jenis_pekerjaan,
success:function(data){
$('#ModalDetail').modal('show');
$('#DataDetail').html(data);
CariJenisDokumen();
}
});
}

function hapus_syarat(id_data_persyaratan,no_jenis_pekerjaan){
var token           = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:'post',
url:'<?php echo base_url('Dashboard/hapus_persyaratan') ?>',
data:"token="+token+"&id_data_persyaratan="+id_data_persyaratan,
success:function(data){
DetailPekerjaan(no_jenis_pekerjaan);
}
});
}

function HapusJenisPekerjaan(no_jenis_pekerjaan){
  var token           = "<?php echo $this->security->get_csrf_hash() ?>";
  Swal.fire({
  title: 'Kamu yakin ?',
  text: "Dokumen yang terkait dengan jenis pekerjaan ini akan ikut terhapus",
  icon: 'danger',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Ya Hapus Saja'
}).then((result) => {
  if (result.value) {
$.ajax({
type:'post',
url:'<?php echo base_url('Dashboard/HapusJenisPekerjaan') ?>',
data:"token="+token+"&no_jenis_pekerjaan="+no_jenis_pekerjaan,
success:function(data){

refresh_table_pekerjaan();
$('#ModalDetail').modal('hide');
Swal.fire(
      'Terhapus !',
      'Seluruh Dokumen yang terkait jenis pekerjaan ini telah dihapus.',
      'success'
    )
}
});

}
})
}

function formatState (state) {
 if(state.error){
  var $state = $(
  '<p class="text-center col-7 mx-auto">Pencarian Dokumen Penunjang Tidak di temukan Silahkan tambahkan terlebih dahulu <br> <button type="button" onclick=FormTambahDokumen();  class="btn btn-dark btn-block">Tambahkan Dokumen Penunjang  <span class="fa fa-plus"></span></button></p>'
  );
  return $state;
 }else{
 var $state = $(
  '<span >'+state.text+'</span>'
  );
  return $state;
 }
};

function CariJenisDokumen(){
var token           = "<?php echo $this->security->get_csrf_hash() ?>";
$(".jenis_dokumen").select2({
dropdownParent: $("#ModalDetailPekerjaan"),  
templateResult: formatState,    
ajax: {
url: '<?php echo site_url('Dashboard/CariJenisDokumen') ?>',
method : "post",
data: function (params) {
var query = {
search: params.term,
token: token
};

return query;
},
processResults: function (data) {
var data = JSON.parse(data);
return {
results: data.results
};

}
}        
});
}

function TambahPersyaratan(){
$(".BtnTambahPersyaratan").attr("disabled", true);
$("#FormTambahPersyaratan").find(".is-invalid").removeClass("is-invalid").addClass("is-valid");
$("#FormTambahPersyaratan").find(".select2").removeClass("is-invalid").addClass("is-valid");    
$('.form-control + p').remove();
$('.select2 + p').remove();
$.ajax({
type:'post',
url:'<?php echo base_url('Dashboard/SimpanPersyaratan') ?>',
data:$("#FormTambahPersyaratan").serialize(),
success:function(data){
  var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
if(key == "jenis_dokumen"){
$("#FormTambahPersyaratan").find(".select2").addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#FormTambahPersyaratan").find(".select2").removeClass("is-valid");    
}else{
$("#FormTambahPersyaratan").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#FormTambahPersyaratan").find("#"+key).removeClass("is-valid");
}
});
});
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
type: r[0].status,
title: r[0].messages
})
DetailPekerjaan(r[0].no_jenis_pekerjaan);
}  
}
});

$(".BtnTambahPersyaratan").attr("disabled", false);
}

function UpdatePekerjaan(){
$(".BtnUpdatePekerjaan").attr("disabled", true);
$("#FormUpdatePekerjaan").find(".is-invalid").removeClass("is-invalid").addClass("is-valid");
$("#FormUpdatePekerjaan").find(".select2").removeClass("is-invalid").addClass("is-valid");    
$('.form-control + p').remove();

$.ajax({
type:"POST",
url:"<?php echo base_url('Dashboard/UpdateJenisPekerjaan') ?>",
data:$("#FormUpdatePekerjaan").serialize(),
success:function(data){

$('#ModalDetail').modal('hide');    
 var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#FormUpdatePekerjaan").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#FormUpdatePekerjaan").find("#"+key).removeClass("is-valid");

});
});
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
type: r[0].status,
title: r[0].messages
});
refresh_table_pekerjaan();
}    
}
});
$(".BtnUpdatePekerjaan").attr("disabled", false);
}

function refresh_table_pekerjaan(){
var table = $('#DataJenisPekerjaan').DataTable();
table.ajax.reload( function ( json ) {
$('#DataJenisPekerjaan').val( json.lastInput );
});
$('#ModalDetailPekerjaan').modal('hide');
}  

function TambahJenisPekerjaan(){
var token           = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:'post',
url:'<?php echo base_url('Dashboard/FormTambahJenisPekerjaan') ?>',
data:"token="+token,
success:function(data){
$('#ModalDetailPekerjaan').modal('show');
$('#DataDetailPekerjaan').html(data);
CariJenisDokumen();
}
});
}
function BuatPekerjaanBaru(){
$("#FormTambahPekerjaan").find(".is-invalid").removeClass("is-invalid").addClass("is-valid");
$("#FormTambahPekerjaan").find(".select2").removeClass("is-invalid").addClass("is-valid");    
$('.form-control + p').remove();

formVals = $("#FormTambahPekerjaan").serialize();
$('#persyaratan').find('.data_text').each(function(){
formVals += '&' + this.id + '=' + encodeURIComponent($(this).text());
});   
console.log(formVals);
$.ajax({
type:"POST",
url:"<?php echo base_url('Dashboard/SimpanPekerjaanBaru') ?>",
data:formVals,
success:function(data){
var r  = JSON.parse(data);

if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#FormTambahPekerjaan").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#FormTambahPekerjaan").find("#"+key).removeClass("is-valid");
});
});

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
type: r[0].status,
title: r[0].messages
});

refresh_table_pekerjaan();
}
}
});
}
function BuatPersyaratan(){
var jumlah       = $(".no").length +1;
var no_dokumen   = $(".jenis_dokumen option:selected" ).val();
var nama_dokumen = $(".jenis_dokumen option:selected").text();
if(nama_dokumen ==''){

alert("Anda Belum Memilih Jenis Dokumen");
}else if($("."+no_dokumen).length ==0 ){

var data = "<tr class='no no"+jumlah+" "+no_dokumen+"'>\n\
<td>"+jumlah+"</td>\n\
<td class='data_text' id="+no_dokumen+">"+nama_dokumen+"</td>\n\
<td width='10%'><button onclick=HapusSyarat('"+no_dokumen+"'); class='btn btn-danger btn-block btn-sm'><span class='fa fa-trash'></span></button></td>\n\
";


$(".data_persyaratan").append(data);
}else{
alert("Jenis Persyaratan Sudah Ditambahkan");
}

}

function HapusSyarat(no){
$("tr").remove("."+no);
}



</script>
