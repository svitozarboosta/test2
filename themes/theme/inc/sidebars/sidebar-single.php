<?php
    require('sidebar-recent.php');  // Include recent block
    require('sidebar-clouds.php');  // Include clouds block
?>
<!-- begin doc-details  -->
<div class="doc-details">
    <?php
        donwlodaAndPrintLinks();
    ?>
    <p><b>Document details:</b></p>

    <p>Words: <?= str_word_count(get_the_content(get_the_ID())) ?></p>
    <p>Pages: <?= ceil(str_word_count(get_the_content(get_the_ID()))/275) ?></p>
    <p>Category:
        <?php
        foreach( get_the_category() as $key => $category ) :
            if ($key == 0) $s = ''; else $s = ',';
                ?>
            <?= $s ?><a href="<?= get_category_link($category->cat_ID) ?>"><?= $category->cat_name ?></a>
            <?php
        endforeach;
        ?>
    </p>
</div>
<!-- end doc-details -->
<?php //if (in_category('qa')): ?>
<!--    --><?php //qaAskAnything(); ?>
<?php //endif; ?>
