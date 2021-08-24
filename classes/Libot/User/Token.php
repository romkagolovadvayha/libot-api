<?php
namespace Libot\User;

class Token {
    public static function execute() {
        $token = bin2hex(random_bytes(16));
        return $token;
    }
}