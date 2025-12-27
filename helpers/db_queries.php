<?php
require_once __DIR__ . "/../config/db.php";

function executeQuery($conn, $sql, $types, $params = [])
{
    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    return $stmt->execute();
}

function selectQuery($conn, $sql, $types = "", $params = [])
{
    $stmt = $conn->prepare($sql);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    return $stmt->get_result();
}

