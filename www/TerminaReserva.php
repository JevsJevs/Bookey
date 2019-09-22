<?php
require_once ('config.php');

session_start();

$num = $_GET['numeroQ'];

echo $num;

$da = new Hotel();

$da = unserialize($_SESSION["myhotel"]);

$da->checkout($num);

header("location:../LogadoHotel.php");
