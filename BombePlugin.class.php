<?php

require_once __DIR__."/models/Bombe.class.php";

class BombePlugin extends StudIPPlugin implements SystemPlugin {

    public function __construct() {
        parent::__construct();
        PageLayout::addScript($this->getPluginURL()."/assets/bombe.js");
        PageLayout::addBodyElements($this->getTemplate("bombs/bomb.php", null)->render());
        if (UpdateInformation::isCollecting()) {
            $bomben = Bombe::findBySQL("user_id = ? AND hit = '0' and mkdate > UNIX_TIMESTAMP() - 2 * 60 ", array($GLOBALS['user']->id));
            if (count($bomben)) {
                $bombtrack = $bomben[0]->toArray();
                $bomben[0]['hit'] = 1;
                $bomben[0]->store();
                $bombtrack['from_user_name'] = get_fullname($bomben[0]['from_user']);
                UpdateInformation::setInformation("Bombe.getHit", $bombtrack);
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

    protected function getTemplate($template_file_name, $layout = "without_infobox") {
        if (!$this->template_factory) {
            $this->template_factory = new Flexi_TemplateFactory(dirname(__file__)."/views");
        }
        $template = $this->template_factory->open($template_file_name);
        $template->set_attribute('plugin', $this);
        if ($layout) {
            if (method_exists($this, "getDisplayName")) {
                PageLayout::setTitle($this->getDisplayName());
            } else {
                PageLayout::setTitle(get_class($this));
            }
            $template->set_layout($GLOBALS['template_factory']->open($layout === "without_infobox" ? 'layouts/base_without_infobox' : 'layouts/base'));
        }
        return $template;
    }
}