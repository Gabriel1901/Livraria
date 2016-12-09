<?php

namespace LivrariaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of Cupom
 *
 * @author aluno
 * 
 * @ORM\Entity
 * @ORM\Table(name="cupom")
 */
class Cupom 
{
    
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id; 
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $data;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $vendedor;
    
    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $valorTotal;
    
    /**
     *
     * @ORM\Column(type="string")
     */
    private $status = "NOVO";
    

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
     * Set data
     *
     * @param \DateTime $data
     *
     * @return Cupom
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set vendedor
     *
     * @param integer $vendedor
     *
     * @return Cupom
     */
    public function setVendedor($vendedor)
    {
        $this->vendedor = $vendedor;

        return $this;
    }

    /**
     * Get vendedor
     *
     * @return integer
     */
    public function getVendedor()
    {
        return $this->vendedor;
    }

    /**
     * Set valorTotal
     *
     * @param string $valorTotal
     *
     * @return Cupom
     */
    public function setValorTotal($valorTotal)
    {
        $this->valorTotal = $valorTotal;

        return $this;
    }

    /**
     * Get valorTotal
     *
     * @return string
     */
    public function getValorTotal()
    {
        return $this->valorTotal;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Cupom
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}
