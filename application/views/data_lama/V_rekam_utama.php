
<div class="container-fluid mt-2 ">    
<div class="row ">
<div class="col">    
<div class="card-header  text-center text-theme1 ">
Dokumen utama yang sudah diupload

<button class="btn btn-dark btn-sm float-md-right" onclick="tambah_dokumen_utama();">Tambah dokumen utama</button>
</div>
<table class="table text-theme1 table-sm table-striped table-bordered text-center table-hover">
<tr>
<th>nama file</th>
<th>jenis</th>
<th>tanggal akta</th>
<th>aksi</th>
</tr>
<?php foreach ($dokumen_utama->result_array() as $utama){ ?>
<tr>
<td><?php echo $utama['nama_berkas'] ?></td>   
<td><?php echo $utama['jenis'] ?></td>   
<td><?php echo $utama['tanggal_akta'] ?></td>   
<td>
<select class="form-control data_aksi<?php echo $utama['id_data_dokumen_utama'] ?>"  onchange="aksi_utama('<?php echo $utama['id_data_dokumen_utama'] ?>','<?php echo $utama['id_data_dokumen_utama'] ?>');">
<option>-- Klik untuk lihat menu --</option>   
<option value="1">Hapus</option>   
<option value="2">Download</option>   
</select>    
</td>   
</tr>
<?php } ?>
</table>
</div>
    
</div>
</div>

<!------------------modal tambah dokumen utama------------->
<div class="modal fade" id="modal_dokumen_utama" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document">
<div class="modal-content ">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel text-center">Upload dokumen utama</h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<form action="<?php  echo base_url('Data_lama/upload_utama')?>" method="post" enctype="multipart/form-data">
<label>Tanggal akta</label>
<input type="text" required="" readonly="" class="form-control" name="tanggal_akta">
<label>Jenis file utama</label>
<select name="jenis" class="form-control">
<option value="Draft">Draft</option>    
<option value="Minuta">Minuta</option>    
<option value="Salinan">Salinan</option>    
</select>
<label>Upload</label>
<input type="hidden" value="<?php echo $this->uri->segment(3) ?>" name="no_pekerjaan">
<input type="hidden" value="<?php echo $this->security->get_csrf_hash() ?>" name="token">
<input type="file" required="" name="file" class="form-control">
</div>
<div class="card-footer">  
    <button type="submit" class="btn btn-block btn-sm btn-success">Upload File <span class="fa fa-upload"></span></button>
</div>
</form>    

</div>
</div>
</div>

<script type="text/javascript">
function tambah_dokumen_utama(){

$('#modal_dokumen_utama').modal('show');
}    
    
    
function aksi_utama(id_data_dokumen_utama){
var val = $(".data_aksi"+id_data_dokumen_utama+" option:selected").val(); 
if (val == 1){
hapus_utama(id_data_dokumen_utama);
}else if(val == 2){
window.location.href="<?php echo base_url('Data_lama/download_utama/') ?>"+btoa(id_data_dokumen_utama);
}
$(".data_aksi"+id_data_dokumen_utama).val("-- Klik untuk lihat menu --");       
}    



function hapus_utama(id_data_dokumen_utama){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
Swal.fire({
title: 'Anda yakin',
text: "file akan dihapus secara permanen",
type: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Ya Hapus'
}).then((result) => {
if (result.value) {
$.ajax({
type:"post",
data:"token="+token+"&id_data_dokumen_utama="+id_data_dokumen_utama,
url:"<?php echo base_url('Data_lama/hapus_file_utama') ?>",
success:function(data){
Swal.fire(
'Terhapus',
'File berhasil dihapus',
'success'
).then(function(){
window.location.href="<?php echo base_url('Data_lama/proses_pekerjaan/'.$this->uri->segment(3))?>";    
});
}
});
}
})
}


$(function() {
$("input[name='tanggal_akta']").daterangepicker({ singleDatePicker: true,dateFormat: 'yy/mm/dd',
    "locale": {
        "format": "YYYY/MM/DD",
        "separator": "-",
      }
});
});
</script>
