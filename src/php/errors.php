<?php
/**
 * Created by PhpStorm.
 * User: Esha
 * Date: 6/26/2017
 * Time: 9:53 PM
 */
if(count($errors) > 0): ?>
    <div class="error">
        <?php foreach ($errors as $error): ?>
            <p class="has-error"><?php echo $error; ?></p>
        <?php endforeach ?>
    </div>
<?php endif ?>
