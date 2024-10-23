<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Purchases_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id = '')
    {
        if (is_numeric($id)) {
            $this->db->where('id', $id);
            return $this->db->get('tblpurchase_orders')->row();
        }

        return $this->db->get('tblpurchase_orders')->result_array();
    }

    public function add_purchase_order($data)
    {
        $data['created_by'] = get_staff_user_id();
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->db->insert('tblpurchase_orders', $data);
        $insert_id = $this->db->insert_id();

        if ($insert_id) {
            // Add items
            $this->add_purchase_items($data['items'], $insert_id);
            log_activity('New Purchase Order Created [ID: ' . $insert_id . ']');
        }

        return $insert_id;
    }

    public function update_purchase_order($data, $id)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $this->db->update('tblpurchase_orders', $data);

        if ($this->db->affected_rows() > 0) {
            // Update items
            $this->update_purchase_items($data['items'], $id);
            log_activity('Purchase Order Updated [ID: ' . $id . ']');
            return true;
        }

        return false;
    }

    private function add_purchase_items($items, $purchase_order_id)
    {
        foreach ($items as $item) {
            $item['purchase_order_id'] = $purchase_order_id;
            $this->db->insert('tblpurchase_items', $item);
        }
    }

    private function update_purchase_items($items, $purchase_order_id)
    {
        $this->db->where('purchase_order_id', $purchase_order_id);
        $this->db->delete('tblpurchase_items');

        $this->add_purchase_items($items, $purchase_order_id);
    }
}