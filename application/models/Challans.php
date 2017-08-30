<?php

class Challans extends CI_Model {

    public function insertData($tbl, $data) {
        $this->db->insert($tbl, $data);

        return $this->db->insert_id();
    }

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

    public function getOrder_date($db_id, $psr_id, $date) {
        $sql = 'SELECT t1.db_id,t4.id as sku_id,t4.sku_name ,t5.qty As Pack_Size ,t2.outlet_lifting_price as PS_Price,t33.qty as stock, round(t2.outlet_lifting_price*t5.qty) AS Price,IFNULL(A.TotalQty,0) As totalQty FROM `tbli_db_bundle_price_mapping` as t1
            left join tbld_bundle_price_details as t2 on t1.bundle_price_id=t2.bundle_price_id         
            LEft join tbld_sku as t4 on t2.sku_id=t4.id
            LEft join tblt_inventory as t33 on t33.sku_id=t4.id
            left join(
                      SELECT t11.sku_id,t11.unit_sale_price,sum(t11.quantity_confirmed) As TotalQty
                      FROM `tblt_sales_order` as t10
                      inner join tblt_sales_order_line As t11 on t10.id=t11.so_id
                      where Challan_no=0 And so_status=1 and t10.planned_order_date="' . $date . '" and t10.db_id=' . $db_id . ' and t10.psr_id=' . $psr_id . '
                      GROUP by t11.sku_id) as A on A.sku_id=t2.sku_id
            LEft join tbld_unit as t5 on t4.db_default_mou_id=t5.id
            where  t1.db_id =' . $db_id . '
            order by t4.sku_type_id,t4.id';
        $result = $this->db->query($sql)->result_array();
        return $result;
    }

    public function getNumberOfMemobyOrder_date($db_id, $psr_id, $date) {
        $sql = 'SELECT count(id) As No_of_memo FROM `tblt_sales_order` as t10 where Challan_no=0 And so_status=1 And t10.planned_order_date="' . $date . '" and t10.db_id=' . $db_id . ' and t10.psr_id=' . $psr_id;
        $result = $this->db->query($sql)->result_array();
        return $result;
    }

    public function GetinventoryQtybySku_ID($skuid) {
        $sql = 'SELECT id,qty FROM tblt_inventory where sku_id=' . $skuid;
        $result = $this->db->query($sql)->result_array();
        return $result;
    }

    public function UpdateinventoryQtybyID($id, $qty) {
        $sql = 'update tblt_inventory set qty=' . $qty . ' WHERE sku_id=' . $id;
        $result = $this->db->query($sql);
        return $result;
    }

    public function getMemoid($db_id, $psr_id, $date) {
        $sql = 'SELECT id As memo_id FROM `tblt_sales_order` as t10 where Challan_no=0 And so_status=1 And t10.planned_order_date="' . $date . '" and t10.db_id=' . $db_id . ' and t10.psr_id=' . $psr_id;
        $result = $this->db->query($sql)->result_array();
        return $result;
    }

    public function MemoUpdate($id, $challan_id) {
        $sql = 'update tblt_sales_order set Challan_no=' . $challan_id . ',so_status=2 where Challan_no=0 And so_status=1 And id=' . $id;
        $result = $this->db->query($sql);
        return $result;
    }

    public function get_all_challan($where) {
        $sql = 'SELECT t2.db_channel_element_name as sub_route ,t3.first_name As PSR,t1.* FROM tblt_challan as t1 INNER join tbld_distribution_route as t2 on t1.route_id=t2.id INNER JOIN tbld_distribution_employee as t3 on t1.psr_id=t3.id where 1 ' . $where;
        $result = $this->db->query($sql)->result_array();
        return $result;
    }

    public function get_challanbyid($id) {
        $sql = 'SELECT t2.db_channel_element_name as sub_route ,t3.first_name As PSR,t1.* FROM tblt_challan as t1 INNER join tbld_distribution_route as t2 on t1.route_id=t2.id INNER JOIN tbld_distribution_employee as t3 on t1.psr_id=t3.id where t1.id=' . $id;
        $result = $this->db->query($sql)->result_array();
        return $result;
    }

    public function get_challanLinebyid($id, $db_id) {
        $sql = 'SELECT t4.sku_name,t4.id AS SKUID,B.Total_qty As Challan_qty,A.* from tbli_db_bundle_price_mapping as t1
                left join tbld_bundle_price_details as t2 on t1.bundle_price_id=t2.bundle_price_id         
                LEft join tbld_sku as t4 on t2.sku_id=t4.id
                inner join(
                SELECT t11.sku_id, t11.Pack_size,t11.unit_sale_price as price ,sum(t11.quantity_delivered) As Totaldelivered
                      FROM `tblt_sales_order` as t10
                      inner join tblt_sales_order_line As t11 on t10.id=t11.so_id
                      where Challan_no=' . $id . '
                      GROUP by t11.sku_id) as A on A.sku_id=t2.sku_id
                left join(
                SELECT t22.* FROM tblt_challan_line as t22 where t22.challan_id=1) as B on B.sku_id=t2.sku_id			  
                WHERE t1.db_id=' . $db_id;
        $result = $this->db->query($sql)->result_array();
        return $result;
    }

}
