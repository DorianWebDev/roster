<?php
//Add new employee to Employee table
//Create new table with the Emp_ID as name

require_once("functions.php");

if( isset($_POST['ID']) )
{
    if( deactivateEmployee($_POST['ID']) )
    {
        header('Location: /index.php');
    }
    else
    {
        echo "<h1>NEW EMPLOYEE NOT DELETED!</h1>";
        echo "<br><a href='../index.php'><- Back</a>";
    }
}