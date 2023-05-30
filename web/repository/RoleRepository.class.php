<?php

namespace Repository;

use Core\Repository;

class RoleRepository extends Repository {

    private static string $CLIENT = "PTRCN-TYPE-18c19c59";
    private static string $EMPLOYEE = "PTRCN-TYPE-4b9e178f";
    private static string $ADMIN = "PTRCN-TYPE-c821d24e";


    private static string $tblAcctType = "pltbl_account_type";

    private array $data;

    /**
     * @param array $data
     */
    private function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    public function find(string $id) {
        $sql = "SELECT *
                FROM ".self::$tblAcctType."
                WHERE id = :id";

        $params = [
            ':id' => $id,
        ];

        $this->setData($this->query($sql, $params));

        return $this->first();
    }

    public function get(string $role) {
        $sql = "SELECT *
                FROM ".self::$tblAccount."
                WHERE name = :name";

        $params = [
            ':name' => $role
        ];

        $this->data = $this->query($sql, $params);

        return $this;
    }

    public function first() {
        $first = null;

        if (isset($this->data[0])) {
            $first = $this->data[0];
        }

        return $first;
    }

}
