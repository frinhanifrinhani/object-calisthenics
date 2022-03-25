<?php

namespace Alura\Calisthenics\Domain\Student;

use Alura\Calisthenics\Domain\Email\Email;
use Alura\Calisthenics\Domain\Video\Video;
use DateTimeInterface;

class Student
{
    private Email $email;
    private DateTimeInterface $birthDay;
    private WatchedVideos $watchedVideos;
    private string $fName;
    private string $lName;
    public string $street;
    public string $number;
    public string $province;
    public string $city;
    public string $state;
    public string $country;

    public function __construct(Email $email, DateTimeInterface $birthDay, string $fullName, string $lastName, string $street, string $number, string $province, string $city, string $state, string $country)
    {
        $this->watchedVideos = new WatchedVideos();
        $this->email = $email;
        $this->birthDay = $birthDay;
        $this->fName = $fullName;
        $this->lName = $lastName;
        $this->street = $street;
        $this->number = $number;
        $this->province = $province;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
    }

    public function fullName(): string
    {
        return "{$this->fName} {$this->lName}";
    }

    public function email(): string
    {
        return $this->email;
    }

    public function birthDay(): DateTimeInterface
    {
        return $this->birthDay;
    }

    public function watch(Video $video, DateTimeInterface $date)
    {
        $this->watchedVideos->add($video, $date);
    }

    public function hasAccess(): bool
    {
        if ($this->watchedVideos->count() === 0) {
            return true;
        }


        $firstDate = $this->watchedVideos->dateOfFirstVideo();


        $today = new \DateTimeImmutable();

        return $firstDate->diff($today)->days < 90;

    }

    public function age(): int
    {
        $today = new \DateTimeImmutable();
        $dateInterval = $this->birthDay()->diff($today);
        return $dateInterval->y;
    }

}
