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

$addp = optional_param('addp', '0', PARAM_TEXT);
$adds = optional_param('adds', '0', PARAM_TEXT);


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
