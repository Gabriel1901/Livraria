<?php

namespace LivrariaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Genero
 *
 * @author Gabriel
 * 
 * @ORM\Entity
 * @ORM\Table(name="genero")
 */
class Genero
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $nome;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param integer $nome
     *
     * @return Genero
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return integer
     */
    public function getNome()
    {
        return $this->nome;
    }
}
