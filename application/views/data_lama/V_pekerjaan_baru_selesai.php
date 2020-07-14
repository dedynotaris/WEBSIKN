<body>
<?php  $this->load->view('umum/data_lama/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/data_lama/V_navbar_data_lama'); ?>

<?php echo $this->breadcrumbs->show(); ?>
<div class="container-fluid mt-2">

    <div class="row">

    <div class="col">
        <table style="width:100%;" id="daftar_pekerjaan" class="table  table-striped table-bordered"><thead>
        <tr class='bg-info text-center  text-white'>
<td colspan='6'>Data Pekerjaan Selesai yang akan dimasukan kedalam bantex</td>
</tr>
<tr class="text-info" role="row">
<th   aria-controls="datatable-fixed-header"  >No</th>
<th   aria-controls="datatable-fixed-header"  >Pekerjaan</th>
<th   aria-controls="datatable-fixed-header"  >Nama Pekerjaan</th>
<th   aria-controls="datatable-fixed-header"  >Nama Client</th>
<th   aria-controls="datatable-fixed-header"  >Asisten</th>
<th   aria-controls="datatable-fixed-header"  >Setting loker</th>
</tr>
</thead>
<tbody>
</table>
        
    </div>
</div>
</div>    
<!------------- Modal ---------------->
<div class="modal fade bd-example-modal-lg"  id="modal"  role="dialog" aria-labelledby="tambah_syarat1" aria-hidden="true">
<div class="modal-dialog modal-lg data_modal" role="document">
</div>
</div>
</div>

<script type="text/javascript">
function SimpanArsipFisik(no_bantek,no_pekerjaan){
  Swal.fire({
  text: "Pekerjaan akan dimasukan kedalam bantex tersebut, Kamu yakin ?",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Ya, Yakin!'
}).then((result) => {
if (result.value) {
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_bantek="+no_bantek+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('data_lama/SimpanArsipFisik') ?>",
success:function(data){
read_response(data);    
var table = $('#daftar_pekerjaan').DataTable();
table.ajax.reload( function ( json ) {
$('#daftar_pekerjaan').val( json.lastInput );
}); 
}
});
}
});   
}

function DetailBantek(no_pekerjaan){
var token           = "<?php echo $this->security->get_csrf_hash(); ?>";
var no_bantek       = $(".no_bantex"+no_pekerjaan+" option:selected").val();
$.ajax({
type:"post",
url:"<?php echo base_url('Data_lama/DetailBantek') ?>",
data:"token="+token+"&no_bantek="+no_bantek+"&no_pekerjaan="+no_pekerjaan,
success:function(data){
$(".DetailBantek"+no_pekerjaan).html(data);    
}
});
}

function BuatBantek(no_pekerjaan){
var token           = "<?php echo $this->security->get_csrf_hash(); ?>";
$.ajax({
type:"post",
url:"<?php echo base_url('Data_lama/FormBuatBantek') ?>",
data:"token="+token,
success:function(data){
$(".data_modal").html(data);    
$('#modal').modal('show');
}
});
}
  
  

function pilihloker(id_no_loker,no_loker){
var nama_lemari = $(".no_lemari option:selected").text();
var no_bantex   = $(".no_bantek").val();
var judul       = $(".judul").val();
Swal.fire({
  text: no_bantex+" akan dimasukan kedalam "+nama_lemari+" di loker nomor "+no_loker +" Kamu yakin ?",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Ya, Yakin!'
}).then((result) => {
if (result.value) {
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&id_no_loker="+id_no_loker+"&no_bantek="+no_bantex+"&judul="+judul,
url:"<?php echo base_url('data_lama/simpan_arsip_bantek') ?>",
success:function(data){
read_response(data);    
var table = $('#daftar_pekerjaan').DataTable();
table.ajax.reload( function ( json ) {
$('#daftar_pekerjaan').val( json.lastInput );
}); 
}
});
}
});    
  
$('#modal').modal('hide');   
}    
function tampilkanloker(no_pekerjaan){
var no_lemari = $(".no_lemari option:selected").val();
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan+"&no_lemari="+no_lemari,
url:"<?php echo base_url('data_lama/tampilkan_loker') ?>",
success:function(data){
$(".daftarloker").html(data);    
}
});
}    
    
    
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
{"data": "asisten"},
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
