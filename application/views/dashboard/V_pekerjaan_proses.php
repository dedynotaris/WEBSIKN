<body>
<?php  $this->load->view('umum/V_sidebar'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar'); ?>
<div class="container-fluid">
<div class="mt-2  text-center  ">
<h5 align="center " class="text-info"><span class="fa-3x fas fa-pencil-alt "></span><br> PEKERJAAN DI PROSES</h5>
</div>
    
<div class="row">    
<div class="col mt-2">
<table style="width:100%;" id="data_pekerjaan" class="table table-striped table-condensed table-sm table-bordered  table-hover table-sm"><thead>
        <tr class="text-info" role="row">
<th   aria-controls="datatable-fixed-header"  >No</th>
<th   aria-controls="datatable-fixed-header"  >Jenis Pekerjaan</th>
<th   aria-controls="datatable-fixed-header"  >Pembuat</th>
<th   aria-controls="datatable-fixed-header"  >Tanggal Dibuat</th>
<th   aria-controls="datatable-fixed-header"  >Nama Client</th>
<th   aria-controls="datatable-fixed-header"  >Status</th>
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

var t = $("#data_pekerjaan").dataTable({
initComplete: function() {
var api = this.api();
$('#data_pekerjaan')
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
ajax: {"url": "<?php echo base_url('Dashboard/json_data_pekerjaan') ?> ", 
"type": "POST",
data: function ( d ) {
d.token = '<?php echo $this->security->get_csrf_hash(); ?>';
}
},
columns: [
{
"data": "id_data_pekerjaan",
"orderable": false
},
{"data": "jenis_perizinan"},
{"data": "pembuat_pekerjaan"},
{"data": "tanggal_dibuat"},
{"data": "nama_client"},
{"data": "status_pekerjaan"},
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


</script>


</body>

