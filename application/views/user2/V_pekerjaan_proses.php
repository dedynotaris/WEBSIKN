<body>
<?php $this->load->view('umum/user2/V_sidebar_user2'); ?>
<div id="page-content-wrapper">
<?php $this->load->view('umum/user2/V_navbar_user2'); ?>
<?php echo $this->breadcrumbs->show(); ?>

<div class="container-fluid">



<div class="row">    
<div class="col mt-2">
<?php if($query->num_rows() == 0){ ?>    
  <div class="col-12 d-flex justify-content-center text-center" >
  <div class='text-center mt-5'>
    <svg class='text-info m-5' width="9em" height="9em" viewBox="0 0 16 16" class="bi bi-emoji-frown" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
      <path fill-rule="evenodd" d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.498 3.498 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.498 4.498 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683z"/>
      <path d="M7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
    </svg>
    <br>
    Data Tidak Ditemukan Silahkan Tambahkan Data Pekerjaan Terlebih Dahulu
    <br>
    <a href="<?php echo base_url('User2/buat_pekerjaan') ?>"><button class='btn btn-block btn-info'>Tambahkan Pekerjaan</button></a>
    </div>
</div>

<?php } else { ?>    
<table class="table table-striped table-bordered ">
<tr class='bg-info text-center  text-white'>
<td colspan='6'>Data Pekerjaan Dalam Tahapan Proses Pembuatan Dokumen Penunjang </td>
</tr>
 <tr >
<th>No</th>
<th>No Pekerjaan</th>
<th>Nama client</th>
<th>Jenis Pekerjaan</th>
<th class="text-center">Target selesai</th>
<th>Aksi</th>
</tr>
<?php $h=1; foreach ($query->result_array() as $data){ ?> 
<tr>
<td ><?php echo $h++ ?></td>
<td ><?php echo $data['no_pekerjaan'] ?></td>
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

<button onclick="tambahkan_kedalam_proses('<?php echo base64_encode($data['no_pekerjaan']) ?>');" class="btn btn-sm btn-dark" title="Proses Perizinan"><span class="fa fa-retweet"></span></button>    
<button onclick="buat_laporan('<?php echo base64_encode($data['no_pekerjaan']) ?>')" class="btn btn-sm btn-dark" title="Buat Laporan"><span class="fa fa-pencil-alt"></span></button>    
<button onclick="lihat_laporan('<?php echo base64_encode($data['no_pekerjaan']) ?>')" class="btn btn-sm btn-dark" title="Lihat Laporan"><i class="far fa-clipboard"></i></button>    
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
        <div class="modal-header bg-info text-white">
            <h6>Buat Laporan Proses Pekerjaan <span class="laporan_client"></span></h6>  
        </div>   
      <div class="modal-body">
          <input class="no_pekerjaan" value="" type="hidden">
          <input class="id_data_pekerjaan" value="" type="hidden">
          <textarea class="form-control laporan" rows="5" placeholder="Masukan laporan proses pekerjaan"></textarea>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-dark btn-sm btn-block simpan_progress">Simpan Laporan <span class="fa fa-save"></span> </button>
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
