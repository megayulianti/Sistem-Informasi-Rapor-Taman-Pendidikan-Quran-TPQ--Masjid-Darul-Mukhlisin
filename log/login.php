<?php
session_start();
require '../database/koneksi.php';

if (isset($_POST["submit"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $level = $_POST["level"];

    // Validasi level
    if ($level == "-- Pilih--") {
        echo "<script>alert('Silakan pilih level login!'); window.location.href='login.php';</script>";
        exit;
    }

    if ($level == "admin") {
        $query = mysqli_query($conn, "SELECT * FROM tb_staf WHERE username='$username' AND password='$password' AND level='admin'");
        if (mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_assoc($query);
            $_SESSION['Login'] = true;
            $_SESSION['user'] = $data['username'];
            $_SESSION['level'] = $data['level'];
            $_SESSION['Admin'] = $data['nik'];
            header("Location: ../index.php?page=guru");
            exit;
        }

    } elseif ($level == "ketua") {
        $query = mysqli_query($conn, "SELECT * FROM tb_staf WHERE username='$username' AND password='$password' AND level='ketua'");
        if (mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_assoc($query);
            $_SESSION['Login'] = true;
            $_SESSION['user'] = $data['username'];
            $_SESSION['level'] = "ketua";
            $_SESSION['ketua'] = $data['nik'];
            header("Location: ../index.php?page=laporan");
            exit;
        }

        } elseif ($level == "guru") {
        $query = mysqli_query($conn, "SELECT * FROM tb_guru WHERE username='$username'");
        if (mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_assoc($query);
            if ($password === $data['password']) { // Ganti ini juga dengan password_verify() jika pakai hash
                $_SESSION['Login'] = true;
                $_SESSION['user'] = $data['username'];
                $_SESSION['level'] = "guru";
                $_SESSION['nip'] = $data['nip'];
                $_SESSION['guru'] = $data['nip']; // Fix utama: ini yang ditambahkan
                header("Location: ../index.php?page=materi");
                exit;
            }
        }

      }


    // Jika login gagal
    echo "<script>alert('Username atau Password salah atau level tidak sesuai!'); window.location.href='login.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login | Sistem Informasi</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="../plugins/iCheck/square/blue.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
    body {
        background-image: url("../img/logo/back.jpg");
        background-size: cover;
    }
  </style>
</head>

<body>
<div class="login-box">
  <div class="login-box-body">
    <p class="login-box-msg">Sign in </p>
   

    <form role="form" method="post" action="">
      <div class="form-group has-feedback">
        <input type="text" name="username" class="form-control" placeholder="Username" autocomplete="off" required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <label for="level">Anda masuk sebagai..</label>
          <select class="form-control" id="level" name="level" required>
            <option>-- Pilih--</option>
            <option value="admin">Admin</option>
            <option value="guru">Guru</option>
            <option value="ketua">Ketua</option>
          </select>
        </div>
        <div class="col-xs-4">
          <br>
          <button type="submit" name="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%'
    });
  });
</script>
</body>
</html>
