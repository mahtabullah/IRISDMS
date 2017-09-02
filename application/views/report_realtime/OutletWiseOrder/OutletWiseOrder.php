<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Outlet Wise Order Report
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Outlet Wise Order Report</li>
    </ol>
</section>


<!-- Main content -->
<section class="content">
    <div class="row">
        <div id="DB_filter"></div>
        <div id="date_filter"></div>

    </div>
    <div class="row">

        <div id="extra_filter"></div>
    </div>
    <div class="row">
        <div id="filter_data">

        </div> <!-- Default box -->


    </div>
</section>

<?php
$this->load->view('footer/footer');
?>
<script type="text/javascript">
    $(document).ready(function () {
        DB_filter();
        singleDate_filter();
        extra_filter();
        OutletWiseOrder_filter();

    });

    function OutletWiseOrder_filter() {
        var url = "<?php echo site_url('report_realtime/OutletWiseOrder_filter'); ?>";
        $.ajax({
            type: "POST",
            url: url,
            success: function (data) {
                $('#filter_data').html(data);
                $('table').DataTable({                  
                    "sDom": '<"top">Tfrtip',
                     "bSort": false,
                    "iDisplayLength": 50                   
                });
              
               
            }
        });
    }

</script>
