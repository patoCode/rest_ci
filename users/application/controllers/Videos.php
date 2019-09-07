<?php
require APPPATH . 'libraries/REST_Controller.php';

class Videos extends REST_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->model('Videos_model','videos');
    }
  public function index_get()
  {
    $array = $this->videos->getAll();
    $this->response($array);
  }

  public function index_post()
  {
    $input = $this->input->post();
    $array = array("SOY","EL" ,"POST");
    $this->response($array);
  }
  public function index_delete(){    
    $array = array("SOY","EL" ,"delete");
    $this->response($array);
  }
}