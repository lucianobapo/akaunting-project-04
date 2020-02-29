@push('stylesheet')
    <style type="text/css">
        .item-quantity-stock {
            float: right;
            margin-top: -20px;
        }
    </style>
@endpush

@push('js')
    <script type="text/javascript">
        $(document).on('click', '.form-control.typeahead', function(e) {
            e.preventDefault();
            e.stopPropagation();

            input_id = $(this).attr('id').split('-');

            item_id = parseInt(input_id[input_id.length-1]);

            $(this).typeahead({
                minLength: 3,
                displayText:function (data) {
                    return data.name + ' (' + data.sku + ')';
                },
                source: function (query, process) {
                    $.ajax({
                        url: '{{ route('inventory.invoice.item.autocomplete') }}',
                        type: 'GET',
                        dataType: 'JSON',
                        data: 'query=' + query + '&type=invoice&currency_code=' + $('#currency_code').val(),
                        success: function(data) {
                            return process(data);
                        }
                    });
                },
                afterSelect: function (data) {
                    $('#item-id-' + item_id).val(data.item_id);

                    $('#item-quantity-' + item_id).val('1');

                    if (data.stock) {
                        $('#item-quantity-' + item_id).after('<span id="item-quantity-stock-' + item_id + '" class="item-quantity-stock"></span>');

                        $(data.stock).each(function( index, element ) {
                            var stock = '</br>' + element.name + ' : ' + element.stock;

                            $('#item-quantity-stock-' + item_id).append(stock);
                        });

                        $('#item-quantity-' + item_id).parent().css('width', '20%');
                        $('#item-quantity-' + item_id).css('float', 'left');
                    }

                    $('#item-price-' + item_id).val(data.sale_price);
                    $('#item-tax-' + item_id).val(data.tax_id);

                    // This event Select2 Stylesheet
                    $('#item-price-' + item_id).trigger('focusout');
                    $('#item-tax-' + item_id).trigger('change');

                    $('#item-total-' + item_id).html(data.total);

                    totalItem();
                }
            });
        });
    </script>
@endpush
