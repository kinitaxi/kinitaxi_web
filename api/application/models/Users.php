<?php
class Users extends CI_Model {

    var $table = 'users';

    function get($id = NULL){
        //$this->db->select("id,name,email,fact");
        if ( ! $id) {
            return $this->db->get($this->table)->result();
        }
        else {
            return $this->db->get_where($this->table, ['id' => $id])->result();
        }
    }

    function create($data){

        $que = $this->db->get_where($this->table, ['mat_no' => $data['mat_no']]);

        if ( ! $que->num_rows()){

            return $this->db->insert($this->table, $data);
        }
        else{

            return NULL;

        }

    }

}
