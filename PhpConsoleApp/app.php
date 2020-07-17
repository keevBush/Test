<?php
require __DIR__.'/vendor/autoload.php';
include_once("Backend.php");
echo __DIR__;
use Data\Backend;

$from = $argv[1];
$from = str_replace('_', " ",$from);
$to = $argv[2];
$to = str_replace('_', " ",$to);
if(isset($from,$to)){
    if($from === "help" || $from === "Help"){
        help();
    }else{
        echo "\n====================We search for you a way for your travel========================\n";
        $data = Backend::SearchGoodRoute($from, $to);
        foreach($data as $d){
            echo $d ."\n";
        }
    }
    
}

function help(){
    printf("\n=================Help=================\n\n");
    echo("This is the tutorial to run app. \n");
    echo("Run command: php app.php (from) (destination) \n");
    echo("Data file is here /data/data.js \n");
    echo("\n");
}
