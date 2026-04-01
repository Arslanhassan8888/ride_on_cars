<?php
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $_SESSION['user'] = $_POST['username'];
    header("Location: index.php");
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Enter name">
    <button type="submit">Login</button>
</form>