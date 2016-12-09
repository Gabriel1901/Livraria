<?php

namespace LivrariaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use \LivrariaBundle\Entity\Cupom;
use \LivrariaBundle\Entity\CupomItem;

/**
 * Description of CaixaController
 *
 * @author aluno
 */
class CaixaController extends Controller
{
    /**
     * @Route("/caixa")
     */    
    public function pdvActrion(Request $request)
    {
       $em = $this->getDoctrine()->getManager(); //carrega o doctrine
       
       $cupom = new Cupom();
       $cupom->setData(new \DateTime());
       $cupom->setValorTotal(0);
       $cupom->setVendedor(1);
       
       $em->persist($cupom); // segura na memoria do doctrine.
       $em->Flush(); // grava no banco de dados.
       
       $request->getSession()->set('cupom-id', $cupom->getId());
       
       return $this->render("LivrariaBundle:Caixa:pdv.html.twig"); 
    }
    
    /**
     * @Route("caixa/carregar")
     * @Method("POST")
     */
    public function carregarProdutoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $codProd = $reqest->request->get('codigo');
        
        $produto = $em->getRepository('LivrariaBundle:Produtos')
                ->find($codProd);
        
        if ($produto == null)
        {
            return $this->json('erro');
        }    
        
        $novoItem = new CupomItem();
        $novoItem->serCupomId($request->getSession()->get('cupom-id'));
        $novoItem->setDescricaoItem($produto-getNome);
        $novoItem->getItemCod($codProd);
        $novoItem->Quantidade(1);
        $novoItem->setValorUnitario($produto->getPreco());
        
        $em->persist($novoItem); // segura na memoria do doctrine.
        $em->Flush(); // grava no banco de dados.
       
        return $this->json('ok');
    
    }
    
    /**
     * @Route("caixa/estorno/{item}")
     */
    public function estornarItemAction(Request $request, $item)
    {
         $cupomId = $request->getSession()->get('cupom-id'); 
                
        $em = $this->getDoctrine()->getManager();
        
        $itemOld = $em->getRepository('LivrariaBundle:CompomItem')
                ->findBy(array(
                   'cupomId' => $cupomId,
                   'ordemItem' => $item 
                ));
        
        $itemEstorno = new CupomItem();
        $itemEstorno->setCupomId($cupomId);
        $itemEstorno->setDescricaoItem("Estorno do Item: $item");
        $itemEstorno->setItemCod(1001);
        $itemEstorno->setQuantidade(1);
        $itemEstorno->setValorUnitario($itemOld->getValorUnitario()* -1);
        
       $em->persist($itemEstorno); // segura na memoria do doctrine.
       $em->Flush(); // grava no banco de dados.
    
       return $this->json('ok');
       
    }
    
    /**
     * @Route("caixa/cancelar")
     */
    public function cancelarVendaAction(Request $request)
    {
        $cupomId = $request->getSession()->get('cupom-id'); 
                
        $em = $this->getDoctrine()->getManager();
        $cupom = $em->getRepository('LivrariaBundle:cupom')->find($em);
        $cupom->setStatus('CANCELADO');
        
        $em->persist($cupom); // segura na memoria do doctrine.
        $em->Flush(); // grava no banco de dados.
        
        return $this->json('ok');
        
    }
    
    /**
     * @Route("caixa/finalizar")
     */
    public function finalizarVendaAction(Request $request)
    {
        $cupomId = $request->getSession()->get('cupom-id'); 
                
        $em = $this->getDoctrine()->getManager();
        $cupom = $em->getRepository('LivrariaBundle:cupom')->find($em);
        $cupom->setStatus('FINALIZADO');
        
        $em->persist($cupom); // segura na memoria do doctrine.
        $em->Flush(); // grava no banco de dados.
        
        //Baixar os Itens do estoque
        // Fechar total da compra
        
        return $this->json('ok');
        
    }
    
    /**
     * @Route("caixa/listar")
     */
    public function listarItensAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $itens = $em->getRepository("LivrariaBundle:CupomItem")
                ->findBy(array(
                    "cupomId" => $request->getSession()->get('cupom-id')                    
                ));        
        return $this->json($itens);
    }
}
