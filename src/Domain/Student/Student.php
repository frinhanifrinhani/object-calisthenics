<?php

namespace Alura\Calisthenics\Domain\Student;

use Alura\Calisthenics\Domain\Address\Address;
use Alura\Calisthenics\Domain\Email\Email;
use Alura\Calisthenics\Domain\Video\Video;
use DateTimeInterface;

class Student
{
    private Email $email;
    private DateTimeInterface $birthDay;
    private WatchedVideos $watchedVideos;
    private FullName $fullName;
    private Address $address;

    public function __construct(Email $email, DateTimeInterface $birthDay, FullName $fullName, Address $address)
    {
        $this->watchedVideos = new WatchedVideos();
        $this->email = $email;
        $this->birthDay = $birthDay;
        $this->address = $address;
        $this->fullName = $fullName;

    }

    public function fullName(): string
    {
        return $this->fullName;
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
