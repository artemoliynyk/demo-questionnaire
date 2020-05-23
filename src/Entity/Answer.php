<?php

namespace App\Entity;

use App\Repository\AnswerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AnswerRepository::class)
 * @ORM\Table(name="answer", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="uniq_weight", columns={"weight", "question_id"})})
 * )
 * @UniqueEntity(
 *     fields={"weight", "question"},
 *     message="Please, make sure all questions has an unique weight"
 * )
 */
class Answer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $answerText;

    /**
     * @ORM\Column(type="integer", name="weight")
     * @Assert\NotBlank()
     * @Assert\Range(min="0", max="5")
     */
    private $weight;

    /**
     * @ORM\ManyToOne(targetEntity=Question::class, inversedBy="answers")
     * @ORM\JoinColumn(name="question_id", nullable=false, onDelete="CASCADE")
     */
    private $question;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnswerText(): ?string
    {
        return $this->answerText;
    }

    public function setAnswerText(string $answerText): self
    {
        $this->answerText = $answerText;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
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
}
