<body onload="refresh()">
<?php  $this->load->view('umum/data_lama/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/data_lama/V_navbar_data_lama'); ?>
<?php  $this->load->view('umum/data_lama/V_data_data_lama'); ?>
<div class="container-fluid ">
<div class="row  mt-4">
<div class="col">
<div id="reportrange" style="background: #fff; cursor: pointer; padding: 6px 18px; border: 1px solid #ccc; width: 100%">
<i class="fa fa-calendar"></i>
<span></span> <i class="fa fa-caret-down"></i>
</div>
</div>
<div class="col">
        <button onclick="ShowGrafikBerkasHarian()" class="btn  btn-info btn-block">Show Grafik Berkas <i class="fas fa-chart-line"></i></button>  
    </div>    
</div>    

<hr>    
<canvas id="GrafikBerkas" width="200" height="70"></canvas>
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
ShowGrafikBerkasHarian();
}


var ChartBerkasHarian =  new Chart(document.getElementById('GrafikBerkas').getContext('2d'), {
type: 'line',
data: {
labels:"",
datasets: [{
label: 'Grafik Berkas Masuk Perharinya ',
backgroundColor:"#17a2b8",
borderColor:"#17a2b8",
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
url:"<?php echo base_url('Data_lama/ShowGrafikBerkas') ?>",
success:function(data){
var r = JSON.parse(data);
ChartBerkasHarian.data.labels = r.tanggal;
ChartBerkasHarian.data.datasets[0].data = r.jumlah;
ChartBerkasHarian.update();
}             
});
}

</script>
