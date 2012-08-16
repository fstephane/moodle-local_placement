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

function admin_tool()
{
    global $DB, $USER, $CFG;
    ?>

    <div class="box1 center" style="width:800px;margin-top:40px;">
        <span class="whitetitle" style="font-size:20px;top:-17px;">Administration</span>
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

function placement()
{
    global $DB;
    
    $schools = $DB->get_records_sql("SELECT DISTINCT s.school, s.schoolid
                                    FROM mdl_placement_school AS s
                                    JOIN mdl_placement_coop_teachers AS t
                                    ON t.schoolid=s.schoolid
                                    WHERE lower(t.stage) LIKE 'edu%' ORDER BY s.school");
    
    $teachers = $DB->get_records_sql("SELECT * FROM mdl_placement_coop_teachers AS t WHERE lower(t.stage) LIKE 'edu%' ORDER BY t.lastname, t.firstname");
    
    $students = $DB->get_records('placement_initial', array(), 'lastname, firstname');
    ?>
    
    <br/><div style="width:1200px;height:600px;border:1px black solid;margin-left:auto;margin-right:auto;">
        <div id="initialtab" align="center" class="tab" style="width:200px;height:25px;border:1px black solid;position:relative;bottom:27px;">EDU E 331</div>
        <div id="stage1tab" align="center" class="tab" style="width:200px;height:25px;border:1px black solid;position:relative;left:204px;bottom:54px;">Stage 1</div>
        <div id="stage2tab" align="center" class="tab" style="width:200px;height:25px;border:1px black solid;position:relative;left:408px;bottom:81px;margin-bottom:-40px;">Stage 2</div>
        
        <table>
            <tr>
                <td>
                    <div align="center" style="width:400px;font-size:20px;"><?php echo get_string('placement', 'local_placement'); ?></div>
                    <div style="border:1px black solid;width:400px;height:500px;overflow-y:scroll;">
                        <?php
                        foreach($schools as $s)
                        {
                            echo '<p id="'.$s->schoolid.'" class="school">'.$s->school.'</p>';
                            foreach($teachers as $t)
                            {
                                if($t->schoolid == $s->schoolid)
                                    echo '<p id="'.$t->coopid.'">'.$t->firstname.' '.$t->lastname.'</p>';
                            }
                        }
                        ?>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                </td>
            </tr>
            <tr>
                <td>
                    <div align="center" style="width:400px;font-size:20px;float:right;margin-top:-540px;"><?php echo get_string('students', 'local_placement'); ?></div>
                    <div style="border:1px black solid;width:400px;height:500px;margin-top:-520px;float:right;overflow-y:scroll;">
                        <?php
                        foreach($students as $s)
                        {
                            echo '<span class="draggable teacher" id="'.$s->student_teacher_id.'">'.$s->firstname.' '.$s->lastname.'</span><br/>';
                        }
                        ?>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <?php
}

?>
