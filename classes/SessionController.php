<?php
namespace Classes;
require_once __DIR__ . "/../config/bootstrap.php";

class SessionController
{
    public static function addMessage(string $type='info', string $message): void
    {
        $_SESSION['msg'][$type] ??= [];
        $types = ['error','done','info'];
        if(!in_array($type, $types)){
            $type = 'info';
        }
        $_SESSION['msg'][$type][] = $message;
    }

    public  static function getMessages(): array
    {
        return $_SESSION['msg'] ?? [];
    }

    public static function clearMessages()
    {
        unset($_SESSION['msg']);
    }

    # USER
    public static function setUser($user)
    {
        $_SESSION['user'] = $user;
    }

    public static function getUser():?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function isLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }

    public static function logout()
    {
        session_unset();
        session_destroy();
    }
}

