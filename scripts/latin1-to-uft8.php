<?php

/**
 * 
 * If you want to use this as a standalone script you will need to 
 * modify it slightly as it uses the coscms framework. 
 * 
 * Or just clone the coscms (you will need php >= 5.3):
 * 
 * git clone git://github.com/diversen/coscms.git
 * 
 * cp config/config.ini-dist config/config.ini
 *  
 * cd coscms
 *
 * and edit config/config.ini 
 * 
 * set: 
 * 
 * url = "mysql:dbname=mydatabase;host=localhost"
 * username = "user"
 * password = "password"
 * 
 * then run 
 * 
 * php scripts/latin1-to-uft8.php 
 * 
 * This will transform all of your broken chars like: 
 * 
 * Ã¡ = á
 * Ã© = é
 * Ã­- = í
 * Ã³ = ó
 * Ã± = ñ
 * Ã¡ = Á
 * 
 * To proper utf8
 * 
 * Only testet on my own setup, so backup your database
 * 
 * There was a few problem with indexes, but they were solved 
 * by running the latin1 -> blob -> utf8 in one query 
 * 
 */

include_once "vendor/autoload.php";
use diversen\conf;
use diversen\db;

conf::setMainIni('base_path', realpath('.'));

conf::loadMainCli();

$db = new db();
$db->connect();

function get_tables_db () {
    $db = new db();
    $rows = $db->selectQuery('show tables');
    $tables = array();
    foreach ($rows as $table) {
        $tables[] = array_pop($table);
    }
    return $tables;
}

function get_table_create ($table) {
    $db = new db();
    $sql = "DESCRIBE $table";
    return $db->selectQuery($sql);
}



function column_has_text ($ary) {
    $ary['Type'] = trim($ary['Type']);
    if (preg_match("#^varchar#", $ary['Type'])) {
        return true;
    }
    
    if (preg_match("#^text#", $ary['Type']) ) {
        return true;
    }
    
    if (preg_match("#^mediumtext#", $ary['Type']) ) {
        return true;
    }
    
    if (preg_match("#^longtext#", $ary['Type']) ) {
        return true;
    }
    if (preg_match("#^tinytext#", $ary['Type']) ) {
        return true;
        
    }
    return false;
}

$tables = get_tables_db();
foreach ($tables as $table ) {
    $create = get_table_create($table);

    foreach ($create as $column) {
        if (column_has_text($column)) {

            
            echo "Fixing $table:  column $column[Field]\n";
            $query = "ALTER TABLE `$table` MODIFY `$column[Field]` $column[Type] character set latin1;";
            $query.= "ALTER TABLE `$table` MODIFY `$column[Field]` BLOB;";
            $query.= "ALTER TABLE `$table` MODIFY `$column[Field]` $column[Type] character set utf8;";
            $db->rawQuery($query);
            
        }
    }    
}
