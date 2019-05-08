<?php
session_start();

function adduser($fullname, $username, $mail, $passwd)
{
    if (!isset($fullname) || !isset($username) || !isset($mail) || !isset($passwd))
    {
        return "MISSinfo";
    }
    if (($users = getfile("users")) != FALSE)
    {
        foreach ($users as $key => $value)
        {
            if ($value["login"] === $login)
            {
                return "ERRloginex"; //"ERROR Login already exists\n";
            }
        }
    }
    $hashpass = hash("whirlpool", $passwd);
    $user = array("login" => $login, "passwd" => $hashpass, "fname" => $fname, "lname" => $lname, "mail" => $mail, "stat" => $stat);
    $users[] = $user;
    if (putfile("users", $users) == FALSE)
    {
        return "ERRwfile"; //"ERROR could not write to file\n";
    }
    return TRUE;
}

}





?>

function adduser($login, $passwd, $fname, $lname, $mail, $stat)
{
    if (!isset($login) || !isset($passwd) || !isset($fname) || !isset($lname) || !isset($mail) || !isset($stat))
    {
        return "MISSinfo";
    }
    if (($users = getfile("users")) != FALSE)
    {
        foreach ($users as $key => $value)
        {
            if ($value["login"] === $login)
            {
                return "ERRloginex"; //"ERROR Login already exists\n";
            }
        }
    }
    $hashpass = hash("whirlpool", $passwd);
    $user = array("login" => $login, "passwd" => $hashpass, "fname" => $fname, "lname" => $lname, "mail" => $mail, "stat" => $stat);
    $users[] = $user;
    if (putfile("users", $users) == FALSE)
    {
        return "ERRwfile"; //"ERROR could not write to file\n";
    }
    return TRUE;
}
