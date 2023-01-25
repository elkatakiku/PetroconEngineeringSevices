<?php
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "";
$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

//new file
<?php
    include_once 'php/(pangalan ng file to).php' <--- location to ng file
$fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
$position = mysqli_real_escape_string($conn, $_POST['position']);
$username = mysqli_real_escape_string($conn, $_POST['username']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$sql = "INSERT INTO editprofile (editprofile_fullname, editprofile_position, editprofile_username, editprofile_email, editprofile_password) VALUES ('$fullname', '$position', '$username', '$email', '$password');";
mysqli_query($conn, $sql);

header("Location: ../index.php?signup=success");


	