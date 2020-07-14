
<table style="width:100%;" id="table_pekerjaan" class="table    table-striped table-condensed table-sm table-bordered  table-hover table-sm"><thead>
        <tr class="text-info" role="row">
<th  align="center" aria-controls="datatable-fixed-header"  >No</th>
<th  align="center" aria-controls="datatable-fixed-header"  >No Pekerjaan</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Pekerjaan</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Tanggal dibuat</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Status</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Asisten</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Aksi</th>
</thead>
<tbody>
</table>

<script type="text/javascript">
function PindahClient(no_client){
Swal.fire({
  text: "kamu yakin ingin berpindah client ?",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Ya, Yakin!'
}).then((result) => {
  if (result.value) {
window.location.href="<?php echo base_url('Data_lama/lihat_client/') ?>"+btoa(no_client);
}
});
}    
    
    
function lihat_terlibat(no_client,no_pekerjaan){
if($(".pekerjaan"+no_pekerjaan).length > 0 ){
$('.pekerjaan'+no_pekerjaan).slideUp("slow").remove();
$(".btn-pekerjaan"+no_pekerjaan).addClass("btn-dark").removeClass("btn-warning").html("Lihat");

}else{    
    
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan+"&no_client="+no_client,
url:"<?php echo base_url('data_lama/lihat_terlibat') ?>",
success:function(data){
$("."+no_pekerjaan).after(data);    
$(".btn-pekerjaan"+no_pekerjaan).addClass("btn-warning").removeClass("btn-dark").html("Tutup ");
    
}
});
}
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

var t = $("#table_pekerjaan").dataTable({
 'createdRow': function( row, data, dataIndex ) {
      $(row).addClass(data.no_pekerjaan );
  },    
initComplete: function() {
var api = this.api();
$('#table_pekerjaan')
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
ajax: {"url": "<?php echo base_url('data_lama/json_data_pekerjaan_client/'.$this->uri->segment(3))?> ", 
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
{"data": "tanggal_dibuat"},
{"data": "status_pekerjaan"},
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

</script>    
    