<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Booth_model extends CI_Model
{

    public function __construct()
    {
    }

    // get all booth from tbl_booth
    public function all_booth_list()
    {
        $query = $this->db->get('tbl_booth');
        return $query->result_array();
    }

    // get all box from tbl_box
    public function all_box_list()
    {
        $query = $this->db->get('tbl_box');
        return $query->result_array();
    }
    
    // get box by id
    public function get_box_by_id($id)
    {
        $query = $this->db->get_where('tbl_box', array('id' => $id));
        return $query->result_array();
    }

    // get all transcations from tbl_transactions
    public function all_transaction_list()
    {
        $query = $this->db->get_where('tbl_transactions', array('is_deleted' => '0'));
        return $query->result_array();
    }

    // get all transcations from tbl_transactions
    public function all_user_list()
    {
        $query = $this->db->get_where('tbl_user', array('is_deleted' => '0'));
        return $query->result_array();
    }

    // get user by id
    public function get_user_by_id($id)
    {
        $query = $this->db->get_where('tbl_user', array('id' => $id, 'is_deleted' => '0'));
        return $query->result_array();
    }

    // update or insert user by id
    public function update_user_by_id($id, $user_name, $is_selected)
    {
        if($id > 0) {
            $this->db->where('id', $id);
            $query = $this->db->update('tbl_user', array('user_name' => $user_name, 'is_selected' => $is_selected));
        } else {
            $query = $this->db->insert('tbl_user', array('user_name' => $user_name, 'is_selected' => $is_selected));
        }
    }

    // get current user
    public function get_current_user()
    {
        $query = $this->db->get_where('tbl_user', array('is_selected' => '1', 'is_deleted' => '0'));
        return $query->result_array();
    }
    
    // remove user by id
    public function remove_user_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->update('tbl_user', array('is_deleted' => '1', 'is_selected' => '0'));
    }

    // get booth by id
    public function get_booth_by_id($id)
    {
        $query = $this->db->get_where('tbl_booth', array('id' => $id));
        return $query->result_array();
    }

    // get booth & box name from booth id
    public function get_booth_box_name_by_booth_id($booth_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_booth');
        $this->db->join('tbl_box', 'tbl_box.id = tbl_booth.box_id');
        $this->db->where(array('tbl_booth.id' => $booth_id));
        $query = $this->db->get();
        return $query->result_array();
    }

    // get work time
    public function all_time_list()
    {
        $query = $this->db->get('tbl_time');
        return $query->result_array();
    }

    // get work time by id
    public function get_work_time_by_id($id)
    {
        $query = $this->db->get_where('tbl_time', array('id' => $id));
        return $query->result_array();
    }
    
    // get booth transactions by booth_id
    public function get_transactions_by_booth_id($booth_id)
    {
        $query = $this->db->get_where('tbl_transactions', array('booth_id' => $booth_id, 'is_deleted' => '0'));
        return $query->result_array();
    }

    // get booth transactions by booth_id and status
    public function get_transactions_by_status($booth_id, $status)
    {
        $query = $this->db->get_where('tbl_transactions', array('booth_id' => $booth_id, 'status' => $status, 'is_deleted' => '0'));
        return $query->result_array();
    }

    // add booth transactions
    public function add_transaction($booth_id, $booth_name, $booth_type, $status, $gender, $age, $manager, $price)
    {
        $format = "%Y-%m-%d %h:%i:%s";

        if ($status == '0') {
            $this->db->where('id', $booth_id);
            $query = $this->db->update('tbl_booth', array('status' => '0'));

            $this->db->where('booth_id', $booth_id);
            $this->db->where('status', '1');
            $this->db->where('is_deleted', '0');
            $query = $this->db->update('tbl_transactions', array('exit_time' => @mdate($format), 'status' => $status));
        } else if ($status == '1') {
            $this->db->where('id', $booth_id);
            $query = $this->db->update('tbl_booth', array('status' => '1'));

            $query = $this->db->insert('tbl_transactions', array('booth_id' => $booth_id, 'booth_name' => $booth_name, 'booth_type' => $booth_type, 'user_name' => $manager, 'price' => $price, 'gender' => $gender, 'age' => $age, 'entrance_time' => @mdate($format), 'status' => $status, 'is_deleted' => '0'));
        }
    }

    // update time and fee table data
    public function update_timetable($day_start_time, $day_end_time, $night_start_time, $night_end_time, $box1_reg, $box1_nig, $box2_reg, $box2_nig, $box3_reg, $box3_nig, $box0_reg, $box0_nig)
    {
        $this->db->where('id', '0');
        $query = $this->db->update('tbl_box', array('price_regular' => $box0_reg, 'price_night' => $box0_nig));
        $this->db->where('id', '1');
        $query = $this->db->update('tbl_box', array('price_regular' => $box1_reg, 'price_night' => $box1_nig));
        $this->db->where('id', '2');
        $query = $this->db->update('tbl_box', array('price_regular' => $box2_reg, 'price_night' => $box2_nig));
        $this->db->where('id', '3');
        $query = $this->db->update('tbl_box', array('price_regular' => $box3_reg, 'price_night' => $box3_nig));

        $this->db->where('id', '0');
        $query = $this->db->update('tbl_time', array('start_time' => $day_start_time, 'end_time' => $day_end_time));
        $this->db->where('id', '1');
        $query = $this->db->update('tbl_time', array('start_time' => $night_start_time, 'end_time' => $night_end_time));
        
        return $query;
    }

    // cancel booth transactions
    public function cancal_transaction($booth_id, $status)
    {
        $format = "%Y-%m-%d %h:%i:%s";
        $this->db->where('id', $booth_id);
        $query = $this->db->update('tbl_booth', array('status' => '0'));

        $this->db->where('booth_id', $booth_id);
        $this->db->where('status', '1');
        $this->db->where('is_deleted', '0');
        $query = $this->db->update('tbl_transactions', array('exit_time' => @mdate($format), 'status' => $status));
    }

    // get booth price by box id and status = 0 : sale status
    public function remain_seat_count_by_box_id($box_id)
    {
        $sale_seats = $this->db->get_where('tbl_booth', array('box_id' => $box_id, 'status' => '0'))->result_array();
        return (count($sale_seats));
    }

    // get booth price by price type and box type
    public function set_sale_pause_seat($booth_id, $status)
    {
        $format = "%Y-%m-%d %h:%i:%s";

        if ($status == '0') {
            $this->db->where('id', $booth_id);
            $this->db->update('tbl_booth', array('status' => '2'));

            $this->db->insert('tbl_transactions', array('booth_id' => $booth_id, 'entrance_time' => @mdate($format), 'status' => '2'));
        } else if ($status == '2') {
            $this->db->where('id', $booth_id);
            $this->db->update('tbl_booth', array('status' => '0'));

            $this->db->where('booth_id', $booth_id);
            $this->db->where('status', '2');
            $this->db->update('tbl_transactions', array('exit_time' => @mdate($format), 'status' => '3'));
        }
    }

    public function set_sale_cancel_seat($booth_id)
    {
        $format = "%Y-%m-%d %h:%i:%s";

        $this->db->where('id', $booth_id);
        $this->db->update('tbl_booth', array('status' => '0'));

        $this->db->where('booth_id', $booth_id);
        $this->db->where('status', '1');
        $this->db->update('tbl_transactions', array('exit_time' => @mdate($format), 'status' => '0', 'is_deleted' => '1'));
    }

    // get transaction list by datetime TO and FROM
    public function get_transcation_list_by_dates($from, $to)
    {
        $query = $this->db->get_where('tbl_transactions', array('is_deleted' => '0', 'entrance_time>=' => $from, 'exit_time<=' <= $to));
        return $query->result_array();
    }
}
