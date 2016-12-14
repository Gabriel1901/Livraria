<?php

namespace LivrariaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use \LivrariaBundle\Entity\Cupom;
use \LivrariaBundle\Entity\CupomItem;
use \LivrariaBundle\Entity\Produtos;

/**
 * Description of CaixaController
 *
 * @author aluno
 */
class CaixaController extends Controller
{
    /**
     * @Route("/caixa", name="caixa-index")
     */    
    public function pdvActrion(Request $request)
    {
       $cupomId = $request->getSession()->get('cupom-id', null); 
       
       if($cupomId === null)
       {
            $cupom = new Cupom();
            $cupom->setData(new \DateTime());
            $cupom->setValorTotal(0);
            $cupom->setVendedor(1);

            $em = $this->getDoctrine()->getManager(); //carrega o doctrine
            $em->persist($cupom); // segura na memoria do doctrine.
            $em->Flush(); // grava no banco de dados.

            $request->getSession()->set('cupom-id', $cupom->getId());
       }
       
       return $this->render("LivrariaBundle:Caixa:pdv.html.twig"); 
    }
    
    /**
     * @Route("caixa/carregar", name="pesquisar_produto")
     * @Method("POST")
     */
    public function carregarProdutoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $codProd = $request->request->get('codigo');
        
        
        $cupomId = $request->getSession()->get('cupom-id');
                
        $produto = $em->getRepository('LivrariaBundle:Produtos')
                ->find($codProd);
        
        $cupom = $em->getRepository('LivrariaBundle:Cupom')
                ->find($cupomId);
        
        $quantItem = $em->getRepository('LivrariaBundle:CupomItem')
                ->findBy(array("cupomId" => $cupomId));
        
        
        
        
        if ($produto instanceof Produtos)
        {
              
        
        $novoItem = new CupomItem();
        $novoItem->setCupomId($cupom);
        $novoItem->setDescricaoItem($produto->getNome());
        $novoItem->setItemCod($codProd);
        $novoItem->setQuantidade(1);
        $novoItem->setValorUnitario($produto->getPreco());
        $novoItem->setOrdemItem(count($quantItem)+1);
        
        $em->persist($novoItem); // segura na memoria do doctrine.
        $em->Flush(); // grava no banco de dados.
       
        $retorno["status"] = "ok";
        $retorno["produto"] = $produto;
        
        
        
        }else{
            
            $retorno["status"] = "erro";
            $retorno["menssagem"] = "Produto não encontrado";
             
        }
    
            return $this->json($retorno);
    }
    
    /**
     * @Route("caixa/estorno/{item}")
     */
    public function estornarItemAction(Request $request, $item)
    {
         $cupomId = $request->getSession()->get('cupom-id'); 
                
        $em = $this->getDoctrine()->getManager();
        
        $itemOld = $em->getRepository('LivrariaBundle:CupomItem')
                ->findOneBy(array(
                   'cupomId' => $cupomId,
                   'ordemItem' => $item 
                ));
        
        $cupom = $em->getRepository('LivrariaBundle:Cupom')
                ->find($cupomId);
        
        $quantItem = $em->getRepository('LivrariaBundle:CupomItem')
                ->findBy(array("cupomId" => $cupomId));
        
        $itemEstorno = new CupomItem();
        $itemEstorno->setCupomId($cupom);
        $itemEstorno->setDescricaoItem("Estorno do Item: $item");
        $itemEstorno->setItemCod(9999);
        $itemEstorno->setQuantidade(1);
        $itemEstorno->setValorUnitario($itemOld->getValorUnitario()* -1);
        $itemEstorno->setOrdemItem(count($quantItem) + 1);
        
       $em->persist($itemEstorno); // segura na memoria do doctrine.
       $em->Flush(); // grava no banco de dados.
    
       return $this->redirectToRoute('caixa-index');
       
    }
    
    /**
     * @Route("caixa/cancelar", name="cancelar")
     */
    public function cancelarVendaAction(Request $request)
    {
        $cupomId = $request->getSession()->get('cupom-id'); 
                
        $em = $this->getDoctrine()->getManager();
        $cupom = $em->getRepository('LivrariaBundle:Cupom')->find($cupomId);
        
        $cupom->setStatus('CANCELADO');
        
        $em->persist($cupom); // segura na memoria do doctrine.
        $em->Flush(); // grava no banco de dados.
        
        $request->getSession()->set('cupom-id', null);
        
        
        return $this->redirectToRoute('caixa-index');
        
    }
    
    /**
     * @Route("caixa/finalizar", name="concluir")
     */
    public function finalizarVendaAction(Request $request)
    {
        $cupomId = $request->getSession()->get('cupom-id'); 
                
        $em = $this->getDoctrine()->getManager();
        $cupom = $em->getRepository('LivrariaBundle:Cupom')->find($cupomId);
        $cupom->setStatus('FINALIZADO');
        
        $valorTotal = 0;
        
        $itens = $em->getRepository("LivrariaBundle:CupomItem")
                ->findBy(array(
                    "cupomId" => $request->getSession()->get('cupom-id')                    
                )); 
        
                foreach ($itens as $item)
                {
                    //Fecha Total da compra - ok
                    $valorTotal += $item->getValorUnitario();
                    
                    //BAixa os itens do estoque - ok
                    $produto = $em->getRepository('LivrariaBundle:Produtos')
                            ->find($item->getItemCod());
                    
                    $produto->setQuantidade($produto->getQuantidade() - 1);
                    
                    $em->persist($produto); // segura na memoria do doctrine.
                    
                }
                
                $cupom->setValorTotal($valorTotal);
        
        $em->persist($cupom); // segura na memoria do doctrine.
        $em->Flush(); // grava no banco de dados.
        
        
        $request->getSession()->set('cupom-id', null);
        
        
        return $this->redirectToRoute('caixa-index');
        
    }
    
    /**
     * @Route("caixa/listar", name="listagem" )
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
    
    /**
     * @Route("caixa/listar", name="unitario" )
     */
    public function listarUnitarioAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $itens = $em->getRepository("LivrariaBundle:Produtos")
                ->findBy(array(
                    "id" => $request->getSession()->get('produtos')                    
                ));        
        return $this->json($itens);
        
    }
    
}
