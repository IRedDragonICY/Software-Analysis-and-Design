<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_reseller extends CI_Model
{
    public function account($email)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->like("email", $email);
        $query = $this->db->get();

        return $query;
    }

    public function num_rows()
    {
        return $this->db->num_rows();
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

    public function get_where($table, $id)
    {
        return $this->db->get_where($table, $id)->result();
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

    public function update($where, $wherenya, $tablenya, $data)
    {
        $this->db->where($where, $wherenya);

        return $this->db->update($tablenya, $data);
    }


    public function update_set($where, $wherenya, $tablenya, $data, $datanya)
    {
        $this->db->set($data, $data .  '-'  .  $datanya, false);
        $this->db->where($where, $wherenya);

        return $this->db->update($tablenya); // gives UPDATE mytable SET field = field+1 WHERE id = 2

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

    public function today($email)
    {
        $today = $this->db->query("SELECT SUM(harga) AS total FROM orders_voucher WHERE email = '$email' AND date(date) = CURRENT_DATE()");
        return $today->row()->total;
    }

    public function voctoday($email)
    {
        $vcrtoday = $this->db->query("SELECT * FROM orders_voucher WHERE email = '$email' AND date(date) = CURRENT_DATE()");
        return $vcrtoday->num_rows();
    }
    public function yesterday($email)
    {
        $today = $this->db->query("SELECT SUM(harga) AS total FROM orders_voucher WHERE email = '$email' AND  date(date) = CURRENT_DATE() - INTERVAL 1 DAY");
        return $today->row()->total;
    }
    public function vcrystrdy($email)
    {
        $vcrystrdy = $this->db->query("SELECT * FROM orders_voucher WHERE email = '$email' AND  date(date) = CURRENT_DATE() - INTERVAL 1 DAY");
        return $vcrystrdy->num_rows();
    }

    public function totalincome($email)
    {
        $total = $this->db->query("SELECT SUM(harga) AS total FROM orders_voucher WHERE email = '$email'");
        return $total->row()->total;
    }

    public function profitmonth($email)
    {
        $month = $this->db->query("SELECT SUM(harga) AS total FROM orders_voucher WHERE email = '$email' AND MONTH(orders_voucher.date) = '" . date('m') . "' AND YEAR(orders_voucher.date) = '" . date('Y') . "' ");
        return $month->row()->total;
    }



    public function profitprevmonth($email)
    {
        $prevmonth = $this->db->query("SELECT SUM(harga) AS total FROM orders_voucher WHERE email = '$email' AND MONTH(orders_voucher.date) = '" . date('m', strtotime('-1 months')) . "' AND YEAR(orders_voucher.date) = '" . date('Y') . "' ");
        return $prevmonth->row()->total;
    }
}
