<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="emailCanonical", errorPath="email", message="fos_user.email.already_used")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(name="first_name", type="string", length=100)
     *
     * @Assert\Length(min=1, max=100)
     * @Assert\NotBlank()
     */
    protected $firstName;

    /**
     * @ORM\Column(name="last_name", type="string", length=100)
     *
     * @Assert\Length(min=1, max=100)
     * @Assert\NotBlank()
     */
    protected $lastName;

    /**
     * @ORM\OneToMany(targetEntity=Response::class, mappedBy="user", orphanRemoval=true)
     */
    private $responses;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->roles = ['ROLE_USER'];
        $this->responses = new ArrayCollection();
    }

    public function setEmail($email)
    {
        parent::setEmail($email);

        // username is identical to the Email
        parent::setUsername($email);
    }

    /**
     * @param string $username
     */
    public function setUsername($username): void
    {
        $this->username = $this->email;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('ROLE_ADMIN');
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getFullname()
    {
        return "{$this->getFirstName()} {$this->getLastName()}";
    }

    public function isAccountNonLocked()
    {
        return $this->enabled;
    }

    /**
     * @return Collection|Response[]
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }

    public function addResponse(Response $response): self
    {
        if (!$this->responses->contains($response)) {
            $this->responses[] = $response;
            $response->setUser($this);
        }

        return $this;
    }

    public function removeResponse(Response $response): self
    {
        if ($this->responses->contains($response)) {
            $this->responses->removeElement($response);
            // set the owning side to null (unless already changed)
            if ($response->getUser() === $this) {
                $response->setUser(null);
            }
        }

        return $this;
    }
}
