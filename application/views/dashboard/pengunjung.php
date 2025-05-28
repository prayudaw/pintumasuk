   <!-- header -->
   <?php $this->load->view('dashboard/template/header') ?>
   <!-- header -->


   <div class="container-fluid">
       <div class="row">
           <!-- navbar -->
           <?php $this->load->view('dashboard/template/nav') ?>
           <!-- navbar -->

           <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
               <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                   <h1 class="h2"><?php echo $title ?></h1>
               </div>
               <table id="table" class="table table-striped" style="width:100%">
                   <thead>
                       <tr>
                           <th>No Mhs</th>
                           <th>Nama</th>
                           <th>Fakultas</th>
                           <th>Jurusan</th>
                           <th>Waktu Kunjung</th>
                       </tr>
                   </thead>
                   <tbody>
                   </tbody>
                   <tfoot>
                       <tr>
                           <th>No Mhs</th>
                           <th>Nama</th>
                           <th>Fakultas</th>
                           <th>Jurusan</th>
                           <th>Waktu Kunjung</th>
                       </tr>
                   </tfoot>
               </table>
           </main>

       </div>

       <?php $this->load->view('dashboard/template/footer') ?>
       <script type="text/javascript">
           $(document).ready(function() {
               $('#table').DataTable({
                   "processing": true,
                   "serverSide": true,
                   "processing": true,
                   "serverSide": true,
                   "searching": true,
                   "ajax": {
                       //panggil method ajax list dengan ajax
                       "url": '<?php echo site_url('admin/pengunjung/ajax_list') ?>',
                       "type": "POST"
                   },
                   "order": [
                       [3, 'desc']
                   ]
               });
           });
       </script>