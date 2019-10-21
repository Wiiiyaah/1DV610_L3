<?php

class DateTimeView {


	/**
	 * Gets the current date and time in timezone of Stockholm as an HTML-paragraph
	 * @return - The current date and time in timezone of Stockholm as an HTML-paragraph
	 */
	public function get() {
		// Setting of time zone
		date_default_timezone_set('Europe/Stockholm');

		$weekDay = date('l');
		$date = date('jS');
		$month = date('F');
		$year = date('Y');
		$time = date('H:i:s');

		$timeString = "$weekDay, the $date of $month $year, The time is $time";

		return '<p>' . $timeString . '</p>';
	}
}