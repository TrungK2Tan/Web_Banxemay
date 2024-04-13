<?php

if(isset($_SESSION['username'])){
    echo "<li class='nav-link navbar-brand' >".$_SESSION['username']."</li>";

    echo "<li><a class='btn btn-warning navbar-brand' href='/php/account/logout'>Logout</a>";
    
}else{
    echo "<li><a  class='nav-link navbar-brand a-auth' href='/php/account/register'>Đăng ký</a>";
    echo "<li><a  class='nav-link navbar-brand a-auth' href='/php/account/login'>Đăng nhập</a>";
}