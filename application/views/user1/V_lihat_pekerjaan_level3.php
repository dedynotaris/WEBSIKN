<body>
<?php  $this->load->view('umum/user1/V_sidebar_user1'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/user1/V_navbar_user1'); ?>
<?php  $this->load->view('umum/user1/V_data_user1'); ?>
<?php $kar = $data->row_array(); ?>
<div class="container-fluid ">
<div class="text-info mt-2 text-center ">
<h5 align="center">Data pekerjaan <?php echo base64_decode($this->uri->segment(4)) ?>  </h5>
</div>    

<div class="row mt-2">
<div class="col">
<table class="table table-striped  ">
    <tr class="text-info">
<th>Nama Tugas</th>
<th>Nama client</th>
<th>Status</th>
<th>Target selesai</th>
<th>Aksi</th>
</tr>
<?php foreach ($data->result_array() as $d) { ?>
<tr>
<td><?php echo $d['nama_dokumen']  ?></td>
<td><?php echo $d['nama_client']  ?></td>
<td><?php echo $d['status_berkas']  ?></td>
<td>
<?php
if($d['target_selesai_perizinan'] == NULL){
echo "<b><span class='text-dark'>Belum tersedia</span><b>";    
}else if($d['target_selesai_perizinan'] == date('Y/m/d')){
echo "<b><span class='text-warning'>Hari ini</span><b>";    
}else if($d['target_selesai_perizinan'] <= date('Y/m/d')){
$startTimeStamp = strtotime(date('Y/m/d'));
$endTimeStamp = strtotime($d['target_selesai_perizinan']);
$timeDiff = abs($endTimeStamp - $startTimeStamp);
$numberDays = $timeDiff/86400; 
$numberDays = intval($numberDays);
echo "<b><span class='text-danger'> Terlewat ".$numberDays." Hari </span><b>" ;
}else{
$startTimeStamp = strtotime(date('Y/m/d'));
$endTimeStamp = strtotime($d['target_selesai_perizinan']);
$timeDiff = abs($endTimeStamp - $startTimeStamp);
$numberDays = $timeDiff/86400; 
$numberDays = intval($numberDays);
echo "<b><span class='text-success'>".$numberDays." Hari lagi </span><b>" ;
}
?> </td>
<td class="text-center">
<button onclick="lihat_laporan('<?php echo base64_encode($d['no_berkas_perizinan']) ?>');" class="btn btn-dark btn-sm" title="Lihat laporan"> Laporan Perizinan <i class="far fa-clipboard"></i></button>
<?php if(base64_decode($this->uri->segment(4)) == 'Selesai'){ ?>
<button onclick="lihat_data_perekaman('<?php echo $d['no_berkas'] ?>','<?php echo base64_encode($d['no_berkas_perizinan']) ?>')" class="btn btn-dark btn-sm" title="Lihat Dokumen">Lihat Perizinan <i class="far fa-eye"></i></button>
<?php }?>   

</td>
</tr>
<?php } ?>    


</table>    
</div>    
</div>
</div>
<div class="modal fade" id="data_laporan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document">
<div class="modal-content  data_laporan">


</div>
</div>
</div>
    <div class="modal fade" id="data_perekaman" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl" role="document">
<div class="modal-content ">
<div class="modal-header bg-info text-white">
<h6 class="modal-title" id="exampleModalLabel text-center">Dokumen Hasil Perizinan<span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>

<div class="modal-body ">
    <div class="embed-responsive embed-responsive-16by9 data_perekaman">
        
    </div>

</div>
</div>
</div>
</div>
<script type="text/javascript">
function opsi(no_berkas_perizinan,no_nama_dokumen,no_pekerjaan){
var val = $(".aksi"+no_berkas_perizinan+" option:selected").val();

if(val == 1){
lihat_laporan(no_berkas_perizinan);    
}else if(val == 2){
lihat_data_perekaman(no_nama_dokumen,no_pekerjaan);    
}

$(".aksi"+no_berkas_perizinan).prop('selectedIndex',0);

}
function lihat_laporan(no_berkas_perizinan){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_berkas_perizinan="+no_berkas_perizinan,
url:"<?php echo base_url('User1/lihat_laporan') ?>",
success:function(data){
$('#data_laporan').modal('show'); 
$(".data_laporan").html(data);
}

});
        
}


</script> 

<script type="text/javascript">
function lihat_data_perekaman(no_berkas,no_berkas_perizinan){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_berkas="+no_berkas+"&no_berkas_perizinan="+no_berkas_perizinan,
url:"<?php echo base_url('User1/data_perekaman') ?>",
success:function(data){
var r = JSON.parse(data);
if(r[0].status == 'Dokumen Lihat'){
$("#judul").html(r[0].titel);
$(".data_perekaman").html(r[0].link);
$('#data_perekaman').modal('show');
}else{
window.location.href=r[0].link;
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated zoomInDown'
});

Toast.fire({
type: 'success',
title: r[0].messages,
});
}
}

});
}
</script>
</html>
