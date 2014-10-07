<?php

namespace Rsms\TrabajandoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Default controller.
 *
 * @Route("/adm")
 */
class DefaultController extends Controller {

    /**
     * @Route("/", name="default_adm")
     * @Template()
     */
    public function indexAction() {
        
        // Vista para un administrador
        if ((true === $this->get('security.context')->isGranted('ROLE_SUPER_ADMIN'))) {

            $em = $this->getDoctrine()->getManager();

            // Buscamos la cantidad de SMS usados por los Clientes
            $clientes = $em->getRepository('RsmsTrabajandoBundle:Clientes')->findAll();
            $contadorSmsUsados = 0;
            $totalClientes = count($clientes);
            foreach ($clientes as $cliente) {
                $contadorSmsUsados = $contadorSmsUsados + $cliente->getCantidadSmsUsados();
            }


            // Buscamos la cantidad de SMS adquiridos por los Clientes

            $clientePaqueteSms = $em->getRepository('RsmsTrabajandoBundle:ClientePaqueteSms')->findAll();

            $contadorSmsAdquiridos = 0;
            foreach ($clientePaqueteSms as $cliente) {
                $contadorSmsAdquiridos = $contadorSmsAdquiridos + $cliente->getPaqueteSms()->getCantidadSms();
            }


            return array(
                'clientesContadorSmsUsados' => $contadorSmsUsados,
                'clientesContadorSmsAdquiridos' => $contadorSmsAdquiridos,
                'totalClientes' => $totalClientes,
                'clientePaqueteSms' => $clientePaqueteSms,
                'clientes' => $clientes,
            );
        } else {
            $cliente = $this->get('security.context')->getToken()->getUser()->getCliente()->getId();
            return $this->redirect($this->generateUrl('clientes_show', array('id' => $cliente)));
        }
    }

}
