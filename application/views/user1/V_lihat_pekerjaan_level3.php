<body>
<?php  $this->load->view('umum/V_sidebar_user1'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar_user1'); ?>
<?php $kar = $data->row_array(); ?>
<div class="container-fluid ">
<div class="card-header mt-2 text-center ">
<h5 align="center">Data pekerjaan <?php echo base64_decode($this->uri->segment(4)) ?>  </h5>
</div>    

<div class="row mt-2">
<div class="col">
<table class="table table-sm table-bordered table-striped  table-condensed">
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
<td><?php echo $d['target_selesai_perizinan']  ?></td>
<td>
<select onchange="opsi('<?php echo $d['no_berkas_perizinan'] ?>','<?php echo $d['no_nama_dokumen'] ?>','<?php echo $d['no_pekerjaan'] ?>')" class="form-control aksi<?php echo $d['no_berkas_perizinan'] ?>">
    <option >-- Klik untuk melihat menu --</option>
    <option value="1">Lihat laporan</option>
    <option value="2">Rekaman Data</option>
</select>
</td>
</tr>
<?php } ?>    


</table>    
</div>    
</div>
</div>
<div class="modal fade" id="data_laporan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
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
function lihat_data_perekaman(no_nama_dokumen,no_pekerjaan){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_nama_dokumen="+no_nama_dokumen+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('User1/data_perekaman') ?>",
success:function(data){
$(".data_perekaman").html(data);    
$('#data_perekaman').modal('show');
}

});
}
</script>
</html>
