
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
                                Action
                            </th>
                            <th>
                                SL No.
                            </th>
                            <th>
                                Memo No
                            </th>
                            <th>
                                Outlet Name
                            </th>
                                                       
                            <th>
                                Sub Route
                            </th>
                            <th>
                                PSR Name
                            </th>
                            <th>
                                Order Date
                            </th>
                            <th>
                                Order Qty
                            </th>
                            
                            <th>
                                Status
                            </th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sl=1;
                        foreach ($Order as $orderline) { ?>
                            <tr>
                                 <td>
                                     <?php $orderline['id']; ?>
                                     <?php $status=$orderline['so_status']; 
                                     if($status==1){//new Order?>
                                        <a target="_blank" href="<?php echo base_url() ;?>order/ordereditbyid/<?php echo $orderline['id']; ?>" class="btn btn-primary btn-xs">Edit</a>
                                         <?php
                                     }elseif($status==2){ //Challan Created And Transit ?>
                                       <a target="_blank" href="<?php echo base_url() ;?>order/ordereditbyid/<?php echo $orderline['id']; ?>" class="btn btn-yahoo btn-xs">Update Order</a>
                                         <?php
                                     }if($status==3){//Challan Confirm And Delveried ?>
                                         <a target="_blank" href="<?php echo base_url() ;?>order/orderdetailsbyid/<?php echo $orderline['id']; ?>" class="btn btn-primary btn-xs">Details</a>
                                         <?php
                                     }
                                     ?>
                                     
                                    
                                </td>
                                <td>
                                    <?php echo $sl;$sl++; ?>
                                </td>
                                <td>
                                    <?php echo $orderline['so_id']; ?>
                                </td>
                                <td>
                                     <?php echo $orderline['outlet_name']; ?>
                                </td>
                                
                                <td>
                                     <?php echo $orderline['sub_route']; ?>
                                </td>
                                <td>
                                     <?php echo $orderline['PSR']; ?>
                                </td>
                                <td>
                                    
                                    <?php echo date('d-m-Y',strtotime($orderline['planned_order_date'])); ?>
                                </td>
                                <td>
                                      <?php echo $orderline['Total_qty']; ?>
                                    
                                </td>
                                 
                                <td >
                                     <?php $status=$orderline['so_status']; 
                                     if($status==1){//new Order?>
                                         <span class="label label-danger">New</span>
                                         <?php
                                     }elseif($status==2){ //Challan Created And Transit ?>
                                         <span class="label label-warning">Delivery</span>
                                         <?php
                                     }if($status==3){//Challan Confirm And Delveried ?>
                                          <span class="label label-primary">Confirmed</span>
                                         <?php
                                     }
                                     ?>
                                   
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


