<?php
/**
* Including arad wp fields framework
*
*/
if (!class_exists('arad_fields_class') && file_exists(TMINT_FILEPATH.'/includes/arad_wp_fields/arad_fields_class.php')) {
	require_once(TMINT_FILEPATH.'/includes/arad_wp_fields/arad_fields_class.php');
	if(!class_exists('arad_fields_class')){
		return;
	}
}
arad_fields_class::$arad_dir = TMINT_DIRECTORY.'/includes';

/**
* Metabox for review score
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

/**
* Metabox for post format
*
*/
// Images
arad_fields_class::addMetaBox(
	array(
	'id' => 'arad_gallery',
	'title' => 'Gallery',
	'screen' => 'post',
	'context' => 'side',
	'priority' => 'high',
	'fields' => 
		array(
			array(
				'title' => 'Images',
				'name' => 'gallery',
				'type' => 'images'	
			),
		)
	)
);
// Video
arad_fields_class::addMetaBox(
	array(
	'id' => 'arad_video',
	'title' => 'Video',
	'screen' => 'post',
	'context' => 'side',
	'priority' => 'high',
	'fields' => 
		array(
			array(
				'title' => 'Video Type',
				'name' => 'video_type',
				'type' => 'select',
				'options' => 
					array(
						'youtube' => 'Youtube',
						'vime' => 'Vimeo',
						'media' => 'My Media'
					)
			),
			array(
				'title' => 'Video Height',
				'name' => 'video_height',
				'type' => 'text'
			),
			array(
				'title' => '(Youtube/Vimeo) Video ID',
				'name' => 'video_id',
				'type' => 'text'
			),
			array(
				'title' => 'Upload Video',
				'name' => 'video_media',
				'type' => 'video'
			),
		)
	)
);
// Audio
arad_fields_class::addMetaBox(
	array(
	'id' => 'arad_audio',
	'title' => 'Audio',
	'screen' => 'post',
	'context' => 'side',
	'priority' => 'high',
	'fields' => 
		array(
			array(
				'title' => 'Soundcloud API url',
				'name' => 'soundcloud_api',
				'type' => 'text'
			),
			array(
				'title' => 'Upload Audio',
				'name' => 'audio_media',
				'type' => 'audio'
			),
		)
	)
);
// Quote
arad_fields_class::addMetaBox(
	array(
	'id' => 'arad_quote',
	'title' => 'Quote',
	'screen' => 'post',
	'context' => 'side',
	'priority' => 'high',
	'fields' => 
		array(
			array(
				'title' => 'Text',
				'name' => 'quote',
				'type' => 'text'
			)
		)
	)
);
arad_fields_class::createMetaBox();