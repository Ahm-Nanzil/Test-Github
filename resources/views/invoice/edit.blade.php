@extends('layouts.main')
@section('page-title')
    {{ __('Invoice Edit') }}
@endsection
@section('page-breadcrumb')
    {{ __('Invoice Edit') }}
@endsection
@push('scripts')
    <script src="{{ asset('public/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('public/js/jquery.repeater.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("input[name='invoice_type_radio']:checked").trigger('change');
        });

        $(document).on('click', '[data-repeater-delete]', function() {
            var el = $(this).parent().parent();
            var id = $(el.find('.id')).val();

            $.ajax({
                url: '{{ route('invoice.product.destroy') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('#token').val()
                },
                data: {
                    'id': id
                },
                cache: false,
                success: function(data) {
                    if (data.error) {
                        toastrs('Error', data.error, 'error');
                    } else {
                        toastrs('Success', data.success, 'success');
                    }
                },
                error: function(data) {
                    toastrs('Error', '{{ __('something went wrong please try again') }}', 'error');
                },
            });
        });
        $(document).on('change', '#customer', function() {
            $('#customer_detail').removeClass('d-none');
            $('#customer_detail').addClass('d-block');
            $('#customer-box').addClass('d-none');
            var id = $(this).val();
            var url = $(this).data('url');
            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery('#token').val()
                },
                data: {
                    'id': id
                },
                cache: false,
                success: function(data) {
                    if (data != '') {
                        $('#customer_detail').html(data);
                    } else {
                        $('#customer-box').removeClass('d-none');
                        $('#customer_detail').removeClass('d-block');
                        $('#customer_detail').addClass('d-none');
                    }

                },

            });
        });

        $(document).on('click', '#remove', function() {
            $('#customer-box').removeClass('d-none');


            $('#customer_detail').removeClass('d-block');
            $('#customer_detail').addClass('d-none');
        })
    </script>
    <Script>
        $(document).on('keyup', '.quantity', function() {
            var quntityTotalTaxPrice = 0;

            var el = $(this).parent().parent().parent().parent();

            var quantity = $(this).val();
            var price = $(el.find('.price')).val();
            var discount = $(el.find('.discount')).val();
            if (discount.length <= 0) {
                discount = 0;
            }

            var totalItemPrice = (quantity * price) - discount;

            var amount = (totalItemPrice);


            var totalItemTaxRate = $(el.find('.itemTaxRate')).val();
            var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (totalItemPrice));
            $(el.find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));

            $(el.find('.amount')).html(parseFloat(itemTaxPrice) + parseFloat(amount));

            var totalItemTaxPrice = 0;
            var itemTaxPriceInput = $('.itemTaxPrice');
            for (var j = 0; j < itemTaxPriceInput.length; j++) {
                totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
            }


            var totalItemPrice = 0;
            var inputs_quantity = $(".quantity");

            var priceInput = $('.price');
            for (var j = 0; j < priceInput.length; j++) {
                totalItemPrice += (parseFloat(priceInput[j].value) * parseFloat(inputs_quantity[j].value));
            }

            var inputs = $(".amount");

            var subTotal = 0;
            for (var i = 0; i < inputs.length; i++) {
                subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
            }

            $('.subTotal').html(totalItemPrice.toFixed(2));
            $('.totalTax').html(totalItemTaxPrice.toFixed(2));

            $('.totalAmount').html((parseFloat(subTotal)).toFixed(2));
        })

        $(document).on('keyup change', '.price', function() {
            var el = $(this).parent().parent().parent().parent();
            var price = $(this).val();
            var quantity = $(el.find('.quantity')).val();
            if (quantity.length <= 0) {
                quantity = 1;
            }
            var discount = $(el.find('.discount')).val();
            if (discount.length <= 0) {
                discount = 0;
            }
            var totalItemPrice = (quantity * price) - discount;

            var amount = (totalItemPrice);

            var totalItemTaxRate = $(el.find('.itemTaxRate')).val();
            var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (totalItemPrice));
            $(el.find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));

            $(el.find('.amount')).html(parseFloat(itemTaxPrice) + parseFloat(amount));

            var totalItemTaxPrice = 0;
            var itemTaxPriceInput = $('.itemTaxPrice');
            for (var j = 0; j < itemTaxPriceInput.length; j++) {
                totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
            }


            var totalItemPrice = 0;
            var inputs_quantity = $(".quantity");
            var priceInput = $('.price');
            for (var j = 0; j < priceInput.length; j++) {
                if (inputs_quantity[j].value <= 0) {
                    inputs_quantity[j].value = 1;
                }
                totalItemPrice += (parseFloat(priceInput[j].value) * parseFloat(inputs_quantity[j].value));
            }

            var inputs = $(".amount");

            var subTotal = 0;
            for (var i = 0; i < inputs.length; i++) {
                subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
            }

            $('.subTotal').html(totalItemPrice.toFixed(2));
            $('.totalTax').html(totalItemTaxPrice.toFixed(2));

            $('.totalAmount').html((parseFloat(subTotal)).toFixed(2));
        })

        $(document).on('keyup change', '.discount', function() {
            var el = $(this).parent().parent().parent();
            var discount = $(this).val();
            if (discount.length <= 0) {
                discount = 0;
            }

            var price = $(el.find('.price')).val();
            var quantity = $(el.find('.quantity')).val();
            var totalItemPrice = (quantity * price) - discount;


            var amount = (totalItemPrice);


            var totalItemTaxRate = $(el.find('.itemTaxRate')).val();
            var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (totalItemPrice));
            $(el.find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));

            $(el.find('.amount')).html(parseFloat(itemTaxPrice) + parseFloat(amount));

            var totalItemTaxPrice = 0;
            var itemTaxPriceInput = $('.itemTaxPrice');
            for (var j = 0; j < itemTaxPriceInput.length; j++) {
                totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
            }


            var totalItemPrice = 0;
            var inputs_quantity = $(".quantity");

            var priceInput = $('.price');
            for (var j = 0; j < priceInput.length; j++) {
                totalItemPrice += (parseFloat(priceInput[j].value) * parseFloat(inputs_quantity[j].value));
            }

            var inputs = $(".amount");

            var subTotal = 0;
            for (var i = 0; i < inputs.length; i++) {
                subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
            }


            var totalItemDiscountPrice = 0;
            var itemDiscountPriceInput = $('.discount');

            for (var k = 0; k < itemDiscountPriceInput.length; k++) {
                if (itemDiscountPriceInput[k].value == '') {
                    itemDiscountPriceInput[k].value = parseFloat(0);
                }
                totalItemDiscountPrice += parseFloat(itemDiscountPriceInput[k].value);
            }


            $('.subTotal').html(totalItemPrice.toFixed(2));
            $('.totalTax').html(totalItemTaxPrice.toFixed(2));

            $('.totalAmount').html((parseFloat(subTotal)).toFixed(2));
            $('.totalDiscount').html(totalItemDiscountPrice.toFixed(2));
        })
    </Script>
    @if (module_is_active('Account'))
        <script>
            $(document).on('change', '.item', function() {
                items($(this));
            });

            function items(data) {
                var in_type = $('#invoice_type').val();
                if (in_type == 'product') {
                    var iteams_id = data.val();
                    var url = data.data('url');
                    var el = data;
                    $.ajax({
                        url: url,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': jQuery('#token').val()
                        },
                        data: {
                            'product_id': iteams_id
                        },
                        cache: false,
                        success: function(data) {
                            var item = JSON.parse(data);
                            $(el.parent().parent().find('.quantity')).val(1);
                            if (item.product != null) {
                                $(el.parent().parent().find('.price')).val(item.product.sale_price);
                                $(el.parent().parent().parent().find('.pro_description')).val(item.product
                                    .description);

                            } else {
                                $(el.parent().parent().find('.price')).val(0);
                                $(el.parent().parent().parent().find('.pro_description')).val('');

                            }
                            var taxes = '';
                            var tax = [];

                            var totalItemTaxRate = 0;

                            if (item.taxes == 0) {
                                taxes += '-';
                            } else {
                                for (var i = 0; i < item.taxes.length; i++) {
                                    taxes += '<span class="badge bg-primary p-2 px-3 rounded mt-1 mr-1">' +
                                        item.taxes[i].name + ' ' + '(' + item.taxes[i].rate + '%)' +
                                        '</span>';
                                    tax.push(item.taxes[i].id);
                                    totalItemTaxRate += parseFloat(item.taxes[i].rate);
                                }
                            }
                            var itemTaxPrice = 0;
                            if (item.product != null) {
                                var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (item.product
                                    .sale_price * 1));
                            }
                            $(el.parent().parent().find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));
                            $(el.parent().parent().find('.itemTaxRate')).val(totalItemTaxRate.toFixed(2));
                            $(el.parent().parent().find('.taxes')).html(taxes);
                            $(el.parent().parent().find('.tax')).val(tax);
                            $(el.parent().parent().find('.unit')).html(item.unit);
                            $(el.parent().parent().find('.discount')).val(0);
                            $(el.parent().parent().find('.amount')).html(item.totalAmount);


                            var inputs = $(".amount");
                            var subTotal = 0;
                            for (var i = 0; i < inputs.length; i++) {
                                subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
                            }

                            var totalItemPrice = 0;
                            var priceInput = $('.price');
                            for (var j = 0; j < priceInput.length; j++) {
                                totalItemPrice += parseFloat(priceInput[j].value);
                            }

                            var totalItemTaxPrice = 0;
                            var itemTaxPriceInput = $('.itemTaxPrice');
                            for (var j = 0; j < itemTaxPriceInput.length; j++) {
                                totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
                                if (item.product != null) {
                                    $(el.parent().parent().find('.amount')).html(parseFloat(item.totalAmount) +
                                        parseFloat(itemTaxPriceInput[j].value));
                                }
                            }

                            var totalItemDiscountPrice = 0;
                            var itemDiscountPriceInput = $('.discount');

                            for (var k = 0; k < itemDiscountPriceInput.length; k++) {

                                totalItemDiscountPrice += parseFloat(itemDiscountPriceInput[k].value);
                            }

                            $('.subTotal').html(totalItemPrice.toFixed(2));
                            $('.totalTax').html(totalItemTaxPrice.toFixed(2));
                            $('.totalAmount').html((parseFloat(totalItemPrice) - parseFloat(
                                totalItemDiscountPrice) + parseFloat(totalItemTaxPrice)).toFixed(2));

                        },
                    });
                }
            }
        </script>
    @endif
    @if (module_is_active('Taskly'))
        <script>
            $(document).on('change', '.item', function() {
                var iteams_id = $(this).val();
                var el = $(this);
                $(el.parent().parent().find('.price')).val(0);
                $(el.parent().parent().find('.amount')).html(0);
                $(el.parent().parent().find('.taxes')).val(0);
                var invoice_type = $("#invoice_type").val();
                if (invoice_type == 'project') {
                    $("#tax_project").change();
                }
            });

            $(document).on('change', '#tax_project', function() {
                var tax_id = $(this).val();
                if (tax_id.length != 0) {
                    $.ajax({
                        type: 'post',
                        url: "{{ route('get.taxes') }}",
                        data: {
                            _token: "{{ csrf_token() }}",
                            tax_id: tax_id,
                        },
                        beforeSend: function() {
                            $("#loader").removeClass('d-none');
                        },
                        success: function(response) {
                            var response = jQuery.parseJSON(response);
                            if (response != null) {
                                $("#loader").addClass('d-none');
                                var TaxRate = 0;
                                if (response.length > 0) {
                                    $.each(response, function(i) {
                                        TaxRate = parseInt(response[i]['rate']) + TaxRate;
                                    });
                                }
                                $(".itemTaxRate").val(TaxRate);
                                $(".price").change();
                            } else {
                                $(".itemTaxRate").val(0);
                                $(".price").change();
                                $('.section_div').html('');
                                toastrs('Error', 'Something went wrong please try again !', 'error');
                            }
                        },
                    });
                } else {
                    $(".itemTaxRate").val(0);
                    $('.taxes').html("");
                    $(".price").change();
                    $("#loader").addClass('d-none');
                }
            });
        </script>
    @endif
    @if (module_is_active('CMMS'))
        <script>
            $(document).on('change', '.item', function() {

                items($(this));
            });

            function items(data) {
                var in_type = $('#invoice_type').val();
                if (in_type == 'parts') {
                    var iteams_id = data.val();

                    var url = data.data('url');
                    var el = data;
                    $.ajax({
                        url: url,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': jQuery('#token').val()
                        },
                        data: {
                            'product_id': iteams_id
                        },
                        cache: false,
                        success: function(data) {
                            var item = JSON.parse(data);
                            $(el.parent().parent().find('.quantity')).val(1);
                            if (item.product != null) {
                                $(el.parent().parent().find('.price')).val(item.product.sale_price);
                                $(el.parent().parent().parent().find('.pro_description')).val(item.product
                                    .description);

                            } else {
                                $(el.parent().parent().find('.price')).val(0);
                                $(el.parent().parent().parent().find('.pro_description')).val('');

                            }

                            var taxes = '';
                            var tax = [];

                            var totalItemTaxRate = 0;

                            if (item.taxes == 0) {
                                taxes += '-';
                            } else {
                                for (var i = 0; i < item.taxes.length; i++) {
                                    taxes += '<span class="badge bg-primary p-2 px-3 rounded mt-1 me-1">' +
                                        item.taxes[i].name + ' ' + '(' + item.taxes[i].rate + '%)' +
                                        '</span>';
                                    tax.push(item.taxes[i].id);
                                    totalItemTaxRate += parseFloat(item.taxes[i].rate);
                                }
                            }
                            var itemTaxPrice = 0;
                            if (item.product != null) {
                                var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (item.product
                                    .sale_price * 1));
                            }
                            $(el.parent().parent().find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));
                            $(el.parent().parent().find('.itemTaxRate')).val(totalItemTaxRate.toFixed(2));
                            $(el.parent().parent().find('.taxes')).html(taxes);
                            $(el.parent().parent().find('.tax')).val(tax);
                            $(el.parent().parent().find('.unit')).html(item.unit);
                            $(el.parent().parent().find('.discount')).val(0);
                            $(el.parent().parent().find('.amount')).html(item.totalAmount);


                            var inputs = $(".amount");
                            var subTotal = 0;
                            for (var i = 0; i < inputs.length; i++) {
                                subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
                            }

                            var totalItemPrice = 0;
                            var priceInput = $('.price');
                            for (var j = 0; j < priceInput.length; j++) {
                                totalItemPrice += parseFloat(priceInput[j].value);
                            }

                            var totalItemTaxPrice = 0;
                            var itemTaxPriceInput = $('.itemTaxPrice');
                            for (var j = 0; j < itemTaxPriceInput.length; j++) {
                                totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
                                if (item.product != null) {
                                    $(el.parent().parent().find('.amount')).html(parseFloat(item.totalAmount) +
                                        parseFloat(itemTaxPriceInput[j].value));
                                }
                            }



                            var totalItemDiscountPrice = 0;
                            var itemDiscountPriceInput = $('.discount');

                            for (var k = 0; k < itemDiscountPriceInput.length; k++) {

                                totalItemDiscountPrice += parseFloat(itemDiscountPriceInput[k].value);
                            }

                            $('.subTotal').html(totalItemPrice.toFixed(2));
                            $('.totalTax').html(totalItemTaxPrice.toFixed(2));
                            $('.totalAmount').html((parseFloat(totalItemPrice) - parseFloat(
                                totalItemDiscountPrice) + parseFloat(totalItemTaxPrice)).toFixed(2));

                        },
                    });
                }
            }
        </script>
    @endif
    @if ( module_is_active('RentalManagement'))
    <script>
        $(document).on('change', '.item', function() {

            items($(this));
        });

        function items(data) {
            var in_type = $('#invoice_type').val();
            if (in_type == 'rent') {
                var iteams_id = data.val();

                var url = data.data('url');
                var el = data;
                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': jQuery('#token').val()
                    },
                    data: {
                        'product_id': iteams_id
                    },
                    cache: false,
                    success: function(data) {
                        var item = JSON.parse(data);
                        $(el.parent().parent().find('.quantity')).val(1);
                        if (item.product != null) {
                            $(el.parent().parent().find('.price')).val(item.product.sale_price);
                            $(el.parent().parent().parent().find('.pro_description')).val(item.product
                                .description);

                        } else {
                            $(el.parent().parent().find('.price')).val(0);
                            $(el.parent().parent().parent().find('.pro_description')).val('');

                        }

                        var taxes = '';
                        var tax = [];

                        var totalItemTaxRate = 0;

                        if (item.taxes == 0) {
                            taxes += '-';
                        } else {
                            for (var i = 0; i < item.taxes.length; i++) {
                                taxes += '<span class="badge bg-primary p-2 px-3 rounded mt-1 me-1">' +
                                    item.taxes[i].name + ' ' + '(' + item.taxes[i].rate + '%)' +
                                    '</span>';
                                tax.push(item.taxes[i].id);
                                totalItemTaxRate += parseFloat(item.taxes[i].rate);
                            }
                        }
                        var itemTaxPrice = 0;
                        if (item.product != null) {
                            var itemTaxPrice = parseFloat((totalItemTaxRate / 100) * (item.product
                                .sale_price * 1));
                        }
                        $(el.parent().parent().find('.itemTaxPrice')).val(itemTaxPrice.toFixed(2));
                        $(el.parent().parent().find('.itemTaxRate')).val(totalItemTaxRate.toFixed(2));
                        $(el.parent().parent().find('.taxes')).html(taxes);
                        $(el.parent().parent().find('.tax')).val(tax);
                        $(el.parent().parent().find('.unit')).html(item.unit);
                        $(el.parent().parent().find('.discount')).val(0);
                        $(el.parent().parent().find('.amount')).html(item.totalAmount);


                        var inputs = $(".amount");
                        var subTotal = 0;
                        for (var i = 0; i < inputs.length; i++) {
                            subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
                        }

                        var totalItemPrice = 0;
                        var priceInput = $('.price');
                        for (var j = 0; j < priceInput.length; j++) {
                            totalItemPrice += parseFloat(priceInput[j].value);
                        }

                        var totalItemTaxPrice = 0;
                        var itemTaxPriceInput = $('.itemTaxPrice');
                        for (var j = 0; j < itemTaxPriceInput.length; j++) {
                            totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
                            if (item.product != null) {
                                $(el.parent().parent().find('.amount')).html(parseFloat(item.totalAmount) +
                                    parseFloat(itemTaxPriceInput[j].value));
                            }
                        }



                        var totalItemDiscountPrice = 0;
                        var itemDiscountPriceInput = $('.discount');

                        for (var k = 0; k < itemDiscountPriceInput.length; k++) {

                            totalItemDiscountPrice += parseFloat(itemDiscountPriceInput[k].value);
                        }

                        $('.subTotal').html(totalItemPrice.toFixed(2));
                        $('.totalTax').html(totalItemTaxPrice.toFixed(2));
                        $('.totalAmount').html((parseFloat(totalItemPrice) - parseFloat(
                            totalItemDiscountPrice) + parseFloat(totalItemTaxPrice)).toFixed(2));

                    },
                });
            }
        }
    </script>
    @endif
        <script>
            $(document).on('change', "[name='invoice_type_radio']", function() {
                var val = $(this).val();
                $(".invoice_div").empty();
                var invoice_module = '{{ $invoice->invoice_module }}';

                if (val == 'product') {
                    $(".discount_apply_div").removeClass('d-none');
                    $(".tax_project_div").addClass('d-none');
                    $(".discount_project_div").addClass('d-none');

                    var label =
                        `{{ Form::label('category_id', __('Category'), ['class' => 'form-label']) }} {{ Form::select('category_id', $category, null, ['class' => 'form-control', 'required' => 'required']) }}`;
                    $(".invoice_div").append(label);
                    $("#invoice_type").val('product');

                    if (invoice_module == 'account') {
                        $("#acction_type").val('edit');
                    } else {
                        $("#acction_type").val('create');
                    }
                    SectionGet(val);
                } else if (val == 'project') {
                    $(".discount_apply_div").addClass('d-none');
                    $(".tax_project_div").removeClass('d-none');
                    $(".discount_project_div").removeClass('d-none');

                    var label =
                        ` {{ Form::label('project', __('Project'), ['class' => 'form-label']) }} {{ Form::select('project', $projects, $invoice->category_id, ['class' => 'form-control', 'required' => 'required']) }}`
                    $(".invoice_div").append(label);
                    $("#invoice_type").val('project');
                    var project_id = $("#project").val();

                    if (invoice_module == 'taskly') {
                        $("#acction_type").val('edit');
                    } else {
                        $("#acction_type").val('create');
                    }

                    SectionGet(val, project_id);
                } else if (val == 'parts') {
                    $(".discount_apply_div").addClass('d-none');
                    $(".tax_project_div").addClass('d-none');
                    $(".discount_project_div").addClass('d-none');

                    var label =
                        ` {{ Form::label('work_order', __('Work Orders'), ['class' => 'form-label']) }} {{ Form::select('work_order', $work_order, null, ['class' => 'form-control', 'required' => 'required']) }}`
                    $(".invoice_div").append(label);
                    $("#invoice_type").val('parts');
                    SectionGet(val);
                } else if (val == 'rent') {
                    $(".discount_apply_div").addClass('d-none');
                    $(".tax_project_div").addClass('d-none');
                    $(".discount_project_div").addClass('d-none');

                    var label =
                        ` {{ Form::label('rent_type', __('Rent Type'), ['class' => 'form-label']) }} {{ Form::select('rent_type', $rent_type, null, ['class' => 'form-control', 'required' => 'required','onchange' => 'Calculate()']) }}`
                        $(".invoice_div").append(label);
                        $("#invoice_type").val('rent');
                    SectionGet(val);
                    Calculate();
                }


                choices();
            });

            function SectionGet(type = 'product', project_id = "0", title = 'Project') {
                var acction = $("#acction_type").val();

                $.ajax({
                    type: 'post',
                    url: "{{ route('invoice.section.type') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        type: type,
                        project_id: project_id,
                        acction: acction,
                        invoice_id: {{ $invoice->id }},
                    },
                    beforeSend: function() {
                        $("#loader").removeClass('d-none');
                    },
                    success: function(response) {
                        if (response != false) {
                            $('.section_div').html(response.html);
                            $("#loader").addClass('d-none');
                            $('.pro_name').text(title)
                            // for item SearchBox ( this function is  custom Js )
                            JsSearchBox();
                        } else {
                            $('.section_div').html('');
                            toastrs('Error', 'Something went wrong please try again !', 'error');
                        }
                    },
                });
            }
            $(document).on('change', "#project", function() {
                var title = $(this).find('option:selected').text();
                var project_id = $(this).val();
                SectionGet('project', project_id, title);

            });
        </script>

    @if (module_is_active('Account') && $invoice->invoice_module == 'account')

        <script>
            $(document).ready(function() {
                $('.project_id').addClass('d-none');
                $('.tax_project_div').addClass('d-none');
                $('.work_order').addClass('d-none');
                $('.rent_type').addClass('d-none');
                SectionGet('product');
            });
        </script>
    @elseif (module_is_active('Taskly') && $invoice->invoice_module == 'taskly')
        <script>
            $(document).ready(function() {
                $('.tax_project_div').removeClass('d-none');
                $('.category_id').addClass('d-none');
                $('.project_id').addClass('d-block');
                $('.work_order').addClass('d-none');
                $('.rent_type').addClass('d-none');
                $("#project").trigger("change");
                SectionGet('project');
            });
        </script>
    @elseif (module_is_active('CMMS') && $invoice->invoice_module == 'cmms')
        <script>
            $(document).ready(function() {
                $('.category_id').addClass('d-none');
                $('.project_id').addClass('d-none');
                $('.rent_type').addClass('d-none');
                SectionGet('parts');
            });
        </script>
     @elseif (module_is_active('RentalManagement') && $invoice->invoice_module == 'rent')
     <script>
        $(document).ready(function() {
               $('.category_id').addClass('d-none');
               $('.project_id').addClass('d-none');
               $('.tax_project_div').addClass('d-none');
               $('.work_order').addClass('d-none');
               SectionGet('rent');
               Calculate();
           });
       </script>
    @endif
    <script>
        setTimeout(() => {
            $('#due_date').trigger('click');
        }, 1500);
    </script>
@endpush
@section('content')
    <div class="row">
        {{ Form::model($invoice, ['route' => ['invoice.update', $invoice->id], 'method' => 'PUT', 'class' => 'w-100', 'enctype' => 'multipart/form-data']) }}
        @if ($invoice->invoice_module == 'account')
            <input type="hidden" name="invoice_type" id="invoice_type" value="product">
        @elseif ($invoice->invoice_module == 'taskly')
            <input type="hidden" name="invoice_type" id="invoice_type" value="project">
        @elseif ($invoice->invoice_module == 'cmms')
            <input type="hidden" name="invoice_type" id="invoice_type" value="parts">
        @elseif ($invoice->invoice_module == 'rent')
            <input type="hidden" name="invoice_type" id="invoice_type" value="rent">
        @endif
        <input type="hidden" name="acction_type" id="acction_type" value="edit">
        <div class="col-12">
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="row" id="customer-box">
                                <div class="form-group col-md-6" id="account-box">
                                    <label class="require form-label">{{ __('Account Type') }}</label>
                                    <select
                                        class="form-control {{ !empty($errors->first('account_type')) ? 'is-invalid' : '' }}"
                                        name="account_type" required="" id="account_type">
                                        <option value="">{{ __('Select Account Type') }}</option>
                                        @if (module_is_active('Account'))
                                        <option value="Accounting" @if ($invoice->account_type == 'Accounting') selected @endif>
                                            {{ __('Accounting') }}</option>
                                        @endif
                                        @if (module_is_active('Taskly'))
                                        <option value="Projects" @if ($invoice->account_type == 'Projects') selected @endif>
                                            {{ __('Projects') }}</option>
                                        @endif

                                        @if (module_is_active('CMMS'))
                                            <option value="Parts" @if ($invoice->account_type == 'Parts') selected @endif>
                                                {{ __('CMMS') }}</option>
                                        @endif
                                        @if (module_is_active('RentalManagement'))
                                        <option value="Rental" @if ($invoice->account_type == 'Rental') selected @endif>
                                            {{ __('Rental') }}</option>
                                        @endif

                                    </select>
                                    <p class="text-danger d-none" id="account_validation">
                                        {{ __('Account Type field is required.') }}</p>

                                </div>
                                <div class="form-group col-md-6">
                                    {{ Form::label('customer_id', __('Customer'), ['class' => 'form-label']) }}
                                    {{ Form::select('customer_id', $customers, !empty($invoice->user_id) ? $invoice->user_id : null, ['class' => 'form-control ', 'id' => 'customer', 'data-url' => route('invoice.customer'), 'required' => 'required', 'placeholder' => 'Select Customer']) }}
                                </div>
                            </div>
                            <div id="customer_detail" class="d-none">
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="row">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="form-group col-md-6">
                                                <label class="require form-label">{{ __('Billing Type') }}</label>
                                                <select
                                                    class="form-control {{ !empty($errors->first('Billing Type')) ? 'is-invalid' : '' }}"
                                                    name="invoice_type_radio" required="" id="billing_type">
                                                    @if (module_is_active('Account') )
                                                    <option value="product"
                                                        @if ($invoice->invoice_module == 'account') selected @endif>
                                                        {{ __('Item Wise') }}</option>
                                                    @endif
                                                    @if (module_is_active('Taskly'))

                                                    <option value="project"
                                                        @if ($invoice->invoice_module == 'taskly') selected @endif>
                                                        {{ __('Project Wise') }}</option>
                                                    @endif
                                                    @if (module_is_active('CMMS'))
                                                    <option value="parts"
                                                        @if ($invoice->invoice_module == 'cmms') selected @endif>
                                                        {{ __('Parts Wise') }}</option>
                                                    @endif
                                                    @if (module_is_active('RentalManagement'))
                                                    <option value="rent"
                                                        @if ($invoice->invoice_module == 'rent') selected @endif>
                                                        {{ __('Rent Wise') }}</option>
                                                    @endif

                                                </select>
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('billing_type') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('issue_date', __('Issue Date'), ['class' => 'form-label']) }}
                                        <div class="form-icon-user">
                                            {{ Form::date('issue_date', null, ['class' => 'form-control ', 'required' => 'required', 'placeholder' => 'Select Customer','onchange' => 'Calculate()']) }}

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('due_date', __('Due Date'), ['class' => 'form-label']) }}
                                        <div class="form-icon-user">
                                            {{ Form::date('due_date', null, ['class' => 'form-control ', 'required' => 'required', 'placeholder' => 'Select Customer']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group invoice_div">
                                        @if (module_is_active('Account'))
                                            {{ Form::label('category_id', __('Category'), ['class' => 'form-label category_id']) }}
                                            {{ Form::select('category_id', $category, null, ['class' => 'form-control category_id', 'required' => 'required']) }}
                                        @endif
                                        @if (module_is_active('Taskly'))
                                            {{ Form::label('project', __('Project'), ['class' => 'form-label project_id']) }}
                                            {{ Form::select('project', $projects, $invoice->category_id, ['class' => 'form-control project_id', 'required' => 'required']) }}
                                        @endif
                                        @if (module_is_active('CMMS'))
                                            {{ Form::label('work_order', __('Work Orders'), ['class' => 'form-label work_order']) }}
                                            {{ Form::select('work_order', $work_order, null, ['class' => 'form-control work_order', 'required' => 'required']) }}
                                        @endif
                                        @if (module_is_active('RentalManagement'))
                                        {{ Form::label('rent_type', __('Rent Type'), ['class' => 'form-label']) }}
                                        {{ Form::select('rent_type', $rent_type, null, ['class' => 'form-control rent_type ', 'required' => 'required','onchange' => 'Calculate()']) }}

                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('invoice_number', __('Invoice Number'), ['class' => 'form-label']) }}
                                        <div class="form-icon-user">
                                            <input type="text" class="form-control" value="{{ $invoice_number }}"
                                                readonly>
                                        </div>
                                    </div>
                                </div>

                                @if (module_is_active('Taskly'))
                                    <div
                                        class="col-md-6 tax_project_div {{ module_is_active('Account') || module_is_active('CMMS') ? 'd-none' : '' }}">
                                        <div class="form-group">
                                            {{ Form::label('tax_project', __('Tax'), ['class' => 'form-label']) }}
                                            {{ Form::select('tax_project[]', $taxs, !empty($invoice->items->first()->tax) ? explode(',', $invoice->items->first()->tax) : null, ['class' => 'form-control get_tax multi-select choices', 'multiple' => 'multiple', 'id' => 'tax_project', 'placeholder' => 'Select Tax']) }}
                                        </div>
                                    </div>
                                @endif
                                @if (module_is_active('CustomField') && !$customFields->isEmpty())
                                    <div class="col-md-12">
                                        <div class="tab-pane fade show" id="tab-2" role="tabpanel">
                                            @include('customfield::formBuilder', [
                                                'fildedata' => !empty($invoice->customField)
                                                    ? $invoice->customField
                                                    : '',
                                            ])
                                        </div>
                                    </div>
                                @endif
                                @stack('add_invoices_agent_filed_edit')
                                @stack('add_invoices_field')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="loader" class="card card-flush">
            <div class="card-body">
                <div class="row">
                    <img class="loader" src="{{ asset('public/images/loader.gif') }}" alt="">
                </div>
            </div>
        </div>
        <div class="col-12 section_div">

        </div>
        <div class="modal-footer mb-3">
            <input type="button" value="{{ __('Cancel') }}" onclick="location.href = '{{ route('invoice.index') }}';"
                class="btn btn-light mx-3">
            <input type="submit" id="submit" value="{{ __('Save Changes') }}" class="btn btn-primary">
        </div>
        {{ Form::close() }}
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('js/jquery-searchbox.js') }}"></script>

    <script>
        $("#submit").click(function() {
            var skill = $('.account_type').val();
            if (skill == '') {
                $('#account_validation').removeClass('d-none')
                return false;
            } else {
                $('#account_validation').addClass('d-none')
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#billing_type').on('change', function() {
                if ($(this).val() == 'rent') {
                    $('#due_date').prop('readonly', true);
                } else {
                    $('#due_date').prop('readonly', false);
                }
            });
        });
    </script>
    <script>

        function Calculate() {

            var rentType = document.getElementById('rent_type').value;
            var startDate = new Date(document.getElementById('issue_date').value);
            if (rentType === '0')
            {
                var endDate = startDate.toISOString().split('T')[0];
                document.getElementById('due_date').value = endDate;
            } else if (rentType === '1') {
                // Calculate end date for a week
                startDate.setDate(startDate.getDate() + 7);
            } else if (rentType === '2') {
                // Calculate end date for a month
                startDate.setMonth(startDate.getMonth() + 1);
            }

            // Format the date to 'YYYY-MM-DD'
            var endDate = startDate.toISOString().split('T')[0];

            // Set the calculated end date
            document.getElementById('due_date').value = endDate;
        }
    </script>
@endpush
