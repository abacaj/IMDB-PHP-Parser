<?php 

require_once 'medoo.min.php';
require_once 'movieObject.php';

// Connection constants
define('MEMCACHED_HOST', '127.0.0.1');
define('MEMCACHED_PORT', '11211');
 
// Connection creation
$memcache = new Memcache;
$cacheAvailable = $memcache->connect(MEMCACHED_HOST, MEMCACHED_PORT);

// initialize database object
$db = new medoo();

// counter for top 10
$top10Movies = array();

// counter for top 10
$rank = 0;

// get todays date into a variable
date_default_timezone_set('America/New_York');
$today = date("Y-m-d"); 

// initialize curl
$url     = "http://www.imdb.com/chart/top";
$ch      = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$html = curl_exec($ch);
curl_close($ch);


// functions to match html elements
function match_all($regex, $str, $i = 0) {
	if (preg_match_all($regex, $str, $matches) === false) {
		return false;
	} else {

		return $matches[$i];
	}
}

function match($regex, $str, $i = 0) {
	if (preg_match($regex, $str, $match) == 1) {
		return $match[$i];
	} else {

		return false;
	}
}

// function to get a movies vote
function getvotes($urlForVotes) {
	$chnl      = curl_init();
	$timeout = 5;
	curl_setopt($chnl, CURLOPT_URL, $urlForVotes);
	curl_setopt($chnl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($chnl, CURLOPT_CONNECTTIMEOUT, $timeout);
	$htmlForVotes = curl_exec($chnl);
	curl_close($chnl);

	$vote = match('/<span itemprop="ratingCount">(.*)<\/span>/', $htmlForVotes, 1);
	return $vote;
}

// match html from imdb
foreach (match_all('/<tr class="(even|odd)">(.*?)<\/tr>/ms', $html, 2) as $m) {
	$rank++;
	$id      = match('/<td class="titleColumn">.*?<a href="\/title\/(tt\d+)\/.*?"/msi', $m, 1);
	$title   = match('/<td class="titleColumn">.*?<a.*?>(.*?)<\/a>/msi', $m, 1);
	$year    = match('/<td class="titleColumn">.*?<span.*?>\((.*?)\)<\/span>/msi', $m, 1);
	$rating  = match('/<td class="ratingColumn">.*?<strong.*?>(.*?)<\/strong>/msi', $m, 1);
	$poster  = match('/<td class="posterColumn">.*?<img src="(.*?)"/msi', $m, 1);
	$votesURL = "http://www.imdb.com/title/".$id."/";
	$votes   = getvotes($votesURL);

	// create each movie object and set the variables
	$movie = new Movie();
	$movie->setId($id);
	$movie->setRank($rank);
	$movie->setTitle($title);
	$movie->setYear($year);
	$movie->setRating($rating);
	$movie->setVotes($votes);

	// insert $movie objects into an array
	array_push($top10Movies, $movie);

	// stop at 10
	if($rank == 10) break;
}

$date = $db->select("movies", "date_added");

// insert into database using medoo if it does not exist
foreach($top10Movies as $movie){
	// check database for matching date, if same day update, else insert
	if (in_array($today, $date))
		{
			$db->update("movies", [
				"imdb_id" => $movie->getId(),
				"rank" => $movie->getRank(),
				"rating" =>  $movie->getRating(),
				"title" => $movie->getTitle(),
				"year" => $movie->getYear(),
				"number_of_votes" => $movie->getVotes(),
				"date_added" => $today
			], 
			[
				"date_added" => $today,
				"rank" => $movie->getRank(),
			]);
		}
		else {
			$db->insert("movies", [
				"imdb_id" => $movie->getId(),
				"rank" => $movie->getRank(),
				"rating" => $movie->getRating(),
				"title" => $movie->getTitle(),
				"year" => $movie->getYear(),
				"number_of_votes" => $movie->getVotes(),
				"date_added" => $today

			]);
		}
}

