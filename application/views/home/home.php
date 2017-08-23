<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Dashboard
        <small>Control panel</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3 id="Number_of_outlet">0</h3>
                    <p>Number Of Outlet</p>
                </div>
                <div class="icon">
                    <i class="fa fa-home"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3 id="Number_of_order">0</h3>
                    <p>New Orders</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3 id="Schedule_Call">0</h3>
                    <p>Schedule Call</p>
                </div>
                <div class="icon">
                    <i class="fa fa-random"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3 id="Strike_Rate">0</h3>
                    <p>Strike Rate</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div><!-- ./col -->

    </div><!-- /.row -->
    <!-- Main row -->

</section><!-- /.content -->


<?php $this->load->view('footer/footer'); ?>
<script>
    $(document).ready(function () {

        Number_of_order();
        Number_of_outlet();
        Schedule_Call();
        Strike_Rate();

    });

    function Number_of_order() {
        var start_date = "<?php echo $system_date; ?>";
        var end_date = "<?php echo $system_date; ?>";
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>Home/order_qty/",

            dataType: "html",
            success: function (data) {
                $("#Number_of_order").html(data);

            }
        });

    }
    function Number_of_outlet() {
        var start_date = "<?php echo $system_date; ?>";
        var end_date = "<?php echo $system_date; ?>";
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>Home/Number_of_outlet/",
            dataType: "html",
            success: function (data) {
                $("#Number_of_outlet").html(data);
            }
        });
    }
    function Schedule_Call() {
        var start_date = "<?php echo $system_date; ?>";
        var end_date = "<?php echo $system_date; ?>";
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>Home/Schedule_Call/",

            dataType: "html",
            success: function (data) {
                $("#Schedule_Call").html(data);
            }
        });
    }
    function Strike_Rate() {
        var start_date = "<?php echo $system_date; ?>";
        var end_date = "<?php echo $system_date; ?>";
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>Home/Strike_Rate/",

            dataType: "html",
            success: function (data) {
              
                $("#Strike_Rate").html(data);
            }
        });
    }
</script>