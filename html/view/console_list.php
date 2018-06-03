<?php require('header.php'); ?>

    <ul id="pagePath">
        <li><a href="<?php echo routing::getURL(); ?>">Pradžia</a></li>
        <li>Konsolės</li>
    </ul>
    <div id="actions">
        <a href='<?php echo routing::getURL($module, 'create'); ?>'>Nauja konsolė</a>
    </div>
    <div class="float-clear"></div>

<?php if(!empty($id_error)) { ?>
    <div class="errorBox">
        Konsolė nerasta!
    </div>
<?php } ?>

    <table>
        <tr>
            <th>Nr.</th>
            <th>Pavadinimas</th>
            <th>Procesorius</th>
            <th>Vaidzo Procesorius</th>
            <th>Didžiausia rezoliucija</th>
            <th>Wifi palaikymas</th>
            <th>Kaina</th>
            <th></th>
        </tr>
        <?php
        // suformuojame lentelę
        foreach($data as $key => $val) {
            echo
                "<tr>"
                . "<td>{$val['id']}</td>"
                . "<td>{$val['name']}</td>"
                . "<td>{$val['cpu']}</td>"
                . "<td>{$val['gpu']}</td>"
                . "<td>{$val['max_resolution_output']}</td>"
                . "<td>{$val['wifi_adapter']}</td>"
                . "<td>{$val['price']}</td>"
                . "<td>"
                . "<a href='#' onclick='showConfirmDialog(\"{$module}\", \"{$val['id']}\"); return false;' title=''>šalinti</a>&nbsp;"
                . "<a href='" . routing::getURL($module, 'edit', 'id=' . $val['nr']), "' title=''>redaguoti</a>"
                . "</td>"
                . "</tr>";
        }
        ?>
    </table>

<?php
require('paging.php');
require('footer.php');

