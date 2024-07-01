<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body>
  <?php
  header("Content-type: application/vnd.ms-excel");
  header("Content-Disposition: attachment; filename=Laporan Data Pengunjung  " . $tittle . ".xls");

  $table = '
    <h2>LAPORAN ' . $tittle . '</h2>
     <table border = "1">
        <tr>
        <td>No.</td>
        <td>Fakultas</td>
        <td>Jumlah Pengunjung</td>
        </tr>';

  $no = 1;
  foreach ($data as $d) {
    $table .= '
            <tr>
              <td>' . $no++ . '</td>
              <td>' . $d['fakultas'] . '</td>
              <td>' . $d['jumlah'] . '</td>
          </tr>';
  }
  $table .= '</table>';

  echo $table;

  ?>

</body>

</html>