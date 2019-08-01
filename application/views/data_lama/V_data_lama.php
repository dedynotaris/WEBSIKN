<body>
<?php  $this->load->view('umum/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar_data_lama'); ?>
<div class="container-fluid ">
<div class="card-header mt-2 mb-2 text-center ">
<h5 align="center">Tentukan Nama Client Dan Jenis Pekerjaan</h5>
</div>
<form  id="file_lama" method="post" action="<?php echo base_url('Data_lama/simpan_pekerjaan_arsip') ?>">

<div class="row">
<div class="col-md-6 mx-auto">


<label>Nama client</label>
<div class="input-group ">
    <input type="text" name="nama_client" class="form-control nama_client required" accept="text/plain" aria-describedby="basic-addon2">
<div class="input-group-append">
<button class="btn btn-dark add_client" type="button"><span class="fa fa-plus"></span> Client</button>
</div>
</div>
<input type="hidden" name="no_client" readonly="" class="form-control no_client required" accept="text/plain">
<label>Nama Notaris</label>
<select class="form-control nama_notaris required" accept="text/plain">
    <option></option>    
<?php 
foreach ($nama_notaris->result_array() as $nama){
echo "<option value=".$nama['no_user'].">".$nama['nama_lengkap']."</option>";    
}
?>
    
</select>

<label>Nama Pekerjaan</label>
<input type="text" name="jenis_pekerjaan" class="form-control jenis_pekerjaan required" accept="text/plain" aria-describedby="basic-addon2">
<input type="hidden" name="no_jenis_pekerjaan" class="form-control no_jenis_pekerjaan required" accept="text/plain" aria-describedby="basic-addon2">
<label>&nbsp;</label>
<button type="submit" class="btn btn-dark btn-md btn-block">Simpan File <span class="fa fa-save"></span></button>
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
<button type="submit" class="btn btn-sm simpan_client btn-dark btn-block">Simpan data arsip <span class="fa fa-save"></span></button>
</form>
</div>
</div>
</div>
</div>   

<script type="text/javascript">


    
    
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
$(".no_jenis_pekerjaan").val(ui.item.no_jenis_pekerjaan);
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

var token    = "<?php echo $this->security->get_csrf_hash() ?>";
formData = new FormData();
formData.append('token',token);
formData.append('nama_client',$(".nama_client").val()),
formData.append('no_client',$(".no_client").val()),
formData.append('jenis_pekerjaan',$(".jenis_pekerjaan").val()),
formData.append('no_jenis_pekerjaan',$('.no_jenis_pekerjaan').val()),
formData.append('no_user',$('.nama_notaris option:selected').val()),
formData.append('pembuat_pekerjaan',$('.nama_notaris option:selected').text()),

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
</script>    


</body>
