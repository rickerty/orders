<?php
 session_start();
 if (isset($_GET['akcja']))
{
	unset($_SESSION['admin']);
	unset($_SESSION['administrator']);
	unset($_SESSION['inicjaly_admin']);

}
include_once 'gora.php';
?>
<div class="container">
	<div class="row">
	<div class="col-md-3"></div>
  <div class="col-md-6 text-justify"><p>Serwis </p><br><center>Sprawdź status. </center>
 </div>
 <div class="col-md-3"></div>
</div></div>
<?php
include_once 'dol.php';
?>