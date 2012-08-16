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

require_once(dirname(__FILE__) . '/config.php');

/**
 * Description of Local_page
 *
 * @author bretin
 */
class Local_page
{

    /**
     *
     * @var array The css array
     */
    private $css;

    /**
     *
     * @var array the js array  
     */
    private $js;

    /**
     *
     * @var array 
     */
    private $menu;

    /**
     * The current page name
     * @var string 
     */
    private $page;

    /**
     * The current page parameters (key = param_name, value = value)
     * @var array 
     */
    private $pageparams;

    /**
     * The current page Title 
     * @var string 
     */
    private $pagetitle;

    /**
     *
     * @global stdobject $CFG
     * @global core_renderer $OUTPUT
     * @global moodle_page $PAGE
     * @param string $page The current page name
     * @param array $pageparams The current page parameters (key = param_name, value = value)
     * @param string $pagetitle The current page Title 
     */
    public function __construct($page, $pageparams = array(), $pagetitle = '')
    {
        global $CFG, $PAGE, $OUTPUT, $SESSION;
        

        $this->page = $page;
        $this->pageparams = $pageparams;
        $this->pagetitle = $pagetitle;
        
        

    }

    /**
     *
     * @global stdobject $CFG
     * @global core_renderer $OUTPUT
     * @global moodle_page $PAGE
     * @return string Return the header to print
     */
    public function generate_header_html()
    {
        global $CFG, $PAGE, $OUTPUT;

        //Set the principal parameters
        $context = get_context_instance(CONTEXT_COURSE, 1);
        $sysctx = get_context_instance(CONTEXT_SYSTEM);

        
        $PAGE->set_title($this->pagetitle);
        $PAGE->set_heading($this->pagetitle);
        $PAGE->set_context($context);

        //Display the header
        return $OUTPUT->header();
    }

    /**
     *
     * @global stdobject $CFG
     * @global core_renderer $OUTPUT
     * @global moodle_page $PAGE
     * @return string Return the header to print
     */
    public function generate_footer_html()
    {
        global $CFG, $PAGE, $OUTPUT;

        return $OUTPUT->footer();
    }


}

?>
