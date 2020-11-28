<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiSubresource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeCompetencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GroupeCompetencesRepository::class)
 *  @ApiFilter(
 *     SearchFilter::class,
 *     properties={"archive":"partial"},
 * )
 * @UniqueEntity(
 * fields={"libelle"},
 * message="Le libelle doit être unique"
 * )
 *
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
 *          "postgrpecompetences"={
*                   "method"="POST",
 *                  "path"="/admin/grpecomptences",
 *                  "route_name"="postgroupecompetences",
 *     },
 *
 *     },
 *
 *     itemOperations={
 *          "get"={"path"="/admin/grpecomptences/{id}"},
 *           "get_competences_id"={
 *              "method"="GET",
 *              "normalization_context"={"groups"={"comptences:read"}},
 *     },
 *              "putUserId"={
 *                  "method"="PUT",
 *                  "path"="/admin/grpecomptences/{id}",
 *                  "route_name"="put_competences"
 *              },
 *
 *
 *          },
 *
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
     * @ApiSubresource (
     *
     * )
     */
    private $Competences;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archive=false;



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

    public function getArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }

}
