<body>
<?php  $this->load->view('umum/data_lama/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/data_lama/V_navbar_data_lama'); ?>
<?php  $this->load->view('umum/data_lama/V_data_data_lama'); ?>
<div class="container-fluid mt-2">
<div class="mt-2  text-center  ">
<h5 align="center " class="text-theme1"><span class="fa-2x fas fa-flag-checkered "></span><br>Pekerjaan Baru Selesai</h5>
</div>
    <div class="row">

    <div class="col">
        <table style="width:100%;" id="daftar_pekerjaan" class="table  text-theme1  table-striped table-condensed table-sm table-bordered  table-hover table-sm"><thead>
<tr role="row">
<th  align="center" aria-controls="datatable-fixed-header"  >No</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Pekerjaan</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Nama Pekerjaan</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Nama Client</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Setting loker</th>
</thead>
<tbody>
</table>
        
    </div>
</div>
</div>    

<script type="text/javascript">
function settingloker(no_pekerjaan){
if($(".settingloker"+no_pekerjaan).length > 0 ){
$('.settingloker'+no_pekerjaan).slideUp("slow").remove();
$(".btn-loker"+no_pekerjaan).addClass("btn-dark").removeClass("btn-warning").html("Loker <i class='fa fa-cogs'></i>");
}else{        
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('data_lama/setting_loker') ?>",
success:function(data){
$("."+no_pekerjaan).after(data);    
$(".btn-loker"+no_pekerjaan).addClass("btn-warning").removeClass("btn-dark").html("Tutup <i class='fa fa-cogs'></i>");    
}
});
}
}  
    
function simpanloker(){
$("#formbuatloker").find(".form-control").removeClass("is-invalid").addClass("is-valid");
$("#formbuatloker").find('.form-control + p').remove();
$.ajax({
type:"post",
data:$("#formbuatloker").serialize(),
url:"<?php echo base_url('Data_lama/simpanloker') ?>",
success:function(data){
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#formbuatloker").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#formbuatloker").find("#"+key).removeClass("is-valid");
});
});
}else{
read_response(data);
$("#formbuatloker").find(".form-control").val("").attr('readonly', false).removeClass("is-valid");
var table = $('#daftar_loker').DataTable();
table.ajax.reload( function ( json ) {
$('#daftar_loker').val( json.lastInput );
});
}
}

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

var t = $("#daftar_pekerjaan").dataTable({
'createdRow': function( row, data, dataIndex ) {
      $(row).addClass( data.no_pekerjaan );
  },    
initComplete: function() {
var api = this.api();
$('#daftar_pekerjaan')
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
ajax: {"url": "<?php echo base_url('data_lama/json_daftar_pekerjaan_selesai/')?> ", 
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
