<body>
<?php  $this->load->view('umum/user1/V_sidebar_user1'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/user1/V_navbar_user1'); ?>
<?php  $this->load->view('umum/user1/V_data_user1'); ?>
<div class="container-fluid ">

<div class="mt-2  text-center  ">
<h5 align="center " class="text-info"><span class="fa-2x fa fa-users "></span><br>Daftar Asisten Notaris</h5>
</div>
    
    
<div class="row  m-1">
<table class="table table-striped ">
    <tr class="text-center text-info">
<th rowspan="3" class="align-middle">Nama karyawan</th>   
<th class="text-center" colspan="6">Jenis Dokumen</th>

<tr class="text-center text-info">
<th colspan="3">Dokumen utama</th>    
<th colspan="3">Dokumen Penunjang</th>    
</tr>

<tr class="text-center text-info">
<th>Masuk</th>    
<th>Proses</th>    
<th>Selesai</th>

<th>Masuk</th>    
<th>Proses</th>    
<th>Selesai</th>
</tr>

<?php $h=1; 
foreach ($karyawan->result_array() as $kar){
if($kar['level'] = 'User'){
?>    
<tr>
<td class="text-dark"><?php echo $kar['nama_lengkap'] ?></td>

<!--------- dokumen utama count---------------->
<td class="text-center">
<a href="<?php echo base_url('User1/lihat_pekerjaan/'.base64_encode($kar['no_user'])."/".base64_encode('Masuk')."/". base64_encode("Level 2")) ?>">
<?php $jumlah = $this->db->get_where('data_pekerjaan',array('no_user'=>$kar['no_user'],'status_pekerjaan'=>'Masuk'))->num_rows();
if($jumlah == 0){
echo "<Button disabled class='btn  btn-danger btn-block'>".$jumlah."</Button>";    
}else{
echo "<Button class='btn btn-danger btn-block'>".$jumlah."</Button>";        
}
?>
</a> 
</td>
<td class="text-center">
<a href="<?php echo base_url('User1/lihat_pekerjaan/'.base64_encode($kar['no_user'])."/".base64_encode('Proses')."/". base64_encode("Level 2")) ?>">
<?php $jumlah = $this->db->get_where('data_pekerjaan',array('no_user'=>$kar['no_user'],'status_pekerjaan'=>'Proses'))->num_rows();
if($jumlah == 0){
echo "<Button disabled class='btn  btn-warning btn-block'>".$jumlah."</Button>";    
}else{
echo "<Button class='btn btn-warning btn-block'>".$jumlah."</Button>";        
}
?>
</a>     
</td>
<td class="text-center">
<a href="<?php echo base_url('User1/lihat_pekerjaan/'.base64_encode($kar['no_user'])."/".base64_encode('Selesai')."/". base64_encode("Level 2")) ?>">
<?php $jumlah = $this->db->get_where('data_pekerjaan',array('no_user'=>$kar['no_user'],'status_pekerjaan'=>'Selesai'))->num_rows();
if($jumlah == 0){
echo "<Button disabled class='btn  btn-info btn-block'>".$jumlah."</Button>";    
}else{
echo "<Button class='btn btn-success btn-block'>".$jumlah."</Button>";        
}
?>
</a>     
</td>
<!--------- dokumen perizinan count---------------->
<td class="text-center">
<a href="<?php echo base_url('User1/lihat_pekerjaan/'.base64_encode($kar['no_user'])."/".base64_encode('Masuk')."/". base64_encode("Level 3")) ?>">
<?php $tot =  $this->db->get_where('data_berkas_perizinan',array('no_user_perizinan'=>$kar['no_user'],'status_berkas'=>'Masuk'))->num_rows(); 
if($tot==0){
echo "<Button disabled class='btn  btn-danger btn-block'>".$tot."</Button>";        
}else{
echo "<Button  class='btn  btn-danger btn-block'>".$tot."</Button>";        
}
?>
</a>    
</td>
<td class="text-center">
<a href="<?php echo base_url('User1/lihat_pekerjaan/'.base64_encode($kar['no_user'])."/".base64_encode('Proses')."/". base64_encode("Level 3")) ?>">
<?php $tot =  $this->db->get_where('data_berkas_perizinan',array('no_user_perizinan'=>$kar['no_user'],'status_berkas'=>'Proses'))->num_rows(); 
if($tot==0){
echo "<Button disabled class='btn  btn-warning btn-block'>".$tot."</Button>";        
}else{
echo "<Button  class='btn  btn-warning btn-block'>".$tot."</Button>";        
}
?>
</a>
</td>
<td class="text-center">
<a href="<?php echo base_url('User1/lihat_pekerjaan/'.base64_encode($kar['no_user'])."/".base64_encode('Selesai')."/". base64_encode("Level 3")) ?>">
<?php $tot =  $this->db->get_where('data_berkas_perizinan',array('no_user_perizinan'=>$kar['no_user'],'status_berkas'=>'Selesai'))->num_rows(); 
if($tot==0){
echo "<Button disabled class='btn  btn-info btn-block'>".$tot."</Button>";        
}else{
echo "<Button class='btn  btn-info btn-block'>".$tot."</Button>";        
}
?>
</a>      
</td>

</tr>

<?php }} ?>
</table>   
</div>   
</script>    
</html>
