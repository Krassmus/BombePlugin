<?php

class ManagerController extends PluginController {

    public function overview_action() {
        Navigation::activateItem("/profile/bomben");
    }
}