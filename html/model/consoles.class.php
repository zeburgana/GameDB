<?php
/**
 * Created by PhpStorm.
 * User: lapdawg
 * Date: 18.5.30
 * Time: 02.18
 */

class consoles
{
    /**
     * Sutarčių sąrašo išrinkimas
     * @param type $limit
     * @param type $offset
     * @return type
     */
    public static function getConsole($limit, $offset) {
        $query = "SELECT
        `" . DB_PREFIX . "nr`.`id`,
        `" . DB_PREFIX . "console.class`.`name`,
        `" . DB_PREFIX . "cpu`.`cpu`,
        `" . DB_PREFIX . "gpu`.`gpu`,
        `" . DB_PREFIX . "portable`.`portable`,
        `" . DB_PREFIX . "max resolution output`.`max_resolution_output`,
        `" . DB_PREFIX . "wifi` AS `wifi_adapter`,
        `" . DB_PREFIX . "Controller support`.`controller_support`,
        `" . DB_PREFIX . "Ethernet port`.`RJ_45`,
        `" . DB_PREFIX . "VR ready`.`VR_ready`,
        `" . DB_PREFIX . "backwards compatibility`.`backwards_compatibility`,
        `" . DB_PREFIX . "online store`.`online_store`,
        `" . DB_PREFIX . "price`.`price`";
        $parameters = array();

        if(isset($limit)) {
            $query .= " LIMIT ?";
            $parameters[] = $limit;
        }
        if(isset($offset)) {
            $query .= " OFFSET ?";
            $parameters[] = $offset;
        }

        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();
        return $data;
    }

    /**
     * Sutarties atnaujinimas
     * @param type $data
     */
    public static function updateContract($data) {
        $query = "UPDATE `" . DB_PREFIX . "sutartys` SET
        `sutarties_data` = ?,
        `nuomos_data_laikas` = ?,
        `planuojama_grazinimo_data_laikas` = ?,
        `faktine_grazinimo_data_laikas` = ?,
        `pradine_rida` = ?,
        `galine_rida` = ?,
        `kaina` = ?,
        `degalu_kiekis_paimant` = ?,
        `dagalu_kiekis_grazinus` = ?,
        `busena` = ?,
        `fk_klientas` = ?,
        `fk_darbuotojas` = ?,
        `fk_automobilis` = ?,
        `fk_grazinimo_vieta` = ?,
        `fk_paemimo_vieta` = ?
      WHERE `nr` = ?";

        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute(array(
            $data['sutarties_data'],
            $data['nuomos_data_laikas'],
            $data['planuojama_grazinimo_data_laikas'],
            $data['faktine_grazinimo_data_laikas'],
            $data['pradine_rida'],
            $data['galine_rida'],
            $data['kaina'],
            $data['degalu_kiekis_paimant'],
            $data['dagalu_kiekis_grazinus'],
            $data['busena'],
            $data['fk_klientas'],
            $data['fk_darbuotojas'],
            $data['fk_automobilis'],
            $data['fk_grazinimo_vieta'],
            $data['fk_paemimo_vieta'],
            $data['nr']
        ));
    }

    /**
     * konsolės įrašymas
     * @param type $data
     */
    public static function insertConsole($data) {
        $query = "INSERT INTO `" . DB_PREFIX . "sutartys`
      (
        `nr`,
        `sutarties_data`,
        `nuomos_data_laikas`,
        `planuojama_grazinimo_data_laikas`,
        `faktine_grazinimo_data_laikas`,
        `pradine_rida`,
        `galine_rida`,
        `kaina`,
        `degalu_kiekis_paimant`,
        `dagalu_kiekis_grazinus`,
        `busena`,
        `fk_klientas`,
        `fk_darbuotojas`,
        `fk_automobilis`,
        `fk_grazinimo_vieta`,
        `fk_paemimo_vieta`
      ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysql::getInstance()->prepare($query);
        $parameters = array(
            $data['nr'],
            $data['sutarties_data'],
            $data['nuomos_data_laikas'],
            $data['planuojama_grazinimo_data_laikas'],
            $data['faktine_grazinimo_data_laikas'],
            $data['pradine_rida'],
            $data['galine_rida'],
            $data['kaina'],
            $data['degalu_kiekis_paimant'],
            $data['dagalu_kiekis_grazinus'],
            $data['busena'],
            $data['fk_klientas'],
            $data['fk_darbuotojas'],
            $data['fk_automobilis'],
            $data['fk_grazinimo_vieta'],
            $data['fk_paemimo_vieta']
        );
        try {
            $stmt->execute($parameters);
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }

    /**
     * Sutarties šalinimas
     * @param type $id
     */
    public static function deleteContract($id) {
        $query = "DELETE FROM `" . DB_PREFIX . "sutartys` WHERE `nr` = ?";
        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute(array($id));
    }


    /**
     * Sutarties būsenų sąrašo išrinkimas
     * @return type
     */
    public static function getContractStates() {
        $query = "SELECT * FROM `" . DB_PREFIX . "sutarties_busenos`";
        $stmt = mysql::getInstance()->query($query);
        $data = $stmt->fetchAll();
        return $data;
    }

    /**
     * Aikštelių sąrašo išrinkimas
     * @return type
     */
    public static function getParkingLots() {
        $query = "SELECT * FROM `" . DB_PREFIX . "aiksteles`";
        $stmt = mysql::getInstance()->query($query);
        $data = $stmt->fetchAll();
        return $data;
    }

    public static function getCustomerContracts($dateFrom, $dateTo) {
        $whereClauseString = "";
        $parameters = array();

        if(!empty($dateFrom)) {
            $whereClauseString .= " WHERE `" . DB_PREFIX . "sutartys`.`sutarties_data` >= ?";
            $parameters[] = $dateFrom;
            if(!empty($dateTo)) {
                $whereClauseString .= " AND `" . DB_PREFIX . "sutartys`.`sutarties_data` <= ?";
                $parameters[] = $dateTo;
            }
        } else {
            if(!empty($dateTo)) {
                $whereClauseString .= " WHERE `" . DB_PREFIX . "sutartys`.`sutarties_data` <= ?";
                $parameters[] = $dateTo;
            }
        }

        // $whereClauseString is used three times in this query
        // We need it to have the same amount of parameters.
        $parameters = array_merge($parameters, $parameters, $parameters);

        $query = "SELECT
        `" . DB_PREFIX . "sutartys`.`nr`,
        `" . DB_PREFIX . "sutartys`.`sutarties_data`,
        `" . DB_PREFIX . "klientai`.`asmens_kodas`,
        `" . DB_PREFIX . "klientai`.`vardas`,
        `" . DB_PREFIX . "klientai`.`pavarde`,
        `" . DB_PREFIX . "sutartys`.`kaina` as `sutarties_kaina`,
        IFNULL(sum(`" . DB_PREFIX . "uzsakytos_paslaugos`.`kiekis` * `" . DB_PREFIX . "uzsakytos_paslaugos`.`kaina`), 0)
          AS `sutarties_paslaugu_kaina`,
        `t`.`bendra_kliento_sutarciu_kaina`,
        `s`.`bendra_kliento_paslaugu_kaina`
      FROM `" . DB_PREFIX . "sutartys`

      INNER JOIN `" . DB_PREFIX . "klientai`
        ON `" . DB_PREFIX . "sutartys`.`fk_klientas` = `" . DB_PREFIX . "klientai`.`asmens_kodas`

      LEFT JOIN `" . DB_PREFIX . "uzsakytos_paslaugos`
        ON `" . DB_PREFIX . "sutartys`.`nr` = `" . DB_PREFIX . "uzsakytos_paslaugos`.`fk_sutartis`

      LEFT JOIN (
        SELECT
          `asmens_kodas`,
          SUM(`" . DB_PREFIX . "sutartys`.`kaina`) AS `bendra_kliento_sutarciu_kaina`
        FROM `" . DB_PREFIX . "sutartys`
        INNER JOIN `" . DB_PREFIX . "klientai`
          ON `" . DB_PREFIX . "sutartys`.`fk_klientas` = `" . DB_PREFIX . "klientai`.`asmens_kodas`
        {$whereClauseString}
        GROUP BY `asmens_kodas`
      ) `t`
        ON `t`.`asmens_kodas` = `" . DB_PREFIX . "klientai`.`asmens_kodas`

      LEFT JOIN (
        SELECT
          `asmens_kodas`,
          IFNULL(sum(`" . DB_PREFIX . "uzsakytos_paslaugos`.`kiekis` * `" . DB_PREFIX . "uzsakytos_paslaugos`.`kaina`), 0)
            AS `bendra_kliento_paslaugu_kaina`
        FROM `" . DB_PREFIX . "sutartys`
        INNER JOIN `" . DB_PREFIX . "klientai`
          ON `" . DB_PREFIX . "sutartys`.`fk_klientas` = `" . DB_PREFIX . "klientai`.`asmens_kodas`
        LEFT JOIN `" . DB_PREFIX . "uzsakytos_paslaugos`
          ON `" . DB_PREFIX . "sutartys`.`nr` = `" . DB_PREFIX . "uzsakytos_paslaugos`.`fk_sutartis`
        {$whereClauseString}							
        GROUP BY `asmens_kodas`
      ) `s`
        ON `s`.`asmens_kodas` = `" . DB_PREFIX . "klientai`.`asmens_kodas`
      {$whereClauseString}
      GROUP BY `" . DB_PREFIX . "sutartys`.`nr`
      ORDER BY `" . DB_PREFIX . "klientai`.`pavarde` ASC";
        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();
        return $data;
    }

    public static function getSumPriceOfContracts($dateFrom, $dateTo) {
        $whereClauseString = "";
        $parameters = array();

        if(!empty($dateFrom)) {
            $whereClauseString .= " WHERE `" . DB_PREFIX . "sutartys`.`sutarties_data` >= ?";
            $parameters[] = $dateFrom;
            if(!empty($dateTo)) {
                $whereClauseString .= " AND `" . DB_PREFIX . "sutartys`.`sutarties_data` <= ?";
                $parameters[] = $dateTo;
            }
        } else {
            if(!empty($dateTo)) {
                $whereClauseString .= " WHERE `" . DB_PREFIX . "sutartys`.`sutarties_data` <= ?";
                $parameters[] = $dateTo;
            }
        }

        $query = "SELECT
        SUM(`" . DB_PREFIX . "sutartys`.`kaina`) AS `nuomos_suma`
      FROM `" . DB_PREFIX . "sutartys`
      {$whereClauseString}";

        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();
        return $data;
    }

    public static function getSumPriceOfOrderedServices($dateFrom, $dateTo) {
        $whereClauseString = "";
        $parameters = array();

        if(!empty($dateFrom)) {
            $whereClauseString .= " WHERE `" . DB_PREFIX . "sutartys`.`sutarties_data` >= ?";
            $parameters[] = $dateFrom;
            if(!empty($dateTo)) {
                $whereClauseString .= " AND `" . DB_PREFIX . "sutartys`.`sutarties_data` <= ?";
                $parameters[] = $dateTo;
            }
        } else {
            if(!empty($dateTo)) {
                $whereClauseString .= " WHERE `" . DB_PREFIX . "sutartys`.`sutarties_data` <= ?";
                $parameters[] = $dateTo;
            }
        }

        $query = "SELECT
        SUM(`" . DB_PREFIX . "uzsakytos_paslaugos`.`kiekis` * `" . DB_PREFIX . "uzsakytos_paslaugos`.`kaina`)
          AS `paslaugu_suma`
      FROM `" . DB_PREFIX . "sutartys`
      INNER JOIN `" . DB_PREFIX . "uzsakytos_paslaugos`
        ON `" . DB_PREFIX . "sutartys`.`nr` = `" . DB_PREFIX . "uzsakytos_paslaugos`.`fk_sutartis`
      {$whereClauseString}";
        $stmt = mysql::getInstance()->prepare($query);
        $stmt->execute($parameters);
        $data = $stmt->fetchAll();
        return $data;
    }
}