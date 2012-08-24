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

//This page provides all the javascript functions for viewuser.php

$(document).ready(function(){
    if((BrowserDetect.browser == 'Chrome'))
    {
       
    }
    
    //For some reason, php wouldn't let me set the value of the specific school preference dropdown menu to what the user has previously selected
    //Instead, I made their specific preference the class name of the dropdown menu and set the value here in javascript
    if($("#specific_preference").length > 0)
    {
        if(document.getElementById('specific_preference').className == '')
            document.getElementById('specific_preference').value = 0;
        else
            document.getElementById('specific_preference').value = document.getElementById('specific_preference').className;
    }
    
    //If the dialog element is present, open the dialog box that allows students to select their stage
    if($("#dialog").length > 0)
    {
        $("#dialog").show();
        $("#mask").show();
        $("#dialog").dialog({ dialogClass: 'no-close' }, { resizable: false });
        
        var winH = $(window).height() - 240;
        var winW = $(window).width() - 20;
    
        $("#mask").css({'height': winH, 'width': winW});
        
        $('#mask').fadeIn(1000);    
        $('#mask').fadeTo("slow",0.8); 
        
        $(window).resize(function(){
            $("#dialog").dialog("option", "position", "center");
            
            winH = $(window).height() - 240;
            winW = $(window).width() - 20;
    
            $("#mask").css({'height': winH, 'width': winW});
        });
    }
});

//If student indicates they wish to be placed in a rural location, all the fields pertaining to a rural placement become required
//(red * is shown beside required fields)
$('.radio5').click(function(){
    if(this.value == 'y')
    {
        $(".show").each(function(){
            this.style.display = '';
        });
    }
    else
    {
        $(".show").each(function(){
            this.style.display = 'none';
        });
    }
});

//If a student is in an editing form and they click 'change stage', their record is deleted and they create a new one
function change_stage(stage)
{
    //Delete student record and open dialog box for them to select a new stage
    $("#null").load('requestuser.php?rs=' + stage + '&stid=' + document.getElementById('studentid').className, function(){
        window.location = document.getElementById('cfg').className + '/local/placement/user/viewuser.php?register=change';
    });
}

//Checks to see if required radio buttons have been filled before saving student info
//jquery validation plugin doesn't work with radio buttons
function check_radio(stage, edit)
{
    $("#newstudent").submit(function(e){
            e.preventDefault();
        });
        
    var checked = new Array();
    
    //francophone/immersion
    checked[0] = false;
    $(".radio2").each(function(){
        if(this.checked)
            checked[0] = true;
    });
    
    //elementary/secondary
    checked[1] = false;
    $(".radio3").each(function(){
        if(this.checked)
            checked[1] = true;
    });
    
    //catholic/public
    checked[2] = false;
    $(".radio4").each(function(){
        if(this.checked)
            checked[2] = true;
    });
    
    //Initial stage doesn't have an option for a rural placement
    if(stage !== 'initial')
    {
        //rural yes/no
        var rur = false;
        checked[3] = false;
        $(".radio5").each(function(){
            if(this.checked)
            {
                checked[3] = true;
                if(this.value == 'y')
                    rur = true;
            }
        });

        //If a rural placement is desired, a student must fill out the relevant information
        if(rur)
        {
            //rural placement scholarship yes/no
            checked[4] = false;
            $(".radio6").each(function(){
                if(this.checked)
                    checked[4] = true;
            });

            //rural housing accommodation yes/no
            checked[5] = false;
            $(".radio7").each(function(){
                if(this.checked)
                    checked[5] = true;
            });
        }
    }
    
    //check to see if any required radio button has been left empty
    var cont = true;
    for(ch in checked)
    {
        if(!checked[ch])
            cont = false;
    }
    
    if(!cont)
    {
        alert(document.getElementById('alert', 'local_placement').className);
    }
    else
    {
        switch(stage)
        {
            case 'initial':
                register_student1(edit);
                break;
            case 'stage1':
                register_student2(rur, edit);
                break;
            case 'stage2':
                register_student3(rur, edit);
                break;
        }
        //scroll to top so that if jquery validation finds fields at the top of the page that haven't been filled, user can see them
        //otherwise it seems as though nothing is happening when you click the save button without filling in every field
        window.scroll(0,0);
    }
}

//Register a student in the EDU stage
//'edit' indicates whether student is editing information or registering for the first time
function register_student1(edit)
{
    //run validation plugin
    $('form.required-form').simpleValidate({
		errorElement: 'em',
                ajaxRequest: true,
		completeCallback: function() {
                    
       var firstname = $("input[name = firstname]").attr('value');
       var lastname = $("input[name = lastname]").attr('value');
       var phone = $("input[name = phone]").attr('value');
       var email = $("input[name = email]").attr('value');
       var address = $("input[name = address]").attr('value');
       var city = $("input[name = city]").attr('value');
       var onecard = $("input[name = onecard]").attr('value');
       var vehicle = $("select[name = vehicle]").attr('value');
       var core = $("select[name = core]").attr('value');
       
       var lang = '';
       $("input[name = lang]").each(function(){
            if(this.checked)
                lang = this.value;
        });
       
       var level = '';
       $("input[name = level]").each(function(){
            if(this.checked)
                level = this.value;
        });
       
       var major = $("input[name = maj]").attr('value');
       var minor = $("input[name = min]").attr('value');
       
       var type = '';
       $("input[name = type]").each(function(){
            if(this.checked)
                type = this.value;
        });
       
        var specific = $("select[name = specific]").attr('value');
        
        var pref = $("textarea[name = pref]").attr('value');
                    
        var snd = firstname + '|' + lastname + '|' + phone + '|' + email + '|' + address + '|' + city + '|' + onecard + '|' + vehicle + '|' + lang + '|' + level + '|' + major + '|' + minor + '|' + type + '|' + core;
        
        //if a specific school preference has been selected
        var spec = 0;
        if($("select[name = specific]").attr('value') !== '0')
        {
            spec = 1;
            snd += '|' + specific;
        }
        
        //If any other preferences have been indicated
        var prefer = 0;
        if($("textarea[name = pref]").attr('value') !== '')
        {
            prefer = 1;
            snd += '|' + pref;
        }
        var send = encodeURIComponent(snd);
        
        var stid = 0;
        if(edit == 'true')
            var stid = document.getElementById('studentid').className;
        
        //save info, then go to Moodle home page
        $("#null").load('requestuser.php?reg=' + send + '&spec=' + spec + '&prefer=' + prefer + '&edit=' + edit + '&stid=' + stid, function(){
            if(document.getElementById('onealert').className == '0')
            {
                alert(document.getElementById('saved').className);
                document.getElementById('onealert').className = 1;
            }
            window.location = document.getElementById('cfg').className;
        });
    }});
}

//Register student in stage 1
//rur indicates whether a rural placement is desired
//edit indicates whether student is editing info or registering for the first time
function register_student2(rur, edit)
{
    //run validation plugin
    $('form.required-form').simpleValidate({
		errorElement: 'em',
                ajaxRequest: true,
		completeCallback: function() {
                    
       var firstname = $("input[name = firstname]").attr('value');
       var lastname = $("input[name = lastname]").attr('value');
       var phone = $("input[name = phone]").attr('value');
       var email = $("input[name = email]").attr('value');
       var address = $("input[name = address]").attr('value');
       var city = $("input[name = city]").attr('value');
       var onecard = $("input[name = onecard]").attr('value');
       var vehicle = $("select[name = vehicle]").attr('value');
       var teacher = $("input[name = teacher]").attr('value');
       var school = $("input[name = school]").attr('value');
       var level2 = $("input[name = level2]").attr('value');
       var core = $("select[name = core]").attr('value');
       
       var lang = '';
       $("input[name = lang]").each(function(){
            if(this.checked)
                lang = this.value;
        });
       
       var level = '';
       $("input[name = level]").each(function(){
            if(this.checked)
                level = this.value;
        });
       
       var major = $("input[name = maj]").attr('value');
       var minor = $("input[name = min]").attr('value');
       
       var type = '';
       $("input[name = type]").each(function(){
            if(this.checked)
                type = this.value;
        });
       
       var rural = '';
       $("input[name = rural]").each(function(){
            if(this.checked)
                rural = this.value;
        });
       
        if(rur)
        {
            var location = $("input[name = location]").attr('value');

            var schol = '';
            $("input[name = scholarship]").each(function(){
                 if(this.checked)
                     schol = this.value;
             });

            var housing = '';
            $("input[name = housing]").each(function(){
                 if(this.checked)
                     housing = this.value;
             });
        }
       
        var specific = $("select[name = specific]").attr('value');
        
        var pref = $("textarea[name = pref]").attr('value');
                    
        var snd = firstname + '|' + lastname + '|' + phone + '|' + email + '|' + address + '|' + city + '|' + onecard + '|' + vehicle + '|' + lang + '|' + level + '|' + major + '|' + minor + '|' + type + '|' + core + '|' + rural + '|' + teacher + '|' + school + '|' + level2;
        
        if(rur)
        {
            rur = 1;
            snd += '|' + location + '|' + schol + '|' + housing;
        }
        else
            rur = 0;
        
        //if a specific school preference has been indicated
        var spec = 0;
        if($("select[name = specific]").attr('value') !== '0')
        {
            spec = 1;
            snd += '|' + specific;
        }
        
        //If any other preferences have been indicated
        var prefer = 0;
        if($("textarea[name = pref]").attr('value') !== '')
        {
            prefer = 1;
            snd += '|' + pref;
        }
        var send = encodeURIComponent(snd);
        
        var stid = 0;
        if(edit == 'true')
            var stid = document.getElementById('studentid').className;
        
        //save info, then go to Moodle home page
        $("#null").load('requestuser.php?reg2=' + send + '&rur=' + rur + '&spec=' + spec + '&prefer=' + prefer + '&edit=' + edit + '&stid=' + stid, function(){
            if(document.getElementById('onealert').className == '0')
            {
                alert(document.getElementById('saved').className);
                document.getElementById('onealert').className = 1;
            }
            window.location = document.getElementById('cfg').className;
        });
    }});
}

//Register student in stage 2
//rur indicates whether a rural placement is desired
//edit indicates whether student is editing info or registering for the first time
function register_student3(rur, edit)
{
    //run jquery validation plugin
    $('form.required-form').simpleValidate({
		errorElement: 'em',
                ajaxRequest: true,
		completeCallback: function() {
                    
       var firstname = $("input[name = firstname]").attr('value');
       var lastname = $("input[name = lastname]").attr('value');
       var phone = $("input[name = phone]").attr('value');
       var email = $("input[name = email]").attr('value');
       var address = $("input[name = address]").attr('value');
       var city = $("input[name = city]").attr('value');
       var onecard = $("input[name = onecard]").attr('value');
       var vehicle = $("select[name = vehicle]").attr('value');
       var teacher = $("input[name = teacher]").attr('value');
       var school = $("input[name = school]").attr('value');
       var level2 = $("input[name = level2]").attr('value');
       var teacher2 = $("input[name = teacher2]").attr('value');
       var school2 = $("input[name = school2]").attr('value');
       var level3 = $("input[name = level3]").attr('value');
       var core = $("select[name = core]").attr('value');
       
       var lang = '';
       $("input[name = lang]").each(function(){
            if(this.checked)
                lang = this.value;
        });
       
       var level = '';
       $("input[name = level]").each(function(){
            if(this.checked)
                level = this.value;
        });
       
       var major = $("input[name = maj]").attr('value');
       var minor = $("input[name = min]").attr('value');
       
       var type = '';
       $("input[name = type]").each(function(){
            if(this.checked)
                type = this.value;
        });
       
       var rural = '';
       $("input[name = rural]").each(function(){
            if(this.checked)
                rural = this.value;
        });
       
        //if a rural placement is desired, record relevant info
        if(rur)
        {
            var location = $("input[name = location]").attr('value');

            var schol = '';
            $("input[name = scholarship]").each(function(){
                 if(this.checked)
                     schol = this.value;
             });

            var housing = '';
            $("input[name = housing]").each(function(){
                 if(this.checked)
                     housing = this.value;
             });
        }
       
        var specific = $("select[name = specific]").attr('value');
        
        var pref = $("textarea[name = pref]").attr('value');
                    
        var snd = firstname + '|' + lastname + '|' + phone + '|' + email + '|' + address + '|' + city + '|' + onecard + '|' + vehicle + '|' + lang + '|' + level + '|' + major + '|' + minor + '|' + type + '|' + core + '|' + rural + '|' + teacher + '|' + school + '|' + level2 + '|' + teacher2 + '|' + school2 + '|' + level3;
        
        //if rural = yes
        if(rur)
        {
            rur = 1;
            snd += '|' + location + '|' + schol + '|' + housing;
        }
        else
            rur = 0;
         
        //if a specific school preference was indicated
        var spec = 0;
        if($("select[name = specific]").attr('value') !== '0')
        {
            spec = 1;
            snd += '|' + specific;
        }
        
        //If any other preferences were indicated
        var prefer = 0;
        if($("textarea[name = pref]").attr('value') !== '')
        {
            prefer = 1;
            snd += '|' + pref;
        }
        var send = encodeURIComponent(snd);
        
        var stid = 0;
        if(edit == 'true')
            var stid = document.getElementById('studentid').className;
        
        //save info, then go to Moodle home page
        $("#null").load('requestuser.php?reg3=' + send + '&rur=' + rur + '&spec=' + spec + '&prefer=' + prefer + '&edit=' + edit + '&stid=' + stid, function(){
            if(document.getElementById('onealert').className == '0')
            {
                alert(document.getElementById('saved').className);
                document.getElementById('onealert').className = 1;
            }
            window.location = document.getElementById('cfg').className;
        });
    }});
}

//go to moodle home page
function return_home()
{
    window.location = document.getElementById('cfg').className;
}

//called when the dialog box is filled
function choose_stage()
{
    var stg = $("#choosestage").attr('value');
    var stage = escape(stg);
    
    $("#null").load('requestuser.php?choose=' + stage, function(){
        window.location = document.getElementById('cfg').className + '/local/placement/user/viewuser.php?register=' + stage;
    });
}


var BrowserDetect = {
    init: function () {
        this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
        this.version = this.searchVersion(navigator.userAgent)
        || this.searchVersion(navigator.appVersion)
        || "an unknown version";
        this.OS = this.searchString(this.dataOS) || "an unknown OS";
    },
    searchString: function (data) {
        for (var i=0;i<data.length;i++)	{
            var dataString = data[i].string;
            var dataProp = data[i].prop;
            this.versionSearchString = data[i].versionSearch || data[i].identity;
            if (dataString) {
                if (dataString.indexOf(data[i].subString) != -1)
                    return data[i].identity;
            }
            else if (dataProp)
                return data[i].identity;
        }
    },
    searchVersion: function (dataString) {
        var index = dataString.indexOf(this.versionSearchString);
        if (index == -1) return;
        return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
    },
    dataBrowser: [
    {
        string: navigator.userAgent,
        subString: "Chrome",
        identity: "Chrome"
    },
    {
        string: navigator.userAgent,
        subString: "OmniWeb",
        versionSearch: "OmniWeb/",
        identity: "OmniWeb"
    },
    {
        string: navigator.vendor,
        subString: "Apple",
        identity: "Safari",
        versionSearch: "Version"
    },
    {
        prop: window.opera,
        identity: "Opera",
        versionSearch: "Version"
    },
    {
        string: navigator.vendor,
        subString: "iCab",
        identity: "iCab"
    },
    {
        string: navigator.vendor,
        subString: "KDE",
        identity: "Konqueror"
    },
    {
        string: navigator.userAgent,
        subString: "Firefox",
        identity: "Firefox"
    },
    {
        string: navigator.vendor,
        subString: "Camino",
        identity: "Camino"
    },
    {		// for newer Netscapes (6+)
        string: navigator.userAgent,
        subString: "Netscape",
        identity: "Netscape"
    },
    {
        string: navigator.userAgent,
        subString: "MSIE",
        identity: "Explorer",
        versionSearch: "MSIE"
    },
    {
        string: navigator.userAgent,
        subString: "Gecko",
        identity: "Mozilla",
        versionSearch: "rv"
    },
    { 		// for older Netscapes (4-)
        string: navigator.userAgent,
        subString: "Mozilla",
        identity: "Netscape",
        versionSearch: "Mozilla"
    }
    ],
    dataOS : [
    {
        string: navigator.platform,
        subString: "Win",
        identity: "Windows"
    },
    {
        string: navigator.platform,
        subString: "Mac",
        identity: "Mac"
    },
    {
        string: navigator.userAgent,
        subString: "iPhone",
        identity: "iPhone/iPod"
    },
    {
        string: navigator.platform,
        subString: "Linux",
        identity: "Linux"
    }
    ]

};
BrowserDetect.init();


