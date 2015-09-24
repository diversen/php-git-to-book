<?php

include_once "webcommon.php";


// try if we can connect to db given in config.ini
try {
    $db = new installDb();
} catch (PDOException $e) {
    echo "Could not connect to db with the data given in config/config.ini. Error";
    die();
}

// check to see if an install have been made.
// we check if there are rows in 'modules'
try {
    $num_rows = $db->getNumRows('modules');
} catch (PDOException $e) {   
    $num_rows = 0;
}

if ($num_rows == 0){
    echo "No tables or data in database. OK<br>";
    // read default sql and execute it.
    $sql = $db->readSql();
    $res = $db->rawQuery($sql);

    // if positive we install base modules.
    
    if (isset($_GET['profile'])) {
        $profile = $_GET['profile'];
    } else {
        $profile = 'default';
    }
    
    if ($res){
        install_from_profile(array ('profile' =>  $profile));
    }
    echo "Base system installed.<br />";
} else {
    echo "System is installed! <br>";
}

$users = $db->getNumRows('account');
if ($users == 0) {
    web_install_add_user();
} else {
    echo "User exists. Install OK<br />\n";
}
