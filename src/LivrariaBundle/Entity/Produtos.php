<?php

namespace LivrariaBundle\Entity;

/**
 * Description of Produtos
 *
 * @author Gabriel
 */
class Produtos 
{
    private $id;
    
    private $nome;
    
    private $quantidade;
    
    private $preco;
    
    private $tipo;
    
    private  $imagem;
    
    public function getId() 
    {
        return $this->id;
    }

    public function getNome() 
    {
        return $this->nome;
    }

    public function getQuantidade()
    {
        return $this->quantidade;
    }

    public function getPreco() 
    {
        return $this->preco;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function getImagem() {
        return $this->imagem;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    public function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
        return $this;
    }

    public function setPreco($preco) {
        $this->preco = $preco;
        return $this;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
        return $this;
    }

    public function setImagem($imagem) {
        $this->imagem = $imagem;
        return $this;
    }


    
}
