<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * @ORM\Entity(repositoryClass=QuestionRepository::class)
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $questionText;

    /**
     * @Assert\Valid()
     * @ORM\OneToMany(targetEntity=Answer::class, mappedBy="question", orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $answers;

    /**
     * @ORM\OneToMany(targetEntity=Response::class, mappedBy="quesion")
     */
    private $responses;

    /**
     * @ORM\OneToMany(targetEntity=ResponseAverage::class, mappedBy="question")
     */
    private $responseAverages;

    public function __construct()
    {
        $this->answers = new ArrayCollection();
        $this->responses = new ArrayCollection();
        $this->responseAverages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestionText(): ?string
    {
        return $this->questionText;
    }

    public function setQuestionText(string $questionText): self
    {
        $this->questionText = $questionText;

        return $this;
    }

    /**
     * @return Collection|Answer[]
     */
    public function getAnswers(): Collection
    {
        return $this->answers;
    }

    public function addAnswer(Answer $answer): self
    {
        if (!$this->answers->contains($answer)) {
            $this->answers[] = $answer;
            $answer->setQuestion($this);
        }

        return $this;
    }

    public function removeAnswer(Answer $answer): self
    {
        if ($this->answers->contains($answer)) {
            $this->answers->removeElement($answer);

            // set the owning side to null (unless already changed)
            if ($answer->getQuestion() === $this) {
                $answer->setQuestion(null);
            }
        }

        return $this;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if (2 > $this->getAnswers()->count()) {
            $context->buildViolation('Please, create at least 2 answers')
                ->atPath('answers')
                ->addViolation()
            ;
        }
        elseif ( 6 < $this->getAnswers()->count()) {
            $context->buildViolation('Only 6 answers are allowed')
                ->atPath('answers')
                ->addViolation()
            ;
        }
    }

    /**
     * @return Collection|Response[]
     */
    public function getResponses(): Collection
    {
        return $this->responses;
    }

    /**
     * @return Collection|ResponseAverage[]
     */
    public function getResponseAverages(): Collection
    {
        return $this->responseAverages;
    }

    public function addResponseAverage(ResponseAverage $responseAverage): self
    {
        if (!$this->responseAverages->contains($responseAverage)) {
            $this->responseAverages[] = $responseAverage;
            $responseAverage->setQuestion($this);
        }

        return $this;
    }

    public function removeResponseAverage(ResponseAverage $responseAverage): self
    {
        if ($this->responseAverages->contains($responseAverage)) {
            $this->responseAverages->removeElement($responseAverage);
            // set the owning side to null (unless already changed)
            if ($responseAverage->getQuestion() === $this) {
                $responseAverage->setQuestion(null);
            }
        }

        return $this;
    }
}
