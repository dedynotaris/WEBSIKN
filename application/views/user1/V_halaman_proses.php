<body >
<?php  $this->load->view('umum/V_sidebar_user1'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar_user1'); ?>
<div class="container-fluid text-theme1">
<div class=" mt-2 text-center ">
<h5 align="center"><i class="fa fa-3x fa-retweet"></i><br>Pekerjaan diproses
</h5>
</div>


<div class="row mt-2">
<div class="col">    
<table class="table text-theme1 table-sm table-bordered table-striped table-hover">
<tr>
<th>Nama Client</th>
<th>Pembuat Client</th>
<th>Tanggal dibuat</th>
<th>Target selesai</th>
</tr>       
<?php foreach ($data_tugas->result_array() as    $data){  ?>
<tr>        
<td><?php echo $data['nama_client'] ?></td>
<td><?php echo $data['pembuat_client'] ?></td>   
<td><?php echo $data['tanggal_dibuat'] ?></td>
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
?> 
</tr>
<?php } ?>



</table>    

    </div>
</div>
</div>
</div>

</body>
</html>
