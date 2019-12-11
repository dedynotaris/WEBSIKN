<body>
<?php $this->load->view('umum/user2/V_sidebar_user2'); ?>
<div id="page-content-wrapper">
<?php $this->load->view('umum/user2/V_navbar_user2'); ?>
<?php $this->load->view('umum/user2/V_data_user2'); ?>
<style>
.is-invalid .select2-selection {
border-color: rgb(185, 74, 72) !important;
}
</style>
<div class="container-fluid p-2 ">
<div class="mt-2  text-center  ">
<h5 align="center " class="text-theme1"><span class="fa-2x fas fa-pencil-alt "></span><br>Tambahkan pekerjaan dan klien baru</h5>
</div>
<form  id="form_pekerjaan" class="mt-2 p-2" method="post" action="#">
<div class="row text-theme1 rounded  m-2" >
<div class="col-md-6">
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash(); ?>" readonly="" class="form-control required"  accept="text/plain">
<label>*Jenis Pekerjaan</label>
<select name='jenis_pekerjaan' id='jenis_pekerjaan' class="form-control form-control-sm  jenis_pekerjaan"></select>
<label>*Target selesai</label>
<input type="text" placeholder="Target selesai pekerjaan" name="target_kelar" readonly="" id="target_kelar" class="form-control form-control-sm required"  accept="text/plain">

<label>*Pilih Jenis client</label>
<select name="jenis_client" id="jenis_client" class="form-control form-control-sm required" accept="text/plain">
<option value="Perorangan">Perorangan</option>
<option value="Badan Hukum">Badan Hukum</option>	
</select>

<div id="FormPeroranganBadanHukum">
<label>*NIK KTP</label>
<input type='text' id='no_identitas' class='form-control form-control-sm' placeholder='NIK KTP' name='no_identitas'>
<label>*Nama Perorangan</label>
<input type='text' placeholder='Nama Perorangan' name='badan_hukum' id='badan_hukum' class='form-control form-control-sm required'  accept='text/plain'>
</div>
</div>
    

<div class="col ">
<label>*Jenis Kontak</label>
<select name="jenis_kontak" id="jenis_kontak" class="form-control form-control-sm required" accept="text/plain">
<option></option>
<option value="Staff">Staff</option>
<option value="Pribadi">Pribadi</option>	
</select>  

<label>*Nama yang bisa dihubungi</label>
<input type="text" placeholder="Kontak yang bisa dihubungi" class="form-control form-control-sm required" id="contact_person" name="contact_person" accept="text/plain">
<label>*Nomor Kontak Telephone / HP</label>
<input type="text" placeholder="Nomor Kontak Telephone  / HP" class="form-control form-control-sm required" id="contact_number" name="contact_number" accept="text/plain">
<label></label>
<button type="button"  onclick="simpan_pekerjaan();" class="btn btn-success btn-sm mx-auto btn-block simpan_perizinan">Buat pekerjaan dan klien baru <i class="fa fa-save"></i></button>
<hr>
<i style="font-size:14px;" class="text-danger">*Hanya Jika Client sudah tersedia</i>
<button type="button"   onclick="buat_pekerjaan_baru();" class="btn btn-warning btn-sm mx-auto btn-block ">Buat Pekerjaan Baru Saja</button>  
</div>
</form>
</div>
</div>

<!------------- Modal ---------------->
<div class="modal fade bd-example-modal-md" id="modal" role="dialog" aria-labelledby="tambah_syarat1" aria-hidden="true">
<div class="modal-dialog modal-md data_modal" role="document">

</div>
</div>

</div>


<script type="text/javascript">
$("#jenis_client").on("change",function(){
var client = $("#jenis_client option:selected").text();

if(client == "Perorangan"){
$("#FormPeroranganBadanHukum").html("<label>*Nama Perorangan</label>\n\
<input type='text' placeholder='Nama Perorangan' name='badan_hukum' id='badan_hukum' class='form-control form-control-sm required'  accept='text/plain'>\n\
<label>*NIK KTP</label>\n\
<input type='text' class='form-control form-control-sm required'  accept='text/plain' id='no_identitas' placeholder='NIK KTP' name='no_identitas'>");

}else if(client == "Badan Hukum"){
$("#FormPeroranganBadanHukum").html("<label>*Nama Badan Hukum</label>\n\
<input type='text' placeholder='Nama Badan Hukum' name='badan_hukum' id='badan_hukum' class='form-control form-control-sm required'  accept='text/plain'>\n\
<label>*No NPWP</label>\n\
<input type='text' class='form-control form-control-sm required'  accept='text/plain'id='no_identitas' placeholder='No NPWP' name='no_identitas'>");
}
});


$(function(){
var <?php echo $this->security->get_csrf_token_name();?>  = "<?php echo $this->security->get_csrf_hash(); ?>";       
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
var data = JSON.parse(data);
console.log(data.results);
return {
results: data.results
};

}

}        

});
});


$(function() {
$("input[name='target_kelar']").datepicker({
minDate:0,
dateFormat: 'yy/mm/dd'
});
});

function cari_client(){
var a = $(".cari_client").val(); 
var <?php echo $this->security->get_csrf_token_name();?>  = "<?php echo $this->security->get_csrf_hash(); ?>"       
$.ajax({
type:"post",
url:"<?php echo base_url('User2/cari_client') ?>",
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


function buat_pekerjaan_baru(){
var <?php echo $this->security->get_csrf_token_name();?>  = "<?php echo $this->security->get_csrf_hash(); ?>"       

  $.ajax({
type:"post",
url:"<?php echo base_url('User2/form_tambah_pekerjaan') ?>",
data:"token="+token,
success:function(data){
$(".data_modal").html(data);    
$('#modal').modal('show');
cari_jenis_pekerjaan();
target_kelar();
}
});
}

function cari_jenis_pekerjaan(){
var <?php echo $this->security->get_csrf_token_name();?>  = "<?php echo $this->security->get_csrf_hash(); ?>";       
$(".jenis_pekerjaan2").select2({
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
}

function simpan_pekerjaan_baru(){
var no_jenis_pekerjaan = $(".jenis_pekerjaan2").val();
var hasil_client       = $(".hasil_client").text();
var target_kelar2      = $("#target_kelar2").val();
var no_client          = $(".no_client2").val();
var <?php echo $this->security->get_csrf_token_name();?>  = "<?php echo $this->security->get_csrf_hash(); ?>";       
$(".simpan_pekerjaan").attr("disabled",true);
if(no_jenis_pekerjaan != null && hasil_client !='' && target_kelar2 != '' ){

$.ajax({
type:"post",
url:"<?php echo base_url('User2/buat_pekerjaan_baru') ?>",
data:"token="+token+"&no_client="+no_client+"&target_kelar="+target_kelar2+"&jenis_pekerjaan="+no_jenis_pekerjaan,
success:function(data){
var r  = JSON.parse(data);
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

$('#modal').modal('hide');
}
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
type:"warning",
title:"Jenis pekerjaan,data client,atau target selesai tidak tersedia"
});
}
$(".simpan_pekerjaan").attr("disabled",false);
}

function target_kelar() {
$("input[name='target_kelar2']").datepicker({ minDate:0,dateFormat: 'yy/mm/dd'
});
}

function simpan_pekerjaan(){
$(".simpan_perizinan").attr("disabled", true);
$("#form_pekerjaan").find(".is-invalid").removeClass("is-invalid").addClass("is-valid");
$("#form_pekerjaan").find(".select2").removeClass("is-invalid").addClass("is-valid");    
$('.form-control + p').remove();
$('.select2 + p').remove();
$.ajax({
url  : "<?php echo base_url("User2/create_client") ?>",
type : "post",
data : $("#form_pekerjaan").serialize(),
success: function(data) {
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
if(key == "jenis_pekerjaan"){
$("#form_pekerjaan").find(".select2").addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#form_pekerjaan").find(".select2").removeClass("is-valid");    
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
