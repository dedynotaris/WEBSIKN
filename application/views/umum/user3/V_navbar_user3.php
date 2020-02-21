<style>
form {
    display: inherit;
    width: inherit;
    margin-bottom: 0;
}    
</style>    
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
<div class="row col-md-12 align-items-center">
<div class="col-xs-2">
<button class="btn btn-success" id="menu-toggle"><span id="z" class="fa fa-chevron-left"> </span></button>
</div>
<div class="col mx-auto ">
<div class="input-group">
    <form  action="<?php echo base_url("DataArsip/pencarian/") ?>" method="get" >       
        <input type="hidden" class="form-control" name="<?php echo  $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
        <input type="hidden" name="kategori" value="dokumen_penunjang">
         <input type="text" name="search" class="form-control" placeholder="Masukan Nama Perorangan atau Badan Hukum" aria-label="Recipient's username" aria-describedby="button-addon2">
  <div class="input-group-append">
      <button   class="btn btn-success" type="submit" ><span class="fa fa-search"</button>
  </form>
</div>
</div>
</div>

<div class="col-xs-2 float-right"><button class="navbar-toggler float-md-right float-xs-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
<ul class="navbar-nav ml-auto mt-2 mt-lg-0">
<li class="nav-item active">
<a class="nav-link" href="<?php echo base_url() ?>">Beranda <span class="fa fa-home "></span></a>
</li>

</ul>
</div> 
</div>
    
</div>
</nav>
<body onload="data_pekerjaan();"></body>

<script type="text/javascript">

function data_pekerjaan(){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token,
url:"<?php echo base_url('User3/data_pekerjaan_baru') ?>",
success:function(data){

var z = JSON.parse(data);

for(i=0; i<z.length; i++){
toastr.success(z[i].nama_dokumen+("<br><button class='btn btn-sm  btn-block btn-warning' onclick='dilihat("+z[i].id_perizinan+");'>Ok saya mengetahui</button>"), 'Pekerjaan baru', {
 "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "0",
  "extendedTimeOut": "0",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
  });    
}    


}    
});
}
function dilihat(id_perizinan){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&id_perizinan="+id_perizinan,
url:"<?php echo base_url('User3/dilihat') ?>",
success:function(data){

}
});

}
$('.toast').toast('show')   
</script>

<script type="text/javascript">
$("#menu-toggle").click(function(e) {
e.preventDefault();
$("#wrapper").toggleClass("toggled");
var cek_icon = $(".fa-chevron-left").html();
if(cek_icon != undefined){
$("#z").addClass("fa-chevron-right");
set_toggled();
}else{
$("#z").addClass("fa-chevron-left");
set_toggled();
}



});
function set_toggled(){
var <?php echo $this->security->get_csrf_token_name();?>  = "<?php echo $this->security->get_csrf_hash(); ?>";      
    
$.ajax({
type:"post",
url:'<?php echo base_url('User3/set_toggled') ?>',
data:"token="+token,
success:function(data){
console.log(data);    
}    
});
        
}
</script>