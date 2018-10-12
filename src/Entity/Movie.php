<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MovieRepository")
 * @ORM\Table(name="mc_movie")
 * @Serializer\ExclusionPolicy("all")
 */
class Movie
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @var |DateTime
     *
     * @ORM\Column(type="datetime")
     */
    private $release_date;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    private $overview;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $poster_path;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\User", mappedBy="movies")
     */
    private $users;

    /**
     * Movie constructor.
     * @param int    $id
     * @param string $title
     * @param        $release_date
     * @param string $overview
     * @param string $poster_path
     */
    public function __construct(int $id, string $title, $release_date, string $overview, string $poster_path)
    {
        $this->id           = $id;
        $this->title        = $title;
        $this->release_date = $release_date;
        $this->overview     = $overview;
        $this->poster_path  = $poster_path;
        $this->users        = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->release_date;
    }

    public function getOverview(): ?string
    {
        return $this->overview;
    }

    public function getPosterPath(): ?string
    {
        return $this->poster_path;
    }

    public function addUser(User $user): self
    {
        if ( ! $this->users->contains($user) ) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ( $this->users->contains($user) ) {
            $this->users->removeElement($user);
        }

        return $this;
    }
}
