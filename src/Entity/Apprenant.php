<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ApprenantRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ApprenantRepository::class)
 * @ApiResource(
 *      attributes={
 *          "security"="is_granted ('ROLE_Admin') or is_granted ('ROLE_Formateur') or is_granted ('ROLE_Cm') or is_granted ('ROLE_Apprenant')",
 *          "security_message"="Vous n'avez pas access à cette Ressource"
 *     },
 *
 *     collectionOperations={
*           "get"={"path"="/apprenants"},
 *          "post"={"path"="/apprenants"},
 *     },
 *
 *     itemOperations={
*           "get_formateurs"={
 *            "method"="GET", "path":"/apprenants/{id}",
 *     },
 *          "put"={"path"="/apprenants/{id}"},
 *     },
 * )
 */
class Apprenant extends User
{
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank (message="le numéro de téléphone est obligatoire")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank (message="l'adresse est obligatoire")
     */
    private $adresse;

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }
}
