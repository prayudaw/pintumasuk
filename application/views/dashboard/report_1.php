   <!-- header -->
   <?php $this->load->view('dashboard/template/header') ?>
   <!-- header -->

   <div class="container-fluid">
       <div class="row">
           <!-- navbar -->
           <?php $this->load->view('dashboard/template/nav') ?>
           <!-- navbar -->


           <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
               <h1><?php echo $title ?></h1>
               <section class="content">
                   <div class="container-fluid">
                       <div class="row">
                           <div class="col-12">
                               <div class="card">
                                   <div class="card-body">
                                       <div class="row g-3 align-items-center">
                                           <div class="col-auto">
                                               <label class="col-form-label">Tahun</label>
                                           </div>
                                           <div class="col-auto">
                                               <input type="text" id="tahun" class="form-control">
                                           </div>
                                           <div class="col-auto">
                                               <span class="form-text">
                                                   <button type="button" class="btn btn-primary">Primary</button>
                                               </span>
                                           </div>
                                           <div class="col-auto">
                                               <label class="col-form-label">Tahun</label>
                                           </div>
                                           <div class="col-auto">
                                               <input type="text" id="tahun" class="form-control">
                                           </div>
                                           <div class="col-auto">
                                               <span class="form-text">
                                                   <button type="button" class="btn btn-primary">Primary</button>
                                               </span>
                                           </div>
                                           <div class="col-auto">
                                               <label class="col-form-label">Tahun</label>
                                           </div>
                                           <div class="col-auto">
                                               <input type="text" id="tahun" class="form-control">
                                           </div>
                                           <div class="col-auto">
                                               <span class="form-text">
                                                   <button type="button" class="btn btn-primary">Primary</button>
                                               </span>
                                           </div>
                                       </div>

                                       <br />
                                       <!-- <button class="btn btn-success" onclick="add_kunci()"><i class="fas fa-plus"></i> Add</button>
                                   <button class="btn btn-default" id="btn-reset"><i class="fas fa-redo"></i> Reload</button> -->

                                       <table id="table" class="table table-striped" style="width:100%">
                                           <thead>
                                               <tr>
                                                   <th>No Mhs</th>
                                                   <th>Nama</th>
                                                   <th>Fakultas</th>
                                               </tr>
                                           </thead>
                                           <tbody>
                                           </tbody>
                                           <tfoot>
                                               <tr>
                                                   <th>No Mhs</th>
                                                   <th>Nama</th>
                                                   <th>Fakultas</th>
                                               </tr>
                                           </tfoot>
                                       </table>
                                   </div>
                                   <!-- /.card-body -->
                               </div>
                               <!-- /.card -->

                           </div>
                           <!-- /.col -->
                       </div>

                   </div>
               </section>
           </main>
       </div>
   </div>
   <?php $this->load->view('dashboard/template/footer') ?>
   <script type="text/javascript">
       $(document).ready(function() {
           $('#table').DataTable({
               "processing": true,
               "serverSide": true,
               "processing": true,
               "serverSide": true,
               "searching": false,
               "ajax": {
                   //panggil method ajax list dengan ajax
                   "url": '<?php echo site_url('admin/report/ajax_list') ?>',
                   "type": "POST"
               }
           });
       });
   </script>