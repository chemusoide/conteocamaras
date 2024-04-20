<?php
// src/models/Database.php

require_once __DIR__ . '/../../config/config.php';  // Asegúrate de que la ruta es correcta.

class Database {
    private $pdo;

    public function __construct() {
        // Configuración de la conexión
        $this->connect();
        // Verificar y crear la tabla, e inicializar datos
        $this->checkAndCreateTable();
    }

    private function connect() {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_PERSISTENT         => true,
        ];
        try {
            $this->pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function checkAndCreateTable() {
        $sql = "CREATE TABLE IF NOT EXISTS aforo (
            id INT AUTO_INCREMENT PRIMARY KEY,
            aforo_manual INT NOT NULL DEFAULT 0
        )";
        $this->pdo->exec($sql);
        $this->initializeAforo();
    }

    private function initializeAforo() {
        $exists = $this->pdo->query("SELECT COUNT(*) FROM aforo")->fetchColumn();
        if ($exists == 0) {
            $this->pdo->exec("INSERT INTO aforo (aforo_manual) VALUES (0)");
        }
    }

    public function getAforoManual() {
        try {
            $stmt = $this->pdo->query('SELECT aforo_manual FROM aforo LIMIT 1');
            return $stmt->fetchColumn();
        } catch (\PDOException $e) {
            throw new \Exception("Error accessing the database: " . $e->getMessage());
        }
    }

    public function updateAforoManual($aforoManual) { 
        $stmt = $this->pdo->prepare('UPDATE aforo SET aforo_manual = ?');
        try {
            $stmt->execute([$aforoManual]);
            return true;  
        } catch (\PDOException $e) {
            throw new \Exception("No se pudo actualizar el aforo manual: " . $e->getMessage());
        }
    }
}
?>