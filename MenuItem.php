<?php

namespace dokuwiki\plugin\randompage2;

use dokuwiki\Menu\Item\AbstractItem;

/**
 * Class MenuItem
 * 
 * Implements the random page button for DokuWiki's menu system
 *
 * @package dokuwiki\plugin\randompage2
 */

class MenuItem extends AbstractItem {

    /** @var string do action for this plugin */
    protected $type = 'randompage';

    /** @var string icon file */
    protected $svg = __DIR__ . '/random.svg';

    /**
     * MenuItem constructor.
     */
     
    public function __construct() {
        parent::__construct();
        global $REV;
        if($REV) $this->params['rev'] = $REV;
        }

    /**
     * Get label 
     *
     * @return string
     */
    public function getLabel() {
        return 'Random Page';
    }
}
