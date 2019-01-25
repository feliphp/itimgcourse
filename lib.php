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
/**
 * Serves the images course attachments. Implements needed access control ;-)
 *
 * @package  mod_itimgcourse
 * @category files
 * @param stdClass $course course object
 * @param stdClass $cm course module object
 * @param stdClass $context context object
 * @param string $filearea file area
 * @param array $args extra arguments
 * @param bool $forcedownload whether or not force download
 * @param array $options additional options affecting the file serving
 * @return bool false if file not found, does not return if found - justsend the file
 */
function itimgcourse_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
    global $CFG, $DB;

     // Check the contextlevel is as expected - if your plugin is a block, this becomes CONTEXT_BLOCK, etc.
    if ($context->contextlevel != CONTEXT_SYSTEM) {
        return false; 
    }

    $itemid = array_shift($args) ;

    // Make sure the filearea is one of those used by the plugin.
    if ($filearea !== 'courseimage' && $filearea !== 'imgfilearea') {
        return false;
    }

    // Make sure the user is logged in and has access to the module (plugins that are not course modules should leave out the 'cm' part).
    require_login($course, true, $cm);

 
    // Check the relevant capabilities - these may vary depending on the filearea being accessed.
    /*if (!has_capability('mod/itimgcourse:view', $context)) {
        return false;
    }*/
 
    // Use the itemid to retrieve any relevant data records and perform any security checks to see if the
    // user really does have access to the file in question.
 
    // Extract the filename / filepath from the $args array.
    $filename = array_pop($args); // The last item in the $args array.
    if (!$args) {
        $filepath = '/'; // $args is empty => the path is '/'
    } else {
        $filepath = '/'.implode('/', $args).'/'; // $args contains elements of the filepath
    }


 
    // Retrieve the file from the Files API.
    $fs = get_file_storage();
    $file = $fs->get_file($context->id, 'mod_itimgcourse', $filearea, $itemid, $filepath, $filename);

    if (!$file) {
        return false; // The file does not exist.
    }
 
    // We can now send the file back to the browser - in this case with a cache lifetime of 1 day and no filtering. 
    // From Moodle 2.3, use send_stored_file instead.
    send_file($file, $filename, 0, $forcedownload, $options);
}
