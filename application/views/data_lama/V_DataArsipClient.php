<body>
<?php $this->load->view('umum/data_lama/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/data_lama/V_navbar_data_lama'); ?>

<?php echo $this->breadcrumbs->show(); ?>
<div class='container'>

<div class="container mt-2">
<div class="row">    
<div class="col ">
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
    <a href="<?php echo base_url('Data_lama/BuatArsip') ?>"><button class='btn btn-block btn-info'>Tambahkan Pekerjaan</button></a>
    </div>
</div>

<?php } else { ?>    
<table class="table text-dark  table-bordered text-center table-striped ">
<tr class='bg-info text-center  text-white'>
<td colspan='6'>Data Pekerjaan Dalam Tahapan Proses Persyaratan Dokumen Penunjang </td>
</tr>
<tr >
<th>No</th>
<th>No Pekerjaan</th>
<th>Nama client</th>
<th>Jenis Pekerjaan</th>
<th class="text-center">Target selesai</th>
<th>Aksi</th>
</tr>
<?php $no=1; foreach ($query->result_array() as $data){ ?> 
<tr>
<td ><?php echo $no++ ?></td>
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
<button onclick="tambahkan_kedalam_proses('<?php echo base64_encode($data['no_pekerjaan']) ?>');" class="btn btn-sm btn-dark" title="Proses Arsip">Proses Arsip <span class="fa fa-retweet"></span></button>    
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
   
  


</div>

<script type="text/javascript">
function tambahkan_kedalam_proses(no_pekerjaan){
  var token             = "<?php echo $this->security->get_csrf_hash() ?>";    
$.ajax({
type:"post",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('data_lama/TambahkanProsesArsip') ?>",
success:function(data){
read_response(data);
window.location.href="<?php echo base_url('data_lama/DataArsipProses') ?>";
}
});    
}

</script>        
    
</body>
