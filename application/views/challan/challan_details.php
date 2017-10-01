
<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>
<style>
    table.table-bordered{
    border:1px solid black;
    margin-top:20px;
  }
table.table-bordered > thead > tr > th{
    border:1px solid black;
    text-align:center;
    
}
table.table-bordered > tbody > tr > td{
    border:1px solid black;
}
    
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Challan
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Challan</li>
    </ol>
</section>


<!-- Main content -->
<section class="content">
    <form role="form" id="details_Challan_form" action="<?php echo site_url('challan/challanconfirmbyid'); ?>"
          method="post">
        <!-- BEGIN FORM-->
        <div class="row">
            <div class="col-md-12">

                <div class="box box-solid box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Challan Inforamtion</h3>

                    </div>
                    <div class="portlet-body">
                        <div class="table-scrollable">
                            <table class="table" >

                                <?php foreach ($challanInfo As $challan) { ?>
                                    <tr>
                                        <th style="width:300px;">
                                            PSR Name
                                        </th>
                                        <th>
                                            <?php echo $challan["PSR"]; ?>
                                            <input type="hidden" name="outlet_id" value="<?php echo $challan["psr_id"]; ?>" type="text">
                                            <input type="hidden" name="challan_id" value="<?php echo $challan["id"]; ?>" type="text">
                                        </th>                                           
                                    </tr>
                                    <tr>
                                        <th>
                                            Sub Route
                                        </th>
                                        <th>
                                            <?php echo $challan["sub_route"]; ?>
                                            <input type="hidden" name="route_id" value="<?php echo $challan["route_id"]; ?>" type="text">
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            Challan Number
                                        </th>
                                        <th>
                                            <?php echo $challan["challan_number"]; ?>

                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            No of Memo
                                        </th>
                                        <th>
                                            <?php echo $challan["No_of_memo"]; ?>

                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            Challan Status
                                        </th>
                                        <th>
                                            <?php
                                            $status = $challan["challan_status"];
                                            if ($status == 1) {//new Order
                                                ?>
                                                <span class="label label-danger">New</span>
                                            <?php } elseif ($status == 2) { //Challan Created And Transit 
                                                ?>
                                                <span class="label label-warning">Delivery</span>
                                            <?php }if ($status == 3) {//Challan Confirm And Delveried 
                                                ?>
                                                <span class="label label-success">New</span>
                                                <?php
                                            }
                                            ?>
                                            <input type="hidden" name="so_status" value="<?php echo $challan["challan_status"]; ?>" type="text">
                                        </th>
                                    </tr>

                                <?php } ?>
                            </table>
                        </div>

                    </div>

                </div>

            </div>
        </div>
        <div class="row">

            <div class="col-md-12" >
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Challan</h3>

                    </div>
                    <div class="portlet-body">

                        <div class="row">
                            <div class="col-md-12" >

                                <div class="table-scrollable" style="padding:10px;">
                                    
                                    <table  class="table  table-striped table-bordered " id="challan">
                                        <thead> 
                                            <tr >
                                                <th  rowspan="2">
                                                    SL
                                                </th>
                                                <th rowspan="2">
                                                    SKU Name 
                                                </th>
                                                <th rowspan="2">
                                                    Pack Size
                                                </th>
                                                <th rowspan="2">
                                                    Price [PS]
                                                </th>
                                                <th style="text-align: center;"  colspan="2">
                                                    Challan Qty
                                                </th>
                                                 <th style="text-align: center;"  colspan="2">
                                                    Total Delivery
                                                </th>
                                                <th rowspan="2">
                                                    Challan Qty Price
                                                </th>
                                                <th rowspan="2">
                                                   Delivery Price
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
                                            </tr>
                                        </thead>
                                        <tbody id="tbody_cycle">
                                            <?php
                                            $sl = 1;
                                            $sku_count = 0;
                                            $Total_Qty = 0;
                                            $Total_value = 0;
                                            $TotalDelivery_Qty = 0;
                                            $TotalDelivery_value = 0;
                                            foreach ($challanLineInfo as $challanLine) {
                                                ?>
                                                <tr>
                                                    <td style="width: 20px;">
                                                        <?php
                                                        echo $sl;
                                                        $sl++;
                                                        ?>
                                                    </td>
                                                    <td style="width: 250px;">
                                                        <input type="hidden" value="<?php echo $challanLine['sku_id']; ?>"  name="sku_id[]" id="sku_id<?php echo $sku_count; ?>" />                                            
                                                        <input type="text" readonly class="form-control"  value="<?php echo $challanLine['sku_name']; ?>"  name="sku_name[]" id="sku_name<?php echo $sku_count; ?>" /> 
                                                    </td>
                                                    <td style="width: 100px;" >
                                                        <input type="text" style="text-align: center;" class="form-control" value="<?php echo $challanLine['Pack_size']; ?>" readonly name="Pack_Size[]" id="Pack_Size<?php echo $sku_count; ?>" />                                            
                                                    </td>
                                                    <td style="text-align: right; width: 100px;">
                                                        <input type="text" style="text-align: right;" class="form-control" readonly value=" <?php echo $challanLine['price']; ?>"  name="TP_price[]" id="TP_price<?php echo $sku_count; ?>" />                                            
                                                    </td>
                                                     <td style="text-align: right; width: 75px;">
                                                        <input type="text" style="text-align: right;" class="form-control"value="<?php echo round($challanLine['Challan_qty'] / $challanLine['Pack_size']); ?>" readonly name="Challan_qty_CS[]" id="Challan_qty_CS<?php echo $sku_count; ?>" /> 
                                                    </td>
                                                    <td style="text-align: right; width: 75px;">
                                                        <input type="text" class="form-control" style="text-align: right;" value="<?php echo round($challanLine['Challan_qty'] % $challanLine['Pack_size']); ?>" readonly name="Challan_qty_PS[]" id="Challan_qty_PS<?php echo $sku_count; ?>" />                                            
                                                        <input type="hidden" class="form-control" style="text-align: right;" value="<?php echo $challanLine['Challan_qty']; ?>" readonly name="Challan_qty[]" id="Challan_qty<?php echo $sku_count; ?>" />
                                                    </td>
                                                     <td style="text-align: right; width: 75px;">
                                                        <input type="text" style="text-align: right;" class="form-control"value="<?php echo round($challanLine['Totaldelivered'] / $challanLine['Pack_size']); ?>" readonly name="Totaldelivered_qty_CS[]" id="Totaldelivered_qty_CS<?php echo $sku_count; ?>" /> 
                                                    </td>
                                                    <td style="text-align: right; width: 75px;">
                                                        <input type="text" class="form-control" style="text-align: right;" value="<?php echo round($challanLine['Totaldelivered'] % $challanLine['Pack_size']); ?>" readonly name="Totaldelivered_qty_PS[]" id="Totaldelivered_qty_PS<?php echo $sku_count; ?>" />                                            
                                                        <input type="hidden" class="form-control" style="text-align: right;" value="<?php echo $challanLine['Totaldelivered']; ?>" readonly name="Totaldelivered_qty[]" id="Totaldelivered_qty<?php echo $sku_count; ?>" />
                                                    </td>
                                                    <td style="text-align: right; width: 75px;">
                                                        <input type="text" class="form-control" style="text-align: right;" value="<?php echo round($challanLine['Challan_qty'] * $challanLine['price'],2); ?>" readonly name="Challan_price[]" id="Challan_price<?php echo $sku_count; ?>" />
                                                        <input type="hidden" style="text-align: right;" class="form-control"value="<?php echo $challanLine['Challan_qty'] - $challanLine['Totaldelivered']; ?>" readonly name="Short_sku_qty[]" id="Short_sku_qty<?php echo $sku_count; ?>" />
                                                    </td>
                                                    <td style="text-align: right; width: 75px;">
                                                        <input type="text" style="text-align: right;" class="form-control"value="<?php echo round($challanLine['Totaldelivered'] * $challanLine['price'],2); ?>" readonly name="Totaldelivered_amount[]" id="Totaldelivered_amount<?php echo $sku_count; ?>" />
                                                    </td>
                                                </tr>
                                                <?php
                                                $Total_Qty += $challanLine['Challan_qty'] / $challanLine['Pack_size'];
                                                $Total_value += $challanLine['Challan_qty'] * $challanLine['price'];
                                                
                                                $TotalDelivery_Qty += $challanLine['Totaldelivered'] / $challanLine['Pack_size'];
                                                $TotalDelivery_value += $challanLine['Totaldelivered'] * $challanLine['price'];    
                                                $sku_count++;
                                            }
                                            ?>

                                        </tbody>
                                        <tfoot>
                                            <tr style="text-align: right; font-weight: bold; ">
                                                <td>
                                                </td>
                                                <td colspan="3" style="text-align: right;">Gross Total</td>
                                                <td  colspan="2">
                                                 <input type="text" class="form-control" style="text-align: right;" value="<?php echo number_format($Total_Qty, 2); ?>" readonly name="" id="" />                                            
                                                     
                                                </td>
                                                  <td colspan="2">
                                                  <input type="text" class="form-control" style="text-align: right;" value="<?php echo $TotalDelivery_Qty;?>" readonly name="grand_total_CS" id="grand_total" />                                            
                                         
                                                </td>
                                                <td >
                                                    <input type="text" class="form-control" style="text-align: right;" value="<?php echo number_format($Total_value, 2); ?>" readonly name="" id="" />                                            
                                                  
                                                 
                                                </td>
                                                <td >
                                                    <input type="text" class="form-control" style="text-align: right;" value="<?php echo $TotalDelivery_value; ?>" readonly name="grand_total" id="total_amount" />                                            
                                                    
                                                  
                                                </td>

                                            </tr>
                                            <tr>
                                                <td>
                                                </td>
                                                <td colspan="5"></td>
                                                <td></td>
                                                <td>
                                                </td>
                                                <td colspan="2">
                                                    <?php
                                            $status = $challan["challan_status"];
                                            if ($status == 1) {//new Order
                                                ?>
                                                 <button id="submit" type="submit" class="btn btn-lg btn-facebook">Confirm Delivery</button>
                                            <?php } elseif ($status == 2) { //Challan Created And Transit 
                                                ?>
                                                
                                            <?php }if ($status == 3) {//Challan Confirm And Delveried 
                                                ?>
                                                <span class="label label-success">Cancle</span>
                                                <?php
                                            }
                                            ?>
                                                   
                                                </td>
                                                

                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                              
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

        </div>



        <div class="modal modal-warning fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Extra Delivery</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <td style="text-align:center;" rowspan="2">SKU Name</td>
                                    <td colspan="2">Challan Qty</td>
                                    <td colspan="2">Dlivery Qty</td>
                                    <td colspan="2">Short</td>                                
                                </tr>
                                <tr>
                                    <td>CS</td>
                                    <td>PS</td>
                                    <td>CS</td>
                                    <td>PS</td> 
                                    <td>CS</td>
                                    <td>PS</td>
                                </tr>
                            </thead>
                            <tbody id="modal_table">

                            </tbody>
                        </table>

                    </div>
                    <div class="modal-footer">
                        
                        
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
    </form>
</section>

<?php
$this->load->view('footer/footer');
?>

<script type="text/javascript">

    $(document).ready(function () {

        $(".select2").select2({
            placeholder: "Select",
            allowClear: true
        });
        $("#challan_date").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true

        });

    });
     function shortage_stock_model() {
        $('#modal_table').html('');
        $('input[name="Short_sku[]"]').each(function () {
            var stock_gap = $(this).val();
            var id = $(this).attr('id');
            var index = id.slice(9);
          
            
            if (stock_gap < 0) {
              //  var sku_id = $("#sku_id" + index).val();
                var sku_name = $("#sku_name" + index).val();
                var Challan_qty = $("#Challan_qty" + index).val();
                var Totaldelivered_qty = $("#Totaldelivered_qty" + index).val();
                
                var Short_gap = $("#Short_sku" + index).val();
                var Pack_Size = $("#Pack_Size" + index).val();
                var shortQty = '<tr><td>' + sku_name + '</td><td>' + Math.floor(Challan_qty / Pack_Size) + '</td><td>' + (Challan_qty % Pack_Size) + '</td><td>' + Math.floor(Totaldelivered_qty / Pack_Size) + '</td><td>' + Totaldelivered_qty % Pack_Size + '</td><td>' + Math.floor(Math.abs(Short_gap / Pack_Size)) + '</td><td>' + Math.abs(Short_gap % Pack_Size) + '</td> </tr>';
                $('#modal_table').append(shortQty);

            }
        });    
       $('#ajax_load').css("display", "none");
      $('#myModal').modal('show');
    }
     $('#details_Challan_form').unbind('submit').bind('submit', function (e) {
       // e.preventDefault(); // avoid to execute the actual submit of the form.
      $('#ajax_load').css("display", "block");

        var Short = 0;
        $('input[name="Short_sku[]"]').each(function () {
            var Short_gap = $(this).val();
            if (Short_gap < 0) {
                Short = 1;
            }
        });

        if (Short == 1) {
         
           shortage_stock_model();
        } else {
           
            $('#ajax_load').css("display", "none");
            
            alert("ok");
           
        } 
    });
    
</script>
