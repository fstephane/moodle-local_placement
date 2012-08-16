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
 * Label module upgrade
 *
 * @package    mod
 * @subpackage label
 * @copyright  2006 onwards Eloy Lafuente (stronk7) {@link http://stronk7.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
// This file keeps track of upgrades to
// the label module
//
// Sometimes, changes between versions involve
// alterations to database structures and other
// major things that may break installations.
//
// The upgrade function in this file will attempt
// to perform all the necessary actions to upgrade
// your older installation to the current version.
//
// If there's something it cannot do itself, it
// will tell you what you need to do.
//
// The commands in here will all be database-neutral,
// using the methods of database_manager class
//
// Please do not forget to use upgrade_set_timeout()
// before any action that may take longer time to finish.

defined('MOODLE_INTERNAL') || die;

function xmldb_local_placement_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();
    
        if ($oldversion < 2012080200) {

        // Define table local_placement to be created
        $table = new xmldb_table('local_placement');

        // Adding fields to table local_placement
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);

        // Adding keys to table local_placement
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for local_placement
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }
        
        
        // Define table placement_school to be created
        $table = new xmldb_table('placement_school');

        // Adding fields to table placement_school
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('school', XMLDB_TYPE_CHAR, '1333', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('address', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('city', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('province', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('postalcode', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('phone', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('fax', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('email', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('principallastname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('principalfirstname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('contactlastname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('contactfirstname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('contactsex', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('contactlang', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('schoolboard', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('website', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('zone', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('schoolid', XMLDB_TYPE_INTEGER, '20', null, XMLDB_NOTNULL, null, '0');
        $table->add_field('principalsex', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('principallang', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('principalphone', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('contactphone', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('contactemail', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('program', XMLDB_TYPE_CHAR, '1333', null, null, null, null);

        // Adding keys to table placement_school
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for placement_school
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }
        
        
        // Define table placement_schoolboard to be created
        $table = new xmldb_table('placement_schoolboard');

        // Adding fields to table placement_schoolboard
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('name', XMLDB_TYPE_CHAR, '1333', null, XMLDB_NOTNULL, null, '0');

        // Adding keys to table placement_schoolboard
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for placement_schoolboard
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }
        
        // Define table placement_initial to be created
        $table = new xmldb_table('placement_initial');

        // Adding fields to table placement_initial
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('student_teacher_id', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('lastname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('firstname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('category', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('phone', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('email', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('type', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('program', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('stage', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('schoolboard', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('supervisor', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('semester', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('school', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('coop_teacher_id', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('supervisor_id', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('minor', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('major', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('schoolid', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('coop_lastname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('coop_firstname', XMLDB_TYPE_CHAR, '133', null, null, null, null);
        $table->add_field('schoolyear', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('vehicle', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('coop2_id', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('coop2_lastname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('coop2_firstname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('supervisor_lastname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('supervisor_firstname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('comments', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('address', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('phone2', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('outside_province', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('mileage_claimed', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('onecard', XMLDB_TYPE_INTEGER, '20', null, null, null, null);

        // Adding keys to table placement_initial
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for placement_initial
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }
        
        // Define table placement_supervisor to be created
        $table = new xmldb_table('placement_supervisor');

        // Adding fields to table placement_supervisor
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('profid', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('lastname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('firstname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('address', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('city', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('province', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('postalcode', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('phone', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('fax', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('category', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('email', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('sin', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('studentteacherid', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('stage', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('fee', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('travel', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('semester', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('comments', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('orientation_dinner', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('claimfee', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('claimtravel', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('claimnothing', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('paid', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('job', XMLDB_TYPE_CHAR, '1333', null, null, null, null);

        // Adding keys to table placement_supervisor
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for placement_supervisor
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }
        
        // Define table placement_users to be created
        $table = new xmldb_table('placement_users');

        // Adding fields to table placement_users
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('lastname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('firstname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('schoolboard', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('school', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('schoolid', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '20', null, null, null, null);

        // Adding keys to table placement_users
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for placement_users
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }
        
        // Define table placement_students to be created
        $table = new xmldb_table('placement_students');

        // Adding fields to table placement_students
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('userid', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('firstname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('lastname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('stage', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('registered', XMLDB_TYPE_INTEGER, '1', null, null, null, null);

        // Adding keys to table placement_students
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for placement_students
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }
        
        // Define table placement_stage1 to be created
        $table = new xmldb_table('placement_stage1');

        // Adding fields to table placement_stage1
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('student_teacher_id', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('lastname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('firstname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('phone', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('email', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('type', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('program', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('stage', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('schoolboard', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('supervisor', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('semester', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('school', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('coop_teacher_id', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('supervisor_id', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('minor', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('major', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('schoolid', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('coop_lastname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('coop_firstname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('schoolyear', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('vehicle', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('coop2_id', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('coop2_lastname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('coop2_firstname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('supervisor_lastname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('supervisor_firstname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('comments', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('address', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('phone2', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('outside_province', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('onecard', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('schooltype', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('rural_placement', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('rural_location', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('rural_scholarship', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('rural_accomidation', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('specific_preference', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('preferences', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('initial_stage_teacher', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('initial_stage_level', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('initial_stage_school', XMLDB_TYPE_CHAR, '1333', null, null, null, null);

        // Adding keys to table placement_stage1
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for placement_stage1
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }
        
        // Define table placement_stage2 to be created
        $table = new xmldb_table('placement_stage2');

        // Adding fields to table placement_stage2
        $table->add_field('id', XMLDB_TYPE_INTEGER, '10', XMLDB_UNSIGNED, XMLDB_NOTNULL, XMLDB_SEQUENCE, null);
        $table->add_field('student_teacher_id', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('lastname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('firstname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('phone', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('email', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('type', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('program', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('stage', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('schoolboard', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('supervisor', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('semester', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('school', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('coop_teacher_id', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('supervisor_id', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('minor', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('major', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('schoolid', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('coop_lastname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('coop_firstname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('schoolyear', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('vehicle', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('coop2_id', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('coop2_lastname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('coop2_firstname', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('comments', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('address', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('phone2', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('outside_province', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('mileage_claimed', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('onecard', XMLDB_TYPE_INTEGER, '20', null, null, null, null);
        $table->add_field('schooltype', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('rural_placement', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('rural_loaction', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('rural_scholarship', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('rural_accomidation', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('specific_preference', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('preferences', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('initial_stage_teacher', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('initial_stage_level', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('initial_stage_school', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('stage1_teacher', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('stage1_level', XMLDB_TYPE_CHAR, '1333', null, null, null, null);
        $table->add_field('stage1_school', XMLDB_TYPE_CHAR, '1333', null, null, null, null);

        // Adding keys to table placement_stage2
        $table->add_key('primary', XMLDB_KEY_PRIMARY, array('id'));

        // Conditionally launch create table for placement_stage2
        if (!$dbman->table_exists($table)) {
            $dbman->create_table($table);
        }

        // placement savepoint reached
        upgrade_plugin_savepoint(true, 2012080900, 'local', 'placement');
    }

    return true;
}

