<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
<div class="row col-md-12 align-items-center">
<div class="col-xs-1">
<button class="btn btn-block btn-info" id="menu-toggle"><span id="z" class="fa fa-chevron-left"> </span></button>
</div>

<div class="col ">
    <form class="input-group mb-0" action="<?php echo base_url("DataArsip/pencarian/") ?>" method="get">
     <div class="input-group col  ">
         <input name="search" minlength="1" class="form-search py-2 border-right-0 border" type="text" placeholder="Masukan Nama Perorangan atau Badan Hukum" id="example-search-input">
           <input type="hidden" class="form-control" name="<?php echo  $this->security->get_csrf_token_name() ?>" value="<?php echo $this->security->get_csrf_hash() ?>" />
        <input type="hidden" name="kategori" value="data_client">
           <span class="input-group-append">
              <button type="submit" class="btn  btn-tranparent mr-3" type="button">
                    <i class="fa fa-search"></i>
              </button>
            </span>
        </div>
        </form>
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
toastr.success(z[i].nama_dokumen+("<br><button class='btn btn-sm  btn-block btn-warning' onclick=dilihat('"+z[i].no_berkas_perizinan+"');>Ok saya mengetahui</button>"), 'Pekerjaan baru', {
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
function dilihat(no_berkas_perizinan){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_berkas_perizinan="+no_berkas_perizinan,
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
var token  = "<?php echo $this->security->get_csrf_hash(); ?>";      
    
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
