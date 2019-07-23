<body>
<?php  $this->load->view('umum/V_sidebar_resepsionis'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar_resepsionis'); ?>
<div class="container-fluid">

<div class="card-header mt-2 text-center ">
<h5 align="center">Absen</h5>
</div>
    
<form id="fileForm" method="post" action="<?php echo base_url('Resepsionis/simpan_absen') ?>" >
<div class="row">

<div class="col">

<label>Nama Karyawan</label>    
<select name="nama_karyawan"  class="form-control nama_karyawan required" accept="text/plain">
<option >--- Pilih karyawan ---</option>   
<?php foreach ($data_karyawan->result_array() as $kar){
echo "<option>".$kar['nama_lengkap']."</option>";    
} ?>   
</select>

<label>Tanggal Jam datang</label>    
<input type="text" name="tanggal" class="form-control jam_datang"  />

<label>Tanggal Jam pulang</label>    
<input type="text" name="tanggal" class="form-control jam_pulang"  />

</div>
<div class="col">
<label>Tugas</label>
<textarea name="tugas" id="tugas"   class="form-control tugas required" accept="text/plain" placeholder="Tugas . . ."></textarea>
<hr>
<button type="submit" class="btn btn-success simpan_absen btn-sm btn-block">Simpan Absen <span class="fa fa-save"></span></button> 
</form>
</div>
<hr>


</div>
    <hr>    
<div class="row mt-5">
<div class="col">
<table style="width:100%;" id="data_absen" class="table table-striped table-condensed table-sm table-bordered  table-hover table-sm"><thead>
<tr role="row">
<th  align="center" aria-controls="datatable-fixed-header"  >No</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Penginput</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Nama Karyawan</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Jam Datang</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Jam Pulang</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Aksi</th>
</thead>
<tbody align="center">
</table>  
</div>
</div>        


</div>
<script type="text/javascript">
$(document).ready(function() {
$.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
{
return {
"iStart": oSettings._iDisplayStart,
"iEnd": oSettings.fnDisplayEnd(),
"iLength": oSettings._iDisplayLength,
"iTotal": oSettings.fnRecordsTotal(),
"iFilteredTotal": oSettings.fnRecordsDisplay(),
"iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
"iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
};
};

var t = $("#data_absen").dataTable({
initComplete: function() {
var api = this.api();
$('#data_absen')
.off('.DT')
.on('keyup.DT', function(e) {
if (e.keyCode == 13) {
api.search(this.value).draw();
}
});
},
oLanguage: {
sProcessing: "loading..."
},
processing: true,
serverSide: true,
ajax: {"url": "<?php echo base_url('Resepsionis/json_data_absen') ?> ", 
"type": "POST",
data: function ( d ) {
d.token = '<?php echo $this->security->get_csrf_hash(); ?>';
}
},
columns: [
{
"data": "id_data_buku_absen",
"orderable": false
},
{"data": "penginput"},
{"data": "nama_karyawan"},
{"data": "jam_datang"},
{"data": "jam_pulang"},
{"data": "view"}


],
order: [[0, 'desc']],
rowCallback: function(row, data, iDisplayIndex) {
var info = this.fnPagingInfo();
var page = info.iPage;
var length = info.iLength;
var index = page * length + (iDisplayIndex + 1);
$('td:eq(0)', row).html(index);
}
});
});


</script>   

<script>
$(function() {
  $('input[name="tanggal"]').daterangepicker({
    singleDatePicker: true,
 timePicker: true,
    startDate: moment().startOf('hour'),
    timePicker24Hour:true,
    endDate: moment().startOf('hour').add(24, 'hour'),
    locale: {
      format: 'YYYY/MM/DD HH:MM A'
    } });
});


CKEDITOR.replace('tugas', {
toolbarGroups: [{
"name": "basicstyles",
"groups": ["basicstyles"]
},
{
"name": "paragraph",
"groups": ["list"]
}



],
removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
});

</script>

<script type="text/javascript">
$(document).ready(function(){
$("#fileForm").submit(function(e) {
e.preventDefault();
$.validator.messages.required = '';
}).validate({
ignore: [],

rules: { tugas: {
required: function(textarea) {
CKEDITOR.instances["tugas"].updateElement();
var editorcontent = textarea.value.replace("asdasdasdasdasdasdasasd", '');
return editorcontent.length === 0;
}
}
},messages:{
tugas:{
required:"<span class='text-danger'>Alasan tugas belum dimasukan </span>"
}
},
highlight: function (element, errorClass) {
$(element).closest('.form-control').addClass('is-invalid');
},
unhighlight: function (element, errorClass) {
$(element).closest(".form-control").removeClass("is-invalid");
},    
submitHandler: function(form) {
$(".simpan_tamu").attr("disabled", true);

var token    = "<?php echo $this->security->get_csrf_hash() ?>";
formData = new FormData();
formData.append('token',token);
formData.append('tugas',CKEDITOR.instances['tugas'].getData());
formData.append('nama_karyawan',$(".nama_karyawan").val()),
formData.append('jam_datang',$(".jam_datang").val()),
formData.append('jam_pulang',$(".jam_pulang").val()),


$.ajax({
url: form.action,
processData: false,
contentType: false,
type: form.method,
data: formData,
success:function(data){
$(".simpan_absen").removeAttr("disabled", true);

CKEDITOR.instances.tugas.setData('');

var table = $('#data_absen').DataTable();
table.ajax.reload( function ( json ) {
$('#data_absen').val( json.lastInput );
});    

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

});

</script>

<script type="text/javascript">
function lihat_tugas(id){
var token    = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&id_data_buku_absen="+id,
url:"<?php echo base_url('Resepsionis/lihat_tugas') ?>",
success:function(data){
$(".data_tugas").html(data);
$('#lihat_tugas').modal('show');
}
});

}

function edit_absen(id){
alert(id);    
}


</script>


<!------------- lihat tugas---------------->
<div class="modal fade" id="lihat_tugas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Daftar Tugas </h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body data_tugas">
    
</div>
</div>
</div>
</div>

</body>

