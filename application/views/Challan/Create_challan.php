
<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Create Challan
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Create Challan</li>
    </ol>
</section>


<!-- Main content -->
<section class="content">



    <form role="form" id="add_Challan_form" action="<?php echo site_url('challan/add_challan'); ?>"
          method="post">
        <!-- BEGIN FORM-->
        <div class="row">
            <div class="col-md-12" >
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-12" >
                            <div class="row">
                                <div class="col-md-12" >
                                    <div class="form-group">
                                        <label class="control-label  text-right control-label-left col-sm-2" for="field2">Order Date :</label>
                                        <div class="controls col-md-4">
                                            <input type="text" class="form-control" onchange="getsubroute();" required name="challan_date" id="challan_date" />

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12" >
                                    <div class="form-group">
                                        <label class="control-label text-right control-label-left col-sm-2" for="field1">PSR :</label>
                                        <div class="controls col-md-4">
                                            <select class="form-control select2" name="PSR" id="PSR" onchange="getsubroute();">
                                                <option ></option>
                                                <?php foreach ($PSR As $Emp) { ?>                                                 
                                                    <option value="<?php echo $Emp[id]; ?>" ><?php echo $Emp[name]; ?></option>
                                                    <?php
                                                }
                                                ?>  
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12" >
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="control-label  text-right control-label-left col-sm-2" for="field2">Sub Route Name :</label>
                                            <div class="controls col-md-4">

                                                <select class="form-control select2" required name="sub_Route" id="sub_Route" onchange="">
                                                    <option ></option>

                                                </select>

                                            </div>
                                            <a onclick="checkMemo();" class="btn btn-success" id="search_data"> Search</a>

                                        </div>

                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" >&nbsp;</div>
                </div>
                <div class="row">
                    <div id="challan_part">


                    </div>

                </div>
            </div>

        </div>
        </div>
        
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Stock</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <td>Sku Name</td>
                                <td>Stock Qty</td>
                                <td>Order Qty</td>
                                <td>Stock Gap</td>                                
                            </tr>
                            </thead>
                            <tbody id="modal_table">
                                
                            </tbody>
                        </table>
                        <p id="Model_data"></p>
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
    function getsubroute() {
        var psr_id = $("#PSR").val();
        var Challan_Date = $("#challan_date").val();

        if (psr_id != '') {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>Challan/getRoutebByPSR/",
                data: {psr_id: psr_id, Date: Challan_Date},
                dataType: "html",
                success: function (data) {
                    $("#sub_Route").empty();
                    $("#sub_Route").append(data);
                    $("#sub_Route").select2({
                        placeholder: "Select...",
                        allowClear: true

                    });
                }


            });
        }
    }
    function checkMemo() {
        var PSR = $("#PSR").val();
        var Challan_Date = $("#challan_date").val();
        var Sub_Route = $("#sub_Route").val();

        if ($("#PSR").val() && $("#challan_date").val() && $("#sub_Route").val()) {

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>challan/No_of_memo",
                data: {PSR_id: PSR, Orderdate: Challan_Date, Sub_Route: Sub_Route},
                dataType: "html",
                success: function (data) {
                    if (data != 0) {
                        add_challan_part();
                    } else {
                        $('#challan_part').html('<h1 class="text-danger">You Have not Any Memo to Create Challan </h1>');
                    }
                }
            });
        } else {
            alert("Fill all Field ");
        }
    }
    /*add challan part*/
    function add_challan_part() {
        var PSR = $("#PSR").val();
        var Challan_Date = $("#challan_date").val();
        var Sub_Route = $("#sub_Route").val();

        if ($("#PSR").val() && $("#challan_date").val() && $("#sub_Route").val()) {
            $('#ajax_load').css("display", "block");

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>challan/add_challan_part",
                data: {PSR_id: PSR, Orderdate: Challan_Date, Sub_Route: Sub_Route},
                dataType: "html",
                success: function (data) {
                    $('#challan_part').html(data);
                    $('#ajax_load').css("display", "none");
                }
            });
        } else {
            alert("Fill all Field ");
        }
    }

    function total_qty(id) {
        var index = id;
        var Pack_Size = $("#Pack_Size" + index).val();
        var TP_price = $("#TP_price" + index).val();

        var order_qty_CS = $("#order_qty_CS" + index).val();
        order_qty_CS = (order_qty_CS != '') ? parseInt(order_qty_CS) : 0;
        var order_qty_PS = $("#order_qty_PS" + index).val();
        order_qty_PS = (order_qty_PS != '') ? parseInt(order_qty_PS) : 0;

        var ExtraCS_Qty = $("#ExtraCS_Qty" + index).val();
        ExtraCS_Qty = (ExtraCS_Qty != '') ? parseInt(ExtraCS_Qty) : 0;
        var ExtraPS_Qty = $("#ExtraPS_Qty" + index).val();
        ExtraPS_Qty = (ExtraPS_Qty != '') ? parseInt(ExtraPS_Qty) : 0;
        var Total = ((order_qty_CS + ExtraCS_Qty) * Pack_Size) + order_qty_PS + ExtraPS_Qty;

        var ExtraTotal = (ExtraCS_Qty * Pack_Size) + ExtraPS_Qty;

        var total_qty_CS = $("#total_qty_CS" + index).val();
        total_qty_CS = (total_qty_CS != '') ? parseInt(total_qty_CS) : 0;
        var total_qty_PS = $("#total_qty_CS" + index).val();
        total_qty_PS = (total_qty_PS != '') ? parseInt(total_qty_PS) : 0;


        var stock = $("#stock" + index).val();
        stock = (stock != '') ? parseInt(stock) : 0;

        var Total = ((order_qty_CS + ExtraCS_Qty) * Pack_Size) + order_qty_PS + ExtraPS_Qty;



        $("#stockgap" + index).val(stock - Total);

        $("#total_qty_CS" + index).val(parseInt(Total / Pack_Size));
        $("#total_qty_PS" + index).val(parseInt(Total % Pack_Size));
        $("#Grand_total_qty_CS" + index).val(Total / Pack_Size);
        $("#Extra_Qty" + index).val(ExtraTotal);
        $("#Total_qty" + index).val(Total);
        $("#total_amount" + index).val(parseFloat(Total * TP_price).toFixed(2));

        grand_total_amount();
    }


    function grand_total_amount() {
        var total_amount = 0;
        var Total_qty = 0;

        $('input[name="total_amount[]"]').each(function () {
            var amount = $(this).val();
            if (amount) {
                total_amount = total_amount + parseFloat(amount);
            }
        });
        $('input[name="Grand_total_qty_CS[]"]').each(function () {
            var qty_cs = $(this).val();
            if (qty_cs) {
                Total_qty = Total_qty + parseFloat(qty_cs);
            }
        });

        $("#grand_total_CS").val(parseFloat(Total_qty).toFixed(2));
        $("#grand_total").val(parseFloat(total_amount).toFixed(2));

    }

    function check_stock() {
        $('input[name="stockgap[]"]').each(function () {
            var stock_gap = $(this).val();
            var id = $(this).attr('id');
            var index = id.slice(8);


            if (stock_gap < 0) {
                var sku_id = $("#sku_id" + index).val();
                var sku_name = $("#sku_name" + index).val();
                var curent_stock = $("#stock" + index).val();
                var stockgap = $("#stockgap" + index).val();
               
                 $('#modal_table').html(sku_name + '-' + sku_id + '-' + curent_stock + '-' + stockgap); 
                 $('#myModal').modal('show');

            }
        });
    }
    $('#add_Challan_form').unbind('submit').bind('submit', function (e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.
        check_stock();



        /* $('#ajax_load').css("display", "block");
         
         var url = "<?php echo site_url('challan/add_challan'); ?>"; // the script where you handle the form input.
         
         $.ajax({
         type: "POST",
         url: url,
         data: $("#add_Challan_form").serialize(), // serializes the form's elements.
         success: function (data) {
         $('#challan_part').html('');
         $('#ajax_load').css("display", "none");
         
         
         }
         });
         */
    });
</script>
