<?php

namespace Libot;

class TradeBotRepository
{
    /**
     * @var \PDO
     */
    private $PDO;

    public function __construct($PDO)
    {
        $this->PDO = $PDO;
    }

    public function addUser($login, $password, $fullname, $email, $token)
    {
        $stmt   = $this->PDO->prepare(
            'INSERT users SET login=:login, password=:password, fullname=:fullname, token=:token, userAgent=:userAgent, ip=:ip, email=:email'
        );
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $params = [
            ':login' => $login, ':password' => md5($password), ':fullname' => $fullname, ':email' => $email, ':token' => $token, ':userAgent' => $userAgent, ':ip' => $ip
        ];
        $result = $stmt->execute($params);

        return $result;
    }

    public function getUser($login)
    {
        $params = [':login' => $login];

        try {
            $query = 'SELECT * FROM users WHERE login=:login';

            $stmt = $this->PDO->prepare($query);
            $stmt->execute($params);
            $objects = [];
            while ($object = $stmt->fetchObject()) {
                $objects[] = $object;
            }
        } catch (\PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
        }

        return !empty($objects) ? get_object_vars($objects[0]) : null;
    }

    public function getUserByToken($token)
    {
        $params = [':token' => $token];

        try {
            $query = 'SELECT * FROM users WHERE token=:token';

            $stmt = $this->PDO->prepare($query);
            $stmt->execute($params);
            $objects = [];
            while ($object = $stmt->fetchObject()) {
                $objects[] = $object;
            }
        } catch (\PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
        }

        return !empty($objects) ? get_object_vars($objects[0]) : null;
    }

    public function updateUser($login, $password = null, $fullname = null)
    {
        $params = [':login' => $login];
        $q      = [];
        if (!empty($password)) {
            $params[':password'] = md5($password);
            $q[]                 = "`password`=:password";
        }
        if (!empty($fullname)) {
            $params[':fullname'] = $fullname;
            $q[]                 = "`fullname`=:fullname";
        }
        if (!empty($q)) {
            $stmt   = $this->PDO->prepare("UPDATE users SET ".implode(', ', $q)." WHERE `login` = :login");
            $stmt->execute($params);
        }
    }

    public function addListing($channel, $currency)
    {
        $params = [
            ':channel' => $channel,
            ':currency' => $currency,
        ];
        $stmt   = $this->PDO->prepare(
            'INSERT listings SET channel=:channel, currency=:currency'
        );
        $stmt->execute($params);
    }

    public function getListings()
    {
        try {
            $query = 'SELECT * FROM listings ORDER BY `id` DESC LIMIT 20';

            $stmt = $this->PDO->prepare($query);
            $stmt->execute();
            $objects = [];
            while ($object = $stmt->fetchObject()) {
                $objects[] = $object;
            }
        } catch (\PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
        }

        return $objects;
    }

    public function addTransfer($botId, $currencyBuy, $sumBuy, $currencySell)
    {
        $stmt = $this->PDO->prepare(
            'INSERT transfers SET bot_id=:bot_id, currency_buy=:currency_buy, sum_buy=:sum_buy, currency_sell=:currency_sell'
        );
        $params = [
            ':bot_id' => $botId, ':currency_buy' => $currencyBuy, ':sum_buy' => $sumBuy, ':currency_sell' => $currencySell,
        ];
        $result = $stmt->execute($params);

        return $result;
    }

    public function getTransfers($botId)
    {
        $params = [':bot_id' => $botId];

        try {
            $query = 'SELECT * FROM transfers WHERE bot_id=:bot_id';

            $stmt = $this->PDO->prepare($query);
            $stmt->execute($params);
            $objects = [];
            while ($object = $stmt->fetchObject()) {
                $objects[] = $object;
            }
        } catch (\PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
        }

        return $objects;
    }

    public function addBot($userId)
    {
        $stmt = $this->PDO->prepare(
            'INSERT bots SET user_id=:user_id'
        );
        $params = [
           ':user_id' => $userId,
        ];
        $stmt->execute($params);

        return  $this->PDO->lastInsertId();
    }

    public function updateBot($botId, $active)
    {
        $params = [
            ':bot_id' => $botId,
            ':active' => $active,
        ];
        $stmt   = $this->PDO->prepare("UPDATE bots SET `active` = :active WHERE `id` = :bot_id");
        $stmt->execute($params);
    }

    public function getBots($userId)
    {
        $params = [':user_id' => $userId];

        try {
            $query = "SELECT * FROM bots WHERE user_id = :user_id";

            $stmt = $this->PDO->prepare($query);
            $stmt->execute($params);
            $objects = [];
            while ($object = $stmt->fetchObject()) {
                $objects[] = get_object_vars($object);
            }
        } catch (\PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
        }

        return $objects;
    }

    public function addBotSettings($botId, $key, $value)
    {
        $stmt = $this->PDO->prepare(
            'INSERT bot_settings SET bot_id=:bot_id, name=:name, value=:value'
        );
        $params = [
            ':bot_id' => $botId,
            ':name' => $key,
            ':value' => $value,
        ];
        $stmt->execute($params);

        return  $this->PDO->lastInsertId();
    }

    public function updateBotSettings($botId, $key, $value)
    {
        $params = [
            ':bot_id' => $botId,
            ':name' => $key,
            ':value' => $value,
        ];
        $stmt   = $this->PDO->prepare("UPDATE bot_settings SET `value` = :value WHERE `bot_id` = :bot_id AND `name` = :name");
        $stmt->execute($params);

        return  $this->PDO->lastInsertId();
    }

    public function getBotSetting($botId, $key)
    {
        $params = [
            ':bot_id' => $botId,
            ':name' => $key,
        ];
        try {
            $query = 'SELECT * FROM bot_settings WHERE `bot_id` = :bot_id AND `name` = :name';
            $stmt = $this->PDO->prepare($query);
            $stmt->execute($params);
            $object = $stmt->fetchObject();
        } catch (\PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
        }
        return $object;
    }

    public function getBotSettings($botId)
    {
        $params = [
            ':bot_id' => $botId,
        ];
        $objects = [];
        try {
            $query = 'SELECT * FROM bot_settings WHERE `bot_id` = :bot_id';
            $stmt = $this->PDO->prepare($query);
            $stmt->execute($params);
            while ($object = $stmt->fetchObject()) {
                $objects[] = get_object_vars($object);
            }
        } catch (\PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
        }
        return $objects;
    }

}
