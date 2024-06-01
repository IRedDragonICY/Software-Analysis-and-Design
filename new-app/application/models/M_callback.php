<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_callback extends CI_Model
{

    public function where($column, $condition)
    {
        $this->db->where($column, $condition);
        return $this;
    }
    public function first($table)
    {
        // Menghasilkan 1 row berupa objek
        return $this->db->get($table)->row();
    }

    public function payment_gateway()
    {
    }

    public function get($table)
    {
        // Menghasilkan banyak row berupa objek
        return $this->db->get($table)->result();
    }
}
