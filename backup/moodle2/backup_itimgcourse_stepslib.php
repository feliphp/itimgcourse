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
defined('MOODLE_INTERNAL') || die;
/**
 * Backup_itimgcourse_activity_structure_step Class
 * 
 * @category Class
 * @package  Moodle
 * @author     JFHR <felsul@hotmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://escuelita.mx
 */
class Backup_Itimgcourse_Activity_Structure_Step extends 
backup_activity_structure_step
{
    /**
     * Defines the backup structure of the module
     *
     * @return backup_nested_element
     */
    protected function defineStructure()
    {
        $userinfo = $this->get_setting_value('userinfo');
        $itimgcourse = new backup_nested_element(
            'itimgcourse', array('id'),
            array('name', 'intro', 'introformat', 'grade')
        );
        $itimgcourse->set_source_table(
            'itimgcourse',
            array('id' => backup::VAR_ACTIVITYID)
        );
        $itimgcourse->annotate_files('mod_itimgcourse', 'intro', null);
        return $this->prepare_activity_structure($itimgcourse);
    }
}
