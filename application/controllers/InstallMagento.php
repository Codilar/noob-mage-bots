<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InstallMagento extends CI_Controller {


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

  public function install_new_magento_one(){
    if($this->session->userdata('admin_data')) {
      $dataTitle['title'] = 'Configure New Server';
      $dataActive['page'] = 'install_magento';
      $messageSuccess = '<div class="alert alert-success alert-dismissable">';
      $messageSuccess .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
      $messageError = '<div class="alert alert-danger alert-dismissable">';
      $messageError .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';


      $this->form_validation->set_rules('select_magento', 'Select Magento', 'required');
      $this->form_validation->set_rules('select_server', 'Select Server', 'required');
        if ($this->form_validation->run() == true) {
          $selectMagentoVersion = $this->input->post('select_magento');
          $selectServer = $this->input->post('select_server');
          $connection = connect_to_remote_server($selectServer);
          if ($connection) {
            $output = "";
            $stream = ssh2_exec($connection, 'sudo apt-get update');
            $output .= get_output_result_of_shell($stream);
            $messageSuccess .= '<strong>Success! Update</strong>' . $output . '</div>';
            if ($selectMagentoVersion && $selectMagentoVersion == "magento_one") {
              $stream = ssh2_exec($connection, 'sudo mkdir /var/www/log');
              $output .= get_output_result_of_shell($stream);
              $stream = ssh2_exec($connection, 'sudo apt-get -y install git');
              $output .= get_output_result_of_shell($stream);
              $stream = ssh2_exec($connection, 'mkdir /var/www/magento;cd /var/www/magento;git clone https://github.com/OpenMage/magento-mirror.git .;chown -R www-data:www-data . ;cd ~;');
              $output .= get_output_result_of_shell($stream);
              $messageSuccess .= '<strong>Success! Apache WebServer installation</strong>' . $output . '</div>';
              $output = "";
            } elseif ($selectMagentoVersion && $selectMagentoVersion == "magento_two") {

            } else {
              $messageError .= '<strong>Error!</strong> Can Not Install To Magento</div>';
              $this->session->set_flashdata('response_message', $messageSuccess);
            }
          } else {
            $messageError .= '<strong>Error!</strong> Unable connect to remote server!</div>';
            $this->session->set_flashdata('response_message', $messageSuccess);
          }
        }
      $messageError .= '<strong>Error!</strong> Please select value!</div>';
      $this->session->set_flashdata('response_message', $messageError);
      redirect('admins/new_server/1');
    } else {
      redirect('/admins');
    }
  }
}
