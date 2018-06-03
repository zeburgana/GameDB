<?php
/**
 * Automobilių modelių redagavimo klasė
 *
 * @author ISK
 */
class game {

    public static function getGame($id) {
        $query = "select game_info.id, name, release_date, genre, developer, publisher from game_info
                      where game_info.id = ?";
        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute(array($id));
        $data = $stmt->fetchAll();

        if (count($data) == 0) {
            return false;
        }

        return $data[0];
    }

    public static function getGameList($limit = null, $offset = null) {
        $query = "select game_info.id, name, release_date, genre, developer, publisher from game_info";
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

    public static function getGameListCount() {
        $query = "select count(id) from game_info";
        $stmt = mysql::getInstance()->query($query);
        $data = $stmt->fetchAll();
        return $data[0]['count(id)'];
    }

    public static function insertGame($data) {
        $query = "insert into game_info (name, release_date, genre, developer, publisher, in_stock, price) values (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysql::getInstance()->prepare($query);
        $parameters = array($data['name'], $data['release_date'], $data['genre'], $data['developer'], $data['publisher'], $data['in_stock'], $data['price']);
        if($data['price'] == "")
            $parameters[] = null;
        else $parameters[] = $data['price'];
        $stmt->execute($parameters);
    }

    public static function updateGame($data) {
        $query = "update game_info set name = ?, release_date = ?, genre = ?, developer = ?, publisher = ?, in_stock = ?, price = ? where id = ?";
        $stmt = mysql::getInstance()->prepare($query);
        $parameters = array($data['name'], $data['release_date'], $data['genre'], $data['developer'], $data['publisher'], $data['in_stock'], $data['price']);
        if($data['price'] == "")
            $parameters[] = null;
        else $parameters[] = $data['price'];
        $parameters[] = $data['id'];
        $stmt->execute($parameters);
    }

    public static function deleteGame($id) {
        $query = "delete from game_info where id = ?";
        $stmt = mysql::getInstance()->prepare($query);
        try {
            $stmt->execute(array($id));
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    public static function getMaxIdOfGame() {
        $query = "select max(id) from game_info";
        $stmt = mysql::getInstance()->query($query);
        $data = $stmt->fetchAll();
        return $data[0]['max(id)'];
    }

}