<?php

if(!class_exists(arad_form_class)){
class arad_form_class{
	private static $arad_uniq;
	
	public function __construct(){
		self::$arad_uniq = 1;
	}
	
	public function generateForm($post_id, $form_arr){

		self::generateNonce($form_arr['id']);
		
		foreach($form_arr['args'] as $field):
			$field = self::setDefaultValue($field);
			$value = self::escapeString(get_post_meta($post_id, $field['name'], true));
			switch($field['type']){
				case 'text':
					self::createInputText($field, $value);
					break;
				case 'range':
					self::createInputRange($field, $value);
					break;
				case 'images':
					self::createInputImages($field, $value);
					break;
				case 'video':
					self::createInputVideo($field, $value);
					break;
				case 'audio':
					self::createInputAudio($field, $value);
					break;
				case 'select':
					self::createInputSelect($field, $value);
					break;
				default:
					self::createInputText($field, $value);
					break;
			}
			self::$arad_uniq++;
		endforeach;
	}
	/**
	* Create input text 
	*
	*/
	private function createInputText($field_info, $value_input){
		echo('
		<div>
			<label for="'.$field_info['name'].'"><strong>'.$field_info['title'].'</strong><label>
			<br />
			<input style="width:100%;" type="text" name="'.$field_info['name'].'" id="'.$field_info['name'].'" value="'.$value_input.'"/>
		</div>
		');
	}	
	/**
	* Create input range 
	*
	*/
	private function createInputRange($field_info, $value_input){
		echo('
		<div>
			<label for="'.$field_info['name'].'"><strong>'.$field_info['title'].'</strong><label>
			<br />
			<table width="100%" border="0px">
				<tr>
					<td width="10%" align="center">
						<span id="val_'.$field_info['name'].strval(self::$arad_uniq).'">'.$value_input.'</span>
					</td>
					<td width="90%">
						<input style="width:100%;" type="range" name="'.$field_info['name'].'" id="'.$field_info['name'].'" value="'.$value_input.'" min="'.$field_info['min'].'" max="'.$field_info['max'].'" onchange="document.getElementById(\'val_'.$field_info['name'].strval(self::$arad_uniq).'\').innerHTML =  this.value"/>
					</td>
				</tr>
			</table>
		</div>
		');
	}
	/**
	* Create input images 
	*
	*/
	private function createInputImages($field_info, $value_input){
		$images_show = '';
		$hidden_remove = '';
		$hidden_upload = '';
		if(empty($value_input)){
			$hidden_remove = 'arad_hide';
		}else{
			$exp_val = explode(',',$value_input);
			foreach(array_filter($exp_val) as $image_id):
				$image_data = wp_get_attachment_image_src($image_id, 'full');
				$images_show .= '<div class="arad_thumbnail"><div class="arad_centered"><img src="'.$image_data[0].'" width="100%" /></div></div>';
			endforeach;
			$hidden_upload = 'arad_hide';
		}
		
		echo('
		<div>
			<label for="'.$field_info['name'].'"><strong>'.$field_info['title'].'</strong><label>
			<br />
			<input type="hidden" name="'.$field_info['name'].'" value="'.$value_input.'" />
			<a class="arad_images button-secondary '.$hidden_upload.'" href="javascript:void(0);" data-name="'.$field_info['name'].'">Select Images</a>
			<div class="'.$field_info['name'].'_imgsblock">
				'.$images_show.'
			</div>
			<a href="javascript:void(0);" class="arad_remove_images '.$hidden_remove.'" data-name="'.$field_info['name'].'">Remove Images</a>
		</div>
		');
	}
	/**
	* Create input video 
	*
	*/
	private function createInputVideo($field_info, $value_input){
		$images_show = '';
		$hidden_remove = '';
		$hidden_upload = '';
		$video_name = '';
		if(empty($value_input)){
			$hidden_remove = 'arad_hide';
		}else{
			$hidden_upload = 'arad_hide';
			$video_name =  basename(get_attached_file($value_input));
		}
		
		echo('
		<div>
			<label for="'.$field_info['name'].'"><strong>'.$field_info['title'].'</strong><label>
			<br />
			<input type="hidden" name="'.$field_info['name'].'" value="'.$value_input.'" />
			<a class="arad_video button-secondary '.$hidden_upload.'" href="javascript:void(0);" data-name="'.$field_info['name'].'">Select Video</a>
			<div class="'.$field_info['name'].'_infvid '.$hidden_remove.'">
				<i class="icon-play-circle"></i> '.$video_name.'
			</div>
			<a href="javascript:void(0);" class="arad_remove_video '.$hidden_remove.'" data-name="'.$field_info['name'].'">Remove Video</a>
		</div>
		');
	}
	/**
	* Create input audio 
	*
	*/
	private function createInputAudio($field_info, $value_input){
		$images_show = '';
		$hidden_remove = '';
		$hidden_upload = '';
		$audio_name = '';
		if(empty($value_input)){
			$hidden_remove = 'arad_hide';
		}else{
			$hidden_upload = 'arad_hide';
			$audio_name =  basename(get_attached_file($value_input));
		}
		
		echo('
		<div>
			<label for="'.$field_info['name'].'"><strong>'.$field_info['title'].'</strong><label>
			<br />
			<input type="hidden" name="'.$field_info['name'].'" value="'.$value_input.'" />
			<a class="arad_audio button-secondary '.$hidden_upload.'" href="javascript:void(0);" data-name="'.$field_info['name'].'">Select Audio</a>
			<div class="'.$field_info['name'].'_infaudio '.$hidden_remove.'">
				<i class="icon-play-circle"></i> '.$audio_name.'
			</div>
			<a href="javascript:void(0);" class="arad_remove_audio '.$hidden_remove.'" data-name="'.$field_info['name'].'">Remove Audio</a>
		</div>
		');
	}
	/**
	* Create input select 
	*
	*/
	private function createInputSelect($field_info, $value_input){
		$options = '';
		$selected = '';
		foreach($field_info['options'] as $value => $caption):
			if($value === $value_input){
				$selected = 'selected="selected"';
			}else{
				$selected = '';
			}
			$options .= '<option value="'.$value.'" '.$selected.'>'.$caption.'</option>';
		endforeach;
		
		echo('
		<div>
			<label for="'.$field_info['name'].'"><strong>'.$field_info['title'].'</strong><label>
			<br />
			<select style="width:100%;" name="'.$field_info['name'].'" id="'.$field_info['name'].'"/>
				'.$options.'
			</select>
		</div>
		');
	}	

	private function setDefaultValue($field_info){
		$return = $field_info;
		
		if(!isset($return['name'])){
			$return['name'] = '';
		}
		if(!isset($return['type'])){
			$return['type'] = 'text';
		}
		if(!isset($return['title'])){
			$return['title'] = $return['name'];
		}
		if(!isset($return['min'])){
			$return['min'] = '0';
		}
		if(!isset($return['max'])){
			$return['max'] = '10';
		}
		if(!isset($return['options'])){
			$return['options'] = array();
		}
		return $return;
	}
	private function escapeString($text){
		return stripslashes(htmlspecialchars(($text), ENT_QUOTES));
	}
	private function generateNonce($name){
		$field_name = 'arad_meta_nonce'.$name;
		echo('<input type="hidden" name="'.$field_name.'" value="'. wp_create_nonce(basename(__FILE__).$name). '" />');
	}
	public function validateNonce($name){
		$field_name = 'arad_meta_nonce'.$name;
		if(wp_verify_nonce($_POST[$field_name], basename(__FILE__).$name)){
			return true;
		}else{
			return false;
		}
	}
}
new arad_form_class;
}