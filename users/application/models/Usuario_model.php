<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuario_model extends CI_Model {

  public function getAll(){
    $q = $this->db->get('usuario');
    $response = $q->result();
    return $response;
  }
  public function getById($id){
    $this->db->from('usuario');
    $this->db->where('id', $id);
    $query = $this->db->get();
    return $query->row();
  }
  public function add($input){
    $this->db->insert('usuario',$input);
  }
  public function delete($id){
    $this->db->delete('usuario', array('id' => $id)); 
  }
  public function search($input){}


}