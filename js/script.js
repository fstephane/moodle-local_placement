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

function edit()
{
var id = 0;
var root = '';
var none = true;

    $(".radio1").each(function(){
        if(this.checked)
        {
           id = this.value;
           root = this.alt;
           none = false;
        }
    });
    
    if(!none)
        window.location = root + '/local/placement/user/viewadmin.php?view=edit&id=' + id;
    else
        alert(document.getElementById("alert").className);
}

function edit_sch()
{
    window.location = document.getElementById('cfg').className + '/local/placement/user/viewadmin.php?view=editschool';
}

function add_teacher()
{
    window.location = $(".radio1").attr('alt') + '/local/placement/user/viewadmin.php?view=add';
}

function check_grade2()
{
    $("#newteacher").submit(function(e){
            e.preventDefault();
        });
    var checked = false;
    $(".checkbox1").each(function(){
        if(this.checked)
            checked = true;
    });

    if(!checked)
        alert(document.getElementById('choosegrade').className);
    else
    {
        var check = false;
        $("input[name=stage]").each(function(){
            if(this.checked)
                check = true;
        });
        
        if(!check)
            alert(document.getElementById('choosestage').className);
        else
            new_teacher();
    }
}

function new_teacher()
{
    $('form.required-form').simpleValidate({
		errorElement: 'em',
                ajaxRequest: true,
		completeCallback: function() {
                
        var firstname = $("input[name = firstname]").attr('value');
        var lastname = $("input[name = lastname]").attr('value');
        var experience = $("input[name = experience]").attr('value');
        var levelexp = $("input[name = levelexp]").attr('value');
        var grd = '';

        $(".checkbox1").each(function(){
            if(this.checked)
                grd = grd + this.value + ',';
        });

        var grade = grd.slice(0, -1);
        var email = $("input[name = email]").attr('value');
        var taught = $("textarea[name = taught]").attr('value');
        var pref = $("textarea[name = pref]").attr('value');
        var stg = 0;

        $("input[name = stage]").each(function(){
            if(this.checked)
                stg = this.value;
        });
        var stage = '';
        switch(stg)
        {
            case '1':
                stage = 'EDU E 331'
                break;
            case '2':
                stage = 'Stage 1';
                break;
            case '3':
                stage = 'Stage 2';
                break;
        }

        var sess = 0;

        $("input[name = session]").each(function(){
            if(this.checked)
                sess = this.value;
        });
        var session = '';

        switch(sess)
        {
            case '1':
                session = 'Fall';
                break;
            case '2':
                session = 'Winter';
                break;
        }

        var snd = firstname + '|' + lastname + '|' + experience + '|' + levelexp + '|' + grade + '|' + email + '|' + taught + '|' + pref + '|' + stage + '|' + session;
        var send = escape(snd);

        $("#null").load('request.php?addt=' + send, function(){
            alert(document.getElementById('worked').className);
            window.location = document.getElementById('cfg').className + '/local/placement/user/viewadmin.php?view=admin';
        });
        }
    });
}

function return_admin()
{
    window.location = document.getElementById('cfg').className + '/local/placement/user/viewadmin.php?view=admin';
}

function check_grade(id)
{
    $("#newteacher").submit(function(e){
            e.preventDefault();
        });
   var checked = false;
    $(".checkbox1").each(function(){
        if(this.checked)
            checked = true;
    });
    
    if(!checked)
        alert(document.getElementById('choosegrade').className);
    else
    {
        edit_teacher(id);
    }
}

function edit_teacher(id)
{
    $('form.required-form').simpleValidate({
		errorElement: 'em',
                ajaxRequest: true,
		completeCallback: function() {
                    
            var firstname = $("input[name = firstname]").attr('value');
            var lastname = $("input[name = lastname]").attr('value');
            var experience = $("input[name = experience]").attr('value');
            var levelexp = $("input[name = levelexp]").attr('value');
            var grd = '';

            $(".checkbox1").each(function(){
                if(this.checked)
                    grd = grd + this.value + ',';
            });

            var grade = grd.slice(0, -1);
            var email = $("input[name = email]").attr('value');
            var taught = $("textarea[name = taught]").attr('value');
            var pref = $("textarea[name = pref]").attr('value');
            var stg = 0;

            $("input[name = stage]").each(function(){
                if(this.checked)
                    stg = this.value;
            });
            var stage = '';
            switch(stg)
            {
                case '1':
                    stage = 'EDU E 331'
                    break;
                case '2':
                    stage = 'Stage 1';
                    break;
                case '3':
                    stage = 'Stage 2';
                    break;
            }

            var sess = 0;

            $("input[name = session]").each(function(){
                if(this.checked)
                    sess = this.value;
            });
            var session = '';

            switch(sess)
            {
                case '1':
                    session = 'Fall';
                    break;
                case '2':
                    session = 'Winter';
                    break;
            }

            var snd = firstname + '|' + lastname + '|' + experience + '|' + levelexp + '|' + grade + '|' + email + '|' + taught + '|' + pref + '|' + stage + '|' + session;
            var send = escape(snd);  
            
            
            $("#null").load('request.php?editt=' + send + '&tid=' + id, function(){
                alert(document.getElementById('edited').className);
                window.location = document.getElementById('cfg').className + '/local/placement/user/viewadmin.php?view=admin';
            });
        }
    });
}

function new_user()
{
    var $dialog = $('<div></div>')
		.html('This dialog will show every time!')
		.dialog({
			autoOpen: false,
			title: 'Basic Dialog'
		});

	$('#opener').click(function() {
		$dialog.dialog('open');
		// prevent the default action, e.g., following a link
		return false;
	});
}

function create_user()
{
    var school = '';
    var board = '';
    var firstname = $("#firstname").html();
    var lastname = $("#lastname").html();
    var email = $("#email").html();
    var newschool = 0;
    var newboard = 0;
    var sex = '';
    var lang = '';
    
    $(".radio1").each(function(){
        if(this.checked)
        {
            switch(this.value)
            {
                case '0':
                    sex = 'm';
                    break;
                case '1':
                    sex = 'f';
                    break;
            }
        }
    })

    $(".radio2").each(function(){
        if(this.checked)
            switch(this.value)
            {
                case '0':
                    lang = 'fr';
                    break;
                case '1':
                    lang = 'en';
                    break;
            }
    })
    
    if(document.getElementById('createschool').style.display  == 'none')
        school = $("#sch").attr('value');
    else
    {
        school = $("#schooltext").attr('value');
        newschool = 1;
    }
    
    if(document.getElementById('createschool').style.display == 'none')
        board = $("#sb").html();
    else if(document.getElementById('hidemenu').style.display !== 'none')
        board = $("#hidemenu").attr('value');
    else
    {
        board = $("#showtext").attr('value');
        newboard = 1;
    }
    
    var snd = firstname + '|' + lastname + '|' + email + '|' + board + '|' + school + '|' + sex + '|' + lang;
    var send = encodeURIComponent(snd);
    
    $("#null").load('request.php?prin=' + send + '&newboard=' + newboard + '&newschool=' + newschool, function(){
        alert(document.getElementById('saved').className);
        window.location = document.getElementById('cfg').className + '/local/placement/user/viewadmin.php?view=editschool';
    });
}

function save_school()
{                   
        var name = $("#name").attr('value');
        var address = $("#address").attr('value');
        var city = $("#city").attr('value');
        var sphone = $("#schoolphone").attr('value');
        var province = $("#province").attr('value');
        var postal = $("#postal").attr('value');
        var pfirst = $("#firstname").attr('value');
        var plast = $("#lastname").attr('value');
        var pemail = $("#email").attr('value');
        var pphone = $("#phone").attr('value');
        var cfirst = $("#firstnamecon").attr('value');
        var clast = $("#lastnamecon").attr('value');
        var cphone = $("#phonecon").attr('value');
        var fax = $("#fax").attr('value');
        var cemail = $("#emailcon").attr('value');
        var clang = $("#lang").attr('value');
        var csex = $("#sex").attr('value');
        var board = $("#board").attr('value');
        var program = $("#program").attr('value');
        var site = $("#website").attr('value');
        var zone = $("#zone").attr('value');
        
        if((name == '') || (address == '') || (city == '') || (sphone == '') || (province == '') || (postal == '') || (pfirst == '') || (plast == '') || (pemail == '') || (pphone == '') || (cfirst == '') || (clast == '') || (cphone == '') || (cemail == '') || (clang == '') || (csex == '') || (board == '') || (program == '') || (site == '') || (zone == ''))
            alert(document.getElementById('req').className);
        else
        {
            var snd = name + '|' + address + '|' + city + '|' + sphone + '|' + province + '|' + postal + '|' + pfirst + '|' + plast + '|' + pemail + '|' + pphone + '|' + cfirst + '|' + clast + '|' + cphone + '|' + fax + '|' + cemail + '|' + clang + '|' + csex + '|' + board + '|' + program + '|' + site + '|' + zone;
            var send = encodeURIComponent(snd);
            
            $("#null").load('request.php?school=' + send, function(){
                alert(document.getElementById('saved').className);
                window.location = document.getElementById('cfg').className + '/local/placement/user/viewadmin.php?view=admin';
            });
        }
}

$(document).ready(function(){
    if((BrowserDetect.browser == 'Firefox') || (BrowserDetect.browser == 'Explorer'))
    {
        if($("#move").length > 0)
        {
            document.getElementById('move').style.height = '15px';

            $("#move2").css('top', 3);
            $('#move3').css('margin-left', 25);
            $("#move4").css('left', 10);
            $("#move5").css('top', 0);
            $("#move6").css('bottom', 10);
        }
        else if($("#shift").length > 0)
        {
            $("#shift").css('margin-top', 23);
            $("#shift2").css('bottom', 70);
            $("#shift3").css('margin-top', 10);
        }
    }
    
    if($("#move").length > 0)
    {
        document.getElementById("move").style.visibility = 'visible';
        document.getElementById("move2").style.visibility = 'visible';
        document.getElementById("move3").style.visibility = 'visible';
        document.getElementById("move4").style.visibility = 'visible';
        document.getElementById("move5").style.visibility = 'visible';
    }
    else if($("#shift").length > 0)
    {
        document.getElementById("shift").style.visibility = 'visible';
        document.getElementById("shift2").style.visibility = 'visible';
    }
    
    if($("#initialize").length > 0)
    {
        document.getElementById('savebutton').disabled = true;
        document.getElementById('savebutton').style.color = 'grey';
        $("#initialize").show();
        var school = $("#sch").attr('value');
        var sch = encodeURIComponent(school);
        $("#sb").load('request.php?sb=' + sch);
        
        $("#initialize").dialog({ dialogClass: 'no-close' }, { resizable: false });
        $("#initialize").dialog('option','width', '430');
        $("#initialize").dialog('option','height', '490');
        
        var winH = $(window).height() - 240;
        var winW = $(window).width() - 20;
    
        $("#mask").css({'height': winH, 'width': winW});
        
        $('#mask').fadeIn(1000);    
        $('#mask').fadeTo("slow",0.8); 
        
        $(window).resize(function(){
            $("#initialize").dialog("option", "position", "center");
            
            winH = $(window).height() - 240;
            winW = $(window).width() - 20;
    
            $("#mask").css({'height': winH, 'width': winW});
        });
        
        $("#savebutton").hover(function(){
            $("#savebutton").css('background-color', 'darkorange');
        }, function(){
            $("#savebutton").css('background-color', 'orange');
        });
    }
    
    if($("#province").length > 0)
    {
        if($("#province").attr('name') !== '')
            document.getElementById("province").value = $("#province").attr('name');
        if($("#lang").attr('name') !== '')
            document.getElementById("lang").value = $("#lang").attr('name');
        if($("#sex").attr('name') !== '')
            document.getElementById("sex").value = $("#sex").attr('name');
        if($("#board").attr('name') !== '')
            document.getElementById("board").value = $("#board").attr('name');
        if($("#program").attr('name') !== '')
            document.getElementById("program").value = $("#program").attr('name');
    }
});

function school_select(school)
{
    var sch = encodeURIComponent(school);
    $("#sb").load('request.php?sb=' + sch);
}

$("#hideschool").click(function(){
    var radio1 = false;
    var radio2 = false;
    
    $('.radio1').each(function(){
        if(this.checked)
            radio1 = true;
    });

    $('.radio2').each(function(){
        if(this.checked)
            radio2 = true;
    });
    
    if((radio1) && (radio2))
    {
        document.getElementById('savebutton').disabled = false;
        document.getElementById('savebutton').style.color = 'white';
    }
    $("#createschool").hide();
    $("#boardind").fadeIn('slow');
    $("#initialize").dialog('option','height', '490');
    document.getElementById('grey').style.opacity = 1;
});

$("#newschool").click(function(){
    document.getElementById('savebutton').disabled = true;
    document.getElementById('savebutton').style.color = 'grey';
    $("#initialize").dialog('option','height', '510');
    $("#createschool").slideDown('slow');
    $("#boardind").hide();
    document.getElementById('grey').style.opacity = 0.4;
});

function disable_school(value)
{
    var radio1 = false;
    var radio2 = false;
    
    $('.radio1').each(function(){
        if(this.checked)
            radio1 = true;
    });

    $('.radio2').each(function(){
        if(this.checked)
            radio2 = true;
    });
    
    if((value.length > 0) && (document.getElementById('showtext').style.display == 'none') && (radio1) && (radio2))
    {
        document.getElementById('savebutton').disabled = false;
        document.getElementById('savebutton').style.color = 'white';
        
    }
    else if((value.length > 0) && ($("#showtext").attr('value').length > 0) && (radio1) && (radio2))
    {
        document.getElementById('savebutton').disabled = false;
        document.getElementById('savebutton').style.color = 'white';
    }
    else if(value.length < 1)
    {
        document.getElementById('savebutton').disabled = true;
        document.getElementById('savebutton').style.color = 'grey';
    }
}

function disable_board(value)
{
    var radio1 = false;
    var radio2 = false;
    
    $('.radio1').each(function(){
        if(this.checked)
            radio1 = true;
    });

    $('.radio2').each(function(){
        if(this.checked)
            radio2 = true;
    });
    
    if((value.length > 0) && ($("#schooltext").attr('value').length > 0) && (radio1) && (radio2))
    {
        document.getElementById('savebutton').disabled = false;
        document.getElementById('savebutton').style.color = 'white';
    }
    else if(value.length < 1)
    {
        document.getElementById('savebutton').disabled = true;
        document.getElementById('savebutton').style.color = 'grey';
    }
}

$(".radio1").click(function(){
    var radio1 = false;
    var radio2 = false;
    
    $('.radio1').each(function(){
        if(this.checked)
            radio1 = true;
    });

    $('.radio2').each(function(){
        if(this.checked)
            radio2 = true;
    });
    
    if(document.getElementById('createschool').style.display == 'none')
    {
        if((radio1) && (radio2))
        {
            document.getElementById('savebutton').disabled = false;
            document.getElementById('savebutton').style.color = 'white';
        }
        else
        {
            document.getElementById('savebutton').disabled = true;
            document.getElementById('savebutton').style.color = 'grey';
        }
    }
    else
    {
        if(document.getElementById('showtext').style.display == 'none')
        {
            if((radio1) && (radio2) && ($("#schooltext").length > 0))
            {
                document.getElementById('savebutton').disabled = false;
                document.getElementById('savebutton').style.color = 'white';
            }
            else
            {
                document.getElementById('savebutton').disabled = true;
                document.getElementById('savebutton').style.color = 'grey';
            }  
        }
        else
        {
            if((radio1) && (radio2) && ($("#schooltext").length > 0) && ($("#showtext").length > 0))
            {
                document.getElementById('savebutton').disabled = false;
                document.getElementById('savebutton').style.color = 'white';
            }
            else
            {
                document.getElementById('savebutton').disabled = true;
                document.getElementById('savebutton').style.color = 'grey';
            }  
        }
    }
});

$(".radio2").click(function(){
    var radio1 = false;
    var radio2 = false;
    
    $('.radio1').each(function(){
        if(this.checked)
            radio1 = true;
    });

    $('.radio2').each(function(){
        if(this.checked)
            radio2 = true;
    });
    
    if(document.getElementById('createschool').style.display == 'none')
    {
        if((radio1) && (radio2))
        {
            document.getElementById('savebutton').disabled = false;
            document.getElementById('savebutton').style.color = 'white';
        }
        else
        {
            document.getElementById('savebutton').disabled = true;
            document.getElementById('savebutton').style.color = 'grey';
        }
    }
    else
    {
        if(document.getElementById('showtext').style.display == 'none')
        {
            if((radio1) && (radio2) && ($("#schooltext").length > 0))
            {
                document.getElementById('savebutton').disabled = false;
                document.getElementById('savebutton').style.color = 'white';
            }
            else
            {
                document.getElementById('savebutton').disabled = true;
                document.getElementById('savebutton').style.color = 'grey';
            }  
        }
        else
        {
            if((radio1) && (radio2) && ($("#schooltext").length > 0) && ($("#showtext").length > 0))
            {
                document.getElementById('savebutton').disabled = false;
                document.getElementById('savebutton').style.color = 'white';
            }
            else
            {
                document.getElementById('savebutton').disabled = true;
                document.getElementById('savebutton').style.color = 'grey';
            }  
        }
    }
});

$("#newboard").click(function(){
    if(document.getElementById('showtext').style.display == 'none')
    {
        $("#hidemenu").hide();
        $("#showtext").slideDown('slow');
        document.getElementById('newboard').innerHTML = document.getElementById('newboard').className;
        document.getElementById('savebutton').disabled = true;
        document.getElementById('savebutton').style.color = 'grey';
    }
    else
    {
        $("#showtext").hide();
        $("#hidemenu").slideDown('slow');
        document.getElementById('newboard').innerHTML = document.getElementById('newboard').rel;
    }
});

$("#grade").hover(function(){
    document.getElementById('grade').style.backgroundColor = 'dimgray';
    
    if(document.getElementById('list').style.display == 'none')
    {
        $("#list").slideDown();
    }
},
function(){
    document.getElementById('grade').style.backgroundColor = 'darkgray';
    if((document.getElementById('list').style.display == '') || (document.getElementById('list').style.display == 'block'))
        $("#list").slideUp('fast');
});

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
