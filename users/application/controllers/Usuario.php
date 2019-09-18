<?php
require APPPATH . 'libraries/REST_Controller.php';

class Usuario extends REST_Controller
{
    public function __construct() {
        parent::__construct();     
        $this->load->model('Usuario_model', 'usuario');
    }
    public function index_get(){
        $this->load->view('public/usuario');
    }
    public function add_post(){
        $nombre = $this->input->post('nombre');
        $apellido = $this->input->post('apellido');
        $telefono = $this->input->post('telefono');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
        $input = array(
            'nombre'   => $nombre,
            'apellido' => $apellido,
            'telefono'=> $telefono,
            'username'=> $username,
            'password'=> $password,
            'email'=> $email,
        );
        $this->usuario->add($input);
        $result = $this->queue->push('hello', array('Hello', 'World'), 'testing.push');
        var_dump($result);
        echo $nombre;
    }
    public function all_get(){
        $resp = $this->usuario->getAll();
        $this->response($resp, REST_Controller::HTTP_OK);
    }
    public function delete_delete($id){
        $usuario = $this->usuario->getById($id);
        $array = array("ELIMINADO ", $usuario);
        $this->usuario->delete($id);
        $this->response($array, REST_Controller::HTTP_OK);
    }    
}