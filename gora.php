<!DOCTYPE html>
<html lang="pl">
<head>
<meta charset="utf-8">
<title>ostrow-serwis.pl</title>	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="main.css">
</head>
<body>
<nav class="navbar navbar-expand-sm bg-dark justify-content-center ">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="index.php">Strona Główna</a>
    </li>
	<li class="nav-item">
      <a class="nav-link" href="status.php">Status naprawy</a>
    </li>
	<li class="nav-item">
      <a class="nav-link"
	  <?php if (isset($_SESSION['admin']))
  {
	  echo "href=\"panel.php?panel\">Konto";
  }
  else if (!isset($_SESSION['admin']))
  {
	   echo "href=\"zaloguj.php\">Logowanie";
  }
  ?></a>
    </li>
  </ul>
  <?php
  if (isset($_SESSION['admin']))
  {
	  ?>
  <form class="form-inline" method="POST" action="panel.php?szukaj_nazwisko">
    <input class="form-control mr-sm-2" type="text" placeholder="Wpisz małymi literami" name="szukaj">
    <button class="btn btn-info" type="submit">Szukaj po nazwisku</button>
  </form>
  <?php
  }
  ?>
</nav>
<br><br>
</div>