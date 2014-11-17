<?php namespace Server\src;

use \Server\src\Database as DB;

class Oauth_server {

    private $db;
    private $inputs = [];

    public function __construct(array $server)
    {
        $this->db = DB::getInstance();
    }

    public function run()
    {

    }

    public function check()
    {

    }

    public function request(array $req)
    {
        $this->inputs = $req;
    }
} 