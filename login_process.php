<?php
require 'connection.php';
require 'global.php';
require 'templates/dashboard/header.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $sql = "SELECT * FROM users WHERE username = '$username'";
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
        return header("location: index.php");
    } else {
        setFlash('alert', 'danger', 'Gagal login, Silahkan coba lagi!');
    }
}

?>