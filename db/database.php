<?php

require_once __DIR__.'./dbconnect.php';

function query($sql, $data = []) {
    global $conn;
    $stmt = $conn->prepare($sql);
    if ($data) {
        $stmt->execute($data);
    } else {
        $stmt->execute();
    }
    return $stmt;
}

function insert($table, $data) {
    $property = implode(',', array_keys($data));
    $value = implode(',', array_map(function($v) {
        return ":$v";
    }, array_keys($data)));
    $sql = "INSERT INTO $table ($property) VALUES ($value)";
    return query($sql, $data);
}

function update($table, $data, $where) {
    $set = implode(',', array_map(function($v) {
        return "$v=:$v";
    }, array_keys($data)));
    $condition = implode(' AND ', array_map(function($v) {
        return "$v=:$v";
    }, array_keys($where)));
    $sql = "UPDATE $table SET $set WHERE $condition";
    return query($sql, array_merge($data, $where));
}

function delete($table, $where) {
    $condition = implode(' AND ', array_map(function($v) {
        return "$v=:$v";
    }, array_keys($where)));
    $sql = "DELETE FROM $table WHERE $condition";
    return query($sql, $where);
}

function getRows($sql, $data = []) {
    return query($sql, $data)->fetchAll();
}

function getRow($sql, $data = []) {
    return query($sql, $data)->fetch();
}