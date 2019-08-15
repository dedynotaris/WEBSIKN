<div class="row"><?php $static = $dokumen_persyaratan->row_array(); ?>    

<div class="col-md-7 card">
<div class="text-center card"><b>Dokumen Penunjang yang harus direkam <br> <?php echo $static['nama_jenis'] ?></b></div>
<hr>    
<?php
foreach ($dokumen_persyaratan->result_array() as $d){ ?>
<div class="row">
<div class="col card-header"><?php echo $d['nama_dokumen'] ?></div>    
<div class="card-header col-md-3"><button class="btn btn-block btn-dark m-1 btn-sm" onclick="tampil_modal_upload('<?php echo $d['no_pekerjaan'] ?>','<?php echo $d['no_nama_dokumen'] ?>','<?php echo $d['no_client'] ?>')"> Rekam Data <span class="fa fa-eye"></span> </button></div>   
</div>
<?php } ?>

</div>
<div class="col">
    <div class="text-center card"><b>Nama Dokumen yang sudah direkam <br> <?php echo $static['nama_client'] ?></b></div>
<hr>    
    
<div class="syarat_telah_dilampirkan">

</div>
</div>
</div>
</div>    

<div class="modal fade" id="modal_upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document">
<div class="modal-content ">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel text-center">Perekaman data<span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<form  id="fileForm" method="post" action="<?php echo base_url('Data_lama/simpan_persyaratan') ?>">

<div class="modal-body form_persyaratan">


</div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-md btn-block btn-dark">Simpan <span class="fa fa-save"></span></button>    
</div>
</form>    
</div>
</div>
</div>
<script type="text/javascript">
function lihat_data_perekaman(no_nama_dokumen,no_pekerjaan){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_nama_dokumen="+no_nama_dokumen+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('Data_lama/data_perekaman') ?>",
success:function(data){
$(".data_perekaman").html(data);    
$('#data_perekaman').modal('show');
}

});
}
function tampil_modal_upload(no_pekerjaan,no_nama_dokumen,no_client){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_pekerjaan="+no_pekerjaan+"&no_nama_dokumen="+no_nama_dokumen+"&no_client="+no_client,
url:"<?php echo base_url('Data_lama/form_persyaratan') ?>",
success:function(data){
$('.form_persyaratan').html(data);    
$('#modal_upload').modal('show');
var inputQuantity = [];
    $(function() {
      $(".quantity").each(function(i) {
        inputQuantity[i]=this.defaultValue;
         $(this).data("idx",i); // save this field's index to access later
      });
      $(".quantity").on("keyup", function (e) {
        var $field = $(this),
            val=this.value,
            $thisIndex=parseInt($field.data("idx"),10); // retrieve the index
        if (this.validity && this.validity.badInput || isNaN(val) || $field.is(":invalid") ) {
            this.value = inputQuantity[$thisIndex];
            return;
        } 
        if (val.length > Number($field.attr("maxlength"))) {
            var t = Number($field.attr("maxlength"));
          val=val.slice(0,t);
          $field.val(val);
        }
        inputQuantity[$thisIndex]=val;
      });      
    });
}    
});
}


$("#fileForm").submit(function(e) {
e.preventDefault();
$.validator.messages.required = '';
}).validate({
highlight: function (element, errorClass) {
$(element).closest('.form-control').addClass('is-invalid');
},
unhighlight: function (element, errorClass) {
$(element).closest(".form-control").removeClass("is-invalid");
},    
submitHandler: function(form) {

var result = { };
var jml_meta = $('.meta').length;
for (i = 1; i <=jml_meta; i++) {
var key   =($("#data_meta"+i).attr('name'));
var value =($("#data_meta"+i).val());
$.each($('form').serializeArray(), function() {
result[key] = value;
});
}

var token             = "<?php echo $this->security->get_csrf_hash() ?>";
var name = $("#id").attr("name");

formdata = new FormData();
formdata.append("token", token);
file = $("#file_berkas").prop('files')[0];;
formdata.append("file_berkas", file);
formdata.append("no_nama_dokumen",$(".no_nama_dokumen").val());
formdata.append("no_client",$(".no_client").val());
formdata.append("no_pekerjaan",$(".no_pekerjaan").val());
formdata.append('data_meta', JSON.stringify(result));


$.ajax({
url: form.action,
processData: false,
contentType: false,
type: form.method,
data: formdata,
success:function(data){
    
persyaratan_telah_dilampirkan();    
var r = JSON.parse(data);
const Toast = Swal.mixin({
toast: true,
position: 'center',
showConfirmButton: false,
timer: 3000,
animation: false,
customClass: 'animated bounceInDown'
});

Toast.fire({
type: r.status,
title: r.pesan
});

}

});
return false; 
}
});


function persyaratan_telah_dilampirkan(){
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token,
url:"<?php echo base_url('Data_lama/persyaratan_telah_dilampirkan/'.$this->uri->segment(3)) ?>",
success:function(data){
$('.syarat_telah_dilampirkan').html(data);
}
});
}
</script>    
    
    <div class="modal fade" id="data_perekaman" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-xl" role="document">
<div class="modal-content ">
<div class="modal-header">
<h6 class="modal-title" id="exampleModalLabel text-center">Data yang telah direkam<span class="i"><span></h6>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>

<div class="modal-body data_perekaman">


</div>
</div>
</div>
</div>