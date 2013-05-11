<?php

/**
 * XiinEngine
 *
 * XiinEngine and its libraries are supplied under the MIT license. Please read license.md  in the root directory
 *
 * @package XiinEngine Standalone Libraries
 * @author Philip Whitehall <philip.whitehall@xiinet.com> 
 * @copyright Copyright 2006-2013 Xiin Networks <http://xiinet.com/>
 * @link http://xiinengine.com/
 * @version v1.0
 */
class XeForm {

    private $db, $action_location, $action_type, $markup_type, $errors, $output,
            $wrapper = array(
                'outer_left' => '<ul>',
                'outer_right' => '</ul>',
                'left' => '<li>',
                'right' => '</li>'
    );

    public function __construct($db, $action_location, $action_type, $markup_type) {
        $this->db = strip_tags($db);
        $this->action_location = $action_location;
        $this->action_type = (strtolower($action_type) == "post" || strtolower($action_type) == "get") ?
                (strtolower($action_type) == 'post') ? 'post' : 'get'  :
                $this->xe_set_error('invalid_action_type');
        $this->markup_type = (strtolower($markup_type) == "ulli" || strtolower($markup_type) == "table") ?
                (strtolower($markup_type) == 'ulli') ? 'ulli' : 'table'  :
                $this->xe_set_error('invalid_markup_type');

        if (!empty($this->errors))
            echo $this->errors;
    }

    public function __destruct() {
        
    }

    /* Localised XeError function for standalone version */

    private function xe_set_error($error_type) {
        $error_labels = array(
            'invalid_action_type' => 'There was a problem with your action type variable in XeForm.',
            'invalid_editor_type' => 'The editor type you have selected does not exist',
            'invalid_markup_type' => 'There was a problem with your markup type variable in XeForm.'
        );

        (empty($this->errors)) ?
                        $this->errors = '<span style="color: #ff0000;">' . $error_labels[$error_type] . '</span>' :
                        $this->errors .= '<br /><span style="color: #ff0000;">' . $error_labels[$error_type] . '</span>';
    }

    public function xe_get_errors() {
        return $this->wrap_content($this->errors);
    }

    /* LABELS & HELPERS */

    private function wrap_content($meat) {
        return $this->wrapper['left'] . $meat . $this->wrapper['right'];
    }

    private function format_attributes($attributes) {
        $attribute_string = '';
        foreach ($attributes as $key => $value) {
            if (!empty($value))
                $attribute_string .= $key . ' = "' . $value . '" ';
        }
        return $attribute_string;
    }

    private function labels($info) {
        return $this->wrap_content('<label for = "' . $info['db_field'] . '">' . $info['label'] . '</label>')
                . $this->wrap_content('<label for = "' . $info['db_field'] . '">' . $info['description'] . '</label>');
    }

    private function rules($rules) {
        $attributes = array(
            'type' => 'hidden',
            'class' => 'rules',
            'name' => 'rules',
        );
        foreach ($rules as $key => $value) {
            $attributes['data-' . $key] = $value;
        }
        return $this->wrap_content('<input ' . $this->format_attributes($attributes) . ' />');
    }

    /* ROW TYPES */

    private function text($info) {
        $attributes = array(
            'type' => 'text',
            'class' => 'xeform_input_text',
            'name' => $info['db_field'],
            'id' => $info['db_field'],
            'value' => $info['db_result'],
            'maxlength' => (!empty($info['rules']['character_limit'])) ? $info['rules']['character_limit'] : ''
        );
        return $this->wrap_content('<input ' . $this->format_attributes($attributes) . ' />');
    }

    /* MAIN LOOP */

    public function rows($row_info = array()) {
        // public function row($label,$description,$editorType,$dbfield,$dbresult,$rules = array())
        // ACCEPTED ASSOCIATIONS: LABEL, DESCRIPTION, EDITOR_TYPE, DB_FIELD, DB_RESULT, RULES
        $this->output = '';
        for ($i = 0; $i < count($row_info); $i++) {
            $this->output .= $this->wrapper['outer_left'];
            $this->output .= $this->labels($row_info[$i]);
            $this->output .= (method_exists($this, $row_info[$i]['editor_type'])) ?
                    $this->{$row_info[$i]['editor_type']}($row_info[$i]) :
                    $this->xe_set_error('invalid_editor_type');
            $this->output .= $this->rules($row_info[$i]['rules']);
            if (!empty($this->errors))
                $this->output .= $this->xe_get_errors();
            $this->output .= $this->wrapper['outer_right'];
        }



        return $this->output;
    }

}

?>