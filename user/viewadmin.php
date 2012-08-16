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
**************************************************************************
**                              Plugin Name                             **
**************************************************************************
* @package     local                                                    **
* @subpackage  Placement                                                **
* @name        Placement                                                **
* @copyright   oohoo.biz                                                **
* @link        http://oohoo.biz                                         **
* @author      Stephane                                                 **
* @author      Fagnan                                                   **
* @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later **
**************************************************************************
**************************************************************************/

require('../config.php');
require('../lib/libadmin.php');

global $DB, $CFG, $USER;

require_login(1, true);
$context = get_context_instance(CONTEXT_USER, $USER->id);

$PAGE->set_url($CFG->wwwroot.'/local/placement/user/viewadmin.php');
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('placement', 'local_placement'));
$PAGE->set_heading(get_string('placement', 'local_placement'));

$PAGE->requires->js('/local/placement/js/jquery.js');
$PAGE->requires->js('/local/placement/js/jquery.min.js');
$PAGE->requires->js('/local/placement/js/script.js');
$PAGE->requires->js('/local/placement/js/validate.js');
$PAGE->requires->js('/local/placement/js/jquery.ui.js');
$PAGE->requires->css('/local/placement/css/style.css');
$PAGE->requires->css('/local/placement/css/jquery.ui.css');
$PAGE->requires->css('/local/placement/css/validate.css');
        
//echo '<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>';
echo $OUTPUT->header();

//    $record = new stdClass();
//    $record->id = $id;
//    $record->student_teacher_id = 1243;
//    $record->lastname = 'Roberts';
//    $record->firstname = 'Melinda';
//    $record->phone = '780-465-1492';
//    $record->email = 'melindar@ualberta.ca';
//    $record->type = '';
//    $record->program = '';
//    $record->stage = 'Stage 2';
//    $record->schoolboard = 'Edmonton Public School Board';
//    $record->supervisor = 'Marylène Lamy-Rittammer';
//    $record->semester = 'Hiver 2012';
//    $record->school = 'Dunluce';
//    $record->coop_teacher_id = 1290;
//    $record->supervisor_id = 297;
//    $record->minor = '';
//    $record->major = '';
//    $record->schoolid = 181;
//    $record->coop_lastname = 'Korcek';
//    $record->coop_firstname = 'Marla';
//    $record->schoolyear = '1ere';
//    $record->vehicle = 'n';
//    $record->coop2_id = 0;
//    $record->coop2_lastname = '';
//    $record->coop2_firstname = '';
//    $record->supervisor_lastname = '';
//    $record->supervisor_firstname = '';
//    $record->comments = '';
//    $record->address = 'apt#309, 107-104st NW Edmonton';
//    $record->phone2 = '';
//    $record->outside_province = '';
//    $record->mileage_claimed = 0;
//    $record->onecard = 1058693;

//$DB->delete_records('user', array("id" => 53));
//$DB->delete_records('placement_coop_teachers', array('id' => 1315));
//$DB->delete_records('placement_school', array('id' => 198));
//$DB->delete_records('placement_users', array('id'=>2));

//$record = new stdClass();
//$record->id = 9;
//$record->school = 'École Gabrielle-Roy';
//$record->address = '8728 - 93e Avenue';
//$record->city = 'Edmonton';
//$record->phone = '(780) 457-2100';
//$record->province = 'AB';
//$record->postalcode = 'T6C 1T8';
//$record->principalfirstname = 'Jean-Daniel';
//$record->principallastname = 'Tremblay';
//$record->email = 'jdtremblay@centrenord.ab.ca';
//$record->principalphone = '';
//$record->contactfirstname = 'Pierre';
//$record->contactlastname = 'Hébert';
//$record->contactphone = '';
//$record->fax = '(780) 472-7855';
//$record->contactemail = '';
//$record->contactlang = '';
//$record->contactsex = 'm';
//$record->schoolboard = 'Conseil Scolaire Regional du Centre-Nord';
//$record->program = '';
//$record->website = 'http://www.csrcn.ab.ca/gabrielleroy/ECOLE.htm';
//$record->zone = 'Edmonton Region';
//
//$DB->update_record('placement_school', $record);


//$DB->delete_records('placement_schoolboard', array("id" => 75));


//$record = new stdClass();
//$record->id = 951;
//$record->coopid = 1311;
//$record->lastname = '';
//$record->firstname = '';
//$record->school = 'Harry Ainlay High School';
//$record->sin = '';
//$record->stage = 'EDU E 331';
//$record->fee = '0.00';
//$record->payment = '';
//$record->stage2 = '';
//$record->level = 'secondaire';
//$record->schoolboard = 'Edmonton Public School Board';
//$record->schoolid = 2;
//$record->schoolyear = '10-11';
//$record->semester = 'Automn 2012';
//$record->email = '';
//$record->comments = '';
//$record->subjects = 'Sciences 10, Mathématiques 10C et Chimie 20';
//$record->sharedstage = 'o';
//$record->responsability = '';
//$record->teacher2 = '';
//$record->studentteachersub = '';
//$record->studentteacher1 = 'Adrienne Cottreau';
//
//$DB->update_record('placement_coop_teachers', $record);

//Check to see if user has access rights.
//$DB->delete_records('placement_users', array("id" => 7));

if($DB->get_record('placement_users', array("userid" => $USER->id)))
{

if($DB->get_record('placement_users', array("userid" => $USER->id, "confirmed" => 0)))
{
    dialog();
}
else
{
$view = optional_param('view', '0', PARAM_TEXT);

if($view !== '0')
{
    if($view == 'admin')
    {
        admin_view();
    }
    else if($view == 'editschool')
    {
        edit_school_view();
    }
    else if($view == 'add')
    {
        add_view();
    }
    else if($view == 'edit')
    {
        $id = optional_param('id', '0', PARAM_INT);
        edit_view($id);
    }
    echo '<span id="null" style="display:none;"></span>';
}   
}
}
else
    echo 'Not in database';
echo $OUTPUT->footer();
?>
