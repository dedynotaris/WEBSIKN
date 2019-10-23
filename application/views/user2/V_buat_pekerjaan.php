<body>
<?php $this->load->view('umum/user2/V_sidebar_user2'); ?>
<div id="page-content-wrapper">
<?php $this->load->view('umum/user2/V_navbar_user2'); ?>
<?php $this->load->view('umum/user2/V_data_user2'); ?>

<div class="container-fluid p-2 ">
<div class="mt-2  text-center  ">
<h5 align="center " class="text-theme1"><span class="fa-2x fas fa-pencil-alt "></span><br>Tambahkan pekerjaan dan klien baru</h5>
</div>
<form  id="form_pekerjaan" class="mt-2 p-2" method="post" action="#">
<div class="row text-theme1 rounded card-header m-2" >
<div class="col-md-6">
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash(); ?>" readonly="" class="form-control required"  accept="text/plain">
<label>Jenis Pekerjaan</label>
<input type="text" placeholder="Tentukan jenis pekerjaan" name="jenis_pekerjaan"  id="jenis_pekerjaan" class="form-control form-control-sm required"  accept="text/plain">
<input type="hidden" name="id_jenis_pekerjaan" readonly="" id="id_jenis_pekerjaan" class="form-control required"  accept="text/plain">
<label>Target selesai</label>
<input type="text" placeholder="Target selesai pekerjaan" name="target_kelar" readonly="" id="target_kelar" class="form-control form-control-sm required"  accept="text/plain">


<label>Nama yang bisa dihubungi</label>
<input type="text" placeholder="Kontak yang bisa dihubungi" class="form-control form-control-sm required" id="contact_person" name="contact_person" accept="text/plain">
<label>Nomor Kontak Telephone / HP</label>
<input type="text" placeholder="Nomor Kontak Telephone  / HP" class="form-control form-control-sm required" id="contact_number" name="contact_number" accept="text/plain">
<label>Jenis Kontak</label>
<select name="jenis_kontak" id="jenis_kontak" class="form-control form-control-sm required" accept="text/plain">
<option></option>
<option value="Staff">Staff</option>
<option value="Pribadi">Pribadi</option>	
</select>  

</div>
<div class="col ">
<label>Pilih Jenis client</label>
<select name="jenis_client" id="jenis_client" class="form-control form-control-sm required" accept="text/plain">
<option></option>
<option value="Perorangan">Perorangan</option>
<option value="Badan Hukum">Badan Hukum</option>	
</select>    

<div id="form_badan_hukum">
<label  id="label_nama_perorangan">Nama Perorangan</label>
<label  style="display: none;" id="label_nama_hukum">Nama Badan Hukum</label>
<input type="text" placeholder="Nama Badan Hukum / Perorangan" name="badan_hukum" id="badan_hukum" class="form-control form-control-sm required"  accept="text/plain">
</div>

<div id="form_alamat_hukum">
<label style="display: none;" id="label_alamat_hukum">Alamat Badan Hukum</label>
<label  id="label_alamat_perorangan">Alamat Perorangan</label>
<textarea name="alamat_badan_hukum" rows="6" placeholder="Alamat Badan Hukum / Perorangan" id="alamat_badan_hukum" class="form-control form-control-sm required" required="" accept="text/plain"></textarea>
<hr>
<button type="button"  onclick="simpan_pekerjaan();" class="btn btn-success btn-sm mx-auto btn-block simpan_perizinan">Buat pekerjaan dan klien baru <i class="fa fa-save"></i></button>

</div>
</div>
</form>

</div>
</div>
    


<script type="text/javascript">
$("#jenis_client").on("change",function(){
var client = $("#jenis_client option:selected").text();
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


$(function(){
var <?php echo $this->security->get_csrf_token_name();?>  = "<?php echo $this->security->get_csrf_hash(); ?>"       
$("#jenis_pekerjaan").autocomplete({
minLength:0,
delay:0,
source:'<?php echo site_url('User2/cari_jenis_pekerjaan') ?>',
select:function(event, ui){
$("#id_jenis_pekerjaan").val("");
$("#id_jenis_pekerjaan,#id_jenis_akta_pekerjaan").val(ui.item.no_jenis_pekerjaan);
}
}
);
});

$(function() {
$("input[name='target_kelar']").datepicker({
minDate:0,
dateFormat: 'yy/mm/dd'
});
});

function simpan_pekerjaan(){
$(".simpan_perizinan").attr("disabled", true);
$("#form_pekerjaan").find(".is-invalid").removeClass("is-invalid").addClass("is-valid");
$('.form-control + p').remove();
$.ajax({
url  : "<?php echo base_url("User2/create_client") ?>",
type : "post",
data : $("#form_pekerjaan").serialize(),
success: function(data) {
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#form_pekerjaan").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#form_pekerjaan").find("#"+key).removeClass("is-valid");
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
window.location.href="<?php echo base_url('User2/pekerjaan_antrian/') ?>"+r[0].no_pekerjaan;
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
</script>

</div>
</body>
</html>
