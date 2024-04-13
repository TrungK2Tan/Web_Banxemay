<?php
class SessionHelper{
    public static function isAdmin(){
        return (isset($_SESSION['role']) && $_SESSION['role']=='admin');
    }
    public static function isUser(){
        return (isset($_SESSION['role']) && $_SESSION['role']=='user');
    }
    //kiem tra đã đăng nhập chưa?
    public static function isLoggedIn(){
        return isset($_SESSION['username']);
    }
}