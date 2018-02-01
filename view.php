<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Prints a particular instance of pbl
 *
 * You can have a rather longer description of the file as well,
 * if you like, and it can span multiple lines.
 *
 * @package    mod_pbl
 * @copyright  2016 Your Name <your@email.address>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Replace pbl with the name of your module and remove this line.

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once(dirname(__FILE__).'/lib.php');

require_once($CFG->libdir."/formslib.php");

class simpleform extends moodleform {
  public function definition() {
    global $CFG;
    $mform = $this->_form;
    $mform->addElement('text','name','ชื่อทีม');
    $definitionoptions = array('subdirs'=>false, 'maxfiles'=>99, 'maxbytes'=>1024000, 'trusttext'=>true,
                           'context'=>'');
    $mform->addElement('editor','intro','เกี่ยวกับทีม',null,$definitionoptions);
    $mform->setType('intro',PARAM_RAW);
    $mform->addElement('filemanager', 'picture', 'รูปภาพทีม', null,
                   array('subdirs'=>0,'maxfiles'=>1,'maxbytes' => 2048000, 'accepted_types' => array('jpg','png','jpeg')));
    $mform->addRule('name', null, 'required', null, 'client');
    $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');

    $this->add_action_buttons();
  }
  function validation($data, $files) {
    return array();
  }
}

class newprojectform extends moodleform {
  public function definition(){
    global $CFG;
    $mform = $this->_form;
    $mform->addElement('text','name','ชื่อโครงการ/โครงงาน','style="width:95%;"');
    $mform->addElement('textarea','problems','ประเด็นปัญหา','wrap="virtual" rows="5" cols="50"');
    $mform->addElement('textarea','objectives','วัตถุประสงค์','wrap="virtual" rows="5" cols="50"');
    $definitionoptions = array('subdirs'=>false, 'maxfiles'=>99, 'maxbytes'=>1024000, 'trusttext'=>true,
                           'context'=>'');
    $mform->addElement('editor','intro','เกี่ยวกับโครงการ',null,$definitionoptions);
    $mform->setType('intro',PARAM_RAW);
    $mform->addElement('filemanager', 'picture', 'รูปภาพประกอบ', null,
                   array('subdirs'=>0,'maxfiles'=>1,'maxbytes' => 2048000, 'accepted_types' => array('jpg','png','jpeg')));
    $mform->addElement('filemanager', 'file', 'ไฟล์ประกอบ', null,
                   array('subdirs'=>0,'maxfiles'=>1,'maxbytes' => 2048000, 'accepted_types' => array('pdf','doc','docx','ppt','pptx')));
    $mform->addRule('name', null, 'required', null, 'client');
    $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
    $mform->addRule('objectives', null, 'required', null, 'client');
    $mform->addRule('objectives', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
    $mform->addRule('problems', null, 'required', null, 'client');
    $mform->addRule('problems', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
    $mform->addElement('hidden','type','project');

    $this->add_action_buttons();
  }
}

class newcaseform extends moodleform {
  public function definition(){
    global $CFG;
    $mform = $this->_form;
    $mform->addElement('text','name','ชื่อโครงการ/โครงงานกรณีศึกษา','style="width:95%;"');
    $mform->addElement('textarea','problems','ประเด็นปัญหา','wrap="virtual" rows="5" cols="50"');
    $mform->addElement('textarea','objectives','วัตถุประสงค์','wrap="virtual" rows="5" cols="50"');
    $definitionoptions = array('subdirs'=>false, 'maxfiles'=>99, 'maxbytes'=>1024000, 'trusttext'=>true,
                           'context'=>'');
    $mform->addElement('editor','intro','เกี่ยวกับโครงการ',null,$definitionoptions);
    $mform->setType('intro',PARAM_RAW);
    $mform->addElement('filemanager', 'picture', 'รูปภาพประกอบ', null,
                   array('subdirs'=>0,'maxfiles'=>1,'maxbytes' => 2048000, 'accepted_types' => array('jpg','png','jpeg')));
    $mform->addElement('filemanager', 'file', 'ไฟล์ประกอบ', null,
                   array('subdirs'=>0,'maxfiles'=>1,'maxbytes' => 2048000, 'accepted_types' => array('pdf','doc','docx','ppt','pptx')));
    $mform->addElement('text','source','แหล่งที่มา','style="width:95%"');
    $mform->addRule('name', null, 'required', null, 'client');
    $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
    $mform->addRule('objectives', null, 'required', null, 'client');
    $mform->addRule('objectives', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
    $mform->addRule('problems', null, 'required', null, 'client');
    $mform->addRule('problems', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
    $mform->addRule('source', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
    $mform->addElement('hidden','type','case');

    $this->add_action_buttons();
  }
}

class newactivityform extends moodleform {
  public function definition(){
    global $CFG;
    $mform = $this->_form;
    $mform->addElement('text','name','ชื่อกิจกรรม','style="width:95%;"');
    $definitionoptions = array('subdirs'=>false, 'maxfiles'=>99, 'maxbytes'=>1024000, 'trusttext'=>true,
                           'context'=>'');
    $mform->addElement('editor','description','อธิบายกิจกรรม',null,$definitionoptions);
    $mform->setType('description',PARAM_RAW);
    $mform->addElement('filemanager', 'picture', 'รูปภาพประกอบ', null,
                   array('subdirs'=>0,'maxfiles'=>1,'maxbytes' => 2048000, 'accepted_types' => array('jpg','png','jpeg')));
    $mform->addElement('filemanager', 'file', 'ไฟล์ประกอบ', null,
                   array('subdirs'=>0,'maxfiles'=>1,'maxbytes' => 2048000, 'accepted_types' => array('pdf','doc','docx','ppt','pptx')));
    $mform->addRule('name', null, 'required', null, 'client');
    $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');

    $this->add_action_buttons();
  }
}

class newcontextform extends moodleform {
  public function definition(){
    global $CFG;
    $mform = $this->_form;
    $mform->addElement('text','name','ชื่อคุณสมบัติ','style="width:95%;"');
    $mform->addElement('textarea','value','อธิบาย','wrap="virtual" rows="5" cols="50"');
    $mform->addRule('name', null, 'required', null, 'client');
    $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');
    $mform->addRule('value', null, 'required', null, 'client');
    $mform->addRule('value', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');

    $this->add_action_buttons();
  }
}

$id = optional_param('id', 0, PARAM_INT); // Course_module ID, or
$n  = optional_param('n', 0, PARAM_INT);  // ... pbl instance ID - it should be named as the first character of the module.

if ($id) {
    $cm         = get_coursemodule_from_id('pbl', $id, 0, false, MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $pbl  = $DB->get_record('pbl', array('id' => $cm->instance), '*', MUST_EXIST);
} else if ($n) {
    $pbl  = $DB->get_record('pbl', array('id' => $n), '*', MUST_EXIST);
    $course     = $DB->get_record('course', array('id' => $pbl->course), '*', MUST_EXIST);
    $cm         = get_coursemodule_from_instance('pbl', $pbl->id, $course->id, false, MUST_EXIST);
} else {
    error('You must specify a course_module ID or an instance ID');
}

require_login($course, true, $cm);

$event = \mod_pbl\event\course_module_viewed::create(array(
    'objectid' => $PAGE->cm->instance,
    'context' => $PAGE->context,
));
$event->add_record_snapshot('course', $PAGE->course);
$event->add_record_snapshot($PAGE->cm->modname, $pbl);
$event->trigger();

// Print the page header.

$PAGE->set_url('/mod/pbl/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($pbl->name));
$PAGE->set_heading(format_string($course->fullname));

/*
 * Other things you may want to set - remove if not needed.
 * $PAGE->set_cacheable(false);
 * $PAGE->set_focuscontrol('some-html-id');
 * $PAGE->add_body_class('pbl-'.$somevar);
 */

// Output starts here.
echo $OUTPUT->header();

// Conditions to show the intro can change to look for own settings or whatever.
if ($pbl->intro) {
    echo $OUTPUT->box(format_module_intro('pbl', $pbl, $cm->id), 'generalbox mod_introbox', 'pblintro');
}

// Replace the following lines with you own code.
echo "<style type='text/css'>".
		"table{border-top:1px solid gray;border-bottom:1px solid gray;}".
		"table tr th{border-bottom:1px solid gray;}".
		"table tr td,table tr th{padding:10px;}".
    "h3 {text-align:center;}".
    ".itembox {float:left;margin:10px;}".
    ".itembox img {height:100px;}".
    ".txtarea {margin:5px;padding:5px;border:1px solid #efefef;}".
	"</style>";


if($_REQUEST['act']=='nc'){//New Case studies
	echo $OUTPUT->heading('Case Studie Analysis');
  $mform = new newcaseform(new moodle_url('?id='.$_REQUEST['id'].'&uid='.$USER->id.'&act=nc'));
  if($mform->is_cancelled()){

  }else if($formform = $mform->get_data()){
    //print_r($formform);
    $rwf = $DB->get_record_sql('select * from {files} where itemid=? and filesize>?',array($formform->picture,0));
    if($draftitem = file_get_submitted_draft_itemid('picture')){
      file_save_draft_area_files($draftitem,$rwf->contextid,'mod_pbl','team_picture',$USER->id,array('subdirs'=>false,'maxfiles'=>1));
    }
    $furl = $CFG->wwwroot.'/pluginfile.php/'.$rwf->contextid.'/mod_pbl/team_picture/'.$USER->id.'/'.$rwf->filename;
    //echo $furl;
    $rwf2 = $DB->get_record_sql('select * from {files} where itemid=? and filesize>?',array($formform->file,0));
    if($draftitem = file_get_submitted_draft_itemid('picture')){
      file_save_draft_area_files($draftitem,$rwf2->contextid,'mod_pbl','team_picture',$USER->id,array('subdirs'=>false,'maxfiles'=>1));
    }
    $furl = $CFG->wwwroot.'/pluginfile.php/'.$rwf2->contextid.'/mod_pbl/team_picture/'.$USER->id.'/'.$rwf2->filename;
    $case = new stdClass();
    $case->pblid = $pbl->id;
    $case->userid = $_REQUEST['uid'];
    $case->name = $formform->name;
    $case->intro = $formform->intro['text'];
    if($furl<>""){
      $case->picture = $furl;
    }
    if($f2url<>""){
      $case->file = $f2url;
    }
    $case->objectives = $formform->objectives;
    $case->problems = $formform->problems;
    $case->source = $formform->source;
    //print_r($case);
    if($_REQUEST['pid']<>""){
      $case->timemodified = mktime();
      $case->id = $_REQUEST['pid'];
      $DB->update_record('pbl_project',$case);
    }else{
      $case->timecreated = mktime();
      $case->timemodified = 0;
      $case->type = $formform->type;
      $case->remove = 0;
      $DB->insert_record('pbl_project',$case);
    }
    echo "<script type='text/javascript'>window.location.href='?id=".$_REQUEST['id']."'</script>";
  }else {
    $r = $DB->get_record('pbl_project',array('id'=>$_REQUEST['pid']));
    $case = new stdClass();
    $case->name = $r->name;
    $case->intro = $r->intro;
    $case->objectives = $r>objectives;
    $case->problems = $r->problems;
    $mform->set_data($case);
    $mform->display();
  }

}else if($_REQUEST['act']=='pa'){//Add Project/Case Activities
  $rwp = $DB->get_record('pbl_project',array('id'=>$_REQUEST['pid']));
	echo $OUTPUT->heading('Adding "'.$rwp->name.'" Activities');
  $mform = new newactivityform(new moodle_url('?id='.$_REQUEST['id'].'&act=pa&pid='.$_REQUEST['pid']));
  if($mform->is_cancelled()){

  }else if($formform = $mform->get_data()){
    //print_r($formform);
    $rwf = $DB->get_record_sql('select * from {files} where itemid=? and filesize>?',array($formform->picture,0));
    //print_r($rwf);
    if($draftitem = file_get_submitted_draft_itemid('picture')){
      file_save_draft_area_files($draftitem,$rwf->contextid,'mod_pbl','team_picture',$USER->id,array('subdirs'=>false,'maxfiles'=>1));
    }
    $furl = $CFG->wwwroot.'/pluginfile.php/'.$rwf->contextid.'/mod_pbl/team_picture/'.$USER->id.'/'.$rwf->filename;
    //echo $furl;
    $rwf2 = $DB->get_record_sql('select * from {files} where itemid=? and filesize>?',array($formform->file,0));
    if($draftitem = file_get_submitted_draft_itemid('picture')){
      file_save_draft_area_files($draftitem,$rwf2->contextid,'mod_pbl','team_picture',$USER->id,array('subdirs'=>false,'maxfiles'=>1));
    }
    $furl = $CFG->wwwroot.'/pluginfile.php/'.$rwf2->contextid.'/mod_pbl/team_picture/'.$USER->id.'/'.$rwf2->filename;
    $acta = new stdClass();
    $acta->projectid = $_REQUEST['pid'];
    if($_REQUEST['aid']==""){
      $acta->userid = $USER->id;
    }
    $acta->name = $formform->name;
    $acta->description = $formform->description['text'];
    if($furl<>""){$acta->picture = $furl;}
    if($f2url<>""){$acta->file = $f2url;}
    //print_r($acta);
    if($_REQUEST['aid']<>""){
      $acta->id = $_REQUEST['aid'];
      $acta->timemodified = mktime();
      $DB->update_record('pbl_project_activity',$acta);
    }else{
      $acta->timecreated = mktime();
      $acta->timemodified = 0;
      $acta->remove = 0;
      $DB->insert_record('pbl_project_activity',$acta);
    }
    $tmp = ($rwp->type=="case")?"cv":"pv";
    echo "<script type='text/javascript'>window.location.href='?id=".$_REQUEST['id']."&act=".$tmp."&pid=".$_REQUEST['pid']."'</script>";
  }else {
    $r = $DB->get_record('pbl_project_activity',array('id'=>$_REQUEST['aid']));
    $acta = new stdClass();
    $acta->projectid = $r->projectid;
    $acta->name = $r->name;
    $acta->description = $r->description;
    $mform->set_data($acta);
    $mform->display();
  }
}else if($_REQUEST['act']=='pac'){//Add Project/Activity Contexts
  $rwa = $DB->get_record('pbl_project_activity',array('id'=>$_REQUEST['aid']));
  $rwp = $DB->get_record('pbl_project',array('id'=>$rwa->projectid));
	echo $OUTPUT->heading('Adding <i>"'.$rwp->name.':'.$rwa->name.'"</i> Attributes');
  $mform = new newcontextform(new moodle_url('?id='.$_REQUEST['id'].'&act=pac&aid='.$_REQUEST['aid']));
  if($mform->is_cancelled()){

  }else if($formform = $mform->get_data()){
    print_r($formform);
    $actc = new stdClass();
    $actc->activityid = $_REQUEST['aid'];
    $actc->userid = $USER->id;
    $actc->name = $formform->name;
    $actc->value = $formform->value;
    $actc->timecreated = mktime();
    $DB->insert_record('pbl_project_activity_context',$actc);
    $tmp = ($rwp->type=="project")?"pv":"cv";
    echo "<script type='text/javascript'>window.location.href='?id=".$_REQUEST['id']."&act=".$tmp."&pid=".$rwp->id."'</script>";
  }else {
    $mform->set_data($toform);
    $mform->display();
  }
}else if($_REQUEST['act']=='np'){//New Projects
	echo $OUTPUT->heading('Create New Project');
  $mform = new newprojectform(new moodle_url('?id='.$_REQUEST['id'].'&act=np&tid='.$_REQUEST['tid']));
  if($mform->is_cancelled()){

  }else if($formform = $mform->get_data()){
    print_r($formform);
    $rwf = $DB->get_record_sql('select * from {files} where itemid=? and filesize>?',array($formform->picture,0));
    if($draftitem = file_get_submitted_draft_itemid('picture')){
      file_save_draft_area_files($draftitem,$rwf->contextid,'mod_pbl','team_picture',$USER->id,array('subdirs'=>false,'maxfiles'=>1));
    }
    $furl = $CFG->wwwroot.'/pluginfile.php/'.$rwf->contextid.'/mod_pbl/team_picture/'.$USER->id.'/'.$rwf->filename;
    $rwf2 = $DB->get_record_sql('select * from {files} where itemid=? and filesize>?',array($formform->file,0));
    if($draftitem = file_get_submitted_draft_itemid('picture')){
      file_save_draft_area_files($draftitem,$rwf2->contextid,'mod_pbl','team_picture',$USER->id,array('subdirs'=>false,'maxfiles'=>1));
    }
    $furl2 = $CFG->wwwroot.'/pluginfile.php/'.$rwf2->contextid.'/mod_pbl/team_picture/'.$USER->id.'/'.$rwf2->filename;
    $proj = new stdClass();
    $proj->pblid = $pbl->id;
    $proj->teamid = $_REQUEST['tid'];
    $proj->name = $formform->name;
    $proj->intro = $formform->intro['text'];
    if($furl<>""){
      $proj->picture = $furl;
    }
    if($f2url<>""){
      $proj->file = $f2url;
    }
    $proj->objectives = $formform->objectives;
    $proj->problems = $formform->problems;
    if($_REQUEST['pid']<>""){
      $timemodified = mktime();
      $proj->id = $_REQUEST['pid'];
      $DB->update_record('pbl_project',$proj);
    }else{
      $proj->timecreated = mktime();
      $proj->type = $formform->type;
      $DB->insert_record('pbl_project',$proj);
    }
    echo "<script type='text/javascript'>window.location.href='?id=".$_REQUEST['id']."'</script>";
  }else {
    if($_REQUEST['pid']<>""){
      $r = $DB->get_record('pbl_project',array('id'=>$_REQUEST['pid']));
      $proj = new stdClass();
      $proj->pblid = $r->pblid;
      $proj->teamid = $r->teamid;
      $proj->name = $r->name;
      $proj->intro = $r->intro;
      $proj->objectives = $r->objectives;
      $proj->problems = $r->problems;
      $mform->set_data($proj);
    }
    $mform->display();
  }
}else if($_REQUEST['act']=='ct'){//New Team
	echo $OUTPUT->heading('Create Your Own Team');

  $mform = new simpleform(new moodle_url('?id='.$_REQUEST['id'].'&act=ct'));
  if($mform->is_cancelled()){

  }else if($formform = $mform->get_data()){
    //print_r($formform);
    $rwf = $DB->get_record_sql('select * from {files} where itemid=? and filesize>?',array($formform->picture,0));
    //print_r($rwf);
    //$furl = ($rwf->id<>"")?$CFG->wwwroot."/draftfile.php/".$rwf->contextid."/".$rwf->component."/".$rwf->filearea."/".$rwf->itemid."/".$rwf->filename:"";
    //echo $furl;
    $entry = new stdClass();
    $entry->id = 0;
    if($draftitem = file_get_submitted_draft_itemid('picture')){
      file_save_draft_area_files($draftitem,$rwf->contextid,'mod_pbl','team_picture',$USER->id,array('subdirs'=>false,'maxfiles'=>1));
    }
    $furl = $CFG->wwwroot.'/pluginfile.php/'.$rwf->contextid.'/mod_pbl/team_picture/'.$USER->id.'/'.$rwf->filename;
    echo $furl;
    $team = new stdClass();
    $team->pblid = $pbl->id;
    $team->userid = $USER->id;
    $team->name = $formform->name;
    $team->intro = $formform->intro['text'];
    if($furl<>""){
      $team->picture = $furl;
    }
    if(!empty($_REQUEST['tid'])){
      $team->id = $_REQUEST['tid'];
      $team->timemodified = mktime();
      $DB->update_record('pbl_team',$team);
    }else{
      $team->timecreated = mktime();
      $team->remove = 0;
      print_r($team);
      $DB->insert_record('pbl_team',$team);
    }
    echo "<script type='text/javascript'>window.location.href='?id=".$_REQUEST['id']."'</script>";
  }else {
    $r = $DB->get_record('pbl_team',array('id'=>$_REQUEST['tid']));
    if(!empty($r->id)){
      $team = new stdClass();
      $team->pblid = $r->pblid;
      $team->userid = $r->userid;
      $team->name = $r->name;
      $team->intro = $r->intro;
      $mform->set_data($team);
    }
    $mform->display();
  }

}else if($_REQUEST['act']=='am'){//Add new members
  if($_POST['action']=="add"){
    $tmobj = new stdClass();
    $tmobj->teamid = $_POST['teamid'];
    $tmobj->userid = $_POST['userid'];
    $tmobj->timecreated = mktime();
    $DB->insert_record('pbl_team_members',$tmobj);
  }else if($_POST['action']=="del"){
    $DB->delete_records('pbl_team_members',array('teamid'=>$_POST['teamid'],'userid'=>$_POST['userid']));
  }
	echo $OUTPUT->heading('Adding Team\'s Members');

  $rw = $DB->get_record('pbl_team',array('id'=>$_REQUEST['tid'],'userid'=>$USER->id));
  if($rw->id<>""){
    echo "<div>";
    $rwm = $DB->get_records('pbl_team_members',array('teamid'=>$rw->id));
    $rwtm = $DB->get_record('pbl_team',array('id'=>$rw->id));
    $rwtmu = $DB->get_record('user',array('id'=>$rwtm->userid));
    $mber = $rwtmu->firstname." ".$rwtmu->lastname."*";
    foreach($rwm as $r){
      $rwu = $DB->get_record('user',array('id'=>$r->userid));
      $mber .= ", ".$rwu->firstname." ".$rwu->lastname;
    }
    $rwp = $DB->get_records('pbl_project',array('teamid'=>$rw->id,'pblid'=>$rw->pblid,'remove'=>0));
    $projs = "<br/><b>Projects:</b>";
    foreach($rwp as $r){
      $projs .= "&nbsp;&nbsp;<a href='?id=".$_REQUEST['id']."&act=pv&pid=".$r->id."'>".$r->name."</a>";
    }
    $arr = retrieveFile($rw->picture);
    echo "<div class='itembox'><h4>".$rw->name."</h4><img src='getfile.php?contextid=$arr->contextid&area=$arr->area&itemid=$arr->itemid&filename=$arr->filename'/><p><b>Members: </b>".$mber.$projs."</p></div>";
    echo "<div style='clear:left;'></div></div>";
    echo "<hr/><h3>Students List</h3>";
    $rw1 = $DB->get_record('context',array('contextlevel'=>'50','instanceid'=>$course->id),"*",MUST_EXIST);
    $rw3 = $DB->get_records('role_assignments',array('contextid'=>$rw1->id,'roleid'=>'5'));
  	echo"<table><tr><th>ที่</th><th>รหัสนักศึกษา</th><th>ชื่อ - สกุล</th><th>รูป</th><th></th></tr>";
  	$i = 1;
  	foreach($rw3 as $r){
      $btn = "<input type='submit' style='color:green;' value='เพิ่มเข้ากลุ่ม'/>";
      $action = "add";
      foreach($rwm as $rc){
        if($rc->userid==$r->userid){
          $btn = "<input type='submit' style='color:red;' value='ลบจากกลุ่ม'/>";
          $action = "del";
        }
      }
      if($chk)continue;
  		$rw4 = $DB->get_record('user',array('id'=>$r->userid),"*",MUST_EXIST);
  		$pix = "<img src='../../user/pix.php/".$rw4->id."/f1.jpg' style='width:70px;'/>";
  		echo "<tr><td>".$i."<input type='hidden' name='userid[]' value='".$rw4->id."'/></td><td>".$rw4->username."</td><td>".$rw4->firstname." ".$rw4->lastname."</td><td>".$pix."</td>".
      "<td><form action='?act=am&id=".$_REQUEST['id']."&tid=".$_REQUEST['tid']."' method='post'><input type='hidden' name='teamid' value='".$rw->id."'/>".
      "<input type='hidden' name='action' value='".$action."'/><input type='hidden' name='userid' value='".$rw4->id."'/>".$btn."</form></td></tr>";
  		$i++;
  	}
  	echo"</table>";
  }
}else if($_REQUEST['act']=='cv'){//Case View
  $rw = $DB->get_record('pbl_project',array('id'=>$_REQUEST['pid']));
	echo $OUTPUT->heading('Case Study - '.$rw->name);
  $rwtmu = $DB->get_record('user',array('id'=>$rw->userid));
  $mber = $rwtmu->firstname." ".$rwtmu->lastname;
  echo "<div>Author: ".$mber."</div>";
  echo "<hr/>";
  echo "<h4>วัตถุประสงค์โครงการ/โครงงาน:</h4>";
  echo "<p>".$rw->objectives."</p>";
  echo "<h4>ประเด็นปัญหา:</h4>";
  echo "<p>".$rw->problems."</p>";
  echo "<h4>เกี่ยวกับโครงการ:</h4>";
  echo "<p class='txtarea'>".$rw->intro."</p>";
  if($rw->picture<>""){
    echo "<h4>ภาพประกอบ:</h4>";
    $arr = retrieveFile($rw->picture);
    echo "<img style='width:100%;' src='getfile.php?contextid=$arr->contextid&area=$arr->area&itemid=$arr->itemid&filename=$arr->filename'/>";
  }
  if($rw->file<>""){
    echo "<h4>เอกสารประกอบ:</h4>";
    $arr = retrieveFile($rw->file);
    echo "<a href='getfile.php?contextid=$arr->contextid&area=$arr->area&itemid=$arr->itemid&filename=$arr->filename'>ดาวน์โหลด</a>";
  }
  $rwpa = $DB->get_records('pbl_project_activity',array('projectid'=>$rw->id,'remove'=>0));
  $pjact = "";
  foreach($rwpa as $ra){
    $des = ($ra->description<>"")?"<p>".$ra->description."</p>":"";
    $pic = "";
    if($ra->picture<>""){
      $arr = retrieveFile($ra->picture);
      $pic = "<img src='getfile.php?contextid=$arr->contextid&area=$arr->area&itemid=$arr->itemid&filename=$arr->filename'/><br/>";
    }
    $fl = "";
    if($ra->file<>""){
      $arr = retrieveFile($ra->file);
      $fl = "<a target='_blank' href='getfile.php?contextid=$arr->contextid&area=$arr->area&itemid=$arr->itemid&filename=$arr->filename'>Document</a>";
    }
    $modbtn = "<button type='button' onclick=\"javascript:window.location.href='?id=".$_REQUEST['id']."&pid=".$rw->id."&aid=".$ra->id."&act=pa';\">แก้ไข</button>";
    $delbtn = "<button type='button' onclick=\"if(confirm('คุณต้องการลบกิจกรรมจริงหรือไม่')){javascript:window.location.href='action.php?id=".$_REQUEST['id']."&pid=".$rw->id."&aid=".$ra->id."&act=deleteactivity';}\">ลบ</button>";
    $adcbtn = "<button type='button' onclick=\"javascript:window.location.href='?id=".$_REQUEST['id']."&aid=".$ra->id."&act=pac';\">เพิ่มคุณสมบัติ</button>";
    $pjact .= "<div style='margin-left:10px;'><h5>".$ra->name."</h5>".$des.$pic.$fl."<br/>".$modbtn."&nbsp;".$delbtn."&nbsp;".$adcbtn;
    $rwpac = $DB->get_records('pbl_project_activity_context',array('activityid'=>$ra->id));
    $pjactcon = "";
    foreach($rwpac as $rc){
      $delbtn2 = "<button type='button' onclick=\"javascript:if(confirm('คุณแน่ใจที่จะลบหรือไม่')){window.location.href='action.php?id=".$_REQUEST['id']."&aid=".$ra->id."&cid=".$rc->id."&act=deletecontext';}\">ลบ</button>";
      $pjactcon .= "<li>".$rc->name." : ".$rc->value."&nbsp;".$delbtn2."</li>";
    }
    $pjact .= "<ul style='margin-top:0;'>".$pjactcon."</ul></div>";
  }
  echo "<h4>กิจกรรม:</h4>".$pjact;
  echo "<h4>แหล่งที่มา:</h4>";
  $src = ($rw->source<>"")?$rw->source:"-";
  echo "<p>".$src."</p>"."<hr/>";
  echo "<button type='button' onclick=\"javascript:window.location.href='?id=".$_REQUEST['id']."&pid=".$rw->id."&act=nc&uid=".$rw->userid."';\">แก้ไขข้อมูล</button>";
  echo "<button type='button' onclick=\"javascript:window.location.href='?id=".$_REQUEST['id']."&pid=".$rw->id."&act=pa';\">เพิ่มกิจกรรม</button>".
  "<button type='button' onclick=\"javascript:if(confirm('คุณต้องการที่จะลบข้อมูลกรณีศึกษานี้ใช่หรือไม่')){window.location.href='action.php?id=".$_REQUEST['id']."&pid=".$rw->id."&act=deletecase';}\" style='color:red;'>Remove</button>";
}else if($_REQUEST['act']=='pv'){//Project View
  $rw = $DB->get_record('pbl_project',array('id'=>$_REQUEST['pid']));
	echo $OUTPUT->heading('Project - '.$rw->name);
  echo "<div>";
  $rwm = $DB->get_records('pbl_team_members',array('teamid'=>$rw->teamid));
  $rwtm = $DB->get_record('pbl_team',array('id'=>$rw->teamid));
  $rwtmu = $DB->get_record('user',array('id'=>$rwtm->userid));
  $mber = $rwtmu->firstname." ".$rwtmu->lastname."*";
  foreach($rwm as $r){
    $rwu = $DB->get_record('user',array('id'=>$r->userid));
    $mber .= ", ".$rwu->firstname." ".$rwu->lastname;
  }
  $arr = retrieveFile($rwtm->picture);
  echo "<div class='itembox'><h4>Team: ".$rwtm->name."</h4><img src='getfile.php?contextid=$arr->contextid&area=$arr->area&itemid=$arr->itemid&filename=$arr->filename'/><p><b>Members: </b>".$mber."</p></div>";
  echo "<div style='clear:left;'></div></div>";
  echo "<hr/>";
  echo "<h4>วัตถุประสงค์ในการทำโครงการ/โครงงาน:</h4>";
  echo "<p>".$rw->objectives."</p>";
  echo "<h4>ประเด็นปัญหา:</h4>";
  echo "<p>".$rw->problems."</p>";
  echo "<h4>เกี่ยวกับโครงการ:</h4>";
  echo "<p class='txtarea'>".$rw->intro."</p>";
  if($rw->picture<>""){
    echo "<h4>ภาพประกอบ:</h4>";
    $arr = retrieveFile($rw->picture);
    echo "<img style='width:100%;' src='getfile.php?contextid=$arr->contextid&area=$arr->area&itemid=$arr->itemid&filename=$arr->filename'/>";
  }
  if($rw->file<>""){
    $arr = retrieveFile($rw->file);
    echo "<h4>เอกสารประกอบ:</h4>";
    echo "<a href='getfile.php?contextid=$arr->contextid&area=$arr->area&itemid=$arr->itemid&filename=$arr->filename'>ดาวน์โหลด</a>";
  }
  $rwpa = $DB->get_records('pbl_project_activity',array('projectid'=>$rw->id,'remove'=>0));
  $pjact = "";
  foreach($rwpa as $ra){
    $des = ($ra->description<>"")?"<p>".$ra->description."</p>":"";
    $pic = "";
    if($ra->picture<>""){
      $arr = retrieveFile($ra->picture);
      $pic = "<img src='getfile.php?contextid=$arr->contextid&area=$arr->area&itemid=$arr->itemid&filename=$arr->filename'/><br/>";
    }
    $fl = "";
    if($ra->file<>""){
      $arr = retrieveFile($ra->file);
      $fl = "<a target='_blank' href='getfile.php?contextid=$arr->contextid&area=$arr->area&itemid=$arr->itemid&filename=$arr->filename'>Document</a>";
    }
    $modbtn = "<button type='button' onclick=\"javascript:window.location.href='?id=".$_REQUEST['id']."&pid=".$rw->id."&aid=".$ra->id."&act=pa';\">แก้ไข</button>";
    $delbtn = "<button type='button' onclick=\"if(confirm('คุณต้องการลบกิจกรรมจริงหรือไม่')){javascript:window.location.href='action.php?id=".$_REQUEST['id']."&pid=".$rw->id."&aid=".$ra->id."&act=deleteactivity';}\">ลบ</button>";
    $adcbtn = "<button type='button' onclick=\"javascript:window.location.href='?id=".$_REQUEST['id']."&aid=".$ra->id."&act=pac';\">เพิ่มคุณสมบัติ</button>";
    $pjact .= "<div style='margin-left:10px;'><h5>".$ra->name."&nbsp;".$modbtn."&nbsp;".$delbtn."&nbsp;".$adcbtn."</h5>".$des.$pic.$fl;
    $rwpac = $DB->get_records('pbl_project_activity_context',array('activityid'=>$ra->id));
    $pjactcon = "";
    foreach($rwpac as $rc){
      $delbtn2 = "<button type='button' onclick=\"javascript:if(confirm('คุณแน่ใจที่จะลบหรือไม่')){window.location.href='action.php?id=".$_REQUEST['id']."&aid=".$ra->id."&cid=".$rc->id."&act=deletecontext';}\">ลบ</button>";
      $pjactcon .= "<li>".$rc->name." : ".$rc->value."&nbsp;".$delbtn2."</li>";
    }
    $pjact .= "<ul style='margin-top:0;'>".$pjactcon."</ul></div>";
  }
  echo "<h4>กิจกรรม:</h4>".$pjact."<hr/>";
  echo "<button type='button' onclick=\"javascript:window.location.href='?id=".$_REQUEST['id']."&pid=".$rw->id."&tid=".$rw->teamid."&act=np';\">แก้ไขข้อมูล</button>";
  echo "<button type='button' onclick=\"javascript:window.location.href='?id=".$_REQUEST['id']."&pid=".$rw->id."&act=pa';\">เพิ่มกิจกรรม</button>".
  "<button type='button' onclick=\"javascript:if(confirm('คุณต้องการที่จะลบข้อมูลโครงการนี้ใช่หรือไม่')){window.location.href='action.php?id=".$_REQUEST['id']."&pid=".$rw->id."&act=deleteproject';}\" style='color:red;'>Remove</button>";
}else if($_REQUEST['act']=='se'){//Search Engine
	echo $OUTPUT->heading('Projects/Case-Studies Search Engine');
}else {//Dashboard
  $rw1 = $DB->get_record('context',array('contextlevel'=>'50','instanceid'=>$course->id),"*",MUST_EXIST);
  $rw2 = $DB->get_record('role_assignments',array('contextid'=>$rw1->id,'userid'=>$USER->id),"*",MUST_EXIST);
	echo $OUTPUT->heading('Projects Dashboard');
	echo "<button class='act-btn' id='nc'>New Case Study</button>".
		"&nbsp;<button class='act-btn' id='ct'>Create Team</button>".
		"&nbsp;<button class='act-btn' id='se'>Search Engine</button>";
  echo "<hr/>";
  if($rw2->roleid<=4){
    echo "<div>";
    echo "<h3>All Case Study</h3>".stdCases($_REQUEST['id'],$pbl->id);
    echo "</div>";
    echo "<div>";
    echo "<h3>All Projects</h3>".stdProjs($_REQUEST['id'],$pbl->id);
    echo "</div>";
  }
  echo "<div>";
  echo "<h3>Your Case Study</h3>";
  $rwcase = $DB->get_records('pbl_project',array('pblid'=>$pbl->id,'userid'=>$USER->id,'remove'=>0,'type'=>'case'));
  foreach($rwcase as $r){
    $rwcaseu = $DB->get_record('user',array('id'=>$r->userid));
    $aut = $rwcaseu->firstname." ".$rwcasemu->lastname;
    $arr = retrieveFile($r->picture);
    echo "<div class='itembox'><h4><a href='?id=".$_REQUEST['id']."&act=cv&pid=".$r->id."'>".$r->name."</a></h4><img src='getfile.php?contextid=$arr->contextid&area=$arr->area&itemid=$arr->itemid&filename=$arr->filename'/><p><b>Author: </b>".$aut."</p>".
    "<button type='button' onclick=\"javascript:if(confirm('คุณต้องการที่จะลบข้อมูลกรณีศึกษานี้ใช่หรือไม่')){window.location.href='action.php?id=".$_REQUEST['id']."&pid=".$r->id."&act=deletecase';}\" style='color:red;'>Remove</button></div>";
  }
  echo "<div style='clear:left;'></div></div><hr/>";
  echo "<div>";
  echo "<h3>Your Teams</h3>";
  $rw = $DB->get_records('pbl_team',array('pblid'=>$pbl->id,'userid'=>$USER->id,'remove'=>0));
  $rwtmp0 = $DB->get_records('pbl_team_members',array('userid'=>$USER->id));
  foreach($rwtmp0 as $r){
    $rwtmp1 = $DB->get_records('pbl_team',array('id'=>$r->teamid));
    $rw = array_merge($rw,$rwtmp1);
  }
  foreach($rw as $r){
    $rwm = $DB->get_records('pbl_team_members',array('teamid'=>$r->id));
    $rwtm = $DB->get_record('pbl_team',array('id'=>$r->id));
    $rwtmu = $DB->get_record('user',array('id'=>$rwtm->userid));
    $mber = $rwtmu->firstname." ".$rwtmu->lastname."*";
    foreach($rwm as $rm){
      $rwu = $DB->get_record('user',array('id'=>$rm->userid));
      $mber .= ", ".$rwu->firstname." ".$rwu->lastname;
    }
    $rwp = $DB->get_records('pbl_project',array('teamid'=>$r->id,'pblid'=>$r->pblid,'type'=>'project','remove'=>0));
    $projs = "<br/><b>Projects:</b>";
    $countp = 0;
    foreach($rwp as $rp){
      $delim = ($countp>0)?",":"";
      $projs .= "&nbsp;".$delim."&nbsp;<a href='?id=".$_REQUEST['id']."&act=pv&pid=".$rp->id."'>".$rp->name."</a>";
      $countp++;
    }
    $arr = retrieveFile($r->picture);
    echo "<div class='itembox'><h4>".$r->name."</h4><img src='getfile.php?contextid=$arr->contextid&area=$arr->area&itemid=$arr->itemid&filename=$arr->filename'/><p><b>Members: </b>".$mber.$projs."</p>";
    if($USER->id==$r->userid){
    echo "<button type='button' onclick=\"javascript:window.location.href='?id=".$_REQUEST['id']."&tid=".$r->id."&act=ct';\">Edit</button>".
      "<button type='button' onclick=\"javascript:window.location.href='?id=".$_REQUEST['id']."&tid=".$r->id."&act=np';\">New Project</button>".
      "<button type='button' onclick=\"javascript:window.location.href='?id=".$_REQUEST['id']."&tid=".$r->id."&act=am';\">Add Member</button>".
      "<button type='button' onclick=\"javascript:if(confirm('คุณต้องการที่จะลบข้อมูลเหล่านี้ใช่หรือไม่\\n - ข้อมูลทีมและสมาชิก\\n - ข้อมูลโปรเจกต์ทั้งหมดในทีม')){window.location.href='action.php?id=".$_REQUEST['id']."&tid=".$r->id."&act=deleteteam';}\" style='color:red;'>Remove</button>";
    }
    echo "</div>";
  }
  echo "<div style='clear:left;'></div></div>";
}

echo "<script type='text/javascript' src='../../lib/jquery/jquery-3.1.0.js'></script>";
echo "<script type='text/javascript'>".
		"\$('.act-btn').click(function(){window.location.href='?id=".$_REQUEST['id']."&uid=".$USER->id."&act='+\$(this).prop('id')});".
		"</script>";

// Finish the page.
echo $OUTPUT->footer();

function stdCases($id,$pblid){
  global $DB;
  $ret = "";
  $rwcase = $DB->get_records('pbl_project',array('pblid'=>$pblid,'remove'=>0,'type'=>'case'));
  foreach($rwcase as $r){
    $rwcaseu = $DB->get_record('user',array('id'=>$r->userid));
    $aut = $rwcaseu->firstname." ".$rwcasemu->lastname;
    $arr = retrieveFile($r->picture);
    $ret .= "<div class='itembox'><h4><a href='?id=".$id."&act=cv&pid=".$r->id."'>".$r->name."</a></h4><img src='getfile.php?contextid=$arr->contextid&area=$arr->area&itemid=$arr->itemid&filename=$arr->filename'/><p><b>Author: </b>".$aut."</p>".
    "<button type='button' onclick=\"javascript:if(confirm('คุณต้องการที่จะลบข้อมูลกรณีศึกษานี้ใช่หรือไม่')){window.location.href='action.php?id=".$id."&pid=".$r->id."&act=deletecase';}\" style='color:red;'>Remove</button></div>";
  }
  $ret .= "<div style='clear:left;'></div><hr/>";
  return $ret;
}

function stdProjs($id,$pblid){
  global $DB;
  $ret = "";
  $rwcase = $DB->get_records('pbl_project',array('pblid'=>$pblid,'remove'=>0,'type'=>'project'));
  foreach($rwcase as $r){
    $rwm = $DB->get_records('pbl_team_members',array('teamid'=>$r->teamid));
    $rwtm = $DB->get_record('pbl_team',array('id'=>$r->teamid));
    $rwtmu = $DB->get_record('user',array('id'=>$rwtm->userid));
    $mber = $rwtmu->firstname." ".$rwtmu->lastname."*";
    foreach($rwm as $rr){
      $rwu = $DB->get_record('user',array('id'=>$rr->userid));
      $mber .= ", ".$rwu->firstname." ".$rwu->lastname;
    }
    $arr = retrieveFile($r->picture);
    $ret .= "<div class='itembox'><h4><a href='?id=".$id."&act=pv&tid=".$r->teamid."&pid=".$r->id."'>".$r->name."</a></h4><img src='getfile.php?contextid=$arr->contextid&area=$arr->area&itemid=$arr->itemid&filename=$arr->filename'/><p><b>Members: </b>".$mber."</p>".
    "<button type='button' onclick=\"javascript:if(confirm('คุณต้องการที่จะลบข้อมูลโครงการนี้ใช่หรือไม่')){window.location.href='action.php?id=".$id."&pid=".$r->id."&act=deleteproject';}\" style='color:red;'>Remove</button></div>";
  }
  $ret .= "<div style='clear:left;'></div><hr/>";
  return $ret;
}

function retrieveFile($url){
  $tmpurl = $url;
  $fs = get_file_storage();
  $filename = substr($url,strrpos($url,"/")+1);
  $url = substr($url,0,strrpos($url,"/"));
  $itemid = substr($url,strrpos($url,"/")+1);
  $url = substr($url,0,strrpos($url,"/"));
  $area = substr($url,strrpos($url,"/")+1);
  $url = substr($url,0,strrpos($url,"/"));
  $url = substr($url,0,strrpos($url,"/"));
  $contextid = substr($url,strrpos($url,"/")+1);
  $ret = new stdClass();
  $ret->filename = $filename;
  $ret->itemid = $itemid;
  $ret->area = $area;
  $ret->contextid = $contextid;
  return $ret;
}
