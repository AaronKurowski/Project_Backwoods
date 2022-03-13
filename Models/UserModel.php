<?php

require_once PROJECT_ROOT_PATH . "/Models/MydbAccessLayer.php";

class UserModel extends MydbAccessLayer
{
    public function getUsers($limit)
    {
        return $this->select("SELECT * FROM users ORDER BY userId ASC LIMIT :lim", [":lim" => $limit]);
    }
}