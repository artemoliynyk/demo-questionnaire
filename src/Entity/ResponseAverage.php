<?php

namespace App\Entity;

use App\Repository\ResponseAverageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResponseAverageRepository::class)
 */
class ResponseAverage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="responseAverages")
     * @ORM\JoinColumn(nullable=false, unique=true)
     */
    private $question;

    /**
     * @ORM\Column(type="integer")
     */
    private $average;


    public function __construct(?Question $question = null)
    {
        if($question instanceof Question) {
            $this->setQuestion($question);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAverage(): ?int
    {
        return $this->average;
    }

    public function setAverage(int $average): self
    {
        $this->average = $average;

        return $this;
    }
}
