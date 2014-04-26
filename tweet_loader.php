<?php
require_once "vendor/autoload.php";
$baseDir = "/home/janis/tweets/twitter/tweets2";
$files = scandir($baseDir);
$params = array(
    'host' => '127.0.0.1',
    'username' => 'tweets',
    'password' => 'tweets',
    'dbname' => 'sentiment',
    'driver_options' => array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8;')
);
$db = Zend_Db::factory('PDO_MYSQL', $params);
//var_export($db->listTables());
//var_export($db->isConnected());

$offset = 2; // To offset the default dir variables in directory listing
$latvian = 0;
$fileArrSize=count($files);
for ($i = $offset; $i < $fileArrSize; $i++) {
    $tweet = json_decode(file_get_contents($baseDir . "/" . $files[$i]));
    $text = $tweet->text;
    $id = $tweet->id;
    if (isset($tweet->lang) && $tweet->lang != "lv") {
        continue;
    }
    $latvian++;

    //var_export($id);
    $id=$db->insert("tweets", array(
        "external_tweet_id" => $id,
        "text"=>$text,
        "lang"=>"lv"
    ));
   // var_export($id);
    //echo "\n";

    //echo "<br/>";

}
//echo "\n";
var_export($latvian);
echo "\n";