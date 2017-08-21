<div class="col-md-12" >
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Order</h3>

    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-12">

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
                                <th style="min-width: 50px;">
                                    CS
                                </th>
                                <th style="min-width: 50px;">
                                    PCS
                                </th>

                                <th>
                                    Total QTY
                                </th>
                                <th>
                                    Total QTY CS
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

                        </tbody>
                        <tfoot>
                            <tr>
                                <td>
                                    <a class="btn btn-xs btn-success" id="row_add" data-track="0" onclick="add_row()"><i class="fa fa-plus"></i>
                                        Add</a>
                                </td>
                                <td colspan="4"></td>

                                <td>Gross Total</td>
                                <td>
                                    <input id="grand_total_CS" type="text" class="form-control" name="grand_total_CS" readonly/>
                                </td>
                                <td>
                                    <input id="grand_total" type="text" class="form-control" name="grand_total" readonly/>
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-success" id="row_add" data-track="0" onclick="add_row()"><i class="fa fa-plus"></i>
                                        Add</a>
                                </td>
                            </tr>
                            <tr>
                                <td>

                                </td>
                                <td colspan="4"></td>

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