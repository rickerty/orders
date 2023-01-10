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
	echo"<a href=\"#\" onclick=\"javascript:window.print()\">DRUKUJ</a>
		<div class=\"container\">
		<div class=\"row\">
		<div class=\"col-md-4 odpowiedz\"></div>
		<div class=\"col-md-4 odpowiedz\"></div>
		<div class=\"col-md-4 odpowiedz\">Serwis </div>
		</div>
		Niniejszy dokument jest potwierdzeniem złożenia zlecenia naprawy sprzętu:<br><br>
			<table class=\"table table-bordered\">
				<thead>
					<tr>
						<th>Nr zlecenia</th>
						<th>Imię</th>
						<th>Nazwisko</th>
						<th>Numer telefonu</th>
						<th>Adres</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><br><br></td>
						<td><br><br></td>
						<td><br><br></td>
						<td><br><br></td>
						<td><br><br></td>
					</tr>
				</tbody>
				<thead>
					<tr>
						<th>Numer fabryczny</th>
						<th>Marka sprzętu</th>
						<th>Opis uszkodzenia</th>
						<th>Uwagi</th>
						<th>Data przyjęcia</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><br><br></td>
						<td><br><br></td>
						<td><br><br></td>
						<td><br><br></td>
						<td><br><br></td></tr></tbody><table></div>";
	

	

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

	

	

?>
<table class="table table-bordered">
							<thead>
								<tr>
									<th>Nr</th>
									<th>Rodzaj</th>
									<th>Kwota</th>
								</tr>
							</thead>
							<tbody>
						
							
							<tr>
								<td>1.</td>
								<td><br></td>
								<td><br></td>
							</tr>
							<tr>
								<td>2.</td>
								<td><br></td>
								<td><br></td>
							</tr>
							<tr>
								<td>3.</td>
								<td><br></td>
								<td><br></td>
							</tr>
							<tr>
								<td>4.</td>
								<td><br></td>
								<td><br></td>
							</tr>
							</tbody><thead><tr><th>SUMA</th><th>-</th><th>
						
						</th></tr></thead></table></div>
?>
<div class="container">
			<div class="row">
			<div class="col-md-6">
			Na wymienione podzespoły udzielamy 3 miesięcy gwarancji.
			
			</div>
			<div class="col-md-6">
			Potwierdzam odbiór naprawionego sprzętu.<br><br>
			Podpis klienta<br><br>
			...............................
			</div>
			</div>
			</div>
			
			
<?php 
}
else
{
	echo "nie umasz uprawnień do tej strony";
}
?>
</body>
</html>