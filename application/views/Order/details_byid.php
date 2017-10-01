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
                Details
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
                                                <td style="width:300px;"><select disabled="" name="sku_id[]" onchange="get_unit_price(id)" id="sku_id<?php echo $count; ?>" class="form-control" required >
                                                        <option selected value="<?php echo $orderlineinfo["sku_id"]; ?>"><?php echo $orderlineinfo["sku_name"]; ?></option>
                                                    </select></td>
                                                <td style="width:100px;"><input type="text" value="<?php echo $orderlineinfo["Pack_size"]; ?>" name="Pack_Size[]" id="Pack_Size<?php echo $count; ?>" class="form-control"  onkeyup="openQty(id);" readonly required/></td>
                                                <td style="width:200px;"><input type="text" value="<?php echo $orderlineinfo["unit_sale_price"]; ?>" name="TP_price[]" id="TP_price<?php echo $count; ?>" class="form-control"  onkeyup="openQty(id);" readonly required/></td>
                                                <td><input type="text" readonly="readonly" name="order_qty_CS[]" value="<?php echo floor($orderlineinfo["quantity_delivered"] / $orderlineinfo["Pack_size"]); ?>" id="order_qty_CS<?php echo $count; ?>" onkeyup="total_qty_cs(id);" class="form-control" /></td>
                                                <td><input type="text" readonly="readonly" name="order_qty_PS[]" value="<?php echo $orderlineinfo["quantity_delivered"] % $orderlineinfo["Pack_size"]; ?>" id="order_qty_PS<?php echo $count; ?>" onkeyup="total_qty_cs(id);" class="form-control" /></td>
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

                                            </td>
                                            <td colspan="5"></td>

                                            <td>Gross Total</td>
                                            <td>
                                                <input id="grand_total" type="text" class="form-control" name="grand_total" readonly/>
                                            </td>
                                            <td>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
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