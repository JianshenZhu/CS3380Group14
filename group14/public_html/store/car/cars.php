<!DOCTYPE html>
<html lang="en">
<head>
<?php include '../../inc/meta.php'; ?>
    <link rel="shortcut icon" href="../../img/MRR.ico" />
	<title>Car Listings - Missouri Rail</title>
</head>
<body>
<?php include '../../inc/header.php'; ?>
<?php include '../../inc/footer.php'; ?>
</body>
</html>


<?php
    include "../../internal/login/loginCheck.php";

    if($loggedIn == false)  {
//        header("Location: ../../login/loginCheck.php");
//        exit;
    }

include "../../../CONFIG.php";

$mysqli = new mysqli($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);
if ($mysqli->connect_errno){
	echo "Connection failed.";
	exit();
}

if($_GET['type'] == "0"){ 
$sql = "SELECT * FROM Equipment WHERE Type = '0'";
$result = $mysqli->query($sql);

echo"<table>";
while($fieldinfo = mysqli_fetch_field($result)){
	echo"<th>".$fieldinfo->name."</th>";
}

while($row = $result->fetch_array(MYSQLI_NUM)){
	echo"<tr>";
	foreach($row as $data){
	echo"<td>". $data. "</td>";
}
	echo "</tr>";
}
    $rows = $result->num_rows;
    echo "There are ".$rows." results.";
}
if($_GET['type'] == "1"){ 
$sql = "SELECT * FROM Equipment WHERE Type = '1'";
$result = $mysqli->query($sql);

echo"<table>";
while($fieldinfo = mysqli_fetch_field($result)){
	echo"<th>".$fieldinfo->name."</th>";
}

while($row = $result->fetch_array(MYSQLI_NUM)){
	echo"<tr>";
	foreach($row as $data){
	echo"<td>". $data. "</td>";
}
	echo "</tr>";
}
    $rows = $result->num_rows;
    echo "There are ".$rows." results.";
}
if($_GET['type'] == "2"){ 
$sql = "SELECT * FROM Equipment WHERE Type = '2'";
$result = $mysqli->query($sql);

echo"<table>";
while($fieldinfo = mysqli_fetch_field($result)){
	echo"<th>".$fieldinfo->name."</th>";
}

while($row = $result->fetch_array(MYSQLI_NUM)){
	echo"<tr>";
	foreach($row as $data){
	echo"<td>". $data. "</td>";
}
	echo "</tr>";
}
    $rows = $result->num_rows;
    echo "There are ".$rows." results.";
}
if($_GET['type'] == "3"){ 
$sql = "SELECT * FROM Equipment WHERE Type = '3'";
$result = $mysqli->query($sql);

echo"<table>";
while($fieldinfo = mysqli_fetch_field($result)){
	echo"<th>".$fieldinfo->name."</th>";
}

while($row = $result->fetch_array(MYSQLI_NUM)){
	echo"<tr>";
	foreach($row as $data){
	echo"<td>". $data. "</td>";
}
	echo "</tr>";
}
    $rows = $result->num_rows;
    echo "There are ".$rows." results.";
}
if($_GET['type'] == "4"){ 
$sql = "SELECT * FROM Equipment WHERE Type = '4'";
$result = $mysqli->query($sql);

echo"<table>";
while($fieldinfo = mysqli_fetch_field($result)){
	echo"<th>".$fieldinfo->name."</th>";
}

while($row = $result->fetch_array(MYSQLI_NUM)){
	echo"<tr>";
	foreach($row as $data){
	echo"<td>". $data. "</td>";
}
	echo "</tr>";
}
    $rows = $result->num_rows;
    echo "There are ".$rows." results.";
}
if($_GET['type'] == "5"){ 
$sql = "SELECT * FROM Equipment WHERE Type = '5'";
$result = $mysqli->query($sql);

echo"<table>";
while($fieldinfo = mysqli_fetch_field($result)){
	echo"<th>".$fieldinfo->name."</th>";
}

while($row = $result->fetch_array(MYSQLI_NUM)){
	echo"<tr>";
	foreach($row as $data){
	echo"<td>". $data. "</td>";
}
	echo "</tr>";
}
    $rows = $result->num_rows;
    echo "There are ".$rows." results.";
}
if($_GET['type'] == "6"){ 
$sql = "SELECT * FROM Equipment WHERE Type = '6'";
$result = $mysqli->query($sql);

echo"<table>";
while($fieldinfo = mysqli_fetch_field($result)){
	echo"<th>".$fieldinfo->name."</th>";
}

while($row = $result->fetch_array(MYSQLI_NUM)){
	echo"<tr>";
	foreach($row as $data){
	echo"<td>". $data. "</td>";
}
	echo "</tr>";
}
    $rows = $result->num_rows;
    echo "There are ".$rows." results.";
}
if($_GET['type'] == "7"){ 
$sql = "SELECT * FROM Equipment WHERE Type = '7'";
$result = $mysqli->query($sql);

echo"<table>";
while($fieldinfo = mysqli_fetch_field($result)){
	echo"<th>".$fieldinfo->name."</th>";
}

while($row = $result->fetch_array(MYSQLI_NUM)){
	echo"<tr>";
	foreach($row as $data){
	echo"<td>". $data. "</td>";
}
	echo "</tr>";
}
    $rows = $result->num_rows;
    echo "There are ".$rows." results.";
}
if($_GET['type'] == "8"){ 
$sql = "SELECT * FROM Equipment WHERE Type = '8'";
$result = $mysqli->query($sql);

echo"<table>";
while($fieldinfo = mysqli_fetch_field($result)){
	echo"<th>".$fieldinfo->name."</th>";
}

while($row = $result->fetch_array(MYSQLI_NUM)){
	echo"<tr>";
	foreach($row as $data){
	echo"<td>". $data. "</td>";
}
	echo "</tr>";
}
    $rows = $result->num_rows;
    echo "There are ".$rows." results.";
}
if($_GET['type'] == "9"){ 
$sql = "SELECT * FROM Equipment WHERE Type = '9'";
$result = $mysqli->query($sql);

echo"<table>";
while($fieldinfo = mysqli_fetch_field($result)){
	echo"<th>".$fieldinfo->name."</th>";
}

while($row = $result->fetch_array(MYSQLI_NUM)){
	echo"<tr>";
	foreach($row as $data){
	echo"<td>". $data. "</td>";
}
	echo "</tr>";
}
    $rows = $result->num_rows;
    echo "There are ".$rows." results.";
}
?>

