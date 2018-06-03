<?php require('header.php'); ?>
<ul id="pagePath">
	<li><a href="<?php echo routing::getURL(); ?>">Pradžia</a></li>
	<li>Darbuotojai</li>
</ul>
<div id="actions">
	<a href='<?php echo routing::getURL($module, 'create'); ?>'>Naujas darbuotojas</a>
</div>
<div class="float-clear"></div>

<?php if(!empty($delete_error)) { ?>
	<div class="errorBox">
    Darbuotojas nebuvo pašalintas, nes turi užsakymą (-ų).
	</div>
<?php } ?>

<?php if(!empty($id_error)) { ?>
  <div class="errorBox">
    Darbuotojas nerastas!
  </div>
<?php } ?>

<table>
	<tr>
		<th>ID</th>
		<th>Vardas</th>
		<th>Parduotų žaidimų kiekis</th>
		<th>Išnomuotų žaidimų kiekis</th>
<!--        <th>Darbo vietos ID</th>-->
<!--        <th>Menedžerio ID</th>-->
	</tr>
	<?php


		// suformuojame lentelę
		foreach($data as $key => $val) {
			echo
				"<tr>"
					. "<td>{$val['id']}</td>"
					. "<td>{$val['name']}</td>"
					. "<td>{$val['games_sold']}</td>"
                    . "<td>{$val['games_rented']}</td>"
//                    . "<td>{$val['workplace_ID']}</td>"
//                    . "<td>{$val['manager_ID']}</td>"
					. "<td>"
						. "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['ID']}\"); return false;' title=''>šalinti</a>&nbsp;"
						. "<a href='" . routing::getURL($module, 'edit', 'id=' . $val['ID']), "' title=''>redaguoti</a>"
					. "</td>"
				. "</tr>\n";
		}
	?>
</table>

<?php
// įtraukiame puslapių šabloną
require('paging.php');
require('footer.php');

