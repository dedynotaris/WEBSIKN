<body>
<?php $this->load->view('umum/user2/V_sidebar_user2'); ?>
<div id="page-content-wrapper">
<?php $this->load->view('umum/user2/V_navbar_user2'); ?>
<?php $this->load->view('umum/user2/V_data_user2'); ?>
<div class="container-fluid  text-theme1"> 
<div class="p-2 mt-2">

<div class="row">
<div class="col">
<h5 align="center"><i class="fa fa-3x fa-user-tie"></i><br>Data client yang telah anda kerjakan</h5>

<table style="width:100%;" id="data_client" class="table  text-theme1 table-striped table-condensed table-sm table-bordered  table-hover table-sm"><thead>
<tr role="row">
<th  align="center" aria-controls="datatable-fixed-header"  >No</th>
<th  align="center" aria-controls="datatable-fixed-header"  >no client</th>
<th  align="center" aria-controls="datatable-fixed-header"  >nama client</th>
<th  align="center" aria-controls="datatable-fixed-header"  >jenis client</th>
<th  align="center" aria-controls="datatable-fixed-header"  >asisten</th>
<th  align="center" aria-controls="datatable-fixed-header"  >aksi</th>
</thead>
<tbody align="center">
</table> 
</div>
</div>
</div>

<!------------- Modal ---------------->
<div class="modal fade bd-example-modal-md" id="modal" tabindex="-1" role="dialog" aria-labelledby="tambah_syarat1" aria-hidden="true">
<div class="modal-dialog modal-md data_modal" role="document">

</div>
</div>
</div>
<!------------- Modal tambah pekerjaan---------------->

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

var t = $("#data_client").dataTable({
initComplete: function() {
var api = this.api();
$('#data_client')
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
ajax: {"url": "<?php echo base_url('User2/json_data_client/Badan_hukum') ?> ", 
"type": "POST",
data: function ( d ) {
d.token = '<?php echo $this->security->get_csrf_hash(); ?>';
}
},
columns: [
{
"data": "id_data_client",
"orderable": false
},
{"data": "no_client"},
{"data": "nama_client"},
{"data": "jenis_client"},
{"data": "pembuat_client"},
{"data": "view"}


],"columnDefs": [
    { "width": "15%", "targets": 5 }
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

</script>    



<script type="text/javascript">
function  form_tambah_pekerjaan(no_client){
var <?php echo $this->security->get_csrf_token_name();?>  = "<?php echo $this->security->get_csrf_hash(); ?>"       
$.ajax({
type:"post",
url:"<?php echo base_url('User2/form_tambah_pekerjaan') ?>",
data:"token="+token+"&no_client="+no_client,
success:function(data){
$(".data_modal").html(data);    
$('#modal').modal('show');
cari_jenis_pekerjaan();
target_kelar();
}
});
}

function  form_edit_client(no_client){
var <?php echo $this->security->get_csrf_token_name();?>  = "<?php echo $this->security->get_csrf_hash(); ?>"       
$.ajax({
type:"post",
url:"<?php echo base_url('User2/form_edit_client') ?>",
data:"token="+token+"&no_client="+no_client,
success:function(data){
$(".data_modal").html(data);    
$('#modal').modal('show');
}
});
}

function update_client(){
$(".update_pekerjaan").attr("disabled", true);
$("#form_update_pekerjaan").find(".form-control").removeClass("is-invalid").addClass("is-valid");
$('.form-control + p').remove();
$.ajax({
url  : "<?php echo base_url("User2/update_client") ?>",
type : "post",
data : $("#form_update_pekerjaan").serialize(),
success: function(data) {
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#form_update_pekerjaan").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#form_update_pekerjaan").find("#"+key).removeClass("is-valid");
});
});
}else{
read_response(data);
$('#modal').modal('hide');
}
$(".update_pekerjaan").attr("disabled", false);
}
});
}

function lihat_berkas(no_client){
window.location.href= "<?php echo base_url('User2/lihat_berkas_client/')?>"+no_client ;        
}

function cari_jenis_pekerjaan(){
var <?php echo $this->security->get_csrf_token_name();?>  = "<?php echo $this->security->get_csrf_hash(); ?>"       
$("#jenis_akta,#jenis_akta_perorangan").autocomplete({
minLength:0,
delay:0,
source:'<?php echo site_url('User2/cari_jenis_pekerjaan') ?>',
select:function(event, ui){
$("#id_jenis_akta").val("");
$("#id_jenis_akta,#id_jenis_akta_perorangan").val(ui.item.no_jenis_pekerjaan);
}
});
}

function target_kelar() {
$("input[name='target_kelar']").datepicker({ minDate:0,dateFormat: 'yy/mm/dd'
});
}

function simpan_pekerjaan_baru(){

$(".simpan_pekerjaan").attr("disabled", true);
$("#form_pekerjaan_baru").find(".form-control").removeClass("is-invalid").addClass("is-valid");
$('.form-control + p').remove();
$.ajax({
url  : "<?php echo base_url("User2/buat_pekerjaan_baru") ?>",
type : "post",
data : $("#form_pekerjaan_baru").serialize(),
success: function(data) {
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#form_pekerjaan_baru").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#form_pekerjaan_baru").find("#"+key).removeClass("is-valid");
});
});
}else{
read_response(data);
window.location.href="<?php echo base_url('User2/lengkapi_persyaratan/') ?>"+r[0].no_pekerjaan;

}
$(".simpan_pekerjaan").attr("disabled", false);

}
});
}


</script>
</body>
