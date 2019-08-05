<?php

defined('BASEPATH') or exit('No direct script access allowed');

class SubMenu_model extends CI_Model
{
    public function getSubMenu()
    {
        $query = "SELECT `title`, `menu`, `url`,`icon`,`is_active`
        FROM `user_menu` JOIN `user_sub_menu`
        ON `user_menu`.`id` = `user_sub_menu`.`menu_id` 
        ORDER BY `user_sub_menu`.`menu_id` ASC";

        return $this->db->query($query)->result_array();
    }
    public function getMenu()
    {
        // $this->db->select('menu');
        return $this->db->get('user_menu')->result_array();
    }
}
