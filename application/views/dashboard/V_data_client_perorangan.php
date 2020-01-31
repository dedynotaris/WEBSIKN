<body>
<?php  $this->load->view('umum/V_sidebar'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar'); ?>
<div class="container-fluid">
<div class="mt-4 mb-2 text-theme1 text-center"><i class="fa fa-users fa-4x"></i></span><br> Data Client Perorangan</div>
    
<div class="row">    
<div class="col mt-2">
<table style="width:100%;" id="data_client" class="table table-striped table-condensed table-sm table-bordered  table-hover table-sm"><thead>
<tr role="row">
<th   aria-controls="datatable-fixed-header"  >No</th>
<th   aria-controls="datatable-fixed-header"  >No Client</th>
<th   aria-controls="datatable-fixed-header"  >Nama Client</th>
<th   aria-controls="datatable-fixed-header"  >No NPWP</th>
<th   aria-controls="datatable-fixed-header"  >Pembuat Client</th>
<th   aria-controls="datatable-fixed-header"  >Jenis Client</th>
<th   aria-controls="datatable-fixed-header"  >Aksi</th>
</thead>
<tbody >
</table>            
</div>
</div>
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
ajax: {"url": "<?php echo base_url('Dashboard/json_data_client_perorangan') ?> ", 
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
{"data": "no_identitas"},
{"data": "pembuat_client"},
{"data": "jenis_client"},
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

function DetailClient(no_client){
window.location.href="<?php echo base_url('Dashboard/DetailClient/'); ?>"+btoa(no_client);    
}
</script>




</body>

