<body>
<?php  $this->load->view('umum/data_lama/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/data_lama/V_navbar_data_lama'); ?>
<?php  $this->load->view('umum/data_lama/V_data_data_lama'); ?>
<div class="container-fluid mt-2">
<div class="mt-2  text-center  ">
<h5 align="center " class="text-theme1"><span class="fa-2x fas fa-folder-open "></span><br>Daftar Dokumen yang sudah diarsipkan</h5>
</div>
    <div class="row">

    <div class="col">
        <table style="width:100%;" id="daftar_arsip" class="table  text-theme1  table-striped table-condensed table-sm table-bordered  table-hover table-sm"><thead>
<tr role="row">
<th  align="center" aria-controls="datatable-fixed-header"  >No</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Pekerjaan</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Nama Pekerjaan</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Nama Client</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Asisten</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Lokasi Arsip</th>
<th  align="center" aria-controls="datatable-fixed-header"  >No Loker</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Aksi</th>
</thead>
<tbody>
</table>
        
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

var t = $("#daftar_arsip").dataTable({
'createdRow': function( row, data, dataIndex ) {
      $(row).addClass( data.no_pekerjaan );
  },    
initComplete: function() {
var api = this.api();
$('#daftar_arsip')
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
ajax: {"url": "<?php echo base_url('data_lama/json_daftar_arsip/')?> ", 
"type": "POST",
data: function ( d ) {
d.token = '<?php echo $this->security->get_csrf_hash(); ?>';
}
},
columns: [
{
"data": "no_pekerjaan",
"orderable": false,
"class":"no_pekerjaan"
},
{"data": "no_pekerjaan"},
{"data": "nama_jenis"},
{"data": "nama_client"},
{"data": "asisten"},
{"data": "nama_tempat"},
{"data": "no_loker"},
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
