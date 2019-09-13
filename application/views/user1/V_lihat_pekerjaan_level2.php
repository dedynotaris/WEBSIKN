<body>
<?php  $this->load->view('umum/V_sidebar_user1'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar_user1'); ?>
<?php $kar = $data->row_array(); ?>
<div class="container-fluid ">
    
<div class="text-theme1 mt-2 text-center ">
<h5 align="center">Data pekerjaan <?php echo base64_decode($this->uri->segment(4)) ?></h5>
</div>
    

<div class="row mt-2">
<div class="col">
<table class="table text-theme1 table-sm table-bordered table-striped  text-center table-condensed">
<tr>
<th>Pekerjaan</th>
<th>Nama client</th>
<th>Pekerjaan</th>
<th>Target selesai</th>
<th>Aksi</th>
</tr>
<?php foreach ($data->result_array() as $d) { ?>
<tr>
<td><?php echo $d['nama_jenis']  ?></td>
<td><?php echo $d['nama_client']  ?></td>
<td>
 <select disabled="" onchange="alihkan_tugas('<?php echo base64_encode($d['no_pekerjaan']) ?>','<?php echo $d['id_data_pekerjaan'] ?>');" class="form-control form-control-sm  pekerjaan<?php echo $d['id_data_pekerjaan'] ?>">    
<option><?php echo $d['pembuat_pekerjaan'] ?></option>
<?php
foreach ($data_user->result_array() as $user){
echo "<option value=".$user['no_user'].">".$user['nama_lengkap']."</option>";

}?>
</select>
</td>   
<td>
<?php
if($d['target_kelar'] == date('Y/m/d')){
echo "<b><span class='text-warning'>Hari ini</span><b>";    
}else if($d['target_kelar'] <= date('Y/m/d')){
$startTimeStamp = strtotime(date('Y/m/d'));
$endTimeStamp = strtotime($d['target_kelar']);
$timeDiff = abs($endTimeStamp - $startTimeStamp);
$numberDays = $timeDiff/86400; 
$numberDays = intval($numberDays);
echo "<b><span class='text-danger'> Terlewat ".$numberDays." Hari </span><b>" ;
}else{
$startTimeStamp = strtotime(date('Y/m/d'));
$endTimeStamp = strtotime($d['target_kelar']);
$timeDiff = abs($endTimeStamp - $startTimeStamp);
$numberDays = $timeDiff/86400; 
$numberDays = intval($numberDays);
echo "<b><span class='text-success'>".$numberDays." Hari lagi </span><b>" ;
}
?> </td>
<td>
<button onclick="lihat_laporan_pekerjaan('<?php echo base64_encode($d['no_pekerjaan']) ?>');" class="btn btn-success btn-sm" title="Lihat laporan"><i class="far fa-clipboard"></i></button>
<button onclick="alihkan_pekerjaan('<?php echo $d['id_data_pekerjaan'] ?>');" class="btn btn-success btn-sm" title="Alihkan pekerjaan"><i class="far fa-share-square"></i></button>
<button onclick="lihat_dokumen('<?php echo base64_encode($d['no_pekerjaan']) ?>')" class="btn btn-success btn-sm" title="Lihat Dokumen"><i class="far fa-eye"></i></span></button>

</td>
</tr>
<?php } ?>    


</table>       
</div>    
</div>


</div>    
</div>
</div>
</div>
</div>
    
 <!-------------------modal laporan--------------------->

<div class="modal fade" id="modal_laporan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-body" id="lihat_status_sekarang">

</div>
</div>
</div>
</div>    
<script type="text/javascript">

function lihat_dokumen(no_pekerjaan){
window.location.href ="<?php echo base_url('User1/berkas_dikerjakan/') ?>"+no_pekerjaan;    
}

function alihkan_pekerjaan(id_data_pekerjaan){
$('.pekerjaan'+id_data_pekerjaan).removeAttr("disabled");
}

function alihkan_tugas(no_pekerjaan,id_data_pekerjaan){
$('.pekerjaan'+id_data_pekerjaan).attr("disabled",true);
var no_user             = $(".pekerjaan"+id_data_pekerjaan+" option:selected").val();
var pembuat_pekerjaan   = $(".pekerjaan"+id_data_pekerjaan+" option:selected").text();
var token               = "<?php echo $this->security->get_csrf_hash() ?>";

$.ajax({
type:"post",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan+"&no_user="+no_user+"&pembuat_pekerjaan="+pembuat_pekerjaan,
url:"<?php echo base_url('User1/alihkan_pekerjaan') ?>",
success:function(data){
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
}).then(function() {
window.location.href = "<?php echo base_url('User1/lihat_karyawan'); ?>";
});
}

});
}
function lihat_laporan_pekerjaan(no_pekerjaan){
$('#modal_laporan').modal('show');
var token           = "<?php echo $this->security->get_csrf_hash() ?>";
    
$.ajax({
type:"post",
url:"<?php echo base_url('User1/lihat_laporan_pekerjaan') ?>",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan,
success:function(data){
$("#lihat_status_sekarang").html(data);
}

});
}


</script>   
</html>
