<body>
<?php $this->load->view('umum/data_lama/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/data_lama/V_navbar_data_lama'); ?>
<?php  $this->load->view('umum/data_lama/V_data_data_lama'); ?>
<div class="container-fluid ">
<div class="mt-2  text-center  ">
<h5 align="center " class="text-theme1"><span class="fa-2x fas fa-inbox "></span><br>Arsip Masuk</h5>
</div>

<div class="row">    
<div class="col mt-2">
<?php if($query->num_rows() == 0){ ?>    
<h5 class="text-center text-theme1">Pekerjaan arsip masuk belum tersedia<br>
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
<button onclick="tambahkan_kedalam_proses('<?php echo base64_encode($data['no_pekerjaan']) ?>');" class="btn btn-sm btn-success" title="Proses Arsip">Proses Arsip <span class="fa fa-retweet"></span></button>    
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
}
});    
}

</script>        
    
</body>
