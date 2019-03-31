<?php

    class Calendar {
        /* Class scope properties */
        // Array of day of the week names
        private $daysOfWeek;
        // First day of the month
        private $firstDayOfMonth;
        // Last day of the month
        private $lastDayOfMonth;
        // Total number of days in a month
        private $numDaysInMonth;
        // Passed in months name
        private $monthName;
        // Passed in month numerical
        private $month;
        // Passed in four digit year
        private $year;
        // Holds mktime default params
        private $makeTime;
        // Day of the week index
        private $dayOfWeek;
        // Column count
        private $colCount;
        // Current day
        private $currentDay;

        // Set default values
        public function __construct($month, $year) { // start constructor

            // Set default timezone
            date_default_timezone_set('America/Denver');
            // Array of day of the week names
            $this->daysOfWeek = [
                'Sunday',
                'Monday',
                'Tuesday',
                'Wednesday',
                'Thursday',
                'Friday',
                'Saturday',
            ];
            // Set month and year to passed in values
            $this->month = $month;
            $this->year = $year;
            // Param mktime
            $this->makeTime = mktime(0, 0, 0, $this->month, 1, $this->year);
            // Get first day of the month
            $this->firstDayOfMonth = date("w", $this->makeTime);
            // Get last day of the month
            $this->lastDayOfMonth = date("w", mktime(0, 0, 0, $this->month + 1, 0, $this->year));
            // Day of the week index
            $this->dayOfWeek = date("w", mktime(0, 0, 0, $this->month, $this->year));
            // Get today
            $this->currentDay = date("d");
            // Get total number of days in the month
            $this->numDaysInMonth = date("t", $this->makeTime);
            // Get full name of the month
            $this->monthName = date("F", $this->makeTime);
            // Starting column count
            $this->colCount = date("w", $this->makeTime);
        } // end constructor

        // Build and return calendar
        public function drawCalendar() { // start drawCalendar
            $calendar = "<div class='title'>";
            $calendar .= "<h3 class='float-left'><a class='prev_next_link' href=''>< </a></h3>";
            $calendar .= "<h1 class='d-inline'>$this->monthName $this->year</h1>";
            $calendar .= "<h3 class='float-right'><a class='prev_next_link' href=''>> </a></h3>";
            $calendar .= "</div>";
            $calendar .= "<table class='table table-bordered'>";
            $calendar .= "<thead>";
            $calendar .= "<tr>";

            // Draw weekday names
            foreach($this->daysOfWeek as $day) { // start foreach
            $calendar .= "<th>$day</th>";
            } // end foreach

            $calendar .= "</tr>";
            $calendar .= "</thead>";
            $calendar .= "<tbody>";
            $calendar .= "<tr>";

            // Draw starting inactive cells
            for($i = 0; $i < $this->firstDayOfMonth; $i++) { // start foreach
            $calendar .= "<td class='inactive'></td>";
            } // end foreach

            // Draw number for days
            // Make new row
            // Add strong tag to current day
            for($i = 1; $i <= $this->numDaysInMonth; $i++) { // start foreach
                if($this->colCount == 7) { // start if
                    $calendar .= "</tr><tr>";
                    $this->colCount = 0;
                } // end if

                if($i != $this->currentDay) { // start if
                    $calendar .= "<td>$i</td>";
                } else {
                    $calendar .= "<td class='strong'><strong>$i</strong></td>";
                } // end if
                
                $this->colCount++;
            } // end foreach

            // Draw ending inactive days
            for($i = 6; $i > $this->lastDayOfMonth; $i--) { // start foreach
                $calendar .= "<td class='inactive'></td>";
                } // end foreach

            $calendar .= "</tbody>";
            $calendar .= "</table>";

            return $calendar;
        } // end drawCalendar

        // Calendar next month control
        public function nextMonth() {
            if($this->month == 12) {
                $this->month = 1;
                $this->year += 1;
            } else {
                $this->month += 1;
            }
        }

        // Calendar previous month control
        public function prevMonth() {
            if($this->month == 1) {
                $this->month = 12;
                $this->year -= 1;
            } else {
                $this->month -= 1;
            }
        }
    } // end class
    // Load calendar on current month and year
    $myDate = getdate();
    $calendar = new Calendar($myDate['mon'], $myDate['year']);
?>