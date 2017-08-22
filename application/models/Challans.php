<?php

class Challans extends CI_Model {
    
     public function getDbpSrList($db_id) {
        $sql = "SELECT id,first_name as name FROM `tbld_distribution_employee` where distribution_house_id=$db_id and dist_role_id=2";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }
    public function getPsrid($id) {
        $sql = "SELECT id,first_name as name FROM `tbld_distribution_employee` where id=$id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }
    
     public function getOrder_date($db_id,$psr_id,$date) {
     $sql ='SELECT t1.db_id,t4.id as sku_id,t4.sku_name ,t5.qty As Pack_Size ,t2.outlet_lifting_price as PS_Price, round(t2.outlet_lifting_price*t5.qty) AS Price,IFNULL(A.TotalQty,0) As totalQty FROM `tbli_db_bundle_price_mapping` as t1
            left join tbld_bundle_price_details as t2 on t1.bundle_price_id=t2.bundle_price_id         
            LEft join tbld_sku as t4 on t2.sku_id=t4.id
            left join(
                      SELECT t11.sku_id,t11.unit_sale_price,sum(t11.quantity_ordered) As TotalQty
                      FROM `tblt_sales_order` as t10
                      inner join tblt_sales_order_line As t11 on t10.id=t11.so_id
                      where Challan_no=0 And so_status=1 and t10.planned_order_date="'.$date.'" and t10.db_id='.$db_id.' and t10.psr_id='.$psr_id.'
                      GROUP by t11.sku_id) as A on A.sku_id=t2.sku_id
            LEft join tbld_unit as t5 on t4.db_default_mou_id=t5.id
            where  t1.db_id ='.$db_id.'
            order by t4.sku_type_id,t4.id';
     $result= $this->db->query($sql)->result_array();
     return $result;
    
}
 public function getNumberOfMemobyOrder_date($db_id,$psr_id,$date) {
     $sql ='SELECT count(id) As No_of_memo FROM `tblt_sales_order` as t10 where Challan_no=0 And so_status=1 And t10.planned_order_date="'.$date.'" and t10.db_id='.$db_id.' and t10.psr_id='.$psr_id;
     $result= $this->db->query($sql)->result_array();
     return $result;
    
}
}
