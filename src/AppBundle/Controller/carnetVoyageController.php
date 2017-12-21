<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Destination;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("carnet-de-voyage")
 */

class carnetVoyageController extends Controller
{

    /**
     * @Route("/", name="carnetVoyage")
     * @Method("GET")
     */
    public function carnetVoyage() {
        $em = $this->getDoctrine()->getManager();
        // $countries = $em->getRepository('AppBundle:Destination')->findAll();
        $countries = $em->getRepository('AppBundle:Destination')->getLastDestinations();

        return $this->render('destination/carnetVoyage.html.twig', array(
            'countries' => $countries
        ));
    }


}
