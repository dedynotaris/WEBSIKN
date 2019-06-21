<body>
<?php  $this->load->view('umum/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar_data_lama'); ?>
<div class="container-fluid ">
<div class="card-header mt-2 text-center ">
<h5 align="center">Upload data lama</h5>
</div>
    
    <div class="row">
        <div class="col">
            
            
            <label>Nama client</label>
            <div class="input-group mb-3">
  <input type="text" class="form-control nama_client"  aria-describedby="basic-addon2">
  <div class="input-group-append">
      <button class="btn btn-success add_client" type="button"><span class="fa fa-plus"></span> Client</button>
  </div>
</div>
            <label>No client</label>
            <input type="text" readonly="" class="form-control no_client">
            <label>Jenis Pekerjaan</label>
            <input type="text" class="form-control jenis_pekerjaan">
            <label>Pilih Jenis Dokumen</label>
            <select class="form-control">
                <option>Dokumen Perizinan</option>
                <option>Dokumen Utama</option>
         </select>
        </div>
        <div class="col">
            <label>Jenis Berkas</label>
            <input type="text" class="form-control">
            <label>Jenis Berkas</label>
            <input type="text" class="form-control">
            <label>Pilih File</label>
            <input type="file" class="form-control">
            <label>&nbsp;</label>
            <button class="btn btn-success btn-block">Simpan File <span class="fa fa-save"></span></button>
            </div>
    </div>    
    
    
</div>
</div>
    
<div class="modal fade" id="modal_tambah_client" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
          <label>Contact Person</label>
           <input type="text" class="form-control">
            
          <label>No Telepon</label>
           <input type="text"  class="form-control">
          
          <label>Pilih Jenis Client</label>
          <select onchange="jenis_client();" class="form-control jenis_client">
                <option value="1">Perorangan</option>
                <option value="2">Badan Hukum</option>
         </select>
         
          <div id="form_perorangan">
          <label>Nama Perorangan</label>
           <input type="text"  class="form-control">
          
          <label>Alamat Perorangan</label>
          <textarea class="form-control"></textarea>
          </div>
          
          <div id="form_badan_hukum" style="display: none;">
          <label>Nama Badan Hukum</label>
           <input type="text"  class="form-control">
          
          <label>Alamat Badan Hukum</label>
          <textarea class="form-control"></textarea>
          </div>
          <label>&nbsp;</label>
          <button class="btn btn-success btn-block">Simpan Client <span class="fa fa-save"></span></button>
          
      </div>
    </div>
  </div>
</div>   
    
 <script type="text/javascript">
$(function(){
var <?php echo $this->security->get_csrf_token_name();?>  = "<?php echo $this->security->get_csrf_hash(); ?>"       
$(".nama_client").autocomplete({
minLength:0,
delay:0,
source:'<?php echo site_url('Data_lama/cari_nama_client') ?>',
select:function(event, ui){
$(".no_client").val(ui.item.no_client);
}
}
);
});

$(function(){
var <?php echo $this->security->get_csrf_token_name();?>  = "<?php echo $this->security->get_csrf_hash(); ?>"       
$(".jenis_pekerjaan").autocomplete({
minLength:0,
delay:0,
source:'<?php echo site_url('Data_lama/cari_jenis_pekerjaan') ?>',
select:function(event, ui){
$(".no_client").val(ui.item.no_client);
}
}
);
});
    
$(document).ready(function(){
$(".add_client").click(function(){
$('#modal_tambah_client').modal('show');   
});


});

function jenis_client(){
var jenis_client = $(".jenis_client option:selected").val();

if(jenis_client == 2){
$("#form_badan_hukum").show();
$("#form_perorangan").hide();
}else{
$("#form_badan_hukum").hide();
$("#form_perorangan").show();    
}
}

</script>    
    
    
</body>
