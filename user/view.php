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
require('../lib/libuser.php');

global $DB, $CFG, $USER;

require_login(1, true);
$context = get_context_instance(CONTEXT_USER, $USER->id);

$PAGE->set_url($CFG->wwwroot.'/local/placement/user/view.php');
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
        
//echo '<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>';
echo $OUTPUT->header();

//$DB->delete_records('placement_students', array("id" => 4));

$register = optional_param('register', '0', PARAM_TEXT);
$info = $DB->get_record('user', array('id' => $USER->id));


if($register == '0')
{
    if($DB->get_record('placement_students', array("userid" => $USER->id, "registered" => 0)))
    {
        dialog();
    }   
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
    if($register == 'EDU E 331')
    {
        initial();
    }
    else if($register == 'Stage 1')
    {
        stage1();
    }
    else if($register == 'Stage 2')
    {
        stage2();
    }
    else if($register == 'EDU E 331 edit')
    {
        initial_edit();
    }
    else if($register == 'Stage 1 edit')
    {
        stage1_edit();
    }
    else if($register == 'Stage 2 edit')
    {
        stage2_edit();
    }
    else if($register == 'change')
    {
        dialog();
    }
}
echo '<span id="null" style="display:none;"></span>';

echo $OUTPUT->footer();

?>
