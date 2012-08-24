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


//This page handles the AJAX calls from viewprincipal.php


require_once('../../../config.php');
require_login(1, true);

global $DB, $CFG, $USER;

$addt = optional_param('addt', '0', PARAM_TEXT);        //Add a teacher
$editt = optional_param('editt', '0', PARAM_TEXT);      //Edit a teacher's info
$sb = optional_param('sb', '0', PARAM_TEXT);            //Displays the school board of an existing school on the new principal dialog box
$prin = optional_param('prin', '0', PARAM_TEXT);        //Saves information from new principal dialog box
$school = optional_param('school', '0', PARAM_TEXT);    //Saves school information
$remove = optional_param('remove', '0', PARAM_INT);     //Remove a teacher

//Remove a teacher
if($remove !== '0')
{
    $email = $DB->get_record('placement_coop_teachers', array("id" => $remove));
    
    $user = $DB->get_record('user', array('email' => $email->email));
    
    user_delete_user($user);
    
    $DB->delete_records('placement_coop_teachers', array("id" => $remove));
    $DB->delete_records('user', array('email' => $email->email));
}

//Saves school information
if($school !== '0')
{
    $sinfo = urldecode($school);
    $sarray = explode('|', $sinfo);
    
    $sc = $DB->get_record('placement_users', array('userid' => $USER->id));
    $schoid = $DB->get_record('placement_school', array('schoolid' => $sc->schoolid));
    
    $record = new stdClass();
    $record->id = $schoid->id;
    $record->school = $sarray[0];
    $record->address = $sarray[1];
    $record->city = $sarray[2];
    $record->phone = $sarray[3];
    $record->province = $sarray[4];
    $record->postalcode = $sarray[5];
    $record->principalfirstname = $sarray[6];
    $record->principallastname = $sarray[7];
    $record->email = $sarray[8];
    $record->principalphone = $sarray[9];
    $record->contactfirstname = $sarray[10];
    $record->contactlastname = $sarray[11];
    $record->contactphone = $sarray[12];
    $record->fax = $sarray[13];
    $record->contactemail = $sarray[14];
    $record->contactlang = $sarray[15];
    $record->contactsex = $sarray[16];
    $record->schoolboard = $sarray[17];
    $record->program = $sarray[18];
    $record->website = $sarray[19];
    $record->zone = $sarray[20];
    $record->school_type = $sarray[21];
    $record->school_level = $sarray[22];
    
    $DB->update_record('placement_school', $record);
    
    $info = $DB->get_record('placement_users', array("userid" => $USER->id));
    
    $insert = new stdClass();
    $insert->id = $info->id;
    $insert->lastname = $sarray[7];
    $insert->firstname = $sarray[6];
    $insert->schoolboard = $sarray[17];
    $insert->school = $sarray[0];
    $insert->schoolid = $sc->schoolid;
    $insert->userid = $sc->userid;
    
    $DB->update_record('placement_users', $insert);
}

//Saves information from new principal dialog box
if($prin !== '0')
{
    $newb = optional_param('newboard', '0', PARAM_INT);
    $news = optional_param('newschool', '0', PARAM_INT);
    
    $info = explode('|', $prin);
    
    if($news == 1)
    {
        $schoolid = 1;
        while($DB->get_record('placement_school', array('schoolid' => $schoolid)))
            $schoolid++;

        $record = new stdClass();
        $record->school = $info[4];
        $record->email = $info[2];
        $record->principallastname = $info[1];
        $record->principalfirstname = $info[0];
        $record->schoolboard = $info[3];
        $record->principalsex = $info[5];
        $record->principallang = $info[6];
        $record->schoolid = $schoolid;

        $DB->insert_record('placement_school', $record);
        
        if($newb == 1)
        {
            $insert = new stdClass();
            $insert->name = $info[3];
            $DB->insert_record('placement_schoolboard', $insert);
        }
        
        $puid = $DB->get_record('placement_users', array('userid' => $USER->id));
        $new = new stdClass();
        $new->id = $puid->id;
        $new->lastname = $info[1];
        $new->firstname = $info[0];
        $new->schoolboard = $info[3];
        $new->school = $info[4];
        $new->userid = $USER->id;
        $new->schoolid = $schoolid;
        $new->confirmed = 1;
        
        $DB->update_record('placement_users', $new);
    }
    else
    {
        $schid = $DB->get_record('placement_school', array('school' => $info[4]));
        
        $record = new stdClass();
        $record->id = $schid->id;
        $record->email = $info[2];
        $record->principallastname = $info[1];
        $record->principalfirstname = $info[0];
        $record->sex = $info[5];
        $record->language = $info[6];
        
        $DB->update_record('placement_school', $record);
        
        $puid = $DB->get_record('placement_users', array('userid' => $USER->id));
        
        $new = new stdClass();
        $new->id = $puid->id;
        $new->lastname = $info[1];
        $new->firstname = $info[0];
        $new->schoolboard = $info[3];
        $new->school = $info[4];
        $new->userid = $USER->id;
        $new->schoolid = $schid->schoolid;
        $new->confirmed = 1;
        
        $DB->update_record('placement_users', $new);
    }
}

//Displays the school board of an existing school on the new principal dialog box
if($sb !== '0')
{
    $scb = $DB->get_record('placement_school', array('school' => urldecode($sb)), 'schoolboard');
    echo $scb->schoolboard;
}

//Add a teacher
if($addt !== '0')
{
    $newt = urldecode($addt);
    $tinfo = explode('|', $newt);
    
    $schl = $DB->get_record('placement_users', array('userid' => $USER->id));
    
    $record = new stdClass();
    $record->firstname = $tinfo[0];
    $record->lastname = $tinfo[1];
    $record->experience = $tinfo[2];
    $record->levelexp = $tinfo[3];
    $record->schoolyear = $tinfo[4];
    $record->email = $tinfo[5];
    $record->subjects = $tinfo[6];
    $record->preferences = $tinfo[7];
    $record->stage = $tinfo[8];
    $record->semester = $tinfo[9];
    $record->school = $schl->school;
    $record->schoolboard = $schl->schoolboard;
    
    $DB->insert_record('placement_coop_teachers', $record);
    
    $user = new stdClass();
    $user->auth = 'manual';
    $user->confirmed = 1;
    $user->policyagreed = 0;
    $user->deleted = 0;
    $user->suspended = 0;
    $user->mnethostid = 1;
    $user->username = $tinfo[5];
    $user->password = 'changeme';
    $user->idnumber = '';
    $user->firstname = $tinfo[0];
    $user->lastname = $tinfo[1];
    $user->email = $tinfo[5];
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
    
    require_once('../../../login/signup_form.php');
    
    $uid = $DB->get_record('user', array('username' => $tinfo[5]));
    $user->password = hash_internal_user_password($uid->password);
    $user->id = $uid->id;
    
    send_confirmation_email($user);
}

//Edit a teacher's information
if($editt !== '0')
{
    $tid = optional_param('tid', '0', PARAM_INT);
    
    $newed = urldecode($editt);
    $edinfo = explode('|', $newed);
    
    $record = new stdClass();
    $record->id = $tid;
    $record->firstname = $edinfo[0];
    $record->lastname = $edinfo[1];
    $record->experience = $edinfo[2];
    $record->levelexp = $edinfo[3];
    $record->schoolyear = $edinfo[4];
    $record->email = $edinfo[5];
    $record->subjects = $edinfo[6];
    $record->preferences = $edinfo[7];
    $record->stage = $edinfo[8];
    $record->semester = $edinfo[9];
    
    $DB->update_record('placement_coop_teachers', $record);
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

//This function was in an external library, so I copied it here
function user_delete_user($user) {
    return delete_user($user);
}
?>
