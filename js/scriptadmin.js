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

function add_principle()
{
    var firstname = $("input[name = firstname]").attr('value');
    var lastname = $("input[name = lastname]").attr('value');
    var email = $("input[name = email]").attr('value');
    
    var snd = firstname + '|' + lastname + '|' + email;
    var send = encodeURIComponent(snd);
    
    $("#null").load('request.php?addp=' + send, function(){
        alert(document.getElementById('addp').className);
        $("input[name = firstname]").val('');
        $("input[name = lastname]").val('');
        $("input[name = email]").val('');
    });
}

function add_student()
{
    var firstname = $("input[name = firstname2]").attr('value');
    var lastname = $("input[name = lastname2]").attr('value');
    var email = $("input[name = email2]").attr('value');
    
    var snd = firstname + '|' + lastname + '|' + email;
    var send = encodeURIComponent(snd);
    
    $("#null").load('request.php?adds=' + send, function(){
        alert(document.getElementById('adds').className);
        $("input[name = firstname2]").val('');
        $("input[name = lastname2]").val('');
        $("input[name = email2]").val('');
    });
}

function enter_placement()
{
    window.location = document.getElementById('cfg').className + '/local/placement/admin/view.php?view=tool';
}


$(document).ready(function(){
    
    $( ".draggable" ).draggable({
        revert:'invalid'
    });
    
    $(".droppable").droppable({
        tolerance:'touch',
        drop: function(event, ui) {
        var drop_p = $(this).offset();
        var drag_p = ui.draggable.offset();
        var left_end = drop_p.left - drag_p.left + 1;
        var top_end = drop_p.top - drag_p.top + 1;
        ui.draggable.animate({
            top: '+=' + top_end,
            left: '+=' + left_end
        });
    }
    });
});