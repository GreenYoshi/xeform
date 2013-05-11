XeForm
======

Standalone version of form helpers &amp; validators developed for XE2. It provides a basic shell so that you can pass XeForm a multi-dimensional array with all your field information, so that you don't have to worry about the lengthy, repetitive HTML syntax, and concentrate more on the data.

This is still a work in progress set to improve over time, and is going to be merged in as part of the XiinEngine 2 project

Getting started with XeForm
======
1. Download a copy of XeForm.php
2. Include a link to your local copy of XeForm.php into whatever code needs it
3. Follow the form array example found in */example/index.php*

Current Usage
======
Main attributes
----
* **label** - *compulsory* - Creates a <code>label</code> tag and fills the <code>for=""</code> attribute with **db_field**
* **description** - *compulsory* - Creates a <code>label</code> tag and fills the <code>for=""</code> attribute with **db_field**. The difference between this and **label** is that this will be handled by JavaScript as a *tooltip* later
* **editor_type** - *compulsory* - specifies what input type you wish to use and populates the <code>type=""</code> attribute as such (or pull in the right tags in general). A full list of supported types are listed below
* **db_field** - *compulsory* - This is used for your <code>id=""</code>, <code>name=""</code> in your input field, and <code>for=""</code> in your label fields.
* **db_result** - *compulsory* - This populates your <code>value=""</code> field
* **rules** - This is an array of *rules* for this particular row. Currently supported rules are documented below


Supported editor types
----
Currently, only *text*, *password* and *textarea*. Nothing exciting, yet.

Supported rules
----
* **not_null** - Makes the field compulsory to fill
* **character_limit** - An integer that specifies the character limit of the associated text field

Todo list
======
* PHP - Add validators
* JS - Add a tooltip handler
* JS - Add on-the-fly validation
* HTML - Add ability to use table markup (nice to have)
