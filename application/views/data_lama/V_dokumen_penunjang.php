
<table style="width:100%;" id="data_berkas" class="table  text-theme1  table-striped table-condensed table-sm table-bordered  table-hover table-sm"><thead>
<tr role="row">
<th  align="center" aria-controls="datatable-fixed-header"  >No</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Nama lampiran</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Jenis Dokumen</th>
<th  align="center" aria-controls="datatable-fixed-header"  >Aksi</th>
</thead>
<tbody >
</table>

    

<div class="modal fade" id="data_perekaman" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-md" role="document">
</div>
</div>    



<script type="text/javascript">
function lihat_meta(no_pekerjaan,no_berkas,no_client){
if($(".hasil"+no_berkas).length > 0 ){
$('.hasil'+no_berkas).slideUp("slow").remove();
$(".btn-lihat"+no_berkas).addClass("btn-dark").removeClass("btn-warning").html("Lihat");
}else{    
var token             = "<?php echo $this->security->get_csrf_hash() ?>";
$.ajax({
type:"post",
data:"token="+token+"&no_berkas="+no_berkas+"&no_client="+no_client+"&no_pekerjaan="+no_pekerjaan,
url:"<?php echo base_url('data_lama/lihat_meta') ?>",
success:function(data){
$("."+no_berkas).after(data);    
$(".btn-lihat"+no_berkas).addClass("btn-warning").removeClass("btn-dark").html("Tutup ");
}
});
}
}

function hapus_lampiran(no_berkas){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>"       
$.ajax({
type:"post",
url:"<?php echo base_url($this->uri->segment(1).'/hapus_lampiran') ?>",
data:"token="+token+"&no_berkas="+no_berkas,
success:function(data){
read_response(data);
$('#data_perekaman').modal('hide');
refresh_table_pekerjaan();
}
});    
    
} 
function refresh_table_pekerjaan(){
var table = $('#data_berkas').DataTable();
table.ajax.reload( function ( json ) {
$('#data_berkas').val( json.lastInput );
});
}

function regis_js(){
$(".Desimal").keyup(function(){
var string = numeral(this.value).format('0,0');
$("#"+this.id).val(string);
});
$(".Bulat").keyup(function(){
var string = this.value;
$("#"+this.id).val(string);
});

$(function() {
$(".date").daterangepicker({ 
    singleDatePicker: true,
    dateFormat: 'yy/mm/dd',
    singleDatePicker: true,
    showDropdowns: true,
    minYear: 1901,
    changeMonth: false,
    changeYear: false,
   
    maxYear: parseInt(moment().format('YYYY'),10),
    "locale": {
        "format": "YYYY/MM/DD",
        "separator": "-",
      }
});
});

}
function edit_meta(no_berkas,no_nama_dokumen,no_pekerjaan){
var token  = "<?php echo $this->security->get_csrf_hash(); ?>"       

$.ajax({
type:"post",
url:"<?php echo base_url($this->uri->segment(1).'/form_meta') ?>",
data:"token="+token+"&no_berkas="+no_berkas+"&no_nama_dokumen="+no_nama_dokumen+"&no_pekerjaan="+no_pekerjaan,
success:function(data){
$(".modal-dialog").html(data);    
$('#data_perekaman').modal('show');
regis_js();
}
});    
}

function update_meta(no_berkas){
var data = $("#form_edit_meta").serialize();

$.ajax({
type:"post",
data:$("#form_edit_meta").serialize(),
url:"<?php echo base_url('data_lama/update_meta') ?>",
success:function(data){
read_response(data);
    
$('#data_perekaman').modal('hide');
}
});

}

$(document).ready(function() {
$.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
{
return {
"iStart": oSettings._iDisplayStart,
"iEnd": oSettings.fnDisplayEnd(),
"iLength": oSettings._iDisplayLength,
"iTotal": oSettings.fnRecordsTotal(),
"iFilteredTotal": oSettings.fnRecordsDisplay(),
"iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
"iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
};
};

var t = $("#data_berkas").dataTable({
 'createdRow': function( row, data, dataIndex ) {
      $(row).addClass( data.no_berkas );
  },  
initComplete: function() {
var api = this.api();
$('#data_berkas')
.off('.DT')
.on('keyup.DT', function(e) {
if (e.keyCode == 13) {
api.search(this.value).draw();
}
});
},
oLanguage: {
sProcessing: "loading..."
},
processing: true,
serverSide: true,
ajax: {"url": "<?php echo base_url('data_lama/json_data_lampiran_client/'.$this->uri->segment(3))?> ", 
"type": "POST",
data: function ( d ) {
d.token = '<?php echo $this->security->get_csrf_hash(); ?>';
}
},
columns: [
{
"data": "id_data_berkas",
"orderable": false,
"class":"id_data_berkas"
},
{"data": "nama_lampiran"},
{"data": "jenis_dokumen"},
{"data": "view"}
],
order: [[0, 'desc']],
rowCallback: function(row, data, iDisplayIndex) {
var info = this.fnPagingInfo();
var page = info.iPage;
var length = info.iLength;
var index = page * length + (iDisplayIndex + 1);
$('td:eq(0)', row).html(index);
}

 
});

});

</script>    
    