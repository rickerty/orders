<?php
session_start();
require_once 'gora.php';
?>
<div class="container">
	<div class="row">
	<div class="col-md-4"></div>
  <div class="col-md-6">
  <?php
  if (isset($_GET['zlecenie']))
  {
	$numer_zlecenia = $_POST['numer_zlecenia'];
	
	$numer_zlecenia = htmlentities($numer_zlecenia,ENT_QUOTES,"UTF-8");

	require_once "connect.php";
	$wynik = mysqli_query($baza,"SELECT * FROM zlecenia WHERE id='$numer_zlecenia'");
	while($row = mysqli_fetch_array($wynik))
	{
		echo "Aktualny status zlecenia to: <b>".$row['status']."</b>";
	}
  }
  else
  {
  ?>
<form class="form-inline" method="POST" action="?zlecenie">
    <input class="form-control mr-sm-2" type="text" placeholder="Wpisz numer zlecenia" name="numer_zlecenia">
    <button class="btn btn-info" type="submit">Sprawdź</button>
  </form>
  <?php
  }
  ?>
  </div>
 <div class="col-md-3"></div>
</div></div>
<?php
require_once 'dol.php';
?>