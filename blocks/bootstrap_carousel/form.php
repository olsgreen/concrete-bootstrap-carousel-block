<?php 
defined('C5_EXECUTE') or die("Access Denied.");

/**
 *
 * Block add / edit form view template
 *
 * @author Oliver Green <green2go@gmail.com>
 * @link http://olsgreen.com
 * @license Apache License v2.0
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * @todo Clear out the rest of the inline CSS
 *
 */

// Text editor bits
$c = Page::getCurrentPage();
$th = $c->getCollectionThemeObject(); 
$this->inc('editor_config.php', array('theme' => $th)); 

// URL Helper
$uh = Loader::helper('concrete/urls');

// Slides
$slides = $this->controller->getSlides();
?>
<link rel="stylesheet" href="<?php echo $this->getBlockURL(); ?>/css/editor/editor.css" />

<div id="sliderEdit" class="ccm-ui">
    <div class="ccm-block-fields">
        
        <div class="ccm-block-field-group">
            <h4>Carousel Settings</h4>
            <p>The basic carousel settings, leave the width and height <strong>empty</strong> for auto dimensions.</p>
            <div class="input-prepend input-append" style="float: left; margin-right: 20px;">      
                <label for="width">Width:</label>        
                <input type="text" name="width" value="<?php echo ($width != 0) ? $width : ''; ?>" style="width: 40px; position: static; margin-right: -4px;">
                <span class="add-on">px</span>
            </div>
            <div class="input-prepend input-append" style="float: left; margin-right: 20px;">
                <label for="height">Height:</label>              
                <input type="text" name="height" value="<?php echo ($height != 0) ? $height : ''; ?>" style="width: 40px; position: static; margin-right: -4px;">
                <span class="add-on">px</span>
            </div>
            <div class="input-prepend input-append" style="float: left; margin-right: 20px;">
                <label for="delay">Transition Delay:</label>              
                <input type="text" name="delay" value="<?php echo (!$delay) ? '5000' : $delay; ?>" style="width: 40px; position: static; margin-right: -4px;">
                <span class="add-on">ms</span>
            </div>
            <div style="float: left;">
                <label for="pause">Pause transitions on mouse hover?</label>              
                <input type="radio" value="1" name="pause"<?php echo ($pause == 1 || !$pause) ? ' checked="checked"' : ''; ?>><span style="margin-right: 10px;"> Yes</span>
                <input type="radio" value="0" name="pause"<?php echo ($pause == 0 && $pause) ? ' checked="checked"' : ''; ?>><span> No</span>
            </div>
            <br style="float: none; clear: both;">
        </div>
        
        <div id="slides" class="ccm-block-field-group" style="position: relative;">
            <h4>Carousel Slides</h4>
            <p>You can <strong>re-order slides</strong> by dragging and dropping them into a new order.</p>
            <a href="javascript:void(0)" class="btn" style="position: absolute; right: 0; top: 6px;" id="addSlide">Add Slide</a>
            
            <ol>
                <?php foreach($slides as $slide) { ?>
                <li>
                    <span class="img" style="background-image: url(<?php echo $slide['image']->getThumbnailSRC(1); ?>);"></span><span class="title"><?php echo $slide['image']->getFileName(); ?></span>
                    <input name="imageID[]" value="<?php echo $slide['imageID']; ?>" type="hidden"><input name="content[]" value="<?php echo htmlentities($slide['content'],ENT_HTML5|ENT_COMPAT, "UTF-8"); ?>" type="hidden">
                    <input name="link[]" value="<?php echo $slide['link']; ?>" type="hidden">
                    <a href="javascript:void(0)" class="btn btn-mini slideEditButton">Edit</a>
                    <a href="javascript:void(0)" class="btn btn-mini btn-danger slideDeleteButton">Delete</a>
                </li>
                <?php } ?>
                <li class="no-results<?php echo (count($slides) > 0) ? ' hide' : ''; ?>">
                    <h4>No slides.</h4>
                </li>
            </ol>
            
        </div>
        
    </div>
</div>

<div id="slideEditLoading" style="background: url(<?php echo $this->getBlockURL(); ?>/images/load_icon.gif) center no-repeat #fff;"></div>
<div id="slideEdit" class="ccm-ui">
</div>

<script src="<?php echo $this->getBlockURL(); ?>/js/editor/bootstrap-carousel-editor.js"></script>
<script>
    
    $(function(){

        // Sortable
        $( "ol" ).sortable();
        $( "ol" ).disableSelection();
        
        //Setup the editor object
        BootstrapCarouselEditor.init({blockURL: "<?php echo $uh->getBlockTypeToolsURL(BlockType::getByHandle('bootstrap_carousel')); ?>/slide_edit_form.php"});
        
        // Slide Edit
        $('#addSlide').click(function(){
            BootstrapCarouselEditor.showEditScreen({ task: 'Add', imageID: '', content: '', link: '' });
        });
        
    });

</script>