<?php

class orders extends CI_Model {

    function getAllsubroute($db_id) {
        $sql = "SELECT id,db_channel_element_name,db_channel_element_code FROM `tbld_distribution_route`  where `db_channel_element_category_id`=2 AND db_id=$db_id Order By db_channel_parent_element_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    function getOutletBySubroute($sub_routes_id, $SystemDate) {

        $sql = 'SELECT t1.id,t1.outlet_name as name FROM `tbld_outlet` as t1 where t1.parent_id=' . $sub_routes_id . ' and t1.status=1 and id  not in (SELECT DISTINCT(outlet_id) FROM `tblt_sales_order`where `planned_order_date` ="' . $SystemDate . '")';
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    function getRoutebByPSR($psr_id, $SystemDate) {

        $sql = 'SELECT t2.id,t2.db_channel_element_name as route,t2.db_channel_element_code FROM `tbld_route_plan_detail` As t1
INNER join tbld_distribution_route as t2 on t1.route_id=t2.id
where t1.dist_emp_id=' . $psr_id . ' AND t1.planned_visit_date="' . $SystemDate . '"';
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getSalesOrderInfo($where) {
        $sql = "SELECT t2.outlet_name,t3.first_name As PSR,t4.db_channel_element_name As sub_route,t6.Total_qty,t1.* FROM `tblt_sales_order` as t1
                Inner join ( SELECT so_id,sum(quantity_ordered/Pack_size) as Total_qty FROM `tblt_sales_order_line` group by so_id ) As t6 on t6.so_id=t1.id
                Inner join tbld_outlet as t2 on t1.outlet_id=t2.id
                Inner join tbld_distribution_employee AS t3 on t3.id=t1.Psr_id
                Inner join tbld_distribution_route as t4 on t4.id=t1.route_id
                where 1 $where"
                . " order by t1.Psr_id,t1.id ";
        //echo $sql;die();
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getOrderinfobyid($id) {
        $sql = 'SELECT t1.id as order_id,t1.so_id,t1.route_id,t3.db_channel_element_name as subroute,t1.outlet_id,t2.outlet_name,t1.psr_id,t4.first_name,t1.so_status FROM tblt_sales_order as t1  
                inner join tbld_outlet as t2 on t1.outlet_id=t2.id
                INNER join tbld_distribution_route as t3 on t3.id=t1.route_id
                inner join tbld_distribution_employee as t4 on t4.id=t1.psr_id
                where t1.id=' . $id;
        $query = $this->db->query($sql)->result_array();

        return $query;
    }
    public function getnextOrderid($id) {
        $sql = 'SELECT t1.id ,t1.psr_id ,t1.route_id FROM tblt_sales_order as t1 where t1.id=' . $id;
        $query = $this->db->query($sql)->result_array();
        $psr_id=$query[0][psr_id];
        $route_id=$query[0][route_id];
        $nextidsql = 'SELECT t1.id FROM tblt_sales_order as t1 where t1.id>'.$id.' AND  t1.psr_id='.$psr_id.' AND  t1.route_id='.$route_id.' Limit 1';
        $nextidquery = $this->db->query($nextidsql)->result_array();
      
       return $nextidquery[0][id];
    }
    
     public function getOrderLInebyid($id) {
        $sql = ' SELECT t2.sku_name,t1.* FROM tblt_sales_order_line as t1
            INNER join tbld_sku as t2 on t1.sku_id=t2.id
            where so_id =' . $id;
        $query = $this->db->query($sql)->result_array();

        return $query;
    }
   

    //////////////*\\\\\\\\\

    public function getsalesTypes() {


        $sql = "Select * from tbld_outlet_type";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getSrListByDbId($db_id) {
        $sql = "SELECT id,first_name FROM `tbld_distribution_employee` where distribution_house_id=$db_id and dist_role_id=2";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    /* --------------------------------------------------------------------------
     * get Filtered sku list
     * @table: tbld_sku
     * ------------------------------------------------------------------------- */

    public function getFilteredSku($block_sku_list) {

        if ($block_sku_list != '') {

            $where = "where id not in(" . implode(',', $block_sku_list) . ")";
        } else {
            $where = "";
        }
        $sql = "SELECT id,sku_code,sku_description as sku_name FROM `tbld_sku` $where";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    /* --------------------------------------------------------------------------
     * get data from `tbli_sku_mou_price_mapping`, by sku id and mou_id
     * ------------------------------------------------------------------------- */

    public function getDdPrice($unit_id, $product_id) {
        $this->db->select('outlet_lifting_price as price');
        $this->db->from('tbli_sku_mou_price_mapping');
        $this->db->where('mou_id', $unit_id);
        $this->db->where('sku_id', $product_id);
        $query = $this->db->get()->result_array();

        return $query;
    }

    /* --------------------------------------------------------------------------
     * Insert data to given table
     * @param_1 = table name
     * @param_2 = table data
     * @return last insert id
     * ------------------------------------------------------------------------- */

    public function insertData($tbl, $data) {
        $this->db->insert($tbl, $data);

        return $this->db->insert_id();
    }

    /* --------------------------------------------------------------------------
     * Update Table By column_name and set the data
     * @param string $tbl
     * @param int $id
     * @param array $data
     * @return boolearn
     * ------------------------------------------------------------------------- */

    public function updateTbl($tbl, $id, $data) {
        $this->db->where('id', $id);
        $query = $this->db->update($tbl, $data);

        return $query;
    }

    public function getDbpSrList($db_id) {
        $sql = "SELECT id,first_name as name FROM `tbld_distribution_employee` where distribution_house_id=$db_id and dist_role_id=2";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function get_unit_price($sku_id) {

        $sql = "SELECT t1.outlet_lifting_price as price, t2.sku_code, t2.sku_description
              FROM `tbli_sku_mou_price_mapping` as t1 
              Inner JOIN `tbld_sku` as t2 On t1.sku_id=t2.id
              where sku_id=$sku_id and quantity=1";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function get_sku_info($sku_id) {
        $sql = "SELECT * FROM `tbld_sku` where sku_id=$sku_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getSalesOrderById($so_id) {
        $sql = "select * from `tblt_sales_order` where id=$so_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

}
