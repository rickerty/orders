<?php
session_start();
require_once 'gora.php';
$server_ip = $_SERVER['REMOTE_ADDR'];
if (isset($_SESSION['admin']) && $_SESSION['ip_login'] == $server_ip)
{
?>
<div class="container">
	<div class="row">
		<div class="col-md-3 menu-pion">
		<ul>
			<li><a href="?dodaj">Dodaj zlecenie</a></li>
			<li><a href="?sprawdz">Wykaz zleceń</a></li>
			<ul>
			<li><a href="?przyjete">Zlecenia przyjęte</a></li>
			<li><a href="?wtoku">Zlecenia w toku</a></li>
			<li><a href="?zrealizowane">Zlecenia zrealizowane</a></li>
			<li><a href="?anulowane">Zlecenia anulowane</a></li>
			</ul>
			
			<?php
			if ($_SESSION['administrator'] == "1")
				echo "<li><a href=\"?uzytkownicy\">Administrowanie użytkownikami</a></li>";
				echo "<li><a href=\"?ogloszenia\">Ogłoszenia</a></li>";
				echo "<li><a href=\"?logi\">Logi</a></li>";
			?>
			<li><a href="?statystyka">Statystyka</a></li>
			<li><a  href="index.php?akcja=wyloguj">Wyloguj</a></li>
			<li><a target="blank" href="potwierdzenie_puste.php">Puste rozliczenie</a></li>
		</ul>
		<script type="text/javascript">
var secs = 6000; //**** liczba sekund do odliczenia
var element = 'czas'; //**** atrybut "id" elementu wyświetlającego wynik
var T = null;
function count(id){
        temp = secs;

        if(secs > 0){

                //**** ten kawałek kodu "rozbija" sekundy na inne jednostki 

                
                result = Math.floor(temp / 60) + ' minut ';
                temp %= 60;
                result += temp + ' sekund';
                document.getElementById(element).innerHTML = result; //**** wypisanie stanu zegara

                secs--;
        }else{
                location.href="index.php?akcja=wyloguj";
                clearInterval(T);
        }

}
function counter(days, hours, minutes, seconds){

        secs = days*86400 + hours*3600 + minutes*60 + seconds;

        T = window.setInterval("count()", 1000);
        //count();
}


</script>
<div>Do zakończenia sesji pozostało: </div>
<div id="czas"></div><br><br>
<script type="text/javascript">counter(0,0,0,600);</script>
		<?php
		$timestamp = time();
		$datum = date("d.m.Y",$timestamp);
		echo "Dzisiaj jest ".$datum;
		?>
		</div>
		<div class="col-md-9 text-justify">
		
		<?php
		if (isset($_GET['panel']))
		{
			echo "Witamy w systemie ZLECENIE. <br><br>Na tej stronie znajdziesz komunikaty dotyczące zmian w systemie<br><br>";
			require_once "connect.php";
			$ogloszenia = mysqli_query($baza,"SELECT * FROM ogloszenia ORDER BY id DESC");
			while($news = mysqli_fetch_array($ogloszenia))
			{
				echo "<table class=\"ogloszenie\"><tr><td>".$news['data']."</td><td>
				".$news['ogloszenie']."</td></tr></table><hr>";
			}
		}
		else if (isset($_GET['statystyka']))
		{
			echo "<p>Statystyka</p>";
			
		}
		else if (isset($_GET['uzytkownicy']))
		{
			?>
			<form action="?dodaj_uzytkownika" method="POST">
						<div class="container">
						<div class="row">
						<div class="col-md-4 odpowiedz">Login: <b><br><input type="text" class="form-control" name="login"></b></div>
						<div class="col-md-4 odpowiedz">Hasło: <b><br><input type="text" class="form-control" name="pass" ></b></div>
						<div class="col-md-4 odpowiedz">Inicjały: <b><br><input type="text" class="form-control" name="inicjaly"></b></div>
						
							<div class="col-md-4 odpowiedz"><br>
							<button type="submit" name="edytuj" class="btn btn-success">Dodaj użytkownika</button>
							</div>
						</div>
						</div>
				</form>
				<div class="container">
							<table class="table table-bordered">
							<thead>
								<tr>
									<th>ID</th>
									<th>Login</th>
									<th>Inicjały</th>
								</tr>
							</thead>
							<tbody>
						<?php
						require_once "connect.php";
						$wynik10 = mysqli_query($baza,"SELECT * FROM users ");
						while($row10 = mysqli_fetch_array($wynik10))
						{
						
							?>
							
							<tr>
								<td><?php echo $row10['id'];?></td>
								<td><?php echo $row10['login'];?></td>
								<td><?php echo $row10['inicjaly'];?></td>
							</tr>
							<?php
							
						}
						echo "</tbody></table></div>";
				
		}
		else if (isset($_GET['szukaj_nazwisko']))
		{
			require_once "connect.php";
			$szukaj = $_POST['szukaj'];
			echo "<table class=\"table\"><tr><th> ID zlecenia</th><th>Imię klienta</th><th>Nazwisko klienta</th><th>Data przyjęcia</th><th>Status</th><th>Szczegóły</th></tr>";
			$wynik11 = mysqli_query($baza,"SELECT * FROM zlecenia WHERE LOWER(nazwisko) = '$szukaj'");
			while($row11 = mysqli_fetch_array($wynik11))
				{
					echo "<tr><td>".$row11['id']."</td><td>".$row11['imie']."</td><td>".$row11['nazwisko']."</td><td>".$row11['data']."</td><td>";
					
								if ($row11['status'] == "Przyjęte")
								{
									echo "<p class=\"przyjete\">".$row11['status']."</p>";
								}
								else if ($row11['status'] == "Zrealizowane")
								{
									echo "<p class=\"zrealizowane\">".$row11['status']."</p>";
								}
								else if ($row11['status'] == "Anulowane")
								{
									echo "<p class=\"anulowane\">".$row11['status']."</p>";
								}
								
					echo "<td><form method=\"POST\" action=\"?edycja\"><button type=\"submit\" name=\"przycisk\" value=\"".$row11['id']."\" class=\"btn btn-success\">
					Szczegóły</button></form></td></tr>";
				}
					echo "</table>";
		}
		else if (isset($_GET['dodaj_uzytkownika']))
		{
			$login = $_POST['login'];
			$pass = $_POST['pass'];
			$inicjaly = $_POST['inicjaly'];
			require_once "connect.php";
			$sql = "INSERT INTO users (login, pass, inicjaly) VALUES 
			('$login', '$pass', '$inicjaly')";
			if ($baza->query($sql) === TRUE) 
				{
					echo "Użytkownik dodany prawidłowo";
				}
		}
		else if (isset($_GET['dodaj']))
		{
			?>
			<form action="?dodane" method="POST">
			<div class="form-group">
				<label for="imie">Imię:</label>
				<input type="text" class="form-control" id="imie" placeholder="Imię klienta" name="imie">
			</div>
			<div class="form-group">
				<label for="nazwisko">Nazwisko:</label>
				<input type="text" class="form-control" id="nazwisko" placeholder="Nazwisko klienta" name="nazwisko">
			</div>
			<div class="form-group">
				<label for="miejscowosc">Miejscowość:</label>
				<input type="text" class="form-control" id="miejscowosc" placeholder="Miejscowość" name="miejscowosc">
			</div>
			<div class="form-group">
				<label for="ulica">Ulica:</label>
				<input type="text" class="form-control" id="ulica" placeholder="Ulica" name="ulica">
			</div>
			<div class="form-group">
				<label for="numer_domu">Numer domu:</label>
				<input type="text" class="form-control" id="numer_domu" placeholder="Numer domu" name="numer_domu">
			</div>
			<div class="form-group">
				<label for="telefon">Numer telefonu:</label>
				<input type="text" class="form-control" id="telefon" placeholder="Numer telefonu" name="telefon">
			</div>
			<div class="form-group">
				<label for="email">Adres email:</label>
				<input type="text" class="form-control" id="email" placeholder="Adres email" name="email">
			</div>
			<div class="form-group">
				<label for="rodzaj">Rodzaj sprzętu:</label>
				<input type="text" class="form-control" id="rodzaj" placeholder="Rodzaj sprzętu" name="rodzaj">
			</div>
			<div class="form-group">
				<label for="marka">Marka:</label>
				<input type="text" class="form-control" id="marka" placeholder="Marka sprzętu" name="marka">
			</div>
			<div class="form-group">
				<label for="model">Model:</label>
				<input type="text" class="form-control" id="model" placeholder="Model sprzętu" name="model">
			</div>
			<div class="form-group">
				<label for="numer">Numer fabryczny:</label>
				<input type="text" class="form-control" id="numer" placeholder="Numer fabryczny" name="numer">
			</div>
			<div class="form-group">
				<label for="opis">Opis usterki:</label>
				<input type="text" class="form-control" id="opis" placeholder="Opis usterki" name="opis">
			</div>
			<div class="form-group">
				<label for="uwagi">Uwagi:</label>
				<input type="text" class="form-control" id="uwagi" placeholder="Uwagi" name="uwagi">
			</div>
			<div class="form-group">
			<label for="status">Status:</label>
			<select name="status" class="form-control">
			<option>Przyjęte</option>
			</select>
			</div>
			<div class="form-group">
			<label for="jaka">Rodzaj naprawy:</label>
			<select name="jaka" class="form-control">
			<option>Gwarancyjna - Teren</option>
			<option>Gwarancyjna - Warsztat</option>
			<option>Odpłatna - Teren</option>
			<option>Odpłatna - Warsztat</option>
			</select>
			</div>
			<button type="submit" class="btn btn-success">Dodaj</button>
			</form>
			<?php
		}
		else if (isset($_GET['dodane']))
		{
			$imie = $_POST['imie'];
			$nazwisko = $_POST['nazwisko'];
			$telefon = $_POST['telefon'];
			$email = $_POST['email'];
			$rodzaj = $_POST['rodzaj'];
			$opis = $_POST['opis'];
			$jaka = $_POST['jaka'];
			$status =$_POST['status'];
			$numer =$_POST['numer'];
			$marka =$_POST['marka'];
			$miejscowosc =$_POST['miejscowosc'];
			$ulica =$_POST['ulica'];
			$model =$_POST['model'];
			$uwagi =$_POST['uwagi'];
			$numer_domu =$_POST['numer_domu'];
			$timestamp = time();
			$datum = date("Y-m-d",$timestamp);
			require_once "connect.php";
			$sql = "INSERT INTO zlecenia (imie, nazwisko, telefon, email, rodzaj, opis, status, numer, marka, data, miejscowosc, ulica, numer_domu, model, uwagi, jaka) VALUES 
			('$imie', '$nazwisko', '$telefon', '$email', '$rodzaj', '$opis', '$status', '$numer', '$marka', '$datum', '$miejscowosc', '$ulica', '$numer_domu', '$model', '$uwagi', '$jaka')";
			if ($baza->query($sql) === TRUE) 
				{
					echo "<b>Wpis został dodany! Sprawdź dane</b><br><br>";
					echo "
					<div class=\"container\">
					<div class=\"row\">
					<div class=\"col-md-4 odpowiedz\">ID zlecenia: <b><br>";
					$wynik3 = mysqli_query($baza,"SELECT * FROM zlecenia WHERE email='$email' AND nazwisko='$nazwisko' AND opis='$opis' AND data='$datum'");
					while($row2 = mysqli_fetch_array($wynik3))
					{
						echo $row2['id'];
						$GLOBALS['id_przy_dodawaniu'] = $row2['id'];
					}
					
					echo "</b></div>
					<div class=\"col-md-4 odpowiedz\">Imię: <b><br>".$imie."</b></div>
					<div class=\"col-md-4 odpowiedz\">Nazwisko: <b><br>".$nazwisko."</b></div>
					<div class=\"col-md-4 odpowiedz\">Miejscowość: <b><br>".$miejscowosc."</b></div>
					<div class=\"col-md-4 odpowiedz\">Ulica: <b><br>".$ulica."</b></div>
					<div class=\"col-md-4 odpowiedz\">Numer domu: <b><br>".$numer_domu."</b></div>
					<div class=\"col-md-4 odpowiedz\">Marka: <b><br>".$marka."</b></div>
					<div class=\"col-md-4 odpowiedz\">Model: <b><br>".$model."</b></div>
					<div class=\"col-md-4 odpowiedz\">Rodzaj naprawy: <b><br>".$jaka."</b></div>
					<div class=\"col-md-4 odpowiedz\">Numer fabryczny: <b><br>".$numer."</b></div>
					<div class=\"col-md-4 odpowiedz\">Numer telefonu: <b><br>".$telefon."</b></div>		
					<div class=\"col-md-4 odpowiedz\">Adres email: <b><br>".$email."</b></div>	
					<div class=\"col-md-4 odpowiedz\">Rodzaj sprzętu: <b><br>".$rodzaj."</b></div>
					<div class=\"col-md-4 odpowiedz\">Opis usterki: <b><br>".$opis."</b></div>
					<div class=\"col-md-4 odpowiedz\">Uwagi: <b><br>".$uwagi."</b></div>
					</div></div>";
					echo "<form action=\"potwierdzenie.php\" method=\"POST\" target=\"_blank\">
				
					<input type=\"hidden\" name=\"id\" value=\"".$GLOBALS['id_przy_dodawaniu']."\">
					<button type=\"submit\" class=\"btn btn-success\">Drukuj formularz</button>
					</form>";
						
				} 
				else 
				{
					echo "Error: " . $sql . "<br>" . $baza->error;
				}
		}
		else if (isset($_GET['sprawdz']))
		{
			require_once "connect.php";
			echo "<table class=\"tabela\"><tr><th> ID</th><th>Rodzaj naprawy</th><th>Imię klienta</th><th>Nazwisko klienta</th><th>Data przyjęcia</th><th>Sprzęt</th><th>Status</th><th>Szczegóły</th></tr>";
			$wynik2 = mysqli_query($baza,"SELECT * FROM zlecenia ORDER BY id DESC");
			while($row = mysqli_fetch_array($wynik2))
				{
					echo "<tr><td>".$row['id']."</td><td><center>";
						if ($row['jaka'] == "Gwarancyjna - Teren")
						{
							echo "GT";
						}
						else if ($row['jaka'] == "Gwarancyjna - Warsztat")
						{
							echo "GW";
						}
						else if ($row['jaka'] == "Odpłatna - Teren")
						{
							echo "OT";
						}
						else if ($row['jaka'] == "Odpłatna - Warsztat")
						{
							echo "OW";
						}
						else if ($row['jaka'] == "Odpłatna")
						{
							echo "O";
						}
						else if ($row['jaka'] == "Gwarancyjna")
						{
							echo "G";
						}
					
					
					echo "</td><td>".$row['imie']."</td><td>".$row['nazwisko']."</td><td>".$row['data']."</td><td>".$row['rodzaj']."<td>";
					
								if ($row['status'] == "Przyjęte")
								{
									echo "<p class=\"przyjete\">".$row['status']."</p>";
								}
								else if ($row['status'] == "W realizacji")
								{
									echo "<p class=\"wrealizacji\">".$row['status']."</p>";
								}
								else if ($row['status'] == "Zrealizowane")
								{
									echo "<p class=\"zrealizowane\">".$row['status']."</p>";
								}
								else if ($row['status'] == "Anulowane")
								{
									echo "<p class=\"anulowane\">".$row['status']."</p>";
								}
								
					echo "<td><form method=\"POST\" action=\"?edycja\"><button type=\"submit\" name=\"przycisk\" value=\"".$row['id']."\" class=\"btn btn-success\">
					Szczegóły</button></form></td></tr>";
				}
					echo "</table>";
			
		}
		else if (isset($_GET['edytuj_status']))
		{
			require_once "connect.php";
			$id = $_POST['id'];
			$status = $_POST['status'];
			$sql_status = "UPDATE zlecenia SET status='$status' WHERE id='$id'";
			if ($baza->query($sql_status) === TRUE) 
			{
				echo 	"<div class=\"container\">
						<div class=\"row\">
						<form action=\"?edycja\" method=\"POST\"> <input type=\"hidden\" value=\"".$id."\" name=\"przycisk\"></b></div>
						<button type=\"submit\"  class=\"btn btn-success\">Wróć do zlecenia</button>
						</form></div></div>";
			}
		}
		else if (isset($_GET['edycja_z_sms']))
		{
			require_once "connect.php";
			$id = $_POST['id'];
			$telefon = $_POST['telefon'];
			$jaka = $_POST['jaka'];
			$sql_status = "UPDATE zlecenia SET status='Zrealizowane' WHERE id='$id'";
			if ($baza->query($sql_status) === TRUE) 
			{
				if (empty($telefon))
				{
					echo "SMS nie został wysłany z uwagi na brak numeru telefonu.<br><br>Zmieniono status na ZREALIZOWANE<BR><BR>
					<div class=\"container\">
						<div class=\"row\">
						<form action=\"?edycja\" method=\"POST\"> <input type=\"hidden\" value=\"".$id."\" name=\"przycisk\"></b></div>
						<button type=\"submit\"  class=\"btn btn-success\">Wróć do zlecenia</button>
						</form></div></div>";
				}
				else if ($jaka == "Odpłatna - Warsztat" OR $jaka == "Gwarancyjna - Warsztat")
				{
					require_once "sms.php";
					echo "<br><br>Wysłano SMS z powiadomieniem.<br><br>Zmieniono status na ZREALIZOWANE<BR><BR>
					<div class=\"container\">
						<div class=\"row\">
						<form action=\"?edycja\" method=\"POST\"> <input type=\"hidden\" value=\"".$id."\" name=\"przycisk\"></b></div>
						<button type=\"submit\"  class=\"btn btn-success\">Wróć do zlecenia</button>
						</form></div></div>";
				}
				else
				{
					echo "SMS nie został wysłany z uwagi na naprawę terenową.<br><br>Zmieniono status na ZREALIZOWANE<BR><BR>
					<div class=\"container\">
						<div class=\"row\">
						<form action=\"?edycja\" method=\"POST\"> <input type=\"hidden\" value=\"".$id."\" name=\"przycisk\"></b></div>
						<button type=\"submit\"  class=\"btn btn-success\">Wróć do zlecenia</button>
						</form></div></div>";
				}
			}
		}
		else if (isset($_GET['edycja']))
		{
			require_once "connect.php";
			$id = $_POST['przycisk'];
			$wynik2 = mysqli_query($baza,"SELECT * FROM zlecenia WHERE id=$id");
			while($row = mysqli_fetch_array($wynik2))
				{
					?>
						<form action="?edytuj" method="POST">
						<div class="container">
						<div class="row">
						<div class="col-md-4 odpowiedz">Rodzaj naprawy: <b><?php echo $row['jaka'];?></b></div>
						<div class="col-md-4 odpowiedz">ID zlecenia: <b><br><input type="text" class="form-control" name="id" value="<?php echo $row['id'];?>"></b></div>
						<div class="col-md-4 odpowiedz">Imię: <b><br><input type="text" class="form-control" name="imie" value="<?php echo $row['imie'];?>"></b></div>
						<div class="col-md-4 odpowiedz">Nazwisko: <b><br><input type="text" class="form-control" name="nazwisko" value="<?php echo $row['nazwisko'];?>"></b></div>
						<div class="col-md-4 odpowiedz">Miejscowość: <b><br><input type="text" class="form-control" name="miejscowosc" value="<?php echo $row['miejscowosc'];?>"></b></div>
						<div class="col-md-4 odpowiedz">Ulica: <b><br><input type="text" class="form-control" name="ulica" value="<?php echo $row['ulica'];?>"></b></div>
						<div class="col-md-4 odpowiedz">Numer domu: <b><br><input type="text" class="form-control" name="numer_domu" value="<?php echo $row['numer_domu'];?>"></b></div>
						<div class="col-md-4 odpowiedz">Rodzaj sprzętu: <b><br><input type="text" class="form-control" name="rodzaj" value="<?php echo $row['rodzaj'];?>"></b></div>
						<div class="col-md-4 odpowiedz">Marka: <b><br><input type="text" class="form-control" name="marka" value="<?php echo $row['marka'];?>"></b></div>
						<div class="col-md-4 odpowiedz">Model: <b><br><input type="text" class="form-control" name="model" value="<?php echo $row['model'];?>"></b></div>
						<div class="col-md-4 odpowiedz">Numer fabryczny: <b><br><input type="text" class="form-control" name="numer" value="<?php echo $row['numer'];?>"></b></div>
						<div class="col-md-4 odpowiedz">Numer telefonu: <b><br><input type="text" class="form-control" name="telefon" value="<?php echo $row['telefon'];?>"></b></div>		
						<div class="col-md-4 odpowiedz">Adres email: <b><br><input type="text" class="form-control" name="email" value="<?php echo $row['email'];?>"></b></div>	
						<div class="col-md-4 odpowiedz">Opis usterki: <br><textarea class="form-control" rows="5" name="opis"><?php echo $row['opis'];?></textarea></div>
						<div class="col-md-4 odpowiedz">Uwagi: <br><textarea class="form-control" rows="5" name="uwagi"><?php echo $row['uwagi'];?></textarea></div>
						<div class="col-md-4 odpowiedz"><br>
						<button type="submit" name="edytuj" class="btn btn-success">Zatwierdź edycje danych zlecenia</button>
						</form>
						</div>
						<div class="col-md-4 odpowiedz"><br>
							<form action="potwierdzenie.php" method="POST" target="_blank">
				
							<input type="hidden" name="id" value="<?php echo $row['id'];?>">
							<button type="submit" class="btn btn-success">Drukuj potwierdzenie przyjęcia zlecenia</button>
							</form>
							</div>
						</div></div>
						<hr>
						<div class="container">
						<div class="row">
							<div class="col-md-4 odpowiedz">
							<form action="?edytuj_status" method="POST">
							<input type="hidden" name="id" value="<?php echo $row['id'];?>">
							<label for="status">Aktualny status: <?php echo $row['status'];?></label>
							<label for="status">Zmień status:</label>
							<select name="status" class="form-control">
							<option>Przyjęte</option>
							<option>W realizacji</option>
							<option>Zrealizowane</option>
							<option>Anulowane</option>
							</select>
							</div>
							<div class="col-md-4 odpowiedz"><br>
							<button type="submit" name="edytuj_status" class="btn btn-success">Zatwierdź zmianę statusu</button>
							</form>
							</div>
							<div class="col-md-4 odpowiedz"><br>
							<form action="?edycja_z_sms" method="POST">
							<input type="hidden" name="id" value="<?php echo $row['id'];?>">
							<input type="hidden" name="telefon" value="<?php echo $row['telefon'];?>">
							<input type="hidden" name="jaka" value="<?php echo $row['jaka'];?>">
							Zmień status na "Zrealizowany" i jednocześnie wyślij sms z powiadomieniem:<br>
							<button type="submit" name="edytuj_sms" class="btn btn-success">Zrealizowane + SMS</button>
							</form>
							</div>
						</div>
						</div>
							
							<hr>
						<p>Działania:</p>
						<div class="container">
							<table class="table table-bordered">
							<thead>
								<tr>
									<th>Nr</th>
									<th>Data</th>
									<th>Rodzaj działania</th>
									<th>Zlecił</th>
								</tr>
							</thead>
							<tbody>
						<?php
						$liczba = 1;
						$wynik4 = mysqli_query($baza,"SELECT * FROM dzialania WHERE id_zlecenia=$id");
						while($row4 = mysqli_fetch_array($wynik4))
						{
						
							?>
							
							<tr>
								<td><?php echo $liczba++;?></td>
								<td><?php echo $row4['data'];?></td>
								<td><?php echo $row4['rodzaj'];?></td>
								<td><?php echo $row4['kto'];?></td>
							</tr>
							<?php
							
						}
						echo "</tbody></table></div>";
						?>
						<p>Dodaj działanie</p>
						<form action="?dodaj_dzialanie" method="POST">
						<div class="container">
						<div class="row">
						<div class="col-md-4 odpowiedz">Rodzaj działania: <br><textarea class="form-control" rows="5" name="rodzaj"></textarea></div>
						<input type="hidden" class="form-control" name="kto" value="<?php echo $_SESSION['inicjaly_admin'];?>"></b>
						</div>
						</div>
						<input type="hidden" name="id_zlecenia" value="<?php echo $row['id']; ?>">
						<div class="col-md-4 odpowiedz"><button type="submit" name="dodaj_dzialanie" class="btn btn-success">Dodaj działanie</button></div>
						</form>
						<hr>
						<p>Rozlicz zlecenie</p>
						<div class="container">
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
						echo $suma;
						echo "</th></tr></thead></table></div>";
						?>
						<div class="container">
						<div class="row">
						
						<form action="rozliczenie.php" method="POST" target="blank">
						<input type="hidden" value="<?php echo $id;?>" name="id">
						<div class="col-md-4 odpowiedz"><button type="submit" class="btn btn-success">Drukuj rozliczenie</button></form></div>
						</div>
						</div>
						
						<form action="?dodaj_rozliczenie" method="POST">
						<div class="container">
						<div class="row">
						
						
						<div class="col-md-4 odpowiedz">Rodzaj czynności: <b><br><br><input type="text" class="form-control" name="rodzaj"></b></div>
						<div class="col-md-4 odpowiedz">Kwota (kwotę zapisz %%.%% np. 10.50): <b><br><input type="text" class="form-control" name="kwota"></b></div>
						<input type="hidden" value="<?php echo $id;?>" name="id_zlecenia"></b></div>
						
							<button type="submit" name="dodaj_rozliczenie" class="btn btn-success">Dodaj punkt rozliczenia</button>
							</form>
							
							</div>
							</div>
						<?php
					
				}
		}
		else if (isset($_GET['dodaj_rozliczenie']))
		{
			require_once "connect.php";
			$id_zlecenia = $_POST['id_zlecenia'];
			$rodzaj = $_POST['rodzaj'];
			$kwota = $_POST['kwota'];
			$sql = "INSERT INTO rozliczenie (id_zlecenia, rodzaj, kwota) VALUES 
			('$id_zlecenia', '$rodzaj', '$kwota')";
			if ($baza->query($sql) === TRUE)
			{
				echo "<div class=\"container\">
						<div class=\"row\">
						<form action=\"?edycja\" method=\"POST\"> <input type=\"hidden\" value=\"".$id_zlecenia."\" name=\"przycisk\"></b></div>
				<button type=\"submit\"  class=\"btn btn-success\">Wróć do zlecenia</button>
				</form></div></div>";
				
			}
		}
		else if (isset($_GET['dodaj_dzialanie']))
		{
			require_once "connect.php";
			$id_zlecenia = $_POST['id_zlecenia'];
			$rodzaj = $_POST['rodzaj'];
			$kto = $_POST['kto'];
			$datum = date("Y-m-d",$timestamp);
			$sql2 = "SELECT * FROM dzialania WHERE id_zlecenia = '$id_zlecenia'";
			if ($rezultat2 = $baza->query($sql2))
			{
				$ile_dzialan2 = $rezultat2->num_rows;
				if($ile_dzialan2==0)
				{
					$sql = "UPDATE zlecenia SET status='W realizacji' WHERE id=$id_zlecenia";
					if ($baza->query($sql) === TRUE) 
					{
						echo "Zmieniono status zlecenia na: W REALIZACJI<br><br>";
					}
					else
					{
						echo "Coś poszło nie tak przy zmianiu statusu";
					}
				}
			}	
				
			$sql = "INSERT INTO dzialania (id_zlecenia, rodzaj, kto, data) VALUES 
			('$id_zlecenia', '$rodzaj', '$kto', '$datum')";
			if ($baza->query($sql) === TRUE)
			{
				echo "<b>Działanie zostało dodane!<br></b>
				<form action=\"?edycja\" method=\"POST\">
				<input type=\"hidden\" name=\"przycisk\" value=\"".$id_zlecenia."\">
				<button type=\"submit\" name=\"id\" class=\"btn btn-success\">Wróć do zlecenia</button></b>";
			}
			else
			{
				echo "Jest problem z wpisem";
			}
			
		}
		else if (isset($_GET['edytuj']))
		{
				require_once "connect.php";
				$imie = $_POST['imie'];
				$nazwisko = $_POST['nazwisko'];
				$telefon = $_POST['telefon'];
				$email = $_POST['email'];
				$rodzaj = $_POST['rodzaj'];
				$opis = $_POST['opis'];
				$numer =$_POST['numer'];
				$marka =$_POST['marka'];
				$model =$_POST['model'];
				$uwagi =$_POST['uwagi'];
				$miejscowosc =$_POST['miejscowosc'];
				$ulica =$_POST['ulica'];
				$numer_domu =$_POST['numer_domu'];
				$id =$_POST['id'];
				$sql = "UPDATE zlecenia SET imie='$imie', nazwisko='$nazwisko', telefon='$telefon', email='$email', rodzaj='$rodzaj', 
				opis='$opis', numer='$numer', marka='$marka', miejscowosc='$miejscowosc', ulica='$ulica', numer_domu='$numer_domu', model='$model', uwagi='$uwagi' WHERE id=$id";
				if ($baza->query($sql) === TRUE) 
				{
					echo "<b>Zlecenie zostało wyedytowane!<br>
				<form action=\"?edycja\" method=\"POST\">
				<input type=\"hidden\" name=\"przycisk\" value=\"".$id."\">
				<button type=\"submit\" name=\"id\" class=\"btn btn-success\">Wróć do zlecenia</button></b>";
				} 
				else 
				{
					echo "Error: " . $sql . "<br>" . $baza->error;
				}	
		}
		else if (isset($_GET['przyjete']))
		{
				require_once "connect.php";
			echo "<table class=\"table\"><tr><th> ID zlecenia</th><th>Imię klienta</th><th>Nazwisko klienta</th><th>Nr telefonu</th><th>Status</th><th>Szczegóły</th></tr>";
			$wynik2 = mysqli_query($baza,"SELECT * FROM zlecenia WHERE status='Przyjęte'");
			while($row = mysqli_fetch_array($wynik2))
				{
					echo "<tr><td>".$row['id']."</td><td>".$row['imie']."</td><td>".$row['nazwisko']."</td><td>".$row['telefon']."</td><td>";
					
								if ($row['status'] == "Przyjęte")
								{
									echo "<p class=\"przyjete\">".$row['status']."</p>";
								}
								else if ($row['status'] == "Zrealizowane")
								{
									echo "<p class=\"zrealizowane\">".$row['status']."</p>";
								}
								else if ($row['status'] == "Anulowane")
								{
									echo "<p class=\"anulowane\">".$row['status']."</p>";
								}
								
					echo "<td><form method=\"POST\" action=\"?edycja\"><button type=\"submit\" name=\"przycisk\" value=\"".$row['id']."\" class=\"btn btn-success\">
					Szczegóły</button></form></td></tr>";
				}
					echo "</table>";
		}
		else if (isset($_GET['zrealizowane']))
		{
				require_once "connect.php";
			echo "<table class=\"table\"><tr><th> ID zlecenia</th><th>Imię klienta</th><th>Nazwisko klienta</th><th>Nr telefonu</th><th>Status</th><th>Szczegóły</th></tr>";
			$wynik2 = mysqli_query($baza,"SELECT * FROM zlecenia WHERE status='Zrealizowane'");
			while($row = mysqli_fetch_array($wynik2))
				{
					echo "<tr><td>".$row['id']."</td><td>".$row['imie']."</td><td>".$row['nazwisko']."</td><td>".$row['telefon']."</td><td>";
					
								if ($row['status'] == "Przyjęte")
								{
									echo "<p class=\"przyjete\">".$row['status']."</p>";
								}
								else if ($row['status'] == "Zrealizowane")
								{
									echo "<p class=\"zrealizowane\">".$row['status']."</p>";
								}
								else if ($row['status'] == "Anulowane")
								{
									echo "<p class=\"anulowane\">".$row['status']."</p>";
								}
								
					echo "<td><form method=\"POST\" action=\"?edycja\"><button type=\"submit\" name=\"przycisk\" value=\"".$row['id']."\" class=\"btn btn-success\">
					Szczegóły</button></form></td></tr>";
				}
					echo "</table>";
		}
		else if (isset($_GET['anulowane']))
		{
				require_once "connect.php";
			echo "<table class=\"table\"><tr><th> ID zlecenia</th><th>Imię klienta</th><th>Nazwisko klienta</th><th>Nr telefonu</th><th>Status</th><th>Szczegóły</th></tr>";
			$wynik2 = mysqli_query($baza,"SELECT * FROM zlecenia WHERE status='Anulowane'");
			while($row = mysqli_fetch_array($wynik2))
				{
					echo "<tr><td>".$row['id']."</td><td>".$row['imie']."</td><td>".$row['nazwisko']."</td><td>".$row['telefon']."</td><td>";
					
								if ($row['status'] == "Przyjęte")
								{
									echo "<p class=\"przyjete\">".$row['status']."</p>";
								}
								else if ($row['status'] == "Zrealizowane")
								{
									echo "<p class=\"zrealizowane\">".$row['status']."</p>";
								}
								else if ($row['status'] == "Anulowane")
								{
									echo "<p class=\"anulowane\">".$row['status']."</p>";
								}
								
					echo "<td><form method=\"POST\" action=\"?edycja\"><button type=\"submit\" name=\"przycisk\" value=\"".$row['id']."\" class=\"btn btn-success\">
					Szczegóły</button></form></td></tr>";
				}
					echo "</table>";
		}
		else if (isset($_GET['wtoku']))
		{
				require_once "connect.php";
			echo "<table class=\"table\"><tr><th> ID zlecenia</th><th>Imię klienta</th><th>Nazwisko klienta</th><th>Nr telefonu</th><th>Status</th><th>Szczegóły</th></tr>";
			$wynik2 = mysqli_query($baza,"SELECT * FROM zlecenia WHERE status='W realizacji'");
			while($row = mysqli_fetch_array($wynik2))
				{
					echo "<tr><td>".$row['id']."</td><td>".$row['imie']."</td><td>".$row['nazwisko']."</td><td>".$row['telefon']."</td><td>";
					
								if ($row['status'] == "Przyjęte")
								{
									echo "<p class=\"przyjete\">".$row['status']."</p>";
								}
								else if ($row['status'] == "Zrealizowane")
								{
									echo "<p class=\"zrealizowane\">".$row['status']."</p>";
								}
								else if ($row['status'] == "W realizacji")
								{
									echo "<p class=\"wrealizacji\">".$row['status']."</p>";
								}
								else if ($row['status'] == "Anulowane")
								{
									echo "<p class=\"anulowane\">".$row['status']."</p>";
								}
								
					echo "<td><form method=\"POST\" action=\"?edycja\"><button type=\"submit\" name=\"przycisk\" value=\"".$row['id']."\" class=\"btn btn-success\">
					Szczegóły</button></form></td></tr>";
				}
					echo "</table>";
		}
		else if (isset($_GET['ogloszenia']))
		{
			$timestamp = time();
			$data = date("Y-m-d",$timestamp);
			echo "Dodaj ogłoszenie";
			echo "<form class=\"table\" method=\"POST\" action=\"?dodaj-ogloszenie\">
			<textarea class=\"form-control\" rows=\"5\" name=\"ogloszenie\"></textarea>
			<input type=\"hidden\" name=\"data\" value=\"".$data."\"><br>
			<button type=\"submit\" value=\"Dodaj ogłoszenie\" class=\"btn btn-success\">Dodaj ogłoszenie</button></form>";
		}
		else if (isset($_GET['dodaj-ogloszenie']))
		{
			require_once "connect.php";
			$data = $_POST['data'];
			$ogloszenie = $_POST['ogloszenie'];
			$sql = "INSERT INTO ogloszenia (data, ogloszenie) VALUES ('$data', '$ogloszenie')";
			if ($baza->query($sql) === TRUE) 
				{
					echo "Ogłoszenie dodane prawidłowo";
				}
		}
		else if (isset($_GET['logi']))
		{
			require_once "connect.php";
			require_once "logi/sprawdz-logi.php";
		}
		?>
		
		</div>
	</div>
</div>
<?php
}
else
{
	header("Location: index.php");
}
require_once 'dol.php';
?>