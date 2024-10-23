<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Purchases extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('purchases_model');
        $this->load->model('vendors_model');
    }

    public function index()
    {
        if (!has_permission('purchases_view')) {
            access_denied('purchases');
        }

        $data['title'] = _l('purchase_orders');
        $this->load->view('purchases/manage', $data);
    }

    public function purchase_order($id = '')
    {
        if (!has_permission('purchases_view')) {
            access_denied('purchases');
        }

        if ($this->input->post()) {
            if ($id == '') {
                if (!has_permission('purchases_create')) {
                    access_denied('purchases');
                }
                $id = $this->purchases_model->add_purchase_order($this->input->post());
                if ($id) {
                    set_alert('success', _l('added_successfully', _l('purchase_order')));
                    redirect(admin_url('purchases/purchase_order/' . $id));
                }
            } else {
                if (!has_permission('purchases_edit')) {
                    access_denied('purchases');
                }
                $success = $this->purchases_model->update_purchase_order($this->input->post(), $id);
                if ($success) {
                    set_alert('success', _l('updated_successfully', _l('purchase_order')));
                }
                redirect(admin_url('purchases/purchase_order/' . $id));
            }
        }

        if ($id == '') {
            $title = _l('add_new', _l('purchase_order_lowercase'));
        } else {
            $data['purchase_order'] = $this->purchases_model->get($id);
            $title = _l('edit', _l('purchase_order_lowercase'));
        }

        $data['vendors'] = $this->vendors_model->get();
        $data['items'] = $this->items_model->get();
        $data['title'] = $title;
        $this->load->view('purchases/purchase_order', $data);
    }
}