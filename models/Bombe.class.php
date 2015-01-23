<?php

class Bombe extends SimpleORMap {

    protected static function configure($config = array())
    {
        $config['db_table'] = 'bomben';
        parent::configure($config);
    }
}