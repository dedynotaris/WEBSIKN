<body onload="refresh()">
<?php  $this->load->view('umum/user1/V_sidebar_user1'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/user1/V_navbar_user1'); ?>
<?php  $this->load->view('umum/user1/V_data_user1'); ?>
<div class="container-fluid mt-3 text-theme1">
LAPORAN PEKERJAAN
<hr>
<div class="row">
<div class="col">
<form  action="<?php echo base_url('User1/buat_laporan') ?>" method="post">
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo$this->security->get_csrf_hash();?>" readonly="" class="form-control required"  accept="text/plain">
<label>Jangka Waktu</label>
<input type="text" name="daterange" class="form-control form-control-sm" />
</div>
<div class="col">
<label>Pilih Output</label>
<select name="output" class="form-control form-control-sm">
<option value="Pdf">PDF</option>
<option value="Excel">Excel</option>
</select>
</div>

<div class="col">
<label>Jenis Laporan</label>
<select name="jenis_laporan" class="form-control form-control-sm">
<option value="Pekerjaan">Pekerjaan</option>
<option value="Dokumen Pendukung">Dokumen Pendukung</option>
<option value="Dokumen Utama">Dokumen Utama</option>
</select>
</div>


<div class="col">
<label>Pilih Asisten</label>
<select name="asisten" class="form-control form-control-sm">
<?php foreach ($asisten->result_array() as $nama){
echo "<option value=".$nama['no_user'].">".$nama['nama_lengkap']."</option>";
} ?>
</select>
</div>

<div class="col">
<label>&nbsp;</label>
<button type="submit" class="btn btn-sm btn-success btn-block">Data Laporan <i class="far fa-clipboard"></i></button>
</form>    
</div>    
</div>
<hr>



<div class="row ">
<div class="col">
<canvas id="GrafikBerkasAsisten" width="200" height="100"></canvas>
</div>
<div class="col">
<canvas id="GrafikPekerjaanAsisten" width="200" height="100"></canvas>
</div>
</div>
<hr>
<div class="row">
<div class="col-md-8">
<div class="row">
<div class="col">
<div id="reportrange" style="background: #fff; cursor: pointer; padding: 2px 18px; border: 1px solid #ccc; width: 100%">
<i class="fa fa-calendar"></i>
<span></span> <i class="fa fa-caret-down"></i>
</div>
</div>
  
    <div class="col">
        <button onclick="ShowGrafikBerkasHarian()" class="btn btn-sm btn-success btn-block">Show Grafik Berkas <i class="fas fa-chart-line"></i></button>  
    </div>    
</div>    

<hr>    
<canvas id="GrafikBerkas" width="200" height="80"></canvas>
</div>
    <div class="col">
      <canvas id="GrafikPerizinan" width="200" height="180"></canvas>
    </div>    
</div>
</div>
    
    <script type="text/javascript">
$(function() {

var start = moment().subtract(29, 'days');
var end = moment();

function cb(start, end) {
$('#reportrange span').html(start.format('YYYY/MM/DD') + ' - ' + end.format('YYYY/MM/DD'));
}

$('#reportrange').daterangepicker({
startDate: start,
endDate: end,
locale: {
format: 'YYYY/MM/DD'
},
ranges: {
'Hari Ini': [moment(), moment()],
'kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
'7 Hari Terkakhir': [moment().subtract(6, 'days'), moment()],
'30 Hari Terakhir': [moment().subtract(29, 'days'), moment()],
'Bulan Ini': [moment().startOf('month'), moment().endOf('month')],
'Bulan Kemarin': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
}
}, cb);

cb(start, end);

});
</script>
<script type="text/javascript">
$(function() {
$('input[name="daterange"]').daterangepicker({
opens: 'right',
startDate: moment().startOf('day').add(-30,'day'),
endDate: moment().startOf('day'), 
locale: {
format: 'YYYY/MM/DD'
}
}, function(start, end, label) {
console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
});
});

function refresh(){
ShowGrafikBerkasAsisten();
ShowGrafikPekerjaanAsisten();
ShowGrafikBerkasHarian();
ShowGrafikPekerjaanPerizinan();
}

function ShowGrafikBerkasAsisten(){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>";       
$.ajax({
type:"post",
data:"token="+token,
url:"<?php echo base_url('User1/ShowGrafik') ?>",
success:function(data){
var r = JSON.parse(data);    
new Chart(document.getElementById('GrafikBerkasAsisten').getContext('2d'), {
type: 'bar',
data: {
labels:r.asisten,
datasets: [{
label: 'Grafik Berkas Asisten ',
backgroundColor:"#116466",
borderColor:"#DAA520",
BorderWidth:10,
data:r.jumlah
}]
},
options: {
scales: {
yAxes: [{
ticks: {
beginAtZero: true
}
}]
}
}
})  

}
});      
}
function ShowGrafikPekerjaanAsisten(){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>";       
$.ajax({
type:"post",
data:"token="+token,
url:"<?php echo base_url('User1/ShowGrafik') ?>",
success:function(data){
var r = JSON.parse(data);    
new Chart(document.getElementById('GrafikPekerjaanAsisten').getContext('2d'), {
type: 'bar',
data: {
labels:r.asisten,
datasets: [{
label: 'Grafik Pekerjaan Selesai ',
backgroundColor:"#FF8C00",
borderColor:"#116466",
BorderWidth:10,
data:r.pekerjaan
}]
},
options: {
scales: {
yAxes: [{
ticks: {
beginAtZero: true
}
}]
}
}
})  

}
});      
}

var ChartBerkasHarian =  new Chart(document.getElementById('GrafikBerkas').getContext('2d'), {
type: 'line',
data: {
labels:"",
datasets: [{
label: 'Grafik Berkas Masuk Perharinya ',
backgroundColor:"#116466",
borderColor:"#FF8C00",
BorderWidth:10,
data:""
}]
},
options: {
scales: {
yAxes: [{
ticks: {
beginAtZero: true
}
}]
}
}
});

function ShowGrafikBerkasHarian(chart){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>";       
var range =  $("#reportrange span").text();
$.ajax({
type:"post",
data:"token="+token+"&range="+range,
url:"<?php echo base_url('User1/ShowGrafikBerkas') ?>",
success:function(data){
var r = JSON.parse(data);
ChartBerkasHarian.data.labels = r.tanggal;
ChartBerkasHarian.data.datasets[0].data = r.jumlah;
ChartBerkasHarian.update();
}             
});
}

function ShowGrafikPekerjaanPerizinan(){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>";       
$.ajax({
type:"post",
data:"token="+token,
url:"<?php echo base_url('User1/ShowGrafikPerizinan') ?>",
success:function(data){
var r = JSON.parse(data);    
new Chart(document.getElementById('GrafikPerizinan').getContext('2d'), {
type: 'radar',
data: {
labels:r.nama,
datasets: [{
label: 'Grafik Peerizinan Selesai ',
backgroundColor:"#FF8C00",
borderColor:"#116466",
BorderWidth:10,
data:r.jumlah
}]
},
options: {
scales: {
yAxes: [{
ticks: {
beginAtZero: true
}
}]
}
}
})  

}
});      
}
</script>


</body>    