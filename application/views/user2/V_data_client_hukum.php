<body>
<?php $this->load->view('umum/user2/V_sidebar_user2'); ?>
<div id="page-content-wrapper">
<?php $this->load->view('umum/user2/V_navbar_user2'); ?>

<?php echo $this->breadcrumbs->show(); ?>
<div class="container-fluid "> 
<div class="p-2 mt-2">

<div class="row">
<div class="col">

<table style="width:100%;" id="data_client" class="table  table-striped table-bordered "><thead>
<tr class='bg-info text-center  text-white'>
<td colspan='6'>Data Cliet Badan Hukum  </td>
</tr>
<tr  role="row">
<th   aria-controls="datatable-fixed-header"  >No</th>
<th   aria-controls="datatable-fixed-header"  >No NPWP</th>
<th   aria-controls="datatable-fixed-header"  >Nama client</th>
<th   aria-controls="datatable-fixed-header"  >Jenis client</th>
<th   aria-controls="datatable-fixed-header"  >Asisten</th>
<th   aria-controls="datatable-fixed-header"  >Aksi</th>
</thead>
<tbody >
</table> 
</div>
</div>
</div>

<!------------- Modal ---------------->
<div class="modal fade bd-example-modal-md" id="modal" tabindex="-1" role="dialog" aria-labelledby="tambah_syarat1" aria-hidden="true">
<div class="modal-dialog modal-lg data_modal" role="document">

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
"data": "no_client",
"orderable": false
},
{"data": "no_identitas"},
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
$(".update_client").attr("disabled", true);
$("#form_update_client").find(".form-control").removeClass("is-invalid").addClass("is-valid");
$('.form-control + p').remove();
$.ajax({
url  : "<?php echo base_url("User2/update_client") ?>",
type : "post",
data : $("#form_update_client").serialize(),
success: function(data) {
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#form_update_client").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#form_update_client").find("#"+key).removeClass("is-valid");
});
});
}else{
refresh_nama_dokumen();
read_response(data);
$('#modal').modal('hide');
}
$(".update_client").attr("disabled", false);
}
});
}

function refresh_nama_dokumen(){
var table = $('#data_client').DataTable();
table.ajax.reload( function ( json ) {
$('#data_client').val( json.lastInput );
});
}

function lihat_berkas(no_client){
window.location.href= "<?php echo base_url('User2/lihat_berkas_client/')?>"+no_client ;        
}



</script>
</body>
