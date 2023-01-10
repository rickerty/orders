<?php
session_start();
require_once 'gora.php';
if (isset($_SESSION['admin']))
{
?>
<div class="container">
	<div class="row">
		<div class="col-md-3 menu-pion">
			<li><a href="dodaj.php">Dodaj zlecenie</a></li>
			<li>Sprawdź zlecenie</li>
			<li><a  href="index.php?akcja=wyloguj">Wyloguj</a></li>
		</div>
		<div class="col-md-6 text-justify">
		<p>Witaj w panelu serwisanta</p>
		
		</div>
		<div class="col-md-3"></div>
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