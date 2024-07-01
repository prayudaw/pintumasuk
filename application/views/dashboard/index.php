<?php $this->load->view('dashboard/template/header') ?>


<div class="container-fluid">
  <div class="row">
    <!-- navbar -->
    <?php $this->load->view('dashboard/template/nav') ?>
    <!-- navbar -->


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
               <button type="button" class="btn btn-sm btn-outline-secondary">Export</button> -->
          </div>
          <!-- <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
            <svg class="bi">
              <use xlink:href="#calendar3" />
            </svg>
            This week
          </button> -->
        </div>
      </div>

      <canvas class="my-4 w-100" id="myChart1" width="900" height="380"></canvas>

      <h2>Transaksi Hari Ini</h2>
      <div class="table-responsive small">
        <table id="table" class="table table-striped" style="width:100%">
          <thead>
            <tr>
              <th>No Mhs</th>
              <th>Nama</th>
              <th>Fakultas</th>
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
              <th>Waktu Kunjung</th>
            </tr>
          </tfoot>
        </table>
      </div>
    </main>
  </div>
</div>

<?php $this->load->view('dashboard/template/footer') ?>

<script type="text/javascript">
  /* globals Chart:false */
  (() => {
    'use strict'
    var labels = [];
    var data = [];
    $.ajax({
      type: "get",
      url: "<?php echo base_url('admin/dashboard/getPeminjam') ?>",
      dataType: "json",
      success: function(response) {
        // console.log(response.data);
        var kunjung = [];
        var jumlah = [];
        if (response.status == true) {
          for (var i = 0; i < response.data.length; i++) {
            kunjung[i] = response.data[i].kunjung;
            jumlah[i] = response.data[i].jumlah;
          }

          // Graphs
          const ctx = document.getElementById('myChart1')
          // eslint-disable-next-line no-unused-vars

          const myChart = new Chart(ctx, {
            type: 'line',
            data: {
              labels: kunjung,
              datasets: [{
                data: jumlah,
                lineTension: 0,
                backgroundColor: 'transparent',
                borderColor: '#007bff',
                borderWidth: 4,
                pointBackgroundColor: '#007bff'
              }]
            },
            options: {
              plugins: {
                title: {
                  display: true,
                  text: 'Grafik Pengunjung',
                  font: {
                    size: 15
                  }
                },
                legend: {
                  display: false
                },
                tooltip: {
                  boxPadding: 3
                }
              }
            }
          })
        }
      }
    });


    $('#table').DataTable({
      "processing": true,
      "serverSide": true,
      "processing": true,
      "serverSide": true,
      "searching": true,
      "ajax": {
        //panggil method ajax list dengan ajax
        "url": '<?php echo site_url('admin/pengunjung/ajax_list/now') ?>',
        "type": "POST"
      },
      "order": [
                [3, 'desc']
               ]
    });


  })()
</script>