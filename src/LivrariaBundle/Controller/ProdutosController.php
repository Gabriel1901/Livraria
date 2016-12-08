<?php

namespace LivrariaBundle\Controller;

use LivrariaBundle\Entity\Produtos;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Produto controller.
 *
 * @Route("produtos")
 */
class ProdutosController extends Controller
{
    /**
     * Lists all produto entities.
     *
     * @Route("/", name="produtos_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $produtos = $em->getRepository('LivrariaBundle:Produtos')->findAll();

        return $this->render('LivrariaBundle:Produtos:index.html.twig', array(
            'produtos' => $produtos,
        ));
    }

    /**
     * Creates a new produto entity.
     *
     * @Route("/new", name="produtos_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $produto = new Produtos();
        
        $form = $this->createForm('LivrariaBundle\Form\ProdutosType', $produto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($produto);
            $em->flush($produto);

            return $this->redirectToRoute('produtos_show', array('id' => $produto->getId()));
        }

        return $this->render('LivrariaBundle:Produtos:new.html.twig', array(
            'produto' => $produto,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a produto entity.
     *
     * @Route("/{id}", name="produtos_show")
     * @Method("GET")
     */
    public function showAction(Produtos $produto)
    {
                
        $deleteForm = $this->createDeleteForm($produto);

        return $this->render('LivrariaBundle:Produtos:show.html.twig', array(
            'produto' => $produto,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing produto entity.
     *
     * @Route("/{id}/edit", name="produtos_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Produtos $produto)
    {
        $deleteForm = $this->createDeleteForm($produto);
        $editForm = $this->createForm('LivrariaBundle\Form\ProdutosType', $produto);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produtos_edit', array('id' => $produto->getId()));
        }

        return $this->render('LivrariaBundle:Produtos:edit.html.twig', array(
            'produto' => $produto,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a produto entity.
     *
     * @Route("/{id}", name="produtos_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Produtos $produto)
    {
        $form = $this->createDeleteForm($produto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($produto);
            $em->flush($produto);
        }

        return $this->redirectToRoute('produtos_index');
    }

    /**
     * Creates a form to delete a produto entity.
     *
     * @param Produtos $produto The produto entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Produtos $produto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('produtos_delete', array('id' => $produto->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
