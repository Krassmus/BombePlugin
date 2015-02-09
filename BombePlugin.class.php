<?php

require_once __DIR__."/models/Bombe.class.php";

class BombePlugin extends StudIPPlugin implements SystemPlugin {

    public function __construct() {
        parent::__construct();
        PageLayout::addScript($this->getPluginURL()."/assets/bombe.js");
        PageLayout::addBodyElements($this->getTemplate("bombs/bomb.php", null)->render());
        if (UpdateInformation::isCollecting()) {
            $bomben = Bombe::findBySQL("user_id = ? AND hit = '0' AND deactivated = '0' AND mkdate > UNIX_TIMESTAMP() - 2 * 60 ", array($GLOBALS['user']->id));
            $data = array();
            if (count($bomben)) {
                if (!$this->userWasActive()) {
                    $bombtrack = $bomben[0]->toArray();
                    $bomben[0]['hit'] = 1;
                    $bomben[0]->store();
                    $bombtrack['from_user_name'] = get_fullname($bomben[0]['from_user']);
                    $data['bomb'] = $bombtrack;
                } else {
                    $by = array();
                    foreach ($bomben as $bomb) {
                        $bomb['deactivated'] = 1;
                        $by[] = get_fullname($bomb['from_user']);
                        $bomb->store();
                    }
                    $data['deactivated'] = count($bomben);
                    $data['deactivated_by'] = implode(", ", $by);
                }
            }
            if (count($data)) {
                UpdateInformation::setInformation("Bombe.getHit", $data);
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

    protected function userWasActive() {
        $tables = array();
        $tables[] = array('table' => "user_info");
        $tables[] = array('table' => "comments");
        $tables[] = array('table' => "dokumente");
        $tables[] = array('table' => "forum_entries");
        $tables[] = array('table' => "news");
        $tables[] = array('table' => "seminar_user");
        $tables[] = array(
            'table' => "blubber",
            'where' => "context_type != 'private'"
        );
        $tables[] = array(
            'table' => "kategorien",
            'user_id_column' => "range_id"
        );
        $tables[] = array(
            'table' => "message",
            'user_id_column' => "autor_id"
        );
        $tables[] = array(
            'table' => "vote",
            'user_id_column' => "range_id"
        );
        $tables[] = array(
            'table' => "voteanswers_user",
            'date_column' => "votedate"
        );
        $tables[] = array(
            'table' => "vote_user",
            'date_column' => "votedate"
        );
        $tables[] = array(
            'table' => "wiki",
            'date_column' => "chdate"
        );

        foreach (PluginManager::getInstance()->getPlugins("ScorePlugin") as $plugin) {
            foreach ((array) $plugin->getPluginActivityTables() as $table) {
                if ($table['table']) {
                    $tables[] = $table;
                }
            }
        }

        $sql = "";
        foreach ($tables as $key => $table) {
            if ($key > 0) {
                $sql .= "UNION ";
            }
            $sql .= "SELECT 1 "
                . "FROM "
                . $table['table']
                . " WHERE "
                . ($table['user_id_column'] ? : 'user_id')
                . " = :user "
                . ($table['where'] ? (' AND ' . $table['where']) : '')
                . "AND ".($table['date_column'] ? : 'mkdate'). " > UNIX_TIMESTAMP() - 10 * 60 ";
        }
        $statement = DBManager::get()->prepare($sql);
        $statement->execute(array('user' => $GLOBALS['user']->id));
        return (bool) $statement->fetch(PDO::FETCH_COLUMN, 0);
    }
}