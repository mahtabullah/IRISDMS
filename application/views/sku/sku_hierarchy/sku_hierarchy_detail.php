<?php
$this->load->view('header/header');
$data['role']=$this->session->userdata('user_role');$this->load->view('left/left',$data);
?>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                   Product Hierarchy
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo site_url('home/home_page'); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <a href="<?php echo site_url('sku/skuHierarchyIndex'); ?>">SKU Hierarchy</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li>
                        <p>Detail</p>
                    </li>
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 ">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-edit"></i>Edit 
                        </div>
                        <div class="tools">
                            <a href="" class="collapse"></a>                           
                        </div>
                    </div>
                    <?php
                        foreach ($sku_hierarchy_data_by_id as $key){
                            $id = $key['id'];
                            $layer_name = $key['layer_name'];
                            $layer_code = $key['layer_code'];
                            $layer_description = $key['layer_description'];
                            $parent_layer_id = $key['parent_layer_id'];
                        }   
                    ?>
                    <div class="portlet-body form">
                        <form role="form" action="" method="post" novalidate>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" value="<?php echo $layer_name;?>" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code">Code</label>
                                            <input type="text" class="form-control" id="code" name="code" value="<?php echo $layer_code;?>" required readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" rows="3" id="description" name="description" readonly placeholder="Description"><?php echo $layer_description;?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="parent_layer">Parent Layer</label>
                                            <select class="form-control input-xlarge select2me" disabled data-placeholder="Select..." id="parent_layer" name="parent_layer">
                                               <option value=""></option>
                                                <?php
                                                    foreach ($sku_hierarchy as $key) {
                                                            $selected = ($key['id'] == $parent_layer_id) ? " selected='selected'" : "";
                                                            echo '<option value="'.$key['id'].'"'.$selected.'>'.$key['layer_name'].'</option>';
                                                        }
                                                ?>                                               
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <a class="btn red" href="<?php echo base_url()?>sku/skuHierarchyDeleteById/<?php echo $sku_id;?>" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                <button type="button" class="btn default" onclick="document.location.href='<?php echo site_url('sku/skuHierarchyIndex');?>'">Back</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('footer/footer');
?>