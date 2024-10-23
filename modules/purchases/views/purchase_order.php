<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <?php echo form_open($this->uri->uri_string(), ['id' => 'purchase-order-form']); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <?php echo render_select('vendor_id', $vendors, ['id', 'company'], 'vendor', ''); ?>
                                <?php echo render_date_input('date', 'date', ''); ?>
                            </div>
                            <div class="col-md-6">
                                <?php echo render_input('po_number', 'purchase_order_number', '', 'text', ['readonly' => true]); ?>
                                <?php echo render_select('status', [
                                    ['id' => 'draft', 'name' => _l('draft')],
                                    ['id' => 'pending', 'name' => _l('pending')],
                                    ['id' => 'approved', 'name' => _l('approved')],
                                    ['id' => 'rejected', 'name' => _l('rejected')]
                                ], ['id', 'name'], 'status'); ?>
                            </div>
                        </div>
                        <div class="items">
                            <div class="table-responsive">
                                <table class="table items">
                                    <thead>
                                        <tr>
                                            <th><?php echo _l('item'); ?></th>
                                            <th><?php echo _l('description'); ?></th>
                                            <th><?php echo _l('qty'); ?></th>
                                            <th><?php echo _l('rate'); ?></th>
                                            <th><?php echo _l('tax'); ?></th>
                                            <th><?php echo _l('amount'); ?></th>
                                            <th><i class="fa fa-cog"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="main">
                                            <td><?php echo render_select('items[]', $items, ['id', 'description'], ''); ?></td>
                                            <td><?php echo render_textarea('description[]', '', ['rows' => 1]); ?></td>
                                            <td><?php echo render_input('qty[]', '', '', 'number'); ?></td>
                                            <td><?php echo render_input('rate[]', '', '', 'number'); ?></td>
                                            <td><?php echo render_input('tax[]', '', '', 'number'); ?></td>
                                            <td class="amount"></td>
                                            <td><button type="button" class="btn btn-danger remove-item"><i class="fa fa-trash"></i></button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" class="btn btn-info add-item"><i class="fa fa-plus"></i> <?php echo _l('add_item'); ?></button>
                        </div>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-4">
                                <table class="table text-right">
                                    <tbody>
                                        <tr>
                                            <td><span class="bold"><?php echo _l('subtotal'); ?></span></td>
                                            <td class="subtotal"></td>
                                        </tr>
                                        <tr>
                                            <td><span class="bold"><?php echo _l('tax'); ?></span></td>
                                            <td class="total-tax"></td>
                                        </tr>
                                        <tr>
                                            <td><span class="bold"><?php echo _l('total'); ?></span></td>
                                            <td class="total"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo render_textarea('notes', 'notes'); ?>
                                <div class="btn-bottom-toolbar text-right">
                                    <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
                                </div>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
$(function() {
    // Initialize purchase order form handling
    appValidateForm($('#purchase-order-form'), {
        vendor_id: 'required',
        date: 'required',
        status: 'required'
    });

    // Handle item calculations and dynamic rows
    $('.add-item').on('click', function() {
        var $clone = $('.items tbody tr.main:first').clone();
        $clone.find('input').val('');
        $('.items tbody').append($clone);
    });

    $(document).on('click', '.remove-item', function() {
        if ($('.items tbody tr').length > 1) {
            $(this).closest('tr').remove();
        }
        calculateTotals();
    });

    $(document).on('change', 'input[name="qty[]"], input[name="rate[]"], input[name="tax[]"]', function() {
        calculateTotals();
    });

    function calculateTotals() {
        var subtotal = 0;
        var totalTax = 0;

        $('.items tbody tr').each(function() {
            var qty = parseFloat($(this).find('input[name="qty[]"]').val()) || 0;
            var rate = parseFloat($(this).find('input[name="rate[]"]').val()) || 0;
            var tax = parseFloat($(this).find('input[name="tax[]"]').val()) || 0;

            var amount = qty * rate;
            var itemTax = (amount * tax) / 100;

            $(this).find('.amount').text(amount.toFixed(2));
            subtotal += amount;
            totalTax += itemTax;
        });

        var total = subtotal + totalTax;

        $('.subtotal').text(subtotal.toFixed(2));
        $('.total-tax').text(totalTax.toFixed(2));
        $('.total').text(total.toFixed(2));
    }
});
</script>