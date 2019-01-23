<?php
/**
 * Fecha:  2019-01-17 - Update: 2019-01-22
 * PHP Version 7
 * 
 * @category   Components
 * @package    Moodle
 * @subpackage Mod_Itimgcourse
 * @author     JFHR <felsul@hotmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://escuelita.mx
 */
namespace mod_itimgcourse\event;
defined('MOODLE_INTERNAL') || die();
/**
 * Course_module_viewed Class
 * 
 * @category Class
 * @package  Moodle
 * @author     JFHR <felsul@hotmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://escuelita.mx
 */
class Course_Module_Viewed extends \core\event\course_module_viewed
{
    /**
     * Function init 
     * 
     * @return null
     */
    protected function init() 
    {
        $this->data['objecttable'] = 'itimgcourse';
        parent::init();
    }
}
