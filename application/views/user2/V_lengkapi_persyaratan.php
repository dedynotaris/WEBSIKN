<body onload="refresh();"></body>
<?php $this->load->view('umum/user2/V_sidebar_user2'); ?>
<div id="page-content-wrapper">
<?php $this->load->view('umum/user2/V_navbar_user2'); ?>
<?php $this->load->view('umum/user2/V_data_user2'); ?>
<?php $static = $query->row_array(); ?>
<div class="container text-theme1">    
<div class="card-header text-theme1 mt-2 mb-2 text-center">
LENGKAPI PERSYARATAN DOKUMEN <?php echo $static['nama_client'] ?>
<button class="btn btn-success btn-sm float-md-right "  onclick="lanjutkan_proses_perizinan('<?php echo $this->uri->segment(3) ?>');">Lanjutkan keproses perizinan <span class="fa fa-exchange-alt"></span></button>
</div>
</div>
    
<div class="container">
<div class="row">
    <div class="col">
        <label>Nama Client</label>
    </div>
</div>
        
<div class="row">
<div class="col data_client text-theme1"></div>
</div>
    
</div>
</div>

<!------------------modal cari client------------->
<div class="modal fade" id="modal_cari_client" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document">
<div class="modal-content ">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel text-center">Tentukan Pemilik Dokumen<span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<label>Jenis Pemilik</label> 
<select onchange="tentukan_jenis()" class="form-control form-control-sm tentukan_jenis">
<option value="null">Pilih jeni pemilik</option>    
<option value="Badan Hukum">Badan Hukum</option>    
<option Value="Perorangan">Perorangan</option>    
</select>

<label>Cari Nama <span class="jenis_pemilik"></span></label>
<div class="input-group ">
<input type="text" id="cari_client" name="nama_client" class="form-control form-control-sm perekaman nama_client required" readonly="" accept="text/plain" aria-describedby="basic-addon2">
<div class="input-group-append">
<button class="btn btn-sm btn-dark add_client" type="button"><span class="fa fa-plus"></span> Client</button>
</div>
</div>
<label>No Client</label>
<input type="text" id="no_client" class="form-control perekaman form-control-sm" readonly="">
<hr>
<button class="btn btn-dark btn-sm" onclick="buat_perekaman();">Buat Perekaman</button>
</div>
</div>
</div>
</div>
<!------------------modal tambah client------------->
<div class="modal fade" id="modal_tambah_client" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel text-center">Buat client baru<span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>    
<div class="modal-body">
<form  id="fileclient" method="post" action="<?php echo base_url('User2/buat_client') ?>">
<label>Pilih Jenis client</label>
<select name="jenis" id="pilih_jenis" class="form-control form-control-sm  required" accept="text/plain">
<option>Jenis Client</option>
<option value="Perorangan">Perorangan</option>
<option value="Badan Hukum">Badan Hukum</option>	
</select>
<div id="form_badan_hukum">
<label  id="label_nama_perorangan">Nama Perorangan</label>
<label  style="display: none;" id="label_nama_hukum">Nama Badan Hukum</label>
<input onkeyup="jadikan_kontak_person();" type="text" placeholder="Nama perorangan / Badan Hukum" name="badan_hukum" id="badan_hukum" class="form-control form-control-sm  required"  accept="text/plain">
</div>
<div id="form_alamat_hukum">
<label style="display: none;" id="label_alamat_hukum">Alamat Badan Hukum</label>
<label  id="label_alamat_perorangan">Alamat Perorangan</label>
<textarea rows="4" placeholder="Alamat Lengkap perorangan atau badan hukum" id="alamat_badan_hukum" class="form-control form-control-sm required" required="" accept="text/plain"></textarea>
</div>
<label>Contact Person</label>
<input type="text" name="contact_person" placeholder="Contact Person" class="form-control form-control-sm contact_person required" accept="text/plain">
<label>No Telepon</label>
<input type="number" name="no_tlp" placeholder="No Telepon/HP"  class="form-control form-control-sm contact_number required" accept="text/plain">
</div>
<div class="card-footer">
<button type="submit" class="btn btn-sm simpan_client btn-dark btn-block">Simpan data pengurus <span class="fa fa-save"></span></button>
</form>
</div>
</div>
</div>
</div> 
<!------------------modal data perekaman user------------->
<div class="modal fade " id="data_perekaman_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl" role="document">
<div class="modal-content ">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel text-center">PROSES PEREKAMAN DATA <span class="nama_client_title"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body data_perekaman_user  text-theme1 ">
</div>
</div>
</div>
</div>
<!------------------modal upload data------------->
<div class="modal fade" id="modal_upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document">
<div class="modal-content ">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel text-center">PEREKAMAN DOKUMEN <span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<form  id="fileForm" method="post" action="<?php echo base_url('User2/simpan_persyaratan') ?>">
<div class="modal-body form_persyaratan">
</div>
<div class="modal-footer">
<button type="submit" class="btn btn-sm btn_simpan_persyaratan btn-block btn-dark">Simpan <img id="loading"  style="display: none; width:25px;" src="<?php echo base_url() ?>assets/loading.svg"></button>    
</div>
</form>    
</div>
</div>
</div>
<!------------------modal data perekaman------------->
<div class="modal fade " id="data_perekaman" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl" role="document">
<div class="modal-content ">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel text-center">Data yang telah direkam<span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body data_perekaman ">
</div>
</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
$(".add_client").click(function(){
$('#modal_tambah_client').modal('show');   
});
});    


$("#pilih_jenis").on("change",function(){
var client = $("#pilih_jenis option:selected").text();
if(client == "Perorangan"){
$("#form_client").show(100);
$("#label_alamat_perorangan,#label_nama_perorangan").fadeIn(100);
$("#label_alamat_hukum,#label_nama_hukum").fadeOut(100);
}else if(client == "Badan Hukum"){
$("#form_client").show(100);
$("#label_alamat_hukum,#label_nama_hukum").fadeIn(100);
$("#label_alamat_perorangan,#label_nama_perorangan").fadeOut(100);
}else{
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated tada'
});

Toast.fire({
type: 'warning',
title: 'Silahkan pilih jenis client terlebih dahulu.'
})
}
});    

function jadikan_kontak_person(){
$(".contact_person").val($("#badan_hukum").val());
}

function modal_client(){
$('#modal_cari_client').modal('show');    
}

function data_perekaman_user(no_client){
var token                    = "<?php echo $this->security->get_csrf_hash() ?>";
var no_pekerjaan             = "<?php echo $this->uri->segment(3) ?>";

$.ajax({
type:"post",
data:"token="+token+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('User2/data_perekaman_user') ?>",
success:function(data){
$('#data_perekaman_user').modal('show');
$('.data_perekaman_user').html(data);
}
});
}    

function response(data){

var r = JSON.parse(data);
if(r.status == "success"){
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated zoomInDown'
});

Toast.fire({
type: r.status,
title: r.pesan
});
$(".form_meta").val("");
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
type: r.status,
title: r.pesan
});
}
}    

$(function(){
var <?php echo $this->security->get_csrf_token_name();?>  = "<?php echo $this->security->get_csrf_hash(); ?>"       
$("#cari_client").autocomplete({
minLength:0,
delay:0,
source: function( request, response ) {
$.ajax({
url: "<?php echo base_url('User2/cari_nama_client') ?>",
method:'post',
data: {
token:token,  
term: request.term,
jenis_pemilik: $(".tentukan_jenis option:selected").val()
},success: function( data ) {
var d = JSON.parse(data);   
response(d);
}
});
},select:function(event, ui){
$("#no_client").val(ui.item.no_client);

}

});
}); 


function buat_perekaman(){
var no_client       =  $("#no_client").val();
var no_pekerjaan    =  "<?php echo $this->uri->segment(3) ?>";
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('User2/buat_pemilik_perekaman') ?>",
success:function(data){
response(data);
tampilkan_data_client();
$(".perekaman").val("")
}
});
}

function tampilkan_data_client(){
var no_pekerjaan    =  "<?php echo $this->uri->segment(3) ?>";
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('User2/tampilkan_data_client') ?>",
success:function(data){
$(".data_client").html(data);
}
});

}

function tentukan_jenis(){
var jenis = $(".tentukan_jenis option:selected").val();
if(jenis != 'null'){
$("#cari_client").attr("readonly",false);
$("#cari_client").val("")
$(".jenis_pemilik").html(jenis);
}else{
$("#cari_client").attr("readonly",true); 
$("#cari_client").val("")
$(".jenis_pemilik").html("");
}

}    


function lihat_data_perekaman(no_nama_dokumen,no_pekerjaan,no_client){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_nama_dokumen="+no_nama_dokumen+"&no_pekerjaan="+no_pekerjaan+"&no_client="+no_client,
url:"<?php echo base_url('User2/data_perekaman') ?>",
success:function(data){
$(".data_perekaman").html(data);    
$('#data_perekaman').modal('show');
}
});
}

function hapus_pemilik(no_pemilik){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_pemilik="+no_pemilik,
url:"<?php echo base_url('User2/hapus_pemilik') ?>",
success:function(data){
response(data);
refresh();
}

});
}


function refresh(){
tampilkan_data_client();
}

function hapus_berkas_persyaratan(id_data_berkas,no_nama_dokumen,no_pekerjaan,no_client){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&id_data_berkas="+id_data_berkas,
url:"<?php echo base_url('User2/hapus_berkas_persyaratan') ?>",
success:function(data){
data_perekaman_user(no_client);    
response(data);
lihat_data_perekaman(no_nama_dokumen,no_pekerjaan,no_client);
persyaratan_telah_dilampirkan();
refresh();
}
});    
}




function persyaratan_telah_dilampirkan(){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token,
url:"<?php echo base_url('User2/persyaratan_telah_dilampirkan/'.$this->uri->segment(3)) ?>",
success:function(data){
$('.syarat_telah_dilampirkan').html(data);
$(function () {
$('[data-toggle="popover"]').popover({
container: 'body',
html :true
});
$('.btn').on('click', function (e) {
$('.btn').not(this).popover('hide');
});
});
}
});
}
function cek_download_berkas(no_berkas){

var token           = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_berkas="+no_berkas,
url:"<?php echo base_url('User2/cek_download_berkas') ?>",
success:function(data){
var r = JSON.parse(data);
if(r.status == 'success'){
window.location.href = '<?php echo base_url('User2/download_berkas/') ?>'+no_berkas;   
}else{
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated tada'
});

Toast.fire({
type: r.status,
title: r.pesan
});
}
}
});
}





function tampil_modal_upload(no_pekerjaan,no_nama_dokumen,no_client){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";

$.ajax({
type:"post",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan+"&no_nama_dokumen="+no_nama_dokumen+"&no_client="+no_client,
url:"<?php echo base_url('User2/form_persyaratan') ?>",
success:function(data){
$('.form_persyaratan').html(data);    
$('#modal_upload').modal('show');
regis_js();
}    
});
}

function regis_js(){
$(".Desimal").keyup(function(){
var string = numeral(this.value).format('0,0');
$("#"+this.id).val(string);
});
$(".Bulat").keyup(function(){
var string = numeral(this.value).format('0');
$("#"+this.id).val(string);
});

$(function() {
$(".date").daterangepicker({ 
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
});

}






function lanjutkan_proses_perizinan(no_pekerjaan){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('User2/lanjutkan_proses_perizinan') ?>",
success:function(data){
refresh();
var r = JSON.parse(data);
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 2000,
animation: false,
customClass: 'animated zoomInDown'
});

Toast.fire({
type: r.status,
title: r.pesan
}).then(function() {
window.location.href = "<?php echo base_url('User2/pekerjaan_proses/'); ?>";
});

}
});
}

function download(id_data_berkas){
window.location.href="<?php echo base_url('User2/download_berkas/') ?>"+id_data_berkas;
}


$("#fileForm").submit(function(e) {
e.preventDefault();
$.validator.messages.required = '';
}).validate({
highlight: function (element, errorClass) {
$(element).closest('.form-control').addClass('is-invalid');
},
unhighlight: function (element, errorClass) {
$(element).closest(".form-control").removeClass("is-invalid");
},    
submitHandler: function(form) {
$(".btn_simpan_persyaratan").attr("disabled", true);

var result = { };
var jml_meta = $('.meta').length;
for (i = 1; i <=jml_meta; i++) {

var key   =($("#data_meta"+i).attr('name'));
var value =($("#data_meta"+i).val());

$.each($('form').serializeArray(), function() {
result[key] = value;
});

}

var token             = "<?php echo $this->security->get_csrf_hash() ?>";
var name = $("#id").attr("name");

formdata = new FormData();
formdata.append("token", token);
file = $("#file_berkas").prop('files')[0];;
formdata.append("file_berkas", file);
formdata.append("no_nama_dokumen",$(".no_nama_dokumen").val());
formdata.append("no_client",$(".no_client").val());
formdata.append("no_pekerjaan",$(".no_pekerjaan").val());
formdata.append('data_meta', JSON.stringify(result));


$.ajax({
url: form.action,
processData: false,
contentType: false,
type: form.method,
data: formdata,
success:function(data){
$(".btn_simpan_persyaratan").attr("disabled", false);
data_perekaman_user($(".no_client").val());    
persyaratan_telah_dilampirkan();    
response(data);


}
});
return false; 
}
});

$(document).ready(function(){
});

$("#fileclient").submit(function(e) {
e.preventDefault();
$.validator.messages.required = '';
}).validate({
highlight: function (element, errorClass) {
$(element).closest('.form-control').addClass('is-invalid');
},
unhighlight: function (element, errorClass) {
$(element).closest(".form-control").removeClass("is-invalid");
},    
submitHandler: function(form) {
$(".simpan_client").attr("disabled", true);
var token    = "<?php echo $this->security->get_csrf_hash() ?>";
formData = new FormData();
formData.append('token',token);
formData.append('jenis_client',$("#pilih_jenis option:selected").text());
formData.append('badan_hukum',$("#badan_hukum").val()),
formData.append('alamat_badan_hukum',$("textarea#alamat_badan_hukum").val()),
formData.append('contact_person',$(".contact_person").val()),
formData.append('contact_number',$(".contact_number").val()),
$.ajax({
url: form.action,
processData: false,
contentType: false,
type: form.method,
data: formData,
success:function(data){
$(".form-control").val("");  
response(data);
$(".simpan_client").removeAttr("disabled", true);
}
});
return false; 
}
});

</script>



</body>

