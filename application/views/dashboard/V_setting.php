<body onload="refresh()">
<?php  $this->load->view('umum/V_sidebar'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar'); ?>
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
<div class="p-2 mt-2">
<ul class="nav nav-tabs">
<li class="nav-item">
<a class="nav-link active" data-toggle="tab" href="#jenis">Pengaturan Jenis Pekerjaan <i class="fas fa-cogs"></i></a>
</li>
<li class="nav-item ml-1">
<a class="nav-link " data-toggle="tab" href="#dokumen">Pengaturan Nama Persyaratan <i class="fas fa-cogs"></i></a>
</li>
<li class="nav-item ml-1">
<a class="nav-link" data-toggle="tab" href="#aplikasi">Pengaturan User <i class="fas fa-cogs"></i></a>
</li>
</ul>

<div class="tab-content">

<div class="tab-pane  container-fluid active" id="jenis">
<div class="row p-2">
<div class="col">
<button  onclick="TambahJenisPekerjaan()" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#tambah_jenis_dokumen">Tambahkan Jenis Pekerjaan <i class="fa fa-plus"></i></button>
<h5 align="center">&nbsp;</h5>
<hr>
<h5 align="center">Data jenis pekerjaan</h5>
<?php $this->load->view('dashboard/V_data_jenis_pekerjaan'); ?>
</div>
</div>
</div>
<!----------------------------Dokumen------------------------------>
<div class="tab-pane  container-fluid fade" id="dokumen">
<div class="row p-2">
<div class="col">
<button  onclick="FormTambahDokumen()"  class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#tambah_data_dokumen">Tambahkan Data Dokumen <i class="fa fa-plus"></i></button>
<h5 align="center">&nbsp;</h5>
<hr>
<h5 align="center">Data Nama Dokumen</h5>
<?php $this->load->view('dashboard/V_data_dokumen'); ?>
</div>
</div>
</div>
<!----------------------------Aplikasi------------------------------>
<div class="tab-pane container-fluid fade" id="aplikasi">
<div class="row p-2">
<div class="col">
<button onclick="TambahDataUser()" class="btn btn-success btn-sm float-right" >Tambahkan Data User <i class="fa fa-plus"></i></button>
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
</div>

</body>

