<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Step;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Step controller.
 *
 * @Route("step")
 */
class StepController extends Controller
{
    /**
     * Lists all step entities.
     *
     * @Route("/", name="step_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $steps = $em->getRepository('AppBundle:Step')->findAll();

        return $this->render('step/index.html.twig', array(
            'steps' => $steps,
        ));
    }

    /**
     * Creates a new step entity.
     *
     * @Route("/new", name="step_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $step = new Step();
        $form = $this->createForm('AppBundle\Form\StepType', $step);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($step);
            $em->flush();

            return $this->redirectToRoute('step_show', array('id' => $step->getId()));
        }

        return $this->render('step/new.html.twig', array(
            'step' => $step,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a step entity.
     *
     * @Route("/{id}", name="step_show")
     * @Method("GET")
     */
    public function showAction(Step $step)
    {
        $deleteForm = $this->createDeleteForm($step);

        return $this->render('step/show.html.twig', array(
            'step' => $step,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing step entity.
     *
     * @Route("/{id}/edit", name="step_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Step $step)
    {
        $deleteForm = $this->createDeleteForm($step);
        $editForm = $this->createForm('AppBundle\Form\StepType', $step);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('step_edit', array('id' => $step->getId()));
        }

        return $this->render('step/edit.html.twig', array(
            'step' => $step,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a step entity.
     *
     * @Route("/{id}", name="step_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Step $step)
    {
        $form = $this->createDeleteForm($step);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($step);
            $em->flush();
        }

        return $this->redirectToRoute('step_index');
    }

    /**
     * Creates a form to delete a step entity.
     *
     * @param Step $step The step entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Step $step)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('step_delete', array('id' => $step->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
