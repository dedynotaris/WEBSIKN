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
<div class="container-fluid p-2 ">
    <div class="row">   
<div class="col-md-9">
<div class="row">
<div class="col">
<div id="reportrange" style="background: #fff; cursor: pointer; padding: 2px 18px; border: 1px solid #ccc; width: 100%">
<i class="fa fa-calendar"></i>
<span></span> <i class="fa fa-caret-down"></i>
</div>
</div>
  
<div class="col">
<button onclick="ShowGrafikBerkasHarian()" class="btn btn-sm btn-warning btn-block ">Tampilkan Berkas Grafik Harian <i class="fas fa-chart-line"></i></button>  
</div>    
</div>    

<hr>    
<canvas id="GrafikBerkas" width="200" height="80"></canvas>
</div>
    
<div class="col">
    <div class="row">
        <div class="col-md-12 mt-4">
            <div class="bg_data rounded-top">
<div class="p-2 text-center">
    <h5><?php 
    $this->db->select('');
$this->db->from('data_berkas_perizinan');
$this->db->where('data_pekerjaan.no_user',$this->session->userdata('no_user'));
$this->db->where_in('data_berkas_perizinan.status_berkas',array('Masuk','Selesai'));
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_berkas_perizinan.no_pekerjaan');
$perizinan = $this->db->get();

echo $perizinan->num_rows();    
    ?></h5>   
</div>
<div class="footer p-2 bg-dark text-white text-center" >Perizinan sedang dikerjakan <div class="float-right">
</div></div>
</div>
            
        </div>
        
        <div class="col-md-12 mt-4">
            <div class="bg_data rounded-top">
<div class="p-2 text-center">
    <h5><?php 
    $this->db->select('');
$this->db->from('data_berkas');
$this->db->where('data_pekerjaan.no_user',$this->session->userdata('no_user'));
$this->db->where_in('data_pekerjaan.status_pekerjaan',array('ArsipSelesai','Selesai'));
$this->db->join('data_pekerjaan', 'data_pekerjaan.no_pekerjaan = data_berkas.no_pekerjaan');
$query = $this->db->get();

echo $query->num_rows();    
    ?></h5>   
</div>
<div class="footer p-2 bg-dark text-white text-center" >Total data berkas <div class="float-right">
</div></div>
</div>
            
        </div>
        <div class="col-md-12 mt-4">
            <div class="bg_data rounded-top">
<div class="p-2 text-center">
    <h5><?php 
    $this->db->select('');
$this->db->from('data_pekerjaan');
$this->db->where('data_pekerjaan.no_user',$this->session->userdata('no_user'));
$this->db->where_in('status_pekerjaan',array('ArsipSelesai','Selesai'));
echo $pekerjaan = $this->db->get()->num_rows();
    ?></h5>   
</div>
<div class="footer p-2 bg-dark text-white text-center" >Total pekerjaan selesai<div class="float-right">

</div></div>
</div>
        </div>
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
backgroundColor:"#116466",
borderColor:"#FF8C00",
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