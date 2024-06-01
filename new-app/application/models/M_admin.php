<?php

class M_admin extends CI_Model
{

    public function where($column, $condition)
    {
        $this->db->where($column, $condition);
        return $this;
    }

    public function get($table)
    {
        // Menghasilkan banyak row berupa objek
        return $this->db->get($table);
    }

    public function get_where($table, $id)
    {
        return $this->db->get_where($table, $id);
    }

    public function results($table, $id)
    {
        return $this->db->get_where($table, $id)->result();
    }


    public function num_rows()
    {
        return $this->db->num_rows();
    }

    public function first($table)
    {
        return $this->db->get($table)->row();
    }

    public function idpel()
    {
        $this->db->select_max('idpel');
        $auto = $this->db->get('orders');
        return $auto->result_array();
    }


    public function paid()
    {
        $this->db->select('*');
        $this->db->from('invoice');
        $this->db->where('status', 'Paid');
        $num_results = $this->db->count_all_results();

        return $num_results;
    }

    public function paiduser()
    {
        $this->db->select('*');
        $this->db->from('invoice');
        $this->db->where('status', 'Paid');
        $this->db->where('account', 'user');

        $num_results = $this->db->count_all_results();

        return $num_results;
    }

    public function paidmember()
    {
        $this->db->select('*');
        $this->db->from('invoice');
        $this->db->where('status', 'Paid');
        $this->db->where('account', 'member');

        $num_results = $this->db->count_all_results();

        return $num_results;
    }


    public function unpaid()
    {
        $this->db->select('*');
        $this->db->from('invoice');
        $this->db->where('status', 'Unpaid');
        $num_results = $this->db->count_all_results();

        return $num_results;
    }

    public function unpaiduser()
    {
        $this->db->select('*');
        $this->db->from('invoice');
        $this->db->where('status', 'Unpaid');
        $this->db->where('account', 'user');

        $num_results = $this->db->count_all_results();

        return $num_results;
    }

    public function unpaidmember()
    {
        $this->db->select('*');
        $this->db->from('invoice');
        $this->db->where('status', 'Unpaid');
        $this->db->where('account', 'member');

        $num_results = $this->db->count_all_results();

        return $num_results;
    }

    public function close()
    {
        $this->db->select('*');
        $this->db->from('tickets');
        $this->db->where('status', 'Closed');
        $num_results = $this->db->count_all_results();

        return $num_results;
    }
    public function pending()
    {
        $this->db->select('*');
        $this->db->from('tickets');
        $this->db->where('status', 'Pending');
        $num_results = $this->db->count_all_results();

        return $num_results;
    }

    public function users()
    {
        return $this->db->get('users');
    }

    public function members()
    {
        return $this->db->where('level', 'member')->get('users');
    }

    public function reseller()
    {
        return $this->db->where('level', 'reseller')->get('users');
    }

    public function join($table, $tablejoin, $var, $type = 'left')
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->join($tablejoin, "$tablejoin.$var =$table.$var", $type);

        $query = $this->db->get();

        return $query->result();
    }

    public function join_where($table, $tablejoin, $var, $where, $wherenya,  $type = 'left')
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->join($tablejoin, "$tablejoin.$var =$table.$var", $type);
        $this->db->where("$tablejoin.$where", $wherenya);
        $query = $this->db->get();

        return $query->result();
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

    public function update_status()
    {
        $this->db->set('status', 'isolir');
        $this->db->where('DATEDIFF(CURDATE(), expdate) >= 1');
        $this->db->where('status', 'active');
        return  $this->db->update('orders');
    }


    public function delete($table, $where)
    {
        return $this->db->delete($table, $where);
    }


    public function input($table, $data)
    {
        $this->db->insert($table, $data);
    }

    function hapus_data($where, $table)
    {
        $this->db->where($where);
        $this->db->delete($table);
    }

    function edit_data($where, $table)
    {
        return $this->db->get_where($table, $where);
    }

    function update_data($where, $data, $table)
    {
        $this->db->where($where);
        $this->db->update($table, $data);
    }

    function customer()
    {
        return $this->db->get('customer');
    }

    function tampil_pembelian()
    {
        return $this->db->get('orders');
    }

    public function totalinvoicehome()
    {
        $this->db->where('account', 'user');

        return $this->db->get('invoice');
    }

    public function totalinvoicemember()
    {
        $this->db->where('account', 'member');

        return $this->db->get('invoice');
    }

    public function invoicethismonth()
    {
        $invoicethismonth = $this->db->query("SELECT * FROM invoice WHERE MONTH(invoice.date) = '" . date('m') . "' AND YEAR(invoice.date) = '" . date('Y') . "'AND account ='user'");

        return $invoicethismonth->result();
    }

    public function invoicethismonthmember()
    {
        $invoicethismonth = $this->db->query("SELECT * FROM invoice WHERE MONTH(invoice.date) = '" . date('m') . "' AND YEAR(invoice.date) = '" . date('Y') . "'AND account ='member' ORDER by ID DESC");

        return $invoicethismonth->result();
    }

    public function invoiceprevmonth()
    {
        $invoiceprevmonth = $this->db->query("SELECT * FROM invoice WHERE MONTH(invoice.date) = '" . date('m', strtotime('-1 months')) . "' AND YEAR(invoice.date) = '" . date('Y') . "' AND account ='user'");

        return $invoiceprevmonth->result();
    }

    public function invoiceprevmonthmember()
    {
        $invoiceprevmonth = $this->db->query("SELECT * FROM invoice WHERE MONTH(invoice.date) = '" . date('m', strtotime('-1 months')) . "' AND YEAR(invoice.date) = '" . date('Y') . "' AND account ='member'");

        return $invoiceprevmonth->result();
    }

    function totalmonthpaid()
    {
        $totalmontpaid =  $this->db->query("SELECT * FROM invoice WHERE MONTH(invoice.date) = '" . date('m') . "' AND YEAR(invoice.date) = '" . date('Y') . "' AND status = 'Paid' AND account ='user'");

        return $totalmontpaid->num_rows();
    }

    function totalmonthpaidmembers()
    {
        $totalmontpaid =  $this->db->query("SELECT * FROM invoice WHERE MONTH(invoice.date) = '" . date('m') . "' AND YEAR(invoice.date) = '" . date('Y') . "' AND status = 'Paid' AND account ='members'");

        return $totalmontpaid->num_rows();
    }

    function totalmonthunpaid()
    {
        $totalmonthunpaid =  $this->db->query("SELECT * FROM invoice WHERE MONTH(invoice.date) = '" . date('m') . "' AND YEAR(invoice.date) = '" . date('Y') . "' AND status = 'Unpaid' AND account ='user'");

        return $totalmonthunpaid->num_rows();
    }

    function totalmonthunpaidmembers()
    {
        $totalmonthunpaid =  $this->db->query("SELECT * FROM invoice WHERE MONTH(invoice.date) = '" . date('m') . "' AND YEAR(invoice.date) = '" . date('Y') . "' AND status = 'Unpaid' AND account ='member'");

        return $totalmonthunpaid->num_rows();
    }

    public function prevmonthpaid()
    {
        $prevmonthpaid = $this->db->query("SELECT * FROM invoice WHERE MONTH(invoice.date) = '" . date('m', strtotime('-1 months')) . "' AND YEAR(invoice.date) = '" . date('Y') . "' AND status = 'Paid' AND account ='user'");
        return $prevmonthpaid->num_rows();
    }

    public function prevmonthpaidmember()
    {
        $prevmonthpaid = $this->db->query("SELECT * FROM invoice WHERE MONTH(invoice.date) = '" . date('m', strtotime('-1 months')) . "' AND YEAR(invoice.date) = '" . date('Y') . "' AND status = 'Paid' AND account ='member'");
        return $prevmonthpaid->num_rows();
    }

    public function prevmonthunpaid()
    {
        $prevmonthunpaid = $this->db->query("SELECT * FROM invoice WHERE MONTH(invoice.date) = '" . date('m', strtotime('-1 months')) . "' AND YEAR(invoice.date) = '" . date('Y') . "' AND status = 'Unpaid' AND account ='user'");
        return $prevmonthunpaid->num_rows();
    }

    public function prevmonthunpaidmember()
    {
        $prevmonthunpaid = $this->db->query("SELECT * FROM invoice WHERE MONTH(invoice.date) = '" . date('m', strtotime('-1 months')) . "' AND YEAR(invoice.date) = '" . date('Y') . "' AND status = 'Unpaid' AND account ='member'");
        return $prevmonthunpaid->num_rows();
    }

    public function useraktif()
    {
        $this->db->where('status', 'Active');

        $query = $this->db->get('orders');

        return $query;
    }

    public function userisolir()
    {
        $this->db->where('status', 'Isolir');

        $query = $this->db->get('orders');

        return $query;
    }

    public function cekcoupon($post)
    {
        $this->db->select('*');
        $this->db->from('invoice');
        $this->db->where('code_coupon', $post['code']);
        $this->db->where('idpel', $post['idpel']);
        $query = $this->db->get();
        return $query;
    }

    public function userend()
    {
        $this->db->where('status', 'Berhenti');

        $query = $this->db->get('orders');

        return $query;
    }

    public function report()
    {
        return $this->db->get('report')->result_array();
    }

    public function report_masuk()
    {
        return $this->db->query("SELECT * FROM invoice WHERE MONTH(invoice.expdate) = '" . date('m') . "' AND YEAR(invoice.expdate) = '" . date('Y') . "' AND status = 'Paid' ORDER BY date ASC")->result_array();
    }

    public function gettahunmasuk()
    {
        $query = $this->db->query("SELECT YEAR(date) AS tahun FROM invoice GROUP BY YEAR(date) ORDER BY YEAR(date) ASC");

        return $query->result();
    }

    public function gettahun()
    {
        $query = $this->db->query("SELECT YEAR(date) AS tahun FROM report GROUP BY YEAR(date) ORDER BY YEAR(date) ASC");

        return $query->result();
    }

    public function report_keluar()
    {
        return $this->db->query("SELECT * FROM report WHERE MONTH(report.date) = '" . date('m') . "' AND YEAR(report.date) = '" . date('Y') . "' AND category = 'Pengeluaran' ORDER BY date ASC")->result_array();
    }

    public function report_psb()
    {
        return $this->db->query("SELECT * FROM report WHERE MONTH(report.date) = '" . date('m') . "' AND YEAR(report.date) = '" . date('Y') . "' AND category = 'Pemasukan' ORDER BY date ASC")->result_array();
    }

    public function debit()
    {
        $debit = $this->db->query("SELECT SUM(balance) AS total FROM report WHERE MONTH(report.date) = '" . date('m') . "' AND YEAR(report.date) = '" . date('Y') . "' AND category = 'Pengeluaran'");
        return $debit->row()->total;
    }

    public function psb()
    {
        $psb = $this->db->query("SELECT SUM(balance) AS total FROM report WHERE MONTH(report.date) = '" . date('m') . "' AND YEAR(report.date) = '" . date('Y') . "' AND category = 'Pemasukan'");
        return $psb->row()->total;
    }

    public function credit()
    {
        $credit = $this->db->query("SELECT SUM(price) AS total FROM invoice WHERE MONTH(invoice.expdate) = '" . date('m') . "' AND YEAR(invoice.expdate) = '" . date('Y') . "' AND status = 'Paid'");
        return $credit->row()->total;
    }

    public function bersih()
    {
        $debit = $this->db->query("SELECT SUM(balance) AS total FROM report WHERE MONTH(report.date) = '" . date('m') . "' AND YEAR(report.date) = '" . date('Y') . "' AND category = 'Pengeluaran'");

        $credit = $this->db->query("SELECT SUM(price) AS total FROM invoice WHERE MONTH(invoice.expdate) = '" . date('m') . "' AND YEAR(invoice.expdate) = '" . date('Y') . "' AND status = 'Paid'");

        $psb = $this->db->query("SELECT SUM(balance) AS total FROM report WHERE MONTH(report.date) = '" . date('m') . "' AND YEAR(report.date) = '" . date('Y') . "' AND category = 'Pemasukan'");

        $bersih = $credit->row()->total + $psb->row()->total - $debit->row()->total;
        return $bersih;
    }


    public function orderBy($column, $order = 'asc')
    {
        $this->db->order_by($column, $order);
        return $this;
    }

    public function update_payment_method($status, $kode)
    {
        $table = 'payment_method';
        $this->db->select('payment_method');
        $this->db->set('status', $status);
        $this->db->where('provider_code', $kode);

        return $this->db->update($table);
    }
}
