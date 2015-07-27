<?php foreach ($menuItems as $menuItem) { ?>
    <li><a href="<?php echo $menuItem['target']; ?>" target="<?php echo $menuItem['targetAttribut']; ?>"><?php echo $menuItem['label']; ?></a>

    </li>
<?php } ?>
