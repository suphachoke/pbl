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
	"</style>";


if($_REQUEST['act']=='nc'){//New case studies
	echo $OUTPUT->heading('Case Studie Analysis');

}else if($_REQUEST['act']=='np'){//New project here
	echo $OUTPUT->heading('Create Your Own Project');
	
}else if($_REQUEST['act']=='se'){//Search Engine
	echo $OUTPUT->heading('Projects/Case-Studies Search Engine');
}else {//Search Engine
	echo $OUTPUT->heading('Projects Case Studies Dashboard');
	echo "<button class='act-btn' id='nc'>New Case Study</button>".
		"&nbsp;<button class='act-btn' id='np'>New Project</button>".
		"&nbsp;<button class='act-btn' id='se'>Search Engine</button>";
}

echo "<script type='text/javascript' src='../../lib/jquery/jquery-3.1.0.min.js'></script>";
echo "<script type='text/javascript'>". 
		"\$('.act-btn').click(function(){window.location.href='?id=".$_REQUEST['id']."&act='+\$(this).prop('id')});".
		"</script>";

// Finish the page.
echo $OUTPUT->footer();
