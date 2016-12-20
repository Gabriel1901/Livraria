<?php

namespace LivrariaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Description of CupomItem
 *
 * @ORM\Entity
 * @ORM\Table(name="cupom_item")
 */
class CupomItem implements \JsonSerializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Cupom")
     * @ORM\JoinColumn(name="cupom_id", referencedColumnName="id")
     */
    private $cupomId;
    
    /**
     *
     * @ORM\Column(type="integer")
     */
    private $ordemItem;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $itemCod;
    
    /**
     *
     * @ORM\Column(type="string", length=100)
     */
    private $descricaoItem;
    
    /**
     *
     * @ORM\Column(type="integer")
     */
    private $quantidade;
    
     /**
     *
     * @ORM\Column(type="decimal", scale=2)
     */
    private $valorUnitario;

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
     * Set itemCod
     *
     * @param integer $itemCod
     *
     * @return CupomItem
     */
    public function setItemCod($itemCod)
    {
        $this->itemCod = $itemCod;

        return $this;
    }

    /**
     * Get itemCod
     *
     * @return integer
     */
    public function getItemCod()
    {
        return $this->itemCod;
    }

    /**
     * Set descricaoItem
     *
     * @param string $descricaoItem
     *
     * @return CupomItem
     */
    public function setDescricaoItem($descricaoItem)
    {
        $this->descricaoItem = $descricaoItem;

        return $this;
    }

    /**
     * Get descricaoItem
     *
     * @return string
     */
    public function getDescricaoItem()
    {
        return $this->descricaoItem;
    }

    /**
     * Set quantidade
     *
     * @param integer $quantidade
     *
     * @return CupomItem
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;

        return $this;
    }

    /**
     * Get quantidade
     *
     * @return integer
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * Set valorUnitario
     *
     * @param string $valorUnitario
     *
     * @return CupomItem
     */
    public function setValorUnitario($valorUnitario)
    {
        $this->valorUnitario = $valorUnitario;

        return $this;
    }

    /**
     * Get valorUnitario
     *
     * @return string
     */
    public function getValorUnitario()
    {
        return $this->valorUnitario;
    }

    /**
     * Set cupomId
     *
     * @param \LivrariaBundle\Entity\Cupom $cupomId
     *
     * @return CupomItem
     */
    public function setCupomId(\LivrariaBundle\Entity\Cupom $cupomId = null)
    {
        $this->cupomId = $cupomId;

        return $this;
    }

    /**
     * Get cupomId
     *
     * @return \LivrariaBundle\Entity\Cupom
     */
    public function getCupomId()
    {
        return $this->cupomId;
    }

    /**
     * Set ordemItem
     *
     * @param integer $ordemItem
     *
     * @return CupomItem
     */
    public function setOrdemItem($ordemItem)
    {
        $this->ordemItem = $ordemItem;

        return $this;
    }

    /**
     * Get ordemItem
     *
     * @return integer
     */
    public function getOrdemItem()
    {
        return $this->ordemItem;
    }
    
    public function jsonSerialize() 
    {
        return array(
            "descricao" => $this->getDescricaoItem(),
            "valor" => $this->getValorUnitario(),
            "numOrdem" => $this->getOrdemItem(),
            "codigo" => $this->getItemCod()
        );
    }

}
