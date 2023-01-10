<?php
echo "<table class=\"table\"><tr><th>ID</th><th>Wprowadzony login</th><th>IP</th><th>Data </th><th>Udane?</th></tr>";
$sprawdz_logi = mysqli_query($baza,"SELECT * FROM logi ORDER BY id DESC");
			while($punkt = mysqli_fetch_array($sprawdz_logi))
				{
					echo "<tr><td>".$punkt['id']."</td>
					<td>".$punkt['login']."</td>
					<td>".$punkt['ip']."</td>
					<td>".$punkt['data']."</td>
					<td>".$punkt['udane']."</td></tr>";
				}
echo "</table>";
?>