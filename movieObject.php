<?php

// the movie object
class Movie
{
    private $id;
    private $rank;
    private $title;
    private $year;
    private $rating;
    private $votes;
    
    public function setId($id)
    {
        $this->id = $id;
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setRank($rk)
    {
        $this->rank = $rk;
    }
    
    public function getRank()
    {
        return $this->rank;
    }
    
    public function setTitle($tl)
    {
        $this->title = $tl;
    }
    
    public function getTitle() 
    {
        return $this->title;
    }
    
    public function setYear($yr)
    {
        $this->year = $yr;
    }
    
    public function getYear()
    {
        return $this->year;
    }

     public function setRating($rt)
    {
        $this->rating = $rt;
    }
    
    public function getRating()
    {
    	return $this->rating;
    }

    public function setVotes($vt)
    {
        $this->votes = $vt;
    }
    
    public function getVotes()
    {
    	return $this->votes;
    }
    
    
}
