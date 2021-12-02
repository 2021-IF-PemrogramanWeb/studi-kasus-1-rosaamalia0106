<?php
session_start();
//jika user berusaha masuk tanpa login
if( !isset($_SESSION["login"]) )
{
    header("Location: login.php"); //kembali ke halaman login
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "pweb_studi-kasus1");

$bulan       = mysqli_query($conn, "SELECT Bulan FROM penjualan WHERE Tahun='2016' order by ID_Penjualan asc");
$penghasilan = mysqli_query($conn, "SELECT Hasil_Penjualan FROM penjualan WHERE Tahun='2016' order by ID_Penjualan asc");

//Mendapatkan id user
$user_id = $_SESSION["id"];
$result_user = mysqli_query($conn, "SELECT * FROM user WHERE ID_User = $user_id");
$user = [];

while( $row = mysqli_fetch_assoc($result_user) )
{
    $user[] = $row;
}
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.js"></script>
    <title>Pemrograman Web</title>

    <style>
    .l-navbar {
        position: fixed;
        top: 0;
    }

    .content {
        height: 100%;
        margin-left: 300px;
        position: relative;
    }
    </style>
</head>

<body>
    <div class="container-fluid p-0">
        <nav class="navbar navbar-light bg-light"
            style="padding: 20px 0px 20px 290px; position:relative; margin-bottom:20px;">
            <div class="container-fluid">
                <span class="navbar-brand mb-0 h1">Grafik Penjualan</span>
            </div>
        </nav>

        <div class="l-navbar">
            <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px; height: 100vh;">
                <a class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
                    <img src="./images/logo.png" alt="" class="rounded" style="width: 50px;">
                    <span class="fs-4" style="margin-left:10px;">Penjualan</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="./index.php" class="nav-link link-dark" aria-current="page">
                            <i class="fa fa-table" style="margin-right:10px;"></i>
                            Tabel
                        </a>
                    </li>
                    <li>
                        <a href="./graph.php?id=<?= $user_id; ?>" class="nav-link active">
                            <i class="fa fa-bar-chart" style="margin-right:10px;"></i>
                            Grafik
                        </a>
                    </li>

                </ul>
                <hr>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
                        id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://64.media.tumblr.com/4ebe1e028881c639b5f39f856e250a80/b077bf54f08a6ae9-dc/s1280x1920/b202fac3e04758c9d272bebd1231c836a86e5ef0.jpg"
                            alt="" width="32" height="32" class="rounded-circle me-2">
                        <?php $i=1; ?>
                        <?php foreach( $user as $row ) : ?>
                        <strong><?= $row["Email"]; ?></strong>
                        <?php $i++; ?>
                        <?php endforeach; ?>
                    </a>
                    <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
                        <li><a class="dropdown-item" href="./logout.php">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="content col-9">
            <canvas id="myChart"></canvas>
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