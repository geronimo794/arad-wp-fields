Arad Wordpress Fields

Version 0.0.1 (Beta)

PHP Framework for wordpress theme developer to automatically register the metabox with various kind of field types. With various function to make register metabox fields with clean and easy code.
Geting started

Step 1 : Dowload the arad wp fields from here

Step 2 : Extract the folder to your some location of your wordpress theme. Getting Started 1

Step 3 : Include the arad_fields_class.php to your php file (this file will be included at your function.php)

/**
* Including arad wp fields framework
*
*/
if (!class_exists('arad_fields_class') && file_exists(get_template_directory().'/includes/arad-wp-fields-master/arad_fields_class.php')) {
    require_once(get_template_directory().'/includes/arad-wp-fields-master/arad_fields_class.php');
    if(!class_exists('arad_fields_class')){
        return;
    }
}

Step 4 : Declare the url location of the arad wp fields folder.

/**
* Declare the uri of arad wp field folder
*
*/
arad_fields_class::$arad_dir = get_template_directory_uri().'/includes/arad-wp-fields-master';

Step 5 : Add a metabox.

/**
* add Meta Box
*
*/
arad_fields_class::addMetaBox(
    array(
    'title' => 'Review Score',
    'screen' => 'post',
    'context' => 'normal',
    'fields' => 
        array(
            array(
                'title' => 'Score',
                'name' => 'score',
                'type' => 'range',
                'min' => '0',
                'max' => '100'
            ),
        )
    )
);

Step 6 : Create the Metabox.

/**
* create Meta Box
*
*/
arad_fields_class::createMetaBox();

Step 7 : Enjoy your Metabox. Getting Started 2
Example

You can take look to another example of Meta Box here.
Changelogs

Version 0.0.1 (Beta)

    Add metabox, create metabox.
