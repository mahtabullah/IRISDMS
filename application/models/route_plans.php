<?php

class Route_plans extends CI_Model {

    public function getAllRoutePlan($db_id) {
        $sql = "SELECT t1.id,t1.route_plan_name,t1.route_plan_code,t4.dbhouse_name,t3.first_name,t1.Modify_date,t1.start_date,end_date FROM `tbld_route_plan` as t1
                    inner join tbld_distribution_employee as t3 on t1.dist_emp_id = t3.id 
                left join tbld_distribution_house as t4 on t1.dbhouse_id=t4.id
                where t1.dbhouse_id=$db_id ";
        $result = $this->db->query($sql)->result_array();
        return $result;
    }

    public function getDbpSrList($db_id) {
        $sql = "SELECT id,first_name as name FROM `tbld_distribution_employee` where distribution_house_id=$db_id and dist_role_id=2";
        $query = $this->db->query($sql)->result_array();

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
}
