<?php

function dd($param)
{
    echo "<pre>";
    var_dump($param);
    echo "</pre>";
}


define('DSN_PG', 'pgsql');
define('DSN_MY', 'mysql');
define('DATABASE', 'user6');
define('USER', 'user6');
define('PASSWORD', 'user6');

define('DEFAULT_HEADER', 'Content-Type: application/json');
