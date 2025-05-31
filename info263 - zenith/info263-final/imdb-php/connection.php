<?php
// 防止重复包含的保护措施
if (!defined('IMDB_DB_CONNECTED')) {
    define('IMDB_DB_CONNECTED', true);

    // ✅ 修改为正确的已有数据库文件路径
    define('DB_FILE', __DIR__ . '/imdb.sqlite'); // 不再创建新的 database 文件夹

    // 检查数据库是否存在（不再创建新文件）
    if (!file_exists(DB_FILE)) {
        die("数据库文件不存在: " . DB_FILE);
    }

    // 数据库连接配置
    define('CONNECTION_STRING', 'sqlite:' . DB_FILE);
    define('CONNECTION_USER', null);
    define('CONNECTION_PASSWORD', null);
    define('CONNECTION_OPTIONS', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ]);

    /**
     * 获取PDO数据库连接实例
     * @return PDO
     */
    function getPDO() {
        static $pdo = null;
        if ($pdo === null) {
            try {
                $pdo = new PDO(CONNECTION_STRING, CONNECTION_USER, CONNECTION_PASSWORD, CONNECTION_OPTIONS);
                $pdo->exec("PRAGMA foreign_keys = ON");
                $pdo->exec("PRAGMA journal_mode = WAL");
            } catch (PDOException $e) {
                die("数据库连接失败: " . $e->getMessage());
            }
        }
        return $pdo;
    }

    // 初始化用户表（⚠️ 可选：如果你已有完整数据库可注释此部分）
    function initializeDatabase() {
        $pdo = getPDO();
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT UNIQUE NOT NULL,
                email TEXT UNIQUE NOT NULL,
                password_hash TEXT NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
    }

    initializeDatabase();
}
?>
