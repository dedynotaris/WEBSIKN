<body>
<?php  $this->load->view('umum/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar_data_lama'); ?>
<div class="container-fluid ">
<div class="card-header mt-2 text-center ">
<h5 align="center">Upload data lama</h5>
</div>
<form  id="file_lama" method="post" action="<?php echo base_url('Data_lama/simpan_berkas') ?>">

<div class="row">
<div class="col">


<label>Nama client</label>
<div class="input-group ">
    <input type="text" name="nama_client" class="form-control nama_client required" accept="text/plain" aria-describedby="basic-addon2">
<div class="input-group-append">
<button class="btn btn-success add_client" type="button"><span class="fa fa-plus"></span> Client</button>
</div>
</div>

<label>No client</label>
<input type="text" name="no_client" readonly="" class="form-control no_client required" accept="text/plain">

<label>Pilih Jenis Dokumen</label>
<select onchange="opsi_jenis_dokumen();" name="jenis_dokumen"  class="form-control  jenis_dokumen required" accept="text/plain">
<option >------ Pilih jenis dokumen -----</option>
<option value="1"> Dokumen Utama </option>
<option value="2"> Dokumen Perizinan </option>
</select>
</div>
<div class="col">
<label>Nama Dokumen</label>

<select class="form-control nama_dokumen required" accept="text/plain" disabled="">
    <option></option>    
</select>
<div class="data_meta"></div>


<label>Pilih File</label>
<input type="file" name="file_upload" class="form-control file_upload required" >

<label>&nbsp;</label>
<button type="submit" class="btn btn-success btn-sm btn-block">Simpan File <span class="fa fa-save"></span></button>
</div>
</div>    

</form>
</div>
</div>

<div class="modal fade" id="modal_tambah_client" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-body">
<form  id="fileForm" method="post" action="<?php echo base_url('Data_lama/create_client') ?>">
    
<label>Contact Person</label>
<input type="text" name="contact_person" class="form-control contact_person required" accept="text/plain">

<label>No Telepon</label>
<input type="number" name="no_tlp"  class="form-control contact_number required" accept="text/plain">

<label>Pilih Jenis client</label>
<select name="jenis" id="pilih_jenis" class="form-control  required" accept="text/plain">
<option ></option>
<option value="Perorangan">Perorangan</option>
<option value="Badan Hukum">Badan Hukum</option>	
</select>

<div id="form_badan_hukum">
<label  id="label_nama_perorangan">Nama Perorangan</label>
<label  style="display: none;" id="label_nama_hukum">Nama Badan Hukum</label>
<input type="text" name="badan_hukum" id="badan_hukum" class="form-control required"  accept="text/plain">
</div>

<div id="form_alamat_hukum">
<label style="display: none;" id="label_alamat_hukum">Alamat Badan Hukum</label>
<label  id="label_alamat_perorangan">Alamat Perorangan</label>
<textarea rows="4" id="alamat_badan_hukum" class="form-control required" required="" accept="text/plain"></textarea>
</div>

    
</div>
<div class="card-footer">
<button type="submit" class="btn btn-sm simpan_client btn-success btn-block">Simpan Client <span class="fa fa-save"></span></button>
</form>
</div>
</div>
</div>
</div>   

<script type="text/javascript">

function tampilkan_meta(){
var no_nama_dokumen = $(".opsi_meta option:selected").val();        
var <?php echo $this->security->get_csrf_token_name();?>  = "<?php echo $this->security->get_csrf_hash(); ?>";       
$.ajax({
type:"post",
url:"<?php echo base_url('Data_lama/data_meta') ?>",
data:"token="+token+"&no_nama_dokumen="+$(".opsi_meta option:selected").val(),
success:function(data){
$(".data_meta").html(data);

if ($('.informasi').is(':empty')){
CKEDITOR.replace('informasi', {
toolbarGroups: [{
"name": "basicstyles",
"groups": ["basicstyles"]
},
{
"name": "links",
"groups": ["links"]
},
{
"name": "paragraph",
"groups": ["list", "blocks"]
},
{
"name": "document",
"groups": ["mode"]
},

{
"name": "styles",
"groups": ["styles"]
}

],
removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
});
}

}
});

}

function opsi_jenis_dokumen(){
var jenis_dokumen = $(".jenis_dokumen option:selected").val();
        
if(jenis_dokumen == 1){
$(".nama_dokumen").html("");    
$(".nama_dokumen").removeAttr("disabled",true);
var opsi = "<option>Draft</option>\n\
<option>Minuta</option>\n\
<option>Salinan</option>";
$(".nama_dokumen").append(opsi);
$(".nama_dokumen").removeClass("opsi_meta");    
}else{
    
var <?php echo $this->security->get_csrf_token_name();?>  = "<?php echo $this->security->get_csrf_hash(); ?>";       
$(".nama_dokumen").addClass("opsi_meta");
$('.nama_dokumen').attr('onClick', 'tampilkan_meta();');
$(".nama_dokumen").html("");    
$.ajax({
type:"post",
url:"<?php echo base_url('Data_lama/opsi_nama_dokumen') ?>",
data:"token="+token,
success:function(data){
$(".nama_dokumen").append(data,".opsi_meta");
}
});

$(".nama_dokumen").removeAttr("disabled",true);
}        
        
        
}    
    
    
$(function(){
var <?php echo $this->security->get_csrf_token_name();?>  = "<?php echo $this->security->get_csrf_hash(); ?>"       
$(".nama_client").autocomplete({
minLength:0,
delay:0,
source:'<?php echo site_url('Data_lama/cari_nama_client') ?>',
select:function(event, ui){
$(".no_client").val(ui.item.no_client);
}
}
);
});

$(function(){
var <?php echo $this->security->get_csrf_token_name();?>  = "<?php echo $this->security->get_csrf_hash(); ?>"       
$(".jenis_pekerjaan").autocomplete({
minLength:0,
delay:0,
source:'<?php echo site_url('Data_lama/cari_jenis_pekerjaan') ?>',
select:function(event, ui){
$(".no_client").val(ui.item.no_client);
}
}
);
});

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

$("#file_lama").submit(function(e) {
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
$(".simpan_data").attr("disabled", true);

var result = { };
var jml_meta = $('.meta_data').length;

for (i = 1; i <=jml_meta; i++) {
var key   =($("#data_meta"+i).attr('name'));
var value =($("#data_meta"+i).val());
$.each($('form').serializeArray(), function() {
result[key] = value;
});
}



var token    = "<?php echo $this->security->get_csrf_hash() ?>";
formData = new FormData();
formData.append('token',token);
formData.append('nama_client',$(".nama_client").val()),
formData.append('no_client',$(".no_client").val()),

formData.append('nama_dokumen',$(".nama_dokumen option:selected").text()),
formData.append('no_nama_dokumen',$('.nama_dokumen option:selected').val()),


formData.append("file_berkas", $(".file_upload").prop('files')[0]);
if ($('.informasi').is(':empty')){
var data_informasi = CKEDITOR.instances['informasi'].getData();    
formData.append('data_informasi',data_informasi);
}else{
formData.append('data_meta', JSON.stringify(result));
}


$.ajax({
url: form.action,
processData: false,
contentType: false,
type: form.method,
data: formData,
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
type: r.status,
title: r.pesan
});
$(".simpan_data").removeAttr("disabled", true);


$(".form-control").val("");
}
});
return false; 
}
});



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
$('#modal_tambah_client').modal('hide');       
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
type: r.status,
title: r.pesan
});
$(".simpan_client").removeAttr("disabled", true);

}

});
return false; 
}
});

</script>    


</body>
