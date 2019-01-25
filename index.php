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
require_once dirname(__FILE__).'/lib.php';
require_once dirname(__FILE__).'/form.php';
require_once $CFG->libdir.'/adminlib.php';

$contextid = optional_param('contextid', 0, PARAM_INT);
$openlink = optional_param('openlink', 0, PARAM_INT); 
$user = optional_param('user', 0, PARAM_INT); 
$category_id = optional_param('category_id', 0, PARAM_INT); 
$course_id = optional_param('course_id', 0, PARAM_INT); 
$accion = optional_param('accion', '', PARAM_TEXT); 
$reporte = optional_param('report_visibility', 0, PARAM_INT); 

$page = optional_param('page', 0, PARAM_INT);
$returnurl = optional_param('returnurl', '', PARAM_LOCALURL);
$strname = get_string('itimgcourse', 'itimgcourse');
$site = get_site();
$params = array('page' => $page);
$baseurl = new moodle_url('/mod/itimgcourse/index.php', $params);

if ($contextid) {
    $context = context_system::instance();
} else {
    $context = context_system::instance();
}

require_login();

$PAGE->set_context($context);
$PAGE->set_pagelayout('admin');
$PAGE->set_heading($site->fullname);
$strorg = get_string('itimgcourse', 'itimgcourse');

echo $PAGE->set_title($strorg);  
echo $OUTPUT->header();  
echo $OUTPUT->heading($strname);  
if (empty($accion)) {
    echo "<strong>".get_string('oneinstruction', 'itimgcourse');
    echo "</strong><br><br><br>";
    echo "<span class='glyphicon glyphicon-link'></span>";
    echo "<a href='./index.php?accion=category'>";
    echo get_string('link_category', 'itimgcourse')."</a><br><br>";
    echo "<span class='glyphicon glyphicon-link'></span>";
    echo "<a href='./index.php?accion=course'>";
    echo get_string('link_course', 'itimgcourse')."</a><br><br>";
    echo "<span class='glyphicon glyphicon-link'></span>";
    echo "<a href='./index.php?accion=view'>";
    echo get_string('link_view', 'itimgcourse')."</a><br>";
} else {
    switch($accion){
    case 'category':
        $mform = new category_form();
        if ($mform->is_cancelled()) {
        } else if ($dataform = $mform->get_data()) {
            $registro = Itimgcourse_Item_exist($category_id, $accion);
            //image
            if (empty($entry->id)) {
                $entry = new stdClass;
                $entry->id = $category_id;
            }

            $draftitemid = file_get_submitted_draft_itemid('courseimage');
            file_prepare_draft_area(
                $draftitemid,
                $context->id,
                'mod_itimgcourse',
                'courseimage',
                $entry->id,
                array(
                    'subdirs' => 0,
                    'maxbytes' => $maxbytes,
                    'maxfiles' => 1
                    )
            );

            $entry->attachments = $draftitemid;
            $mform->set_data($entry);

            $file = file_save_draft_area_files(
                $dataform->courseimage,
                $context->id,
                'mod_itimgcourse',
                'courseimage',
                $entry->id,
                array(
                    'subdirs' => 0,
                    'maxbytes' => $maxbytes,
                    'maxfiles' => 50
                )
            );

            $fs = get_file_storage();
            $file_o = $fs->get_area_files(
                $context->id,
                'mod_itimgcourse',
                'courseimage',
                $entry->id
            );
            foreach ($file_o as $f) {
                $filename = $f->get_filename();
            }

            //data
            $dataform->itemid = $category_id;
            $dataform->type = $accion;
            $dataform->report = 1 ;
            $dataform->url_image = $filename;
            if ($registro == 0) {
                itimgcourse_add_image($dataform);
            } else {
                itimgcourse_update_image($dataform, $registro);
            }
            $array_openlink = array('openlink' => $openlink);
            redirect(new moodle_url('/mod/itimgcourse/index.php', $array_openlink));
        } else {
            $mform->set_data($toform);
            $mform->display();
        }
        break;
    case 'course' :
        $mform = new course_form();
        if ($mform->is_cancelled()) {
        } else if ($dataform = $mform->get_data()) {
            $registro = Itimgcourse_Item_exist($course_id, $accion);
            //image
            if (empty($entry->id)) {
                $entry = new stdClass;
                $entry->id = $course_id+9000;
            }

            $draftitemid = file_get_submitted_draft_itemid('courseimage');
            file_prepare_draft_area(
                $draftitemid,
                $context->id,
                'mod_itimgcourse',
                'courseimage',
                $entry->id,
                array(
                    'subdirs' => 0,
                    'maxbytes' => $maxbytes,
                    'maxfiles' => 1
                    )
            );

            $entry->attachments = $draftitemid;
            $mform->set_data($entry);

            $file = file_save_draft_area_files(
                $dataform->courseimage,
                $context->id,
                'mod_itimgcourse',
                'courseimage',
                $entry->id,
                array(
                    'subdirs' => 0,
                    'maxbytes' => $maxbytes,
                    'maxfiles' => 50
                )
            );

            $fs = get_file_storage();
            $file_o = $fs->get_area_files(
                $context->id,
                'mod_itimgcourse',
                'courseimage',
                $entry->id
            );
            foreach ($file_o as $f) {
                $filename = $f->get_filename();
            }
            
            //data
            $dataform->itemid = $course_id;
            $dataform->type = $accion;
            $dataform->report = $reporte;
            $dataform->url_image = $filename;

            if ($registro == 0) {
                itimgcourse_add_image($dataform);
            } else {
                itimgcourse_update_image($dataform, $registro);
            }
            $array_openlink = array('openlink' => $openlink);
            // Use new context id, it has been changed.
            redirect(new moodle_url('/mod/itimgcourse/index.php', $array_openlink));
        } else {
            $mform->set_data($toform);
            $mform->display();
        }
        break;
    case 'view' :
        // function table
        $itimgcourse_array = array();
        $itimgcourse_array =itimgcourse_get_table_images_courses();
        echo '<table border="1"><tr><td>Id</td><td>Item</td><td>Type</td>';
        echo '<td>URL</td><td>Report</td></tr>';
        foreach ($itimgcourse_array as $item) {
            echo '<tr>';
                echo '<td>'.$item->id.'</td>';
                echo '<td>'.$item->itemid.'</td>';
                echo '<td>'.$item->type.'</td>';
                echo '<td>'.$item->url_image.'</td>';
                echo '<td>'.$item->report.'</td>';
            echo '</tr>';
        }
        echo '</table>';
        break;
    }
}
echo $OUTPUT->footer();
