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
url:'<?php echo base_url('User2/set_toggled') ?>',
data:"token="+token,
success:function(data){
console.log(data);    
}    
});
        
}
</script> 
