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
	require_once "connect.php";
	$id = $_POST['id'];
	echo "<a href=\"#\" onclick=\"javascript:window.print()\">DRUKUJ</a>";

?>
<div class="container">
<h1>Rozliczenie zlecenia nr <?php echo $id."</h1>";
$wynik3 = mysqli_query($baza,"SELECT * FROM zlecenia WHERE id = '$id'");
while($row2 = mysqli_fetch_array($wynik3))
{
	echo "
		<div class=\"container\">
		<div class=\"row\">
		<div class=\"col-md-4 odpowiedz\"></div>
		<div class=\"col-md-4 odpowiedz\"></div>
		<div class=\"col-md-4 odpowiedz\">Serwis
		</div>
			<table class=\"table table-bordered\">
				<thead>
					<tr>
						<th>Nr zlecenia</th>
						<th>Imię</th>
						<th>Nazwisko</th>
						<th>Numer telefonu</th>
						<th>Rodzaj sprzętu</th>
						<th>Miejscowość</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>".$row2['id']."</td>
						<td>".$row2['imie']."</td>
						<td>".$row2['nazwisko']."</td>
						<td>".$row2['telefon']."</td>
						<td>".$row2['rodzaj']."</td>
						<td>".$row2['miejscowosc']."</td>
					</tr>
				</tbody>
				<thead>
					<tr>
						<th>Ulica</th>
						<th>Numer domu</th>
						<th>Marka</th>
						<th>Opis uszkodzenia</th>
						<th>Uwagi</th>
						<th>Data przyjęcia</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>".$row2['ulica']."</td>
						<td>".$row2['numer_domu']."</td>
						<td>".$row2['marka']."</td>
						<td>".$row2['opis']."</td>
						<td>".$row2['uwagi']."</td>
						<td>".$row2['data']."</td></tr></tbody><table></div>";
	

	
}
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
						<?php
						$liczba = 1;
						$suma = 00.00;
						
						$wynik6 = mysqli_query($baza,"SELECT * FROM rozliczenie WHERE id_zlecenia=$id");
						while($row6 = mysqli_fetch_array($wynik6))
						{
						
							?>
							
							<tr>
								<td><?php echo $liczba++;?></td>
								<td><?php echo $row6['rodzaj'];?></td>
								<td><?php echo $row6['kwota'];?></td>
							</tr>
							<?php
							$suma = $suma + $row6['kwota'];
							
						}
						echo "</tbody><thead><tr><th>SUMA</th><th>-</th><th>";
						echo $suma." zł";
						echo "</th></tr></thead></table></div>";
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