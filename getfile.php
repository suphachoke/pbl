<?php
require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

$fs = get_file_storage();
$filename = $_REQUEST['filename'];
$itemid = $_REQUEST['itemid'];
$area = $_REQUEST['area'];
$contextid = $_REQUEST['contextid'];

    $rwf = $DB->get_record_sql("select * from {files} where filename=? and userid=? and contextid=?",array($filename,$itemid,$contextid));
    
$file = $fs->get_file($contextid,'mod_pbl',$area,$itemid,"/",$filename);
    $file2 = $fs->get_file($rwf->contextid,'user','draft',$rwf->itemid,'/',$rwf->filename);
if(!$file2){
    if(!$file){
      /*if(file_exists("picture1.png")){
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename('picture1.png').'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: '.filesize('picture1.png'));
        readfile('picture1.png');
        exit;
      }*/
        echo "No file";
        print_r($rwf);
    }else{
        header("Content-Type:".$file->get_mimetype());
        send_file($file,$file->get_filename());
    }
}else{
  header("Content-Type:".$file2->get_mimetype());
  //echo $file->get_filename();
  send_file($file2,$file2->get_filename());
    //echo "Found file";
}
