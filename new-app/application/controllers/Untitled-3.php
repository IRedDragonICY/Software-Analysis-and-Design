<?php defined('BASEPATH') or exit('No direct script access allowed');

class Coupon_m extends CI_Model
{

    public function get($id = null)
    {
        $this->db->select('*');
        $this->db->from('coupon');
        $this->db->order_by('created', 'desc');
        if ($id != null) {
            $this->db->where('coupon_id', $id);
        }
        $query = $this->db->get();
        return $query;
    }
    public function cekcoupon($post)
    {
        $this->db->select('*');
        $this->db->from('invoice');
        $this->db->where('code_coupon', $post['code']);
        $this->db->where('no_services', $post['no_services']);
        $query = $this->db->get();
        return $query;
    }

    public function add($post)
    {
        $params = [
            'code' => $post['code'],
            'is_active' => $post['is_active'],
            'one_time' => $post['one_time'],
            'percent' => $post['percent'],
            'remark' => $post['remark'],
            'created' => time(),

        ];

        $this->db->insert('coupon', $params);
    }
    public function edit($post)
    {
        $params = [
            'code' => $post['code'],
            'is_active' => $post['is_active'],
            'one_time' => $post['one_time'],
            'percent' => $post['percent'],
            'remark' => $post['remark'],
            'created' => time(),

        ];

        $this->db->where('coupon_id', $post['coupon_id']);
        $this->db->update('coupon', $params);
    }
    public function del($id)
    {
        $this->db->where('coupon_id', $id);
        $this->db->delete('coupon');
    }
}
v