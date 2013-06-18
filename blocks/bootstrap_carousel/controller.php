<?php 
defined('C5_EXECUTE') or die("Access Denied.");

/**
 *
 * The carousels block controller
 *
 * @author Oliver Green <green2go@gmail.com>
 * @link http://olsgreen.com
 * @license Apache License v2.0
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 */

class BootstrapCarouselBlockController extends BlockController {
	
	protected $btTable = 'btBootstrapCarousel';
	protected $btInterfaceWidth = "600";
	protected $btInterfaceHeight = "465";
	protected $btCacheBlockRecord = true;
	protected $btCacheBlockOutput = true;
	protected $btCacheBlockOutputOnPost = true;
	protected $btCacheBlockOutputForRegisteredUsers = true;
	protected $btCacheBlockOutputLifetime = 0; //until manually updated or cleared
	
	public function getBlockTypeDescription() {
		return t("Boostrap's (@twbootstrap) famed carousel for Conctrete5.");
	}
	
	public function getBlockTypeName() {
		return t("Bootstrap Carousel");
	}
    
    public function on_page_view() {
    
        // Get & set our slides
        $this->set('slides', $this->getSlides());
        
    }
    
    public function getSlides() {
        
        $slides = array();
     
        if($this->bID > 0) {
            $db = Loader::db();
            $q = "SELECT * FROM btBootstrapCarouselSlides WHERE bID = ? ORDER BY position ASC;";
            $r = $db->query($q, $this->bID);
            
            while($row = $r->fetchRow()) {
                $row['image'] = File::getByID($row['imageID'])->getApprovedVersion();
                $slides[] = $row;
            }
        }
        
        return $slides;
        
    }
    
    public function save($data) {
        
        $data['width'] = (!$data['width']) ? 0 : $data['width'];
        $data['height'] = (!$data['height']) ? 0 : $data['height'];
     
        $db = Loader::db();
        $q = "DELETE FROM btBootstrapCarouselSlides WHERE bID = ?;";
        $r = $db->execute($q, $this->bID);
        
        for($i = 0; $i < count($data['imageID']); $i++) {            
            $q = "INSERT INTO btBootstrapCarouselSlides SET bID = ?, imageID = ?, content = ?, position = ?, link = ?;";
            $r = $db->execute($q, array($this->bID, $data['imageID'][$i], $data['content'][$i], $i, $data['link'][$i]));            
        }
        
        parent::save($data);
        
    }

    
    /*
	
	function getContent() {
		$content = $this->translateFrom($this->content);
		return $content;				
	}
	
	public function getSearchableContent(){
		return $this->content;
	}*/
    
    
}
		