<?php

class InitPluginMigration extends Migration {
    
    function description() {
        return 'creates the database';
    }

    public function up() {
        $db = DBManager::get();
        $db->exec("
            CREATE TABLE IF NOT EXISTS `bomben` (
                `bomb_id` varchar(32) NOT NULL,
                `from_user` varchar(32) NOT NULL,
                `user_id` varchar(32)  NOT NULL,
                `bomb_url` varchar(128)  NOT NULL,
                `hit` tinyint(4) NOT NULL DEFAULT '0',
                `chdate` bigint(20) NOT NULL,
                `mkdate` bigint(20) NOT NULL,
                PRIMARY KEY (`bomb_id`)
            ) ENGINE=MyISAM;
        ");


    }
	
    public function down() {

    }
}