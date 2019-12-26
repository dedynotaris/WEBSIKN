<body>
<?php  $this->load->view('umum/data_lama/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/data_lama/V_navbar_data_lama'); ?>
<?php  $this->load->view('umum/data_lama/V_data_data_lama'); ?>
<div class="container-fluid ">
<div class="mt-2  text-center  ">
<h5 align="center " class="text-theme1"><span class="fa-2x fas fa-pencil-alt "></span><br>Tambahkan data arsip</h5>
</div>


<form id="form_data_lama">
<div class="row card-header m-2">
<div class="col">
<input type="hidden" name="nama_notaris" id="nama_notaris" class="form-control form-control-sm nama_notaris required" accept="text/plain" aria-describedby="basic-addon2">

<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash(); ?>" readonly="" class="required"  accept="text/plain">
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


<label>Jenis Pekerjaan</label>
<select name='jenis_pekerjaan' id='jenis_pekerjaan' class="form-control form-control-sm  jenis_pekerjaan"></select>
</div>

<div class="col">
<label>Nama Notaris</label>
<select onchange="tambah_no_user();" name="no_user_pembuat"  id="no_user_pembuat" class="form-control form-control-sm no_user_pembuat required" accept="text/plain">
<option></option>
<?php 
foreach ($nama_notaris->result_array() as $nama){
echo "<option value=".$nama['no_user'].">".$nama['nama_lengkap']."</option>";    
}
?>
</select>

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
<hr>

<button type="button" onclick="simpan_pihak();" class="btn btn-sm btn-success btn-block"> Buat Berkas Arsip</button>

</div>        
</form>        
</div>                
</div>
</div>    

</body>
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
window.location.href='<?php echo base_url('Data_lama/') ?>';

}
}

});
}    
</script>    