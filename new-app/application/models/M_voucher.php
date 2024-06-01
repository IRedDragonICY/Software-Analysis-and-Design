<?php


class M_voucher extends CI_Model
{

    public function tampil()
    {
        return $this->db->get('logs_voucher');
    }

    public function input($table, $data)
    {
        $this->db->insert($table, $data);
    }

    public function month()
    {
        $month = $this->db->query("SELECT SUM(harga) AS total FROM logs_voucher WHERE MONTH(logs_voucher.date) = '" . date('m') . "' AND YEAR(logs_voucher.date) = '" . date('Y') . "' ");
        return $month->row()->total;
    }

    public function today()
    {
        $today = $this->db->query("SELECT SUM(harga) AS total FROM logs_voucher WHERE date(date) = CURRENT_DATE()");
        return $today->row()->total;
    }

    public function yesterday()
    {
        $today = $this->db->query("SELECT SUM(harga) AS total FROM logs_voucher WHERE date(date) = CURRENT_DATE() - INTERVAL 1 DAY");
        return $today->row()->total;
    }

    public function vcrtoday()
    {
        $vcrtoday = $this->db->query("SELECT * FROM logs_voucher WHERE date(date) = CURRENT_DATE()");
        return $vcrtoday->num_rows();
    }

    public function vcrystrdy()
    {
        $vcrystrdy = $this->db->query("SELECT * FROM logs_voucher WHERE date(date) = CURRENT_DATE() - INTERVAL 1 DAY");
        return $vcrystrdy->num_rows();
    }

    public function vcrmonth()
    {
        $vcrmonth = $this->db->query("SELECT * FROM logs_voucher WHERE MONTH(logs_voucher.date) = '" . date('m') . "' AND YEAR(logs_voucher.date) = '" . date('Y') . "' ");
        return $vcrmonth->num_rows();
    }

    public function datavcrmonth()
    {
        $vcrmonth = $this->db->query("SELECT * FROM logs_voucher WHERE MONTH(logs_voucher.date) = '" . date('m') . "' AND YEAR(logs_voucher.date) = '" . date('Y') . "' ");
        return $vcrmonth;
    }

    public function totalhotspotuser()
    {
        $query = $this->db->where('email', 'Admin')->get('orders_voucher')->num_rows();

        return $query;
    }

    public function hotspotuser()
    {
        $query = $this->db->where('email', 'Admin')->get('orders_voucher')->result_array();

        return $query;
    }

    public function gettahunmasuk()
    {
        $query = $this->db->query("SELECT YEAR(date) AS tahun FROM logs_voucher GROUP BY YEAR(date) ORDER BY YEAR(date) ASC");

        return $query->result();
    }

    public function comment()
    {

        $query = $this->db->where('email', 'Admin')->group_by("CASE WHEN comment IS NOT NULL THEN comment END", FALSE)->get('orders_voucher');

        return $query;
    }
    public function get($table)
    {
        // Menghasilkan banyak row berupa objek
        return $this->db->get($table);
    }
    public function where($column, $condition)
    {
        $this->db->where($column, $condition);
        return $this;
    }

    public function deleteby($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('orders_voucher');
    }

    public function num_rows()
    {
        return $this->db->num_rows();
    }

    public function credit()
    {
        $credit = $this->db->query("SELECT SUM(harga) AS total FROM logs_voucher WHERE MONTH(logs_voucher.date) = '" . date('m') . "' AND YEAR(logs_voucher.date) = '" . date('Y') . "' ");
        return $credit->row()->total;
    }

    public function filter($bulan, $tahun)
    {
        $query = $this->db->query("SELECT * FROM logs_voucher WHERE MONTH(date) = '$bulan' AND YEAR(date) = '$tahun' ORDER BY date ASC");

        return $query;
    }
    public function creditfilter($bulan, $tahun)
    {
        $credit = $this->db->query("SELECT SUM(harga) AS total FROM logs_voucher WHERE MONTH(date) = '$bulan' AND YEAR(date) = '$tahun'");
        return $credit->row()->total;
    }
}
