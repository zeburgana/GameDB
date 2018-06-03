<?php
/**
 * Created by PhpStorm.
 * User: lapdawg
 * Date: 18.5.31
 * Time: 04:40
 */

class manager
{
    public static function getManager($id) {
        $query = "select manager.id, name, time_working from manager 
                      where manager.id = ?";
        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute(array($id));
        $data = $stmt->fetchAll();

        if (count($data) == 0) {
            return false;
        }

        return $data[0];
    }

    public static function getManagerList($limit = null, $offset = null) {
        $query = "select manager.id, name, time_working from manager";
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

    public static function getManagerListCount() {
        $query = "select count(id) from manager";
        $stmt = mysql::getInstance()->query($query);
        $data = $stmt->fetchAll();
        return $data[0]['count(id)'];
    }

    public static function insertManager($data) {
        $query = "insert into manager (name, time_working) values (?, ?)";
        $stmt = mysql::getInstance()->prepare($query);
        $parameters = array($data['name'], $data['time_working']);
        if($data['name'] == "")
            $parameters[] = null;
        else $parameters[] = $data['name'];
        $stmt->execute($parameters);
    }

    public static function updateManager($data) {
        $query = "update manager set name = ?, time_working = ? where id = ?";
        $stmt = mysql::getInstance()->prepare($query);
        $parameters = array($data['name'], $data['time_working']);
        if($data['name'] == "")
            $parameters[] = null;
        else $parameters[] = $data['name'];
        $parameters[] = $data['id'];
        $stmt->execute($parameters);
    }

    public static function deleteManager($id) {
        $query = "delete from manager where id = ?";
        $stmt = mysql::getInstance()->prepare($query);
        try {
            $stmt->execute(array($id));
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public static function getMaxIdOfManager() {
        $query = "select max(id) from manager";
        $stmt = mysql::getInstance()->query($query);
        $data = $stmt->fetchAll();
        return $data[0]['max(id)'];
    }
}