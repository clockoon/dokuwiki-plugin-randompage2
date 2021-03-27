<?php
/**
 *
 * @author     Szymon Olewniczak
 */

if(!defined('DOKU_INC')) die();


class action_plugin_randompage2 extends DokuWiki_Action_Plugin {


    public function register(Doku_Event_Handler $controller) {
        $controller->register_hook('ACTION_ACT_PREPROCESS', 'BEFORE', $this, 'do_randompage');
        $controller->register_hook('MENU_ITEMS_ASSEMBLY', 'AFTER', $this, 'addsvgbutton', array());
    }

    public function do_randompage(Doku_Event $event, $param) {
        if($event->data !== 'randompage') return;
        $event->preventDefault();

        global $conf;
        $dir = $conf['indexdir'];

        $pages = file($dir.'/page.idx');
        shuffle($pages);

        foreach ($pages as $page) {
            $page = trim($page);
            if(!page_exists($page)) continue;
            if(isHiddenPage($page)) continue;
            if (auth_quickaclcheck($page)) {
                send_redirect(wl($page, '', true, '&'));
            }
        }
    }

    /**
     * Add 'Random page' button to page tools, new SVG based mechanism
     *
     * @param Doku_Event $event
     */
    public function addsvgbutton(Doku_Event $event) {
        global $INFO;
        if($event->data['view'] != 'page') {
            return;
        }

        if(!$INFO['exists']) {
            return;
        }

        array_splice($event->data['items'], -1, 0, [new \dokuwiki\plugin\randompage2\MenuItem()]);
    }
}
