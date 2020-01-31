<body>
<?php  $this->load->view('umum/V_sidebar'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar'); ?>
<?php $static = $DetailPekerjaan->row_array(); ?>   
<div class="container-fluid mt-2">
<div class="mt-2  text-center  ">
<h5 align="center " class="text-theme1"><span class="fa-2x fa fa-exchange-alt "></span><br> DETAIL PEKERJAAN</h5>
</div>
<div class="row">
<div class="col">
<div class="card p-2">
<span class="text-center">Detail Pekerjaan</span><hr>

<div class="row">
<div class="col-md-4">Nama Pekerjaan</div>
<div class="col">: <?php echo  $static['nama_jenis']?></div>
</div>
<div class="row">
<div class="col-md-4">Nama Client</div>
<div class="col">: <?php echo  $static['nama_client']?></div>
</div>

<div class="row">
<div class="col-md-4">Status Pekerjaan</div>
<div class="col">: <?php echo  $static['status_pekerjaan']?></div>
</div>

<div class="row">
<div class="col-md-4">Tanggal Dibuat</div>
<div class="col">: <?php echo  $static['tanggal_dibuat']?></div>
</div>

<div class="row">
<div class="col-md-4">Pembuat Pekerjaan</div>
<div class="col">: <?php echo  $static['pembuat_pekerjaan']?></div>
</div>

</div>
</div>
    <div class="col">
        <div class="card p-2">
            <span class="text-center">Laporan Progress Pekerjaan</span><hr>
            <div class=" overflow-auto" style="max-height:200px">
             <?php if($static['laporan_pekerjaan'] != NULL){ ?>
            <?php 
                    foreach ($DetailPekerjaan->result_array() as $laporan){ ?>
            <div class="card-header">
                <div class="row">
                    <div class="col"> <?php echo $laporan['waktu_lapor'] ?> : <?php echo $laporan['laporan_pekerjaan'] ?></div>
                </div>    
            </div>
             <?php  }
             
                    }else{
                    echo "<span class='text-center'>laporan yang diberikan tidak tersedia</span>";         
                  } ?>
        </div>
        </div>
        
    </div>
</div>

<div class="p-2 mt-2">
<ul class="nav nav-tabs">
<li class="nav-item">
<a class="nav-link active" data-toggle="tab" href="#jenis">Dokumen Penunjang <i class="fas fa-file-word"></i></a>
</li>
<li class="nav-item ml-1">
<a class="nav-link " data-toggle="tab" href="#dokumen">Dokumen Utama <i class="fas fa-file"></i></a>
</li>
<li class="nav-item ml-1">
<a class="nav-link" data-toggle="tab" href="#aplikasi">Pihak Terlibat <i class="fas fa-users"></i></a>
</li>
</ul>

<div class="tab-content">

<div class="tab-pane  container-fluid active" id="jenis">
<div class="row p-2">
<div class="col">
<table style="width:100%;" id="DokumenPenunjang" class="table table-striped table-condensed table-sm table-bordered  table-hover table-sm"><thead>
<tr role="row">
<th  align="center" aria-controls="datatable-fixed-header"  >No</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Nama File</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Jenis Dokumen</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Pengupload</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Tanggal Upload</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Nama Client</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Aksi</th>
</thead>
<tbody>
</table>
    
</div>
</div>
</div>
<!----------------------------Dokumen------------------------------>
<div class="tab-pane  container-fluid fade" id="dokumen">
<div class="row p-2">
<div class="col">
<table style="width:100%;" id="DokumenUtama" class="table table-striped table-condensed table-sm table-bordered  table-hover table-sm"><thead>
<tr role="row">
<th  align="center" aria-controls="datatable-fixed-header"  >No</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Nama Berkas</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Jenis Berkas</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Tanggal Akta</th>
<th  align="center" aria-controls="datatable-fixed-header"  >No akta</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Tanggal Upload</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Aksi</th>
</thead>
<tbody>
</table>
    
</div>
</div>
</div>
<!----------------------------Aplikasi------------------------------>
<div class="tab-pane container-fluid fade" id="aplikasi">
<div class="row p-2">
<div class="col">
<table style="width:100%;" id="PihakTerlibat" class="table table-striped table-condensed table-sm table-bordered  table-hover table-sm"><thead>
<tr role="row">
<th  align="center" aria-controls="datatable-fixed-header"  >No</th>
<th  align="center" aria-controls="datatable-fixed-header"  >No Client</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Nama Client</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Aksi</th>
</thead>
<tbody>
</table>
   
</div>
</div>
</div>

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

var t = $("#DokumenPenunjang").dataTable({
initComplete: function() {
var api = this.api();
$('#DokumenPenunjang')
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
ajax: {"url": "<?php echo base_url('Dashboard/JsonDokumenPenunjangPekerjaan/'.$this->uri->segment(3)) ?> ", 
"type": "POST",
data: function ( d ) {
d.token = '<?php echo $this->security->get_csrf_hash(); ?>';
}
},
columns: [
{
"data": "no_berkas",
"orderable": false
},
{"data": "nama_file"},
{"data": "nama_dokumen"},
{"data": "pengupload"},
{"data": "tanggal_upload"},
{"data": "nama_client"},
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

var t = $("#DokumenUtama").dataTable({
initComplete: function() {
var api = this.api();
$('#DokumenUtama')
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
ajax: {"url": "<?php echo base_url('Dashboard/JsonDokumenUtamaPekerjaan/'.$this->uri->segment(3)) ?> ", 
"type": "POST",
data: function ( d ) {
d.token = '<?php echo $this->security->get_csrf_hash(); ?>';
}
},
columns: [
{
"data": "id_data_dokumen_utama",
"orderable": false
},
{"data": "nama_berkas"},
{"data": "jenis_utama"},
{"data": "tanggal_akta"},
{"data": "no_akta"},
{"data": "tanggal_upload"},
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
function download_utama(id_data_dokumen_utama){
window.location.href="<?php echo base_url('Dashboard/download_utama/') ?>"+btoa(id_data_dokumen_utama);
}
</script>


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

var t = $("#PihakTerlibat").dataTable({
initComplete: function() {
var api = this.api();
$('#PihakTerlibat')
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
ajax: {"url": "<?php echo base_url('Dashboard/JsonPihakTerlibat/'.$this->uri->segment(3)) ?> ", 
"type": "POST",
data: function ( d ) {
d.token = '<?php echo $this->security->get_csrf_hash(); ?>';
}
},
columns: [
{
"data": "id_data_pemilik",
"orderable": false
},
{"data": "no_client"},
{"data": "nama_client"},
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
</body>    