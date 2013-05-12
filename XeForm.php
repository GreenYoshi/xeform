<?php

/**
 * XiinEngine - XeForm Library PHP
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
                'outer_left' => '<ul id="xeform_wrapper">',
                'outer_right' => '</ul>',
                'left' => '<li class="xeform_form_entry">',
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
        return;
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
        return $this->_wrap_content($this->errors);
    }

    /* LABELS & HELPERS */

    private function _wrap_content($meat) {
        return $this->wrapper['left'] . $meat . $this->wrapper['right'];
    }

    private function _format_attributes($attributes) {
        $attribute_string = '';
        foreach ($attributes as $key => $value) {
            if (!empty($value))
                $attribute_string .= $key . '="' . $value . '" ';
        }
        return $attribute_string;
    }

    private function _labels($info) {
        return $this->_wrap_content('<label class="xeform_label" for="' . $info['db_field'] . '">' . $info['label'] . '</label>')
                . $this->_wrap_content('<label class="xeform_description" for="' . $info['db_field'] . '">' . $info['description'] . '</label>');
    }

    private function _input_tag($type, $info) {
        $attributes = array(
            'type' => $type,
            'class' => 'xeform_input_' . $type,
            'name' => $info['db_field'],
            'id' => $info['db_field'],
            'value' => ($type !== 'password') ? $info['db_result'] : '',
            'maxlength' => (!empty($info['rules']['character_limit'])) ? $info['rules']['character_limit'] : ''
        );
        return $this->_wrap_content('<input ' . $this->_format_attributes($attributes) . ' />');
    }

    private function _rules($rules) {
        $attributes = array(
            'type' => 'hidden',
            'class' => 'xeform_rules',
            'name' => 'rules',
        );
        foreach ($rules as $key => $value) {
            $attributes['data-' . $key] = $value;
        }
        return $this->_wrap_content('<input ' . $this->_format_attributes($attributes) . ' />');
    }

    /* ROW TYPES */

    private function text($info) {
        return $this->_input_tag('text', $info);
    }

    private function password($info) {
        return $this->_input_tag('password', $info);
    }

    private function textarea($info) {
        $attributes = array(
            'class' => 'xeform_input_textarea',
            'name' => $info['db_field'],
            'id' => $info['db_field'],
            'maxlength' => (!empty($info['rules']['character_limit'])) ? $info['rules']['character_limit'] : ''
        );
        return $this->_wrap_content('<textarea ' . $this->_format_attributes($attributes) . ' >' . $info['db_result'] . '</textarea>');
    }

    /* PUBLIC METHODS */

    public function open_form() {
        return '<form enctype="multipart/form-data" action="' . $this->action_location . '" method="' . $this->action_type . '">';
    }

    public function close_form() {
        return '</form>';
    }

    public function buttons() {
        return '<input type="submit" class="xeform_button_submit" name="action" value="Edit" />';
    }

    public function rows($row_info = array()) {
        $this->output = '';
        for ($i = 0; $i < count($row_info); $i++) {
            $this->output .= $this->wrapper['outer_left'];
            $this->output .= $this->_labels($row_info[$i]);
            $this->output .= (method_exists($this, $row_info[$i]['editor_type'])) ?
                    $this->{$row_info[$i]['editor_type']}($row_info[$i]) :
                    $this->xe_set_error('invalid_editor_type');
            $this->output .= $this->_rules($row_info[$i]['rules']);
            if (!empty($this->errors))
                $this->output .= $this->xe_get_errors();
            $this->output .= $this->wrapper['outer_right'];
        }
        return $this->output;
    }

}

?>