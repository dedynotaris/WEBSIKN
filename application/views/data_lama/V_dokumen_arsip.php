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
function simpan_peminjam(no_pekerjaan){
var nama_peminjam = $(".no_peminjam"+no_pekerjaan+" option:selected").text();    
var no_peminjam = $(".no_peminjam"+no_pekerjaan+" option:selected").val();    
Swal.fire({
  text: "Arsip Fisik akan dipinjamkan ke "+nama_peminjam+" Kamu yakin ?",
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
data:"token="+token+"&no_peminjam="+no_peminjam+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('data_lama/simpan_peminjam') ?>",
success:function(data){
read_response(data);    
var table = $('#daftar_arsip').DataTable();
table.ajax.reload( function ( json ) {
$('#daftar_arsip').val( json.lastInput );
}); 
}
});
}
});     
}

function pinjamarsip(no_pekerjaan){
if($(".pinjamarsip"+no_pekerjaan).length > 0 ){
$('.pinjamarsip'+no_pekerjaan).slideUp("slow").remove();
$(".btn-pinjam"+no_pekerjaan).addClass("btn-dark").removeClass("btn-warning").html("Pinjam Arsip");
}else{        
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('data_lama/pinjamarsip') ?>",
success:function(data){
$("."+no_pekerjaan).after(data);    
$(".btn-pinjam"+no_pekerjaan).addClass("btn-warning").removeClass("btn-dark").html("Tutup");    
}
});
}
}   
     
    
function pilihloker(id_no_loker,no_loker,no_pekerjaan){
var nama_lemari = $(".no_lemari"+no_pekerjaan+" option:selected").text();    
Swal.fire({
  text: "Arsip Fisik akan dimasukan "+nama_lemari+" di loker nomor "+no_loker +" Kamu yakin ?",
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
data:"token="+token+"&id_no_loker="+id_no_loker+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('data_lama/simpan_arsip_fisik') ?>",
success:function(data){
read_response(data);    
var table = $('#daftar_arsip').DataTable();
table.ajax.reload( function ( json ) {
$('#daftar_arsip').val( json.lastInput );
}); 
}
});
}
});    
    
}    
function tampilkanloker(no_pekerjaan){
var no_lemari = $(".no_lemari"+no_pekerjaan+" option:selected").val();
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan+"&no_lemari="+no_lemari,
url:"<?php echo base_url('data_lama/tampilkan_loker') ?>",
success:function(data){
$(".daftarloker"+no_pekerjaan).html(data);    
}
});
}        
    
function settingloker(no_pekerjaan){
if($(".settingloker"+no_pekerjaan).length > 0 ){
$('.settingloker'+no_pekerjaan).slideUp("slow").remove();
$(".btn-loker"+no_pekerjaan).addClass("btn-dark").removeClass("btn-warning").html("Pindah Lokers");
}else{        
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('data_lama/setting_loker') ?>",
success:function(data){
$("."+no_pekerjaan).after(data);    
$(".btn-loker"+no_pekerjaan).addClass("btn-warning").removeClass("btn-dark").html("Tutup </i>");    
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
