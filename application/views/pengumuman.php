<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Istirahat</title>

    <link rel="stylesheet" href="<?php echo base_url('assets/plugins') ?>/fontawesome-free/css/all.min.css">
    <link href="<?php echo base_url('assets/plugins/bootstrap') ?>/5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<style>
    body {
        background-color: black;
        /* background-image: url("<?php echo base_url('assets/images/break.jpg') ?>"); */
        background-repeat: no-repeat;
        background-position: center;
        background-attachment: fixed;

    }
</style>

<body>
    <div class="container-fluid">
        <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="<?php echo base_url('assets/images/break.jpg') ?>" class="d-block w-100" alt="...">
                </div>
                <!-- <div class="carousel-item">
                    <img src="<?php echo base_url('assets/images/break.jpg') ?>" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="<?php echo base_url('assets/images/break.jpg') ?>" class="d-block w-100" alt="...">
                </div> -->
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</html>

<script type="text/javascript">
    setInterval("pengumuman()", 1000);

    function pengumuman() {
        var today = new Date();
        var hr = today.getHours();
        var min = today.getMinutes();
        console.log('t');
        var d = checkTime(hr) + ':' + checkTime(min);
        // var awal = '11:55';
        var akhir = '12:55';
         if (akhir < d) {
            window.location = "<?php echo base_url() ?>";
        }

    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }
</script>