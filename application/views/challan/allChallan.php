
<div class="row">

    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">All Order</h3>

            </div><!-- /.box-header -->
            <div style="padding: 10px;">
            <div class="box-body no-padding">
                 <table class="table table-striped table-bordered table-hover table-full-width" id="sample_3">
                    <thead>
                        <tr>
                            <th>
                                SL No.
                            </th>
                            <th>
                                Challan No
                            </th>
                            <th>
                                Sub Route  Name
                            </th>
                              
                            <th>
                                PSR Name
                            </th>
                            <th>
                                Total Memo
                            </th>
                            <th>
                                Order Qty
                            </th>
                            
                            <th>
                                Status
                            </th>
                             <th>
                                Status
                            </th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sl=1; foreach($all_challan as $challan){ ?>
                        <tr>
                            <td>
                               <?php echo $sl;$sl++; ?>
                            </td>
                             <td>
                                <?php echo $challan['challan_number']; ?>
                            </td>
                             <td>
                               <?php echo $challan['sub_route']; ?>
                            </td>
                             <td>
                               <?php echo $challan['PSR']; ?>
                            </td>
                             <td>
                               <?php echo $challan['No_of_memo']; ?>
                            </td>
                             <td>
                               <?php echo $challan['grand_total_CS']; ?>
                            </td>
                             <td>
                                 <?php $status=$challan['challan_status']; 
                                     if($status==1){//new Order?>
                                         <span class="label label-danger">New</span>
                                         <?php
                                     }elseif($status==2){ //Challan Created And Transit ?>
                                         <span class="label label-warning">Delivery</span>
                                         <?php
                                     }if($status==3){//Challan Confirm And Delveried ?>
                                         <span class="label label-success">New</span>
                                         <?php
                                     }
                                     ?>
                            </td>
                            <td>
                                 <a target="_blank" href="<?php echo base_url() ;?>challan/detailsbyid/<?php echo $challan['id']; ?>" class="btn btn-success btn-xs">Details</a>
                            </td>
                        </tr>
                        <?php } ?>
                       
                    </tbody>
                </table>
           
            </div><!-- /.box-body -->
            <div class="box-footer no-padding">

            </div>
            </div>
        </div><!-- /. box -->
    </div><!-- /.col -->
</div><!-- /.row -->


