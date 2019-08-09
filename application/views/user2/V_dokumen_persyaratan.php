   
<div class="container mt-2">
<div class="row">
<div class="col">
<div class="text-center"><b>Nama Badan Hukum atau Perorangan yang harus dilengkapi datanya   <button class="btn btn-dark btn-sm float-md-right "  onclick="modal_client();">Tambah Client <span class="fa fa-plus"></span></button>
<hr> </b></div>
<div class="data_client">
</div>
</div>
</div>
</div>
</div>




<!------------------modal buat perizinan------------->
<div class="modal fade" id="modal_buat_perizinan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl" role="document">
<div class="modal-content ">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel text-center">Buat Perizinan Dokumen Client<span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body modal_buat_perizinan">
</div>
</div>
</div>
</div>
<div class="data_form_perizinan m-2 p-2"></div>
<!-------------------modal laporan--------------------->
<div class="modal fade" id="modal_laporan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document">
<div class="modal-content">
<div class="modal-body data_laporan">

</div>
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
<select onchange="tentukan_jenis()" class="form-control tentukan_jenis">
<option value="null">--- Tentukan Jenis Pemilik ---</option>    
<option value="Badan Hukum">Badan Hukum</option>    
<option Value="Perorangan">Perorangan</option>    
</select>

<label>Cari Nama <span class="jenis_pemilik"></span></label>
<div class="input-group ">
    <input type="text" id="cari_client" name="nama_client" class="form-control perekaman nama_client required" readonly="" accept="text/plain" aria-describedby="basic-addon2">
<div class="input-group-append">
<button class="btn btn-dark add_client" type="button"><span class="fa fa-plus"></span> Client</button>
</div>
</div>


<label>No Client</label>
<input type="text" id="no_client" class="form-control perekaman" readonly="">
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
<label>Contact Person</label>
<input type="text" name="contact_person" placeholder="contact person" class="form-control form-control-sm contact_person required" accept="text/plain">
<label>No Telepon</label>
<input type="number" name="no_tlp" placeholder="no telepon/HP"  class="form-control form-control-sm contact_number required" accept="text/plain">
<label>Pilih Jenis client</label>
<select name="jenis" id="pilih_jenis" class="form-control form-control-sm  required" accept="text/plain">
<option>---Jenis cLient ----</option>
<option value="Perorangan">Perorangan</option>
<option value="Badan Hukum">Badan Hukum</option>	
</select>
<div id="form_badan_hukum">
<label  id="label_nama_perorangan">Nama Perorangan</label>
<label  style="display: none;" id="label_nama_hukum">Nama Badan Hukum</label>
<input type="text" placeholder="nama perorangan / badan HUkum" name="badan_hukum" id="badan_hukum" class="form-control form-control-sm  required"  accept="text/plain">
</div>
<div id="form_alamat_hukum">
<label style="display: none;" id="label_alamat_hukum">Alamat Badan Hukum</label>
<label  id="label_alamat_perorangan">Alamat Perorangan</label>
<textarea rows="4" placeholder="Alamat Lengkap perorangan atau badan hukum" id="alamat_badan_hukum" class="form-control form-control-sm required" required="" accept="text/plain"></textarea>
</div>
</div>
<div class="card-footer">
<button type="submit" class="btn btn-sm simpan_client btn-dark btn-block">Simpan data arsip <span class="fa fa-save"></span></button>
</form>
</div>
</div>
</div>
</div> 


<!------------------modal data perekaman user------------->
<div class="modal fade" id="data_perekaman_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl" role="document">
<div class="modal-content ">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel text-center">Data Perekaman Client<span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body data_perekaman_user">
</div>
</div>
</div>
</div>



<!------------------modal upload data------------->
<div class="modal fade" id="modal_upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document">
<div class="modal-content ">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel text-center">Perekaman data<span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<form  id="fileForm" method="post" action="<?php echo base_url('User2/simpan_persyaratan') ?>">
<div class="modal-body form_persyaratan">
</div>
<div class="modal-footer">
<button type="submit" class="btn btn-md btn-block btn-dark">Simpan <span class="fa fa-save"></span></button>    
</div>
</form>    
</div>
</div>
</div>

<!------------------modal data perekaman------------->
<div class="modal fade" id="data_perekaman" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl" role="document">
<div class="modal-content ">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel text-center">Data yang telah direkam<span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body data_perekaman">
</div>
</div>
</div>
</div>

<!------------------modal alihkan_tugas------------->
<div class="modal fade" id="modal_alihkan_tugas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document">
<div class="modal-content ">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel text-center">Alihkan Tugas Perizinan<span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body modal_alihkan_tugas">
    
</div>
</div>
</div>
</div>


<script type="text/javascript">
function lihat_progress_perizinan(no_berkas_perizinan){
var token           = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_berkas_perizinan="+no_berkas_perizinan,
url:"<?php echo base_url('User2/lihat_laporan') ?>",
success:function(data){
$('#modal_laporan').modal('show');
$(".data_laporan").html(data);
}
});
}

function alihkan_tugas(no_berkas_perizinan){
var token           = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_berkas_perizinan="+no_berkas_perizinan,
url:"<?php echo base_url('User2/modal_alihkan_tugas') ?>",
success:function(data){
$('#modal_alihkan_tugas').modal('show');
$(".modal_alihkan_tugas").html(data);
}
});
}
    
function option_aksi(no_berkas_perizinan,no_nama_dokumen,no_pekerjaan,no_client){
var val = $(".option_aksi"+no_berkas_perizinan).val();
if(val == 1){
hapus_syarat(no_berkas_perizinan,no_pekerjaan,no_client);    
}else if(val == 2){
alihkan_tugas(no_berkas_perizinan,no_pekerjaan,);
}else if(val == 3){
lihat_progress_perizinan(no_berkas_perizinan);
}else if(val == 4){
lihat_data_perekaman(no_nama_dokumen,no_pekerjaan);
}
$(".option_aksi"+no_berkas_perizinan).prop('selectedIndex',0);
}


function hapus_syarat(no_berkas_perizinan,no_pekerjaan,no_client){
var token    = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",	
url:"<?php echo base_url('User2/hapus_syarat') ?>",	
data:"token="+token+"&no_berkas_perizinan="+no_berkas_perizinan,
success:function(data){	
refresh();
buat_perizinan(no_pekerjaan,no_client);
}
});
}

    
    
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

function simpan_perizinan(no_pekerjaan,no_client){
var token                    = "<?php echo $this->security->get_csrf_hash() ?>";
var no_petugas               = $(".data_nama_petugas option:selected").val();
var no_dokumen               = $(".data_nama_dokumen option:selected").val();

$.ajax({
type:"post",
url:"<?php echo base_url('User2/simpan_perizinan') ?>",
data:"token="+token+"&no_petugas="+no_petugas+"&no_nama_dokumen="+no_dokumen+"&no_pekerjaan="+no_pekerjaan+"&no_client="+no_client,
success:function(data){
response(data);
buat_perizinan('<?php echo $this->uri->segment(3) ?>',no_client);    
}
});

}

function buat_perizinan(no_pekerjaan,no_client){
var token                    = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_client="+no_client+'&no_pekerjaan='+no_pekerjaan,
url:"<?php echo base_url('User2/modal_buat_perizinan') ?>",
success:function(data){
$(".modal_buat_perizinan").html(data);    
}
});    
$('#modal_buat_perizinan').modal('show');        
    
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


function tentukan_pengurus(no_berkas_perizinan,no_pekerjaan,no_client){
var no_user  = $(".tentukan_pengurus"+no_berkas_perizinan+" option:selected").val();
var token     = "<?php echo $this->security->get_csrf_hash() ?>";
if(no_user !=''){
$.ajax({
type:"post",
url:"<?php echo base_url('User2/simpan_pekerjaan_user') ?>",
data:"token="+token+"&no_user="+no_user+"&no_berkas_perizinan="+no_berkas_perizinan,
success:function(data){
buat_perizinan("<?php echo $this->uri->segment(3) ?>",no_client);    
}
});
}else{
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 10000,
animation: false,
customClass: 'animated zoomInDown'
});
Toast.fire({
type: 'error',
title: 'Tentukan user yang akan mengerjakan perizinan tersebut'
});
}
}

function tampilkan_data_client(){
var no_pekerjaan    =  "<?php echo $this->uri->segment(3) ?>";
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('User2/tampilkan_data_perizinan') ?>",
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
    
    
function lihat_data_perekaman(no_nama_dokumen,no_pekerjaan){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_nama_dokumen="+no_nama_dokumen+"&no_pekerjaan="+no_pekerjaan,
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
lihat_data_perekaman(no_nama_dokumen,no_pekerjaan);
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






function tampil_modal_upload(no_pekerjaan,no_nama_dokumen,no_client){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";

$.ajax({
type:"post",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan+"&no_nama_dokumen="+no_nama_dokumen+"&no_client="+no_client,
url:"<?php echo base_url('User2/form_persyaratan') ?>",
success:function(data){
$('.form_persyaratan').html(data);    
$('#modal_upload').modal('show');
var inputQuantity = [];
    $(function() {
      $(".quantity").each(function(i) {
        inputQuantity[i]=this.defaultValue;
         $(this).data("idx",i); // save this field's index to access later
      });
      $(".quantity").on("keyup", function (e) {
        var $field = $(this),
            val=this.value,
            $thisIndex=parseInt($field.data("idx"),10); // retrieve the index
        if (this.validity && this.validity.badInput || isNaN(val) || $field.is(":invalid") ) {
            this.value = inputQuantity[$thisIndex];
            return;
        } 
        if (val.length > Number($field.attr("maxlength"))) {
            var t = Number($field.attr("maxlength"));
          val=val.slice(0,t);
          $field.val(val);
        }
        inputQuantity[$thisIndex]=val;
      });      
    });
}    
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
data_perekaman_user($(".no_client").val());    
persyaratan_telah_dilampirkan();    
response(data);
refresh();
}

});
return false; 
}
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

