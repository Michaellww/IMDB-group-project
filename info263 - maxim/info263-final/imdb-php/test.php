<?php
require_once __DIR__ . '/connection.php';

// 确保使用全局$pdo变量或从getPDO()获取
$pdo = getPDO();

try {
    // 插入测试数据
    $pdo->exec("INSERT INTO test (name) VALUES ('测试数据')");

    // 查询数据
    $stmt = $pdo->query("SELECT * FROM test");
    $results = $stmt->fetchAll();

    echo "<h2>数据库连接成功！</h2>";
    echo "<pre>";
    print_r($results);
    echo "</pre>";
} catch (PDOException $e) {
    die("<h2>数据库操作失败</h2>" . $e->getMessage());
}
?>