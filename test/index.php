<!DOCTYPE html>
<html>
<head>
    <title>XiinEngine Forms - Standalone version</title>
    <meta charset="utf-8">
</head>
<body>
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
include ('../XeForm.php');
$form_array = array(
    array(
        'label' => 'First Name',
        'description' => 'This is where you enter your first name',
        'editor_type' => 'text',
        'db_field' => 'first_name',
        'db_result' => 'Phil',
        'rules' => array(
            'not_null' => true,
            'character_limit' => 20
        )
    ),
    array(
        'label' => 'Last Name',
        'description' => 'This is where you enter your last name',
        'editor_type' => 'text',
        'db_field' => 'last_name',
        'db_result' => 'Whitehall',
        'rules' => array(
            'not_null' => true,
            'character_limit' => 50
        )
    ),
    array(
        'label' => 'Bio',
        'description' => 'Talk about yourself!',
        'editor_type' => 'textarea',
        'db_field' => 'description',
        'db_result' => 'This is a description about me. It&rsquo;s fantastic!',
        'rules' => array(
            'not_null' => true,
            'character_limit' => 50
        )
    )
);
$form_object = new XeForm('db', 'edit.php', 'POST', 'ulli');
$form_output = 
$form_output = $form_object->rows($form_array);
echo $form_output;

?>
</body>
</html>
