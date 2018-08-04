<?php

/**
 * 
 */
class Calender
{
	private $region;
	private $now;
	private $pray_data;
	private $pray_time;
	private $pray_time_unix;

	function __construct($_city, $_country, $_zone, $_calender_type)
	{
		$this->region["city"]			= $_city; 
		$this->region["country"]		= $_country; 
		$this->region["zone"]			= $_zone; 
		$this->region["calender_type"]	= $_calender_type; 

		date_default_timezone_set($_zone);
		//now time
		$date['d']  	= date('d', time());
		$date['m']  	= date('m', time());
		$date['y']  	= date('Y', time());
		$date['h']  	= date('H', time());
		$date['i']  	= date('i', time());
		$date['full']  	= date('d/m/Y H:i', time());
		$date['time']  	= time();
		$this->now 		= $date;
	}

	/**
	 * 
	 */
	private function pray_time()
	{

		//api nedded data
		$pray_data["city"] 				= $this->region["city"];
		$pray_data["country"] 			= $this->region["country"];
		$pray_data["timezonestring"] 	= $this->region["zone"];
		$pray_data["method"] 			= "7";
		$pray_data["day"] 				= (int)$this->now['d'] - 1;
		$this->pray_data 				= $pray_data;

		//API
		$api["url"] = "http://api.aladhan.com/v1/calendarByCity?city=".$pray_data["city"]."&country=".$pray_data["country"]."&method=".$pray_data["method"]."&month=".$this->now['m']."&year=".$this->now['y']."&timezonestring=".$pray_data["timezonestring"]; 
		$json = file_get_contents($api["url"]);

		$deecode = json_decode($json, true);
		foreach ($deecode as $key => $value) 
		{
			if (is_array($value)) 
			{
				$pray_array = $value[$pray_data["day"]];
			}
		}

		//api  outpot data
		$pray["fajr"]		= $pray_array["timings"]["Fajr"];
		$pray["sunrise"]	= $pray_array["timings"]["Sunrise"];
		$pray["dhuhr"]		= $pray_array["timings"]["Dhuhr"];
		$pray["sunset"]		= $pray_array["timings"]["Sunset"];
		$pray["maghrib"]	= $pray_array["timings"]["Maghrib"];
		$this->pray_time 	= $pray;

		//make api outpot to unix time
		$pray_unix["fajr"]		= DateTime::createFromFormat('d/m/Y @ H:i', $this->now['d'].'/'.$this->now['m'].'/'.$this->now['y'].' @ '.substr($pray["fajr"], 0, 5))->getTimestamp();
		$pray_unix["sunrise"]	= DateTime::createFromFormat('d/m/Y @ H:i', $this->now['d'].'/'.$this->now['m'].'/'.$this->now['y'].' @ '.substr($pray["sunrise"], 0, 5))->getTimestamp();
		$pray_unix["dhuhr"]		= DateTime::createFromFormat('d/m/Y @ H:i', $this->now['d'].'/'.$this->now['m'].'/'.$this->now['y'].' @ '.substr($pray["dhuhr"], 0, 5))->getTimestamp();
		$pray_unix["sunset"]	= DateTime::createFromFormat('d/m/Y @ H:i', $this->now['d'].'/'.$this->now['m'].'/'.$this->now['y'].' @ '.substr($pray["sunset"], 0, 5))->getTimestamp();	
		$pray_unix["maghrib"]	= DateTime::createFromFormat('d/m/Y @ H:i', $this->now['d'].'/'.$this->now['m'].'/'.$this->now['y'].' @ '.substr($pray["maghrib"], 0, 5))->getTimestamp();
		$this->pray_time_unix 	= $pray_unix;

		return true;
	}

	/**
	 * 
	 */
	public function get_first_delay()
	{
		$this->pray_time();
		$unix_fajr 		= $this->pray_time_unix["fajr"]		-	$this->now["time"];  
		$unix_sunrise 	= $this->pray_time_unix["sunrise"] 	-	$this->now["time"];  
		$unix_dhuhr 	= $this->pray_time_unix["dhuhr"] 	-	$this->now["time"];  
		$unix_sunset 	= $this->pray_time_unix["sunset"] 	-	$this->now["time"];  
		$unix_maghrib 	= $this->pray_time_unix["maghrib"] 	-	$this->now["time"]; 
		
		if ($unix_fajr > 0) 
		{
			$export["delay"] = ($unix_fajr * 1000);
			$export["type"] = "fajr";
		}
		elseif ($unix_sunrise > 0) 
		{
			$export["delay"] = ($unix_sunrise * 1000);
			$export["type"] = "sunrise";			
		}
		elseif ($unix_dhuhr > 0) 
		{
			$export["delay"] = ($unix_dhuhr * 1000);
			$export["type"] = "dhuhr";
		}
		elseif ($unix_sunset > 0) 
		{
			$export["delay"] = ($unix_sunset * 1000);
			$export["type"] = "sunset";
		}
		elseif ($unix_maghrib > 0) 
		{
			$export["delay"] = ($unix_maghrib * 1000);
			$export["type"] = "maghrib";			
		}
		else
		{
			$export["delay"] = (7200 * 1000);
			$export["type"] = "delay";
			//7200 s
		}
		return $export;
	}


}