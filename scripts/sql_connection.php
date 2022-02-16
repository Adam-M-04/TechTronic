<?php

    class Connection
    {
        private const hostname = "localhost";
        private const username = "root";
        private const password = "";
        private const database = "techtronic_database";

        public object $obj;

        function __construct(){$this->connect();}

        function connect()
        {
            $this->obj = new mysqli(self::hostname, self::username, self::password, self::database);
            if ($this->obj -> connect_errno) {
                exit("Failed to connect to MySQL: " . $this->obj->connect_error);
            }
        }

        function query($query)
        {
            return $this->obj->query($query);
        }

        function close()
        {
            $this->obj->close();
        }

        function get_data(string $query): array
        {
            $arr = [];
            if($result = $this->obj->query($query))
            {
                while ($row = $result->fetch_object())
                {
                    array_push($arr, $row);
                }
            }
            return $arr;
        }
    }

