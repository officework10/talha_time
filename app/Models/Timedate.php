<?php

namespace App\Models;
use Carbon\Carbon;
use DateInterval;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Age
{
	var $age = '';

	function calculateAge($iTimestamp)
	{
		$iDiffYear  = date('Y') - date('Y', $iTimestamp);
		$iDiffMonth = date('n') - date('n', $iTimestamp);
		$iDiffDay   = date('j') - date('j', $iTimestamp);

		// If birthday has not happen yet for this year, subtract 1.
		if ($iDiffMonth < 0 || ($iDiffMonth == 0 && $iDiffDay < 0)) {
			$iDiffYear--;
		}

		$this->age = $iDiffYear;
	}

	function getAge()
	{
		return $this->age;
	}

	function get_rank($rank)
	{
		$last = substr($rank, -1);
		$seclast = substr($rank, -2, -1);
		if ($last > 3 || $last == 0) $ext = 'th';
		else if ($last == 3) $ext = 'rd';
		else if ($last == 2) $ext = 'nd';
		else $ext = 'st';

		if ($last == 1 && $seclast == 1) $ext = 'th';
		if ($last == 2 && $seclast == 1) $ext = 'th';
		if ($last == 3 && $seclast == 1) $ext = 'th';

		return $rank . $ext;
	}
}

class Timedate extends Model
{
    public $param;
    // time calculator
	function time($request){
		if(($request->language ?? app()->getLocale()) == "en"){		
			$submitt = $request->sim_adv;
			if ($submitt === 'time_first') {
				$t_days = (int)($request->t_days ?? 0);
				$t_hours = (int)($request->t_hours ?? 0);
				$t_min = (int)($request->t_min ?? 0);
				$t_sec = (int)($request->t_sec ?? 0);
				$t_method = $request->t_method;
				$te_days = (int)($request->te_days ?? 0);
				$te_hours = (int)($request->te_hours ?? 0);
				$te_min = (int)($request->te_min ?? 0);
				$te_sec = (int)($request->te_sec ?? 0);

				if(!isset($request->t_days) && !isset($request->t_hours) && !isset($request->t_min) && !isset($request->t_sec)){
					$this->param['error'] = 'Please enter any input at time 1';
					return $this->param;
				}
				
				if(!isset($request->te_days) && !isset($request->te_hours) && !isset($request->te_min) && !isset($request->te_sec)){
					$this->param['error'] = 'Please enter any input at time 2';
					return $this->param;
				}
				if ($t_method === 'plus') {
					$seconds = $t_sec + $te_sec;
					$min = $t_min + $te_min;
					$hour = $t_hours + $te_hours;
					$days = $t_days + $te_days;
					while ($seconds >= 60) {
						$min = $min + 1;
						$seconds = $seconds - 60;
					}
					while ($min >= 60) {
						$hour = $hour + 1;
						$min = $min - 60;
					}
					while ($hour >= 24) {
						$days = $days + 1;
						$hour = $hour - 24;
					}
					$method = "+";
				} else {
					if ($t_days > $te_days) {
						if ($te_sec > $t_sec) {
							$t_sec = $t_sec + 60;
							$t_min = $t_min - 1;
						}
						if ($te_min > $t_min) {
							$t_min = $t_min + 60;
							$t_hours = $t_hours - 1;
						}
						if ($te_hours > $t_hours) {
							$t_hours = $t_hours + 24;
							$t_days = $t_days - 1;
						}
					}
					$seconds = $t_sec - $te_sec;
					$min = $t_min - $te_min;
					$hour = $t_hours - $te_hours;
					$days = $t_days - $te_days;
					while ($seconds >= 60) {
						$min = $min + 1;
						$seconds = $seconds - 60;
					}
					while ($min >= 60) {
						$hour = $hour + 1;
						$min = $min - 60;
					}
					while ($hour >= 24) {
						$days = $days + 1;
						$hour = $hour - 24;
					}
					$method = "-";
				}
				$totalDays = $min + ($seconds / 60);
				$totalDays = $hour + ($totalDays / 60);
				$totalDays = $days + ($totalDays / 24);
				$totalHours = ($totalDays * 24);
				$totalMin = $totalDays * 24 * 60;
				$totalSec = $totalDays * 24 * 60 * 60;
				$this->param = [
					// 'submit' => $submit,
					'submitt' => $submitt,
					't_method' => $method,
					't_sec' => $t_sec,
					't_min' => $t_min,
					't_hours' => $t_hours,
					't_days' => $t_days,
					'te_sec' => $te_sec,
					'te_min' => $te_min,
					'te_hours' => $te_hours,
					'te_days' => $te_days,
					'totalDays' => $totalDays,
					'totalHours' => $totalHours,
					'totalMin' => $totalMin,
					'totalSec' => $totalSec,
					'seconds' => $seconds,
					'min' => $min,
					'hour' => $hour,
					'days' => $days,
					'RESULT' => '1',
				];
				// dd($this->param);
				return $this->param;
			} elseif ($submitt === 'time_second') {
				$td_date = $request->td_date;
				// $t_hours = $request->t_hours; // Incorrect variable usage for this block
				// $t_min = $request->t_min;
				// $t_sec = $request->t_sec;
				$td_method = $request->td_method;
				$td_days = $request->td_days;
				$td_hours = $request->td_hours;
				$td_min = $request->td_min;
				$td_sec = $request->td_sec;
				$am_pm = $request->am_pm;
				$ts_hours = $request->ts_hours ?? 0;
				$ts_min = $request->ts_min ?? 0;
				$ts_sec = $request->ts_sec ?? 0;
				
				if (is_numeric($ts_hours) && is_numeric($ts_min) && is_numeric($ts_sec)) {
					if (!isset($td_days)) {
						$td_days = 0;
					}
					if (!isset($td_hours)) {
						$td_hours = 0;
					}
					if (!isset($td_min)) {
						$td_min = 0;
					}
					if (!isset($td_sec)) {
						$td_sec = 0;
					}
					if (!empty($td_date)) {
						if ($am_pm === "am" || $am_pm === "pm") {
							$time = $ts_hours . ":" . $ts_min . ":" . $ts_sec . " " . $am_pm;
						} else {
							$time = $ts_hours . ":" . $ts_min . ":" . $ts_sec;
						}
						$date = $td_date;
						$addSec = 0;
						$addMin = 0;
						$addHours = 0;
						$addDays = 0;
						$addSec = $td_sec;
						$addMin = $td_min;
						$addHours = $td_hours;
						$addDays = $td_days;
						$dateTime = $date;
						if ($td_method === "plus") {
							$method = "+";
						} else {
							$method = "-";
						}
						$resDate = date('M. d, Y h:i:s A', strtotime("$dateTime $time $method $addDays Days"));
						$resDate = date('M. d, Y h:i:s A', strtotime("$resDate $method $addHours Hours"));
						$resDate = date('M. d, Y h:i:s A', strtotime("$resDate $method $addMin Minutes"));
						$resDate = date('M. d, Y h:i:s A', strtotime("$resDate $method $addSec Seconds"));
						$finalDate = date('F, d, Y', strtotime("$resDate"));
						$resTime = date('h:i:s A', strtotime("$resDate"));
						$resDay = date('l', strtotime("$resDate"));
						if ($am_pm === "24") {
							$resTime = date("H:i:s", strtotime($resTime));
						}
						$this->param = [
							'finalDate' => $finalDate,
							'resTime' => $resTime,
							'resDay' => $resDay,
							'RESULT' => '1',
							'submitt' => $submitt,
						];
						return $this->param;
					} else {
						$this->param['error'] = 'Please! Enter Start Date.';
						return $this->param;
					}
				} else {
					$this->param['error'] = 'Please provide a valid start time.';
					return $this->param;
				}
			} else {
				if ($submitt === 'time_third') {
					// $submit = $request->submit;
					$input = $request->input;
					if (!empty($input)) {
						$components = preg_split('/\s*([\+\-\*\/])\s*/', $input, -1, PREG_SPLIT_DELIM_CAPTURE);
	
						$totalDuration = 0; // Total duration in seconds
	
						for ($i = 0; $i < count($components); $i++) {
							$part = $components[$i];
							if ($i % 2 === 0) {
								preg_match_all('/(\d+)([dhms])/', $part, $matches);
	
								$duration = 0;
								for ($j = 0; $j < count($matches[0]); $j++) {
									$value = (int)$matches[1][$j];
									$unit = $matches[2][$j];
									switch ($unit) {
										case 'd':
											$duration += $value * 86400;
											break;
										case 'h':
											$duration += $value * 3600;
											break;
										case 'm':
											$duration += $value * 60;
											break;
										case 's':
											$duration += $value;
											break;
									}
								}
								if ($i === 0 || $components[$i - 1] === '+') {
									$totalDuration += $duration;
								} elseif ($components[$i - 1] === '-') {
									$totalDuration -= $duration;
								} elseif ($components[$i - 1] = '*' || $components[$i - 1] = '/') {
									return ['error' => 'please check your input'];
								}
							}
						}
	
	
						// Convert the total duration to days, hours, minutes, and seconds
						$days = floor($totalDuration / 86400);
						$hours = floor(($totalDuration % 86400) / 3600);
						$minutes = floor(($totalDuration % 3600) / 60);
						$seconds = $totalDuration % 60;
	
						$totleresult = "{$days}d {$hours}h {$minutes}m {$seconds}s";
						$secondsResult = $totalDuration;
						$mintsResult = $totalDuration / 60;
						$hoursResult = $totalDuration / 3600;
						$daysResult = $totalDuration / 86400;
						$this->param = [
							'totleresult' => $totleresult,
							'days' => $days,
							'hours' => $hours,
							'minutes' => $minutes,
							'seconds' => $seconds,
							'secondsResult' => $secondsResult,
							'mintsResult' => $mintsResult,
							'hoursResult' => $hoursResult,
							'daysResult' => $daysResult,
							'RESULT' => '1',
							'submitt' => $submitt,
						];
						// dd($this->param);
						return $this->param;
					} else {
						return ['error' => 'please check your input'];
					}
				} else {
					return ['error' => 'please check your input'];
				}
			}
		}else{
			$time_type = $request->time_type;
			$t_days = $request->t_days;
			$t_hours = $request->t_hours;
			$t_min = $request->t_min;
			$t_sec = $request->t_sec;
			$t_method = $request->t_method;
			// $te_days = $request->te_days;
			// $te_hours = $request->te_hours;
			// $te_min = $request->te_min;
			// $te_sec = $request->te_sec;
			// dd($te_min);
			$te_sec = is_array($request->te_sec) ? $request->te_sec : [$request->te_sec];
			$te_min = is_array($request->te_min) ? $request->te_min : [$request->te_min];
			$te_hours = is_array($request->te_hours) ? $request->te_hours : [$request->te_hours];
			$te_days = is_array($request->te_days) ? $request->te_days : [$request->te_days];

			$startTime = $request->s_time ?? null;
			$endTime = $request->e_time ?? null;
			$s_date = $request->s_date ?? null;
			$et_time = $request->et_time ?? null;

			$fe_time = $request->fe_time ?? null;
			$fs_date = $request->fs_date ?? null;
			$ft_time = $request->ft_time ?? null;
			$fe_date = $request->fe_date ?? null;
			if($time_type == '1'){
				if(!isset($t_days) && !isset($t_hours) && !isset($t_min) && !isset($t_sec)){
					$this->param['error'] = 'Please enter any input at time 1';
					return $this->param;
				}
				if (empty($t_days)) {
					$t_days = 0;
				}
				if (empty($t_hours)) {
					$t_hours = 0;
				}
				if (empty($t_min)) {
					$t_min = 0;
				}
				if (empty($t_sec)) {
					$t_sec = 0;
				}
				if(!isset($te_days) && !isset($te_hours) && !isset($te_min) && !isset($te_sec)){
					$this->param['error'] = 'Please enter any input at time 2';
					return $this->param;
				}
				if (empty($te_days)) {
					$te_days = 0;
				}
				if (empty($te_hours)) {
					$te_hours = 0;
				}
				if (empty($te_min)) {
					$te_min = 0;
				}
				if (empty($te_sec)) {
					$te_sec = 0;
				}
				if ($t_method === 'plus') {
					$seconds = $t_sec + array_sum((array)$te_sec);
					$min = $t_min + array_sum((array)$te_min);
					$hour = $t_hours + array_sum((array)$te_hours);
					$days = $t_days + array_sum((array)$te_days);

					while ($seconds >= 60) {
						$min = $min + 1;
						$seconds = $seconds - 60;
					}
					while ($min >= 60) {
						$hour = $hour + 1;
						$min = $min - 60;
					}
					while ($hour >= 24) {
						$days = $days + 1;
						$hour = $hour - 24;
					}
					$method = "+";
				} else {
					if ($t_days > $te_days) {
						if ($te_sec > $t_sec) {
							$t_sec = $t_sec + 60;
							$t_min = $t_min - 1;
						}
						if (array_sum($te_min) > $t_min) {
							$t_min = $t_min + 60;
							$t_hours = $t_hours - 1;
						}
						if (array_sum($te_hours) > $t_hours) {
							$t_hours = $t_hours + 24;
							$t_days = $t_days - 1;
						}
					}
					$seconds = $t_sec - array_sum((array)$te_sec);
					$min = $t_min - array_sum((array)$te_min);
					$hour = $t_hours - array_sum((array)$te_hours);
					$days = $t_days - array_sum((array)$te_days);
					while ($seconds >= 60) {
						$min = $min + 1;
						$seconds = $seconds - 60;
					}
					while ($min >= 60) {
						$hour = $hour + 1;
						$min = $min - 60;
					}
					while ($hour >= 24) {
						$days = $days + 1;
						$hour = $hour - 24;
					}
					$method = "-";
				}
				$totalDays = $min + ($seconds / 60);
				$totalDays = $hour + ($totalDays / 60);
				$totalDays = $days + ($totalDays / 24);
				$totalHours = ($totalDays * 24);
				$totalMin = $totalDays * 24 * 60;
				$totalSec = $totalDays * 24 * 60 * 60;
				$this->param = [
					// 'submit' => $submit,
					// 'submitt' => $submitt,
					'te_hours' => $te_hours,
					't_method' => $method,
					't_sec' => $t_sec,
					't_min' => $t_min,
					't_hours' => $t_hours,
					't_days' => $t_days,
					'te_sec' => $te_sec,
					'te_min' => $te_min,
					'te_hours' => $te_hours,
					'te_days' => $te_days,
					'totalDays' => $totalDays,
					'totalHours' => $totalHours,
					'totalMin' => $totalMin,
					'totalSec' => $totalSec,
					'seconds' => $seconds,
					'min' => $min,
					'hour' => $hour,
					'days' => $days,
				];
				// dd($this->param);
				return $this->param;
			}elseif($time_type == '2'){
				if(!empty($startTime) && !empty($endTime)){
					try {
						$start = Carbon::parse($startTime);
						$end = Carbon::parse($endTime);

						$diff = $end->diff($start);
						$hours = $diff->h;
						$minutes = $diff->i;
						$seconds = $diff->s;
						if ($end->lessThan($start)) {
							$end->addDay();
							$diff = $end->diff($start);
							$hours = $diff->h;
							$minutes = $diff->i;
							$seconds = $diff->s;
						}
					} catch (\Exception $e) {
						$this->param['error'] = 'Invalid Time Format.';
						return $this->param;
					}
					$this->param = [
						'hours' => $hours,
						'minutes' => $minutes,
						'seconds' => $seconds
					];
					return $this->param;
				}else{
					$this->param['error'] = 'Please Add Both Time.';
					return $this->param;
				}
			}elseif($time_type == '3'){
				if(!empty($s_date) && !empty($et_time)){							
					$startDate = Carbon::parse($request->s_date);
					$startTime = Carbon::parse($request->et_time);
					$startDate->setTime($startTime->hour, $startTime->minute, $startTime->second);
			
					$days = $request->st_days;
					$hours = $request->st_hours;
					$minutes = $request->st_min;
					$seconds = $request->st_sec;
					$method = $request->td_method ?? 'plus';
					if(is_numeric($days) && is_numeric($hours) && is_numeric($minutes) && is_numeric($seconds)){
			
						if ($method === 'plus') {
							$newDateTime = $startDate->addDays($days)
											->addHours($hours)
											->addMinutes($minutes)
											->addSeconds($seconds);
						} else {
							$newDateTime = $startDate->subDays($days)
											->subHours($hours)
											->subMinutes($minutes)
											->subSeconds($seconds);
						}
						// Format the new date and time as needed
						$formattedDate = $newDateTime->format('Y-m-d');
						$formattedTime = $newDateTime->format('h:i:s A');
						$this->param = [
							'formattedDate' => $formattedDate,
							'formattedTime' => $formattedTime
						];
						return $this->param;
					}else{
						$this->param['error'] = 'Please Fill all the Input Fields.';
						return $this->param;
					}
				}else{
					$this->param['error'] = 'Please Enter Time.';
					return $this->param;
				}
			}else{
				if(!empty($fs_date) && !empty($fe_time) && !empty($fe_date) && !empty($ft_time)){
					$fsDate = Carbon::parse($request->fs_date);
					try {
						$fsTime = Carbon::createFromFormat('H:i:s A', $request->ft_time);
					} catch (\Exception $e) {
						$fsTime = Carbon::parse($request->ft_time);
					}
					$fsDate->setTime($fsTime->hour, $fsTime->minute, $fsTime->second);

					$feDate = Carbon::parse($request->fe_date);
					try {
						$feTime = Carbon::createFromFormat('H:i:s A', $request->fe_time);
					} catch (\Exception $e) {
						$feTime = Carbon::parse($request->fe_time);
					}
					$feDate->setTime($feTime->hour, $feTime->minute, $feTime->second);

					// Calculate the difference between the two Carbon instances
					$difference = $fsDate->diff($feDate);

					// Format the difference as needed
					$days = $difference->days;
					$hours = $difference->h;
					$minutes = $difference->i;
					$seconds = $difference->s;

					// Return the results
					$this->param = [
						'days' => $days,
						'hours' => $hours,
						'minutes' => $minutes,
						'seconds' => $seconds
					];
					// dd($this->param);
					return $this->param;
				}else{
					$this->param['error'] = 'Please Fill all the Fields.';
					return $this->param;
				}
			}
		}
	}

    // Age calculator	
	public function age($request)
	{
		$submit = $_POST['submit'];
		
		$day = $request->input('day');
		$month = $request->input('month');
		$year = $request->input('year');
		$dob = sprintf('%04d-%02d-%02d', $year, $month, $day);

		$day_sec = $request->input('day_sec');
		$month_sec = $request->input('month_sec');
		$year_sec = $request->input('year_sec');
		$e_date = sprintf('%04d-%02d-%02d', $year_sec, $month_sec, $day_sec);
		// $dob = $request->input('dob');
		// $e_date = $request->input('e_date');

		$orderdob = explode('-', $dob);
		$orderdate = explode('-', $e_date);
		$e_year = $orderdate[0];
		$e_month   = $orderdate[1];
		$e_day  = $orderdate[2];
		$dob_year = $orderdob[0];
		$dob_month   = $orderdob[1];
		$dob_day  = $orderdob[2];
		// dd($e_year);

		if (is_numeric($dob_day) && is_numeric($dob_month) && is_numeric($dob_year) && is_numeric($e_day) && is_numeric($e_month) && is_numeric($e_year)) {
			$dob_array[] = sprintf('%02d', $dob_year) . "-" . sprintf('%02d', $dob_month) . "-" . sprintf('%02d', $dob_day);
			$dates_array[] = sprintf('%02d', $e_year) . "-" . sprintf('%02d', $e_month) . "-" . sprintf('%02d', $e_day);
			// dd($dob_array,$dates_array);
			// dd($dates_array);
			for ($i = 0; $i < count($dob_array); $i++) {
				$dob = $dob_array[$i]; // yyyy-mm-dd
				$all_dob[] = date('l, F d, Y', strtotime($dob));
				$date = $dates_array[$i]; // yyyy-mm-dd
				$date = explode("-", $date);
				$dob2 = explode("-", $dob);
				$birth_month = $dob2[1];
				$bday = new Carbon($dob2[2] . '.' . $dob2[1] . '.' . $dob2[0]); // Your date of birth
				$today = new Carbon($date[2] . '.' . $date[1] . '.' . $date[0]);
				$diff = $today->diff($bday);
				$age_years[] = $diff->y;
				$age_months[] = $diff->m;
				$age_days[] = $diff->d;
				$all_users_days[] = $diff->days;
				$d = getdate();		// Current date
				$year = $d['year'];
				$mon = $d['mon'];
				$mday = $d['mday'];
				$hour = $d['hours'];
				$min = $d['minutes'];
				$sec = $d['seconds'];
				$dob_hour = $hour; // 24 hour format
				$dob_min = $min;
				$dob_sec = $sec;
				@$d1 = mktime($dob_hour, $dob_min, $dob_sec, $dob2[1], $dob2[2], $dob2[0]);
				$d2 = mktime($hour, $min, $sec, $mon, $mday, $year);
				$obj = new Age;
				@$obj->calculateAge(mktime($dob_hour, $dob_min, $dob_sec, $dob2[1], $dob2[2], $dob2[0]));
				// Alert
				// echo $d1.'<br>';
				// echo $d2.'<br>';
				// die;
				if (($d2 - $d1) <= 0) {
					$this->param['error'] = 'Invalid Date of Birth.';
					return $this->param;
				}
				$age = $obj->getAge();
				$rank = $obj->get_rank($age + 1);
				$totalyears = floor(($d2 - $d1) / 31536000);
				$Total_years[] = $totalyears;
				$Total_months[] = floor(($d2 - $d1) / 2628000);
				$Total_weeks[] = floor(($d2 - $d1) / 604800);
				$total_days = floor(($d2 - $d1) / 86400);
				$Total_days[] = $total_days;
				$Total_hours[] = floor(($d2 - $d1) / 3600);
				$total_minuts = floor(($d2 - $d1) / 60);
				$Total_minuts[] = $total_minuts;
				$Total_seconds[] = ($d2 - $d1);
				// Next Birthday
				// n for next
				// r for remaining
				$nbday = new Carbon($mday . '.' . $mon . '.' . $year);
				if ($mon > $dob2[1] || $mon == $dob2[1]) {
					$year = $year + 1;
				}
				if ($mon == $dob2[1] && $mday < $dob2[2]) {
					$year = $year - 1;
				}
				$ntoday = new Carbon($dob2[2] . '.' . $dob2[1] . '.' . $year); // Your date of birth
				$ndiff = $ntoday->diff($nbday);
				$N_r_days[] = $ndiff->days;
				$N_r_days_per[] = round(($ndiff->days / 365) * 100);
				$breath[] = round(0.5 * 15 * $total_minuts);
				$heartBeats[] = round(72 * $total_minuts);
				$sleeping[] = round($totalyears * 365.25 * 8 / (365.25 * 24), 1);
				$laughed[] = $total_days * 10;
				// Half birthDay


				$current  = getdate(); // Current date 	 	
				$half     = date('Y-m-d', strtotime("+6 months", strtotime($dob)));
				$birthday = date('Y-m-d', strtotime($dob));

				$Q2   = explode("-", $half);
				$bday = explode("-", $birthday);

				if ($Q2[1] > $current['mon'] || ($Q2[1] == $current['mon'] && $Q2[2] > $current['mday'])) {
					$year_q2 = $current['year'];
					$mon_q2  = $Q2[1];
					$day_q2  = $Q2[2];
				} else {
					$year_q2 = $current['year'] + 1;
					$mon_q2  = $Q2[1];
					$day_q2  = $Q2[2];
				}

				if ($bday[1] > $current['mon'] || ($bday[1] == $current['mon'] && $bday[2] > $current['mday'])) {
					$bd_year = $current['year'];
					$bd_mon  = $bday[1];
					$bd_day  = $bday[2];
				} else {
					$bd_year = $current['year'] + 1;
					$bd_mon  = $bday[1];
					$bd_day  = $bday[2];
				}

				$next_bday = date('l, F d, Y', strtotime($bd_year . '-' . $bd_mon . '-' . $bd_day));
				$half_brdy[] = date('l, F d, Y', strtotime($year_q2 . '-' . $mon_q2 . '-' . $day_q2));

				$next   = new Carbon($day_q2 . '-' . $mon_q2 . '-' . $year_q2);
				$today  = new Carbon(date('d-m-Y'));

				$next_half_day = $today->diff($next);
				$n_half_brdy_days[] = $next_half_day->days * 100 / 365;
				// blinking times calculation
				$blinking_times[] = $diff->days * 16800;
				// hair length calculation
				$hair_length_mm[] = $diff->days * 0.42;
				$hair_length_m[] = ($diff->days * 0.42) / 1000;
				// nail length calculation
				$nail_length_mm[] = $diff->days * 0.12;
				$nail_length_m[] = ($diff->days * 0.12) / 1000;
				// dog age calculation
				$dog_age[] = number_format($diff->days * 0.0004657534246575342, 2);
				// cat age calculation
				$cat_age[] = number_format($diff->days * 0.0005753424657534247, 2);
				// turtle age calculation
				$turtle_age[] = number_format($diff->days * 0.0068219178082192, 2);
				// horse age calculation
				$horse_age[] = number_format($diff->days * 0.001041095890411, 2);
				// cow age calculation
				$cow_age[] = number_format($diff->days * 0.0007671232876712329, 2);
				// elephant age calculation
				$elephant_age[] = number_format($diff->days * 0.0018630136986301, 2);
				// mercury age calculation
				$mercury_age[] = number_format($diff->days * 0.0113698630136986, 2);
				// venus age calculation
				$venus_age[] = number_format($diff->days * 0.0044383561643836, 2);
				// mars age calculation
				$mars_age[] = number_format($diff->days * 0.0014520547945205, 2);
				// jupiter age calculation
				$jupiter_age[] = number_format($diff->days * 0.0002191780821917808, 2);
				// saturn age calculation
				$saturn_age[] = number_format($diff->days * 0.00008219178082191781, 2);
			}
			// for combine years and days
			$sum_users_days = array_sum($all_users_days);
			$combine_years = $sum_users_days / 365.2425;
			$sep_years = explode(".", $combine_years);
			$combine_years_ans = $sep_years[0];
			$combine_days_ans = floor(fmod($sum_users_days, 365.2425));
			// for combine date and remaining days
			$combine_r_days = round((365 - $combine_days_ans) / count($dob_array));
			$aaj_ki_date = date('Y-m-d');
			$next_combine_brdy = date('F d, Y', strtotime("+$combine_r_days days", strtotime($aaj_ki_date)));
			$combine_r_days_per = round(($combine_r_days / 365) * 100);
			// all names 
			// $this->param['name_array'] = $name_array;
			$this->param['dob_array'] = $dob_array;
			$this->param['dates_array'] = $dates_array;
			// dd($this->param);
			// all dob 
			$this->param['all_dob'] = $all_dob;
			// next birthday remaining days
			$this->param['N_r_days'] = $N_r_days;
			// next birthday remaining days in percent
			$this->param['N_r_days_per'] = $N_r_days_per;
			// combine years and days
			$this->param['combine_years_ans'] = $combine_years_ans;
			$this->param['combine_days_ans'] = $combine_days_ans;
			// combine remaining days and next combine byrdy date
			$this->param['combine_r_days'] = $combine_r_days;
			$this->param['combine_r_days_per'] = $combine_r_days_per;
			$this->param['next_combine_brdy'] = $next_combine_brdy;
			// age in years, months, days 
			$this->param['age_years'] = $age_years;
			$this->param['age_months'] = $age_months;
			$this->param['age_days'] = $age_days;
			// half brdy
			$this->param['half_brdy'] = $half_brdy;
			// total years, total months, total days, etc
			$this->param['Total_years'] = $Total_years;
			$this->param['Total_months'] = $Total_months;
			$this->param['Total_weeks'] = $Total_weeks;
			$this->param['Total_days'] = $Total_days;
			$this->param['Total_hours'] = $Total_hours;
			$this->param['Total_minuts'] = $Total_minuts;
			$this->param['Total_seconds'] = $Total_seconds;
			// breath, sleeping, nail length etc 
			$this->param['breath'] = $breath;
			$this->param['heartBeats'] = $heartBeats;
			$this->param['sleeping'] = $sleeping;
			$this->param['laughed'] = $laughed;
			$this->param['blinking_times'] = $blinking_times;
			$this->param['hair_length_mm'] = $hair_length_mm;
			$this->param['hair_length_m'] = $hair_length_m;
			$this->param['nail_length_mm'] = $nail_length_mm;
			$this->param['nail_length_m'] = $nail_length_m;
			// animal age
			$this->param['dog_age'] = $dog_age;
			$this->param['cat_age'] = $cat_age;
			$this->param['turtle_age'] = $turtle_age;
			$this->param['horse_age'] = $horse_age;
			$this->param['cow_age'] = $cow_age;
			$this->param['elephant_age'] = $elephant_age;
			// planet age
			$this->param['mercury_age'] = $mercury_age;
			$this->param['venus_age'] = $venus_age;
			$this->param['mars_age'] = $mars_age;
			$this->param['jupiter_age'] = $jupiter_age;
			$this->param['saturn_age'] = $saturn_age;
			$this->param['submit'] = $submit;
			$this->param['RESULT'] = 1;
			return $this->param;
		} else {
			$this->param['error'] = 'Please check your input.';
			return $this->param;
		}
	}

    // Age Difference calculator
	public function age_diff($request)
	{
		$submit = $request->input('selection');
		$dob_f = $request->input('dob_f');
		$dob_s = $request->input('dob_s');
		$year_1 = $request->input('year_1');
		$year_2 = $request->input('year_2');
		$age_1 = $request->input('age_1');
		$age_2 = $request->input('age_2');
		if ($submit === "1") {
			if (!empty($dob_f) && !empty($dob_s)) {
				$dob_f = new Carbon($dob_f);
				$dob_s = new Carbon($dob_s);
				$currentDate = date("Y-m-d");
				$currentDate = new Carbon($currentDate);
				$age_diff = $dob_f->diff($dob_s);
				$age_diff_Year = $age_diff->y;
				$age_diff_Month = $age_diff->m;
				$age_diff_Day = $age_diff->d;
				$age_diff_in_days = $age_diff->days;
				$age_diff_weeks = $age_diff_in_days / 7;
				$age_diff_remaining_days = $age_diff_in_days % 7;
				$age_f = $currentDate->diff($dob_f);
				$ageFYear = $age_f->y;
				$ageFMonth = $age_f->m;
				$ageFDay = $age_f->d;
				$age_s = $currentDate->diff($dob_s);
				$ageSYear = $age_s->y;
				$ageSMonth = $age_s->m;
				$ageSDay = $age_s->d;
				$this->param = [
					'submit' => $submit,
					'age_diff_Day' => $age_diff_Day,
					'age_diff_Month' => $age_diff_Month,
					'age_diff_Year' => $age_diff_Year,
					'age_diff_in_days' => $age_diff_in_days,
					'age_diff_weeks' => floor($age_diff_weeks),
					'age_diff_remaining_days' => $age_diff_remaining_days,

					'ageFYear' => $ageFYear,
					'ageFMonth' => $ageFMonth,
					'ageFDay' => $ageFDay,

					'ageSYear' => $ageSYear,
					'ageSMonth' => $ageSMonth,
					'ageSDay' => $ageSDay
				];
			} else {
				$this->param['error'] = 'Please! Select Correct Date';
				return $this->param;
			}
		} else if ($submit === "2") {
			if (!empty($year_1) && !empty($year_2)) {
				$dob_f = new Carbon("$year_1-01-01");
				$dob_s = new Carbon("$year_2-01-01");
				$age_diff = $dob_f->diff($dob_s);
				$age_diff_Year = $age_diff->y;
				$age_diff_Month = $age_diff->m;
				$age_diff_Day = $age_diff->d;
				$age_diff_in_days = $age_diff->days;
				$age_diff_weeks = $age_diff_in_days / 7;
				$age_diff_remaining_days = $age_diff_in_days % 7;
				$this->param = [
					'submit' => $submit,
					'age_diff_Day' => $age_diff_Day,
					'age_diff_Month' => $age_diff_Month,
					'age_diff_Year' => $age_diff_Year,
					'age_diff_in_days' => $age_diff_in_days,
					'age_diff_weeks' => floor($age_diff_weeks),
					'age_diff_remaining_days' => $age_diff_remaining_days,
				];
			} else {
				$this->param['error'] = 'Please! Select Correct Year';
				return $this->param;
			}
		} else {
			if (is_numeric($age_1) && is_numeric($age_2)) {
				$age_diff_Year = abs($age_2 - $age_1);
				$age_diff_in_days = $age_diff_Year * 365;
				$this->param = [
					'submit' => $submit,
					'age_diff_Year' => $age_diff_Year,
					'age_diff_in_days' => $age_diff_in_days,
				];
			} else {
				$this->param['error'] = 'Please! Check Your Input';
				return $this->param;
			}
		}
		$this->param['RESULT'] = 1;
		return $this->param;
	}

    public function korean($request)
	{
		$current_year = $request->input('current_year');
		$year = $request->input('year');
		$birthday_unit = $request->input('birthday_unit');
		$age = $request->input('age');
		$room_unit = $request->input('room_unit');
		if ($room_unit == "1") {
			if (is_numeric($year) && is_numeric($current_year)) {
				if ($year < $current_year) {
					$korean_age = ($current_year - $year) + 1;
				} else {
					$this->param['error'] = 'It is must that your birth year is earlier than current one in case you are from the future';
					return $this->param;
				}
			} else {
				$this->param['error'] = 'Please! Check Your Inputs';
				return $this->param;
			}
		} elseif ($room_unit == "2") {
			if ($birthday_unit == "1") {
				if (is_numeric($age)) {
					if ($age > 0) {
						$korean_age = $age + 2;
						$this->param['korean_age'] = $korean_age;
						$this->param['RESULT'] = 1;
						return $this->param;
					} else {
						$this->param['error'] = 'Age Cannot be negitive';
						return $this->param;
					}
				} else {
					$this->param['error'] = 'Please! Check Your Inputs';
					return $this->param;
				}
			} elseif ($birthday_unit == "2") {
				if (is_numeric($age)) {
					if ($age > 0) {
						$korean_age = $age + 1;
						$this->param['korean_age'] = $korean_age;
						$this->param['RESULT'] = 1;
						return $this->param;
					} else {
						$this->param['error'] = 'Age Cannot be negitive';
						return $this->param;
					}
				} else {
					$this->param['error'] = 'Please! Check Your Inputs';
					return $this->param;
				}
			}
		}
		$this->param['korean_age'] = $korean_age;
		$this->param['RESULT'] = 1;
		return $this->param;
	}

    // Half Age Calculator
	public function half($request){
		$day = $request->input('day');
		$month = $request->input('month');
		$year = $request->input('year');
		$dob = sprintf('%04d-%02d-%02d', $year, $month, $day);
		if(!empty($dob) && $dob <= date("Y-m-d")){
			$current  = getdate(); // Current date 	 	
			$first_q  = date('Y-m-d', strtotime("+3 months", strtotime($dob)));
			$half     = date('Y-m-d', strtotime("+6 months", strtotime($dob)));
			$third_q  = date('Y-m-d', strtotime("+9 months", strtotime($dob)));
			$birthday = date('Y-m-d', strtotime($dob));

			$Q1   = explode("-",$first_q);
			$Q2   = explode("-",$half);
			$Q3   = explode("-",$third_q);
			$bday = explode("-",$birthday); 

			if($Q1[1] > $current['mon'] || ($Q1[1] == $current['mon'] && $Q1[2] > $current['mday'])){
				$year_q1 = $current['year'];
				$mon_q1  = $Q1[1];
				$day_q1  = $Q1[2];
			}
			else{
				$year_q1 = $current['year'] + 1;
				$mon_q1  = $Q1[1];
				$day_q1  = $Q1[2];
			}

			if($Q2[1] > $current['mon'] || ($Q2[1] == $current['mon'] && $Q2[2] > $current['mday'])){
				$year_q2 = $current['year'];
				$mon_q2  = $Q2[1];
				$day_q2  = $Q2[2];
			}
			else{
				$year_q2 = $current['year'] + 1;
				$mon_q2  = $Q2[1];
				$day_q2  = $Q2[2];
			}

			if($Q3[1] > $current['mon'] || ($Q3[1] == $current['mon'] && $Q3[2] > $current['mday'])){
				$year_q3 = $current['year'];
				$mon_q3  = $Q3[1];
				$day_q3  = $Q3[2];
			}
			else{
				$year_q3 = $current['year'] + 1;
				$mon_q3  = $Q3[1];
				$day_q3  = $Q3[2];
			}

			if($bday[1] > $current['mon'] || ($bday[1] == $current['mon'] && $bday[2] > $current['mday'])){
				$bd_year = $current['year'];
				$bd_mon  = $bday[1];
				$bd_day  = $bday[2];
			}
			else{
				$bd_year = $current['year'] + 1;
				$bd_mon  = $bday[1];
				$bd_day  = $bday[2];
			}

			$next_bday = date('l, F d, Y', strtotime($bd_year.'-'.$bd_mon.'-'.$bd_day));
			$next_half = date('l, F d, Y', strtotime($year_q2.'-'.$mon_q2.'-'.$day_q2));
			$first_Q   = date('l, F d, Y', strtotime($year_q1.'-'.$mon_q1.'-'.$day_q1));
			$third_Q   = date('l, F d, Y', strtotime($year_q3.'-'.$mon_q3.'-'.$day_q3));
			
			$next   = new Carbon($day_q2.'-'.$mon_q2.'-'.$year_q2);
			$Q1_day = new Carbon($day_q1.'-'.$mon_q1.'-'.$year_q1);
			$Q3_day = new Carbon($day_q3.'-'.$mon_q3.'-'.$year_q3);
			$today  = new Carbon(date('d-m-Y'));

			$next_half_day = $today->diff($next);
			$first_Q_day   = $today->diff($Q1_day);
			$third_Q_day   = $today->diff($Q3_day);
			$day_per       = $next_half_day->days * 100 / 365; 

			$this->param['next_half']      = $next_half;
			$this->param['day_per']        = $day_per;
			$this->param['next_half_days'] = $next_half_day->days;
			$this->param['first_Q']        = $first_Q;
			$this->param['first_Q_days']   = $first_Q_day->days;
			$this->param['third_Q']        = $third_Q;
			$this->param['third_Q_days']   = $third_Q_day->days;
			$this->param['next_bday']      = $next_bday;
			$this->param['RESULT'] 	       = 1;
			return $this->param;
		}
		else{
			$this->param ['error'] ='Please! Check Your Input';
			return $this->param;
		}
	}
	
    // Birthday calculator	
	public function birthday($request)
	{
		$next_birth = $request->input('next_birth');

		if (!empty($next_birth)) {
			$dob = $next_birth; // yyyy-mm-dd
			$date = date('Y-m-d'); // yyyy-mm-dd

			$date = explode("-",$date);
			$dob2 = explode("-",$dob);
			$birth_month=$dob2[1];
			$bday = new Carbon($dob2[2].'.'.$dob2[1].'.'.$dob2[0]); // Your date of birth
			$today = new Carbon($date[2].'.'.$date[1].'.'.$date[0]);
			$diff = $today->diff($bday);
			$age_years=$diff->y;
			$age_months=$diff->m;
			$age_days=$diff->d;

			$d = getdate();		// Current date
			
			$year=$d['year'];
			$mon=$d['mon'];
			$mday=$d['mday'];
			$hour = $d['hours'];
			$min = $d['minutes'];
			$sec = $d['seconds'];
			$dob_hour = $hour; // 24 hour format
			$dob_min = $min;
			$dob_sec = $sec;
			
			$d1=mktime($dob_hour,$dob_min,$dob_sec,$dob2[1],$dob2[2],$dob2[0]);
			$d2=mktime($hour,$min,$sec,$mon,$mday,$year);
			
			$obj = new Age;
			
			@$obj->calculateAge(mktime($dob_hour,$dob_min,$dob_sec,$dob2[1],$dob2[2],$dob2[0]));
			// Alert
			if (($d2-$d1)<= 0) {
				$this->param['error'] = 'Invalid Date of Birth.';
				return $this->param;
			}
			$age = $obj->getAge();
			$rank = $obj->get_rank($age+1);
			$Totalyears =floor(($d2-$d1)/31536000);
			$Total_months = floor(($d2-$d1)/2628000);
			$Total_weeks = floor(($d2-$d1)/604800);
			$Total_days = floor(($d2-$d1)/86400);
			$Total_hours = floor(($d2-$d1)/3600);
			$Total_minuts =floor(($d2-$d1)/60);
			$Total_seconds = ($d2-$d1);
			$totalDays=[0,0,0,0,0,0,0];
			$daysName=[];
			for ($i=0; $i < $age ; $i++) { 
				$day=date('w',strtotime("+$i years ".$dob));
				$dayName=date('l',strtotime("+$i years ".$dob));
				$totalDays[$day]=$totalDays[$day]+1;
				$daysName[]=$dayName;
			}
			$nbday = new Carbon($mday.'.'.$mon.'.'.$year);
			if($mon > $dob2[1] || $mon == $dob2[1]){
				$year=$year+1;
			}
			if ($mon == $dob2[1] && $mday < $dob2[2]) {
				$year=$year-1;
			}
			$ntoday = new Carbon($dob2[2].'.'.$dob2[1].'.'.$year); // Your date of birth
			$ndiff = $ntoday->diff($nbday);
			$next_r_mon=$ndiff->m;
			$next_r_day=$ndiff->d;
			$remDays=$ndiff->days;
			$nextBirth=date('l, F d, Y',strtotime("+$next_r_mon months +$next_r_day days ".date('Y-m-d')));
			$n_brdy_days_per = ($remDays / 365) * 100;

			$current  = getdate(); // Current date 	 	
			$half     = date('Y-m-d', strtotime("+6 months", strtotime($dob)));
			$birthday = date('Y-m-d', strtotime($dob));

			$Q2   = explode("-",$half);
			$bday = explode("-",$birthday); 

			if($Q2[1] > $current['mon'] || ($Q2[1] == $current['mon'] && $Q2[2] > $current['mday'])){
				$year_q2 = $current['year'];
				$mon_q2  = $Q2[1];
				$day_q2  = $Q2[2];
			}
			else{
				$year_q2 = $current['year'] + 1;
				$mon_q2  = $Q2[1];
				$day_q2  = $Q2[2];
			}
			if($bday[1] > $current['mon'] || ($bday[1] == $current['mon'] && $bday[2] > $current['mday'])){
				$bd_year = $current['year'];
				$bd_mon  = $bday[1];
				$bd_day  = $bday[2];
			}
			else{
				$bd_year = $current['year'] + 1;
				$bd_mon  = $bday[1];
				$bd_day  = $bday[2];
			}

			$next_bday = date('l, F d, Y', strtotime($bd_year.'-'.$bd_mon.'-'.$bd_day));
			$half_brdy = date('l, F d, Y', strtotime($year_q2.'-'.$mon_q2.'-'.$day_q2));
			
			$next   = new Carbon($day_q2.'-'.$mon_q2.'-'.$year_q2);
			$today  = new Carbon(date('d-m-Y'));

			$next_half_day = $today->diff($next);
			$n_half_brdy_days = round(($next_half_day->days / 365) * 100); 
			// return values
			
			$this->param = array(
				"Age" => $age,
				"Age_months" => $age_months,
				"Age_days" => $age_days,
				"birth_month" => $birth_month,
				"N_r_months" => $next_r_mon,
				"N_r_days" => $next_r_day,
				"Years" => $Totalyears,
				"Months" => $Total_months,
				"Weeks" => $Total_weeks,
				"Days" => $Total_days,
				"Hours" => $Total_hours,
				"Min" => $Total_minuts,
				"nextBirth" => $nextBirth,
				"remDays" => $remDays,
				"totalDays" => $totalDays,
				"daysName" => $daysName,
				"n_brdy_days_per" => $n_brdy_days_per,
				"half_brdy" => $half_brdy,
				"next_half_r_days" => $next_half_day->days,
				"n_half_brdy_days" => $n_half_brdy_days,
			);
			$this->param['RESULT'] = 1;
			return $this->param;
		}else{
			$this->param['error'] = 'Please Select Your Date of Birth.';
			return $this->param;
		}
	}

    // House Age Calculator
	public function house($request)
	{
		$build_date     = $request->input('build_date');
		$structure_type = $request->input('structure_type');

		if (!empty($structure_type) && !empty($build_date)) {
			$date1 = new Carbon($build_date);
			$date2 = new Carbon();
			if ($date1 < $date2) {
				$calculated_age = $date1->diff($date2);

				if ($structure_type == 'concrete') {
					$predicted_age = '50-60';
				} else if ($structure_type == 'cement-bricks') {
					$predicted_age = '75-100';
				} else if ($structure_type == 'wooden') {
					$predicted_age = '100-150';
				} else if ($structure_type == 'stone') {
					$predicted_age = '150-200';
				}

				$this->param['predicted_age'] = $predicted_age;
				$this->param['years']         = $calculated_age->y;
				$this->param['months']        = $calculated_age->m;
				$this->param['days']          = $calculated_age->d;
				$this->param['RESULT'] 		  = 1;
				return $this->param;
			} else {
				$this->param['error'] = 'Please! Check Your Input';
				return $this->param;
			}
		} else {
			$this->param['error'] = 'Please! Check Your Input';
			return $this->param;
		}
	}

    // Reading Time calculator
	public function reading($request){
		$reading_speed = trim($request->reading_speed);
		$read_pages = trim($request->read_pages);
		$book_unit = trim($request->book_unit);
		$book_leng = trim($request->book_leng);
		$daily_reading = trim($request->daily_reading);
		$total_unit = trim($request->total_unit);
		$time_unit = trim($request->time_unit);
		$reading_unit = trim($request->reading_unit);
		$period_unit = trim($request->period_unit);
		if(is_numeric($read_pages) && is_numeric($book_leng)){
			if($book_unit === "hr"){
				$read_pages = $read_pages / 60;
			}
			$answer = $book_leng / $read_pages;
			if($total_unit === "min"){
				$answer_main=$answer." min";
				$answer=$answer;
			}elseif($total_unit === "hr"){
				$answer=$answer / 60; 
				$answer_main=round($answer,3)." hrs";
				$answer=round($answer,3);
			}elseif($total_unit === "min/hr"){
				$hours = floor($answer / 60);
				$minutes = $answer % 60;
				$answer = $answer;
				$answer_main = $hours." hrs " .$minutes." min";
			}	
			if(is_numeric($daily_reading)){
				$dly_reading= $answer  / $book_leng;
				$dly_reading_min=$dly_reading *1440;
				$total_daily_reading= $daily_reading / $dly_reading_min;
				$period_spent= $answer / $daily_reading *1440;
				if($reading_unit === "min"){
					$total_daily_reading=round($total_daily_reading,3 )." min";
				}elseif($reading_unit === "hr"){
					$total_daily_reading=$total_daily_reading * 60  . " hrs";
				}elseif($reading_unit === "day"){
					$total_daily_reading=$total_daily_reading * 1440  . " days";
				}elseif($reading_unit === "week"){
					$total_daily_reading=$total_daily_reading * 10080 . " wks";
				}elseif($reading_unit === "month"){
					$total_daily_reading=$total_daily_reading * 43800 ." mons";
				}elseif($reading_unit === "year"){
					$total_daily_reading=$total_daily_reading * 525600 ." yrs";
				}
				if($period_unit === "min"){
					$period_spent= $period_spent . " min";
				}elseif($period_unit === "hr"){
					$period_sp=$period_spent / 60;
					$period_spent= round($period_sp,1) . " hrs";
				}elseif($period_unit === "day"){
					$period_sp=$period_spent / 1440;
					$period_spent= round($period_sp,1) . " day";
				}elseif($period_unit === "week"){
					$period_sp=$period_spent / 10080;
					$period_spent= round($period_sp,1) . " wks";
				}elseif($period_unit === "month"){
					$period_sp=$period_spent / 43800;
					$period_spent= round($period_sp,1) . " mons";
				}elseif($period_unit === "year"){
					$period_sp=$period_spent /  525600;
					$period_spent= round($period_sp,1) . " yrs";
				}elseif($period_unit === "minutes/hour"){
					$hours = floor($period_spent / 60);
					$minutes = $period_spent % 60;
					$period_spent = $hours ."hr " .$minutes. "min"; 
				}elseif($period_unit === "year/month/day"){
					$minutesPerYear = 365 * 24 * 60;
					$minutesPerMonth = 30 * 24 * 60; 
					$minutesPerDay = 24 * 60;
					$years = floor($period_spent / $minutesPerYear);
					$remainingMinutes = $period_spent % $minutesPerYear;
					$months = floor($remainingMinutes / $minutesPerMonth);
					$remainingMinutes = $remainingMinutes % $minutesPerMonth;
					$days = floor($remainingMinutes / $minutesPerDay);
					$period_spent = $years ."year ". $months ."mon " . $days . "day " ;
				}elseif($period_unit === "week/day"){
					$minutesPerWeek = 7 * 24 * 60;
					$minutesPerDay = 24 * 60;
					$week = floor($period_spent / $minutesPerWeek);
					$days = floor(($period_spent % $minutesPerWeek) / $minutesPerDay);
					$period_spent = $week ."week " . $days . "day " ;
				}elseif($period_unit === "day/hour/minutes"){
					$minutesPerDay = 24 * 60;
					$minutesPerHour = 60;
					$days = floor($period_spent / $minutesPerDay);
					$remainingMinutes = $period_spent % $minutesPerDay;
					$hours = floor($remainingMinutes / $minutesPerHour);
					$minutes = $remainingMinutes % $minutesPerHour;
					$period_spent = $days . " day, " . $hours . " hr, " . $minutes . " min";
				}
				$this->param['total_daily_reading'] = $total_daily_reading;
				$this->param['period_spent'] = $period_spent;
			}
		}else{
			$this->param['error'] = 'Please! Check Your Input';
			return $this->param; 
		}
		$this->param['answer'] = $answer_main;
		$this->param[ 'RESULT' ] = 1;
		return $this->param;
	}

    // Time Card calculator
	public function time_card($request)
	{
		// dd($request->all());
		//    if (isset($_POST['submit'])) {
		$selection1 = $request->input('selection1');
		$selection2 = $request->input('selection2');
		$selection3 = $request->input('selection3');
		// table 1 variables
		$inhour = $request->input('inhour');
		$inmin = $request->input('inmin');
		$inampm = $request->input('inampm');
		$outhour = $request->input('outhour');
		$outmin = $request->input('outmin');
		$outampm = $request->input('outampm');
		$inhourl1 = $request->input('inhourl1');
		$inminl1 = $request->input('inminl1');
		$inampml1 = $request->input('inampml1');
		$outhourl1 = $request->input('outhourl1');
		$outminl1 = $request->input('outminl1');
		$outampml1 = $request->input('outampml1');
		$inhourl2 = $request->input('inhourl2');
		$inminl2 = $request->input('inminl2');
		$inampml2 = $request->input('inampml2');
		$outhourl2 = $request->input('outhourl2');
		$outminl2 = $request->input('outminl2');
		$outampml2 = $request->input('outampml2');

		// table 1 optional

		$in = $request->input('in');
		$out = $request->input('out');
		$inlunch1 = $request->input('inlunch1');
		$outlunch1 = $request->input('outlunch1');
		$inlunch2 = $request->input('inlunch2');
		$outlunch2 = $request->input('outlunch2');

		// table 2 variables
		$t2inhour = $request->input('t2inhour');
		$t2inmin = $request->input('t2inmin');
		$t2inampm = $request->input('t2inampm');
		$t2outhour = $request->input('t2outhour');
		$t2outmin = $request->input('t2outmin');
		$t2outampm = $request->input('t2outampm');
		$t2inhourl1 = $request->input('t2inhourl1');
		$t2inminl1 = $request->input('t2inminl1');
		$t2inampml1 = $request->input('t2inampml1');
		$t2outhourl1 = $request->input('t2outhourl1');
		$t2outminl1 = $request->input('t2outminl1');
		$t2outampml1 = $request->input('t2outampml1');
		$t2inhourl2 = $request->input('t2inhourl2');
		$t2inminl2 = $request->input('t2inminl2');
		$t2inampml2 = $request->input('t2inampml2');
		$t2outhourl2 = $request->input('t2outhourl2');
		$t2outminl2 = $request->input('t2outminl2');
		$t2outampml2 = $request->input('t2outampml2');

		// table 2 optional
		$t2in = $request->input('t2in');
		$t2out = $request->input('t2out');
		$t2inlunch1 = $request->input('t2inlunch1');
		$t2outlunch1 = $request->input('t2outlunch1');
		$t2inlunch2 = $request->input('t2inlunch2');
		$t2outlunch2 = $request->input('t2outlunch2');

		// table 3 variables
		$t3inhour = $request->input('t3inhour');
		$t3inmin = $request->input('t3inmin');
		$t3inampm = $request->input('t3inampm');
		$t3outhour = $request->input('t3outhour');
		$t3outmin = $request->input('t3outmin');
		$t3outampm = $request->input('t3outampm');
		$t3inhourl1 = $request->input('t3inhourl1');
		$t3inminl1 = $request->input('t3inminl1');
		$t3inampml1 = $request->input('t3inampml1');
		$t3outhourl1 = $request->input('t3outhourl1');
		$t3outminl1 = $request->input('t3outminl1');
		$t3outampml1 = $request->input('t3outampml1');
		$t3inhourl2 = $request->input('t3inhourl2');
		$t3inminl2 = $request->input('t3inminl2');
		$t3inampml2 = $request->input('t3inampml2');
		$t3outhourl2 = $request->input('t3outhourl2');
		$t3outminl2 = $request->input('t3outminl2');
		$t3outampml2 = $request->input('t3outampml2');

		// table 3 optional
		$t3in = $request->input('t3in');
		$t3out = $request->input('t3out');
		$t3inlunch1 = $request->input('t3inlunch1');
		$t3outlunch1 = $request->input('t3outlunch1');
		$t3inlunch2 = $request->input('t3inlunch2');
		$t3outlunch2 = $request->input('t3outlunch2');

		// table 4 variables
		$t4inhour = $request->input('t4inhour');
		$t4inmin = $request->input('t4inmin');
		$t4inampm = $request->input('t4inampm');
		$t4outhour = $request->input('t4outhour');
		$t4outmin = $request->input('t4outmin');
		$t4outampm = $request->input('t4outampm');
		$t4inhourl1 = $request->input('t4inhourl1');
		$t4inminl1 = $request->input('t4inminl1');
		$t4inampml1 = $request->input('t4inampml1');
		$t4outhourl1 = $request->input('t4outhourl1');
		$t4outminl1 = $request->input('t4outminl1');
		$t4outampml1 = $request->input('t4outampml1');
		$t4inhourl2 = $request->input('t4inhourl2');
		$t4inminl2 = $request->input('t4inminl2');
		$t4inampml2 = $request->input('t4inampml2');
		$t4outhourl2 = $request->input('t4outhourl2');
		$t4outminl2 = $request->input('t4outminl2');
		$t4outampml2 = $request->input('t4outampml2');

		// table 4 optional
		$t4in = $request->input('t4in');
		$t4out = $request->input('t4out');
		$t4inlunch1 = $request->input('t4inlunch1');
		$t4outlunch1 = $request->input('t4outlunch1');
		$t4inlunch2 = $request->input('t4inlunch2');
		$t4outlunch2 = $request->input('t4outlunch2');

		$lunch = $request->input('lunch');
		$advancedcheck = $request->input('advancedcheck');
		if (isset($advancedcheck)) {
			$advancedcheck = $request->input('advancedcheck');
		} else {
			$advancedcheck = false;
		}
		$paid_lunch1 = $request->input('paid_lunch1');
		$paid_lunch2 = $request->input('paid_lunch2');
		$hour_rate = $request->input('hour_rate');
		$overtime = $request->input('overtime');
		$overtime_pay = $request->input('overtime_pay');
		$table_selection = $request->input('table_selection');
		$sick_h = $request->input('sick_h');
		$sick_m = $request->input('sick_m');
		$v_h = $request->input('v_h');
		$v_m = $request->input('v_m');
		$t2sick_h = $request->input('t2sick_h');
		$t2sick_m = $request->input('t2sick_m');
		$t2v_h = $request->input('t2v_h');
		$t2v_m = $request->input('t2v_m');
		$t3sick_h = $request->input('t3sick_h');
		$t3sick_m = $request->input('t3sick_m');
		$t3v_h = $request->input('t3v_h');
		$t3v_m = $request->input('t3v_m');
		$t4sick_h = $request->input('t4sick_h');
		$t4sick_m = $request->input('t4sick_m');
		$t4v_h = $request->input('t4v_h');
		$t4v_m = $request->input('t4v_m');
		$naam = $request->input('naam');
		$naam2 = $request->input('naam2');
		$naam3 = $request->input('naam3');
		$naam4 = $request->input('naam4');
		$s_date = $request->input('s_date');
		$e_date = $request->input('e_date');
		$s2_date = $request->input('s2_date');
		$e2_date = $request->input('e2_date');
		$s3_date = $request->input('s3_date');
		$e3_date = $request->input('e3_date');
		$s4_date = $request->input('s4_date');
		$e4_date = $request->input('e4_date');

		function timeCal($selection3 = null, $selection1 = null, $inhour = null, $inmin = null, $inampm = null, $outhour = null, $outmin = null, $outampm = null, $in = null, $out = null, $inhourl1 = null, $inminl1 = null, $inampml1 = " ", $outhourl1 = null, $outminl1 = null, $outampml1 = null, $inlunch1 = null, $outlunch1 = null, $inhourl2 = null, $inminl2 = null, $inampml2 = null, $outhourl2 = null, $outminl2 = null, $outampml2 = null, $inlunch2 = null, $outlunch2 = null, $sick_h = null, $sick_m = null, $v_h = null, $v_m = null, $advancedcheck = null, $lunch = null, $paid_lunch1 = null, $paid_lunch2 = null, $hour_rate = null, $overtime = null, $overtime_pay = null)
		{
			$checkHour = true;
			$checkHourl = true;
			$checkHourl2 = true;
			$regular_time = false;
			$overtime2_first = false;
			$overtime3_first = false;
			$overtime4_first = false;
			$overtime5_first = false;
			$overtime6_first = false;
			$a = $b = $c = $d = $sick_pay = $sick_time = $total_pay = $vacation_pay = $v_time = $ans_arrt2 = $ansl1_arrt2 = $ansl21_arrt2 = $ansl2_arrt2 = $overall_timet2 = $regular_timet2 = $overtime2_firstt2 = $overtime3_firstt2 = $sick_payt2 = $t2sick_timet2 = $total_payt2 = $vacation_payt2 = $v_timet2 = $overtime4_firstt2 = $overtime5_firstt2 = $overtime6_firstt2 = $s_pay = $sickpay = $days = $dayst2 = $overtime_work1 = $ans_arrt3 = $ansl1_arrt3 = $ansl21_arrt3 = $ansl2_arrt3 = $overall_timet3 = $regular_timet3 = $overtime2_firstt3 = $overtime3_firstt3 = $sick_payt3 = $t3sick_timet3 = $total_payt3 = $vacation_payt3 = $v_timet3 = $overtime4_firstt3 = $overtime5_firstt3 = $overtime6_firstt3 = $s_pay = $sickpay = $days = $dayst3 = $ans_arrt4 = $ansl1_arrt4 = $ansl21_arrt4 = $ansl2_arrt4 = $overall_timet4 = $regular_timet4 = $overtime2_firstt4 = $overtime3_firstt4 = $sick_payt4 = $t4sick_timet4 = $total_payt4 = $vacation_payt4 = $v_timet4 = $overtime4_firstt4 = $overtime5_firstt4 = $overtime6_firstt4 = $s_pay = $sickpay = $days = $dayst4 = false;
			$ans_arr = [];
			$ansl1_arr = [];
			$ansl2_arr = [];
			$ansl21_arr = [];
			$checkHour = true;
			if ($selection3 == "1") {
				for ($i = 0; $i < $selection1; $i++) {
					$hour = $inhour[$i];
					$hour1 = $outhour[$i];
					if (empty($hour) || empty($hour1)) {
						$checkHour = false;
					} else {
						$day = 14;
						if ($inampm[$i] == $outampm[$i]) {
							$day = 15;
						}
						$hour = $inhour[$i];
						$min = $inmin[$i];
						$ampm = $inampm[$i];
						if ($hour <= 9) {
							$hour = sprintf("%02d", $hour);
						}
						if ($min <= 9) {
							$min = sprintf("%02d", $min);
						}
						$inr1_res = $hour . ":" . $min . " " . $ampm;
						$inr1_time = date("H:i:s", strtotime($inr1_res));
						$inr1_time = new Carbon("2006-04-14 " . $inr1_time);
						$hour = $outhour[$i];
						$min = $outmin[$i];
						$ampm = $outampm[$i];
						if ($hour <= 9) {
							$hour = sprintf("%02d", $hour);
						}
						if ($min <= 9) {
							$min = sprintf("%02d", $min);
						}
						$outr1_res = $hour . ":" . $min . " " . $ampm;
						$outr1_time = date("H:i:s", strtotime($outr1_res));
						$outr1_time = new Carbon("2006-04-" . $day . " " . $outr1_time);
					}
				}
			} else if ($selection3 == "2") {
				for ($i = 0; $i < $selection1; $i++) {
					$hour = $in[$i];
					$hour1 = $out[$i];
					if (empty($hour) || empty($hour1)) {
						$checkHour = false;
					} else {
						$ab1 = substr($hour, 2);
						$ab2 = substr($hour1, 2);
						if ($ab1 < 59 && $ab2 < 59) {
							$day = 14;
							if ($hour1 < $hour) {
								$day = 15;
							}
							$inr1_time = date("H:i:s", strtotime($hour));
							$inr1_time = new Carbon("2006-04-14 " . $inr1_time);
							$outr1_time = date("H:i:s", strtotime($hour1));
							$outr1_time = new Carbon("2006-04-" . $day . " " . $outr1_time);
						} else {
							return false;
						}
					}
				}
			}
			if ($checkHour == true) {
				for ($i = 0; $i < $selection1; $i++) {
					$rowans1 = $inr1_time->diff($outr1_time);
					$ans_arr5[] = $rowans1->format('%h : %i');
					foreach ($ans_arr5 as $value) {
						list($t1, $t2) = explode(':', $value);
						$t1 = sprintf("%02d", $t1);
						$t2 = sprintf("%02d", $t2);
					}
					$ans_arr[] = $t1 . ":" . $t2;
					$a = $ans_arr;
				}
				if ($lunch == "2") {
					if ($selection3 == "1") {
						for ($i = 0; $i < $selection1; $i++) {
							$hourl1 = $inhourl1[$i];
							$hour1l1 = $outhourl1[$i];
							if (empty($hourl1) || empty($hour1l1)) {
								$checkHourl = false;
							} else {
								$day = 14;
								if ($inampm[$i] == $outampm[$i]) {
									$day = 15;
								}
								$hourl1 = $inhourl1[$i];
								$minl1 = $inminl1[$i];
								$ampml1 = $inampml1[$i];
								if ($hourl1 <= 9) {
									$hourl1 = sprintf("%02d", $hourl1);
								}
								if ($minl1 <= 9) {
									$minl1 = sprintf("%02d", $minl1);
								}
								$inr1l1_res = $hourl1 . ":" . $minl1 . " " . $ampml1;
								$inr1l1_time = date("H:i:s", strtotime($inr1l1_res));
								$inr1l1_time = new Carbon("2006-04-14 " . $inr1l1_time);
								$hourl1 = $outhourl1[$i];
								$minl1 = $outminl1[$i];
								$ampml1 = $outampml1[$i];
								if ($hourl1 <= 9) {
									$hourl1 = sprintf("%02d", $hourl1);
								}
								if ($minl1 <= 9) {
									$minl1 = sprintf("%02d", $minl1);
								}
								$outr1l1_res = $hourl1 . ":" . $minl1 . " " . $ampml1;
								$outr1l1_time = date("H:i:s", strtotime($outr1l1_res));
								$outr1l1_time = new Carbon("2006-04-" . $day . " " . $outr1l1_time);
							}
						}
					} else if ($selection3 == "2") {
						for ($i = 0; $i < $selection1; $i++) {
							$hourl1 = $inlunch1[$i];
							$hour1l1 = $outlunch1[$i];
							if (empty($hourl1) || empty($hour1l1)) {
								$checkHourl = false;
							} else {
								$xy1 = substr($hourl1, 2);
								$xy2 = substr($hour1l1, 2);
								if ($xy1 < 59 && $xy2 < 59) {
									$day = 14;
									if ($hour1l1 < $hourl1) {
										$day = 15;
									}
									$inr1l1_time = date("H:i:s", strtotime($hourl1));
									$inr1l1_time = new Carbon("2006-04-14 " . $inr1l1_time);
									$outr1l1_time = date("H:i:s", strtotime($hour1l1));
									$outr1l1_time = new Carbon("2006-04-" . $day . " " . $outr1l1_time);
								} else {
									return false;
								}
							}
						}
					}
					if ($checkHourl == true) {
						$ansl1_arr = [];
						for ($i = 0; $i < $selection1; $i++) {
							$rowans1l1 = $inr1l1_time->diff($outr1l1_time);
							$ansl1_arr5[] = $rowans1l1->format('%h : %i');
							foreach ($ansl1_arr5 as $value) {
								list($t1, $t2) = explode(':', $value);
								$t1 = sprintf("%02d", $t1);
								$t2 = sprintf("%02d", $t2);
							}
							$ansl1_arr[] = $t1 . ":" . $t2;
							$b = $ansl1_arr;
						}
					} else {
						return false;
					}
				}
				if ($lunch == "3") {
					if ($selection3 == "1") {
						for ($i = 0; $i < $selection1; $i++) {
							$hourl1 = $inhourl1[$i];
							$hour1l1 = $outhourl1[$i];
							if (empty($hourl1) || empty($hour1l1)) {
								$checkHourl = false;
							} else {
								$day = 14;
								if ($inampm[$i] == $outampm[$i]) {
									$day = 15;
								}
								$hourl1 = $inhourl1[$i];
								$minl1 = $inminl1[$i];
								$ampml1 = $inampml1[$i];
								if ($hourl1 <= 9) {
									$hourl1 = sprintf("%02d", $hourl1);
								}
								if ($minl1 <= 9) {
									$minl1 = sprintf("%02d", $minl1);
								}
								$inr1l1_res = $hourl1 . ":" . $minl1 . " " . $ampml1;
								$inr1l1_time = date("H:i:s", strtotime($inr1l1_res));
								$inr1l1_time = new Carbon("2006-04-14 " . $inr1l1_time);
								$hourl1 = $outhourl1[$i];
								$minl1 = $outminl1[$i];
								$ampml1 = $outampml1[$i];
								if ($hourl1 <= 9) {
									$hourl1 = sprintf("%02d", $hourl1);
								}
								if ($minl1 <= 9) {
									$minl1 = sprintf("%02d", $minl1);
								}
								$outr1l1_res = $hourl1 . ":" . $minl1 . " " . $ampml1;
								$outr1l1_time = date("H:i:s", strtotime($outr1l1_res));
								$outr1l1_time = new Carbon("2006-04-" . $day . " " . $outr1l1_time);
							}
						}
						for ($i = 0; $i < $selection1; $i++) {
							$hourl2 = $inhourl2[$i];
							$hour1l2 = $outhourl2[$i];
							if (empty($hourl2) || empty($hour1l2)) {
								$checkHourl2 = false;
							} else {
								$day = 14;
								if ($inampm[$i] == $outampm[$i]) {
									$day = 15;
								}
								$hourl2 = $inhourl2[$i];
								$minl2 = $inminl2[$i];
								$ampml2 = $inampml2[$i];
								if ($hourl2 <= 9) {
									$hourl2 = sprintf("%02d", $hourl2);
								}
								if ($minl2 <= 9) {
									$minl2 = sprintf("%02d", $minl2);
								}
								$inr1l2_res = $hourl2 . ":" . $minl2 . " " . $ampml2;
								$inr1l2_time = date("H:i:s", strtotime($inr1l2_res));
								$inr1l2_time = new Carbon("2006-04-14 " . $inr1l2_time);
								$hourl2 = $outhourl2[$i];
								$minl2 = $outminl2[$i];
								$ampml2 = $outampml2[$i];
								if ($hourl2 <= 9) {
									$hourl2 = sprintf("%02d", $hourl2);
								}
								if ($minl2 <= 9) {
									$minl2 = sprintf("%02d", $minl2);
								}
								$outr1l2_res = $hourl2 . ":" . $minl2 . " " . $ampml2;
								$outr1l2_time = date("H:i:s", strtotime($outr1l2_res));
								$outr1l2_time = new Carbon("2006-04-" . $day . " " . $outr1l2_time);
							}
						}
					} else if ($selection3 == "2") {
						for ($i = 0; $i < $selection1; $i++) {
							$hourl1 = $inlunch1[$i];
							$hour1l1 = $outlunch1[$i];
							if (empty($hourl1) || empty($hour1l1)) {
								$checkHourl = false;
							} else {
								$xy1 = substr($hourl1, 2);
								$xy2 = substr($hour1l1, 2);
								if ($xy1 < 59 && $xy2 < 59) {
									$day = 14;
									if ($hour1l1 < $hourl1) {
										$day = 15;
									}
									$inr1l1_time = date("H:i:s", strtotime($hourl1));
									$inr1l1_time = new Carbon("2006-04-14 " . $inr1l1_time);
									$outr1l1_time = date("H:i:s", strtotime($hour1l1));
									$outr1l1_time = new Carbon("2006-04-" . $day . " " . $outr1l1_time);
								} else {
									return false;
								}
							}
						}
						for ($i = 0; $i < $selection1; $i++) {
							$hourl2 = $inlunch2[$i];
							$hour1l2 = $outlunch2[$i];
							if (empty($hourl2) || empty($hour1l2)) {
								$checkHourl2 = false;
							} else {
								$x1y1 = substr($hourl2, 2);
								$x2y2 = substr($hour1l2, 2);
								if ($x1y1 < 59 && $x2y2 < 59) {
									$day = 14;
									if ($hour1l2 < $hourl2) {
										$day = 15;
									}
									$inr1l2_time = date("H:i:s", strtotime($hourl2));
									$inr1l2_time = new Carbon("2006-04-14 " . $inr1l2_time);
									$outr1l2_time = date("H:i:s", strtotime($hour1l2));
									$outr1l2_time = new Carbon("2006-04-" . $day . " " . $outr1l2_time);
								} else {
									return false;
								}
							}
						}
					}
					if ($checkHourl == true) {
						$ansl1_arr = [];
						for ($i = 0; $i < $selection1; $i++) {
							$rowans1l1 = $inr1l1_time->diff($outr1l1_time);
							$ansl21_arr5[] = $rowans1l1->format('%h : %i');
							foreach ($ansl21_arr5 as $value) {
								list($t1, $t2) = explode(':', $value);
								$t1 = sprintf("%02d", $t1);
								$t2 = sprintf("%02d", $t2);
							}
							$ansl21_arr[] = $t1 . ":" . $t2;
							$c = $ansl21_arr;
						}
					} else {
						return false;
					}
					if ($checkHourl2 == true) {
						$ansl1_arr = [];
						for ($i = 0; $i < $selection1; $i++) {
							$rowans1l2 = $inr1l2_time->diff($outr1l2_time);
							$ansl2_arr5[] = $rowans1l2->format('%h : %i');
							foreach ($ansl2_arr5 as $value) {
								list($t1, $t2) = explode(':', $value);
								$t1 = sprintf("%02d", $t1);
								$t2 = sprintf("%02d", $t2);
							}
							$ansl2_arr[] = $t1 . ":" . $t2;
							$d = $ansl2_arr;
						}
					} else {
						return false;
					}
				}
			} else {
				return false;
			}

			if ($lunch == "1") {
				if ($advancedcheck == true) {
					if (!empty($paid_lunch1) && !empty($paid_lunch2)) {
						$min1 = "00" . ":" . $paid_lunch1;
						$min2 = "00" . ":" . $paid_lunch2;
						function calculate_total_time()
						{
							$i = 0;
							foreach (func_get_args() as $time) {
								sscanf($time, '%d:%d', $hour, $min);
								$i += $hour * 60 + $min;
							}
							if ($h = floor($i / 60)) {
								$i %= 60;
							}
							return sprintf('%02d:%02d', $h, $i);
						}
						$paid_lunch = calculate_total_time($min1, $min2);
						foreach ($ans_arr as $key => $val) {
							list($h, $m) = explode(':', $val);
							if ($h <= 9) {
								$h = sprintf("%02d", $h);
							}
							if ($m <= 9) {
								$m = sprintf("%02d", $m);
							}
							$answer1 = trim($h) . ":" . trim($m) . ":" . "00";
							$secs = strtotime($paid_lunch) - strtotime("00:00:00");
							$resultt2[] = date("H:i", strtotime($answer1) - $secs);
						}
						$overall_time = $resultt2;
					} else if (!empty($paid_lunch1)) {
						$paid_lunch = "00" . ":" . $paid_lunch1;
						foreach ($ans_arr as $key => $val) {
							list($h, $m) = explode(':', $val);
							if ($h <= 9) {
								$h = sprintf("%02d", $h);
							}
							if ($m <= 9) {
								$m = sprintf("%02d", $m);
							}
							$answer1 = trim($h) . ":" . trim($m) . ":" . "00";
							$secs = strtotime($paid_lunch) - strtotime("00:00:00");
							$result2[] = date("H:i", strtotime($answer1) - $secs);
						}
						$overall_time = $result2;
					} else if (!empty($paid_lunch2)) {
						$paid_lunch = "00" . ":" . $paid_lunch2;
						foreach ($ans_arr as $key => $val) {
							list($h, $m) = explode(':', $val);
							if ($h <= 9) {
								$h = sprintf("%02d", $h);
							}
							if ($m <= 9) {
								$m = sprintf("%02d", $m);
							}
							$answer1 = trim($h) . ":" . trim($m) . ":" . "00";
							$secs = strtotime($paid_lunch) - strtotime("00:00:00");
							$result3[] = date("H:i", strtotime($answer1) - $secs);
						}
						$overall_time = $result3;
					}
				} else {
					$overall_time = $ans_arr;
				}
			}
			if ($lunch == "2") {
				foreach ($a as $key => $val1) {
					$val2 = $b[$key];
					list($hl1, $ml1) = explode(':', $val1);
					if ($hl1 <= 9) {
						$hl1 = sprintf("%02d", $hl1);
					}
					if ($ml1 <= 9) {
						$ml1 = sprintf("%02d", $ml1);
					}
					$val11 = trim($hl1) . ":" . trim($ml1) . ":" . "00";
					list($hl12, $ml12) = explode(':', $val2);
					if ($hl12 <= 9) {
						$hl12 = sprintf("%02d", $hl12);
					}
					if ($ml12 <= 9) {
						$ml12 = sprintf("%02d", $ml12);
					}
					$val12 = trim($hl12) . ":" . trim($ml12) . ":" . "00";
					$secs = strtotime($val12) - strtotime("00:00:00");
					$result20[] = date("H:i", strtotime($val11) + $secs);
					$overall_time = $result20;
				}
				if (!empty($paid_lunch1)) {
					$paid_lunch = "00" . ":" . $paid_lunch1;
					foreach ($result20 as $key => $val) {
						list($h, $m) = explode(':', $val);
						if ($h <= 9) {
							$h = sprintf("%02d", $h);
						}
						if ($m <= 9) {
							$m = sprintf("%02d", $m);
						}
						$answer1 = $h . ":" . $m . ":" . "00";
						$secs = strtotime($paid_lunch) - strtotime("00:00:00");
						$result21[] = date("H:i", strtotime($answer1) + $secs);
						$overall_time = $result21;
					}
				}
			}
			if ($lunch == "3") {
				foreach ($a as $key => $val1) {
					$val2 = $c[$key];
					$val3 = $d[$key];
					list($hl1, $ml1) = explode(':', $val1);
					if ($hl1 <= 9) {
						$hl1 = sprintf("%02d", $hl1);
					}
					if ($ml1 <= 9) {
						$ml1 = sprintf("%02d", $ml1);
					}
					$val11 = trim($hl1) . ":" . trim($ml1) . ":" . "00";
					list($hl12, $ml12) = explode(':', $val2);
					if ($hl12 <= 9) {
						$hl12 = sprintf("%02d", $hl12);
					}
					if ($ml12 <= 9) {
						$ml12 = sprintf("%02d", $ml12);
					}
					$val12 = trim($hl12) . ":" . trim($ml12) . ":" . "00";
					list($hl13, $ml13) = explode(":", $val3);
					if ($hl13 <= 9) {
						$hl13 = sprintf("%02d", $hl13);
					}
					if ($ml13 <= 9) {
						$ml13 = sprintf("%02d", $ml13);
					}
					$val13 = trim($hl13) . ":" . trim($ml13) . ":" . "00";
					$secs = strtotime($val12) - strtotime("00:00:00");
					$secs2 = strtotime($val13) - strtotime("00:00:00");
					$result30[] = date("H:i", strtotime($val11) + $secs + $secs2);
					$overall_time = $result30;
				}
				if (!empty($paid_lunch2)) {
					$paid_lunch = "00" . ":" . $paid_lunch2;
					foreach ($result30 as $key => $val) {
						list($h, $m) = explode(':', $val);
						if ($h <= 9) {
							$h = sprintf("%02d", $h);
						}
						if ($m <= 9) {
							$m = sprintf("%02d", $m);
						}
						$answer1 = $h . ":" . $m . ":" . "00";
						$secs = strtotime($paid_lunch) - strtotime("00:00:00");
						$result31[] = date("H:i", strtotime($answer1) + $secs);
						$overall_time = $result31;
					}
				}
			}
			function AddPlayTime($overall_time)
			{
				$minutes = 0;
				foreach ($overall_time as $value) {
					list($hour, $minute) = explode(':', $value);
					$minutes += trim($hour) * 60;
					$minutes += trim($minute);
				}
				$hours = floor($minutes / 60);
				$minutes -= $hours * 60;
				return sprintf('%02d:%02d', $hours, $minutes);
			}
			$table_ans = AddPlayTime($overall_time);
			$overtime3_first = $table_ans;
			if ($overtime == "0") {
				if (!empty($hour_rate)) {
					foreach ($overall_time as $key => $val) {
						$a1 = explode(":", $val);
						$a1_ans[] = $a1[0] . ":" . "00";
						$pay[] = trim($a1[0]) * $hour_rate;
						$pay2[] = $a1[1] / 60 * $hour_rate;
						$pay2_ans[] = "00" . ":" . $a1[1];
						$pay_sum = array_merge($pay, $pay2);
						$paysum = array_sum($pay_sum);
						$overtime3_first = $table_ans;
						$overtime6_first = $paysum;
					}
				}
				$overtime3_first = $table_ans;
			}
			if ($overtime == "1") {
				foreach ($overall_time as $key => $val) {
					list($overtime_h1, $overtime_m1) = explode(":", $val);
					if ($overtime_h1 >= 8) {
						$hour_res = trim($overtime_h1) - 8;
						$overtime_work1[] = $hour_res . ":" . $overtime_m1;
					} else {
						$overtime3_first = $table_ans;
					}
				}
				function calculate_overtime_one($overtime_work1)
				{
					$minutes = 0;
					if ($overtime_work1 != "") {
						foreach ($overtime_work1 as $value) {
							list($hour, $minute) = explode(':', $value);
							$minutes += trim($hour) * 60;
							$minutes += trim($minute);
						}
					}
					$hours = floor($minutes / 60);
					$minutes -= $hours * 60;
					return sprintf('%02d:%02d', $hours, $minutes);
				}
				$Ans1 = calculate_overtime_one($overtime_work1);
				list($Ans1_h, $Ans1_m) = explode(':', $Ans1);
				if ($Ans1_h <= 9) {
					$Ans1_h = sprintf("%02d", $Ans1_h);
				}
				if ($Ans1_m <= 9) {
					$Ans1_m = sprintf("%02d", $Ans1_m);
				}
				$Ans11 = trim($Ans1_h) . ":" . trim($Ans1_m) . ":" . "00";
				list($tableans_h, $tableans_m) = explode(':', $table_ans);
				if ($tableans_h <= 9) {
					$tableans_h = sprintf("%02d", $tableans_h);
				}
				if ($tableans_m <= 9) {
					$tableans_m = sprintf("%02d", $tableans_m);
				}
				if ($selection1 == "1") {
					$duty_time = 1 * 8;
				} else if ($selection1 == "2") {
					$duty_time = 2 * 8;
				} else if ($selection1 == "3") {
					$duty_time = 3 * 8;
				} else if ($selection1 == "4") {
					$duty_time = 4 * 8;
				} else if ($selection1 == "5") {
					$duty_time = 5 * 8;
				} else if ($selection1 == "6") {
					$duty_time = 6 * 8;
				} else if ($selection1 == "7") {
					$duty_time = 7 * 8;
				}
				$regular_time = $duty_time . ":" . "00";
				if (!empty($hour_rate)) {
					if (!empty($overtime_work1)) {
					}
					$pay_h = trim($duty_time) * $hour_rate;
					$pay_dutytime = $pay_h;
				}
				if (!empty($overtime_pay)) {
					list($overtimepay_h, $overtimepay_m) = explode(":", $Ans1);
					if (!empty($hour_rate)) {
						$overpay_h = trim($overtimepay_h) * trim($hour_rate) * trim($overtime_pay);
						$overpay_m = ($overtimepay_m / 60) * trim($hour_rate) * trim($overtime_pay);
						$overwork_pay = $overpay_h + $overpay_m;
					}
				}
				if (!empty($hour_rate) && !empty($overtime_pay)) {
					$total_pay = $overwork_pay + $pay_dutytime;
				}
				$overtime2_first = $Ans1;
				$overtime3_first = $table_ans;
				if (!empty($hour_rate)) {
					$overtime4_first = $pay_dutytime;
				}
				if (!empty($overwork_pay)) {
					$overtime5_first = $overwork_pay;
				}
				if (!empty($hour_rate) && !empty($overtime_pay)) {
					$overtime6_first = $total_pay;
				}
			}
			if ($overtime == "2") {
				list($tableans_h, $tableans_m) = explode(":", $table_ans);
				if ($tableans_h >= 40) {
					$hour_res = trim($tableans_h) - 40;
					$overtime_work1 = $hour_res . ":" . $tableans_m;
					$overtime2_first = $overtime_work1;
				} else {
					$overtime3_first = $table_ans;
					$overtime2_first = "00";
				}
				if ($overtime_work1 != "") {
					list($Ans1_h, $Ans1_m) = explode(':', $overtime_work1);
					if ($Ans1_h <= 9) {
						$Ans1_h = sprintf("%02d", $Ans1_h);
					}
					if ($Ans1_m <= 9) {
						$Ans1_m = sprintf("%02d", $Ans1_m);
					}
					$Ans111 = trim($Ans1_h) . ":" . trim($Ans1_m);
				}
				list($tableans_h, $tableans_m) = explode(':', $table_ans);
				if ($tableans_h <= 9) {
					$tableans_h = sprintf("%02d", $tableans_h);
				}
				if ($tableans_m <= 9) {
					$tableans_m = sprintf("%02d", $tableans_m);
				}
				$tableans1 = trim($tableans_h) . ":" . trim($tableans_m) . ":" . "00";
				if ($overtime_work1 != "") {
					$duty_timet2 = 40;
					$regular_time = $duty_timet2 . ":" . "00";
				}
				if (!empty($hour_rate)) {
					if (!empty($duty_timet2)) {
						$pay_h = trim($duty_timet2) * $hour_rate;
						$pay_dutytimet1 = $pay_h;
					}
					if (empty($overtime_work1)) {
						$regular_time = $table_ans;
						list($tableans_h, $tableans_m) = explode(':', $table_ans);
						$pay_h = trim($tableans_h) * $hour_rate;
						$pay_dutytimet1 = $pay_h;
					}
					$overtime4_first = $pay_dutytimet1;
				}
				if (!empty($overtime_pay)) {
					if ($overtime_work1 != "") {
						list($overtimepay_h, $overtimepay_m) = explode(":", $overtime_work1);
					}
					if ($hour_rate != "" && $overtime_pay != "") {
						if (!empty($overtimepay_h)) {
							$overpay_h = trim($overtimepay_h) * $hour_rate * $overtime_pay;
							$overpay_m = ($overtimepay_m / 60) * $hour_rate * $overtime_pay;
							$overwork_payt1 = $overpay_h + $overpay_m;
							$overtime5_first = $overwork_payt1;
						}
					}
				}
				if (!empty($hour_rate) && !empty($overtime_pay) && !empty($pay_dutytimet1)) {
					if (!empty($overwork_payt1)) {
						$total_pay = $pay_dutytimet1 + $overwork_payt1;
						$overtime6_first = $total_pay;
					}
				}
				$overtime3_first = $table_ans;
			}
			if (!empty($sick_h) || !empty($sick_m)) {
				if ($sick_h <= 9) {
					$sick_h = sprintf("%02d", $sick_h);
				}
				if ($sick_m <= 9) {
					$sick_m = sprintf("%02d", $sick_m);
				}
				list($h, $m) = explode(":", $table_ans);
				$total_m = $sick_m + $m;
				$total_h = $sick_h + $h;
				$t_pay = $total_h . ":" . $total_m;
				$answer1 = trim($sick_h) . ":" . trim($sick_m);
				if (!empty($hour_rate)) {
					if (!empty($answer1)) {
						list($s_h, $s_m) = explode(":", $answer1);
						$sickpay_h = trim($s_h) * $hour_rate;
						$sickpay_m = ($s_m / 60) * $hour_rate;
						$s_pay = $sickpay_h + $sickpay_m;
					}
					$sick_pay = $s_pay;
					list($sick_hour, $sick_min) = explode(":", $t_pay);
					$pay_h = trim($sick_hour) * $hour_rate;
					$pay_m = ($sick_min / 60) * $hour_rate;
					$sickpay = $pay_h + $pay_m;
					$overtime6_first = $sickpay;
				}
				$sick_time = trim($sick_h) . ":" . trim($sick_m);
				$overtime3_first = $t_pay;
				if ($hour_rate != "") {
					$sick_pay = $s_pay;
					$overtime6_first = $sickpay;
				}
			}
			if (!empty($v_h) || !empty($v_m)) {
				if ($v_h <= 9) {
					$v_h = sprintf("%02d", $v_h);
				}
				if ($v_m <= 9) {
					$v_m = sprintf("%02d", $v_m);
				}
				$answer1 = trim($v_h) . ":" . trim($v_m);
				$secs = strtotime($answer1) - strtotime("00:00:00");
				if (!empty($sick_h) || !empty($sick_m)) {
					if ($sick_h <= 9) {
						$sick_h = sprintf("%02d", $sick_h);
					}
					if ($sick_m <= 9) {
						$sick_m = sprintf("%02d", $sick_m);
					}
					$answer2 = trim($sick_h) . ":" . trim($sick_m);
					$v_hours = date("H:i", strtotime($answer2) + $secs);
					list($hours, $minutes) = explode(":", $v_hours);
					list($h, $m) = explode(":", $table_ans);
					$total_m = $minutes + $m;
					$total_h = $hours + $h;
					$total_sick = $total_h . ":" . $total_m;
					$overtime3_first = $total_sick;
				} else {
					$v_hours = date("H:i", strtotime($table_ans) + $secs);
					$overtime3_first = $v_hours;
				}
				if (!empty($hour_rate)) {
					list($vacation_h, $vacation_m) = explode(":", $answer1);
					$sickpay_h = trim($vacation_h) * $hour_rate;
					$sickpay_m = ($vacation_m / 60) * $hour_rate;
					$v_pay = $sickpay_h + $sickpay_m;
					list($v_hour, $v_min) = explode(":", $total_sick);
					$pay_h = trim($v_hour) * $hour_rate;
					$pay_m = ($v_min / 60) * $hour_rate;
					$sickpay = $pay_h + $pay_m;
				}
				$v_time = trim($v_h) . ":" . trim($v_m);
				if ($hour_rate != "") {
					$vacation_pay = $v_pay;
					$overtime6_first = $sickpay;
				}
			}
			return array($ans_arr, $ansl1_arr, $ansl21_arr, $ansl2_arr, $overall_time, $regular_time, $overtime2_first, $overtime3_first, $sick_pay, $sick_time, $vacation_pay, $v_time, $overtime4_first, $overtime5_first, $overtime6_first);
		}
		function timeCal2($selection3 = null, $selection1 = null, $inhour = null, $inmin = null, $inampm = null, $outhour = null, $outmin = null, $outampm = null, $in = null, $out = null, $inhourl1 = null, $inminl1 = null, $inampml1 = " ", $outhourl1 = null, $outminl1 = null, $outampml1 = null, $inlunch1 = null, $outlunch1 = null, $inhourl2 = null, $inminl2 = null, $inampml2 = null, $outhourl2 = null, $outminl2 = null, $outampml2 = null, $inlunch2 = null, $outlunch2 = null, $sick_h = null, $sick_m = null, $v_h = null, $v_m = null, $advancedcheck = null, $lunch = null, $paid_lunch1 = null, $paid_lunch2 = null, $hour_rate = null, $overtime = null, $overtime_pay = null)
		{
			$checkHour = true;
			$checkHourl = true;
			$checkHourl2 = true;
			$regular_time = false;
			$overtime2_first = false;
			$overtime3_first = false;
			$overtime4_first = false;
			$overtime5_first = false;
			$overtime6_first = false;
			$a = $b = $c = $d = $sick_pay = $sick_time = $total_pay = $vacation_pay = $v_time = $ans_arrt2 = $ansl1_arrt2 = $ansl21_arrt2 = $ansl2_arrt2 = $overall_timet2 = $regular_timet2 = $overtime2_firstt2 = $overtime3_firstt2 = $sick_payt2 = $t2sick_timet2 = $total_payt2 = $vacation_payt2 = $v_timet2 = $overtime4_firstt2 = $overtime5_firstt2 = $overtime6_firstt2 = $s_pay = $sickpay = $days = $dayst2 = $overtime_work1 = $ans_arrt3 = $ansl1_arrt3 = $ansl21_arrt3 = $ansl2_arrt3 = $overall_timet3 = $regular_timet3 = $overtime2_firstt3 = $overtime3_firstt3 = $sick_payt3 = $t3sick_timet3 = $total_payt3 = $vacation_payt3 = $v_timet3 = $overtime4_firstt3 = $overtime5_firstt3 = $overtime6_firstt3 = $s_pay = $sickpay = $days = $dayst3 = $ans_arrt4 = $ansl1_arrt4 = $ansl21_arrt4 = $ansl2_arrt4 = $overall_timet4 = $regular_timet4 = $overtime2_firstt4 = $overtime3_firstt4 = $sick_payt4 = $t4sick_timet4 = $total_payt4 = $vacation_payt4 = $v_timet4 = $overtime4_firstt4 = $overtime5_firstt4 = $overtime6_firstt4 = $s_pay = $sickpay = $days = $dayst4 = false;
			$ans_arr = [];
			$ansl1_arr = [];
			$ansl2_arr = [];
			$ansl21_arr = [];
			$checkHour = true;
			if ($selection3 == "1") {
				for ($i = 0; $i < $selection1; $i++) {
					$hour = $inhour[$i];
					$hour1 = $outhour[$i];
					if (empty($hour) || empty($hour1)) {
						$checkHour = false;
					} else {
						$day = 14;
						if ($inampm[$i] == $outampm[$i]) {
							$day = 15;
						}
						$hour = $inhour[$i];
						$min = $inmin[$i];
						$ampm = $inampm[$i];
						if ($hour <= 9) {
							$hour = sprintf("%02d", $hour);
						}
						if ($min <= 9) {
							$min = sprintf("%02d", $min);
						}
						$inr1_res = $hour . ":" . $min . " " . $ampm;
						$inr1_time = date("H:i:s", strtotime($inr1_res));
						$inr1_time = new Carbon("2006-04-14 " . $inr1_time);
						$hour = $outhour[$i];
						$min = $outmin[$i];
						$ampm = $outampm[$i];
						if ($hour <= 9) {
							$hour = sprintf("%02d", $hour);
						}
						if ($min <= 9) {
							$min = sprintf("%02d", $min);
						}
						$outr1_res = $hour . ":" . $min . " " . $ampm;
						$outr1_time = date("H:i:s", strtotime($outr1_res));
						$outr1_time = new Carbon("2006-04-" . $day . " " . $outr1_time);
					}
				}
			} else if ($selection3 == "2") {
				for ($i = 0; $i < $selection1; $i++) {
					$hour = $in[$i];
					$hour1 = $out[$i];
					if (empty($hour) || empty($hour1)) {
						$checkHour = false;
					} else {
						$ab1 = substr($hour, 2);
						$ab2 = substr($hour1, 2);
						if ($ab1 < 59 && $ab2 < 59) {
							$day = 14;
							if ($hour1 < $hour) {
								$day = 15;
							}
							$inr1_time = date("H:i:s", strtotime($hour));
							$inr1_time = new Carbon("2006-04-14 " . $inr1_time);
							$outr1_time = date("H:i:s", strtotime($hour1));
							$outr1_time = new Carbon("2006-04-" . $day . " " . $outr1_time);
						} else {
							return false;
						}
					}
				}
			}
			if ($checkHour == true) {
				for ($i = 0; $i < $selection1; $i++) {
					// $day=14;
					// if ($inampm[$i]==$outampm[$i]) {
					// 	$day=15;
					// }
					// $hour=$inhour[$i];
					// $min=$inmin[$i];
					// $ampm=$inampm[$i];
					// if ($hour<=9) {
					// 	$hour=sprintf("%02d", $hour);
					// }
					// if ($min<=9) {
					// 	$min=sprintf("%02d", $min);
					// }
					// $inr1_res=$hour.":".$min." ".$ampm;
					// $inr1_time = date("H:i:s", strtotime($inr1_res));
					// $inr1_time = new Carbon("2006-04-14 ".$inr1_time);
					// $hour=$outhour[$i];
					// $min=$outmin[$i];
					// $ampm=$outampm[$i];
					// if ($hour<=9) {
					// 	$hour=sprintf("%02d", $hour);
					// }
					// if ($min<=9) {
					// 	$min=sprintf("%02d", $min);
					// }
					// $outr1_res=$hour.":".$min." ".$ampm;
					// $outr1_time = date("H:i:s", strtotime($outr1_res));
					// $outr1_time = new Carbon("2006-04-".$day." ".$outr1_time);
					$rowans1 = $inr1_time->diff($outr1_time);
					$ans_arr5[] = $rowans1->format('%h : %i');
					foreach ($ans_arr5 as $value) {
						list($t1, $t2) = explode(':', $value);
						$t1 = sprintf("%02d", $t1);
						$t2 = sprintf("%02d", $t2);
					}
					$ans_arr[] = $t1 . ":" . $t2;
					$a = $ans_arr;
				}
				if ($lunch == "2") {
					if ($selection3 == "1") {
						for ($i = 0; $i < $selection1; $i++) {
							$hourl1 = $inhourl1[$i];
							$hour1l1 = $outhourl1[$i];
							if (empty($hourl1) || empty($hour1l1)) {
								$checkHourl = false;
							} else {
								$day = 14;
								if ($inampm[$i] == $outampm[$i]) {
									$day = 15;
								}
								$hourl1 = $inhourl1[$i];
								$minl1 = $inminl1[$i];
								$ampml1 = $inampml1[$i];
								if ($hourl1 <= 9) {
									$hourl1 = sprintf("%02d", $hourl1);
								}
								if ($minl1 <= 9) {
									$minl1 = sprintf("%02d", $minl1);
								}
								$inr1l1_res = $hourl1 . ":" . $minl1 . " " . $ampml1;
								$inr1l1_time = date("H:i:s", strtotime($inr1l1_res));
								$inr1l1_time = new Carbon("2006-04-14 " . $inr1l1_time);
								$hourl1 = $outhourl1[$i];
								$minl1 = $outminl1[$i];
								$ampml1 = $outampml1[$i];
								if ($hourl1 <= 9) {
									$hourl1 = sprintf("%02d", $hourl1);
								}
								if ($minl1 <= 9) {
									$minl1 = sprintf("%02d", $minl1);
								}
								$outr1l1_res = $hourl1 . ":" . $minl1 . " " . $ampml1;
								$outr1l1_time = date("H:i:s", strtotime($outr1l1_res));
								$outr1l1_time = new Carbon("2006-04-" . $day . " " . $outr1l1_time);
							}
						}
					} else if ($selection3 == "2") {
						for ($i = 0; $i < $selection1; $i++) {
							$hourl1 = $inlunch1[$i];
							$hour1l1 = $outlunch1[$i];
							if (empty($hourl1) || empty($hour1l1)) {
								$checkHourl = false;
							} else {
								$xy1 = substr($hourl1, 2);
								$xy2 = substr($hour1l1, 2);
								if ($xy1 < 59 && $xy2 < 59) {
									$day = 14;
									if ($hour1l1 < $hourl1) {
										$day = 15;
									}
									$inr1l1_time = date("H:i:s", strtotime($hourl1));
									$inr1l1_time = new Carbon("2006-04-14 " . $inr1l1_time);
									$outr1l1_time = date("H:i:s", strtotime($hour1l1));
									$outr1l1_time = new Carbon("2006-04-" . $day . " " . $outr1l1_time);
								} else {
									return false;
								}
							}
						}
					}
					if ($checkHourl == true) {
						$ansl1_arr = [];
						for ($i = 0; $i < $selection1; $i++) {
							// $day=14;
							// if ($inampm[$i]==$outampm[$i]) {
							// 	$day=15;
							// }
							// $hourl1=$inhourl1[$i];
							// $minl1=$inminl1[$i];
							// $ampml1=$inampml1[$i];
							// if ($hourl1<=9) {
							// 	$hourl1=sprintf("%02d", $hourl1);
							// }
							// if ($minl1<=9) {
							// 	$minl1=sprintf("%02d", $minl1);
							// }
							// $inr1l1_res=$hourl1.":".$minl1." ".$ampml1;
							// $inr1l1_time = date("H:i:s", strtotime($inr1l1_res));
							// $inr1l1_time = new Carbon("2006-04-14 ".$inr1l1_time);
							// $hourl1=$outhourl1[$i];
							// $minl1=$outminl1[$i];
							// $ampml1=$outampml1[$i];
							// if ($hourl1<=9) {
							// 	$hourl1=sprintf("%02d", $hourl1);
							// }
							// if ($minl1<=9) {
							// 	$minl1=sprintf("%02d", $minl1);
							// }
							// $outr1l1_res=$hourl1.":".$minl1." ".$ampml1;
							// $outr1l1_time = date("H:i:s", strtotime($outr1l1_res));
							// $outr1l1_time = new Carbon("2006-04-".$day." ".$outr1l1_time);
							$rowans1l1 = $inr1l1_time->diff($outr1l1_time);
							$ansl1_arr5[] = $rowans1l1->format('%h : %i');
							foreach ($ansl1_arr5 as $value) {
								list($t1, $t2) = explode(':', $value);
								$t1 = sprintf("%02d", $t1);
								$t2 = sprintf("%02d", $t2);
							}
							$ansl1_arr[] = $t1 . ":" . $t2;
							$b = $ansl1_arr;
						}
					} else {
						return false;
					}
				}
				if ($lunch == "3") {
					if ($selection3 == "1") {
						for ($i = 0; $i < $selection1; $i++) {
							$hourl1 = $inhourl1[$i];
							$hour1l1 = $outhourl1[$i];
							if (empty($hourl1) || empty($hour1l1)) {
								$checkHourl = false;
							} else {
								$day = 14;
								if ($inampm[$i] == $outampm[$i]) {
									$day = 15;
								}
								$hourl1 = $inhourl1[$i];
								$minl1 = $inminl1[$i];
								$ampml1 = $inampml1[$i];
								if ($hourl1 <= 9) {
									$hourl1 = sprintf("%02d", $hourl1);
								}
								if ($minl1 <= 9) {
									$minl1 = sprintf("%02d", $minl1);
								}
								$inr1l1_res = $hourl1 . ":" . $minl1 . " " . $ampml1;
								$inr1l1_time = date("H:i:s", strtotime($inr1l1_res));
								$inr1l1_time = new Carbon("2006-04-14 " . $inr1l1_time);
								$hourl1 = $outhourl1[$i];
								$minl1 = $outminl1[$i];
								$ampml1 = $outampml1[$i];
								if ($hourl1 <= 9) {
									$hourl1 = sprintf("%02d", $hourl1);
								}
								if ($minl1 <= 9) {
									$minl1 = sprintf("%02d", $minl1);
								}
								$outr1l1_res = $hourl1 . ":" . $minl1 . " " . $ampml1;
								$outr1l1_time = date("H:i:s", strtotime($outr1l1_res));
								$outr1l1_time = new Carbon("2006-04-" . $day . " " . $outr1l1_time);
							}
						}
						for ($i = 0; $i < $selection1; $i++) {
							$hourl2 = $inhourl2[$i];
							$hour1l2 = $outhourl2[$i];
							if (empty($hourl2) || empty($hour1l2)) {
								$checkHourl2 = false;
							} else {
								$day = 14;
								if ($inampm[$i] == $outampm[$i]) {
									$day = 15;
								}
								$hourl2 = $inhourl2[$i];
								$minl2 = $inminl2[$i];
								$ampml2 = $inampml2[$i];
								if ($hourl2 <= 9) {
									$hourl2 = sprintf("%02d", $hourl2);
								}
								if ($minl2 <= 9) {
									$minl2 = sprintf("%02d", $minl2);
								}
								$inr1l2_res = $hourl2 . ":" . $minl2 . " " . $ampml2;
								$inr1l2_time = date("H:i:s", strtotime($inr1l2_res));
								$inr1l2_time = new Carbon("2006-04-14 " . $inr1l2_time);
								$hourl2 = $outhourl2[$i];
								$minl2 = $outminl2[$i];
								$ampml2 = $outampml2[$i];
								if ($hourl2 <= 9) {
									$hourl2 = sprintf("%02d", $hourl2);
								}
								if ($minl2 <= 9) {
									$minl2 = sprintf("%02d", $minl2);
								}
								$outr1l2_res = $hourl2 . ":" . $minl2 . " " . $ampml2;
								$outr1l2_time = date("H:i:s", strtotime($outr1l2_res));
								$outr1l2_time = new Carbon("2006-04-" . $day . " " . $outr1l2_time);
							}
						}
					} else if ($selection3 == "2") {
						for ($i = 0; $i < $selection1; $i++) {
							$hourl1 = $inlunch1[$i];
							$hour1l1 = $outlunch1[$i];
							if (empty($hourl1) || empty($hour1l1)) {
								$checkHourl = false;
							} else {
								$xy1 = substr($hourl1, 2);
								$xy2 = substr($hour1l1, 2);
								if ($xy1 < 59 && $xy2 < 59) {
									$day = 14;
									if ($hour1l1 < $hourl1) {
										$day = 15;
									}
									$inr1l1_time = date("H:i:s", strtotime($hourl1));
									$inr1l1_time = new Carbon("2006-04-14 " . $inr1l1_time);
									$outr1l1_time = date("H:i:s", strtotime($hour1l1));
									$outr1l1_time = new Carbon("2006-04-" . $day . " " . $outr1l1_time);
								} else {
									return false;
								}
							}
						}
						for ($i = 0; $i < $selection1; $i++) {
							$hourl2 = $inlunch2[$i];
							$hour1l2 = $outlunch2[$i];
							if (empty($hourl2) || empty($hour1l2)) {
								$checkHourl2 = false;
							} else {
								$x1y1 = substr($hourl2, 2);
								$x2y2 = substr($hour1l2, 2);
								if ($x1y1 < 59 && $x2y2 < 59) {
									$day = 14;
									if ($hour1l2 < $hourl2) {
										$day = 15;
									}
									$inr1l2_time = date("H:i:s", strtotime($hourl2));
									$inr1l2_time = new Carbon("2006-04-14 " . $inr1l2_time);
									$outr1l2_time = date("H:i:s", strtotime($hour1l2));
									$outr1l2_time = new Carbon("2006-04-" . $day . " " . $outr1l2_time);
								} else {
									return false;
								}
							}
						}
					}
					// for ($i=0; $i < $selection1 ; $i++) {
					// 	$hourl1=$inhourl1[$i];
					// 	$hour1l1=$outhourl1[$i];
					// 	if (empty($hourl1) || empty($hour1l1)) {
					// 		$checkHourl=false;
					// 	}
					// }
					if ($checkHourl == true) {
						$ansl1_arr = [];
						for ($i = 0; $i < $selection1; $i++) {
							// $day=14;
							// if ($inampm[$i]==$outampm[$i]) {
							// 	$day=15;
							// }
							// $hourl1=$inhourl1[$i];
							// $minl1=$inminl1[$i];
							// $ampml1=$inampml1[$i];
							// if ($hourl1<=9) {
							// 	$hourl1=sprintf("%02d", $hourl1);
							// }
							// if ($minl1<=9) {
							// 	$minl1=sprintf("%02d", $minl1);
							// }
							// $inr1l1_res=$hourl1.":".$minl1." ".$ampml1;
							// $inr1l1_time = date("H:i:s", strtotime($inr1l1_res));
							// $inr1l1_time = new Carbon("2006-04-14 ".$inr1l1_time);
							// $hourl1=$outhourl1[$i];
							// $minl1=$outminl1[$i];
							// $ampml1=$outampml1[$i];
							// if ($hourl1<=9) {
							// 	$hourl1=sprintf("%02d", $hourl1);
							// }
							// if ($minl1<=9) {
							// 	$minl1=sprintf("%02d", $minl1);
							// }
							// $outr1l1_res=$hourl1.":".$minl1." ".$ampml1;
							// $outr1l1_time = date("H:i:s", strtotime($outr1l1_res));
							// $outr1l1_time = new Carbon("2006-04-".$day." ".$outr1l1_time);
							$rowans1l1 = $inr1l1_time->diff($outr1l1_time);
							$ansl21_arr5[] = $rowans1l1->format('%h : %i');
							foreach ($ansl21_arr5 as $value) {
								list($t1, $t2) = explode(':', $value);
								$t1 = sprintf("%02d", $t1);
								$t2 = sprintf("%02d", $t2);
							}
							$ansl21_arr[] = $t1 . ":" . $t2;
							$c = $ansl21_arr;
						}
					} else {
						return false;
					}
					// for ($i=0; $i < $selection1 ; $i++) {
					// 	$hourl2=$inhourl2[$i];
					// 	$hour1l2=$outhourl2[$i];
					// 	if (empty($hourl2) || empty($hour1l2)) {
					// 		$checkHourl2=false;
					// 	}
					// }
					if ($checkHourl2 == true) {
						$ansl1_arr = [];
						for ($i = 0; $i < $selection1; $i++) {
							// $day=14;
							// if ($inampm[$i]==$outampm[$i]) {
							// 	$day=15;
							// } 
							// $hourl2=$inhourl2[$i];
							// $minl2=$inminl2[$i];
							// $ampml2=$inampml2[$i];
							// if ($hourl2<=9) {
							// 	$hourl2=sprintf("%02d", $hourl2);
							// }
							// if ($minl2<=9) {
							// 	$minl2=sprintf("%02d", $minl2);
							// }
							// $inr1l2_res=$hourl2.":".$minl2." ".$ampml2;
							// $inr1l2_time = date("H:i:s", strtotime($inr1l2_res));
							// $inr1l2_time = new Carbon("2006-04-14 ".$inr1l2_time);
							// $hourl2=$outhourl2[$i];
							// $minl2=$outminl2[$i];
							// $ampml2=$outampml2[$i];
							// if ($hourl2<=9) {
							// 	$hourl2=sprintf("%02d", $hourl2);
							// }
							// if ($minl2<=9) {
							// 	$minl2=sprintf("%02d", $minl2);
							// }
							// $outr1l2_res=$hourl2.":".$minl2." ".$ampml2;
							// $outr1l2_time = date("H:i:s", strtotime($outr1l2_res));
							// $outr1l2_time = new Carbon("2006-04-".$day." ".$outr1l2_time);
							$rowans1l2 = $inr1l2_time->diff($outr1l2_time);
							$ansl2_arr5[] = $rowans1l2->format('%h : %i');
							foreach ($ansl2_arr5 as $value) {
								list($t1, $t2) = explode(':', $value);
								$t1 = sprintf("%02d", $t1);
								$t2 = sprintf("%02d", $t2);
							}
							$ansl2_arr[] = $t1 . ":" . $t2;
							$d = $ansl2_arr;
						}
					} else {
						return false;
					}
				}
			} else {
				return false;
			}
			if ($lunch == "1") {
				if ($advancedcheck == true) {
					if (!empty($paid_lunch1) && !empty($paid_lunch2)) {
						$min1 = "00" . ":" . $paid_lunch1;
						$min2 = "00" . ":" . $paid_lunch2;
						function calculate_total_time2()
						{
							$i = 0;
							foreach (func_get_args() as $time) {
								sscanf($time, '%d:%d', $hour, $min);
								$i += $hour * 60 + $min;
							}
							if ($h = floor($i / 60)) {
								$i %= 60;
							}
							return sprintf('%02d:%02d', $h, $i);
						}
						$paid_lunch = calculate_total_time2($min1, $min2);
						foreach ($ans_arr as $key => $val) {
							list($h, $m) = explode(':', $val);
							if ($h <= 9) {
								$h = sprintf("%02d", $h);
							}
							if ($m <= 9) {
								$m = sprintf("%02d", $m);
							}
							$answer1 = trim($h) . ":" . trim($m) . ":" . "00";
							$secs = strtotime($paid_lunch) - strtotime("00:00:00");
							$resultt2[] = date("H:i", strtotime($answer1) - $secs);
						}
						$overall_time = $resultt2;
					} else if (!empty($paid_lunch1)) {
						$paid_lunch = "00" . ":" . $paid_lunch1;
						foreach ($ans_arr as $key => $val) {
							list($h, $m) = explode(':', $val);
							if ($h <= 9) {
								$h = sprintf("%02d", $h);
							}
							if ($m <= 9) {
								$m = sprintf("%02d", $m);
							}
							$answer1 = trim($h) . ":" . trim($m) . ":" . "00";
							$secs = strtotime($paid_lunch) - strtotime("00:00:00");
							$result2[] = date("H:i", strtotime($answer1) - $secs);
						}
						$overall_time = $result2;
					} else if (!empty($paid_lunch2)) {
						$paid_lunch = "00" . ":" . $paid_lunch2;
						foreach ($ans_arr as $key => $val) {
							list($h, $m) = explode(':', $val);
							if ($h <= 9) {
								$h = sprintf("%02d", $h);
							}
							if ($m <= 9) {
								$m = sprintf("%02d", $m);
							}
							$answer1 = trim($h) . ":" . trim($m) . ":" . "00";
							$secs = strtotime($paid_lunch) - strtotime("00:00:00");
							$result3[] = date("H:i", strtotime($answer1) - $secs);
						}
						$overall_time = $result3;
					}
				} else {
					$overall_time = $ans_arr;
				}
			}
			if ($lunch == "2") {
				foreach ($a as $key => $val1) {
					$val2 = $b[$key];
					list($hl1, $ml1) = explode(':', $val1);
					if ($hl1 <= 9) {
						$hl1 = sprintf("%02d", $hl1);
					}
					if ($ml1 <= 9) {
						$ml1 = sprintf("%02d", $ml1);
					}
					$val11 = trim($hl1) . ":" . trim($ml1) . ":" . "00";
					list($hl12, $ml12) = explode(':', $val2);
					if ($hl12 <= 9) {
						$hl12 = sprintf("%02d", $hl12);
					}
					if ($ml12 <= 9) {
						$ml12 = sprintf("%02d", $ml12);
					}
					$val12 = trim($hl12) . ":" . trim($ml12) . ":" . "00";
					$secs = strtotime($val12) - strtotime("00:00:00");
					$result20[] = date("H:i", strtotime($val11) + $secs);
					$overall_time = $result20;
				}
				if (!empty($paid_lunch1)) {
					$paid_lunch = "00" . ":" . $paid_lunch1;
					foreach ($result20 as $key => $val) {
						list($h, $m) = explode(':', $val);
						if ($h <= 9) {
							$h = sprintf("%02d", $h);
						}
						if ($m <= 9) {
							$m = sprintf("%02d", $m);
						}
						$answer1 = $h . ":" . $m . ":" . "00";
						$secs = strtotime($paid_lunch) - strtotime("00:00:00");
						$result21[] = date("H:i", strtotime($answer1) + $secs);
						$overall_time = $result21;
					}
				}
			}
			if ($lunch == "3") {
				foreach ($a as $key => $val1) {
					$val2 = $c[$key];
					$val3 = $d[$key];
					list($hl1, $ml1) = explode(':', $val1);
					if ($hl1 <= 9) {
						$hl1 = sprintf("%02d", $hl1);
					}
					if ($ml1 <= 9) {
						$ml1 = sprintf("%02d", $ml1);
					}
					$val11 = trim($hl1) . ":" . trim($ml1) . ":" . "00";
					list($hl12, $ml12) = explode(':', $val2);
					if ($hl12 <= 9) {
						$hl12 = sprintf("%02d", $hl12);
					}
					if ($ml12 <= 9) {
						$ml12 = sprintf("%02d", $ml12);
					}
					$val12 = trim($hl12) . ":" . trim($ml12) . ":" . "00";
					list($hl13, $ml13) = explode(":", $val3);
					if ($hl13 <= 9) {
						$hl13 = sprintf("%02d", $hl13);
					}
					if ($ml13 <= 9) {
						$ml13 = sprintf("%02d", $ml13);
					}
					$val13 = trim($hl13) . ":" . trim($ml13) . ":" . "00";
					$secs = strtotime($val12) - strtotime("00:00:00");
					$secs2 = strtotime($val13) - strtotime("00:00:00");
					$result30[] = date("H:i", strtotime($val11) + $secs + $secs2);
					$overall_time = $result30;
				}
				if (!empty($paid_lunch2)) {
					$paid_lunch = "00" . ":" . $paid_lunch2;
					foreach ($result30 as $key => $val) {
						list($h, $m) = explode(':', $val);
						if ($h <= 9) {
							$h = sprintf("%02d", $h);
						}
						if ($m <= 9) {
							$m = sprintf("%02d", $m);
						}
						$answer1 = $h . ":" . $m . ":" . "00";
						$secs = strtotime($paid_lunch) - strtotime("00:00:00");
						$result31[] = date("H:i", strtotime($answer1) + $secs);
						$overall_time = $result31;
					}
				}
			}
			function AddPlayTime2($overall_time)
			{
				$minutes = 0;
				foreach ($overall_time as $value) {
					list($hour, $minute) = explode(':', $value);
					$minutes += trim($hour) * 60;
					$minutes += trim($minute);
				}
				$hours = floor($minutes / 60);
				$minutes -= $hours * 60;
				return sprintf('%02d:%02d', $hours, $minutes);
			}
			$table_ans = AddPlayTime2($overall_time);
			$overtime3_first = $table_ans;
			if ($overtime == "0") {
				if (!empty($hour_rate)) {
					foreach ($overall_time as $key => $val) {
						$a1 = explode(":", $val);
						$a1_ans[] = $a1[0] . ":" . "00";
						$pay[] = trim($a1[0]) * $hour_rate;
						$pay2[] = $a1[1] / 60 * $hour_rate;
						$pay2_ans[] = "00" . ":" . $a1[1];
						$pay_sum = array_merge($pay, $pay2);
						$paysum = array_sum($pay_sum);
						$overtime3_first = $table_ans;
						$overtime6_first = $paysum;
					}
				}
				$overtime3_first = $table_ans;
			}
			if ($overtime == "1") {
				foreach ($overall_time as $key => $val) {
					list($overtime_h1, $overtime_m1) = explode(":", $val);
					if ($overtime_h1 >= 8) {
						$hour_res = trim($overtime_h1) - 8;
						$overtime_work1[] = $hour_res . ":" . $overtime_m1;
					} else {
						$overtime3_first = $table_ans;
					}
				}
				function calculate_overtime_one2($overtime_work1)
				{
					$minutes = 0;
					if ($overtime_work1 != "") {
						foreach ($overtime_work1 as $value) {
							list($hour, $minute) = explode(':', $value);
							$minutes += trim($hour) * 60;
							$minutes += trim($minute);
						}
					}
					$hours = floor($minutes / 60);
					$minutes -= $hours * 60;
					return sprintf('%02d:%02d', $hours, $minutes);
				}
				$Ans1 = calculate_overtime_one2($overtime_work1);
				list($Ans1_h, $Ans1_m) = explode(':', $Ans1);
				if ($Ans1_h <= 9) {
					$Ans1_h = sprintf("%02d", $Ans1_h);
				}
				if ($Ans1_m <= 9) {
					$Ans1_m = sprintf("%02d", $Ans1_m);
				}
				$Ans11 = trim($Ans1_h) . ":" . trim($Ans1_m) . ":" . "00";
				list($tableans_h, $tableans_m) = explode(':', $table_ans);
				if ($tableans_h <= 9) {
					$tableans_h = sprintf("%02d", $tableans_h);
				}
				if ($tableans_m <= 9) {
					$tableans_m = sprintf("%02d", $tableans_m);
				}
				if ($selection1 == "1") {
					$duty_time = 1 * 8;
				} else if ($selection1 == "2") {
					$duty_time = 2 * 8;
				} else if ($selection1 == "3") {
					$duty_time = 3 * 8;
				} else if ($selection1 == "4") {
					$duty_time = 4 * 8;
				} else if ($selection1 == "5") {
					$duty_time = 5 * 8;
				} else if ($selection1 == "6") {
					$duty_time = 6 * 8;
				} else if ($selection1 == "7") {
					$duty_time = 7 * 8;
				}
				$regular_time = $duty_time . ":" . "00";
				if (!empty($hour_rate)) {
					if (!empty($overtime_work1)) {
					}
					$pay_h = trim($duty_time) * $hour_rate;
					$pay_dutytime = $pay_h;
				}
				if (!empty($overtime_pay)) {
					list($overtimepay_h, $overtimepay_m) = explode(":", $Ans1);
					if (!empty($hour_rate)) {
						$overpay_h = trim($overtimepay_h) * trim($hour_rate) * trim($overtime_pay);
						$overpay_m = ($overtimepay_m / 60) * trim($hour_rate) * trim($overtime_pay);
						$overwork_pay = $overpay_h + $overpay_m;
					}
				}
				if (!empty($hour_rate) && !empty($overtime_pay)) {
					$total_pay = $overwork_pay + $pay_dutytime;
				}
				$overtime2_first = $Ans1;
				$overtime3_first = $table_ans;
				if (!empty($hour_rate)) {
					$overtime4_first = $pay_dutytime;
				}
				if (!empty($overwork_pay)) {
					$overtime5_first = $overwork_pay;
				}
				if (!empty($hour_rate) && !empty($overtime_pay)) {
					$overtime6_first = $total_pay;
				}
			}
			if ($overtime == "2") {
				list($tableans_h, $tableans_m) = explode(":", $table_ans);
				if ($tableans_h >= 40) {
					$hour_res = trim($tableans_h) - 40;
					$overtime_work1 = $hour_res . ":" . $tableans_m;
					$overtime2_first = $overtime_work1;
				} else {
					$overtime3_first = $table_ans;
					$overtime2_first = "00";
				}
				if ($overtime_work1 != "") {
					list($Ans1_h, $Ans1_m) = explode(':', $overtime_work1);
					if ($Ans1_h <= 9) {
						$Ans1_h = sprintf("%02d", $Ans1_h);
					}
					if ($Ans1_m <= 9) {
						$Ans1_m = sprintf("%02d", $Ans1_m);
					}
					$Ans111 = trim($Ans1_h) . ":" . trim($Ans1_m);
				}
				list($tableans_h, $tableans_m) = explode(':', $table_ans);
				if ($tableans_h <= 9) {
					$tableans_h = sprintf("%02d", $tableans_h);
				}
				if ($tableans_m <= 9) {
					$tableans_m = sprintf("%02d", $tableans_m);
				}
				$tableans1 = trim($tableans_h) . ":" . trim($tableans_m) . ":" . "00";
				if ($overtime_work1 != "") {
					$duty_timet2 = 40;
					$regular_time = $duty_timet2 . ":" . "00";
				}
				if (!empty($hour_rate)) {
					if (!empty($duty_timet2)) {
						$pay_h = trim($duty_timet2) * $hour_rate;
						$pay_dutytimet1 = $pay_h;
					}
					if (empty($overtime_work1)) {
						$regular_time = $table_ans;
						list($tableans_h, $tableans_m) = explode(':', $table_ans);
						$pay_h = trim($tableans_h) * $hour_rate;
						$pay_dutytimet1 = $pay_h;
					}
					$overtime4_first = $pay_dutytimet1;
				}
				if (!empty($overtime_pay)) {
					if ($overtime_work1 != "") {
						list($overtimepay_h, $overtimepay_m) = explode(":", $overtime_work1);
					}
					if ($hour_rate != "" && $overtime_pay != "") {
						if (!empty($overtimepay_h)) {
							$overpay_h = trim($overtimepay_h) * $hour_rate * $overtime_pay;
							$overpay_m = ($overtimepay_m / 60) * $hour_rate * $overtime_pay;
							$overwork_payt1 = $overpay_h + $overpay_m;
							$overtime5_first = $overwork_payt1;
						}
					}
				}
				if (!empty($hour_rate) && !empty($overtime_pay) && !empty($pay_dutytimet1)) {
					if (!empty($overwork_payt1)) {
						$total_pay = $pay_dutytimet1 + $overwork_payt1;
						$overtime6_first = $total_pay;
					}
				}
				$overtime3_first = $table_ans;
			}
			if (!empty($sick_h) || !empty($sick_m)) {
				if ($sick_h <= 9) {
					$sick_h = sprintf("%02d", $sick_h);
				}
				if ($sick_m <= 9) {
					$sick_m = sprintf("%02d", $sick_m);
				}
				list($h, $m) = explode(":", $table_ans);
				$total_m = $sick_m + $m;
				$total_h = $sick_h + $h;
				$t_pay = $total_h . ":" . $total_m;
				$answer1 = trim($sick_h) . ":" . trim($sick_m);
				if (!empty($hour_rate)) {
					if (!empty($answer1)) {
						list($s_h, $s_m) = explode(":", $answer1);
						$sickpay_h = trim($s_h) * $hour_rate;
						$sickpay_m = ($s_m / 60) * $hour_rate;
						$s_pay = $sickpay_h + $sickpay_m;
					}
					$sick_pay = $s_pay;
					list($sick_hour, $sick_min) = explode(":", $t_pay);
					$pay_h = trim($sick_hour) * $hour_rate;
					$pay_m = ($sick_min / 60) * $hour_rate;
					$sickpay = $pay_h + $pay_m;
					$overtime6_first = $sickpay;
				}
				$sick_time = trim($sick_h) . ":" . trim($sick_m);
				$overtime3_first = $t_pay;
				if ($hour_rate != "") {
					$sick_pay = $s_pay;
					$overtime6_first = $sickpay;
				}
			}
			if (!empty($v_h) || !empty($v_m)) {
				if ($v_h <= 9) {
					$v_h = sprintf("%02d", $v_h);
				}
				if ($v_m <= 9) {
					$v_m = sprintf("%02d", $v_m);
				}
				$answer1 = trim($v_h) . ":" . trim($v_m);
				$secs = strtotime($answer1) - strtotime("00:00:00");
				if (!empty($sick_h) || !empty($sick_m)) {
					if ($sick_h <= 9) {
						$sick_h = sprintf("%02d", $sick_h);
					}
					if ($sick_m <= 9) {
						$sick_m = sprintf("%02d", $sick_m);
					}
					$answer2 = trim($sick_h) . ":" . trim($sick_m);
					$v_hours = date("H:i", strtotime($answer2) + $secs);
					list($hours, $minutes) = explode(":", $v_hours);
					list($h, $m) = explode(":", $table_ans);
					$total_m = $minutes + $m;
					$total_h = $hours + $h;
					$total_sick = $total_h . ":" . $total_m;
					$overtime3_first = $total_sick;
				} else {
					$v_hours = date("H:i", strtotime($table_ans) + $secs);
					$overtime3_first = $v_hours;
				}
				if (!empty($hour_rate)) {
					list($vacation_h, $vacation_m) = explode(":", $answer1);
					$sickpay_h = trim($vacation_h) * $hour_rate;
					$sickpay_m = ($vacation_m / 60) * $hour_rate;
					$v_pay = $sickpay_h + $sickpay_m;
					list($v_hour, $v_min) = explode(":", $total_sick);
					$pay_h = trim($v_hour) * $hour_rate;
					$pay_m = ($v_min / 60) * $hour_rate;
					$sickpay = $pay_h + $pay_m;
				}
				$v_time = trim($v_h) . ":" . trim($v_m);
				if ($hour_rate != "") {
					$vacation_pay = $v_pay;
					$overtime6_first = $sickpay;
				}
			}
			return array($ans_arr, $ansl1_arr, $ansl21_arr, $ansl2_arr, $overall_time, $regular_time, $overtime2_first, $overtime3_first, $sick_pay, $sick_time, $vacation_pay, $v_time, $overtime4_first, $overtime5_first, $overtime6_first);
		}
		function timeCal3($selection3 = null, $selection1 = null, $inhour = null, $inmin = null, $inampm = null, $outhour = null, $outmin = null, $outampm = null, $in = null, $out = null, $inhourl1 = null, $inminl1 = null, $inampml1 = " ", $outhourl1 = null, $outminl1 = null, $outampml1 = null, $inlunch1 = null, $outlunch1 = null, $inhourl2 = null, $inminl2 = null, $inampml2 = null, $outhourl2 = null, $outminl2 = null, $outampml2 = null, $inlunch2 = null, $outlunch2 = null, $sick_h = null, $sick_m = null, $v_h = null, $v_m = null, $advancedcheck = null, $lunch = null, $paid_lunch1 = null, $paid_lunch2 = null, $hour_rate = null, $overtime = null, $overtime_pay = null)
		{
			$checkHour = true;
			$checkHourl = true;
			$checkHourl2 = true;
			$regular_time = false;
			$overtime2_first = false;
			$overtime3_first = false;
			$overtime4_first = false;
			$overtime5_first = false;
			$overtime6_first = false;
			$a = $b = $c = $d = $sick_pay = $sick_time = $total_pay = $vacation_pay = $v_time = $ans_arrt2 = $ansl1_arrt2 = $ansl21_arrt2 = $ansl2_arrt2 = $overall_timet2 = $regular_timet2 = $overtime2_firstt2 = $overtime3_firstt2 = $sick_payt2 = $t2sick_timet2 = $total_payt2 = $vacation_payt2 = $v_timet2 = $overtime4_firstt2 = $overtime5_firstt2 = $overtime6_firstt2 = $s_pay = $sickpay = $days = $dayst2 = $overtime_work1 = $ans_arrt3 = $ansl1_arrt3 = $ansl21_arrt3 = $ansl2_arrt3 = $overall_timet3 = $regular_timet3 = $overtime2_firstt3 = $overtime3_firstt3 = $sick_payt3 = $t3sick_timet3 = $total_payt3 = $vacation_payt3 = $v_timet3 = $overtime4_firstt3 = $overtime5_firstt3 = $overtime6_firstt3 = $s_pay = $sickpay = $days = $dayst3 = $ans_arrt4 = $ansl1_arrt4 = $ansl21_arrt4 = $ansl2_arrt4 = $overall_timet4 = $regular_timet4 = $overtime2_firstt4 = $overtime3_firstt4 = $sick_payt4 = $t4sick_timet4 = $total_payt4 = $vacation_payt4 = $v_timet4 = $overtime4_firstt4 = $overtime5_firstt4 = $overtime6_firstt4 = $s_pay = $sickpay = $days = $dayst4 = false;
			$ans_arr = [];
			$ansl1_arr = [];
			$ansl2_arr = [];
			$ansl21_arr = [];
			$checkHour = true;
			if ($selection3 == "1") {
				for ($i = 0; $i < $selection1; $i++) {
					$hour = $inhour[$i];
					$hour1 = $outhour[$i];
					if (empty($hour) || empty($hour1)) {
						$checkHour = false;
					} else {
						$day = 14;
						if ($inampm[$i] == $outampm[$i]) {
							$day = 15;
						}
						$hour = $inhour[$i];
						$min = $inmin[$i];
						$ampm = $inampm[$i];
						if ($hour <= 9) {
							$hour = sprintf("%02d", $hour);
						}
						if ($min <= 9) {
							$min = sprintf("%02d", $min);
						}
						$inr1_res = $hour . ":" . $min . " " . $ampm;
						$inr1_time = date("H:i:s", strtotime($inr1_res));
						$inr1_time = new Carbon("2006-04-14 " . $inr1_time);
						$hour = $outhour[$i];
						$min = $outmin[$i];
						$ampm = $outampm[$i];
						if ($hour <= 9) {
							$hour = sprintf("%02d", $hour);
						}
						if ($min <= 9) {
							$min = sprintf("%02d", $min);
						}
						$outr1_res = $hour . ":" . $min . " " . $ampm;
						$outr1_time = date("H:i:s", strtotime($outr1_res));
						$outr1_time = new Carbon("2006-04-" . $day . " " . $outr1_time);
					}
				}
			} else if ($selection3 == "2") {
				for ($i = 0; $i < $selection1; $i++) {
					$hour = $in[$i];
					$hour1 = $out[$i];
					if (empty($hour) || empty($hour1)) {
						$checkHour = false;
					} else {
						$ab1 = substr($hour, 2);
						$ab2 = substr($hour1, 2);
						if ($ab1 < 59 && $ab2 < 59) {
							$day = 14;
							if ($hour1 < $hour) {
								$day = 15;
							}
							$inr1_time = date("H:i:s", strtotime($hour));
							$inr1_time = new Carbon("2006-04-14 " . $inr1_time);
							$outr1_time = date("H:i:s", strtotime($hour1));
							$outr1_time = new Carbon("2006-04-" . $day . " " . $outr1_time);
						} else {
							return false;
						}
					}
				}
			}
			if ($checkHour == true) {
				for ($i = 0; $i < $selection1; $i++) {
					// $day=14;
					// if ($inampm[$i]==$outampm[$i]) {
					// 	$day=15;
					// }
					// $hour=$inhour[$i];
					// $min=$inmin[$i];
					// $ampm=$inampm[$i];
					// if ($hour<=9) {
					// 	$hour=sprintf("%02d", $hour);
					// }
					// if ($min<=9) {
					// 	$min=sprintf("%02d", $min);
					// }
					// $inr1_res=$hour.":".$min." ".$ampm;
					// $inr1_time = date("H:i:s", strtotime($inr1_res));
					// $inr1_time = new Carbon("2006-04-14 ".$inr1_time);
					// $hour=$outhour[$i];
					// $min=$outmin[$i];
					// $ampm=$outampm[$i];
					// if ($hour<=9) {
					// 	$hour=sprintf("%02d", $hour);
					// }
					// if ($min<=9) {
					// 	$min=sprintf("%02d", $min);
					// }
					// $outr1_res=$hour.":".$min." ".$ampm;
					// $outr1_time = date("H:i:s", strtotime($outr1_res));
					// $outr1_time = new Carbon("2006-04-".$day." ".$outr1_time);
					$rowans1 = $inr1_time->diff($outr1_time);
					$ans_arr5[] = $rowans1->format('%h : %i');
					foreach ($ans_arr5 as $value) {
						list($t1, $t2) = explode(':', $value);
						$t1 = sprintf("%02d", $t1);
						$t2 = sprintf("%02d", $t2);
					}
					$ans_arr[] = $t1 . ":" . $t2;
					$a = $ans_arr;
				}
				if ($lunch == "2") {
					if ($selection3 == "1") {
						for ($i = 0; $i < $selection1; $i++) {
							$hourl1 = $inhourl1[$i];
							$hour1l1 = $outhourl1[$i];
							if (empty($hourl1) || empty($hour1l1)) {
								$checkHourl = false;
							} else {
								$day = 14;
								if ($inampm[$i] == $outampm[$i]) {
									$day = 15;
								}
								$hourl1 = $inhourl1[$i];
								$minl1 = $inminl1[$i];
								$ampml1 = $inampml1[$i];
								if ($hourl1 <= 9) {
									$hourl1 = sprintf("%02d", $hourl1);
								}
								if ($minl1 <= 9) {
									$minl1 = sprintf("%02d", $minl1);
								}
								$inr1l1_res = $hourl1 . ":" . $minl1 . " " . $ampml1;
								$inr1l1_time = date("H:i:s", strtotime($inr1l1_res));
								$inr1l1_time = new Carbon("2006-04-14 " . $inr1l1_time);
								$hourl1 = $outhourl1[$i];
								$minl1 = $outminl1[$i];
								$ampml1 = $outampml1[$i];
								if ($hourl1 <= 9) {
									$hourl1 = sprintf("%02d", $hourl1);
								}
								if ($minl1 <= 9) {
									$minl1 = sprintf("%02d", $minl1);
								}
								$outr1l1_res = $hourl1 . ":" . $minl1 . " " . $ampml1;
								$outr1l1_time = date("H:i:s", strtotime($outr1l1_res));
								$outr1l1_time = new Carbon("2006-04-" . $day . " " . $outr1l1_time);
							}
						}
					} else if ($selection3 == "2") {
						for ($i = 0; $i < $selection1; $i++) {
							$hourl1 = $inlunch1[$i];
							$hour1l1 = $outlunch1[$i];
							if (empty($hourl1) || empty($hour1l1)) {
								$checkHourl = false;
							} else {
								$xy1 = substr($hourl1, 2);
								$xy2 = substr($hour1l1, 2);
								if ($xy1 < 59 && $xy2 < 59) {
									$day = 14;
									if ($hour1l1 < $hourl1) {
										$day = 15;
									}
									$inr1l1_time = date("H:i:s", strtotime($hourl1));
									$inr1l1_time = new Carbon("2006-04-14 " . $inr1l1_time);
									$outr1l1_time = date("H:i:s", strtotime($hour1l1));
									$outr1l1_time = new Carbon("2006-04-" . $day . " " . $outr1l1_time);
								} else {
									return false;
								}
							}
						}
					}
					if ($checkHourl == true) {
						$ansl1_arr = [];
						for ($i = 0; $i < $selection1; $i++) {
							// $day=14;
							// if ($inampm[$i]==$outampm[$i]) {
							// 	$day=15;
							// }
							// $hourl1=$inhourl1[$i];
							// $minl1=$inminl1[$i];
							// $ampml1=$inampml1[$i];
							// if ($hourl1<=9) {
							// 	$hourl1=sprintf("%02d", $hourl1);
							// }
							// if ($minl1<=9) {
							// 	$minl1=sprintf("%02d", $minl1);
							// }
							// $inr1l1_res=$hourl1.":".$minl1." ".$ampml1;
							// $inr1l1_time = date("H:i:s", strtotime($inr1l1_res));
							// $inr1l1_time = new Carbon("2006-04-14 ".$inr1l1_time);
							// $hourl1=$outhourl1[$i];
							// $minl1=$outminl1[$i];
							// $ampml1=$outampml1[$i];
							// if ($hourl1<=9) {
							// 	$hourl1=sprintf("%02d", $hourl1);
							// }
							// if ($minl1<=9) {
							// 	$minl1=sprintf("%02d", $minl1);
							// }
							// $outr1l1_res=$hourl1.":".$minl1." ".$ampml1;
							// $outr1l1_time = date("H:i:s", strtotime($outr1l1_res));
							// $outr1l1_time = new Carbon("2006-04-".$day." ".$outr1l1_time);
							$rowans1l1 = $inr1l1_time->diff($outr1l1_time);
							$ansl1_arr5[] = $rowans1l1->format('%h : %i');
							foreach ($ansl1_arr5 as $value) {
								list($t1, $t2) = explode(':', $value);
								$t1 = sprintf("%02d", $t1);
								$t2 = sprintf("%02d", $t2);
							}
							$ansl1_arr[] = $t1 . ":" . $t2;
							$b = $ansl1_arr;
						}
					} else {
						return false;
					}
				}
				if ($lunch == "3") {
					if ($selection3 == "1") {
						for ($i = 0; $i < $selection1; $i++) {
							$hourl1 = $inhourl1[$i];
							$hour1l1 = $outhourl1[$i];
							if (empty($hourl1) || empty($hour1l1)) {
								$checkHourl = false;
							} else {
								$day = 14;
								if ($inampm[$i] == $outampm[$i]) {
									$day = 15;
								}
								$hourl1 = $inhourl1[$i];
								$minl1 = $inminl1[$i];
								$ampml1 = $inampml1[$i];
								if ($hourl1 <= 9) {
									$hourl1 = sprintf("%02d", $hourl1);
								}
								if ($minl1 <= 9) {
									$minl1 = sprintf("%02d", $minl1);
								}
								$inr1l1_res = $hourl1 . ":" . $minl1 . " " . $ampml1;
								$inr1l1_time = date("H:i:s", strtotime($inr1l1_res));
								$inr1l1_time = new Carbon("2006-04-14 " . $inr1l1_time);
								$hourl1 = $outhourl1[$i];
								$minl1 = $outminl1[$i];
								$ampml1 = $outampml1[$i];
								if ($hourl1 <= 9) {
									$hourl1 = sprintf("%02d", $hourl1);
								}
								if ($minl1 <= 9) {
									$minl1 = sprintf("%02d", $minl1);
								}
								$outr1l1_res = $hourl1 . ":" . $minl1 . " " . $ampml1;
								$outr1l1_time = date("H:i:s", strtotime($outr1l1_res));
								$outr1l1_time = new Carbon("2006-04-" . $day . " " . $outr1l1_time);
							}
						}
						for ($i = 0; $i < $selection1; $i++) {
							$hourl2 = $inhourl2[$i];
							$hour1l2 = $outhourl2[$i];
							if (empty($hourl2) || empty($hour1l2)) {
								$checkHourl2 = false;
							} else {
								$day = 14;
								if ($inampm[$i] == $outampm[$i]) {
									$day = 15;
								}
								$hourl2 = $inhourl2[$i];
								$minl2 = $inminl2[$i];
								$ampml2 = $inampml2[$i];
								if ($hourl2 <= 9) {
									$hourl2 = sprintf("%02d", $hourl2);
								}
								if ($minl2 <= 9) {
									$minl2 = sprintf("%02d", $minl2);
								}
								$inr1l2_res = $hourl2 . ":" . $minl2 . " " . $ampml2;
								$inr1l2_time = date("H:i:s", strtotime($inr1l2_res));
								$inr1l2_time = new Carbon("2006-04-14 " . $inr1l2_time);
								$hourl2 = $outhourl2[$i];
								$minl2 = $outminl2[$i];
								$ampml2 = $outampml2[$i];
								if ($hourl2 <= 9) {
									$hourl2 = sprintf("%02d", $hourl2);
								}
								if ($minl2 <= 9) {
									$minl2 = sprintf("%02d", $minl2);
								}
								$outr1l2_res = $hourl2 . ":" . $minl2 . " " . $ampml2;
								$outr1l2_time = date("H:i:s", strtotime($outr1l2_res));
								$outr1l2_time = new Carbon("2006-04-" . $day . " " . $outr1l2_time);
							}
						}
					} else if ($selection3 == "2") {
						for ($i = 0; $i < $selection1; $i++) {
							$hourl1 = $inlunch1[$i];
							$hour1l1 = $outlunch1[$i];
							if (empty($hourl1) || empty($hour1l1)) {
								$checkHourl = false;
							} else {
								$xy1 = substr($hourl1, 2);
								$xy2 = substr($hour1l1, 2);
								if ($xy1 < 59 && $xy2 < 59) {
									$day = 14;
									if ($hour1l1 < $hourl1) {
										$day = 15;
									}
									$inr1l1_time = date("H:i:s", strtotime($hourl1));
									$inr1l1_time = new Carbon("2006-04-14 " . $inr1l1_time);
									$outr1l1_time = date("H:i:s", strtotime($hour1l1));
									$outr1l1_time = new Carbon("2006-04-" . $day . " " . $outr1l1_time);
								} else {
									return false;
								}
							}
						}
						for ($i = 0; $i < $selection1; $i++) {
							$hourl2 = $inlunch2[$i];
							$hour1l2 = $outlunch2[$i];
							if (empty($hourl2) || empty($hour1l2)) {
								$checkHourl2 = false;
							} else {
								$x1y1 = substr($hourl2, 2);
								$x2y2 = substr($hour1l2, 2);
								if ($x1y1 < 59 && $x2y2 < 59) {
									$day = 14;
									if ($hour1l2 < $hourl2) {
										$day = 15;
									}
									$inr1l2_time = date("H:i:s", strtotime($hourl2));
									$inr1l2_time = new Carbon("2006-04-14 " . $inr1l2_time);
									$outr1l2_time = date("H:i:s", strtotime($hour1l2));
									$outr1l2_time = new Carbon("2006-04-" . $day . " " . $outr1l2_time);
								} else {
									return false;
								}
							}
						}
					}













					// for ($i=0; $i < $selection1 ; $i++) {
					// 	$hourl1=$inhourl1[$i];
					// 	$hour1l1=$outhourl1[$i];
					// 	if (empty($hourl1) || empty($hour1l1)) {
					// 		$checkHourl=false;
					// 	}
					// }
					if ($checkHourl == true) {
						$ansl1_arr = [];
						for ($i = 0; $i < $selection1; $i++) {
							// $day=14;
							// if ($inampm[$i]==$outampm[$i]) {
							// 	$day=15;
							// }
							// $hourl1=$inhourl1[$i];
							// $minl1=$inminl1[$i];
							// $ampml1=$inampml1[$i];
							// if ($hourl1<=9) {
							// 	$hourl1=sprintf("%02d", $hourl1);
							// }
							// if ($minl1<=9) {
							// 	$minl1=sprintf("%02d", $minl1);
							// }
							// $inr1l1_res=$hourl1.":".$minl1." ".$ampml1;
							// $inr1l1_time = date("H:i:s", strtotime($inr1l1_res));
							// $inr1l1_time = new Carbon("2006-04-14 ".$inr1l1_time);
							// $hourl1=$outhourl1[$i];
							// $minl1=$outminl1[$i];
							// $ampml1=$outampml1[$i];
							// if ($hourl1<=9) {
							// 	$hourl1=sprintf("%02d", $hourl1);
							// }
							// if ($minl1<=9) {
							// 	$minl1=sprintf("%02d", $minl1);
							// }
							// $outr1l1_res=$hourl1.":".$minl1." ".$ampml1;
							// $outr1l1_time = date("H:i:s", strtotime($outr1l1_res));
							// $outr1l1_time = new Carbon("2006-04-".$day." ".$outr1l1_time);
							$rowans1l1 = $inr1l1_time->diff($outr1l1_time);
							$ansl21_arr5[] = $rowans1l1->format('%h : %i');
							foreach ($ansl21_arr5 as $value) {
								list($t1, $t2) = explode(':', $value);
								$t1 = sprintf("%02d", $t1);
								$t2 = sprintf("%02d", $t2);
							}
							$ansl21_arr[] = $t1 . ":" . $t2;
							$c = $ansl21_arr;
						}
					} else {
						return false;
					}
					// for ($i=0; $i < $selection1 ; $i++) {
					// 	$hourl2=$inhourl2[$i];
					// 	$hour1l2=$outhourl2[$i];
					// 	if (empty($hourl2) || empty($hour1l2)) {
					// 		$checkHourl2=false;
					// 	}
					// }
					if ($checkHourl2 == true) {
						$ansl1_arr = [];
						for ($i = 0; $i < $selection1; $i++) {
							// $day=14;
							// if ($inampm[$i]==$outampm[$i]) {
							// 	$day=15;
							// } 
							// $hourl2=$inhourl2[$i];
							// $minl2=$inminl2[$i];
							// $ampml2=$inampml2[$i];
							// if ($hourl2<=9) {
							// 	$hourl2=sprintf("%02d", $hourl2);
							// }
							// if ($minl2<=9) {
							// 	$minl2=sprintf("%02d", $minl2);
							// }
							// $inr1l2_res=$hourl2.":".$minl2." ".$ampml2;
							// $inr1l2_time = date("H:i:s", strtotime($inr1l2_res));
							// $inr1l2_time = new Carbon("2006-04-14 ".$inr1l2_time);
							// $hourl2=$outhourl2[$i];
							// $minl2=$outminl2[$i];
							// $ampml2=$outampml2[$i];
							// if ($hourl2<=9) {
							// 	$hourl2=sprintf("%02d", $hourl2);
							// }
							// if ($minl2<=9) {
							// 	$minl2=sprintf("%02d", $minl2);
							// }
							// $outr1l2_res=$hourl2.":".$minl2." ".$ampml2;
							// $outr1l2_time = date("H:i:s", strtotime($outr1l2_res));
							// $outr1l2_time = new Carbon("2006-04-".$day." ".$outr1l2_time);
							$rowans1l2 = $inr1l2_time->diff($outr1l2_time);
							$ansl2_arr5[] = $rowans1l2->format('%h : %i');
							foreach ($ansl2_arr5 as $value) {
								list($t1, $t2) = explode(':', $value);
								$t1 = sprintf("%02d", $t1);
								$t2 = sprintf("%02d", $t2);
							}
							$ansl2_arr[] = $t1 . ":" . $t2;
							$d = $ansl2_arr;
						}
					} else {
						return false;
					}
				}
			} else {
				return false;
			}
			if ($lunch == "1") {
				if ($advancedcheck == true) {
					if (!empty($paid_lunch1) && !empty($paid_lunch2)) {
						$min1 = "00" . ":" . $paid_lunch1;
						$min2 = "00" . ":" . $paid_lunch2;
						function calculate_total_time3()
						{
							$i = 0;
							foreach (func_get_args() as $time) {
								sscanf($time, '%d:%d', $hour, $min);
								$i += $hour * 60 + $min;
							}
							if ($h = floor($i / 60)) {
								$i %= 60;
							}
							return sprintf('%02d:%02d', $h, $i);
						}
						$paid_lunch = calculate_total_time3($min1, $min2);
						foreach ($ans_arr as $key => $val) {
							list($h, $m) = explode(':', $val);
							if ($h <= 9) {
								$h = sprintf("%02d", $h);
							}
							if ($m <= 9) {
								$m = sprintf("%02d", $m);
							}
							$answer1 = trim($h) . ":" . trim($m) . ":" . "00";
							$secs = strtotime($paid_lunch) - strtotime("00:00:00");
							$resultt2[] = date("H:i", strtotime($answer1) - $secs);
						}
						$overall_time = $resultt2;
					} else if (!empty($paid_lunch1)) {
						$paid_lunch = "00" . ":" . $paid_lunch1;
						foreach ($ans_arr as $key => $val) {
							list($h, $m) = explode(':', $val);
							if ($h <= 9) {
								$h = sprintf("%02d", $h);
							}
							if ($m <= 9) {
								$m = sprintf("%02d", $m);
							}
							$answer1 = trim($h) . ":" . trim($m) . ":" . "00";
							$secs = strtotime($paid_lunch) - strtotime("00:00:00");
							$result2[] = date("H:i", strtotime($answer1) - $secs);
						}
						$overall_time = $result2;
					} else if (!empty($paid_lunch2)) {
						$paid_lunch = "00" . ":" . $paid_lunch2;
						foreach ($ans_arr as $key => $val) {
							list($h, $m) = explode(':', $val);
							if ($h <= 9) {
								$h = sprintf("%02d", $h);
							}
							if ($m <= 9) {
								$m = sprintf("%02d", $m);
							}
							$answer1 = trim($h) . ":" . trim($m) . ":" . "00";
							$secs = strtotime($paid_lunch) - strtotime("00:00:00");
							$result3[] = date("H:i", strtotime($answer1) - $secs);
						}
						$overall_time = $result3;
					}
				} else {
					$overall_time = $ans_arr;
				}
			}
			if ($lunch == "2") {
				foreach ($a as $key => $val1) {
					$val2 = $b[$key];
					list($hl1, $ml1) = explode(':', $val1);
					if ($hl1 <= 9) {
						$hl1 = sprintf("%02d", $hl1);
					}
					if ($ml1 <= 9) {
						$ml1 = sprintf("%02d", $ml1);
					}
					$val11 = trim($hl1) . ":" . trim($ml1) . ":" . "00";
					list($hl12, $ml12) = explode(':', $val2);
					if ($hl12 <= 9) {
						$hl12 = sprintf("%02d", $hl12);
					}
					if ($ml12 <= 9) {
						$ml12 = sprintf("%02d", $ml12);
					}
					$val12 = trim($hl12) . ":" . trim($ml12) . ":" . "00";
					$secs = strtotime($val12) - strtotime("00:00:00");
					$result20[] = date("H:i", strtotime($val11) + $secs);
					$overall_time = $result20;
				}
				if (!empty($paid_lunch1)) {
					$paid_lunch = "00" . ":" . $paid_lunch1;
					foreach ($result20 as $key => $val) {
						list($h, $m) = explode(':', $val);
						if ($h <= 9) {
							$h = sprintf("%02d", $h);
						}
						if ($m <= 9) {
							$m = sprintf("%02d", $m);
						}
						$answer1 = $h . ":" . $m . ":" . "00";
						$secs = strtotime($paid_lunch) - strtotime("00:00:00");
						$result21[] = date("H:i", strtotime($answer1) + $secs);
						$overall_time = $result21;
					}
				}
			}
			if ($lunch == "3") {
				foreach ($a as $key => $val1) {
					$val2 = $c[$key];
					$val3 = $d[$key];
					list($hl1, $ml1) = explode(':', $val1);
					if ($hl1 <= 9) {
						$hl1 = sprintf("%02d", $hl1);
					}
					if ($ml1 <= 9) {
						$ml1 = sprintf("%02d", $ml1);
					}
					$val11 = trim($hl1) . ":" . trim($ml1) . ":" . "00";
					list($hl12, $ml12) = explode(':', $val2);
					if ($hl12 <= 9) {
						$hl12 = sprintf("%02d", $hl12);
					}
					if ($ml12 <= 9) {
						$ml12 = sprintf("%02d", $ml12);
					}
					$val12 = trim($hl12) . ":" . trim($ml12) . ":" . "00";
					list($hl13, $ml13) = explode(":", $val3);
					if ($hl13 <= 9) {
						$hl13 = sprintf("%02d", $hl13);
					}
					if ($ml13 <= 9) {
						$ml13 = sprintf("%02d", $ml13);
					}
					$val13 = trim($hl13) . ":" . trim($ml13) . ":" . "00";
					$secs = strtotime($val12) - strtotime("00:00:00");
					$secs2 = strtotime($val13) - strtotime("00:00:00");
					$result30[] = date("H:i", strtotime($val11) + $secs + $secs2);
					$overall_time = $result30;
				}
				if (!empty($paid_lunch2)) {
					$paid_lunch = "00" . ":" . $paid_lunch2;
					foreach ($result30 as $key => $val) {
						list($h, $m) = explode(':', $val);
						if ($h <= 9) {
							$h = sprintf("%02d", $h);
						}
						if ($m <= 9) {
							$m = sprintf("%02d", $m);
						}
						$answer1 = $h . ":" . $m . ":" . "00";
						$secs = strtotime($paid_lunch) - strtotime("00:00:00");
						$result31[] = date("H:i", strtotime($answer1) + $secs);
						$overall_time = $result31;
					}
				}
			}
			function AddPlayTime3($overall_time)
			{
				$minutes = 0;
				foreach ($overall_time as $value) {
					list($hour, $minute) = explode(':', $value);
					$minutes += trim($hour) * 60;
					$minutes += trim($minute);
				}
				$hours = floor($minutes / 60);
				$minutes -= $hours * 60;
				return sprintf('%02d:%02d', $hours, $minutes);
			}
			$table_ans = AddPlayTime3($overall_time);
			$overtime3_first = $table_ans;
			if ($overtime == "0") {
				if (!empty($hour_rate)) {
					foreach ($overall_time as $key => $val) {
						$a1 = explode(":", $val);
						$a1_ans[] = $a1[0] . ":" . "00";
						$pay[] = trim($a1[0]) * $hour_rate;
						$pay2[] = $a1[1] / 60 * $hour_rate;
						$pay2_ans[] = "00" . ":" . $a1[1];
						$pay_sum = array_merge($pay, $pay2);
						$paysum = array_sum($pay_sum);
						$overtime3_first = $table_ans;
						$overtime6_first = $paysum;
					}
				}
				$overtime3_first = $table_ans;
			}
			if ($overtime == "1") {
				foreach ($overall_time as $key => $val) {
					list($overtime_h1, $overtime_m1) = explode(":", $val);
					if ($overtime_h1 >= 8) {
						$hour_res = trim($overtime_h1) - 8;
						$overtime_work1[] = $hour_res . ":" . $overtime_m1;
					} else {
						$overtime3_first = $table_ans;
					}
				}
				function calculate_overtime_one3($overtime_work1)
				{
					$minutes = 0;
					if ($overtime_work1 != "") {
						foreach ($overtime_work1 as $value) {
							list($hour, $minute) = explode(':', $value);
							$minutes += trim($hour) * 60;
							$minutes += trim($minute);
						}
					}
					$hours = floor($minutes / 60);
					$minutes -= $hours * 60;
					return sprintf('%02d:%02d', $hours, $minutes);
				}
				$Ans1 = calculate_overtime_one3($overtime_work1);
				list($Ans1_h, $Ans1_m) = explode(':', $Ans1);
				if ($Ans1_h <= 9) {
					$Ans1_h = sprintf("%02d", $Ans1_h);
				}
				if ($Ans1_m <= 9) {
					$Ans1_m = sprintf("%02d", $Ans1_m);
				}
				$Ans11 = trim($Ans1_h) . ":" . trim($Ans1_m) . ":" . "00";
				list($tableans_h, $tableans_m) = explode(':', $table_ans);
				if ($tableans_h <= 9) {
					$tableans_h = sprintf("%02d", $tableans_h);
				}
				if ($tableans_m <= 9) {
					$tableans_m = sprintf("%02d", $tableans_m);
				}
				if ($selection1 == "1") {
					$duty_time = 1 * 8;
				} else if ($selection1 == "2") {
					$duty_time = 2 * 8;
				} else if ($selection1 == "3") {
					$duty_time = 3 * 8;
				} else if ($selection1 == "4") {
					$duty_time = 4 * 8;
				} else if ($selection1 == "5") {
					$duty_time = 5 * 8;
				} else if ($selection1 == "6") {
					$duty_time = 6 * 8;
				} else if ($selection1 == "7") {
					$duty_time = 7 * 8;
				}
				$regular_time = $duty_time . ":" . "00";
				if (!empty($hour_rate)) {
					if (!empty($overtime_work1)) {
					}
					$pay_h = trim($duty_time) * $hour_rate;
					$pay_dutytime = $pay_h;
				}
				if (!empty($overtime_pay)) {
					list($overtimepay_h, $overtimepay_m) = explode(":", $Ans1);
					if (!empty($hour_rate)) {
						$overpay_h = trim($overtimepay_h) * trim($hour_rate) * trim($overtime_pay);
						$overpay_m = ($overtimepay_m / 60) * trim($hour_rate) * trim($overtime_pay);
						$overwork_pay = $overpay_h + $overpay_m;
					}
				}
				if (!empty($hour_rate) && !empty($overtime_pay)) {
					$total_pay = $overwork_pay + $pay_dutytime;
				}
				$overtime2_first = $Ans1;
				$overtime3_first = $table_ans;
				if (!empty($hour_rate)) {
					$overtime4_first = $pay_dutytime;
				}
				if (!empty($overwork_pay)) {
					$overtime5_first = $overwork_pay;
				}
				if (!empty($hour_rate) && !empty($overtime_pay)) {
					$overtime6_first = $total_pay;
				}
			}
			if ($overtime == "2") {
				list($tableans_h, $tableans_m) = explode(":", $table_ans);
				if ($tableans_h >= 40) {
					$hour_res = trim($tableans_h) - 40;
					$overtime_work1 = $hour_res . ":" . $tableans_m;
					$overtime2_first = $overtime_work1;
				} else {
					$overtime3_first = $table_ans;
					$overtime2_first = "00";
				}
				if ($overtime_work1 != "") {
					list($Ans1_h, $Ans1_m) = explode(':', $overtime_work1);
					if ($Ans1_h <= 9) {
						$Ans1_h = sprintf("%02d", $Ans1_h);
					}
					if ($Ans1_m <= 9) {
						$Ans1_m = sprintf("%02d", $Ans1_m);
					}
					$Ans111 = trim($Ans1_h) . ":" . trim($Ans1_m);
				}
				list($tableans_h, $tableans_m) = explode(':', $table_ans);
				if ($tableans_h <= 9) {
					$tableans_h = sprintf("%02d", $tableans_h);
				}
				if ($tableans_m <= 9) {
					$tableans_m = sprintf("%02d", $tableans_m);
				}
				$tableans1 = trim($tableans_h) . ":" . trim($tableans_m) . ":" . "00";
				if ($overtime_work1 != "") {
					$duty_timet2 = 40;
					$regular_time = $duty_timet2 . ":" . "00";
				}
				if (!empty($hour_rate)) {
					if (!empty($duty_timet2)) {
						$pay_h = trim($duty_timet2) * $hour_rate;
						$pay_dutytimet1 = $pay_h;
					}
					if (empty($overtime_work1)) {
						$regular_time = $table_ans;
						list($tableans_h, $tableans_m) = explode(':', $table_ans);
						$pay_h = trim($tableans_h) * $hour_rate;
						$pay_dutytimet1 = $pay_h;
					}
					$overtime4_first = $pay_dutytimet1;
				}
				if (!empty($overtime_pay)) {
					if ($overtime_work1 != "") {
						list($overtimepay_h, $overtimepay_m) = explode(":", $overtime_work1);
					}
					if ($hour_rate != "" && $overtime_pay != "") {
						if (!empty($overtimepay_h)) {
							$overpay_h = trim($overtimepay_h) * $hour_rate * $overtime_pay;
							$overpay_m = ($overtimepay_m / 60) * $hour_rate * $overtime_pay;
							$overwork_payt1 = $overpay_h + $overpay_m;
							$overtime5_first = $overwork_payt1;
						}
					}
				}
				if (!empty($hour_rate) && !empty($overtime_pay) && !empty($pay_dutytimet1)) {
					if (!empty($overwork_payt1)) {
						$total_pay = $pay_dutytimet1 + $overwork_payt1;
						$overtime6_first = $total_pay;
					}
				}
				$overtime3_first = $table_ans;
			}
			if (!empty($sick_h) || !empty($sick_m)) {
				if ($sick_h <= 9) {
					$sick_h = sprintf("%02d", $sick_h);
				}
				if ($sick_m <= 9) {
					$sick_m = sprintf("%02d", $sick_m);
				}
				list($h, $m) = explode(":", $table_ans);
				$total_m = $sick_m + $m;
				$total_h = $sick_h + $h;
				$t_pay = $total_h . ":" . $total_m;
				$answer1 = trim($sick_h) . ":" . trim($sick_m);
				if (!empty($hour_rate)) {
					if (!empty($answer1)) {
						list($s_h, $s_m) = explode(":", $answer1);
						$sickpay_h = trim($s_h) * $hour_rate;
						$sickpay_m = ($s_m / 60) * $hour_rate;
						$s_pay = $sickpay_h + $sickpay_m;
					}
					$sick_pay = $s_pay;
					list($sick_hour, $sick_min) = explode(":", $t_pay);
					$pay_h = trim($sick_hour) * $hour_rate;
					$pay_m = ($sick_min / 60) * $hour_rate;
					$sickpay = $pay_h + $pay_m;
					$overtime6_first = $sickpay;
				}
				$sick_time = trim($sick_h) . ":" . trim($sick_m);
				$overtime3_first = $t_pay;
				if ($hour_rate != "") {
					$sick_pay = $s_pay;
					$overtime6_first = $sickpay;
				}
			}
			if (!empty($v_h) || !empty($v_m)) {
				if ($v_h <= 9) {
					$v_h = sprintf("%02d", $v_h);
				}
				if ($v_m <= 9) {
					$v_m = sprintf("%02d", $v_m);
				}
				$answer1 = trim($v_h) . ":" . trim($v_m);
				$secs = strtotime($answer1) - strtotime("00:00:00");
				if (!empty($sick_h) || !empty($sick_m)) {
					if ($sick_h <= 9) {
						$sick_h = sprintf("%02d", $sick_h);
					}
					if ($sick_m <= 9) {
						$sick_m = sprintf("%02d", $sick_m);
					}
					$answer2 = trim($sick_h) . ":" . trim($sick_m);
					$v_hours = date("H:i", strtotime($answer2) + $secs);
					list($hours, $minutes) = explode(":", $v_hours);
					list($h, $m) = explode(":", $table_ans);
					$total_m = $minutes + $m;
					$total_h = $hours + $h;
					$total_sick = $total_h . ":" . $total_m;
					$overtime3_first = $total_sick;
				} else {
					$v_hours = date("H:i", strtotime($table_ans) + $secs);
					$overtime3_first = $v_hours;
				}
				if (!empty($hour_rate)) {
					list($vacation_h, $vacation_m) = explode(":", $answer1);
					$sickpay_h = trim($vacation_h) * $hour_rate;
					$sickpay_m = ($vacation_m / 60) * $hour_rate;
					$v_pay = $sickpay_h + $sickpay_m;
					list($v_hour, $v_min) = explode(":", $total_sick);
					$pay_h = trim($v_hour) * $hour_rate;
					$pay_m = ($v_min / 60) * $hour_rate;
					$sickpay = $pay_h + $pay_m;
				}
				$v_time = trim($v_h) . ":" . trim($v_m);
				if ($hour_rate != "") {
					$vacation_pay = $v_pay;
					$overtime6_first = $sickpay;
				}
			}
			return array($ans_arr, $ansl1_arr, $ansl21_arr, $ansl2_arr, $overall_time, $regular_time, $overtime2_first, $overtime3_first, $sick_pay, $sick_time, $vacation_pay, $v_time, $overtime4_first, $overtime5_first, $overtime6_first);
		}
		function timeCal4($selection3 = null, $selection1 = null, $inhour = null, $inmin = null, $inampm = null, $outhour = null, $outmin = null, $outampm = null, $in = null, $out = null, $inhourl1 = null, $inminl1 = null, $inampml1 = " ", $outhourl1 = null, $outminl1 = null, $outampml1 = null, $inlunch1 = null, $outlunch1 = null, $inhourl2 = null, $inminl2 = null, $inampml2 = null, $outhourl2 = null, $outminl2 = null, $outampml2 = null, $inlunch2 = null, $outlunch2 = null, $sick_h = null, $sick_m = null, $v_h = null, $v_m = null, $advancedcheck = null, $lunch = null, $paid_lunch1 = null, $paid_lunch2 = null, $hour_rate = null, $overtime = null, $overtime_pay = null)
		{
			$checkHour = true;
			$checkHourl = true;
			$checkHourl2 = true;
			$regular_time = false;
			$overtime2_first = false;
			$overtime3_first = false;
			$overtime4_first = false;
			$overtime5_first = false;
			$overtime6_first = false;
			$a = $b = $c = $d = $sick_pay = $sick_time = $total_pay = $vacation_pay = $v_time = $ans_arrt2 = $ansl1_arrt2 = $ansl21_arrt2 = $ansl2_arrt2 = $overall_timet2 = $regular_timet2 = $overtime2_firstt2 = $overtime3_firstt2 = $sick_payt2 = $t2sick_timet2 = $total_payt2 = $vacation_payt2 = $v_timet2 = $overtime4_firstt2 = $overtime5_firstt2 = $overtime6_firstt2 = $s_pay = $sickpay = $days = $dayst2 = $overtime_work1 = $ans_arrt3 = $ansl1_arrt3 = $ansl21_arrt3 = $ansl2_arrt3 = $overall_timet3 = $regular_timet3 = $overtime2_firstt3 = $overtime3_firstt3 = $sick_payt3 = $t3sick_timet3 = $total_payt3 = $vacation_payt3 = $v_timet3 = $overtime4_firstt3 = $overtime5_firstt3 = $overtime6_firstt3 = $s_pay = $sickpay = $days = $dayst3 = $ans_arrt4 = $ansl1_arrt4 = $ansl21_arrt4 = $ansl2_arrt4 = $overall_timet4 = $regular_timet4 = $overtime2_firstt4 = $overtime3_firstt4 = $sick_payt4 = $t4sick_timet4 = $total_payt4 = $vacation_payt4 = $v_timet4 = $overtime4_firstt4 = $overtime5_firstt4 = $overtime6_firstt4 = $s_pay = $sickpay = $days = $dayst4 = false;
			$ans_arr = [];
			$ansl1_arr = [];
			$ansl2_arr = [];
			$ansl21_arr = [];
			$checkHour = true;
			if ($selection3 == "1") {
				for ($i = 0; $i < $selection1; $i++) {
					$hour = $inhour[$i];
					$hour1 = $outhour[$i];
					if (empty($hour) || empty($hour1)) {
						$checkHour = false;
					} else {
						$day = 14;
						if ($inampm[$i] == $outampm[$i]) {
							$day = 15;
						}
						$hour = $inhour[$i];
						$min = $inmin[$i];
						$ampm = $inampm[$i];
						if ($hour <= 9) {
							$hour = sprintf("%02d", $hour);
						}
						if ($min <= 9) {
							$min = sprintf("%02d", $min);
						}
						$inr1_res = $hour . ":" . $min . " " . $ampm;
						$inr1_time = date("H:i:s", strtotime($inr1_res));
						$inr1_time = new Carbon("2006-04-14 " . $inr1_time);
						$hour = $outhour[$i];
						$min = $outmin[$i];
						$ampm = $outampm[$i];
						if ($hour <= 9) {
							$hour = sprintf("%02d", $hour);
						}
						if ($min <= 9) {
							$min = sprintf("%02d", $min);
						}
						$outr1_res = $hour . ":" . $min . " " . $ampm;
						$outr1_time = date("H:i:s", strtotime($outr1_res));
						$outr1_time = new Carbon("2006-04-" . $day . " " . $outr1_time);
					}
				}
			} else if ($selection3 == "2") {
				for ($i = 0; $i < $selection1; $i++) {
					$hour = $in[$i];
					$hour1 = $out[$i];
					if (empty($hour) || empty($hour1)) {
						$checkHour = false;
					} else {
						$ab1 = substr($hour, 2);
						$ab2 = substr($hour1, 2);
						if ($ab1 < 59 && $ab2 < 59) {
							$day = 14;
							if ($hour1 < $hour) {
								$day = 15;
							}
							$inr1_time = date("H:i:s", strtotime($hour));
							$inr1_time = new Carbon("2006-04-14 " . $inr1_time);
							$outr1_time = date("H:i:s", strtotime($hour1));
							$outr1_time = new Carbon("2006-04-" . $day . " " . $outr1_time);
						} else {
							return false;
						}
					}
				}
			}
			if ($checkHour == true) {
				for ($i = 0; $i < $selection1; $i++) {
					// $day=14;
					// if ($inampm[$i]==$outampm[$i]) {
					// 	$day=15;
					// }
					// $hour=$inhour[$i];
					// $min=$inmin[$i];
					// $ampm=$inampm[$i];
					// if ($hour<=9) {
					// 	$hour=sprintf("%02d", $hour);
					// }
					// if ($min<=9) {
					// 	$min=sprintf("%02d", $min);
					// }
					// $inr1_res=$hour.":".$min." ".$ampm;
					// $inr1_time = date("H:i:s", strtotime($inr1_res));
					// $inr1_time = new Carbon("2006-04-14 ".$inr1_time);
					// $hour=$outhour[$i];
					// $min=$outmin[$i];
					// $ampm=$outampm[$i];
					// if ($hour<=9) {
					// 	$hour=sprintf("%02d", $hour);
					// }
					// if ($min<=9) {
					// 	$min=sprintf("%02d", $min);
					// }
					// $outr1_res=$hour.":".$min." ".$ampm;
					// $outr1_time = date("H:i:s", strtotime($outr1_res));
					// $outr1_time = new Carbon("2006-04-".$day." ".$outr1_time);
					$rowans1 = $inr1_time->diff($outr1_time);
					$ans_arr5[] = $rowans1->format('%h : %i');
					foreach ($ans_arr5 as $value) {
						list($t1, $t2) = explode(':', $value);
						$t1 = sprintf("%02d", $t1);
						$t2 = sprintf("%02d", $t2);
					}
					$ans_arr[] = $t1 . ":" . $t2;
					$a = $ans_arr;
				}
				if ($lunch == "2") {
					if ($selection3 == "1") {
						for ($i = 0; $i < $selection1; $i++) {
							$hourl1 = $inhourl1[$i];
							$hour1l1 = $outhourl1[$i];
							if (empty($hourl1) || empty($hour1l1)) {
								$checkHourl = false;
							} else {
								$day = 14;
								if ($inampm[$i] == $outampm[$i]) {
									$day = 15;
								}
								$hourl1 = $inhourl1[$i];
								$minl1 = $inminl1[$i];
								$ampml1 = $inampml1[$i];
								if ($hourl1 <= 9) {
									$hourl1 = sprintf("%02d", $hourl1);
								}
								if ($minl1 <= 9) {
									$minl1 = sprintf("%02d", $minl1);
								}
								$inr1l1_res = $hourl1 . ":" . $minl1 . " " . $ampml1;
								$inr1l1_time = date("H:i:s", strtotime($inr1l1_res));
								$inr1l1_time = new Carbon("2006-04-14 " . $inr1l1_time);
								$hourl1 = $outhourl1[$i];
								$minl1 = $outminl1[$i];
								$ampml1 = $outampml1[$i];
								if ($hourl1 <= 9) {
									$hourl1 = sprintf("%02d", $hourl1);
								}
								if ($minl1 <= 9) {
									$minl1 = sprintf("%02d", $minl1);
								}
								$outr1l1_res = $hourl1 . ":" . $minl1 . " " . $ampml1;
								$outr1l1_time = date("H:i:s", strtotime($outr1l1_res));
								$outr1l1_time = new Carbon("2006-04-" . $day . " " . $outr1l1_time);
							}
						}
					} else if ($selection3 == "2") {
						for ($i = 0; $i < $selection1; $i++) {
							$hourl1 = $inlunch1[$i];
							$hour1l1 = $outlunch1[$i];
							if (empty($hourl1) || empty($hour1l1)) {
								$checkHourl = false;
							} else {
								$xy1 = substr($hourl1, 2);
								$xy2 = substr($hour1l1, 2);
								if ($xy1 < 59 && $xy2 < 59) {
									$day = 14;
									if ($hour1l1 < $hourl1) {
										$day = 15;
									}
									$inr1l1_time = date("H:i:s", strtotime($hourl1));
									$inr1l1_time = new Carbon("2006-04-14 " . $inr1l1_time);
									$outr1l1_time = date("H:i:s", strtotime($hour1l1));
									$outr1l1_time = new Carbon("2006-04-" . $day . " " . $outr1l1_time);
								} else {
									return false;
								}
							}
						}
					}
					if ($checkHourl == true) {
						$ansl1_arr = [];
						for ($i = 0; $i < $selection1; $i++) {
							// $day=14;
							// if ($inampm[$i]==$outampm[$i]) {
							// 	$day=15;
							// }
							// $hourl1=$inhourl1[$i];
							// $minl1=$inminl1[$i];
							// $ampml1=$inampml1[$i];
							// if ($hourl1<=9) {
							// 	$hourl1=sprintf("%02d", $hourl1);
							// }
							// if ($minl1<=9) {
							// 	$minl1=sprintf("%02d", $minl1);
							// }
							// $inr1l1_res=$hourl1.":".$minl1." ".$ampml1;
							// $inr1l1_time = date("H:i:s", strtotime($inr1l1_res));
							// $inr1l1_time = new Carbon("2006-04-14 ".$inr1l1_time);
							// $hourl1=$outhourl1[$i];
							// $minl1=$outminl1[$i];
							// $ampml1=$outampml1[$i];
							// if ($hourl1<=9) {
							// 	$hourl1=sprintf("%02d", $hourl1);
							// }
							// if ($minl1<=9) {
							// 	$minl1=sprintf("%02d", $minl1);
							// }
							// $outr1l1_res=$hourl1.":".$minl1." ".$ampml1;
							// $outr1l1_time = date("H:i:s", strtotime($outr1l1_res));
							// $outr1l1_time = new Carbon("2006-04-".$day." ".$outr1l1_time);
							$rowans1l1 = $inr1l1_time->diff($outr1l1_time);
							$ansl1_arr5[] = $rowans1l1->format('%h : %i');
							foreach ($ansl1_arr5 as $value) {
								list($t1, $t2) = explode(':', $value);
								$t1 = sprintf("%02d", $t1);
								$t2 = sprintf("%02d", $t2);
							}
							$ansl1_arr[] = $t1 . ":" . $t2;
							$b = $ansl1_arr;
						}
					} else {
						return false;
					}
				}
				if ($lunch == "3") {
					if ($selection3 == "1") {
						for ($i = 0; $i < $selection1; $i++) {
							$hourl1 = $inhourl1[$i];
							$hour1l1 = $outhourl1[$i];
							if (empty($hourl1) || empty($hour1l1)) {
								$checkHourl = false;
							} else {
								$day = 14;
								if ($inampm[$i] == $outampm[$i]) {
									$day = 15;
								}
								$hourl1 = $inhourl1[$i];
								$minl1 = $inminl1[$i];
								$ampml1 = $inampml1[$i];
								if ($hourl1 <= 9) {
									$hourl1 = sprintf("%02d", $hourl1);
								}
								if ($minl1 <= 9) {
									$minl1 = sprintf("%02d", $minl1);
								}
								$inr1l1_res = $hourl1 . ":" . $minl1 . " " . $ampml1;
								$inr1l1_time = date("H:i:s", strtotime($inr1l1_res));
								$inr1l1_time = new Carbon("2006-04-14 " . $inr1l1_time);
								$hourl1 = $outhourl1[$i];
								$minl1 = $outminl1[$i];
								$ampml1 = $outampml1[$i];
								if ($hourl1 <= 9) {
									$hourl1 = sprintf("%02d", $hourl1);
								}
								if ($minl1 <= 9) {
									$minl1 = sprintf("%02d", $minl1);
								}
								$outr1l1_res = $hourl1 . ":" . $minl1 . " " . $ampml1;
								$outr1l1_time = date("H:i:s", strtotime($outr1l1_res));
								$outr1l1_time = new Carbon("2006-04-" . $day . " " . $outr1l1_time);
							}
						}
						for ($i = 0; $i < $selection1; $i++) {
							$hourl2 = $inhourl2[$i];
							$hour1l2 = $outhourl2[$i];
							if (empty($hourl2) || empty($hour1l2)) {
								$checkHourl2 = false;
							} else {
								$day = 14;
								if ($inampm[$i] == $outampm[$i]) {
									$day = 15;
								}
								$hourl2 = $inhourl2[$i];
								$minl2 = $inminl2[$i];
								$ampml2 = $inampml2[$i];
								if ($hourl2 <= 9) {
									$hourl2 = sprintf("%02d", $hourl2);
								}
								if ($minl2 <= 9) {
									$minl2 = sprintf("%02d", $minl2);
								}
								$inr1l2_res = $hourl2 . ":" . $minl2 . " " . $ampml2;
								$inr1l2_time = date("H:i:s", strtotime($inr1l2_res));
								$inr1l2_time = new Carbon("2006-04-14 " . $inr1l2_time);
								$hourl2 = $outhourl2[$i];
								$minl2 = $outminl2[$i];
								$ampml2 = $outampml2[$i];
								if ($hourl2 <= 9) {
									$hourl2 = sprintf("%02d", $hourl2);
								}
								if ($minl2 <= 9) {
									$minl2 = sprintf("%02d", $minl2);
								}
								$outr1l2_res = $hourl2 . ":" . $minl2 . " " . $ampml2;
								$outr1l2_time = date("H:i:s", strtotime($outr1l2_res));
								$outr1l2_time = new Carbon("2006-04-" . $day . " " . $outr1l2_time);
							}
						}
					} else if ($selection3 == "2") {
						for ($i = 0; $i < $selection1; $i++) {
							$hourl1 = $inlunch1[$i];
							$hour1l1 = $outlunch1[$i];
							if (empty($hourl1) || empty($hour1l1)) {
								$checkHourl = false;
							} else {
								$xy1 = substr($hourl1, 2);
								$xy2 = substr($hour1l1, 2);
								if ($xy1 < 59 && $xy2 < 59) {
									$day = 14;
									if ($hour1l1 < $hourl1) {
										$day = 15;
									}
									$inr1l1_time = date("H:i:s", strtotime($hourl1));
									$inr1l1_time = new Carbon("2006-04-14 " . $inr1l1_time);
									$outr1l1_time = date("H:i:s", strtotime($hour1l1));
									$outr1l1_time = new Carbon("2006-04-" . $day . " " . $outr1l1_time);
								} else {
									return false;
								}
							}
						}
						for ($i = 0; $i < $selection1; $i++) {
							$hourl2 = $inlunch2[$i];
							$hour1l2 = $outlunch2[$i];
							if (empty($hourl2) || empty($hour1l2)) {
								$checkHourl2 = false;
							} else {
								$x1y1 = substr($hourl2, 2);
								$x2y2 = substr($hour1l2, 2);
								if ($x1y1 < 59 && $x2y2 < 59) {
									$day = 14;
									if ($hour1l2 < $hourl2) {
										$day = 15;
									}
									$inr1l2_time = date("H:i:s", strtotime($hourl2));
									$inr1l2_time = new Carbon("2006-04-14 " . $inr1l2_time);
									$outr1l2_time = date("H:i:s", strtotime($hour1l2));
									$outr1l2_time = new Carbon("2006-04-" . $day . " " . $outr1l2_time);
								} else {
									return false;
								}
							}
						}
					}


					// for ($i=0; $i < $selection1 ; $i++) {
					// 	$hourl1=$inhourl1[$i];
					// 	$hour1l1=$outhourl1[$i];
					// 	if (empty($hourl1) || empty($hour1l1)) {
					// 		$checkHourl=false;
					// 	}
					// }
					if ($checkHourl == true) {
						$ansl1_arr = [];
						for ($i = 0; $i < $selection1; $i++) {
							// $day=14;
							// if ($inampm[$i]==$outampm[$i]) {
							// 	$day=15;
							// }
							// $hourl1=$inhourl1[$i];
							// $minl1=$inminl1[$i];
							// $ampml1=$inampml1[$i];
							// if ($hourl1<=9) {
							// 	$hourl1=sprintf("%02d", $hourl1);
							// }
							// if ($minl1<=9) {
							// 	$minl1=sprintf("%02d", $minl1);
							// }
							// $inr1l1_res=$hourl1.":".$minl1." ".$ampml1;
							// $inr1l1_time = date("H:i:s", strtotime($inr1l1_res));
							// $inr1l1_time = new Carbon("2006-04-14 ".$inr1l1_time);
							// $hourl1=$outhourl1[$i];
							// $minl1=$outminl1[$i];
							// $ampml1=$outampml1[$i];
							// if ($hourl1<=9) {
							// 	$hourl1=sprintf("%02d", $hourl1);
							// }
							// if ($minl1<=9) {
							// 	$minl1=sprintf("%02d", $minl1);
							// }
							// $outr1l1_res=$hourl1.":".$minl1." ".$ampml1;
							// $outr1l1_time = date("H:i:s", strtotime($outr1l1_res));
							// $outr1l1_time = new Carbon("2006-04-".$day." ".$outr1l1_time);
							$rowans1l1 = $inr1l1_time->diff($outr1l1_time);
							$ansl21_arr5[] = $rowans1l1->format('%h : %i');
							foreach ($ansl21_arr5 as $value) {
								list($t1, $t2) = explode(':', $value);
								$t1 = sprintf("%02d", $t1);
								$t2 = sprintf("%02d", $t2);
							}
							$ansl21_arr[] = $t1 . ":" . $t2;
							$c = $ansl21_arr;
						}
					} else {
						return false;
					}
					// for ($i=0; $i < $selection1 ; $i++) {
					// 	$hourl2=$inhourl2[$i];
					// 	$hour1l2=$outhourl2[$i];
					// 	if (empty($hourl2) || empty($hour1l2)) {
					// 		$checkHourl2=false;
					// 	}
					// }
					if ($checkHourl2 == true) {
						$ansl1_arr = [];
						for ($i = 0; $i < $selection1; $i++) {
							// $day=14;
							// if ($inampm[$i]==$outampm[$i]) {
							// 	$day=15;
							// } 
							// $hourl2=$inhourl2[$i];
							// $minl2=$inminl2[$i];
							// $ampml2=$inampml2[$i];
							// if ($hourl2<=9) {
							// 	$hourl2=sprintf("%02d", $hourl2);
							// }
							// if ($minl2<=9) {
							// 	$minl2=sprintf("%02d", $minl2);
							// }
							// $inr1l2_res=$hourl2.":".$minl2." ".$ampml2;
							// $inr1l2_time = date("H:i:s", strtotime($inr1l2_res));
							// $inr1l2_time = new Carbon("2006-04-14 ".$inr1l2_time);
							// $hourl2=$outhourl2[$i];
							// $minl2=$outminl2[$i];
							// $ampml2=$outampml2[$i];
							// if ($hourl2<=9) {
							// 	$hourl2=sprintf("%02d", $hourl2);
							// }
							// if ($minl2<=9) {
							// 	$minl2=sprintf("%02d", $minl2);
							// }
							// $outr1l2_res=$hourl2.":".$minl2." ".$ampml2;
							// $outr1l2_time = date("H:i:s", strtotime($outr1l2_res));
							// $outr1l2_time = new Carbon("2006-04-".$day." ".$outr1l2_time);
							$rowans1l2 = $inr1l2_time->diff($outr1l2_time);
							$ansl2_arr5[] = $rowans1l2->format('%h : %i');
							foreach ($ansl2_arr5 as $value) {
								list($t1, $t2) = explode(':', $value);
								$t1 = sprintf("%02d", $t1);
								$t2 = sprintf("%02d", $t2);
							}
							$ansl2_arr[] = $t1 . ":" . $t2;
							$d = $ansl2_arr;
						}
					} else {
						return false;
					}
				}
			} else {
				return false;
			}
			if ($lunch == "1") {
				if ($advancedcheck == true) {
					if (!empty($paid_lunch1) && !empty($paid_lunch2)) {
						$min1 = "00" . ":" . $paid_lunch1;
						$min2 = "00" . ":" . $paid_lunch2;
						function calculate_total_time4()
						{
							$i = 0;
							foreach (func_get_args() as $time) {
								sscanf($time, '%d:%d', $hour, $min);
								$i += $hour * 60 + $min;
							}
							if ($h = floor($i / 60)) {
								$i %= 60;
							}
							return sprintf('%02d:%02d', $h, $i);
						}
						$paid_lunch = calculate_total_time4($min1, $min2);
						foreach ($ans_arr as $key => $val) {
							list($h, $m) = explode(':', $val);
							if ($h <= 9) {
								$h = sprintf("%02d", $h);
							}
							if ($m <= 9) {
								$m = sprintf("%02d", $m);
							}
							$answer1 = trim($h) . ":" . trim($m) . ":" . "00";
							$secs = strtotime($paid_lunch) - strtotime("00:00:00");
							$resultt2[] = date("H:i", strtotime($answer1) - $secs);
						}
						$overall_time = $resultt2;
					} else if (!empty($paid_lunch1)) {
						$paid_lunch = "00" . ":" . $paid_lunch1;
						foreach ($ans_arr as $key => $val) {
							list($h, $m) = explode(':', $val);
							if ($h <= 9) {
								$h = sprintf("%02d", $h);
							}
							if ($m <= 9) {
								$m = sprintf("%02d", $m);
							}
							$answer1 = trim($h) . ":" . trim($m) . ":" . "00";
							$secs = strtotime($paid_lunch) - strtotime("00:00:00");
							$result2[] = date("H:i", strtotime($answer1) - $secs);
						}
						$overall_time = $result2;
					} else if (!empty($paid_lunch2)) {
						$paid_lunch = "00" . ":" . $paid_lunch2;
						foreach ($ans_arr as $key => $val) {
							list($h, $m) = explode(':', $val);
							if ($h <= 9) {
								$h = sprintf("%02d", $h);
							}
							if ($m <= 9) {
								$m = sprintf("%02d", $m);
							}
							$answer1 = trim($h) . ":" . trim($m) . ":" . "00";
							$secs = strtotime($paid_lunch) - strtotime("00:00:00");
							$result3[] = date("H:i", strtotime($answer1) - $secs);
						}
						$overall_time = $result3;
					}
				} else {
					$overall_time = $ans_arr;
				}
			}
			if ($lunch == "2") {
				foreach ($a as $key => $val1) {
					$val2 = $b[$key];
					list($hl1, $ml1) = explode(':', $val1);
					if ($hl1 <= 9) {
						$hl1 = sprintf("%02d", $hl1);
					}
					if ($ml1 <= 9) {
						$ml1 = sprintf("%02d", $ml1);
					}
					$val11 = trim($hl1) . ":" . trim($ml1) . ":" . "00";
					list($hl12, $ml12) = explode(':', $val2);
					if ($hl12 <= 9) {
						$hl12 = sprintf("%02d", $hl12);
					}
					if ($ml12 <= 9) {
						$ml12 = sprintf("%02d", $ml12);
					}
					$val12 = trim($hl12) . ":" . trim($ml12) . ":" . "00";
					$secs = strtotime($val12) - strtotime("00:00:00");
					$result20[] = date("H:i", strtotime($val11) + $secs);
					$overall_time = $result20;
				}
				if (!empty($paid_lunch1)) {
					$paid_lunch = "00" . ":" . $paid_lunch1;
					foreach ($result20 as $key => $val) {
						list($h, $m) = explode(':', $val);
						if ($h <= 9) {
							$h = sprintf("%02d", $h);
						}
						if ($m <= 9) {
							$m = sprintf("%02d", $m);
						}
						$answer1 = $h . ":" . $m . ":" . "00";
						$secs = strtotime($paid_lunch) - strtotime("00:00:00");
						$result21[] = date("H:i", strtotime($answer1) + $secs);
						$overall_time = $result21;
					}
				}
			}
			if ($lunch == "3") {
				foreach ($a as $key => $val1) {
					$val2 = $c[$key];
					$val3 = $d[$key];
					list($hl1, $ml1) = explode(':', $val1);
					if ($hl1 <= 9) {
						$hl1 = sprintf("%02d", $hl1);
					}
					if ($ml1 <= 9) {
						$ml1 = sprintf("%02d", $ml1);
					}
					$val11 = trim($hl1) . ":" . trim($ml1) . ":" . "00";
					list($hl12, $ml12) = explode(':', $val2);
					if ($hl12 <= 9) {
						$hl12 = sprintf("%02d", $hl12);
					}
					if ($ml12 <= 9) {
						$ml12 = sprintf("%02d", $ml12);
					}
					$val12 = trim($hl12) . ":" . trim($ml12) . ":" . "00";
					list($hl13, $ml13) = explode(":", $val3);
					if ($hl13 <= 9) {
						$hl13 = sprintf("%02d", $hl13);
					}
					if ($ml13 <= 9) {
						$ml13 = sprintf("%02d", $ml13);
					}
					$val13 = trim($hl13) . ":" . trim($ml13) . ":" . "00";
					$secs = strtotime($val12) - strtotime("00:00:00");
					$secs2 = strtotime($val13) - strtotime("00:00:00");
					$result30[] = date("H:i", strtotime($val11) + $secs + $secs2);
					$overall_time = $result30;
				}
				if (!empty($paid_lunch2)) {
					$paid_lunch = "00" . ":" . $paid_lunch2;
					foreach ($result30 as $key => $val) {
						list($h, $m) = explode(':', $val);
						if ($h <= 9) {
							$h = sprintf("%02d", $h);
						}
						if ($m <= 9) {
							$m = sprintf("%02d", $m);
						}
						$answer1 = $h . ":" . $m . ":" . "00";
						$secs = strtotime($paid_lunch) - strtotime("00:00:00");
						$result31[] = date("H:i", strtotime($answer1) + $secs);
						$overall_time = $result31;
					}
				}
			}
			function AddPlayTime4($overall_time)
			{
				$minutes = 0;
				foreach ($overall_time as $value) {
					list($hour, $minute) = explode(':', $value);
					$minutes += trim($hour) * 60;
					$minutes += trim($minute);
				}
				$hours = floor($minutes / 60);
				$minutes -= $hours * 60;
				return sprintf('%02d:%02d', $hours, $minutes);
			}
			$table_ans = AddPlayTime4($overall_time);
			$overtime3_first = $table_ans;
			if ($overtime == "0") {
				if (!empty($hour_rate)) {
					foreach ($overall_time as $key => $val) {
						$a1 = explode(":", $val);
						$a1_ans[] = $a1[0] . ":" . "00";
						$pay[] = trim($a1[0]) * $hour_rate;
						$pay2[] = $a1[1] / 60 * $hour_rate;
						$pay2_ans[] = "00" . ":" . $a1[1];
						$pay_sum = array_merge($pay, $pay2);
						$paysum = array_sum($pay_sum);
						$overtime3_first = $table_ans;
						$overtime6_first = $paysum;
					}
				}
				$overtime3_first = $table_ans;
			}
			if ($overtime == "1") {
				foreach ($overall_time as $key => $val) {
					list($overtime_h1, $overtime_m1) = explode(":", $val);
					if ($overtime_h1 >= 8) {
						$hour_res = trim($overtime_h1) - 8;
						$overtime_work1[] = $hour_res . ":" . $overtime_m1;
					} else {
						$overtime3_first = $table_ans;
					}
				}
				function calculate_overtime_one4($overtime_work1)
				{
					$minutes = 0;
					if ($overtime_work1 != "") {
						foreach ($overtime_work1 as $value) {
							list($hour, $minute) = explode(':', $value);
							$minutes += trim($hour) * 60;
							$minutes += trim($minute);
						}
					}
					$hours = floor($minutes / 60);
					$minutes -= $hours * 60;
					return sprintf('%02d:%02d', $hours, $minutes);
				}
				$Ans1 = calculate_overtime_one4($overtime_work1);
				list($Ans1_h, $Ans1_m) = explode(':', $Ans1);
				if ($Ans1_h <= 9) {
					$Ans1_h = sprintf("%02d", $Ans1_h);
				}
				if ($Ans1_m <= 9) {
					$Ans1_m = sprintf("%02d", $Ans1_m);
				}
				$Ans11 = trim($Ans1_h) . ":" . trim($Ans1_m) . ":" . "00";
				list($tableans_h, $tableans_m) = explode(':', $table_ans);
				if ($tableans_h <= 9) {
					$tableans_h = sprintf("%02d", $tableans_h);
				}
				if ($tableans_m <= 9) {
					$tableans_m = sprintf("%02d", $tableans_m);
				}
				if ($selection1 == "1") {
					$duty_time = 1 * 8;
				} else if ($selection1 == "2") {
					$duty_time = 2 * 8;
				} else if ($selection1 == "3") {
					$duty_time = 3 * 8;
				} else if ($selection1 == "4") {
					$duty_time = 4 * 8;
				} else if ($selection1 == "5") {
					$duty_time = 5 * 8;
				} else if ($selection1 == "6") {
					$duty_time = 6 * 8;
				} else if ($selection1 == "7") {
					$duty_time = 7 * 8;
				}
				$regular_time = $duty_time . ":" . "00";
				if (!empty($hour_rate)) {
					if (!empty($overtime_work1)) {
					}
					$pay_h = trim($duty_time) * $hour_rate;
					$pay_dutytime = $pay_h;
				}
				if (!empty($overtime_pay)) {
					list($overtimepay_h, $overtimepay_m) = explode(":", $Ans1);
					if (!empty($hour_rate)) {
						$overpay_h = trim($overtimepay_h) * trim($hour_rate) * trim($overtime_pay);
						$overpay_m = ($overtimepay_m / 60) * trim($hour_rate) * trim($overtime_pay);
						$overwork_pay = $overpay_h + $overpay_m;
					}
				}
				if (!empty($hour_rate) && !empty($overtime_pay)) {
					$total_pay = $overwork_pay + $pay_dutytime;
				}
				$overtime2_first = $Ans1;
				$overtime3_first = $table_ans;
				if (!empty($hour_rate)) {
					$overtime4_first = $pay_dutytime;
				}
				if (!empty($overwork_pay)) {
					$overtime5_first = $overwork_pay;
				}
				if (!empty($hour_rate) && !empty($overtime_pay)) {
					$overtime6_first = $total_pay;
				}
			}
			if ($overtime == "2") {
				list($tableans_h, $tableans_m) = explode(":", $table_ans);
				if ($tableans_h >= 40) {
					$hour_res = trim($tableans_h) - 40;
					$overtime_work1 = $hour_res . ":" . $tableans_m;
					$overtime2_first = $overtime_work1;
				} else {
					$overtime3_first = $table_ans;
					$overtime2_first = "00";
				}
				if ($overtime_work1 != "") {
					list($Ans1_h, $Ans1_m) = explode(':', $overtime_work1);
					if ($Ans1_h <= 9) {
						$Ans1_h = sprintf("%02d", $Ans1_h);
					}
					if ($Ans1_m <= 9) {
						$Ans1_m = sprintf("%02d", $Ans1_m);
					}
					$Ans111 = trim($Ans1_h) . ":" . trim($Ans1_m);
				}
				list($tableans_h, $tableans_m) = explode(':', $table_ans);
				if ($tableans_h <= 9) {
					$tableans_h = sprintf("%02d", $tableans_h);
				}
				if ($tableans_m <= 9) {
					$tableans_m = sprintf("%02d", $tableans_m);
				}
				$tableans1 = trim($tableans_h) . ":" . trim($tableans_m) . ":" . "00";
				if ($overtime_work1 != "") {
					$duty_timet2 = 40;
					$regular_time = $duty_timet2 . ":" . "00";
				}
				if (!empty($hour_rate)) {
					if (!empty($duty_timet2)) {
						$pay_h = trim($duty_timet2) * $hour_rate;
						$pay_dutytimet1 = $pay_h;
					}
					if (empty($overtime_work1)) {
						$regular_time = $table_ans;
						list($tableans_h, $tableans_m) = explode(':', $table_ans);
						$pay_h = trim($tableans_h) * $hour_rate;
						$pay_dutytimet1 = $pay_h;
					}
					$overtime4_first = $pay_dutytimet1;
				}
				if (!empty($overtime_pay)) {
					if ($overtime_work1 != "") {
						list($overtimepay_h, $overtimepay_m) = explode(":", $overtime_work1);
					}
					if ($hour_rate != "" && $overtime_pay != "") {
						if (!empty($overtimepay_h)) {
							$overpay_h = trim($overtimepay_h) * $hour_rate * $overtime_pay;
							$overpay_m = ($overtimepay_m / 60) * $hour_rate * $overtime_pay;
							$overwork_payt1 = $overpay_h + $overpay_m;
							$overtime5_first = $overwork_payt1;
						}
					}
				}
				if (!empty($hour_rate) && !empty($overtime_pay) && !empty($pay_dutytimet1)) {
					if (!empty($overwork_payt1)) {
						$total_pay = $pay_dutytimet1 + $overwork_payt1;
						$overtime6_first = $total_pay;
					}
				}
				$overtime3_first = $table_ans;
			}
			if (!empty($sick_h) || !empty($sick_m)) {
				if ($sick_h <= 9) {
					$sick_h = sprintf("%02d", $sick_h);
				}
				if ($sick_m <= 9) {
					$sick_m = sprintf("%02d", $sick_m);
				}
				list($h, $m) = explode(":", $table_ans);
				$total_m = $sick_m + $m;
				$total_h = $sick_h + $h;
				$t_pay = $total_h . ":" . $total_m;
				$answer1 = trim($sick_h) . ":" . trim($sick_m);
				if (!empty($hour_rate)) {
					if (!empty($answer1)) {
						list($s_h, $s_m) = explode(":", $answer1);
						$sickpay_h = trim($s_h) * $hour_rate;
						$sickpay_m = ($s_m / 60) * $hour_rate;
						$s_pay = $sickpay_h + $sickpay_m;
					}
					$sick_pay = $s_pay;
					list($sick_hour, $sick_min) = explode(":", $t_pay);
					$pay_h = trim($sick_hour) * $hour_rate;
					$pay_m = ($sick_min / 60) * $hour_rate;
					$sickpay = $pay_h + $pay_m;
					$overtime6_first = $sickpay;
				}
				$sick_time = trim($sick_h) . ":" . trim($sick_m);
				$overtime3_first = $t_pay;
				if ($hour_rate != "") {
					$sick_pay = $s_pay;
					$overtime6_first = $sickpay;
				}
			}
			if (!empty($v_h) || !empty($v_m)) {
				if ($v_h <= 9) {
					$v_h = sprintf("%02d", $v_h);
				}
				if ($v_m <= 9) {
					$v_m = sprintf("%02d", $v_m);
				}
				$answer1 = trim($v_h) . ":" . trim($v_m);
				$secs = strtotime($answer1) - strtotime("00:00:00");
				if (!empty($sick_h) || !empty($sick_m)) {
					if ($sick_h <= 9) {
						$sick_h = sprintf("%02d", $sick_h);
					}
					if ($sick_m <= 9) {
						$sick_m = sprintf("%02d", $sick_m);
					}
					$answer2 = trim($sick_h) . ":" . trim($sick_m);
					$v_hours = date("H:i", strtotime($answer2) + $secs);
					list($hours, $minutes) = explode(":", $v_hours);
					list($h, $m) = explode(":", $table_ans);
					$total_m = $minutes + $m;
					$total_h = $hours + $h;
					$total_sick = $total_h . ":" . $total_m;
					$overtime3_first = $total_sick;
				} else {
					$v_hours = date("H:i", strtotime($table_ans) + $secs);
					$overtime3_first = $v_hours;
				}
				if (!empty($hour_rate)) {
					list($vacation_h, $vacation_m) = explode(":", $answer1);
					$sickpay_h = trim($vacation_h) * $hour_rate;
					$sickpay_m = ($vacation_m / 60) * $hour_rate;
					$v_pay = $sickpay_h + $sickpay_m;
					list($v_hour, $v_min) = explode(":", $total_sick);
					$pay_h = trim($v_hour) * $hour_rate;
					$pay_m = ($v_min / 60) * $hour_rate;
					$sickpay = $pay_h + $pay_m;
				}
				$v_time = trim($v_h) . ":" . trim($v_m);
				if ($hour_rate != "") {
					$vacation_pay = $v_pay;
					$overtime6_first = $sickpay;
				}
			}
			return array($ans_arr, $ansl1_arr, $ansl21_arr, $ansl2_arr, $overall_time, $regular_time, $overtime2_first, $overtime3_first, $sick_pay, $sick_time, $vacation_pay, $v_time, $overtime4_first, $overtime5_first, $overtime6_first);
		}
		if ($table_selection == "1") {
			$ans_time = timeCal($selection3, $selection1, $inhour, $inmin, $inampm, $outhour, $outmin, $outampm, $in, $out, $inhourl1, $inminl1, $inampml1, $outhourl1, $outminl1, $outampml1, $inlunch1, $outlunch1, $inhourl2, $inminl2, $inampml2, $outhourl2, $outminl2, $outampml2, $inlunch2, $outlunch2, $sick_h, $sick_m, $v_h, $v_m, $advancedcheck, $lunch, $paid_lunch1, $paid_lunch2, $hour_rate, $overtime, $overtime_pay);
			if ($ans_time === false) {
				$this->param['error'] = 'Please check your input';
				return $this->param;
			} else {
				$this->param['ans_arr'] = $ans_time[0];
				$this->param['ansl1_arr'] = $ans_time[1];
				$this->param['ansl21_arr'] = $ans_time[2];
				$this->param['ansl2_arr'] = $ans_time[3];
				$this->param['overall_time'] = $ans_time[4];
				$this->param['regular_time'] = $ans_time[5];
				$this->param['overtime2_first'] = $ans_time[6];
				$this->param['overtime3_first'] = $ans_time[7];
				$this->param['sick_pay'] = $ans_time[8];
				$this->param['sick_time'] = $ans_time[9];
				$this->param['vacation_pay'] = $ans_time[10];
				$this->param['v_time'] = $ans_time[11];
				$this->param['overtime4_first'] = $ans_time[12];
				$this->param['overtime5_first'] = $ans_time[13];
				$this->param['overtime6_first'] = $ans_time[14];
				if ($selection2 == "1") {
					$days = ["1", "2", "3", "4", "5", "6", "7"];
				} elseif ($selection2 == "2") {
					$days = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
				} elseif ($selection2 == "3") {
					$days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
				} elseif ($selection2 == "4") {
					$days = ["M", "T", "W", "T", "F", "S", "S"];
				} elseif ($selection2 == "5") {
					$days = ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"];
				}
				$from = date('M d, Y', strtotime($s_date));
				$to = date('M d, Y', strtotime($e_date));
				if (strtotime($s_date) > strtotime($e_date)) {
					$new = $from;
					$from = $to;
					$to = $new;
				}
				$this->param['from'] = $from;
				$this->param['to'] = $to;
				$this->param['days'] = $days;
			}
		} else if ($table_selection == "2") {
			$ans_time = timeCal($selection3, $selection1, $inhour, $inmin, $inampm, $outhour, $outmin, $outampm, $in, $out, $inhourl1, $inminl1, $inampml1, $outhourl1, $outminl1, $outampml1, $inlunch1, $outlunch1, $inhourl2, $inminl2, $inampml2, $outhourl2, $outminl2, $outampml2, $inlunch2, $outlunch2, $sick_h, $sick_m, $v_h, $v_m, $advancedcheck, $lunch, $paid_lunch1, $paid_lunch2, $hour_rate, $overtime, $overtime_pay);
			if ($ans_time === false) {
				$this->param['error'] = 'Please check your input';
				return $this->param;
			} else {
				$this->param['ans_arr'] = $ans_time[0];
				$this->param['ansl1_arr'] = $ans_time[1];
				$this->param['ansl21_arr'] = $ans_time[2];
				$this->param['ansl2_arr'] = $ans_time[3];
				$this->param['overall_time'] = $ans_time[4];
				$this->param['regular_time'] = $ans_time[5];
				$this->param['overtime2_first'] = $ans_time[6];
				$this->param['overtime3_first'] = $ans_time[7];
				$this->param['sick_pay'] = $ans_time[8];
				$this->param['sick_time'] = $ans_time[9];
				$this->param['vacation_pay'] = $ans_time[10];
				$this->param['v_time'] = $ans_time[11];
				$this->param['overtime4_first'] = $ans_time[12];
				$this->param['overtime5_first'] = $ans_time[13];
				$this->param['overtime6_first'] = $ans_time[14];
				if ($selection2 == "1") {
					$days = ["1", "2", "3", "4", "5", "6", "7"];
				} elseif ($selection2 == "2") {
					$days = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
				} elseif ($selection2 == "3") {
					$days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
				} elseif ($selection2 == "4") {
					$days = ["M", "T", "W", "T", "F", "S", "S"];
				} elseif ($selection2 == "5") {
					$days = ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"];
				}
				$from = date('M d, Y', strtotime($s_date));
				$to = date('M d, Y', strtotime($e_date));
				if (strtotime($s_date) > strtotime($e_date)) {
					$new = $from;
					$from = $to;
					$to = $new;
				}
				$this->param['from'] = $from;
				$this->param['to'] = $to;
				$this->param['days'] = $days;
			}

			// for table 2 calculation

			$ans_timet2 = timeCal2($selection3, $selection1, $t2inhour, $t2inmin, $t2inampm, $t2outhour, $t2outmin, $t2outampm, $t2in, $t2out, $t2inhourl1, $t2inminl1, $t2inampml1, $t2outhourl1, $t2outminl1, $t2outampml1, $t2inlunch1, $t2outlunch1, $t2inhourl2, $t2inminl2, $t2inampml2, $t2outhourl2, $t2outminl2, $t2outampml2, $t2inlunch2, $t2outlunch2, $t2sick_h, $t2sick_m, $t2v_h, $t2v_m, $advancedcheck, $lunch, $paid_lunch1, $paid_lunch2, $hour_rate, $overtime, $overtime_pay);
			if ($ans_timet2 === false) {
				$this->param['error'] = 'Please check your input';
				return $this->param;
			} else {
				$this->param['ans_arrt2'] = $ans_timet2[0];
				$this->param['ansl1_arrt2'] = $ans_timet2[1];
				$this->param['ansl21_arrt2'] = $ans_timet2[2];
				$this->param['ansl2_arrt2'] = $ans_timet2[3];
				$this->param['overall_timet2'] = $ans_timet2[4];
				$this->param['regular_timet2'] = $ans_timet2[5];
				$this->param['overtime2_firstt2'] = $ans_timet2[6];
				$this->param['overtime3_firstt2'] = $ans_timet2[7];
				$this->param['sick_payt2'] = $ans_timet2[8];
				$this->param['sick_timet2'] = $ans_timet2[9];
				$this->param['vacation_payt2'] = $ans_timet2[10];
				$this->param['v_timet2'] = $ans_timet2[11];
				$this->param['overtime4_firstt2'] = $ans_timet2[12];
				$this->param['overtime5_firstt2'] = $ans_timet2[13];
				$this->param['overtime6_firstt2'] = $ans_timet2[14];
				if ($selection2 == "1") {
					$dayst2 = ["1", "2", "3", "4", "5", "6", "7"];
				} elseif ($selection2 == "2") {
					$dayst2 = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
				} elseif ($selection2 == "3") {
					$dayst2 = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
				} elseif ($selection2 == "4") {
					$dayst2 = ["M", "T", "W", "T", "F", "S", "S"];
				} elseif ($selection2 == "5") {
					$dayst2 = ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"];
				}
				$fromt2 = date('M d, Y', strtotime($s2_date));
				$tot2 = date('M d, Y', strtotime($e2_date));
				if (strtotime($s2_date) > strtotime($e2_date)) {
					$newt2 = $fromt2;
					$fromt2 = $tot2;
					$tot2 = $newt2;
				}
				$this->param['fromt2'] = $fromt2;
				$this->param['tot2'] = $tot2;
				$this->param['dayst2'] = $dayst2;
			}
		} else if ($table_selection == "3") {
			$ans_time = timeCal($selection3, $selection1, $inhour, $inmin, $inampm, $outhour, $outmin, $outampm, $in, $out, $inhourl1, $inminl1, $inampml1, $outhourl1, $outminl1, $outampml1, $inlunch1, $outlunch1, $inhourl2, $inminl2, $inampml2, $outhourl2, $outminl2, $outampml2, $inlunch2, $outlunch2, $sick_h, $sick_m, $v_h, $v_m, $advancedcheck, $lunch, $paid_lunch1, $paid_lunch2, $hour_rate, $overtime, $overtime_pay);
			if ($ans_time === false) {
				$this->param['error'] = 'Please check your input';
				return $this->param;
			} else {
				$this->param['ans_arr'] = $ans_time[0];
				$this->param['ansl1_arr'] = $ans_time[1];
				$this->param['ansl21_arr'] = $ans_time[2];
				$this->param['ansl2_arr'] = $ans_time[3];
				$this->param['overall_time'] = $ans_time[4];
				$this->param['regular_time'] = $ans_time[5];
				$this->param['overtime2_first'] = $ans_time[6];
				$this->param['overtime3_first'] = $ans_time[7];
				$this->param['sick_pay'] = $ans_time[8];
				$this->param['sick_time'] = $ans_time[9];
				$this->param['vacation_pay'] = $ans_time[10];
				$this->param['v_time'] = $ans_time[11];
				$this->param['overtime4_first'] = $ans_time[12];
				$this->param['overtime5_first'] = $ans_time[13];
				$this->param['overtime6_first'] = $ans_time[14];
				if ($selection2 == "1") {
					$days = ["1", "2", "3", "4", "5", "6", "7"];
				} elseif ($selection2 == "2") {
					$days = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
				} elseif ($selection2 == "3") {
					$days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
				} elseif ($selection2 == "4") {
					$days = ["M", "T", "W", "T", "F", "S", "S"];
				} elseif ($selection2 == "5") {
					$days = ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"];
				}
				$from = date('M d, Y', strtotime($s_date));
				$to = date('M d, Y', strtotime($e_date));
				if (strtotime($s_date) > strtotime($e_date)) {
					$new = $from;
					$from = $to;
					$to = $new;
				}
				$this->param['from'] = $from;
				$this->param['to'] = $to;
				$this->param['days'] = $days;
			}

			// for table 2 calculation

			$ans_timet2 = timeCal2($selection3, $selection1, $t2inhour, $t2inmin, $t2inampm, $t2outhour, $t2outmin, $t2outampm, $t2in, $t2out, $t2inhourl1, $t2inminl1, $t2inampml1, $t2outhourl1, $t2outminl1, $t2outampml1, $t2inlunch1, $t2outlunch1, $t2inhourl2, $t2inminl2, $t2inampml2, $t2outhourl2, $t2outminl2, $t2outampml2, $t2inlunch2, $t2outlunch2, $t2sick_h, $t2sick_m, $t2v_h, $t2v_m, $advancedcheck, $lunch, $paid_lunch1, $paid_lunch2, $hour_rate, $overtime, $overtime_pay);
			if ($ans_timet2 === false) {
				$this->param['error'] = 'Please check your input';
				return $this->param;
			} else {
				$this->param['ans_arrt2'] = $ans_timet2[0];
				$this->param['ansl1_arrt2'] = $ans_timet2[1];
				$this->param['ansl21_arrt2'] = $ans_timet2[2];
				$this->param['ansl2_arrt2'] = $ans_timet2[3];
				$this->param['overall_timet2'] = $ans_timet2[4];
				$this->param['regular_timet2'] = $ans_timet2[5];
				$this->param['overtime2_firstt2'] = $ans_timet2[6];
				$this->param['overtime3_firstt2'] = $ans_timet2[7];
				$this->param['sick_payt2'] = $ans_timet2[8];
				$this->param['sick_timet2'] = $ans_timet2[9];
				$this->param['vacation_payt2'] = $ans_timet2[10];
				$this->param['v_timet2'] = $ans_timet2[11];
				$this->param['overtime4_firstt2'] = $ans_timet2[12];
				$this->param['overtime5_firstt2'] = $ans_timet2[13];
				$this->param['overtime6_firstt2'] = $ans_timet2[14];
				if ($selection2 == "1") {
					$dayst2 = ["1", "2", "3", "4", "5", "6", "7"];
				} elseif ($selection2 == "2") {
					$dayst2 = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
				} elseif ($selection2 == "3") {
					$dayst2 = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
				} elseif ($selection2 == "4") {
					$dayst2 = ["M", "T", "W", "T", "F", "S", "S"];
				} elseif ($selection2 == "5") {
					$dayst2 = ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"];
				}
				$fromt2 = date('M d, Y', strtotime($s2_date));
				$tot2 = date('M d, Y', strtotime($e2_date));
				if (strtotime($s2_date) > strtotime($e2_date)) {
					$newt2 = $fromt2;
					$fromt2 = $tot2;
					$tot2 = $newt2;
				}
				$this->param['fromt2'] = $fromt2;
				$this->param['tot2'] = $tot2;
				$this->param['dayst2'] = $dayst2;
			}

			// for table 3 calculation

			$ans_timet3 = timeCal3($selection3, $selection1, $t3inhour, $t3inmin, $t3inampm, $t3outhour, $t3outmin, $t3outampm, $t3in, $t3out, $t3inhourl1, $t3inminl1, $t3inampml1, $t3outhourl1, $t3outminl1, $t3outampml1, $t3inlunch1, $t3outlunch1, $t3inhourl2, $t3inminl2, $t3inampml2, $t3outhourl2, $t3outminl2, $t3outampml2, $t3inlunch2, $t3outlunch2, $t3sick_h, $t3sick_m, $t3v_h, $t3v_m, $advancedcheck, $lunch, $paid_lunch1, $paid_lunch2, $hour_rate, $overtime, $overtime_pay);
			if ($ans_timet2 === false) {
				$this->param['error'] = 'Please check your input';
				return $this->param;
			} else {
				$this->param['ans_arrt3'] = $ans_timet3[0];
				$this->param['ansl1_arrt3'] = $ans_timet3[1];
				$this->param['ansl21_arrt3'] = $ans_timet3[2];
				$this->param['ansl2_arrt3'] = $ans_timet3[3];
				$this->param['overall_timet3'] = $ans_timet3[4];
				$this->param['regular_timet3'] = $ans_timet3[5];
				$this->param['overtime2_firstt3'] = $ans_timet3[6];
				$this->param['overtime3_firstt3'] = $ans_timet3[7];
				$this->param['sick_payt3'] = $ans_timet3[8];
				$this->param['sick_timet3'] = $ans_timet3[9];
				$this->param['vacation_payt3'] = $ans_timet3[10];
				$this->param['v_timet3'] = $ans_timet3[11];
				$this->param['overtime4_firstt3'] = $ans_timet3[12];
				$this->param['overtime5_firstt3'] = $ans_timet3[13];
				$this->param['overtime6_firstt3'] = $ans_timet3[14];
				if ($selection2 == "1") {
					$dayst3 = ["1", "2", "3", "4", "5", "6", "7"];
				} elseif ($selection2 == "2") {
					$dayst3 = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
				} elseif ($selection2 == "3") {
					$dayst3 = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
				} elseif ($selection2 == "4") {
					$dayst3 = ["M", "T", "W", "T", "F", "S", "S"];
				} elseif ($selection2 == "5") {
					$dayst3 = ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"];
				}
				$fromt3 = date('M d, Y', strtotime($s3_date));
				$tot3 = date('M d, Y', strtotime($e3_date));
				if (strtotime($s3_date) > strtotime($e3_date)) {
					$newt3 = $fromt3;
					$fromt3 = $tot3;
					$tot3 = $newt3;
				}
				$this->param['fromt3'] = $fromt3;
				$this->param['tot3'] = $tot3;
				$this->param['dayst3'] = $dayst3;
			}
		} else if ($table_selection == "4") {
			$ans_time = timeCal($selection3, $selection1, $inhour, $inmin, $inampm, $outhour, $outmin, $outampm, $in, $out, $inhourl1, $inminl1, $inampml1, $outhourl1, $outminl1, $outampml1, $inlunch1, $outlunch1, $inhourl2, $inminl2, $inampml2, $outhourl2, $outminl2, $outampml2, $inlunch2, $outlunch2, $sick_h, $sick_m, $v_h, $v_m, $advancedcheck, $lunch, $paid_lunch1, $paid_lunch2, $hour_rate, $overtime, $overtime_pay);
			if ($ans_time === false) {
				$this->param['error'] = 'Please check your input';
				return $this->param;
			} else {
				$this->param['ans_arr'] = $ans_time[0];
				$this->param['ansl1_arr'] = $ans_time[1];
				$this->param['ansl21_arr'] = $ans_time[2];
				$this->param['ansl2_arr'] = $ans_time[3];
				$this->param['overall_time'] = $ans_time[4];
				$this->param['regular_time'] = $ans_time[5];
				$this->param['overtime2_first'] = $ans_time[6];
				$this->param['overtime3_first'] = $ans_time[7];
				$this->param['sick_pay'] = $ans_time[8];
				$this->param['sick_time'] = $ans_time[9];
				$this->param['vacation_pay'] = $ans_time[10];
				$this->param['v_time'] = $ans_time[11];
				$this->param['overtime4_first'] = $ans_time[12];
				$this->param['overtime5_first'] = $ans_time[13];
				$this->param['overtime6_first'] = $ans_time[14];
				if ($selection2 == "1") {
					$days = ["1", "2", "3", "4", "5", "6", "7"];
				} elseif ($selection2 == "2") {
					$days = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
				} elseif ($selection2 == "3") {
					$days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
				} elseif ($selection2 == "4") {
					$days = ["M", "T", "W", "T", "F", "S", "S"];
				} elseif ($selection2 == "5") {
					$days = ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"];
				}
				$from = date('M d, Y', strtotime($s_date));
				$to = date('M d, Y', strtotime($e_date));
				if (strtotime($s_date) > strtotime($e_date)) {
					$new = $from;
					$from = $to;
					$to = $new;
				}
				$this->param['from'] = $from;
				$this->param['to'] = $to;
				$this->param['days'] = $days;
			}

			// for table 2 calculation

			$ans_timet2 = timeCal2($selection3, $selection1, $t2inhour, $t2inmin, $t2inampm, $t2outhour, $t2outmin, $t2outampm, $t2in, $t2out, $t2inhourl1, $t2inminl1, $t2inampml1, $t2outhourl1, $t2outminl1, $t2outampml1, $t2inlunch1, $t2outlunch1, $t2inhourl2, $t2inminl2, $t2inampml2, $t2outhourl2, $t2outminl2, $t2outampml2, $t2inlunch2, $t2outlunch2, $t2sick_h, $t2sick_m, $t2v_h, $t2v_m, $advancedcheck, $lunch, $paid_lunch1, $paid_lunch2, $hour_rate, $overtime, $overtime_pay);
			if ($ans_timet2 === false) {
				$this->param['error'] = 'Please check your input';
				return $this->param;
			} else {
				$this->param['ans_arrt2'] = $ans_timet2[0];
				$this->param['ansl1_arrt2'] = $ans_timet2[1];
				$this->param['ansl21_arrt2'] = $ans_timet2[2];
				$this->param['ansl2_arrt2'] = $ans_timet2[3];
				$this->param['overall_timet2'] = $ans_timet2[4];
				$this->param['regular_timet2'] = $ans_timet2[5];
				$this->param['overtime2_firstt2'] = $ans_timet2[6];
				$this->param['overtime3_firstt2'] = $ans_timet2[7];
				$this->param['sick_payt2'] = $ans_timet2[8];
				$this->param['sick_timet2'] = $ans_timet2[9];
				$this->param['vacation_payt2'] = $ans_timet2[10];
				$this->param['v_timet2'] = $ans_timet2[11];
				$this->param['overtime4_firstt2'] = $ans_timet2[12];
				$this->param['overtime5_firstt2'] = $ans_timet2[13];
				$this->param['overtime6_firstt2'] = $ans_timet2[14];
				if ($selection2 == "1") {
					$dayst2 = ["1", "2", "3", "4", "5", "6", "7"];
				} elseif ($selection2 == "2") {
					$dayst2 = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
				} elseif ($selection2 == "3") {
					$dayst2 = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
				} elseif ($selection2 == "4") {
					$dayst2 = ["M", "T", "W", "T", "F", "S", "S"];
				} elseif ($selection2 == "5") {
					$dayst2 = ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"];
				}
				$fromt2 = date('M d, Y', strtotime($s2_date));
				$tot2 = date('M d, Y', strtotime($e2_date));
				if (strtotime($s2_date) > strtotime($e2_date)) {
					$newt2 = $fromt2;
					$fromt2 = $tot2;
					$tot2 = $newt2;
				}
				$this->param['fromt2'] = $fromt2;
				$this->param['tot2'] = $tot2;
				$this->param['dayst2'] = $dayst2;
			}

			// for table 3 calculation

			$ans_timet3 = timeCal3($selection3, $selection1, $t3inhour, $t3inmin, $t3inampm, $t3outhour, $t3outmin, $t3outampm, $t3in, $t3out, $t3inhourl1, $t3inminl1, $t3inampml1, $t3outhourl1, $t3outminl1, $t3outampml1, $t3inlunch1, $t3outlunch1, $t3inhourl2, $t3inminl2, $t3inampml2, $t3outhourl2, $t3outminl2, $t3outampml2, $t3inlunch2, $t3outlunch2, $t3sick_h, $t3sick_m, $t3v_h, $t3v_m, $advancedcheck, $lunch, $paid_lunch1, $paid_lunch2, $hour_rate, $overtime, $overtime_pay);
			if ($ans_timet2 === false) {
				$this->param['error'] = 'Please check your input';
				return $this->param;
			} else {
				$this->param['ans_arrt3'] = $ans_timet3[0];
				$this->param['ansl1_arrt3'] = $ans_timet3[1];
				$this->param['ansl21_arrt3'] = $ans_timet3[2];
				$this->param['ansl2_arrt3'] = $ans_timet3[3];
				$this->param['overall_timet3'] = $ans_timet3[4];
				$this->param['regular_timet3'] = $ans_timet3[5];
				$this->param['overtime2_firstt3'] = $ans_timet3[6];
				$this->param['overtime3_firstt3'] = $ans_timet3[7];
				$this->param['sick_payt3'] = $ans_timet3[8];
				$this->param['sick_timet3'] = $ans_timet3[9];
				$this->param['vacation_payt3'] = $ans_timet3[10];
				$this->param['v_timet3'] = $ans_timet3[11];
				$this->param['overtime4_firstt3'] = $ans_timet3[12];
				$this->param['overtime5_firstt3'] = $ans_timet3[13];
				$this->param['overtime6_firstt3'] = $ans_timet3[14];
				if ($selection2 == "1") {
					$dayst3 = ["1", "2", "3", "4", "5", "6", "7"];
				} elseif ($selection2 == "2") {
					$dayst3 = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
				} elseif ($selection2 == "3") {
					$dayst3 = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
				} elseif ($selection2 == "4") {
					$dayst3 = ["M", "T", "W", "T", "F", "S", "S"];
				} elseif ($selection2 == "5") {
					$dayst3 = ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"];
				}
				$fromt3 = date('M d, Y', strtotime($s3_date));
				$tot3 = date('M d, Y', strtotime($e3_date));
				if (strtotime($s3_date) > strtotime($e3_date)) {
					$newt3 = $fromt3;
					$fromt3 = $tot3;
					$tot3 = $newt3;
				}
				$this->param['fromt3'] = $fromt3;
				$this->param['tot3'] = $tot3;
				$this->param['dayst3'] = $dayst3;
			}

			// for table 4 calculation

			$ans_timet4 = timeCal4($selection3, $selection1, $t4inhour, $t4inmin, $t4inampm, $t4outhour, $t4outmin, $t4outampm, $t4in, $t4out, $t4inhourl1, $t4inminl1, $t4inampml1, $t4outhourl1, $t4outminl1, $t4outampml1, $t4inlunch1, $t4outlunch1, $t4inhourl2, $t4inminl2, $t4inampml2, $t4outhourl2, $t4outminl2, $t4outampml2, $t4inlunch2, $t4outlunch2, $t4sick_h, $t4sick_m, $t4v_h, $t4v_m, $advancedcheck, $lunch, $paid_lunch1, $paid_lunch2, $hour_rate, $overtime, $overtime_pay);
			if ($ans_timet4 === false) {
				$this->param['error'] = 'Please check your input';
				return $this->param;
			} else {
				$this->param['ans_arrt4'] = $ans_timet4[0];
				$this->param['ansl1_arrt4'] = $ans_timet4[1];
				$this->param['ansl21_arrt4'] = $ans_timet4[2];
				$this->param['ansl2_arrt4'] = $ans_timet4[3];
				$this->param['overall_timet4'] = $ans_timet4[4];
				$this->param['regular_timet4'] = $ans_timet4[5];
				$this->param['overtime2_firstt4'] = $ans_timet4[6];
				$this->param['overtime3_firstt4'] = $ans_timet4[7];
				$this->param['sick_payt4'] = $ans_timet4[8];
				$this->param['sick_timet4'] = $ans_timet4[9];
				$this->param['vacation_payt4'] = $ans_timet4[10];
				$this->param['v_timet4'] = $ans_timet4[11];
				$this->param['overtime4_firstt4'] = $ans_timet4[12];
				$this->param['overtime5_firstt4'] = $ans_timet4[13];
				$this->param['overtime6_firstt4'] = $ans_timet4[14];
				if ($selection2 == "1") {
					$dayst4 = ["1", "2", "3", "4", "5", "6", "7"];
				} elseif ($selection2 == "2") {
					$dayst4 = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"];
				} elseif ($selection2 == "3") {
					$dayst4 = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
				} elseif ($selection2 == "4") {
					$dayst4 = ["M", "T", "W", "T", "F", "S", "S"];
				} elseif ($selection2 == "5") {
					$dayst4 = ["Mo", "Tu", "We", "Th", "Fr", "Sa", "Su"];
				}
				$fromt4 = date('M d, Y', strtotime($s4_date));
				$tot4 = date('M d, Y', strtotime($e4_date));
				if (strtotime($s4_date) > strtotime($e4_date)) {
					$newt4 = $fromt4;
					$fromt4 = $tot4;
					$tot4 = $newt4;
				}
				$this->param['fromt4'] = $fromt4;
				$this->param['tot4'] = $tot4;
				$this->param['dayst4'] = $dayst4;
			}
		}
		$this->param['table_selection'] = $table_selection;
		$this->param['RESULT'] = 1;
		// dd($this->param);
		return $this->param;
	}

    // Time Span Calculator
	public function timespan($request)
	{
		$clock_format = $request->clock_format;
		$s_hour       = $request->s_hour;
		$s_min        = $request->s_min;
		$s_sec        = $request->s_sec;
		$s_ampm       = $request->s_ampm;
		$e_hour       = $request->e_hour;
		$e_min        = $request->e_min;
		$e_sec        = $request->e_sec;
		$e_ampm       = $request->e_ampm;

		if (is_numeric($s_hour) && is_numeric($s_min) && is_numeric($s_sec) && is_numeric($e_hour) && is_numeric($e_min) && is_numeric($e_sec)) {
			if ($clock_format == 12) {
				// $first  = new Carbon($s_hour . ':' . $s_min . ':' . $s_sec . '' . $s_ampm);
				// $second = new Carbon($e_hour . ':' . $e_min . ':' . $e_sec . '' . $e_ampm);
				// $difference = $first->diff($second);
				
				   $s_hour  = str_pad($s_hour, 2, '0', STR_PAD_LEFT);
					$s_min   = str_pad($s_min, 2, '0', STR_PAD_LEFT);
					$s_sec   = str_pad($s_sec, 2, '0', STR_PAD_LEFT);
					$e_hour  = str_pad($e_hour, 2, '0', STR_PAD_LEFT);
					$e_min   = str_pad($e_min, 2, '0', STR_PAD_LEFT);
					$e_sec   = str_pad($e_sec, 2, '0', STR_PAD_LEFT);

					$startTime = Carbon::createFromFormat('h:i:sA', "$s_hour:$s_min:$s_sec$s_ampm");
					$endTime   = Carbon::createFromFormat('h:i:sA', "$e_hour:$e_min:$e_sec$e_ampm");
					$difference = $startTime->diff($endTime);

				if (isset($s_ampm) && isset($e_ampm)) {
					if ($s_ampm == 'pm' && $e_ampm == 'am') {
						$hours12 = '-' . $difference->h;
						$min12   = $difference->i;
						$sec12   = $difference->s;

						$hours21 = $difference->h;
						$min21   = $difference->i;
						$sec21   = $difference->s;
					} else if ($s_ampm == 'pm' && $e_ampm == 'pm') {
						if ($s_hour > $e_hour) {
							$hours12 = '-' . $difference->h;
							$min12   = $difference->i;
							$sec12   = $difference->s;

							$hours21 = $difference->h;
							$min21   = $difference->i;
							$sec21   = $difference->s;
						} else {
							$hours12 = $difference->h;
							$min12   = $difference->i;
							$sec12   = $difference->s;

							$hours21 = '-' . $difference->h;
							$min21   = $difference->i;
							$sec21   = $difference->s;
						}
					} else if ($s_ampm == 'am' && $e_ampm == 'am') {
						if ($s_hour < $e_hour) {
							$hours12 = '-' . $difference->h;
							$min12   = $difference->i;
							$sec12   = $difference->s;

							$hours21 = $difference->h;
							$min21   = $difference->i;
							$sec21   = $difference->s;
						} else {
							$hours12 = $difference->h;
							$min12   = $difference->i;
							$sec12   = $difference->s;

							$hours21 = '-' . $difference->h;
							$min21   = $difference->i;
							$sec21   = $difference->s;
						}
					} else {
						$hours12 = $difference->h;
						$min12   = $difference->i;
						$sec12   = $difference->s;

						$hours21 = '-' . $difference->h;
						$min21   = $difference->i;
						$sec21   = $difference->s;
					}
				} else {
					$this->param['error'] = 'Please! Check Your Input';
					return $this->param;
				}


			} else {
				$first  = new Carbon($s_hour . ':' . $s_min . ':' . $s_sec);
				$second = new Carbon($e_hour . ':' . $e_min . ':' . $e_sec);
				$difference = $first->diff($second);

				if ($s_hour < $e_hour) {
					$hours12 = '-' . $difference->h;
					$min12   = $difference->i;
					$sec12   = $difference->s;

					$hours21 = $difference->h;
					$min21   = $difference->i;
					$sec21   = $difference->s;
				} else {
					$hours12 = $difference->h;
					$min12   = $difference->i;
					$sec12   = $difference->s;

					$hours21 = '-' . $difference->h;
					$min21   = $difference->i;
					$sec21   = $difference->s;
				}
			}

			if ($hours12 < 0) {
				$new_hours12 = abs($hours12);

				$over_night12    = (86400 - ($new_hours12 * 3600) + ($min12 * 60) + $sec12);
				$over_night12_h  = $over_night12 / 3600;
				$over_night12_m  = $over_night12 / 60;
				$over_night12_s  = $over_night12;

				$midnight_hours12 = explode('.', $over_night12_h)[0];
				$midnight_min12   = explode('.', $over_night12_m)[0] - ($midnight_hours12 * 60);
				$midnight_sec12   = ($over_night12_s - ($midnight_hours12 * 3600) - ($midnight_min12 * 60));
			} else {
				$over_night12    = (86400 + ($hours12 * 3600) + ($min12 * 60) + $sec12);
				$over_night12_h  = $over_night12 / 3600;
				$over_night12_m  = $over_night12 / 60;
				$over_night12_s  = $over_night12;

				$midnight_hours12 = explode('.', $over_night12_h)[0];
				$midnight_min12   = explode('.', $over_night12_m)[0] - ($midnight_hours12 * 60);
				$midnight_sec12   = ($over_night12_s - ($midnight_hours12 * 3600) - ($midnight_min12 * 60));
			}

			if ($hours21 < 0) {
				$new_hours21 = abs($hours21);

				$over_night21    = (86400 - ($new_hours21 * 3600) + ($min21 * 60) + $sec21);
				$over_night21_h  = $over_night21 / 3600;
				$over_night21_m  = $over_night21 / 60;
				$over_night21_s  = $over_night21;

				$midnight_hours21 = explode('.', $over_night21_h)[0];
				$midnight_min21   = explode('.', $over_night21_m)[0] - ($midnight_hours21 * 60);
				$midnight_sec21   = ($over_night21_s - ($midnight_hours21 * 3600) - ($midnight_min21 * 60));
			} else {
				$over_night21    = (86400 + ($hours21 * 3600) + ($min21 * 60) + $sec21);
				$over_night21_h  = $over_night21 / 3600;
				$over_night21_m  = $over_night21 / 60;
				$over_night21_s  = $over_night21;

				$midnight_hours21 = explode('.', $over_night21_h)[0];
				$midnight_min21   = explode('.', $over_night21_m)[0] - ($midnight_hours21 * 60);
				$midnight_sec21   = ($over_night21_s - ($midnight_hours21 * 3600) - ($midnight_min21 * 60));
			}

			$first_to_second            = sprintf("%02d", $hours12) . ':' . sprintf("%02d", $min12) . ':' . sprintf("%02d", $sec12);
			$first_to_second_over_night = sprintf("%02d", $midnight_hours12) . ':' . sprintf("%02d", $midnight_min12) . ':' . sprintf("%02d", $midnight_sec12);
			$second_to_first            = sprintf("%02d", $hours21) . ':' . sprintf("%02d", $min21) . ':' . sprintf("%02d", $sec21);
			$second_to_first_over_night = sprintf("%02d", $midnight_hours21) . ':' . sprintf("%02d", $midnight_min21) . ':' . sprintf("%02d", $midnight_sec21);

			$this->param['first_to_second']            = $first_to_second;
			$this->param['first_to_second_over_night'] = $first_to_second_over_night;
			$this->param['second_to_first']            = $second_to_first;
			$this->param['second_to_first_over_night'] = $second_to_first_over_night;
			$this->param['RESULT'] = 1;
			return $this->param;
		} else {
			$this->param['error'] = 'Please! Check Your Input';
			return $this->param;
		}
	}

    // Time Duration Calculator
    public function time_duration($request)
    {
        // Time calculator fields
        $t_start_h = trim($request->t_start_h);
        $t_start_m = trim($request->t_start_m);
        $t_start_s = trim($request->t_start_s);
        $t_start_ampm = trim($request->t_start_ampm);
        $t_end_h = trim($request->t_end_h);
        $t_end_m = trim($request->t_end_m);
        $t_end_s = trim($request->t_end_s);
        $t_end_ampm = trim($request->t_end_ampm);

        // Date calculator fields
        $start_date = trim($request->start_date);
        $end_date = trim($request->end_date);
        $d_start_h = trim($request->d_start_h);
        $d_start_m = trim($request->d_start_m);
        $d_start_s = trim($request->d_start_s);
        $d_start_ampm = trim($request->d_start_ampm);
        $d_end_h = trim($request->d_end_h);
        $d_end_m = trim($request->d_end_m);
        $d_end_s = trim($request->d_end_s);
        $d_end_ampm = trim($request->d_end_ampm);

        $calculator_time = trim($request->calculator_time);

        if ($calculator_time == "time_cal") {
            // Validate time calculator inputs
            if ($t_start_h > 23 || $t_start_h < 0) {
                $this->param['error'] = 'Please enter a valid Start Hour (0-23).';
                return $this->param;
            }
            if ($t_end_h > 23 || $t_end_h < 0) {
                $this->param['error'] = 'Please enter a valid End Hour (0-23).';
                return $this->param;
            }
            if ($t_start_m > 59 || $t_start_m < 0 || $t_start_m === "") {
                $this->param['error'] = 'Please enter a valid Start Minute (0-59).';
                return $this->param;
            }
            if ($t_end_m > 59 || $t_end_m < 0 || $t_end_m === "") {
                $this->param['error'] = 'Please enter a valid End Minute (0-59).';
                return $this->param;
            }
            if ($t_start_s > 59 || $t_start_s < 0 || $t_start_s === "") {
                $this->param['error'] = 'Please enter a valid Start Second (0-59).';
                return $this->param;
            }
            if ($t_end_s > 59 || $t_end_s < 0 || $t_end_s === "") {
                $this->param['error'] = 'Please enter a valid End Second (0-59).';
                return $this->param;
            }

            // Format time values
            $t_start_h = sprintf("%02d", $t_start_h);
            $t_start_m = sprintf("%02d", $t_start_m);
            $t_start_s = sprintf("%02d", $t_start_s);

            // Handle AM/PM conversion if hour is <= 12
            if ($t_start_h <= 12) {
                $start_time = $t_start_h . ":" . $t_start_m . ":" . $t_start_s . " " . $t_start_ampm;
                $start_time_res = date('H:i:s', strtotime($start_time));
            } else {
                $start_time_res = $t_start_h . ":" . $t_start_m . ":" . $t_start_s;
            }

            $t_end_h = sprintf("%02d", $t_end_h);
            $t_end_m = sprintf("%02d", $t_end_m);
            $t_end_s = sprintf("%02d", $t_end_s);

            if ($t_end_h <= 12) {
                $end_time = $t_end_h . ":" . $t_end_m . ":" . $t_end_s . " " . $t_end_ampm;
                $end_time_res = date('H:i:s', strtotime($end_time));
            } else {
                $end_time_res = $t_end_h . ":" . $t_end_m . ":" . $t_end_s;
            }

            // Determine if we need to add a day (for overnight calculations)
            $start_unit = date('a', strtotime($start_time_res));
            $end_unit = date('a', strtotime($end_time_res));
            $day = ($start_unit === $end_unit) ? "15" : "14";

            $start_time_res = new Carbon("2006-04-14 " . $start_time_res);
            $end_time_res = new Carbon("2006-04-" . $day . " " . $end_time_res);
            $days_ans = 0;
        } else {
            // Validate date calculator inputs
            if ($d_start_h > 23 || $d_start_h < 0) {
                $this->param['error'] = 'Please enter a valid Start Hour (0-23).';
                return $this->param;
            }
            if ($d_end_h > 23 || $d_end_h < 0) {
                $this->param['error'] = 'Please enter a valid End Hour (0-23).';
                return $this->param;
            }
            if ($d_start_m > 59 || $d_start_m < 0 || $d_start_m === "") {
                $this->param['error'] = 'Please enter a valid Start Minute (0-59).';
                return $this->param;
            }
            if ($d_end_m > 59 || $d_end_m < 0 || $d_end_m === "") {
                $this->param['error'] = 'Please enter a valid End Minute (0-59).';
                return $this->param;
            }
            if ($d_start_s > 59 || $d_start_s < 0 || $d_start_s === "") {
                $this->param['error'] = 'Please enter a valid Start Second (0-59).';
                return $this->param;
            }
            if ($d_end_s > 59 || $d_end_s < 0 || $d_end_s === "") {
                $this->param['error'] = 'Please enter a valid End Second (0-59).';
                return $this->param;
            }

            // Format date calculator time values
            $d_start_h = sprintf("%02d", $d_start_h);
            $d_start_m = sprintf("%02d", $d_start_m);
            $d_start_s = sprintf("%02d", $d_start_s);

            if ($d_start_h <= 12) {
                $start_time = $d_start_h . ":" . $d_start_m . ":" . $d_start_s . " " . $d_start_ampm;
                $start_time_res = date('H:i:s', strtotime($start_time));
            } else {
                $start_time_res = $d_start_h . ":" . $d_start_m . ":" . $d_start_s;
            }

            $d_end_h = sprintf("%02d", $d_end_h);
            $d_end_m = sprintf("%02d", $d_end_m);
            $d_end_s = sprintf("%02d", $d_end_s);

            if ($d_end_h <= 12) {
                $end_time = $d_end_h . ":" . $d_end_m . ":" . $d_end_s . " " . $d_end_ampm;
                $end_time_res = date('H:i:s', strtotime($end_time));
            } else {
                $end_time_res = $d_end_h . ":" . $d_end_m . ":" . $d_end_s;
            }

            // Create Carbon instances for date calculations
            $start_time_res = new Carbon($start_date . " " . $start_time_res);
            $end_time_res = new Carbon($end_date . " " . $end_time_res);
            
            // Calculate full days difference
            $dStart = new Carbon($start_date);
            $dEnd = new Carbon($end_date);
            $dDiff = $dStart->diff($dEnd);
            $days_ans = $dDiff->days;
        }

        // Calculate the duration difference
        $duration = $start_time_res->diff($end_time_res);
        $hours = $duration->format('%H');
        $minutes = $duration->format('%I');
        $seconds = $duration->format('%S');

        // Calculate totals in different units
        $total_days = round(($hours / 24) + ($minutes / 1440) + ($seconds / 86400) + $days_ans, 2);
        $total_hours = round($hours + ($minutes / 60) + ($seconds / 3600) + ($days_ans * 24), 2);
        $total_minutes = round(($hours * 60) + $minutes + ($seconds / 60) + ($days_ans * 1440), 2);
        $total_seconds = round(($hours * 3600) + ($minutes * 60) + $seconds + ($days_ans * 86400), 2);

        // Set results
        $this->param['days_ans'] = $days_ans;
        $this->param['hours'] = $hours;
        $this->param['minutes'] = $minutes;
        $this->param['seconds'] = $seconds;
        $this->param['total_days'] = $total_days;
        $this->param['total_hours'] = $total_hours;
        $this->param['total_minutes'] = $total_minutes;
        $this->param['total_seconds'] = $total_seconds;
        $this->param['calculator_time'] = $calculator_time;
        $this->param['RESULT'] = 1;

        return $this->param;
    }

    // Add Time Calculator
	public function add($request)
	{
		// Helper function for milliseconds conversion
		function convertMilliseconds($milliseconds) {
			$seconds = 0;
			$minutes = 0;
			$hours   = 0;

			if ($milliseconds >= 1000) {
				$seconds += floor($milliseconds / 1000);
				$milliseconds %= 1000;
			}
			if ($seconds >= 60) {
				$minutes += floor($seconds / 60);
				$seconds %= 60;
			}
			if ($minutes >= 60) {
				$hours += floor($minutes / 60);
				$minutes %= 60;
			}

			return [$hours, $minutes, $seconds, $milliseconds];
		}

		$checkbox1 = $request->hours_check ?? false;
		$checkbox2 = $request->min_check ?? false;
		$checkbox3 = $request->sec_check ?? false;
		$checkbox4 = $request->milli_check ?? false;

		$rows = $request->rows ?? [];
		$count_val = count($rows);

		// Initialize totals
		$time_hour        = 0;
		$time_minutes     = 0;
		$time_seconds     = 0;
		$time_miliseconds = 0;

		$hour_list = [];
		$min_list  = [];
		$sec_list  = [];
		$mili_list = [];

		foreach ($rows as $row) {
			$h  = ($checkbox1 && $row['inhour']        !== "") ? (int) $row['inhour']        : 0;
			$m  = ($checkbox2 && $row['inminutes']     !== "") ? (int) $row['inminutes']     : 0;
			$s  = ($checkbox3 && $row['inseconds']     !== "") ? (int) $row['inseconds']     : 0;
			$ms = ($checkbox4 && $row['inmiliseconds'] !== "") ? (int) $row['inmiliseconds'] : 0;

			if (!is_numeric($h) || !is_numeric($m) || !is_numeric($s) || !is_numeric($ms)) {
				return ['error' => 'Please! Check Your Input'];
			}

			$time_hour        += $h;
			$time_minutes     += $m;
			$time_seconds     += $s;
			$time_miliseconds += $ms;

			$hour_list[] = $h;
			$min_list[]  = $m;
			$sec_list[]  = $s;
			$mili_list[] = $ms;
		}

		// Convert milliseconds overflow
		list($hours, $minutes, $seconds, $remainingMilliseconds) = convertMilliseconds($time_miliseconds);
		$time_hour += $hours;
		$time_minutes += $minutes;
		$time_seconds += $seconds;
		$time_miliseconds = $remainingMilliseconds;

		// Adjust minutes overflow
		if ($time_minutes >= 60) {
			$time_hour += floor($time_minutes / 60);
			$time_minutes %= 60;
		}

		// Adjust seconds overflow
		if ($time_seconds >= 60) {
			$time_minutes += floor($time_seconds / 60);
			$time_seconds %= 60;
			if ($time_minutes >= 60) {
				$time_hour += floor($time_minutes / 60);
				$time_minutes %= 60;
			}
		}

		// ✅ If checkbox is unchecked, force total to 0
		if (!$checkbox1) $time_hour = 0;
		if (!$checkbox2) $time_minutes = 0;
		if (!$checkbox3) $time_seconds = 0;
		if (!$checkbox4) $time_miliseconds = 0;

		return [
			'hour_list'        => $hour_list,
			'min_list'         => $min_list,
			'sec_list'         => $sec_list,
			'mili_list'        => $mili_list,
			'time_hour'        => $time_hour,
			'time_minutes'     => $time_minutes,
			'time_seconds'     => $time_seconds,
			'time_miliseconds' => $time_miliseconds,
			'RESULT'           => 1
		];
	}


    // Lead Time Calculator
    public function lead($request)
    {
		$type = trim($request->type);
		$pre_time = trim($request->pre_time);
		$pre_units = trim($request->pre_units);
		$p_time = trim($request->p_time);
		$p_units = trim($request->p_units);
		$post_time = trim($request->post_time);
		$post_units = trim($request->post_units);
		$place_time = trim($request->place_time);
		$receive_time = trim($request->receive_time);
		$s_delay = trim($request->s_delay);
		$supply_units = trim($request->supply_units);
		$r_delay = trim($request->r_delay);
		$r_units = trim($request->r_units);
       
		function convertToHoursMins1($time, $format = '%02d Hours %02d Minutes') {
			if ($time < 1) {
				return;
			}
			$hours = floor($time / 60);
			$minutes = ($time % 60);
			return sprintf($format, $hours, $minutes);
		}
		function convert($first_value,$units){
			if ($units == 'sec' ) {
				$first_value = $first_value / 86400;
			}else if ($units == 'min' ) {
				$first_value = $first_value / 1440;
			}else if ($units == 'hrs' ) {
				$first_value = $first_value / 24;
			}else if ($units == 'wks' ) {
				$first_value = $first_value * 7;
			}else if ($units == 'mos' ) {
				$first_value = $first_value * 30.417;
			}else if ($units == 'yrs' ) {
				$first_value = $first_value * 365;
			}
			return $first_value;
		}
        if (!empty($type) ) {
			if($type == 'manufac'){
				if(is_numeric($pre_time) && is_numeric($p_time) && is_numeric($post_time)){
					if(isset($pre_units) ) {
						$pre_time = convert($pre_time,$pre_units);
					} 
					if(isset($p_units) ) {
						$p_time = convert($p_time,$p_units);
					}
					if(isset($post_units) ) {
						$post_time = convert($post_time,$post_units);
					}
					$manufac = $pre_time + $p_time + $post_time;	
				}
				else {
					$this->param ['error'] = 'Please! Check Your Input' ;
					return $this->param;
				}
			}
			else if($type == 'order'){
				if(!empty($place_time) && !empty($receive_time)){
					$from_time = strtotime($place_time); 
					$to_time = strtotime($receive_time); 
					$diff_minutes = round(abs($from_time - $to_time) / 60);
					$timeDiff = convertToHoursMins1($diff_minutes);
					// dd($diff_minutes);
				}
				else {
					$this->param ['error'] = 'Please! Check Your Input' ;
					return $this->param;
				}
			}
			else if($type == 'supply'){
				if(is_numeric($s_delay) && is_numeric($r_delay)){
					if(isset($supply_units) ) {
						$s_delay = convert($s_delay,$supply_units);
					}
					if(isset($r_units) ) {
						$r_delay = convert($r_delay,$r_units);
					}
					$supply = $s_delay + $r_delay;
				}
				else {
					$this->param ['error'] = 'Please! Check Your Input' ;
					return $this->param;
				}
			}
			else {
				$this->param ['error'] = 'Please! Check Your Input' ;
				return $this->param;
			}
        } 
		else {
            $this->param ['error'] = 'Please! Check Your Input' ;
            return $this->param;
        }
		$this->param[ 'type' ] = $type;  
		if($type == 'manufac'){
			$this->param[ 'pre_time' ] = $pre_time;   
			$this->param[ 'p_time' ] = $p_time;   
			$this->param[ 'post_time' ] = $post_time;
			$this->param[ 'manufac' ] = $manufac;   
		}else if($type == 'order'){
			$this->param[ 'timeDiff' ] = $timeDiff;   
			$this->param[ 'diff_minutes' ] = $diff_minutes;   
		}else if($type == 'supply'){
			$this->param[ 's_delay' ] = $s_delay;   
			$this->param[ 'r_delay' ] = $r_delay; 
			$this->param[ 'supply' ] = $supply;   
		}
		$this->param[ 'RESULT' ] = 1;
		// dd($this->param);
		return $this->param;
    }

    // militry time
    public function military_time($request)
	{
		$conversion = trim($request->conversion);
		$military_time = trim($request->military_time);
		$hours = trim($request->hours);
		$hur = trim($request->hur);
		$min = trim($request->min);
		$am_pm = trim($request->am_pm);
		function eng_time($num)
		{
			$reading = [
				"zero ",
				"one ",
				"two ",
				"three ",
				"four ",
				"five ",
				"six ",
				"seven ",
				"eight ",
				"nine ",
				"ten ",
				"eleven ",
				"twelve ",
				"thirteen ",
				"fourteen ",
				"fifteen ",
				"sixteen ",
				"seventeen ",
				"eighteen ",
				"nineteen ",
				"twenty ",
				"twenty-one ",
				"twenty-two ",
				"twenty-three "
			];
			$prefix = [
				2 => "twenty",
				3 => "thirty",
				4 => "forty",
				5 => "fifty"
			];
			// for hours
			$f_two = substr($num, 0, 2);
			$zain = substr($f_two, 1);
			if ($f_two <= 9) {
				$hr = "zero " . $reading[$zain];
			} else {
				if ($f_two <= 23) {
					$hr = $reading[$f_two];
				} else {
					$f_alphabet = mb_substr($f_two, 0, 1);
					$l_alphabet = mb_substr($f_two, -1, 1);
					$hr = $prefix[$f_alphabet] . "-" . $reading[$l_alphabet];
				}
			}
			// for minutes
			$l_two = substr($num, -2, 2);
			$zain2 = substr($l_two, 1);
			if ($l_two <= 9) {
				$min = "zero " . $reading[$zain2];
			} else {
				if ($l_two <= 23) {
					$min = $reading[$l_two];
				} else {
					$f_alphabet_min = mb_substr($l_two, 0, 1);
					$l_alphabet_min = mb_substr($l_two, -1, 1);
					$min = $prefix[$f_alphabet_min] . "-" . $reading[$l_alphabet_min];
				}
			}
			$jawab = $hr . $min;
			return ($jawab);
		}
		if ($conversion === "1") {
			if (is_numeric($military_time)) {
				if (((int)substr($military_time, 0, 2)) < 0 || ((int)substr($military_time, 0, 2)) >= 24 || ((int)substr($military_time, -2, 2)) < 0 || ((int)substr($military_time, -2, 2)) >= 60) {
					$this->param['error'] = 'Please! Check Your Input';
					return $this->param;
				}
				$f_two = substr($military_time, 0, 2);
				$l_two = substr($military_time, -2, 2);
				// answers
				$chubees_ghante = $f_two . ":" . $l_two;
				$bara_ghante  = date("g:i a", strtotime($chubees_ghante));
				$military_time = $military_time;
				$eng_word = eng_time($military_time);
			} else {
				$this->param['error'] = 'Please! Check Your Input';
				
				return $this->param;
			}
		}
		 elseif ($conversion === "2") {
			if (is_numeric($hur) && is_numeric($min)) {
				if ($hours === "24h") {
					$hur = sprintf("%02d", $hur);
					$min = sprintf("%02d", $min);
					$time = $hur . $min;
					// answers
					$chubees_ghante = $hur . ":" . $min;
					$bara_ghante  = date("g:i a", strtotime($chubees_ghante));
					$military_time = $time;
					$eng_word = eng_time($military_time);
				} elseif ($hours === "12h") {
					$hur = sprintf("%02d", $hur);
					$min = sprintf("%02d", $min);
					$time = $hur . ':' . $min . ' ' . $am_pm;
					// answers
					$bara_ghante  = $time;
					$hrs_ans  = date("H", strtotime($bara_ghante));
					$min_ans  = date("i", strtotime($bara_ghante));
					$chubees_ghante = $hrs_ans . ":" . $min_ans;
					$military_time = $hrs_ans . $min_ans;
					$eng_word = eng_time($military_time);
				}
			} else {
				$this->param['error'] = 'Please! Check Your Input';
				return $this->param;
			}
		}
		$this->param['bara_ghante'] = $bara_ghante;
		$this->param['chubees_ghante'] = $chubees_ghante;
		$this->param['military_time'] = $military_time;
		$this->param['eng_word'] = $eng_word;
		$this->param['RESULT'] = 1;
		// dd($this->param);
		return $this->param;
	}

     // elapsed-time-calculator
	public function elapsed($request)
	{
		$main_units = trim($request->main_units);
		$elapsed_start = trim($request->elapsed_start);
		$elapsed_start_one = trim($request->elapsed_start_one);
		$elapsed_start_sec = trim($request->elapsed_start_sec);
		$elapsed_start_three = trim($request->elapsed_start_three);
		$elapsed_start_unit = trim($request->elapsed_start_unit);
		$elapsed_end = trim($request->elapsed_end);
		$elapsed_end_one = trim($request->elapsed_end_one);
		$elapsed_end_sec = trim($request->elapsed_end_sec);
		$elapsed_end_three = trim($request->elapsed_end_three);
		$elapsed_end_unit = trim($request->elapsed_end_unit);
		$clock_format = trim($request->clock_format);
		$clock_hour = trim($request->clock_hour);
		$clock_minute = trim($request->clock_minute);
		$clock_second = trim($request->clock_second);
		$clock_start_unit = trim($request->clock_start_unit);
		$clock_hur = trim($request->clock_hur);
		$clock_mints = trim($request->clock_mints);
		$clock_secs = trim($request->clock_secs);
		$clock_end_unit = trim($request->clock_end_unit);
		function time_unit($elapsed_start, $elapsed_start_unit)
		{
			if ($elapsed_start_unit == "sec") {
				$elapsed_start = $elapsed_start;
			} elseif ($elapsed_start_unit == "mins") {
				$elapsed_start = $elapsed_start * 60;
			} elseif ($elapsed_start_unit == "hrs") {
				$elapsed_start = $elapsed_start * 3600;
			}
			return $elapsed_start;
		}
		function other_time($elapsed_start_one, $elapsed_start_sec, $elapsed_start_unit)
		{
			if ($elapsed_start_unit === "mins/sec") {
				$interval = ($elapsed_start_one * 60) + $elapsed_start_sec;
			} elseif ($elapsed_start_unit === "hrs/mins") {
				$interval = ($elapsed_start_one *  3600) + ($elapsed_start_sec * 60);
			}
			return $interval;
		}
		function other_time_sec($elapsed_start_one, $elapsed_start_sec, $elapsed_start_three, $elapsed_start_unit)
		{
			if ($elapsed_start_unit === "hrs/mins/sec") {
				$interval = ($elapsed_start_one *  3600) + ($elapsed_start_sec * 60) + $elapsed_start_three;
			}
			return $interval;
		}
		if ($main_units === 'elapsed') {
			if (is_numeric($elapsed_start) && is_numeric($elapsed_start_one) && is_numeric($elapsed_start_sec)  && is_numeric($elapsed_start_three) && is_numeric($elapsed_end) && is_numeric($elapsed_end_one) && is_numeric($elapsed_end_sec) && is_numeric($elapsed_end_three)) {
				if ($elapsed_start_unit === 'sec' || $elapsed_start_unit === 'mins'  || $elapsed_start_unit === 'hrs') {
					$elapsed_start = time_unit($elapsed_start, $elapsed_start_unit);
				
				} elseif ($elapsed_start_unit === "hrs/mins/sec") {
					$elapsed_start = other_time_sec($elapsed_start_one, $elapsed_start_sec, $elapsed_start_three, $elapsed_start_unit);
				} else {
					$elapsed_start = other_time($elapsed_start_one, $elapsed_start_sec, $elapsed_start_unit);
					
				}
				if ($elapsed_end_unit === 'sec' || $elapsed_end_unit === 'mins'  || $elapsed_end_unit === 'hrs') {
					$elapsed_end = time_unit($elapsed_end, $elapsed_end_unit);
				} elseif ($elapsed_end_unit === "hrs/mins/sec") {
					$elapsed_end = other_time_sec($elapsed_end_one, $elapsed_end_sec, $elapsed_end_three, $elapsed_end_unit);
				} else {
					$elapsed_end = other_time($elapsed_end_one, $elapsed_end_sec, $elapsed_end_unit);
				}
				if ($elapsed_end < $elapsed_start) {
					$this->param['error'] = 'the end time should be greater than the start time';
					return $this->param;
				}
					 $elapsed_start = (int)$elapsed_start;
					 $elapsed_end = (int)$elapsed_end;
				
				$timeelapsed_start = new Carbon($elapsed_start);
				$timeelapsed_end = new Carbon($elapsed_end);
				$diff = $timeelapsed_end->diff($timeelapsed_start);
				$hours = $diff->h;
				$minutes = $diff->i;
				$seconds = $diff->s;

				$answer = $elapsed_end - $elapsed_start;
				$this->param['answer'] = $answer;
				$this->param['hours'] = $hours;
				$this->param['minutes'] = $minutes;
				$this->param['seconds'] = $seconds;
			} else {
				$this->param['error'] = 'Please! Check Your Input';
				return $this->param;
			}
		} else {
			if ($clock_format == "24") {
				if (is_numeric($clock_hour) && is_numeric($clock_minute) && is_numeric($clock_second) && is_numeric($clock_hur) && is_numeric($clock_mints) && is_numeric($clock_secs)) {
					if ($clock_hour > $clock_hur) {
						$this->param['error'] = 'End time must be later than start time.';
						return $this->param;
					}
					if ($clock_hour >= 24) {
						$this->param['error'] = 'Start time hour must be less than 24.';
						return $this->param;
					}
					if ($clock_minute >= 60) {
						$this->param['error'] = 'Start time minute must be less than 60.';
						return $this->param;
					}
					if ($clock_second >= 60) {
						$this->param['error'] = 'Start time second must be less than 60.';
						return $this->param;
					}
					if ($clock_hur >= 24) {
						$this->param['error'] = 'End time hour must be less than 24.';
						return $this->param;
					}
					if ($clock_mints >= 60) {
						$this->param['error'] = 'End time minute must be less than 60.';
						return $this->param;
					}
					if ($clock_secs >= 60) {
						$this->param['error'] = 'End time second must be less than 60.';
						return $this->param;
					}
					
					$start_clock = ($clock_hour * 3600) + ($clock_minute * 60) + ($clock_second);
					$end_clock = ($clock_hur * 3600) + ($clock_mints * 60) + ($clock_secs);
					$answer = $end_clock - $start_clock;

					$timeelapsed_start = new Carbon($start_clock);
					$timeelapsed_end = new Carbon($end_clock);
					$diff = $timeelapsed_end->diff($timeelapsed_start);
					$hours = $diff->h;
					$minutes = $diff->i;
					$seconds = $diff->s;
				} else {
					$this->param['error'] = 'Please! Check Your Input';
					return $this->param;
				}
			} else {
				if (is_numeric($clock_hour) && is_numeric($clock_minute) && is_numeric($clock_second) && is_numeric($clock_hur) && is_numeric($clock_mints) && is_numeric($clock_secs)) {
					if ($clock_hour >= 12) {
						$this->param['error'] =  'start clock time hour should be less than 12';
						return $this->param;
					}
					if ($clock_minute >= 60) {
						$this->param['error'] =  'start clock minute hour should be less than 60';
						return $this->param;
					}
					if ($clock_second >= 60) {
						$this->param['error'] =  'start clock time second should be less than 60';
						return $this->param;
					}
					if ($clock_hur >= 12) {
						$this->param['error'] =  'end clock time hour should be less than 12';
						return $this->param;
					}
					if ($clock_mints >= 60) {
						$this->param['error'] =  'end clock minute hour should be less than 60';
						return $this->param;
					}
					if ($clock_secs >= 60) {
						$this->param['error'] =  'end clock time second should be less than 60';
						return $this->param;
					}

					// Convert 12-hour format to 24-hour format
					if ($clock_start_unit == 'PM' && $clock_hour != 12) {
						$clock_hour += 12;
					}

					if ($clock_end_unit == 'PM' && $clock_hur != 12) {
						$clock_hur += 12;
					}

					// Calculate the duration in seconds
					$start_time = strtotime("$clock_hour:$clock_minute:$clock_second");
					$end_time = strtotime("$clock_hur:$clock_mints:$clock_secs");
					$answer = $end_time - $start_time;

					$timeelapsed_start = new Carbon($start_time);
					$timeelapsed_end = new Carbon($end_time);
					$diff = $timeelapsed_end->diff($timeelapsed_start);
					$hours = $diff->h;
					$minutes = $diff->i;
					$seconds = $diff->s;
					// Handle negative answer (PM to AM)
					if ($answer < 0) {
						$answer += 24 * 60 * 60; // Add 24 hours in seconds
					}
				} else {
					$this->param['error'] = 'Please! Check Your Input';
					return $this->param;
				}
			}
		}
		$this->param['hours'] = $hours;
		$this->param['minutes'] = $minutes;
		$this->param['seconds'] = $seconds;
		$this->param['answer'] = $answer;
		$this->param['RESULT'] = 1;
		return $this->param;
	}


    // Date Calculator
	public function date($request)
	{
			$add_date = $request->add_date;
			$method = $request->method;
			$years = $request->years;
			$months = $request->months;
			$weeks = $request->weeks;
			$days = $request->days;
			$repeat = $request->repeat;
			$add_hrs_f = $request->add_hrs_f;
			$add_min_f = $request->add_min_f;
			$add_sec_f = $request->add_sec_f;
			$add_hrs_s = $request->add_hrs_s;
			$add_min_s = $request->add_min_s;
			$add_sec_s = $request->add_sec_s;
			if ($add_date !== "" && $method !== "") {
				$s_date = $add_date; // mmm,dd,yyyy
				$s_date = explode("-", $s_date);
				$date = "$s_date[0]-$s_date[1]-$s_date[2]";
				if (empty($days)) {
					$days = 0;
				}
				if (empty($weeks)) {
					$weeks = 0;
				}
				if (empty($months)) {
					$months = 0;
				}
				if (empty($years)) {
					$years = 0;
				}
				if (empty($repeat)) {
					$repeat = "1";
				}
				if (is_numeric($add_hrs_f) || is_numeric($add_min_f) || is_numeric($add_sec_f) || is_numeric($add_hrs_s) || is_numeric($add_min_s) || is_numeric($add_sec_s)) {
					if (empty($add_hrs_f)) {
						$add_hrs_f = 0;
					}
					if (empty($add_min_f)) {
						$add_min_f = 0;
					}
					if (empty($add_sec_f)) {
						$add_sec_f = 0;
					}
					if (empty($add_hrs_s)) {
						$add_hrs_s = 0;
					}
					if (empty($add_min_s)) {
						$add_min_s = 0;
					}
					if (empty($add_sec_s)) {
						$add_sec_s = 0;
					}
					$date = $date . " " . sprintf('%02d', $add_hrs_f) . ":" . sprintf('%02d', $add_min_f) . ":" . sprintf('%02d', $add_sec_f);
					$this->param['from'] = date('l, M d, Y h:i:s A', strtotime($date));
					$this->param['add_hrs_f'] = sprintf('%02d', $add_hrs_f);
					$this->param['add_min_f'] = sprintf('%02d', $add_min_f);
					$this->param['add_sec_f'] = sprintf('%02d', $add_sec_f);
					$this->param['add_hrs_s'] = sprintf('%02d', $add_hrs_s);
					$this->param['add_min_s'] = sprintf('%02d', $add_min_s);
					$this->param['add_sec_s'] = sprintf('%02d', $add_sec_s);
					for ($i = 0; $i < $repeat; $i++) {
						if ($method === 'add') {
							$date = date('l, M d, Y h:i:s A', strtotime($date . ' + ' . $years . ' years' . ' + ' . $months . ' months' . ' + ' . $weeks . ' weeks' . ' + ' . $days . ' days' . ' + ' . $add_hrs_s . ' hours' . ' + ' . $add_min_s . ' minutes' . ' + ' . $add_sec_s . ' seconds'));
						} else {
							$date = date('l, M d, Y h:i:s A', strtotime($date . ' - ' . $years . ' years' . ' - ' . $months . ' months' . ' - ' . $weeks . ' weeks' . ' - ' . $days . ' days' . ' - ' . $add_hrs_s . ' hours' . ' - ' . $add_min_s . ' minutes' . ' - ' . $add_sec_s . ' seconds'));
						}
						$ans[] = $date;
					}
				} else {
					$this->param['from'] = date('l, M d, Y', strtotime($date));
					for ($i = 0; $i < $repeat; $i++) {
						if ($method === 'add') {
							$date = date('l, M d, Y', strtotime($date . ' + ' . $years . ' years' . ' + ' . $months . ' months' . ' + ' . $weeks . ' weeks' . ' + ' . $days . ' days'));
						} else {
							$date = date('l, M d, Y', strtotime($date . ' - ' . $years . ' years' . ' - ' . $months . ' months' . ' - ' . $weeks . ' weeks' . ' - ' . $days . ' days'));
						}
						$ans[] = $date;
					}
				}
				$this->param['method'] = $method;
				$this->param['years'] = sprintf('%02d', $years);
				$this->param['months'] = sprintf('%02d', $months);
				$this->param['weeks'] = sprintf('%02d', $weeks);
				$this->param['days'] = sprintf('%02d', $days);
				$this->param['ans'] = $ans;
				$this->param['repeat'] = $repeat;
				$this->param['RESULT'] = 1;
				// dd($this->param);
				return $this->param;
			} else {
				$this->param['error'] = 'Please! Check Your Input.';
				return $this->param;
			}
	}

    // Business Days caluclator
	public function business($request)
	{
		// dd($request);
			$submitt = $request->sim_adv;
			$end_inc = $request->end_inc;
			if($end_inc == true){
				$end_inc = true;
			}else{
				$end_inc = null;

			}
			$sat_inc = $request->sat_inc;
				if($sat_inc == true){
				$sat_inc = true;
			}else{
				$sat_inc = null;

			}
			$holiday_c = $request->holiday_c;
			$nyd = $request->nyd;
			$ind = $request->ind;
			$vetd = $request->vetd;
			$cheve = $request->cheve;
			$chirs = $request->chirs;
			$nye = $request->nye;
			$total_i = $request->total_i;
			$total_j = $request->total_j;
			// $d = $request->d;
			// $m = $request->m;
			// $n = $request->n;
			$blkf = $request->blkf;
			$thankd = $request->thankd;
			$cold = $request->cold;
			$labd = $request->labd;
			$mlkd = $request->mlkd;
			$psd = $request->psd;
			$memd = $request->memd;
			$ex_in = $request->ex_in;
			$satting = $request->satting;
			$sun = $request->sun;
			$mon = $request->mon;
			$tue = $request->tue;
			$wed = $request->wed;
			$thu = $request->thu;
			$fri = $request->fri;
			$sat = $request->sat;
			$cal_bus = $request->cal_bus;
			$weekend_c = $request->weekend_c;
			$method = $request->method;
			$years = $request->years;
			$months = $request->months;
			$days = $request->days;
			$weeks = $request->weeks;

			$s_date = $request->s_date;
			$add_date = $request->add_date;
			$e_date = $request->e_date;
			if($cal_bus == true){
				$cal_bus = true;
			}else{
				$cal_bus = null;

			}
			function getWorkdays($date1, $date2, $workSat = FALSE, $patron = '', $fix_holiday = '', $display = '', $display_repeat = '')
			{
				if (!defined('SATURDAY')) define('SATURDAY', 6);
				if (!defined('SUNDAY')) define('SUNDAY', 0);

				// Array of all public festivities
				$publicHolidays = array();
				// The Patron day (if any) is added to public festivities
				if ($patron) {
					$publicHolidays[] = $patron;
				}
				$holi_arr = array();
				if ($fix_holiday) {
					$holi_arr[] = $fix_holiday;
				}
				$start = strtotime($date1);
				$end = strtotime($date2);
				if (!isset($end_inc)) {
					$end = strtotime("-1 day", $end);
				}
				if ($start > $end) {
					$new = $start;
					$start = $end;
					$end = $new;
				}
				$workdays = 0;
				$weekend = 0;
				$holidays = 0;
				$get_holi = array();
				$dis_holi = array();
				$count = 0;
				for ($i = $start; $i <= $end; $i = strtotime("+1 day", $i)) {
					$day = date("w", $i);  // 0=sun, 1=mon, ..., 6=sat
					$mmgg = date('m-d', $i);
					$mg = date('l, M d, Y', $i);
					if (($day == SATURDAY && $workSat == FALSE) || $day == SUNDAY) {
						$weekend++;
					} elseif (in_array($mg, $holi_arr)) {
						$get_holi[] = $mg;
						$holidays++;
						$dis_holi[] = $display[$count];
						$count++;
					} elseif (in_array($mmgg, $publicHolidays)) {
						$holidays++;
						$get_holi[] = $mg;
						$c = array_search($mmgg, $publicHolidays, true);
						$dis_holi[] = $display_repeat[$c];
					} elseif (
						$day != SUNDAY &&
						!in_array($mmgg, $publicHolidays) &&
						!($day == SATURDAY && $workSat == FALSE)
					) {
						$workdays++;
					}
				}
				$getdays = array('workdays' => $workdays, 'weekend' => $weekend, 'holidays' => $holidays, 'get_holi' => $get_holi, 'dis_holi' => $dis_holi);
				return $getdays;
			}
			if ($submitt === 'simple') {
				if ($e_date) {
					if (isset($end_inc)) {
						$e_date = date('Y-m-d', strtotime("+1 day" . $e_date));
					}
					
					// $e_date = explode("-", $e_date);
					if (isset($sat_inc)) {
						$check_sat = true;
					} else {
						$check_sat = false;
					}
					if ($holiday_c == 'yes') {
						$all_holiday = array();
						$repeat_holiday = array();
						$display_holiday = array();
						$display_repeat = array();
						if (isset($nyd)) {
							$repeat_holiday[] = '01-01';
							$display_repeat[] = "New Year's Day";
						}
						if (isset($ind)) {
							$repeat_holiday[] = '07-04';
							$display_repeat[] = "Independence Day";
						}
						if (isset($vetd)) {
							$repeat_holiday[] = '11-11';
							$display_repeat[] = "Veteran's Day";
						}
						if (isset($cheve)) {
							$repeat_holiday[] = '12-24';
							$display_repeat[] = "Christmas Eve";
						}
						if (isset($chirs)) {
							$repeat_holiday[] = '12-25';
							$display_repeat[] = "Christmas";
						}
						if (isset($nye)) {
							$repeat_holiday[] = '12-31';
							$display_repeat[] = "New Year's Eve";
						}
						// for ($j = 0; $j <= $total_i; $j++) {
						// 	if (is_numeric($d . $j) && is_numeric($m . $j)) {
						// 		$repeat_holiday[] = $m . $j . '-' . $d . $j;
						// 		$display_repeat[] = $n . $j;
						// 	}
						// }
						// Process dynamic holidays
						for ($j = 0; $j <= $request->total_i; $j++) {
							$d = $request->{"d{$j}"} ?? null;
							$m = $request->{"m{$j}"} ?? null;
							$n = $request->{"n{$j}"} ?? null;
							
							if (is_numeric($d) && is_numeric($m) && !empty($n)) {
								// Pad single digit months/days with leading zero
								$m = str_pad($m, 2, '0', STR_PAD_LEFT);
								$d = str_pad($d, 2, '0', STR_PAD_LEFT);
								
								$repeat_holiday[] = $m . '-' . $d;
								$display_repeat[] = $n;
							}
						}

						$yearStart = date('Y', strtotime($s_date));
						$yearEnd   = date('Y', strtotime($e_date));

						// $s_date_string = $s_date->format('Y-m-d');
						// $e_date_string = $e_date->format('Y-m-d');

						if ($yearEnd < $yearStart) {
							$start_m = $e_date['1'];
							$end_m = $s_date['1'];
							$start_d = $e_date['2'];
							$end_d = $s_date['2'];
							$yearStart = date('Y', strtotime($e_date));
							$yearEnd   = date('Y', strtotime($s_date));
						} else {
							$start_m = $s_date['1'];
							$end_m = $e_date['1'];
							$start_d = $s_date['2'];
							$end_d = $e_date['2'];
						}
						for ($i = $yearStart; $i <= $yearEnd; $i++) {
							if (isset($mlkd)) {
								if ($start_m == '1' && $i == $yearStart && $yearStart != $yearEnd) {
									$date_check = date('d', strtotime("january $i third monday"));
									if ($start_d <= $date_check) {
										$all_holiday[] = date('l, M d, Y', strtotime("january $i third monday"));
										$display_holiday[] = 'M. L. King Day';
									}
								}
								if ($i == $yearEnd) {
									$date_check = date('d', strtotime("january $i third monday"));
									if ($end_m > 1 || $end_d <= $date_check) {
										$all_holiday[] = date('l, M d, Y', strtotime("january $i third monday"));
										$display_holiday[] = 'M. L. King Day';
									}
								}
								if ($i != $yearStart && $i != $yearEnd) {
									$all_holiday[] = date('l, M d, Y', strtotime("january $i third monday"));
									$display_holiday[] = 'M. L. King Day';
								}
							}
							if (isset($psd)) {
								if ($start_m <= '2' && $i == $yearStart && $yearStart != $yearEnd) {
									$date_check = date('d', strtotime("february $i third monday"));
									if ($start_d <= $date_check) {
										$all_holiday[] = date('l, M d, Y', strtotime("february $i third monday"));
										$display_holiday[] = "President's Day";
									}
								}
								if ($i == $yearEnd) {
									$date_check = date('d', strtotime("february $i third monday"));
									if (($end_m == 2 && $end_d >= $date_check) || $end_m > 2) {
										$all_holiday[] = date('l, M d, Y', strtotime("february $i third monday"));
										$display_holiday[] = "President's Day";
									}
								}
								if ($i != $yearStart && $i != $yearEnd) {
									$all_holiday[] = date('l, M d, Y', strtotime("february $i third monday"));
									$display_holiday[] = "President's Day";
								}
							}
							if (isset($memd)) {
								if ($start_m <= '5' && $i == $yearStart && $yearStart != $yearEnd) {
									$date_check = date('d', strtotime("may $i first monday"));
									if ($start_d <= $date_check) {
										$all_holiday[] = date('l, M d, Y', strtotime("may $i first monday"));
										$display_holiday[] = "Memorial Day";
									}
								}
								if ($i == $yearEnd) {
									$date_check = date('d', strtotime("may $i first monday"));
									if (($end_m == 5 && $end_d >= $date_check) || $end_m > 5) {
										$all_holiday[] = date('l, M d, Y', strtotime("may $i first monday"));
										$display_holiday[] = "Memorial Day";
									}
								}
								if ($i != $yearStart && $i != $yearEnd) {
									$all_holiday[] = date('l, M d, Y', strtotime("may $i first monday"));
									$display_holiday[] = "Memorial Day";
								}
							}
							if (isset($labd)) {
								if ($start_m <= '9' && $i == $yearStart && $yearStart != $yearEnd) {
									$date_check = date('d', strtotime("september $i first monday"));
									if ($start_d <= $date_check) {
										$all_holiday[] = date('l, M d, Y', strtotime("september $i first monday"));
										$display_holiday[] = "Labor Day";
									}
								}
								if ($i == $yearEnd) {
									$date_check = date('d', strtotime("september $i first monday"));
									if (($end_m == 9 && $end_d >= $date_check) || $end_m > 9) {
										$all_holiday[] = date('l, M d, Y', strtotime("september $i first monday"));
										$display_holiday[] = "Labor Day";
									}
								}
								if ($i != $yearStart && $i != $yearEnd) {
									$all_holiday[] = date('l, M d, Y', strtotime("september $i first monday"));
									$display_holiday[] = "Labor Day";
								}
							}
							if (isset($cold)) {
								if ($start_m <= '9' && $i == $yearStart && $yearStart != $yearEnd) {
									$date_check = date('d', strtotime("october $i third monday"));
									if ($start_d <= $date_check) {
										$all_holiday[] = date('l, M d, Y', strtotime("october $i third monday"));
										$display_holiday[] = "Columbus Day";
									}
								}
								if ($i == $yearEnd) {
									$date_check = date('d', strtotime("october $i third monday"));
									if (($end_m == 9 && $end_d >= $date_check) || $end_m > 9) {
										$all_holiday[] = date('l, M d, Y', strtotime("october $i third monday"));
										$display_holiday[] = "Columbus Day";
									}
								}
								if ($i != $yearStart && $i != $yearEnd) {
									$all_holiday[] = date('l, M d, Y', strtotime("october $i third monday"));
									$display_holiday[] = "Columbus Day";
								}
							}
							if (isset($thankd)) {
								if ($start_m <= '9' && $i == $yearStart && $yearStart != $yearEnd) {
									$date_check = date('d', strtotime("november $i fourth thursday"));
									if ($start_d <= $date_check) {
										$all_holiday[] = date('l, M d, Y', strtotime("november $i fourth thursday"));
										$display_holiday[] = "Thanksgiving";
									}
								}
								if ($i == $yearEnd) {
									$date_check = date('d', strtotime("november $i fourth thursday"));
									if (($end_m == 9 && $end_d >= $date_check) || $end_m > 9) {
										$all_holiday[] = date('l, M d, Y', strtotime("november $i fourth thursday"));
										$display_holiday[] = "Thanksgiving";
									}
								}
								if ($i != $yearStart && $i != $yearEnd) {
									$all_holiday[] = date('l, M d, Y', strtotime("november $i fourth thursday"));
									$display_holiday[] = "Thanksgiving";
								}
							}
							if (isset($blkf)) {
								if ($start_m <= '9' && $i == $yearStart && $yearStart != $yearEnd) {
									$date_check = date('d', strtotime("november $i fourth friday"));
									if ($start_d <= $date_check) {
										$all_holiday[] = date('l, M d, Y', strtotime("november $i fourth friday"));
										$display_holiday[] = "Black Friday";
									}
								}
								if ($i == $yearEnd) {
									$date_check = date('d', strtotime("november $i fourth friday"));
									if (($end_m == 9 && $end_d >= $date_check) || $end_m > 9) {
										$all_holiday[] = date('l, M d, Y', strtotime("november $i fourth friday"));
										$display_holiday[] = "Black Friday";
									}
								}
								if ($i != $yearStart && $i != $yearEnd) {
									$all_holiday[] = date('l, M d, Y', strtotime("november $i fourth friday"));
									$display_holiday[] = "Black Friday";
								}
							}
						}
						$getworkdays = getWorkdays($s_date, $e_date, $check_sat, $repeat_holiday, $all_holiday, $display_holiday, $display_repeat);
					} else {
						$getworkdays = getWorkdays($s_date, $e_date, $check_sat);
					}
					$s_hour = 0;
					$s_min = 0;
					$s_sec = 0;
					$e_hour = 0;
					$e_min = 0;
					$e_sec = 0;
					// $from = new Carbon($s_date);
					// $to = new Carbon($e_date);
					$from = new Carbon($s_date[2] . '.' . $s_date[1] . '.' . $s_date[0]);
					$to = new Carbon($e_date[2] . '.' . $e_date[1] . '.' . $e_date[0]);
					$diff = $to->diff($from);
					$years = $diff->y;
					$months = $diff->m;
					$days = $diff->d;
					$from = date('M d, Y', strtotime($s_date));
					$to = date('M d, Y', strtotime($e_date));
					if (strtotime($s_date) > strtotime($e_date)) {
						$new = $from;
						$from = $to;
						$to = $new;
					}
					$d1 = mktime($s_hour, $s_min, $s_sec, $s_date[1], $s_date[2], $s_date[0]);
					$d2 = mktime($e_hour, $e_min, $e_sec, $e_date[1], $e_date[2], $e_date[0]);

					$diff = abs($d2 - $d1);

					// Calculate hours, minutes, and seconds from the difference
					$hours = floor($diff / (60 * 60));
					$minutes = floor(($diff % (60 * 60)) / 60);
					$seconds = $diff % 60;

					if ($holiday_c == "no") {
						// dd($holiday_c);
						if ($ex_in == "1") {
							if ($satting == "2") {
								$f1_ans = $getworkdays['workdays'] + $getworkdays['weekend'] + $getworkdays['holidays'];
								$res_days = $f1_ans - $getworkdays['weekend'];
								$ans2 = $getworkdays['weekend'];
								$weekends_days = "Excluded " . $getworkdays['weekend'];
							} else if ($satting == "5") {
								$res_days = $getworkdays['workdays'] + $getworkdays['weekend'] + $getworkdays['holidays'];
								$ans2 = "no days were skipped in this period";
							} else if ($satting == "6") {
								// input start and end date
								$startDate = $s_date;
								$endDate = $e_date;

								$resultDays = array(
									'Sunday' => 0,
									'Monday' => 0,
									'Tuesday' => 0,
									'Wednesday' => 0,
									'Thursday' => 0,
									'Friday' => 0,
									'Saturday' => 0
								);

								// change string to date time object
								$startDate = new Carbon($startDate);
								$endDate = new Carbon($endDate);

								// iterate over start to end date
								while ($startDate <= $endDate) {
									// find the timestamp value of start date
									$timestamp = strtotime($startDate->format('d-m-Y'));

									// find out the day for timestamp and increase particular day
									$weekDay = date('l', $timestamp);
									$resultDays[$weekDay] = $resultDays[$weekDay] + 1;

									// increase startDate by 1
									$startDate->modify('+1 day');
								}
								// dd($endDate);

								$sun_day2 = $resultDays['Sunday'];
								if (isset($sun)) {
									$sun_day = "Excluded " . $sun_day2 . " Sundays";
								}
								$mon_day2 = $resultDays['Monday'];
								if (isset($mon)) {
									$mon_day = "Excluded " . $mon_day2 . " Mondays";
								}
								$tue_day2 = $resultDays['Tuesday'];
								if (isset($tue)) {
									$tue_day = "Excluded " . $tue_day2 . " Tuesdays";
								}
								$wed_day2 = $resultDays['Wednesday'];
								if (isset($wed)) {
									$wed_day = "Excluded " . $wed_day2 . " Wednesdays";
								}
								$thu_day2 = $resultDays['Thursday'];
								if (isset($thu)) {
									$thu_day = "Excluded " . $thu_day2 . " Thursdays";
								}
								$fri_day2 = $resultDays['Friday'];
								if (isset($fri)) {
									$fri_day = "Excluded " . $fri_day2 . " Fridays";
								}
								$sat_day2 = $resultDays['Saturday'];
								if (isset($sat)) {
									$sat_day = "Excluded " . $sat_day2 . " Saturday";
								}
								$days_sum = $sun_day2 + $mon_day2 + $tue_day2 + $wed_day2 + $thu_day2 + $fri_day2 + $sat_day2;
								$f1_ans = $getworkdays['workdays'] + $getworkdays['weekend'] + $getworkdays['holidays'];
								$res_days = $f1_ans - $days_sum;
								$ans2 = $days_sum;
							}
						} else if ($ex_in == "2") {
							if ($satting == "2") {
								$f1_ans = $getworkdays['workdays'] + $getworkdays['weekend'] + $getworkdays['holidays'];
								$res_days2 = $f1_ans - $getworkdays['weekend'];
								$ans2 = $res_days2;
								$res_days = $getworkdays['weekend'];
								$weekends_days = "Included " . $getworkdays['weekend'];
							} else if ($satting == "4") {
								$res_days = $getworkdays['workdays'] + $getworkdays['weekend'] + $getworkdays['holidays'];
								$ans2 = "no days were skipped in this period";
							} else if ($satting == "6") {
								// input start and end date
								$startDate = $s_date;
								$endDate = $e_date;

								$resultDays = array(
									'Sunday' => 0,
									'Monday' => 0,
									'Tuesday' => 0,
									'Wednesday' => 0,
									'Thursday' => 0,
									'Friday' => 0,
									'Saturday' => 0
								);

								// change string to date time object
								$startDate = new Carbon($startDate);
								$endDate = new Carbon($endDate);

								// iterate over start to end date
								while ($startDate <= $endDate) {
									// find the timestamp value of start date
									$timestamp = strtotime($startDate->format('d-m-Y'));

									// find out the day for timestamp and increase particular day
									$weekDay = date('l', $timestamp);
									$resultDays[$weekDay] = $resultDays[$weekDay] + 1;

									// increase startDate by 1
									$startDate->modify('+1 day');
								}
								$sun_day2 = $resultDays['Sunday'];
								if (isset($sun)) {
									$sun_day = "Included " . $sun_day2 . " Sundays";
								}
								$mon_day2 = $resultDays['Monday'];
								if (isset($mon)) {
									$mon_day = "Included " . $mon_day2 . " Mondays";
								}
								$tue_day2 = $resultDays['Tuesday'];
								if (isset($tue)) {
									$tue_day = "Included " . $tue_day2 . " Tuesdays";
								}
								$wed_day2 = $resultDays['Wednesday'];
								if (isset($wed)) {
									$wed_day = "Included " . $wed_day2 . " Wednesdays";
								}
								$thu_day2 = $resultDays['Thursday'];
								if (isset($thu)) {
									$thu_day = "Included " . $thu_day2 . " Thursdays";
								}
								$fri_day2 = $resultDays['Friday'];
								if (isset($fri)) {
									$fri_day = "Included " . $fri_day2 . " Fridays";
								}
								$sat_day2 = $resultDays['Saturday'];
								if (isset($sat)) {
									$sat_day = "Included " . $sat_day2 . " Saturday";
								}
								$days_sum = $sun_day2 + $mon_day2 + $tue_day2 + $wed_day2 + $thu_day2 + $fri_day2 + $sat_day2;
								$f1_ans = $getworkdays['workdays'] + $getworkdays['weekend'] + $getworkdays['holidays'];
								$res_days2 = $f1_ans - $days_sum;
								$ans2 = $res_days2;
								$res_days = $days_sum;
							}
						}
					} else if ($holiday_c == "yes") {
						if ($ex_in == "1") {
							if ($satting == "2") {
								$f1_ans = $getworkdays['workdays'] + $getworkdays['weekend'] + $getworkdays['holidays'];
								$res_days = $f1_ans - $getworkdays['weekend'];
								$ans2 = $getworkdays['weekend'];
								$weekends_days = $getworkdays['weekend'];
							} else if ($satting == "5") {
								$res_days = $getworkdays['workdays'] + $getworkdays['weekend'] + $getworkdays['holidays'];
								$ans2 = "no days were skipped in this period";
							} else if ($satting == "6") {
								// input start and end date
								$startDate = $s_date;
								$endDate = $e_date;

								$resultDays = array(
									'Sunday' => 0,
									'Monday' => 0,
									'Tuesday' => 0,
									'Wednesday' => 0,
									'Thursday' => 0,
									'Friday' => 0,
									'Saturday' => 0
								);

								// change string to date time object
								$startDate = new Carbon($startDate);
								$endDate = new Carbon($endDate);

								// iterate over start to end date
								while ($startDate <= $endDate) {
									// find the timestamp value of start date
									$timestamp = strtotime($startDate->format('d-m-Y'));

									// find out the day for timestamp and increase particular day
									$weekDay = date('l', $timestamp);
									$resultDays[$weekDay] = $resultDays[$weekDay] + 1;

									// increase startDate by 1
									$startDate->modify('+1 day');
								}
								if (isset($sun)) {
									$sun_day2 = $resultDays['Sunday'];
									$sun_day = "Excluded " . $sun_day2 . " Sundays";
								}
								if (isset($mon)) {
									$mon_day2 = $resultDays['Monday'];
									$mon_day = "Excluded " . $mon_day2 . " Mondays";
								}
								if (isset($tue)) {
									$tue_day2 = $resultDays['Tuesday'];
									$tue_day = "Excluded " . $tue_day2 . " Tuesdays";
								}
								if (isset($wed)) {
									$wed_day2 = $resultDays['Wednesday'];
									$wed_day = "Excluded " . $wed_day2 . " Wednesdays";
								}
								if (isset($thu)) {
									$thu_day2 = $resultDays['Thursday'];
									$thu_day = "Excluded " . $thu_day2 . " Thursdays";
								}
								if (isset($fri)) {
									$fri_day2 = $resultDays['Friday'];
									$fri_day = "Excluded " . $fri_day2 . " Fridays";
								}
								if (isset($sat)) {
									$sat_day2 = $resultDays['Saturday'];
									$sat_day = "Excluded " . $sat_day2 . " Saturday";
								}
								$days_sum = $sun_day2 + $mon_day2 + $tue_day2 + $wed_day2 + $thu_day2 + $fri_day2 + $sat_day2;
								$f1_ans = $getworkdays['workdays'] + $getworkdays['weekend'] + $getworkdays['holidays'];
								$res_days = $f1_ans - $days_sum;
								$ans2 = $days_sum;
							} else if ($satting == "1") {
								$f1_ans = $getworkdays['workdays'] + $getworkdays['weekend'] + $getworkdays['holidays'];
								$weekends_days = $getworkdays['weekend'];
								$holi_days = $getworkdays['holidays'];
								$ans2 = $holi_days + $weekends_days;
								$res_days = $f1_ans - $ans2;
							} else if ($satting == "3") {
								$f1_ans = $getworkdays['workdays'] + $getworkdays['weekend'] + $getworkdays['holidays'];
								$res_days = $f1_ans - $getworkdays['holidays'];
								$ans2 = $getworkdays['holidays'];
								$holi_days = $getworkdays['holidays'];
							}
						} else if ($ex_in == "2") {
							if ($satting == "2") {
								$f1_ans = $getworkdays['workdays'] + $getworkdays['weekend'] + $getworkdays['holidays'];
								$res_days2 = $f1_ans - $getworkdays['weekend'];
								$ans2 = $res_days2;
								$res_days = $getworkdays['weekend'];
								$weekends_days = $getworkdays['weekend'];
							} else if ($satting == "4") {
								$res_days = $getworkdays['workdays'] + $getworkdays['weekend'] + $getworkdays['holidays'];
								$ans2 = "no days were skipped in this period";
							} else if ($satting == "6") {
								// input start and end date
								$startDate = $s_date;
								$endDate = $e_date;

								$resultDays = array(
									'Sunday' => 0,
									'Monday' => 0,
									'Tuesday' => 0,
									'Wednesday' => 0,
									'Thursday' => 0,
									'Friday' => 0,
									'Saturday' => 0
								);

								// change string to date time object
								$startDate = new Carbon($startDate);
								$endDate = new Carbon($endDate);

								// iterate over start to end date
								while ($startDate <= $endDate) {
									// find the timestamp value of start date
									$timestamp = strtotime($startDate->format('d-m-Y'));

									// find out the day for timestamp and increase particular day
									$weekDay = date('l', $timestamp);
									$resultDays[$weekDay] = $resultDays[$weekDay] + 1;

									// increase startDate by 1
									$startDate->modify('+1 day');
								}
								if (isset($sun)) {
									$sun_day2 = $resultDays['Sunday'];
									$sun_day = "Included " . $sun_day2 . " Sundays";
								}
								if (isset($mon)) {
									$mon_day2 = $resultDays['Monday'];
									$mon_day = "Included " . $mon_day2 . " Mondays";
								}
								if (isset($tue)) {
									$tue_day2 = $resultDays['Tuesday'];
									$tue_day = "Included " . $tue_day2 . " Tuesdays";
								}
								if (isset($wed)) {
									$wed_day2 = $resultDays['Wednesday'];
									$wed_day = "Included " . $wed_day2 . " Wednesdays";
								}
								if (isset($thu)) {
									$thu_day2 = $resultDays['Thursday'];
									$thu_day = "Included " . $thu_day2 . " Thursdays";
								}
								if (isset($fri)) {
									$fri_day2 = $resultDays['Friday'];
									$fri_day = "Included " . $fri_day2 . " Fridays";
								}
								if (isset($sat)) {
									$sat_day2 = $resultDays['Saturday'];
									$sat_day = "Included " . $sat_day2 . " Saturday";
								}
								$days_sum = $sun_day2 + $mon_day2 + $tue_day2 + $wed_day2 + $thu_day2 + $fri_day2 + $sat_day2;
								$f1_ans = $getworkdays['workdays'] + $getworkdays['weekend'] + $getworkdays['holidays'];
								$res_days2 = $f1_ans - $days_sum;
								$ans2 = $res_days2;
								$res_days = $days_sum;
							} else if ($satting == "1") {
								$f1_ans = $getworkdays['workdays'] + $getworkdays['weekend'] + $getworkdays['holidays'];
								$weekends_days = $getworkdays['weekend'];
								$holi_days = $getworkdays['holidays'];
								$res_days = $holi_days + $weekends_days;
								$ans2 = $f1_ans - $res_days;
							} else if ($satting == "3") {
								$f1_ans = $getworkdays['workdays'] + $getworkdays['weekend'] + $getworkdays['holidays'];
								$ans2 = $f1_ans - $getworkdays['holidays'];
								$res_days = $getworkdays['holidays'];
								$holi_days = $getworkdays['holidays'];
							}
						}
					}
					if (isset($days_sum)) {
						$this->param['days_sum'] = $days_sum;
					}
					if (isset($sun_day)) {
						$this->param['sun_day'] = $sun_day;
					}
					if (isset($mon_day)) {
						$this->param['mon_day'] = $mon_day;
					}
					if (isset($tue_day)) {
						$this->param['tue_day'] = $tue_day;
					}
					if (isset($wed_day)) {
						$this->param['wed_day'] = $wed_day;
					}
					if (isset($thu_day)) {
						$this->param['thu_day'] = $thu_day;
					}
					if (isset($fri_day)) {
						$this->param['fri_day'] = $fri_day;
					}
					if (isset($sat_day)) {
						$this->param['sat_day'] = $sat_day;
					}
					if (isset($days_sum)) {
						$this->param['days_sum'] = $days_sum;
					}
					if (isset($holi_days)) {
						$this->param['holi_days'] = $holi_days;
					}
					if (isset($weekends_days)) {
						$this->param['weekends_days'] = $weekends_days;
					}
					if (isset($f1_ans)) {
						$this->param['f1_ans'] = $f1_ans;
					}
					if (isset($res_days)) {
						$this->param['res_days'] = $res_days;
					}
					$this->param = [
						'from' => $from,
						'count_days' => 'active',
						'diff' => $diff,
						'to' => $to,
						'years' => $years,
						'getworkdays' => $getworkdays,
						'months' => $months,
						'hours' => $hours,
						'days' => $days,
						'minutes' => $minutes,
						'seconds' => $seconds,
						't_days' => $getworkdays['weekend'] + $getworkdays['workdays'] + $getworkdays['holidays'],
						'ans2' => $ans2,
						'holiday_c' => $holiday_c,
						'RESULT' => 1,
					];
					// dd($this->param);
					return $this->param;
				} else {
					return ['error' => 'Please enter start and end date'];
				}
			} else {
						// dd($submitt,$cal_bus);
				if (isset($cal_bus)) {
					// $this->load->library('form_validation');
					// $this->form_validation->set_rules('add_date', 'add_date', 'required|trim|htmlspecialchars|stripslashes');
					if (is_numeric($days)) {
						
						// $s_date = $_POST['add_date']; // mmm,dd,yyyy
						// $s_date = explode("-", $s_date);
						$s_date = $add_date; // mmm,dd,yyyy
						$s_date = explode("-", $s_date);
						$date = "$s_date[0]-$s_date[1]-$s_date[2]";
						$start = strtotime($date);
				    	// dd($start,$date);
						$date1 = "$s_date[0]-$s_date[1]-$s_date[2]";
						$days = $days;
						
						$weekends = 0;
						$workdays = 0;
						$holidays = 0;
						if ($weekend_c == 'no') {
									
							if ($method == '+') {
								for ($i = 0; $i < $days; $i++) {
									if ($i != 0) {
										$start = strtotime("+1 days", $start);
									}
									$day = date('w', $start);
									if ($day == '0' || $day == '6') {
										$weekends++;
										$days++;
									}
								}
							} else {
								for ($i = $days; $i > 0; $i--) {
									$start = strtotime("-1 days", $start);
									$day = date('w', $start);
									if ($day == '0' || $day == '6') {
										$weekends++;
										$i++;
									}
								}
							}
								
						} else {
							$all_holiday = array();
							$repeat_holiday = array();
							$display_holiday = array();
							$display_repeat = array();
							$year = date('Y', $start);
							if (isset($mlkd)) {
								$all_holiday[] = date('l, M d, Y', strtotime("january $year third monday"));
								$display_holiday[] = 'M. L. King Day';
							}
							if (isset($psd)) {
								$all_holiday[] = date('l, M d, Y', strtotime("february $year third monday"));
								$display_holiday[] = "President's Day";
							}
							if (isset($memd)) {
								$all_holiday[] = date('l, M d, Y', strtotime("may $year first monday"));
								$display_holiday[] = "Memorial Day";
							}
							if (isset($labd)) {
								$all_holiday[] = date('l, M d, Y', strtotime("september $year first monday"));
								$display_holiday[] = "Labor Day";
							}
							if (isset($cold)) {
								$all_holiday[] = date('l, M d, Y', strtotime("october $year third monday"));
								$display_holiday[] = "Columbus Day";
							}
							if (isset($thankd)) {
								$all_holiday[] = date('l, M d, Y', strtotime("november $year fourth thursday"));
								$display_holiday[] = "Thanksgiving";
							}
							if (isset($blkf)) {
								$all_holiday[] = date('l, M d, Y', strtotime("november $year fourth friday"));
								$display_holiday[] = "Black Friday";
							}
							if (isset($nyd)) {
								$repeat_holiday[] = '01-01';
								$display_repeat[] = "New Year's Day";
							}
							if (isset($ind)) {
								$repeat_holiday[] = '07-04';
								$display_repeat[] = "Independence Day";
							}
							if (isset($vetd)) {
								$repeat_holiday[] = '11-11';
								$display_repeat[] = "Veteran's Day";
							}
							if (isset($cheve)) {
								$repeat_holiday[] = '12-24';
								$display_repeat[] = "Christmas Eve";
							}
							if (isset($chirs)) {
								$repeat_holiday[] = '12-25';
								$display_repeat[] = "Christmas";
							}
							if (isset($nye)) {
								$repeat_holiday[] = '12-31';
								$display_repeat[] = "New Year's Eve";
							}
							// for ($j = 0; $j <= $total_j; $j++) {
							// 	if (is_numeric($d . $j) && is_numeric($m . $j)) {
							// 		$repeat_holiday[] = $m . $j . '-' . $d . $j;
							// 		$display_repeat[] = $n . $j;
							// 	}
							// }
							// Process second set of dynamic holidays
								for ($j = 0; $j <= $request->total_j; $j++) {
									$d = $request->{"d{$j}"} ?? null;
									$m = $request->{"m{$j}"} ?? null;
									$n = $request->{"n{$j}"} ?? null;
									
									if (is_numeric($d) && is_numeric($m) && !empty($n)) {
										// Pad single digit months/days with leading zero
										$m = str_pad($m, 2, '0', STR_PAD_LEFT);
										$d = str_pad($d, 2, '0', STR_PAD_LEFT);
										
										$repeat_holiday[] = $m . '-' . $d;
										$display_repeat[] = $n;
									}
								}
							if ($method == '+') {
								$count = 0;
								$get_holi = array();
								$dis_holi = array();
								for ($i = 0; $i < $days; $i++) {
									if ($i != 0) {
										$start = strtotime("+1 days", $start);
									}
									$day = date('w', $start);
									$year_c = date('Y', $start);
									if ($year != $year_c) {
										$year = $year_c;
										if (isset($mlkd)) {
											$all_holiday[] = date('l, M d, Y', strtotime("january $year third monday"));
											$display_holiday[] = 'M. L. King Day';
										}
										if (isset($psd)) {
											$all_holiday[] = date('l, M d, Y', strtotime("february $year third monday"));
											$display_holiday[] = "President's Day";
										}
										if (isset($memd)) {
											$all_holiday[] = date('l, M d, Y', strtotime("may $year first monday"));
											$display_holiday[] = "Memorial Day";
										}
										if (isset($labd)) {
											$all_holiday[] = date('l, M d, Y', strtotime("september $year first monday"));
											$display_holiday[] = "Labor Day";
										}
										if (isset($cold)) {
											$all_holiday[] = date('l, M d, Y', strtotime("october $year third monday"));
											$display_holiday[] = "Columbus Day";
										}
										if (isset($thankd)) {
											$all_holiday[] = date('l, M d, Y', strtotime("november $year fourth thursday"));
											$display_holiday[] = "Thanksgiving";
										}
										if (isset($blkf)) {
											$all_holiday[] = date('l, M d, Y', strtotime("november $year fourth friday"));
											$display_holiday[] = "Black Friday";
										}
									}
									$mmgg = date('m-d', $start);
									$mg = date('l, M d, Y', $start);
									if (in_array($mg, $all_holiday)) {
										$get_holi[] = $mg;
										$holidays++;
										$dis_holi[] = $display_holiday[$count];
										$count++;
										$days++;
									} elseif (in_array($mmgg, $repeat_holiday)) {
										$holidays++;
										$get_holi[] = $mg;
										$c = array_search($mmgg, $repeat_holiday, true);
										$dis_holi[] = $display_repeat[$c];
										$days++;
									} elseif ($day == '0' || $day == '6') {
										$weekends++;
										$days++;
									}
								}
							} else {
								$get_holi = array();
								$dis_holi = array();
								for ($i = $days; $i > 0; $i--) {
									$start = strtotime("-1 days", $start);
									$day = date('w', $start);
									$year_c = date('Y', $start);
									if ($year != $year_c) {
										$year = $year_c;
										if (isset($mlkd)) {
											$all_holiday[] = date('l, M d, Y', strtotime("january $year third monday"));
											$display_holiday[] = 'M. L. King Day';
										}
										if (isset($psd)) {
											$all_holiday[] = date('l, M d, Y', strtotime("february $year third monday"));
											$display_holiday[] = "President's Day";
										}
										if (isset($memd)) {
											$all_holiday[] = date('l, M d, Y', strtotime("may $year first monday"));
											$display_holiday[] = "Memorial Day";
										}
										if (isset($labd)) {
											$all_holiday[] = date('l, M d, Y', strtotime("september $year first monday"));
											$display_holiday[] = "Labor Day";
										}
										if (isset($cold)) {
											$all_holiday[] = date('l, M d, Y', strtotime("october $year third monday"));
											$display_holiday[] = "Columbus Day";
										}
										if (isset($thankd)) {
											$all_holiday[] = date('l, M d, Y', strtotime("november $year first thursday"));
											$display_holiday[] = "Thanksgiving";
										}
									}
									$mmgg = date('m-d', $start);
									$mg = date('l, M d, Y', $start);
									if ($day == '0' || $day == '6') {
										$weekends++;
										$i++;
									} elseif (in_array($mg, $all_holiday)) {
										$get_holi[] = $mg;
										$holidays++;
										$c = array_search($mg, $all_holiday, true);
										$dis_holi[] = $display_holiday[$c];
										$i++;
									} elseif (in_array($mmgg, $repeat_holiday)) {
										$holidays++;
										$get_holi[] = $mg;
										$c = array_search($mmgg, $repeat_holiday, true);
										$dis_holi[] = $display_repeat[$c];
										$i++;
									}
								}
							}
						}
						if ($weekend_c == 'yes') {
							$this->param['get_holi'] = $get_holi;
							$this->param['dis_holi'] = $dis_holi;
						}
					
						$this->param = [
							'from' => date('l, M d, Y', strtotime($date1)),
							'from_s' => date('M d, Y', strtotime($date1)),
							'date' => date('l, M d, Y', $start),
							'date_e' => date('M d, Y', $start),
							'holidays' => $holidays,
							'weekends' => $weekends,
							'cal_bus' => $cal_bus,
							'method' => $method,
							'days' => $days,
							'weekend_c' => $weekend_c,
							'RESULT' => 1,
						];
						// dd($this->param);
						return $this->param;
					} else {
						return ['error' => 'Please Check Your Input'];
					}
				} else if ($submitt === 'advance') {
				
					// if(is_numeric($years) || is_numeric($months) || is_numeric($weeks) || is_numeric($days)){
					// 	return ['error'=>];
					// }
					if ((is_numeric($years) || is_numeric($months) || is_numeric($weeks) || is_numeric($days))) {
						// dd($s_date);
						$s_date = $add_date; // mmm,dd,yyyy
						$s_date = explode("-", $s_date);
						$date = "$s_date[0]-$s_date[1]-$s_date[2]";
						$date1 = "$s_date[0]-$s_date[1]-$s_date[2]";
						// $date = $s_date->format('y-m-d');
						// $date1 = $s_date->format('y-m-d');
						if ($method === '+') {
							$des = "Added ";
						} else {
							$des = "Subtracted ";
						}
						$days = 0;
						if (!empty($days)) {
							$days = $days;
						}
						$weeks = 0;
						if (!empty($weeks)) {
							$weeks = $weeks;
						}
						$months = 0;
						if (!empty($months)) {
							$months = $months;
						}
						$years = 0;
						if (!empty($years)) {
							$years = $years;
						}
						if ($method === '+') {
							$date = date('l, M d, Y', strtotime($date . ' + ' . $years . ' years' . ' + ' . $months . ' months' . ' + ' . $weeks . ' weeks' . ' + ' . $days . ' days'));
						} else {
							$date = date('l, M d, Y', strtotime($date . ' - ' . $years . ' years' . ' - ' . $months . ' months' . ' - ' . $weeks . ' weeks' . ' - ' . $days . ' days'));
						}
						$des .= $years . ' years' . ' , ' . $months . ' months' . ' , ' . $weeks . ' weeks' . ' , ' . $days . ' days';
						$this->param = [
							'from' => date('l, M d, Y', strtotime($date1)),
							'from_s' => date('M d, Y', strtotime($date1)),
							'add_days' => "active",
							'date' => $date,
							'des' => $des,
							'RESULT' => 1,
						];
						// dd($this->param);
						return $this->param;
					} else {
						return ['error' => 'Please Check Your Input'];
						// $this->param['add'] = "active";
						// return false;
					}
				}
			}

	}

    // Date Duration Calculator
	public function date_duration($request)
	{
		// dd($request);
		$s_date = $request->s_date;
		$e_date = $request->e_date;
		if ($request->checkbox != false) {
			$checkbox = $request->checkbox;
		} else {
			$checkbox = false;
		}
		if (!empty($s_date) && !empty($e_date)) {
			$ss_date = $s_date;
			$ee_date = $e_date;
			$s_date = explode("-", $s_date);
			if ($checkbox !== false) {
				$e_date = date('Y-m-d', strtotime("+1 day" . $e_date));
			}
			$e_date = explode("-", $e_date);
			$s_hour = 0;
			$s_min = 0;
			$s_sec = 0;
			$e_hour = 0;
			$e_min = 0;
			$e_sec = 0;
			$from = new Carbon($s_date[2] . '.' . $s_date[1] . '.' . $s_date[0]);
			$to = new Carbon($e_date[2] . '.' . $e_date[1] . '.' . $e_date[0]);
			$diff = $to->diff($from);
			$years = $diff->y;
			$months = $diff->m;
			$days = $diff->d;
			$from = date('M d, Y', strtotime($ss_date));
			$to = date('M d, Y', strtotime($ee_date));
			if (strtotime($ss_date) > strtotime($ee_date)) {
				$new = $from;
				$from = $to;
				$to = $new;
			}
			$d1 = mktime($s_hour, $s_min, $s_sec, $s_date[1], $s_date[2], $s_date[0]);
			$d2 = mktime($e_hour, $e_min, $e_sec, $e_date[1], $e_date[2], $e_date[0]);
			$diff = abs($d2 - $d1);
			$hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24)  / (60 * 60));

			$minutes = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24  - $hours * 60 * 60) / 60);

			$seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60));
			$this->param['from'] = $from;
			$this->param['to'] = $to;
			$this->param['years'] = $years;
			$this->param['months'] = $months;
			$this->param['hours'] = $hours;
			$this->param['days'] = $days;
			$this->param['minutes'] = $minutes;
			$this->param['seconds'] = $seconds;
		} else {
			$this->param['error'] = 'Please! Check Your Input.';
			return $this->param;
		}
		$this->param['RESULT'] = 1;
		return $this->param;
	}

    /*******************
		working days calculator
	 *******************/
	public function working($request)
	{
		$start_date = trim($request->start_date);
		$end_date = trim($request->end_date);
		$working_days = trim($request->working_days);
		$include_end_date = trim($request->include_end_date);
		function calculateWorkingDays($start_timestamp, $end_timestamp, $working_days)
		{
			$result = 0;
			while ($start_timestamp <= $end_timestamp) {
				$current_day = date('N', $start_timestamp);

				if ($working_days == "Exclude weekends" && $current_day != 6 && $current_day != 7) {
					$result++;
				} elseif ($working_days == "Exclude only Sunday" && $current_day != 7) {
					$result++;
				} elseif ($working_days == "Include all days") {
					$result++;
				}

				$start_timestamp = strtotime('+1 day', $start_timestamp);
			}

			return $result;
		}

		if (!empty($start_date) && !empty($end_date)) {
			$start_timestamp = strtotime($start_date);
			$end_timestamp = strtotime($end_date);

			if ($start_timestamp === false || $end_timestamp === false) {
				$this->param['error'] = 'Invalid date format';
				return $this->param;
			}

			$result = 0;

			if ($working_days == "Exclude weekends") {
				$start_timestamp = strtotime($start_date);
				$end_timestamp = strtotime($end_date);
				$working_days = "Exclude weekends";
				$result = calculateWorkingDays($start_timestamp, $end_timestamp, $working_days);
			} elseif ($working_days == "Exclude only Sunday") {
				$start_timestamp = strtotime($start_date);
				$end_timestamp = strtotime($end_date);
				$working_days = "Exclude only Sunday";
				$result = calculateWorkingDays($start_timestamp, $end_timestamp, $working_days);
			} else {
				$result = ceil(($end_timestamp - $start_timestamp) / (60 * 60 * 24));
			}

			if ($include_end_date == "No") {
				$result--;
			}

			$this->param['answer'] = $result;
			$this->param['RESULT'] = 1;
			return $this->param;
		} else {
			$this->param['error'] = 'Please provide both the starting and ending dates';
			return $this->param;
		}
	}

    // month calcualtor
	public function month($request)
	{
		$start_date = trim($request->start_date);
		$end_date = trim($request->end_date);
		if ($start_date !== '' && $end_date !== '') {
			$datetime1 = new Carbon($start_date);
			$datetime2 = new Carbon($end_date);
			$interval = $datetime1->diff($datetime2);
			$months = ($interval->y * 12) + $interval->m;
			$days = $interval->d;
		} else {
			$this->param['error'] = 'Please! Check Your Input';
			return $this->param;
		}
		$this->param['months'] = $months;
		$this->param['days'] = $days;
		$this->param['RESULT'] = 1;
		return $this->param;
	}

    /*******************
    	Anniversary Calculator
	 *******************/
	public function anniversary($request)
	{
		$date = $request->input("date");
		$current_date = $request->input("current_date");
		$one = $request->input("one");
		if ($one === 'one') {
			if (!empty($date)) {
				$anniversaryDate = date("M d, Y", strtotime("+" . (date("Y") - date("Y", strtotime($date))) . " year", strtotime($date)));
				$anniversaryDate = date("M d, Y", strtotime($anniversaryDate . " + 365 days"));
				$today = date("Y-m-d");
				$daysUntilAnniversary = floor((strtotime($anniversaryDate) - strtotime($today)) / (60 * 60 * 24));

				// Calculate marriage age
				$marriageStartDate = new Carbon($date);
				$currentDate = new Carbon($current_date);

				$marriageAge = $marriageStartDate->diff($currentDate);

				$yearsMarried = $marriageAge->y;
				$monthsMarried = ($yearsMarried * 12) + $marriageAge->m;
				$daysMarried = $marriageAge->d;
				$this->param['anniversaryDate'] = $anniversaryDate;
				$this->param['daysUntilAnniversary'] = $daysUntilAnniversary;
				$this->param['yearsMarried'] = $yearsMarried;
				$this->param['monthsMarried'] = $monthsMarried;
				$this->param['daysMarried'] = $daysMarried;
				$this->param['marriage_age_weeks'] = ceil($marriageAge->days / 7);
				$this->param['marriage_age_days'] = $marriageAge->days;
			} else {
				$this->param['error'] = 'Please! Enter the date';
				return $this->param;
			}
		} else if ($one === 'two') {
			if (!empty($date)) {
				$anniversaryDate = date("M d, Y", strtotime("+" . (date("Y") - date("Y", strtotime($date))) . " year", strtotime($date)));
				$anniversaryDate = date("M d, Y", strtotime($anniversaryDate . " + 365 days"));
				$today = date("Y-m-d");
				$daysUntilAnniversary = floor((strtotime($anniversaryDate) - strtotime($today)) / (60 * 60 * 24));

				// Calculate marriage age
				$marriageStartDate = new Carbon($date);
				$currentDate = new Carbon($current_date);
				$marriageAge = $marriageStartDate->diff($currentDate);

				$yearsMarried = $marriageAge->y;
				$monthsMarried = ($yearsMarried * 12) + $marriageAge->m;
				$daysMarried = $marriageAge->d;
				$this->param['anniversaryDate'] = $anniversaryDate;
				$this->param['daysUntilAnniversary'] = $daysUntilAnniversary;
				$this->param['yearsMarried'] = $yearsMarried;
				$this->param['monthsMarried'] = $monthsMarried;
				$this->param['daysMarried'] = $daysMarried;
				$this->param['marriage_age_weeks'] = ceil($marriageAge->days / 7);
				$this->param['marriage_age_days'] = $marriageAge->days;
			} else {
				$this->param['error'] = 'Please! Enter the date';
				return $this->param;
			}
		} else if ($one === 'three') {
			if (!empty($date)) {
				$anniversaryDate = date("M d, Y", strtotime("+" . (date("Y") - date("Y", strtotime($date))) . " year", strtotime($date)));
				$anniversaryDate = date("M d, Y", strtotime($anniversaryDate . " + 365 days"));
				$today = date("Y-m-d");
				$daysUntilAnniversary = floor((strtotime($anniversaryDate) - strtotime($today)) / (60 * 60 * 24));

				// Calculate marriage age
				$marriageStartDate = new Carbon($date);
				$currentDate = new Carbon($current_date);
				$marriageAge = $marriageStartDate->diff($currentDate);

				$yearsMarried = $marriageAge->y;
				$monthsMarried = ($yearsMarried * 12) + $marriageAge->m;
				$daysMarried = $marriageAge->d;
				$this->param['anniversaryDate'] = $anniversaryDate;
				$this->param['daysUntilAnniversary'] = $daysUntilAnniversary;
				$this->param['yearsMarried'] = $yearsMarried;
				$this->param['monthsMarried'] = $monthsMarried;
				$this->param['daysMarried'] = $daysMarried;
				$this->param['marriage_age_weeks'] = ceil($marriageAge->days / 7);
				$this->param['marriage_age_days'] = $marriageAge->days;
			} else {
				$this->param['error'] = 'Please! Enter the date';
				return $this->param;
			}
		}

		$this->param['RESULT'] = 1;
		return $this->param;
	}

    // Deadline Calculator
	public function deadline($request)
	{
		$date = trim($request->date);
		$period = trim($request->period);
		$Number = trim($request->Number);
		$before_after = trim($request->before_after);
		if (empty($date) || !is_numeric($Number)) {
			$this->param['error'] = 'Please check your input.';
			return $this->param;
		}

		if (!strtotime($date)) {
			$this->param['error'] = 'Invalid date format. Please use YYYY-MM-DD.';
			return $this->param;
		}

		if ($period == "Days") {
			$interval = "days";
		} elseif ($period == "Weeks") {
			$interval = "weeks";
		} elseif ($period == "Years") {
			$interval = "years";
		} else {
			$this->param['error'] = 'Invalid period. Please select Days, Weeks, or Years.';
			return $this->param;
		}

		if ($before_after == "Before") {
			$result = date("Y-m-d", strtotime("-$Number $interval", strtotime($date)));
		} else {
			$result = date("Y-m-d", strtotime("+$Number $interval", strtotime($date)));
		}


		$timestamp = strtotime($result);
		$result = date("M d, Y", $timestamp);

		$this->param['answer'] = $result;
		$this->param['RESULT'] = 1;
		return $this->param;
	}

    // birthyear
    function  birthyear($request)
	{
		$date = $request->date;
		$age = $request->age;
		$ageUnit = $request->age_unit;
		$choose = $request->choose;
        if ($date && is_numeric($age) && $choose && $ageUnit && $choose)  {
			if($ageUnit == 'years'){
					$date = Carbon::parse($date);
					$newDate = $date->subYears($age);
					$newYear = $newDate->year;
			}elseif($ageUnit == 'months'){
					$date = Carbon::parse($date);
					$newDate = $date->subMonths($age);
					$newYear = $newDate->year;
			}elseif($ageUnit == 'weeks'){
					$date = Carbon::parse($date);
					$newDate = $date->subWeeks($age);
					$newYear = $newDate->year;
			}elseif($ageUnit == 'days'){
					$date = Carbon::parse($date);
					$newDate = $date->subDays($age);
					$newYear = $newDate->year;
			}elseif($ageUnit == 'hours'){
					$date = Carbon::parse($date);
					$newDate = $date->subHours($age);
					$newYear = $newDate->year;
			}elseif($ageUnit == 'minutes'){
					$date = Carbon::parse($date);
					$newDate = $date->subMinutes($age);
					$newYear = $newDate->year;
			}elseif($ageUnit == 'second'){
					$date = Carbon::parse($date);
					$newDate = $date->subSeconds($age);
					$newYear = $newDate->year;
			}
			if($choose == 'before'){
				$newYear = $newYear-1;
			}

			$this->param['newYear'] = $newYear;
			$this->param[ 'RESULT' ] = 1;
			return $this->param;
        }else{
			$this->param['error'] = 'Please! Check Your Input';
			return $this->param;
		}
		
	}


	// time until calculateWorkingDays
	function time_until($request){
		$currentInput = $request->current;
        $nextInput = $request->next;

        $currentTime = Carbon::parse($currentInput);
        $nextTime = Carbon::parse($nextInput);
        $today = Carbon::now();

        if (!$currentTime || !$nextTime) {
			$this->param['error'] = 'Please enter valid dates';
			return $this->param;
        }

        if ($nextTime->lessThan($today)) {
			$this->param['error'] = 'Next date cannot be less than today\'s date.';
			return $this->param;
        }

        $totalSeconds = $nextTime->diffInSeconds($currentTime);

        $years = floor($totalSeconds / (365 * 24 * 60 * 60));
        $months = floor(($totalSeconds % (365 * 24 * 60 * 60)) / (30 * 24 * 60 * 60));
        $days = floor(($totalSeconds % (30 * 24 * 60 * 60)) / (24 * 60 * 60));
        $hours = floor(($totalSeconds % (24 * 60 * 60)) / (60 * 60));
        $minutes = floor(($totalSeconds % (60 * 60)) / 60);
        $seconds = $totalSeconds % 60;

        $this->param = [
            'years' => $years,
            'months' => $months,
            'days' => $days,
            'hours' => $hours,
            'minutes' => $minutes,
            'seconds' => $seconds,
            'RESULT' => 1
        ];
		// dd($this->param);
		return $this->param;
	}

	// week calculator
	function week_calc($request){
		$current = $request->current;
		$next = $request->next;
		$number = $request->number;
		$stype = $request->stype;

		if($stype == 's_date'){
			if(is_numeric($number)){
				$date1 = Carbon::parse($current);
				$dateAfterAddingWeeks = $date1->copy()->addWeeks($number);
				$this->param['adding'] = $dateAfterAddingWeeks->format('F j, Y');
				$this->param['RESULT'] = 1;
				$this->param['stype'] = $stype;
				return $this->param;
			}else{
				return ['error'=>'Please input Number of weeks'];
			}
		}if($stype == 'e_date'){
			if(is_numeric($number)){
				$date1 = Carbon::parse($current);
				$dateAfterSubtractingWeeks = $date1->copy()->subWeeks($number);
				$this->param['subbtract'] = $dateAfterSubtractingWeeks->format('F j, Y');
				$this->param['RESULT'] = 1;
				$this->param['stype'] = $stype;
				return $this->param;
			}else{
				return ['error'=>'Please input Number of weeks'];
			}
		}else{
			$date1 = Carbon::parse($current);
			$date2 = Carbon::parse($request->next);
			$diff = $date1->diff($date2);
			$totaldays = $diff->days;
			$weeks = floor($totaldays / 7);
			$this->param['weeks'] = $weeks;
			$this->param['RESULT'] = 1;
			$this->param['stype'] = $stype;
			return $this->param;
		}
	}

	// days form today
	function days_from($request){
		$number = $request->number;
		if(is_numeric($number)){
			if ($number >= 1 || $number == '0') {
				$date1 = Carbon::parse($request->current);
				$dateAfterAddingDays = $date1->copy()->addDays($number);
				$this->param['date_name'] = $dateAfterAddingDays->dayName;
				$this->param['t_date'] = $dateAfterAddingDays->format('F j, Y');
				$this->param['uk_date'] = $dateAfterAddingDays->format('j F, Y');
				$this->param['number'] = $dateAfterAddingDays->format('d/m/y');
				$this->param['usa_num'] = $dateAfterAddingDays->format('m/d/y');
				$this->param['iso'] = $dateAfterAddingDays->format('Y-m-d');
				$this->param['RESULT'] = 1;
				return $this->param;
			} elseif ($number <= -1) {
				$date2 = Carbon::parse($request->current);
				$dateAfterSubtractingDays = $date2->copy()->subDays(abs($number));
				$this->param['date_name'] = $dateAfterSubtractingDays->dayName;
				$this->param['t_date'] = $dateAfterSubtractingDays->format('F j, Y');
				$this->param['uk_date'] = $dateAfterSubtractingDays->format('j F, Y');
				$this->param['number'] = $dateAfterSubtractingDays->format('d/m/y');
				$this->param['usa_num'] = $dateAfterSubtractingDays->format('m/d/y');
				$this->param['iso'] = $dateAfterSubtractingDays->format('Y-m-d');
				$this->param['RESULT'] = 1;
				return $this->param;
			}	
		}else{
			return ['error' => 'Please add Number of days'];
		}

	}

	// weeks form
	function weeks_from($request){
		$number = $request->number;
		if(is_numeric($number)){
			if ($number >= 1 || $number == '0') {
				$date1 = Carbon::parse($request->current);
				$dateAfterAddingDays = $date1->copy()->addWeeks($number);
				$isLeapYear = $dateAfterAddingDays->isLeapYear();
				$daysInYear = $isLeapYear ? 366 : 365;   
				$weeksInYear = 52; 
				$currentWeekOfYear = $dateAfterAddingDays->weekOfYear; 
				$currentDayOfYear = $dateAfterAddingDays->dayOfYear;
				$this->param['date_name'] = $dateAfterAddingDays->dayName;
				$this->param['t_date'] = $dateAfterAddingDays->format('F j, Y');
				$this->param['daysInYear'] = $daysInYear;
				$this->param['weeksInYear'] = $weeksInYear;
				$this->param['currentWeekOfYear'] = $currentWeekOfYear;
				$this->param['currentDayOfYear'] = $currentDayOfYear;
				$this->param['RESULT'] = 1;
				$this->param['number'] = $number;
				// $this->param['uk_date'] = $dateAfterAddingDays->format('j F, Y');
				// $this->param['number'] = $dateAfterAddingDays->format('d/m/y');
				// $this->param['usa_num'] = $dateAfterAddingDays->format('m/d/y');
				// $this->param['iso'] = $dateAfterAddingDays->format('Y-m-d');
				return $this->param;
			} elseif ($number <= -1) {
				$date2 = Carbon::parse($request->input('current'));
				$dateAfterSubtractingDays = $date2->copy()->subWeeks(abs($number));
				$isLeapYear = $dateAfterSubtractingDays->isLeapYear();
				$daysInYear = $isLeapYear ? 366 : 365;   
				$weeksInYear = 52 ; 
				$currentWeekOfYear = $dateAfterSubtractingDays->weekOfYear; 
				$currentDayOfYear = $dateAfterSubtractingDays->dayOfYear;
				$this->param['daysInYear'] = $daysInYear;
				$this->param['weeksInYear'] = $weeksInYear;
				$this->param['currentWeekOfYear'] = $currentWeekOfYear;
				$this->param['currentDayOfYear'] = $currentDayOfYear;
				$this->param['date_name'] = $dateAfterSubtractingDays->dayName;
				$this->param['t_date'] = $dateAfterSubtractingDays->format('F j, Y');
					$this->param['RESULT'] = 1;
					$this->param['number'] = $number;
				// $this->param['uk_date'] = $dateAfterSubtractingDays->format('j F, Y');
				// $this->param['number'] = $dateAfterSubtractingDays->format('d/m/y');
				// $this->param['usa_num'] = $dateAfterSubtractingDays->format('m/d/y');
				// $this->param['iso'] = $dateAfterSubtractingDays->format('Y-m-d');
				return $this->param;
			}			
		}else{
			return ['error' => 'Please add Number of Weeks'];
		}
	}

	// years form

	function years_from($request) {
		$number = $request->number;
		$currentDate = Carbon::parse($request->current);

		if (!is_numeric($number)) {
			return ['error' => 'Please add Number of Years'];
		}

		// Calculate these common values
		$currentWeekOfYear = $currentDate->weekOfYear;
		$weeksInYear = Carbon::parse($currentDate->year . '-12-31')->weekOfYear;
		$currentDayOfYear = $currentDate->dayOfYear;
		$daysInYear = $currentDate->isLeapYear() ? 366 : 365;

		if ($number >= 0) {
			$dateAfter = $currentDate->copy()->addYears($number);
			$daysDifference = $currentDate->diffInDays($dateAfter);
			$weeksDifference = $currentDate->diffInWeeks($dateAfter);

			$this->param = [
				'WeekOfYear' => $weeksDifference,
				'DayOfYear' => $daysDifference,
				'date_name' => $dateAfter->dayName,
				't_date' => $dateAfter->format('F j, Y'),
				'RESULT' => 1,
				'number' => $number,

				// Add missing keys here:
				'currentWeekOfYear' => $currentWeekOfYear,
				'weeksInYear' => $weeksInYear,
				'currentDayOfYear' => $currentDayOfYear,
				'daysInYear' => $daysInYear,
			];

			return $this->param;

		} else {
			$dateAfter = $currentDate->copy()->subYears(abs($number));
			$daysDifference = $currentDate->diffInDays($dateAfter);
			$weeksDifference = $currentDate->diffInWeeks($dateAfter);

			$this->param = [
				'WeekOfYear' => "-" . $weeksDifference,
				'DayOfYear' => "-" . $daysDifference,
				'date_name' => $dateAfter->dayName,
				't_date' => $dateAfter->format('F j, Y'),
				'RESULT' => 1,
				'number' => $number,

				'currentWeekOfYear' => $currentWeekOfYear,
				'weeksInYear' => $weeksInYear,
				'currentDayOfYear' => $currentDayOfYear,
				'daysInYear' => $daysInYear,
			];

			return $this->param;
		}
	}

	// hours form now
	function hours_from($request){
		$hours = $request->hours;
		$minuts = $request->minuts;
		$sec = $request->sec;
		$hrs = $request->hrs;
		$min = $request->min;

		$date1 = Carbon::createFromTime($hours,$minuts,$sec);
		$hoursadding = $date1->copy()->addHours($hrs);
		$hoursadding = $hoursadding->copy()->addMinutes($min);
		$this->param['hoursadding'] = $hoursadding;
		$this->param['sec'] = $sec;
		$this->param['RESULT'] = 1;
		return $this->param;
	}

	// weeks ago calculator
	function weeks_ago($request){
		$number = $request->number;
		if(is_numeric($number)){
			if ($number <= -1 || $number == '0') {
				$date1 = Carbon::parse($request->current);
				$dateAfterAddingDays = $date1->copy()->addWeeks(abs($number));

				$isLeapYear = $dateAfterAddingDays->isLeapYear();
				$daysInYear = $isLeapYear ? 366 : 365;   
				$weeksInYear = 52; 
				$currentWeekOfYear = $dateAfterAddingDays->weekOfYear; 
				$currentDayOfYear = $dateAfterAddingDays->dayOfYear;
				$this->param['date_name'] = $dateAfterAddingDays->dayName;
				$this->param['t_date'] = $dateAfterAddingDays->format('F j, Y');
				$this->param['daysInYear'] = $daysInYear;
				$this->param['weeksInYear'] = $weeksInYear;
				$this->param['currentWeekOfYear'] = $currentWeekOfYear;
				$this->param['currentDayOfYear'] = $currentDayOfYear;
				$this->param['number'] = $number;
				$this->param['RESULT'] = 1;
				return $this->param;
			} elseif ($number >= 1) {
				$date2 = Carbon::parse($request->current);
				$dateAfterSubtractingDays = $date2->copy()->subWeeks($number);
				$isLeapYear = $dateAfterSubtractingDays->isLeapYear();
				$daysInYear = $isLeapYear ? 366 : 365;   
				$weeksInYear = 52 ; 
				$currentWeekOfYear = $dateAfterSubtractingDays->weekOfYear; 
				$currentDayOfYear = $dateAfterSubtractingDays->dayOfYear;
				$this->param['daysInYear'] = $daysInYear;
				$this->param['weeksInYear'] = $weeksInYear;
				$this->param['currentWeekOfYear'] = $currentWeekOfYear;
				$this->param['currentDayOfYear'] = $currentDayOfYear;
				$this->param['date_name'] = $dateAfterSubtractingDays->dayName;
				$this->param['t_date'] = $dateAfterSubtractingDays->format('F j, Y');
				$this->param['number'] = $number;
				$this->param['RESULT'] = 1;
				return $this->param;
			}			
		}else{
			return ['error' => 'Please add Number of Weeks'];
		}
	}

	// time ago calculator
	function time_ago($request){
		$hours = isset($request->hours) ? (int)$request->hours : 0;
		$minutes = isset($request->minuts) ? (int)$request->minuts : 0;
		$seconds = isset($request->sec) ? (int)$request->sec : 0;
		$hrs = isset($request->hrs) ? (int)$request->hrs : 0;
		$min = isset($request->min) ? (int)$request->min : 0;
		$current = Carbon::createFromTime($hours,$minutes,$seconds);
		if ($hours >= 1 || $minutes >= 1 || $seconds >= 1) {
			$timeSubtract = $current->copy()->subHours($hrs)->subMinutes($min);
			$t_date = $timeSubtract->format('F j, Y');
			$days = $current->diffInDays($timeSubtract);
			$this->param['days'] = $days;
			$this->param['t_date'] = $t_date;
			$this->param['time'] = $timeSubtract->format('h:i A');
			$this->param['hours'] = $hours;
			$this->param['minutes'] = $minutes;
			$this->param['seconds'] = $seconds;
			$this->param['RESULT'] = 1;
			return $this->param;

		} else{
			$timeAdd = $current->copy()->addHours(abs($hrs))->addMinutes(abs($min));
			$t_date = $timeAdd->format('F j, Y');
			$days = $current->diffInDays($timeAdd);
			$this->param['days'] = $days;
			$this->param['t_date'] = $t_date;
			$this->param['time'] = $timeAdd->format('h:i A');
				$this->param['hours'] = $hours;
			$this->param['minutes'] = $minutes;
			$this->param['seconds'] = $seconds;
				$this->param['RESULT'] = 1;
			return $this->param;
		} 
	}

	// years ago
	function year_ago($request){
		$number = $request->number;
		if(is_numeric($number)){
			if ($number >= 1) {
				$date2 = Carbon::parse($request->current);
				$dateAfterAddingYear = $date2->copy()->subYears($number);
				$daysDifference = $date2->diffInDays($dateAfterAddingYear);
				$weeksDifference = $date2->diffInWeeks($dateAfterAddingYear);
				$diffInMonths = $date2->diffInMonths($dateAfterAddingYear);
				$this->param['diffInMonths'] = $diffInMonths;
				$this->param['DayOfYear'] =$daysDifference;
				$this->param['WeekOfYear'] =$weeksDifference;
				$this->param['date_name'] = $dateAfterAddingYear->dayName;
				$this->param['t_date'] = $dateAfterAddingYear->format('F j, Y');
				$this->param['number'] = $number;
				$this->param['RESULT'] = 1;
				return $this->param;
			} else{
				$date1 = Carbon::parse($request->current);
				$dateAfterAddingYear = $date1->copy()->addYears(abs($number));
				$daysDifference = $date1->diffInDays($dateAfterAddingYear);
				$weeksDifference = $date1->diffInWeeks($dateAfterAddingYear);
				$diffInMonths = $date1->diffInMonths($dateAfterAddingYear);
				$this->param['DayOfYear'] = $daysDifference;
				$this->param['WeekOfYear'] = $weeksDifference;
				$this->param['diffInMonths'] = $diffInMonths;
				$this->param['date_name'] = $dateAfterAddingYear->dayName;
				$this->param['t_date'] = $dateAfterAddingYear->format('F j, Y');
				$this->param['number'] = $number;
				$this->param['RESULT'] = 1;
				return $this->param;
			}			
		}else{
			return ['error' => 'Please add Number of Years'];
		}
	}
	
	// days ago calculator
	function days_ago($request){
		$number = $request->number;
		if(is_numeric($number)){
			if ($number <= -1 || $number == '0') {
				$date1 = Carbon::parse($request->current);
				$dateAfterAddingDays = $date1->copy()->addDays(abs($number));

				$isLeapYear = $dateAfterAddingDays->isLeapYear();
				$daysInYear = $isLeapYear ? 366 : 365;   
				$weeksInYear = 52; 
				$currentWeekOfYear = $dateAfterAddingDays->weekOfYear; 
				$currentDayOfYear = $dateAfterAddingDays->dayOfYear;
				$this->param['date_name'] = $dateAfterAddingDays->dayName;
				$this->param['t_date'] = $dateAfterAddingDays->format('F j, Y');
				$this->param['daysInYear'] = $daysInYear;
				$this->param['weeksInYear'] = $weeksInYear;
				$this->param['currentWeekOfYear'] = $currentWeekOfYear;
				$this->param['currentDayOfYear'] = $currentDayOfYear;
					$this->param['number'] = $number;
				$this->param['RESULT'] = 1;
				return $this->param;
			} elseif ($number >= 1) {
				$date2 = Carbon::parse($request->current);
				$dateAfterSubtractingDays = $date2->copy()->subDays($number);
				$isLeapYear = $dateAfterSubtractingDays->isLeapYear();
				$daysInYear = $isLeapYear ? 366 : 365;   
				$weeksInYear = 52 ; 
				$currentWeekOfYear = $dateAfterSubtractingDays->weekOfYear; 
				$currentDayOfYear = $dateAfterSubtractingDays->dayOfYear;
				$this->param['daysInYear'] = $daysInYear;
				$this->param['weeksInYear'] = $weeksInYear;
				$this->param['currentWeekOfYear'] = $currentWeekOfYear;
				$this->param['currentDayOfYear'] = $currentDayOfYear;
				$this->param['date_name'] = $dateAfterSubtractingDays->dayName;
				$this->param['t_date'] = $dateAfterSubtractingDays->format('F j, Y');
					$this->param['number'] = $number;
				$this->param['RESULT'] = 1;
				return $this->param;
			}			
		}else{
			return ['error' => 'Please add Number of Weeks'];
		}
	}

	// Months From Now Calculator
	function months_from($request){
		$number = $request->number;
		if(is_numeric($number)){
			if ($number >= 1 || $number == '0') {
				$date1 = Carbon::parse($request->current);
				$dateAfterAddingDays = $date1->copy()->addMonths($number);
				$isLeapYear = $dateAfterAddingDays->isLeapYear();
				$daysInYear = $isLeapYear ? 366 : 365;   
				$weeksInYear = 52; 
				$currentWeekOfYear = $dateAfterAddingDays->weekOfYear; 
				$currentDayOfYear = $dateAfterAddingDays->dayOfYear;
				$this->param['date_name'] = $dateAfterAddingDays->dayName;
				$this->param['t_date'] = $dateAfterAddingDays->format('F j, Y');
				$this->param['daysInYear'] = $daysInYear;
				$this->param['weeksInYear'] = $weeksInYear;
				$this->param['currentWeekOfYear'] = $currentWeekOfYear;
				$this->param['currentDayOfYear'] = $currentDayOfYear;
				$this->param['number'] = $number;
				$this->param['RESULT'] = 1;
				return $this->param;
			} elseif ($number <= -1) {
				$date2 = Carbon::parse($request->current);
				$dateAfterSubtractingDays = $date2->copy()->subMonths(abs($number));
				$isLeapYear = $dateAfterSubtractingDays->isLeapYear();
				$daysInYear = $isLeapYear ? 366 : 365;   
				$weeksInYear = 52 ; 
				$currentWeekOfYear = $dateAfterSubtractingDays->weekOfYear; 
				$currentDayOfYear = $dateAfterSubtractingDays->dayOfYear;
				$this->param['daysInYear'] = $daysInYear;
				$this->param['weeksInYear'] = $weeksInYear;
				$this->param['currentWeekOfYear'] = $currentWeekOfYear;
				$this->param['currentDayOfYear'] = $currentDayOfYear;
				$this->param['date_name'] = $dateAfterSubtractingDays->dayName;
				$this->param['t_date'] = $dateAfterSubtractingDays->format('F j, Y');
				$this->param['number'] = $number;
				$this->param['RESULT'] = 1;
				return $this->param;
			}			
		}else{
			return ['error' => 'Please add Number of Months'];
		}
	}

		// Weeks Between Dates Calculator
	function days_since($request){
		$day = $request->day;
		$month = $request->month;
		$year = $request->year;
		$day1 = $request->day1;
		$month1 = $request->month1;
		$year1 = $request->year1;
		$date1 = Carbon::create($year, $month, $day);
		$date2 = Carbon::create($year1, $month1, $day1);
		$diff = $date1->diff($date2);
		$totaldays = $diff->days;
		$workingDays = 0;
		$holidays = 0;
		$currentDate = $date1;
		while ($currentDate->lte($date2)) {
			if ($currentDate->isSaturday() || $currentDate->isSunday()) {
				$holidays++;
			} else {
				$workingDays++;
			}
			$currentDate->addDay();
		}
		
		$holidays =  $totaldays - $workingDays ;
		$this->param['workingDays'] = $workingDays;
		$this->param['holidays'] = $holidays;
		$this->param['totaldays'] = $totaldays;
		$this->param['RESULT'] = 1;
		return $this->param;
	}

	
	// weeks_left calculator
	function weeks_left($request){
		$day = $request->day;
		$month = $request->month;
		$year = $request->year;
		$now = Carbon::create($year, $month, $day);
		if(is_numeric($day)){
			$isLeapYear = $now->isLeapYear();
			$daysInYear = $isLeapYear ? 366 : 365;  
			$weeksInYear = 52; 
			$endOfYear = Carbon::create($now->year, 12, 31, 23, 59, 59);
			// Calculate the difference in days
			$daysRemaining = $now->diffInDays($endOfYear);
			// Calculate the difference in weeks and days
			$weeksRemaining = $now->diffInWeeks($endOfYear);
			$remainingDaysAfterWeeks = $now->diffInDays($endOfYear) - ($weeksRemaining * 7);
			// Calculate the difference in months and days
			$monthsRemaining = $now->diffInMonths($endOfYear);
			$remainingDaysAfterMonths = $now->diffInDays($endOfYear) - ($monthsRemaining * 30); // Approximation
			// Calculate the difference in hours
			$hoursRemaining = $now->diffInHours($endOfYear);

			$this->param['now'] = $now->format('m-d-Y');
			$this->param['daysRemaining'] = $daysRemaining;
			$this->param['weeksRemaining'] = $weeksRemaining;
			$this->param['remainingDaysAfterWeeks'] = $remainingDaysAfterWeeks;
			$this->param['monthsRemaining'] = $monthsRemaining;
			$this->param['remainingDaysAfterMonths'] = $remainingDaysAfterMonths;
			$this->param['hoursRemaining'] = $hoursRemaining;
			$this->param['RESULT'] = 1;
			return $this->param;
		}
	}

	
	// until my birthday_days
	function birthday_days($request){
		$day = $request->day;
		$month = $request->month;
		$year = $request->year;
		// $endOfYear = Carbon::create($now->year, 12, 31, 23, 59, 59);
		$dob = Carbon::create($year, $month, $day);
		// Calculate the age
		$age = $dob->age;
		// Calculate the next birthday
		$now = Carbon::now();
		$nextBirthday = Carbon::create($now->year, $month, $day);
		
		if ($nextBirthday->isPast()) {
			$nextBirthday->addYear();
		}
		$daysUntilNextBirthday = $now->diffInDays($nextBirthday);
		$diffInHours = $now->diffInHours($nextBirthday);
		$diffInMinutes = $now->diffInMinutes($nextBirthday);
		$diffInMonths = $now->diffInMonths($nextBirthday);

		$this->param['nextBirthday'] = $nextBirthday;
		$this->param['dob'] = $dob->format('m-d-Y');
		$this->param['age'] = $age;
		$this->param['diffInHours'] = $diffInHours;
		$this->param['diffInMinutes'] = $diffInMinutes;
		$this->param['diffInMonths'] = $diffInMonths;
		$this->param['daysUntilNextBirthday'] = $daysUntilNextBirthday;
		$this->param['RESULT'] = 1;
		return $this->param;


	}
	
	// days ago calculator
	function days_left($request){
		$day = $request->day;
		$month = $request->month;
		$year = $request->year;
		$dob = sprintf('%04d-%02d-%02d', $year, $month, $day);
		$date1 = date('l, F d, Y', strtotime($dob));
		$now = New carbon($date1);
		if(is_numeric($day)){
			$isLeapYear = $now->isLeapYear();
			$daysInYear = $isLeapYear ? 366 : 365;  
			$weeksInYear = 52; 
			$endOfYear = Carbon::create($now->year, 12, 31, 23, 59, 59);
			$daysRemaining = $now->diffInDays($endOfYear);
			$weeksRemaining = $now->diffInWeeks($endOfYear);
			$remainingDaysAfterWeeks = $now->diffInDays($endOfYear) - ($weeksRemaining * 7);
			$monthsRemaining = $now->diffInMonths($endOfYear);
			$remainingDaysAfterMonths = $now->diffInDays($endOfYear) - ($monthsRemaining * 30);
			$hoursRemaining = $now->diffInHours($endOfYear);
			$this->param['now'] = $now->format('m-d-Y');
			$this->param['daysRemaining'] = $daysRemaining;
			$this->param['weeksRemaining'] = $weeksRemaining;
			$this->param['remainingDaysAfterWeeks'] = $remainingDaysAfterWeeks;
			$this->param['monthsRemaining'] = $monthsRemaining;
			$this->param['remainingDaysAfterMonths'] = $remainingDaysAfterMonths;
			$this->param['hoursRemaining'] = $hoursRemaining;
			$this->param['RESULT'] = 1;
			return $this->param;
		}
	}

	// julians date celander
	function julians($request){
		$day = $request->day;
		$month = $request->month;
		$year = $request->year;
		$timecheck = $request->timecheck;
		$julian = $request->julian;
		$dob = sprintf('%04d-%02d-%02d', $year, $month, $day);
		$date1 = date('l, F d, Y', strtotime($dob));

		if($timecheck == 'stat'){
			if ($month <= 2) {
				$year -= 1;
				$month += 12;
			}
			$A = floor($year / 100);
			$B = 2 - $A + floor($A / 4);
			$julianDate = floor(365.25 * ($year + 4716)) + floor(30.6001 * ($month + 1)) + $day + $B - 1524.5;	
			$this->param['julianDate'] = $julianDate;
		}else{
			if(empty($julian)){
				return ['error' => 'Please Enter Julian Date'];
			}
			$julian += 0.5;
			$Z = floor($julian);
			$F = $julian - $Z;
			if ($Z < 2299161) {
				$A = $Z;
			} else {
				$alpha = floor(($Z - 1867216.25) / 36524.25);
				$A = $Z + 1 + $alpha - floor($alpha / 4);
			}
			$B = $A + 1524;
			$C = floor(($B - 122.1) / 365.25);
			$D = floor(365.25 * $C);
			$E = floor(($B - $D) / 30.6001);
	
			$day = $B - $D - floor(30.6001 * $E) + $F;
			if ($E < 14) {
				$month = $E - 1;
			} else {
				$month = $E - 13;
			}
			if ($month > 2) {
				$year = $C - 4716;
			} else {
				$year = $C - 4715;
			}
			$year = (int) $year;
			$month = (int) $month;
			$day = (int) floor($day);

			$jul_date = sprintf('%04d-%02d-%02d', $year, $month, $day);
			$jul_date = date('l, Y F d ', strtotime($jul_date));
			$this->param['jul_date'] = $jul_date;
		}
		$this->param['date1'] = $date1;
		$this->param['timecheck'] = $timecheck;
		$this->param['RESULT'] = 1;
		return $this->param;

	}

// months_left calculator
	function months_left($request){
		$day = $request->day;
		$month = $request->month;
		$year = $request->year;
		$now = Carbon::create($year, $month, $day);
		if(is_numeric($day)){
			$isLeapYear = $now->isLeapYear();
			$daysInYear = $isLeapYear ? 366 : 365;  
			$weeksInYear = 52; 
			$endOfYear = Carbon::create($now->year, 12, 31, 23, 59, 59);
			// Calculate the difference in days
			$daysRemaining = $now->diffInDays($endOfYear);
			// Calculate the difference in weeks and days
			$weeksRemaining = $now->diffInWeeks($endOfYear);
			$remainingDaysAfterWeeks = $now->diffInDays($endOfYear) - ($weeksRemaining * 7);
			// Calculate the difference in months and days
			$monthsRemaining = $now->diffInMonths($endOfYear);
			$remainingDaysAfterMonths = $now->diffInDays($endOfYear) - ($monthsRemaining * 30); // Approximation
			// Calculate the difference in hours
			$hoursRemaining = $now->diffInHours($endOfYear);
			$this->param['now'] = $now->format('m-d-Y');
			$this->param['daysRemaining'] = $daysRemaining;
			$this->param['weeksRemaining'] = $weeksRemaining;
			$this->param['remainingDaysAfterWeeks'] = $remainingDaysAfterWeeks;
			$this->param['monthsRemaining'] = $monthsRemaining;
			$this->param['remainingDaysAfterMonths'] = $remainingDaysAfterMonths;
			$this->param['hoursRemaining'] = $hoursRemaining;
			$this->param['RESULT'] = 1;
			return $this->param;
		}
	}

	// Weeks Between Dates Calculator
	function weeks_between($request){
		$day = $request->day;
		$month = $request->month;
		$year = $request->year;
		$day1 = $request->day1;
		$month1 = $request->month1;
		$year1 = $request->year1;
		$date1 = Carbon::create($year, $month, $day);
		$date2 = Carbon::create($year1, $month1, $day1);
		// $date1 = Carbon::createFromDate($year, $month, $day);
		// $date2 = Carbon::createFromDate($year1, $month1, $day1);
		$diff = $date1->diff($date2);
		$totaldays = $diff->days;
		$days = $totaldays % 7 ; 
		$weeks = floor($totaldays / 7);
		$this->param['date1'] = $date1;
		$this->param['date2'] = $date2;
		$this->param['days'] = $days;
		$this->param['weeks'] = $weeks;
		$this->param['RESULT'] = 1;
		return $this->param;
	}



	// Playback Speed Calculator
	function playback_speed_calculator($request)
	{
		$hours = $request->hours;
		$minutes = $request->minutes;
		$seconds = $request->seconds;
		$speed = $request->speed;

		if ($hours === "" || $minutes === "" || $seconds === "" || !$speed) {
			return ['error' => 'All fields (hours, minutes, seconds, speed) are required'];
		}

		try {
			// Convert input to total seconds
			$totalSeconds = (float)$hours * 3600 + (float)$minutes * 60 + (float)$seconds;

			if ($totalSeconds <= 0) {
				return ['error' => 'Total time must be greater than zero'];
			}

			// Adjusted listening time at selected speed
			$adjustedSeconds = $totalSeconds / (float)$speed;

			// Speed range for comparison
			$speeds = [1, 1.25, 1.5, 1.75, 2];

			// Generate comparison table and chart data
			$comparisonTable = [];
			$chartData = [];

			foreach ($speeds as $sp) {
				$spSeconds = $totalSeconds / $sp;
				$saved = ((1 - $spSeconds / $totalSeconds) * 100);

				$comparisonTable[] = [
					'speed' => "{$sp}x",
					'listeningTime' => $this->formatTimeModel($spSeconds),
					'timeSaved' => number_format($saved, 1) . '% saved',
				];

				$chartData[] = [
					'speed' => $sp,
					'timeInHours' => (float)number_format($spSeconds / 3600, 2),
				];
			}

			// Calculate time saved for selected speed
			$timeSavedSeconds = $totalSeconds - $adjustedSeconds;

			return [
				'totalListeningTime' => $this->formatTimeModel($adjustedSeconds),
				'timeSaved' => $this->formatTimeModel($timeSavedSeconds),
				'selectedSpeed' => "{$speed}x",
				'speedComparison' => $comparisonTable,
				'chart' => $chartData,
				'message' => "At {$speed}x speed, your audiobook will take " . $this->formatTimeModel($adjustedSeconds) . ".",
				'RESULT' => 1
			];

		} catch (\Exception $e) {
			return ['error' => 'Please! Check Your Input.'];
		}
	}

	private function formatTimeModel($seconds)
	{
		$h = floor($seconds / 3600);
		$m = floor(($seconds % 3600) / 60);
		$s = floor($seconds % 60);
		return "{$h}h {$m}m {$s}s";
	}

	function thirty_days_from_today_calculator($request)
	{
		$days = $request->days;

		if (!$days || !is_numeric($days)) {
			return ['error' => 'Please provide a valid number of days'];
		}

		try {
			$today = \Carbon\Carbon::now();
			$futureDate = $today->copy()->addDays((int)$days);

			$diffInDays = (int)$days;
			$diffInWeeks = number_format($diffInDays / 7, 1);
			$diffInMonths = number_format($diffInDays / 30.44, 1);

			// Generate chart data (each 5 days till target)
			$chartData = [];
			for ($i = 0; $i <= $diffInDays; $i += 5) {
				$stepDate = $today->copy()->addDays($i);
				$chartData[] = [
					'label' => $stepDate->format('Y-m-d'),
					'dayCount' => $i,
				];
			}

			// Add the final day if not already added by the loop
			if (($diffInDays % 5) !== 0) {
				$chartData[] = [
					'label' => $futureDate->format('Y-m-d'),
					'dayCount' => $diffInDays,
				];
			}

			return [
				'today' => $today->format('l, F j, Y'),
				'addedDays' => $diffInDays,
				'resultDate' => $futureDate->format('l, F j, Y'),
				'resultISO' => $futureDate->format('Y-m-d'),
				'weekDay' => $futureDate->format('l'),
				'difference' => [
					'days' => $diffInDays,
					'weeks' => $diffInWeeks,
					'months' => $diffInMonths,
				],
				'chart' => $chartData,
				'message' => "{$days} days from today (" . $today->format('l, F j, Y') . ") will be " . $futureDate->format('l, F j, Y') . ".",
				'RESULT' => 1
			];

		} catch (\Exception $e) {
			return ['error' => 'Please! Check Your Input.'];
		}
	}

	// Hours calculator
	function hours($request){
		try {
			$hh = $request->hh ?? 0;
			$mm = $request->mm ?? 0;
			$ss = $request->ss ?? 0;
			$method = $request->method ?? 'AM';
			$hhe = $request->hhe ?? 0;
			$mme = $request->mme ?? 0;
			$sse = $request->sse ?? 0;
			$methode = $request->methode ?? 'PM';
			$outputformate = $request->outputformate ?? 'hr12';
			$breaks = $request->breaks ?? [];

			// Convert start time to 24-hour format
			$startHour = $hh;
			if ($outputformate == 'hr12') {
				if ($method == 'PM' && $startHour != 12) {
					$startHour += 12;
				} elseif ($method == 'AM' && $startHour == 12) {
					$startHour = 0;
				}
			}

			// Convert end time to 24-hour format
			$endHour = $hhe;
			if ($outputformate == 'hr12') {
				if ($methode == 'PM' && $endHour != 12) {
					$endHour += 12;
				} elseif ($methode == 'AM' && $endHour == 12) {
					$endHour = 0;
				}
			}

			// Create Carbon instances
			$startTime = Carbon::create(null, null, null, $startHour, $mm, $ss);
			$endTime = Carbon::create(null, null, null, $endHour, $mme, $sse);

			// If end time is before start time, assume it's the next day
			if ($endTime->lt($startTime)) {
				$endTime->addDay();
			}

			// Calculate total minutes worked
			$totalMinutes = $startTime->diffInMinutes($endTime);

			// Calculate break time
			$breakMinutes = 0;
			foreach ($breaks as $break) {
				if (!empty($break)) {
					$breakMinutes += (int)$break;
				}
			}

			// Check if break time exceeds work time
			if ($breakMinutes > $totalMinutes) {
				return ['error' => 'The break time exceeds the time worked'];
			}

			// Subtract break time
			$workedMinutes = $totalMinutes - $breakMinutes;

			// Calculate hours and minutes
			$hours = floor($workedMinutes / 60);
			$minutes = $workedMinutes % 60;

			// Format time worked
			$timeWorked = sprintf('%02d:%02d', $hours, $minutes);

			// Calculate decimal hours
			$decimalHours = round($workedMinutes / 60, 2);

			$this->param = [
				'time_worked' => $timeWorked,
				'in_hours' => $decimalHours,
				'in_minutes' => $workedMinutes,
				'RESULT' => 1,
			];

			return $this->param;

		} catch (\Exception $e) {
			return ['error' => 'An error occurred during calculation. Please check your inputs.'];
		}
	}


	/*******************
	 Decimal to Time
	 *******************/
	function decimal_to_time($request){
		 $validatedData = $request->validate([
			 'decimal' => 'required|numeric|min:0',
			 'startEvent' => 'required|string|in:days,hours,minutes,seconds',
		 ]);

		 $decimal = $validatedData['decimal'];
		 $unit = $validatedData['startEvent'];

		 $days = 0;
		 $hours = 0;
		 $minutes = 0;
		 $seconds = 0;

		 // Convert decimal based on the selected unit
		 switch ($unit) {
			case 'days':
				$days = (int) $decimal;
				$hours = (int) (($decimal * 24) % 24);
				$minutes = (int) (($decimal * 24 * 60) % 60);
				$seconds = (int) (($decimal * 24 * 60 * 60) % 60);
				break;
			case 'hours':
				$days = (int) ($decimal / 24);
				$hours = (int) ($decimal % 24);
				$minutes = (int) (($decimal * 60) % 60);
				$seconds = (int) (($decimal * 60 * 60) % 60);
				break;
			case 'minutes':
				$days = (int) ($decimal / (24 * 60));
				$hours = (int) (($decimal / 60) % 24);
				$minutes = (int) ($decimal % 60);
				$seconds = (int) (($decimal * 60) % 60);
				break;
			case 'seconds':
				$days = (int) ($decimal / (24 * 3600));
				$hours = (int) (($decimal / 3600) % 24);
				$minutes = (int) (($decimal % 3600) / 60);
				$seconds = (int) ($decimal % 60);
				break;
			default:
				return ['error' => "Invalid unit"];
		}

		 // Prepare the response array
		 $param = [
			 'days' => $days > 0 ? $days : 0,
			 'hours' => $hours,
			 'mins' => $minutes,
			 'secs' => $seconds,
			 'decimal' => $decimal,
			 'unit' => $unit

		 ];
		 return $param;
	}



	   function time_to_decimal($request)
	{
		$hh = $request->input('hh', 0);
		$mm = $request->input('mm', 0);
		$ss = $request->input('ss', 0);

		if ($hh === 0 && $mm === 0 && $ss === 0 && !$request->has('hh')) {
			return ['error' => 'Please input your time'];
		} else {
			$hour = is_numeric($hh) ? $hh : 0;
			$min = is_numeric($mm) ? $mm : 0;
			$sec = is_numeric($ss) ? $ss : 0;

			$hours = $hour + ($min / 60) + ($sec / 3600);
			$mins = ($hour * 60) + ($min) + ($sec / 60);
			$secs = ($hour * 3600) + ($min * 60) + $sec;
			$result = [
				'hour' => sprintf("%02d", $hour),
				'min' => sprintf("%02d", $min),
				'sec' => sprintf("%02d", $sec),
				'hours' => $hours,
				'mins' => $mins,
				'secs' => $secs,
			];
			return $result;
		}
	}

	// date until calculator
	function days_until($request) {
		$current = $request->current;
		$next = $request->next;
		$startEvent = $request->startEvent;
		$inc_all = $request->inc_all;
		$inc_day = $request->inc_day;
		$weekDay = $request->weekDay; // array expected

		if (!empty($current) && !empty($next)) {

			$date1 = Carbon::parse($current);
			$date2 = Carbon::parse($next);

			$diff = $date1->diff($date2);
			$totaldays = $diff->days;
			$months = $diff->m;
			$weeks = floor($totaldays / 7);
			$days = $totaldays % 7;

			$hours = 0;

			if ($inc_day) {
				$days += 1; // Add one extra day
				$totaldays += 1; 
			}

			// Agar inc_all false ho (ya null), to selected weekdays ko consider karen
			if (!$inc_all) {
				if (empty($weekDay) || !is_array($weekDay)) {
					$days = 0;
					$hours = 0;
				} else {
					$additionalDays = count($weekDay); // Count selected weekdays
					if ($additionalDays > 0) {
						$days = $weeks * $additionalDays + $days;
						$hours = $days * 24;
					}
				}
			} else {
				// Jab inc_all true ho to hours = totaldays * 24
				$hours = $totaldays * 24;
			}

			$this->param = [
				'totaldays' => $totaldays,
				'months' => $months,
				'weeks' => $weeks,
				'days' => $days,
				'hours' => $hours,
				'RESULT' => 1,
			];

			return $this->param;

		} else {
			$this->param['error'] = 'Please! Check Your Input';
			return $this->param;
		}
	}


		// Doubling Time Calculator
	function doubling($request)
	{
		$x = $request->x;
		$want = $request->want;
		if (is_numeric($x) && is_numeric($want)) {
			if ($want == 1) {
				$ans = log(2) / (log(1 + ($x / 100)));
			} else {
				$ans = log(2) / ($x);
				$ans = pow(2.71828, $ans) - 1;
				$ans = $ans * 100;
			}
			$result = [
				'ans'  => $ans,
				'RESULT'  => 1,
			];
			return $result;
		} else {
			return ['error' => 'Please! Check Your Input'];
		}
	}


		/*******************
    	Time of Flight Calculator
	 *******************/
	function time_flight($request)
	{
		$a = trim($request->a);
		$a_unit = trim($request->a_unit);
		$h = trim($request->h);
		$h_unit = trim($request->h_unit);
		$v = trim($request->v);
		$v_unit = trim($request->v_unit);
		$g = trim($request->g);
		$g_unit = trim($request->g_unit);

		if (is_numeric($a) && is_numeric($h) && !empty($v) && !empty($g) && !empty($a_unit) && !empty($h_unit) && !empty($v_unit) && !empty($g_unit)) {

			function sigFig($value, $digits)
			{
				if ($value === 0) {
					$decimalPlaces = $digits - 1;
				} elseif ($value < 0) {
					$decimalPlaces = $digits - floor(log10($value * -1)) - 1;
				} else {
					$decimalPlaces = $digits - floor(log10($value)) - 1;
				}
				$answer = round($value, $decimalPlaces);
				return $answer;
			}
			if (is_numeric($h)) {
				if ($h_unit === 'cm') {
					$h = $h / 100;
				} elseif ($h_unit === 'km') {
					$h = $h / 0.001;
				} elseif ($h_unit === 'in') {
					$h = $h / 39.37;
				} elseif ($h_unit === 'ft') {
					$h = $h / 3.281;
				} elseif ($h_unit === 'yd') {
					$h = $h / 1.0936;
				} elseif ($h_unit === 'mi') {
					$h = $h / 0.0006214;
				}
			}
			if (is_numeric($v)) {
				if ($v_unit === 'kmh') {
					$v = $v / 3.6;
				} elseif ($v_unit === 'fts') {
					$v = $v / 3.28;
				} elseif ($v_unit === 'mph') {
					$v = $v / 2.237;
				}
			}
			if ($a_unit === 'deg') {
				$vx = $v * cos(deg2rad($a));
				$sin = sin(deg2rad($a));
				$vy = $v * sin(deg2rad($a));
			} else {
				$vx = $v * cos($a);
				$sin = sin($a);
				$vy = $v * sin($a);
			}
			if (is_numeric($g)) {
				if ($g_unit === 'g') {
					$g = $g * 9.807;
				}
			}
			if ($h == 0) {
				$res = 2 * $vy;
				$tof = 2 * $vy / $g;
				$result['res'] = sigFig($res, 4);
			} else {
				$gh = 2 * $g * $h;
				$pvy = pow($vy, 2);
				$vs2gh = $pvy + $gh;
				$sqrvs2gh = sqrt($vs2gh);
				$vysqrt = $vy + $sqrvs2gh;
				$tof = ($vy + (sqrt(pow($vy, 2) + 2 * $g * $h))) / $g;
				$result['pvy'] = $pvy;
				$result['gh'] = $gh;
				$result['vs2gh'] = $vs2gh;
				$result['sqrvs2gh'] = $sqrvs2gh;
				$result['vysqrt'] = sigFig($vysqrt, 4);
			}
			
			$final_result = [
				'h'  => $h,
				'a'   => $a,
				'sin' 	=> sigFig($sin, 4),
				'v' => sigFig($v, 4),
				'tof'   => sigFig($tof, 4),
				'check'   	=> 'tof',
				'g'   	=> sigFig($g, 4),
				'vx'   	=> sigFig($vx, 4),
				'vy'   	=> sigFig($vy, 4),
				'RESULT'  => 1,
			];
			return array_merge($result, $final_result);
		} else {
			return ['error' => 'Please! Check Your Input'];
		}
	}




		// --- Main Function
	 function SleepCalculator($request)
	{
		$WhichForSubmit = $request->submit; // SimpleSleep OR SleepLength
		$SleepCyles = [1, 2, 3, 4, 5, 6, 7];
		$result = [];

		if ($WhichForSubmit === "SimpleSleep") {
			// --- For Sleep Calculator Tab Form
			$SleepType = $request->stype; // 'wkup' OR "bedtime"
			$Hours = $request->h;
			$result['ResultFor'] = 'SimpleSleep';

			if ($SleepType == 'wkup') {
				foreach ($SleepCyles as $cycles) {
					$result[$cycles] = $this->calculateSleepTime($Hours, $cycles); // Supportive Function 1
				}
				$result['stype'] = 'wkup';
				// dd($result);
			} else {
				foreach ($SleepCyles as $cycles) {
					$result[$cycles] = $this->calculateWakeUpTime($Hours, $cycles); // Supportive Function 2
				}
				$result['stype'] = 'bedtime';
				// dd($result);
			}
		} else {
			// --- For Sleep Length Calculator Tab Form
			$SleepType = $request->sleep_type; // 'sleep_wkup' OR "sleep_bedtime"
			$wakeUpTime = $request->h1;
			$sleepHours = $request->sleephour;
			$sleepMinutes = $request->sleep_minutes;
			$result['ResultFor'] = 'SleepLength';
			// dd($request->all());

			if ($SleepType == 'sleep_wkup') {
				$result['BedTime'] = $this->calculateSleepTimelength($wakeUpTime, $sleepHours, $sleepMinutes); // Supportive Function 3
				$result['stype'] = 'sleep_wkup';
				// dd($result);
			} else {
				$result['WakupTime'] = $this->calculateWakeUpTimelength($wakeUpTime, $sleepHours, $sleepMinutes); // Supportive Function 4
				$result['stype'] = 'sleep_bedtime';
				// dd($result);
			}
		}
		// dd($result);
		return $result;
	}

		// 1: Supportive Functions For Sleep Calculator 'wkup'
		public function calculateSleepTime($wakeUpTime, $cycles)
		{
			$sleepCycleLength = 90;
			$latency = 15 * 60; // --- Latency: is a time required to fall asleep
	
			// Convert wake-up time to timestamp
			$wakeUp = strtotime($wakeUpTime);
	
			// Calculate the total sleep time in minutes (cycle count * cycle length)
			$totalSleepMinutes = $cycles * $sleepCycleLength;
	
			// Calculate the recommended sleep time by subtracting the total sleep duration from wake-up time
			$sleepTime = $wakeUp - $latency - ($totalSleepMinutes * 60); // Convert minutes to seconds
			// dd($sleepTime);
			return date('h:i A', $sleepTime); //--- It Will Return time like 10:30 PM
		}
	
		// 2: Supportive Functions For Sleep Calculator "bedtime"
		function calculateWakeUpTime($sleepTime, $cycles)
		{
			// Define sleep cycle length in minutes (90 minutes)
			$sleepCycleLength = 90;
			$latency = 15 * 60; // --- Latency: is a time required to fall asleep
	
			// Convert sleep time to timestamp
			$sleep = strtotime($sleepTime);
	
			// Calculate the total sleep duration in minutes (cycle count * cycle length)
			$totalSleepMinutes = $cycles * $sleepCycleLength;
	
			// Calculate the recommended wake-up time by adding the total sleep duration to sleep time
			$latency = 15 * 60; // --- Latency: is a time required to fall asleep
			$wakeUpTime = $sleep + $latency + ($totalSleepMinutes * 60); // Convert minutes to seconds
	
			// Return the wake-up time as a formatted time (h:i A for 12-hour format)
			return date('h:i A', $wakeUpTime); //--- It Will Return time like 10:30 PM
		}
	
		// 3: Supportive Functions For Sleep Calculator
		function calculateSleepTimelength($wakeUpTime, $sleepHours, $sleepMinutes)
		{
			// Convert wake-up time to timestamp
			$wakeUp = strtotime($wakeUpTime);
	
			// Calculate total sleep duration in minutes
			$totalSleepMinutes = ($sleepHours * 60) + $sleepMinutes;
	
			// Calculate the recommended sleep time by subtracting the total sleep duration from the wake-up time
			$sleepTime = $wakeUp - ($totalSleepMinutes * 60); // Convert minutes to seconds
	
			// Return the sleep time as a formatted time (h:i A for 12-hour format)
			return date('h:i A', $sleepTime);
		}
	
		// 4: Supportive Functions For Sleep Calculator
		public function calculateWakeUpTimelength($sleepTime, $sleepHours, $sleepMinutes)
		{
			// Convert sleep time to timestamp
			$sleep = strtotime($sleepTime);
	
			// Calculate total sleep duration in minutes
			$totalSleepMinutes = ($sleepHours * 60) + $sleepMinutes;
	
			// Calculate the recommended wake-up time by adding the total sleep duration to the sleep time
			$wakeUpTime = $sleep + ($totalSleepMinutes * 60); // Convert minutes to seconds
	
			// Return the wake-up time as a formatted time (h:i A for 12-hour format)
			return date('h:i A', $wakeUpTime);
		}


		// Travel Time Calculator

   function travel($request)
	{
		$distance       = $request->input('distance');
		$distance_unit  = $request->input('distance_unit');
		$speed          = $request->input('speed');
		$speed_unit     = $request->input('speed_unit');
		$break_hrs      = $request->input('break_hrs');
		$break_min      = $request->input('break_min');
		$dep_time       = $request->input('dep_time');
		$fule_effi      = $request->input('fule_effi');
		$fule_effi_unit = $request->input('fule_effi_unit');
		$price          = $request->input('price');
		$price_unit     = $request->input('price_unit');
		$currancy = $request->input('currancy');
		$price_unit = str_replace($currancy, '', $price_unit);
		$passenger      = $request->input('passenger');

		if (!function_exists('convert_to_km')) {
			function convert_to_km($unit, $value)
			{
				if ($unit == 'mi') {
					$ans = $value * 1.609;
				} else {
					$ans = $value;
				}
				return $ans;
			}
		}
		if (!function_exists('convert_to_kmpl')) {
			function convert_to_kmpl($unit, $value)
			{
				if ($unit == 'mpg') {
					$ans = $value / 2.352;
				} else {
					$ans = $value;
				}
				return $ans;
			}
		}
		if (is_numeric($distance) && is_numeric($speed) && is_numeric($break_hrs) && is_numeric($break_min) && is_numeric($fule_effi) && is_numeric($price) && is_numeric($passenger) && !empty($dep_time)) {
			// dd('$request->input()');

			$distance_f  = convert_to_km($distance_unit, $distance);
			$fule_effi_f = convert_to_kmpl($fule_effi_unit, $fule_effi);
			$speed_f     = convert_to_km($speed_unit, $speed);
			$price_f     = (trim($price_unit) == "liter") ? $price : $price / 3.785;

			$break_hr    = (($break_hrs * 60) + $break_min) / 60;
			$travel_time = ($distance_f / $speed_f) + $break_hr;
			$time_array  = explode('.', $travel_time);
			$hours       = $time_array[0];
			$mins        = round(($travel_time - $hours) * 60);

			$tym        = date('Y-m-d H:i:s', strtotime("+" . $hours . " hours", strtotime($dep_time)));
			$arrival    = date('M d, Y h:i:s A', strtotime("+" . $mins . " minutes", strtotime($tym)));
			$depature   = date('M d, Y h:i:s A', strtotime($dep_time));

			$fule_req   = round($distance_f / $fule_effi_f, 2);
			$fule_price = round($fule_req * $price_f, 2);
			$per_person = round($fule_price / $passenger, 2);

			$result = [
				'hours'  => $hours,
				'mins'   => $mins,
				'depature' 	=> $depature,
				'arrival' => $arrival,
				'fule_price'   => number_format($fule_price, 2),
				'per_person'   	=> number_format($per_person, 2),
				'RESULT'  => 1,
			];
			return $result;
		} else {
			return ['error' => 'Please! Check Your Input'];
		}
	}


		// Overtime Calculator

	public function overtime(Request $request)
	{
		$pay = $request->pay;
		$per = $request->per;
		$time = $request->time;
		$timeper = $request->timeper;
		$multi = $request->multi;
		$over = $request->over;
		$overper = $request->overper;
		$overtime = $request->overtime;

		if (is_numeric($request->pay) && $request->per && is_numeric($request->time) && $request->timeper && is_numeric($request->multi)  && is_numeric($request->over)) {
			$hourly = $pay;
			if ($per == 'hour') {
				$hourly = $hourly;
			} else if ($per == 'day') {
				$hourly = $hourly / 8;
			} elseif ($per == 'week') {
				$hourly = $hourly / 40;
			} else {
				$hourly = $hourly / 173.6;
			}
			$monthTime = $time;
			if ($timeper == 'h_m') {
				$monthTime = $monthTime;
			} elseif ($timeper == 'd_m') {
				$monthTime = ($monthTime * 8);
				// dd($monthTime);
			} elseif ($timeper == 'w_m') {
				$monthTime = $monthTime * 5 * 8;
			} elseif ($timeper == 'h_w') {
				$monthTime = $monthTime * 4.344;
			} elseif ($timeper == 'd_w') {
				$monthTime = ($monthTime * 8) * 4.345;
			} elseif ($timeper == 'h_d') {
				$monthTime = ($monthTime * 5) * 4.345;
			}
			$regPay = round($hourly * $monthTime, 4);

			$overPayPerHour = round($multi * $hourly, 4);
			$overHour = round($over, 4);
			$overHour = round($overHour, 4);
			$overTotalPay = round($overHour * $overPayPerHour, 4);

			$result = [
				'overPayPerHour' => $overPayPerHour,
				'overTotalPay' => $overTotalPay,
				'regPay' =>  $regPay,
				'total' => $overTotalPay + $regPay,
				'RESULT' => 1,
			];
			return $result;
		} else {
			return ['error' => 'Please! Check Your Input'];
		}
	}


			/*******************
		Time adn half calculator
	 *******************/
	 function time_and_half($request){
		$daily_rate = $request->daily_rate;
		$working_hour = $request->working_hour;
		$normal_pay = $request->normal_pay;
		$normal_time = $request->normal_time;
		$selected_value = $request->selected_value;
		if($selected_value == null){
			if(is_numeric($daily_rate)){
				$standard_hour_rate = $daily_rate ;
				$time_and_half = $standard_hour_rate * 1.5;
				$Time_and_half_pay = $time_and_half * $normal_pay;
				$Standard_pay = $standard_hour_rate * $normal_time;

				$result = [
					'standard_hour_rate' => $standard_hour_rate,
					'time_and_half' => $time_and_half,
					'Time_and_half_pay' => $Time_and_half_pay,
					'Standard_pay' => $Standard_pay,
				];
				return $result;
			}else{
				return ['error' => 'please input Standerd pay rate'];
			}
		}else{
			if(is_numeric($daily_rate)){
				$standard_hour_rate = $daily_rate / $working_hour;
				$time_and_half = $standard_hour_rate * 1.5;
				$Time_and_half_pay = $time_and_half * $normal_pay;
				$Standard_pay = $standard_hour_rate * $normal_time;

				$result = [
					'standard_hour_rate' => $standard_hour_rate,
					'time_and_half' => $time_and_half,
					'Time_and_half_pay' => $Time_and_half_pay,
					'Standard_pay' => $Standard_pay,
				];
				return $result;
			}else{
				return ['error' => 'please input Standerd pay rate'];
			}
		}
	}


		/*******************
		Average time Calculator
	 *******************/
	function average()
	{
		if (isset($_POST['submit'])) {
			$count_val = $_POST['count_val'];
			if (isset($_POST['inhour'])) {
				$inhour = $_POST['inhour'];
			} else {
				$inhour = false;
			}
			if (isset($_POST['inminutes'])) {
				$inminutes = $_POST['inminutes'];
			} else {
				$inminutes = false;
			}
			if (isset($_POST['inseconds'])) {
				$inseconds = $_POST['inseconds'];
			} else {
				$inseconds = false;
			}
			if (isset($_POST['inmiliseconds'])) {
				$inmiliseconds = $_POST['inmiliseconds'];
			} else {
				$inmiliseconds = false;
			}
			if (isset($_POST['checkbox1'])) {
				$checkbox1 = $_POST['checkbox1'];
			} else {
				$checkbox1 = false;
			}
			if (isset($_POST['checkbox2'])) {
				$checkbox2 = $_POST['checkbox2'];
			} else {
				$checkbox2 = false;
			}
			if (isset($_POST['checkbox3'])) {
				$checkbox3 = $_POST['checkbox3'];
			} else {
				$checkbox3 = false;
			}
			if (isset($_POST['checkbox4'])) {
				$checkbox4 = $_POST['checkbox4'];
			} else {
				$checkbox4 = false;
			}
			$count_val = $_POST['count_val'];
		} elseif (isset($_GET['res_link'])) {
			$count_val = $_GET['count_val'];
			if (isset($_GET['inhour'])) {
				$inhour = $_GET['inhour'];
			} else {
				$inhour = false;
			}
			if (isset($_GET['inminutes'])) {
				$inminutes = $_GET['inminutes'];
			} else {
				$inminutes = false;
			}
			if (isset($_GET['inseconds'])) {
				$inseconds = $_GET['inseconds'];
			} else {
				$inmiliseconds = false;
			}
			if (isset($_GET['inmiliseconds'])) {
				$inmiliseconds = $_GET['inmiliseconds'];
			} else {
				$inmiliseconds = false;
			}
			if (isset($_GET['checkbox1'])) {
				$checkbox1 = $_GET['checkbox1'];
			} else {
				$checkbox1 = false;
			}
			if (isset($_GET['checkbox2'])) {
				$checkbox2 = $_GET['checkbox2'];
			} else {
				$checkbox2 = false;
			}
			if (isset($_GET['checkbox3'])) {
				$checkbox3 = $_GET['checkbox3'];
			} else {
				$checkbox3 = false;
			}
			if (isset($_GET['checkbox4'])) {
				$checkbox4 = $_GET['checkbox4'];
			} else {
				$checkbox4 = false;
			}
			$count_val = $_GET['count_val'];
		}
		// functions
		function calc_time(array $times)
		{
			$i = 0;
			foreach ($times as $time) {
				sscanf($time, '%d:%d:%d', $hour, $min, $sec);
				$i += $hour * 3600 + $min * 60 + $sec;
			}
			return $i;
		}
		function avg_time(array $times)
		{
			$i = calc_time($times);
			$i = round($i / count($times));
			if ($h = floor($i / 3600)) $i %= 3600;
			if ($m = floor($i / 60)) $i %= 60;
			$h = sprintf('%02d', $h);
			$m = sprintf('%02d', $m);
			$s = sprintf('%02d', $i);
			return array($h, $m, $s);
		}
		$i = 0;
		while ($i < $count_val) {
			if ($checkbox1 == false) {
				$inhour[$i] = 0;
			} else {
				if ($inhour[$i] === "") {
					$inhour[$i] = 0;
				}else{
					$inhour[$i];
				}
			}
			if ($checkbox2 == false) {
				$inminutes[$i] = 0;
			} else {
				if ($inminutes[$i] === "") {
					$inminutes[$i] = 0;
				}else{
					$inminutes[$i];
				}
			}
			if ($checkbox3 == false) {
				$inseconds[$i] = 0;
			} else {
				if ($inseconds[$i] === "") {
					$inseconds[$i] = 0;
				}else{
					$inseconds[$i];
				}
			}
			if ($checkbox4 == false) {
				$inmiliseconds[$i] = 0;
			} else {
				if ($inmiliseconds[$i] === "") {
					$inmiliseconds[$i] = 0;
				}else{
					$inmiliseconds[$i];
				}
			}
			if (empty($inhour[$i]) && empty($inminutes[$i]) && empty($inseconds[$i]) && empty($inmiliseconds[$i])) {
				return ['error' => 'Please! Check Your Input'];
			}
			if (is_numeric($inhour[$i]) && is_numeric($inminutes[$i]) && is_numeric($inseconds[$i]) && is_numeric($inmiliseconds[$i])) {
			// if (is_numeric($inhour[$i]) ) {
				$hour_list[] = $inhour[$i];
				$min_list[] = $inminutes[$i];
				$sec_list[] = $inseconds[$i];
				$mili_list[] = $inmiliseconds[$i];
				$total_seconds = ($inhour[$i] * 3600) + ($inminutes[$i] * 60) + $inseconds[$i];
				$hours = floor($total_seconds / 3600);
				$mins = floor($total_seconds / 60 % 60);
				$secs = floor($total_seconds % 60);
				$hoursminsandsecs[] = sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
			} else {
				return ['error' => 'Please! Check Your Input'];
			}
			$i++;
		}
		list($hr, $min, $s) = avg_time($hoursminsandsecs);
		$totalo_milisec = array_sum($mili_list);
		$mili_jawab = $totalo_milisec / count($mili_list);
		$result = [
			'hour_list' => $hour_list,
			'min_list' => $min_list,
			'sec_list' => $sec_list,
			'mili_list' => $mili_list,
			'time_hour' => sprintf('%02d', $hr),
			'time_seconds' => sprintf('%02d', $s),
			'time_minutes' => sprintf('%02d', $min),
			'time_miliseconds' => $mili_jawab,
		];
		return $result;
	}


		/*******************
		Dilation-calculator
	 *******************/
	public static function dilation($data = [])
	{
		$data = (array) $data;
		$interval = $data['interval'] ?? 0;
		$interval_sec = $data['interval_sec'] ?? 0;
		$interval_unit = $data['interval_unit'] ?? 'sec';
		$velocity = $data['velocity'] ?? 0;
		$velocity_unit = $data['velocity_unit'] ?? 'm/s';

		if ($interval_unit === 'mins/sec' || $interval_unit === 'hrs/mins' || $interval_unit === 'yrs/mos' || $interval_unit === 'wks/days') {
			if (empty($interval) && empty($interval_sec)) {
				return ['error' => 'Please! Enter Input'];
			}
			$interval = self::other_time_dilation($interval, $interval_sec, $interval_unit);
		} else {
			if (!is_numeric($interval)) {
				return ['error' => 'Please! Check Your Input'];
			}
			$interval = self::time_unit_dilation($interval, $interval_unit);
		}

		if (!is_numeric($velocity)) {
			return ['error' => 'Please! Check Your Input'];
		}

		$velocity_km_s = self::speed_unit_dilation($velocity, $velocity_unit);
		$observer_velocity_m_s = $velocity_km_s * 1000;
		$speed_of_light = 299792458;

		if ($observer_velocity_m_s >= $speed_of_light) {
			return ['error' => 'Velocity must be less than the speed of light (c)'];
		}

		$lorentz_factor = 1 / sqrt(1 - (($observer_velocity_m_s ** 2) / ($speed_of_light ** 2)));
		$answer = $lorentz_factor * $interval;

		return [
			'RESULT' => 1,
			'answer' => $answer,
			'lorentz_factor' => $lorentz_factor
		];
	}

	private static function speed_unit_dilation($velocity, $velocity_unit)
	{
		if ($velocity_unit == "m/s") {
			$velocity =  $velocity / 1000;
		} elseif ($velocity_unit == "km/s") {
			$velocity = $velocity;
		} elseif ($velocity_unit == "mi/s") {
			$velocity = $velocity * 1.60934;
		} elseif ($velocity_unit == "c") {
			$velocity = $velocity * 299792.458;
		}
		return $velocity;
	}

	private static function time_unit_dilation($interval, $interval_unit)
	{
		if ($interval_unit == "sec") {
			$interval = $interval;
		} elseif ($interval_unit == "mins") {
			$interval = $interval * 60;
		} elseif ($interval_unit == "hrs") {
			$interval = $interval * 3600;
		} elseif ($interval_unit == "days") {
			$interval = $interval * 86400;
		} elseif ($interval_unit == "wks") {
			$interval = $interval * 604800;
		} elseif ($interval_unit == "mos") {
			$interval = $interval * 2629800;
		} elseif ($interval_unit == "yrs") {
			$interval = $interval * 31557600;
		}
		return $interval;
	}

	private static function other_time_dilation($interval, $interval_sec, $interval_unit)
	{
		if ($interval_unit === "mins/sec") {
			$interval = ($interval * 60) + $interval_sec;
		} elseif ($interval_unit === "hrs/mins") {
			$interval = ($interval * 3600) + ($interval_sec * 60);
		} elseif ($interval_unit === "yrs/mos") {
			$interval = ($interval * 31557600) + ($interval_sec * 2629800);
		} elseif ($interval_unit === "wks/days") {
			$interval = ($interval * 604800) + ($interval_sec * 86400);
		}
		return $interval;
	}



		/*******************
    	Drive Time Calculator
	 *******************/
	 function drive($request)
	{
		$distance = $request->input("distance");
		$distance_unit = $request->input("distance_unit");
		$average_speed = $request->input("average_speed");
		$average_speed_unit = $request->input("average_speed_unit");
		$breaks = $request->input("breaks");
		$breaks_unit = $request->input("breaks_unit");
		$departure_time = $request->input("departure_time");
		$fuel_e = $request->input("fuel_e");
		$fuel_e_unit = $request->input("fuel_e_unit");
		$fuel_p = $request->input("fuel_p");
		$currancy = $request->input("currancy");
		$fuel_p = str_replace($currancy, '', $fuel_p);
		$fuel_p_unit = $request->input("fuel_p_unit");
		$passengers = $request->input("passengers");
		if (is_numeric($distance) && is_numeric($average_speed) && is_numeric($passengers) && is_numeric($fuel_p)) {
			if (isset($breaks_unit)) {
				if ($breaks_unit == 'sec') {
					$breaks = $breaks / 60;
				} elseif ($breaks_unit == 'hrs') {
					$breaks = $breaks * 60;
				} elseif ($breaks_unit == 'days') {
					$breaks = $breaks * 24 * 60;
				} elseif ($breaks_unit == 'wks') {
					$breaks = $breaks * 10080;
				}
			}
			if (isset($distance_unit)) {
				if ($distance_unit === 'km') {
					$distance = $distance;
				} elseif ($distance_unit === 'm') {
					$distance = $distance / 1000;
				} elseif ($distance_unit === 'mi') {
					$distance = round($distance * 1.609);
				} elseif ($distance_unit === 'nmi') {
					$distance = $distance * 1.852;
				}
			}
			if (isset($average_speed_unit)) {
				if ($average_speed_unit === 'km/h') {
					$average_speed = $average_speed;
				} elseif ($average_speed_unit === 'm/s') {
					$average_speed = $average_speed * 3.6;
				} elseif ($distance_unit === 'mph') {
					$average_speed = $average_speed * 1.609;
				}
			}
			if (isset($fuel_e_unit)) {
				if ($fuel_e_unit === 'L/100km') {
					$fuel_e = $fuel_e;
				} elseif ($fuel_e_unit === 'us mpg') {
					$fuel_e = 235.215 / $fuel_e;
				} elseif ($fuel_e_unit === 'uk mpg') {
					$fuel_e = 282.5 / $fuel_e;
				} elseif ($fuel_e_unit === 'km/L') {
					$fuel_e = 100 / $fuel_e;
				}
			}
			if (isset($fuel_p_unit)) {
				if ($fuel_p_unit === '/L') {
					$fuel_p = $fuel_p;
				} elseif ($fuel_p_unit === '/us gal') {
					$fuel_p = $fuel_p * 0.26;
				} elseif ($fuel_p_unit === '/uk gal') {
					$fuel_p = $fuel_p * 0.22;
				}
			}
			// Calculate total drive time
			$total_breaks_hours = $breaks / 60;
			$total_drive_hours = ($distance / $average_speed) + $total_breaks_hours;
			// Calculate arrival time
			if (!empty($departure_time)) {
				$departure_timestamp = strtotime($departure_time);
				$arrival_timestamp = $departure_timestamp + ($total_drive_hours * 3600);
				$arrival_time = date("d F Y, h:i A", $arrival_timestamp);
				$result['arrival_time'] = $arrival_time;
				// dd($result['arrival_time']);
			}
			// Calculate total drive cost
			$total_drive_cost = ($distance / 100) * $fuel_e * $fuel_p;
			// Calculate drive cost per person
			$drive_cost_per_person = $total_drive_cost / $passengers;
			$result = [
				'total_drive_hours' => $total_drive_hours,
				'total_drive_cost'  => $total_drive_cost,
				'drive_cost_per_person' => $drive_cost_per_person,
				'RESULT' => 1,
			];
			if (!empty($departure_time)) {
				$result['arrival_time'] = $arrival_time;
			}
		} else {
			return ['error' => 'Please! Check Your Input'];
		}

		// dd($result);
		return $result;
	}

}
