<?php
/**
 * Created by PhpStorm.
 * User: lapdawg
 * Date: 18.5.30
 * Time: 23.48
 */

class employee
{
    public static function getEmployee($id) {
        $query = "select employee.id, name, games_sold, time_working, games_rented from employee 
                      where employee.id = ?";
        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute(array($id));
        $data = $stmt->fetchAll();

        if (count($data) == 0) {
            return false;
        }

        return $data[0];
    }

    public static function getEmployeeList($limit = null, $offset = null) {
        $query = "select employee.id, name, games_sold, time_working, games_rented from employee";
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

    public static function getEmployeeListCount() {
        $query = "select count(id) from employee";
        $stmt = mysql::getInstance()->query($query);
        $data = $stmt->fetchAll();
        return $data[0]['count(id)'];
    }

    public static function insertEmployee($data) {
        $query = "insert into employee (name, games_sold, time_working, games_rented) values (?, ?, ?, ?)";
        $stmt = mysql::getInstance()->prepare($query);
        $parameters = array($data['name'], $data['games_sold'], $data['time_working'], $data['games_rented']);
        if($data['name'] == "")
            $parameters[] = null;
        else $parameters[] = $data['name'];
        $stmt->execute($parameters);
    }

    public static function updateEmployee($data) {
        $query = "update employee set name = ?, games_sold = ?, time_working = ?, games_rented = ? where id = ?";
        $stmt = mysql::getInstance()->prepare($query);
        $parameters = array($data['name'], $data['games_sold'], $data['time_working'], $data['games_rented']);
        if($data['name'] == "")
            $parameters[] = null;
        else $parameters[] = $data['name'];
        $parameters[] = $data['id'];
        $stmt->execute($parameters);
    }

    public static function deleteEmployee($id) {
        $query = "delete from employee where id = ?";
        $stmt = mysql::getInstance()->prepare($query);
        try {
            $stmt->execute(array($id));
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public static function getMaxIdOfEmployee() {
        $query = "select max(id) from employee";
        $stmt = mysql::getInstance()->query($query);
        $data = $stmt->fetchAll();
        return $data[0]['max(id)'];
    }
}