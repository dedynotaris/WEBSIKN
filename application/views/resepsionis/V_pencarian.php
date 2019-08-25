<body>
<?php  $this->load->view('umum/V_sidebar_resepsionis'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/V_navbar_resepsionis'); ?>
<div class="container-fluid mt-2 text-theme1">
<ul class="nav nav-tabs">
<li class="nav-item">
<a class="nav-link active" data-toggle="tab" href="#dokumen">Hasil Pencarian Dokumen <?php echo $data_dokumen->num_rows(); ?> </a>
</li>

<li class="nav-item ml-1">
<a class="nav-link" data-toggle="tab" href="#utama">Hasil Pencarian Dokumen Utama  <?php echo $data_dokumen_utama->num_rows(); ?>    </a>
</li>
<li class="nav-item ml-1">
<a class="nav-link" data-toggle="tab" href="#client">Hasil Pencarian Client <?php echo $data_client->num_rows(); ?>    </a>
</li>

</ul>    

<div class="tab-content">
<div class="tab-pane  active " id="dokumen">
    <div class="container-fluid overflow-auto " style="max-height:1000px;">
        <?php if($data_dokumen->num_rows() != 0){ ?>
    <div class="row card-header rounded">
            <div class="col">Nama client</div>
            <div class="col">Nama Dokumen</div>
            <div class="col">Hasil</div>
            <div class="col-sm-2">Aksi</div>
       
        </div>   
        
 <?php foreach ($data_dokumen->result_array() as $dokumen){
echo "<div class='row mt-1 rounded card-header'>";
echo "<div class='col'>".$dokumen['nama_client']."</div>"
    ."<div class='col'>".$dokumen['nama_dokumen']."</div>"
    ."<div class='col'>".$dokumen['nama_meta'].": ".$dokumen['value_meta']."</div>"
    . "<div class='col-sm-2'>"
    . "<button onclick=cek_download_berkas('".base64_encode($dokumen['no_berkas'])."'); class='btn btn-outline-success col-md-6 btn-sm'><span class='fa fa-download'></span></button>"
    . "<button onclick=lihat_meta_berkas('".base64_encode($dokumen['no_nama_dokumen'])."','". base64_encode($dokumen['no_client'])."'); class='btn btn-outline-success  col-md-5 ml-1  btn-sm'><span class='fa fa-eye'></span></button>"
    . "</div>"   
    . "</div>";    
}
        }
?>
</div>    
</div>

<div class="tab-pane " id="utama"> 
    <div class="container-fluid overflow-auto " style="max-height:1000px;">
    <?php if($data_dokumen_utama->num_rows() != 0){ ?>

        <div class="row card-header rounded">
            <div class="col">Nama Berkas</div>
            <div class="col-sm-2">Tanggal akta</div>
            <div class="col-sm-2 text-center">Aksi</div>
        </div>   
    
   
<?php foreach ($data_dokumen_utama->result_array() as $utama){
echo "<div class='row mt-1 card-header rounded'>"
    . "<div class='col'>".$utama['nama_berkas']."</div>"
    . "<div class='col-sm-2'>".$utama['tanggal_akta']."</div>"
    . "<div class='col-sm-2 text-center'>"
    . "<button onclick=download_utama('".base64_encode($utama['id_data_dokumen_utama'])."') class='btn  col-md-6 btn-success btn-sm'>File <span class='fa fa-download'></span></button>"
    . "</div>"
     . "</div>";    
}
    }
?>
</div>
    
</div>

    
<div class="tab-pane" id="client">
  <div class="container-fluid overflow-auto " style="max-height:1000px;">
  
<?php if($data_client->num_rows() != 0){ ?>
      <div class="row card-header rounded">
            <div class="col">Nama Client</div>
            <div class="col-sm-2 text-center">Aksi</div>
        </div>   
      
      
     <?php foreach ($data_client->result_array() as $client){ 
       echo "<div class='row card-header rounded mt-1'>"
    . "<div class='col'>".$client['nama_client']."</div>"
    . "<div class='col-sm-2'>"
    . "<button onclick=lihat_berkas_client('".base64_encode($client['no_client'])."'); class='btn  bt-block btn-success btn-sm'> Lihat berkas <span class='fa fa-eye'></span></button>"
    . "</div>"
    . "</div>";
      
      }
}?>
      
      
</div>
</div>    
</div>
</div>
<!------------------modal data perekaman------------->
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
    
<script type="text/javascript">
function cek_download_berkas(no_berkas){

var token           = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_berkas="+no_berkas,
url:"<?php echo base_url('Resepsionis/cek_download_berkas') ?>",
success:function(data){
var r = JSON.parse(data);
if(r.status == 'success'){
window.location.href = '<?php echo base_url('Resepsionis/download_berkas/') ?>'+no_berkas;   
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

function lihat_meta_berkas(no_nama_dokumen,no_client){
var token           = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_nama_dokumen="+no_nama_dokumen+"&no_client="+no_client,
url:"<?php echo base_url('Resepsionis/data_perekaman_pencarian') ?>",
success:function(data){
  
$('#data_perekaman').modal('show');  
$(".data_perekaman").html(data);
}
});
}
function download_utama(id){
window.location.href="<?php echo base_url('Resepsionis/download_utama/'); ?>"+id 
}

function lihat_berkas_client(no_client){   
var token           = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_client="+no_client,
url:"<?php echo base_url('Resepsionis/data_perekaman_user_client') ?>",
success:function(data){ 
$('#data_perekaman').modal('show');  
$(".data_perekaman").html(data);
}
});
}    

</script>        
        
    
</html>
