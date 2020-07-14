<body>
<?php  $this->load->view('umum/data_lama/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/data_lama/V_navbar_data_lama'); ?>
<?php echo $this->breadcrumbs->show(); ?>
<div class="container-fluid">
    
    
<div class="mt-2 ">


<div class="row ">
<div class="col ">
<table style="width:100%;" id="data_arsip" class="table  table-striped table-bordered  "><thead>
<tr class='bg-info text-center  text-white'>
<td colspan='7'>Data Client Badan Hukum</td>
</tr>
  <tr  role="row">
<th   aria-controls="datatable-fixed-header"  >No</th>
<th   aria-controls="datatable-fixed-header"  >No Client</th>
<th   aria-controls="datatable-fixed-header"  >NIK</th>
<th   aria-controls="datatable-fixed-header"  >Nama client</th>
<th   aria-controls="datatable-fixed-header"  >Nama Asisten</th>
<th   aria-controls="datatable-fixed-header"  >Aksi</th>
</thead>
<tbody >
</table> 
</div>
</div>    
    
</div>
</div>

</body>
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

var t = $("#data_arsip").dataTable({
initComplete: function() {
var api = this.api();
$('#data_arsip')
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
ajax: {"url": "<?php echo base_url('Data_lama/json_data_arsip_perorangan') ?> ", 
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
{"data": "no_client"},
{"data": "no_identitas"},
{"data": "nama_client"},
{"data": "nama_lengkap"},
{"data": "view"}


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

