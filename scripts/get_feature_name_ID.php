<?php
    function get_feature_name_ID(string $name, Connection $conn): int
    {
        $response = $conn->get_data("SELECT sn_id FROM specification_names WHERE specification_name = '$name'");
        if($response) return $response[0]->sn_id;

        $conn->query("INSERT INTO specification_names (specification_name) VALUES ('$name')");
        return $conn->obj->insert_id;
    }

    function get_feature_value_ID(string $name, Connection $conn): int
    {
        $response = $conn->get_data("SELECT sv_id FROM specification_values WHERE specification_value = '$name'");
        if($response) return $response[0]->sv_id;

        $conn->query("INSERT INTO specification_values (specification_value) VALUES ('$name')");
        return $conn->obj->insert_id;
    }

    function get_producer_ID(string $name, Connection $conn): int
    {
        $response = $conn->get_data("SELECT producer_id FROM producers WHERE producer_name = '$name'");
        if($response) return $response[0]->producer_id;

        $conn->query("INSERT INTO producers (producer_name) VALUES ('$name')");
        return $conn->obj->insert_id;
    }

    function get_color_ID(string $name, Connection $conn): int
    {
        $response = $conn->get_data("SELECT color_id FROM colors WHERE color_name = '$name'");
        if($response) return $response[0]->color_id;

        $conn->query("INSERT INTO colors (color_name) VALUES ('$name')");
        return $conn->obj->insert_id;
    }
