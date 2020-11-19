<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FormateurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FormateurRepository::class)
 * @ApiResource(
 *      attributes={
 *          "security"="is_granted ('ROLE_Admin') or is_granted ('ROLE_Formateur') or is_granted ('ROLE_Cm')",
 *          "security_message"="Vous n'avez pas access à cette Ressource"
 *     },
 *
 *     collectionOperations={
            "get"={"path"="/formateurs"},
 *     },
 *
 *     itemOperations={
            "get_formateurs"={
 *              "method"="GET", "path":"/formateurs/{id}",
 *     },
 *          "put"={"path"="/formateurs/{id}"},
 *     },
 * )
 */
class Formateur extends User
{

}
