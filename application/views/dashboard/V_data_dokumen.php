<table  id="data_nama_dokumen" class="table table-striped table-condensed table-sm table-bordered  table-hover table-sm"><thead>
<tr role="row">
<th  aria-controls="datatable-fixed-header"  >No</th>
<th  aria-controls="datatable-fixed-header"  >no nama dokumen</th>
<th aria-controls="datatable-fixed-header"  >nama dokumen</th>
<th class='text-center' style="width: 1%;"  aria-controls="datatable-fixed-header"  >aksi</th>
</thead>
<tbody >
</table>


<!------------- Modal Detail Dokumen---------------->
<div class="modal fade bd-example-modal-lg" id="ModalDetailDokumen" role="dialog" aria-labelledby="tambah_syarat1" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document" id="DataDetailDokumen">

</div>
</div>


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

var t = $("#data_nama_dokumen").dataTable({
 
initComplete: function() {
var api = this.api();
$('#data_nama_dokumen')
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
ajax: {"url": "<?php echo base_url('Dashboard/json_data_nama_dokumen') ?> ", 
"type": "POST",
data: function ( d ) {
d.token = '<?php echo $this->security->get_csrf_hash(); ?>';
}
},
columns: [
{
"data": "id_nama_dokumen",
"orderable": false
},
{"data": "no_nama_dokumen"},
{"data": "nama_dokumen"},
{"data": "view"}


],"columnDefs": [
    { "width": "17%", "targets": 3 }
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

function LihatDetailDokumen(no_dokumen){
var token = '<?php echo $this->security->get_csrf_hash(); ?>';  
$.ajax({
type:"post",
data:"token="+token+"&no_dokumen="+no_dokumen,
url:"<?php echo base_url('Dashboard/DetailDokumen') ?>",
success:function(data){
$("#DataDetailDokumen").html(data);
$('#ModalDetailDokumen').modal('show');
check_inputan();
}
});       

}

function UpdateNamaDokumen(){
$("#FormUpdateDokumen").find(".is-invalid").removeClass("is-invalid").addClass("is-valid");
$('.form-control + p').remove();
$('.form-check + p').remove();
$.ajax({
type:"post",
data:$("#FormUpdateDokumen").serialize(),
url:"<?php echo base_url('Dashboard/UpdateNamaDokumen') ?>",
success:function(data){
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#FormUpdateDokumen").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#FormUpdateDokumen").find("#"+key).removeClass("is-valid");
});
});
}else{
refresh_nama_dokumen();

const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated zoomInDown'
});

Toast.fire({
type: r[0].status,
title: r[0].messages
});
$('#ModalDetailDokumen').modal('hide');
}  
}
});  
}

function refresh_nama_dokumen(){
var table = $('#data_nama_dokumen').DataTable();
table.ajax.reload( function ( json ) {
$('#data_nama_dokumen').val( json.lastInput );
});
}

function SimpanFormMeta(no_dokumen){
$("#FormMeta").find(".is-invalid").removeClass("is-invalid").addClass("is-valid");
$('.form-control + p').remove();

$.ajax({
type:"post",
url :"<?php echo base_url('Dashboard/SimpanMeta') ?>",
data:$("#FormMeta").serialize(),
success:function(data){
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#FormMeta").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#FormMeta").find("#"+key).removeClass("is-valid");
});
});
}else{
LihatDetailDokumen(no_dokumen); 
 
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated zoomInDown'
});

Toast.fire({
type: r[0].status,
title: r[0].messages
});
}
}
});
}


function hapus_meta(id_data_meta,no_dokumen){
var token    = "<?php echo $this->security->get_csrf_hash() ?>";    
$.ajax({
type:"post",
data:"token="+token+"&id_data_meta="+id_data_meta,
url:"<?php echo base_url('Dashboard/HapusDataMeta') ?>",
success:function(data){
var r  = JSON.parse(data);

LihatDetailDokumen(no_dokumen); 
 
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated zoomInDown'
});

Toast.fire({
type: r[0].status,
title: r[0].messages
});
}
});
}

function check_inputan(){
var inputan = $(".jenis_inputan option:selected").val();
if(inputan == 'number'){
$(".jenis_bilangan").attr("disabled", false);   
}else{
$(".jenis_bilangan").attr("disabled", true);        
}
}

function TambahkanOpsi(id_data_meta,no_dokumen){
var token    = "<?php echo $this->security->get_csrf_hash() ?>";    
$.ajax({
type:"post",
data:"token="+token+"&id_data_meta="+id_data_meta+"&no_dokumen="+no_dokumen,
url:"<?php echo base_url('Dashboard/FormTambahOpsi') ?>",
success:function(data){
$("#form"+id_data_meta).slideDown().after(data);
$(".TmbhOpsi"+id_data_meta).hide();
}
});

}

function SimpanOpsiBaru(id_data_meta,no_dokumen){
$("#TambahOpsi"+id_data_meta).find(".is-invalid").removeClass("is-invalid").addClass("is-valid");
$('.form-control + p').remove();

$.ajax({
type:"post",
url :"<?php echo base_url('Dashboard/SimpanOpsi') ?>",
data:$("#TambahOpsi"+id_data_meta).serialize(),
success:function(data){
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#TambahOpsi"+id_data_meta).find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#TambahOpsi"+id_data_meta).find("#"+key).removeClass("is-valid");
});
});
}else{
LihatDetailDokumen(no_dokumen); 
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated zoomInDown'
});

Toast.fire({
type: r[0].status,
title: r[0].messages
});
}
}
});
}

function HideFormOpsi(id_data_meta){
$("#FormOpsi"+id_data_meta).slideUp().hide();
$(".TmbhOpsi"+id_data_meta).show();
}
function HapusPilihan(id_data_input_pilihan,no_dokumen){
var token    = "<?php echo $this->security->get_csrf_hash() ?>";    

$.ajax({
type:"post",
url :"<?php echo base_url('Dashboard/HapusPilihan') ?>",
data:"token="+token+"&id_data_input_pilihan="+id_data_input_pilihan,
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
type: r[0].status,
title: r[0].messages
});
LihatDetailDokumen(no_dokumen); 

}
});
}
function HapusJenisDokumen(no_dokumen){
  var token           = "<?php echo $this->security->get_csrf_hash() ?>";
  Swal.fire({
  title: 'Kamu yakin ?',
  text: "Dokumen yang terkait dengan jenis dokumen ini akan ikut terhapus",
  icon: 'danger',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Ya Hapus Saja'
}).then((result) => {
  if (result.value) {
$.ajax({
type:'post',
url:'<?php echo base_url('Dashboard/HapusJenisDokumen') ?>',
data:"token="+token+"&no_dokumen="+no_dokumen,
success:function(data){


$('#ModalDetailDokumen').modal('hide');
refresh_nama_dokumen();
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

function FormTambahDokumen(){
var token = '<?php echo $this->security->get_csrf_hash(); ?>';  
$.ajax({
type:"post",
data:"token="+token+"&asd=asd",
url:"<?php echo base_url('Dashboard/FormTambahDokumen') ?>",
success:function(data){
$("#DataDetailDokumen").html(data);
$('#ModalDetailDokumen').modal('show');
}
});       

}



function SimpanDokumenBaru(){
$("#FormBuatDokumen").find(".is-invalid").removeClass("is-invalid").addClass("is-valid");
$('.form-control + p').remove();

$.ajax({
type:"post",
url :"<?php echo base_url('Dashboard/SimpanNamaDokumen') ?>",
data:$("#FormBuatDokumen").serialize(),
success:function(data){
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#FormBuatDokumen").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#FormBuatDokumen").find("#"+key).removeClass("is-valid");
});
});
}else{

$('#ModalDetailDokumen').modal('hide');
refresh_nama_dokumen();
 
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated zoomInDown'
});

Toast.fire({
type: r[0].status,
title: r[0].messages
});
}
}
});
}
</script> 
