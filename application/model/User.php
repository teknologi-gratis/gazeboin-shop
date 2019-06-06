<?php
/**
 * Created by PhpStorm.
 * User: zhanang19
 * Date: 10/05/2019
 * Time: 19:40
 * Project: e-commerce
 */

class User
{
    private static $db;
    
    public function __construct()
    {
        self::$db = new Database;
    }

    public static function all()
    {
        self::$db->query("SELECT * FROM users");
        self::$db->execute();
        return self::$db->fetch();
    }

    public static function create($data = [])
    {
        self::$db->query("INSERT INTO users (name, address, email, username, password) VALUES (:name, :address, :email, :username, :password)");
        self::$db->bind('name', $data['name']);
        self::$db->bind('address', $data['address']);
        self::$db->bind('email', strtolower($data['email']));
        self::$db->bind('username', strtolower($data['username']));
        self::$db->bind('password', $data['password']);
        self::$db->execute();
        return self::$db->affectedRows();
    }

    public static function authenticate($username = '', $password = '')
    {
        self::$db->query("SELECT id, name, username, level FROM users WHERE username = :username AND password = :password AND status = 1");
        self::$db->bind('username', strtolower($username));
        self::$db->bind('password', $password);
        self::$db->execute();
        $result = self::$db->first();
        if (empty($result)) {
            return false;
        }
        return $result;
    }

    public static function checkUsername($username = '')
    {
        self::$db->query("SELECT username FROM users WHERE username = :username");
        self::$db->bind('username', strtolower($username));
        self::$db->execute();
        if (empty(self::$db->first())) {
            return true;
        }
        return false;
    }

    public static function checkEmail($email = '')
    {
        self::$db->query("SELECT email FROM users WHERE email = :email");
        self::$db->bind('email', strtolower($email));
        self::$db->execute();
        if (empty(self::$db->first())) {
            return true;
        }
        return false;
    }

    public static function count()
    {
        return self::$db->countRows("categories");
    }

}