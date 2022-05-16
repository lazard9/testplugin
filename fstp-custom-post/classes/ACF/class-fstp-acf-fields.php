<?php

namespace FSTP\Classes\ACF;

class FSTP_ACF_Fields
{
	public function register_fields() {
		add_action('acf/init', array( $this, 'my_acf_add_local_field_groups' ) );
	}

	/*
	 * Register fields via PHP
	 * @source {https://www.advancedcustomfields.com/resources/register-fields-via-php/}
	 */
	function my_acf_add_local_field_groups() {
	acf_add_local_field_group(array (
		'key' => 'group_1',
		'title' => 'My Group',
		'fields' => array (
			array (
				'key' => 'field_1',
				'label' => 'Sub Title',
				'name' => 'sub_title',
				'type' => 'text',
				'prefix' => '',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
				'readonly' => 0,
				'disabled' => 0,
			),
			array (
				'key' => 'field_2',
				'label' => 'Image',
				'name' => 'image',
				'type' => 'image',
				'prefix' => '',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				
				/* (string) Specify the type of value returned by get_field(). Defaults to 'array'.
				Choices of 'array' (Image Array), 'url' (Image URL) or 'id' (Image ID) */
				'return_format' => 'array',
				
				/* (string) Specify the image size shown when editing. Defaults to 'thumbnail'. */
				'preview_size' => 'thumbnail',
				
				/* (string) Restrict the image library. Defaults to 'all'.
				Choices of 'all' (All Images) or 'uploadedTo' (Uploaded to post) */
				'library' => 'all',
				
				/* (int) Specify the minimum width in px required when uploading. Defaults to 0 */
				'min_width' => 0,
				
				/* (int) Specify the minimum height in px required when uploading. Defaults to 0 */
				'min_height' => 0,
				
				/* (int) Specify the minimum filesize in MB required when uploading. Defaults to 0 
				The unit may also be included. eg. '256KB' */
				'min_size' => 0,
				
				/* (int) Specify the maximum width in px allowed when uploading. Defaults to 0 */
				'max_width' => 0,
				
				/* (int) Specify the maximum height in px allowed when uploading. Defaults to 0 */
				'max_height' => 0,
				
				/* (int) Specify the maximum filesize in MB in px allowed when uploading. Defaults to 0
				The unit may also be included. eg. '256KB' */
				'max_size' => 0,
				
				/* (string) Comma separated list of file type extensions allowed when uploading. Defaults to '' */
				'mime_types' => '',
			),
			array (
				'key' => 'field_3',
				'label' => 'Gallery',
				'name' => 'gallery',
				'type' => 'gallery',
				'prefix' => '',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array (
					'width' => '',
					'class' => '',
					'id' => '',
				),
				
				/* (int) Specify the minimum attachments required to be selected. Defaults to 0 */
				'min' => 1,
				
				/* (int) Specify the maximum attachments allowed to be selected. Defaults to 0 */
				'max' => 12,
				
				/* (string) Specify the image size shown when editing. Defaults to 'thumbnail'. */
				'preview_size' => 'thumbnail',
				
				/* (string) Restrict the image library. Defaults to 'all'.
				Choices of 'all' (All Images) or 'uploadedTo' (Uploaded to post) */
				'library' => 'all',
				
				/* (int) Specify the minimum width in px required when uploading. Defaults to 0 */
				'min_width' => 0,
				
				/* (int) Specify the minimum height in px required when uploading. Defaults to 0 */
				'min_height' => 0,
				
				/* (int) Specify the minimum filesize in MB required when uploading. Defaults to 0 
				The unit may also be included. eg. '256KB' */
				'min_size' => 0,
				
				/* (int) Specify the maximum width in px allowed when uploading. Defaults to 0 */
				'max_width' => 0,
				
				/* (int) Specify the maximum height in px allowed when uploading. Defaults to 0 */
				'max_height' => 0,
				
				/* (int) Specify the maximum filesize in MB in px allowed when uploading. Defaults to 0
				The unit may also be included. eg. '256KB' */
				'max_size' => 0,
				
				/* (string) Comma separated list of file type extensions allowed when uploading. Defaults to '' */
				'mime_types' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'estates',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
	));
	}

} 