<body>
<?php $this->load->view('umum/data_lama/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/data_lama/V_navbar_data_lama'); ?>
<?php echo $this->breadcrumbs->show(); ?>
<div class="container-fluid ">

<div class="row">
<div class="col mt-2">
<table style="width:100%;" id="DataArsipSelesai" class="table table-bordered  table-striped  "><thead>
<tr class='bg-info text-center  text-white'>
<td colspan='6'>Data Pekerjaan yang telah selesai di kerjakan</td>
</tr>
<tr  role="row">
<th   aria-controls="datatable-fixed-header"  >No</th>
<th   aria-controls="datatable-fixed-header"  >No Pekerjaan</th>
<th   aria-controls="datatable-fixed-header"  >Nama Client</th>
<th   aria-controls="datatable-fixed-header"  >Asisten</th>
<th   aria-controls="datatable-fixed-header"  >Jenis Pekerjaan</th>
</tr>
</thead>
<tbody >
</table> 

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

var t = $("#DataArsipSelesai").dataTable({
initComplete: function() {
var api = this.api();
$('#DataArsipSelesai')
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
ajax: {"url": "<?php echo base_url('Data_lama/JsonDataPekerjaanArsipSelesai') ?> ", 
"type": "POST",
data: function ( d ) {
d.token = '<?php echo $this->security->get_csrf_hash(); ?>';
}
},
columns: [
{
"data": "no_pekerjaan",
"orderable": false
},
{"data": "no_pekerjaan"},
{"data": "nama_client"},
{"data": "nama_lengkap"},
{"data": "nama_jenis"}


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
function download(id_data_berkas){
window.location.href="<?php echo base_url('Dashboard/download_berkas/') ?>"+id_data_berkas
}


</script>



</body>
