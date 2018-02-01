<?php
require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$fs = get_file_storage();
$filename = $_REQUEST['filename'];
$itemid = $_REQUEST['itemid'];
$area = $_REQUEST['area'];
$contextid = $_REQUEST['contextid'];

$file = $fs->get_file($contextid,'mod_pbl',$area,$itemid,"/",$filename);
if(!$file){
  if(file_exists("picture1.png")){
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename('picture1.png').'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: '.filesize('picture1.png'));
    readfile('picture1.png');
    exit;
  }
}else{
  header("Content-Type:".$file->get_mimetype());
  //echo $file->get_filename();
  send_file($file,$file->get_filename());
}
