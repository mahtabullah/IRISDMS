<?php

class orders extends CI_Model {

    /**
     *
     * @param string $where
     *
     * @return array
     */
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

    //////////////


    public function getOrderQty($db_id, $so_id) {
        $sql = "SELECT $db_id as db_id,sku_id,unit_sale_price,sum(quantity_confirmed) as qty FROM `tblt_sales_order_line` where so_id=$so_id
                group by db_id,sku_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }
    
   
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
        //      $sql = "SELECT outlet_lifting_price as price FROM `tbli_sku_mou_price_mapping` where sku_id=$sku_id and quantity=1";
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

    public function getDefaultMou($sku_id) {
        $sql = "SELECT t3.sku_code,t2.qty,t4.code FROM `tbli_sku_default_mou` as t1
              left join tbld_unit as t2 on t1.outlet_mou_id=t2.id
              LEFT JOIN tbld_sku as t3 on t1.sku_id = t3.id
              LEFT JOIN tbld_container_type as t4 on t3.sku_container_type_id = t4.id
              where t1.sku_id=$sku_id
              order by t2.qty desc";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getNextSalesOrderBySoId($so_id, $so_status, $type) {
        if ($type == 'mobile') {
            $where = "and t2.sales_order_type_id = 1";
        } else {
            if ($type == 'others') {
                $where = "and t2.sales_order_type_id>1";
            }
        }


        $sql = "SELECT t2.id FROM `tblt_sales_order` as t1
                        inner join `tblt_sales_order` as t2 on date(t1.order_date_time)=date(t2.order_date_time) and t1.sr_id=t2.sr_id
                        where t1.id=$so_id and t1.id!=t2.id and t2.so_status=$so_status $where";



        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getFreeSku($so_id, $promo_id) {
        $sql = "SELECT t2.sku_name_b as sku_name,t1.quantity_confirmed as qty,t3.ctn_size,t3.price FROM `tblt_sales_order_line` as t1
               left join tbld_sku as t2 on t1.sku_id=t2.id
               left join (SELECT t1.sku_id,max(t1.quantity) as ctn_size,round(max(db_lifting_price),2) as price FROM `tbli_sku_mou_price_mapping` as t1 group by t1.sku_id) as t3 on t2.id=t3.sku_id
                
               where t1.so_id=$so_id and t1.promotion_id=$promo_id and t1.sku_order_type_id=2";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function deleteExistingFreeSku($so_id, $promotion_id) {
        $sql = "delete FROM `tblt_sales_order_line` where so_id=$so_id and promotion_id=$promotion_id and sku_order_type_id=2";
        $query = $this->db->query($sql);

        return $query;
    }

    public function checkFreeSkuExistOrNot($so_id, $promotion_id, $sku_id) {
        $sql = "SELECT id FROM `tblt_sales_order_line` where so_id=$so_id and sku_id=$sku_id and promotion_id=$promotion_id and sku_order_type_id=2";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function checkInventoryBySo($so_id, $db_id) {
        $sql = "select c.so_id,c.sku_id,c.units_available,c.qty as required_qty,d.sku_name from (select a.sku_id,a.units_available,b.qty,b.so_id from  tbld_inventory as a
                inner join 
                (SELECT $db_id as db_id,sku_id,sum(quantity_confirmed) as qty,so_id FROM `tblt_sales_order_line` where so_id=$so_id 
                group by db_id,sku_id) as b 
                on a.dbhouse_id=b.db_id and a.sku_id=b.sku_id) as c 
                left join tbld_sku as d on c.sku_id=d.id
                where c.units_available<c.qty";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getCrateQty($sku_id, $qty) {
        $sql = "SELECT max(quantity) as qty FROM tbli_sku_mou_price_mapping WHERE sku_id = $sku_id;";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getSkyContainerType($sku_id) {
        $sql = "SELECT t2.code  FROM tbld_sku AS t1
                INNER JOIN tbld_container_type as t2 on t1.sku_container_type_id = t2.id
                WHERE t1.id = $sku_id;";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function salesOrderWiseDue($so_id) {
        $sql = "select * from
                (SELECT id as so_id,outlet_id,date(order_date_time) as due_date,db_id,total_order-(cash_received+manual_discount) as due_amount FROM `tblt_sales_order` where id=$so_id) as A
                ";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getSalesOrderById($so_id) {
        $sql = "select * from `tblt_sales_order` where id=$so_id";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getSalesOrderInfoWithPromotion($so_id) {
        $sql = "select D.sku_id,D.sku_code,D.sku_name_b as sku_name,D.ctn_size as pack_size,(D.unit_sale_price) as price,D.ctn_qty,D.piece_qty,
                '' as free_sku,sum(D.free_qty) as free_qty,'' as damage,
                D.total_sale_price as total_amount
                ,D.total_discount_amount as discount,D.total_billed_amount as netAmount,D.manual_discount
                from
                (select * from
                (select A.*,B.ctn_size,B.db_lifting_price,floor(A.quantity_confirmed/B.ctn_size) as ctn_qty,
                                (A.quantity_confirmed%B.ctn_size) as piece_qty,0 as free_qty  from
                (SELECT t1.sku_id,t2.sku_code,if(t2.sku_name_b='',t2.sku_name,t2.sku_name_b) as sku_name_b ,t1.quantity_confirmed,t1.unit_sale_price,t1.total_sale_price,t1.total_discount_amount,t1.total_billed_amount,t3.manual_discount FROM `tblt_sales_order_line` as t1
                left join tbld_sku as t2 on t1.sku_id=t2.id
                inner join tblt_sales_order as t3 on t1.so_id=t3.id
                where t1.so_id=$so_id and t1.sku_order_type_id=1) as A
                inner join
                (SELECT t1.sku_id,max(t1.quantity) as ctn_size,t1.db_lifting_price FROM `tbli_sku_mou_price_mapping` as t1

                group by t1.sku_id) as B on A.sku_id=B.sku_id) as C
                union all
                (select A.*,B.ctn_size,B.db_lifting_price,0 as ctn_qty,
                                0 as piece_qty,A.quantity_confirmed as free_qty  from
                (SELECT t1.sku_id,t2.sku_code,if(t2.sku_name_b='',t2.sku_name,t2.sku_name_b) as sku_name_b,t1.quantity_confirmed,t1.unit_sale_price,t1.total_sale_price,t1.total_discount_amount,t1.total_billed_amount,t3.manual_discount FROM `tblt_sales_order_line` as t1
                left join tbld_sku as t2 on t1.sku_id=t2.id
                inner join tblt_sales_order as t3 on t1.so_id=t3.id
                where t1.so_id=$so_id and t1.sku_order_type_id=2) as A
                inner join
                (SELECT t1.sku_id,max(t1.quantity) as ctn_size,t1.db_lifting_price FROM `tbli_sku_mou_price_mapping` as t1

                group by t1.sku_id) as B on A.sku_id=B.sku_id)) as D
                group by D.sku_id
                ";

        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getSalesOrderInfoHeader($id) {
        $sql = " SELECT t2.first_name AS sr_name,t3.db_channel_element_name AS sub_route_name, t2.contact_no AS psr_mobile FROM tblt_sales_order AS t1
                 INNER JOIN tbld_distribution_employee AS t2 ON t1.sr_id = t2.id
                 INNER JOIN tbld_distribution_channel_elements AS t3 ON t1.market_id = t3.id
                 INNER JOIN tbld_address AS t4 ON t2.dist_emp_address = t4.id where t1.id = $id ";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function getChallanIdBySoId($so_id) {
        $sql = "SELECT challan_id FROM `tbli_challan_sales_order_mapping` where so_id=$so_id and challan_status=1";
        $query = $this->db->query($sql)->result_array();

        return $query;
    }

    public function isAvailableBookedInventory($challan_id, $sku_id, $qty) {
        $sql = "SELECT t1.*,t2.sku_name FROM `tbld_booked_inventory` as t1
                      LEFT JOIN tbld_sku as t2 on t1.sku_id=t2.id
                      where t1.challan_id=$challan_id and t1.sku_id=$sku_id and t1.total_qty<$qty";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    /* Edit From MD:Rabius Sani Raju
     * ...............Business Requiremtn Where Codition...........
     * Not Allow External Product
     */

    public function getSoInfo($so_id) {
        $sql = "SELECT t2.sku_id,t2.quantity_confirmed as qty,t2.quantity_delivered,t2.unit_sale_price,t1.so_status FROM `tblt_sales_order` as t1
                      inner join `tblt_sales_order_line` as t2 on t1.id=t2.so_id 
                      left join `tbld_sku` as t3 on t3.id = t2.sku_id
                      where t1.id=$so_id and t3.sku_type_id !=99 ";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function isNewSku($challan_id, $sku_id) {
        $sql = "SELECT t1.* FROM `tbld_booked_inventory` as t1
                      where t1.challan_id=$challan_id and t1.sku_id=$sku_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getSkuQtyInfo($sku_id) {
        $sql = "select sku_name ,0 as qty_case,0 as qty_piece from tbld_sku where id=$sku_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getDbCode($db_id) {
        $sql = "SELECT dbhouse_code FROM `tbld_distribution_house` where id=$db_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getRouteCode($route_id) {
        $sql = "SELECT route_code FROM `tbld_route` where id=$route_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getSoSerial($sr_id) {
        $sql = "SELECT count(id)+1 as serial FROM `tblt_sales_order` where sr_id=$sr_id and planned_order_date=curdate()";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function getInvoiceNo($so_id) {
        $sql = "SELECT so_id FROM `tblt_sales_order` where id=$so_id";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    public function deliveryDamageBySoId($so_id) {
        $sql = "update `tblt_outlet_damage_order` AS t1
                    inner join (select id as so_id,outlet_id from tblt_sales_order where id= $so_id) as t2 
                    on t1.outlet_id=t2.outlet_id
                    set t1.so_id=t2.so_id
                    where t1.so_id = 0 and t1.stage ='END' ";
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

}
