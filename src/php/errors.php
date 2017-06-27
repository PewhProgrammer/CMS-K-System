<?php
/**
 * Created by PhpStorm.
 * User: Esha
 * Date: 6/26/2017
 * Time: 9:53 PM
 */
if(count($errors) > 0): ?>
    <?php foreach ($errors as $error): ?>
        <h4 class="panel text-danger"><?php echo $error; ?></h4>
    <?php endforeach ?>
<?php endif ?>
