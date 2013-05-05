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

    private $db, $action_location, $action_type, $markup_type, $errors;

    public function __construct($db, $action_location, $action_type, $markup_type) {
        $this->db = strip_tags($db);
        $this->action_location = $action_location;
        $this->action_type = (strtolower($action_type) == "post" || strtolower($action_type) == "get") ?
                (strtolower($action_type) == 'post') ? 'post' : 'get'  :
                $this->xe_error('invalid_action_type');
        $this->markup_type = (strtolower($markup_type) == "post" || strtolower($markup_type) == "get") ?
                (strtolower($markup_type) == 'ulli') ? 'ulli' : 'table' :
                $this->xe_error('invalid_markup_type');
        
        if (!empty($this->errors)) echo $this->errors;
        echo $db.$action_location. $action_type.$markup_type;
    }

    public function __destruct() {
        
    }

    /**
     * 	Localised XeError function for standalone version
     */
    public function xe_error($error_type) {
        $error_labels = array(
            'invalid_action_type' => 'There was a problem with your action type variable in XeForm.',
            'invalid_markup_type' => 'There was a problem with your markup type variable in XeForm.'
        );
        
        (empty($this->errors)) ? $this->errors = $error_labels[$error_type] : $this->errors .= '<br />'.$error_labels[$error_type];
    }

}

?>