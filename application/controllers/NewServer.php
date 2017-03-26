<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NewServer extends CI_Controller {


  public function __construct() { 
    parent::__construct();
    $this -> load -> model('admins_model');
  }

  public function index()
  {
    if($this->session->userdata('admin_data'))
    {
      redirect('admins');
    }
    else {
      $this->load->view('admins/login');
    }
  }

  public function config_new_server(){
    if($this->session->userdata('admin_data')){
        $dataTitle['title'] = 'Configure New Server';
        $dataActive['page'] = 'new_server';
      $messageSuccess = '<div class="alert alert-success alert-dismissable">';
      $messageSuccess .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $messageError = '<div class="alert alert-danger alert-dismissable">';
      $messageError .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $serverIpCheck = $this->input->post('server_ip');
      $serverDetails = $this->admins_model->get_result('server_credentials', array('server_ip'=>trim($serverIpCheck)));
//      $this->form_validation->set_rules('category', 'Category Name', 'required');
      if ($serverDetails[0]->server_ip != trim($serverIpCheck)) {
        $this->form_validation->set_rules('server_name', 'Server Name', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('server_ip', 'Server IP', 'required');
        $this->form_validation->set_rules('server_url', 'Server URL', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('server_username', 'Server Username', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('server_password', 'Server Password', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('server_port', 'Server Port', 'required');
        $this->form_validation->set_rules('database_username', 'Database Username', 'trim|required|min_length[3]');
        $this->form_validation->set_rules('database_password', 'Database Password', 'trim|required|min_length[3]');
        if ($this->form_validation->run() == true) {
          $serverName = $this->input->post('server_name');
          $serverIp = $this->input->post('server_ip');
          $serverUrl = $this->input->post('server_url');
          $serverUsername = $this->input->post('server_username');
          $serverPassword = $this->input->post('server_password');
          $serverPort = $this->input->post('server_port');
          $databaseUsername = $this->input->post('database_username');
          $databasePassword = $this->input->post('database_password');
          $developerNote = $this->input->post('developer_note');
//        $developerNote = $this->input->post('apache_install');
          $insertId = $this->admins_model->insert('server_credentials', array('server_name' => $serverName, 'server_ip' => $serverIp, 'server_url' => $serverUrl, 'server_username' => $serverUsername, 'server_password' => $serverPassword, 'server_port' => $serverPort, 'database_username' => $databaseUsername, 'database_password' => $databasePassword, 'developer_note' => $developerNote));
          if ($insertId) {
            $connection = connect_to_remote_server($insertId);
            if ($connection) {
              $output="";
              $stream = ssh2_exec($connection, 'sudo apt-get update');
              $output .= get_output_result_of_shell($stream);
              $messageSuccess .= '<strong>Success! Update</strong>' . $output . '</div>';
              if ($this->input->post('apache_install')) {
                $stream = ssh2_exec($connection, 'sudo apt-get -y install apache2');
                $output .= get_output_result_of_shell($stream);
                $messageSuccess .= '<strong>Success! Apache WebServer installation</strong>' . $output . '</div>';
                $output = "";
              }
              if ($this->input->post('php_install')) {
                $stream = ssh2_exec($connection, 'sudo apt-get -y install software-properties-common');
                $output .= get_output_result_of_shell($stream);
                $stream = ssh2_exec($connection, 'sudo add-apt-repository -y ppa:ondrej/php');
                $output .= get_output_result_of_shell($stream);
                $stream = ssh2_exec($connection, 'sudo apt-get -y update');
                $output .= get_output_result_of_shell($stream);
                $stream = ssh2_exec($connection, 'sudo apt-get -y install php5.6 php5.6-mcrypt php5.6-gd php5.6-soap php5.6-mbstring php5.6-curl php5.6-cli php5.6-mysql php5.6-gd php5.6-intl php5.6-xsl php5.6-zip');
                $output .= get_output_result_of_shell($stream);
                $stream = ssh2_exec($connection, 'sudo apt-get -y update');
                $output .= get_output_result_of_shell($stream);
                $stream = ssh2_exec($connection, 'sudo apt-get -y install  htop');
                $output .= get_output_result_of_shell($stream);
                $messageSuccess .= '<strong>Success! PHP5.6 Installation</strong>' . $output . '</div>';
                $output = "";
              }
              if ($this->input->post('mysql_install')) {
                $stream = ssh2_exec($connection, "sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password " . $databasePassword . "'");
                $output .= get_output_result_of_shell($stream);
                $stream = ssh2_exec($connection, "sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password " . $databasePassword . "'");
                $output .= get_output_result_of_shell($stream);
                $stream = ssh2_exec($connection, "sudo apt-get -y install mysql-server");
                $output .= get_output_result_of_shell($stream);
                $messageSuccess .= '<strong>Success! MySQL</strong>' . $output . '</div>';
                $output = "";
              }
            } else {
              $messageError .= '<strong>Error!</strong> Can Not Connect To Remote Server!</div>';
              $this->session->set_flashdata('response_message', $messageSuccess);
            }
          } else {
            $messageError .= '<strong>Error!</strong> Unable to insert server details!</div>';
            $this->session->set_flashdata('response_message', $messageSuccess);
          }
          $this->session->set_flashdata('response_message', $messageSuccess);
          redirect('admins/new_server/1');
        }
        $messageError .= '<strong>Error!</strong> Please enter valid form data!</div>';
        $this -> session -> set_flashdata('response_message', $messageError);
        redirect('admins/new_server/1');
      }
      $messageError .= '<strong>Error!</strong> Ip is already present!</div>';
      $this -> session -> set_flashdata('response_message', $messageError);
      redirect('admins/new_server/1');
    } else {
      redirect('/admins');
    }
  }
}
