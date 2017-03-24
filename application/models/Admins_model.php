<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admins_model extends CI_Model {
   /*
	*
	::::::::::Start of CRUD - ::::::::::::::
	*
	*/
	public function insert($table_name = '', $data = '') {
    $query = $this->db->insert($table_name, $data);
    if ($query)
      return $this->db->insert_id();
    else
      return FALSE;
  }

  public function get_result($table_name = '', $id_array = '') {
    if (!empty($id_array)):
      foreach ($id_array as $key => $value) {
	$this->db->where($key, $value);
      }
    endif;

    $query = $this->db->get($table_name);
    if ($query->num_rows() > 0)
      return $query->result();
    else
      return FALSE;
  }

  public function get_row($table_name = '', $id_array = '') {
    if (!empty($id_array)):
      foreach ($id_array as $key => $value) { 
	$this->db->where($key, $value);
      }
    endif;

    $query = $this->db->get($table_name); 
    if ($query->num_rows() > 0)
      return $query->row();
    else
      return FALSE;
  }

  public function update($table_name = '', $data = '', $id_array = '') {
    foreach ($id_array as $key => $value) {
      $this->db->where($key, $value);
    }
    return $this->db->update($table_name, $data);
  }

  public function delete($table_name = '', $id_array = '') {
    return $this->db->delete($table_name, $id_array);
  }

  /*
   *
   ::::::::::::::::End of CDUD-::::::::::::::::
   *
   */

    public function get_admin_details($userName){
        $this->db->where('username', $userName);
        $query = $this->db->get('admins');
        if($query->num_rows() > 0){
          $sessionData = array(
            'adminId'=>$query->row()->admin_id,
            'userName'=>$query->row()->username,
            'firstName'=>$query->row()->first_name,
            'lastName'=>$query->row()->last_name,
            'permissionId'=>$query->row()->permission_id,
            'lastIp'=>$query->row()->last_ip,
            'logged_in'=>TRUE
            );
          $this->session->set_userdata('admin_data', $sessionData);
        }
    }

    public function get_permission_list_by_user_group($permissionId){
        $this->db->select('features_list.feature_id,features_list.feature_name,features_list.feature_controller,features_permission_map.feature_id,features_permission_map.permission_id');
        $this->db->from('features_list');
        $this->db->join('features_permission_map','features_list.feature_id = features_permission_map.feature_id','left');
        $this->db->where('permission_id',$permissionId);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }













   public function get_sub_cat(){
    $this->db->select('subject.subject_id,subject.subject_name,subject_category.category_id,subject_category.category_name');
                $this->db->from('subject');
                $this->db->join('subject_category','subject_category.category_id = subject.category_id','left');
                $query = $this->db->get();
                if ($query->num_rows() > 0) {
                    return $query->result_array();
                } else {
                    return FALSE;
                }
            }
   public function get_sub_cat_by_id($subjectID){
    $this->db->select('subject.subject_id,subject.subject_name,subject_category.category_id,subject_category.category_name');
                $this->db->from('subject');
                $this->db->join('subject_category','subject_category.category_id = subject.category_id','left');
                $this->db->where('subject.subject_id',$subjectID);
                $query = $this->db->get();
                if ($query->num_rows() > 0) {
                    return $query->result_array();
                } else {
                    return FALSE;
                }
   }
   public function get_topic_exam(){
    $this->db->select('topic.topic_id, topic.topic_name, topic.subject_id, topic.topic_position, GROUP_CONCAT(exam_topic_map.exam_id) AS eid,subject.subject_id,subject.subject_name,GROUP_CONCAT(exams.exam_name) AS ename');
                $this->db->from('topic');
                $this->db->join('exam_topic_map','exam_topic_map.topic_id = topic.topic_id','left');
                $this->db->join('subject','subject.subject_id = topic.subject_id','left');
                $this->db->join('exams','exams.exam_id = exam_topic_map.exam_id','left');
                // $this->db->where('exam_topic_map.exam_id');
                $this->db->group_by("topic.topic_id", "ASC");
                $query = $this->db->get();
//                    echo "<pre>";
//                    print_r($query->result());
//                    die();
                if ($query->num_rows() > 0) {
                    return $query->result_array();
                } else {
                    return FALSE;
                }
            }
    public function get_topic_by_id($topicId){
    $this->db->select('topic.topic_id, topic.topic_name, topic.subject_id, topic.topic_position, GROUP_CONCAT(exam_topic_map.exam_id) AS eid,subject.subject_id,subject.subject_name,GROUP_CONCAT(exams.exam_name) AS ename');
                $this->db->from('topic');
                $this->db->join('exam_topic_map','exam_topic_map.topic_id = topic.topic_id','left');
                $this->db->join('subject','subject.subject_id = topic.subject_id','left');
                $this->db->join('exams','exams.exam_id = exam_topic_map.exam_id','left');
                $this->db->where('topic.topic_id',$topicId);
                $query = $this->db->get();
//                    echo "<pre>";
//                    print_r($query->result());
//                    die();
                if ($query->num_rows() > 0) {
                    return $query->result_array();
                } else {
                    return FALSE;
                }
            }
    public function get_exam_cat(){
    $this->db->select('exams.exam_id,exams.exam_name,exams.exam_full_name,exam_category.category_id,exam_category.category_name');
                $this->db->from('exams');
                $this->db->join('exam_category','exam_category.category_id = exams.category_id','left');
                $query = $this->db->get();
//                    echo "<pre>";
//                    print_r($query->result());
//                    die();
                if ($query->num_rows() > 0) {
                    return $query->result_array();
                } else {
                    return FALSE;
                }
            }
    public function get_exam_cat_by_id($examID){
        $this->db->select('exams.exam_id,exams.exam_name,exams.exam_full_name,exam_category.category_id,exam_category.category_name');
                $this->db->from('exams');
                $this->db->join('exam_category','exam_category.category_id = exams.category_id','left');
                $this->db->where('exams.exam_id',$examID);
                $query = $this->db->get();
                if ($query->num_rows() > 0) {
                    return $query->result_array();
                } else {
                    return FALSE;
                }
        }
    public function fetch_question($subjectId,$topicId) {
            $this->db->select("questions.*,question_level.*,subject.*,topic.*,question_answer.*,GROUP_CONCAT(question_option.question_option SEPARATOR '__') AS `option`");
            $this->db->from('questions');
            $this->db->join('question_option','question_option.question_id = questions.qid','left');
            $this->db->join('subject','subject.subject_id = questions.subject_id','left');
            $this->db->join('topic','topic.topic_id = questions.topic_id','left');
            $this->db->join('question_level','question_level.level_id = questions.level_id','left');
            $this->db->join('question_answer','question_answer.question_id = questions.qid','left');
            $this->db->where('questions.subject_id',$subjectId);
            if ($topicId){
                $this->db->where('questions.topic_id',$topicId);
            }
            $this->db->group_by('questions.qid');
            $this->db->order_by('questions.qid','ASC');
            $query1 = $this->db->get();

            $this->db->select("questions.qid,GROUP_CONCAT(year_question_map.year) AS years,GROUP_CONCAT(exams.exam_name) AS exams");
            $this->db->from('questions');
            $this->db->join('year_question_map','year_question_map.question_id = questions.qid','left');
            $this->db->join('exams','exams.exam_id = year_question_map.exam_id','left');
            // $this->db->where('questions.topic_id',$topicId);
            $this->db->where('questions.subject_id',$subjectId);
            if ($topicId){
            $this->db->where('questions.topic_id',$topicId);
                }
            $this->db->group_by('questions.qid');
            $this->db->order_by('questions.qid','ASC');
            $query2 = $this->db->get();

            if ($query1->num_rows() > 0) {
            $result1 = $query1->result();
            $result2 = $query2->result();
            $i = 0;
            foreach ($result1 as $result) {
                $obj_merged[] = (object) array_merge((array) $result, (array) $result2[$i]);
                $i++;
            }
                return $obj_merged;
            } else {
              return FALSE;
            }
      }
   public function fetch_question_details($questionID) { 
            $this->db->select("questions.*,question_level.*,subject.*,topic.*,question_answer.*,GROUP_CONCAT(question_option.question_option SEPARATOR '__') AS `option`,GROUP_CONCAT(question_option.option_id) AS `optionId`");
            $this->db->from('questions');
            $this->db->join('question_option','question_option.question_id = questions.qid','left');
            $this->db->join('subject','subject.subject_id = questions.subject_id','left');
            $this->db->join('topic','topic.topic_id = questions.topic_id','left');
            $this->db->join('question_level','question_level.level_id = questions.level_id','left');
            $this->db->join('question_answer','question_answer.question_id = questions.qid','left');
            $this->db->where('questions.qid',$questionID);
            $this->db->group_by('questions.qid');
            $this->db->order_by('questions.qid','ASC');
            $query1 = $this->db->get();

            $this->db->select("GROUP_CONCAT(year_question_map.year SEPARATOR '__') AS years,GROUP_CONCAT(exams.exam_name SEPARATOR '__') AS exams,GROUP_CONCAT(exams.exam_id SEPARATOR '__') AS exam_id");
            $this->db->from('year_question_map');
            $this->db->join('exams','exams.exam_id = year_question_map.exam_id','left');
            $this->db->where('year_question_map.question_id',$questionID);
            $this->db->group_by('year_question_map.exam_id');
            $this->db->order_by('year_question_map.exam_id','ASC');
            $query2 = $this->db->get();

            if ($query1->num_rows() > 0) {
            $result1 = $query1->result();
            $result2['yearsSelected'] = $query2->result();
            $i = 0;
            foreach ($result1 as $result) {
                $obj_merged[] = (object) array_merge((array) $result, (array) $result2);
                $i++;
            }
                return $obj_merged;
            } else {
              return FALSE;
            }
      }

    public function fetch_instruction(){
        $this->db->select('instructions.*,subject.subject_name,topic.topic_name');
        $this->db->from('instructions');
        $this->db->join('subject','subject.subject_id=instructions.subject_id','left');
        $this->db->join('topic','topic.topic_id=instructions.topic_id','left');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }
    public function fetch_direction(){
        $this->db->select('directions.*,topic.topic_name');
        $this->db->from('directions');
        $this->db->join('topic','topic.topic_id=directions.topic_id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }
    public function getDirectionById($directionId){
        $this->db->select('directions.*,topic.topic_id,topic.topic_name,subject.subject_id,subject.subject_name');
        $this->db->from('directions');
        $this->db->join('topic','topic.topic_id=directions.topic_id');
        $this->db->join('subject','subject.subject_id=topic.subject_id');
        $this->db->where('directions.direction_id',$directionId);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }
    public function getInstructionByTopicId($instructionId){
        $this->db->select('instructions.*,subject.subject_name,topic.topic_name');
        $this->db->from('instructions');
        $this->db->join('subject','subject.subject_id=instructions.subject_id');
        $this->db->join('topic','topic.topic_id=instructions.topic_id');
        $this->db->where('instructions.instruction_id',$instructionId);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }
    public function getDirectionByTime($topicId){
        $this->db->select('*');
        $this->db->from('directions');
        $this->db->order_by('last_used','desc');
        $this->db->where('topic_id',$topicId);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return FALSE;
        }
    }

   }

