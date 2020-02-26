
<table style="width:100%;" id="data_utama" class="table  text-theme1  table-striped table-condensed table-sm table-bordered  table-hover table-sm"><thead>
<tr role="row">
<th  align="center" aria-controls="datatable-fixed-header"  >No</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Pekerjaan</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Jenis Dokumen</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Tanggal Akta</th>
<th  align="center" aria-controls="datatable-fixed-header"  >No Akta</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Aksi</th>
</thead>
<tbody >
</table>

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

var t = $("#data_utama").dataTable({
 'createdRow': function( row, data, dataIndex ) {
      $(row).addClass( data.no_berkas );
  },    
initComplete: function() {
var api = this.api();
$('#data_utama')
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
ajax: {"url": "<?php echo base_url('data_lama/json_data_utama_client/'.$this->uri->segment(3))?> ", 
"type": "POST",
data: function ( d ) {
d.token = '<?php echo $this->security->get_csrf_hash(); ?>';
}
},
columns: [
{
"data": "id_data_dokumen_utama",
"orderable": false,
"class":"id_data_dokumen_utama"
},
{"data": "nama_jenis"},
{"data": "jenis"},
{"data": "tanggal_akta"},
{"data": "no_akta"},
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
    