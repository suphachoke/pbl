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
$act = "";
if($_REQUEST['act']=="deleteteam"){
  $DB->execute('update {pbl_team} set remove=? where id=?',array(1,$_REQUEST['tid']));
  $DB->execute('update {pbl_project} set remove=? where teamid=?',array(1,$_REQUEST['tid']));
}else if($_REQUEST['act']=="deleteproject"){
  $DB->execute('update {pbl_project} set remove=? where id=?',array(1,$_REQUEST['pid']));
}else if($_REQUEST['act']=="deletecase"){
  $DB->execute('update {pbl_project} set remove=? where id=?',array(1,$_REQUEST['pid']));
}else if($_REQUEST['act']=="deleteactivity"){
  $DB->execute('update {pbl_project_activity} set remove=? where id=?',array(1,$_REQUEST['aid']));
  $rw = $DB->get_record('pbl_project',array('id'=>$_REQUEST['pid']));
  $v = ($rw->type=="project")?"pv":"cv";
  $act = "act=".$v."&pid=".$_REQUEST['pid'];
}else if($_REQUEST['act']=="deletecontext"){
  $DB->execute('delete from {pbl_project_activity_context} where id=?',array($_REQUEST['cid']));
  $rp = $DB->get_record('pbl_project_activity',array('id'=>$_REQUEST['aid']));
  $rw = $DB->get_record('pbl_project',array('id'=>$rp->projectid));
  $v = ($rw->type=="project")?"pv":"cv";
  $act = "act=".$v."&aid=".$_REQUEST['aid'];
}

echo "<script type='text/javascript'>window.location.href='view.php?id=".$_REQUEST['id']."&".$act."';</script>";
