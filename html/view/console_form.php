<?php require('header.php'); ?>
    <ul id="pagePath">
        <li><a href="<?php echo routing::getURL(); ?>">Pradžia</a></li>
        <li><a href="<?php echo routing::getURL($module); ?>">Konsolės</a></li>
        <li><?php if(!empty($id)) echo "Konsolės redagavimas"; else echo "Nauja kosolė"; ?></li>
    </ul>
    <div class="float-clear"></div>
    <div id="formContainer">
        <?php require("formErrors.php"); ?>
        <form action="" method="post">
            <fieldset>
                <legend>Žaidimo informacija</legend>
                <p>
                    <label class="field" for="name">Pavadinimas<?php echo in_array('name', $required) ? '<span> *</span>' : ''; ?></label>
                    <input type="text" id="name" name="name" class="textbox-70" value="<?php echo isset($fields['name']) ? $fields['name'] : ''; ?>">
                    <?php if(key_exists('name', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['name']} simb.)</span>"; ?>
                </p>
                <p>
                    <label class="field" for="cpu">Processorius<?php echo in_array('cpu', $required) ? '<span> *</span>' : ''; ?></label>
                    <input type="text" id="cpu" name="cpu" class="textbox-70" value="<?php echo isset($fields['cpu']) ? $fields['cpu'] : ''; ?>">
                    <?php if(key_exists('cpu', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['cpu']} simb.)</span>"; ?>
                </p>
                <p>
                    <label class="field" for="gpu">Vaizdo plokštė<?php echo in_array('gpu', $required) ? '<span> *</span>' : ''; ?></label>
                    <input type="text" id="gpu" name="gpu" class="textbox-70" value="<?php echo isset($fields['gpu']) ? $fields['gpu'] : ''; ?>">
                    <?php if(key_exists('gpu', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['gpu']} simb.)</span>"; ?>
                </p>
                <p>
                    <label class="field" for="max_resolution_output">Didžiausia raiška<?php echo in_array('max_resolution_output', $required) ? '<span> *</span>' : ''; ?></label>
                    <input type="text" id="max_resolution_output" name="max_resolution_output" class="textbox-70" value="<?php echo isset($fields['max_resolution_output']) ? $fields['max_resolution_output'] : ''; ?>">
                    <?php if(key_exists('max_resolution_output', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['max_resolution_output']} simb.)</span>"; ?>
                </p>
                <p>
                    <label class="field" for="wifi_adapter">Belaidžio interneto palaikymas<?php echo in_array('wifi_adapter', $required) ? '<span> *</span>' : ''; ?></label>
                    <input type="text" id="wifi_adapter" name="wifi_adapter" class="textbox-70" value="<?php echo isset($fields['wifi_adapter']) ? $fields['wifi_adapter'] : ''; ?>">
                    <?php if(key_exists('wifi_adapter', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['wifi_adapter']} simb.)</span>"; ?>
                </p>
                <p>
                    <label class="field" for="price">Kaina<?php echo in_array('price', $required) ? '<span> *</span>' : ''; ?></label>
                    <input type="text" id="price" name="price" class="textbox-70" value="<?php echo isset($fields['price']) ? $fields['price'] : ''; ?>">
                    <?php if(key_exists('price', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['price']} simb.)</span>"; ?>
                </p>
            </fieldset>
            <p class="required-note">* pažymėtus laukus užpildyti privaloma</p>
            <p>
                <input type="submit" class="submit" name="submit" value="Išsaugoti">
            </p>
        </form>
    </div>

<?php
require('footer.php');

