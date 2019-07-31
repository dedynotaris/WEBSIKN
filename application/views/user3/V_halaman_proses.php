<body >
<?php  $this->load->view('umum/V_sidebar_user3'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar_user3'); ?>
<div class="container-fluid ">
<div class="card-header mt-2 mb-2 text-center">
Data perizinan yang perlu diproses
</div>    
<div class="row">
<div class="col">    
<table class="table table-hover table-striped table-sm table-bordered text-center">
<tr>
<th>Nama client</th>
<th>Nama Tugas</th>
<th>Dari</th>
<th class="text-center">Target selesai perizinan</th>
<th>Aksi</th>
</tr>

<?php foreach ($data_tugas->result_array() as    $data){  ?>
<tr>
<td><?php echo $data['nama_client'] ?></td>
<td><?php echo $data['nama_dokumen'] ?></td>
<td><?php echo $data['nama_lengkap'] ?></td>
<td class="text-center"><?php echo $data['target_selesai_perizinan'] ?></td>
<td>
<select onchange="aksi_option('<?php echo $data['no_pekerjaan'] ?>','<?php echo $data['no_berkas_perizinan'] ?>','<?php echo $data['no_nama_dokumen'] ?>','<?php echo $data['no_client'] ?>');" class="form-control data_option<?php echo $data['no_berkas_perizinan'] ?>">
<option value="1">-- Klik untuk lihat menu --</option>
<option value="2">Buat Laporan</option>
<option value="3">Lihat Persyaratan</option>
<option value="4">Rekam Data</option>
<option value="5">Selesaikan Perizinan</option>
</select>    
</td>
</tr>

<?php } ?>
</table>
</div>
</div>
</div>

<!-------------------modal laporan--------------------->

<div class="modal fade" id="modal_laporan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Masukan Progress Pekerjaan</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">

<input type="hidden" value="" id="no_pekerjaan">
<input type="hidden" value="" id="no_berkas_perizinan">
<textarea id="laporan"class="form-control" placeholder="masukan progress pekerjaan"></textarea>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
<button type="button" class="btn btn-sm btn-success" id="simpan_laporan">Simpan laporan</button>
</div>
</div>
</div>
</div>

<!-------------modal--------------------->
<div class="modal fade" id="modal_data" tabindex="-1" role="dialog" aria-labelledby="modal_dinamis" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">
<div class="modal-content ">
<div class="modal-body tampilkan_data">

</div>
</div>
</div>
</div>



</body>

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




<div class="modal fade" id="modal_upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document">
<div class="modal-content ">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel text-center">Perekaman data<span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<form  id="fileForm" method="post" action="<?php echo base_url('User3/simpan_persyaratan') ?>">

<div class="modal-body form_persyaratan">


</div>
<div class="modal-footer">
<button type="submit" class="btn btn-md btn-block btn-dark">Simpan <span class="fa fa-save"></span></button>    
</div>
</form>    
</div>
</div>
</div>




<script type="text/javascript">
function aksi_option(no_pekerjaan,no_berkas_perizinan,no_nama_dokumen,no_client){
var aksi_option = $(".data_option"+no_berkas_perizinan+" option:selected").val();
if(aksi_option == 1){
$(".data_option"+no_berkas_perizinan).val("-- Klik untuk lihat menu --");
}else if(aksi_option == 2){
$('#modal_laporan').modal('show');
$("#no_pekerjaan").val(no_pekerjaan);
$("#no_berkas_perizinan").val(no_berkas_perizinan);
}else if(aksi_option == 3){
form_lihat_persyaratan(no_pekerjaan);    
}else if(aksi_option == 4){
form_rekam_data(no_nama_dokumen,no_pekerjaan,no_client);
}else if(aksi_option == 5){
selesaikan_perizinan(no_berkas_perizinan);
}
$(".data_option"+no_berkas_perizinan).prop('selectedIndex',0);

}
function selesaikan_perizinan(no_berkas_perizinan){
var token           = "<?php echo $this->security->get_csrf_hash() ?>";
    
Swal.fire({
  text: 'Anda yakin ingin menyelesaikan perizinan tersebut ?',
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#FF8C00',
  cancelButtonColor: '#2F4F4F',
  confirmButtonText: 'Ya, Selesaikan!'
}).then((result) => {
  if (result.value) {
    
    $.ajax({
      type:"post",
      data:"token="+token+"&no_berkas_perizinan="+no_berkas_perizinan,
      url:"<?php echo base_url('User3/selesaikan_tugas') ?>",
      success:function(data){
          var r = JSON.parse(data);
          
          const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated zoomInDown'
});
Toast.fire({
type: r.status,
title: "Perizinan berhasil diselesaikan"
}).then(function(){
window.location.href="<?php echo base_url('User3/Halaman_proses') ?>";    
});
  
    }
    });
    
    
    
    }
});    
}

function form_lihat_persyaratan(no_pekerjaan){
var token           = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
url:"<?php echo base_url('User3/lihat_persyaratan') ?>",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan,
success:function(data){
$(".tampilkan_data").html(data);
$('#modal_data').modal('show');
}
});
}

function form_rekam_data(no_nama_dokumen,no_pekerjaan,no_client){
var token           = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
url:"<?php echo base_url('User3/form_persyaratan') ?>",
data:"token="+token+"&no_nama_dokumen="+no_nama_dokumen+"&no_pekerjaan="+no_pekerjaan+"&no_client="+no_client,
success:function(data){
$(".form_persyaratan").html(data);
$('#modal_upload').modal('show');

var inputQuantity = [];
    $(function() {
      $(".quantity").each(function(i) {
        inputQuantity[i]=this.defaultValue;
         $(this).data("idx",i); // save this field's index to access later
      });
      $(".quantity").on("keyup", function (e) {
        var $field = $(this),
            val=this.value,
            $thisIndex=parseInt($field.data("idx"),10); // retrieve the index
        if (this.validity && this.validity.badInput || isNaN(val) || $field.is(":invalid") ) {
            this.value = inputQuantity[$thisIndex];
            return;
        } 
        if (val.length > Number($field.attr("maxlength"))) {
            var t = Number($field.attr("maxlength"));
          val=val.slice(0,t);
          $field.val(val);
        }
        inputQuantity[$thisIndex]=val;
      });      
    });
}
});
}

function form_tolak_tugas(no_pekerjaan,id_data_berkas){
}

function download(id_data_berkas){
window.location.href="<?php echo base_url('User3/download_berkas/') ?>"+id_data_berkas;
}

$(document).ready(function(){
$("#simpan_laporan").click(function(){
var no_pekerjaan   = $("#no_pekerjaan").val();
var no_berkas_perizinan = $("#no_berkas_perizinan").val();
var laporan        = $("#laporan").val();
var token           = "<?php echo $this->security->get_csrf_hash() ?>";

$.ajax({
type:"post",
data:"token="+token+"&laporan="+laporan+"&no_berkas_perizinan="+no_berkas_perizinan+"&no_pekerjaan="+no_pekerjaan,
url :"<?php echo base_url('User3/simpan_laporan') ?>",
success:function(data){
var r = JSON.parse(data);

const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated zoomInDown'
});
Toast.fire({
type: r.status,
title: r.pesan
});
$('#modal_laporan').modal('hide');
$("#laporan").val("")

}
});

}); 
});

function lihat_data_perekaman(no_nama_dokumen,no_pekerjaan){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_nama_dokumen="+no_nama_dokumen+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('User3/data_perekaman') ?>",
success:function(data){
$(".data_perekaman").html(data);    
$('#data_perekaman').modal('show');
}
});
}

$("#fileForm").submit(function(e) {
e.preventDefault();
$.validator.messages.required = '';
}).validate({
highlight: function (element, errorClass) {
$(element).closest('.form-control').addClass('is-invalid');
},
unhighlight: function (element, errorClass) {
$(element).closest(".form-control").removeClass("is-invalid");
},    
submitHandler: function(form) {

var result = { };
var jml_meta = $('.meta').length;
for (i = 1; i <=jml_meta; i++) {
var key   =($("#data_meta"+i).attr('name'));
var value =($("#data_meta"+i).val());
$.each($('form').serializeArray(), function() {
result[key] = value;
});
}

var token             = "<?php echo $this->security->get_csrf_hash() ?>";
var name = $("#id").attr("name");

formdata = new FormData();
formdata.append("token", token);
file = $("#file_berkas").prop('files')[0];;
formdata.append("file_berkas", file);
formdata.append("no_nama_dokumen",$(".no_nama_dokumen").val());
formdata.append("no_client",$(".no_client").val());
formdata.append("no_pekerjaan",$(".no_pekerjaan").val());
formdata.append('data_meta', JSON.stringify(result));


$.ajax({
url: form.action,
processData: false,
contentType: false,
type: form.method,
data: formdata,
success:function(data){
     
var r = JSON.parse(data);
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated bounceInDown'
});

Toast.fire({
type: r.status,
title: r.pesan
});

}

});
return false; 
}
});


function hapus_berkas_persyaratan(id_data_berkas,no_nama_dokumen,no_pekerjaan){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&id_data_berkas="+id_data_berkas,
url:"<?php echo base_url('User3/hapus_berkas_persyaratan') ?>",
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
lihat_data_perekaman(no_nama_dokumen,no_pekerjaan);
}
});    
}
</script>    
</html>
