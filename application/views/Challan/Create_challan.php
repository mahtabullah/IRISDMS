
<?php
$this->load->view('header/header');
$data['role'] = $this->session->userdata('user_role');
$this->load->view('left/left', $data);
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Challan
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Create Challan</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

    
    
    

</section><!-- /.content -->

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
        
    });


    }
</script>
