<body>
<?php $this->load->view('umum/user2/V_sidebar_user2'); ?>
<div id="page-content-wrapper">
<?php $this->load->view('umum/user2/V_navbar_user2'); ?>
<?php $this->load->view('umum/user2/V_data_user2'); ?>
<div class="container-fluid">
<div class="card p-2 mt-2">
<div class="row">
<div class="col">
<h5 align="center"><i class="fa fa-3x fa-users"></i><br>Data perorangan yang telah anda kerjakan</h5>

<table style="width:100%;" id="data_perorangan" class="table table-striped table-condensed table-sm table-bordered  table-hover table-sm"><thead>
<tr role="row">
<th  align="center" aria-controls="datatable-fixed-header"  >No</th>
<th  align="center" aria-controls="datatable-fixed-header"  >no nama perorangan</th>
<th  align="center" aria-controls="datatable-fixed-header"  >nama perorangan</th>
<th  align="center" aria-controls="datatable-fixed-header"  >no identitas</th>
<th  align="center" aria-controls="datatable-fixed-header"  >jenis identitas</th>
<th  align="center" aria-controls="datatable-fixed-header"  >jabatan</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Download </th>
</thead>
<tbody align="center">
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

var t = $("#data_perorangan").dataTable({
initComplete: function() {
var api = this.api();
$('#data_perorangan')
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
ajax: {"url": "<?php echo base_url('user2/json_data_perorangan') ?> ", 
"type": "POST",
data: function ( d ) {
d.token = '<?php echo $this->security->get_csrf_hash(); ?>';
}
},
columns: [
{
"data": "id_perorangan",
"orderable": false
},
{"data": "no_nama_perorangan"},
{"data": "nama_identitas"},
{"data": "no_identitas"},
{"data": "jenis_identitas"},
{"data": "status_jabatan"},
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


function download_lampiran(id){
window.location="<?php echo base_url('Dashboard/download_lampiran_perorangan') ?>/"+id;

/*
var token    = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
url :"<?php echo base_url('Dashboard/download_lampiran_perorangan') ?>",
data:"token="+token+"&id_perorangan="+id,
success:function(response){
var r = JSON.parse(response);
if(r.status == "Gagal"){
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated zoomInDown'
});

Toast.fire({
type: 'error',
title: r.pesan
})    
}else{

const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated zoomInDown'
});

Toast.fire({
type: 'success',
title: r.pesan
})

}
}
});*/
}

</script>    


</body>
