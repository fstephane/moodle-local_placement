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


//This page contains functions for the admin page and the placement tool called by viewadmin.php

/**
* Admin Page
*
* @global moodle_database $DB
* @global stdClass $USER
* @global stdClass $CFG
**/
function admin()
{
    global $DB, $USER, $CFG;
    ?>

    <div class="box1 center" style="width:800px;margin-top:40px;">
        <span class="whitetitle" style="font-size:20px;top:-17px;">Administration</span>
        <!--ADD A PRINCIPAL-->
        <div class="box1 center" style="width:750px;margin-bottom:20px;">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('addprinciple', 'local_placement'); ?></span>
            <table id="alert1" class="<?php echo get_string('studentadd', 'local_placement'); ?>">
                <tr id="alert2" class="<?php echo get_string('principaladd', 'local_placement'); ?>">
                    <td id="addp" class="<?php echo get_string('principaladd', 'local_placement'); ?>">
                        <?php echo get_string('firstname', 'local_placement'); ?>:
                        <input type="text" name="firstname" class="required" style="float:right;width:140px;"/>
                    </td>
                    <td id="adds" class="<?php echo get_string('studentadd', 'local_placement'); ?>">
                        <?php echo get_string('lastname', 'local_placement'); ?>:
                        <input type="text" name="lastname" class="required" style="float:right;width:140px;"/>
                    </td>
                    <!--provides wwwroot to be retrieved by javascript-->
                    <td id="cfg" class="<?php echo $CFG->wwwroot; ?>">
                        <?php echo get_string('email', 'local_placement'); ?>:
                        <input type="text" name="email" class="required" style="float:right;width:140px;"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><hr/>
                        <div align="center"><button class="generalbutton" onclick="add_principle();" style="font-size:12px;width:400px;"><?php echo get_string('add', 'local_placement'); ?></button></div>
                    </td>
                </tr>
            </table>
        </div>
        <!--ADD A STUDENT-->
        <div class="box1 center" style="width:750px;margin-bottom:20px;">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('addstudent', 'local_placement'); ?></span>
            <table>
                <tr>
                    <td>
                        <?php echo get_string('firstname', 'local_placement'); ?>:
                        <input type="text" name="firstname2" class="required" style="float:right;width:140px;"/>
                    </td>
                    <td>
                        <?php echo get_string('lastname', 'local_placement'); ?>:
                        <input type="text" name="lastname2" class="required" style="float:right;width:140px;"/>
                    </td>
                    <td>
                        <?php echo get_string('email', 'local_placement'); ?>:
                        <input type="text" name="email2" class="required" style="float:right;width:140px;"/>
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><hr/>
                        <div align="center"><button class="generalbutton" onclick="add_student();" style="font-size:12px;width:400px;"><?php echo get_string('add', 'local_placement'); ?></button></div>
                    </td>
                </tr>
            </table>
        </div>
        <!--ENTER PLACEMENT TOOL-->
        <div class="box1 center" style="width:750px;">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('placement', 'local_placement'); ?></span>
            <table>
                <tr>
                    <td>
                        <div align="center"><span style="font-weight:bold;font-size:16px;text-decoration:underline;"><?php echo get_string('viewtool', 'local_placement'); ?>:</span></div>
                        <br/><div align="center"><button class="generalbutton" onclick="enter_placement();" style="font-size:12px;width:500px;height:60px;"><?php echo get_string('entertool', 'local_placement'); ?></button></div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
        
    <?php
}

/**
* Placement Tool
*
* @global moodle_database $DB
**/
function placement()
{
    global $DB;
    
    $schools = $DB->get_records_sql("SELECT DISTINCT s.school, s.schoolid
                                    FROM mdl_placement_school AS s
                                    JOIN mdl_placement_coop_teachers AS t
                                    ON t.schoolid=s.schoolid
                                    WHERE lower(t.stage) LIKE 'edu%' ORDER BY s.school");
    
    $teachers = $DB->get_records_sql("SELECT t.coopid, t.firstname, t.lastname, t.schoolid, t.school, m.student_first_name, m.student_last_name, m.student_teacher_id FROM mdl_placement_coop_teachers AS t 
                                    LEFT JOIN mdl_placement_matches as m ON m.coopid=t.coopid
                                    WHERE lower(t.stage) LIKE 'edu%' ORDER BY t.lastname, t.firstname");
    
    $students = $DB->get_records_sql('SELECT i.student_teacher_id, i.firstname, i.lastname, m.student_first_name FROM mdl_placement_initial as i
                                    LEFT JOIN mdl_placement_matches as m ON i.student_teacher_id=m.student_teacher_id
                                    ORDER BY lastname, firstname');
    ?>
    
    <br/><div style="width:1200px;height:600px;border:1px black solid;margin-left:auto;margin-right:auto;">
        <!--STAGE TABS-->
        <div id="initialtab" align="center" class="tab" style="width:200px;height:25px;border:1px black solid;position:relative;bottom:27px;">EDU E 331</div>
        <div id="stage1tab" align="center" class="tab" style="width:200px;height:25px;border:1px black solid;position:relative;left:204px;bottom:54px;">Stage 1</div>
        <div id="stage2tab" align="center" class="tab" style="width:200px;height:25px;border:1px black solid;position:relative;left:408px;bottom:81px;margin-bottom:-40px;">Stage 2</div>
        
        <table>
            <!--indicates which stage tab is selected-->
            <tr id="indicator" class="1">
                <!--STUDENT LIST-->
                <td>
                    <div align="center" style="width:300px;font-size:20px;"><?php echo get_string('students', 'local_placement'); ?></div>
                    <div id="studentbox" style="border:1px black solid;width:300px;height:500px;overflow-y:scroll;z-index:2;">
                        <?php
                        foreach($students as $s)
                        {
                            if(!isset($s->student_first_name))
                                echo '<div onclick="select_student(this);" class="student" id="'.$s->student_teacher_id.'" style="background-color:white;">'.$s->firstname.' '.$s->lastname.'</div>';
                        }
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="position:relative;bottom:515px;left:325px;display:inline-block;">
                    <!--STUDENT INFORMATION BOX-->
                    <div id="stud" lang="0" style="width:400px;height:200px;border:1px black solid;margin-bottom:24px;padding:5px;margin-top:3px;">
                        
                    </div>
                    <button id="matchbutton" class="mbutton" onclick="match();" disabled="disabled" style="font-size:15px;width:150px;position:relative;left:10px;font-weight:bold;background-color:silver;border:1px black solid;height:30px;font-size:14px;font-family:verdana;"><?php echo get_string('match', 'local_placement'); ?></button>
                    <div align="center" style="margin-top:-50px;"><span style="font-weight:bold;;font-size:17px;"><?php echo get_string('matches', 'local_placement'); ?></span><br/><div id="match" style="padding-top:10px;color:red;border:2px black solid;height:30px;width:50px;font-size:35px;"></div></div>
                    <button id="unmatchbutton" class="mbutton" onclick="unmatch();" disabled="disabled" style="font-size:15px;width:150px;position:relative;left:250px;bottom:44px;font-weight:bold;background-color:silver;border:1px black solid;height:30px;font-size:14px;font-family:verdana;"><?php echo get_string('unmatch', 'local_placement'); ?></button>
                    <!--TEACHER INFORMATION BOX-->
                    <div id="teac" lang="0" style="width:400px;height:200px;border:1px black solid;padding:5px;margin-top:-20px;">
                        
                    </div>
                    </div>
                </td>
            </tr>
                <td>
                    <div align="center" style="width:400px;font-size:20px;float:right;position:relative;bottom:1047px;"><?php echo get_string('teachers', 'local_placement'); ?></div>
                    <div id="teacherbox" style="border:1px black solid;width:400px;height:500px;overflow-y:scroll;float:right;position:relative;bottom:1027px;left:400px;">
                        <?php
                        //TEACHER AND PRINCIPAL INFORMATION
                        foreach($schools as $s)
                        {
                            echo '<p id="'.$s->schoolid.'" class="school">'.$s->school.'</p>';
                            foreach($teachers as $t)
                            {
                                if($t->schoolid == $s->schoolid)
                                {
                                    //id=y means box is full, id=n means it is empty
                                    if($t->student_first_name == '')
                                        echo '<div id="n" onclick="select_teacher(this);" class="teach" lang="'.$t->coopid.'" xml:lang="'.$s->schoolid.'">';
                                    else
                                        echo '<div id="y" onclick="select_teacher(this);" class="teach" lang="'.$t->coopid.'" xml:lang="'.$s->schoolid.'">';
                                    //I added a t to the teacher id because some of them were overlapping with student ids and creating errors
                                    echo '<div class="teacher" style="font-weight:bold;background-color:white;padding-left:20px;" id="t'.$t->coopid.'">'.$t->firstname.' '.$t->lastname.'</div>';
                                    echo '<div align="center" id="'.$t->firstname.' '.$t->lastname.'" class="teacherbox"><span id="$sid" onclick="student2();" style="color:blue;">'.$t->student_first_name.' '.$t->student_last_name.'</span></div><br/>';
                                    echo '</div>';
                                }
                            }
                        }
                        ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>
<tr>

    <?php
}

?>
