<?php
use SMSApi\Client;
use SMSApi\Api\SmsFactory;
use SMSApi\Exception\SmsapiException;
if (isset($_SESSION['admin']))
{
require_once 'sms/vendor/autoload.php';

$client = Client::createFromToken('....');

//Lub wykorzystując login oraz hasło w md5
//$client = new Client('login');
//$client->setPasswordHash(md5('super tajne haslo'));

$smsapi = new SmsFactory;
$smsapi->setClient($client);

try {
	$actionSend = $smsapi->actionSend();

	$actionSend->setTo($telefon);
	$actionSend->setText('zapraszamy po odbiór urządzenia. Zlecenie nr '.$id.' zostało zrealizowane.  ');
	$actionSend->setSender('ECO'); //Pole nadawcy, lub typ wiadomości: 'ECO', '2Way'

	$response = $actionSend->execute();

	foreach ($response->getList() as $status) {
		echo $status->getNumber() . ' ' . $status->getPoints() . ' ' . $status->getStatus();
		
		
	}
} catch (SmsapiException $exception) {
	echo 'ERROR: ' . $exception->getMessage();
}
}
?>