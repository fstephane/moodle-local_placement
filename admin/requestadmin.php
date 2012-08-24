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

//This page deals with all AJAX calls from viewadmin.php

require_once('../../../config.php');
require_login(1, true);

global $DB, $CFG, $USER;

$addp = optional_param('addp', '0', PARAM_TEXT);        //Add a principal - creates a user account. Principals fill in their own information regarding their schools and teachers
$adds = optional_param('adds', '0', PARAM_TEXT);        //Add a student - creates a user account. Students fill out their own registration forms
$stud = optional_param('stud', '0', PARAM_INT);         //Populate a box on the placement tool with student information when a student's name is selected
$teac = optional_param('teac', '0', PARAM_INT);         //Populate a box on the placement tool with teacher/school information when a teacher's name is selected
$tab = optional_param('tab', '0', PARAM_INT);           //Generate a new list of students depending on which stage is chosen
$tb = optional_param('tb', '0', PARAM_INT);             //Generate a new list of teachers depending on which stage is chosen
$match = optional_param('match', '0', PARAM_INT);       //Match a student with a teacher
$unmatch = optional_param('unmatch', '0', PARAM_INT);   //Unmatch a teacher with their prospective student teacher
$load = optional_param('load', '0', PARAM_INT);         //Load new list of students after match/unmatch


//Load new list of students after match/unmatch
if($load !== '0')
{
    switch($load)
    {
        case '1':
            $students = $DB->get_records_sql('SELECT i.student_teacher_id, i.firstname, i.lastname, m.student_first_name FROM mdl_placement_initial as i
                                    LEFT JOIN mdl_placement_matches as m ON i.student_teacher_id=m.student_teacher_id
                                    ORDER BY lastname, firstname');
            break;
        case '2':
            $students = $DB->get_records_sql('SELECT i.student_teacher_id, i.firstname, i.lastname, m.student_first_name FROM mdl_placement_stage1 as i
                                    LEFT JOIN mdl_placement_matches as m ON i.student_teacher_id=m.student_teacher_id
                                    ORDER BY lastname, firstname');
            break;
        case '3':
            $students = $DB->get_records_sql('SELECT i.student_teacher_id, i.firstname, i.lastname, m.student_first_name FROM mdl_placement_stage2 as i
                                    LEFT JOIN mdl_placement_matches as m ON i.student_teacher_id=m.student_teacher_id
                                    ORDER BY lastname, firstname');
            break;
    }
    //Display new list of students
    foreach($students as $s)
    {
        if(!isset($s->student_first_name))
            echo '<div onclick="select_student(this);" class="student" id="'.$s->student_teacher_id.'" style="background-color:white;">'.$s->firstname.' '.$s->lastname.'</div>';
    }
}


//Unmatch a teacher with their prospective student teacher
if($unmatch !== '0')
{
    $DB->delete_records('placement_matches', array('coopid' => $unmatch));
}

//Match a student with a teacher
if($match !== '0')
{
    $sid = optional_param('sid', '0', PARAM_INT);
    $stage = optional_param('stage', '0', PARAM_INT);
    $num = optional_param('num', '0', PARAM_INT);
    
    switch($stage)
    {
        case 1: 
            $stu = $DB->get_record('placement_initial', array('student_teacher_id' => $sid));
            $stage = 'EDU E 331';
            break;
        case 2:
            $stu = $DB->get_record('placement_stage1', array('student_teacher_id' => $sid));
            $stage = 'Stage 1';
            break;
        case 3:
            $stu = $DB->get_record('placement_stage2', array('student_teacher_id' => $sid));
            $stage = 'Stage 2';
            break;
    }
    
    $tea = $DB->get_record('placement_coop_teachers', array('coopid' => $match));
    //Delete previous match
    $DB->delete_records('placement_matches', array('coopid' => $match));
    
    $record = new stdClass();
    $record->teacher_first_name = $tea->firstname;
    $record->teacher_last_name = $tea->lastname;
    $record->student_first_name = $stu->firstname;
    $record->student_last_name = $stu->lastname;
    $record->matches = $num;
    $record->school = $tea->school;
    $record->stage = $stage;
    $record->student_teacher_id = $sid;
    $record->coopid = $match;
    
    $DB->insert_record('placement_matches', $record);
    
    //Display student name in box below teacher name
    echo '<span onclick="student2();" style="color:blue;">'.$stu->firstname.' '.$stu->lastname.'</span>';
}

//Generate a new list of teachers depending on which stage is chosen
if($tb !== '0')
{
    if($tb == '1')
    {
        $schools = $DB->get_records_sql("SELECT DISTINCT s.school, s.schoolid
                                        FROM mdl_placement_school AS s
                                        JOIN mdl_placement_coop_teachers AS t
                                        ON t.schoolid=s.schoolid
                                        WHERE lower(t.stage) LIKE 'edu%' ORDER BY s.school");

        $teachers = $DB->get_records_sql("SELECT t.coopid, t.firstname, t.lastname, t.schoolid, t.school, m.student_first_name, m.student_last_name, m.student_teacher_id FROM mdl_placement_coop_teachers AS t 
                                        LEFT JOIN mdl_placement_matches as m ON m.coopid=t.coopid
                                        WHERE lower(t.stage) LIKE 'edu%' ORDER BY t.lastname, t.firstname");
    }
    else if($tb == '2')
    {
        $schools = $DB->get_records_sql("SELECT DISTINCT s.school, s.schoolid
                                        FROM mdl_placement_school AS s
                                        JOIN mdl_placement_coop_teachers AS t
                                        ON t.schoolid=s.schoolid
                                        WHERE lower(t.stage)='stage 1' ORDER BY s.school");

        $teachers = $DB->get_records_sql("SELECT t.coopid, t.firstname, t.lastname, t.schoolid, t.school, m.student_first_name, m.student_last_name, m.student_teacher_id 
                                        FROM mdl_placement_coop_teachers AS t 
                                        LEFT JOIN mdl_placement_matches as m ON m.coopid=t.coopid
                                        WHERE lower(t.stage)='stage 1' ORDER BY t.lastname, t.firstname");
    }
    else if($tb == '3')
    {
        $schools = $DB->get_records_sql("SELECT DISTINCT s.school, s.schoolid
                                        FROM mdl_placement_school AS s
                                        JOIN mdl_placement_coop_teachers AS t
                                        ON t.schoolid=s.schoolid
                                        WHERE lower(t.stage)='stage 2' ORDER BY s.school");

        $teachers = $DB->get_records_sql("SELECT t.coopid, t.firstname, t.lastname, t.schoolid, t.school, m.student_first_name, m.student_last_name, m.student_teacher_id 
                                        FROM mdl_placement_coop_teachers AS t 
                                        LEFT JOIN mdl_placement_matches as m ON m.coopid=t.coopid
                                        WHERE lower(t.stage)='stage 2' ORDER BY t.lastname, t.firstname");
    }
    //Display teacher/school information
    foreach($schools as $s)
    {
        echo '<p id="'.$s->schoolid.'" class="school">'.$s->school.'</p>';
        foreach($teachers as $t)
        {
            if($t->schoolid == $s->schoolid)
            {
                if($t->student_first_name == '')
                    echo '<div id="n" onclick="select_teacher(this);" class="teach" lang="'.$t->coopid.'" xml:lang="'.$s->schoolid.'">';
                else
                    echo '<div id="y" onclick="select_teacher(this);" class="teach" lang="'.$t->coopid.'" xml:lang="'.$s->schoolid.'">';
                echo '<div class="teacher" style="font-weight:bold;background-color:white;padding-left:20px;" id="t'.$t->coopid.'">'.$t->firstname.' '.$t->lastname.'</div>';
                echo '<div align="center" id="'.$t->firstname.' '.$t->lastname.'" class="teacherbox"><span id="$sid" onclick="student2();" style="color:blue;">'.$t->student_first_name.' '.$t->student_last_name.'</span></div><br/>';
                echo '</div>';
            }
        }
    }
}

//Generate a new list of students depending on which stage is chosen
if($tab !== '0')
{
    if($tab == '1')
        $students = $DB->get_records('placement_initial', array(), 'lastname, firstname');
    else if($tab == '2')
        $students = $DB->get_records('placement_stage1', array(), 'lastname, firstname');
    else if($tab == '3')
        $students = $DB->get_records('placement_stage2', array(), 'lastname, firstname');
    //Display student information
    foreach($students as $s)
    {
        echo '<div onclick="select_student(this);" class="student" id="'.$s->student_teacher_id.'" style="background-color:white;">'.$s->firstname.' '.$s->lastname.'</div>';
    }
}

//Populate a box on the placement tool with teacher/school information when a teacher's name is selected
if($teac !== '0')
{
    $stage = optional_param('stage', '0', PARAM_INT);
    $match = $DB->get_record('placement_matches', array('coopid' => $teac));
    
    switch($stage)
    {
        case 1:
            $t = $DB->get_record_sql("SELECT * FROM mdl_placement_coop_teachers as t
                                    WHERE coopid=".$teac." AND lower(t.stage) LIKE 'edu%'");
            $s = $DB->get_record('placement_school', array('schoolid' => $t->schoolid));
            break;
        case 2:
            $t = $DB->get_record('placement_coop_teachers', array("coopid" => $teac));
            $s = $DB->get_record('placement_school', array('schoolid' => $t->schoolid));
            break;
        case 3:
            $t = $DB->get_record('placement_coop_teachers', array("coopid" => $teac));
            $s = $DB->get_record('placement_school', array('schoolid' => $t->schoolid));
            break;
    }
    ?>
    <span style="font-weight:bold;font-size:20px;text-decoration:underline;"><?php echo $t->firstname.' '.$t->lastname; ?></span><br/>
    <!--IF MATCH IS DISPLAYED, SHORTEN INFO SECTION BENEATH-->
    <?php if($match)
    {?>
    <div id="<?php echo 'c'.$match->coopid; ?>" class="current"><span style="color:dimgrey;font-weight:bold;"><?php echo get_string('current', 'local_placement'); ?>: </span><span style="color:blue;"><?php echo $match->student_first_name.' '.$match->student_last_name; ?></span></div>
    <?php } ?>
    <hr/>
    <?php if($match)
    {?>
        <div style="overflow-y:scroll;height:145px;">
    <?php }else{ ?>
        <div style="overflow-y:scroll;height:165px;">
    <?php } ?>
    <table>
        <tr>
            <!--ELEMENTARY/SECONDARY-->
            <td style="width:130px;">
                <span style="font-weight:bold;"><?php echo get_string('schoollev', 'local_placement'); ?>:</span><br/>
            </td>
            <td style="width:130px;">
                <span id="level"><?php echo $t->type; ?></span><br/>
            </td>
        </tr>
        <tr>
            <!--CATHOLIC/PUBLIC-->
            <td>
                <span style="font-weight:bold;"><?php echo get_string('schooltype', 'local_placement'); ?>:</span><br/>
            </td>
            <td>
                <span id="type"><?php echo $s->school_type; ?></span><br/>
            </td>
        </tr>
        <tr>
            <!--FRANCOPHONE/IMMERSION-->
            <td>
                <span style="font-weight:bold;"><?php echo get_string('langpro', 'local_placement'); ?>:</span><br/>
            </td>
            <td>
                <span id="program"><?php echo $s->program; ?></span><br/>
            </td>
        </tr>
        <tr>
            <!--CORE SUBJECTS TAUGHT-->
            <td>
                <span style="font-weight:bold;"><?php echo get_string('core', 'local_placement'); ?>:</span><br/>
            </td>
            <td>
                <span id="core"><?php echo $t->subjects; ?></span><br/>
            </td>
        </tr>
        <tr>
            <!--PREFERENCES-->
            <td>
                <span style="font-weight:bold;"><?php echo get_string('pref', 'local_placement'); ?>:</span><br/>
            </td>
            <td>
                <span id="pref"><?php echo $t->preferences; ?></span><br/>
            </td>
        </tr>
    </table>
    </div>
    <?php
}

//Populate a box on the placement tool with student information when a student's name is selected
if($stud !== '0')
{
    $stage = optional_param('stage', '0', PARAM_INT);
    
    switch($stage)
    {
        case 1:
            $st = $DB->get_record('placement_initial', array("student_teacher_id" => $stud));
            break;
        case 2:
            $st = $DB->get_record('placement_stage1', array("student_teacher_id" => $stud));
            break;
        case 3:
            $st = $DB->get_record('placement_stage2', array("student_teacher_id" => $stud));
            break;
    }
    ?>
    <span style="font-weight:bold;font-size:20px;text-decoration:underline;"><?php echo $st->firstname.' '.$st->lastname; ?></span><br/>
    <span style="font-size:18px;color:dimgrey;">  <?php echo get_string('pref', 'local_placement'); ?>:</span><hr/>
    <div style="overflow-y:scroll;height:145px;">
    <table>
        <tr>
            <!--ELEMENTARY/SECONDARY-->
            <td style="width:130px;">
                <span style="font-weight:bold;"><?php echo get_string('schoollev', 'local_placement'); ?>:</span><br/>
            </td>
            <td style="width:130px;">
                <span id="levpref"><?php echo $st->type; ?></span><br/>
            </td>
        </tr>
        <tr>
            <!--CATHOLIC/PUBLIC-->
            <td>
                <span style="font-weight:bold;"><?php echo get_string('schooltype', 'local_placement'); ?>:</span><br/>
            </td>
            <td>
                <span id="typepref"><?php echo $st->schooltype; ?></span><br/>
            </td>
        </tr>
        <tr>
            <!--FRANCOPHONE/IMMERSION-->
            <td>
                <span style="font-weight:bold;"><?php echo get_string('langpro', 'local_placement'); ?>:</span><br/>
            </td>
            <td>
                <span id="programpref"><?php echo $st->program; ?></span><br/>
            </td>
        </tr>
        <tr>
            <!--CORE SUBJECTS PREFERENCE-->
            <td>
                <span style="font-weight:bold;"><?php echo get_string('subjectpref', 'local_placement'); ?>:</span><br/>
            </td>
            <td>
                <span id="subpref"><?php echo $st->subject_preference; ?></span><br/>
            </td>
        </tr>
        <tr>
            <!--OTHER PREFERENCES-->
            <td>
                <span style="font-weight:bold;"><?php echo get_string('otherpref', 'local_placement'); ?>:</span><br/>
            </td>
            <td>
                <span id="otherpref"><?php echo $st->preferences; ?></span><br/>
            </td>
        </tr>
    </table>
    </div>
    <?php
}

//Add a principal - creates a user account. Principals fill in their own information regarding their schools and teachers
if($addp !== '0')
{
    $p = urldecode($addp);
    $ap = explode('|', $p);
    
    $user = new stdClass();
    $user->auth = 'manual';
    $user->confirmed = 1;
    $user->policyagreed = 0;
    $user->deleted = 0;
    $user->suspended = 0;
    $user->mnethostid = 1;
    $user->username = $ap[2];
    $user->password = 'changeme';
    $user->idnumber = '';
    $user->firstname = $ap[0];
    $user->lastname = $ap[1];
    $user->email = $ap[2];
    $user->emailstop = 0;
    $user->icq = '';
    $user->skype = '';
    $user->yahoo = '';
    $user->aim = '';
    $user->msn = '';
    $user->phone1 = '';
    $user->phone2 = '';
    $user->institution = '';
    $user->department = '';
    $user->address = '';
    $user->city = '';
    $user->country = 'CA';
    $user->lang = '';
    $user->theme = '';
    $user->timezone = 99;
    $user->firstaccess = time();
    $user->lastaccess = 0;
    $user->lastlogin = 0;
    $user->curentlogin = time();
    $user->lastip = '127.0.0.1';
    $user->secret = '';
    $user->picture = 0;
    $user->url = '';
    $user->description = '';
    $user->descriptioninfo = 1;
    $user->mailformat = 1;
    $user->maildigest = 0;
    $user->maildisplay = 2;
    $user->htmleditor = 1;
    $user->ajax = 0;
    $user->autosubscribe = 1;
    $user->trackforums = 0;
    $user->timecreated = time();
    $user->timemodified = time();
    $user->trustbitmask = 0;
    $user->imagealt = '';
    $user->screenreader = 0;
    
    user_create_user($user);
    
    $ui = $DB->get_record('user', array('email' => $ap[2]));
    
    $record = new stdClass();
    $record->userid = $ui->id;
    $record->firstname = $ap[0];
    $record->lastname = $ap[1];
    $record->confirmed = 0;
    
    $DB->insert_record('placement_users', $record);
}

//Add a student - creates a user account. Students fill out their own registration forms
if($adds !== '0')
{
    $s = urldecode($adds);
    $as = explode('|', $s);
    
    $user = new stdClass();
    $user->auth = 'manual';
    $user->confirmed = 1;
    $user->policyagreed = 0;
    $user->deleted = 0;
    $user->suspended = 0;
    $user->mnethostid = 1;
    $user->username = $as[2];
    $user->password = 'changeme';
    $user->idnumber = '';
    $user->firstname = $as[0];
    $user->lastname = $as[1];
    $user->email = $as[2];
    $user->emailstop = 0;
    $user->icq = '';
    $user->skype = '';
    $user->yahoo = '';
    $user->aim = '';
    $user->msn = '';
    $user->phone1 = '';
    $user->phone2 = '';
    $user->institution = '';
    $user->department = '';
    $user->address = '';
    $user->city = '';
    $user->country = 'CA';
    $user->lang = '';
    $user->theme = '';
    $user->timezone = 99;
    $user->firstaccess = time();
    $user->lastaccess = 0;
    $user->lastlogin = 0;
    $user->curentlogin = time();
    $user->lastip = '127.0.0.1';
    $user->secret = '';
    $user->picture = 0;
    $user->url = '';
    $user->description = '';
    $user->descriptioninfo = 1;
    $user->mailformat = 1;
    $user->maildigest = 0;
    $user->maildisplay = 2;
    $user->htmleditor = 1;
    $user->ajax = 0;
    $user->autosubscribe = 1;
    $user->trackforums = 0;
    $user->timecreated = time();
    $user->timemodified = time();
    $user->trustbitmask = 0;
    $user->imagealt = '';
    $user->screenreader = 0;
    
    user_create_user($user);
    
    $ui = $DB->get_record('user', array('firstname' => $as[0]));
    
    $record = new stdClass();
    $record->userid = $ui->id;
    $record->firstname = $as[0];
    $record->lastname = $as[1];
    $record->registered = 0;
    
    $DB->insert_record('placement_students', $record);
}

//This function was in an external library, so I copied it here. It does NOT send a confirmation email
function user_create_user($user) {
    global $DB;

    // set the timecreate field to the current time
    if (!is_object($user)) {
            $user = (object)$user;
    }

    // save the password in a temp value for later
    if (isset($user->password)) {
        $userpassword = $user->password;
        unset($user->password);
    }

    $user->timecreated = time();
    $user->timemodified = $user->timecreated;

    // insert the user into the database
    $newuserid = $DB->insert_record('user', $user);

    // trigger user_created event on the full database user row
    $newuser = $DB->get_record('user', array('id' => $newuserid));
    events_trigger('user_created', $newuser);

    // create USER context for this user
    get_context_instance(CONTEXT_USER, $newuserid);

    // update user password if necessary
    if (isset($userpassword)) {
        update_internal_user_password($newuser, $userpassword);
    }

    return $newuserid;

}
?>
