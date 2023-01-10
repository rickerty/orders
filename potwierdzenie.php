<?php
session_start();
?><meta charset="utf-8">
<title>ostrow-serwis.pl</title>	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="main2.css">
<?php
 if (isset($_SESSION['admin']))
{
	$id = $_POST['id'];
	echo "<a href=\"#\" onclick=\"javascript:window.print()\">DRUKUJ</a>";
require_once "connect.php";
$wynik3 = mysqli_query($baza,"SELECT * FROM zlecenia WHERE id = '$id'");
while($row2 = mysqli_fetch_array($wynik3))
{
	$GLOBALS['id'] = $row2['id'];
	$GLOBALS['telefon'] = $row2['telefon'];
	echo "
	
		<div class=\"container\">
		<div class=\"row\">
		<div class=\"col-md-4 odpowiedz\"></div>
		<div class=\"col-md-4 odpowiedz\"></div>
		<div class=\"col-md-4 odpowiedz\">Serwis.</div>
		</div>
		Niniejszy dokument jest potwierdzeniem złożenia zlecenia naprawy sprzętu:<br><br>
		<b>Sprawdź aktualny status zlecenia na stronie ostrow-serwis.pl -> zakładka \"Sprawdź aktualny status zlecenia\"</b><br><br>
			<table class=\"table table-bordered\">
				<thead>
					<tr>
						<th>Nr zlecenia</th>
						<th>Nazwisko</th>
						<th>Numer telefonu</th>
						<th>Miejscowość</th>
						<th>Ulica</th>
						<th>Numer</th>
						<th>Rodzaj naprawy</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>".$row2['id']."</td>
						<td>".$row2['nazwisko']."</td>
						<td>".$row2['telefon']."</td>
						<td>".$row2['miejscowosc']."</td>
						<td>".$row2['ulica']."</td>
						<td>".$row2['numer_domu']."</td>
						<td>".$row2['jaka']."</td>
					</tr>
				</tbody>
				</table>
				<table class=\"table table-bordered\">
				<thead>
					<tr>
						<th>Numer fabryczny</th>
						<th>Marka sprzętu</th>
						<th>Model sprzętu</th>
						<th>Opis uszkodzenia</th>
						<th>Uwagi</th>
						<th>Data przyjęcia</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>".$row2['numer']."</td>
						<td>".$row2['marka']."</td>
						<td>".$row2['model']."</td>
						<td>".$row2['opis']."</td>
						<td>".$row2['uwagi']."</td>
						<td>".$row2['data']."</td></tr></tbody><table></div>";
	

	
}
?>
<ol>
			<li>Administratorem powyższych danych osobowych jest Serwis. - dalej "serwis"</li>
			<li>Podane dane są wykorzystywane tylko i wyłącznia do prawidłowego zrealizowania zlecenia, a także w celu nawiązania kontaktu z klientem i poinformowaniu go stanie zlecenia.</li>
			<li>Klient wyraża zgodę na kontakt drogą telefoniczną oraz elektroniczną (jeżeli podano numer telefonu i email)</li>
			<li>Klient może żądać usunięcia lub zmiany danych podanych w serwisie.</li>
			<li>Jeżeli klient nie odbierze złożonego w serwisie sprzętu przed upływem 4 miesięcy od poinformowania go o zakończeniu naprawy to za każdy kolejny dzień przechowywania sprzętu pobierana jest opłata na rzecz serwisu w wysokości 25 złotych dziennie.</li>
			
			</ol><br><br>
			<div class="container">
			<div class="row">
			<div class="col-md-6">
			Serwis<br><br>
			...............................
			</div>
			<div class="col-md-6">
			Podpis klienta<br><br>
			...............................
			</div>
			</div>
			</div>
			
<hr>
<?php
require_once "connect.php";
$wynik3 = mysqli_query($baza,"SELECT * FROM zlecenia WHERE id = '$id'");
while($row3 = mysqli_fetch_array($wynik3))
{
	echo "<p>Potwierdzenie przyjęcia zlecenia</p>
	Niniejszy dokument jest potwierdzeniem złożenia zlecenia naprawy sprzętu:<br><br>
		<div class=\"container\">
			<table class=\"table table-bordered\">
				<thead>
					<tr>
						<th>Nr zlecenia</th>
						<th>Nazwisko</th>
						<th>Numer telefonu</th>
						<th>Miejscowość</th>
						<th>Ulica</th>
						<th>Numer</th>
						<th>Rodzaj naprawy</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>".$row3['id']."</td>
						<td>".$row3['nazwisko']."</td>
						<td>".$row3['telefon']."</td>
						<td>".$row3['miejscowosc']."</td>
						<td>".$row3['ulica']."</td>
						<td>".$row3['numer_domu']."</td>
						<td>".$row3['jaka']."</td>
					</tr>
				</tbody>
				</table>
				<table class=\"table table-bordered\">
				<thead>
					<tr>
						<th>Numer fabryczny</th>
						<th>Marka sprzętu</th>
						<th>Model sprzętu</th>
						<th>Opis uszkodzenia</th>
						<th>Uwagi</th>
						<th>Data przyjęcia</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>".$row3['numer']."</td>
						<td>".$row3['marka']."</td>
						<td>".$row3['model']."</td>
						<td>".$row3['opis']."</td>
						<td>".$row3['uwagi']."</td>
						<td>".$row3['data']."</td></tr></tbody><table></div>";
	

	
}
?>
<ol>
			<li>Administratorem powyższych danych osobowych jest Serwis RTV Jan Jaś 63-400 Ostrów Wielkopolski ul. Sobieskiego 7. - dalej "serwis"</li>
			<li>Podane dane są wykorzystywane tylko i wyłącznia do prawidłowego zrealizowania zlecenia, a także w celu nawiązania kontaktu z klientem i poinformowaniu go stanie zlecenia.</li>
			<li>Klient wyraża zgodę na kontakt drogą telefoniczną oraz elektroniczną (jeżeli podano numer telefonu i email)</li>
			<li>Klient może żądać usunięcia lub zmiany danych podanych w serwisie.</li>
			<li>Jeżeli klient nie odbierze złożonego w serwisie sprzętu przed upływem 4 miesięcy od poinformowania go o zakończeniu naprawy to za każdy kolejny dzień przechowywania sprzętu pobierana jest opłata na rzecz serwisu w wysokości 25 złotych dziennie.</li>
			
			</ol><br><br>
			<div class="container">
			<div class="row">
			<div class="col-md-6">
			Serwis<br><br>
			...............................
			</div>
			<div class="col-md-6">
			Podpis klienta<br><br>
			...............................
			</div>
			</div>
			</div>
			<hr>
			<h1>Numer zlecenia: <?php echo $GLOBALS['id']." ----------- Telefon: ".$GLOBALS['telefon'];?></h1>
			
<?php 
}
else
{
	echo "nie umasz uprawnień do tej strony";
}
?>
</body>
</html>