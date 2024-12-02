<?php

    include 'config/koneksi.php';

    session_start();

    if(isset($_SESSION['status']) == 'login'){

        header("location:index.php");
    }

    if(isset($_POST['login'])){

        $username = $_POST['username'];
        $password = md5($_POST['password']);

        $login_admin = mysqli_query($koneksi, "SELECT * FROM data_admin WHERE username_admin='$username' and password_admin='$password'");
        $cek_admin = mysqli_num_rows($login_admin);

        $login = mysqli_query($koneksi, "SELECT * FROM data_pelanggan WHERE username_pelanggan='$username' and password_pelanggan='$password'");
        $cek = mysqli_num_rows($login);

        if($cek > 0) {
            $admin_data = mysqli_fetch_assoc($login);
            $_SESSION['id_pelanggan'] = $admin_data['id_pelanggan'];
            $_SESSION['nama_pelanggan'] = $admin_data['nama_pelanggan'];
            $_SESSION['alamat_pelanggan'] = $admin_data['alamat_pelanggan'];
            $_SESSION['email_pelanggan'] = $admin_data['email_pelanggan'];
            $_SESSION['username_pelanggan'] = $username;
            $_SESSION['status'] = "login";
            header('location:index.php');

        } else if($cek_admin > 0) {
            $admin_data = mysqli_fetch_assoc($login_admin);
            $_SESSION['id_admin'] = $admin_data['id_admin'];
            $_SESSION['nama_admin'] = $admin_data['nama_admin'];
            $_SESSION['username_admin'] = $username;
            $_SESSION['status'] = "login";
            header('location:admin');
        
         } else  {
            echo "<script>
            alert('Login Gagal, Periksa Username dan Password Anda!');
            header('location:index.php');
                 </script>";
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-form {
            max-width: 400px;
            margin: 0 auto;
            margin-top: 100px;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="login-form">
                    <h2 class="text-center">Login</h2>
                    <form method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="showPassword" onclick="togglePassword()">
                            <label class="form-check-label" for="showPassword">Show Password</label>
                        </div>
                        <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
                        <span>Belum punya akun?<a href="registrasi.php" class="text-decoration-none" > Registrasi</a></span>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>