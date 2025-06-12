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
               <div class="row">
                   <div class="col-md-12">
                       <div class="card card-primary">
                           <div class="card-header">
                               <h3 class="card-title">Pencarian</h3>
                           </div>

                           <div class="card-body">
                               <form id="form-filter">
                                   <div class="row">
                                       <div class="col-md-6">

                                           <div class="form-group">
                                               <label>NIM</label>
                                               <input type="text" class="form-control" placeholder="Masukan Nim" id="nim">
                                           </div><br />
                                           <div class="form-group">
                                               <label>NAMA</label>
                                               <input type="text" class="form-control" placeholder="Masukan Nama" id="nama">
                                           </div><br />
                                           <div class="form-group">
                                               <label>JURUSAN</label>
                                               <select name="jurusan" class="form-control select2bs4-jurusan" id="jurusan">
                                                   <option></option>
                                               </select>
                                           </div> <br />
                                       </div>
                                       <div class="col-md-6">
                                           <div class="form-group">
                                               <label>FAKULTAS</label>
                                               <select name="fakultas" class="form-control select2bs4-fakultas" id="fakultas">
                                                   <option></option>
                                               </select>
                                           </div> <br />

                                           <!-- Date range -->
                                           <div class="form-group">
                                               <label>WAKTU KUNJUNG:</label>
                                               <div class="input-group">
                                                   <input type="text" class="form-control" id="tanggal" autocomplete="off" value="">
                                               </div><br />
                                               <!-- /.input group -->
                                           </div>
                                       </div>
                                   </div>
                               </form>
                               <div class="card-footer">
                                   <button type="button" id="btn-filter" class="btn btn-primary" fdprocessedid="1fsmid"><i class="fas fa-search"></i>
                                       Filter</button>
                                   <button type="button" id="btn-reset" class="btn btn-default" fdprocessedid="4i4oh">Reset</button>
                                   <button type="button" id="btn-excel" class="btn btn-success" fdprocessedid="1h3uq"><i class="fas fa-file-excel"></i> Export Execl</button>
                               </div>

                           </div>
                       </div>

                   </div>
               </div><br /><br />
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
           $('.select2bs4-jurusan').select2({
               placeholder: "-- Pilih Jurusan --",
               theme: 'bootstrap4',
               ajax: {
                   dataType: 'json',
                   delay: 250,
                   url: '<?php echo base_url('index.php/admin/pengunjung/getJurusanListApi'); ?>',
                   data: function(params) {
                       return {
                           searchTerm: params.term
                       }
                   },
                   processResults: function(data) {
                       return {
                           results: $.map(data, function(obj) {
                               return {
                                   id: obj.jurusan,
                                   text: obj.jurusan
                               };
                           })
                       };
                   }
               }
           });

           $('.select2bs4-fakultas').select2({
               placeholder: "-- Pilih Fakultas --",
               theme: 'bootstrap4',
               ajax: {
                   dataType: 'json',
                   delay: 250,
                   url: '<?php echo base_url('index.php/admin/pengunjung/getFakultasListApi'); ?>',
                   data: function(params) {
                       return {
                           searchTerm: params.term
                       }
                   },
                   processResults: function(data) {
                       return {
                           results: $.map(data, function(obj) {
                               return {
                                   id: obj.fakultas,
                                   text: obj.fakultas
                               };
                           })
                       };
                   }
               }
           });
           $(document).ready(function() {
               var table;
               table = $('#table').DataTable({
                   "processing": true,
                   "serverSide": true,
                   "processing": true,
                   "serverSide": true,
                   "searching": true,
                   "ajax": {
                       //panggil method ajax list dengan ajax
                       "url": '<?php echo site_url('admin/pengunjung/ajax_list') ?>',
                       'data': function(data) {
                           data.searchNim = $('#nim').val();
                           data.searchNama = $('#nama').val();
                           data.searchJurusan = $('#jurusan').val();
                           data.searchFakultas = $('#fakultas').val();
                           data.searchTanggal = $('#tanggal').val();
                       },
                       "type": "POST"
                   },
                   "order": [
                       [3, 'desc']
                   ]
               });

               $('#btn-filter').click(function() { //button filter event click
                   table.ajax.reload(); //just reload table
               });

               $('#btn-reset').click(function() { //button reset event click
                   $('#form-filter')[0].reset();
                   table.ajax.reload(); //just reload table
               });


               $('#btn-excel').click(function() { //button reset event click
                   //    if ($('#tanggal').val() == '') {
                   //        alert('Tanggal Harus Diisi');
                   //        return false;
                   //    }
                   var tanggal = $("#tanggal").val();
                   var nama = $("#nama").val();
                   var nim = $("#nim").val();
                   var fakultas = $("#fakultas").val();
                   var jurusan = $("#jurusan").val();
                   location.href = "<?= base_url() ?>admin/pengunjung/export_excel?nama=" + nama;

               });
           });
           //Date range picker
           $('#tanggal').daterangepicker({
               autoUpdateInput: false,
               locale: {
                   cancelLabel: 'Clear'
               }
           });

           $('#tanggal').on('apply.daterangepicker', function(ev, picker) {
               $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
           });
       </script>