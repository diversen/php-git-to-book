<?php

// Simple progress bar taken from:
// http://www.johnboy.com/php-upload-progress-bar/
// upload.php
$url = basename($_SERVER['SCRIPT_FILENAME']);

if (isset($_GET['progress_key'])) {
    if (!function_exists('apc_fetch')) {
        // no progress bar
        die;
    }
    $status = apc_fetch('upload_' . $_GET['progress_key']);
    if ($status['total'] == 0) {
        echo "0";
    } else {
        echo $status['current'] / $status['total'] * 100;
    }
    die;
}


?>
<!doctype html>
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.js" type="text/javascript"></script>
    <link href="/css/progress.css" rel="stylesheet" type="text/css" />

    <script>
        $(document).ready(function () {
            setInterval(function () {
                // get request to the current URL (upload_frame.php) 
                // which calls the code at the top of the page.  It checks the 
                // file's progress based on the file id "progress_key=" and 
                // returns the value with the function below:
                $.get("<?= $url ?>?progress_key=<?= $_GET['up_id']; ?>&randval=" + Math.random(), {
                    //return information back from jQuery's get request
                }, function (data) {
                    $('#progress_container').fadeIn(100);	//fade in progress bar	
                    $('#progress_bar').width(data + "%");	//set width of progress bar based on the $status value (set at the top of this page)
                    $('#progress_completed').html(parseInt(data) + "%");	//display the % completed within the progress bar
                }
                )
            }, 1000);	//Interval is set at 500 milliseconds (the progress bar will refresh every .5 seconds)
        });


    </script>
</head>
<body style="margin:0px">
    <div id="progress_container">
        <div id="progress_bar">
            <div id="progress_completed"></div>
        </div>
    </div>
</body>
