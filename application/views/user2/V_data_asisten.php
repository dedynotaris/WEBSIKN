<body>
<?php $this->load->view('umum/user2/V_sidebar_user2'); ?>
<div id="page-content-wrapper">
<?php $this->load->view('umum/user2/V_navbar_user2'); ?>
<?php $this->load->view('umum/user2/V_data_user2'); ?>
<div class="container-fluid text-theme1">
<div class="p-2 mt-2">

<div class="row">
<div class="col">
<h5 align="center"><i class="fa fa-3x fa-users"></i><br>Daftar asisten yang memiliki pekerjaan</h5>
<table class="table text-theme1 table-sm table-bordered  table-condensed table-striped ">
<tr>
<th> Asisten</th>   
<th class="text-center">In</th>   
<th class="text-center">Progress</th>   
<th class="text-center">Out</th>   
</tr>
<?php foreach ($asisten->result_array() as $data){ ?>        
<tr>
<td><?php echo $data['nama_lengkap'] ?></td>
<td class="text-center">
<a href="<?php echo base_url('User2/lihat_pekerjaan_asisten/'.base64_encode($data['no_user_perizinan'])."/".base64_encode('Masuk')) ?>"><span class="badge p-2 badge-primary"><?php echo  $this->db->get_where('data_berkas_perizinan',array('no_user_perizinan'=>$data['no_user_perizinan'],'status_berkas'=>'Masuk'))->num_rows(); ?></span></a>    
</td>
<td class="text-center">
<a href="<?php echo base_url('User2/lihat_pekerjaan_asisten/'.base64_encode($data['no_user_perizinan'])."/".base64_encode('Proses')) ?>"><span class="badge p-2 badge-warning"><?php echo  $this->db->get_where('data_berkas_perizinan',array('no_user_perizinan'=>$data['no_user_perizinan'],'status_berkas'=>'Proses'))->num_rows(); ?></span></a>     
</td>
<td class="text-center">
<a href="<?php echo base_url('User2/lihat_pekerjaan_asisten/'.base64_encode($data['no_user_perizinan'])."/".base64_encode('Selesai')) ?>"><span class="badge p-2 badge-success"><?php echo  $this->db->get_where('data_berkas_perizinan',array('no_user_perizinan'=>$data['no_user_perizinan'],'status_berkas'=>'Selesai'))->num_rows(); ?></span></a>     
</td>
</tr>
<?php }?>        
</table>

</div>

</div>
</div>
</div>
</div>
</div>    

</body>
