<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question", indexes={@ORM\Index(name="question_ibfk_1", columns={"quiz"})})
 * @ORM\Entity
 */
class Question
{
    /**
     * @var int
     *
     * @ORM\Column(name="questionId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $questionid;

    /**
     * @var string
     *
     * @ORM\Column(name="questionText", type="string", length=255, nullable=false)
     */
    private $questiontext;

    /**
     * @var string
     *
     * @ORM\Column(name="optionA", type="string", length=255, nullable=false)
     */
    private $optiona;

    /**
     * @var string
     *
     * @ORM\Column(name="optionB", type="string", length=255, nullable=false)
     */
    private $optionb;

    /**
     * @var string
     *
     * @ORM\Column(name="optionC", type="string", length=255, nullable=false)
     */
    private $optionc;

    /**
     * @var int
     *
     * @ORM\Column(name="correctoptionIndex", type="integer", nullable=false)
     */
    private $correctoptionindex;

    /**
     * @var \Quiz
     *
     * @ORM\ManyToOne(targetEntity="Quiz")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="quiz", referencedColumnName="quizId")
     * })
     */
    private $quiz;

    public function getQuestionid(): ?int
    {
        return $this->questionid;
    }

    public function getQuestiontext(): ?string
    {
        return $this->questiontext;
    }

    public function setQuestiontext(string $questiontext): static
    {
        $this->questiontext = $questiontext;

        return $this;
    }

    public function getOptiona(): ?string
    {
        return $this->optiona;
    }

    public function setOptiona(string $optiona): static
    {
        $this->optiona = $optiona;

        return $this;
    }

    public function getOptionb(): ?string
    {
        return $this->optionb;
    }

    public function setOptionb(string $optionb): static
    {
        $this->optionb = $optionb;

        return $this;
    }

    public function getOptionc(): ?string
    {
        return $this->optionc;
    }

    public function setOptionc(string $optionc): static
    {
        $this->optionc = $optionc;

        return $this;
    }

    public function getCorrectoptionindex(): ?int
    {
        return $this->correctoptionindex;
    }

    public function setCorrectoptionindex(int $correctoptionindex): static
    {
        $this->correctoptionindex = $correctoptionindex;

        return $this;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): static
    {
        $this->quiz = $quiz;

        return $this;
    }

}
