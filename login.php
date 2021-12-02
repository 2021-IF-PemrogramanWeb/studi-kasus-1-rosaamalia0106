<?php
session_start();

//jika user udah login, tidak bisa kembali ke halaman login
if( isset($_SESSION["login"]) )
{
    header("Location: index.php"); //kembali ke halaman index
    exit;
}

$error = false;
$conn = mysqli_connect("localhost", "root", "", "pweb_studi-kasus1");

//cek tombol submit ditekan
if( isset($_POST["login"]) )
{
    $email = $_POST["email"];
    $password = $_POST["password"];

    //cek username ada di database atau tidak
    $cek = mysqli_query($conn, "SELECT * FROM user WHERE Email = '$email'");

    if( mysqli_num_rows($cek) === 1 )
    {
        //cek password
        $row = mysqli_fetch_assoc($cek); //ambil semua data

        if ( password_verify($password, $row["Password"]) )
        {
            //set session
            $_SESSION["login"] = true;

            $_SESSION["id"] = $row["ID_User"];

            header("Location: index.php"); //diarahkan ke index.php
            exit;
        }
    }

    $error = true;
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
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <title>Pemrograman Web</title>
</head>

<body>
    <div class="container-fluid d-flex p-5 justify-content-center">
        <div class="row">
            <div class="text-center">
                <img src="./images/logo.png" alt="" class="rounded" style="width: 100px;">
            </div>
            <div class="row">
                <form class="p-5" action="" method="post">
                    <p class="text-center fs-6 fw-bold">Belum memiliki akun? Daftar <a href="./signup.php">disini</a>
                    </p>
                    <div class="mb-3 col-12">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email"
                            required>
                    </div>
                    <div class="mb-3 col-12">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="login">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal alert email/password salah -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    Email atau Password salah.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
</body>

<?php			
	if( $error ) {
		echo '<script type="text/javascript">
			$(document).ready(function(){
				$("#exampleModal").modal("show");
			});
		</script>';
	} 
?>

</html>
