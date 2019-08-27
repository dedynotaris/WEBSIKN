<body>
<?php  $this->load->view('umum/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar_data_lama'); ?>
<div class="container-fluid ">
    <div class="col-md-6 mx-auto">
    <div class="mt-4 card mx-auto ">    
    
<div class=" card-header ">
<h5 align="center " class="text-theme1">Buat Berkas Arsip<br><span class="fa-2x fas fa-pencil-alt"></span></h5>
</div>
<div class="card-body">    
<form  id="file_lama" method="post" action="<?php echo base_url('Data_lama/simpan_pekerjaan_arsip') ?>">
<label>Nama client</label>
<div class="input-group ">
    <input type="text" placeholder="nama client" name="nama_client" class="form-control form-control-sm nama_client required" accept="text/plain" aria-describedby="basic-addon2">
<div class="input-group-append">
<button class="btn btn-sm btn-dark add_client" type="button"><span class="fa fa-plus"></span> Client</button>
</div>
</div>
<input type="hidden" name="no_client" readonly="" class="form-control form-control-sm no_client required" accept="text/plain">
<label>Nama Notaris</label>
<select class="form-control form-control-sm nama_notaris required" accept="text/plain">
    <option> Pilih Nama Notaris </option>    
<?php 
foreach ($nama_notaris->result_array() as $nama){
echo "<option value=".$nama['no_user'].">".$nama['nama_lengkap']."</option>";    
}
?>
    
</select>

<label>Nama Pekerjaan</label>
<input type="text" placeholder="Nama Pekerjaan" name="jenis_pekerjaan" class="form-control form-control-sm jenis_pekerjaan required" accept="text/plain" aria-describedby="basic-addon2">
<input type="hidden" name="no_jenis_pekerjaan" class="form-control form-control-sm no_jenis_pekerjaan required" accept="text/plain" aria-describedby="basic-addon2">
</div>
        <div class="card-footer">
            <button type="submit" class="btn btn-dark btn-sm btn-md btn-block">Buat Arsip <span class="fa fa-save"></span></button>

        </div>
    
    </div>
        

</form>
</div>
</div>    
</div>    
</div>

<div class="modal fade" id="modal_tambah_client" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-body">
<form  id="fileForm" method="post" action="<?php echo base_url('Data_lama/create_client') ?>">

    <input type="hidden" id="pilih_jenis" value="Badan Hukum">
<div id="form_badan_hukum">
<label   id="label_nama_hukum">Nama Badan Hukum</label>
<input  placeholder="Nama Perorangan" type="text" name="badan_hukum" id="badan_hukum" class="form-control form-control-sm required"  accept="text/plain">
</div>

<div id="form_alamat_hukum">
<label  id="label_alamat_hukum">Alamat Badan Hukum</label>
<textarea placeholder="Badan Hukum" rows="4" id="alamat_badan_hukum" class="form-control form-control-sm required" required="" accept="text/plain"></textarea>
</div>

<label>Contact Person</label>
<input placeholder="contact Person" type="text" name="contact_person" class="form-control form-control-sm contact_person required" accept="text/plain">

<label>No Telepon</label>
<input placeholder="No telepon" type="number" name="no_tlp"  class="form-control form-control-sm contact_number required" accept="text/plain">

    
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
formData.append('jenis_client',$("#pilih_jenis").val());
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
