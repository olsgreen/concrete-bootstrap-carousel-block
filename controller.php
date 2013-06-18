<?php 
defined('C5_EXECUTE') or die("Access Denied.");

/**
 *
 * Package containing the bootstrap carousel plugin
 *
 * @author Oliver Green <green2go@gmail.com>
 * @link http://olsgreen.com
 * @license Apache License v2.0
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 */

class BootstrapCarouselPackage extends Package
{
	protected $pkgHandle = 'concrete5_bootstrap_carousel';
    protected $appVersionRequired = '5.6';
    protected $pkgVersion = '0.2';

    public function getPackageDescription() {
    	return t("Package containing Boostrap's (@twbootstrap) famed carousel for Conctrete5.");
    }

    public function getPackageName() {
    	return t("Bootstrap Carousel");
    }
	
	public function install() {         
        $pkg = parent::install();
        
        // Install the block type
        BlockType::installBlockTypeFromPackage('bootstrap_carousel', $pkg);
        
        return $pkg;        
    }
    
}