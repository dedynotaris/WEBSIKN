<body>
<?php  $this->load->view('umum/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar_data_lama'); ?>
<div class="container-fluid ">
<div class="mt-2  text-center  ">
<h5 align="center " class="text-theme1"><span class="fa-2x fas fa-pencil-alt "></span><br>Tambahkan data arsip</h5>
</div>
    
    
    <div class="row card-header m-2">
<form id="form_data_lama">
        <div class="col-md-6">    
<label>Nama Pekerjaan</label>
<input type="text" placeholder="Nama Pekerjaan" name="jenis_pekerjaan" id="jenis_pekerjaan" class="form-control form-control-sm jenis_pekerjaan required" accept="text/plain" aria-describedby="basic-addon2">
<input type="hidden" name="no_jenis_pekerjaan" class="form-control form-control-sm no_jenis_pekerjaan required" accept="text/plain" aria-describedby="basic-addon2">

<label>Nama Notaris</label>
<select onchange="tambah_no_user();" name="no_user_pembuat"  id="no_user_pembuat" class="form-control form-control-sm no_user_pembuat required" accept="text/plain">
    <option></option>
<?php 
foreach ($nama_notaris->result_array() as $nama){
echo "<option value=".$nama['no_user'].">".$nama['nama_lengkap']."</option>";    
}
?>
</select>
<input type="hidden" name="nama_notaris" id="nama_notaris" class="form-control form-control-sm nama_notaris required" accept="text/plain" aria-describedby="basic-addon2">

<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash(); ?>" readonly="" class="required"  accept="text/plain">
<label>Pilih Jenis client</label>
<select name="jenis_client" id="jenis_client" class="form-control form-control-sm required" accept="text/plain">
<option></option>
<option value="Perorangan">Perorangan</option>
<option value="Badan Hukum">Badan Hukum</option>	
</select>    

<label>Nama client</label>
<input type="text" placeholder="Nama Pihak" name="nama_pihak" id="nama_pihak" class="form-control form-control-sm required"  accept="text/plain">
<input type="hidden" id="no_client" name="no_client" class="form-control">


<label>Jenis client yang bisa dihubungi</label>
<select name="jenis_kontak" id="jenis_kontak" class="form-control form-control-sm required" accept="text/plain">
<option></option>
<option value="Staff">Staff</option>
<option value="Pribadi">Pribadi</option>	
</select>  
</div>

<div class="col-md-6">
<label>Nama client yang bisa dihubungi</label>
<input type="text" placeholder="Kontak yang bisa dihubungi" class="form-control form-control-sm required" id="contact_person" name="contact_person" accept="text/plain">

<label>Nomor Kontak Telephone / HP </label>
<input type="text" placeholder="Nomor Kontak Telephone  / HP" class="form-control form-control-sm required" id="contact_number" name="contact_number" accept="text/plain">

<label >Alamat Client</label>
<textarea  rows="7" name="alamat" placeholder="Alamat Pihak" id="alamat" class="form-control form-control-sm required" required="" accept="text/plain"></textarea>
<hr>

<button type="button" onclick="simpan_pihak();" class="btn btn-sm btn-success btn-block"> Buat Berkas Arsip</button>
            
</div>        
</form>        
</div>                
</div>
</div>    
    
</body>
<script type="text/javascript">
function tambah_no_user(){
var nama_notaris = $(".no_user_pembuat option:selected").text();
$("#nama_notaris").val(nama_notaris);
}    
    
$(function(){
var <?php echo $this->security->get_csrf_token_name();?>  = "<?php echo $this->security->get_csrf_hash(); ?>"       
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
$("#alamat").val(ui.item.alamat_pihak).attr('readonly', true);
$("#jenis_kontak option[value='"+ui.item.jenis_kontak+"']").attr("selected","selected");
$("#jenis_kontak").attr('readonly', true);
$("#contact_person").val(ui.item.contact_person).attr('readonly', true);
$("#contact_number").val(ui.item.contact_number).attr('readonly', true);
}else{
$("#no_client").attr('readonly', false).val("");
$("#alamat").attr('readonly', false).val("");
$("#jenis_kontak option[value='"+ui.item.jenis_kontak+"']").attr("selected","selected");
$("#jenis_kontak").attr('readonly', false).val("");
$("#contact_person").attr('readonly', false).val("");
$("#contact_number").attr('readonly', false).val("");
}
}
});
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

function simpan_pihak(){
$("#form_data_lama").find(".form-control").removeClass("is-invalid").addClass("is-valid");
$("#form_data_lama").find('.form-control + p').remove();
$.ajax({
type:"post",
data:$("#form_data_lama").serialize(),
url:"<?php echo base_url('Data_lama/buat_arsip') ?>",
success:function(data){
var r  = JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key, value){
$("#form_data_lama").find("#"+key).addClass("is-invalid").after("<p class='"+key+"alert text-danger'>"+value+"</p>");
$("#form_data_lama").find("#"+key).removeClass("is-valid");
});
});
}else{
read_response(data);
$("#form_pihak_terlibat").find(".form-control").val("").attr('readonly', false).removeClass("is-valid");

}
}

});
}    
</script>    