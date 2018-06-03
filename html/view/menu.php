<?php
  $menuLeft = array(
    'game' => 'Žaidimai',
    'console' => 'Konsolės',
    'user' => 'Klientai',
    'employee' => 'Darbuotojai',
    'manager' => 'Menedžeriai',
    'workplace' => 'Parduotuvių Vietos'
  );
  $menuRight = array(
    'report' => 'Ataskaitos'
  );
?>

<div id="topMenu">
	<ul class="float-left">
<?php
  foreach ($menuLeft as $key => $val) {
    echo "<li><a href='", routing::getURL($key), "' title='${val}'";
    if ($module == $key) {
      echo ' class="active"';
    }
    echo ">${val}</a></li>";
  }
?>
	</ul>

	<ul class="float-right">

<?php
  foreach ($menuRight as $key => $val) {
    echo "<li><a href='", routing::getURL($key), "' title='${val}'";
    if ($module == $key) {
      echo ' class="active"';
    }
    echo ">${val}</a></li>";
  }
?>
	</ul>
</div>
