<?php
session_start();
include_once 'functions/globalFunctions.php';
isLoggedElseRedirect();

date_default_timezone_set("Europe/Prague"); //Changing default time zone.

html_start("Calendar", "css/global", "css/calendar");
nav();
banner("Calendar");

$daysOfWeekCZ =
    [
        1 => "Po",
        "Út",
        "St",
        "Čt",
        "Pa",
        "So",
        "Ne"
    ];

$currentMonth = date("n");
$currentYear = date("Y");
?>

<div class="container-fluid">
    <div class="container-fluid calendar-nav" style="margin-bottom: 1vh;">
        <div class="row d-flex justify-content-center">
            <div class="col-4 calendar-nav-button">
                <a href="?show=month">
                    Month
                </a>
            </div>
            <div class="col-4 calendar-nav-button">
                <a href="?show=week">
                    Week
                </a>
            </div>
            <div class="col-4 calendar-nav-button">
                <a href="?show=day">
                    Day
                </a>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 calendar-side-nav ">

            </div>
            <div class="col-10 calendar-body">
                <?php
                if (isset($_GET["show"]))
                {
                    if (strtolower(test_input($_GET["show"])) == "month")
                    {
                        Month($currentMonth, $currentYear);
                    }
                    elseif (strtolower(test_input($_GET["show"])) == "week")
                    {
                        Week(31, 12, 2021);
                    }
                    elseif (strtolower(test_input($_GET["show"])) == "day")
                    {
                        echo "WIP";
                    }
                    else
                    {
                        Month($currentMonth, $currentYear);
                    }
                }
                else
                {
                    Month($currentMonth, $currentYear);
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php
footer();
html_end();

function oneDay($day, $month, $year, $week = false)
{
    $redirect = "window.open('calendarEvent.php?day=$day&month=$month&year=$year', '_blank')";
    $strToDate = strtotime("$day.$month.$year");
    $date = date("d.m.Y", $strToDate);
    $currentDate = date("d.m.Y");
    $daysOfWeekCZ =
        [
            1 => "Po",
            "Út",
            "St",
            "Čt",
            "Pá",
            "So",
            "Ne"
        ];


    echo
    '
        <div class="col calendar-day ';
    if ($currentDate == $date)
    {
        echo "current-day";
    }
    echo '" ';
    if ($week)
    {
        echo 'style="height: 70vh;"';
    }
    echo 'onclick="' . $redirect . '">
            <div class="d-flex flex-column">
                <div class="p-2 row calendar-day-header ';
    if ($currentDate == $date)
    {
        echo "current-day";
    }
    echo '">
                    <p class="col">' . $day . '.' . $month . '.</p>
                    <p class="col"></p>
                    <p class="col">' . $daysOfWeekCZ[date("N", $strToDate)] . '</p>
                </div>
                <div class="p-2 calendar-day-body">
                    <p style="text-align: center; margin: 0;">
                        
                    </p>
                </div>
            </div>
        </div>
    ';
}
function oneDayNotIncluded($day, $month, $year, $week = false)
{
    $redirect = "window.open('calendarEvent.php?day=$day&month=$month&year=$year', '_blank')";
    $strToDate = strtotime("$day.$month.$year");
    $date = date("d.m.Y", $strToDate);
    $currentDate = date("d.m.Y");
    $daysOfWeekCZ =
        [
            1 => "Po",
            "Út",
            "St",
            "Čt",
            "Pá",
            "So",
            "Ne"
        ];


    echo
    '
        <div class="col calendar-day ';
    if ($currentDate == $date)
    {
        echo "current-day";
    }
    echo '" ';
    if ($week)
    {
        echo 'style="height: 70vh;"';
    }
    echo ' onclick="' . $redirect .
        '">
            <div class="d-flex flex-column">
                <div class="p-2 row calendar-day-header ';
    if ($currentDate == $date)
    {
        echo "current-day";
    }
    echo '" style="background-color: #c300ffa0;">
                    <p class="col">' . $day . '.' . $month . '.</p>
                    <p class="col"></p>
                    <p class="col">' . $daysOfWeekCZ[date("N", $strToDate)] . '</p>
                </div>
                <div class="p-2 calendar-day-body">
                    <p style="text-align: center; margin: 0;">
                        test<br>test
                    </p>
                </div>
            </div>
        </div>
    ';
}
function Month($monthNumber, $yearNumber)
{
    $firstDayDate = strtotime("1.$monthNumber.$yearNumber");
    $numOfDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $monthNumber, $yearNumber);
    $lastDayDate = strtotime("$numOfDaysInMonth.$monthNumber.$yearNumber");
    $firstDayOrderNumber = date("N", $firstDayDate);
    $lastDayOrderNumber = date("N", $lastDayDate);
    $daysBefore = $firstDayOrderNumber - 1;
    $daysAfter = 7 - $lastDayOrderNumber;
    if ($daysBefore != 0)
    {
        if ($monthNumber == 1)
        {
            $yearBefore = $yearNumber - 1;
            $monthBefore = 12;
            $numOfDaysInMonthBefore = cal_days_in_month(CAL_GREGORIAN, $monthBefore, $yearBefore);
        }
        else
        {
            $yearBefore = $yearNumber;
            $monthBefore = $monthNumber - 1;
            $numOfDaysInMonthBefore = cal_days_in_month(CAL_GREGORIAN, $monthBefore, $yearBefore);
        }
    }
    if ($daysAfter != 0)
    {
        if ($monthNumber == 12)
        {
            $yearAfter = $yearNumber + 1;
            $monthAfter = 1;
            $numOfDaysInMonthAfter = cal_days_in_month(CAL_GREGORIAN, $monthAfter, $yearAfter);
        }
        else
        {
            $yearAfter = $yearNumber;
            $monthAfter = $monthNumber + 1;
            $numOfDaysInMonthAfter = cal_days_in_month(CAL_GREGORIAN, $monthAfter, $yearAfter);
        }
    }


    // ------ Printing whole month ------
    for ($i = 1, $j = 0, $beforeDone = 0; $i <= $numOfDaysInMonth; $i++)
    {
        if ($j == 7)
        {
            $j = 0;
        }
        if ($j == 0)
        {
            echo '<div class="row">';
        }

        // ------ Days Before ------
        for ($b = 1; $b <= $daysBefore && $beforeDone == 0; $b++)
        {
            oneDayNotIncluded($numOfDaysInMonthBefore - ($daysBefore - $b), $monthBefore, $yearBefore);
            $j++;
        }
        $beforeDone = 1;
        // ------ End Days Before ------

        oneDay($i, $monthNumber, $yearNumber);
        $j++;

        // ------ Days After ------
        for ($a = 1; $a <= $daysAfter && $i == $numOfDaysInMonth; $a++)
        {
            oneDayNotIncluded($a, $monthAfter, $yearAfter);
            $j++;
        }
        // ------ End Days After ------

        if ($j == 7)
        {
            echo '</div>';
        }
    }
    // ------ End of printing ------
}
function Week($dayInWeek, $monthNumber, $yearNumber)
{
    $dayDate = strtotime("$dayInWeek.$monthNumber.$yearNumber");
    $numOfDaysInMonth = cal_days_in_month(CAL_GREGORIAN, $monthNumber, $yearNumber);
    if ($monthNumber == 1)
    {
        $numOfDaysInMonthBefore = cal_days_in_month(CAL_GREGORIAN, 12, $yearNumber - 1);
    }
    else
    {
        $numOfDaysInMonthBefore = cal_days_in_month(CAL_GREGORIAN, $monthNumber - 1, $yearNumber);
    }
    $dayOrderNumber = date("N", $dayDate);
    $daysBefore = $dayOrderNumber - 1;
    $daysAfter = 7 - $dayOrderNumber;


    echo '<div class="row" style="height: 70vh">';
    // ------ Days Before ------
    for ($b = 0; $b < $daysBefore; $b++)
    {
        if ($monthNumber == 1)
        {
            if (($dayInWeek - ($daysBefore - $b)) <= 0)
            {
                oneDay($numOfDaysInMonthBefore + $dayInWeek - ($daysBefore - $b), 12, $yearNumber - 1, true);
            }
            else
            {
                oneDay($dayInWeek - ($daysBefore - $b), $monthNumber, $yearNumber, true);
            }
        }
        else
        {
            if (($dayInWeek - ($daysBefore - $b)) <= 0)
            {
                oneDay($numOfDaysInMonthBefore + $dayInWeek - ($daysBefore - $b), $monthNumber - 1, $yearNumber, true);
            }
            else
            {
                oneDay($dayInWeek - ($daysBefore - $b), $monthNumber, $yearNumber, true);
            }
        }
    }
    // ------ End Days Before ------
    oneDay($dayInWeek, $monthNumber, $yearNumber, true);
    // ------ Days After ------
    for ($a = 1; $a <= $daysAfter; $a++)
    {
        if ($monthNumber == 12)
            if (($dayInWeek + $a) > $numOfDaysInMonth)
            {
                oneDay($dayInWeek + $a - $numOfDaysInMonth, 1, $yearNumber + 1, true);
            }
            else
            {
                oneDay($dayInWeek + $a, $monthNumber, $yearNumber, true);
            }
        else
        {
            if (($dayInWeek + $a) > $numOfDaysInMonth)
            {
                oneDay($dayInWeek + $a - $numOfDaysInMonth, $monthNumber + 1, $yearNumber, true);
            }
            else
            {
                oneDay($dayInWeek + $a, $monthNumber, $yearNumber, true);
            }
        }
    }
    // ------ End Days After ------
    echo '</div>';



    /*
        echo '<div class="row" style="height: 70vh">';
        for ($i = 14; $i <= 21; $i++)
        {
            oneDay($i, 6, 2022, true);
        }
        echo '</div>';
    */
}