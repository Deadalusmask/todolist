<?php
include_once("connect.php");
session_start();
    function getmicrotime()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }

    $time_start = getmicrotime();
    IF (!isset($_GET['year'])) {
        $_GET['year'] = date("Y");
    }
    IF (!isset($_GET['month'])) {
        $_GET['month'] = date("n") + 1;
    }

    $userid = stripslashes(trim($_SESSION['userid']));
    $month = addslashes($_GET['month'] - 1);
    $year = addslashes($_GET['year']);

    $query = "SELECT event_id,event_title,event_day,event_time FROM list WHERE userid='$userid' AND event_month='$month' AND event_year='$year' ORDER BY event_time";
    $query_result = mysqli_query($link, $query);
    while ($info = mysqli_fetch_array($query_result)) {
        $day = $info['event_day'];
        $event_id = $info['event_id'];
        $events[$day][] = $info['event_id'];
        $event_info[$event_id]['0'] = substr($info['event_title'], 0, 8);;
        $event_info[$event_id]['1'] = $info['event_time'];
    }
    $todays_date = date("j");
    $todays_month = date("n");

    $days_in_month = date("t", mktime(0, 0, 0, $_GET['month'], 0, $_GET['year']));
    $first_day_of_month = date("w", mktime(0, 0, 0, $_GET['month'] - 1, 1, $_GET['year']));
    $first_day_of_month = $first_day_of_month + 1;
    $count_boxes = 0;
    $days_so_far = 0;

    IF ($_GET['month'] == 13) {
        $next_month = 2;
        $next_year = $_GET['year'] + 1;
    } ELSE {
        $next_month = $_GET['month'] + 1;
        $next_year = $_GET['year'];
    }

    IF ($_GET['month'] == 2) {
        $prev_month = 13;
        $prev_year = $_GET['year'] - 1;
    } ELSE {
        $prev_month = $_GET['month'] - 1;
        $prev_year = $_GET['year'];
    }
    ?>


    <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
    <html>
    <head>
        <title>todolist</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link href="cal.css" rel="stylesheet" type="text/css">
        <style type="text/css">
            #top{
                width: 99.8%;
                min-width: 800px;
                background-repeat: repeat-x;
                background-color: #EFE;
                color: #464646;
                left: 0;
                top: 0 !important;
                text-align: left;
                font-size: 12px;
                z-index: 8000;
                border: 1px solid #c9c9c9;
                line-height:0;
                overflow:hidden;
            }
        </style>
        <script language="JavaScript" type="text/JavaScript">
            function MM_jumpMenu(targ, selObj, restore) {
                eval(targ + ".location='" + selObj.options[selObj.selectedIndex].value + "'");
                if (restore) selObj.selectedIndex = 0;
            }
            function MM_openBrWindow(theURL, winName, features) {
                window.open(theURL, winName, features);
            }
        </script>
    </head>

    <body style="background-color:#d9edf7; " >
    <div id="top" style="position: absolute; height: 25px">
        <p align="right" style="">
        <?php
        if($_SESSION!=null) echo "欢迎回来，".$_COOKIE['username'];
        else echo "您好，请<a href=signin.php>登录</a>";
        ?>&nbsp;&nbsp;</p>
    </div><br><br>
    <div align="center"><span class="currentdate"><?php echo date("F Y", mktime(0, 0, 0, $_GET['month'] - 1, 1, $_GET['year'])); ?></span><br>
        <br>
    </div>
    <div align="center"><br>
        <table width="800" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <div align="right"><a href="<?php echo "index.php?month=$prev_month&amp;year=$prev_year"; ?>">
                            &lt;&lt;</a></div>
                </td>
                <td width="200">
                    <div align="center">

                        <select name="month" id="month" onChange="MM_jumpMenu('parent',this,0)">
                            <?php
                            for ($i = 1; $i <= 12; $i++) {
                                $link = $i + 1;
                                IF ($_GET['month'] == $link) {
                                    $selected = "selected";
                                } ELSE {
                                    $selected = "";
                                }
                                echo "<option value=\"index.php?month=$link&amp;year=$_GET[year]\" $selected>" . date("F", mktime(0, 0, 0, $i, 1, $_GET['year'])) . "</option>\n";
                            }
                            ?>
                        </select>
                        <select name="year" id="year" onChange="MM_jumpMenu('parent',this,0)">
                            <?php
                            for ($i = 2015; $i <= 2025; $i++) {
                                IF ($i == $_GET['year']) {
                                    $selected = "selected";
                                } ELSE {
                                    $selected = "";
                                }
                                echo "<option value=\"index.php?month=$_GET[month]&amp;year=$i\" $selected>$i</option>\n";
                            }
                            ?>
                        </select>
                    </div>
                </td>
                <td>
                    <div align="left"><a href="<?php echo "index.php?month=$next_month&amp;year=$next_year"; ?>">
                            &gt;&gt;</a></div>
                </td>
            </tr>
        </table>
        <br>
    </div>
    <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#000000">
        <tr>
            <td>
                <table width="100%" border="0" cellpadding="0" cellspacing="1">
                    <tr class="topdays">
                        <td>
                            <div align="center">Sunday</div>
                        </td>
                        <td>
                            <div align="center">Monday</div>
                        </td>
                        <td>
                            <div align="center">Tuesday</div>
                        </td>
                        <td>
                            <div align="center">Wednesday</div>
                        </td>
                        <td>
                            <div align="center">Thursday</div>
                        </td>
                        <td>
                            <div align="center">Friday</div>
                        </td>
                        <td>
                            <div align="center">Saturday</div>
                        </td>
                    </tr>
                    <tr valign="top" bgcolor="#FFFFFF">
                        <?php
                        for ($i = 1; $i <= $first_day_of_month - 1; $i++) {
                            $days_so_far = $days_so_far + 1;
                            $count_boxes = $count_boxes + 1;
                            echo "<td width=\"100\" height=\"100\" class=\"beforedayboxes\"></td>\n";
                        }
                        for ($i = 1; $i <= $days_in_month; $i++) {
                            $days_so_far = $days_so_far + 1;
                            $count_boxes = $count_boxes + 1;
                            IF ($_GET['month'] == $todays_month + 1) {
                                IF ($i == $todays_date) {
                                    $class = "highlighteddayboxes";
                                } ELSE {
                                    $class = "dayboxes";
                                }
                            } ELSE {
                                IF ($i == 1) {
                                    $class = "highlighteddayboxes";
                                } ELSE {
                                    $class = "dayboxes";
                                }
                            }
                            echo "<td width=\"100\" height=\"100\" class=\"$class\">\n";
                            $link_month = $_GET['month'] - 1;
                            echo "<div align=\"right\"><span class=\"toprightnumber\">\n<a href=\"javascript:MM_openBrWindow('event_add.php?day=$i&amp;month=$link_month&amp;year=$_GET[year]','','width=500,height=300');\">$i</a>&nbsp;</span></div>\n";
                            IF (isset($events[$i])) {
                                echo "<div align=\"left\"><span class=\"eventinbox\">\n";
                                while (list($key, $value) = each($events[$i])) {
                                    echo "&nbsp;<a href=\"javascript:MM_openBrWindow('event.php?id=$value','','width=500,height=200');\">" . $event_info[$value]['1'] . " " . $event_info[$value]['0'] . "</a>\n<br>\n";
                                }
                                echo "</span></div>\n";
                            }
                            echo "</td>\n";
                            IF (($count_boxes == 7) AND ($days_so_far != (($first_day_of_month - 1) + $days_in_month))) {
                                $count_boxes = 0;
                                echo "</TR><TR valign=\"top\">\n";
                            }
                        }
                        $extra_boxes = 7 - $count_boxes;
                        for ($i = 1; $i <= $extra_boxes; $i++) {
                            echo "<td width=\"100\" height=\"100\" class=\"afterdayboxes\"></td>\n";
                        }
                        $time_end = getmicrotime();
                        $time = round($time_end - $time_start, 3);
                        ?>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </body>
    </html>
