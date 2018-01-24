<?php
//Add new employee to Employee table
//Create new table with the Emp_ID as name

require_once("functions.php");

if( isset($_POST['startDate']) )
{
    $rostId = addRoster($_POST['startDate'], $_POST['delivery']);

    if( !$rostId )
    {
        echo "<p>ROSTER NOT CREATED!</p>";
    }
    else
    {
        $i = 0;

        foreach($_POST['employee'] as $emp)
        {
            if( $_POST['totalHours'][$i] == 0 )
            {
                $i++;
                continue;
            }
            else
            {
                addRosterToEmployee($emp, $rostId, $_POST['mondayStart'][$i], $_POST['mondayFinish'][$i], $_POST['tuesdayStart'][$i], $_POST['tuesdayFinish'][$i], $_POST['wednesdayStart'][$i], $_POST['wednesdayFinish'][$i], $_POST['thursdayStart'][$i], $_POST['thursdayFinish'][$i], $_POST['fridayStart'][$i], $_POST['fridayFinish'][$i], $_POST['saturdayStart'][$i], $_POST['saturdayFinish'][$i], $_POST['sundayStart'][$i], $_POST['sundayFinish'][$i], $_POST['totalHours'][$i]);

                $i++;
            }
        }
    }
}

if( isset($_GET['loadRoster']) )
{
    $roster = getRosterById($_GET['loadRoster']);
    $data = getRosterData($_GET['loadRoster']);
    $rostId = $data['ID'];
    $date = str_replace('/', '-', $data['week']);
    $deliveries = array($data['delMon'], $data['delTue'], $data['delWed'], $data['delThu'], $data['delFri'], $data['delSat'], $data['delSun']);
}
else
{
    $roster = getLastRoster();
    $data = getRosterData();
    $rostId = $data['ID'];
    $date = str_replace('/', '-', $data['week']);
    $deliveries = array($data['delMon'], $data['delTue'], $data['delWed'], $data['delThu'], $data['delFri'], $data['delSat'], $data['delSun']);
}

?>

<!DOCTYPE html>
<html lang="en">

    <head>
       <meta charset="UTF-8">
        <title>Roster Maker</title>
        <link rel="stylesheet" href="../style.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="../jq.js"></script>

    </head>

    <body>

        <header>
            <h1><a href="../index.php">&lt;- Roster Maker</a></h1>
        </header>


        <section>

            <table id="rosterPrint">
                <tr>
                    <th>Tot.H</th>
                    <th>Emp.</th>
                    <th>Monday <?php echo '<br><small>'.date('d/m', strtotime($date)).'</small>'; ?></th>
                    <th>Tuesday <?php echo '<br><small>'.date('d/m', strtotime($date.' +1 day')).'</small>'; ?></th>
                    <th>Wednesday <?php echo '<br><small>'.date('d/m', strtotime($date.' +2 days')).'</small>'; ?></th>
                    <th>Thursday <?php echo '<br><small>'.date('d/m', strtotime($date.' +3 days')).'</small>'; ?></th>
                    <th>Friday <?php echo '<br><small>'.date('d/m', strtotime($date.' +4 days')).'</small>'; ?></th>
                    <th>Saturday <?php echo '<br><small>'.date('d/m', strtotime($date.' +5 days')).'</small>'; ?></th>
                    <th>Sunday <?php echo '<br><small>'.date('d/m', strtotime($date.' +6 days')).'</small>'; ?></th>
                </tr>

                <tr>
                  <td></td>
                  <td><small><i>Deliveries</i></small></td>
                  <?php
                  for($i=0;$i<7;$i++)
                  {
                    $emp = getEmployeeById($deliveries[$i]);
                    echo '<td>'.$emp['name'].' '.$emp['surname'].'</td>';
                  }
                  ?>
                </tr>

                <?php
                foreach($roster as $row)
                {
                ?>
                <tr class="calcContainer">
                    <td><?php echo $row['total']; ?></td>

                    <td>
                        <?php echo $row['name']; ?>
                    </td>

                    <td>
                        <?php echo str_replace('.5', '.30', $row['mondayStart']); ?>
                        <br>
                        <?php echo str_replace('.5', '.30', $row['mondayFinish']); ?>
                    </td>

                    <td>
                        <?php echo str_replace('.5', '.30', $row['tuesdayStart']); ?>
                        <br>
                        <?php echo str_replace('.5', '.30', $row['tuesdayFinish']); ?>
                    </td>

                    <td>
                        <?php echo str_replace('.5', '.30', $row['wednesdayStart']); ?>
                        <br>
                        <?php echo str_replace('.5', '.30', $row['wednesdayFinish']); ?>
                    </td>

                    <td>
                        <?php echo str_replace('.5', '.30', $row['thursdayStart']); ?>
                        <br>
                        <?php echo str_replace('.5', '.30', $row['thursdayFinish']); ?>
                    </td>

                    <td>
                        <?php echo str_replace('.5', '.30', $row['fridayStart']); ?>
                        <br>
                        <?php echo str_replace('.5', '.30', $row['fridayFinish']); ?>
                    </td>

                    <td>
                        <?php echo str_replace('.5', '.30', $row['saturdayStart']); ?>
                        <br>
                        <?php echo str_replace('.5', '.30', $row['saturdayFinish']); ?>
                    </td>

                    <td>
                        <?php echo str_replace('.5', '.30', $row['sundayStart']); ?>
                        <br>
                        <?php echo str_replace('.5', '.30', $row['sundayFinish']); ?>
                    </td>

                </tr>
                <?php
                }
                ?>

            </table>

        </section>

        <section class="shrinked">

            <h2>Send Roster</h2>

            <form action="sendMail.php" method="post">

                <input type="hidden" name="rosterId" value="<?php echo $rostId; ?>">

                <button type="submit">Send Mail</button>

            </form>

        </section>

        <footer>
            <p>Developed by Dorian <img src="../images/Dorian-hat-favicon.png" width="20px" height="20px"></p>
        </footer>


    </body>

</html>
