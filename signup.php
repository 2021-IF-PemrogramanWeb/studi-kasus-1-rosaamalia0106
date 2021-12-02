<?php
session_start();

//jika user udah login, tidak bisa kembali ke halaman login
if( isset($_SESSION["login"]) )
{
    header("Location: index.php"); //kembali ke halaman index
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "pweb_studi-kasus1");

// flag untuk menampilkan modal
$flag_password = 0;
$flag_email = 0;
$flag_empty = 0;
$flag_signup = 0;

//cek tombol submit ditekan
if( isset($_POST["signup"]) )
{
    $email = $_POST["email"];
    $password = mysqli_real_escape_string($conn, $_POST["password"]); //agar dapat menggunakan simbol tanda kutip
    $password2 = mysqli_real_escape_string($conn, $_POST["confirm_password"]); 

    if($email == '' || $password == '' || $password2 == ''){
        $flag_empty = 1;
    }
    else if(mysqli_num_rows(mysqli_query($conn, "SELECT * FROM user WHERE Email = '$email'")) == 1){
        $flag_email = 1;
    }
    else if( $password !== $password2)
    {
        $flag_password = 1;
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
    
        // tambahkan userbaru ke database
        mysqli_query($conn, "INSERT INTO user VALUES('', '$email', '$password')");
    
        if( mysqli_affected_rows($conn) > 0 )
        {
            $flag_signup = 1;
        } else {
            echo mysqli_error($conn);
        }
    }


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
                    <p class="text-center fs-6 fw-bold">Sudah memiliki akun? Masuk <a href="./login.php">disini</a>
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
                    <div class="mb-3 col-12">
                        <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                            required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="signup">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal field kosong  -->
    <div class="modal fade" id="emptyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    Mohon isi kotak formulir untuk mendaftar.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal email sudah digunakan  -->
    <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    Email sudah digunakan. Silahkan gunakan email lain untuk mendaftar.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal konfirmasi password salah -->
    <div class="modal fade" id="passwordModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    Konfirmasi password harus sama dengan password.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal signup berhasil -->
    <div class="modal fade" id="berhasilModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    Pendaftaran berhasil! Silahkan masuk dengan akun yang sudah didaftarkan.
                </div>
                <div class="modal-footer">
                    <a href="./login.php" type="button" class="btn btn-primary">OK</a>
                </div>
            </div>
        </div>
    </div>
</body>

<?php			
	if( $flag_password == 1 ) {
		echo '<script type="text/javascript">
			$(document).ready(function(){
				$("#passwordModal").modal("show");
			});
		</script>';
	} else if( $flag_signup == 1) {
        echo '<script type="text/javascript">
			$(document).ready(function(){
				$("#berhasilModal").modal("show");
			});
		</script>';
    } else if( $flag_email == 1) {
        echo '<script type="text/javascript">
			$(document).ready(function(){
				$("#emailModal").modal("show");
			});
		</script>';
    } else if ( $flag_empty == 1) {
        echo '<script type="text/javascript">
			$(document).ready(function(){
				$("#emptyModal").modal("show");
			});
		</script>';
    }
?>

</html>