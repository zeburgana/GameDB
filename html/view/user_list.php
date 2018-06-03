<?php require('header.php'); ?>
<ul id="pagePath">
	<li><a href="<?php echo routing::getURL(); ?>">Pradžia</a></li>
	<li>Klientai</li>
</ul>
<div id="actions">
	<a href='<?php echo routing::getURL($module, 'create'); ?>'>Naujas klientas</a>
</div>
<div class="float-clear"></div>

<?php if(!empty($delete_error)) { ?>
	<div class="errorBox">
		Klientas nebuvo pašalintas, nes turi užsakymą (-ų).
	</div>
<?php } ?>

<?php if(!empty($id_error)) { ?>
  <div class="errorBox">
    Klientas nerastas!
  </div>
<?php } ?>

<table>
	<tr>
		<th>ID</th>
		<th>Vardas</th>
		<th>Išsinuomuotų žaidimų kiekis</th>
		<th>Pirktų žaidimų kiekis</th>
        <th>Taškai</th>
		<th></th>
	</tr>
	<?php

		// suformuojame lentelę
		foreach($data as $key => $val) {
			echo
				"<tr>"
					. "<td>{$val['id']}</td>"
					. "<td>{$val['name']}</td>"
					. "<td>{$val['games_rented']}</td>"
					. "<td>{$val['games_bought']}</td>"
                    . "<td>{$val['points']}</td>"
					. "<td>"
						. "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['id']}\"); return false;' title=''>šalinti</a>&nbsp;"
						. "<a href='" . routing::getURL($module, 'edit', 'id=' . $val['id']), "' title=''>redaguoti</a>"
					. "</td>"
				. "</tr>\n";
		}
	?>
</table>

<?php
// įtraukiame puslapių šabloną
require('paging.php');
require('footer.php');

