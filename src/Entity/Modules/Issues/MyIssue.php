<?php

namespace App\Entity\Modules\Issues;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Modules\Issues\MyIssueRepository")
 */
class MyIssue {

    const FIELD_NAME_DELETED  = "deleted";
    const FIELD_NAME_RESOLVED = "resolved";

    /**
     * @var int $id
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var bool $deleted
     * @ORM\Column(type="boolean")
     */
    private $deleted = 0;

    /**
     * @var bool $resolved
     * @ORM\Column(type="boolean")
     */
    private $resolved = 0;

    /**
     * @var string $name
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Modules\Issues\MyIssueContact", mappedBy="myIssue")
     */
    private $issueContact;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Modules\Issues\MyIssueProgress", mappedBy="myIssue")
     */
    private $issueProgress;

    public function __construct()
    {
        $this->issueContact = new ArrayCollection();
        $this->issueProgress = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void {
        $this->name = $name;
    }
    /**
     * @return bool
     */
    public function isDeleted(): bool {
        return $this->deleted;
    }

    /**
     * @param bool $deleted
     */
    public function setDeleted(bool $deleted): void {
        $this->deleted = $deleted;
    }

    /**
     * @return bool
     */
    public function isResolved(): bool {
        return $this->resolved;
    }

    /**
     * @param bool $resolved
     */
    public function setResolved(bool $resolved): void {
        $this->resolved = $resolved;
    }

    /**
     * @return Collection|MyIssueContact[]
     */
    public function getIssueContact(): Collection
    {
        return $this->issueContact;
    }

    public function addIssueContact(MyIssueContact $issueContact): self
    {
        if (!$this->issueContact->contains($issueContact)) {
            $this->issueContact[] = $issueContact;
            $issueContact->setMyIssue($this);
        }

        return $this;
    }

    public function removeIssueContact(MyIssueContact $issueContact): self
    {
        if ($this->issueContact->contains($issueContact)) {
            $this->issueContact->removeElement($issueContact);
            // set the owning side to null (unless already changed)
            if ($issueContact->getMyIssue() === $this) {
                $issueContact->setMyIssue(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MyIssueProgress[]
     */
    public function getIssueProgress(): Collection
    {
        return $this->issueProgress;
    }

    public function addIssueProgress(MyIssueProgress $issueProgress): self
    {
        if (!$this->issueProgress->contains($issueProgress)) {
            $this->issueProgress[] = $issueProgress;
            $issueProgress->setMyIssue($this);
        }

        return $this;
    }

    public function removeIssueProgress(MyIssueProgress $issueProgress): self
    {
        if ($this->issueProgress->contains($issueProgress)) {
            $this->issueProgress->removeElement($issueProgress);
            // set the owning side to null (unless already changed)
            if ($issueProgress->getMyIssue() === $this) {
                $issueProgress->setMyIssue(null);
            }
        }

        return $this;
    }

}