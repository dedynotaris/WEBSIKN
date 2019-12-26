<body>
<?php $this->load->view('umum/data_lama/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/data_lama/V_navbar_data_lama'); ?>
<?php  $this->load->view('umum/data_lama/V_data_data_lama'); ?>
<div class="container-fluid ">
<div class="mt-2  text-center  ">
<h5 align="center " class="text-theme1"><span class="fa-2x fas fa-box "></span><br>Arsip Selesai</h5>
</div>

<div class="row">    
<div class="col mt-2">
<?php if($query->num_rows() == 0){ ?>    
<h5 class="text-center text-theme1">Pekerjaan arsip selesai belum tersedia<br>
</h5>
<?php } else { ?>    
<table class="table text-theme1 table-hover table-sm text-center table-striped table-bordered">
<tr>
<th>Nama client</th>
<th>Jenis Pekerjaan</th>
<th class="text-center">Target selesai</th>
<th>Aksi</th>
</tr>
<?php foreach ($query->result_array() as $data){ ?> 
<tr>
<td id='nama_client<?php echo $data['id_data_pekerjaan'] ?>'><?php echo $data['nama_client'] ?></td>
<td ><?php echo $data['nama_jenis'] ?></td>
<td><?php
if($data['target_kelar'] == date('Y/m/d')){
echo "<b><span class='text-warning'>Hari ini</span><b>";    
}else if($data['target_kelar'] <= date('Y/m/d')){
$startTimeStamp = strtotime(date('Y/m/d'));
$endTimeStamp = strtotime($data['target_kelar']);
$timeDiff = abs($endTimeStamp - $startTimeStamp);
$numberDays = $timeDiff/86400; 
$numberDays = intval($numberDays);
echo "<b><span class='text-danger'> Terlewat ".$numberDays." Hari </span><b>" ;
}else{
$startTimeStamp = strtotime(date('Y/m/d'));
$endTimeStamp = strtotime($data['target_kelar']);
$timeDiff = abs($endTimeStamp - $startTimeStamp);
$numberDays = $timeDiff/86400; 
$numberDays = intval($numberDays);
echo "<b><span class='text-success'>".$numberDays." Hari lagi </span><b>" ;
}
?></td>
<td>
<button onclick="tambahkan_kedalam_proses('<?php echo base64_encode($data['no_pekerjaan']) ?>');" class="btn btn-sm btn-success" title="Proses Perizinan"><span class="fa fa-retweet"></span></button>    
</td>
</tr>
<?php } ?>
 </table>        
<?php } ?>
</div>
</div>
</div>    
</div>
</div>
<div class="modal fade" id="modal_laporan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h6>Progress <span class="laporan_client"></span></h6>  
        </div>   
      <div class="modal-body">
          <input class="no_pekerjaan" value="" type="hidden">
          <input class="id_data_pekerjaan" value="" type="hidden">
          <textarea class="form-control laporan" placeholder="laporkan progress pekerjaan"></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success btn-sm simpan_progress">Simpan</button>
      </div>
    </div>
  </div>
</div>    
  
<div class="modal fade" id="lihat_laporan" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-body lihat_laporan">
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="lihat_data_meta" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
<div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
<div class="modal-content">
<div class="modal-body lihat_data_meta">
    
</div>
</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
$(".simpan_progress").click(function(){
var laporan             = $(".laporan").val();
var no_pekerjaan        = $(".no_pekerjaan").val();
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan+"&laporan="+laporan,
url:"<?php echo base_url('User2/simpan_progress_pekerjaan') ?>",
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
});
$('#modal_laporan').modal('hide');
$(".laporan").val("");
}
});
    

});    
    
});    
function buat_laporan(no_pekerjaan,id_data_pekerjaan){
$('#modal_laporan').modal('show');
var nama_client = $("#nama_client"+id_data_pekerjaan).text();
$(".laporan_client").text(nama_client);
$(".no_pekerjaan").val(no_pekerjaan);
$(".id_data_pekerjaan").val(id_data_pekerjaan);

}    
     
function lihat_laporan(no_pekerjaan){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";    
$.ajax({
type:"post",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('User2/lihat_laporan_pekerjaan') ?>",
success:function(data){
$('#lihat_laporan').modal('show');
$(".lihat_laporan").html(data);
}
});    
}

function tambahkan_kedalam_proses(no_pekerjaan){
window.location.href = "<?php echo base_url('User2/proses_pekerjaan/'); ?>"+no_pekerjaan;
}

function lihat_data(no_pekerjaan){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";    
$.ajax({
type:"post",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('User2/lihat_data_meta') ?>",
success:function(data){
$('#lihat_data_meta').modal('show');
$(".lihat_data_meta").html(data);
}
});
}
function tampilkan_data(){
var no_pekerjaan = $("#no_pekerjaan").val();
var no_client    = $("#no_client option:selected").val();
var token             = "<?php echo $this->security->get_csrf_hash() ?>";    
$.ajax({
type:"post",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan+"&no_client="+no_client,
url:"<?php echo base_url('User2/tampilkan_data') ?>",
success:function(data){
$(".tampilkan_data").html(data);
var clipboard = new ClipboardJS('button');

clipboard.on('success', function(e) {
  setTooltip(e.trigger, 'Copied!');
  hideTooltip(e.trigger);
});

clipboard.on('error', function(e) {
  setTooltip(e.trigger, 'Failed!');
  hideTooltip(e.trigger);
});
$('button').tooltip({
  trigger: 'click',
  placement: 'bottom'
});

}
});

}


function setTooltip(btn, message) {
  $(btn).tooltip('hide')
    .attr('data-original-title', message)
    .tooltip('show');
}

function hideTooltip(btn) {
  setTimeout(function() {
    $(btn).tooltip('hide');
  }, 1000);
}
</script>        
    
</body>
