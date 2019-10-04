<body onload="refresh()">
<?php $this->load->view('umum/user2/V_sidebar_user2'); ?>
<div id="page-content-wrapper">
<?php $this->load->view('umum/user2/V_navbar_user2'); ?>
<?php $this->load->view('umum/user2/V_data_user2'); ?>
<?php $static = $query->row_array(); ?>
<div class="container text-theme1">    
<div class="card-header text-theme1 mt-2 mb-2 text-center">
LENGKAPI PERSYARATAN DOKUMEN <?php echo $static['nama_client'] ?>
<button class="btn btn-success btn-sm float-md-right "  onclick="lanjutkan_proses_perizinan('<?php echo $this->uri->segment(3) ?>');">Lanjutkan keproses perizinan <span class="fa fa-exchange-alt"></span></button>
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
<label>Alamat client</label><br>    

</div>
<div class="col"> :
<?php echo $static['alamat_client'] ?>        
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
<?php echo $static['target_kelar'] ?>        
</div>
</div>    
</div>

</div>
    
<!-----------------------------PIHAK2 YANG TERLIBAT--------------------------------------------------->    
<div class="card-header text-theme1 mt-2 mb-2 text-center">Daftar Pihak-pihak yang terlibat
</div>
<form id="form_pihak_terlibat">
<div class=" card-header" >
<div class="row">
<div class="col-md-5">    
<div style="max-height:250px; " class="col overflow-auto">
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash(); ?>" readonly="" class="required"  accept="text/plain">
<input type="hidden" name="no_pekerjaan" value="<?php echo $this->uri->segment(3) ?>" readonly="" class="required"  accept="text/plain">   
<label>Selaku Pihak</label>
<select name="selaku_pihak" id="selaku_pihak"  class="form-control form-control-sm">
<option>Direktur</option>    
<option>Komisaris</option>    
<option>Pemegang Saham</option>    
<option>Kreditur</option>    
<option>Debitur</option>    

</select>   
    
<label>Pilih Jenis pihak</label>
<select name="jenis_client" id="jenis_client" class="form-control form-control-sm required" accept="text/plain">
<option></option>
<option value="Perorangan">Perorangan</option>
<option value="Badan Hukum">Badan Hukum</option>	
</select>    

<label>Nama Pihak</label>
<input type="text" placeholder="Nama Pihak" name="nama_pihak" id="nama_pihak" class="form-control form-control-sm required"  accept="text/plain">
<input type="hidden" id="no_client" name="no_client" class="form-control">

<label >Alamat Pihak</label>
<textarea name="alamat_pihak" rows="6" placeholder="Alamat Pihak" id="alamat_pihak" class="form-control form-control-sm required" required="" accept="text/plain"></textarea>

<label>Jenis pihak yang bisa dihubungi</label>
<select name="jenis_kontak" id="jenis_kontak" class="form-control form-control-sm required" accept="text/plain">
<option></option>
<option value="Staff">Staff</option>
<option value="Pribadi">Pribadi</option>	
</select>  

<label>Nama pihak yang bisa dihubungi</label>
<input type="text" placeholder="Kontak yang bisa dihubungi" class="form-control form-control-sm required" id="contact_person" name="contact_person" accept="text/plain">
<label>Nomor Kontak Telephone / HP</label>
<input type="text" placeholder="Nomor Kontak Telephone  / HP" class="form-control form-control-sm required" id="contact_number" name="contact_number" accept="text/plain">

</form>
</div>    
<hr>
<button type="button" onclick="simpan_pihak();" class="btn btn-sm btn-success btn-block"> Tambahkan pihak yang terlibat</button>

</div>

<div class="col text-theme1 ">
    <div class="row text-center">
        <div class="col"><b>Nama</div>
        <div class="col">Selaku</div>
        <div class="col">Aksi</b></div>
    </div>
    <div class="para_pihak">
        
    </div>    
    
</div>    
</div>
</div>

<div class="card-header text-theme1 mt-2 mb-2 text-center">Lengkapi form-form dokumen dibawah ini
</div>

<div class=" card-header">
<div class="row">    
<?php 
foreach ($nama_persyaratan->result_array() as $persyaratan){ 
$fm = $this->db->get_where('data_meta',array('no_nama_dokumen'=>$persyaratan['no_nama_dokumen']));    
?>
<div class="col-md-6">
<span class="text-center"><?php echo $persyaratan['nama_dokumen'] ?></span><hr>
<?php
$i = 1;
foreach ($fm->result_array() as $d){

if($d['jenis_inputan'] == 'select'){
$data_option = $this->db->get_where('data_input_pilihan',array('id_data_meta'=>$d['id_data_meta']));   
echo "<label>".$d['nama_meta']."</label>"
."<select id='data_meta".$i++."' name='".$d['nama_meta']."' class='form-control form_meta form-control-sm meta required' required='' accept='text/plain'>";
foreach ($data_option->result_array() as $option){
echo "<option>".$option['jenis_pilihan']."</option>";
}
echo "</select>";
}else if($d['jenis_inputan'] == 'date'){

echo "<label>".$d['nama_meta']."</label>"
."<input  type='text' id='data_meta".$i++."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-sm ".$d['jenis_inputan']." meta required ' required='' accept='text/plain' >";    

}else if($d['jenis_inputan'] == 'number'){
echo "<label>".$d['nama_meta']."</label>"
."<input  type='text' id='data_meta".$i++."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-sm ".$d['jenis_bilangan']." meta required ' required='' accept='text/plain' >";        


}else if($d['jenis_inputan'] == 'textarea'){
echo "<label>".$d['nama_meta']."</label>"
. "<textarea  id='data_meta".$i++."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-sm ".$d['jenis_bilangan']." meta required ' required='' accept='text/plain'></textarea>";


}else{
echo "<label>".$d['nama_meta']."</label>"
."<input  type='".$d['jenis_inputan']."' id='data_meta".$i++."' name='".$d['nama_meta']."' placeholder='".$d['nama_meta']."'  maxlength='".$d['maksimal_karakter']."' class='form-control form_meta form-control-sm  meta required ' required='' accept='text/plain' >";    
}    
}

echo "<label>Lampiran</label>"
. "<input type='file' id='file_berkas' class='form-control'>";
echo "<hr>"
. "<button class='btn btn-sm btn-success '>Simpan dan rekam</button>"
. "<button class='btn btn-sm btn-warning float-right'>Lihat Rekaman</button><hr>";

?>
</div>

<?php } ?>    
</div>
</div>
</div>
</div>

<script type="text/javascript">
    
$(function(){
var <?php echo $this->security->get_csrf_token_name();?>  = "<?php echo $this->security->get_csrf_hash(); ?>"       
$("#nama_pihak").autocomplete({
minLength:0,
delay:0,
source: function( request, rse ) {
$.ajax({
url: "<?php echo base_url('User2/cari_nama_client') ?>",
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
url:"<?php echo base_url('User2/simpan_pihak_terlibat') ?>",
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
var <?php echo $this->security->get_csrf_token_name();?>  = "<?php echo $this->security->get_csrf_hash(); ?>" ;      

$.ajax({
type:"post",
url:"<?php echo base_url('User2/data_para_pihak/') ?>",
data:"token="+token+"&no_pekerjaan="+"<?php echo $this->uri->segment(3) ?>",
    success:function(data){
$(".para_pihak").html(data);
}
});
}

function refresh(){
para_pihak();
}

</script>    



