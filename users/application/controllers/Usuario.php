<?php
require APPPATH . 'libraries/REST_Controller.php';
require_once __DIR__ . '/../third_party/vendor/autoload.php';


use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class Usuario extends REST_Controller
{
    public function __construct() {
        parent::__construct();     
        $this->load->model('Usuario_model', 'usuario');
    }
    public function index_get($id = null){
        $data['user'] = $this->usuario->getById($id);
        $this->load->view('public/usuario', $data);
    }

    public function add_post(){
        $nombre = $this->input->post('nombre');
        $apellido = $this->input->post('apellido');
        $telefono = $this->input->post('telefono');
        $username = $this->input->post('username');
        $password = md5($this->input->post('password'));
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
            $this->response("OK", REST_Controller::HTTP_OK);         
        }else{
            $this->usuario->update($input, $id);
            $this->queue->push('BBDD', array($nombre, $id), 'testing.push');            
            $this->response("OK", REST_Controller::HTTP_OK);
        }       
    }

    public function search_post(){
        $username = $this->input->post('username');
        $nombre = $this->input->post('nombre');
        $resultados = $this->usuario->search($username, $nombre);
        $this->response($resultados, REST_Controller::HTTP_OK);
    }

    public function all_get(){
        $data['lista'] = $this->usuario->getAll();
        $this->response($data['lista'], REST_Controller::HTTP_OK);        
    }

    public function addQty_get($id){
        $resp = $this->usuario->addQty($id);
        $this->response($resp, REST_Controller::HTTP_OK);
    }  
    public function discountQty_get($id){
        $resp = $this->usuario->discountQty($id);
        $this->response($resp, REST_Controller::HTTP_OK);
    } 

    public function profile_get($id){
        $usuario = $this->usuario->getById($id);
        $queueUser = "QUEUE-".$id;
        $queue_rpc = new RpcClient();
        $queue_rpc->setQueue($queueUser);
        $response = $queue_rpc->call($id);
        $data = array("USUARIO" => $usuario, "KUDOS" =>json_decode($response));
        $this->response($data, REST_Controller::HTTP_OK);
    }

    public function delete_delete($id){
        $usuario = $this->usuario->getById($id);
        $this->usuario->delete($id);


        $queue_rpc = new RpcClient();
        $queue_rpc->setQueue('USERDEL_');
        $response = $queue_rpc->call($id);

        $array = array("ELIMINADO " => $usuario, "KUDOS"=>json_decode($response));

        
        $this->response($array, REST_Controller::HTTP_OK);
    }  

    private function fib($n){
        if ($n == 0) {
            return 0;
        }
        if ($n == 1) {
            return 1;
        }
        return $this->fib($n-1) + $this->fib($n-2);
    }
}