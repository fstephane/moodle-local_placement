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

//This page provides functions for viewuser.php


/**
* Form for adding a teacher
*
* @global moodle_database $DB
* @global stdClass $USER
* @global stdClass $CFG
**/
function dialog()
{
    global $DB, $CFG, $USER;
    $info = $DB->get_record('user', array("id" => $USER->id));
    ?>
    <div id="mask" style="z-index:-10;background-color:gray;display:none;"></div>
    <div id="dialog" title="<?php echo get_string('newuser', 'local_placement')?>" style="display:none;">
        <div id="cfg" class="<?php echo $CFG->wwwroot; ?>" style="font-variant:small-caps;font-size:20px;font-family:georgia;font-weight:bold;color:dimgray;"><?php echo $info->firstname . ' ' . $info->lastname ?></div><br/>
        <span style="font-weight:bold;"><?php echo get_string('select', 'local_placement'); ?>:</span><br/><br/>
        <select id="choosestage" style="width:200px;">
            <option>EDU E 331</option>
            <option>Stage 1</option>
            <option>Stage 2</option>
        </select><br/><br/><hr/>
        <button class="dialogbutton" onclick="choose_stage();" style="width:100px;height:30px;border-radius:5px 5px;border:1px darkorange solid;color:white;font-weight:bold;float:right;"><?php echo get_string('save', 'local_placement'); ?></button>
    </div>
    <span id="null" style="display:none;"></span>
    <?php
}


/**
* EDU registration form
*
* @global moodle_database $DB
* @global stdClass $USER
* @global stdClass $CFG
**/
function initial()
{
    global $DB, $CFG, $USER;
    $stud = $DB->get_record('user', array('id' => $USER->id));
    $schools = $DB->get_records('placement_school', array(), 'school');
    $stude = $DB->get_record('placement_initial', array('email' => $stud->email));
    ?>
    <!--FORM PROVIDES VALIDATION - REQUIRED FIELDS MUST BE FILLED-->
    <form class="required-form" name="newstudent" id="newstudent">
    <div class="center" style="width:900px;">
    </div>
    <div class="center" style="width:850px;font-size:20px;font-weight:bold;text-decoration:underline;"><?php echo $stud->firstname . ' ' . $stud->lastname; ?></div>
    <div class="box1 center" style="width:800px;margin-top:40px;">
        <span class="whitetitle" style="font-size:20px;top:-17px;"><?php echo get_string('register', 'local_placement'); ?></span>
        <div class="box1 center">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('personal', 'local_placement'); ?></span>
            <table id="alert" class="<?php echo get_string('required', 'local_placement'); ?>">
                <tr id="saved" class="<?php echo get_string('usersaved', 'local_placement'); ?>">
                <!--FIRSTNAME-->
                    <td id="cfg" class="<?php echo $CFG->wwwroot; ?>">
                        <span style="color:red;">*</span><?php echo get_string('firstname', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="firstname" class="required" value="<?php echo $stud->firstname; ?>"/>
                    </td>
                <!--LASTNAME-->
                    <td id="onealert" class="0">
                        <span style="color:red;">*</span><?php echo get_string('lastname', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="lastname" class="required" value="<?php echo $stud->lastname; ?>"/>
                    </td>
                </tr>
                <tr>
                <!--PHONE NUMBER-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('phone', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="phone" class="required"/>
                    </td>
                <!--EMAIL-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('email', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="email" class="required email" value="<?php echo $stud->email; ?>"/>
                    </td>
                </tr>
                <tr>
                <!--ADDRESS-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('address', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="address" class="required"/>
                    </td>
                <!--CITY-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('city', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="city" class="required"/>
                    </td>
                </tr>
                <tr>
                <!--ONECARD-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('onecard', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="onecard" class="required"/>
                    </td>
                <!--VEHICLE-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('vehicle', 'local_placement'); ?>:
                        <select name="vehicle" style="margin-left:8px;">
                            <option value="n"><?php echo get_string('no', 'local_placement'); ?></option>
                            <option value="y"><?php echo get_string('yes', 'local_placement'); ?></option>
                        </select>
                    </td>
                </tr>
            </table>
        </div><br/>
        <div class="box1 center">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('programinfo', 'local_placement'); ?></span>
            <table>
                <tr>
                <!--FRANCOPHONE/IMMERSION-->
                    <td>
                        <div style="margin-top:-20px;"><span style="color:red;">*</span><?php echo get_string('langpro', 'local_placement'); ?>:
                        <div class="move" style="float:right;margin-right:30px;"><input type="radio" class="radio2" name="lang" value="francophone"/><span style="font-weight:bold;"><?php echo ' ' . get_string('french', 'local_placement'); ?></span><br/>
                        <input type="radio" class="radio2" name="lang" value="immersion"/><span style="font-weight:bold;"><?php echo ' ' . get_string('immersion', 'local_placement'); ?></span></div>
                    </td>
                <!--ELEMENTARY/SECONDARY-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('schoollev', 'local_placement'); ?>:
                        <div class="move" style="float:right;margin-right:30px;"><input type="radio" class="radio3" name="level" value="elementary" style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('elementary', 'local_placement'); ?></span><br/>
                        <input type="radio" class="radio3" name="level" value="secondary"  style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('secondary', 'local_placement'); ?><br/>
                        <input type="radio" class="radio3" name="level" value="doesn't matter"  style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('nomatter', 'local_placement'); ?></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span style="text-decoration:underline;"><?php echo get_string('specialisation', 'local_placement'); ?>:</span><br/>
                    <td/>
                </tr>
                <tr>
                <!--MAJOR-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('major', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:10px;" name="maj" class="required"/>
                    </td>
                <!--MINOR-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('minor', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:100px;" name="min" class="required"/>
                    </td>
                </tr>
            </table>
        </div><br/>
        <div class="box1 center">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('pref', 'local_placement'); ?></span>
            <table>
                <tr>
                <!--CATHOLIC/PUBLIC-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('type', 'local_placement'); ?>:<br/><br/>
                        <div style=""><input type="radio" class="radio4" name="type" value="catholic" style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('catholic', 'local_placement'); ?></span><br/>
                        <input type="radio" class="radio4" name="type" value="public"  style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('public', 'local_placement'); ?></span><br/>
                        <input type="radio" class="radio4" name="type" value="doesn't matter"  style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('nomatter', 'local_placement'); ?></span></div>
                    </td>
                <!--CORE SUBJECT PREFERENCE-->
                    <td>
                        <?php echo get_string('subject', 'local_placement'); ?><br/><br/>
                        <select name="core">
                            <option value="none"><?php echo get_string('nomatter', 'local_placement'); ?></option>
                            <option value="language arts"><?php echo get_string('la', 'local_placement'); ?></option>
                            <option value="math"><?php echo get_string('math', 'local_placement'); ?></option>
                            <option value="science"><?php echo get_string('science', 'local_placement'); ?></option>
                            <option value="social studies"><?php echo get_string('social', 'local_placement'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                <!--SPECIFIC SCHOOL PREFERENCE-->
                    <td colspan="2"><br/><hr/><br/>
                        <?php echo get_string('specific', 'local_placement'); ?>:<br/><br/>
                        <select name="specific">
                            <option value="0"><?php echo get_string('notrequired', 'local_placement'); ?></option>
                            <?php
                            foreach($schools as $s)
                            {
                            ?>
                            <option value="<?php echo $s->school; ?>"><?php echo $s->school; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                <!--OTHER PREFERENCES-->
                    <td colspan="2"><br/><hr/><br/>
                        <?php echo get_string('otherinfo', 'local_placement'); ?><br/><br/>
                        <textarea name="pref" cols="110" rows="10" style="resize:none;"></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <table>
            <tr>
                <td>
                    <div style="float:right;margin-top:10px;margin-bottom:-10px;">
                        <input type="submit" class="generalbutton" onclick="check_radio('initial', 'false');" style="font-size:12px;width:150px;margin-right:10px;" value="<?php echo get_string('save', 'local_placement'); ?>"/>
                        <button class="generalbutton" onclick="" style="font-size:12px;width:150px;"><?php echo get_string('cancel', 'local_placement'); ?></button>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    </form>
    <?php
}


/**
* Stage 1 registration form
*
* @global moodle_database $DB
* @global stdClass $USER
* @global stdClass $CFG
**/
function stage1()
{
    global $DB, $CFG, $USER;
    $stud = $DB->get_record('user', array('id' => $USER->id));
    $schools = $DB->get_records('placement_school', array(), 'school');
    ?>
    <!--FORM PROVIDES VALIDATION - REQUIRED FIELDS MUST BE FILLED-->
    <form class="required-form" name="newstudent" id="newstudent">
    <div class="center" style="width:900px;">
    </div>
    <div class="center" style="width:850px;font-size:20px;font-weight:bold;text-decoration:underline;"><?php echo $stud->firstname . ' ' . $stud->lastname; ?></div>
    <div class="box1 center" style="width:800px;margin-top:40px;">
        <span class="whitetitle" style="font-size:20px;top:-17px;"><?php echo get_string('register', 'local_placement'); ?></span>
        <div class="box1 center">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('personal', 'local_placement'); ?></span>
            <table id="alert" class="<?php echo get_string('required', 'local_placement'); ?>">
                <tr id="saved" class="<?php echo get_string('usersaved', 'local_placement'); ?>">
                <!--FIRSTNAME-->
                    <td id="cfg" class="<?php echo $CFG->wwwroot; ?>">
                        <span style="color:red;">*</span><?php echo get_string('firstname', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="firstname" class="required" value="<?php echo $stud->firstname; ?>"/>
                    </td>
                <!--LASTNAME-->
                    <td id="onealert" class="0">
                        <span style="color:red;">*</span><?php echo get_string('lastname', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="lastname" class="required" value="<?php echo $stud->lastname; ?>"/>
                    </td>
                </tr>
                <tr>
                <!--PHONE NUMBER-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('phone', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="phone" class="required"/>
                    </td>
                <!--EMAIL-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('email', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="email" class="required email" value="<?php echo $stud->email; ?>"/>
                    </td>
                </tr>
                <tr>
                <!--ADDRESS-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('address', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="address" class="required"/>
                    </td>
                <!--CITY-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('city', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="city" class="required"/>
                    </td>
                </tr>
                <tr>
                <!--ONECARD-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('onecard', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="onecard" class="required"/>
                    </td>
                <!--VEHICLE-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('vehicle', 'local_placement'); ?>:
                        <select name="vehicle" style="margin-left:8px;">
                            <option value="n"><?php echo get_string('no', 'local_placement'); ?></option>
                            <option value="y"><?php echo get_string('yes', 'local_placement'); ?></option>
                        </select>
                    </td>
                </tr>
            </table>
        </div><br/>
        <div class="box1 center">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('programinfo', 'local_placement'); ?></span>
            <table>
                <tr>
                <!--FRANCOPHONE/IMMERSION-->
                    <td>
                        <div style="margin-top:-20px;"><span style="color:red;">*</span><?php echo get_string('langpro', 'local_placement'); ?>:
                        <div class="move" style="float:right;margin-right:30px;"><input type="radio" class="radio2" name="lang" value="francophone"/><span style="font-weight:bold;"><?php echo ' ' . get_string('french', 'local_placement'); ?></span><br/>
                        <input type="radio" class="radio2" name="lang" value="immersion"/><span style="font-weight:bold;"><?php echo ' ' . get_string('immersion', 'local_placement'); ?></span></div>
                    </td>
                <!--ELEMENTARY/SECONDARY-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('schoollev', 'local_placement'); ?>:
                        <div class="move" style="float:right;margin-right:30px;"><input type="radio" class="radio3" name="level" value="elementary" style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('elementary', 'local_placement'); ?></span><br/>
                        <input type="radio" class="radio3" name="level" value="secondary"  style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('secondary', 'local_placement'); ?><br/>
                        <input type="radio" class="radio3" name="level" value="doesn't matter"  style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('nomatter', 'local_placement'); ?></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span style="text-decoration:underline;"><?php echo get_string('specialisation', 'local_placement'); ?>:</span><br/>
                    <td/>
                </tr>
                <tr>
                <!--MAJOR-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('major', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:10px;" name="maj" class="required"/>
                    </td>
                <!--MINOR-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('minor', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:100px;" name="min" class="required"/>
                    </td>
                </tr>
            </table>
        </div><br/>
        <div class="box1 center" style="margin-bottom:20px;">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('pref', 'local_placement'); ?></span>
            <table>
                <tr>
                <!--CATHOLIC/PUBLIC-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('type', 'local_placement'); ?>:<br/><br/>
                        <div style=""><input type="radio" class="radio4" name="type" value="catholic" style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('catholic', 'local_placement'); ?></span><br/>
                        <input type="radio" class="radio4" name="type" value="public"  style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('public', 'local_placement'); ?></span><br/>
                        <input type="radio" class="radio4" name="type" value="doesn't matter"  style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('nomatter', 'local_placement'); ?></span></div>
                    </td>
                <!--CORE SUBJECT PREFERENCE-->
                    <td>
                        <?php echo get_string('subject', 'local_placement'); ?><br/><br/>
                        <select name="core">
                            <option value="none"><?php echo get_string('nomatter', 'local_placement'); ?></option>
                            <option value="language arts"><?php echo get_string('la', 'local_placement'); ?></option>
                            <option value="math"><?php echo get_string('math', 'local_placement'); ?></option>
                            <option value="science"><?php echo get_string('science', 'local_placement'); ?></option>
                            <option value="social studies"><?php echo get_string('social', 'local_placement'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br/><hr/>
                    </td>
                </tr>
                <tr>
                <!--RURAL PLACEMENT  YES/NO-->
                    <td colspan="2">
                        <span style="color:red;">*</span><?php echo get_string('rural', 'local_placement'); ?>:
                        <input id="yes" type="radio" class="radio5" name="rural" value="y" style="margin-left:20px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('yes', 'local_placement'); ?></span>
                        <input type="radio" class="radio5" name="rural" value="n" style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('no', 'local_placement'); ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br/><span style="margin-left:20px;font-weight:bold;">-  <?php echo get_string('ifyes', 'local_placement'); ?>:</span>
                    </td>
                </tr>
                <tr>
                <!--RURAL LOCATION-->
                    <td>
                        <br/><p><span class="show" style="color:red;display:none;">*</span><?php echo get_string('location', 'local_placement'); ?>:<span>    </span><input name="location" type="text"/></p>
                    </td>
                </tr>
                <tr>
                <!--RURAL SCHOLARSHIP YES/NO-->
                    <td colspan="2"><br/>
                        <span class="show" style="color:red;display:none;">*</span><?php echo get_string('scholarship', 'local_placement'); ?>:
                        <input type="radio" class="radio6" name="scholarship" value="y" style="margin-left:30px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('yes', 'local_placement'); ?></span>
                        <input type="radio" class="radio6" name="scholarship" value="n"  style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('no', 'local_placement'); ?></span><br/>
                        <b><?php echo get_string('scholdetail', 'local_placement'); ?></b>
                    </td>
                </tr>
                <tr>
                <!--RURAL HOUSING ACCOMMODATION YES/NO-->
                    <td colspan="2"><br/>
                        <span class="show" style="color:red;display:none;">*</span><?php echo get_string('housing', 'local_placement'); ?>:
                        <input type="radio" class="radio7" name="housing" value="y" style="margin-left:30px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('yes', 'local_placement'); ?></span>
                        <input type="radio" class="radio7" name="housing" value="n"  style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('no', 'local_placement'); ?></span>
                    </td>
                </tr>
                <tr>
                <!--LIST OF SCHOOLS FOR SPECIFIC SCHOOL PREFERENCE-->
                    <td colspan="2"><br/><hr/><br/>
                        <?php echo get_string('specific', 'local_placement'); ?>:<br/><br/>
                        <select name="specific">
                            <option value="0"><?php echo get_string('notrequired', 'local_placement'); ?></option>
                            <?php
                            foreach($schools as $s)
                            {
                            ?>
                            <option value="<?php echo $s->school; ?>"><?php echo $s->school; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                <!--OTHER PREFERENCES-->
                    <td colspan="2"><br/><hr/><br/>
                        <?php echo get_string('otherinfo', 'local_placement'); ?><br/><br/>
                        <textarea name="pref" cols="110" rows="10" style="resize:none;"></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <div class="box1 center">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('first', 'local_placement'); ?></span>
            <table>
                <tr>
                <!--EDU STAGE TEACHER NAME-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('teachername', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:120px;" name="teacher" class="required"/>
                    </td>
                <!--EDU STAGE SCHOOL NAME-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('school', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:120px;" name="school" class="required"/>
                    </td>
                <!--EDU STAGE LEVEL-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('level', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:120px;" name="level2" class="required"/>
                    </td>
                </tr>
            </table>
        </div>
        <table>
            <tr>
                <td>
                    <div style="float:right;margin-top:10px;margin-bottom:-10px;">
                        <input type="submit" class="generalbutton" onclick="check_radio('stage1', 'false');" style="font-size:12px;width:150px;margin-right:10px;" value="<?php echo get_string('save', 'local_placement'); ?>"/>
                        <button class="generalbutton" onclick="return_home();" style="font-size:12px;width:150px;"><?php echo get_string('cancel', 'local_placement'); ?></button>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    </form>
    <?php
}


/**
* Form for adding a teacher
*
* @global moodle_database $DB
* @global stdClass $USER
* @global stdClass $CFG
**/
function stage2()
{
    global $DB, $CFG, $USER;
    $stud = $DB->get_record('user', array('id' => $USER->id));
    $schools = $DB->get_records('placement_school', array(), 'school');
    ?>
    <!--FORM PROVIDES VALIDATION - REQUIRED FIELDS MUST BE FILLED-->
    <form class="required-form" name="newstudent" id="newstudent">
    <div class="center" style="width:900px;">
    </div>
    <div class="center" style="width:850px;font-size:20px;font-weight:bold;text-decoration:underline;"><?php echo $stud->firstname . ' ' . $stud->lastname; ?></div>
    <div class="box1 center" style="width:800px;margin-top:40px;">
        <span class="whitetitle" style="font-size:20px;top:-17px;"><?php echo get_string('register', 'local_placement'); ?></span>
        <div class="box1 center">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('personal', 'local_placement'); ?></span>
            <table id="alert" class="<?php echo get_string('required', 'local_placement'); ?>">
                <tr id="saved" class="<?php echo get_string('usersaved', 'local_placement'); ?>">
                <!--FIRSTNAME-->
                    <td id="cfg" class="<?php echo $CFG->wwwroot; ?>">
                        <span style="color:red;">*</span><?php echo get_string('firstname', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="firstname" class="required" value="<?php echo $stud->firstname; ?>"/>
                    </td>
                <!--LASTNAME-->
                    <td id="onealert" class="0">
                        <span style="color:red;">*</span><?php echo get_string('lastname', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="lastname" class="required" value="<?php echo $stud->lastname; ?>"/>
                    </td>
                </tr>
                <tr>
                <!--PHONE NUMBER-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('phone', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="phone" class="required"/>
                    </td>
                <!--EMAIL-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('email', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="email" class="required email" value="<?php echo $stud->email; ?>"/>
                    </td>
                </tr>
                <tr>
                <!--ADDRESS-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('address', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="address" class="required"/>
                    </td>
                <!--CITY-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('city', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="city" class="required"/>
                    </td>
                </tr>
                <tr>
                <!--ONECARD-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('onecard', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="onecard" class="required"/>
                    </td>
                <!--VEHICLE-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('vehicle', 'local_placement'); ?>:
                        <select name="vehicle" style="margin-left:8px;">
                            <option value="n"><?php echo get_string('no', 'local_placement'); ?></option>
                            <option value="y"><?php echo get_string('yes', 'local_placement'); ?></option>
                        </select>
                    </td>
                </tr>
            </table>
        </div><br/>
        <div class="box1 center">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('programinfo', 'local_placement'); ?></span>
            <table>
                <tr>
                <!--FRANCOPHONE/IMMERSION-->
                    <td>
                        <div style="margin-top:-20px;"><span style="color:red;">*</span><?php echo get_string('langpro', 'local_placement'); ?>:
                        <div class="move" style="float:right;margin-right:30px;"><input type="radio" class="radio2" name="lang" value="francophone"/><span style="font-weight:bold;"><?php echo ' ' . get_string('french', 'local_placement'); ?></span><br/>
                        <input type="radio" class="radio2" name="lang" value="immersion"/><span style="font-weight:bold;"><?php echo ' ' . get_string('immersion', 'local_placement'); ?></span></div>
                    </td>
                <!--ELEMENTARY/SECONDARY-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('schoollev', 'local_placement'); ?>:
                        <div class="move" style="float:right;margin-right:30px;"><input type="radio" class="radio3" name="level" value="elementary" style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('elementary', 'local_placement'); ?></span><br/>
                        <input type="radio" class="radio3" name="level" value="secondary"  style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('secondary', 'local_placement'); ?><br/>
                        <input type="radio" class="radio3" name="level" value="doesn't matter"  style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('nomatter', 'local_placement'); ?></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span style="text-decoration:underline;"><?php echo get_string('specialisation', 'local_placement'); ?>:</span><br/>
                    <td/>
                </tr>
                <tr>
                <!--MAJOR-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('major', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:10px;" name="maj" class="required"/>
                    </td>
                <!--MINOR-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('minor', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:100px;" name="min" class="required"/>
                    </td>
                </tr>
            </table>
        </div><br/>
        <div class="box1 center" style="margin-bottom:20px;">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('pref', 'local_placement'); ?></span>
            <table>
                <tr>
                <!--CATHOLIC/PUBLIC-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('type', 'local_placement'); ?>:<br/><br/>
                        <div style=""><input type="radio" class="radio4" name="type" value="catholic" style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('catholic', 'local_placement'); ?></span><br/>
                        <input type="radio" class="radio4" name="type" value="public"  style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('public', 'local_placement'); ?></span><br/>
                        <input type="radio" class="radio4" name="type" value="doesn't matter"  style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('nomatter', 'local_placement'); ?></span></div>
                    </td>
                <!--CORE SUBJECT PREFERENCE-->
                    <td>
                        <?php echo get_string('subject', 'local_placement'); ?><br/><br/>
                        <select name="core">
                            <option value="none"><?php echo get_string('nomatter', 'local_placement'); ?></option>
                            <option value="language arts"><?php echo get_string('la', 'local_placement'); ?></option>
                            <option value="math"><?php echo get_string('math', 'local_placement'); ?></option>
                            <option value="science"><?php echo get_string('science', 'local_placement'); ?></option>
                            <option value="social studies"><?php echo get_string('social', 'local_placement'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br/><hr/>
                    </td>
                </tr>
                <tr>
                <!--RURAL PLACEMENT YES/NO-->
                    <td colspan="2">
                        <span style="color:red;">*</span><?php echo get_string('rural', 'local_placement'); ?>:
                        <input id="yes" type="radio" class="radio5" name="rural" value="y" style="margin-left:20px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('yes', 'local_placement'); ?></span>
                        <input type="radio" class="radio5" name="rural" value="n" style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('no', 'local_placement'); ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br/><span style="margin-left:20px;font-weight:bold;">-  <?php echo get_string('ifyes', 'local_placement'); ?>:</span>
                    </td>
                </tr>
                <tr>
                <!--RURAL LOCATION-->
                    <td>
                        <br/><p><span class="show" style="color:red;display:none;">*</span><?php echo get_string('location', 'local_placement'); ?>:<span>    </span><input name="location" type="text"/></p>
                    </td>
                </tr>
                <tr>
                <!--RURAL SCHOLARHSIP YES/NO-->
                    <td colspan="2"><br/>
                        <span class="show" style="color:red;display:none;">*</span><?php echo get_string('scholarship', 'local_placement'); ?>:
                        <input type="radio" class="radio6" name="scholarship" value="y" style="margin-left:30px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('yes', 'local_placement'); ?></span>
                        <input type="radio" class="radio6" name="scholarship" value="n"  style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('no', 'local_placement'); ?></span><br/>
                        <b><?php echo get_string('scholdetail', 'local_placement'); ?></b>
                    </td>
                </tr>
                <tr>
                <!--RURAL HOUSING ACCOMIDATION YES/NO-->
                    <td colspan="2"><br/>
                        <span class="show" style="color:red;display:none;">*</span><?php echo get_string('housing', 'local_placement'); ?>:
                        <input type="radio" class="radio7" name="housing" value="y" style="margin-left:30px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('yes', 'local_placement'); ?></span>
                        <input type="radio" class="radio7" name="housing" value="n"  style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('no', 'local_placement'); ?></span>
                    </td>
                </tr>
                <tr>
                <!--SPECIFIC SCHOOL PREFERENCE-->
                    <td colspan="2"><br/><hr/><br/>
                        <?php echo get_string('specific', 'local_placement'); ?>:<br/><br/>
                        <select name="specific">
                            <option value="0"><?php echo get_string('notrequired', 'local_placement'); ?></option>
                            <?php
                            foreach($schools as $s)
                            {
                            ?>
                            <option value="<?php echo $s->school; ?>"><?php echo $s->school; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                <!--OTHER PREFERENCES-->
                    <td colspan="2"><br/><hr/><br/>
                        <?php echo get_string('otherinfo', 'local_placement'); ?><br/><br/>
                        <textarea name="pref" cols="110" rows="10" style="resize:none;"></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <div class="box1 center" style="margin-bottom:20px;">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('first', 'local_placement'); ?></span>
            <table>
                <tr>
                <!--EDU STAGE TEACHER NAME-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('teachername', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:120px;" name="teacher" class="required"/>
                    </td>
                <!--EDU STAGE SCHOOL NAME-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('school', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:120px;" name="school" class="required"/>
                    </td>
                <!--EDU STAGE LEVEL-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('level', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:120px;" name="level2" class="required"/>
                    </td>
                </tr>
            </table>
        </div>
        <div class="box1 center">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('second', 'local_placement'); ?></span>
            <table>
                <tr>
                <!--STAGE 1 TEACHER NAME-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('teachername', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:120px;" name="teacher2" class="required"/>
                    </td>
                <!--STAGE 1 SCHOOL NAME-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('school', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:120px;" name="school2" class="required"/>
                    </td>
                <!--STAGE 1 LEVEL-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('level', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:120px;" name="level3" class="required"/>
                    </td>
                </tr>
            </table>
        </div>
        <table>
            <tr>
                <td>
                    <div style="float:right;margin-top:10px;margin-bottom:-10px;">
                        <input type="submit" class="generalbutton" onclick="check_radio('stage2', 'false');" style="font-size:12px;width:150px;margin-right:10px;" value="<?php echo get_string('save', 'local_placement'); ?>"/>
                        <button class="generalbutton" onclick="return_home();" style="font-size:12px;width:150px;"><?php echo get_string('cancel', 'local_placement'); ?></button>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    </form>
    <?php
}


/**
* Form for adding a teacher
*
* @global moodle_database $DB
* @global stdClass $USER
* @global stdClass $CFG
**/
function initial_edit()
{
    global $DB, $CFG, $USER;
    $std = $DB->get_record('user', array('id' => $USER->id));
    $stud = $DB->get_record('placement_initial', array("email" => $std->email));
    $schools = $DB->get_records('placement_school', array(), 'school');
    
    //These if statements determine which radio buttons and checkboxes to fill
    
    $radio1a = '';
    $radio1b = '';
    if($stud->program == 'francophone')
    {
        $radio1a = 'checked="checked"';
        $radio1b = '';
    }
    else
    {
        $radio1a = '';
        $radio1b = 'checked="checked"';
    }
    
    $radio2a = '';
    $radio2b = '';
    $radio2c = '';
    switch($stud->type)
    {
        case 'elementary':
            $radio2a = 'checked="checked"';
            $radio2b = '';
            $radio2c = '';
            break;
        case 'secondary':
            $radio2a = '';
            $radio2b = 'checked="checked"';
            $radio2c = '';
            break;
        case 'doesn\'t matter':
            $radio2a = '';
            $radio2b = '';
            $radio2c = 'checked="checked"';
            break;
    }
    
    $radio3a = '';
    $radio3b = '';
    $radio3c = '';
    switch($stud->schooltype)
    {
        case 'catholic':
            $radio3a = 'checked="checked"';
            $radio3b = '';
            $radio3c = '';
            break;
        case 'public':
            $radio3a = '';
            $radio3b = 'checked="checked"';
            $radio3c = '';
            break;
        case 'doesn\'t matter':
            $radio3a = '';
            $radio3b = '';
            $radio3c = 'checked="checked"';
            break;
    }
    
    switch($stud->subject_preference)
    {
        case 'none':
            $select1 = 'selected=selected';
            $select2 = '';
            $select3 = '';
            $select4 = '';
            $select5 = '';
            break;
        case 'language arts':
            $select1 = '';
            $select2 = 'selected=selected';
            $select3 = '';
            $select4 = '';
            $select5 = '';
            break;
        case 'math':
            $select1 = '';
            $select2 = '';
            $select3 = 'selected=selected';
            $select4 = '';
            $select5 = '';
            break;
        case 'science':
            $select1 = '';
            $select2 = '';
            $select3 = '';
            $select4 = 'selected=selected';
            $select5 = '';
            break;
        case 'social studies':
            $select1 = '';
            $select2 = '';
            $select3 = '';
            $select4 = '';
            $select5 = 'selected=selected';
            break;
    }
    ?>
    <!--FORM PROVIDES VALIDATION - REQUIRED FIELDS MUST BE FILLED-->
    <form class="required-form" name="newstudent" id="newstudent">
    <div class="center" style="width:900px;">
    </div>
    <div class="center" style="width:850px;font-size:20px;font-weight:bold;text-decoration:underline;"><?php echo $stud->firstname . ' ' . $stud->lastname; ?></div>
    <div align="center"><a href="#" onclick="change_stage(1)"><?php echo get_string('chooseanother', 'local_placement'); ?></a></div>
    <div class="box1 center" style="width:800px;margin-top:40px;">
        <span class="whitetitle" style="font-size:20px;top:-17px;"><?php echo get_string('register', 'local_placement'); ?></span>
        <div class="box1 center">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('personal', 'local_placement'); ?></span>
            <table id="alert" class="<?php echo get_string('required', 'local_placement'); ?>">
                <tr id="saved" class="<?php echo get_string('usersaved', 'local_placement'); ?>">
                <!--FIRSTNAME-->
                    <td id="cfg" class="<?php echo $CFG->wwwroot; ?>">
                        <span style="color:red;">*</span><?php echo get_string('firstname', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="firstname" class="required" value="<?php echo $stud->firstname; ?>"/>
                    </td>
                <!--LASTNAME-->
                    <td id="onealert" class="0">
                        <span style="color:red;">*</span><?php echo get_string('lastname', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="lastname" class="required" value="<?php echo $stud->lastname; ?>"/>
                    </td>
                </tr>
                <tr id="studentid" class="<?php echo $stud->student_teacher_id; ?>">
                <!--PHONE NUMBER-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('phone', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="phone" class="required" value="<?php echo $stud->phone; ?>"/>
                    </td>
                <!--EMAIL-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('email', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="email" class="required email" value="<?php echo $stud->email; ?>"/>
                    </td>
                </tr>
                <tr>
                <!--ADDRESS-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('address', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="address" class="required" value="<?php echo $stud->address; ?>"/>
                    </td>
                <!--CITY-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('city', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="city" class="required" value="<?php echo $stud->city; ?>"/>
                    </td>
                </tr>
                <tr>
                <!--ONECARD-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('onecard', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="onecard" class="required" value="<?php echo $stud->onecard; ?>"/>
                    </td>
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('vehicle', 'local_placement'); ?>:
                        <?php
                        if($stud->vehicle == 'y')
                        {
                        ?>
                        <select name="vehicle" style="margin-left:8px;">
                            <option value="n"><?php echo get_string('no', 'local_placement'); ?></option>
                            <option value="y" selected="selected"><?php echo get_string('yes', 'local_placement'); ?></option>
                        </select>
                        <?php
                        }
                        else
                        {
                        ?>
                        <select name="vehicle" style="margin-left:8px;">
                            <option value="n" selected="selected"><?php echo get_string('no', 'local_placement'); ?></option>
                            <option value="y"><?php echo get_string('yes', 'local_placement'); ?></option>
                        </select>
                        <?php
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </div><br/>
        <div class="box1 center">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('programinfo', 'local_placement'); ?></span>
            <table>
                <tr>
                <!--FRANCOPHONE/IMMERSION-->
                    <td>
                        <div style="margin-top:-20px;"><span style="color:red;">*</span><?php echo get_string('langpro', 'local_placement'); ?>:
                        <div class="move" style="float:right;margin-right:30px;"><input type="radio" class="radio2" name="lang" value="francophone" <?php echo $radio1a; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('french', 'local_placement'); ?></span><br/>
                        <input type="radio" class="radio2" name="lang" value="immersion" <?php echo $radio1b; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('immersion', 'local_placement'); ?></span></div>
                    </td>
                <!--ELEMENTARY/SECONDARY-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('schoollev', 'local_placement'); ?>:
                        <div class="move" style="float:right;margin-right:30px;"><input type="radio" class="radio3" name="level" value="elementary" style="margin-left:10px;" <?php echo $radio2a; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('elementary', 'local_placement'); ?></span><br/>
                        <input type="radio" class="radio3" name="level" value="secondary"  style="margin-left:10px;" <?php echo $radio2b; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('secondary', 'local_placement'); ?><br/>
                        <input type="radio" class="radio3" name="level" value="doesn't matter"  style="margin-left:10px;" <?php echo $radio2c; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('nomatter', 'local_placement'); ?></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span style="text-decoration:underline;"><?php echo get_string('specialisation', 'local_placement'); ?>:</span><br/>
                    <td/>
                </tr>
                <tr>
                <!--MAJOR-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('major', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:10px;" name="maj" class="required" value="<?php echo $stud->major; ?>"/>
                    </td>
                <!--MINOR-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('minor', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:100px;" name="min" class="required" value="<?php echo $stud->minor; ?>"/>
                    </td>
                </tr>
            </table>
        </div><br/>
        <div class="box1 center">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('pref', 'local_placement'); ?></span>
            <table>
                <tr>
                <!--CATHOLIC/PUBLIC-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('type', 'local_placement'); ?>:<br/><br/>
                        <div style=""><input <?php echo $radio3a; ?> type="radio" class="radio4" name="type" value="catholic" style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('catholic', 'local_placement'); ?></span><br/>
                        <input <?php echo $radio3b; ?> type="radio" class="radio4" name="type" value="public"  style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('public', 'local_placement'); ?></span><br/>
                        <input <?php echo $radio3c; ?> type="radio" class="radio4" name="type" value="doesn't matter"  style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('nomatter', 'local_placement'); ?></span></div>
                    </td>
                <!--CORE SUBJECT PREFERENCE-->
                    <td>
                        <?php echo get_string('subject', 'local_placement'); ?><br/><br/>
                        <select name="core">
                            <option <?php echo $select1; ?> value="none"><?php echo get_string('nomatter', 'local_placement'); ?></option>
                            <option <?php echo $select2; ?> value="language arts"><?php echo get_string('la', 'local_placement'); ?></option>
                            <option <?php echo $select3; ?> value="math"><?php echo get_string('math', 'local_placement'); ?></option>
                            <option <?php echo $select4; ?> value="science"><?php echo get_string('science', 'local_placement'); ?></option>
                            <option <?php echo $select5; ?> value="social studies"><?php echo get_string('social', 'local_placement'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                <!--SPECIFIC SCHOOL PREFERENCE-->
                    <td colspan="2"><br/><hr/><br/>
                        <?php echo get_string('specific', 'local_placement'); ?>:<br/><br/>
                        <select id="specific_preference" class="<?php echo $stud->specific_preference; ?>" name="specific">
                            <option value="0"><?php echo get_string('notrequired', 'local_placement'); ?></option>
                            <?php
                            foreach($schools as $s)
                            {
                            ?>
                            <option value="<?php echo $s->school; ?>"><?php echo $s->school; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                <!--OTHER PREFERENCES-->
                    <td colspan="2"><br/><hr/><br/>
                        <?php echo get_string('otherinfo', 'local_placement'); ?><br/><br/>
                        <textarea name="pref" cols="110" rows="10" style="resize:none;"><?php echo $stud->preferences; ?></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <table>
            <tr>
                <td>
                    <div style="float:right;margin-top:10px;margin-bottom:-10px;">
                        <input type="submit" class="generalbutton" onclick="check_radio('initial', 'true');" style="font-size:12px;width:150px;margin-right:10px;" value="<?php echo get_string('save', 'local_placement'); ?>"/>
                        <button class="generalbutton" onclick="" style="font-size:12px;width:150px;"><?php echo get_string('cancel', 'local_placement'); ?></button>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    </form>
    <?php
}


/**
* Form for adding a teacher
*
* @global moodle_database $DB
* @global stdClass $USER
* @global stdClass $CFG
**/
function stage1_edit()
{
    global $DB, $CFG, $USER;
    $std = $DB->get_record('user', array('id' => $USER->id));
    $stud = $DB->get_record('placement_stage1', array("email" => $std->email));
    $schools = $DB->get_records('placement_school', array(), 'school');
    
    //These if statements determine which radio buttons and checkboxes to fill
    
    $radio1a = '';
    $radio1b = '';
    if($stud->program == 'francophone')
    {
        $radio1a = 'checked="checked"';
        $radio1b = '';
    }
    else
    {
        $radio1a = '';
        $radio1b = 'checked="checked"';
    }
    
    $radio2a = '';
    $radio2b = '';
    $radio2c = '';
    switch($stud->type)
    {
        case 'elementary':
            $radio2a = 'checked="checked"';
            $radio2b = '';
            $radio2c = '';
            break;
        case 'secondary':
            $radio2a = '';
            $radio2b = 'checked="checked"';
            $radio2c = '';
            break;
        case 'doesn\'t matter':
            $radio2a = '';
            $radio2b = '';
            $radio2c = 'checked="checked"';
            break;
    }
    
    $radio3a = '';
    $radio3b = '';
    $radio3c = '';
    switch($stud->schooltype)
    {
        case 'catholic':
            $radio3a = 'checked="checked"';
            $radio3b = '';
            $radio3c = '';
            break;
        case 'public':
            $radio3a = '';
            $radio3b = 'checked="checked"';
            $radio3c = '';
            break;
        case 'doesn\'t matter':
            $radio3a = '';
            $radio3b = '';
            $radio3c = 'checked="checked"';
            break;
    }
    
    $radio4a = '';
    $radio4b = '';
    if($stud->rural_placement == 'y')
    {
        $radio4a = 'checked="checked"';
        $radio4b = '';
    }
    else
    {
        $radio4a = '';
        $radio4b = 'checked="checked"';
    }
    
    $radio5a = '';
    $radio5b = '';
    if($stud->rural_scholarship == 'y')
    {
        $radio5a = 'checked="checked"';
        $radio5b = '';
    }
    else if($stud->rural_scholarship == 'n')
    {
        $radio5a = '';
        $radio5b = 'checked="checked"';
    }
    
    $radio6a = '';
    $radio6b = '';
    if($stud->rural_accomidation == 'y')
    {
        $radio6a = 'checked="checked"';
        $radio6b = '';
    }
    else if($stud->rural_accomidation == 'n')
    {
        $radio6a = '';
        $radio6b = 'checked="checked"';
    }
    
    switch($stud->subject_preference)
    {
        case 'none':
            $select1 = 'selected=selected';
            $select2 = '';
            $select3 = '';
            $select4 = '';
            $select5 = '';
            break;
        case 'language arts':
            $select1 = '';
            $select2 = 'selected=selected';
            $select3 = '';
            $select4 = '';
            $select5 = '';
            break;
        case 'math':
            $select1 = '';
            $select2 = '';
            $select3 = 'selected=selected';
            $select4 = '';
            $select5 = '';
            break;
        case 'science':
            $select1 = '';
            $select2 = '';
            $select3 = '';
            $select4 = 'selected=selected';
            $select5 = '';
            break;
        case 'social studies':
            $select1 = '';
            $select2 = '';
            $select3 = '';
            $select4 = '';
            $select5 = 'selected=selected';
            break;
    }
    ?>
    <!--FORM PROVIDES VALIDATION - REQUIRED FIELDS MUST BE FILLED-->
    <form class="required-form" name="newstudent" id="newstudent">
    <div class="center" style="width:900px;">
    </div>
    <div class="center" style="width:850px;font-size:20px;font-weight:bold;text-decoration:underline;"><?php echo $stud->firstname . ' ' . $stud->lastname; ?></div>
    <div align="center"><a href="#" onclick="change_stage(2)"><?php echo get_string('chooseanother', 'local_placement'); ?></a></div>
    <div class="box1 center" style="width:800px;margin-top:40px;">
        <span class="whitetitle" style="font-size:20px;top:-17px;"><?php echo get_string('register', 'local_placement'); ?></span>
        <div class="box1 center">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('personal', 'local_placement'); ?></span>
            <table id="alert" class="<?php echo get_string('required', 'local_placement'); ?>">
                <tr id="saved" class="<?php echo get_string('usersaved', 'local_placement'); ?>">
                <!--FIRSTNAME-->
                    <td id="cfg" class="<?php echo $CFG->wwwroot; ?>">
                        <span style="color:red;">*</span><?php echo get_string('firstname', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="firstname" class="required" value="<?php echo $stud->firstname; ?>"/>
                    </td>
                <!--LASTNAME-->
                    <td id="onealert" class="0">
                        <span style="color:red;">*</span><?php echo get_string('lastname', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="lastname" class="required" value="<?php echo $stud->lastname; ?>"/>
                    </td>
                </tr>
                <tr id="studentid" class="<?php echo $stud->student_teacher_id; ?>">
                <!--PHONE NUMBER-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('phone', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="phone" class="required" value="<?php echo $stud->phone; ?>"/>
                    </td>
                <!--EMAIL-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('email', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="email" class="required email" value="<?php echo $stud->email; ?>"/>
                    </td>
                </tr>
                <tr>
                <!--ADDRESS-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('address', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="address" class="required" value="<?php echo $stud->address; ?>"/>
                    </td>
                <!--CITY-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('city', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="city" class="required" value="<?php echo $stud->city; ?>"/>
                    </td>
                </tr>
                <tr>
                <!--ONECARD-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('onecard', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="onecard" class="required" value="<?php echo $stud->onecard; ?>"/>
                    </td>
                <!--VEHICLE-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('vehicle', 'local_placement'); ?>:
                        <?php
                        if($stud->vehicle == 'y')
                        {
                        ?>
                        <select name="vehicle" style="margin-left:8px;">
                            <option value="n"><?php echo get_string('no', 'local_placement'); ?></option>
                            <option value="y" selected="selected"><?php echo get_string('yes', 'local_placement'); ?></option>
                        </select>
                        <?php
                        }
                        else
                        {
                        ?>
                        <select name="vehicle" style="margin-left:8px;">
                            <option value="n" selected="selected"><?php echo get_string('no', 'local_placement'); ?></option>
                            <option value="y"><?php echo get_string('yes', 'local_placement'); ?></option>
                        </select>
                        <?php
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </div><br/>
        <div class="box1 center">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('programinfo', 'local_placement'); ?></span>
            <table>
                <tr>
                <!--FRANCOPHONE/IMMERSION-->
                    <td>
                        <div style="margin-top:-20px;"><span style="color:red;">*</span><?php echo get_string('langpro', 'local_placement'); ?>:
                        <div class="move" style="float:right;margin-right:30px;"><input type="radio" class="radio2" name="lang" value="francophone" <?php echo $radio1a; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('french', 'local_placement'); ?></span><br/>
                        <input type="radio" class="radio2" name="lang" value="immersion" <?php echo $radio1b; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('immersion', 'local_placement'); ?></span></div>
                    </td>
                <!--ELEMENTARY/SECONDARY-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('schoollev', 'local_placement'); ?>:
                        <div class="move" style="float:right;margin-right:30px;"><input type="radio" class="radio3" name="level" value="elementary" style="margin-left:10px;" <?php echo $radio2a; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('elementary', 'local_placement'); ?></span><br/>
                        <input type="radio" class="radio3" name="level" value="secondary"  style="margin-left:10px;" <?php echo $radio2b; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('secondary', 'local_placement'); ?><br/>
                        <input type="radio" class="radio3" name="level" value="doesn't matter"  style="margin-left:10px;" <?php echo $radio2c; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('nomatter', 'local_placement'); ?></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span style="text-decoration:underline;"><?php echo get_string('specialisation', 'local_placement'); ?>:</span><br/>
                    <td/>
                </tr>
                <tr>
                <!--MAJOR-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('major', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:10px;" name="maj" class="required" value="<?php echo $stud->major; ?>"/>
                    </td>
                <!--MINOR-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('minor', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:100px;" name="min" class="required" value="<?php echo $stud->minor; ?>"/>
                    </td>
                </tr>
            </table>
        </div><br/>
        <div class="box1 center" style="margin-bottom:20px;">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('pref', 'local_placement'); ?></span>
            <table>
                <tr>
                <!--CATHOLIC/PUBLIC-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('type', 'local_placement'); ?>:<br/><br/>
                        <div style=""><input <?php echo $radio3a; ?> type="radio" class="radio4" name="type" value="catholic" style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('catholic', 'local_placement'); ?></span><br/>
                        <input <?php echo $radio3b; ?> type="radio" class="radio4" name="type" value="public"  style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('public', 'local_placement'); ?></span><br/>
                        <input <?php echo $radio3c; ?> type="radio" class="radio4" name="type" value="doesn't matter"  style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('nomatter', 'local_placement'); ?></span></div>
                    </td>
                <!--CORE SUBJECT PREFERENCE-->
                    <td>
                        <?php echo get_string('subject', 'local_placement'); ?><br/><br/>
                        <select name="core">
                            <option <?php echo $select1; ?> value="none"><?php echo get_string('nomatter', 'local_placement'); ?></option>
                            <option <?php echo $select2; ?> value="language arts"><?php echo get_string('la', 'local_placement'); ?></option>
                            <option <?php echo $select3; ?> value="math"><?php echo get_string('math', 'local_placement'); ?></option>
                            <option <?php echo $select4; ?> value="science"><?php echo get_string('science', 'local_placement'); ?></option>
                            <option <?php echo $select5; ?> value="social studies"><?php echo get_string('social', 'local_placement'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br/><hr/>
                    </td>
                </tr>
                <tr>
                <!--RURAL PLACEMENT YES/NO-->
                    <td colspan="2">
                        <span style="color:red;">*</span><?php echo get_string('rural', 'local_placement'); ?>:
                        <input id="yes" type="radio" class="radio5" name="rural" value="y" style="margin-left:20px;" <?php echo $radio4a; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('yes', 'local_placement'); ?></span>
                        <input type="radio" class="radio5" name="rural" value="n" style="margin-left:10px;" <?php echo $radio4b; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('no', 'local_placement'); ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br/><span style="margin-left:20px;font-weight:bold;">-  <?php echo get_string('ifyes', 'local_placement'); ?>:</span>
                    </td>
                </tr>
                <tr>
                <!--RURAL LOCATION-->
                    <td>
                        <br/><p><span class="show" style="color:red;display:none;">*</span><?php echo get_string('location', 'local_placement'); ?>:<span>    </span><input name="location" type="text" value="<?php echo $stud->rural_location; ?>"/></p>
                    </td>
                </tr>
                <tr>
                <!--RURAL SCHOLARSHIP YES/NO-->
                    <td colspan="2"><br/>
                        <span class="show" style="color:red;display:none;">*</span><?php echo get_string('scholarship', 'local_placement'); ?>:
                        <input type="radio" class="radio6" name="scholarship" value="y" style="margin-left:30px;" <?php echo $radio5a; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('yes', 'local_placement'); ?></span>
                        <input type="radio" class="radio6" name="scholarship" value="n"  style="margin-left:10px;" <?php echo $radio5b; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('no', 'local_placement'); ?></span><br/>
                        <b><?php echo get_string('scholdetail', 'local_placement'); ?></b>
                    </td>
                </tr>
                <tr>
                <!--RURAL HOUSING ACCOMMODATION YES/NO-->
                    <td colspan="2"><br/>
                        <span class="show" style="color:red;display:none;">*</span><?php echo get_string('housing', 'local_placement'); ?>:
                        <input type="radio" class="radio7" name="housing" value="y" style="margin-left:30px;" <?php echo $radio6a; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('yes', 'local_placement'); ?></span>
                        <input type="radio" class="radio7" name="housing" value="n"  style="margin-left:10px;" <?php echo $radio6b; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('no', 'local_placement'); ?></span>
                    </td>
                </tr>
                <tr>
                <!--SPECIFIC SCHOOL PREFERENCE-->
                    <td colspan="2"><br/><hr/><br/>
                        <?php echo get_string('specific', 'local_placement'); ?>:<br/><br/>
                        <select id="specific_preference" class="<?php echo $stud->specific_preference; ?>" name="specific">
                            <option value="0"><?php echo get_string('notrequired', 'local_placement'); ?></option>
                            <?php
                            foreach($schools as $s)
                            {
                            ?>
                            <option value="<?php echo $s->school; ?>"><?php echo $s->school; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                <!--OTHER PREFERENCES-->
                    <td colspan="2"><br/><hr/><br/>
                        <?php echo get_string('otherinfo', 'local_placement'); ?><br/><br/>
                        <textarea name="pref" cols="110" rows="10" style="resize:none;"><?php echo $stud->preferences; ?></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <div class="box1 center">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('first', 'local_placement'); ?></span>
            <table>
                <tr>
                <!--EDU STAGE TEACHER NAME-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('teachername', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:120px;" name="teacher" class="required" value="<?php echo $stud->initial_stage_teacher; ?>"/>
                    </td>
                <!--EDU STAGE SCHOOL NAME-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('school', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:120px;" name="school" class="required" value="<?php echo $stud->initial_stage_school; ?>"/>
                    </td>
                <!--EDU STAGE LEVEL-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('level', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:120px;" name="level2" class="required" value="<?php echo $stud->initial_stage_level; ?>"/>
                    </td>
                </tr>
            </table>
        </div>
        <table>
            <tr>
                <td>
                    <div style="float:right;margin-top:10px;margin-bottom:-10px;">
                        <input type="submit" class="generalbutton" onclick="check_radio('stage1', 'true');" style="font-size:12px;width:150px;margin-right:10px;" value="<?php echo get_string('save', 'local_placement'); ?>"/>
                        <button class="generalbutton" onclick="" style="font-size:12px;width:150px;"><?php echo get_string('cancel', 'local_placement'); ?></button>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    </form>
    <?php
}


/**
* Form for adding a teacher
*
* @global moodle_database $DB
* @global stdClass $USER
* @global stdClass $CFG
**/
function stage2_edit()
{
    global $DB, $CFG, $USER;
    $std = $DB->get_record('user', array('id' => $USER->id));
    $stud = $DB->get_record('placement_stage2', array("email" => $std->email));
    $schools = $DB->get_records('placement_school', array(), 'school');
    
    //these if statements determine which radio buttons or checkboxes to fill
    
    $radio1a = '';
    $radio1b = '';
    if($stud->program == 'francophone')
    {
        $radio1a = 'checked="checked"';
        $radio1b = '';
    }
    else
    {
        $radio1a = '';
        $radio1b = 'checked="checked"';
    }
    
    $radio2a = '';
    $radio2b = '';
    $radio2c = '';
    switch($stud->type)
    {
        case 'elementary':
            $radio2a = 'checked="checked"';
            $radio2b = '';
            $radio2c = '';
            break;
        case 'secondary':
            $radio2a = '';
            $radio2b = 'checked="checked"';
            $radio2c = '';
            break;
        case 'doesn\'t matter':
            $radio2a = '';
            $radio2b = '';
            $radio2c = 'checked="checked"';
            break;
    }
    
    $radio3a = '';
    $radio3b = '';
    $radio3c = '';
    switch($stud->schooltype)
    {
        case 'catholic':
            $radio3a = 'checked="checked"';
            $radio3b = '';
            $radio3c = '';
            break;
        case 'public':
            $radio3a = '';
            $radio3b = 'checked="checked"';
            $radio3c = '';
            break;
        case 'doesn\'t matter':
            $radio3a = '';
            $radio3b = '';
            $radio3c = 'checked="checked"';
            break;
    }
    
    $radio4a = '';
    $radio4b = '';
    if($stud->rural_placement == 'y')
    {
        $radio4a = 'checked="checked"';
        $radio4b = '';
    }
    else
    {
        $radio4a = '';
        $radio4b = 'checked="checked"';
    }
    
    $radio5a = '';
    $radio5b = '';
    if($stud->rural_scholarship == 'y')
    {
        $radio5a = 'checked="checked"';
        $radio5b = '';
    }
    else if($stud->rural_scholarship == 'n')
    {
        $radio5a = '';
        $radio5b = 'checked="checked"';
    }
    
    $radio6a = '';
    $radio6b = '';
    if($stud->rural_accomidation == 'y')
    {
        $radio6a = 'checked="checked"';
        $radio6b = '';
    }
    else if($stud->rural_accomidation == 'n')
    {
        $radio6a = '';
        $radio6b = 'checked="checked"';
    }
    
    switch($stud->subject_preference)
    {
        case 'none':
            $select1 = 'selected=selected';
            $select2 = '';
            $select3 = '';
            $select4 = '';
            $select5 = '';
            break;
        case 'language arts':
            $select1 = '';
            $select2 = 'selected=selected';
            $select3 = '';
            $select4 = '';
            $select5 = '';
            break;
        case 'math':
            $select1 = '';
            $select2 = '';
            $select3 = 'selected=selected';
            $select4 = '';
            $select5 = '';
            break;
        case 'science':
            $select1 = '';
            $select2 = '';
            $select3 = '';
            $select4 = 'selected=selected';
            $select5 = '';
            break;
        case 'social studies':
            $select1 = '';
            $select2 = '';
            $select3 = '';
            $select4 = '';
            $select5 = 'selected=selected';
            break;
    }
    ?>
    <!--FORM PROVIDES VALIDATION - REQUIRED FIELDS MUST BE FILLED-->
    <form class="required-form" name="newstudent" id="newstudent">
    <div class="center" style="width:900px;">
    </div>
    <div class="center" style="width:850px;font-size:20px;font-weight:bold;text-decoration:underline;"><?php echo $stud->firstname . ' ' . $stud->lastname; ?></div>
    <div align="center"><a href="#" onclick="change_stage(3)"><?php echo get_string('chooseanother', 'local_placement'); ?></a></div>
    <div class="box1 center" style="width:800px;margin-top:40px;">
        <span class="whitetitle" style="font-size:20px;top:-17px;"><?php echo get_string('register', 'local_placement'); ?></span>
        <div class="box1 center">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('personal', 'local_placement'); ?></span>
            <table id="alert" class="<?php echo get_string('required', 'local_placement'); ?>">
                <tr id="saved" class="<?php echo get_string('usersaved', 'local_placement'); ?>">
                <!--FIRSTNAME-->
                    <td id="cfg" class="<?php echo $CFG->wwwroot; ?>">
                        <span style="color:red;">*</span><?php echo get_string('firstname', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="firstname" class="required" value="<?php echo $stud->firstname; ?>"/>
                    </td>
                <!--LASTNAME-->
                    <td id="onealert" class="0">
                        <span style="color:red;">*</span><?php echo get_string('lastname', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="lastname" class="required" value="<?php echo $stud->lastname; ?>"/>
                    </td>
                </tr>
                <tr id="studentid" class="<?php echo $stud->student_teacher_id; ?>">
                <!--PHONE NUMBER-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('phone', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="phone" class="required" value="<?php echo $stud->phone; ?>"/>
                    </td>
                <!--EMAIL-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('email', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="email" class="required email" value="<?php echo $stud->email; ?>"/>
                    </td>
                </tr>
                <tr>
                <!--ADDRESS-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('address', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="address" class="required" value="<?php echo $stud->address; ?>"/>
                    </td>
                <!--CITY-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('city', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="city" class="required" value="<?php echo $stud->city; ?>"/>
                    </td>
                </tr>
                <tr>
                <!--ONECARD-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('onecard', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:50px;" name="onecard" class="required" value="<?php echo $stud->onecard; ?>"/>
                    </td>
                <!--VEHICLE-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('vehicle', 'local_placement'); ?>:
                        <?php
                        if($stud->vehicle == 'y')
                        {
                        ?>
                        <select name="vehicle" style="margin-left:8px;">
                            <option value="n"><?php echo get_string('no', 'local_placement'); ?></option>
                            <option value="y" selected="selected"><?php echo get_string('yes', 'local_placement'); ?></option>
                        </select>
                        <?php
                        }
                        else
                        {
                        ?>
                        <select name="vehicle" style="margin-left:8px;">
                            <option value="n" selected="selected"><?php echo get_string('no', 'local_placement'); ?></option>
                            <option value="y"><?php echo get_string('yes', 'local_placement'); ?></option>
                        </select>
                        <?php
                        }
                        ?>
                    </td>
                </tr>
            </table>
        </div><br/>
        <div class="box1 center">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('programinfo', 'local_placement'); ?></span>
            <table>
                <tr>
                <!--FRANCOPHONE/IMMERSION-->
                    <td>
                        <div style="margin-top:-20px;"><span style="color:red;">*</span><?php echo get_string('langpro', 'local_placement'); ?>:
                        <div class="move" style="float:right;margin-right:30px;"><input type="radio" class="radio2" name="lang" value="francophone" <?php echo $radio1a; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('french', 'local_placement'); ?></span><br/>
                        <input type="radio" class="radio2" name="lang" value="immersion" <?php echo $radio1b; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('immersion', 'local_placement'); ?></span></div>
                    </td>
                <!--ELEMENTARY/SECONDARY-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('schoollev', 'local_placement'); ?>:
                        <div class="move" style="float:right;margin-right:30px;"><input type="radio" class="radio3" name="level" value="elementary" style="margin-left:10px;" <?php echo $radio2a; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('elementary', 'local_placement'); ?></span><br/>
                        <input type="radio" class="radio3" name="level" value="secondary"  style="margin-left:10px;" <?php echo $radio2b; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('secondary', 'local_placement'); ?><br/>
                        <input type="radio" class="radio3" name="level" value="doesn't matter"  style="margin-left:10px;" <?php echo $radio2c; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('nomatter', 'local_placement'); ?></div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <span style="text-decoration:underline;"><?php echo get_string('specialisation', 'local_placement'); ?>:</span><br/>
                    <td/>
                </tr>
                <tr>
                <!--MAJOR-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('major', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:10px;" name="maj" class="required" value="<?php echo $stud->major; ?>"/>
                    </td>
                <!--MINOR-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('minor', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;margin-right:100px;" name="min" class="required" value="<?php echo $stud->minor; ?>"/>
                    </td>
                </tr>
            </table>
        </div><br/>
        <div class="box1 center" style="margin-bottom:20px;">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('pref', 'local_placement'); ?></span>
            <table>
                <tr>
                <!--CATHOLIC/PREFERENCE-->
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('type', 'local_placement'); ?>:<br/><br/>
                        <div style=""><input <?php echo $radio3a; ?> type="radio" class="radio4" name="type" value="catholic" style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('catholic', 'local_placement'); ?></span><br/>
                        <input <?php echo $radio3b; ?> type="radio" class="radio4" name="type" value="public"  style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('public', 'local_placement'); ?></span><br/>
                        <input <?php echo $radio3c; ?> type="radio" class="radio4" name="type" value="doesn't matter"  style="margin-left:10px;"/><span style="font-weight:bold;"><?php echo ' ' . get_string('nomatter', 'local_placement'); ?></span></div>
                    </td>
                <!--CORE SUBJECT PREFERENCES-->
                    <td>
                        <?php echo get_string('subject', 'local_placement'); ?><br/><br/>
                        <select name="core">
                            <option <?php echo $select1; ?> value="none"><?php echo get_string('nomatter', 'local_placement'); ?></option>
                            <option <?php echo $select2; ?> value="language arts"><?php echo get_string('la', 'local_placement'); ?></option>
                            <option <?php echo $select3; ?> value="math"><?php echo get_string('math', 'local_placement'); ?></option>
                            <option <?php echo $select4; ?> value="science"><?php echo get_string('science', 'local_placement'); ?></option>
                            <option <?php echo $select5; ?> value="social studies"><?php echo get_string('social', 'local_placement'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <br/><hr/>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span style="color:red;">*</span><?php echo get_string('rural', 'local_placement'); ?>:
                        <input id="yes" type="radio" class="radio5" name="rural" value="y" style="margin-left:20px;" <?php echo $radio4a; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('yes', 'local_placement'); ?></span>
                        <input type="radio" class="radio5" name="rural" value="n" style="margin-left:10px;" <?php echo $radio4b; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('no', 'local_placement'); ?></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br/><span style="margin-left:20px;font-weight:bold;">-  <?php echo get_string('ifyes', 'local_placement'); ?>:</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br/><p><span class="show" style="color:red;display:none;">*</span><?php echo get_string('location', 'local_placement'); ?>:<span>    </span><input name="location" type="text" value="<?php echo $stud->rural_location; ?>"/></p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><br/>
                        <span class="show" style="color:red;display:none;">*</span><?php echo get_string('scholarship', 'local_placement'); ?>:
                        <input type="radio" class="radio6" name="scholarship" value="y" style="margin-left:30px;" <?php echo $radio5a; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('yes', 'local_placement'); ?></span>
                        <input type="radio" class="radio6" name="scholarship" value="n"  style="margin-left:10px;" <?php echo $radio5b; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('no', 'local_placement'); ?></span><br/>
                        <b><?php echo get_string('scholdetail', 'local_placement'); ?></b>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><br/>
                        <span class="show" style="color:red;display:none;">*</span><?php echo get_string('housing', 'local_placement'); ?>:
                        <input type="radio" class="radio7" name="housing" value="y" style="margin-left:30px;" <?php echo $radio6a; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('yes', 'local_placement'); ?></span>
                        <input type="radio" class="radio7" name="housing" value="n"  style="margin-left:10px;" <?php echo $radio6b; ?>/><span style="font-weight:bold;"><?php echo ' ' . get_string('no', 'local_placement'); ?></span>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><br/><hr/><br/>
                        <?php echo get_string('specific', 'local_placement'); ?>:<br/><br/>
                        <select id="specific_preference" class="<?php echo $stud->specific_preference; ?>" name="specific">
                            <option value="0"><?php echo get_string('notrequired', 'local_placement'); ?></option>
                            <?php
                            foreach($schools as $s)
                            {
                            ?>
                            <option value="<?php echo $s->school; ?>"><?php echo $s->school; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><br/><hr/><br/>
                        <?php echo get_string('otherinfo', 'local_placement'); ?><br/><br/>
                        <textarea name="pref" cols="110" rows="10" style="resize:none;"><?php echo $stud->preferences; ?></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <div class="box1 center" style="margin-bottom:20px;">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('first', 'local_placement'); ?></span>
            <table>
                <tr>
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('teachername', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:120px;" name="teacher" class="required" value="<?php echo $stud->initial_stage_teacher; ?>"/>
                    </td>
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('school', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:120px;" name="school" class="required" value="<?php echo $stud->initial_stage_school; ?>"/>
                    </td>
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('level', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:120px;" name="level2" class="required" value="<?php echo $stud->initial_stage_level; ?>"/>
                    </td>
                </tr>
            </table>
        </div>
        <div class="box1 center">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('second', 'local_placement'); ?></span>
            <table>
                <tr>
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('teachername', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:120px;" name="teacher2" class="required" value="<?php echo $stud->stage1_teacher; ?>"/>
                    </td>
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('school', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:120px;" name="school2" class="required" value="<?php echo $stud->stage1_school; ?>"/>
                    </td>
                    <td>
                        <span style="color:red;">*</span><?php echo get_string('level', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:120px;" name="level3" class="required" value="<?php echo $stud->stage1_level; ?>"/>
                    </td>
                </tr>
            </table>
        </div>
        <table>
            <tr>
                <td>
                    <div style="float:right;margin-top:10px;margin-bottom:-10px;">
                        <input type="submit" class="generalbutton" onclick="check_radio('stage2', 'true');" style="font-size:12px;width:150px;margin-right:10px;" value="<?php echo get_string('save', 'local_placement'); ?>"/>
                        <button class="generalbutton" onclick="" style="font-size:12px;width:150px;"><?php echo get_string('cancel', 'local_placement'); ?></button>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    </form>
    <?php
}
?>
