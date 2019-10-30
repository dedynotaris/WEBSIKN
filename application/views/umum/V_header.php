<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">		    
<link href="<?php echo base_url() ?>assets/croppie/croppie.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url() ?>assets/croppie/croppie.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/jquery/jquery-3.3.1.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/datatables/datatables.min.js" type="text/javascript"></script>
<link href="<?php echo base_url() ?>assets/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url() ?>assets/jquery-ui-1.12.1/jquery-ui.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/bootstrap-4.1.3/dist/js/bootstrap.bundle.js" type="text/javascript"></script>
<link href="<?php echo base_url() ?>assets/bootstrap-4.1.3/dist/css/bootstrap.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() ?>assets/fontawesome-free-5.7.1/css/all.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url() ?>assets/fontawesome-free-5.7.1/js/all.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/jquery/popper.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/sweetalert2/dist/sweetalert2.all.js" type="text/javascript"></script>
<link href="<?php echo base_url() ?>assets/sweetalert2/dist/sweetalert2.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() ?>assets/sweetalert2/dist/animate.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() ?>assets/datatables/datatables.min.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url() ?>assets/jqueryvalidation/dist/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/jqueryvalidation/dist/additional-methods.js" type="text/javascript"></script>
<link href="<?php echo base_url() ?>assets/npprogress/nprogress.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url() ?>assets/npprogress/nprogress.js" type="text/javascript"></script>
<link href="<?php echo base_url() ?>assets/bootstrap-4.1.3/dist/css/simple-sidebar.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url() ?>assets/daterange/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/daterange/daterangepicker.js" type="text/javascript"></script>
<link href="<?php echo base_url() ?>assets/daterange/daterangepicker.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url() ?>assets/bootstrap-4.1.3/js/dist/util.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/toast/build/toastr.min.js" type="text/javascript"></script>
<link href="<?php echo base_url() ?>assets/toast/build/toastr.min.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() ?>assets/EasyAutocomplete-1.3.5/easy-autocomplete.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url() ?>assets/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/jquery/numeral.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/clipboard.js/dist/clipboard.js" type="text/javascript"></script>
<link href="<?php echo base_url() ?>assets/select2-4.0.11/dist/css/select2.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url() ?>assets/select2-4.0.11/dist/js/select2.js" type="text/javascript"></script>
</head>


<script type="text/javascript">
jQuery( document ).ajaxStart(function() {
NProgress.start();
$("#loading").show();
});
jQuery( document ).ajaxStop(function() {
NProgress.done();
$("#loading").hide();
});


$(document).ready(function(){
$(".search").keyup(function(){
var token      = "<?php echo $this->security->get_csrf_hash() ?>";
var kata_kunci = $(".search").val();    
$.ajax({
type:"post",
data:"token="+token+"&kata_kunci="+kata_kunci,
url:"<?php echo base_url('User2/cari_data') ?>",
success:function(data){
console.log(data);
}

});

});

});

function setTooltip(btn, message) {
  $(btn).tooltip('hide')
    .attr('data-original-title', message)
    .tooltip('show');
}

function hideTooltip(btn) {
  setTimeout(function() {
    $(btn).tooltip('hide');
  }, 1000);
}
</script>


<script type="text/javascript">
$(document).ready(function(){
 var token           = "<?php echo $this->security->get_csrf_hash() ?>";
  
 var options = {
    url: function(kata_kunci) {
    return "<?php echo base_url($this->uri->segment(1).'/data_pencarian') ?>";
  },
   ajaxSettings: {
    dataType: "json",
    method: "POST",
    data: {
      token   : token
    }
  },

  preparePostData: function(data) {
    data.kata_kunci = $("#pencarian").val();
    return data;
  },
          list: {
		onChooseEvent: function(value,data) {
    var kata_kunci = $("#pencarian").val();
    $('#button_cari').submit();
},showAnimation: {
			type: "fade", //normal|slide|fade
			time: 400,
			callback: function() {}
		},

		hideAnimation: {
			type: "slide", //normal|slide|fade
			time: 400,
			callback: function() {}
		}	
	},
    categories: [
        {  
            listLocation: "data_dokumen",
            header: "<div>Hasil Pencarian Data Dokumen Penunjang</div>"
        },{  
            listLocation: "data_dokumen_utama",
            header: "<div>Hasil Pencarian Data Dokumen Utama</div>"
        }, 
        {  
            listLocation: "data_client",
            header: "<div > Hasil Pencarian Data Client</div>"
        }
    ]

};

$("#pencarian").easyAutocomplete(options);
 
}); 


function cek_download(no_berkas){

var token           = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_berkas="+no_berkas,
url:"<?php echo base_url($this->uri->segment(1).'/cek_download_berkas') ?>",
success:function(data){
var r = JSON.parse(data);
if(r.status == 'success'){
window.location.href = '<?php echo base_url($this->uri->segment(1).'/download_berkas/') ?>'+no_berkas;   
}else{
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated tada'
});

Toast.fire({
type: r.status,
title: r.pesan
});
}
}
});
}

function read_response(data){
var r =JSON.parse(data); 

const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated bounce'
});

Toast.fire({
type: r[0].status,
title: r[0].messages
});
}

</script>