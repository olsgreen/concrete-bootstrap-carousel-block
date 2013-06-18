<?php 
defined('C5_EXECUTE') or die("Access Denied.");

/**
 *
 * The carousels view template
 *
 * @author Oliver Green <green2go@gmail.com>
 * @link http://olsgreen.com
 * @license Apache License v2.0
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 */

?>

<!-- Carousel !-->
<div id="bootstrap-carousel-<?php echo $bID; ?>" class="carousel slide"<?php echo ($width > 0 || $height > 0) ? ' style="width: ' . $width . 'px; height: ' . $height . 'px; overflow: hidden;"' : ''; ?>>
    <ol class="carousel-indicators">
        <?php for($i = 0; $i < count($slides); $i++) { ?>
        <li data-target="#bootstrap-carousel-<?php echo $bID; ?>" data-slide-to="<?php echo $i; ?>"<?php echo ($i == 0) ? ' class="active"' : ''; ?></l>></li>
        <?php } ?>
    </ol>
    <!-- Carousel items -->
    <div class="carousel-inner">
        <?php $first = true; foreach($slides as $slide) { ?>
        <div class="item<?php echo ($first) ? ' active' : ''; ?>">
            <?php if($slide['link']) { ?><a href="http://<?php echo $slide['link']; ?>"><?php } ?><img src="<?php echo $slide['image']->getURL(); ?>" alt="<?php echo $slide['image']->getFileName(); ?>"><?php if($slide['link']) { ?></a><?php } ?>
            <?php if($slide['content']) { ?>
            <div class="carousel-caption">
                <?php echo $slide['content']; ?>
            </div>
            <?php } ?>
        </div>
        <?php $first = false; } ?>
    </div>
    <!-- Carousel nav -->
    <!--<a class="carousel-control left" href="#bootstrap-carousel-<?php echo $bID; ?>" data-slide="prev">&lsaquo;</a>
    <a class="carousel-control right" href="#bootstrap-carousel-<?php echo $bID; ?>" data-slide="next">&rsaquo;</a>!-->
</div>
<script>$(function(){ $('#bootstrap-carousel-<?php echo $bID; ?>').carousel({ interval: <?php echo $delay; ?>, pause: <?php echo ($pause) ? '\'hover\'' : 'false'; ?>}); });</script>