<body>
<?php  $this->load->view('umum/V_sidebar'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar'); ?>
<?php $static = $DataClient->row_array(); ?>
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
    </style>     
<div class="container-fluid mt-3 text-dark">
<div class="row">
<div class="col">
<div class="card p-2">
<p class="text-center"> DATA CLIENT <?php echo  $static['nama_client']?></p>

<div class="row">
<div class="col-md-4">No Identitas</div>
<div class="col">: <?php echo  $static['no_identitas']?></div>
</div>
<div class="row">
<div class="col-md-4">Nama Client</div>
<div class="col">: <?php echo  $static['nama_client']?></div>
</div>
<div class="row">
<div class="col-md-4">Jenis Client</div>
<div class="col">: <?php echo  $static['jenis_client']?></div>
</div>
<div class="row">
<div class="col-md-4">Alamat Client</div>
<div class="col">: <?php echo  $static['alamat_client']?></div>
</div>
<div class="row">
<div class="col-md-4">Pembuat Client</div>
<div class="col">: <?php echo  $static['pembuat_client']?></div>
</div>
<div class="row">
<div class="col-md-4">Kontak Yang Bisa Dihubungi</div>
<div class="col">: <?php echo  $static['contact_person']?></div>
</div>
<div class="row">
<div class="col-md-4">Nomor Kontak</div>
<div class="col">: <?php echo  $static['contact_number']?></div>
</div>

</div>
</div>

    
<div class="col">
<div class="card p-2">
<p class="text-center"> DATA PEKERJAAN <?php echo  $static['nama_client']?></p>

<div class="row">
<div class="col-md-5">Pekerjaan yang masuk</div>
<div class="col">: <?php echo  $this->db->get_where('data_pekerjaan',array('no_client'=>base64_decode($this->uri->segment(3))))->num_rows();?></div>
</div>
<div class="row">
<div class="col-md-5">Berkas yang masuk</div>
<div class="col">: <?php echo  $this->db->get_where('data_berkas',array('no_client'=>base64_decode($this->uri->segment(3))))->num_rows();?></div>
</div>

</div>
</div>
</div>
 
<hr>
    
<ul class="nav nav-tabs">
<li class="nav-item">
<a class="nav-link active" data-toggle="tab" href="#jenis">Data Pekerjaan Client </a>
</li>
<li class="nav-item ml-1">
<a class="nav-link " data-toggle="tab" href="#dokumen">Data Dokumen Penunjang </a>
</li>
</ul>



<div class="tab-content">
<div class="tab-pane  container-fluid active" id="jenis">
<div class="row p-2">
<div class="col">
<h5 align="center">&nbsp;</h5>
<h5 align="center " class="text-info">Data Pekerjaan Client</h5>

<table style="width:100%;" id="DataPekerjaanClient" class="table table-striped table-condensed table-sm table-bordered  table-hover table-sm"><thead>
        <tr class="text-info" role="row">
<th   aria-controls="datatable-fixed-header"  >No</th>
<th   aria-controls="datatable-fixed-header"  >No Pekerjaan</th>
<th   aria-controls="datatable-fixed-header"  >Jenis Pekerjaan</th>
<th   aria-controls="datatable-fixed-header"  >Tanggal Pekerjaan</th>
<th   aria-controls="datatable-fixed-header"  >Nama Client</th>
<th   aria-controls="datatable-fixed-header"  >Status Pekerjaan</th>
<th   aria-controls="datatable-fixed-header"  >Aksi</th>
</thead>
<tbody >
</table> 

</div>
</div>
</div>    
<!----------------------------Dokumen------------------------------>
<div class="tab-pane  container-fluid fade" id="dokumen">
<div class="row p-2">
<div class="col">
<h5 align="center"  class="text-info">Data Dokumen Penunjang</h5>
<table style="width:100%;" id="DataDokumenPenunjang" class="table table-striped table-condensed table-sm table-bordered  table-hover table-sm"><thead>
        <tr class="text-info" role="row">
<th aria-controls="datatable-fixed-header"  >No</th>
<th aria-controls="datatable-fixed-header"  >Nama File</th>
<th aria-controls="datatable-fixed-header"  >Jenis Dokumen</th>
<th aria-controls="datatable-fixed-header"  >Tanggal Upload</th>
<th aria-controls="datatable-fixed-header"  >Pengupload</th>
<th aria-controls="datatable-fixed-header"  >Aksi</th>
</thead>
<tbody >
</table> 
</div>
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

var t = $("#DataPekerjaanClient").dataTable({
initComplete: function() {
var api = this.api();
$('#DataPekerjaanClient')
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
ajax: {"url": "<?php echo base_url('Dashboard/JsonDataPekerjaanClient/'.$this->uri->segment(3)) ?> ", 
"type": "POST",
data: function ( d ) {
d.token = '<?php echo $this->security->get_csrf_hash(); ?>';
}
},
columns: [
{
"data": "no_pekerjaan",
"orderable": false
},
{"data": "no_pekerjaan"},
{"data": "nama_jenis"},
{"data": "tanggal_dibuat"},
{"data": "nama_client"},
{"data": "status_pekerjaan"},
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

var t = $("#DataDokumenPenunjang").dataTable({
initComplete: function() {
var api = this.api();
$('#DataDokumenPenunjang')
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
ajax: {"url": "<?php echo base_url('Dashboard/JsonDOkumenPenunjangClient/'.$this->uri->segment(3)) ?> ", 
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
{"data": "tanggal_upload"},
{"data": "pengupload"},
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