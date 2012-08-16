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
require('../lib/lib.php');

global $DB, $CFG, $USER;

require_login(1, true);
$context = get_context_instance(CONTEXT_USER, $USER->id);

$PAGE->set_url($CFG->wwwroot.'/local/placement/admin/view.php');
$PAGE->set_context($context);
$PAGE->set_pagelayout('standard');
$PAGE->set_title(get_string('placement', 'local_placement'));
$PAGE->set_heading(get_string('placement', 'local_placement'));

$PAGE->requires->js('/local/placement/js/jquery.js');
$PAGE->requires->js('/local/placement/js/jquery.min.js');
$PAGE->requires->js('/local/placement/js/scriptadmin.js');
$PAGE->requires->js('/local/placement/js/validate.js');
$PAGE->requires->js('/local/placement/js/jquery.ui.js');
$PAGE->requires->js('/local/placement/js/jquery.ui.draggable.min.js');
$PAGE->requires->js('/local/placement/js/jquery.ui.droppable.min.js');
$PAGE->requires->css('/local/placement/css/style.css');
$PAGE->requires->css('/local/placement/css/jquery.ui.css');
$PAGE->requires->css('/local/placement/css/validate.css');
        
//echo '<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>';
echo $OUTPUT->header();

//$DB->delete_records('placement_student_teacher', array("id" => 433));
//$DB->delete_records('placement_users', array("id" => 6));
//$DB->delete_records('user', array("id" => 60));

if (!has_capability('local/placement:manage',$context)) {
        print_string('norights','local_placement');
        } else {
        $view = optional_param('view', '0', PARAM_TEXT);    
            
        if($view == 'admin')
            admin_tool();
        else if($view == 'tool')
            placement();

        echo '<span id="null" style="display:none;"></span>';
}
echo $OUTPUT->footer();

?>
