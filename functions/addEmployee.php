<?php
//Add new employee to Employee table
//Create new table with the Emp_ID as name

require_once("functions.php");

if( isset($_POST['name']) && isset($_POST['surname']) )
{
    if( addEmployee($_POST['name'], $_POST['surname'], $_POST['email']) )
    {
        header('Location: /index.php');
    }
    else
    {
        echo "<h1>NEW EMPLOYEE NOT CREATED!</h1>";
        echo "<br><a href='../index.php'><- Back</a>";
    }
}
