<?php require('header.php'); ?>
    <ul id="pagePath">
        <li><a href="<?php echo routing::getURL(); ?>">Pradžia</a></li>
        <li><a href="<?php echo routing::getURL($module); ?>">Žaidimai</a></li>
        <li><?php if(!empty($id)) echo "Žaidimo redagavimas"; else echo "Naujas žaidimas"; ?></li>
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
                    <label class="field" for="genre">Žanras<?php echo in_array('genre', $required) ? '<span> *</span>' : ''; ?></label>
                    <input type="text" id="genre" name="genre" class="textbox-70" value="<?php echo isset($fields['genre']) ? $fields['genre'] : ''; ?>">
                    <?php if(key_exists('genre', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['genre']} simb.)</span>"; ?>
                </p>
                <p>
                    <label class="field" for="release_date">Išleidimo data<?php echo in_array('release_date', $required) ? '<span> *</span>' : ''; ?></label>
                    <input type="text" id="release_date" name="release_date" class="textbox-70" value="<?php echo isset($fields['release_date']) ? $fields['release_date'] : ''; ?>">
                    <?php if(key_exists('release_date', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['release_date']} simb.)</span>"; ?>
                </p>
                <p>
                    <label class="field" for="developer">Kūrėjas<?php echo in_array('developer', $required) ? '<span> *</span>' : ''; ?></label>
                    <input type="text" id="developer" name="developer" class="textbox-70" value="<?php echo isset($fields['developer']) ? $fields['developer'] : ''; ?>">
                    <?php if(key_exists('developer', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['developer']} simb.)</span>"; ?>
                </p>
                <p>
                    <label class="field" for="publisher">Platintojas<?php echo in_array('publisher', $required) ? '<span> *</span>' : ''; ?></label>
                    <input type="text" id="publisher" name="publisher" class="textbox-70" value="<?php echo isset($fields['publisher']) ? $fields['publisher'] : ''; ?>">
                    <?php if(key_exists('publisher', $maxLengths)) echo "<span class='max-len'>(iki {$maxLengths['publisher']} simb.)</span>"; ?>
                </p>
                <p>
                    <label class="field" for="in_stock">Yra sandelyje</label>
                    <input type="checkbox" id="in_stock" name="in_stock"<?php echo (isset($fields['in_stock']) && ($fields['in_stock'] == 1 || $fields['in_stock'] == 0))  ? ' checked="checked"' : ''; ?>>
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

