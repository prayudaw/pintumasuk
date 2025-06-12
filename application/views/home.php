<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url('assets/images/logo-perpus.png') ?>" />
    <title>Pintu Masuk</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins') ?>/fontawesome-free/css/all.min.css">
    <link href="<?php echo base_url('assets/plugins/bootstrap') ?>/5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/home.css') ?>">
</head>

<body>
    <div class="container-fluid" style="margin-left:0;margin-bottom:0px">
        <div class="row" style="height:100%">
            <div class="col-md-3" style="background-color:#000000;height:1000px;position:static;color:wihte">
                <div class="text-center logo">
                    <img src="<?php echo base_url('assets/images/') ?>logo-perpus.png" class="rounded"
                        style="width:110px;">
                </div>
                <div class="foto-anggota text-center">
                    <div id="data-anggota">
                    </div>
                </div>
                <div id="clockdate">
                    <div class="clockdate-wrapper">
                        <div id="clock"></div>
                        <div id="date"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="main">
                    <div class="float-left col-lg-7 judul">
                        <i class="fas fa-door-open" style="font-size:60px"> Visitor Gateway</i>
                    </div>
                    <div class="float-right col-lg-2">

                    </div>
                    <div class="scan" style="border:2px solid #fff;height:400px;color:#fff">
                        <h1 style="text-align:center;color:#">Scan Kartu Anggota</h1>
                        <form action="#" class="info">
                            <div id="scan_anggota">
                                <div class="input-group input-group-lg" style="background-color:#0F0F0F">
                                    <input type="text" class="form-control" name="nim" autocomplete="off" id="nim"
                                        aria-describedby="inputGroup-sizing-lg"
                                        style="color:#fff;background: #0F0F0F;background: -webkit-linear-gradient(to right, #0F0F0F, #0F0F0F);background: linear-gradient(to right, #243B55, #0F0F0F);height:200px;margin-top:30px;text-align:center;font-size:70px;border:0;margin:0;box-shadow: none">

                                </div>
                            </div>
                            <div id="info-message">
                            </div>
                        </form>

                    </div>
                    <div class="chart_header">
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content" style=" font-family:Georgia;font-size: 21px;">
                    <div class="modal-header" style="background-color:#7f6003;color:#fff">
                        <h1 class="modal-title fs-5" id="exampleModalLabel"> <i class="fas fa-info"></i> Info Blokir
                        </h1>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button> -->
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url('assets/plugins') ?>/jquery/jquery.min.js"></script>
        <script src="<?php echo base_url('assets/plugins') ?>/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url('assets/plugins/canvas/jquery.canvasjs.min.js') ?>">
        </script>

        <script src="<?php echo base_url('assets/plugins/bootstrap') ?>/5.3.0/dist/js/bootstrap.min.js">
        </script>
        <script src="<?php echo base_url('assets/plugins/bootstrap') ?>/5.3.0/dist/js/bootstrap.bundle.min.js">
        </script>
</body>

<script type="text/javascript">
    window.onload = function() {
        $('#nim').focus();
        setInterval("getStatistik()", 9000);
    }

    function getStatistik() {
        //pengumuman()
        $.ajax({
            type: "get",
            url: "<?php echo base_url('home/getStatistik') ?>",
            dataType: "json",
            success: function(response) {
                $('#chart_element').remove();

                if (response) {
                    var data = [];
                    for (var i = 0; i < response.data.length; i++) {
                        data[i] = {
                            label: response.data[i].fakultas,
                            y: response.data[i].jumlah,
                            color: response.data[i].color,
                            indexLabel: "{y}",
                            indexLabelFontColor: "white",
                            indexLabelBackgroundColor: "black"
                        };
                    }

                    var tot_harian = response.data_pengunjung.harian;
                    var tot_bulan = response.data_pengunjung.bulanan;

                    var options = {
                        title: {
                            text: "Statistik Pengunjung",
                            fontColor: "#F5DEB3",
                            fontFamily: "sans-serif",
                            fontWeight: "bold",
                            fontSize: 40,
                        },

                        subtitles: [{
                            text: "Total Pengunjung Hari ini : " + tot_harian +
                                "   Total Pengunjung Bulan ini :  " + tot_bulan,
                            fontColor: "#F5DEB3",
                            //Uncomment properties below to see how they behave
                            //fontColor: "red",
                            fontFamily: "cursive",
                            fontSize: 17
                        }],
                        backgroundColor: "transparent",
                        axisX: {
                            labelMaxWidth: 85,
                            labelFontColor: "white",
                            fontSize: 50,
                            fontFamily: "sans-serif",
                            fontWeight: "bold",
                            horizontalAlign: "center",
                        },
                        axisY: {
                            labelFontColor: "white",
                            fontSize: 0,
                            fontFamily: "sans-serif",
                            fontWeight: "bold",
                        },

                        data: [{
                            // Change type to "doughnut", "line", "splineArea", etc.
                            type: "column",
                            dataPoints: data
                        }]
                    };
                }
                $(".chart_header").append(
                    '<div id="chart_element"><div id="chartContainer" style="height: 400px; width: 100%;margin-top:40px"></div></div>'
                );
                $("#chartContainer").CanvasJSChart(options);

            }
        });


    }


    function remove() {
        $('#message').remove();
        $('#data').remove();
        $('#nim').val('');
    }

    var element = '';
    var element_message = '';
    $('#scan_anggota').keypress((e) => {
        if (e.which === 13) {
            e.preventDefault();
            var nim = $('#nim').val();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url('home/getAnggota') ?>",
                data: {
                    nim: nim
                },
                dataType: "json",
                success: function(response) {
                    if (response.status == 1) {

                        if (response.message_blokir) {

                            $(".modal-body").html(
                                '<h4 style="text-align:center;color:red">Kartu Anggota Anda Sedang Diblokir</h4><p>Alasan:' +
                                response
                                .message_blokir + '</p>')
                            $('#myModal').modal('show');

                            setTimeout(function() {
                                $('#myModal').modal('hide');
                                $('.modal-body').html('');
                                $('#nim').focus();
                            }, 3000);


                        }

                        element = '<div id="data"><img class="img-fluid" src="' + response.foto +
                            '" alt="User profile picture"><h3>' + response.data.nama + '</h3><h3>' +
                            response.data.no_mhs + '</h3><h3>' + response.data.fakultas + '</h3></div>';
                        element_message =
                            '<p id="message" style="color:#1dff00;font-size:30px;text-align:center"><i class="fas fa-check-square"></i> ' +
                            response.message + '</p>';
                    } else {
                        element = '<div id="data"></div>';
                        element_message =
                            '<p id="message" style="color:#f20404;font-size:30px;text-align:center"><i class="fas fa-times"></i> ' +
                            response.message + '</p>';
                    }

                    $("#data-anggota").append(element);
                    $('#info-message').append(element_message);
                    setTimeout("remove()", 2000);
                    $('#nim').focus();
                }
            });
        }

    });



    function pengumuman() {
        var today = new Date();
        var hr = today.getHours();
        var min = today.getMinutes();
        var d = checkTime(hr) + ':' + checkTime(min);

        var hr_ini = today.getDay();
        //selain hari sabtu ada istirahat
        if (hr_ini !== 6) {

            var awal = '11:59';
            var akhir = '12:55';


            if (hr_ini == 5) {
                var awal = '11:30';
                var akhir = '12:55';
            }

            console.log(awal);
            console.log(akhir);
            if (awal < d && akhir > d) {
                window.location = "<?php echo base_url('pengumuman') ?>";
            }


        }




    }



    function startTime() {
        var today = new Date();
        var hr = today.getHours();
        var min = today.getMinutes();
        var sec = today.getSeconds();
        ap = (hr < 12) ? "<span></span>" : "<span></span>";
        hr = (hr == 0) ? 12 : hr;
        // hr = (hr > 12) ? hr - 12 : hr;
        //Add a zero in front of numbers<10
        hr = checkTime(hr);
        min = checkTime(min);
        sec = checkTime(sec);
        document.getElementById("clock").innerHTML = hr + ":" + min + ":" + sec + " " + ap;

        var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
            'November', 'Desember'
        ];
        var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        var curWeekDay = days[today.getDay()];
        var curDay = today.getDate();
        var curMonth = months[today.getMonth()];
        var curYear = today.getFullYear();
        var date = curWeekDay + ", " + curDay + " " + curMonth + " " + curYear;
        document.getElementById("date").innerHTML = date;

        var time = setTimeout(function() {
            startTime()
        }, 500);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }
    startTime();
</script>

</html>