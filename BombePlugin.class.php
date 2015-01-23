<?php

require_once __DIR__."/models/Bombe.class.php";

class BombePlugin extends StudIPPlugin implements SystemPlugin {

    public function __construct() {
        parent::__construct();
        PageLayout::addScript($this->getPluginURL()."/assets/bombe.js");
        if (UpdateInformation::isCollecting()) {
            $bomben = Bombe::findBySQL("user_id = ? AND hit = '0' and mkdate > UNIX_TIMESTAMP() - 2 * 60 ");
            if (count($bomben)) {
                foreach ($bomben as $key => $bombe) {
                    $bomben[$key] = $bombe->toArray();
                }
                UpdateInformation::setInformation("Bombe.getHit", $bomben);
            }
        }
    }
}