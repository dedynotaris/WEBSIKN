<body>
<?php $this->load->view('umum/user2/V_sidebar_user2'); ?>
<div id="page-content-wrapper">
<?php $this->load->view('umum/user2/V_navbar_user2'); ?>
<div class="container-fluid mt-2 text-theme1">
<ul class="nav nav-tabs">
<li class="nav-item">
<a class="nav-link active" data-toggle="tab" href="#dokumen">Dokumen Penunjang (<?php echo $data_dokumen->num_rows(); ?>) </a>
</li>

<li class="nav-item ml-1">
<a class="nav-link" data-toggle="tab" href="#utama">Dokumen Utama  (<?php echo $data_dokumen_utama->num_rows(); ?>)    </a>
</li>
<li class="nav-item ml-1">
<a class="nav-link" data-toggle="tab" href="#client">Client (<?php echo $data_client->num_rows(); ?>)    </a>
</li>

</ul>    

<div class="tab-content">

<div class="tab-pane  active " id="dokumen">
<div class="container-fluid overflow-auto " style="max-height:1000px;">
 <div class='row '>          
 <?php foreach ($data_dokumen->result_array() as $dokumen){
$ext = pathinfo($dokumen['nama_berkas'], PATHINFO_EXTENSION);
echo "<div onclick=LihatDokumenPenunjang('".$dokumen['no_berkas']."'); class='col hasil  m-1 d-flex justify-content-center text-center'>
<div style='width:210px; height:210px;' class='card'>
<div class='card-body'>";
if($ext =="docx" || $ext =="doc" ){
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/wordicon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}else if($ext == "xlx"  || $ext == "xlsx"){
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/excelicon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}else if($ext == "PDF"  || $ext == "pdf"){
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/pdficon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}else if($ext == "JPG"  || $ext == "jpg" || $ext == "png"  || $ext == "PNG"){
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/imageicon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}else{
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/othericon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}

echo "
</div>
<div class='card-footer'><span style='font-size:12px;'>".$dokumen['nama_dokumen']."<br>".$dokumen['nama_client']."</span></div>
</div></div>";


}
?>
</div>    
</div>    
</div>
<!------------------------------------------->
<div class="tab-pane " id="utama"> 
    <div class="container-fluid overflow-auto " style="max-height:1000px;">
    <div class='row '>  
      <?php if($data_dokumen_utama->num_rows() != 0){ ?>

     
   
<?php foreach ($data_dokumen_utama->result_array() as $utama){
$ext = pathinfo($utama['nama_file'], PATHINFO_EXTENSION);
echo "<div onclick=LihatDokumenUtama('".$utama['id_data_dokumen_utama']."'); class='col hasil  m-1 d-flex justify-content-center text-center'>
<div style='width:210px; height:210px;' class='card'>
<div class='card-body'>";
if($ext =="docx" || $ext =="doc" ){
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/wordicon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}else if($ext == "xlx"  || $ext == "xlsx"){
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/excelicon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}else if($ext == "PDF"  || $ext == "pdf"){
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/pdficon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}else if($ext == "JPG"  || $ext == "jpg" || $ext == "png"  || $ext == "PNG"){
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/imageicon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}else{
echo"<img style='width:80px; height:80px;'  src='".base_url('assets/othericon.png')."' alt='MS WORD' class='  img-thumbnail'>";
}

echo "
</div>
<div class='card-footer'><span style='font-size:12px;'>".$utama['nama_berkas']."</span></div>
</div></div>";

}
}
?>

</div>
</div>
</div>

    
<div class="tab-pane" id="client">
  <div class="container-fluid overflow-auto " style="max-height:1000px;">
  <div class='row '>  
<?php if($data_client->num_rows() != 0){ ?>
    <?php foreach ($data_client->result_array() as $client){
        echo "<div onclick=lihat_berkas_client('".base64_encode($client['no_client'])."'); class='col hasil  m-1 d-flex justify-content-center text-center'>
        <div style='width:210px; height:210px;' class='card'>
         <div class='card-body'>";
         if($client['jenis_client'] =="Badan Hukum" ){
          echo"<img style='width:80px; height:80px;'  src='".base_url('assets/badanhukumicon.png')."' alt='MS WORD' class='  img-thumbnail'>";
        }else if($client['jenis_client'] =="Perorangan"){
            echo"<img style='width:80px; height:80px;'  src='".base_url('assets/peroranganicon.png')."' alt='MS WORD' class='  img-thumbnail'>";
          }

        echo "
        </div>
        <div class='card-footer'><span style='font-size:12px;'>".$client['nama_client']."</span></div>
        </div></div>";
 
      }
   }
   ?>
   
      
</div>     
      
</div>
</div>    
</div>
</div>



<!------------------modal data perekaman------------->
<div class="modal fade" id="data_perekaman" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document">
</div>
</div>    
    
<script type="text/javascript">
$(document).ready(function(){
  $(".hasil").mouseover(function(){
    $(this).find(" > div").css("background-color","#FF8C00").css('cursor', 'pointer');
    $(this).mouseout(function(){
   $(this).find(" > div").css("background-color","white");
 });
});
 

});
function cek_download_berkas(no_berkas){
var token           = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_berkas="+no_berkas,
url:"<?php echo base_url('Dashboard/cek_download_berkas') ?>",
success:function(data){
var r = JSON.parse(data);
if(r.status == 'success'){
window.location.href = '<?php echo base_url('Dashboard/download_berkas/') ?>'+no_berkas;   
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

function download_utama(id){
window.location.href="<?php echo base_url('Dashboard/download_utama/'); ?>"+id 
}

function lihat_berkas_client(no_client){   
window.location.href="<?php echo base_url($this->uri->segment(1)."/DetailClient/") ?>"+no_client;    
}    

function LihatDokumenPenunjang(NoBerkas){
var token           = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_berkas="+NoBerkas,
url:"<?php echo base_url('Dashboard/data_perekaman_pencarian') ?>",
success:function(data){
$('#data_perekaman').modal('show');  
$(".modal-dialog").html(data);
}})
}

function LihatDokumenUtama(id_data_dokumen_utama){
var token           = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&id_data_dokumen_utama="+id_data_dokumen_utama,
url:"<?php echo base_url('Dashboard/data_perekaman_utama') ?>",
success:function(data){
$('#data_perekaman').modal('show');  
$(".modal-dialog").html(data);
}})
}


function lihat_gambar(nama_folder,nama_berkas){
    window.open("<?php echo base_url('berkas/'); ?>"+nama_folder+"/"+nama_berkas, '_blank');
}
function lihat_pdf(nama_folder,nama_berkas){
    window.open("<?php echo base_url('berkas/'); ?>"+nama_folder+"/"+nama_berkas, '_blank');
}


</script>        
        
    
</html>
