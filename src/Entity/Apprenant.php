<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ApprenantRepository;
use Doctrine\ORM\Mapping as ORM;

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

}
