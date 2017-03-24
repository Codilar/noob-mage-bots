<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admins extends CI_Controller {


  public function __construct() { 
    parent::__construct();
    $this -> load -> model('admins_model');
  }

  public function index()
  {
    if($this->session->userdata('admin_data'))
    {
      redirect('admins/admin_dashboard');
    }
    else {
      $this->load->view('admins/login');
    }
  }


  public function login(){
    $this->load->helper('url');
    $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[4]|max_length[12]');
    $this->form_validation->set_rules('password', 'Password', 'required');
    if ($this->form_validation->run() == true){
      $username = $this->input->post('username');
      $password = md5($this->input->post('password'));
      $admins = $this->admins_model->get_row('admins', array('username'=>$username, 'password'=>$password));
      if($admins){
        $check = $this->admins_model->get_admin_details($username);
        if($this->session->userdata('admin_data')) {
          redirect('admins/admin_dashboard');
        }else {
          $message = '<div class="alert alert-danger alert-dismissable">';
          $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
          $message .= '<strong>Error!</strong> Invalid Username or Password!</div>';
          $this -> session -> set_flashdata('response_message', $message);
          $this->load->view('admins/login');
        }
    } else {
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> Invalid Username or Password!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      $this->load->view('admins/login');
    }
          // $data['verification'] = true;
          // $data['message'] = "Login Successful";
          // echo json_encode($data);
    } else {
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> Invalid Username or Password!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      $this->load->view('admins/login');
    }

  }

  public function logout(){
    $this->session->unset_userdata('admin_data');
    redirect('admins','refresh');
  }

  public function isAdminHavePermission($functionName,$featureId){
    $adminDataCollection = $this->session->userdata('admin_data');
    if ($adminDataCollection['permissionId']){
      $permissionList = permission_list($adminDataCollection['permissionId']);
      if ($permissionList){
        $featureIdNew = is_permission_granted($functionName,$permissionList);
        if ($featureId == $featureIdNew) {
          return true;
        }
      }
    }
    return false;
  }

  public function admin_dashboard(){
    if($this->session->userdata('admin_data')){
      $dataTitle['title'] = 'Admin Dashboard';
      $dataActive['page'] = 'admin_dashboard';
//    $data['subject'] = $this->admins_model->get_result('subject');
//    $data['levels'] = $this->admins_model->get_result('question_level');
//    $data['exams'] = $this->admins_model->get_result('exams');
//    $data['years'] = $this->admins_model->get_result('year');
//    $data['questions'] = '';

      $this->load->view('admins/common/header',$dataTitle);
      $this->load->view('admins/common/head',$dataActive);
      $this->load->view('admins/adminDashboard');
//    $this->load->view('admins/sidebar',$data1);
//    $this->load->view('admins/questions_add',$data);
      $this->load->view('admins/common/footer');
    } else {
      redirect('/index.php/admins');
    }
  }
  public function new_server(){
    if($this->session->userdata('admin_data')){
      $functionName = $this->uri->segment(2);
      $featureId = $this->uri->segment(3);
      if ($this->isAdminHavePermission($functionName,$featureId)){
        $dataTitle['title'] = 'Configure New Server';
        $dataActive['page'] = 'new_server';

        $this->load->view('admins/common/header',$dataTitle);
        $this->load->view('admins/common/head',$dataActive);
        $this->load->view('admins/newServer');
        $this->load->view('admins/common/footer');
      } else {
        $this->load->view('admins/noPermission');
      }
    } else {
      redirect('/admins');
    }
  }
  public function update_server(){
    if($this->session->userdata('admin_data')){
      $functionName = $this->uri->segment(2);
      $featureId = $this->uri->segment(3);
      if ($this->isAdminHavePermission($functionName,$featureId)){
      $dataTitle['title'] = 'Configure New Server';
      $dataActive['page'] = 'update_server';

      $this->load->view('admins/common/header',$dataTitle);
      $this->load->view('admins/common/head',$dataActive);
      $this->load->view('admins/updateServer');
      $this->load->view('admins/common/footer');
    } else {
      $this->load->view('admins/noPermission');
    }
    } else {
      redirect('/admins');
    }
  }
  public function install_magento(){
    if($this->session->userdata('admin_data')){
      $functionName = $this->uri->segment(2);
      $featureId = $this->uri->segment(3);
      if ($this->isAdminHavePermission($functionName,$featureId)){
      $dataTitle['title'] = 'Configure New Server';
      $dataActive['page'] = 'install_magento';

      $this->load->view('admins/common/header',$dataTitle);
      $this->load->view('admins/common/head',$dataActive);
      $this->load->view('admins/installMagento');
      $this->load->view('admins/common/footer');
    } else {
      $this->load->view('admins/noPermission');
    }
    } else {
      redirect('/admins');
    }
  }
  public function website_analysis(){
    if($this->session->userdata('admin_data')){
      $functionName = $this->uri->segment(2);
      $featureId = $this->uri->segment(3);
      if ($this->isAdminHavePermission($functionName,$featureId)){
      $dataTitle['title'] = 'Configure New Server';
      $dataActive['page'] = 'website_analysis';

      $this->load->view('admins/common/header',$dataTitle);
      $this->load->view('admins/common/head',$dataActive);
      $this->load->view('admins/websiteAnalysis');
      $this->load->view('admins/common/footer');
    } else {
      $this->load->view('admins/noPermission');
    }
    } else {
      redirect('/admins');
    }
  }








  public function dashboard(){
    if($this->session->userdata('admin_data')){
      
    $this->load->view('admins/admin_header');
    $this->load->view('admins/sidebar');
    $this->load->view('admins/home');
    $this->load->view('admins/admin_footer');
  } else {
    redirect('/index.php/admins');
  }
}
  /*###################
          Admin Side Menu wise page view functions 
          ####################################*/
  /* Function For adding questions 
  */

  public function view_question(){
    if($this->session->userdata('admin_data')){
      $subjectId= $this->input->post('subject_id');
      $topicId= $this->input->post('topics');
      $data1['title'] = 'View questions';
      $data1['page'] = 'view_question';
      $data['subject'] = $this->admins_model->get_result('subject');
      $data['levels'] = $this->admins_model->get_result('question_level');
      $data['exams'] = $this->admins_model->get_result('exams');
      $data['years'] = $this->admins_model->get_result('year');
      $data['questions'] = $this->admins_model->fetch_question($subjectId,$topicId);
      $this->load->view('admins/admin_header');
      $this->load->view('admins/sidebar',$data1);
      $this->load->view('admins/questions/view_question',$data);
      $this->load->view('admins/admin_footer');
    } else {
      redirect('/index.php/admins');
    }
  }

  public function add_direction(){
    if($this->session->userdata('admin_data')){
    $data1['title'] = 'Directions';
    $data1['page'] = 'direction';
    $data['subject'] = $this->admins_model->get_result('subject');
    $data['directions'] = $this->admins_model->fetch_direction();
    if($data['directions']===false){
      $data['directions'] = array();
    }
    $this->load->view('admins/admin_header');
    $this->load->view('admins/sidebar',$data1);
    $this->load->view('admins/direction/add_direction',$data);
    $this->load->view('admins/admin_footer'); 
  } else {
    redirect('/index.php/admins');
  }
  }
  public function add_new_direction(){
    $this->form_validation->set_rules('subject_id', 'Subject Name', 'required');
    $this->form_validation->set_rules('topic_id', 'Topic Name', 'required');
    $this->form_validation->set_rules('direction', 'Direction', 'required');
    if ($this->form_validation->run() == true){
    $subjectID = $this->input->post('subject_id');
    $topicID = $this->input->post('topic_id');
    $direction = $this->input->post('direction');
        $directions = array('topic_id'=>$topicID,'direction'=>$direction,'last_used'=>date('Y-m-d H:i:s'));
        $instruction_id = $this->admins_model->insert('directions',$directions);
        $message = '<div class="alert alert-success alert-dismissable">';
        $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        $message .= '<strong>Success!</strong> Direction successfully added!</div>';
        $this -> session -> set_flashdata('response_message', $message);
        redirect('index.php/admins/add_direction');
      }   
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> Can Not Add direction!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_direction');
  }
  public function edit_direction($directionId){
    if($this->session->userdata('admin_data')){
    $data1['title'] = 'Directions';
    $data1['page'] = 'direction';
    $data['subject'] = $this->admins_model->get_result('subject');
    // $data['levels'] = $this->admins_model->get_result('question_level');
    // $data['exams'] = $this->admins_model->get_result('exams');
    // $data['years'] = $this->admins_model->get_result('year');
    // $data['instruction'] = $this->admins_model->fetch_instruction();
    $data['direction'] = $this->admins_model->getDirectionById($directionId);
    // $data['instructions'] = $this->admins_model->get_row('instructions',array('instruction_id'=>$instructionId));
    // if($data['instructions']===false){
    //   $data['instructions'] = array();
    // }
    $this->load->view('admins/admin_header');
    $this->load->view('admins/sidebar',$data1);
    $this->load->view('admins/direction/edit_direction',$data);
    $this->load->view('admins/admin_footer'); 
  } else {
    redirect('/index.php/admins');
  }
  }
  public function update_direction($directionID){
    $this->form_validation->set_rules('subject_id', 'Subject Name', 'required');
    $this->form_validation->set_rules('topic_id', 'Topic Name', 'required');
    $this->form_validation->set_rules('direction', 'Direction', 'required');
    if ($this->form_validation->run() == true){
    $subjectID = $this->input->post('subject_id');
    $topicID = $this->input->post('topic_id');
    $direction = $this->input->post('direction');
    $update_id = $this->admins_model->update('directions', array('topic_id'=>$topicID, 'direction'=>$direction, 'last_used'=>date('Y-m-d H:i:s')),array('direction_id'=>$directionID));
    if($update_id){
      $message = '<div class="alert alert-success alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Success!</strong> Direction <strong> successfully Updated!</strong></div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_direction');
    }
    }else{
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> <strong>Can Not Update </strong>Direction!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_direction');
    }
  }
  public function delete_direction(){
    $directionId = $this->input->post('directionId');
    if($directionId){
      $this->admins_model->delete('directions',array('direction_id'=>$directionId));
      $message = '<div class="alert alert-success alert-dismissable">';
      $message .='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .='<strong>Success!</strong> Direction Successfully Deleted!</div>';
      $this->session->set_flashdata('response_message', $message);
    } else {
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> Can Not Delete Direction!</div>';
      $this -> session -> set_flashdata('response_message', $message);
    }
  }
  public function get_directions(){
    $topicID = $this->input->post('topic_id');
    $directions = $this->admins_model->getDirectionByTime($topicID);
    // foreach ($directions as $key => $direction) {
    //   echo "<td>".$direction->direction_id."</td><td>".$direction->direction."</td><td>".$direction->last_used."</td>";
    // }
      echo json_encode($directions);
  }
  public function add_topic(){
    if($this->session->userdata('admin_data')){
    $data1['title'] = 'Topics';
    $data1['page'] = 'topic';
    $data['subject'] = $this->admins_model->get_result('subject');
    $data['exams'] = $this->admins_model->get_result('exams');
    $data['exam_topic'] = $this->admins_model->get_topic_exam();
    $this->load->view('admins/admin_header');
    $this->load->view('admins/sidebar',$data1);
    $this->load->view('admins/topic/add_topic',$data);
    $this->load->view('admins/admin_footer');
  } else {
    redirect('/index.php/admins');
  }
}

  public function add_subject(){
    if($this->session->userdata('admin_data')){
    $data1['title'] = 'Subject';
    $data1['page'] = 'subject';
    $data['sub_cat'] = $this->admins_model->get_result('subject_category');
    $data['sub_cat_list'] = $this->admins_model->get_sub_cat();
    $this->load->view('admins/admin_header');
    $this->load->view('admins/sidebar',$data1);
    $this->load->view('admins/subject/add_subject',$data);
    $this->load->view('admins/admin_footer');
    } else {
    redirect('/index.php/admins');
    }
  }
  public function edit_subject($subjectID){
    if($this->session->userdata('admin_data')){
    $data1['title'] = 'Subject';
    $data1['page'] = 'subject';
    $data['sub_cat'] = $this->admins_model->get_result('subject_category');
    $data['sub_category'] = $this->admins_model->get_sub_cat_by_id($subjectID);
    $data['subject'] = $this->admins_model->get_row('subject',array('subject_id'=>$subjectID));
    $this->load->view('admins/admin_header');
    $this->load->view('admins/sidebar',$data1);
    $this->load->view('admins/subject/edit_subject',$data);
    $this->load->view('admins/admin_footer');
    } else {
    redirect('/index.php/admins');
    }
  }
  /*############## Function for Adding New Subject ######### */
    public function add_new_subject(){
      $this->form_validation->set_rules('category', 'Category Name', 'required');
    $this->form_validation->set_rules('subject_name', 'Subject Name', 'trim|required|min_length[3]');
    if ($this->form_validation->run() == true){
    $categoryId = $this->input->post('category');
    $subjectName = $this->input->post('subject_name');
    $this->admins_model->insert('subject', array('subject_name'=>$subjectName,'category_id'=>$categoryId));
      $message = '<div class="alert alert-success alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Success!</strong> New Subject successfully Added!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_subject');
    }
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> Can Not Add New Subject!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_subject');
  }
  /*############## End of Function for Adding New Subject ######### */
  /*############## Function for Adding New Subject ######### */
    public function update_subject($subjectID){
      $this->form_validation->set_rules('category', 'Category Name', 'required');
    $this->form_validation->set_rules('subject_name', 'Subject Name', 'trim|required|min_length[3]');
    if ($this->form_validation->run() == true){
    $categoryId = $this->input->post('category');
    $subjectName = $this->input->post('subject_name');
    $this->admins_model->update('subject', array('subject_name'=>$subjectName,'category_id'=>$categoryId),array('subject_id'=>$subjectID));

      $message = '<div class="alert alert-success alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Success!</strong> Subject Details successfully Updated!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_subject');
    }
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> Can Not Update Subject Details!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_subject');
  }

  public function delete_subject(){
    $id = $this->input->post('id');
    if ($id) {
    $this->admins_model->delete('subject',array('subject_id'=>$id));
    $message = '<div class="alert alert-success alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Success!</strong> Subject Details successfully Deleted!</div>';
      $this -> session -> set_flashdata('response_message', $message);
    }else{
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> Can Not Delete Subject Details!</div>';
      $this -> session -> set_flashdata('response_message', $message);
    }
  }
  /*############## End of Function for Adding New Subject ######### */
  public function add_subject_category(){
    $data1['title'] = 'Subject Category';
    $data1['page'] = 'sub_cat';
    if($this->session->userdata('admin_data')){
    $data['subject_cat'] = $this->admins_model->get_result('subject_category');
    $this->load->view('admins/admin_header');
    $this->load->view('admins/sidebar',$data1);
    $this->load->view('admins/subject/add_subject_category',$data);
    $this->load->view('admins/admin_footer');
    } else {
    redirect('/index.php/admins');
    }
  }
 public function delete_subject_category(){
    $id = $this->input->post('id');
    if ($id) {
    $this->admins_model->delete('subject_category',array('category_id'=>$id));
    $message = '<div class="alert alert-success alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Success!</strong> Subject Category successfully Deleted!</div>';
      $this -> session -> set_flashdata('response_message', $message);
    }else{
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> Can Not Delete Subject Category!</div>';
      $this -> session -> set_flashdata('response_message', $message);
    }
 }
  public function add_exam($examID=''){
    if($this->session->userdata('admin_data')){
      if($examID){
    $data1['title'] = 'Exams';
    $data1['page'] = 'exam';
    $data['exam_cat'] = $this->admins_model->get_result('exam_category');
    $data['exam_cat_list'] = $this->admins_model->get_exam_cat_by_id($examID);
    $this->load->view('admins/admin_header');
    $this->load->view('admins/sidebar',$data1);
    $this->load->view('admins/exam/edit_exam',$data);
    $this->load->view('admins/admin_footer');
  }else{
    $data1['title'] = 'Exams';
    $data1['page'] = 'exam';
    $data['exam_cat'] = $this->admins_model->get_result('exam_category');
    $data['exam_cat_list'] = $this->admins_model->get_exam_cat();
    $this->load->view('admins/admin_header');
    $this->load->view('admins/sidebar',$data1);
    $this->load->view('admins/exam/add_exam',$data);
    $this->load->view('admins/admin_footer');
  }
    } else {
    redirect('/index.php/admins');
    }
  }
  
  public function add_exam_category(){
    if($this->session->userdata('admin_data')){
    $data1['title'] = 'Exam Category';
    $data1['page'] = 'exam_cat';
    $data['exam_cat'] = $this->admins_model->get_result('exam_category');
    $this->load->view('admins/admin_header');
    $this->load->view('admins/sidebar',$data1);
    $this->load->view('admins/exam/add_exam_category',$data);
    $this->load->view('admins/admin_footer');
    } else {
    redirect('/index.php/admins');
    }
  }
  public function update_exam_category(){
    $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|min_length[3]');
    if ($this->form_validation->run() == true){
      $id = $this->input->post('id');
    $category = $this->input->post('category_name');
    $this->admins_model->update('exam_category', array('category_name'=>$category),array('category_id'=>$id));
      $message = '<div class="alert alert-success alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Success!</strong> New Exam Category <strong> successfully Updated!</strong></div>';
      $this -> session -> set_flashdata('response_message', $message);
    }else{
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> <strong>Can Not Update </strong>Exam Category!</div>';
      $this -> session -> set_flashdata('response_message', $message);
    }
  }
  public function delete_exam_category(){
    $id = $this->input->post('id');
    if ($id) {
    $this->admins_model->delete('exam_category',array('category_id'=>$id));
    $message = '<div class="alert alert-success alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Success!</strong> Exam Category successfully Deleted!</div>';
      $this -> session -> set_flashdata('response_message', $message);
    }else{
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> Can Not Delete Exam Category!</div>';
      $this -> session -> set_flashdata('response_message', $message);
    }
  }
      /*############## Function for Adding New Exam Category ######### */
   public function add_new_question(){
    $AllOpt = array("A","B","C","D","E","F","G");
    $this->form_validation->set_rules('subject_id', 'Subject Name', 'required');
    $this->form_validation->set_rules('topics', 'Topic Name', 'required');
    $this->form_validation->set_rules('question', 'Question', 'required');
    // $this->form_validation->set_rules('option', 'Option', 'required');
    $this->form_validation->set_rules('optradio', 'Mark an answer', 'required');
    $this->form_validation->set_rules('answer', 'Answer', 'required');
    $this->form_validation->set_rules('level', 'Level', 'required');

    if ($this->form_validation->run() == true){
    $subjectID = $this->input->post('subject_id');
    $topicID = $this->input->post('topics');
    $question = $this->input->post('question');

      // Checking Question for duplicate
      if ($question) {
        $matchPercentageArray = array();
        $qi = 0;
        $arr1 = explode(' ', $question);
        $oldQuestions = $this->admins_model->fetch_question($subjectID,$topicID);
        foreach ($oldQuestions as $que){
//          print_r($que);
          $arr2 = explode(' ', $que->question);

          similar_text($question, $que->question, $stringMatchPercentageF);
          similar_text($que->question, $question, $stringMatchPercentageR);

          $aintF = array_intersect($arr2, $arr1);
          $aintR = array_intersect($arr1, $arr2);
          $arrayMatchPercentageF = (count($aintF) * 100 / count($arr2));
          $arrayMatchPercentageR = (count($aintR) * 100 / count($arr1));
          if (($stringMatchPercentageF > 90 && $stringMatchPercentageR > 90) || ($arrayMatchPercentageF > 90 && $arrayMatchPercentageR > 90)) {
            $matchPercentageArray[$qi]['questionId'] = $que->qid;
            $matchPercentageArray[$qi]['string_match_percentage_forward'] = $stringMatchPercentageF;
            $matchPercentageArray[$qi]['string_match_percentage_backward'] = $stringMatchPercentageR;
            $matchPercentageArray[$qi]['array_match_percentage_forward'] = $arrayMatchPercentageF;
            $matchPercentageArray[$qi]['array_match_percentage_backward'] = $arrayMatchPercentageR;
            $qi = $qi +1;
          }
        }
      }
//      echo "<pre>";
//      echo "<br><br><br><br><br>";
//      echo "Hello";
//      print_r($matchPercentageArray);
//      die();
    $directionID = $this->input->post('groupOpt');
    $options = $this->input->post('option');
    // $optionB = $this->input->post('option_b');
    // $optionC = $this->input->post('option_c');
    // $optionD = $this->input->post('option_d');
    // $optionE = $this->input->post('option_e');
    // $optionF = $this->input->post('option_f');
    $answerOption = $this->input->post('optradio');
    $answer = $this->input->post('answer');
    $level = $this->input->post('level');
    $exams1 = $this->input->post('exam_id1');
    $years1 = $this->input->post('year1');
    $exams2 = $this->input->post('exam_id2');
    $years2 = $this->input->post('year2');
    $exams3 = $this->input->post('exam_id3');
    $years3 = $this->input->post('year3');
    $exams4 = $this->input->post('exam_id4');
    $years4 = $this->input->post('year4');
    $exams5 = $this->input->post('exam_id5');
    $years5 = $this->input->post('year5');
    $exams6 = $this->input->post('exam_id6');
    $years6 = $this->input->post('year6'); 
    $questions = array('question'=>$question,'subject_id'=>$subjectID,'topic_id'=>$topicID,'level_id'=>$level);
    $question_id = $this->admins_model->insert('questions',$questions);

      // Logging Match case of questions;
      foreach ($matchPercentageArray as $match){
        log_message('error', "==================================================== Important ===================================================== \r\n
        Possible Duplicate Question: \r\nSubject id:".$subjectID." \r\nTopic id:".$topicID." \r\nQuestion Id: ".$question_id."\r\nWith Question id:".$match['questionId']."
        \r\n \r\n Where Match Percentage are: \r\n string_match_percentage_forward".$match['string_match_percentage_forward']."\r\n string_match_percentage_backward".$match['string_match_percentage_backward']."
        \r\n array_match_percentage_forward".$match['array_match_percentage_forward']."\r\n array_match_percentage_backward".$match['array_match_percentage_backward']."
        \r\n ============================================================= End Important =========================================================");
      }
    if(sizeof($options) > 0){
    foreach ($options as $key => $option) {
      if ($option) {
        $option_id = $this->admins_model->insert('question_option',array('question_id'=>$question_id,'question_option'=>$option));
      if (trim($answerOption) == $key) {
        $optionValueForAnswer = $AllOpt[$key];
        $optionIdForAnswer = $option_id;
      }
      }
    }
  }
      $answer_id = $this->admins_model->insert('question_answer',array('question_id'=>$question_id,'answer'=>$optionValueForAnswer, 'option_id'=>$optionIdForAnswer,'detail_answer'=>$answer));
      if($directionID){
        $this->admins_model->update('questions',array('direction_id'=>$directionID), array('qid'=>$question_id));
        $this->admins_model->update('directions', array('last_used'=>date('Y-m-d H:i:s')), array('direction_id'=>$directionID));
      }

      if(sizeof($years1) > 0){
    foreach ($years1 as $key => $year1) {
      $exam_id1 = $this->admins_model->insert('year_question_map',array('year'=>$year1,'question_id'=>$question_id,'exam_id'=>$exams1));
    }
  }
    if(sizeof($years2) > 0){
    foreach ($years2 as $key => $year2) {
      $exam_id2 = $this->admins_model->insert('year_question_map',array('year'=>$year2,'question_id'=>$question_id,'exam_id'=>$exams2));
    }
  }
  if(sizeof($years3)  > 0){
    foreach ($years3 as $key => $year3) {
      $exam_id3 = $this->admins_model->insert('year_question_map',array('year'=>$year3,'question_id'=>$question_id,'exam_id'=>$exams3));
    }
  }
  if(sizeof($years4) > 0){
    foreach ($years4 as $key => $year4) {
      $exam_id4 = $this->admins_model->insert('year_question_map',array('year'=>$year4,'question_id'=>$question_id,'exam_id'=>$exams4));
    }
  }
  if(sizeof($years5) > 0){
    foreach ($years5 as $key => $year5) {
      $exam_id5 = $this->admins_model->insert('year_question_map',array('year'=>$year5,'question_id'=>$question_id,'exam_id'=>$exams5));
    }
  }
  if(sizeof($years6) > 0){
    foreach ($years6 as $key => $year6) {
      $exam_id6 = $this->admins_model->insert('year_question_map',array('year'=>$year6,'question_id'=>$question_id,'exam_id'=>$exams6));
    }
  }
      $message = '<div class="alert alert-success alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Success!</strong> New Question successfully added!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/admin_dashboard');
    }
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> New Question has not added!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/admin_dashboard');
  }
  public function delete_question($questionID){
    if($questionID){
    $this->admins_model->delete('questions',array('qid'=>$questionID));
    $this->admins_model->delete('question_option',array('question_id'=>$questionID));
    $this->admins_model->delete('question_answer',array('question_id'=>$questionID));
    $this->admins_model->delete('year_question_map',array('question_id'=>$questionID));
    $message = '<div class="alert alert-success alert-dismissable">';
    $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
    $message .= '<strong>Success!</strong> Question Deleted successfully!</div>';
    $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/admin_dashboard');
    }
    $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> Can Not Delete the Question!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/admin_dashboard');
  }
  public function edit_question($questionID){
    if($this->session->userdata('admin_data')){
    $data1['title'] = 'Questions';
    $data1['page'] = 'question';
    $data['subject'] = $this->admins_model->get_result('subject');
    $data['topics'] = $this->admins_model->get_result('topic');
    $data['levels'] = $this->admins_model->get_result('question_level');
    $data['exams'] = $this->admins_model->get_result('exams');
    $data['years'] = $this->admins_model->get_result('year');
    $data['questions'] = $this->admins_model->fetch_question_details($questionID);
    $this->load->view('admins/admin_header');
    $this->load->view('admins/sidebar',$data1);
    $this->load->view('admins/edit_question',$data);
    $this->load->view('admins/admin_footer'); 
  } else {
    redirect('/index.php/admins');
  }
  }

  public function update_question($questionID){
    $AllOpt = array("A","B","C","D","E","F","G");
    // $this->form_validation->set_rules('subject_id', 'Subject Name', 'required');
    // $this->form_validation->set_rules('topics', 'Topic Name', 'required');
    // $this->form_validation->set_rules('question', 'Question', 'required');
    // // $this->form_validation->set_rules('option', 'Option', 'required');
    // $this->form_validation->set_rules('optradio', 'Mark an answer', 'required');
    // $this->form_validation->set_rules('answer', 'Answer', 'required');
    // $this->form_validation->set_rules('level', 'Level', 'required');

    if ($questionID){
    $subjectID = $this->input->post('subject_id');
    $topicID = $this->input->post('topics');
    $question = $this->input->post('question');
    $options = $this->input->post('option');
    $answerOption = $this->input->post('optradio');
    $answer = $this->input->post('answer');
    $level = $this->input->post('level');
//    $exams = $this->input->post('exam_id');
//    $years = $this->input->post('year');
    $exams1 = $this->input->post('exam_id1');
    $years1 = $this->input->post('year1');
    $exams2 = $this->input->post('exam_id2');
    $years2 = $this->input->post('year2');
    $exams3 = $this->input->post('exam_id3');
    $years3 = $this->input->post('year3');
    $exams4 = $this->input->post('exam_id4');
    $years4 = $this->input->post('year4');
    $exams5 = $this->input->post('exam_id5');
    $years5 = $this->input->post('year5');
    $exams6 = $this->input->post('exam_id6');
    $years6 = $this->input->post('year6');
    $questions = array('question'=>$question,'subject_id'=>$subjectID,'topic_id'=>$topicID,'level_id'=>$level);
    // print_r($questions);
    // die();
    $question_id = $this->admins_model->update('questions',$questions,array('qid'=>$questionID));
    if(sizeof($options) > 0){
      $deleteId = $this->admins_model->delete('question_option',array('question_id'=>$questionID));
    foreach ($options as $key => $option) {
      if ($option) {
        $option_id = $this->admins_model->insert('question_option',array('question_option'=>$option,'question_id'=>$questionID));
      if (trim($answerOption) == $key) {
        $optionValueForAnswer = $AllOpt[$key];
        $optionIdForAnswer = $option_id;
      }
      }
    }
  }
    $answer_id = $this->admins_model->update('question_answer',array('answer'=>$optionValueForAnswer, 'option_id'=>$optionIdForAnswer,'detail_answer'=>$answer),array('question_id'=>$questionID));
    $this->admins_model->delete('year_question_map',array('question_id'=>$questionID));
//    if(sizeof($years) > 0){
//    foreach ($years as $k => $year) {
//      $exam_id = $this->admins_model->insert('year_question_map',array('year'=>$year,'exam_id'=>$exams[$k],'question_id'=>$questionID));
//    }
//  }
    if(sizeof($years1) > 0){
    foreach ($years1 as $key => $year1) {
      $exam_id1 = $this->admins_model->insert('year_question_map',array('year'=>$year1,'exam_id'=>$exams1,'question_id'=>$questionID));
    }
  }
    if(sizeof($years2) > 0){
    foreach ($years2 as $key => $year2) {
      $exam_id2 = $this->admins_model->insert('year_question_map',array('year'=>$year2,'exam_id'=>$exams2,'question_id'=>$questionID));
    }
  }
  if(sizeof($years3) > 0){
    foreach ($years3 as $key => $year3) {
      $exam_id3 = $this->admins_model->insert('year_question_map',array('year'=>$year3,'exam_id'=>$exams3,'question_id'=>$questionID));
    }
  }
  if(sizeof($years4) > 0){
    foreach ($years4 as $key => $year4) {
      $exam_id4 = $this->admins_model->insert('year_question_map',array('year'=>$year4,'exam_id'=>$exams4,'question_id'=>$questionID));
    }
  }
  if(sizeof($years5) > 0){
    foreach ($years5 as $key => $year5) {
      $exam_id5 = $this->admins_model->insert('year_question_map',array('year'=>$year5,'exam_id'=>$exams5,'question_id'=>$questionID));
    }
  }
  if(sizeof($years6) > 0){
    foreach ($years6 as $key => $year6) {
      $exam_id6 = $this->admins_model->insert('year_question_map',array('year'=>$year6,'exam_id'=>$exams6,'question_id'=>$questionID));
    }
  }
      $message = '<div class="alert alert-success alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Success!</strong> Question successfully Updated!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/admin_dashboard');
    }
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> failed to Update the Question!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/admin_dashboard');
  }
  
    /*############## Function for Adding New Exam Category ######### */
   public function add_new_exam_category(){
    $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|min_length[3]');
    if ($this->form_validation->run() == true){
    $category = $this->input->post('category_name');
    $this->admins_model->insert('exam_category', array('category_name'=>$category));
      $message = '<div class="alert alert-success alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Success!</strong> New Exam Category successfully added!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_exam_category');
    }
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> New Exam Category has not added!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_exam_category');
  }
   /*############## End of Function for Adding New Exam Category ######### */

   /*############## Function for Adding New Subject Topic ######### */
    public function add_new_topic(){    
    $this->form_validation->set_rules('topic_name', 'Topic Name', 'trim|required|min_length[3]');
    $this->form_validation->set_rules('subject_name', 'Subject Name', 'required');
    $this->form_validation->set_rules('topic_position', 'Topic Position', 'required');
    if ($this->form_validation->run() == true){
    $topicName = $this->input->post('topic_name');
    $subjectId = $this->input->post('subject_name');
    $examId = $this->input->post('exam_id');
    $topicPosition = $this->input->post('topic_position');
    $insert_id = $this->admins_model->insert('topic', array('topic_name'=>$topicName,'subject_id'=>$subjectId,'topic_position'=>$topicPosition));
    if ($insert_id) {
      if(sizeof($examId) > 0){
        foreach ($examId as $exam_id) {
      $this->admins_model->insert('exam_topic_map',array('exam_id'=>$exam_id,'topic_id'=>$insert_id));
        }
      }
      $message = '<div class="alert alert-success alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Success!</strong> New Topic successfully Inserted!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_topic');
    }
      $message = '<div class="alert alert-success alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Success!</strong> New Topic successfully Added!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_topic');
    }
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> Can Not Add New Topic!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_topic');
  }
  public function edit_topic($topicID){
    if($this->session->userdata('admin_data')){
    $data1['title'] = 'Topics';
    $data1['page'] = 'topic';
    $data['subject'] = $this->admins_model->get_result('subject');
    $data['levels'] = $this->admins_model->get_result('question_level');
    $data['exams'] = $this->admins_model->get_result('exams');
    $data['years'] = $this->admins_model->get_result('year');
    $data['exam_topic'] = $this->admins_model->get_topic_by_id($topicID);
    $this->load->view('admins/admin_header');
    $this->load->view('admins/sidebar',$data1);
    $this->load->view('admins/topic/edit_topic',$data);
    $this->load->view('admins/admin_footer'); 
  } else {
    redirect('/index.php/admins');
  }
  }
  public function update_topic($topicID){
    $this->form_validation->set_rules('topic_name', 'Topic Name', 'trim|required|min_length[3]');
    $this->form_validation->set_rules('subject_name', 'Subject Name', 'required');
    $this->form_validation->set_rules('topic_position', 'Topic Position', 'required');
    if ($this->form_validation->run() == true){
    $topicName = $this->input->post('topic_name');
    $subjectId = $this->input->post('subject_name');
    $examId = $this->input->post('exam_id');
    // print_r($examId);
    // die();
    $topicPosition = $this->input->post('topic_position');
    $update_id = $this->admins_model->update('topic', array('topic_name'=>$topicName,'subject_id'=>$subjectId,'topic_position'=>$topicPosition),array('topic_id'=>$topicID));
    if ($update_id) {
      $this->admins_model->delete('exam_topic_map',array('topic_id'=>$topicID));
      if(sizeof($examId) > 0){
        foreach ($examId as $exam_id) {
      $this->admins_model->insert('exam_topic_map',array('exam_id'=>$exam_id,'topic_id'=>$topicID));
        }
      }
      $message = '<div class="alert alert-success alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Success!</strong>Topic Details successfully Updated!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_topic');
    }
      $message = '<div class="alert alert-success alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Success!</strong> Topic Details successfully Updated!!!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_topic');
    }
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> Can Not Update Topic Details!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_topic');
  }
  public function delete_topic(){
    $id = $this->input->post('id');
    if ($id) {
    $this->admins_model->delete('topic',array('topic_id'=>$id));
    $this->admins_model->delete('exam_topic_map',array('topic_id'=>$id));
    $message = '<div class="alert alert-success alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Success!</strong> Topic Details successfully Deleted!</div>';
      $this -> session -> set_flashdata('response_message', $message);
    }else{
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> Can Not Delete Topic Details!</div>';
      $this -> session -> set_flashdata('response_message', $message);
    } 
  }
  /*############## End of Function for Adding New Subject Topic ######### */

   /*############## Function for Adding New Subject ######### */
    public function add_new_exam(){
    $this->form_validation->set_rules('category', 'Category Name', 'required');
    $this->form_validation->set_rules('exam_full_name', 'Subject Full Name', 'required');
    $this->form_validation->set_rules('exam_short_name', 'Subject Short Name', 'required');
    if ($this->form_validation->run() == true){
    $categoryId = $this->input->post('category');
    $examFname = $this->input->post('exam_full_name');
    $examSname = $this->input->post('exam_short_name');
    $this->admins_model->insert('exams', array('exam_name'=>$examSname,'exam_full_name'=>$examFname,'category_id'=>$categoryId));
      $message = '<div class="alert alert-success alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Success!</strong> New Exam successfully Added!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_exam');
    }
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> Can Not Add New Exam!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_exam');
  }
  public function update_exam(){
    $this->form_validation->set_rules('category', 'Category Name', 'required');
    $this->form_validation->set_rules('exam_full_name', 'Subject Full Name', 'required');
    $this->form_validation->set_rules('exam_short_name', 'Subject Short Name', 'required');
    if ($this->form_validation->run() == true){
      $examId = $this->input->post('exam_id');
    $categoryId = $this->input->post('category');
    $examFname = $this->input->post('exam_full_name');
    $examSname = $this->input->post('exam_short_name');
    $this->admins_model->update('exams', array('exam_name'=>$examSname,'exam_full_name'=>$examFname,'category_id'=>$categoryId),array('exam_id'=>$examId));
      $message = '<div class="alert alert-success alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Success!</strong> Exam Details successfully <strong>Updated!</strong>!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_exam');
    }else{
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> Can Not Add Update Exam Details!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_exam');
    }
  }
  public function delete_exam(){
    $id = $this->input->post('id');
    if ($id) {
    $this->admins_model->delete('exams',array('exam_id'=>$id));
    $message = '<div class="alert alert-success alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Success!</strong> Exam Details successfully Deleted!</div>';
      $this -> session -> set_flashdata('response_message', $message);
    }else{
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> Can Not Delete Exam Details!</div>';
      $this -> session -> set_flashdata('response_message', $message);
    } 
  }
  /*############## End of Function Exam ######### */

   /*############## Function for Adding New Subject Category ######### */
    public function add_new_subject_category(){
    $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|min_length[3]');
    if ($this->form_validation->run() == true){
    $category = $this->input->post('category_name');
    $this->admins_model->insert('subject_category', array('category_name'=>$category));
      $message = '<div class="alert alert-success alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Success!</strong> New Subject Category successfully added!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_subject_category');
    }
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> Can Not Add New Subject Category!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_subject_category');
  }

  public function update_subject_category(){
    $this->form_validation->set_rules('category_name', 'Category Name', 'trim|required|min_length[3]');
    if ($this->form_validation->run() == true){
      $id = $this->input->post('id');
    $category = $this->input->post('category_name');
    $this->admins_model->update('subject_category', array('category_name'=>$category),array('category_id'=>$id));
      $message = '<div class="alert alert-success alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Success!</strong> New Subject Category <strong> successfully Updated!</strong></div>';
      $this -> session -> set_flashdata('response_message', $message);
    }else{
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> <strong>Can Not Update </strong>Subject Category!</div>';
      $this -> session -> set_flashdata('response_message', $message);
    }
  }
  /*############## End of Function for Updating New Subject Category ######### */
    /*###################
         End Of Admin Side Menu wise page view functions 
          ####################################*/

  public function test(){
    $this->load->view('admins/admin_header');
    $this->load->view('admins/sidebar');
    $this->load->view('admins/add_topic');
    $this->load->view('admins/admin_footer');
  }


  public function get_topic(){

    // header('Content-Type: application/x-json; charset=utf-8');
    $subjectID = $this->input->post('id');
    $topics = $this->admins_model->get_result('topic',array('subject_id'=>$subjectID));
    foreach ($topics as $key => $topic) {
      echo "<option value=".$topic->topic_id.">".$topic->topic_name."</option>";
      
    }
  }

  /*############### Formulas ################# */

  public function add_instruction(){
    if($this->session->userdata('admin_data')){
    $data1['title'] = 'Instructions';
    $data1['page'] = 'instruction';
    $data['subject'] = $this->admins_model->get_result('subject');
    $data['levels'] = $this->admins_model->get_result('question_level');
    $data['exams'] = $this->admins_model->get_result('exams');
    $data['years'] = $this->admins_model->get_result('year');
    $data['instructions'] = $this->admins_model->fetch_instruction();
    if($data['instructions']===false){
      $data['instructions'] = array();
    }
    $this->load->view('admins/admin_header');
    $this->load->view('admins/sidebar',$data1);
    $this->load->view('admins/instruction/add_instruction',$data);
    $this->load->view('admins/admin_footer'); 
  } else {
    redirect('/index.php/admins');
  }
  }
  public function delete_instruction(){
    $instructionId = $this->input->post('instructionId');
    if($instructionId){
      $this->admins_model->delete('instructions',array('instruction_id'=>$instructionId));
      $message = '<div class="alert alert-success alert-dismissable">';
      $message .='<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .='<strong>Success!</strong> instruction Successfully Deleted!</div>';
      $this->session->set_flashdata('response_message', $message);
    } else {
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> Can Not Delete instruction!</div>';
      $this -> session -> set_flashdata('response_message', $message);
    }
  }
  public function add_new_instruction(){
    $this->form_validation->set_rules('subject_id', 'Subject Name', 'required');
    $this->form_validation->set_rules('topic_id', 'Topic Name', 'required');
    $this->form_validation->set_rules('instruction', 'Instruction', 'required');
    if ($this->form_validation->run() == true){
    $subjectID = $this->input->post('subject_id');
    $topicID = $this->input->post('topic_id');
    $instruction = $this->input->post('instruction');
    $checkTopic = $this->admins_model->get_row('instructions', array('topic_id'=>$topicID));
      if ($checkTopic > 0) {
        $instructions = array('subject_id'=>$subjectID,'instruction'=>$instruction);
        $instruction_id = $this->admins_model->update('instructions',$instructions, array('topic_id'=>$topicID));
        $message = '<div class="alert alert-success alert-dismissable">';
        $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        $message .= '<strong>Success!</strong> New Instruction successfully Updated!</div>';
        $this -> session -> set_flashdata('response_message', $message);
        redirect('index.php/admins/add_instruction');
      } else {
        $instructions = array('subject_id'=>$subjectID,'topic_id'=>$topicID,'instruction'=>$instruction);
        $instruction_id = $this->admins_model->insert('instructions',$instructions);
        $message = '<div class="alert alert-success alert-dismissable">';
        $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
        $message .= '<strong>Success!</strong> New Instruction successfully added!</div>';
        $this -> session -> set_flashdata('response_message', $message);
        redirect('index.php/admins/add_instruction');
      }   
    }
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> Can Not Add New Instruction!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_instruction');
  }
  public function edit_instruction($instructionId){
    if($this->session->userdata('admin_data')){
    $data1['title'] = 'Instructions';
    $data1['page'] = 'instruction';
    $data['subject'] = $this->admins_model->get_result('subject');
    $data['topic_instruction'] = $this->admins_model->getInstructionByTopicId($instructionId);
    $this->load->view('admins/admin_header');
    $this->load->view('admins/sidebar',$data1);
    $this->load->view('admins/instruction/edit_instruction',$data);
    $this->load->view('admins/admin_footer'); 
  } else {
    redirect('/index.php/admins');
  }
  }
  public function update_instruction($instructionID){
    $this->form_validation->set_rules('subject_id', 'Subject Name', 'required');
    $this->form_validation->set_rules('topic_id', 'Topic Name', 'required');
    $this->form_validation->set_rules('instruction', 'Instruction', 'required');
    if ($this->form_validation->run() == true){
    $subjectID = $this->input->post('subject_id');
    $topicID = $this->input->post('topic_id');
    $instruction = $this->input->post('instruction');
    $update_id = $this->admins_model->update('instructions', array('subject_id'=>$subjectID, 'topic_id'=>$topicID, 'instruction'=>$instruction),array('instruction_id'=>$instructionID));
    if($update_id){
      $message = '<div class="alert alert-success alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Success!</strong> Instruction <strong> successfully Updated!</strong></div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_instruction');
    }
    }else{
      $message = '<div class="alert alert-danger alert-dismissable">';
      $message .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $message .= '<strong>Error!</strong> <strong>Can Not Update </strong>Instruction!</div>';
      $this -> session -> set_flashdata('response_message', $message);
      redirect('index.php/admins/add_instruction');
    }
  }
}
