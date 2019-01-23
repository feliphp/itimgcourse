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
require_once $CFG->libdir.'/adminlib.php';
require_once $CFG->libdir.'/formslib.php';
/**
 * Category_Form Class
 * 
 * @category Class
 * @package  Moodle
 * @author     JFHR <felsul@hotmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://escuelita.mx
 */
class Category_Form extends moodleform
{
    /**
     * Function from Form 
     * 
     * @return null
     */
    public function definition() 
    {
        global $CFG;
        $mform = $this->_form;      
        $categories_array = array();
        $categories_array =itimgcourse_get_categories();
        $type = 'category';

        $div_fitem ='<div id="fitem_id_type" class="fitem fitem_fselect">'.
        '<div class="fitemtitle"><label for="category_id" >'
        .get_string('category', 'itimgcourse').'</label></div>';
        $div_felement ='<div class="felement fselect"><select name="category_id"'.
        ' id="category_id" ><option value="0">'
        .get_string('option_default_category', 'itimgcourse').'</option>';
        $mform->addElement('html', ''.$div_fitem);
        $mform->addElement('html', ''.$div_felement);

        foreach ($categories_array as $cat) {
            $html_cat = '<option value="'.$cat->id.'">'.$cat->name.'</option>';
            $mform->addElement('html', $html_cat);
        }
        $mform->addElement('html', '</select></div></div>'."\n");

        $mform->addElement(
            'filemanager',
            'file_img',
            get_string('image', 'itimgcourse'),
            null,
            array(
                'subdirs' => 0,
                'maxbytes' => $maxbytes,
                'areamaxbytes' => 10485760,
                'maxfiles' => 1,
                'accepted_types' => array('.jpg','.png'),
                'return_types'=> FILE_INTERNAL | FILE_EXTERNAL
                )
        );
        $mform->addElement('hidden', 'accion', $type);
        $this->add_action_buttons(
            $cancel = false,
            $submitlabel = get_string('submit_value', 'itimgcourse')
        );
    }

    /**
     * Function from Validation Form 
     * 
     * @param array $data  comment about this variable
     * @param array $files comment about this variable
     * 
     * @return array
     */
    function validation($data, $files) 
    {
        return array();
    }
}
/**
 * Course_Form Class
 * 
 * @category Class
 * @package  Moodle
 * @author     JFHR <felsul@hotmail.com>
 * @license    https://www.gnu.org/licenses/gpl-3.0.txt GNU/GPLv3
 * @link       https://escuelita.mx
 */
class Course_Form extends moodleform
{
    /**
     * Function from Form 
     * 
     * @return null
     */
    public function definition() 
    {
        global $CFG;
        $mform = $this->_form;      
        $courses_array = array();
        $courses_array =itimgcourse_get_courses();
        $type = 'course';

        $div_fitem ='<div id="fitem_id_type" class="fitem fitem_fselect">'.
        '<div class="fitemtitle"><label for="course_id" >'
        .get_string('course', 'itimgcourse').'</label></div>';
        $div_felement ='<div class="felement fselect"><select name="course_id"'.
        ' id="course_id" ><option value="0">'
        .get_string('option_default_course', 'itimgcourse').'</option>';
        $mform->addElement('html', ''.$div_fitem);
        $mform->addElement('html', ''.$div_felement);

        foreach ($courses_array as $cou) {
            $html_cou = '<option value="'.$cou->id.'">'.$cou->shortname.'</option>';
            $mform->addElement('html', $html_cou);
        }
        $mform->addElement('html', '</select></div></div>'."\n");
        $mform->addElement(
            'filemanager',
            'file_img',
            get_string('image', 'itimgcourse'),
            null,
            array(
                'subdirs' => 0,
                'maxbytes' => $maxbytes,
                'areamaxbytes' => 10485760,
                'maxfiles' => 1,
                'accepted_types' => array('.jpg','.png'),
                'return_types'=> FILE_INTERNAL | FILE_EXTERNAL
                )
        );

        $select_visibilidad_array =[get_string('select_op1', 'itimgcourse'), 
                                    get_string('select_op2', 'itimgcourse')];
        $mform->addElement(
            'select',
            'report_visibility',
            get_string('report_visibility', 'itimgcourse'), 
            $select_visibilidad_array
        );

        $mform->setDefault(
            'report_visibility',
            1
        );
        $mform->addElement('hidden', 'accion', $type);

        $this->add_action_buttons(
            $cancel = false,
            $submitlabel = get_string('submit_value', 'itimgcourse')
        );
        
    }

    /**
     * Function from Validation Form 
     * 
     * @param array $data  comment about this variable
     * @param array $files comment about this variable
     * 
     * @return array
     */
    function validation($data, $files) 
    {
        return array();
    }
}
