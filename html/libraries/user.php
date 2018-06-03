<?php
/**
 * Created by PhpStorm.
 * User: lapdawg
 * Date: 18.5.30
 * Time: 23.47
 */

class user
{

    public static function getUser($id) {
        $query = "select user.id, name, games_rented, games_bought, points from user 
                      where user.id = ?";
        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute(array($id));
        $data = $stmt->fetchAll();

        if (count($data) == 0) {
            return false;
        }

        return $data[0];
    }

    public static function getUserList($limit = null, $offset = null) {
        $query = "select user.id, name, games_rented, games_bought, points from user";
        $parameters = array();

        if(isset($limit)) {
            $query .= " limit ?";
            $parameters[] = $limit;
        }
        if(isset($offset)) {
            $query .= " offset ?";
            $parameters[] = $offset;
        }

        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();

        return $data;
    }

    public static function getUserListCount() {
        $query = "select count(id) from user";
        $stmt = mysql::getInstance()->query($query);
        $data = $stmt->fetchAll();
        return $data[0]['count(id)'];
    }

    public static function insertUser($data) {
        $query = "insert into user (name, games_rented, games_bought, points) values (?, ?, ?, ?)";
        $stmt = mysql::getInstance()->prepare($query);
        $parameters = array($data['name'], $data['games_rented'], $data['games_bought'], $data['points']);
        if($data['points'] == "")
            $parameters[] = null;
        else $parameters[] = $data['points'];
        $stmt->execute($parameters);
    }

    public static function updateUser($data) {
        $query = "update user set name = ?, games_rented = ?, games_bought = ?, points = ? where id = ?";
        $stmt = mysql::getInstance()->prepare($query);
        $parameters = array($data['name'], $data['games_rented'], $data['games_bought'], $data['points']);
        if($data['points'] == "")
            $parameters[] = null;
        else $parameters[] = $data['points'];
        $parameters[] = $data['id'];
        $stmt->execute($parameters);
    }

    public static function deleteUser($id) {
        $query = "delete from user where id = ?";
        $stmt = mysql::getInstance()->prepare($query);
        try {
            $stmt->execute(array($id));
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public static function getMaxIdOfUser() {
        $query = "select max(id) from user";
        $stmt = mysql::getInstance()->query($query);
        $data = $stmt->fetchAll();
        return $data[0]['max(id)'];
    }
}