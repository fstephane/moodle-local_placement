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

//This script provides every javascript function for viewadmin.php


$(document).ready(function(){
    //First off, select EDU E 331 tab
    $("#initialtab").css({'background-color': 'white', 'color': 'black'});
});

//Add a principal - creates a user
function add_principle()
{
    var firstname = $("input[name = firstname]").attr('value');
    var lastname = $("input[name = lastname]").attr('value');
    var email = $("input[name = email]").attr('value');
    
    var snd = firstname + '|' + lastname + '|' + email;
    var send = encodeURIComponent(snd);
    
    $("#null").load('requestadmin.php?addp=' + send, function(){
        alert(document.getElementById('addp').className);
        //clear textboxes to enable more adding
        $("input[name = firstname]").val('');
        $("input[name = lastname]").val('');
        $("input[name = email]").val('');
    });
}

//Add a student - creates a user
function add_student()
{
    var firstname = $("input[name = firstname2]").attr('value');
    var lastname = $("input[name = lastname2]").attr('value');
    var email = $("input[name = email2]").attr('value');
    
    var snd = firstname + '|' + lastname + '|' + email;
    var send = encodeURIComponent(snd);
    
    $("#null").load('requestadmin.php?adds=' + send, function(){
        alert(document.getElementById('adds').className);
        //clear textboxes to enable more adding
        $("input[name = firstname2]").val('');
        $("input[name = lastname2]").val('');
        $("input[name = email2]").val('');
    });
}

//Enter placement tool
function enter_placement()
{
    window.location = document.getElementById('cfg').className + '/local/placement/admin/viewadmin.php?view=tool';
}

//Display student information when student name is clicked
//click = div that contains student name (this)
function select_student(click)
{
    //Clear any other selections
    $(".student").each(function(){
        if(this !== click)
        {
            document.getElementById(this.id).style.backgroundColor = 'white';
            document.getElementById(this.id).style.color = 'black';
        }
    });
    
    //If student is not already selected
    if(document.getElementById(click.id).style.backgroundColor == 'white')
    {
        //Display selection
        document.getElementById(click.id).style.backgroundColor = 'black';
        document.getElementById(click.id).style.color = 'white';
        
        //Load student information
        $("#stud").load('requestadmin.php?stud=' + click.id + '&stage=' + document.getElementById('indicator').className, function(){
            //Shows that student info box is not empty in order to trigger event that calculates number of matches (innerHTML !== '' wasn't working for some reason)
            document.getElementById('stud').lang = 1;
            
            //if teacher info box is not empty, calculate matches
            if(document.getElementById('teac').lang == 1)
            {
                document.getElementById('matchbutton').disabled = false;
                
                //Student preferences
                var levpref = document.getElementById('levpref').innerHTML;
                var typepref = document.getElementById('typepref').innerHTML;
                var programpref = document.getElementById('programpref').innerHTML;
                var subpref = document.getElementById('subpref').innerHTML;

                //Teacher/school info
                var level = document.getElementById('level').innerHTML;
                var type = document.getElementById('type').innerHTML;
                var program = document.getElementById('program').innerHTML;
                var core = document.getElementById('core').innerHTML;

                var match = 0;
                
                //Compare
                if((levpref.toLowerCase() == level.toLowerCase()) && (levpref !== ''))
                    match++;
                if((typepref.toLowerCase() == type.toLowerCase()) && (typepref !== ''))
                    match++;
                if((programpref.toLowerCase() == program.toLowerCase())  && (programpref !== ''))
                    match++;
                
                //split list of the core subjects taught by the teacher
                var sub = subpref.split(',');
                
                //compare each subject to the student core subject preference
                for(s in sub)
                {
                    if((core !== '') && (subpref !== ''))
                        if(core.toLowerCase().indexOf(sub[s].toLowerCase()) !== -1)
                            match++;
                }
                //Display number of matches
                document.getElementById('match').innerHTML = match;
            }
        });
    }
}

//Display teacher information when a teacher is selected
function select_teacher(click)
{
    if(click.id == 'y')
        document.getElementById('unmatchbutton').disabled = false;
    else
        document.getElementById('unmatchbutton').disabled = true;
    
    //retrieve school id
    var school = document.getElementById(click.getAttribute('xml:lang'));
    
    //Clear other teacher selections
    $(".teach").each(function(){
        if(this !== click)
            document.getElementById('t' + this.lang).style.backgroundColor = 'white';
    });
    
    //Clear other school selections
    $(".school").each(function(){
        if(this !== school)
            this.style.backgroundColor = 'grey';
    });
    
    //I had to add t to the teacher ids because some of them were overlapping with student ids and creating errors
    if(document.getElementById('t' + click.lang).style.backgroundColor == 'white')
    {
        //Display selection
        document.getElementById('t' + click.lang).style.backgroundColor = 'red';
        school.style.backgroundColor = 'black';
        
        //load teacher information in order to trigger event that calculates number of matches
        $("#teac").load('requestadmin.php?teac=' + click.lang + '&stage=' + document.getElementById('indicator').className, function(){
            //indicates teacher information box is not empty in order to trigger event that calculates number of matches (innerHTML !== '' wasn't working for some reason)
            document.getElementById('teac').lang = 1;
            
            //if student box is not empty, calculate matches
            if(document.getElementById('stud').lang == 1)
            {
                document.getElementById('matchbutton').disabled = false;
                
                //student preferences
                var levpref = document.getElementById('levpref').innerHTML;
                var typepref = document.getElementById('typepref').innerHTML;
                var programpref = document.getElementById('programpref').innerHTML;
                var subpref = document.getElementById('subpref').innerHTML;

                //teacher/school information
                var level = document.getElementById('level').innerHTML;
                var type = document.getElementById('type').innerHTML;
                var program = document.getElementById('program').innerHTML;
                var core = document.getElementById('core').innerHTML;

                var match = 0;
                
                //compare
                if((levpref.toLowerCase() == level.toLowerCase()) && (levpref !== ''))
                    match++;
                if((typepref.toLowerCase() == type.toLowerCase()) && (typepref !== ''))
                    match++;
                if((programpref.toLowerCase() == program.toLowerCase())  && (programpref !== ''))
                    match++;
                
                //split list of core subjects taught by teacher into an array
                var sub = subpref.split(',');
                
                //compare student's core subject preference with array
                for(s in sub)
                {
                    if((core !== '') && (subpref !== ''))
                        if(core.toLowerCase().indexOf(sub[s].toLowerCase()) !== -1)
                            match++;
                }
                //Display number of matches
                document.getElementById('match').innerHTML = match;
            }
        });
    }
}

//Match a student with a teacher
function match()
{
    document.getElementById('unmatchbutton').disabled = false;

    var select = '';
    var id = '';
    //Check which teacher is selected
    $(".teacher").each(function(){
        if(this.style.backgroundColor == 'red')
        {
            //This is the id of the box in which the name of the match goes
            select = this.innerHTML;
            //This is the teacher's coop id
            id = this.id.replace('t', '');
            
            //set id to y to show that box is filled
            $("teach").each(function(){
                if(this.lang == id)
                    this.id = 'y';
            });
        }
    });
    
    var sid = '';
    //Checks which student is selected
    $(".student").each(function(){
        if(this.style.backgroundColor == 'black')
        {
            sid = this.id;
        }
    });
    var num = document.getElementById('match').innerHTML;
    
    //.load wasn't working for some reason
    var xmlhttp;
    if (window.XMLHttpRequest)
      {// code for IE7+, Firefox, Chrome, Opera, Safari
      xmlhttp=new XMLHttpRequest();
      }
    else
      {// code for IE6, IE5
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }
    xmlhttp.onreadystatechange=function()
      {
      if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
        document.getElementById(select).innerHTML=xmlhttp.responseText;
        //build new student list
        $("#studentbox").load('requestadmin.php?load=' + document.getElementById('indicator').className);
        document.getElementById('matchbutton').disabled = false;
        }
      }
    xmlhttp.open("POST","requestadmin.php",true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send('match=' + id + '&sid=' + sid + '&stage=' + document.getElementById('indicator').className + '&num=' + num);
}

//UNMATCH DOESN'T WORK IMMEDIATELY AFTER MATCH HAS BEEN MADE
//FOR SOME REASON YOU HAVE TO CLICK SOMEWHERE ELSE THEN GO BACK IN ORDER TO UNMATCH
function unmatch()
{
    document.getElementById('unmatchbutton').disabled = true;
    
    var select = '';
    var id = '';
    //check which teacher is selected
    $(".teacher").each(function(){
        if(this.style.backgroundColor == 'red')
        {
            //This is the id of the box in which the name of the match goes
            select = this.innerHTML;
            //This is the teacher's coop id
            id = this.id.replace('t', '');
            
            //set id to n to show box is empty
            $("teach").each(function(){
                if(this.lang == id)
                    this.id = 'n';
            });
        }
    });

    //I added to c to make sure there wasn't more than one element with the same id
    document.getElementById('c' + id).innerHTML = '';

    //Empty box
    document.getElementById(select).innerHTML = '';
    
    //Take match out of database
    $("#null").load('requestadmin.php?unmatch=' + id, function(){
        //build new student list
        $("#studentbox").load('requestadmin.php?load=' + document.getElementById('indicator').className);
    });
}

//When the EDU E 331 tab is selected
$("#initialtab").click(function(){
    //if it is not already selected
    if($("#indicator").className !== '1')
    {
        //Highlight EDU tab and deselect the other tabs
        $("#initialtab").css({'background-color': 'white', 'color': 'black'});
        $("#stage1tab").css({'background-color': 'black', 'color': 'white'});
        $("#stage2tab").css({'background-color': 'black', 'color': 'white'});
        //Clear two information boxes and number of matches
        document.getElementById('teac').innerHTML = '';
        document.getElementById('stud').innerHTML = '';
        document.getElementById('match').innerHTML = '';
        //Disable match and unmatch buttons
        document.getElementById('matchbutton').disabled = true;
        document.getElementById('unmatchbutton').disabled = true;
        //indicates that boxes are empty
        document.getElementById('stud').lang = 0;
        document.getElementById('teac').lang = 0;
        //indicates that EDU stage is selected
        document.getElementById('indicator').className = '1';
        //Repopulate lists
        $("#studentbox").load('requestadmin.php?tab=1');
        $("#teacherbox").load('requestadmin.php?tb=1');
    }
});

//When stage1 tab is selected
$("#stage1tab").click(function(){
    //if tab is not already selected
    if($("#indicator").className !== '2')
    {
        //Select one tab and deselect others
        $("#initialtab").css({'background-color': 'black', 'color': 'white'});
        $("#stage1tab").css({'background-color': 'white', 'color': 'black'});
        $("#stage2tab").css({'background-color': 'black', 'color': 'white'});
        //Clear info boxes and number of matches
        document.getElementById('teac').innerHTML = '';
        document.getElementById('stud').innerHTML = '';
        document.getElementById('match').innerHTML = '';
        //Disable match and unmatch buttons
        document.getElementById('matchbutton').disabled = true;
        document.getElementById('unmatchbutton').disabled = true;
        //Show that info boxes are empty
        document.getElementById('stud').lang = 0;
        document.getElementById('teac').lang = 0;
        //Shows that stage2 is selected
        document.getElementById('indicator').className = '2';
        //Load new student and teacher lists
        $("#studentbox").load('requestadmin.php?tab=2');
        $("#teacherbox").load('requestadmin.php?tb=2');
    }
});

//When stage2 tab is selected
$("#stage2tab").click(function(){
    //if it is not already selected
    if($("#indicator").className !== '3')
    {
        //Select one tab and deselect other
        $("#initialtab").css({'background-color': 'black', 'color': 'white'});
        $("#stage1tab").css({'background-color': 'black', 'color': 'white'});
        $("#stage2tab").css({'background-color': 'white', 'color': 'black'});
        //Clear info boxes and number of matches
        document.getElementById('teac').innerHTML = '';
        document.getElementById('stud').innerHTML = '';
        document.getElementById('match').innerHTML = '';
        //Disable match and unmatch buttons
        document.getElementById('matchbutton').disabled = true;
        document.getElementById('unmatchbutton').disabled = true;
        //Show that info boxes are empty
        document.getElementById('stud').lang = 0;
        document.getElementById('teac').lang = 0;
        //Shows that stage2 is selected
        document.getElementById('indicator').className = '3';
        //Load new student and teacher lists
        $("#studentbox").load('requestadmin.php?tab=3');
        $("#teacherbox").load('requestadmin.php?tb=3');
    }
});

//Hover functions for match and unmatch buttons
$(".mbutton").hover(function(){
    if(!this.disabled)
        this.style.backgroundColor = 'grey';
}, function(){
    this.style.backgroundColor = 'silver';
});