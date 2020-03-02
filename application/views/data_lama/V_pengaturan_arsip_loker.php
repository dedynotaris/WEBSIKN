<body>
<?php  $this->load->view('umum/data_lama/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/data_lama/V_navbar_data_lama'); ?>
<?php  $this->load->view('umum/data_lama/V_data_data_lama'); ?>
<div class="container-fluid mt-2">
<div class="row">
<div class="col-md-4">
<div class="card">
<div class="card-header text-center">Buat Tempat Arsip Fisik</div>
<div class="card-body">
<form id="formbuatlemari">
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" readonly="" class="form-control required"  accept="text/plain">    
<label>Nama Tempat</label>
<input type="text" name="nama_tempat" id="nama_tempat" placeholder="nama tempat" class="form-control form-control-sm">

</div>
<div class="card-footer">
<button type="button" onclick="simpanlemari()" class="btn btn-success btn-sm btn-block">Simpan Tempat Penyimpanan Arsip Fisik</button>
</div>
</form>
</div>
</div>

    <div class="col">
        <table style="width:100%;" id="daftar_lemari" class="table  text-theme1  table-striped table-condensed table-sm table-bordered  table-hover table-sm"><thead>
<tr role="row">
<th  align="center" aria-controls="datatable-fixed-header"  >No</th>
<th  align="center" aria-controls="datatable-fixed-header"  >No Lemari</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Nama Tempat</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Aksi</th>
</thead>
<tbody>
</table>
        
    </div>
</div>
</div>    

<script type="text/javascript">
function printlabelloker(id_no_loker){
window.open("<?php echo base_url('Data_lama/PrintLabelLoker/')  ?>"+btoa(id_no_loker));    
}     
function UpdateLoker(id_loker){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
var status_loker      = $(".status_loker"+id_loker+" option:selected").text();
$.ajax({
type:"post",
data:"token="+token+"&id_loker="+id_loker+"&status_loker="+status_loker,
url:"<?php echo base_url('data_lama/update_loker') ?>",
success:function(data){
read_response(data);
$("#formbuatlemari").find(".form-control").val("").attr('readonly', false).removeClass("is-valid");
var table = $('#daftar_lemari').DataTable();
table.ajax.reload( function ( json ) {
$('#daftar_lemari').val( json.lastInput );
});    
}
});
}

function buatlokerlemari(no_lemari){
if($(".lemari"+no_lemari).length > 0 ){
$('.lemari'+no_lemari).slideUp("slow").remove();
$(".btn-lemari"+no_lemari).addClass("btn-dark").removeClass("btn-warning").html("Buat Loker <i class='fa fa-cogs'></i>");
}else{        
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_lemari="+no_lemari,
url:"<?php echo base_url('data_lama/setting_lemari') ?>",
success:function(data){
$("."+no_lemari).after(data);    
$(".btn-lemari"+no_lemari).addClass("btn-warning").removeClass("btn-dark").html("Tutup Loker<i class='fa fa-cogs'></i>");    
}
});
}  
}    
function simpanlemari(){
$("#formbuatlemari").find(".form-control").removeClass("is-invalid").addClass("is-valid");
$("#formbuatlemari").find('.form-control + p').remove();
$.ajax({
type:"post",
data:$("#formbuatlemari").serialize(),
url:"<?php echo base_url('Data_lama/simpanlemari') ?>",
success:function(data){
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#formbuatlemari").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#formbuatlemari").find("#"+key).removeClass("is-valid");
});
});
}else{
read_response(data);
$("#formbuatlemari").find(".form-control").val("").attr('readonly', false).removeClass("is-valid");
var table = $('#daftar_lemari').DataTable();
table.ajax.reload( function ( json ) {
$('#daftar_lemari').val( json.lastInput );
});
}
}

});
}


function simpanloker(no_lemari){
$("#formbuatloker").find(".form-control").removeClass("is-invalid").addClass("is-valid");
$("#formbuatloker").find('.form-control + p').remove();
$.ajax({
type:"post",
data:$("#formbuatloker"+no_lemari).serialize(),
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
var table = $('#daftar_lemari').DataTable();
table.ajax.reload( function ( json ) {
$('#daftar_lemari').val( json.lastInput );
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

var t = $("#daftar_lemari").dataTable({   
'createdRow': function( row, data, dataIndex ) {
      $(row).addClass( data.no_lemari );
},    
initComplete: function() {
var api = this.api();
$('#daftar_lemari')
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
ajax: {"url": "<?php echo base_url('data_lama/json_daftar_lemari/'.$this->uri->segment(3))?> ", 
"type": "POST",
data: function ( d ) {
d.token = '<?php echo $this->security->get_csrf_hash(); ?>';
}
},
columns: [
{
"data": "no_lemari",
"orderable": false,
"class":"no_lemari"
},
{"data": "no_lemari"},
{"data": "nama_tempat"},
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
