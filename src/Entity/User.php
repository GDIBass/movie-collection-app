<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="mc_user")
 *
 * @UniqueEntity("username")
 *
 * @Serializer\ExclusionPolicy("all")
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose()
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Serializer\Expose()
     */
    private $username;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Movie", inversedBy="movies")
     *
     * @Serializer\Expose()
     */
    private $movies;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

    /**
     * Get the ID
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the username
     *
     * @return null|string
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Get the collection of movies
     *
     * @return Collection|Movie[]
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    /**
     * Set Username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Add a movie to the user
     *
     * @param Movie $movie
     *
     * @return User
     */
    public function addMovie(Movie $movie): self
    {
        if ( ! $this->movies->contains($movie) ) {
            $this->movies[] = $movie;
            $movie->addUser($this);
        }

        return $this;
    }

    /**
     * Remove a movie from the user
     *
     * @param Movie $movie
     *
     * @return User
     */
    public function removeMovie(Movie $movie): self
    {
        if ( $this->movies->contains($movie) ) {
            $this->movies->removeElement($movie);
            $movie->removeUser($this);
        }

        return $this;
    }

    /**
     * Returns whether or not the user has a movie
     *
     * @param Movie $movie
     *
     * @return bool
     */
    public function hasMovie(Movie $movie): bool
    {
        return $this->movies->contains($movie);
    }
}
