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

//This page provides functions for principal tools called from viewprincipal.php

/**
* Shows a list of teachers and provides buttons for editing school info, teacher info or adding/removing a new teacher
*
* @global moodle_database $DB
* @global stdClass $USER
* @global stdClass $CFG
**/
function admin_view() {
    global $DB, $CFG, $USER;
    $school = $DB->get_record('placement_users', array('userid' => $USER->id));
    $teachers = $DB->get_records('placement_coop_teachers', array('school' => $school->school));
    $sfo = $DB->get_record('placement_users', array("userid" => $USER->id));
    ?>
<br/><div class="center" style="width:900px;">
<div class="center" style="width:850px;font-size:20px;font-weight:bold;text-decoration:underline;"><?php echo $sfo->school; ?> - <?php echo $sfo->schoolboard; ?></div>
    <div class="center" style="border:1px black solid;width:800px;height:450px;margin-top:40px;">
        <p class="whitetitle" style="width:140px;font-size:23px;top:-10px;">Administration</p>
    <!--EDIT SCHOOL BUTTON-->
        <button class="generalbutton" onclick="edit_sch();" style="width:250px;margin-left:30px;"><?php echo get_string('editschool', 'local_placement'); ?></button>
        <p style="margin-left:30px;margin-top:10px;font-size:15px;"><?php echo get_string('available', 'local_placement'); ?></p>
        <div id="alert" class="<?php echo get_string('chooseteacher', 'local_placement'); ?>" style="height:35px;width:76px;background-color:grey;border:1px black solid;margin-left:30px;"></div>
        <div id="cfg" class="<?php echo $CFG->wwwroot; ?>" style="height:35px;width:244px;background-color:grey;border:1px black solid;margin-left:106px;margin-top:-37px;"><p style="margin-top:10px;margin-left:20px;color:white;"><?php echo get_string('name', 'local_placement'); ?></p></div>
        <div id="removed" class="<?php echo get_string('removed', 'local_placement'); ?>" style="height:35px;width:279px;background-color:grey;border:1px black solid;margin-left:351px;margin-top:-37px;"></div>
        <div style="overflow-y:scroll;width:600px;height:200px;border:1px black solid;margin-left:30px;margin-top:-1px;">
        <!--LIST OF TEACHERS BELONGING TO THE SCHOOL-->
            <table style="border:1px black solid;margin-left:-1px;margin-top:-1px;">
                <?php
                foreach ($teachers as $t) {
                    echo '<tr>';
                    echo '<td style="width:38px;border:1px black solid;"><input type="radio" class="radio1" value="'.$t->id.'" alt="'.$CFG->wwwroot.'" name="teacher" style="margin-left:12px;"/></td><td style="width:236px;border:1px black solid;">' . $t->firstname . ' ' . $t->lastname . '</td><td style="width:270px;border:1px black solid;"></td>';
                    echo '</tr>';
                }
                ?>
            </table>
        </div>
        <span id="confirm" class="<?php echo get_string('removeconfirm', 'local_placement'); ?>"></span>
        <span id="load"></span>
        <button class="generalbutton" onclick="edit();" style="width:200px;margin-left:30px;margin-top:30px;font-size:12px;"><?php echo get_string('editselected', 'local_placement'); ?></button>
        <button class="generalbutton" onclick="remove_teacher();" style="width:200px;margin-left:30px;margin-top:30px;font-size:12px;"><?php echo get_string('removeteacher', 'local_placement'); ?></button>
        <button class="generalbutton" onclick="add_teacher();"style="width:200px;margin-left:30px;margin-top:30px;font-size:12px;"><?php echo get_string('addnew', 'local_placement'); ?></button>
    </div>
</div>

<?php
}

/**
* Form for editing school information
*
* @global moodle_database $DB
* @global stdClass $USER
* @global stdClass $CFG
**/
function edit_school_view() {
    global $DB, $CFG, $USER;
    $boards = $DB->get_records('placement_schoolboard', array());
    if (get_string('lang', 'local_placement') == 'en') {
        $width = '200px';
        $width2 = '44px';
    } else {
        $width = '186px';
        $width2 = '116px';
    }
    
    $sid = $DB->get_record('placement_users', array("userid" => $USER->id));
    $sinfo = $DB->get_record('placement_school', array("schoolid" => $sid->schoolid));
    ?>
<br/><div class="center" style="width:900px;">
<div class="center" style="width:850px;font-size:20px;font-weight:bold;text-decoration:underline;"><?php echo $sinfo->school; ?> - <?php echo $sinfo->schoolboard; ?></div>
    <div class="center" style="border:1px black solid;width:800px;height:460px;margin-top:40px;">
        <p class="whitetitle" style="width:<?php echo $width; ?>;font-size:20px;top:-12px;margin-bottom:5px;"><?php echo get_string('editschool', 'local_placement'); ?></p>
        <div style="border:1px black solid;width:300px;height:230px;margin-left:10px;">
            <p class="whitetitle" style="width:55px;font-size:15px;top:-10px;margin-bottom:-12px;"><?php echo get_string('address', 'local_placement'); ?></p>
            <table id="cfg" class="<?php echo $CFG->wwwroot; ?>">
                <!--NAME OF SCHOOL-->
                <tr id="req" class="<?php echo get_string('required', 'local_placement'); ?>">
                    <td id="saved" class="<?php echo get_string('usersaved', 'local_placement'); ?>">
                        <span style="color:red;">*</span><span><?php echo get_string('name', 'local_placement'); ?>:</span><input id="name"  type="text" style="float:right;width:170px;" value="<?php echo $sinfo->school; ?>"/>
                    </td>
                </tr>
                <!--ADDRESS-->
                <tr>
                    <td>
                        <span style="color:red;">*</span><span><?php echo get_string('address', 'local_placement'); ?>:</span><textarea id="address"  rows="3" style="float:right;width:170px;resize:none;"><?php echo $sinfo->address; ?></textarea>
                    </td>
                </tr>
                <!--CITY-->
                <tr>
                    <td>
                        <span style="color:red;">*</span><span><?php echo get_string('city', 'local_placement'); ?>:</span><input id="city"  type="text" style="float:right;width:170px;" value="<?php echo $sinfo->city; ?>"/>
                    </td>
                </tr>
                <!--PHONE NUMBER-->
                <tr>
                    <td>
                        <span style="color:red;">*</span><span><?php echo get_string('phone', 'local_placement'); ?>:</span><input id="schoolphone"  type="text" style="float:right;width:170px;" value="<?php echo $sinfo->phone; ?>"/>
                    </td>
                </tr>
                <!--FAX NUMBER-->
                <tr>
                    <td>
                        <span><? echo get_string('fax', 'local_placement'); ?></span><input type="text" id="fax" value="<?php echo $sinfo->fax; ?>" style="float:right;width:170px;"/>
                    </td>
                </tr>
                <!--PROVINCE-->
                <tr>
                    <td>
                        <span style="color:red;">*</span><span><?php echo get_string('province', 'local_placement'); ?>:</span>
                        <select id="province" style="list-style-type:none;margin-left:13px;" name="<?php echo $sinfo->province; ?>">
                            <option value="AB">AB</option>
                            <option value="BC">BC</option>
                            <option value="MB">MB</option>
                            <option value="NB">NB</option>
                            <option value="NL">NL</option>
                            <option value="NS">NS</option>
                            <option value="NT">NT</option>
                            <option value="NU">NU</option>
                            <option value="PE">PE</option>
                            <option value="QC">QC</option>
                            <option value="QN">QN</option>
                            <option value="SK">SK</option>
                            <option value="YT">YT</option>
                        </select>
                        <span style="color:red;margin-left:10px;">*</span><span style="margin-left:10px;"><?php echo get_string('postal', 'local_placement'); ?></span><input id="postal"  type="text" maxlength="7" style="float:right;width:65px;" value="<?php echo $sinfo->postalcode; ?>"/>
                    </td>
                </tr>
            </table>
            <div style="border:1px black solid;width:470px;height:230px;position:relative;left:309px;bottom:237px;">
            <!--CONTACT INFO-->
            <p class="whitetitle" style="width:60px;font-size:15px;top:-10px;margin-bottom:-15px;">Contacts</p>
            <table>
                <tr>
                    <td>
                        <b style="text-decoration:underline;"><?php echo get_string('principal', 'local_placement'); ?></b>
                    </td>
                </tr>
                <!--PRINCIPAL FIRSTNAME-->
                <tr>
                    <td>
                        <span style="color:red;">*</span><span><?php echo get_string('firstname', 'local_placement'); ?>:</span><input id="firstname"  type="text" style="float:right;width:110px;" value="<?php echo $sinfo->principalfirstname; ?>"/>
                    </td>
                <!--PRINCIPAL LASTNAME-->
                    <td>
                        <span style="color:red;">*</span><span><?php echo get_string('lastname', 'local_placement'); ?>:</span><input id="lastname"  type="text" style="float:right;width:110px;" value="<?php echo $sinfo->principallastname; ?>"/>
                    </td>
                </tr>
                <!--PRINCIPAL EMAIL-->
                <tr>
                    <td>
                        <span style="color:red;">*</span><span><?php echo get_string('email', 'local_placement'); ?>:</span><input id="email"  type="text" style="float:right;width:110px;" value="<?php echo $sinfo->email; ?>"/>
                    </td>
                <!--PRINCIPAL PHONE NUMBER-->
                    <td>
                        <span style="color:red;">*</span><span><?php echo get_string('phone', 'local_placement'); ?>:</span><input id="phone"  type="text" style="float:right;width:110px;" value="<?php echo $sinfo->principalphone; ?>"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b style="text-decoration:underline;"><?php echo get_string('main', 'local_placement'); ?></b>
                    </td>
                </tr>
                <tr>
                <!--CONTACT FIRSTNAME-->
                    <td>
                        <span style="color:red;">*</span><span><?php echo get_string('firstname', 'local_placement'); ?>:</span><input id="firstnamecon"  type="text" style="float:right;width:110px;" value="<?php echo $sinfo->contactfirstname; ?>"/>
                    </td>
                <!--CONTACT LASTNAME-->
                    <td>
                        <span style="color:red;">*</span><span><?php echo get_string('lastname', 'local_placement'); ?>:</span><input id="lastnamecon"  type="text" style="float:right;width:110px;" value="<?php echo $sinfo->contactlastname; ?>"/>
                    </td>
                </tr>
                <tr>
                <!--CONTACT PHONE NUMBER-->
                    <td>
                        <span style="color:red;">*</span><span><?php echo get_string('phone', 'local_placement'); ?>:</span><input id="phonecon"  type="text" style="float:right;width:110px;" value="<?php echo $sinfo->contactphone; ?>"/>
                    </td>
                <!--CONTACT LANGUAGE-->
                    <td>
                        <span style="color:red;">*</span><span><?php echo get_string('language', 'local_placement'); ?>:</span>
                        <select id="lang" style="list-style-type:none;margin-right:71px;float:right;" name="<?php echo $sinfo->contactlang; ?>">
                            <option value="fr">fr</option>
                            <option value="en">en</option>
                        </select>
                    </td>
                </tr>
                <tr>
                <!--CONTACT EMAIL-->
                    <td>
                        <span style="color:red;">*</span><span><?php echo get_string('email', 'local_placement'); ?>:</span><input id="emailcon"  type="text" style="float:right;width:110px;" value="<?php echo $sinfo->contactemail; ?>"/>
                    </td>
                <!--CONTACT GENDER-->
                    <td>
                        <span style="color:red;">*</span><span><?php echo get_string('sex', 'local_placement'); ?>:</span>
                        <select id="sex" style="list-style-type:none;float:right;margin-right:75px;" name="<?php echo $sinfo->contactsex; ?>">
                            <option value="m">M</option>
                            <option value="f">F</option>
                        </select>
                    </td>
                </tr>
            </table>
            </div>
            <div style="border:1px black solid;width:780px;height:140px;position:relative;top:-224px;">
                <p class="whitetitle" style="width:<?php echo $width2; ?>;font-size:15px;top:-10px;margin-bottom:0px;"><?php echo get_string('other', 'local_placement'); ?></p>
                <table>
                <tr>
                <!--SCHOOLBOARD-->
                    <td>
                        <span style="color:red;">*</span><span><?php echo get_string('board', 'local_placement'); ?>:</span>
                        <select id="board" style="width:250px;float:right;" name="<?php echo $sinfo->schoolboard; ?>">
                        <?php
                            foreach ($boards as $b)
                                echo '<option>' . $b->name . '</option>';
                            ?>
                        </select>
                    </td>
                <!--WEBSITE-->
                    <td>
                        <span style="color:red;">*</span><span><?php echo get_string('website', 'local_placement'); ?>:</span><input id="website" type="text" style="width:200px;float:right;" value="<?php echo $sinfo->website; ?>"/>
                    </td>
                </tr>
                <tr>
                <!--FRANCOPHONE/IMMERSION-->
                    <td>
                        <span style="color:red;">*</span><span style="margin-right:10px;"  value="<?php echo $sinfo->school; ?>"><?php echo get_string('program', 'local_placement'); ?>:</span>
                        <select id="program" style="list-style-type:none;margin-left:5px;float:right;margin-right:130px;width:120px;" name="<?php echo $sinfo->program; ?>">
                            <option value="immersion"><?php echo get_string('immersion', 'local_placement'); ?></option>
                            <option value="french"><?php echo get_string('french', 'local_placement'); ?></option>
                        </select>
                    </td>
                <!--ZONE-->
                    <td>
                        <span style="color:red;">*</span><span><?php echo get_string('zone', 'local_placement'); ?>:</span><input id="zone" type="text" style="width:200px;float:right;" value="<?php echo $sinfo->zone; ?>"/>
                    </td>
                </tr>
                <tr>
                <!--CATHOLIC/PUBLIC-->
                    <td>
                        <span style="color:red;">*</span><span><?php echo get_string('schooltype', 'local_placement'); ?>:</span>
                        <select id="type" style="width:120px;float:right;margin-right:130px;" name="<?php echo $sinfo->schoolboard; ?>">
                            <option value="public"><?php echo get_string('public', 'local_placement'); ?></option>
                            <option value="catholic"><?php echo get_string('catholic', 'local_placement'); ?></option>
                        </select>
                    </td>
                <!--ELEMENTARY/SECONDARY-->
                    <td>
                        <span style="color:red;">*</span><span><?php echo get_string('schoollev', 'local_placement'); ?>:</span>
                        <select id="lev" style="width:120px;float:right;" name="<?php echo $sinfo->schoolboard; ?>">
                            <option value="elementary"><?php echo get_string('elementary', 'local_placement'); ?></option>
                            <option value="secondary"><?php echo get_string('secondary', 'local_placement'); ?></option>
                            <option value="mixed"><?php echo get_string('mix', 'local_placement'); ?></option>
                        </select>
                    </td>
                </tr>
                </table>
            </div>
            <button class="generalbutton" onclick="save_school();" style="font-size:12px;width:150px;position:relative;bottom:215px;left:470px;" ><?php echo get_string('save', 'local_placement'); ?></button>
            <button onclick="return_admin();" class="generalbutton" style="font-size:12px;width:150px;position:relative;bottom:245px;left:630px;"><?php echo get_string('cancel', 'local_placement'); ?></button>
        </div>
    </div>
<?php
    
}

/**
* Form for adding a teacher
*
* @global moodle_database $DB
* @global stdClass $USER
* @global stdClass $CFG
**/
function add_view() {
    global $CFG, $USER, $DB;
    
    $fo = $DB->get_record('placement_users', array("userid" => $USER->id));
    ?>
    <br/><div class="center" style="width:900px;">
<div class="center" style="width:850px;font-size:20px;font-weight:bold;text-decoration:underline;"><?php echo $fo->school; ?> - <?php echo $fo->schoolboard; ?></div>
    <!--FORM PROVIDES VALIDATION - REQUIRED FIELDS MUST BE FILLED-->
    <form class="required-form" id="newteacher" name="newteacher">
    <div class="box1 center" style="width:800px;margin-top:40px;">
        <span class="whitetitle" style="font-size:20px;top:-17px;"><?php echo get_string('addnew', 'local_placement'); ?></span>
        <span class="whitetitle" style="left:-145px;"><?php echo get_string('personal', 'local_placement'); ?></span>
        <div class="box1">
            <table id="cfg" class="<?php echo $CFG->wwwroot; ?>">
                <tr id="worked" class="<?php echo get_string('added', 'local_placement'); ?>">
                <!--FIRSTNAME-->
                    <td id="choosestage" class="<?php echo get_string('choosestage', 'local_placement'); ?>">
                        <?php echo get_string('firstname', 'local_placement'); ?>:
                        <input type="text" name="firstname" class="required" style="float:right;width:166px;"/>
                    </td>
                <!--LASTNAME-->
                    <td id="choosegrade" class="<?php echo get_string('choosegrade', 'local_placement'); ?>">
                        <?php echo get_string('lastname', 'local_placement'); ?>:
                        <input type="text" name="lastname" class="required" style="float:right;width:166px;"/>
                    </td>
                </tr>
                <tr>
                <!--EXPERIENCE AS A TEACHER-->
                    <td>
                        <?php echo get_string('experience', 'local_placement'); ?>:
                        <input type="text" name="experience" class="required" maxlength="2" style="float:right;width:2em"/>
                    </td>
                </tr>
                <tr>
                <!--GRADES TAUGHT-->
                    <td>
                        <?php echo get_string('grade', 'local_placement'); ?>(s):
                        <div id="grade" style="height:20px;width:167px;background-color:darkgrey;float:right;border:1px black solid;">
                            <img src="down-arrow.png" style="float:left;"/>
                            <div style="text-align:center;"><?php echo get_string('choose', 'local_placement'); ?></div>
                            <div id="list" style="display:none;position:relative;bottom:13px;right:29px;">
                                <ul style="list-style-type:none;">
                                    <li class="grade" style="background-color:darkgray;">
                                        <input type="checkbox" class="checkbox1" value="<?php echo get_string('kind', 'local_placement'); ?>"/><?php echo get_string('kind', 'local_placement'); ?></li>
                                    <li class="grade" style="background-color:dimgray;">
                                        <input type="checkbox" class="checkbox1" value="1"/>1</li>
                                    <li class="grade" style="background-color:darkgray;">
                                        <input type="checkbox" class="checkbox1" value="2"/>2</li>
                                    <li class="grade" style="background-color:dimgray;">
                                        <input type="checkbox" class="checkbox1" value="3"/>3</li>
                                    <li class="grade" style="background-color:darkgray;">
                                        <input type="checkbox" class="checkbox1" value="4"/>4</li>
                                    <li class="grade" style="background-color:dimgray;">
                                        <input type="checkbox" class="checkbox1" value="5"/>5</li>
                                    <li class="grade" style="background-color:darkgray;">
                                        <input type="checkbox" class="checkbox1" value="6"/>6</li>
                                    <li class="grade" style="background-color:dimgray;">
                                        <input type="checkbox" class="checkbox1" value="7"/>7</li>
                                    <li class="grade" style="background-color:darkgray;">
                                        <input type="checkbox" class="checkbox1" value="8"/>8</li>
                                    <li class="grade" style="background-color:dimgray;">
                                        <input type="checkbox" class="checkbox1" value="9"/>9</li>
                                    <li class="grade" style="background-color:darkgray;">
                                        <input type="checkbox" class="checkbox1" value="10"/>10</li>
                                    <li class="grade" style="background-color:dimgray;">
                                        <input type="checkbox" class="checkbox1" value="11"/>11</li>
                                    <li class="grade" style="background-color:darkgray;">
                                        <input type="checkbox" class="checkbox1" value="12"/>12</li>
                                </ul>
                            </div>
                        </div>                        
                    </td>​
                <!--EXPERIENCE AT THIS LEVEL-->
                    <td>
                        <?php echo get_string('levelexp', 'local_placement'); ?>:
                        <input type="text" name="levelexp" maxlength="2" class="required" style="float:right;width:2em"/>
                    </td>
                </tr>
                <tr>
                <!--EMAIL-->
                    <td>
                        <?php echo get_string('email', 'local_placement'); ?>:
                        <input type="text" name="email" class="required email" style="float:right;width:165px;"/>
                    </td>
                </tr>
                <tr>
                <!--CORE SUBJECTS TAUGHT-->
                    <td>
                        <?php echo get_string('core', 'local_placement'); ?>:
                        <div id="core" style="height:20px;width:167px;background-color:darkgrey;float:right;border:1px black solid;">
                            <img src="down-arrow.png" style="float:left;"/>
                        <div style="text-align:center;"><?php echo get_string('choose', 'local_placement'); ?></div>
                        <div id="cores" style="display:none;position:relative;bottom:13px;right:29px;">
                                <ul style="list-style-type:none;">
                                    <li class="core" style="background-color:darkgray;">
                                        <input type="checkbox" class="checkbox2" value="<?php echo get_string('none', 'local_placement'); ?>"/><?php echo get_string('none', 'local_placement'); ?></li>
                                    <li class="core" style="background-color:dimgray;">
                                        <input type="checkbox" class="checkbox2" value="Language Arts"/><?php echo get_string('la', 'local_placement'); ?></li>
                                    <li class="core" style="background-color:darkgray;">
                                        <input type="checkbox" class="checkbox2" value="Math"/><?php echo get_string('math', 'local_placement'); ?></li>
                                    <li class="core" style="background-color:dimgray;">
                                        <input type="checkbox" class="checkbox2" value="Science"/><?php echo get_string('science', 'local_placement'); ?></li>
                                    <li class="core" style="background-color:darkgray;">
                                        <input type="checkbox" class="checkbox2" value="Social Studies"/><?php echo get_string('social', 'local_placement'); ?></li>
                                </ul>
                        </div>
                        </div><br/><br/><br/>
                    </td>
                <!--PREFERENCES-->
                    <td>
                        <?php echo get_string('pref', 'local_placement'); ?>:
                        <textarea rows="4" cols="25" name="pref" class="required" style="resize:none;float:right;"></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <span class="whitetitle"><?php echo get_string('practicum', 'local_placement'); ?></span>
        <div class="box1"></br>
            <span style="font-weight:bold"><?php echo get_string('terms', 'local_placement'); ?>:</span></br></br>
            <table>
                <tr>
                    <td>
                        <!--IF FRENCH, DISPLAY FRENCH PICTURES, IF ENGLISH, DISPLAY ENGLISH PICTURES-->
                        <?php
                        if(get_string('lang', 'local_placement') == 'fr')
                        {
                        ?>
                        <img style="width:142px;height:112px;background:url('stagesprite.png') 0 0;"/>
                    </td><td>
                        <input type="radio" name="stage" value="1"/>
                        <span><?php echo get_string('fall', 'local_placement'); ?></span><br/>
                        <input type="radio" name="stage" value="1"/>
                        <span><?php echo get_string('winter', 'local_placement'); ?></span><br/>
                    </td>
                </tr><tr>
                    <td>
                        <img style="width:142px;height:112px;background:url('stagesprite.png') 295px 0;"/>
                    </td><td>
                        <input type="radio" name="stage" value="2"/>
                        <span><?php echo get_string('date1', 'local_placement'); ?></span><br/>
                    </td>
                </tr><tr>
                    <td>
                        <img style="width:142px;height:112px;background:url('stagesprite.png') 141px 0;"/>
                        <?php
                        }
                        else
                        {
                        ?>
                        <img style="width:142px;height:112px;background:url('stagesprite.png') 0 113px;"/>
                    </td><td>
                        <input type="radio" name="stage" value="1"/>
                        <span><?php echo get_string('fall', 'local_placement'); ?></span><br/>
                        <input type="radio" name="stage" value="1"/>
                        <span><?php echo get_string('winter', 'local_placement'); ?></span><br/>
                    </td>
                </tr><tr>
                    <td>
                        <img style="width:142px;height:112px;background:url('stagesprite.png') 294px 112px;"/>
                    </td>
                <!--AUTUMN SESSION-->
                    <td>
                        <input type="radio" name="stage" value="2"/>
                        <span><?php echo get_string('date1', 'local_placement'); ?></span><br/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <img style="width:142px;height:112px;background:url('stagesprite.png') 143px 111px;"/>
                        <?php
                        }
                        ?>
                    </td>
                <!--WINTER SESSION-->
                    <td>
                        <input type="radio" name="stage" value="3"/>
                        <span><?php echo get_string('date2', 'local_placement'); ?></span><br/>
                    </td>
                </tr>
            </table>
            <span class="whitetitle"><?php echo get_string('practicum', 'local_placement'); ?></span>
        <div class="box1"></br>
            <table>
                <tr>
                    <td></td>
                    <td>
                        <input type="radio" name="session" value="1"/>
                        <span><?php echo get_string('fall', 'local_placement'); ?></span><br/>
                        <input type="radio" name="session" value="2"/>
                        <span><?php echo get_string('winter', 'local_placement'); ?></span><br/>
                    </td>
                </tr>
            </table>
        </div>
            <table>
                <tr></br>
                    <td></td>
                    <td>
                        <input type="submit" class="generalbutton" onclick="check_grade2();" style="font-size:12px;width:150px;margin-left:370px;" value="<?php echo get_string('save', 'local_placement'); ?>"/>
                        <div align="center" class="generalbutton" onclick="return_admin();" style="font-size:12px;width:150px;position:relative;left:530px;bottom:30px;height:28px;margin-bottom:-30px;"><span style="position:relative;top:4px;"><?php echo get_string('cancel', 'local_placement'); ?></span></div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    ​</form>
<?php
}


/**
* Form for editing a teacher
*
* @global moodle_database $DB
* @global stdClass $USER
* @global stdClass $CFG
**/
function edit_view($id) {
    global $DB, $CFG, $USER;
    
    //These if and switch statements are for checking off the appropriate radio buttons and checkboxes to reflect the teacher info
    
    $teachers = $DB->get_record('placement_coop_teachers', array('id' => $id));
    
    switch($teachers->stage)
    {
        case 'EDU E 331':
            if($teachers->semester == 'Fall')
            {
                $stage1a = 'checked="checked"';
                $stage1b = '';
            }
            else
            {
                $stage1a = '';
                $stage1b = 'checked="checked"';
            }
            $stage2 = '';
            $stage3 = '';
            break;
        case 'Stage 2':
            $stage1a = '';
            $stage1b = '';
            $stage2 = 'checked="checked"';
            $stage3 = '';
            break;
        case 'Stage 3':
            $stage1a = '';
            $stage1b = '';
            $stage2 = '';
            $stage3 = 'checked="checked"';
            break;
        default:
            $stage1a = 'checked="checked"';
            $stage1b = '';
            $stage2 = '';
            $stage3 = '';
            break;
    }
    
    if($teachers->semester == 'Winter')
    {
        $session1 = '';
        $session2 = 'checked="checked"';
    }
    else
    {
        $session1 = 'checked="checked"';
        $session2 = '';
    }
    $ifo = $DB->get_record('placement_users', array("userid" => $USER->id));
    ?>
<br/><div class="center" style="width:900px;">
<div class="center" style="width:850px;font-size:20px;font-weight:bold;text-decoration:underline;"><?php echo $ifo->school; ?> - <?php echo $ifo->schoolboard; ?></div>
    <!--FORM PROVIDES VALIDATION - REQUIRED FIELDS MUST BE FILLED-->
    <form id="newteacher" name="newteacher" class="required-form">
    <div class="box1 center" style="width:800px;margin-top:40px;">
        <span class="whitetitle" style="font-size:20px;top:-17px;"><?php echo get_string('editteacher', 'local_placement'); ?></span>
        <div class="box1">
            <span class="whitetitle" style="top:-17px;"><?php echo get_string('personal', 'local_placement'); ?></span>
            <table id="worked" class=""></br>
                <tr id="cfg" class="<?php echo $CFG->wwwroot; ?>">
                <!--FIRSTNAME-->
                    <td id="choosegrade" class="<?php echo get_string('choosegrade', 'local_placement'); ?>">
                        <?php echo get_string('firstname', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;" name="firstname" class="required" value="<?php echo $teachers->firstname; ?>"/>
                <!--LASTNAME-->
                    </td><td id="edited" class="<?php echo get_string('edited', 'local_placement'); ?>">
                        <?php echo get_string('lastname', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:166px;" name="lastname" class="required" value="<?php echo $teachers->lastname; ?>"/>
                    </td>
                </tr>
                <tr>
                <!--EXPERIENCE AS A TEACHER-->
                    <td id="edit" class="<?php echo $teachers->subjects; ?>">
                        <?php echo get_string('experience', 'local_placement'); ?>:
                        <input type="text" maxlength="2" style="float:right;width:2em" name="experience" class="required" value="<?php echo $teachers->experience; ?>"/>
                    </td>
                </tr>
                <tr>
                <!--GRADE(S) TAUGHT-->
                    <td>
                        <?php echo get_string('grade', 'local_placement'); ?>
                        <div id="grade" style="height:20px;width:167px;background-color:darkgrey;float:right;border:1px black solid;">
                            <img id="year" class="<?php echo $teachers->schoolyear; ?>" src="down-arrow.png" style="float:left;"/>
                            <div style="text-align:center;"><?php echo get_string('choose', 'local_placement'); ?></div>
                            <div id="list" style="display:none;position:relative;bottom:13px;right:29px;">
                                <ul style="list-style-type:none;">
                                    <li class="grade" style="background-color:darkgray;">
                                        <input id="Kindergarten" type="checkbox" class="checkbox1"><?php echo get_string('kind', 'local_placement'); ?></input></li>
                                    <li class="grade" style="background-color:dimgray;">
                                        <input id="1" type="checkbox" class="checkbox1">1</input></li>
                                    <li class="grade" style="background-color:darkgray;">
                                        <input id="2" type="checkbox" class="checkbox1">2</input></li>
                                    <li class="grade" style="background-color:dimgray;">
                                        <input id="3" type="checkbox" class="checkbox1">3</input></li>
                                    <li class="grade" style="background-color:darkgray;">
                                        <input id="4" type="checkbox" class="checkbox1">4</input></li>
                                    <li class="grade" style="background-color:dimgray;">
                                        <input id="5" type="checkbox" class="checkbox1">5</input></li>
                                    <li class="grade" style="background-color:darkgray;">
                                        <input id="6" type="checkbox" class="checkbox1">6</input></li>
                                    <li class="grade" style="background-color:dimgray;">
                                        <input id="7" type="checkbox" class="checkbox1">7</input></li>
                                    <li class="grade" style="background-color:darkgray;">
                                        <input id="8" type="checkbox" class="checkbox1">8</input></li>
                                    <li class="grade" style="background-color:dimgray;">
                                        <input id="9" type="checkbox" class="checkbox1">9</input></li>
                                    <li class="grade" style="background-color:darkgray;">
                                        <input id="10" type="checkbox" class="checkbox1">10</input></li>
                                    <li class="grade" style="background-color:dimgray;">
                                        <input id="11" type="checkbox" class="checkbox1">11</input></li>
                                    <li class="grade" style="background-color:darkgray;">
                                        <input id="12" type="checkbox" class="checkbox1">12</input></li>
                                </ul>
                            </div>
                        </div>                        
                    </td>​
                <!--EXPERIENCE AT THIS LEVEL-->
                    <td>
                        <?php echo get_string('levelexp', 'local_placement'); ?>:
                        <input type="text" maxlength="2" style="float:right;width:2em" name="levelexp" class="required" value="<?php echo $teachers->levelexp; ?>"/>
                    </td>
                </tr>
                <tr>
                <!--EMAIL-->    
                    <td>
                        <?php echo get_string('email', 'local_placement'); ?>:
                        <input type="text" style="float:right;width:165px;" name="email" class="required" value="<?php echo $teachers->email; ?>"/>
                    </td>
                </tr>
                <tr>
                <!--CORE SUBJECTS TAUGHT-->
                    <td>
                        <?php echo get_string('core', 'local_placement'); ?>:
                        <div id="core" style="height:20px;width:167px;background-color:darkgrey;float:right;border:1px black solid;">
                            <img src="down-arrow.png" style="float:left;"/>
                        <div style="text-align:center;"><?php echo get_string('choose', 'local_placement'); ?></div>
                        <div id="cores" style="display:none;position:relative;bottom:13px;right:29px;">
                                <ul style="list-style-type:none;">
                                    <li class="core" style="background-color:darkgray;">
                                        <input id="none" type="checkbox" class="checkbox2" value="<?php echo get_string('none', 'local_placement'); ?>"/><?php echo get_string('none', 'local_placement'); ?></li>
                                    <li class="core" style="background-color:dimgray;">
                                        <input id="la" type="checkbox" class="checkbox2" value="Language Arts"/><?php echo get_string('la', 'local_placement'); ?></li>
                                    <li class="core" style="background-color:darkgray;">
                                        <input id="math" type="checkbox" class="checkbox2" value="Math"/><?php echo get_string('math', 'local_placement'); ?></li>
                                    <li class="core" style="background-color:dimgray;">
                                        <input id="science" type="checkbox" class="checkbox2" value="Science"/><?php echo get_string('science', 'local_placement'); ?></li>
                                    <li class="core" style="background-color:darkgray;">
                                        <input id="social" type="checkbox" class="checkbox2" value="Social Studies"/><?php echo get_string('social', 'local_placement'); ?></li>
                                </ul>
                        </div>
                        </div><br/><br/><br/>
                    </td>
                <!--PREFERENCES-->
                    <td>
                        <?php echo get_string('pref', 'local_placement'); ?>:
                        <textarea rows="4" cols="25" name="pref" class="required" style="resize:none;float:right;"><?php echo $teachers->preferences; ?></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <span class="whitetitle"><?php echo get_string('practicum', 'local_placement'); ?></span>
        <div class="box1"></br>
            <span style="font-weight:bold"><?php echo get_string('terms', 'local_placement'); ?>:</span></br></br>
            <table>
                <tr>
                    <td>
                    <!--DEPENDING ON LANGUAGE IS SELECTED, SHOW IMAGES IN THAT LANGUAGE-->
                        <?php
                        if(get_string('lang', 'local_placement') == 'fr')
                        {
                        ?>
                        <img style="width:142px;height:112px;background:url('stagesprite.png') 0 0;"/>
                    </td>
                    <td>
                        <input type="radio" name="stage" value="1" <?php echo $stage1a; ?>/>
                        <span><?php echo get_string('fall', 'local_placement'); ?></span><br/>
                        <input type="radio" name="stage" value="1" <?php echo $stage1b; ?>/>
                        <span><?php echo get_string('winter', 'local_placement'); ?></span><br/>
                    </td>
                </tr><tr>
                    <td>
                        <img style="width:142px;height:112px;background:url('stagesprite.png') 295px 0;"/>
                    </td><td>
                        <input type="radio" name="stage" value="2" <?php echo $stage2; ?>/>
                        <span><?php echo get_string('date1', 'local_placement'); ?></span><br/>
                    </td>
                </tr><tr>
                    <td>
                        <img style="width:142px;height:112px;background:url('stagesprite.png') 141px 0;"/>
                        <?php
                        }
                        else
                        {
                        ?>
                        <img style="width:142px;height:112px;background:url('stagesprite.png') 0 113px;"/>
                    </td><td>
                        <input type="radio" name="stage" value="1" <?php echo $stage1a; ?>/>
                        <span><?php echo get_string('fall', 'local_placement'); ?></span><br/>
                        <input type="radio" name="stage" value="1" <?php echo $stage1b; ?>/>
                        <span><?php echo get_string('winter', 'local_placement'); ?></span><br/>
                    </td>
                </tr><tr>
                    <td>
                        <img style="width:142px;height:112px;background:url('stagesprite.png') 294px 112px;"/>
                    </td>
                <!--AUGUST SESSION-->
                    <td>
                        <input type="radio" name="stage" value="2" <?php echo $stage2; ?>/>
                        <span><?php echo get_string('date1', 'local_placement'); ?></span><br/>
                    </td>
                </tr><tr>
                    <td>
                        <img style="width:142px;height:112px;background:url('stagesprite.png') 143px 111px;"/>
                        <?php
                        }
                        ?>
                    </td>
                <!--WINTER SESSION-->
                    <td>
                        <input type="radio" name="stage" value="male" <?php echo $stage3; ?>/>
                        <span><?php echo get_string('date2', 'local_placement'); ?></span><br/>
                    </td>
                </tr>
            </table>
        </div>
        <span class="whitetitle"><?php echo get_string('practicum', 'local_placement'); ?></span>
        <div class="box1"></br>
            <table>
                <tr>
                    <td></td>
                    <td>
                        <input type="radio" name="session" value="1" <?php echo $session1; ?>/>
                        <span><?php echo get_string('fall', 'local_placement'); ?></span><br/>
                        <input type="radio" name="session" value="2" <?php echo $session2; ?>/>
                        <span><?php echo get_string('winter', 'local_placement'); ?></span><br/>
                    </td>
                </tr>
            </table>
        </div>
            <table>
                <tr></br>
                    <td></td>
                    <td>
                        <input id="submit" type="submit" class="generalbutton" onclick="check_grade(<?php echo $id; ?>);" style="font-size:12px;width:150px;margin-left:370px;" value="<?php echo get_string('save', 'local_placement'); ?>"/>
                        <div align="center" class="generalbutton" onclick="return_admin();" style="font-size:12px;width:150px;position:relative;left:530px;bottom:30px;height:28px;margin-bottom:-30px;"><span style="position:relative;top:4px;"><?php echo get_string('cancel', 'local_placement'); ?></span></div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</form>
    <?php
}


/**
* Dialog box for principals that have not yet added thier information.
* If principal declares their school is not yet in the database, they should be redirected to the 'edit school form' after the dialog box
*
* @global moodle_database $DB
* @global stdClass $USER
* @global stdClass $CFG
**/
function dialog()
{
    global $DB, $CFG, $USER;
    
    $info = $DB->get_record('user', array("id" => $USER->id));
    $boards = $DB->get_records('placement_schoolboard', array(), 'name');
    $schools = $DB->get_records('placement_school', array(), 'school');
    ?>
    <br/><div id="mask" style="z-index:-10;background-color:gray;display:none;"></div>
    <div id="initialize" title="<?php echo get_string('newuser', 'local_placement')?>" style="display:none;">
        <div style="font-variant:small-caps;font-size:20px;font-family:georgia;font-weight:bold;color:dimgray;"><?php echo get_string('personal', 'local_placement'); ?></div><br/>
    <!--FIRSTNAME-->
        <b id="saved" class="<?php echo get_string('usersaved', 'local_placement'); ?>"><?php echo get_string('firstname', 'local_placement'); ?>: </b><span id="firstname"><?php echo $info->firstname; ?></span>
    <!--GENDER-->
        <div id="cfg" class="<?php echo $CFG->wwwroot; ?>" style="float:right;"><b><?php echo get_string('sex', 'local_placement'); ?>: </b>M <input type="radio" name="sex" class="radio1" value="0"/>  F <input type="radio" name="sex" class="radio1" value="1"/></div><br/>
    <!--LASTNAME-->
        <b><?php echo get_string('lastname', 'local_placement'); ?>: </b><span id="lastname"><?php echo $info->lastname; ?></span>
    <!--LANGUAGE-->
        <div style="float:right;"><b><?php echo get_string('language', 'local_placement'); ?>: </b>Fr <input type="radio" name="lang" class="radio2" value="0"/>  En <input type="radio" name="lang" class="radio2" value="1"/></div><br/>
    <!--EMAIL-->
        <b><?php echo get_string('email', 'local_placement'); ?>: </b><span id="email"><?php echo $info->email; ?></span><br/>
        <hr/>
        <div id="grey">
        <div style="font-variant:small-caps;font-size:20px;font-family:georgia;font-weight:bold;color:dimgray;"><?php echo get_string('school', 'local_placement'); ?></div>
    <!--SCHOOL-->
        <span style="color:red;font-size:13px;"><?php echo get_string('chooseschool', 'local_placement'); ?></span><br/><br/>
        - <select id="sch" onchange="school_select(this.value);" style="width:350px;">
            <?php
            foreach ($schools as $s)
                echo '<option value="' . $s->school . '">' . $s->school . '</option>';
            ?>
        </select><br/><br/>
    <!--NEW SCHOOL OPTION-->
        - <a id="newschool" href="#" style="color:blue;"><?php echo get_string('newschool', 'local_placement'); ?> <img src="down.gif"/></a><br/>
        </div><hr/>
    <!--NEW SCHOOL SECTION (HIDDEN AT FIRST)-->
        <div id="createschool" style="display:none;">
            <span style="font-variant:small-caps;font-size:20px;font-family:georgia;font-weight:bold;color:dimgray;"><?php echo get_string('newschool', 'local_placement'); ?></span>
        <!--HIDE NEW SCHOOL SECTION-->
            <a id="hideschool" href="#" style="color:blue;float:right;"><?php echo get_string('hide', 'local_placement'); ?> <img src="uparrow.png"/></a><br/><br/>
        <!--SCHOOL NAME-->
            <span style="font-weight:bold;"><?php echo get_string('school', 'local_placement'); ?>:</span><input id="schooltext" onkeyup="disable_school(this.value);" type="text" style="float:right;width:190px;"/><br/><br/>
        <!--SCHOOL BOARD NAME-->
            <span style="font-weight:bold;"><?php echo get_string('board', 'local_placement'); ?>:</span>
        <!--NEW SCHOOL BOARD OPTION-->
            <select id="hidemenu" style="width:240px;float:right;">
                <?php
                foreach ($boards as $b)
                    echo '<option>' . $b->name . '</option>';
                ?>
            </select>
        <!--NEW SCHOOL BOARD NAME-->
            <input id="showtext" onkeyup="disable_board(this.value);" type="text" style="float:right;width:190px;display:none;"/><br/><br/>
        <!--HIDE NEW SCHOOL BOARD SECTION-->
            <a id="newboard" class="<?php echo get_string('existing', 'local_placement'); ?> <img src='uparrow.png'/>" rel="<?php echo get_string('newboard', 'local_placement'); ?> <img src='uparrow.png'/>" href="#" style="color:blue;float:right;"><?php echo get_string('newboard', 'local_placement'); ?> <img src="uparrow.png"/></a><br/>
            <hr/>
        </div>
    <!--SHOWS THE SCHOOL BOARD OF AN EXISTING SCHOOL-->
        <div id="boardind" style="display:inline;">
            <br/><br/>
            <span style="font-variant:small-caps;font-size:20px;font-family:georgia;font-weight:bold;color:dimgray;"><?php echo get_string('board', 'local_placement'); ?>:</span><br/>
            <span>- </span><span id="sb" style="font-weight:bold;font-size:14px;"></span>
            <br/></br></br><hr/>
        </div>
        <button id="savebutton" onclick="create_user();" style="width:100px;height:30px;border-radius:5px 5px;background-color:orange;border:1px darkorange solid;color:white;font-weight:bold;float:right;"><?php echo get_string('save', 'local_placement'); ?></button>
    </div>
    <span id="null" style="display:none;" ></span>
    <?php
}
?>
