<?php
 session_start();
if (!isset($_POST['login']) && !isset($_POST['akcja']) && !isset($_SESSION['admin']))
{
require_once 'gora.php';
?>
<div class="container">
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6 text-justify"> 
		<form action="zaloguj.php" method="POST">
			<div class="form-group">
				<label for="login">Login:</label>
				<input type="text" class="form-control" name="login" id="login">
			</div>
			<div class="form-group">
				<label for="pswd">Hasło:</label>
				<input type="password" class="form-control" name="pswd" id="pswd">
			</div>
			<button type="submit" class="btn btn-success">Zaloguj</button>
		</form>
		</div>
	<div class="col-md-3"></div>
</div></div>
<?php
}
else if (isset($_POST['login']) && !isset($_SESSION['admin']))
{
	require_once "connect.php";
	$login = $_POST['login'];
	$pass = $_POST['pswd'];
	
	$login = htmlentities($login,ENT_QUOTES,"UTF-8");
	$pass = htmlentities($pass,ENT_QUOTES,"UTF-8");
	
	$sql = "SELECT * FROM users WHERE login='$login' AND pass='$pass'";
	if ($rezultat = $baza->query($sql))
		{
			$ilu_userow = $rezultat->num_rows;
			if($ilu_userow>0)
			{
				
				header("Location: panel.php?panel");
				$wynik8 = mysqli_query($baza,"SELECT * FROM users WHERE login='$login' AND pass='$pass'");
					while($row8 = mysqli_fetch_array($wynik8))
					{
						$_SESSION['admin'] = $row8['id'];
						$_SESSION['administrator'] = $row8['admin'];
						$_SESSION['inicjaly_admin'] = $row8['inicjaly'];
						$_SESSION['ip_login'] = $_SERVER['REMOTE_ADDR'];
					}
				//rejestracja logów
				$efekt="tak";
				require_once "logi/logi.php";
				//koniec rejestracji logów
				
			}
			else
			{
				//rejestracja logów
				$efekt="nie";
				require_once "logi/logi.php";
				//koniec rejestracji logów
				echo "Wprowadziłeś złe dane logowania";
			}
		}
		else
		{
			echo "Coś jest nie tak z bazą danych";
		}
		$baza->close();

}
else if (isset($_SESSION['admin']) && !isset($_POST['akcja']))
{
	header("Location: panel.php?panel");
}

include_once 'dol.php';
?>