<?php
/**
 * Created by PhpStorm.
 * Workplace: lapdawg
 * Date: 18.5.30
 * Time: 23.49
 */

class workplace
{

    public static function getWorkplace($id) {
        $query = "select workplace.id, city, address from workplace 
                      where workplace.id = ?";
        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute(array($id));
        $data = $stmt->fetchAll();

        if (count($data) == 0) {
            return false;
        }

        return $data[0];
    }

    public static function getWorkplaceList($limit = null, $offset = null) {
        $query = "select workplace.id, city, address from workplace ";
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

    public static function getWorkplaceListCount() {
        $query = "select count(id) from workplace";
        $stmt = mysql::getInstance()->query($query);
        $data = $stmt->fetchAll();
        return $data[0]['count(id)'];
    }

    public static function insertWorkplace($data) {
        $query = "insert into workplace (city, address) values (?, ?)";
        $stmt = mysql::getInstance()->prepare($query);
        $parameters = array($data['city'], $data['address']);
        if($data['address'] == "")
            $parameters[] = null;
        else $parameters[] = $data['address'];
        $stmt->execute($parameters);
    }

    public static function updateWorkplace($data) {
        $query = "update workplace set city = ?, address = ?";
        $stmt = mysql::getInstance()->prepare($query);
        $parameters = array($data['city'], $data['address']);
        if($data['address'] == "")
            $parameters[] = null;
        else $parameters[] = $data['address'];
        $parameters[] = $data['id'];
        $stmt->execute($parameters);
    }

    public static function deleteWorkplace($id) {
        $query = "delete from workplace where id = ?";
        $stmt = mysql::getInstance()->prepare($query);
        try {
            $stmt->execute(array($id));
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public static function getMaxIdOfWorkplace() {
        $query = "select max(id) from workplace";
        $stmt = mysql::getInstance()->query($query);
        $data = $stmt->fetchAll();
        return $data[0]['max(id)'];
    }
}