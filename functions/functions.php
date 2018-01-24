<?php
//Custom functions

/*

- DB_connection()
- addEmployee($name, $surname, $email)
- deleteEmployee($id)

*/

function DB_connection()
{
    $db = false;

    $db = new PDO('mysql:host=doriantrevisan.com;dbname=doria028_rost', 'doria028_rost', 'rost123');

    return $db;
}

function getEmployees()
{
    $db = DB_connection();

    $stmt = $db -> prepare("
    SELECT *
    FROM employee;");

    $stmt -> execute();
    $results = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    return $results;
}

function getEmployeeById($eID)
{
    $db = DB_connection();

    $stmt = $db -> prepare("
    SELECT *
    FROM employee WHERE ID = :empID;");

    $stmt -> bindParam(':empID', $eID);

    $stmt -> execute();
    $results = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    return $results[0];
}

function getActiveEmployees()
{
    $db = DB_connection();

    $stmt = $db -> prepare("
    SELECT *
    FROM employee
    WHERE status = 'active';");

    $stmt -> execute();
    $results = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    return $results;
}

function getRosters()
{
    $db = DB_connection();

    $stmt = $db -> prepare("
    SELECT MAX(ID) AS ID, week
    FROM roster
    GROUP BY week;");

    $stmt -> execute();
    $results = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    return $results;
}

function getRosterById($id)
{
    $db = DB_connection();

    $employees = getEmployees();

    $i = 0;
    $roster = array();

    foreach( $employees as $emp )
    {
        $stmt2 = $db -> prepare("
        SELECT *
        FROM emp_".$emp['ID']."
        WHERE roster_ID = :rostID;");

        $stmt2 -> bindParam(':rostID', $id);

        $stmt2 -> execute();
        $result = $stmt2 -> fetchAll(PDO::FETCH_ASSOC);
        if( !empty($result[0]) )
        {
            $roster[$i] = $result[0];
            $roster[$i]['name'] = $emp['name'].' '.$emp['surname'];
        }
        $i++;
    }

    return $roster;
}

function getLastRoster()
{
    $db = DB_connection();

    $stmt1 = $db -> prepare("
    SELECT MAX(ID) AS ID
    FROM roster;");

    $stmt1 -> execute();
    $result = $stmt1 -> fetch();
    $rostID = $result['ID'];

    $employees = getEmployees();

    $i = 0;
    $roster = array();

    foreach( $employees as $emp )
    {
        $stmt2 = $db -> prepare("
        SELECT *
        FROM emp_".$emp['ID']."
        WHERE roster_ID = :rostID;");

        $stmt2 -> bindParam(':rostID', $rostID);

        $stmt2 -> execute();
        $result = $stmt2 -> fetchAll(PDO::FETCH_ASSOC);
        if( !empty($result[0]) )
        {
            $roster[$i] = $result[0];
            $roster[$i]['name'] = $emp['name'].' '.$emp['surname'];
        }
        $i++;
    }

    return $roster;
}

function getRosterData($id=NULL)
{
    $db = DB_connection();

    if( $id == NULL )
    {
        $stmt = $db -> prepare("
        SELECT *
        FROM roster
        WHERE ID =(
        SELECT MAX(ID)
        FROM roster);");

        $stmt -> execute();
        $data = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }
    else
    {
        $stmt = $db -> prepare("
        SELECT *
        FROM roster
        WHERE ID = :rostID;");

        $stmt -> bindParam(':rostID', $id);

        $stmt -> execute();
        $data = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    }

    return $data[0];
}

function getMailsFromRoster($id)
{
    $db = DB_connection();

    $stmt = $db -> prepare("
    SELECT emp_ID
    FROM roster_employee
    WHERE rost_ID = :rostID;");

    $stmt -> bindParam(':rostID', $id);

    $stmt -> execute();
    $empIds = $stmt -> fetchAll(PDO::FETCH_ASSOC);

    $emails = array();

    foreach($empIds as $empId)
    {
        $stmt = $db -> prepare("
        SELECT email
        FROM employee
        WHERE ID = :empID;");

        $stmt -> bindParam(':empID', $empId);

        $stmt -> execute();
        $mail = $stmt -> fetch();

        array_push($emails, $mail);
    }

    return $emails;
}

function addEmployee($name, $surname, $email=null)
{
    $db = DB_connection();

    //Insert new record in employee details table
    $stmt1 = $db -> prepare("
    INSERT INTO employee(`name`, `surname`, `email`)
    VALUES (:name, :surname, :email);");

    $stmt1 -> bindParam(':name', $name);
    $stmt1 -> bindParam(':surname', $surname);
    $stmt1 -> bindParam(':email', $email);

    $exec = $stmt1 -> execute();

    //Fetch last created ID fron employee table
    $query = $db -> prepare("
    SELECT MAX(ID)
    AS lastID
    FROM employee;");

    $exec = $query -> execute();
    $row = $query -> fetch();

    //Create new table using the last created employee ID
    $stmt2 = $db -> prepare("
    CREATE TABLE emp_".$row['lastID']." (
    ID int NOT NULL AUTO_INCREMENT,
    roster_ID int,
    mondayStart varchar(15),
    mondayFinish varchar(15),
    tuesdayStart varchar(15),
    tuesdayFinish varchar(15),
    wednesdayStart varchar(15),
    wednesdayFinish varchar(15),
    thursdayStart varchar(15),
    thursdayFinish varchar(15),
    fridayStart varchar(15),
    fridayFinish varchar(15),
    saturdayStart varchar(15),
    saturdayFinish varchar(15),
    sundayStart varchar(15),
    sundayFinish varchar(15),
    total float,
    PRIMARY KEY (ID)
    );");

    $exec = $stmt2 -> execute();

    return $exec;
}

function addRoster($startDate, $delivery)
{
    $db = DB_connection();

    //Insert new record in employee details table
    $stmt1 = $db -> prepare("
    INSERT INTO roster(`week`, `delMon`, `delTue`, `delWed`, `delThu`, `delFri`, `delSat`, `delSun`)
    VALUES (:week, :mon, :tue, :wed, :thu, :fri, :sat, :sun);");

    $stmt1 -> bindParam(':week', $startDate);
      $stmt1 -> bindParam(':mon', $delivery[0]);
        $stmt1 -> bindParam(':tue', $delivery[1]);
          $stmt1 -> bindParam(':wed', $delivery[2]);
            $stmt1 -> bindParam(':thu', $delivery[3]);
              $stmt1 -> bindParam(':fri', $delivery[4]);
                $stmt1 -> bindParam(':sat', $delivery[5]);
                  $stmt1 -> bindParam(':sun', $delivery[6]);

    $exec = $stmt1 -> execute();

    //Fetch last created ID from roster table
    $query = $db -> prepare("
    SELECT MAX(ID)
    AS lastID
    FROM roster;");

    $exec = $query -> execute();
    $row['lastID'] = false;

    if( $exec )
    {
        $row = $query -> fetch();
    }

    return $row['lastID'];
}

function addRosterToEmployee($empId, $rostId, $monS=NULL, $monF=NULL, $tueS=NULL, $tueF=NULL, $wedS=NULL, $wedF=NULL, $thuS=NULL, $thuF=NULL, $friS=NULL, $friF=NULL, $satS=NULL, $satF=NULL, $sunS=NULL, $sunF=NULL, $total=0)
{
    $db = DB_connection();

    //Insert new record in employee details table
    $stmt1 = $db -> prepare("
    INSERT INTO emp_".$empId."(`roster_ID`, `mondayStart`, `mondayFinish`, `tuesdayStart`, `tuesdayFinish`, `wednesdayStart`, `wednesdayFinish`, `thursdayStart`, `thursdayFinish`, `fridayStart`, `fridayFinish`, `saturdayStart`, `saturdayFinish`, `sundayStart`, `sundayFinish`, `total`)
    VALUES (:roster_ID, :monS, :monF, :tueS, :tueF, :wedS, :wedF, :thuS, :thuF, :friS, :friF, :satS, :satF, :sunS, :sunF, :tot);");

    $stmt1 -> bindParam(':roster_ID', $rostId);
    $stmt1 -> bindParam(':monS', $monS);
    $stmt1 -> bindParam(':monF', $monF);
    $stmt1 -> bindParam(':tueS', $tueS);
    $stmt1 -> bindParam(':tueF', $tueF);
    $stmt1 -> bindParam(':wedS', $wedS);
    $stmt1 -> bindParam(':wedF', $wedF);
    $stmt1 -> bindParam(':thuS', $thuS);
    $stmt1 -> bindParam(':thuF', $thuF);
    $stmt1 -> bindParam(':friS', $friS);
    $stmt1 -> bindParam(':friF', $friF);
    $stmt1 -> bindParam(':satS', $satS);
    $stmt1 -> bindParam(':satF', $satF);
    $stmt1 -> bindParam(':sunS', $sunS);
    $stmt1 -> bindParam(':sunF', $sunF);
    $stmt1 -> bindParam(':tot', $total);

    $exec = $stmt1 -> execute();

    $stmt2 = $db -> prepare("
    INSERT INTO roster_employee(`rost_ID`, `emp_ID`)
    VALUES (:roster_ID, :employee_ID);");

    $stmt2 -> bindParam(':roster_ID', $rostId);
    $stmt2 -> bindParam(':employee_ID', $empId);

    $exec = $stmt2 -> execute();

    return $exec;
}

function deactivateEmployee($id)
{
    $db = DB_connection();

    $stmt1 = $db -> prepare("
    UPDATE employee
    SET status = 'inactive'
    WHERE ID = :id;");

    $stmt1 -> bindParam(':id', $id);

    $exec = $stmt1 -> execute();

    /*$stmt2 = $db -> prepare("
    DROP TABLE emp_".$id.";");

    $exec = $stmt2 -> execute();*/

    return $exec;
}
