<?php

class Title implements JsonSerializable
{
    protected $id;
    protected $image_url;
    protected $title_type;
    protected $primary_title;
    protected $original_title;
    protected $is_adult;
    protected $start_year;
    protected $end_year;
    protected $runtime_minutes;
    protected $rating;
    protected $votes;
    protected $genres;
    protected $directors_count;
    protected $principals_count;
    protected $writers_count;

    function __construct()
    {

    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'image_url' => $this->getImageUrl(),
            'title_type' => $this->getTitleType(),
            'primary_title' => $this->getPrimaryTitle(),
            'original_title' => $this->getOriginalTitle(),
            'is_adult' => $this->getIsAdult(),
            'start_year' => $this->getStartYear(),
            'end_year' => $this->getEndYear(),
            'runtime_minutes' => $this->getRuntimeMinutes(),
            'rating' => $this->getRating(),
            'votes' => $this->getVotes(),
            'genres' => $this->getGenres(),
            'directors_count' => $this->getDirectorsCount(),
            'principals_count' => $this->getPrincipalsCount(),
            'writers_count' => $this->getWritersCount(),
        ];
    }

    function toHtml()
    {
        return '<div class="card">
                    <img class="card-img-top img-thumbnail" src=' . $this->getImageUrl() . ' alt=' . $this->original_title . ' />
                    <div class="card-body">
                        <div>' . $this->original_title . '</div>
                        <div>Rating: ' . $this->rating . '</div>
                        <div>Runtime: ' . $this->getRuntimeMinutes() . ' min.</div>
                        <div>Year: ' . $this->getStartYear() . '</div>
                        <div>Principals: ' . $this->getPrincipalsCount() . '</div>
                        <div>Directors: ' . $this->getDirectorsCount() . '</div>
                        <div>Writers: ' . $this->getWritersCount() . '</div>
                    </div>
                </div>';
    }

    public function getId()
    {
        return $this->id;
    }

    public function getImageUrl()
    {
        return "./images/movie_not_found.jpg";
    }

    public function getTitleType()
    {
        return $this->title_type;
    }

    public function getPrimaryTitle()
    {
        return $this->primary_title;
    }

    public function getOriginalTitle()
    {
        return $this->original_title;
    }

    public function getIsAdult()
    {
        return $this->is_adult;
    }

    public function getStartYear()
    {
        return $this->start_year;
    }

    public function getEndYear()
    {
        return $this->end_year;
    }

    public function getRuntimeMinutes()
    {
        return $this->runtime_minutes;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function getVotes()
    {
        return $this->votes;
    }

    public function getGenres()
    {
        return $this->genres;
    }

    public function getDirectorsCount()
    {
        return $this->directors_count;
    }

    public function getPrincipalsCount()
    {
        return $this->principals_count;
    }

    public function getWritersCount()
    {
        return $this->writers_count;
    }
}