<body onload="refresh()">
<?php  $this->load->view('umum/V_sidebar'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar'); ?>
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
</body>