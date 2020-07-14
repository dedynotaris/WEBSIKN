
<body style="background: url(<?php echo base_url('assets') ?>/bg_login.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover; " >
<br>
<br>
<div class="container ">
<div class="row"> 
<div class='col-md-10 mx-auto' style='-webkit-box-shadow: 0px 10px 13px -7px #000000, 5px 27px 8px 3px rgba(0,0,0,0); 
box-shadow: 0px 10px 13px -7px #000000, 5px 27px 8px 3px rgba(0,0,0,0)'>
<div class="row">    
<div class="col shadow-lg p-3 text-center  text-white " style="background: url(<?php echo base_url('assets') ?>/bg_login.jpg) no-repeat center center fixed ; 
 object-fit: cover;">
<br>
<p  class='h2 m-2 p-3'>Website Document Management</p>
<img style='width:180px;  '   class='bg-light rounded-circle opacity-90' src='<?php echo base_url('assets/icon.png') ?>'>      
<p class="text-center  mt-5">&copy; 2020 Sistem Informasi Kantor Notaris <br> Dewantari Handayani, SH, MPA. <br></p>

</div>

<div class="col-md-5   shadow-xl p-4  bg-white  " style='-webkit-box-shadow: 0px 10px 13px -7px #000000, 5px 27px 8px 3px rgba(0,0,0,0); 
box-shadow: 0px 10px 13px -7px #000000, 5px 27px 8px 3px rgba(0,0,0,0)' >
<div class='text-center text-info h4 mb-5 '>
<svg width="4em" height="4em" viewBox="0 0 16 16" class="bi bi-key" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z"/>
  <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
</svg><br>
Masuk
</div>
<form id="FormLogin" >

<input type="hidden" name="token" value="<?php echo $this->security->get_csrf_hash() ?>">
<label class="text-dark">Username</label>
<input type="text" class="form-control" id="username" name="username"  placeholder="Masukan username ">
<label class="text-dark">Password</label>
<input type="password" class="form-control" id="password" name="password"  placeholder="Masukan password ">
<br>
</form>
<button type="button" class="btn   btn-block btn-danger" id="proses_login">Masuk

</button>
</div>

</div> 


</body>

<script type="text/javascript">
var callback = function() {

$("#proses_login").attr("disabled", true);
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


