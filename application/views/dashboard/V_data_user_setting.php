<table style="width:100%;" id="data_user" class="table table-striped table-condensed table-sm table-bordered  table-hover table-sm"><thead>
<tr role="row">
<th   aria-controls="datatable-fixed-header"  >No</th>
<th   aria-controls="datatable-fixed-header"  >no user</th>
<th   aria-controls="datatable-fixed-header"  >username</th>
<th   aria-controls="datatable-fixed-header"  >nama lengkap</th>
<th   aria-controls="datatable-fixed-header"  >email</th>
<th   aria-controls="datatable-fixed-header"  >No HP</th>
<th   aria-controls="datatable-fixed-header"  >level</th>
<th   aria-controls="datatable-fixed-header"  >aksi</th>
</thead>
<tbody >
</table>

<!------------- Modal User Setting---------------->
<div class="modal fade bd-example-modal-lg" id="ModalUserSetting" role="dialog" aria-labelledby="tambah_syarat1" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document" id="DataUserSetting">

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

var t = $("#data_user").dataTable({
initComplete: function() {
var api = this.api();
$('#data_user')
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
ajax: {"url": "<?php echo base_url('Dashboard/json_data_user') ?> ", 
"type": "POST",
data: function ( d ) {
d.token = '<?php echo $this->security->get_csrf_hash(); ?>';
}
},
columns: [
{
"data": "id_user",
"orderable": false
},
{"data": "no_user"},
{"data": "username"},
{"data": "nama_lengkap"},
{"data": "email"},
{"data": "phone"},
{"data": "level"},
{"data": "view"},


],
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


function refresh_table_user(){
var table = $('#data_user').DataTable();
table.ajax.reload( function ( json ) {
$('#data_user').val( json.lastInput );
});
}

function TambahDataUser(){
var token = '<?php echo $this->security->get_csrf_hash(); ?>';  
$.ajax({
type:"post",
data:"token="+token+"&no=asd",
url:"<?php echo base_url('Dashboard/FormTambahUser') ?>",
success:function(data){
$("#ModalUserSetting").modal('show');
$('#DataUserSetting').html(data);
}
});       
}

function SimpanUserBaru(){
$("#FormUserBaru").find(".is-invalid").removeClass("is-invalid").addClass("is-valid");
$('.form-control + p').remove();
$.ajax({
type:"post",
data:$("#FormUserBaru").serialize(),
url:"<?php echo base_url('Dashboard/SimpanUser') ?>",
success:function(data){
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#FormUserBaru").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#FormUserBaru").find("#"+key).removeClass("is-valid");
});
});
}else{
refresh_table_user();

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
$("#ModalUserSetting").modal('hide');
}  
}
});  
}

function DetailDataUser(no_user){
var token = '<?php echo $this->security->get_csrf_hash(); ?>';  
$.ajax({
type:"post",
data:"token="+token+"&no_user="+no_user,
url:"<?php echo base_url('Dashboard/DetailDataUser') ?>",
success:function(data){
$("#ModalUserSetting").modal('show');
$('#DataUserSetting').html(data);
}
});       
}



function UpdateUser(){
$("#FormUpdateUser").find(".is-invalid").removeClass("is-invalid").addClass("is-valid");
$('.form-control + p').remove();
$.ajax({
type:"post",
data:$("#FormUpdateUser").serialize(),
url:"<?php echo base_url('Dashboard/UpdateUser') ?>",
success:function(data){
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#FormUpdateUser").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#FormUpdateUser").find("#"+key).removeClass("is-valid");
});
});
}else{
refresh_table_user();

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
$("#ModalUserSetting").modal('hide');
}  
}
});  
}


function hapus_sublevel(id_sublevel_user,no_user){
var token    = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
url:"<?php echo base_url('Dashboard/hapus_sublevel') ?>",
data:"token="+token+"&id_sublevel_user="+id_sublevel_user,
success:function(data){
var r = JSON.parse(data);
DetailDataUser(no_user);
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

function SimpanSubLevel(no_user){
$("#FormSubLevel").find(".is-invalid").removeClass("is-invalid").addClass("is-valid");
$('.form-control + p').remove();
$.ajax({
type:"post",
data:$("#FormSubLevel").serialize(),
url:"<?php echo base_url('Dashboard/SimpanSubLevel') ?>",
success:function(data){
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#FormSubLevel").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#FormSubLevel").find("#"+key).removeClass("is-valid");
});
});
}else{
refresh_table_user();

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
DetailDataUser(no_user);
}  
}
});  
}

function HapusUser(no_user){
var token    = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
url:"<?php echo base_url('Dashboard/HapusUser') ?>",
data:"token="+token+"&no_user="+no_user,
success:function(data){
var r = JSON.parse(data);
refresh_table_user();

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

$("#ModalUserSetting").modal('hide');
}
});
}

</script>