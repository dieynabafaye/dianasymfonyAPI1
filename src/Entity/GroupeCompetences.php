<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeCompetencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GroupeCompetencesRepository::class)
 * @ApiResource(
 *     normalizationContext={"groups"={"grpComptence:read"}},
 *
 *     collectionOperations={
            "get"={"path"="/admin/grpecomptences"},
 *          "get_competences"={
 *              "method"="GET",
 *              "path"="/admin/grpecomptences/comptences",
 *              "normalization_context"={"groups"={"comptences:read"}},
 *          },
 *
 *     },
 *
 *     itemOperations={
 *          "get"={"path"="/admin/grpecomptences/{id}"},
 *           "get_competences_id"={
 *              "method"="GET",
 *              "path"="/admin/grpecomptences/{id}/comptences",
 *              "normalization_context"={"groups"={"comptences:read"}},
 *          },
 *          "put"={"path"="/admin/grpecomptences/{id}"},
 *     }
 * )
 */
class GroupeCompetences
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank (message="le libelle est obligatoire")
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank (message="le descriptif est obligatoire")
     */
    private $descriptif;

    /**
     * @ORM\ManyToMany(targetEntity=Competences::class, inversedBy="groupeCompetences")
     * @Groups ({"grpComptence:read"})
     */
    private $Competences;

    public function __construct()
    {
        $this->Competences = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(string $descriptif): self
    {
        $this->descriptif = $descriptif;

        return $this;
    }

    /**
     * @return Collection|Competences[]
     */
    public function getCompetences(): Collection
    {
        return $this->Competences;
    }

    public function addCompetence(Competences $competence): self
    {
        if (!$this->Competences->contains($competence)) {
            $this->Competences[] = $competence;
        }

        return $this;
    }

    public function removeCompetence(Competences $competence): self
    {
        $this->Competences->removeElement($competence);

        return $this;
    }
}
