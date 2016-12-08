<?php

namespace LivrariaBundle\Controller;

use LivrariaBundle\Entity\Genero;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Genero controller.
 *
 * @Route("genero")
 */
class GeneroController extends Controller
{
    /**
     * Lists all genero entities.
     *
     * @Route("/", name="genero_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $generos = $em->getRepository('LivrariaBundle:Genero')->findAll();

        return $this->render('LivrariaBundle:Genero:index.html.twig', array(
            'generos' => $generos,
        ));
    }

    /**
     * Creates a new genero entity.
     *
     * @Route("/new", name="genero_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $genero = new Genero();
        $form = $this->createForm('LivrariaBundle\Form\GeneroType', $genero);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($genero);
            $em->flush($genero);

            return $this->redirectToRoute('genero_show', array('id' => $genero->getId()));
        }

        return $this->render('LivrariaBundle:Genero:new.html.twig', array(
            'genero' => $genero,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a genero entity.
     *
     * @Route("/{id}", name="genero_show")
     * @Method("GET")
     */
    public function showAction(Genero $genero)
    {
        $deleteForm = $this->createDeleteForm($genero);

        return $this->render('LivrariaBundle:Genero:show.html.twig', array(
            'genero' => $genero,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing genero entity.
     *
     * @Route("/{id}/edit", name="genero_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Genero $genero)
    {
        $deleteForm = $this->createDeleteForm($genero);
        $editForm = $this->createForm('LivrariaBundle\Form\GeneroType', $genero);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('genero_edit', array('id' => $genero->getId()));
        }

        return $this->render('LivrariaBundle:Genero:edit.html.twig', array(
            'genero' => $genero,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a genero entity.
     *
     * @Route("/{id}", name="genero_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Genero $genero)
    {
        $form = $this->createDeleteForm($genero);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($genero);
            $em->flush($genero);
        }

        return $this->redirectToRoute('genero_index');
    }

    /**
     * Creates a form to delete a genero entity.
     *
     * @param Genero $genero The genero entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Genero $genero)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('genero_delete', array('id' => $genero->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
