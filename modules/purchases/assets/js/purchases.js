$(function() {
    // Initialize datatables
    var purchaseOrdersTable = $('.table-purchase-orders').DataTable({
        "ajax": {
            "url": admin_url + "purchases/table",
            "type": "GET",
            "dataType": "json",
            "data": function(d) {}
        },
        "columns": [
            { "data": "po_number" },
            { "data": "vendor" },
            { "data": "date" },
            { "data": "status" },
            { "data": "total" },
            { "data": "options", "orderable": false }
        ]
    });

    // Handle purchase order form submissions
    $('#purchase-order-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var data = form.serialize();
        
        $.post(form.attr('action'), data).done(function(response) {
            response = JSON.parse(response);
            if (response.success) {
                alert_float('success', response.message);
                if (typeof(response.id) !== 'undefined') {
                    window.location.href = admin_url + 'purchases/purchase_order/' + response.id;
                } else {
                    window.location.reload();
                }
            }
        });
    });
});