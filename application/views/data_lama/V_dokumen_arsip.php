<body>

<?php  $this->load->view('umum/data_lama/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/data_lama/V_navbar_data_lama'); ?>
<?php echo $this->breadcrumbs->show(); ?>
<div class="container-fluid mt-2">
<style>
@media print{
body  {
 visibility :hidden; 
}

.table .table {
  background-color: #fff;
}

.table-bordered {
  border: 1px solid #000;
}

.table-bordered th,
.table-bordered td {
  border: 1px solid #000;
}

.table-bordered thead th,
.table-bordered thead td {
  border-bottom-width: 2px;
}
}
</style>
<div class="mt-2    ">

    <div class="row">

    <div class="col">
        <table style="width:100%;" id="daftar_arsip" class="table  table-striped table-bordered"><thead>
              
        <tr class='bg-info text-center  text-white'>
<td colspan='7'>Data Arsip yang telah dimasukan kedalam bantex</td>
</tr>
                <tr role="row">
<th   aria-controls="datatable-fixed-header"  >No</th>
<th   aria-controls="datatable-fixed-header"  >No Bantex</th>
<th   aria-controls="datatable-fixed-header"  >Judul</th>
<th   aria-controls="datatable-fixed-header"  >Pengarsip</th>
<th   aria-controls="datatable-fixed-header"  >Lokasi Arsip</th>
<th   aria-controls="datatable-fixed-header"  >No Loker</th>
<th   aria-controls="datatable-fixed-header"  >Aksi</th>
</tr>
</thead>
<tbody>
</table>
        
    </div>
</div>
</div>    

<script type="text/javascript">
function BalikanLoker(no_bantek){
Swal.fire({
  text: "Anda akan mengembalikan arsip fisik ke loker semula, Kamu yakin ?",
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
data:"token="+token+"&no_bantek="+no_bantek,
url:"<?php echo base_url('data_lama/balikan_arsip') ?>",
success:function(data){
read_response(data); var table = $('#daftar_arsip').DataTable();
table.ajax.reload( function ( json ) {
$('#daftar_arsip').val( json.lastInput );
}); 
}
});
}
});     
}

function PinjamBantek(no_bantek){

var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_bantek="+no_bantek,
url:"<?php echo base_url('data_lama/DataAsisten') ?>",
success:function(data){
var r = JSON.parse(data);
  Swal.fire({
  title: 'Pilih Nama Asisten yang meminjam Bantex',
  input: 'select',
  inputOptions:r,
  inputPlaceholder: 'Nama Asisten',
  showCancelButton: true,
  inputValidator: (value) => {

var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_bantek="+no_bantek+"&no_peminjam="+value,
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
})


}
});
}

function PrintLabel(no_bantek){
  var pageTitle = 'Page Title'
  var htmlToPrint = '' +
        '<style type="text/css">' +
        'table th, table td {' +
        'border:1px solid #000;' +
        'padding:0.5em;' +
        'margin:0.5em;' +
        '}' +
        '</style>';
            stylesheet = '<?php echo base_url() ?>assets/bootstrap-4.1.3/dist/css/bootstrap.css',
           
            win = window.open('', 'Print');
            win.document.write(htmlToPrint);
        win.document.write('<html><head><title>Print Label Bantex</title>' +
            '<link rel="stylesheet" href="'+ stylesheet +'">' +
            '</head><body>' + $('#print'+no_bantek)[0].outerHTML + '</body></html>');
        win.document.close();
        win.print();
        win.close();
        return false;
}

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
var no_bantex   = $(".no_bantex"+no_pekerjaan+" option:selected").text();
Swal.fire({
  text: "Arsip Fisik akan dimasukan kedalam bantex "+no_bantex+" "+nama_lemari+" di loker nomor "+no_loker +" Kamu yakin ?",
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
data:"token="+token+"&id_no_loker="+id_no_loker+"&no_pekerjaan="+no_pekerjaan+"&no_bantex="+no_bantex,
url:"<?php echo base_url('data_lama/simpan_arsip_fisik') ?>",
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
    
function EditBantex(no_bantex){
if($(".settingloker"+no_bantex).length > 0 ){
$('.settingloker'+no_bantex).slideUp("slow").remove();
$(".btn-loker"+no_bantex).addClass("btn-dark").removeClass("btn-warning").html("Detail Bantek");
}else{        
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_bantek="+no_bantex,
url:"<?php echo base_url('data_lama/EditBantek') ?>",
success:function(data){
$("."+no_bantex).after(data);    
$(".btn-loker"+no_bantex).addClass("btn-warning").removeClass("btn-dark").html("Tutup </i>");    
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
      $(row).addClass( data.no_bantek );
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
"data": "no_bantek",
"orderable": false,
"class":"no_bantek"
},
{"data": "no_bantek"},
{"data": "judul"},
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
