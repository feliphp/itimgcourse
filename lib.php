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
require_once dirname(dirname(dirname(__FILE__))).'/config.php';

defined('MOODLE_INTERNAL') || die();
/**
 * Get Categories
 * 
 * @return array
 */
function Itimgcourse_Get_categories() 
{
    global $DB;
    return $DB->get_records_sql("SELECT id,name FROM {course_categories}");
}
/**
 * Get Courses
 * 
 * @return array
 */
function Itimgcourse_Get_courses()
{
    global $DB;
    return $DB->get_records_sql("SELECT id,shortname FROM {course}");
}
/**
 * Get Table
 * 
 * @return array
 */
function Itimgcourse_Get_Table_Images_courses()
{
    global $DB;
    return $DB->get_records_sql("SELECT * FROM {itimgcourse}");
}
/**
 * Add Image
 * 
 * @param array $dataform comment about this variable
 * 
 * @return int
 */
function Itimgcourse_Add_image($dataform)
{
    global $DB;
    $itimgcourse->id = $DB->insert_record('itimgcourse', $dataform);
    return $itimgcourse->id;
}
/**
 * Update Image
 * 
 * @param array $dataform comment about this variable
 * @param int   $idreg    comment about this variable
 * 
 * @return int
 */
function Itimgcourse_Update_image($dataform, $idreg)
{
    global $DB;
    $dataform->id = $idreg;
    $itimgcourse->id = $DB->update_record('itimgcourse', $dataform);
    return $itimgcourse->id;
}
/**
 * Item Exist
 * 
 * @param int    $itemid comment about this variable
 * @param string $type   comment about this variable
 * 
 * @return int
 */
function Itimgcourse_Item_exist($itemid, $type)
{
    global $DB;
    $sql = "SELECT id FROM {itimgcourse} WHERE itemid = ".
    $itemid." AND type = '".$type."'";
    $array_sql = $DB->get_record_sql($sql);
    $id_update = 0;
    foreach ($array_sql as $item) {
        $id_update = $item;
    }
    return $id_update;
}
