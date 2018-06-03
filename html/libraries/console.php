<?php
/**
 * Automobilių modelių redagavimo klasė
 *
 * @author ISK
 */

class Console {

    public static function getConsole($id) {
        $query = "select console.id, name, cpu, gpu, max_resolution_output, wifi_adapter, controller_support, RJ_45, VR_ready, backwards_compatibility, online_store, price from console 
                      where console.id = ?";
        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute(array($id));
        $data = $stmt->fetchAll();

        if (count($data) == 0) {
            return false;
        }

        return $data[0];
    }

    public static function getConsoleList($limit = null, $offset = null) {
        $query = "select console.id, name, cpu, gpu, max_resolution_output, wifi_adapter, controller_support, RJ_45, VR_ready, backwards_compatibility, online_store, price from console";
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

    public static function getConsoleListCount() {
        $query = "select count(id) from console";
        $stmt = mysql::getInstance()->query($query);
        $data = $stmt->fetchAll();
        return $data[0]['count(id)'];
    }

    public static function insertConsole($data) {
        $query = "insert into console (name, cpu, gpu, max_resolution_output, wifi_adapter, controller_support, RJ_45, VR_ready, backwards_compatibility, online_store, price) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysql::getInstance()->prepare($query);
        $parameters = array($data['name'], $data['cpu'], $data['gpu'], $data['controller_support'], $data['wifi_adapter'],$data['controller_support'],$data['RJ_45'],$data['VR_ready'],$data['backwards_compatibility'],$data['online_store'],$data['price']);
        if($data['price'] == "")
            $parameters[] = null;
        else $parameters[] = $data['price'];
        $stmt->execute($parameters);
    }

    public static function updateConsole($data) {
        $query = "update Consoles set name = ?, brewery_id = ?, style_id = ?, abv = ?, ibu = ? where id = ?";
        $stmt = mysql::getInstance()->prepare($query);
        $parameters = array($data['name'], $data['cpu'], $data['gpu'], $data['controller_support'], $data['wifi_adapter'],$data['controller_support'],$data['RJ_45'],$data['VR_ready'],$data['backwards_compatibility'],$data['online_store'],$data['price']);
        if($data['price'] == "")
            $parameters[] = null;
        else $parameters[] = $data['price'];
        $parameters[] = $data['id'];
        $stmt->execute($parameters);
    }

    public static function deleteConsole($id) {
        $query = "delete from console where id = ?";
        $stmt = mysql::getInstance()->prepare($query);
        try {
            $stmt->execute(array($id));
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public static function getMaxIdOfConsole() {
        $query = "select max(id) from console";
        $stmt = mysql::getInstance()->query($query);
        $data = $stmt->fetchAll();
        return $data[0]['max(id)'];
    }
}