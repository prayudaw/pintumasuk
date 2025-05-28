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
                                       <div class="row g-3 align-items-center" style="margin-bottom:20px">
                                           <div class="col-md-2">
                                               <label class="col-form-label">Laporan Harian </label>
                                           </div>
                                           <div class="col-md-4">
                                               <input type="date" id="harian" class="form-control" value="u">
                                           </div>
                                           <div class="col-5 text-left">
                                               <span class="form-text">
                                                   <button type="button" id="btn-excel-harian" class="btn btn-success"><i class="fas fa-solid fa-file-excel"></i> Export</button>
                                                   <button type="button" id="btn-filter-harian" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
                                               </span>
                                           </div>
                                       </div>
                                       <div class="row g-3 align-items-center" style="margin-bottom:20px">
                                           <div class="col-md-2">
                                               <label class="col-form-label">Laporan Bulanan </label>
                                           </div>
                                           <div class="col-md-2">
                                               <select class="form-select" id="bulanan">
                                                   <option selected value="">--Pilih Bulan --</option>
                                                   <option value="01">Januari</option>
                                                   <option value="02">Februari</option>
                                                   <option value="03">Maret</option>
                                                   <option value="04">April</option>
                                                   <option value="05">Mei</option>
                                                   <option value="06">Juni</option>
                                                   <option value="07">Juli</option>
                                                   <option value="08">Agusutus</option>
                                                   <option value="09">September</option>
                                                   <option value="10">Oktoner</option>
                                                   <option value="11">November</option>
                                                   <option value="12">Desember</option>
                                               </select>
                                           </div>
                                           <div class="col-md-2">
                                               <select class="form-select" id="bulan_tahun">
                                                   <option selected value="">--Pilih Tahun --</option>
                                                   <?php
                                                    $year = date('Y');
                                                    for ($i = $year; $i >= 1991; $i--) { ?>
                                                       <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                   <?php } ?>
                                               </select>

                                           </div>
                                           <div class="col-5 text-left">
                                               <span class="form-text">
                                                   <button type="button" id="btn-excel-bulanan" class="btn btn-success"><i class="fas fa-solid fa-file-excel"></i> Export</button>
                                                   <button type="button" id="btn-filter-bulanan" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
                                               </span>
                                           </div>
                                       </div>
                                       <div class="row g-3 align-items-center" style="margin-bottom:20px">
                                           <div class="col-md-2">
                                               <label class="col-form-label">Laporan Tahunan </label>
                                           </div>
                                           <div class="col-md-4">
                                               <select class="form-select" id="tahun">
                                                   <option value="" selected>--Pilih Tahun --</option>
                                                   <?php
                                                    $year = date('Y');
                                                    for ($i = $year; $i >= 1991; $i--) { ?>
                                                       <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                   <?php } ?>

                                               </select>
                                           </div>
                                           <div class="col-5 text-left">
                                               <span class="form-text">
                                                   <button type="button" id="btn-excel-tahunan" class="btn btn-success"><i class="fas fa-solid fa-file-excel"></i> Export</button>
                                                   <button type="button" id="btn-filter-tahunan" class="btn btn-primary"><i class="fas fa-search"></i> Filter</button>
                                               </span>
                                           </div>
                                       </div>

                                       <br />
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
       $('.select2bs4').select2({
           theme: 'bootstrap4',

       })

       $(document).ready(function() {
           $('#harian').datepicker();
           $("#btn-filter").click(function() {

               if ($('#data_report').length) {
                   $('#data_report').remove();
               }

               if ($('#reservation').val() == '') {
                   alert('Tanggal Harus Diisi');
                   return false;
               }

               var tanggal = $('#reservation').val();

               $.ajax({
                   type: "post",
                   url: "<?php echo base_url('admin/laporan/getData') ?>",
                   data: {
                       tanggal: tanggal
                   },
                   success: function(response) {
                       $('#table').append(response);
                   }
               });
           });

       });


       $('#btn-reset').click(function() { //button reset event click
           $('#form-filter')[0].reset();
       });

       $('#btn-excel-harian').click(function() { //button reset event click
           if ($('#harian').val() == '') {
               alert('Tanggal Harus Diisi');
               return false;
           }
           var tanggal = $("#harian").val();
           location.href = "<?= base_url() ?>admin/report/export_excel_harian?tanggal=" + tanggal;
       });


       $('#btn-excel-bulanan').click(function() { //button reset event click
           if ($('#bulanan').val() == '') {
               alert('Bulan Harus Diisi');
               return false;
           }
           if ($('#bulan_tahun').val() == '') {
               alert('Tahun Harus Diisi');
               return false;
           }

           var bulan = $("#bulanan").val();
           var tahun = $("#bulan_tahun").val();

           location.href = "<?= base_url() ?>admin/report/export_excel_bulan?bulan=" + bulan + "&tahun=" + tahun;
       });

       $('#btn-excel-tahunan').click(function() { //button reset event click
           if ($('#tahun').val() == '') {
               alert('Tahun Harus Diisi');
               return false;
           }

           var tahun = $("#tahun").val();
           location.href = "<?= base_url() ?>admin/report/export_excel_tahun?tahun=" + tahun;
       });
   </script>