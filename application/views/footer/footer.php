</div>
</div> 
</section>
</div>

<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 2.3.0
    </div>
    <strong>Copyright &copy; 2016-2017 <a href="#">Md. Mahtab Ullah</a>.</strong> All rights reserved.
</footer>



<script src="<?php echo base_url(); ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/fastclick/fastclick.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/app.min.js"></script>
<script src="<?php echo base_url(); ?>dist/js/demo.js"></script>
<script src="<?php echo base_url(); ?>plugins/select2/select2.full.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/input-mask/jquery.inputmask.js"></script>
<script src="<?php echo base_url(); ?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="<?php echo base_url(); ?>plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script src="<?php echo base_url(); ?>plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/timepicker/bootstrap-timepicker.min.js"></script>
<script src="<?php echo base_url(); ?>plugins/datatables/extensions/FixedHeader/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>plugins/iCheck/icheck.min.js"></script>
<script>
    var base_url = '<?php echo base_url(); ?>';
</script>
<script src="<?php echo base_url(); ?>plugins/datatables/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" language="javascript"
        src="<?php echo base_url(); ?>plugins/js2/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript"
        src="<?php echo base_url(); ?>plugins/js2/dataTables.tableTools.js"></script>



<script>
    $(document).ready(function () {
        var pathname = $(location).attr('href');
        $('[href="' + pathname + '"]').parent("li").addClass("active");
        $('[href="' + pathname + '"]').parent("li").parent("ul").parent("li").addClass("active");
        $('[href="' + pathname + '"]').parent("li").parent("ul").parent("li").parent("ul").parent("li").addClass("active");
        $('[href="' + pathname + '"]').parent("li").parent("ul").parent("li").parent("ul").parent("li").parent("ul").parent("li").addClass("active");
        var ReportName=$('[href="' + pathname + '"]').text();
                
        
        
        document.getElementById("title").innerHTML ="IRIS | "+ReportName

    });
    
     function DB_filter() {
        var url = "<?php echo site_url('report_filter/DB_filter'); ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            success: function (data) {
                $('#DB_filter').html(data);

            }
        });
    }
    function singleDate_filter() {
        var url = "<?php echo site_url('report_filter/singleDate_filter'); ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            success: function (data) {
                $('#date_filter').html(data);

            }
        });
    }
    function extra_filter() {
        var url = "<?php echo site_url('report_filter/singleDate_filter'); ?>"; // the script where you handle the form input.
        $.ajax({
            type: "POST",
            url: url,
            success: function (data) {
                $('#extra_filter').html(data);

            }
        });
    }
</script>
            

