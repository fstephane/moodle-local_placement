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


//This page deals with all the requests from viewuser.php


require_once('../../../config.php');
require_login(1, true);

global $DB, $CFG, $USER;

$choose = optional_param('choose', '0', PARAM_TEXT);    //Updates placement_students with their selected stage
$reg = optional_param('reg', '0', PARAM_TEXT);          //register an EDU stage student teacher
$reg2 = optional_param('reg2', '0', PARAM_TEXT);        //register a Stage 1 student teacher
$reg3 = optional_param('reg3', '0', PARAM_TEXT);        //register a Stage 2 student teacher
$rs = optional_param('rs', '0', PARAM_INT);             //Delete registration in order to change stage


//Delete registration in order to change stage
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


//Updates placement_students with their selected stage
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


//register an EDU stage student teacher
if($reg !== '0')
{
    $spec = optional_param('spec', '0', PARAM_INT);         //If 1, it shows that student has indicated a specific school preference
    $prefer = optional_param('prefer', '0', PARAM_INT);     //If 1, shows that student has indicated preferences
    $edit = optional_param('edit', '0', PARAM_TEXT);        //If 1, shows that student is editing information and not registering for the first time
    $stid = optional_param('stid', '0', PARAM_INT);         //student_teacher_id
    
    $regi = urldecode($reg);        //Decode string of information
    
    $regis = explode('|', $regi);   //Explode string into array
    
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
    $record->subject_preference = $regis[13];
    
    //Check which optional fields were filled out
    if(($spec !== '0') && ($pref == '0'))
        $record->specific_preference = $regis[14];
    else if(($spec == '0') && ($pref !== '0'))
        $record->preferences = $regis[14];
    else if(($spec !== '0') && ($pref !== '0'))
    {
        $record->specific_preference = $regis[14];
        $record->preferences = $regis[15];
    }
    
    //Generates a student teacher id that has not already been taken
    $studentid = 1;
        while($DB->get_record('placement_initial', array('student_teacher_id' => $studentid)))
            $studentid++;
        
    $record->student_teacher_id = $studentid;
    
    //Check if student is editing info or registering for the first time
    if($edit == 'false')
        $DB->insert_record('placement_initial', $record);
    else if($edit == 'true')
    {
        $ssid = $DB->get_record('placement_initial', array('student_teacher_id' => $stid));
        $record->id = $ssid->id;
        $record->student_teacher_id = $ssid->student_teacher_id;
        
        $DB->update_record('placement_initial', $record);
    }

    //update placement_students
    $studid = $DB->get_record('placement_students', array("userid" => $USER->id));
    $insert = new stdClass();
    $insert->id = $studid->id;
    $insert->registered = 1;
    
    $DB->update_record('placement_students', $insert);
}


//register a Stage 1 student teacher
if($reg2 !== '0')
{
    $rur = optional_param('rur', '0', PARAM_INT);           //If 1, shows that student has indicated they prefer a rural placement           
    $spec = optional_param('spec', '0', PARAM_INT);         //If 1, it shows that student has indicated a specific school preference      
    $prefer = optional_param('prefer', '0', PARAM_INT);     //If 1, shows that student has indicated preferences    
    $edit = optional_param('edit', '0', PARAM_TEXT);        //If 1, shows that student is editing information and not registering for the first time
    $stid = optional_param('stid', '0', PARAM_INT);         //student_teacher_id
    
    $regi = urldecode($reg2);       //Decode string of information
    
    $regis = explode('|', $regi);   //Explode string into array
    
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
    $record->subject_preference = $regis[13];
    $record->rural_placement = $regis[14];
    $record->initial_stage_teacher = $regis[15];
    $record->initial_stage_school = $regis[16];
    $record->initial_stage_level = $regis[17];
    
    //Generates a student teacher id that has not already been taken
    $studentid = 1;
        while(($DB->get_record('placement_initial', array('student_teacher_id' => $studentid))) || ($DB->get_record('placement_stage1', array('student_teacher_id' => $studentid))) || ($DB->get_record('placement_stage2', array('student_teacher_id' => $studentid))))
            $studentid++;
        
    $record->student_teacher_id = $studentid;
    
    //Check to see which optional fields were filled out
    if($rur !== 0)
    {
        if(($spec !== 0) && ($prefer !== 0))
        {
            $record->rural_location = $regis[18];
            $record->rural_scholarship = $regis[19];
            $record->rural_accomidation = $regis[20];
            $record->specific_preference = $regis[21];
            $record->preferences = $regis[22];
        }
        else if(($spec !== 0) && ($prefer == 0))
        {
            $record->rural_location = $regis[18];
            $record->rural_scholarship = $regis[19];
            $record->rural_accomidation = $regis[20];
            $record->specific_preference = $regis[21];
        }
        else if(($spec == 0) && ($prefer !== 0))
        {
            $record->rural_location = $regis[18];
            $record->rural_scholarship = $regis[19];
            $record->rural_accomidation = $regis[20];
            $record->preferences = $regis[21];
        }
        else
        {
            $record->rural_location = $regis[18];
            $record->rural_scholarship = $regis[19];
            $record->rural_accomidation = $regis[20];
        }
    }
    else
    {
        if(($spec !== 0) && ($prefer !== 0))
        {
            $record->specific_preference = $regis[18];
            $record->preferences = $regis[19];
        }
        else if(($spec !== 0) && ($prefer == 0))
        {
            $record->specific_preference = $regis[18];
        }
        else if(($spec == 0) && ($prefer !== 0))
        {
            $record->preferences = $regis[18];
        }
    }
    
    //Check if student is editing info or registering for the first time
        if($edit == 'false')
            $DB->insert_record('placement_stage1', $record);
        else if($edit == 'true')
        {
            $ssid = $DB->get_record('placement_stage1', array('student_teacher_id' => $stid));
            $record->id = $ssid->id;
            $record->student_teacher_id = $ssid->student_teacher_id;

            $DB->update_record('placement_stage1', $record);
        }
        
    //Update placement_students
    $studid = $DB->get_record('placement_students', array("userid" => $USER->id));
    $insert = new stdClass();
    $insert->id = $studid->id;
    $insert->registered = 1;
    
    $DB->update_record('placement_students', $insert);
}


//register a Stage 2 student teacher
if($reg3 !== '0')
{
    $rur = optional_param('rur', '0', PARAM_INT);           //If 1, shows that student has indicated they prefer a rural placement
    $spec = optional_param('spec', '0', PARAM_INT);         //If 1, it shows that student has indicated a specific school preference
    $prefer = optional_param('prefer', '0', PARAM_INT);     //If 1, shows that student has indicated preferences 
    $edit = optional_param('edit', '0', PARAM_TEXT);        //If 1, shows that student has indicated preferences 
    $stid = optional_param('stid', '0', PARAM_INT);         //student_teacher_id
    
    $regi = urldecode($reg3);       //Decode string of information
    
    $regis = explode('|', $regi);   //Explode string into array
    
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
    $record->subject_preference = $regis[13];
    $record->rural_placement = $regis[14];
    $record->initial_stage_teacher = $regis[15];
    $record->initial_stage_level = $regis[16];
    $record->initial_stage_school = $regis[17];
    $record->stage1_teacher = $regis[18];
    $record->stage1_school = $regis[19];
    $record->stage1_level = $regis[20];
    
    //Generate a student id that has not yet been chosen
    $studentid = 1;
        while(($DB->get_record('placement_initial', array('student_teacher_id' => $studentid))) || ($DB->get_record('placement_stage1', array('student_teacher_id' => $studentid))) || ($DB->get_record('placement_stage2', array('student_teacher_id' => $studentid))))
            $studentid++;
        
    $record->student_teacher_id = $studentid;
    
    //Check to see which optional fields have been filled out
    if($rur !== 0)
    {
        if(($spec !== 0) && ($prefer !== 0))
        {
            $record->rural_location = $regis[21];
            $record->rural_scholarship = $regis[22];
            $record->rural_accomidation = $regis[23];
            $record->specific_preference = $regis[24];
            $record->preferences = $regis[25];
        }
        else if(($spec !== 0) && ($prefer == 0))
        {
            $record->rural_location = $regis[21];
            $record->rural_scholarship = $regis[22];
            $record->rural_accomidation = $regis[23];
            $record->specific_preference = $regis[24];
        }
        else if(($spec == 0) && ($prefer !== 0))
        {
            $record->rural_location = $regis[21];
            $record->rural_scholarship = $regis[22];
            $record->rural_accomidation = $regis[23];
            $record->preferences = $regis[24];
        }
        else
        {
            $record->rural_location = $regis[21];
            $record->rural_scholarship = $regis[22];
            $record->rural_accomidation = $regis[23];
        }
    }
    else
    {
        if(($spec !== 0) && ($prefer !== 0))
        {
            $record->specific_preference = $regis[21];
            $record->preferences = $regis[22];
        }
        else if(($spec !== 0) && ($prefer == 0))
        {
            $record->specific_preference = $regis[21];
        }
        else if(($spec == 0) && ($prefer !== 0))
        {
            $record->preferences = $regis[21];
        }
    }
    
    //Check if student is editing info or registering for the first time
        if($edit == 'false')
            $DB->insert_record('placement_stage2', $record);
        else if($edit == 'true')
        {
            $ssid = $DB->get_record('placement_stage2', array('student_teacher_id' => $stid));
            $record->id = $ssid->id;
            $record->student_teacher_id = $ssid->student_teacher_id;

            $DB->update_record('placement_stage2', $record);
        }
        
    //Update placement_students
    $studid = $DB->get_record('placement_students', array("userid" => $USER->id));
    $insert = new stdClass();
    $insert->id = $studid->id;
    $insert->registered = 1;
    
    $DB->update_record('placement_students', $insert);
}
?>
