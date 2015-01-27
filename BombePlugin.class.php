<?php

require_once __DIR__."/models/Bombe.class.php";

class BombePlugin extends StudIPPlugin implements SystemPlugin {

    public function __construct() {
        parent::__construct();
        PageLayout::addScript($this->getPluginURL()."/assets/bombe.js");
        PageLayout::addBodyElements('<div style="display: none; font-size: 4em; color: red;" id="bombe">BOMBE!!!!</div>');
        if (UpdateInformation::isCollecting()) {
            $bomben = Bombe::findBySQL("user_id = ? AND hit = '0' and mkdate > UNIX_TIMESTAMP() - 2 * 60 ");
            if (count($bomben)) {
                foreach ($bomben as $key => $bombe) {
                    $bomben[$key] = $bombe->toArray();
                }
                UpdateInformation::setInformation("Bombe.getHit", $bomben);
            }
        }
        if (Navigation::hasItem("/profile")) {
            $navigation = new Navigation(_("Bomben"), PluginEngine::getURL($this, array(), "manager/overview"));
            Navigation::getItem("/profile")->addSubNavigation("bomben", $navigation);
        }
        PageLayout::addBodyElements('<audio style="display: none;" id="bombe_sound" preload="none">
            <source type="audio/mpeg" src="'.$this->getPluginURL().'/assets/zangrutz_bomb-small.mp3"></source>
        </audio>');
    }
}