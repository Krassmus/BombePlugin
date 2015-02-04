<?php

require_once 'app/controllers/plugin_controller.php';

class ManagerController extends PluginController {

    public function overview_action() {
        Navigation::activateItem("/profile/bomben");
        $this->user_id = Request::username("username")
            ? get_userid(Request::username("username"))
            : $GLOBALS['user']->id;
    }

    public function set_bomb_action()
    {
        if (Request::isPost() && Request::get("user_id")) {
            $recent_bombs = Bombe::countBySQL("user_id = ? AND from_user = ? AND hit = '0' AND mkdate > UNIX_TIMESTAMP() - 2 * 60", array(Request::get("user_id"), $GLOBALS['user']->id));

            if ($recent_bombs < 1) {
                $bombe = new Bombe();
                $bombe['user_id'] = Request::get("user_id");
                $bombe['from_user'] = $GLOBALS['user']->id;
                $bombe['bomb_url'] = $this->plugin->getPluginURL()."/assets/glyph_bomb.svg";
                $bombe->store();
                PageLayout::postMessage(MessageBox::info(_("Eine Bombe wurde gelegt. Wenn der Nutzer in den nächsten zwei Minuten online ist, geht sie hoch.")));
            } else {
                PageLayout::postMessage(MessageBox::error(_("Eine Bombe wartet noch darauf, hoch zu gehen. Die müssen Sie erst einmal abwarten. Probieren Sie es gleich wieder.")));
            }
        }
    }
}