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


//This page takes care of all the administrative features.
//If viewadmin.php?view=admin, page calls the admin page in libadmin.php, where you can add student teachers and prinicipals of schools as users on Moodle.
//If viewadmin.php?view=tool, page calls the placement tool in libadmin.php where you can match students to schools


require('../config.php');
require('../lib/libadmin.php');

global $DB, $CFG, $USER;

require_login(1, true);
$context = get_context_instance(CONTEXT_USER, $USER->id);

$PAGE->set_url($CFG->wwwroot.'/local/placement/admin/viewadmin.php');
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('placement', 'local_placement'));
$PAGE->set_heading(get_string('placement', 'local_placement'));

$PAGE->requires->js('/local/placement/js/jquery.js');
$PAGE->requires->js('/local/placement/js/jquery.min.js');
$PAGE->requires->js('/local/placement/js/scriptadmin.js');
$PAGE->requires->js('/local/placement/js/validate.js');
$PAGE->requires->js('/local/placement/js/jquery.ui.js');
$PAGE->requires->css('/local/placement/css/style.css');
$PAGE->requires->css('/local/placement/css/jquery.ui.css');
$PAGE->requires->css('/local/placement/css/validate.css');

echo $OUTPUT->header();

//Needs management capability
if (!has_capability('local/placement:manage',$context)) {
        print_string('norights','local_placement');
        } else {
        $view = optional_param('view', '0', PARAM_TEXT);    
    //Admin page - add users
        if($view == 'admin')
            admin();
    //Placement tool - match students with teachers
        else if($view == 'tool')
            placement();
    //null element used to load AJAX calls with no return
        echo '<span id="null" style="display:none;"></span>';
}
echo $OUTPUT->footer();

?>
