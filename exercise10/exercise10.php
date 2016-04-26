<?php

define("FIRST_MONTH", "January");

class Artist {
    const EARLIEST_DATE = 'January 1, 1200';
    public static $artistCount = 0;
    private $firstName;
	private $lastName;
	private $birthDate;
	private $birthCity;
	private $deathDate;
	
	function __construct($firstName, $lastName, $city, 
		$birth, $death=null) {
		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->birthCity = $city;
		$this->birthDate = $birth;
		$this->deathDate = $death;
		self::$artistCount++;
	}
	
	public function outputAsTable() {
		$table = "<table>";
		$table .= "<tr><th colspan='2'>";
		$table .= $this->firstName . " " . $this->lastName;
		$table .= "</th></tr>";
		$table .= "<tr><td>Birth:</td>";
		$table .= "<td>" . $this->birthDate;
		$table .= "(" . $this->birthCity . ")</td></tr>";
		$table .= "<tr><td>Death:</td>";
		$table .= "<td>" . $this->deathDate . "</td></tr>";
		$table .= "</table>";
		return $table;
	}
}

$picasso = new Artist("Pablo","Picasso","Malaga","Oct 25,1881",
"Apr 8,1973");
$dali = new Artist("Salvador","Dali","Figures","May 11 1904",
"Jan 23 1989");
echo $picasso->outputAsTable();
echo $dali->outputAsTable();


/* if members are public...

$picasso = new Artist();
$dali = new Artist();
$picasso->firstName = "Pablo";
$picasso->lastName = "Picasso";
$picasso->birthCity = "Malaga";
$picasso->birthDate = "October 25 1881";
$picasso->deathDate = "April 8 1973";
*/
?>