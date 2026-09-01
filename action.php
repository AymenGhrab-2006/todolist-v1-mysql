<?php
require 'config.php';
$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$con) { die("Connection failed: " . mysqli_connect_error()); }

$action=$_POST["action"];
switch ($action) {
    case 'add':
        $title = mysqli_real_escape_string($con, $_POST["title"]);
        $desc = mysqli_real_escape_string($con, $_POST["desc"]);
        $req=mysqli_prepare($con,"insert into tasks (title,description) VALUES(?,?)");
        mysqli_stmt_bind_param($req,"ss",$title,$desc);
        mysqli_stmt_execute($req);
        break;
    case 'modi':
        $id=$_POST["id"];
        $title=$_POST["title"];
        $desc=$_POST["desc"];
        $req=mysqli_prepare($con,"update tasks set title=?, description=? where ID=?;");
        mysqli_stmt_bind_param($req,"ssi",$title,$desc,$id);
        mysqli_stmt_execute($req);
        break;
    case is_numeric($action):
        $action=(int)$action;
        $req=mysqli_prepare($con,"delete from tasks where ID=?");
        mysqli_stmt_bind_param($req,"i",$action);
        mysqli_stmt_execute($req);
        break;
}
header("Location: index.php");
exit;?>