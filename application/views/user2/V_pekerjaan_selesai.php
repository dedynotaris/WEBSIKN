<body>
<?php $this->load->view('umum/user2/V_sidebar_user2'); ?>
<div id="page-content-wrapper">
<?php $this->load->view('umum/user2/V_navbar_user2'); ?>
<?php echo $this->breadcrumbs->show(); ?>
<div class="container-fluid">

   
<div class="row p-2">
<div class="col ">    
<table style="width:100%;" id="data_pekerjaan_selesai" class="table  text-center table-bordered table-striped "><thead>
<tr class='bg-info text-center  text-white'>
<td colspan='6'>Data Pekerjaan yang di kerjakan pada bulan  <?php echo date('F') ?></td>
</tr>
        <tr  role="row">
<th aria-controls="datatable-fixed-header"  >No</th>
<th aria-controls="datatable-fixed-header"  >No Pekerjaan</th>
<th aria-controls="datatable-fixed-header"  >Nama Client</th>
<th aria-controls="datatable-fixed-header"  >Jenis pekerjaan</th>
<th aria-controls="datatable-fixed-header"  >Tanggal selesai</th>
<th aria-controls="datatable-fixed-header"  >Aksi</th>
</thead>
<tbody >
</table>

</div>
</div>        
</div>
</div>  
</div>
<script type="text/javascript">

function lihat_berkas(no_client){
window.location.href="<?php echo base_url('User2/lihat_berkas_client/') ?>"+no_client;
    
}


function proses_ulang(id_data_pekerjaan){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&id_data_pekerjaan="+id_data_pekerjaan,
url:"<?php echo base_url('User2/proses_ulang') ?>",
success:function(data){
read_response(data)
refresh_table();
}
});
}

function refresh_table(){
var table = $('#data_pekerjaan_selesai').DataTable();
table.ajax.reload( function ( json ) {
$('#data_pekerjaan_selesai').val( json.lastInput );
});

}

    
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

var t = $("#data_pekerjaan_selesai").dataTable({
initComplete: function() {
var api = this.api();
$('#data_pekerjaan_selesai')
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
ajax: {"url": "<?php echo base_url('User2/json_data_pekerjaan_selesai') ?> ", 
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
{"data": "pekerjaan"},
{"data": "tanggal_selesai"},
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
