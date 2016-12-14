<?php

namespace LivrariaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 *  Description of Produtos
 *
 * @author aluno
 * 
 * @ORM\Entity
 * @ORM\Table(name="produtos")
 */
class Produtos implements \JsonSerializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * 
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="É obrigatorio informar um nome para o produto. ")
     */
    private $nome;
    
    /**
     * @ORM\Column(type="integer", length=6)
     * @Assert\NotBlank()
     * @Assert\GreaterThan(
     *     value = 0,
     * message="A quantidade deve ser maior ou igual a 0. "
     * )
     */
    private $quantidade;
    
    /**
     * @ORM\Column(type="decimal", scale=2)
     * @Assert\NotBlank()
     * @Assert\GreaterThan(
     *     value = 0,
     * message="O Valor deve ser maior ou igual a 0. "
     * )
     */
    private $preco;
    
    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="É obrigatorio informar um tipo para o produto. ")
     */
    private $tipo;
    
    /**
     * @ORM\Column(type="string")
     */
    private $imagem;
    
     /**
     * @ORM\ManyToOne(targetEntity="Genero")
     * @ORM\JoinColumn(name="genero_id", referencedColumnName="id")
      * @Assert\NotBlank(message="É obrigatorio informar o genero para o produto. ")
     */
    private $genero;
    

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
     * @return Produtos
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

    /**
     * Set quantidade
     *
     * @param integer $quantidade
     *
     * @return Produtos
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
     * Set preco
     *
     * @param string $preco
     *
     * @return Produtos
     */
    public function setPreco($preco)
    {
        $this->preco = $preco;

        return $this;
    }

    /**
     * Get preco
     *
     * @return string
     */
    public function getPreco()
    {
        return $this->preco;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     *
     * @return Produtos
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set imagem
     *
     * @param string $imagem
     *
     * @return Produtos
     */
    public function setImagem($imagem)
    {
        $this->imagem = $imagem;

        return $this;
    }

    /**
     * Get imagem
     *
     * @return string
     */
    public function getImagem()
    {
        return $this->imagem;
    }

    /**
     * Set genero
     *
     * @param \LivrariaBundle\Entity\Genero $genero
     *
     * @return Produtos
     */
    public function setGenero(\LivrariaBundle\Entity\Genero $genero = null)
    {
        $this->genero = $genero;

        return $this;
    }

    /**
     * Get genero
     *
     * @return \LivrariaBundle\Entity\Genero
     */
    public function getGenero()
    {
        return $this->genero;
    }
    
    public function jsonSerialize() 
    {
        return array(
            "nome"   => $this->getNome(),
            "tipo"   => $this->getTipo(),
            "preco"  => $this->getPreco(),
            "imagem" => $this->getImagem(),
            "genero" => $this->getGenero()->getNome()
        );
    }

}
