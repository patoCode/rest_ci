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
        $id = $this->input->post('id');
        $input = array(
            'nombre'   => $nombre,
            'apellido' => $apellido,
            'telefono'=> $telefono,
            'username'=> $username,
            'password'=> $password,
            'email'=> $email,
        );
        if($id == null){
            $this->usuario->add($input);
            echo "INSERT OK";
        }else{
            $this->usuario->update($input, $id);
            $this->queue->push('BBDD', array($nombre, $id), 'testing.push');            
            echo "INSERT RABBIT MAS";
        }       
    }

    public function search_post(){
        $username = $this->input->post('username');
        $nombre = $this->input->post('nombre');

        $this->queue->push('BBDD', array($usuario->nombre, $usuario->id), 'testing.push');            
        echo "CONTAR KUDOS";

        $resultados = $this->usuario->search($username, $nombre);
        $this->response($resultados, REST_Controller::HTTP_OK);
    }

    public function all_get(){
        $resp = $this->usuario->getAll();
        $this->response($resp, REST_Controller::HTTP_OK);
    }

    public function profile_get($id){
        $usuario = $this->usuario->getById($id);

        $this->queue->push('BBDD', array($usuario->nombre, $usuario->id), 'testing.push');            
        echo "CONTAR KUDOS";

        $this->response($usuario, REST_Controller::HTTP_OK);
    }

    public function delete_delete($id){
        $usuario = $this->usuario->getById($id);
        $array = array("ELIMINADO ", $usuario);
        $this->queue->push('BBDD', array($usuario->nombre, $usuario->id), 'testing.push');            
        echo "BORRA KUDOS";
        $this->usuario->delete($id);
        $this->response($array, REST_Controller::HTTP_OK);
    }  
}