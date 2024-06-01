<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_user extends CI_Model
{

    public function account($email)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->like("email", $email);
        $query = $this->db->get();

        return $query;
    }

    public function input($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    public function getDataHistory($table)
    {
        return $this->db->get($table);
    }

    public function where($column, $condition)
    {
        $this->db->where($column, $condition);
        return $this;
    }

    public function data($where, $table)
    {
        return $this->db->get_where($table, $where);
    }
    public function orderBy($column, $order = 'asc')
    {
        $this->db->order_by($column, $order);
        return $this;
    }
    public function get($table)
    {
        // Menghasilkan banyak row berupa objek
        return $this->db->get($table);
    }

    public function num_rows()
    {
        return $this->db->num_rows();
    }


    public function r_array($table)
    {
        return $this->db->get($table)->result_array();
    }


    public function first($table)
    {
        // Menghasilkan 1 row berupa objek
        return $this->db->get($table)->row();
    }
    public function select($columns)
    {
        // Param columns beripe array
        $this->db->select($columns);
        return $this;
    }
    public function join($tablenya, $table, $type = 'left')
    {
        // Param 1: table yang ingin digabungkan
        // Param 2 misal: mencari produk berdasarkan kategori --> "product.id_category = category.id"
        $this->db->join($table, "$tablenya.id_$table = $table.id", $type);
        return $this;
    }


    public function datainvoice($code, $idpel)
    {
        // $cek = $this->db->query("SELECT * FROM invoice WHERE code = '$code' AND idpel = '$this->id'");

        $this->db->select('*');
        $this->db->from('invoice');
        $this->db->where('code', $code);
        $this->db->where('idpel', $idpel);

        $query = $this->db->get();

        return $query;
    }


    public function paymentmethod($id)
    {
        $this->db->select('*');
        $this->db->from('payment_method');
        $this->db->where('id', $id);
        $this->db->where('status', '1');

        $query = $this->db->get();

        return $query->result_array();
    }

    public function cobajoin($firsttable, $secondtable)
    {
        $this->db->select('*');
        $this->db->from('comments');
        $this->db->join('tbl_user', 'tbl_user.id = comments.id');

        $query = $this->db->get();
        // SELECT * FROM comments
        // JOIN tbl_user ON tbl_user.id = comments.id
    }
}
