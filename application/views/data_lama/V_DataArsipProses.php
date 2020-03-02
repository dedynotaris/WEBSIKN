<body>
<?php $this->load->view('umum/data_lama/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/data_lama/V_navbar_data_lama'); ?>
<?php  $this->load->view('umum/data_lama/V_data_data_lama'); ?>
<div class="container-fluid ">
<div class="mt-2  text-center  ">
<h5 align="center " class="text-theme1"><span class="fa-2x fas fa-arrow-circle-right "></span><br>Arsip Proses</h5>
</div>

<div class="row">    
<div class="col mt-2">
<?php if($query->num_rows() == 0){ ?>    
<h5 class="text-center text-theme1">Pekerjaan arsip proses belum tersedia<br>
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
<button onclick="proses_rekam_data('<?php echo base64_encode($data['no_pekerjaan']) ?>');" class="btn btn-sm btn-success" title="Proses Upload">Upload Dokumen <span class="fa fa-upload"></span></button>    
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
function proses_rekam_data(no_pekerjaan){
window.location.href="<?php echo base_url('data_lama/rekam_data/'); ?>"+no_pekerjaan;
}

</script>        
    
</body>
