<?php
$con = mysqli_connect("localhost", "root", "", "querysolution");

if (!$con) {
    die("Error:" . mysqli_connect_error());
}
