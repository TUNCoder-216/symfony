<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserStudentgroup
 *
 * @ORM\Table(name="user_studentgroup", indexes={@ORM\Index(name="student_group_id", columns={"student_group_id"})})
 * @ORM\Entity
 */
class UserStudentgroup
{
    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $userId;

    /**
     * @var int
     *
     * @ORM\Column(name="student_group_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $studentGroupId;

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getStudentGroupId(): ?int
    {
        return $this->studentGroupId;
    }


}
