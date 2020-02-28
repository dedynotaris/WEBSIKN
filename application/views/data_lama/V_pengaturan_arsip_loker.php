<body>
<?php  $this->load->view('umum/data_lama/V_sidebar_data_lama'); ?>
<div id="page-content-wrapper">
<?php  $this->load->view('umum/data_lama/V_navbar_data_lama'); ?>
<?php  $this->load->view('umum/data_lama/V_data_data_lama'); ?>
<div class="container-fluid mt-2">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header text-center">Buat Tempat Arsip Fisik</div>
                <div class="card-body">
                    <label>Nama Tempat</label>
                    <input type="text" name="nama_tempat" id="nama_tempat" placeholder="nama tempat" class="form-control form-control-sm">
                    <label>Jumlah Loker</label>
                    <input type="number" name="jumlah_loker" id="jumlah_loker" placeholder="jumlah loker"  class="form-control form-control-sm">
                    
                </div>
                    <div class="card-footer">
                        <button class="btn btn-success btn-sm btn-block">Simpan Tempat Penyimpanan Arsip Fisik</button>
                    </div>
            </div>
        </div>
        
        <div class="col"></div>
    </div>
</div>    
</body>    