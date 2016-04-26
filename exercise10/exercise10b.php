<!-- filename: exercise10b.php
     author: george corser, cis355, winter2016
	 description: demonstrates encapsulation, inheritance, polymorphism
	              and interfaces
-->
<html>
<body>
<h2>Tester for Artist class</h2>
<?php
// first must include the class definition
include 'Artist.class.php';
// now create one instance of the Artist class
$picasso = new Artist("Pablo","Picasso","Malaga","Oct 25,1881",
"Apr 8,1973");
// output some of its fields to test the getters
echo $picasso->getLastName() . ': ';
echo date_format($picasso->getBirthDate(),'d M Y') . ' to ';
echo date_format($picasso->getDeathDate(),'d M Y') . '<hr>';
// create another instance and test it
$dali = new Artist("Salvador","Dali","Figures","May 11,1904",
"January 23,1989");
echo $dali->getLastName() . ': ';
echo date_format($dali->getBirthDate(),'d M Y') . ' to ';
echo date_format($dali->getDeathDate(),'d M Y'). '<hr>';
// test the output method
echo $picasso->outputAsTable();
// finally test the static method: notice its syntax
echo '<hr>';
echo 'Number of Instantiated artists: ' . Artist::getArtistCount();

/* The abstract class that contains functionality required by all
types of Art */

abstract class Art {
	private $name;
	private $artist;
	private $yearCreated;
	
	function __construct($year, $artist, $name) {
		$this->setYear($year);
		$this->setArtist($artist);
		$this->setName($name);
	}
	public function getYear() { return $this->yearCreated; }
	public function getArtist() { return $this->artist; }
	public function getName() { return $this->name; }
	public function setYear($year) {
		if (is_numeric($year))
			$this->yearCreated = $year;
	}
	public function setArtist($artist) {
		if ((is_object($artist)) && ($artist instanceof Artist))
			$this->artist = $artist;
	}
	public function setName($name) {
		$this->name = $name;
	}
	public function __toString() {
		$line = "Year:" . $this->getYear();
		$line .= ", Name: " .$this->getName();
		$line .= ", Artist: " . $this->getArtist()->getFirstName() . ' ';
		$line .= $this->getArtist()->getLastName();
		return $line;
	}
}

interface Viewable {
	public function getSize();
	public function getPNG();
}

class Painting extends Art implements Viewable {
	private $medium;
	function __construct($year, $artist, $name, $medium) {
		parent::__construct($year, $artist, $name);
		$this->setMedium($medium);
	}
	public function getMedium() { return $this->medium; }
	public function setMedium($medium) {
		$this->medium = $medium;
	}
	public function __toString() {
		return parent::__toString() . ", Medium: " . $this->getMedium();
	}
	public function getSize() { echo "show size of painting"; }
	public function getPNG() { echo "show pic of painting"; }
}

class Sculpture extends Art {
	private $weight;
	function __construct($year, $artist, $name, $weight) {
		parent::__construct($year, $artist, $name);
		$this->setWeight($weight);
	}
	public function getWeight() { return $this->weight; }
	public function setWeight($weight) {
		if (is_numeric($weight))
			$this->weight = $weight;
	}
	public function __toString() {
		return parent::__toString() . ", Weight: " . $this->getWeight() . "kg";
	}
}

class ArtPrint extends Painting {
	private $printNumber;
	function __construct($year, $artist, $name, $medium, $printNumber) {
	parent::__construct($year, $artist, $name, $medium);
		$this->setPrintNumber($printNumber);
	}

	public function getPrintNumber() { return $this->printNumber; }
	public function setPrintNumber($printNumber) {
		if (is_numeric($printNumber))
			$this->printNumber = $printNumber;
	}
	public function __toString() {
		return parent::__toString() . ", Print Number: " .$this->getPrintNumber();
	}
}

// instantiate some sample objects
$picasso = new Artist("Pablo","Picasso","Malaga","May 11,904",
"Apr 8, 1973");
$guernica = new Painting("1937",$picasso,"Guernica","Oil on
canvas");
$stein = new Painting("1907",$picasso,"Portrait of Gertrude Stein",
"Oil on canvas");
$woman = new Sculpture("1909",$picasso,"Head of a Woman", 30.5);
$bowl = new ArtPrint("1912",$picasso,"Still Life with Bowl and Fruit",
"Charcoal on paper", 25);

?>

<h1>Tester for Art Classes</h1>
<h2>Paintings</h2>
<p><em>Use the __toString() methods </em></p>
<p><?php echo $guernica; ?></p>
<p><?php echo $stein; ?></p>
<p><em>Use the getter methods </em></p>
<?php
	echo $guernica->getName() . ' by '
	. $guernica->getArtist()->getLastName() . "<br />";
	
	echo "Year of ". $stein->getName() . " is " . $stein->getYear()  ;
?>
<h2>Sculptures</h2>
<p> <?php echo $woman; ?></p>
<h2>Art Prints</h2>
<?php
	echo 'Year: ' . $bowl->getYear() . '<br/>';
	echo 'Artist: ';
	echo $bowl->getArtist()->getFirstName() . ' ';
	echo $bowl->getArtist()->getLastName() . ' (';
	echo date_format( $bowl->getArtist()->getBirthDate() ,'d M Y') . ' - ';
	echo date_format( $bowl->getArtist()->getDeathDate() ,'d M Y');
	echo ')<br/>';
	echo 'Name: ' . $bowl->getName() . '<br/>';
	echo 'Medium: ' . $bowl->getMedium() . '<br/>';
	echo 'Print Number: ' . $bowl->getPrintNumber() . '<br/>';
	
	$picasso = new Artist("Pablo","Picasso","Malaga","Oct 25, 1881",
		"Apr 8, 1973");
		
	// create the paintings
	$guernica = new Painting("1937",$picasso,"Guernica","Oil on canvas");
	$chicago = new Sculpture("1967",$picasso,"Chicago", 454);
	
	// create an array of art
	$works = array();
	$works[0] = $guernica;
	$works[1] = $chicago;
	
	echo "<br />";
	
	// to test polymorphism, loop through art array
	foreach ($works as $art)
	{
		// the beauty of polymorphism:
		// the appropriate __toString() method will be called!
		echo $art;
		echo "<br />";
	}
	/*
	// add works to artist ... any type of art class will work
	$picasso->addWork($guernica);
	$picasso->addWork($chicago);
	
	// do the same type of loop
	foreach ($picasso->getWorks() as $art) {
		echo $art; // again polymorphism at work
		echo "<br />";
	}
	*/
	echo "<br />";
	echo "<br />";
	echo "<br />";
	echo "<br />";
	echo "<br />";
	echo "<br />";
	echo "<br />";
	echo "<br />";
	echo "end of program";


?>

</body>
</html>

















