<?php

namespace Libot;

class Config {

    /**
     * Экземпляр класса
     *
     * @var Config
     */
    private static $Instance;

    /**
     * @var \PDO
     */
    public $PDO;

    public static $PER_VK = "\r\n";

    /**
     * Инициализация конфигурации.
     */
    private function __construct() {
        try {
            $settingApp = new Settings();
            $this->PDO = new \PDO("mysql:host=localhost;dbname=" . $settingApp->db_name, $settingApp->db_user, $settingApp->db_password);
        } catch (\Exception $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
        }
    }

    /**
     * Получить экземпляр класса
     * @return Config
     */
    public static function getInstance() {
        if (!self::$Instance) {
            self::$Instance = new Config();
        }
        return self::$Instance;
    }

}
