<?php

$ip = $_SERVER['REMOTE_ADDR'];
$timestamp = time();
$data = date("Y-m-d, H:i:s",$timestamp);

$logi = "INSERT INTO logi (login, data, ip, udane) VALUES ('$login', '$data', '$ip', '$efekt')";
		if ($baza->query($logi) === TRUE) 
		{
		}
		else
		{
			echo "Coś poszło nie tak";
		}
?>