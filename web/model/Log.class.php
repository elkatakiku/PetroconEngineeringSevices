<?php

namespace Model;

class Log implements Expose {

    private $id;
    private $loginId;
    private $loginTimeIn;
    private $loginTimeOut;
    private $activitiesId;
    private $details;
    private $date;

    public function expose() {
        return get_object_vars($this);
    }

}