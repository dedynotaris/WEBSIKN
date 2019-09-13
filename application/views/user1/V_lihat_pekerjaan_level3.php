<body>
<?php  $this->load->view('umum/V_sidebar_user1'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar_user1'); ?>
<?php $kar = $data->row_array(); ?>
<div class="container-fluid ">
<div class="text-theme1 mt-2 text-center ">
<h5 align="center">Data pekerjaan <?php echo base64_decode($this->uri->segment(4)) ?>  </h5>
</div>    

<div class="row mt-2">
<div class="col">
<table class="table text-theme1 table-sm table-bordered table-striped  table-condensed">
<tr>
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
if($d['target_selesai_perizinan'] == date('Y/m/d')){
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
<button onclick="lihat_laporan('<?php echo base64_encode($d['no_berkas_perizinan']) ?>');" class="btn btn-success btn-sm" title="Lihat laporan"><i class="far fa-clipboard"></i></button>
<button onclick="lihat_data_perekaman('<?php echo $d['no_nama_dokumen'] ?>','<?php echo $d['no_client'] ?>')" class="btn btn-success btn-sm" title="Lihat Dokumen"><i class="far fa-eye"></i></span></button>
   

</td>
</tr>
<?php } ?>    


</table>    
</div>    
</div>
</div>
<div class="modal fade" id="data_laporan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content">
<div class="modal-body data_laporan">

</div>

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
function lihat_data_perekaman(no_nama_dokumen,no_client){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_nama_dokumen="+no_nama_dokumen+"&no_client="+no_client,
url:"<?php echo base_url('User1/data_perekaman') ?>",
success:function(data){
$(".data_perekaman").html(data);    
$('#data_perekaman').modal('show');
}

});
}
</script>
</html>
