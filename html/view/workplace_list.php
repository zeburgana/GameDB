<?php require ('header.php')
/**
 * Created by PhpStorm.
 * User: lapdawg
 * Date: 18.6.3
 * Time: 14.09
 */
?>

    <ul id="pagePath">
        <li><a href="<?php echo routing::getURL(); ?>">Pradžia</a></li>
        <li>Parduotuvės</li>
    </ul>
    <div id="actions">
        <a href='<?php echo routing::getURL($module, 'create'); ?>'>Nauja parduotuvė</a>
    </div>
    <div class="float-clear"></div>

<?php if(!empty($delete_error)) { ?>
    <div class="errorBox">
        Parduotuvė nebuvo pašalinta. Pirmiausia pašalinkite darbuotojus.
    </div>
<?php } ?>

<?php if(!empty($id_error)) { ?>
    <div class="errorBox">
        Parduotuvė nerasta!
    </div>
<?php } ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Miestas</th>
            <th>Adresas</th>
        </tr>
        <?php
        // suformuojame lentelę
        foreach($data as $key => $val) {
            echo
                "<tr>"
                . "<td>{$val['id']}</td>"
                . "<td>{$val['city']}</td>"
                . "<td>{$val['address']}</td>"
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

