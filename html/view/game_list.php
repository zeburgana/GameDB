<?php require ('header.php')
/**
 * Created by PhpStorm.
 * User: lapdawg
 * Date: 18.6.2
 * Time: 16.35
 */
?>

    <ul id="pagePath">
        <li><a href="<?php echo routing::getURL(); ?>">Pradžia</a></li>
        <li>Žaidimai</li>
    </ul>
    <div id="actions">
        <a href='<?php echo routing::getURL($module, 'create'); ?>'>Naujas žaidimas</a>
    </div>
    <div class="float-clear"></div>

<?php if(!empty($delete_error)) { ?>
    <div class="errorBox">
        Žaidimas nebuvo pašalintas. Pirmiausia pašalinkite žaidimus.
    </div>
<?php } ?>

<?php if(!empty($id_error)) { ?>
    <div class="errorBox">
        Žaidimas nerastas!
    </div>
<?php } ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Pavadinimas</th>
            <th>Išleidimo data</th>
            <th>Žanras</th>
            <th>Kūrėjas</th>
        </tr>
        <?php
        // suformuojame lentelę
        foreach($data as $key => $val) {
            echo
                "<tr>"
                . "<td>{$val['id']}</td>"
                . "<td>{$val['name']}</td>"
                . "<td>{$val['release_date']}</td>"
                . "<td>{$val['genre']}</td>"
                . "<td>{$val['developer']}</td>"
                . "<td>"
                . "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['id']}\"); return false;' title=''>šalinti</a>&nbsp;"
                . "<a href='" . routing::getURL($module, 'edit', 'id=' . $val['id']), "' title=''>redaguoti</a>"
                . "</td>"
                . "</tr>\n";
        }
        ?>
    </table>

<?php
require('paging.php');
require('footer.php');

