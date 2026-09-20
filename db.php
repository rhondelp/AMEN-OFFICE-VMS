<?php
session_start();
date_default_timezone_set('Asia/Manila');

$conn = new mysqli("localhost", "root", "", "amen_vms");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->query("SET time_zone = '+08:00'");

function query(string $sql, array $params = [], string $types = ''): mysqli_result|bool {
    global $conn;
    if ($params) {
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result ?? true;
    }
    return $conn->query($sql);
}

function query_single(string $sql, array $params = [], string $types = ''): ?array {
    $result = query($sql, $params, $types);
    return ($result instanceof mysqli_result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
}

function query_count(string $sql, array $params = [], string $types = ''): int {
    $row = query_single($sql, $params, $types);
    return $row ? (int)$row['count'] : 0;
}

function sanitize(mixed $value): string {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $url): never {
    header("Location: $url");
    exit;
}
