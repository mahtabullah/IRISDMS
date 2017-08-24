<div class="col-md-12" >
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">Challan</h3>

        </div>
        <div class="portlet-body">

            <div class="row">
                <div class="col-md-12" >

                    <div class="table-scrollable" style="padding:10px;">
                        <table>                            
                            <tr>
                                <th style="width:150px">
                                    PSR Name 
                                </th>
                                <th style="width:10px">
                                    :
                                </th>
                                <th style=" text-align:left; width:300px">




                                    <?php foreach ($PSR As $Emp) { ?>    
                                        <input name="Psr_name" id="Psr_name" value="<?php echo $Emp[id]; ?>" type="hidden">
                                        <input type="text" class="form-control" style="width:200px;" readonly value="<?php echo $Emp[name]; ?>"  />

                                        <?php
                                    }
                                    ?>  

                                </th>

                            </tr>
                            <tr>
                                <th style="width:150px">
                                    Sub Route Name 
                                </th>
                                <th style="width:10px">
                                    :
                                </th>
                                <th style=" text-align:left; width:200px">
                                    <?php foreach ($subroute As $SRoute) { ?>    
                                        <input name="subroute" id="subroute" value="<?php echo $SRoute[id]; ?>" type="hidden">
                                        <input type="text" class="form-control" style="width:200px;" readonly value="<?php echo $SRoute[route]; ?>"  />

                                        <?php
                                    }
                                    ?>  
                                </th>
                            </tr>
                            <tr>
                                <th style="width:150px">
                                    Order Date 
                                </th>
                                <th style="width:10px">
                                    :
                                </th>
                                <th style=" text-align:left; width:200px">
                                    <input type="text" class="form-control" readonly style="width:100px;" value="<?php echo $Date; ?>" name="Order_Date" id="Order_Date" />
                                </th>
                            </tr>
                            <tr>
                                <th>
                                    Number of Memo
                                </th>
                                <th >
                                    :
                                </th>
                                <th>
                                    <input type="text" class="form-control col-md-6" style="width:100px;" readonly value="<?php
                                    foreach ($No_of_memo as $No_memo) {
                                        echo $No_memo["No_of_memo"];
                                    }
                                    ?>" name="No_of_memo" id="No_of_memo" />
                                </th>


                            </tr>

                        </table>
                        <br>
                        <table class="table table-striped table-bordered table-hover" id="sales_order">
                            <thead> 
                                <tr>
                                    <th rowspan="2">
                                        SL
                                    </th>
                                    <th rowspan="2">
                                        SKU Name 
                                    </th>
                                    <th rowspan="2">
                                        Pack Size
                                    </th>
                                    <th rowspan="2">
                                        Price [CS]
                                    </th>
                                                                   
                                    <th style="text-align: center;"  colspan="2">
                                        Order Qty
                                    </th>
                                    <th style="text-align: center;"  colspan="2">
                                        Extra Qty
                                    </th>
                                    <th style="text-align: center;"  colspan="2">
                                        Total Qty
                                    </th>
                                    <th style="min-width: 140px;" rowspan="2">
                                        Total Price
                                    </th>

                                </tr>
                                <tr>
                                    <th style=" text-align: center; min-width: 50px;">
                                        CS
                                    </th>
                                    <th style="text-align: center; min-width: 50px;">
                                        PCS
                                    </th>
                                    <th style=" text-align: center; min-width: 50px;">
                                        CS
                                    </th>
                                    <th style="text-align: center; min-width: 50px;">
                                        PCS
                                    </th>
                                    <th style=" text-align: center; min-width: 50px;">
                                        CS
                                    </th>
                                    <th style="text-align: center; min-width: 50px;">
                                        PCS
                                    </th>

                                </tr>
                            </thead>
                            <tbody id="tbody_cycle">

                                <?php
                                $sl = 1;
                                $sku_count = 0;
                                $Total_Qty = 0;
                                $Total_value = 0;
                                foreach ($Order_data as $rp_i) {
                                    ?>


                                    <tr>
                                        <td>
                                            <?php
                                            echo $sl;
                                            $sl++;
                                            ?>
                                        </td>
                                        <td style="width: 250px;">
                                            <input type="hidden" value="<?php echo $rp_i['sku_id']; ?>"  name="sku_id[]" id="sku_id<?php echo $sku_count; ?>" />                                            
                                            <input type="text" readonly class="form-control"  value="<?php echo $rp_i['sku_name']; ?>"  name="sku_name[]" id="sku_name<?php echo $sku_count; ?>" /> 
                                           
                                        </td>
                                        <td style="width: 100px;" >
                                            <input type="text" style="text-align: center;" class="form-control" value="<?php echo $rp_i['Pack_Size']; ?>" readonly name="Pack_Size[]" id="Pack_Size<?php echo $sku_count; ?>" />                                            
                                        </td>
                                        <td style="text-align: right; width: 100px;">
                                            <input type="text" style="text-align: right;" class="form-control" readonly value=" <?php echo $rp_i['PS_Price']; ?>"  name="TP_price[]" id="TP_price<?php echo $sku_count; ?>" />                                            
                                        
                                            <input type="hidden" value="<?php echo $rp_i['stock']; ?>" readonly name="stock[]" id="stock<?php echo $sku_count; ?>" />                                            
                                        </td>
                                        <td style="text-align: right; width: 75px;">
                                            <input type="text" style="text-align: right;" class="form-control"value="<?php echo round($rp_i['totalQty'] / $rp_i['Pack_Size']); ?>" readonly name="order_qty_CS[]" id="order_qty_CS<?php echo $sku_count; ?>" />                                            
                                        </td>
                                        <td style="text-align: right; width: 75px;">
                                            <input type="text" class="form-control" style="text-align: right;" value="<?php echo round($rp_i['totalQty'] % $rp_i['Pack_Size']); ?>" readonly name="order_qty_PS[]" id="order_qty_PS<?php echo $sku_count; ?>" />
                                            <input type="hidden" value="<?php echo $rp_i['totalQty']; ?>" name="Totalorder_qty[]" id="Totalorder_qty<?php echo $sku_count; ?>" />                                            
                                        </td>
                                        <td style="text-align: right; width: 75px;">
                                            <input type="text" class="form-control" style="text-align: right;" onkeyup="total_qty(<?php echo $sku_count; ?>);" name="ExtraCS_Qty[]" id="ExtraCS_Qty<?php echo $sku_count; ?>" />                                            
                                        </td>
                                        <td style="text-align: right; width: 75px;">
                                            <input type="text" class="form-control" style="text-align: right;" onkeyup="total_qty(<?php echo $sku_count; ?>);"name="ExtraPS_Qty[]" id="ExtraPS_Qty<?php echo $sku_count; ?>" />
                                            <input type="hidden" value="" readonly name="Extra_Qty[]" id="Extra_Qty<?php echo $sku_count; ?>" />                                            
                                        </td>
                                        <td style="text-align: right; width: 75px;">
                                            <input type="text" style="text-align: right;" class="form-control"value="<?php echo round($rp_i['totalQty'] / $rp_i['Pack_Size']); ?>" readonly name="total_qty_CS[]" id="total_qty_CS<?php echo $sku_count; ?>" /> 
                                            <input type="hidden" style="text-align: right;" class="form-control"value="<?php echo $rp_i['totalQty'] / $rp_i['Pack_Size']; ?>" readonly name="Grand_total_qty_CS[]" id="Grand_total_qty_CS<?php echo $sku_count; ?>" />                                            
                                        </td>
                                        <td style="text-align: right; width: 75px;">
                                            <input type="text" class="form-control" style="text-align: right;" value="<?php echo round($rp_i['totalQty'] % $rp_i['Pack_Size']); ?>" readonly name="total_qty_PS[]" id="total_qty_PS<?php echo $sku_count; ?>" />                                            
                                            <input type="hidden" class="form-control" style="text-align: right;" value="<?php echo $rp_i['totalQty']; ?>" readonly name="Total_qty[]" id="Total_qty<?php echo $sku_count; ?>" />
                                        </td>



                                        <td style="text-align: right; width: 75px;">
                                            <input type="text" style="text-align: right;" class="form-control"value="<?php echo round($rp_i['totalQty'] * $rp_i['PS_Price']); ?>" readonly name="total_amount[]" id="total_amount<?php echo $sku_count; ?>" />
                                            <input  type="hidden" value="<?php echo $rp_i['stock']-$rp_i['totalQty']; ?>" readonly name="stockgap[]" id="stockgap<?php echo $sku_count; ?>" />                                            
                                        </td>


                                    </tr>
                                    <?php
                                    $Total_Qty += $rp_i['totalQty'] / $rp_i['Pack_Size'];
                                    $Total_value += $rp_i['totalQty'] * $rp_i['PS_Price'];

                                    $sku_count++;
                                }
                                ?>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>
                                    </td>
                                    <td colspan="7" style="text-align: right;">Gross Total</td>
                                    <td colspan="2">
                                        <input id="grand_total_CS" type="text" value="<?php echo round($Total_Qty, 2); ?>" class="form-control" name="grand_total_CS" readonly/>
                                    </td>
                                    <td>
                                        <input id="grand_total" type="text" value="<?php echo round($Total_value, 2); ?>" class="form-control" name="grand_total" readonly/>
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                    </td>
                                    <td colspan="6"></td>
                                    <td></td>
                                    <td>
                                    </td>
                                    <td>
                                        <button id="submit" type="submit" class="btn btn-lg btn-facebook">Save</button>
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
            <div class="row">
                <div class="col-md-12">
                    &nbsp;
                </div>
            </div>
        </div>
    </div> 
</div>