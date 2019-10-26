<?php
require_once('config.php');

session_start();

$num = $_GET['numeroQ'];

$da = new Hotel();

$da = unserialize($_SESSION["myhotel"]);

$da->checkout($num);

header("location:../LogadoHotel.php");
