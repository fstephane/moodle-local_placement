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

//This page takes care of all the principal's features
//if viewprincipal.php?view=admin, admin page is displayed
//if viewprincipal.php?view=editschool, school editing form is displayed
//if viewprincipal.php?view=add, add teacher form is displayed
//if viewprincipal.php?view=edit, edit teacher form is displayed

require('../config.php');
require('../lib/libprincipal.php');

global $DB, $CFG, $USER;

require_login(1, true);
$context = get_context_instance(CONTEXT_USER, $USER->id);

$PAGE->set_url($CFG->wwwroot.'/local/placement/user/viewprincipal.php');
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('placement', 'local_placement'));
$PAGE->set_heading(get_string('placement', 'local_placement'));

$PAGE->requires->js('/local/placement/js/jquery.js');
$PAGE->requires->js('/local/placement/js/jquery.min.js');
$PAGE->requires->js('/local/placement/js/scriptprincipal.js');
$PAGE->requires->js('/local/placement/js/validate.js');
$PAGE->requires->js('/local/placement/js/jquery.ui.js');
$PAGE->requires->css('/local/placement/css/style.css');
$PAGE->requires->css('/local/placement/css/jquery.ui.css');
$PAGE->requires->css('/local/placement/css/validate.css');
        
echo $OUTPUT->header();

//if principal is in the placement_users table, then continue
if($DB->get_record('placement_users', array("userid" => $USER->id)))
{
    //If principal has not yet been confirmed, open the dialog box where they can enter their information
    if($DB->get_record('placement_users', array("userid" => $USER->id, "confirmed" => 0)))
    {
        dialog();
    }
    else
    {
        $view = optional_param('view', '0', PARAM_TEXT);

        if($view !== '0')
        {
            if($view == 'admin')        //admin page
            {
                admin_view();
            }
            else if($view == 'editschool')  //edit school form
            {
                edit_school_view();
            }
            else if($view == 'add')     //add teacher form
            {
                add_view();
            }
            else if($view == 'edit')    //edit teacher form
            {
                $id = optional_param('id', '0', PARAM_INT);
                edit_view($id);
            }
            //Null element for loading ajax calls without returns
            echo '<span id="null" style="display:none;"></span>';
        }   
    }
}
else
    echo 'Not in database';
echo $OUTPUT->footer();
?>
