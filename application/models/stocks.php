<?php

class stocks extends CI_Model {

    function current_stock($db_ids) {
        $sql = "SELECT t1.db_id,t4.id,t4.sku_name,round(t2.db_lifting_price,4) AS Price,t5.qty As Pack_Size,IFNULL(t3.qty,0)/t5.qty As Total_Qty,floor(IFNULL(t3.qty,0)/t5.qty) As Total_Qty_cs ,IFNULL(t3.qty,0)%t5.qty as Total_Qty_ps
            FROM `tbli_db_bundle_price_mapping` as t1
            left join tbld_bundle_price_details as t2 on t1.bundle_price_id=t2.bundle_price_id
            LEFT join tblt_inventory as t3 on t3.sku_id=t2.sku_id
            LEft join tbld_sku as t4 on t2.sku_id=t4.id
            LEft join tbld_unit as t5 on t4.db_default_mou_id=t5.id
            where  t1.db_id in(" . $db_ids . ") order by t4.sku_type_id,t4.id"
             ;
        $result = $this->db->query($sql)->result_array();
        return $result;
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
    
     public function inventory_qty_check($db_id,$sku_id){
         $sql ='SELECT id FROM tblt_inventory WHERE db_id='.$db_id.' and sku_id='.$sku_id;
         $result = $this->db->query($sql)->result_array();
        return $result;
    }
    public function GetinventoryQtybyID($id){
         $sql ='SELECT id,qty FROM tblt_inventory WHERE id='.$id;
         $result = $this->db->query($sql)->result_array();
        return $result;
    }
     public function UpdateinventoryQtybyID($id,$qty){
         $sql ='update tblt_inventory set qty='.$qty.' WHERE id='.$id;
         $result = $this->db->query($sql);
        return $result;
    }
}
