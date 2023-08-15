<?php

require 'connection.php';
require 'global.php';
require 'templates/dashboard/header.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $sql = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    $user = mysqli_fetch_all($result, MYSQLI_ASSOC)[0] ?? null;

    if ($user && ($password == $user['password'])) {
        $_SESSION['auth'] = [
            'isLoggedIn' => true,
            'user' => [
                'id' => $user['id'],
                'type' => $user['type'],
                'username' => $user['username'],
            ]
        ];
        setFlash('alert', 'success', 'Anda berhasil login');
        return header("location: view_letter.php");
    } else {
        setFlash('alert', 'danger', 'Gagal login, Silahkan coba lagi!');
    }
}
?>
<html>
<head>
<title>Penjadwalan</title>
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta content='IE=edge,chrome=1' http-equiv='X-UA-Compatible'/>
<link rel="stylesheet" href="css/reset.css">
<link rel="stylesheet" href="css/style.css">


<!--[if lt IE 9]>
 <script src=”https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js”></script>
   <script src=”https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js”></script>
<![endif]-->    
	
<link rel="icon" type="image/png" id="favicon"
          href="img/buleleng.png"/>
</head>
<body>

 <section>
  

    <span></span>
    <?php require 'templates/alert.php' ?>
    <?php require 'templates/alert.php'; ?>

    <form action="" method="POST">
            
        <input type="text" id="username" name="username" placeholder='Username'/>
    
        <input type="password" id="password" name="password" placeholder='Password' />
        <input type="submit" name="submit">
    </form>
               
</section>

</body>
</html>
<?php
require 'mysql-footer.php';
require 'templates/dashboard/footer.php';
?>
