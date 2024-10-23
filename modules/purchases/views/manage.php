<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <div class="_buttons">
                            <?php if (has_permission('purchases_create')) { ?>
                            <a href="<?php echo admin_url('purchases/purchase_order'); ?>" class="btn btn-info pull-left display-block">
                                <?php echo _l('new_purchase_order'); ?>
                            </a>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                        <hr class="hr-panel-heading" />
                        <div class="clearfix"></div>
                        <?php render_datatable([
                            _l('purchase_order_number'),
                            _l('vendor'),
                            _l('date'),
                            _l('status'),
                            _l('total'),
                            _l('options')
                        ], 'purchase-orders'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
<script>
$(function() {
    initDataTable('.table-purchase-orders', window.location.href);
});
</script>