            <table class="table text-theme1 table-striped table-bordered table-sm mt-2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>No pekerjaan</th>
                        <th>Nama dokumen penunjang</th>
                        <th>Pengupload</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                
            <?php $no=1; foreach ($data_utama->result_array() as $utama){ ?>
    <tr>
        <td><?php echo $no++ ?></td>  
        <td><?php echo $utama['no_pekerjaan'] ?></td>
        <td><?php echo $utama['nama_berkas'] ?></td>
        <td><?php echo $utama['nama_lengkap'] ?></td>
        <td><button onclick="download_utama('<?php echo $utama['id_data_dokumen_utama'] ?>')" class="btn btn-sm btn-dark btn-block" title="Download"><span class="fa fa-download"></span></button></td>
    </tr> 
            <?php } ?>
        </table>

 
