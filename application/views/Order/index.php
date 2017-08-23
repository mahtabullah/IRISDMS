<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
$Systemdate = $this->session->userdata('System_date');
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
                Sales Order
                <i class="fa fa-angle-right"></i>
            </li>

        </ul>
        <!-- END PAGE TITLE & BREADCRUMB-->
    </div>
</div>

<div id="filter_option">
    <div class="row">
        <div class="col-md-12 ">
            <!-- BEGIN SAMPLE FORM PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">

                </div>
                <div class="portlet-body form">   
                    <div class="row">
                        <div class="col-md-12">
                            <div style="padding: 10px;">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Date Range</label>
                                            <div class="input-group date-picker input-daterange" >
                                                <input type="text" class="form-control" name="date_frm" id="date_frm" value="<?php echo date("d-m-Y", strtotime($Systemdate)); ?>" />
                                                <span class="input-group-addon">
                                                    to
                                                </span>
                                                <input type="text" class="form-control" name="date_to" id="date_to" value="<?php echo date("d-m-Y", strtotime($Systemdate)); ?>">
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">PSR</label>

                                            <select class="form-control select2" name="PSR" id="PSR" onchange="">
                                                <option ></option>
                                                <?php foreach ($PSR As $Emp) { ?>                                                 
                                                    <option value="<?php echo $Emp[id]; ?>" ><?php echo $Emp[name]; ?></option>
                                                    <?php
                                                }
                                                ?>  

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Sub Route</label>
                                            <select class="form-control select2" id="Sub_Route" onchange="">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Outlet</label>
                                            <select class="form-control select2" id="outlet">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label">Order Status</label>
                                            <select class="form-control select2" id="sales_status">
                                                <option selected value="0">All</option>
                                                <option value="1">New</option>                                                
                                                <option value="2">Delivery</option>
                                                <option value="3">Confirmed</option>
                                                <option value="6">Cancel</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="control-label"></label>
                                            <button style="margin-top: 25px; margin-left: 25px;" class="btn btn-success" onclick="getallData();">Search</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>           
            </div>
        </div>
    </div>

</div>

<div id="all_order_info">

</div>



<?php
$this->load->view('footer/footer');
?>
<script>
    $(document).ready(function () {

        $("#PSR,#sales_status,#Sub_Route,#outlet").select2({
            placeholder: "Select",
            allowClear: true
        });
        $("#date_frm,#date_to").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true

        });
        getallData();
    });

    function getRouteBySrAndDateRange() {}

    function getallData() {
        var date_frm = $('#date_frm').val();
        var date_to = $('#date_to').val();
        var PSR = $('#PSR').val();
        var Sub_Route = $('#Sub_Route').val();
        var sales_status = $('#sales_status').val();

        $('#ajax_load').css("display", "block");
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>order/allorder/",
            data: {date_frm: date_frm, date_to: date_to, PSR: PSR, Sub_Route: Sub_Route, sales_status: sales_status},
            dataType: "html",
            success: function (data) {
                $("#all_order_info").html(data);
                $('#sample_3').DataTable({
                    dom: 'T<"clear">lfrtip',
                    "bSort": false,
                    "iDisplayLength": 100
                });
                $('#ajax_load').css("display", "none");
            }
        });
    }
</script>
