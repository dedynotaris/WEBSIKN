<body onload="refresh()">
<?php  $this->load->view('umum/V_sidebar'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar'); ?>
    <style>
 .nav-tabs .nav-link {
    background-color:#212529;
    border: 1px solid transparent;
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
   
}
.nav-tabs .nav-link.active, .nav-tabs .nav-item.show .nav-link {
    color: #fff;
    background-color: #17a2b8;
    border-color: #dee2e6 #dee2e6 #fff;
}

 a {
   color: #fff;
   
}
a:hover {
  color: #fff;
  text-decoration: underline;
}
form {
    display: inherit;
    width: inherit;
    margin-bottom: 0;
    width: -webkit-fill-available;
}
    </style>     
<div class="container-fluid">
<div class=" data_feature">

</div>

</div>
<script type="text/javascript">
function refresh(){
load_data_feature();    
}

function load_data_feature(){
var token           = "<?php echo $this->security->get_csrf_hash() ?>";

$.ajax({
type:"post",
url:"<?php echo base_url('Dashboard/setting_feature') ?>",
data:"token="+token,
success:function(data){
$(".data_feature").html(data);    
}
});
}

function toogle(app){
var token           = "<?php echo $this->security->get_csrf_hash() ?>";

    $.ajax({
type:"post",
url:"<?php echo base_url('Dashboard/on_off_feature') ?>",
data:"token="+token+"&app="+app,
success:function(){
//refresh();
}
});
    
}


</script>
<div class="container">
<div class=" mt-2">
<ul class="nav nav-tabs">
<li class="nav-item">
<a class="nav-link active" data-toggle="tab" href="#jenis">Pengaturan Jenis Pekerjaan <i class="fas fa-cogs"></i></a>
</li>
<li class="nav-item ml-1">
<a class="nav-link " data-toggle="tab" href="#dokumen">Pengaturan Dokumen Penunjang <i class="fas fa-cogs"></i></a>
</li>
<li class="nav-item ml-1">
<a class="nav-link" data-toggle="tab" href="#aplikasi">Pengaturan User <i class="fas fa-cogs"></i></a>
</li>
</ul>

<div class="tab-content">

<div class="tab-pane  container-fluid active" id="jenis">
<div class="row p-2">
<div class="col">
<button  onclick="TambahJenisPekerjaan()" class="btn btn-dark btn-sm float-right" data-toggle="modal" data-target="#tambah_jenis_dokumen">Tambahkan Jenis Pekerjaan <i class="fa fa-plus"></i></button>
<h5 align="center">&nbsp;</h5>
<hr>
<?php $this->load->view('dashboard/V_data_jenis_pekerjaan'); ?>
</div>
</div>
</div>
<!----------------------------Dokumen------------------------------>
<div class="tab-pane  container-fluid fade" id="dokumen">
<div class="row p-2">
<div class="col">
<button  onclick="FormTambahDokumen()"  class="btn btn-dark btn-sm float-right" data-toggle="modal" data-target="#tambah_data_dokumen">Tambahkan Dokumen Penunjang <i class="fa fa-plus"></i></button>
<h5 align="center">&nbsp;</h5>
<hr>
<?php $this->load->view('dashboard/V_data_dokumen'); ?>
</div>
</div>
</div>
<!----------------------------Aplikasi------------------------------>
<div class="tab-pane container-fluid fade" id="aplikasi">
<div class="row p-2">
<div class="col">
<button onclick="TambahDataUser()" class="btn btn-dark btn-sm float-right" >Tambahkan Data User <i class="fa fa-plus"></i></button>
<h5 align="center">&nbsp;</h5>
<hr>
<?php $this->load->view('dashboard/V_data_user_setting'); ?>
</div>
</div>
</div>

</div>
</div>
</div>
</div>


<!------------- Modal Detail Pekerjaaan---------------->
<div class="modal fade bd-example-modal-lg" id="ModalDetailPekerjaan" role="dialog" aria-labelledby="tambah_syarat1" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document" id="DataDetailPekerjaan">

</div>
</div>

<!------------- Modal Detail Pekerjaaan---------------->
<div class="modal fade bd-example-modal-lg" id="ModalDetail" role="dialog" aria-labelledby="tambah_syarat1" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document" id="DataDetail">

</div>
</div>

<!------------- Modal Detail Dokumen---------------->
<div class="modal fade bd-example-modal-xl" id="ModalDetailDokumen" role="dialog" aria-labelledby="tambah_syarat1" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document" id="DataDetailDokumen">

</div>
</div>

<!------------- Modal Detail Dokumen---------------->
<div class="modal fade bd-example-modal-xl" id="ModalDetailDokumen2" role="dialog" aria-labelledby="tambah_syarat1" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document" id="DataDetailDokumen2">

</div>
</div>


</body>

