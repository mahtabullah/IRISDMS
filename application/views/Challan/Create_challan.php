
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



    <form role="form" id="add_stock_form" action="<?php echo site_url('stock/add_stock'); ?>"
          method="post">
        <!-- BEGIN FORM-->
        <div class="row">
            <div class="col-md-12" >
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-12" >
                            <div class="form-group">
                                <label class="control-label text-right control-label-left col-sm-2" for="field1">PSR :</label>
                                <div class="controls col-md-4">
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
                            <div class="row">
                                <div class="col-md-12" >
                                    &nbsp;
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="control-label  text-right control-label-left col-sm-2" for="field2">Order Date :</label>
                                <div class="controls col-md-4">

                                    <input type="text" class="form-control" required name="challan_date" id="challan_date" />

                                </div>
                                <div class="row">
                                    <div class="col-md-12" >
                                        &nbsp;
                                    </div>

                                </div>
                                <div class="form-group">
                                    <label class="control-label  text-right control-label-left col-sm-2" for="field2">Sub Route Name :</label>
                                    <div class="controls col-md-4">

                                        <input type="text" class="form-control" name="Sub_route" id="Sub_route" />

                                    </div>
                                    <a href="#" onclick="add_challan_part();" class="btn btn-success" id="search_data"> Search</a>

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
    /*add row*/
    function add_challan_part() {
        var PSR = $("#PSR").val();
        var Challan_Date = $("#challan_date").val();



        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>challan/add_challan_part",
            data:{PSR_id: PSR,Orderdate: Challan_Date},
            dataType: "html",
            success: function (data) {
                $('#challan_part').html(data);
            }
        });
    }


</script>
