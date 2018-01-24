<?php

require_once("functions/functions.php");

$employees = getActiveEmployees();

$rosters = getRosters();

?>

<!DOCTYPE html>
<html lang="en">

    <head>
       <meta charset="UTF-8">
        <title>Roster Maker</title>
        <link rel="shortcut icon" href="images/coffee.png" type="image/x-icon">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="jq.js"></script>
        <script>
            $(function() {
                $('#startDate').datepicker({
                    changeMonth: true,
                    changeYear: false,
                    dateFormat: "dd/mm/yy"
                });
            });
        </script>
    </head>

    <body>

        <header>
            <h1><img src="images/coffee.png" width="30px" height="30px"> Roster Maker</h1>
        </header>


        <section class="shrinked">

            <h2>+ Show all my employees</h2>

            <table>

                <tr>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>

                <?php
                foreach($employees as $e)
                {
                    echo '<tr>';
                    echo '<td>'.$e['name'].'</td>';
                    echo '<td>'.$e['surname'].'</td>';
                    echo '<td>'.$e['email'].'</td>';
                    echo '<td>

                    <form action="functions/deactivateEmployee.php" method="post">
                        <input type="hidden" name="ID" value="'.$e['ID'].'">
                        <button type="submit">[ X ]</button>
                    </form>

                    </td>';
                    echo '</tr>';
                }
                ?>

            </table>

        </section>


        <section class="shrinked">

            <h2>+ Add new employee</h2>

            <form action="functions/addEmployee.php" method="post">

                <label>Name</label>
                <input type="text" name="name" required>

                <label>Surname</label>
                <input type="text" name="surname" required>

                <label>E-Mail</label>
                <input type="email" name="email">

                <button type="submit">Add</button>

            </form>

        </section>


        <section class="shrinked">

            <h2>+ Load previous Roster</h2>

            <form action="functions/addRoster.php" method="get">

                <laber>Select Roster date</laber>
                <select name="loadRoster">
                    <option selected>-</option>
                    <?php
                    foreach($rosters as $rost)
                    {
                        echo '<option value="'.$rost['ID'].'">'.$rost['week'].'</option>';
                    }
                    ?>
                </select>

                <button type="submit">Load</button>

            </form>

        </section>


        <section class="shrinked" style="border-bottom:3px solid grey;">

            <h2>+ New Roster</h2>

            <form action="functions/addRoster.php" method="post">

                <label>Week starting:</label>
                <input type="text" name="startDate" id="startDate" required>

                <table id="rosterMaker">
                    <tr>
                        <th>Tot.H</th>
                        <th>Emp.</th>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                        <th>Saturday</th>
                        <th>Sunday</th>
                    </tr>

                    <tr>
                      <td></td>
                      <td></td>
                      <?php
                      for($i=0;$i<7;$i++)
                      {
                        echo '<td><select name="delivery[]">';
                        echo '<option value="NULL" selected>Delivery</option>';
                        foreach($employees as $e)
                        {
                          echo '<option value="'.$e['ID'].'">'.$e['name'].' '.$e['surname'].'</option>';
                        }
                        echo '</select></td>';
                      }
                      ?>
                    </tr>

                    <?php
                    foreach($employees as $e)
                    {
                    ?>
                    <tr class="calcContainer">
                        <td>
                            <input type="hidden" class="hours" name="totalHours[]" value="0">
                            <input type="text" class="hours" value="0" disabled>
                        </td>

                        <td>
                            <?php
                            echo '<input type="hidden" name="employee[]" value="'.$e['ID'].'">'.$e['name'].' '.$e['surname'];
                            ?>
                        </td>

                        <td>
                            <select class="monS" name="mondayStart[]">
                                <option value="0" selected>Start</option>
                                <option value="X">X</option>
                                <option value="Junction">Junction</option>
                                <option value="5">5.00</option>
                                <option value="5.5">5.30</option>
                                <option value="6">6.00</option>
                                <option value="6.5">6.30</option>
                                <option value="7">7.00</option>
                                <option value="7.5">7.30</option>
                                <option value="8">8.00</option>
                                <option value="8.5">8.30</option>
                                <option value="9">9.00</option>
                                <option value="9.5">9.30</option>
                                <option value="10">10.00</option>
                                <option value="10.5">10.30</option>
                                <option value="11">11.00</option>
                                <option value="11.5">11.30</option>
                                <option value="12">12.00</option>
                                <option value="12.5">12.30</option>
                                <option value="13">13.00</option>
                                <option value="13.5">13.30</option>
                                <option value="14">14.00</option>
                                <option value="14.5">14.30</option>
                                <option value="15">15.00</option>
                                <option value="15.5">15.30</option>
                            </select>
                            <br>
                            <select class="monF" name="mondayFinish[]">
                                <option value="0" selected>Finish</option>
                                <option value="0">X</option>
                                <option value="6">6.00</option>
                                <option value="6.5">6.30</option>
                                <option value="7">7.00</option>
                                <option value="7.5">7.30</option>
                                <option value="8">8.00</option>
                                <option value="8.5">8.30</option>
                                <option value="9">9.00</option>
                                <option value="9.5">9.30</option>
                                <option value="10">10.00</option>
                                <option value="10.5">10.30</option>
                                <option value="11">11.00</option>
                                <option value="11.5">11.30</option>
                                <option value="12">12.00</option>
                                <option value="12.5">12.30</option>
                                <option value="13">13.00</option>
                                <option value="13.5">13.30</option>
                                <option value="14">14.00</option>
                                <option value="14.5">14.30</option>
                                <option value="15">15.00</option>
                                <option value="15.5">15.30</option>
                                <option value="16">16.00</option>
                                <option value="16.5">16.30</option>
                            </select>
                        </td>

                        <td>
                            <select class="tueS" name="tuesdayStart[]">
                                <option value="0" selected>Start</option>
                                <option value="0">X</option>
                                <option value="0">Junction</option>
                                <option value="5">5.00</option>
                                <option value="5.5">5.30</option>
                                <option value="6">6.00</option>
                                <option value="6.5">6.30</option>
                                <option value="7">7.00</option>
                                <option value="7.5">7.30</option>
                                <option value="8">8.00</option>
                                <option value="8.5">8.30</option>
                                <option value="9">9.00</option>
                                <option value="9.5">9.30</option>
                                <option value="10">10.00</option>
                                <option value="10.5">10.30</option>
                                <option value="11">11.00</option>
                                <option value="11.5">11.30</option>
                                <option value="12">12.00</option>
                                <option value="12.5">12.30</option>
                                <option value="13">13.00</option>
                                <option value="13.5">13.30</option>
                                <option value="14">14.00</option>
                                <option value="14.5">14.30</option>
                                <option value="15">15.00</option>
                                <option value="15.5">15.30</option>
                            </select>
                            <br>
                            <select class="tueF" name="tuesdayFinish[]">
                                <option value="0" selected>Finish</option>
                                <option value="6">6.00</option>
                                <option value="6.5">6.30</option>
                                <option value="7">7.00</option>
                                <option value="7.5">7.30</option>
                                <option value="8">8.00</option>
                                <option value="8.5">8.30</option>
                                <option value="9">9.00</option>
                                <option value="9.5">9.30</option>
                                <option value="10">10.00</option>
                                <option value="10.5">10.30</option>
                                <option value="11">11.00</option>
                                <option value="11.5">11.30</option>
                                <option value="12">12.00</option>
                                <option value="12.5">12.30</option>
                                <option value="13">13.00</option>
                                <option value="13.5">13.30</option>
                                <option value="14">14.00</option>
                                <option value="14.5">14.30</option>
                                <option value="15">15.00</option>
                                <option value="15.5">15.30</option>
                                <option value="16">16.00</option>
                                <option value="16.5">16.30</option>
                            </select>
                        </td>

                        <td>
                            <select class="wedS" name="wednesdayStart[]">
                                <option value="0" selected>Start</option>
                                <option value="0">X</option>
                                <option value="0">Junction</option>
                                <option value="5">5.00</option>
                                <option value="5.5">5.30</option>
                                <option value="6">6.00</option>
                                <option value="6.5">6.30</option>
                                <option value="7">7.00</option>
                                <option value="7.5">7.30</option>
                                <option value="8">8.00</option>
                                <option value="8.5">8.30</option>
                                <option value="9">9.00</option>
                                <option value="9.5">9.30</option>
                                <option value="10">10.00</option>
                                <option value="10.5">10.30</option>
                                <option value="11">11.00</option>
                                <option value="11.5">11.30</option>
                                <option value="12">12.00</option>
                                <option value="12.5">12.30</option>
                                <option value="13">13.00</option>
                                <option value="13.5">13.30</option>
                                <option value="14">14.00</option>
                                <option value="14.5">14.30</option>
                                <option value="15">15.00</option>
                                <option value="15.5">15.30</option>
                            </select>
                            <br>
                            <select class="wedF" name="wednesdayFinish[]">
                                <option value="0" selected>Finish</option>
                                <option value="6">6.00</option>
                                <option value="6.5">6.30</option>
                                <option value="7">7.00</option>
                                <option value="7.5">7.30</option>
                                <option value="8">8.00</option>
                                <option value="8.5">8.30</option>
                                <option value="9">9.00</option>
                                <option value="9.5">9.30</option>
                                <option value="10">10.00</option>
                                <option value="10.5">10.30</option>
                                <option value="11">11.00</option>
                                <option value="11.5">11.30</option>
                                <option value="12">12.00</option>
                                <option value="12.5">12.30</option>
                                <option value="13">13.00</option>
                                <option value="13.5">13.30</option>
                                <option value="14">14.00</option>
                                <option value="14.5">14.30</option>
                                <option value="15">15.00</option>
                                <option value="15.5">15.30</option>
                                <option value="16">16.00</option>
                                <option value="16.5">16.30</option>
                            </select>
                        </td>

                        <td>
                            <select class="thuS" name="thursdayStart[]">
                                <option value="0" selected>Start</option>
                                <option value="0">X</option>
                                <option value="0">Junction</option>
                                <option value="5">5.00</option>
                                <option value="5.5">5.30</option>
                                <option value="6">6.00</option>
                                <option value="6.5">6.30</option>
                                <option value="7">7.00</option>
                                <option value="7.5">7.30</option>
                                <option value="8">8.00</option>
                                <option value="8.5">8.30</option>
                                <option value="9">9.00</option>
                                <option value="9.5">9.30</option>
                                <option value="10">10.00</option>
                                <option value="10.5">10.30</option>
                                <option value="11">11.00</option>
                                <option value="11.5">11.30</option>
                                <option value="12">12.00</option>
                                <option value="12.5">12.30</option>
                                <option value="13">13.00</option>
                                <option value="13.5">13.30</option>
                                <option value="14">14.00</option>
                                <option value="14.5">14.30</option>
                                <option value="15">15.00</option>
                                <option value="15.5">15.30</option>
                            </select>
                            <br>
                            <select class="thuF" name="thursdayFinish[]">
                                <option value="0" selected>Finish</option>
                                <option value="6">6.00</option>
                                <option value="6.5">6.30</option>
                                <option value="7">7.00</option>
                                <option value="7.5">7.30</option>
                                <option value="8">8.00</option>
                                <option value="8.5">8.30</option>
                                <option value="9">9.00</option>
                                <option value="9.5">9.30</option>
                                <option value="10">10.00</option>
                                <option value="10.5">10.30</option>
                                <option value="11">11.00</option>
                                <option value="11.5">11.30</option>
                                <option value="12">12.00</option>
                                <option value="12.5">12.30</option>
                                <option value="13">13.00</option>
                                <option value="13.5">13.30</option>
                                <option value="14">14.00</option>
                                <option value="14.5">14.30</option>
                                <option value="15">15.00</option>
                                <option value="15.5">15.30</option>
                                <option value="16">16.00</option>
                                <option value="16.5">16.30</option>
                            </select>
                        </td>

                        <td>
                            <select class="friS" name="fridayStart[]">
                                <option value="0" selected>Start</option>
                                <option value="0">X</option>
                                <option value="0">Junction</option>
                                <option value="5">5.00</option>
                                <option value="5.5">5.30</option>
                                <option value="6">6.00</option>
                                <option value="6.5">6.30</option>
                                <option value="7">7.00</option>
                                <option value="7.5">7.30</option>
                                <option value="8">8.00</option>
                                <option value="8.5">8.30</option>
                                <option value="9">9.00</option>
                                <option value="9.5">9.30</option>
                                <option value="10">10.00</option>
                                <option value="10.5">10.30</option>
                                <option value="11">11.00</option>
                                <option value="11.5">11.30</option>
                                <option value="12">12.00</option>
                                <option value="12.5">12.30</option>
                                <option value="13">13.00</option>
                                <option value="13.5">13.30</option>
                                <option value="14">14.00</option>
                                <option value="14.5">14.30</option>
                                <option value="15">15.00</option>
                                <option value="15.5">15.30</option>
                            </select>
                            <br>
                            <select class="friF" name="fridayFinish[]">
                                <option value="0" selected>Finish</option>
                                <option value="6">6.00</option>
                                <option value="6.5">6.30</option>
                                <option value="7">7.00</option>
                                <option value="7.5">7.30</option>
                                <option value="8">8.00</option>
                                <option value="8.5">8.30</option>
                                <option value="9">9.00</option>
                                <option value="9.5">9.30</option>
                                <option value="10">10.00</option>
                                <option value="10.5">10.30</option>
                                <option value="11">11.00</option>
                                <option value="11.5">11.30</option>
                                <option value="12">12.00</option>
                                <option value="12.5">12.30</option>
                                <option value="13">13.00</option>
                                <option value="13.5">13.30</option>
                                <option value="14">14.00</option>
                                <option value="14.5">14.30</option>
                                <option value="15">15.00</option>
                                <option value="15.5">15.30</option>
                                <option value="16">16.00</option>
                                <option value="16.5">16.30</option>
                            </select>
                        </td>

                        <td>
                            <select class="satS" name="saturdayStart[]">
                                <option value="0" selected>Start</option>
                                <option value="0">X</option>
                                <option value="0">Junction</option>
                                <option value="5">5.00</option>
                                <option value="5.5">5.30</option>
                                <option value="6">6.00</option>
                                <option value="6.5">6.30</option>
                                <option value="7">7.00</option>
                                <option value="7.5">7.30</option>
                                <option value="8">8.00</option>
                                <option value="8.5">8.30</option>
                                <option value="9">9.00</option>
                                <option value="9.5">9.30</option>
                                <option value="10">10.00</option>
                                <option value="10.5">10.30</option>
                                <option value="11">11.00</option>
                                <option value="11.5">11.30</option>
                                <option value="12">12.00</option>
                                <option value="12.5">12.30</option>
                                <option value="13">13.00</option>
                                <option value="13.5">13.30</option>
                                <option value="14">14.00</option>
                                <option value="14.5">14.30</option>
                                <option value="15">15.00</option>
                                <option value="15.5">15.30</option>
                            </select>
                            <br>
                            <select class="satF" name="saturdayFinish[]">
                                <option value="0" selected>Finish</option>
                                <option value="6">6.00</option>
                                <option value="6.5">6.30</option>
                                <option value="7">7.00</option>
                                <option value="7.5">7.30</option>
                                <option value="8">8.00</option>
                                <option value="8.5">8.30</option>
                                <option value="9">9.00</option>
                                <option value="9.5">9.30</option>
                                <option value="10">10.00</option>
                                <option value="10.5">10.30</option>
                                <option value="11">11.00</option>
                                <option value="11.5">11.30</option>
                                <option value="12">12.00</option>
                                <option value="12.5">12.30</option>
                                <option value="13">13.00</option>
                                <option value="13.5">13.30</option>
                                <option value="14">14.00</option>
                                <option value="14.5">14.30</option>
                                <option value="15">15.00</option>
                                <option value="15.5">15.30</option>
                                <option value="16">16.00</option>
                                <option value="16.5">16.30</option>
                            </select>
                        </td>

                        <td>
                            <select class="sunS" name="sundayStart[]">
                                <option value="0" selected>Start</option>
                                <option value="0">X</option>
                                <option value="0">Junction</option>
                                <option value="5">5.00</option>
                                <option value="5.5">5.30</option>
                                <option value="6">6.00</option>
                                <option value="6.5">6.30</option>
                                <option value="7">7.00</option>
                                <option value="7.5">7.30</option>
                                <option value="8">8.00</option>
                                <option value="8.5">8.30</option>
                                <option value="9">9.00</option>
                                <option value="9.5">9.30</option>
                                <option value="10">10.00</option>
                                <option value="10.5">10.30</option>
                                <option value="11">11.00</option>
                                <option value="11.5">11.30</option>
                                <option value="12">12.00</option>
                                <option value="12.5">12.30</option>
                                <option value="13">13.00</option>
                                <option value="13.5">13.30</option>
                                <option value="14">14.00</option>
                                <option value="14.5">14.30</option>
                                <option value="15">15.00</option>
                                <option value="15.5">15.30</option>
                            </select>
                            <br>
                            <select class="sunF" name="sundayFinish[]">
                                <option value="0" selected>Finish</option>
                                <option value="6">6.00</option>
                                <option value="6.5">6.30</option>
                                <option value="7">7.00</option>
                                <option value="7.5">7.30</option>
                                <option value="8">8.00</option>
                                <option value="8.5">8.30</option>
                                <option value="9">9.00</option>
                                <option value="9.5">9.30</option>
                                <option value="10">10.00</option>
                                <option value="10.5">10.30</option>
                                <option value="11">11.00</option>
                                <option value="11.5">11.30</option>
                                <option value="12">12.00</option>
                                <option value="12.5">12.30</option>
                                <option value="13">13.00</option>
                                <option value="13.5">13.30</option>
                                <option value="14">14.00</option>
                                <option value="14.5">14.30</option>
                                <option value="15">15.00</option>
                                <option value="15.5">15.30</option>
                                <option value="16">16.00</option>
                                <option value="16.5">16.30</option>
                            </select>
                        </td>

                    </tr>
                    <?php
                    }
                    ?>

                    <tr>
                        <td></td>
                        <td></td>
                        <td><input type="text" id="usersMon"  value="0" disabled></td>
                        <td><input type="text" id="usersTue"  value="0" disabled></td>
                        <td><input type="text" id="usersWed"  value="0" disabled></td>
                        <td><input type="text" id="usersThu"  value="0" disabled></td>
                        <td><input type="text" id="usersFri"  value="0" disabled></td>
                        <td><input type="text" id="usersSat"  value="0" disabled></td>
                        <td><input type="text" id="usersSun"  value="0" disabled></td>
                    </tr>

                    <tr>
                        <td colspan="3">
                            <button type="reset" id="resetHours">Clear</button>
                        </td>
                        <td colspan="3">
                            <button class="count" id="countHours" type="button">Count hours</button>
                        </td>
                        <td colspan="3">
                            <button type="submit" id="saveRoster" disabled>Save</button>
                        </td>
                    </tr>

                </table>

            </form>

        </section>


        <footer>
            <p>Developed by Dorian <img src="images/Dorian-hat-favicon.png" width="20px" height="20px"></p>
        </footer>


    </body>

</html>
