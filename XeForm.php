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
 * @since v2.0
 */

class XiinEngine_Form {
	private $db, $action_location, $action_type, $markup_type;

	public __construct($db, $action_location, $action_type, $markup_type) {
		$this->db = strip_tags($db);
		$this->action_location = $action_location;
		$this->action_type = $action_type;
		$this->markup_type = $markup_type;
	}

	public __destruct() {

	}

	/**
	*	Localised XeError function for standalone version
	*/
	public xe_error() {

	}
}




?>