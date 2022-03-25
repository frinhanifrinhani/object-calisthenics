<?php


namespace Alura\Calisthenics\Domain\Student;
use DateTimeInterface;
use DS\Map;

class WatchedVideos implements \Countable
{
    private Map $video;

    public function __construct()
    {
        $this->video = new Map();
    }

    public function add($video, DateTimeInterface $date) : void
    {
        $this->video->put($video, $date);
    }

    public function count() : int
    {
        return $this->video->count();
    }

    public function dateOfFirstVideo() : DateTimeInterface
    {
        $this->video
            ->sort(fn(DateTimeInterface $dateA, DateTimeInterface $dateB) => $dateA <=> $dateB);
        return $this->video->first()->value;
    }


}