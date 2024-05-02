<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserResults
 *
 * @ORM\Table(name="user_results", indexes={@ORM\Index(name="userId", columns={"userId"}), @ORM\Index(name="quizId", columns={"quizId"})})
 * @ORM\Entity
 */
class UserResults
{
    /**
     * @var int
     *
     * @ORM\Column(name="userId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $userid;

    /**
     * @var int
     *
     * @ORM\Column(name="quizId", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $quizid;

    /**
     * @var int
     *
     * @ORM\Column(name="result_score", type="integer", nullable=false)
     */
    private $resultScore;

    public function getUserid(): ?int
    {
        return $this->userid;
    }

    public function getQuizid(): ?int
    {
        return $this->quizid;
    }

    public function getResultScore(): ?int
    {
        return $this->resultScore;
    }

    public function setResultScore(int $resultScore): static
    {
        $this->resultScore = $resultScore;

        return $this;
    }


}
