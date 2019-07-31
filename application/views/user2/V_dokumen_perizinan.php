<div class="row">
<div class="col-md-5 card-header m-2 mx-auto">
<label>Pilih jenis file perizinan</label>       

<select onchange="jenis_file_perizinan();" class="form-control file_perizinan">
<option>-- Klik untuk lihat jenis perizinan --</option>
<?php foreach ($data->result_array() as $persyaratan) { ?>
<option value="<?php echo $persyaratan['no_nama_dokumen'] ?>"><?php echo $persyaratan['nama_dokumen'] ?></option>
<?php } ?>
</select>

</div>
</div>
<div class="data_form_perizinan m-2 p-2"></div>
<!-------------------modal laporan--------------------->
<div class="modal fade" id="modal_laporan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-body data_laporan">

</div>
</div>
</div>
</div>

<script type="text/javascript">
function jenis_file_perizinan(){
var no_nama_dokumen = $(".file_perizinan option:selected").val();     
var token           = "<?php echo $this->security->get_csrf_hash() ?>";
var no_pekerjaan    = "<?php echo $this->uri->segment(3) ?>";   
$.ajax({
type:"post",
url:"<?php echo base_url('User2/simpan_perizinan') ?>",
data:"token="+token+"&no_nama_dokumen="+no_nama_dokumen+"&no_pekerjaan="+no_pekerjaan,
success:function(data){
var r = JSON.parse(data);
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 4000,
animation: false,
customClass: 'animated zoomInDown'
});

Toast.fire({
type: r.status,
title: r.pesan
});

refresh();    
}

});
$(".file_perizinan").prop('selectedIndex',0);

}

function refresh(){
form_perizinan();
persyaratan_telah_dilampirkan();
}

function form_perizinan(){
var token           = "<?php echo $this->security->get_csrf_hash() ?>";
var no_pekerjaan    = "<?php echo $this->uri->segment(3) ?>";   
$.ajax({
type:"post",
url:"<?php echo base_url('User2/form_perizinan') ?>",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan,
success:function(data){
$(".data_form_perizinan").html(data);    
}

});    
}


function option_aksi(no_berkas_perizinan,no_nama_dokumen,no_pekerjaan){
var val = $(".option_aksi"+no_berkas_perizinan).val();

if(val == 1){
hapus_syarat(no_berkas_perizinan);    
}else if(val == 2){
$('.tentukan_pengurus'+no_berkas_perizinan).removeAttr("disabled");
}else if(val == 3){
lihat_progress_perizinan(no_berkas_perizinan);
}else if(val == 4){
lihat_data_perekaman(no_nama_dokumen,no_pekerjaan);
}
$(".option_aksi"+no_berkas_perizinan).prop('selectedIndex',0);
}

function tentukan_pengurus(no_berkas_perizinan){
var no_user  = $(".tentukan_pengurus"+no_berkas_perizinan+" option:selected").val();
var token     = "<?php echo $this->security->get_csrf_hash() ?>";
if(no_user !=''){
$.ajax({
type:"post",
url:"<?php echo base_url('User2/simpan_pekerjaan_user') ?>",
data:"token="+token+"&no_user="+no_user+"&no_berkas_perizinan="+no_berkas_perizinan,
success:function(data){
refresh();
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



function hapus_syarat(no_berkas_perizinan){
var token    = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",	
url:"<?php echo base_url('User2/hapus_syarat') ?>",	
data:"token="+token+"&no_berkas_perizinan="+no_berkas_perizinan,
success:function(data){	
refresh(); 
}
});
}

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



function download_berkas(id_data_berkas){
window.location.href="<?php echo base_url('User3/download_berkas/') ?>"+id_data_berkas;
}


function download(id_data_berkas){
window.location.href="<?php echo base_url('User3/download_berkas/') ?>"+id_data_berkas;
}



    
function update_selesaikan_pekerjaan(no_pekerjaan){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('User2/update_selesaikan_pekerjaan') ?>",
success:function(data){
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
</script>