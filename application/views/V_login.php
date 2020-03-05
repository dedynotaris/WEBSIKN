
<body  style="background: url(<?php echo base_url('assets') ?>/bg_login.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover; " class="bg_login">
<br>
<br>
<div class="container ">

<div class="row">    
   
<div class="col-md-4 mx-auto " >
<div class='text-center'>
<img style='width:200px;' src='<?php echo base_url('assets/icon.png') ?>'>      
</div>
<form id="FormLogin" >

<input type="hidden" name="token" value="<?php echo $this->security->get_csrf_hash() ?>">
<label>Username</label>
<input type="text" class="form-control" id="username" name="username"  placeholder="username . . .">
<label>Password</label>
<input type="password" class="form-control" id="password" name="password"  placeholder="password . . .">
<br>
</form>
<button type="button" class="btn btn-md btn-outline-dark btn-block" id="proses_login">Sign in <i class="fa fa-key"></i></button>
</div>
</div> 

</div>
</div>

</div>
<div class="mt-5 pt-5">
<div class="row">
<div class="mx-auto">    
<p class="text-center">App Management Document <br> V.2.1</p>
</div>
</div>
</div>   
</body>
<script type="text/javascript">
var callback = function() {

//$("#proses_login").attr("disabled", true);
$("#FormLogin").find(".form-control").removeClass("is-invalid").addClass("is-valid");
$("#FormLogin").find('.form-control + p').remove();

$.ajax({
type:"post",
url:"<?php echo base_url('Login/proses_login') ?>",
data:$("#FormLogin").serialize(),
success:function(data){
var r =JSON.parse(data);
if(r[0].status == 'error_validasi'){
$.each(r[0].messages, function(key, value){
$.each(value, function(key2, value2){
$("#FormLogin").find("#"+key2).addClass("is-invalid").after("<p class='"+key2+"alert text-danger'>"+value2+"</p>").removeClass("is-valid");

});
});

}else if(r[0].status == "success"){
const Toast = Swal.mixin({
toast: true,
position: 'top',
showConfirmButton: false,
timer: 1000,
animation: false,
customClass: 'animated fadeInDown'
});

Toast.fire({
type: 'success',
title: r[0].messages
}).then(function() {
window.location.href = "<?php echo base_url('DataArsip'); ?>";
});    
}
$('#proses_login').removeAttr("disabled");
}
});


};

$(document).keypress(function() {
if (event.which == 13) callback();
});
$('#proses_login').click(callback);   
</script>

<html>


