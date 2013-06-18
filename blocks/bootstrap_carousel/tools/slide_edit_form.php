<?php 
defined('C5_EXECUTE') or die("Access Denied.");

/**
 *
 * Tool to retrieve populated add / edit form
 *
 * @author Oliver Green <green2go@gmail.com>
 * @link http://olsgreen.com
 * @license Apache License v2.0
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 */

// Asset Helper
$al = Loader::helper('concrete/asset_library'); 
        
// Get and validate the data
$data = $_POST;
//if(!is_array($data) || count(array_diff_key(array('imageID', 'link', 'content', 'task'), $data)) > 0) header("HTTP/1.0 400 Bad Data");
        
// Dirty I know, time is of the essence
print '
<h4>' . $data['task'] .' Slide</h4>
<p>Enter this slides information below and then click \'Save Changes\'.</p>
<ol style="list-style: none; padding: 0; margin: 0 0 20px;">
    <li>
        <label for="imageID">Slide Image:</label>
        ' . $al->image('eimageID', 'eimageID', 'Choose image', (intval($data['imageID']) > 0) ? File::getByID($data['imageID']) : null) . '
        <br>
        <div class="input-prepend input-append">
            <label for="link">Image Link:</label>
            <span class="add-on">http://</span>
            <input type="text" name="elink" value="' . $data['link'] . '" style="position: static; width: 60%; margin-left: -4px;">                        
        </div>
        <br>
        <label for="content">Content:</label>
        <div style="text-align: center" id="ccm-editor-pane">
            <textarea id="ccm-content" class="advancedEditor ccm-advanced-editor" name="econtent" style="width: 580px; height: 380px">' . htmlspecialchars($data['content'],ENT_HTML5|ENT_COMPAT, "UTF-8") . '</textarea>
        </div>
    </li>
</ol>
<a href="javascript:void(0)" class="saveEdit btn" style="">Save Changes</a>
<a href="javascript:void(0)" class="cancelEdit btn btn-danger" style="">Cancel</a>
';