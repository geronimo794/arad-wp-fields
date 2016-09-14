<?php
require('arad_form_class.php');

if(!class_exists(arad_fields_class)){
class arad_fields_class{
	
	public static $metabox_data;
	private static $metabox_count;
	public static $arad_dir;
	
	public function __construct(){
		self::$metabox_data = array();
		self::$metabox_count = 0;
	}
	private function generateDefaultValue(){
		self::$metabox_data['meta'][self::$metabox_count]['id'] = 'arad_m'.md5(self::$metabox_count);
		self::$metabox_data['meta'][self::$metabox_count]['title'] = 'Arad';
		self::$metabox_data['meta'][self::$metabox_count]['screen'] = null;
		self::$metabox_data['meta'][self::$metabox_count]['context'] = 'advanced';
		self::$metabox_data['meta'][self::$metabox_count]['priority'] = 'high';
	}
	public function addMetaBox($metabox_input){
		if(is_array($metabox_input)){
			self::generateDefaultValue();
			foreach($metabox_input as $key => $value){
				if($key === 'fields'){
					self::$metabox_data['fields'][self::$metabox_count] = $value;
				}else{
					self::$metabox_data['meta'][self::$metabox_count][$key] = $value;
				}
			}
			self::$metabox_count++;
		}
	}
	public function createMetaBox(){
		if(is_admin()) {
			
			wp_register_script('arad-scripts', self::$arad_dir.'/arad_wp_fields/js/arad-scripts.js', array('jquery'), '1.0.0', true);
			wp_register_style('arad-styles', self::$arad_dir.'/arad_wp_fields/css/arad-styles.css', array(), '1.0.0');

			wp_enqueue_style('arad-styles');
			wp_enqueue_script('arad-scripts');

			add_action('load-post.php', array(__CLASS__, 'initMetaBox'));
			add_action('load-post-new.php', array(__CLASS__, 'initMetaBox'));
		}
	}
	public function initMetaBox(){
		add_action('add_meta_boxes', array(__CLASS__, 'generateMetaBox'));
		add_action('save_post', array(__CLASS__, 'saveMetaBox' ), 10, 2 );
	}
	public function generateMetaBox(){
		for($i=0; $i < self::$metabox_count; $i++){
			add_meta_box( 
				self::$metabox_data['meta'][$i]['id'],
				self::$metabox_data['meta'][$i]['title'],
				array(__CLASS__, 'generateForm'),
				self::$metabox_data['meta'][$i]['screen'],
				self::$metabox_data['meta'][$i]['context'],
				self::$metabox_data['meta'][$i]['priority'],
				self::$metabox_data['fields'][$i]);
		}
	}
	public function generateForm($post, $fields_array){
		$post_id = $post->ID;
		arad_form_class::generateForm($post_id, $fields_array);
	}
	public function saveMetaBox($post_id, $post){
		/**
		* Check is autosave
		*
		*/
	    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
	        return;
	    }

	    /**
		* Check user permissions
		*
		*/
	    if('page' == $_POST['post_type']){
	        if(!current_user_can('edit_page', $post_id)){
	            return;
	        }
	    }elseif(!current_user_can('edit_post', $post_id)){
	        return;
	    }
		
	    /**
		* Validate nonce every metabox
		*
		*/
		for($i=0; $i<self::$metabox_count; $i++){
			if(!arad_form_class::validateNonce(self::$metabox_data['meta'][$i]['id'])){
				return;
			}
		}
		
	    /**
		* Save every fields
		*
		*/
		for($i=0; $i<self::$metabox_count; $i++){
			foreach(self::$metabox_data['fields'][$i] as $field){
				
		        $old_val = get_post_meta($post_id, $field['name'], true);
		        $new_val = sanitize_text_field(nl2br($_POST[$field['name']]));

		        if(isset($new_val)){
					update_post_meta($post_id, $field['name'], $new_val);
		        }elseif(isset($old_val) && empty($new_val)){
		        	delete_post_meta($post_id, $field['name'], $old_val);
		        }

			}
		}

	}
	
}
new arad_fields_class;
}