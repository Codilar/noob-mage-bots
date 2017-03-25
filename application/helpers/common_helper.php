<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* All page helper functions */

/**
 * ######### LOAD SITE MENU #############
 */

if(!function_exists('permission_list')){
	/**
	 * Load list of permitted features
	 * @return bool
     */
	function permission_list($permissionId){
		$CI =& get_instance();
		$CI->load->model('admins_model');
		$get_permission = $CI->admins_model->get_permission_list_by_user_group($permissionId);
		if ($get_permission) {
			return $get_permission;
		}
		else {
			return FALSE;
		}
	}
}

if(!function_exists('is_permission_granted')){
	/**
	 * @param $controllerName
	 * @param $permissionList
	 * @return null
     */
	function is_permission_granted($controllerName, $permissionList){
		foreach ($permissionList as $key => $val) {
			if ($val['feature_controller'] === $controllerName) {
				return $val['feature_id'];
			}
		}
		return null;
	}
}

if(!function_exists('connect_to_remote_server')){

	function connect_to_remote_server($serverId){
		$CI =& get_instance();
		$serverDetails = $CI->admins_model->get_result('server_credentials', array('server_id'=>$serverId));
		$connection = ssh2_connect($serverDetails[0]->server_ip, $serverDetails[0]->server_port);
		ssh2_auth_password($connection, $serverDetails[0]->server_username, $serverDetails[0]->server_password);
		return $connection;
	}
}

if(!function_exists('get_output_result_of_shell')){

	function get_output_result_of_shell($stream){
//		$string = stream_get_contents($stream);
		$errorStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
// Enable blocking for both streams
		stream_set_blocking($errorStream, true);
		stream_set_blocking($stream, true);
// Whichever of the two below commands is listed first will receive its appropriate output.  The second command receives nothing
		$response = '';
		while($buffer = fread($stream, 4096)) {
			$response .= '<br>'.$buffer;
		}
		$response = '';
		while($buffer = fread($stream, 4096)) {
			$response .= '<br>'.$buffer;
		}

// Close the streams
		fclose($errorStream);
		fclose($stream);
		return $response;
	}
}





if(!function_exists('exam_category')){
	/**
	 * Load examinations for menu
	 * @return bool
     */
	function exam_category(){
		$CI =& get_instance();
		$CI->load->model('home_model');
		$get_exam = $CI->home_model->exam_by_category();
		if ($get_exam) {
			return $get_exam;
		}
		else {
			return FALSE;
		}
	}
}

/* End all page helper */

/* Questions page helper functions */

if(!function_exists('current_topic_name')){
	/**
	 * Load topic name by Id
	 * @param $topicId
	 * @return bool
     */
	function current_topic_name($topicId){
		$CI =& get_instance();
		$CI->load->model('questions_model');
		$get_current_topic = $CI->questions_model->current_topic_name_by_id($topicId);
		if ($get_current_topic) {
			return $get_current_topic;
		}
		else {
			return FALSE;
		}
	}
}

if(!function_exists('get_current_subject_id')){
	/**
	 * @param $topicId
	 * @return bool
     */
	function get_current_subject_id($topicId){
		$CI =& get_instance();
		$CI->load->model('questions_model');
		$get_current_subject_id = $CI->questions_model->get_result('topic', array('topic_id'=>$topicId));
		if ($get_current_subject_id) {
			$currentSubjectId = $get_current_subject_id[0]->subject_id;
		} else {
			$currentSubjectId = NULL;
		}
		if ($currentSubjectId != Null) {
			return $currentSubjectId;
		}
		else {
			return FALSE;
		}
	}
}

if(!function_exists('is_current_topic_instruction_present')){
	/**
	 * Check is there any instruction / formula is present for particular topic
	 * @param $topicId
	 * @return bool
     */
	function is_current_topic_instruction_present($topicId){
		$CI =& get_instance();
		$CI->load->model('questions_model');
		$is_current_topic_instruction_present = $CI->questions_model->get_result('instructions', array('topic_id'=>$topicId));
		if ($is_current_topic_instruction_present) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
}


if(!function_exists('get_direction_details')){
	/**
	 * Get direction details for group of questions
	 * @param $directionId
	 * @return bool
     */
	function get_direction_details($directionId){
		$CI =& get_instance();
		$CI->load->model('questions_model');
		$get_direction_details = $CI->questions_model->get_result('directions', array('direction_id'=>$directionId));
		if ($get_direction_details) {
			return $get_direction_details;
		}
		else {
			return FALSE;
		}
	}
}

/* End question page helper functions */