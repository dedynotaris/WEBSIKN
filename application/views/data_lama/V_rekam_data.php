<body onload="refresh()">
<?php  $this->load->view('umum/data_lama/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/data_lama/V_navbar_data_lama'); ?>
<?php  $this->load->view('umum/data_lama/V_data_data_lama'); ?>
<?php $static = $query->row_array(); 
?>
<div class="container text-theme1">    
<div class="card-header text-theme1 mt-2 mb-2 text-center">
HALAMAN BUAT PERIZINAN <?php echo $static['nama_client'] ?>
<button class="btn btn-success btn-sm float-md-right "  onclick="lanjutkan_proses_selesai('<?php echo $this->uri->segment(3) ?>');">Selesaikan pekerjaan <span class="fa fa-check"></span></button>
</div>



<div class="row m-1 text-theme1">
<div class="col-md-6 card-header">
<div class="row">

<div class="col">
<label>Pembuat Client</label><br>    

</div>
<div class="col"> :
<?php echo $static['pembuat_client'] ?>        
</div>
</div>    
<div class="row">
<div class="col">
<label>Nama client</label><br>    

</div>
<div class="col"> :
<?php echo $static['nama_client'] ?>  
</div>
</div>
<div class="row">
<div class="col">
<label>No Identitas</label><br>    

</div>
<div class="col"> :
<?php echo $static['no_identitas'] ?>        
</div>
</div>

<div class="row">
<div class="col">
<label>Jenis Client</label><br>    

</div>
<div class="col"> :
<?php echo $static['jenis_client'] ?>        
</div>
</div>
<div class="row">
<div class="col">
<label>Nama Kontak</label><br>    

</div>
<div class="col"> :
<?php echo $static['contact_person'] ?>        
</div>
</div>
<div class="row">
<div class="col">
<label>Nomor Kontak</label><br>    

</div>
<div class="col"> :
<?php echo $static['contact_number'] ?>        
</div>
</div>
<div class="row">
<div class="col">
<label>Jenis Kontak</label><br>    

</div>
<div class="col"> :
<?php echo $static['jenis_kontak'] ?>        
</div>
</div>
    <hr>
    <button onclick=form_edit_client("<?php echo base64_encode($static['no_client']) ?>"); class="btn btn-success btn-sm btn-block">Edit client <span class="fa fa-edit"></span></button>    
</div>

<div class="col card-header ml-1">
<div class="row">
<div class="col">
<label>Pembuat pekerjaan</label><br>    

</div>
<div class="col"> :
<?php echo $static['pembuat_pekerjaan'] ?>        
</div>
</div>
<div class="row">
<div class="col">
<label>Jenis Pekerjaan</label><br>    

</div>
<div class="col"> :
<?php echo $static['nama_jenis'] ?>        
</div>
</div>

<div class="row">
<div class="col">
<label>Tanggal dibuat pekerjaan</label><br>    

</div>
<div class="col"> :
<?php echo $static['tanggal_dibuat'] ?>        
</div>
</div>
<div class="row">
<div class="col">
<label>Target selesai pekerjaan</label><br>    

</div>
<div class="col"> :
    
<?php
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
?> 
</div>
</div>    
<form id='form_update_pekerjaan' >
<hr>
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name() ?>" value="<?php echo  $this->security->get_csrf_hash()  ?>" readonly="" class="form-control required"  accept="text/plain">
<input type="hidden" name="no_pekerjaan" value="<?php echo base64_encode($static['no_pekerjaan'])?>" readonly="" class="form-control required"  accept="text/plain">           
<label>Jenis Pekerjaan</label>
<select name='jenis_pekerjaan' id='jenis_pekerjaan' class="form-control form-control-sm  jenis_pekerjaan"></select>
</form>    
<hr>
<button onclick=update_pekerjaan(); class="btn btn-success btn-sm btn-block">Update jenis pekerjaan <span class="fa fa-edit"></span></button>    
</div>

</div>
    
<!-----------------------------PIHAK2 YANG TERLIBAT--------------------------------------------------->    
<div class="card-header text-theme1 mt-2 mb-2 text-center">Daftar Pihak-pihak yang terlibat
</div>
<div class=" card-header" >
<div class="row">
<div class="col-md-5">    
<div class="col ">
<form id="form_pihak_terlibat">
<input type="hidden" name="token" value="<?php echo $this->security->get_csrf_hash(); ?>" readonly="" class="required"  accept="text/plain">
<input type="hidden" name="no_pekerjaan" value="<?php echo $this->uri->segment(3) ?>" readonly="" class="required"  accept="text/plain">   
<input type="hidden" id="no_client" name="no_client" value="" readonly="" class="required"  accept="text/plain">   
    
<label>*Pilih Jenis pihak terlibat</label>
<select name="jenis_client" id="jenis_client" class="form-control form-control-sm required" accept="text/plain">
<option value="Perorangan">Perorangan</option>
<option value="Badan Hukum">Badan Hukum</option>	
</select>    

<div id="FormPeroranganBadanHukum">
<label>*NIK KTP</label>
<input type='text' onkeyup="cari_client2()" id='no_identitas' class='form-control form-control-sm no_identitas' placeholder='NIK KTP' name='no_identitas'>
<label>*Nama Perorangan</label>
<input type='text' placeholder='Nama Perorangan' name='badan_hukum' id='badan_hukum' class='form-control form-control-sm required'  accept='text/plain'>
</div>
    
<label>*Jenis pihak yang bisa dihubungi</label>
<select name="jenis_kontak" id="jenis_kontak" class="form-control form-control-sm required" accept="text/plain">
<option></option>
<option value="Staff">Staff</option>
<option value="Pribadi">Pribadi</option>	
</select>  

<label>*Nama pihak yang bisa dihubungi</label>
<input type="text" placeholder="Kontak yang bisa dihubungi" class="form-control form-control-sm required" id="contact_person" name="contact_person" accept="text/plain">
<label>*Nomor Kontak Telephone / HP</label>
<input type="text" placeholder="Nomor Kontak Telephone  / HP" class="form-control form-control-sm required" id="contact_number" name="contact_number" accept="text/plain">

</form>
</div>    
<hr>
<button type="button" onclick="simpan_pihak();" class="btn btn-sm btn-success btn-block"> Tambahkan pihak yang terlibat</button>
</div>

<div class="col text-theme1 ">
<div class="row text-center">
<div class="col"><b>Nama</div>
<div class="col">Aksi</b></div>
</div>
<div class="para_pihak">

</div>    
    
</div>    
</div>
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

    
    
<script type="text/javascript">
function cari_client2(){
var a = $(".no_identitas").val(); 
var token  = "<?php echo $this->security->get_csrf_hash(); ?>"       

$.ajax({
type:"post",
url:"<?php echo base_url('data_lama/cari_client2') ?>",
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

function hapus_berkas_persyaratan(no_client,no_pekerjaan,id_data_berkas){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>" ;      

$.ajax({
type:"post",
url:"<?php echo base_url('Data_lama/hapus_berkas_persyaratan/') ?>",
data:"token="+token+"&id_data_berkas="+id_data_berkas,
success:function(data){
data_terupload(no_client,no_pekerjaan);    
read_response(data);
}
});    
    
}        
    
$(function(){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>"       
$("#nama_pihak").autocomplete({
minLength:0,
delay:0,
source: function( request, rse ) {
$.ajax({
url: "<?php echo base_url('Data_lama/cari_nama_client') ?>",
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
url:"<?php echo base_url('Data_lama/simpan_pihak_terlibat') ?>",
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

function para_pihak(){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>" ;      

$.ajax({
type:"post",
url:"<?php echo base_url('Data_lama/data_para_pihak/') ?>",
data:"token="+token+"&proses=perizinan&no_pekerjaan="+"<?php echo $this->uri->segment(3) ?>"+"&no_client=<?php echo $static['no_client'] ?>",
success:function(data){
$(".para_pihak").html(data);
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
url:"<?php echo base_url('Data_lama/form_edit_client') ?>",
data:"token="+token+"&no_client="+no_client,
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
url  : "<?php echo base_url("Data_lama/update_client") ?>",
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
});

function update_pekerjaan(){
$(".update_pekerjaan").attr("disabled", true);
$("#form_update_pekerjaan").find(".form-control").removeClass("is-invalid").addClass("is-valid");
$('.form-control + p').remove();
$.ajax({
url  : "<?php echo base_url("Data_lama/update_pekerjaan") ?>",
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
url :"<?php echo base_url('Data_lama/update_selesaikan_pekerjaan') ?>",
success:function(data){
read_response(data);
window.location.href="<?php echo base_url('data_lama/DataArsipSelesai') ?>";
}

});
}

function tampilkan_form_utama(no_client,no_pekerjaan){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>"       
$.ajax({
type:"post",
url:"<?php echo base_url('Data_lama/tampilkan_form_utama') ?>",
data:"token="+token+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
success:function(data){
$(".modal-content").html(data);    
$('#data_modal').modal('show');
tanggal_akta();

}
});
}



function hapus_perizinan(no_berkas_perizinan,no_client,no_pekerjaan){
var token    = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",	
url:"<?php echo base_url('Data_lama/hapus_perizinan') ?>",	
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
url:"<?php echo base_url('Data_lama/upload_utama') ?>",
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
});
}


function hapus_utama(id_data_dokumen_utama,no_client,no_pekerjaan){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
Swal.fire({
title: 'Anda yakin',
text: "file akan dihapus secara permanen",
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
url:"<?php echo base_url('Data_lama/hapus_file_utama') ?>",
success:function(data){
read_response(data);
tampilkan_form_utama(no_client,no_pekerjaan);

}
});
}
})

}

function download_utama(id_data_dokumen_utama){
window.location.href="<?php echo base_url('Data_lama/download_utama/') ?>"+btoa(id_data_dokumen_utama);
}



function hapus_keterlibatan(no_client,no_pekerjaan){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('Data_lama/hapus_keterlibatan') ?>",
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
url:"<?php echo base_url('Data_lama/form_persyaratan') ?>",
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
url:"<?php echo base_url('Data_lama/simpan_meta') ?>",
success:function(data){
data_terupload(no_client,no_pekerjaan);
}
});
}
function form_edit_meta(no_client,no_pekerjaan,no_berkas,no_nama_dokumen){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";

$.ajax({
type:"post",
data:"token="+token+"&no_client="+no_client+"&no_berkas="+no_berkas+"&no_nama_dokumen="+no_nama_dokumen+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('Data_lama/form_edit_meta') ?>",
success:function(data){
$(".data"+no_berkas).slideDown().after(data); 
$(".btn_edit"+no_berkas).hide();  
regis_js();
}
});
}
function update_meta(no_berkas,no_nama_dokumen,no_client,no_pekerjaan){
var data = $("#form"+no_berkas).serialize();

$.ajax({
type:"post",
data:$("#form"+no_berkas).serialize(),
url:"<?php echo base_url('Data_lama/update_meta') ?>",
success:function(data){
$(".data_edit"+no_berkas).slideUp().html(""); 
$(".btn_edit"+no_berkas).show();  
read_response(data);
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
url:"<?php echo base_url('Data_lama/upload_berkas') ?>",
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

        var Percentage = (current * 100)/max;
        console.log(Percentage);
        $(".progress").show();
        $(".progress-bar").css({'width': +Percentage+'%'});

        if(Percentage >= 100){
        
       }
    }  
 }
function data_terupload(no_client,no_pekerjaan){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('Data_lama/data_terupload') ?>",
success:function(data){
$(".data_terupload").html(data);    
}
});
}



function set_jenis_dokumen(no_client,no_pekerjaan,no_berkas){
var no_nama_dokumen = $(".no_berkas"+no_berkas +" option:selected").val();

var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_nama_dokumen="+no_nama_dokumen+"&no_berkas="+no_berkas,
url:"<?php echo base_url('Data_lama/set_jenis_dokumen') ?>",
success:function(data){
data_terupload(no_client,no_pekerjaan);
}
});

}
function cancel_edit(no_berkas){
$(".data_edit"+no_berkas ).slideUp().html();
$(".btn_edit"+no_berkas).show();  
}

function simpan_lampiran(no_client,no_pekerjaan){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";

$.ajax({
type:"post",
data:"token="+token+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('data_lama/simpan_lampiran') ?>",
success:function(data){
data_terupload(no_client,no_pekerjaan);
}
});
}

function lihat_berkas_client(no_client){
window.location.href="<?php echo base_url('data_lama/lihat_berkas_client/') ?>"+btoa(no_client);
}


function lihat_lampiran_client(no_client){
window.location.href="<?php echo base_url('data_lama/lihat_lampiran_client/') ?>"+btoa(no_client);
}


</script>    



