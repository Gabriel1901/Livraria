<?php

namespace LivrariaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Genero
 *
 * @author aluno
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
     * @ORM\Column(type="string", length=100)
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
     * @param string $nome
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
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }
    
    public function __toString() 
    {
        return $this->id .'-'. $this->nome;
    }
}
