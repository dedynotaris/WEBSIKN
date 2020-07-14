<body onload="refresh()">
<?php $this->load->view('umum/user2/V_sidebar_user2'); ?>
<div id="page-content-wrapper">
<?php $this->load->view('umum/user2/V_navbar_user2'); ?>
<?php $this->load->view('umum/user2/V_data_user2'); ?>
<style>
.is-invalid .select2-selection {
border-color: rgb(185, 74, 72) !important;
}
</style>
<div class="container-fluid  ">
    <div class="row p-2">   
<div class="col mt-2">
<div class="row">
<div class="col">
<div id="reportrange" style="background: #fff; cursor: pointer; padding: 6px 18px; border: 1px solid #ccc; width: 100%">
<i class="fa fa-calendar"></i>
<span></span> <i class="fa fa-caret-down"></i>
</div>
</div>
  
<div class="col">
<button onclick="ShowGrafikBerkasHarian()" class="btn btn-dark btn-block ">Tampilkan Berkas Grafik Harian Anda <i class="fas fa-chart-line"></i></button>  
</div>    
<canvas id="GrafikBerkas" width="10" height="4"></canvas>

</div>    

</div>
    

</div>

</body>
</html>

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
function refresh(){
ShowGrafikBerkasHarian();
}

var ChartBerkasHarian =  new Chart(document.getElementById('GrafikBerkas').getContext('2d'), {
type: 'bar',
data: {
labels:"",
datasets: [{
label: 'Grafik Berkas Masuk Milik Kamu Perharinya ',
backgroundColor:"#17a2b8",
borderColor:"#17a2b8",
BorderWidth:3,
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
url:"<?php echo base_url('User2/ShowGrafikBerkas') ?>",
success:function(data){
var r = JSON.parse(data);
ChartBerkasHarian.data.labels = r.tanggal;
ChartBerkasHarian.data.datasets[0].data = r.jumlah;
ChartBerkasHarian.update();
}             
});
}

</script>