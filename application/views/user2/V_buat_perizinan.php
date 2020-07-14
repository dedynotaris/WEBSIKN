<body onload="refresh()">
<?php  $this->load->view('umum/User2/V_sidebar_user2'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/User2/V_navbar_user2'); ?>

<?php echo $this->breadcrumbs->show(); ?>
<?php $static = $query->row_array(); ?>
<style>
.is-invalid .select2-selection {
border-color: rgb(185, 74, 72) !important;
}
.select2-container {
    display: block;   
}
.swal2-container {
z-index: 1000000;;
}
.input-group {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    -ms-flex-align: stretch;
    align-items: stretch;
    width: 100%;
}
element.style {
    width: 68%;
    background-color: white;
}
.input-group-prepend {
    margin-right: -1px;
    position: static;
}

span.select2.select2-container.select2-container--default.select2-container--focus{
width: 60%;    
}

</style> 
<div class="container ">    
<div class="card-header text-info  mt-2 mb-2 text-center">
Halaman Untuk Melengkapi Persyaratan <?php echo ucwords(strtolower($static['nama_client'])) ?>
<button class="btn btn-dark btn-sm float-md-right "  onclick="lanjutkan_proses_selesai('<?php echo $this->uri->segment(3) ?>');">Selesaikan Pekerjaan <span class="fa fa-arrow-right"></span></button>
</div>



<div class="row">

<div class="col-md-6">
<label>*Pilih Jenis pihak terlibat</label>
<select name="jenis_client" id="jenis_client" class="form-control required" accept="text/plain">
<option value="Perorangan">Perorangan</option>
<option value="Badan Hukum">Badan Hukum</option>	
</select>
<label>*Cari Pihak</label>
            <select onchange="SimpanPihak()" name='nama_client' id='nama_client' class="form-control nama_client"></select>
   
        <hr>
<div class="para_pihak">

</div> 
</div>
<div class='col-sm-6'>
<table class='table table-striped'>
<tr >
<td align="center" colspan='2'>Detail Pekerjaan</td>
</tr>
<tr>
<td>Nama Client</td>
<td>: <?php echo $static['nama_client'] ?> </td>
</tr>

<tr>
<td>Pembuat Client</td>
<td>: <?php echo $static['pembuat_client'] ?></td>
</tr>


<tr>
<td>Pembuat Pekerjaan</td>
<td>: <?php echo $static['pembuat_pekerjaan'] ?></td>
</tr>

<tr>
<td>Jenis Pekerjaan</td>
<td>: <?php echo $static['nama_jenis'] ?></td>
</tr>

<tr>
<td>Target Selesai</td>
<td>: <?php
if($static['target_kelar']  == date('Y/m/d')){
echo "<b><span class='text-warning'>Hari ini</span></b>";    
}else if($static['target_kelar']  <= date('Y/m/d')){
$startTimeStamp = strtotime(date('Y/m/d'));
$endTimeStamp = strtotime($static['target_kelar'] );
$timeDiff = abs($endTimeStamp - $startTimeStamp);
$numberDays = $timeDiff/86400; 
$numberDays = intval($numberDays);
echo "<b><span class='text-danger'> Terlewat ".$numberDays." Hari </span></b>" ;
}else{
$startTimeStamp = strtotime(date('Y/m/d'));
$endTimeStamp = strtotime($static['target_kelar'] );
$timeDiff = abs($endTimeStamp - $startTimeStamp);
$numberDays = $timeDiff/86400; 
$numberDays = intval($numberDays);
echo "<b><span class='text-success'>".$numberDays." Hari lagi </span></b>" ;
}
?></td>
</tr>
</table>
<div class='row p-2 '>
<button onclick=tampilkan_form_utama('<?php echo $static['no_client'] ?>','<?php echo base64_decode($this->uri->segment(3)); ?>'); class="btn col-md-6  mx-auto  btn-dark btn-sm m-1">Dokumen Utama  <span class="fa fa-upload"></span></button>    
<button onclick=form_edit_client("<?php echo $static['no_client'] ?>","<?php echo $this->uri->segment(3) ?>"); class="btn col-md-5 btn-dark btn-sm   m-1"> Detail Client  <span class="fa fa-user"></span></button>    
<button onclick=tampilkan_form("<?php echo $static['no_client'] ?>","<?php echo base64_decode($this->uri->segment(3)); ?>"); class="btn col-md-6 mx-auto btn-dark btn-sm  m-1">Dokumen Penunjang  <span class="fa fa-upload"></span></button>    
<button  onclick=tampilkan_form_perizinan("<?php echo $static['no_client'] ?>","<?php echo $this->uri->segment(3) ?>"); class='btn  col-md-5 m-1 btn-dark btn-sm   ' title='Rekam dokumen utama' > Buat Penunjang <span class='fa fa-plus'></span> </button>  
</div>

</div>


</div>
    
<!--------------- data modal --------------->    
<div class="modal fade" id="data_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
<div class="modal-content ">
    
</div>
</div>
</div>
<!--------------- data modal --------------->    
<div class="modal fade" id="modalcek" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
<div class="modal-content modalcek ">

</div>
</div>
</div>
    
<!------------- Modal ---------------->
<div class="modal fade bd-example-modal-md" id="modal" role="dialog" aria-labelledby="tambah_syarat1" aria-hidden="true">
<div class="modal-dialog modal-xl data_modal modal-dialog-scrollable" role="document">
</div>
</div>
</div>
<!------------- Modal ---------------->
<div class="modal fade bd-example-modal-md" id="modal2" role="dialog" aria-labelledby="tambah_syarat1" aria-hidden="true">
<div class="modal-dialog modal-md data_modal2 modal-dialog-scrollable" role="document">
</div>
</div>
</div>

<!------------- ModalMeta ---------------->
<div class="modal fade bd-example-modal-md" id="ModalMeta" role="dialog" aria-labelledby="tambah_syarat1" aria-hidden="true">
<div class="modal-dialog modal-md ModalMeta modal-dialog-scrollable" role="document">

</div>
</div>

<!------------- ModalPekerjaan ---------------->
<div class="modal fade bd-example-modal-md" id="ModalDetailPekerjaan" role="dialog" aria-labelledby="tambah_syarat1" aria-hidden="true">
<div class="modal-dialog modal-xl ModalDetailPekerjaan modal-dialog-scrollable" role="document">

</div>
</div>
<!------------- ModalShare ---------------->
<div class="modal fade bd-example-modal-md" id="ModalShare" role="dialog" aria-labelledby="tambah_syarat1" aria-hidden="true">
<div class="modal-dialog modal-md ModalShare modal-dialog-scrollable" role="document">

</div>
</div>

</div>
    
<script type="text/javascript">
function TambahkanFile(){
  $('#file_berkas').click(); 
}

function lihat_laporan_perizinan(no_berkas_perizinan){
var token           = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_berkas_perizinan="+no_berkas_perizinan,
url:"<?php echo base_url('User2/lihat_laporan_perizinan') ?>",
success:function(data){
$(".ModalMeta").html(data);    
$('#ModalMeta').modal('show');
}
});
}
function alihkan_perizinan(no_berkas_perizinan,no_client,no_pekerjaan){
var token    = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",	
url:"<?php echo base_url('User2/option_user_level3') ?>",	
data:"token="+token+"&no_berkas_perizinan="+no_berkas_perizinan+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
success:function(data){	
$("#"+no_berkas_perizinan).html(data);
}
});
}

function simpan_perizinan(no_pekerjaan,no_client){
var token                    = "<?php echo $this->security->get_csrf_hash() ?>";
var no_petugas               = $(".data_nama_petugas option:selected").val();
var no_dokumen               = $(".data_nama_dokumen option:selected").val();

$.ajax({
type:"post",
url:"<?php echo base_url('User2/simpan_perizinan') ?>",
data:"token="+token+"&no_petugas="+no_petugas+"&no_nama_dokumen="+no_dokumen+"&no_pekerjaan="+no_pekerjaan+"&no_client="+no_client,
success:function(data){
read_response(data);
tampilkan_form_perizinan(no_client,btoa(no_pekerjaan));
}
});
}

function tampilkan_form_perizinan(no_client,no_pekerjaan){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>"       
$.ajax({
type:"post",
url:"<?php echo base_url('User2/form_data_perizinan') ?>",
data:"token="+token+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
success:function(data){
$(".modal-content").html(data);    
$('#data_modal').modal('show');
InitializeNamaDokumen();
}
});
}

function GenerateNPWP(){
var token           = "<?php echo $this->security->get_csrf_hash(); ?>";
$.ajax({
type:"post",
url:"<?php echo base_url('User2/GenerateNPWP') ?>",
data:"token="+token,
success:function(data){
var r = JSON.parse(data);
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated bounceInDown'
});
Toast.fire({
type: r[0].status,
title: r[0].messages
});
$("#no_identitas").val(r[0].no_npwp);
$("#no_identitas").attr("readonly",true);
}
});  
}
function LihatSemuaDokumen(no_client){
var token           = "<?php echo $this->security->get_csrf_hash(); ?>";
$.ajax({
type:"post",
url:"<?php echo base_url('User2/LihatSemuaDokumen') ?>",
data:"token="+token+"&no_client="+no_client,
success:function(data){
$("#LihatSemua").slideUp().before(data);

}
});
}

function ProsesBagikan(no_berkas,no_pekerjaan){
var formdata = new FormData();
var pihak = [];
$.each($("input[name='pihak']:checked"), function(){
pihak.push($(this).val());
});

var data = {
pihak:pihak,
no_berkas :no_berkas,
no_pekerjaan :no_pekerjaan
}

$.ajax({
type :"post",
url  :"<?php echo base_url('User2/ProsesBagikan') ?>",
data :data,
success:function(data){
var z = JSON.parse(data);
if(z.status =='warning'){
toastr.warning(z.messages);    
}else{
for (i=0; i<z['data_kopi'].length; i++){

if(z['data_kopi'][i].status == "error"){
toastr.error(z['data_kopi'][i].messages);    

}else if(z['data_kopi'][i].status == "success"){
toastr.success(z['data_kopi'][i].messages);    
}
}

$('#ModalShare').modal('hide');
}
}
});
}

function ShareDokumen(no_berkas){
var no_pekerjaan    = "<?php echo base64_decode($this->uri->segment(3)) ?>";
var token           = "<?php echo $this->security->get_csrf_hash(); ?>";
var no_client       = $(".no_client").val();

$.ajax({
type :"post",
url  :"<?php echo base_url('User2/DataClientShare') ?>",
data :"token="+token+"&no_pekerjaan="+no_pekerjaan+"&no_berkas="+no_berkas+"&no_client="+no_client,
success:function(data){
$(".ModalShare").html(data);    
$('#ModalShare').modal('show');

}
});
}

function InitializeNamaDokumen(){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>";       
$(".nama_dokumen").select2({
allowClear: true,
dropdownParent: $('#data_modal'),        
ajax: {
url: '<?php echo site_url('User2/cari_dokumen') ?>',
method : "post",
data: function (params) {
var query = {
search: params.term,
token: token
};

return query;
},
processResults : function (data) {
var data = JSON.parse(data);
return {
results: data.results
};

}
}        
});

}

function SimpanKontak(){
$("#FormTambahKontak").find(".is-invalid").removeClass("is-invalid").addClass("is-valid");
$("#FormTambahKontak").find(".select2").removeClass("is-invalid").addClass("is-valid");    
$('.form-control + p').remove();
$('.select2 + p').remove();
$.ajax({
url  : "<?php echo base_url("User2/SimpanKontak") ?>",
type : "post",
data : $("#FormTambahKontak").serialize(),
success: function(data) {
 
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#FormTambahKontak").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#FormTambahKontak").find("#"+key).removeClass("is-valid");
});
});
}else{
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated bounceInDown'
});
Toast.fire({
type: r[0].status,
title: r[0].messages
});
$('#modal2').modal('hide');
}

}

});
}

function FormTambahKontak(){
var token           = "<?php echo $this->security->get_csrf_hash(); ?>";
$.ajax({
type:"post",
url:"<?php echo base_url('User2/FormTambahKontak') ?>",
data:"token="+token,
success:function(data){
$(".data_modal2").html(data);    
$('#modal2').modal('show');
$("#modal2").css("z-index", "1500");
}
});
}

function SetJenisDokumen(){
if($(".nama_dokumen option:selected").text() !="NPWP" ){  
if($(".nama_dokumen option:selected").text() =="Passport" ){
$("#nm_file").text("Passport");
$("#nmr_file").text("No Passport");
$("#no_identitas").attr("placeholder", "Masukan Nomor Passport");
}else{
$("#nm_file").text("KTP");
$("#nmr_file").text("NIK KTP");
$("#no_identitas").attr("placeholder", "Masukan NIK KTP");
}
}
}

function SimpanClient(){
//var file_berkas = $('input[name="file_berkas"]').get(0).files[0];

var viewData =[];
$('#DataKontak').find('tr').each(function(){
var jsonData = {};
$(this).find("td").each(function(a){
if(this.id){
jsonData[this.id] = $(this).text();
}
});
viewData.push(jsonData);
}); 

var formdata = new FormData();
var x = $('#FormClientBaru').serializeArray();
$.each(x,function(prop,obj){
formdata.append(obj.name, obj.value);
});

formdata.append('data_kontak',JSON.stringify(viewData));
formdata.append("file_penunjang",$("input[name='file_berkas']").prop('files')[0]);
formdata.append("jenis_dokumen",$("#nama_dokumen option:selected").text());


$("#FormClientBaru").find(".is-invalid").removeClass("is-invalid").addClass("is-valid");
$("#FormClientBaru").find(".select2").removeClass("is-invalid").addClass("is-valid");    
$('.form-control + p').remove();
$('.select2 + p').remove();

$.ajax({
url  : "<?php echo base_url("User2/SimpanClient") ?>",
type : "post",
data : formdata,    
processData: false,
contentType: false,
dataType  :"JSON",    
success: function(data) {
var r  = data;
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
if(key == "jenis_pekerjaan"){
$("#FormClientBaru").find(".select2").addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#FormClientBaru").find(".select2").removeClass("is-valid");    
}else{
$("#FormClientBaru").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#FormClientBaru").find("#"+key).removeClass("is-valid");
}
});
});
}else{
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated bounceInDown'
});
Toast.fire({
type: r[0].status,
title: r[0].messages
});
$('#modal').modal('hide');
}
}
});
}

function SimpanPihak(){
var no_pekerjaan    = "<?php echo $this->uri->segment(3) ?>";
var no_client       = $("#nama_client option:selected").val();
var token           = "<?php echo $this->security->get_csrf_hash(); ?>";
$.ajax({
type :"post",
url  :"<?php echo base_url('User2/simpan_pihak_terlibat') ?>",
data :"token="+token+"&no_pekerjaan="+no_pekerjaan+"&no_client="+no_client,
success:function(data){
refresh();
read_response(data);
}
});
}

function formatKontak (state) {
  
  if(state.error){
  var $state = $(
    '<p class="text-center">Pencarian Kontak Tidak Ditemukan Untuk Menambahkan Kontak Silahkan Klik Button Dibawah Ini </p> <button  type="button" onclick="FormTambahKontak()" class="btn btn-block btn-dark" >Tambahkan Kontak <span class="fa fa-plus"></span></button>'
   );
  return $state;
 }else{
  var $state = $(
    '<span>'+state.text+'<br><span> No Kontak : '+state.no_kontak+' </span> </span>'
  );
 
    return $state;
}
};

$(function(){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>";       
$(".nama_kontak").select2({
templateResult: formatKontak,
ajax: {
url: '<?php echo site_url('User2/cari_kontak') ?>',
method : "post",
data: function (params) {
var query = {
search: params.term,
token: token
};

return query;
},
processResults: function (data) {
var data = JSON.parse(data);
return {
results: data.results
};

}
}        
});
});
function SetKontak(){
var id_kontak       = $("#nama_kontak option:selected").val();

$("#nama_kontak").val(null); 
var token           = "<?php echo $this->security->get_csrf_hash(); ?>";
$.ajax({
type:"post",
url:"<?php echo base_url('User2/SetKontak') ?>",
data:"token="+token+"&id_kontak="+id_kontak,
success:function(data){
var r  = JSON.parse(data);
if($('#KontakKosong').length){
$("#KontakKosong").remove();    
}
if(!$('#'+r[0].DaftarKontak.id_kontak).length){
var datatable = "<tr id="+r[0].DaftarKontak.id_kontak+">\n\
<td style='display:none;' id='id_kontak'>"+r[0].DaftarKontak.id_kontak+"</td>\n\
<td id='nama_kontak'>"+r[0].DaftarKontak.nama_kontak+"</td>\n\
<td id='no_kontak'>"+r[0].DaftarKontak.no_kontak+"</td>\n\
<td id='email'>"+r[0].DaftarKontak.email+"</td>\n\
<td id='jabatan'>"+r[0].DaftarKontak.jabatan+"</td>\n\
<td ><button type='button' onclick=FormEditKontak('"+r[0].DaftarKontak.id_kontak+"') class='btn btn-sm btn-warning'><span class='fa fa-edit'></span></button></td>\n\
</tr>";

$("#DataKontak").append(datatable);
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated bounceInDown'
});
Toast.fire({
type: r[0].status,
title: r[0].messages
});
}else{
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated bounceInDown'
});
Toast.fire({
type: "error",
title:"Nama Kontak Sudah Ditambahkan"
});
}   

}
});
}

function InitializeKontak(){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>";       
$(".nama_kontak").select2({
  allowClear: true,
     templateResult: formatKontak,
dropdownParent: $('#modal'),        
ajax: {
url: '<?php echo site_url('User2/cari_kontak') ?>',
method : "post",
data: function (params) {
var query = {
search: params.term,
token: token
};

return query;
},
processResults: function (data) {
var data = JSON.parse(data);
return {
results: data.results
};

}
}        
});

}

function FormTambahClient(){
var token           = "<?php echo $this->security->get_csrf_hash(); ?>";
var jenis_client    = $("#jenis_client option:selected").text();
$.ajax({
type:"post",
url:"<?php echo base_url('User2/FormTambahClient') ?>",
data:"token="+token+"&jenis_client="+jenis_client,
success:function(data){
$(".data_modal").html(data);    
$('#modal').modal('show');
$("#modal").css("z-index", "1500");
InitializeKontak();
SetJenisDokumen();
}
});
}


function para_pihak(){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>" ;      

$.ajax({
type:"post",
url:"<?php echo base_url('User2/data_para_pihak/') ?>",
data:"token="+token+"&proses=perizinan&no_pekerjaan="+"<?php echo base64_decode($this->uri->segment(3)) ?>"+"&no_client=<?php echo $static['no_client'] ?>",
success:function(data){
$(".para_pihak").html(data);
}
});
}

function formatState (state) {

 if(state.error){
  var $state = $(
    '<p class="text-center">Pencarian Client Tidak Ditemukan<br> Untuk Menambahkan Client Silahkan Klik Button Dibawah Ini</p> <button  type="button" onclick="FormTambahClient()" class="btn btn-block btn-dark" >Tambahkan Pihak <span class="fa fa-plus"></span></button>'
    );
  return $state;
 }else{
 var j = $("#jenis_client option:selected").text();
  if(j == 'Perorangan'){
  var $state = $(
    '<span>'+state.text+'<br><span> NIK  : '+state.no_identitas+' </span> </span>'
  );
  return $state;
  }else{
  var $state = $(
    '<span>'+state.text+'<br>NPWP : '+state.no_identitas+' </span>'
  );
  return $state;
  }
  
 }
};

$(function(){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>"; 


$(".nama_client").select2({
templateResult: formatState,    
ajax: {
url: '<?php echo site_url('User2/cari_nama_client') ?>',
method : "post",

data: function (params) {
var query = {
jenis_client:$("#jenis_client option:selected").text(),
search: params.term,
token: token
};

return query;
},
processResults: function (data) {
var data = JSON.parse(data);
return {
results: data.results
};

}
}        
});
});



function cari_client2(){
var a = $(".no_identitas").val(); 
var token  = "<?php echo $this->security->get_csrf_hash(); ?>"       

$.ajax({
type:"post",
url:"<?php echo base_url('User2/cari_client2') ?>",
data:"token="+token+"&no_identitas="+a,
success:function(data){
var r = JSON.parse(data);
if(r[0].status == "success"){
$("#no_client").val(r[0].message.no_client).attr('readonly', true);;
$("#contact_person").val(r[0].message.contact_person).attr('readonly', true);;
$("#contact_number").val(r[0].message.contact_number).attr('readonly', true);;
$("#badan_hukum").val(r[0].message.nama_client).attr('readonly', true);;
$("#jenis_kontak option[value='"+r[0].message.jenis_kontak+"']").attr("selected","selected");
$("#jenis_kontak").attr('readonly', true);

}else{
$("#no_client").attr('readonly', false).val("");
$("#jenis_kontak").attr('readonly', false).removeAttr("selected","selected");
$("#contact_person").attr('readonly', false).val("");
$("#contact_number").attr('readonly', false).val("");
$("#badan_hukum").val("").attr('readonly', false);;
}    
}
});
}

function hapus_berkas_persyaratan(no_berkas){
Swal.fire({
text: "Kamu yakin ingin menghapus lampiran ini",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Ya, hapus',
cancelButtonText: 'Batalkan',
}).then((result) => {
if (result.value) {    
$(".btnhapus"+no_berkas).attr('disabled',true);
var token  = "<?php echo $this->security->get_csrf_hash(); ?>"       
$.ajax({
type:"post",
url:"<?php echo base_url('User2/hapus_berkas_persyaratan/') ?>",
data:"token="+token+"&no_berkas="+no_berkas,
success:function(data){
tampilkan_form($(".no_client").val(),$(".no_pekerjaan").val());    
read_response(data);
$(".btnhapus"+no_berkas).attr('disabled',false);
$('#modalcek').modal('hide')
}
}); 
}
})
}        
    
$(function(){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>"       
$("#nama_pihak").autocomplete({
minLength:0,
delay:0,
source: function( request, rse ) {
$.ajax({
url: "<?php echo base_url('User2/cari_nama_client') ?>",
method:'post',
data: {
token:token,  
term: request.term,
jenis_pemilik: $("#jenis_client option:selected").text()
},success: function( data ) {
var d = JSON.parse(data);
rse(d);
}
});
},select:function(event, ui){
if(ui.item.no_client != null){
$("#no_client").val(ui.item.no_client).attr('readonly', true);
$("#alamat_pihak").val(ui.item.alamat_pihak).attr('readonly', true);
$("#jenis_kontak option[value='"+ui.item.jenis_kontak+"']").attr("selected","selected");
$("#jenis_kontak").attr('readonly', true);
$("#contact_person").val(ui.item.contact_person).attr('readonly', true);
$("#contact_number").val(ui.item.contact_number).attr('readonly', true);
}else{
$("#no_client").attr('readonly', false).val("");
$("#alamat_pihak").attr('readonly', false).val("");
$("#jenis_kontak option[value='"+ui.item.jenis_kontak+"']").attr("selected","selected");
$("#jenis_kontak").attr('readonly', false).val("");
$("#contact_person").attr('readonly', false).val("");
$("#contact_number").attr('readonly', false).val("");
}
}
});
});


function simpan_pihak(){
$("#form_pihak_terlibat").find(".form-control").removeClass("is-invalid").addClass("is-valid");
$("#form_pihak_terlibat").find('.form-control + p').remove();
$.ajax({
type:"post",
data:$("#form_pihak_terlibat").serialize(),
url:"<?php echo base_url('User2/simpan_pihak_terlibat') ?>",
success:function(data){
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#form_pihak_terlibat").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#form_pihak_terlibat").find("#"+key).removeClass("is-valid");
});
});
}else{
read_response(data);
$("#form_pihak_terlibat").find(".form-control").val("").attr('readonly', false).removeClass("is-valid");
refresh();
}
}

});
}



function refresh(){
para_pihak();
regis_js();
}


function regis_js(){
$(".Desimal").keyup(function(){
var string = numeral(this.value).format('0,0');
$("#"+this.id).val(string);
});
$(".Bulat").keyup(function(){
var string = this.value;
$("#"+this.id).val(string);
});

$(function() {
$(".date").daterangepicker({ 
    dateFormat: 'yy/mm/dd',
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1901,
    changeMonth: false,
   changeYear: false,
    maxYear: parseInt(moment().format('YYYY'),10),
    "locale": {
        "format": "YYYY/MM/DD",
        "separator": "-",
      }
});
});

}



function  form_edit_client(no_client,no_pekerjaan){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>"       
$.ajax({
type:"post",
url:"<?php echo base_url('User2/form_edit_client') ?>",
data:"token="+token+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
success:function(data){
$(".modal-content").html(data);    
$('#data_modal').modal('show');
}
});
}

function update_client(){
$(".update_client").attr("disabled", true);
$("#form_update_client").find(".form-control").removeClass("is-invalid").addClass("is-valid");
$('.form-control + p').remove();
$.ajax({
url  : "<?php echo base_url("User2/update_client") ?>",
type : "post",
data : $("#form_update_client").serialize(),
success: function(data) {
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#form_update_client").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#form_update_client").find("#"+key).removeClass("is-valid");
});
});
}else{
read_response(data);
$('#data_modal').modal('hide');
}
$(".update_client").attr("disabled", false);
}

});
}



$(function(){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>";       
$(".jenis_pekerjaan").select2({
   ajax: {
    url: '<?php echo site_url('User2/cari_jenis_pekerjaan') ?>',
    method : "post",
    
    data: function (params) {
      var query = {
        search: params.term,
        token: token
      };

      return query;
    },
   processResults: function (data) {
      // Transforms the top-level key of the response object from 'items' to 'results'
      var data = JSON.parse(data);
      console.log(data.results);
      return {
        results: data.results
      };
      
    }
      
    }        
   
});
});

function update_pekerjaan(){
$(".update_pekerjaan").attr("disabled", true);
$("#form_update_pekerjaan").find(".form-control").removeClass("is-invalid").addClass("is-valid");
$('.form-control + p').remove();
$.ajax({
url  : "<?php echo base_url("User2/update_pekerjaan") ?>",
type : "post",
data : $("#form_update_pekerjaan").serialize(),
success: function(data) {
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#form_update_pekerjaan").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#form_update_pekerjaan").find("#"+key).removeClass("is-valid");
});
});
}else{
read_response(data);
$('#data_modal').modal('hide');
}
$(".update_pekerjaan").attr("disabled", false);
}

});
}

function lanjutkan_proses_selesai(no_pekerjaan){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>"       
$.ajax({
type:"post",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan,
url :"<?php echo base_url('User2/update_selesaikan_pekerjaan') ?>",
success:function(data){
read_response(data);
window.location.href="<?php echo base_url('User2/pekerjaan_selesai') ?>";
}

});
}

function tampilkan_form_utama(no_client,no_pekerjaan){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>"       
$.ajax({
type:"post",
url:"<?php echo base_url('User2/tampilkan_form_utama') ?>",
data:"token="+token+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
success:function(data){
$(".modal-content").html(data);    
$('#data_modal').modal('show');
tanggal_akta();
utama_terupload(no_pekerjaan);
}
});
}



function hapus_perizinan(no_berkas_perizinan,no_client,no_pekerjaan){
var token    = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",	
url:"<?php echo base_url('User2/hapus_perizinan') ?>",	
data:"token="+token+"&no_berkas_perizinan="+no_berkas_perizinan,
success:function(data){	
read_response(data);
tampilkan_form_perizinan(no_client,no_pekerjaan);
}
});
}




function tanggal_akta(){
$("input[name=tanggal_akta]").daterangepicker({
    singleDatePicker: true,
    dateFormat: 'yy/mm/dd',
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1901,
    maxYear: parseInt(moment().format('YYYY'),10),
    "locale": {
        "format": "YYYY/MM/DD",
        "separator": "-",
      }
});
}



function upload_utama(no_client,no_pekerjaan){
  var formData = new FormData();
var files = $("#file_utama")[0].files;;
var token             = "<?php echo $this->security->get_csrf_hash() ?>";

formData.append("token", token);
formData.append("no_client", $(".no_client").val());
formData.append("no_pekerjaan", $(".no_pekerjaan").val());

for (var i = 0; i < files.length; i++) {
formData.append("file_utama"+i, $("#file_utama").prop('files')[i]);
}

$.ajax({
type:"post",
data:formData,
xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){
                    myXhr.upload.addEventListener('progress',progress, false);
                }
                return myXhr;
        },
processData: false,
contentType: false,
url:"<?php echo base_url('User2/upload_utama') ?>",
success:function(data){
    var z = JSON.parse(data);
for (i=0; i<z.length; i++){
    
if(z[i].status == "error"){
toastr.error(z[i].messages, z[i].name_file);    
}else if(z[i].status == "success"){
toastr.success(z[i].messages, z[i].name_file);    
}
}
$("#file_utama").val("");
$(".progress").hide();
tampilkan_form_utama($(".no_client").val(), $(".no_pekerjaan").val());
}
});


/*
$("#form_utama").find(".form-control").removeClass("is-invalid").addClass("is-valid");
$("#form_utama").find('.form-control + p').remove();


var token  = "<?php echo $this->security->get_csrf_hash(); ?>" ;      
formdata = new FormData();
var x = $('#form_utama').serializeArray();
$.each(x,function(prop,obj){
formdata.append(obj.name, obj.value);
});
formdata.append("file_utama", $("#file_utama").prop('files')[0]);

$.ajax({
type:"post",
data:formdata,
processData: false,
contentType: false,
url:"<?php echo base_url('User2/upload_utama') ?>",
success:function(data){
var r = JSON.parse(data); 

if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#form_utama").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#form_utama").find("#"+key).removeClass("is-valid");
});
});
}else{
read_response(data);
tampilkan_form_utama(no_client,no_pekerjaan);
}    
}
});*/
}



function utama_terupload(no_pekerjaan){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('User2/utama_terupload') ?>",
success:function(data){
$(".utama_terupload").html(data);
//InitializeNamaDokumen();    
}
});
}
function hapus_utama(id_data_dokumen_utama){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
var no_client = $(".no_client").val();
var no_pekerjaan = $(".no_pekerjaan").val();
Swal.fire({
title: 'Anda yakin Ingin Menghapus File Ini ?',
text: "File ini akan dihapus secara permanen",
type: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Ya Hapus'
}).then((result) => {
if (result.value) {
$.ajax({
type:"post",
data:"token="+token+"&id_data_dokumen_utama="+id_data_dokumen_utama,
url:"<?php echo base_url('User2/hapus_file_utama') ?>",
success:function(data){
read_response(data);
tampilkan_form_utama(no_client,no_pekerjaan);
}
});
}
})

}

function download_utama(id_data_dokumen_utama){
window.location.href="<?php echo base_url('User2/download_utama/') ?>"+btoa(id_data_dokumen_utama);
}



function hapus_keterlibatan(no_client,no_pekerjaan){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('User2/hapus_keterlibatan') ?>",
success:function(data){
read_response(data);
para_pihak();
}
});

}


function tampilkan_form(no_client,no_pekerjaan){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>" ;      

$.ajax({
type:"post",
data:"token="+token+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('User2/form_persyaratan') ?>",
success:function(data){
$('#data_modal').modal('show');
$(".modal-content").html(data);
data_terupload(no_client,no_pekerjaan);
regis_js();
}
});

}

function simpan_meta(no_client,no_pekerjaan,no_nama_dokumen){
$.ajax({
type:"post",
data:$("#form"+no_nama_dokumen).serialize(),
url:"<?php echo base_url('User2/simpan_meta') ?>",
success:function(data){
data_terupload(no_client,no_pekerjaan);
}
});
}
function FormLihatMeta(no_berkas,nama_folder,nama_berkas){

if($(".data_edit"+no_berkas).length > 0 ){
$('.'+no_berkas).slideUp("slow").remove();
}else{
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_berkas="+no_berkas+"&nama_folder="+nama_folder+"&nama_berkas="+nama_berkas,
url:"<?php echo base_url('User2/FormLihatMeta') ?>",
success:function(data){
$(".data"+no_berkas).slideDown().after("<tr class="+no_berkas+"><td colspan='2'>"+data+"</tr></td>"); 
regis_js();
}
});
}
}

function FormLihatMetaDuplicate(no_berkas,nama_folder,nama_berkas){

if($(".data_edit"+no_berkas).length > 0 ){
$('.'+no_berkas).slideUp("slow").remove();
}else{
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_berkas="+no_berkas+"&nama_folder="+nama_folder+"&nama_berkas="+nama_berkas,
url:"<?php echo base_url('User2/FormLihatMetaDuplicate') ?>",
success:function(data){
$(".data"+no_berkas).slideDown().after("<tr class="+no_berkas+"><td colspan='2'>"+data+"</tr></td>"); 
regis_js();
}
});
}
}

function SimpanPenunjang(){
$("#FormMeta").find(".is-invalid").removeClass("is-invalid").addClass("is-valid");
$('.form-control + p').remove();

$.ajax({
type:"post",
data:$("#FormMeta").serialize(),
url:"<?php echo base_url('User2/SimpanPenunjang') ?>",
success:function(data){
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){

$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#FormMeta").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#FormMeta").find("#"+key).removeClass("is-valid");
});
});

}else{
read_response(data);
tampilkan_form($(".no_client").val(),$(".no_pekerjaan").val());
$('#ModalMeta').modal('hide');
}

}
});
}

function SimpanUtama(){
$("#FormUtama").find(".is-invalid").removeClass("is-invalid").addClass("is-valid");
$('.form-control + p').remove();

$.ajax({
type:"post",
data:$("#FormUtama").serialize(),
url:"<?php echo base_url('User2/SimpanUtama') ?>",
success:function(data){
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){

$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#FormUtama").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#FormUtama").find("#"+key).removeClass("is-valid");
});
});

}else{
read_response(data);
tampilkan_form_utama($(".no_client").val(),$(".no_pekerjaan").val());
$('#ModalMeta').modal('hide');
}

}
});

}

function upload_file(){
var formData = new FormData();
var files = $("#file_berkas")[0].files;;
var token             = "<?php echo $this->security->get_csrf_hash() ?>";

formData.append("token", token);
formData.append("no_client", $(".no_client").val());
formData.append("no_pekerjaan", $(".no_pekerjaan").val());

for (var i = 0; i < files.length; i++) {
formData.append("file_berkas"+i, $("#file_berkas").prop('files')[i]);
}

$.ajax({
type:"post",
data:formData,
xhr: function() {
                var myXhr = $.ajaxSettings.xhr();
                if(myXhr.upload){
                    myXhr.upload.addEventListener('progress',progress, false);
                }
                return myXhr;
        },
processData: false,
contentType: false,
url:"<?php echo base_url('User2/upload_berkas') ?>",
success:function(data){
    var z = JSON.parse(data);
for (i=0; i<z.length; i++){
    
if(z[i].status == "error"){
toastr.error(z[i].messages, z[i].name_file);    
}else if(z[i].status == "success"){
toastr.success(z[i].messages, z[i].name_file);    
}
}
$("#file_berkas").val("");
data_terupload($(".no_client").val(),$(".no_pekerjaan").val());
regis_js();
$(".progress").hide();
}
});
}
function progress(e){
    if(e.lengthComputable){
        var max = e.total;
        var current = e.loaded;

        var Percentage = (current * 100) / max;
        console.log(Percentage+"<br>");
        $(".progress").show();
        $(".progress-bar").css({'width': +Percentage+'%'});
        $(".persen").html(Percentage +"%");
        if(Percentage >= 100){
        
       }
    }  
 }
function data_terupload(no_client,no_pekerjaan){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('User2/data_terupload') ?>",
success:function(data){
$(".data_terupload").html(data);
InitializeNamaDokumen();    
}
});
}



function set_jenis_dokumen(no_client,no_pekerjaan,no_berkas){
var no_nama_dokumen   = $(".no_berkas"+no_berkas +" option:selected").val();
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
var no_pekerjaan      = "<?php echo $this->uri->segment(3) ?>";

$.ajax({
type:"post",
data:"token="+token+"&no_nama_dokumen="+no_nama_dokumen+"&no_berkas="+no_berkas+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('User2/FormMasukanMetaDokumen') ?>",
success:function(data){

var r = JSON.parse(data);
if(r[0].status  =='warning'){
openmodalcekdokumen(no_client,no_nama_dokumen,no_berkas,no_pekerjaan);
}else if(r[0].status  =='error'){
read_response(data);
}else if(r[0].status  =='success'){
$(".ModalMeta").html(r[0].data );    
$('#ModalMeta').modal('show');
regis_js();
}
}
});
}

function set_jenis_utama(no_pekerjaan,id_dokumen_utama){
var jenis_dokumen     = $(".no_utama"+id_dokumen_utama +" option:selected").val();
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
var no_pekerjaan      = $(".no_pekerjaan").val();

$.ajax({
type:"post",
data:"token="+token+"&jenis_dokumen="+jenis_dokumen+"&no_pekerjaan="+no_pekerjaan+"&id_dokumen_utama="+id_dokumen_utama,
url :"<?php echo base_url('User2/FormMasukanMetaUtama') ?>",
success:function(data){
  regis_js();
var r = JSON.parse(data);
if(r[0].status  =='error'){
read_response(data);
}else if(r[0].status  =='success'){
$(".ModalMeta").html(r[0].data );    
$('#ModalMeta').modal('show');
}
}

});
}

function set_jenis_dokumen_duplicate(no_client,no_pekerjaan,no_berkas){
var no_nama_dokumen   = $(".no_berkas"+no_berkas +" option:selected").val();
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
var no_pekerjaan      = "<?php echo $this->uri->segment(3) ?>";

$.ajax({
type:"post",
data:"token="+token+"&no_nama_dokumen="+no_nama_dokumen+"&no_berkas="+no_berkas+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('User2/FormMasukanMetaDokumenDuplicate') ?>",
success:function(data){
  regis_js();
var r = JSON.parse(data);
if(r[0].status  =='error'){
read_response(data);
}else if(r[0].status  =='success'){
$(".ModalMeta").html(r[0].data );    
$('#ModalMeta').modal('show');
}
}
});
}

function openmodalcekdokumen(no_client,no_nama_dokumen,no_berkas,no_pekerjaan){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_nama_dokumen="+no_nama_dokumen+"&no_berkas="+no_berkas+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('User2/modal_cek_dokumen') ?>",
success:function(data){
$(".modalcek").html(data);    
$('#modalcek').modal('show');
}
});
}

function hapus_meta(no_berkas,no_nama_dokumen,no_client,no_pekerjaan){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>";       
$.ajax({
type    :"post",
url     :"<?php echo base_url('User2/hapus_meta/') ?>",
data    :"token="+token+"&no_berkas="+no_berkas+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan+"&no_nama_dokumen="+no_nama_dokumen,
success :function(data){
data_terupload(no_client,no_pekerjaan);    
read_response(data);
}
}); 
}


function cancel_edit(no_berkas){
$(".data_edit"+no_berkas ).slideUp().html();
$(".btn_edit"+no_berkas).show();  
}



$("#jenis_client").on("change",function(){
var client = $("#jenis_client option:selected").text();

if(client == "Perorangan"){
$("#FormPeroranganBadanHukum").html("<label>*NIK KTP</label>\n\
<input type='text' id='no_identitas' class='form-control no_identitas form-control-sm required' onkeyup='cari_client2()'  accept='text/plain' id='no_identitas' placeholder='NIK KTP' name='no_identitas'>\n\
<label>*Nama Perorangan</label>\n\
<input type='text' placeholder='Nama Perorangan' name='badan_hukum' id='badan_hukum' class='form-control form-control-sm required'  accept='text/plain'>");

}else if(client == "Badan Hukum"){
$("#FormPeroranganBadanHukum").html("<label>*No NPWP</label>\n\
<input type='text' id='no_identitas' class='form-control no_identitas form-control-sm required' onkeyup='cari_client2()'  accept='text/plain'id='no_identitas' placeholder='No NPWP' name='no_identitas'>\n\
<label>*Nama Badan Hukum</label>\n\
<input type='text' placeholder='Nama Badan Hukum'  name='badan_hukum' id='badan_hukum' class='form-control form-control-sm required'  accept='text/plain'>");
}
});


function DuplicateDokumen(no_client,no_pekerjaan,no_berkas,no_nama_dokumen){
Swal.fire({
text: "Kamu yakin ingin menduplikasi dokumen ini, jika ya maka client tersebut akan memiliki lebih dari satu jenis dokumen yang sama",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Ya, Duplikasi',
cancelButtonText: 'Batalkan',
}).then((result) => {
if (result.value) {
  $('#modalcek').modal('hide');
  set_jenis_dokumen_duplicate(no_client,no_pekerjaan,no_berkas)

}
})
}

function LihatLampiran(nama_folder,nama_berkas){
window.open( 
  "<?php echo base_url('berkas/') ?>"+nama_folder+"/"+nama_berkas+"","_blank"); 
}

</script>    



