<?php
$baza=@mysqli_connect("localhost","user","password","user") or die ("Nie można nawiązać połączenia z serwerem");
$baza -> query ('SET NAMES utf8');
?>