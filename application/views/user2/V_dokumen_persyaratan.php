<div class="container-fluid">
<div class="card-header mt-2 mb-2 text-center">
Lengkapi persyaratan dokumen
<button class="btn btn-success btn-sm float-md-right "  onclick="lanjutkan_proses_perizinan('<?php echo $this->uri->segment(3) ?>');">Lanjutkan keproses perizinan <span class="fa fa-exchange-alt"></span>
</div>

<div class="container">
<div class="row">
<div class="col-md-4 card">
<div class="text-center card-footer"><b>Tentukan Pemilik Dokumen </b></div>
<hr>    
<label>Jenis Pemilik</label> 
<select onchange="tentukan_jenis()" class="form-control tentukan_jenis">
<option value="null">--- Tentukan Jenis Pemilik ---</option>    
<option value="Badan Hukum">Badan Hukum</option>    
<option Value="Perorangan">Perorangan</option>    
</select>
<label>Cari Nama <span class="jenis_pemilik"></span></label>
<input type="text" id="cari_client" class="form-control" readonly="">
<label>No Client</label>
<input type="text" id="no_client" class="form-control" readonly="">
<hr>
<button class="btn btn-dark btn-sm" onclick="buat_perekaman();">Buat Perekaman</button>
</div>
<div class="col">
<div class="text-center card-footer"><b>Nama Badan Hukum atau Perorangan yang harus dilengkapi datanya <br> </b></div>
<hr>        
<div class="data_client">
</div>
</div>
</div>
</div>
</div>
</div>





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
<script type="text/javascript">
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
$(".form-control").val("")
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


</script>