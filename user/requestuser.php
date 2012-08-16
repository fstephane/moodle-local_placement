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

require_once('../../../config.php');
require_login(1, true);

global $DB, $CFG, $USER;

$choose = optional_param('choose', '0', PARAM_TEXT);
$reg = optional_param('reg', '0', PARAM_TEXT);
$reg2 = optional_param('reg2', '0', PARAM_TEXT);
$reg3 = optional_param('reg3', '0', PARAM_TEXT);
$rs = optional_param('rs', '0', PARAM_INT);


if($rs !== '0')
{
    $stid = optional_param('stid', '0', PARAM_INT);
    
    switch($rs)
    {
        case '1':
            $DB->delete_records('placement_initial', array('student_teacher_id' => $stid));
            break;
        case '2':
            $DB->delete_records('placement_stage1', array('student_teacher_id' => $stid));
            break;
        case '3':
            $DB->delete_records('placement_stage2', array('student_teacher_id' => $stid));
            break;
    }
}


if($choose !== '0')
{
    $stud = $DB->get_record('user', array("id" => $USER->id));
    $stude = $DB->get_record('placement_students', array("userid" => $USER->id));
    
    $record = new stdCLass();
    $record->id = $stude->id;
    $record->userid = $USER->id;
    $record->firstname = $stud->firstname;
    $record->lastname = $stud->lastname;
    $record->registered = 0;
    $record->stage = urldecode($choose);
    
    $DB->update_record('placement_students', $record);
}


if($reg !== '0')
{
    $rur = optional_param('rur', '0', PARAM_INT);
    $spec = optional_param('spec', '0', PARAM_INT);
    $prefer = optional_param('prefer', '0', PARAM_INT);
    $edit = optional_param('edit', '0', PARAM_TEXT);
    $stid = optional_param('stid', '0', PARAM_INT);
    
    $regi = urldecode($reg);
    
    $regis = explode('|', $regi);
    
    $record = new stdClass();
    $record->stage = 'EDU E 331';
    $record->firstname = $regis[0];
    $record->lastname = $regis[1];
    $record->phone = $regis[2];
    $record->email = $regis[3];
    $record->address = $regis[4];
    $record->city = $regis[5];
    $record->onecard = $regis[6];
    $record->vehicle = $regis[7];
    $record->program = $regis[8];
    $record->type = $regis[9];
    $record->major = $regis[10];
    $record->minor = $regis[11];
    $record->schooltype = $regis[12];
    $record->rural_placement = $regis[13];
    
    $studentid = 1;
        while($DB->get_record('placement_initial', array('student_teacher_id' => $studentid)))
            $studentid++;
        
    $record->student_teacher_id = $studentid;
    
    if($rur !== 0)
    {
        if(($spec !== 0) && ($prefer !== 0))
        {
            $record->rural_location = $regis[14];
            $record->rural_scholarship = $regis[15];
            $record->rural_accomidation = $regis[16];
            $record->specific_preference = $regis[17];
            $record->preferences = $regis[18];
        }
        else if(($spec !== 0) && ($prefer == 0))
        {
            $record->rural_location = $regis[14];
            $record->rural_scholarship = $regis[15];
            $record->rural_accomidation = $regis[16];
            $record->specific_preference = $regis[17];
        }
        else if(($spec == 0) && ($prefer !== 0))
        {
            $record->rural_location = $regis[14];
            $record->rural_scholarship = $regis[15];
            $record->rural_accomidation = $regis[16];
            $record->preferences = $regis[17];
        }
        else
        {
            $record->rural_location = $regis[14];
            $record->rural_scholarship = $regis[15];
            $record->rural_accomidation = $regis[16];
        }
    }
    else
    {
        if(($spec !== 0) && ($prefer !== 0))
        {
            $record->specific_preference = $regis[14];
            $record->preferences = $regis[15];
        }
        else if(($spec !== 0) && ($prefer == 0))
        {
            $record->specific_preference = $regis[14];
        }
        else if(($spec == 0) && ($prefer !== 0))
        {
            $record->preferences = $regis[14];
        }
    }
    
    if($edit == 'false')
        $DB->insert_record('placement_initial', $record);
    else if($edit == 'true')
    {
        $ssid = $DB->get_record('placement_initial', array('student_teacher_id' => $stid));
        $record->id = $ssid->id;
        
        $DB->update_record('placement_initial', $record);
    }

    $studid = $DB->get_record('placement_students', array("userid" => $USER->id));
    $insert = new stdClass();
    $insert->id = $studid->id;
    $insert->registered = 1;
    
    $DB->update_record('placement_students', $insert);
}


if($reg2 !== '0')
{
    $rur = optional_param('rur', '0', PARAM_INT);
    $spec = optional_param('spec', '0', PARAM_INT);
    $prefer = optional_param('prefer', '0', PARAM_INT);
    $edit = optional_param('edit', '0', PARAM_TEXT);
    $stid = optional_param('stid', '0', PARAM_INT);
    
    $regi = urldecode($reg2);
    
    $regis = explode('|', $regi);
    
    $record = new stdClass();
    $record->stage = 'Stage 1';
    $record->firstname = $regis[0];
    $record->lastname = $regis[1];
    $record->phone = $regis[2];
    $record->email = $regis[3];
    $record->address = $regis[4];
    $record->city = $regis[5];
    $record->onecard = $regis[6];
    $record->vehicle = $regis[7];
    $record->program = $regis[8];
    $record->type = $regis[9];
    $record->major = $regis[10];
    $record->minor = $regis[11];
    $record->schooltype = $regis[12];
    $record->rural_placement = $regis[13];
    $record->initial_stage_teacher = $regis[14];
    $record->initial_stage_school = $regis[15];
    $record->initial_stage_level = $regis[16];
    
    $studentid = 1;
        while(($DB->get_record('placement_initial', array('student_teacher_id' => $studentid))) || ($DB->get_record('placement_stage1', array('student_teacher_id' => $studentid))) || ($DB->get_record('placement_stage2', array('student_teacher_id' => $studentid))))
            $studentid++;
        
    $record->student_teacher_id = $studentid;
    
    if($rur !== 0)
    {
        if(($spec !== 0) && ($prefer !== 0))
        {
            $record->rural_location = $regis[17];
            $record->rural_scholarship = $regis[18];
            $record->rural_accomidation = $regis[19];
            $record->specific_preference = $regis[20];
            $record->preferences = $regis[21];
        }
        else if(($spec !== 0) && ($prefer == 0))
        {
            $record->rural_location = $regis[17];
            $record->rural_scholarship = $regis[18];
            $record->rural_accomidation = $regis[19];
            $record->specific_preference = $regis[20];
        }
        else if(($spec == 0) && ($prefer !== 0))
        {
            $record->rural_location = $regis[17];
            $record->rural_scholarship = $regis[18];
            $record->rural_accomidation = $regis[19];
            $record->preferences = $regis[20];
        }
        else
        {
            $record->rural_location = $regis[17];
            $record->rural_scholarship = $regis[18];
            $record->rural_accomidation = $regis[19];
        }
    }
    else
    {
        if(($spec !== 0) && ($prefer !== 0))
        {
            $record->specific_preference = $regis[17];
            $record->preferences = $regis[18];
        }
        else if(($spec !== 0) && ($prefer == 0))
        {
            $record->specific_preference = $regis[17];
        }
        else if(($spec == 0) && ($prefer !== 0))
        {
            $record->preferences = $regis[17];
        }
    }
    
        if($edit == 'false')
            $DB->insert_record('placement_stage1', $record);
        else if($edit == 'true')
        {
            $ssid = $DB->get_record('placement_stage1', array('student_teacher_id' => $stid));
            $record->id = $ssid->id;

            $DB->update_record('placement_stage1', $record);
        }
        
        $studid = $DB->get_record('placement_students', array("userid" => $USER->id));
    $insert = new stdClass();
    $insert->id = $studid->id;
    $insert->registered = 1;
    
    $DB->update_record('placement_students', $insert);
}


if($reg3 !== '0')
{
    $rur = optional_param('rur', '0', PARAM_INT);
    $spec = optional_param('spec', '0', PARAM_INT);
    $prefer = optional_param('prefer', '0', PARAM_INT);
    $edit = optional_param('edit', '0', PARAM_TEXT);
    $stid = optional_param('stid', '0', PARAM_INT);
    
    $regi = urldecode($reg3);
    
    $regis = explode('|', $regi);
    
    $record = new stdClass();
    $record->stage = 'Stage 2';
    $record->firstname = $regis[0];
    $record->lastname = $regis[1];
    $record->phone = $regis[2];
    $record->email = $regis[3];
    $record->address = $regis[4];
    $record->city = $regis[5];
    $record->onecard = $regis[6];
    $record->vehicle = $regis[7];
    $record->program = $regis[8];
    $record->type = $regis[9];
    $record->major = $regis[10];
    $record->minor = $regis[11];
    $record->schooltype = $regis[12];
    $record->rural_placement = $regis[13];
    $record->initial_stage_teacher = $regis[14];
    $record->initial_stage_level = $regis[15];
    $record->initial_stage_school = $regis[16];
    $record->stage1_teacher = $regis[17];
    $record->stage1_level = $regis[18];
    $record->stage1_school = $regis[19];
    
    $studentid = 1;
        while(($DB->get_record('placement_initial', array('student_teacher_id' => $studentid))) || ($DB->get_record('placement_stage1', array('student_teacher_id' => $studentid))) || ($DB->get_record('placement_stage2', array('student_teacher_id' => $studentid))))
            $studentid++;
        
    $record->student_teacher_id = $studentid;
    
    if($rur !== 0)
    {
        if(($spec !== 0) && ($prefer !== 0))
        {
            $record->rural_location = $regis[20];
            $record->rural_scholarship = $regis[21];
            $record->rural_accomidation = $regis[22];
            $record->specific_preference = $regis[23];
            $record->preferences = $regis[24];
        }
        else if(($spec !== 0) && ($prefer == 0))
        {
            $record->rural_location = $regis[20];
            $record->rural_scholarship = $regis[21];
            $record->rural_accomidation = $regis[22];
            $record->specific_preference = $regis[23];
        }
        else if(($spec == 0) && ($prefer !== 0))
        {
            $record->rural_location = $regis[20];
            $record->rural_scholarship = $regis[21];
            $record->rural_accomidation = $regis[22];
            $record->preferences = $regis[23];
        }
        else
        {
            $record->rural_location = $regis[20];
            $record->rural_scholarship = $regis[21];
            $record->rural_accomidation = $regis[22];
        }
    }
    else
    {
        if(($spec !== 0) && ($prefer !== 0))
        {
            $record->specific_preference = $regis[20];
            $record->preferences = $regis[21];
        }
        else if(($spec !== 0) && ($prefer == 0))
        {
            $record->specific_preference = $regis[20];
        }
        else if(($spec == 0) && ($prefer !== 0))
        {
            $record->preferences = $regis[20];
        }
    }
    
        if($edit == 'false')
            $DB->insert_record('placement_stage2', $record);
        else if($edit == 'true')
        {
            $ssid = $DB->get_record('placement_stage2', array('student_teacher_id' => $stid));
            $record->id = $ssid->id;

            $DB->update_record('placement_stage2', $record);
        }
        
        $studid = $DB->get_record('placement_students', array("userid" => $USER->id));
    $insert = new stdClass();
    $insert->id = $studid->id;
    $insert->registered = 1;
    
    $DB->update_record('placement_students', $insert);
}
?>
