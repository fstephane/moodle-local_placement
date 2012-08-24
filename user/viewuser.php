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

//This page takes care of all the student teacher features
//viewuser.php?register=EDU E 331 --- EDU stage registration form
//viewuser.php?register=Stage 1 --- Stage 1 registration form
//viewuser.php?register=Stage 2 --- Stage 2 registration form
//viewuser.php?register=EDU E 331 edit --- EDU stage editing form
//viewuser.php?register=Stage 1 edit --- Stage 1 stage editing form
//viewuser.php?register=Stage 2 edit --- Stage 2 stage editing form

require('../config.php');
require('../lib/libuser.php');

global $DB, $CFG, $USER;

require_login(1, true);
$context = get_context_instance(CONTEXT_USER, $USER->id);

$PAGE->set_url($CFG->wwwroot.'/local/placement/user/viewuser.php');
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('placement', 'local_placement'));
$PAGE->set_heading(get_string('placement', 'local_placement'));

$PAGE->requires->js('/local/placement/js/jquery.js');
$PAGE->requires->js('/local/placement/js/jquery.min.js');
$PAGE->requires->js('/local/placement/js/scriptuser.js');
$PAGE->requires->js('/local/placement/js/validate.js');
$PAGE->requires->js('/local/placement/js/jquery.ui.js');
$PAGE->requires->css('/local/placement/css/style.css');
$PAGE->requires->css('/local/placement/css/jquery.ui.css');
$PAGE->requires->css('/local/placement/css/validate.css');
        
echo $OUTPUT->header();

$register = optional_param('register', '0', PARAM_TEXT);
$info = $DB->get_record('user', array('id' => $USER->id));


if($register == '0')
{
    //If user is in the database but not yet registered, open dialog box and allow student to select their stage and continue to a registration form
    if($DB->get_record('placement_students', array("userid" => $USER->id, "registered" => 0)))
        dialog();
    //After dialog box is submitted, student is redirected to registration form
    else if($DB->get_record('placement_students', array("userid" => $USER->id, "registered" => 1)))
    {
        $reg = $DB->get_record('placement_students', array("userid" => $USER->id, "registered" => 1));
        $regi = $reg->stage;
        
        switch($regi)
        {
            case 'EDU E 331':
                initial();
                break;
            case 'Stage 1':
                stage1();
                break;
            case 'Stage 2':
                stage2();
                break;
        }
    }
}
else
{
    if($register == 'EDU E 331')        //EDU stage
        initial();
    else if($register == 'Stage 1')     //Stage 1
        stage1();
    else if($register == 'Stage 2')     //Stage 2
        stage2();
    else if($register == 'EDU E 331 edit')  //EDU stage edit
        initial_edit();
    else if($register == 'Stage 1 edit')    //Stage 1 edit
        stage1_edit();
    else if($register == 'Stage 2 edit')    //Stage 2 edit
        stage2_edit();
    else if($register == 'change')      //reopens dialog box 
        dialog();
}
//Null element to load AJAX calls without returns
echo '<span id="null" style="display:none;"></span>';

echo $OUTPUT->footer();

?>
