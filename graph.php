<?php
// session_start();
// //jika user berusaha masuk tanpa login
// if( !isset($_SESSION["login"]) )
// {
//     header("Location: login.php"); //kembali ke halaman login
//     exit;
// }

$conn = mysqli_connect("localhost", "root", "", "pweb_studi-kasus1");

$bulan       = mysqli_query($conn, "SELECT Bulan FROM penjualan WHERE Tahun='2016' order by ID_Penjualan asc");
$penghasilan = mysqli_query($conn, "SELECT Hasil_Penjualan FROM penjualan WHERE Tahun='2016' order by ID_Penjualan asc");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.js"></script>
    <title>Pemrograman Web</title>
</head>

<body>
    <div class="container-fluid p-5">
        <div class="row-cols-1">
            <div class="col-md-2" style="margin-right: 5px;">
                <div class="row-2">
                    <img src="./images/logo.png" alt="" class="rounded" style="width: 100px;">
                </div>
                <div class="row">
                    <div class="d-grid gap-3">
                        <a class="btn btn-warning" href="./graph.php">Graph</a>
                        <button type="button" class="btn btn-info">Export</button>
                        <a class="btn btn-danger" href="./logout.php">Logout<a>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <canvas id="myChart"></canvas>
            </div>
        </div>
    </div>
</body>

<script>
var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php while ($b = mysqli_fetch_array($bulan)) { echo '"' . $b['Bulan'] . '",';}?>],
        datasets: [{
            label: 'Hasil Penjualan',
            data: [
                <?php while ($p = mysqli_fetch_array($penghasilan)) { echo '"' . $p['Hasil_Penjualan'] . '",';}?>
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>


</html>