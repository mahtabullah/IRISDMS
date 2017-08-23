<?php

class Homes extends CI_Model {

    function new_order_qty($start_date, $end_date, $db_ids) {
        $sql = 'SELECT count(id)as Number_of_order FROM `tblt_sales_order` WHERE db_id in ' . $db_ids . ' AND planned_order_date between "' . $start_date . '" and "' . $end_date . '"';
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    function total_outlet($db_ids) {

        $sql = 'SELECT count(id)as Number_of_outlet FROM `tbld_outlet` where status=1 and dbhouse_id in' . $db_ids;
        $query = $this->db->query($sql)->result_array();
        return $query;
    }

    function Total_Schedule_Call($start_date, $end_date, $db_ids) {
        $sql = 'SELECT count(t2.id) As SC FROM `tbld_route_plan_detail` as t1  INNER join tbld_outlet as t2 on t1.route_id=t2.parent_id
                where t1.dbhouse_id in' . $db_ids . ' and t2.status=1 And t1.planned_visit_date 
                between "' . $start_date . '" and "' . $end_date . '"';
        $query = $this->db->query($sql)->result_array();
        return $query;
    }
    //////////************\\\\\\\\\\\\\\\\\
}
