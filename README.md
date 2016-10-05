# Arad Wordpress Fields 
Version 0.0.1 (Beta)

PHP Framework for wordpress theme developer to automatically register the metabox with some kind of field types. With various function to make register metabox fields with clean and easy code.

## Geting started
Step 1 :
Dowload the arad wp fields from [here](https://github.com/geronimo794/arad-wp-fields/archive/master.zip) 

Step 2 : Extract the folder to your some location of your wordpress theme.
![Getting Started 1](https://github.com/geronimo794/arad-wp-fields/raw/master/images/getting-started-1.jpg)

Step 3 : Include the arad_fields_class.php to your php file (this file will be included at your function.php)
```php
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
```
Step 4 : Declare the url location of the arad wp fields folder.
```php
/**
* Declare the uri of arad wp field folder
*
*/
arad_fields_class::$arad_dir = get_template_directory_uri().'/includes/arad-wp-fields-master';
```
Step 5 : Add a metabox.
```php
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
```
Step 6 : Create the Metabox.
```php
/**
* create Meta Box
*
*/
arad_fields_class::createMetaBox();
```
Step 7 : Enjoy your Metabox.
![Getting Started 2](https://github.com/geronimo794/arad-wp-fields/raw/master/images/getting-started-2.jpg)
## Field types
##### - Input Text
- Type : **text**
- Options : *title*, *name*, *div_class*, *id*
- Example : 
```php
array(
	'type' => 'text',
	'title' => 'Input Text',
	'name' => 'name',
	'div_class' => 'name_class',
	'id' => 'name_id'
)
```
##### - Range
- Type : **range**
- Options : *title*, *name*, *div_class*, *id*, *min*, *max*
- Example : 
```php
array(
	'type' => 'range',
	'title' => 'Distance',
	'name' => 'distance',
	'div_class' => 'distance_class',
	'id' => 'distance_id',
	'min' => 0,
	'max' => 100
)
```
##### - Images
- Type : **images**
- Options : *title*, *name*, *div_class*, *id*
- Example : 
```php
array(
	'type' => 'images',
	'title' => 'Gallery',
	'name' => 'gallery',
	'div_class' => 'gallery_class',
	'id' => 'gallery_id'
)
```
##### - Video
- Type : **video**
- Options : *title*, *name*, *div_class*, *id*
- Example : 
```php
array(
	'type' => 'video',
	'title' => 'Trailer',
	'name' => 'trailer',
	'div_class' => 'trailer_class',
	'id' => 'trailer_id'
)
```
##### - Audio
- Type : **audio**
- Options : *title*, *name*, *div_class*, *id*
- Example : 
```php
array(
	'type' => 'audio',
	'title' => 'Sound Wave',
	'name' => 'sound_wave',
	'div_class' => 'sound_wave_class',
	'id' => 'soundwave_id'
)
```
##### - Select
- Type : **select**
- Options : *title*, *name*, *div_class*, *id*, *options*
- Example : 
```php
array(
	'type' => 'select',
	'title' => 'Gender',
	'name' => 'gender',
	'div_class' => 'gender_class',
	'id' => 'gender_id',
	'options' => array(
	    'male' => 'Male',
	    'female' => 'Female'
	)
)
```

## Example
You can take look to another example of Meta Box [here](https://github.com/geronimo794/arad-wp-fields/blob/master/example/mta_centric.php).
## Changelogs
Version 0.0.1 (Beta)
- Add metabox, create metabox.
