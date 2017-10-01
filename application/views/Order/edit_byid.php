<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>


<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PAGE TITLE & BREADCRUMB-->

        <ul class="page-breadcrumb breadcrumb">
            <li>
                <i class="fa fa-home"></i>
                <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                <a href="<?php echo site_url('order/index'); ?>">Sales Order Others</a>
                <i class="fa fa-angle-right"></i>
            </li>
            <li>
                Edit
            </li>
        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <form role="form" id="add_order_form" action="<?php echo site_url('order/save_after_edit'); ?>"    method="post">
            <!-- BEGIN FORM-->

            <div class="row">
                <div class="col-md-12">

                    <div class="box box-solid box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Order Inforamtion</h3>

                        </div>
                        <div class="portlet-body">
                            <div class="table-scrollable">
                                <table class="table table-striped table-bordered" >

                                    <?php foreach ($orderInfo As $outletinfo) { ?>
                                        <tr>
                                            <th style="width:300px;">
                                                Outlet Name
                                            </th>
                                            <th>
                                                <?php echo $outletinfo["outlet_name"]; ?>
                                                <input name="outlet_id" value="<?php echo $outletinfo["outlet_id"]; ?>" type="hidden">
                                                <input name="order_id" value="<?php echo $outletinfo["order_id"]; ?>" type="hidden">
                                            </th>                                           

                                        </tr>
                                        <tr>
                                            <th style="width:300px;">
                                                Memo Number
                                            </th>
                                            <th>
                                                <?php echo $outletinfo["so_id"]; ?>
                                            </th>

                                        </tr>
                                        <tr>

                                            <th>
                                                Sub Route
                                            </th>
                                            <th>
                                                <?php echo $outletinfo["subroute"]; ?>
                                                <input name="route_id" value="<?php echo $outletinfo["route_id"]; ?>" type="hidden">

                                            </th>


                                        </tr>
                                        <tr>
                                            <th>
                                                PSR Name
                                            </th>
                                            <th>
                                                <?php echo $outletinfo["first_name"]; ?>
                                                <input name="psr_id" value="<?php echo $outletinfo["psr_id"]; ?>" type="hidden">
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>
                                                Order Status
                                            </th>
                                            <th>
                                                <?php
                                                $status = $outletinfo["so_status"];
                                                if ($status == 1) {//new Order
                                                    ?>
                                                    <span class="label label-danger">New</span>
                                                <?php } elseif ($status == 2) { //Challan Created And Transit 
                                                    ?>
                                                    <span class="label label-warning">Delivery</span>
                                                <?php }if ($status == 3) {//Challan Confirm And Delveried 
                                                    ?>
                                                    <span class="label label-success">Confirmed</span>
                                                    <?php
                                                }
                                                ?>
                                                <input name="so_status" value="<?php echo $outletinfo["so_status"]; ?>" type="hidden">
                                            </th>
                                        </tr>

                                    <?php } ?>
                                </table>
                            </div>
                            <input type="hidden" class="form-control" id="row_num" name="row_num" value="1">
                        </div>

                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <div class="box box-solid box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Order</h3>

                        </div>
                        <div class="portlet-body">
                            <div class="table-scrollable">
                                <table class="table table-striped table-bordered table-hover" id="sales_order">
                                    <thead>
                                        <tr>
                                            <th>
                                                SKU Name (Code)
                                            </th>
                                            <th>
                                                Pack Size
                                            </th>
                                            <th>
                                                Unit Price
                                            </th>
                                            <th style="min-width: 100px;">
                                                CS
                                            </th>
                                            <th style="min-width: 100px;">
                                                PCS
                                            </th>
                                            <th style="max-width: 100px;">
                                                Discount/Offer
                                            </th>
                                            <th>
                                                Discount amount
                                            </th>

                                            <th style="min-width: 140px;">
                                                Subtotal
                                            </th>
                                            <th>
                                                Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_cycle">

                                        <?php
                                        $count = 0;
                                        foreach ($orderline As $orderlineinfo) {
                                            ?>
                                            <tr>
                                                <td style="width:300px;"><select  name="sku_id[]" onchange="get_unit_price(id)" id="sku_id<?php echo $count; ?>" class="form-control" required >
                                                        <option selected value="<?php echo $orderlineinfo["sku_id"]; ?>"><?php echo $orderlineinfo["sku_name"]; ?></option>
                                                    </select></td>
                                                <td style="width:100px;"><input type="text" value="<?php echo $orderlineinfo["Pack_size"]; ?>" name="Pack_Size[]" id="Pack_Size<?php echo $count; ?>" class="form-control"  onkeyup="openQty(id);" readonly required/></td>
                                                <td style="width:200px;"><input type="text" value="<?php echo $orderlineinfo["unit_sale_price"]; ?>" name="TP_price[]" id="TP_price<?php echo $count; ?>" class="form-control"  onkeyup="openQty(id);" readonly required/></td>
                                                <td><input type="text"  name="order_qty_CS[]" value="<?php echo floor($orderlineinfo["quantity_delivered"] / $orderlineinfo["Pack_size"]); ?>" id="order_qty_CS<?php echo $count; ?>" onkeyup="total_qty_cs(id);" class="form-control" /></td>
                                                <td><input type="text"  name="order_qty_PS[]" value="<?php echo $orderlineinfo["quantity_delivered"] % $orderlineinfo["Pack_size"]; ?>" id="order_qty_PS<?php echo $count; ?>" onkeyup="total_qty_cs(id);" class="form-control" /></td>
                                                <td><input type="text"  name="Offer_txt[]"  id="Offer_txt<?php echo $count; ?>" onkeyup="" class="form-control" readonly /></td>
                                                <td><input type="text"  name="Discount[]" value="<?php echo $orderlineinfo["total_discount_amount"]; ?>" id="Discount<?php echo $count; ?>" onkeyup="" class="form-control" readonly /></td>
                                        <input type="hidden"  name="Total_qty[]" value="<?php echo $orderlineinfo["quantity_delivered"]; ?>" id="Total_qty<?php echo $count; ?>" class="form-control" readonly />
                                        <input type="hidden"  name="TotalOrder_qty[]" value="<?php echo $orderlineinfo["quantity_delivered"]; ?>" id="TotalOrder_qty<?php echo $count; ?>" class="form-control" readonly />

                                        <td><input type="text" name="total_amount[]" id="total_amount<?php echo $count; ?>"  value="<?php echo $orderlineinfo["total_billed_amount"]; ?>" class="form-control"  readonly /></td>
                                        <td></td>
                                        </tr>
                                        <?php
                                        $count++;
                                    }
                                    ?>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>
                                                <a class="btn btn-xs btn-success" id="row_add" data-track="0" onclick="add_row()"><i class="fa fa-plus"></i>
                                                    Add</a>
                                            </td>
                                            <td colspan="5"></td>

                                            <td>Gross Total</td>
                                            <td>
                                                <input id="grand_total" type="text" class="form-control" name="grand_total" readonly/>
                                            </td>
                                            <td>
                                                <a class="btn btn-xs btn-success" id="row_add" data-track="0" onclick="add_row()"><i class="fa fa-plus"></i>
                                                    Add</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> <button type="submit" class="btn btn-facebook btn-lg">Save</button></td>
                                            <td colspan="5"></td>


                                            <td>Discount</td>
                                            <td>
                                                <input id="invoice_discount" type="text" class="float-input form-control" name="invoice_dis" readonly/>
                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6"></td>
                                            <td>After Discount Total</td>
                                            <td>
                                                <input type="text" class="float-input form-control" id="discount_total" name="discount_total"
                                                       readonly/>
                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td> </td>

                                            <td colspan="6">

                                            </td>
                                            <td style="text-align: right;">
                                               <!-- <a href="<?php echo site_url('order/OrderEditById/' . $Next_orderId); ?>"  class="btn btn-facebook btn-lg">Next</a>-->
                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <input type="hidden" class="form-control" id="row_num" name="row_num" value="1">

                        </div>

                    </div>


                </div>
            </div>
        </form>
    </div>
</div>



<?php
$this->load->view('footer/footer');
?>
<script>
    var sku_row_count = <?php echo $count ?>;
    $(document).ready(function () {
        grand_total_amount();
        document.getElementById("title").innerHTML = "IRIS | Order Edit "
    });
    /*add row*/
    function add_row() {
        sku_row_count++;
        var sku_list = block_sku_list();
        var count = sku_row_count;

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>order/Editadd_row/",
            data: {count: count, sku_list: sku_list},
            dataType: "html",
            success: function (data) {

                $('#sales_order tbody').append(data);
                $("#sales_order tbody select").select2({
                    placeholder: "Select",
                    allowClear: true
                });
            }
        });
    }

    /*-----------------------------------------------------------------------
     * Get the  Block Sku by using this function
     *-----------------------------------------------------------------------*/
    function block_sku_list() {
        var sku_id_list = [];
        $('body select[name="sku_id[]"]').each(function () {
            var sku_id = $(this).val();
            if (sku_id) {
                sku_id_list.push(sku_id);
            }
        });
        return sku_id_list;
    }

    /*-----------------------------------------------------------------------
     * delete sales order line if add
     *-----------------------------------------------------------------------*/
    $("table").on('click', '#removeLine', function () {
        $(this).parent('td').parent('tr').remove();
        grand_total_amount();
    });
    //end

    function get_unit_price(id) {
        var index = id.slice(6);
        var sku_id = $("#sku_id" + index).val();
        $("#Pack_Size" + index).val('');
        $("#TP_price" + index).val('');
        $("#order_qty_CS" + index).val('');
        $("#order_qty_PS" + index).val('');
        $("#Offer_txt" + index).val('');
        $("#Discount" + index).val('');
        $("#Total_qty" + index).val('');
        $("#total_amount" + index).val('');
        //    grand_total_amount();

        if (sku_id != '') {

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>order/getBundleDetailbySku/",
                data: {sku_id: sku_id},
                dataType: "json",
                error: function (e) {
                    alert("error");
                },
                success: function (data) {
                    $("#TP_price" + index).val(data.price);
                    $("#Pack_Size" + index).val(data.unit);

                    openQty(index);
                }
            });
            //end
            //get mou

        } else {
            openQty(index);
        }
    }
    function openQty(index) {
        var TP_price = $("#TP_price" + index).val();
        if (TP_price !== '') {
            $("#order_qty_CS" + index).attr('readonly', false);
            $("#order_qty_PS" + index).attr('readonly', false);
        } else {
            grand_total_amount();
        }
    }

    function total_qty_cs(id) {
        var index = id.slice(12);
        var Pack_Size = $("#Pack_Size" + index).val();
        var TP_price = $("#TP_price" + index).val();
        var order_qty_CS = $("#order_qty_CS" + index).val();
        order_qty_CS = (order_qty_CS != '') ? parseInt(order_qty_CS) : 0;
        var order_qty_PS = $("#order_qty_PS" + index).val();
        order_qty_PS = (order_qty_PS != '') ? parseInt(order_qty_PS) : 0;
        $("#Total_qty" + index).val(parseInt(order_qty_CS * Pack_Size) + order_qty_PS);
        $("#total_amount" + index).val(parseFloat(((order_qty_CS * Pack_Size) + order_qty_PS) * TP_price).toFixed(2));
        grand_total_amount();
    }

    function grand_total_amount() {
        var total_amount = 0;

        $('input[name="total_amount[]"]').each(function () {
            var amount = $(this).val();
            if (amount) {
                total_amount = total_amount + parseFloat(amount);
            }
        });
        $("#grand_total").val(parseFloat(total_amount).toFixed(2));
        $("#discount_total").val(parseFloat(total_amount).toFixed(2));


    }

    $('#add_order_form').unbind('submit').bind('submit', function (e) {
        var status =<?php echo$status; ?>;
        e.preventDefault(); // avoid to execute the actual submit of the form.
        if (status == 1) {
            $('#ajax_load').css("display", "block");

            var url = "<?php echo site_url('order/save_after_edit'); ?>"; // the script where you handle the form input.

            $.ajax({
                type: "POST",
                url: url,
                data: $("#add_order_form").serialize(), // serializes the form's elements.
                success: function (data) {

                    $('#ajax_load').css("display", "none");
                    alert(data);
                    window.location = window.close();
                }
            });
        } else {
            // alert("Edit not Possible");
            $('#ajax_load').css("display", "block");

            var url = "<?php echo site_url('order/save_after_order_confirm'); ?>"; // the script where you handle the form input.

            $.ajax({
                type: "POST",
                url: url,
                data: $("#add_order_form").serialize(), // serializes the form's elements.
                success: function (data) {

                    $('#ajax_load').css("display", "none");
                    alert(data);
                    window.location = window.close();
                }
            });




        }
    });


</script>