<body>
<?php  $this->load->view('umum/data_lama/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/data_lama/V_navbar_data_lama'); ?>

<?php echo $this->breadcrumbs->show(); ?>
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
width: 100%;    
}

</style>
<div class="container-fluid ">
<div class="mt-4 col-2   text-center mx-auto  ">
<svg class='text-info' width="5em" height="5em" viewBox="0 0 16 16" class="bi bi-pencil-square" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
</svg>
<br>
Membuat Arsip Pekerjaan Baru
</div>

<form  id="form_pekerjaan" class="mt-2 p-2" method="post" action="#">
<div class="row  rounded  m-2" >
<div class="col-md-6 mx-auto">
<input type="hidden" name="token" value="<?php echo $this->security->get_csrf_hash(); ?>" readonly="" class="form-control required"  accept="text/plain">
<label>* Nama Asisten</label>
<select  name="nama_asisten"  id="nama_asisten" class="form-control no_user_pembuat required" accept="text/plain">
<option></option>
<?php 
foreach ($nama_notaris->result_array() as $nama){
echo "<option value=".$nama['no_user'].">".$nama['nama_lengkap']."</option>";    
}
?>
</Select>
<label>*Jenis Pekerjaan</label>
<select name='jenis_pekerjaan' id='jenis_pekerjaan' class="form-control jenis_pekerjaan"></select>


 
<label>*Target selesai</label>
<input type="text" placeholder="Target selesai pekerjaan" name="target_selesai" readonly="" id="target_selesai" class="form-control  required"  accept="text/plain">

<label>*Pilih Jenis client</label>
<select name="jenis_client" id="jenis_client" class="form-control required" accept="text/plain">
<option value="Perorangan">Perorangan</option>
<option value="Badan Hukum">Badan Hukum</option>	
</select>
<label>*Nama Client</label>
    <select name='nama_client' id='nama_client' class="form-control nama_client"></select>
    
    <hr>
<button type="button"  onclick="simpan_pekerjaan();" class="btn btn-dark  mx-auto btn-block simpan_perizinan">Buat Arsip Pekerjaan <i class="fa fa-save"></i></button>

</div>

</div>

</form>    
</div>
</div>

<!------------- Modal ---------------->
<div class="modal fade bd-example-modal-md"   data-backdrop="static"   id="modal2" role="dialog" aria-labelledby="tambah_syarat2" aria-hidden="true">
<div class="modal-dialog modal-xl data_modal2 modal-dialog-scrollable" role="document">
</div>
</div>
</div>
<!------------- Modal ---------------->
<div class="modal fade bd-example-modal-md"  id="modal"  role="dialog" aria-labelledby="tambah_syarat1" aria-hidden="true">
<div class="modal-dialog modal-md data_modal" role="document">
</div>
</div>
</div>

<script type="text/javascript">
function GenerateNPWP(){
var token           = "<?php echo $this->security->get_csrf_hash(); ?>";
$.ajax({
type:"post",
url:"<?php echo base_url('Data_lama/GenerateNPWP') ?>",
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

function formatPekerjaan (state) {

 if(state.error){
  var $state = $(
  '<p class="text-center">Pencarian Pekerjaan Tidak Ditemukan Untuk Menambahkan Silahkan Hubungi Administrator</p>'
  );
  return $state;
 }else{
  var $state = $(
    '<span>'+state.text+'</span>'
  );
  return $state;
 }
 
};

$(function(){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>";       
$(".jenis_pekerjaan").select2({
templateResult: formatPekerjaan,    
ajax: {
url: '<?php echo site_url('Data_lama/cari_jenis_pekerjaan') ?>',
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


function formatState (state) {

if(state.error){
 var $state = $(
   '<p class="text-center">Pencarian Client Tidak Ditemukan<br> Untuk Menambahkan Client Silahkan Klik Button Dibawah Ini</p> <button  type="button" onclick="FormTambahClient()" class="btn btn-block btn-dark" >Tambahkan Client <span class="fa fa-plus"></span></button>'
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
url: '<?php echo site_url('Data_lama/cari_nama_client') ?>',
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
url: '<?php echo site_url('Data_lama/cari_kontak') ?>',
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
function InitializeKontak(){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>";       
$(".nama_kontak").select2({
  allowClear: true,
     templateResult: formatKontak,
dropdownParent: $('#modal2'),        
ajax: {
url: '<?php echo site_url('Data_lama/cari_kontak') ?>',
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

$(function() {
$("input[name='target_selesai']").datepicker({
minDate:0,
dateFormat: 'yy/mm/dd'
});
});

function cari_client(){
var a = $(".cari_client").val(); 
var token  = "<?php echo $this->security->get_csrf_hash(); ?>"       
$.ajax({
type:"post",
url:"<?php echo base_url('Data_lama/cari_client') ?>",
data:"token="+token+"&no_identitas="+a,
success:function(data){
var r = JSON.parse(data);
if( r[0].status == "success"){
$(".hasil_client").html(r[0].message);
}else{
$(".hasil_client").html("<hr><p class='text-center text-danger'>Data Client Tidak Tersedia</p>");    
}

}
});

}




function cari_jenis_pekerjaan(){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>";       
$(".jenis_pekerjaan2").select2({
   ajax: {
    url: '<?php echo site_url('Data_lama/cari_jenis_pekerjaan') ?>',
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
}


function target_kelar() {
$("input[name='target_kelar2']").datepicker({ minDate:0,dateFormat: 'yy/mm/dd'
});
}

function simpan_pekerjaan(){
 var viewData = [];
$('#DataKontak').find('tr').each(function(){
var jsonData = {};
$(this).find("td").each(function(a){
if(this.id){
jsonData[this.id] = $(this).text();
}
});
viewData.push(jsonData);
});   

var data = {
'jenis_pekerjaan'  :$("#jenis_pekerjaan option:selected").val(),  
'data_kontak'      :viewData,
'nama_client'      :$("#nama_client option:selected").val(),
'nama_asisten'     :$("#nama_asisten option:selected").text(),
'target_selesai'   :$("#target_selesai").val()
}

$(".simpan_perizinan").attr("disabled", true);
$("#form_pekerjaan").find(".is-invalid").removeClass("is-invalid").addClass("is-valid");
$("#form_pekerjaan").find(".select2").removeClass("is-invalid").addClass("is-valid");    
$('.form-control + p').remove();
$('.select2 + p').remove();

$.ajax({
url  : "<?php echo base_url("Data_lama/SimpanArsip") ?>",
type : "post",
data : data,
dataType:"JSON",
success: function(data) {
 var r = data;
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
if(key == "jenis_pekerjaan" || key =='jenis_client' || key=='nama_client' ){
$("#form_pekerjaan").find("#"+key).next().addClass("is-invalid");
$("#form_pekerjaan").find("#"+key).removeClass("is-valid");    
}else{
$("#form_pekerjaan").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#form_pekerjaan").find("#"+key).removeClass("is-valid");
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
}).then(function(){
window.location.href="<?php echo base_url('Data_lama/DataArsipClient/') ?>";
});
$(".form-control").val("");
}
$(".simpan_perizinan").attr("disabled", false);
}
});
}

function response(data){
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
title: r[0].message
});
}
function FormTambahClient(){
var token           = "<?php echo $this->security->get_csrf_hash(); ?>";
var jenis_client    = $("#jenis_client option:selected").text();
$.ajax({
type:"post",
url:"<?php echo base_url('Data_lama/FormTambahClient') ?>",
data:"token="+token+"&jenis_client="+jenis_client,
success:function(data){
$(".data_modal2").html(data);    
$('#modal2').modal('show');
$("#modal2").css("z-index", "1500");
InitializeKontak();
SetJenisDokumen();
}
});
}


function FormTambahKontak(){
var token           = "<?php echo $this->security->get_csrf_hash(); ?>";
$.ajax({
type:"post",
url:"<?php echo base_url('Data_lama/FormTambahKontak') ?>",
data:"token="+token,
success:function(data){
$(".data_modal").html(data);    
$('#modal').modal('show');
$("#modal").css("z-index", "1500");
}
});
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
url  : "<?php echo base_url("Data_lama/SimpanClient") ?>",
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
$('#modal2').modal('hide');

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
url  : "<?php echo base_url("Data_lama/SimpanKontak") ?>",
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
$('#modal').modal('hide');
}

}

});
}
function UpdateKontak(id_kontak){
$("#FormEditKontak").find(".is-invalid").removeClass("is-invalid").addClass("is-valid");
$("#FormEditKontak").find(".select2").removeClass("is-invalid").addClass("is-valid");    
$('.form-control + p').remove();
$('.select2 + p').remove();
$.ajax({
url  : "<?php echo base_url("Data_lama/SimpanEditKontak") ?>",
type : "post",
data : $("#FormEditKontak").serialize(),
success: function(data) {
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#FormEditKontak").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#FormEditKontak").find("#"+key).removeClass("is-valid");
});
});
}else{

var datatable = "\n\
<td style='display:none;' id='id_kontak'>"+id_kontak+"</td>\n\
<td id='nama_kontak'>"+r[0].DataKontak.nama_kontak+"</td>\n\
<td id='no_kontak'>"+r[0].DataKontak.no_kontak+"</td>\n\
<td id='email'>"+r[0].DataKontak.email+"</td>\n\
<td id='jabatan'>"+r[0].DataKontak.jabatan+"</td>\n\
<td ><button type='button' onclick=FormEditKontak("+id_kontak+") class='btn btn-sm btn-warning'><span class='fa fa-edit'></span></button></td>\n\
";
$("#"+id_kontak).html(datatable);    

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

$('#nama_kontak').on('select2:select', function (e) {
    var data = e.params.data;
    console.log(data);
});

function SetKontak(){
var id_kontak       = $("#nama_kontak option:selected").val();

$("#nama_kontak").val(null); 
var token           = "<?php echo $this->security->get_csrf_hash(); ?>";
$.ajax({
type:"post",
url:"<?php echo base_url('Data_lama/SetKontak') ?>",
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

function FormEditKontak(id_kontak){

var token           = "<?php echo $this->security->get_csrf_hash(); ?>";
$.ajax({
type:"post",
url:"<?php echo base_url('Data_lama/FormEditKontak') ?>",
data:"token="+token+"&id_kontak="+id_kontak,
success:function(data){
$(".data_modal").html(data);    
$('#modal').modal('show');
$("#modal").css("z-index", "1500");

}
});
}

function CekNamaPerorangan(){
/*var nama_client = $(".nama_client2").val();
if(nama_client.length > 4 ){

var convert = nama_client.split(" "); 

console.log(convert);
for(var a=0; a<nama_client.length; a++){

if(!isNaN(convert[a])){
alert("tidak boleh ada angka");    
}else{
    
}

}

}*/
}

function CekNamaBadanHukum(){
/*var nama_client = $(".nama_client2").val();*/
}

</script>