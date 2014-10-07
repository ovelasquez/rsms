<?php

namespace Rsms\TrabajandoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Rsms\TrabajandoBundle\Entity\Envios;
use Rsms\TrabajandoBundle\Form\EnviosType;
use Rsms\TrabajandoBundle\Util\Util;
use Rsms\TrabajandoBundle\Entity\Candidatos;
use Rsms\TrabajandoBundle\Entity\Telefonos;
use Rsms\TrabajandoBundle\Entity\Empresas;

/**
 * Envios controller.
 *
 * @Route("/adm/envios")
 */
class EnviosController extends Controller
{

    /**
     * Lists all Envios entities.
     *
     * @Route("/", name="envios")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RsmsTrabajandoBundle:Envios')->findAll();
        
        

        return array(
            'entities' => $entities,
            
        );
    }
    
    
    /**
     * Displays a form to create a new Envios entity mass.
     *
     * @Route("/cargar", name="envios_cargar")
     * @Method("GET")
     * @Template("")
     */
    public function cargarAction()
    {
        $entity = new Envios();
        $form = $this->createFormBuilder($entity)
            ->setAction('registrar')               
            ->add('arch', 'file', array('required' => true,'label'=>'Archivo'))
            ->add('Cargar', 'submit',array('attr' => array('class' => 'btn btn-primary')))
            ->getForm();

        return $this->render('RsmsTrabajandoBundle:Envios:cargar.html.twig', array(
            'form' => $form->createView(),
            'cargamass' => false,
            'tot' => 0,
        ));
    }
    
    /**
     * Displays a form to create a new Envios entity mass.
     *
     * @Route("/registrar", name="envios_registrar")
     * @Method("POST")
     * @Template("RsmsTrabajandoBundle:Envios:cargar.html.twig")
     */
    public function registrarAction(Request $request)
    {
        $entity  = new Envios();
        $form = $this->createFormBuilder($entity)
            ->add('arch', 'file', array('required' => true))
            ->getForm();
        $form->handleRequest($request);
        $cont = 0;
        $entities = array();
        $jsoncontactos = array();
        
        $jsoncontactosstr = '';
        
        $logger = $this->get('logger'); 
        
        if ($entity->subirArch($this->container->getParameter('rsms.directorio.arch'))) {
            //$entity->subirArch($this->container->getParameter('rsms.directorio.arch'));
            $em = $this->getDoctrine()->getManager(); 
            $objPHPExcel = \PHPExcel_IOFactory::load($entity->getArch());
            $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
             
            foreach ($sheetData as $envio) {
                if ($envio["A"]!='Personaid' && $envio["B"]!=''):    
                      try {
                        $cmp = new Envios();  
                        $cmp->setPersonaid($envio["A"]);
                        $cmp->setRut($envio["B"]);
                        $cmp->setNombre(($envio["C"]));    
                        $cmp->setApellido(($envio["D"]));
                        $cmp->setFono($envio["E"]);
                        $cmp->setFecha(new \DateTime());
                        $mensaje = substr((html_entity_decode(trim($envio["F"]))),0,150);
                        $cmp->setOferta($mensaje);
                        $cmp->setAvisoid($envio["G"]);
                        $cmp->setDominioid($envio["H"]);   
                        $cmp->setCodigo(Util::unique_id(3)); 
                        $cmp->setStatus(0);
                        $em->persist($cmp);
                        $em->flush(); 
                        $entities[] = $cmp;
                        $logger->info('Oferta cargada en BD: Avisoid-'.$envio["G"].' Personaid-'.$envio["A"].' '.  \date('Y-m-d H:i:s'));
                        $cont = $cont +1;
                        //$jsoncontactos[]=array($cmp->getId()=>array("msisdn"=>$cmp->getFono(),"content"=>$cmp->getOferta().' '.$cmp->getCodigo()));
                        $jsoncontactosstr .= '"'.$cmp->getId().'":{"msisdn":"'.$cmp->getFono().'","content":"'.$cmp->getOferta().' '.$cmp->getCodigo().'"},';
                      }catch (\Exception $e) {                        
                        $logger->error($e->getMessage());
                       }
                
                    
                    
                endif;

            }
            
            //$em->flush(); 
            //die();
        }
        
        unlink($entity->getArch());

        $entity = new Envios();
        $form = $this->createFormBuilder($entity)
            ->add('arch', 'file', array('required' => true))
            ->getForm();
        $resp1=$resp = 'False';
        $json1=$json = 'Null';
        $logger->info('PETICION : '.  \date('Y-m-d H:i:s'));
        try {
           /****PETICION DE CONTACTO*/
            //$json = json_encode(array("credential"=>array("user"=>$this->container->getParameter('rsms.opratel.ws.user'),"passw"=>$this->container->getParameter('rsms.opratel.ws.passw')),"contact"=>$jsoncontactos));
            if (strlen($jsoncontactosstr)>1):
                $jsoncontactosstr = substr($jsoncontactosstr, 0,strlen($jsoncontactosstr)-1);
            endif;
            $json = '{"credential":{"user": "'.$this->container->getParameter('rsms.opratel.ws.user').'","pass": "'.$this->container->getParameter('rsms.opratel.ws.passw').'"},"contact":{'.$jsoncontactosstr.'}}';
            $json = json_encode($json);
            $ch = curl_init(); // set the URL 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL, $this->container->getParameter('rsms.opratel.ws.url')); // return the response instead of printing 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // set request method to POST
            curl_setopt($ch, CURLOPT_POST, true); // set the data to send 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json); // send the request and store the response in $resp 
            $resp= curl_exec($ch); // end the session
            if($errno = curl_errno($ch)) {
                //$error_message = curl_strerror($errno);
                echo "cURL error ({$errno}):\n ";
            }

        //var_dump($resp); die();
            curl_close($ch);
            $logger->info('RESPUESTA DE PETICION CONTC : '.$resp.' '.  \date('Y-m-d H:i:s'));
           
//          $resp = '{"credential":{"Status":1},"response":[{"2":{"Status":1,"code":"102"}},{"3":{"Status":1,"code":"103"}},{"4":{"Status":-2,"code":"0"}}]}';
          /****ACTUALIZACION DE CONTACTO*/
           
           $jsonResp = json_decode($resp,true);  
           echo $jdres = Util::json_last_error_msg_($jsonResp);
           $logger->info($jdres.' '.  \date('Y-m-d H:i:s'));
           if (is_array($jsonResp)){
                $jsonRespk = array_keys($jsonResp);
                $cred = $conts = array();
                $jsoncontactoscf = array(); 
                
                foreach ($jsonRespk as $value) {
                     switch ($value) {
                         case 'credential':
                             $cred[]=$jsonResp[$value];
                             break;

                         default:
                             //$conts[]=array_merge((array)$jsonResp[$value], (array)$value);
                             $conf = $jsonResp[$value]; 
                             
                             if (is_array($conf)){                            
                                 $idcs = array_keys($conf);
                                 
                                 foreach ($idcs as $idcu) {
                                     
                                    $valuec = $conf[$idcu];
                                    $entityE = null;
                                    
                                    if (is_array($valuec)):
                                        $idc = $idcu;
                                        $entityE = $em->getRepository('RsmsTrabajandoBundle:Envios')->find($idc);
                                        //var_dump($valuec['Status']); die();
                                        if ($entityE) {
                                            $entityE->setStatus($valuec['Status']);
                                            $entityE->setIdOpratel($valuec['code']);
                                            $em->flush(); 
                                            //$jsoncontactoscf[]=array($entityE->getIdOpratel()=>array("msisdn"=>$entityE->getFono(),"content"=>"Gracias por postular. Si tu perfil esta acorde con el cargo te contactaremos. En caso contrario estaras en nuestro archivo de elegibles para otra oportunidad","id"=>$entityE->getId()));
                                        }else{
                                            //$jsoncontactoscf[]=array($valuec[$idc[0]]['code']=>array("msisdn"=>"0","content"=>"Código invalido, por favor verifique el código de la oferta","id"=>$idc[0]));
                                        } 
                                    endif;
                                    
                                 }
                             }
                             
                             break;
                     }
                 }
                    
                 /****PETICION DE CONFIRMACI[ON*/
                 $json1 = json_encode(array("credential"=>array("user"=>$this->container->getParameter('rsms.opratel.ws.user'),"passw"=>$this->container->getParameter('rsms.opratel.ws.passw')),"confirmation"=>$jsoncontactoscf));

    
           }
           
            
        }catch (\Exception $e) {                        
            $logger->error($e->getMessage());
           }
        
        return $this->render('RsmsTrabajandoBundle:Envios:rescarga.html.twig', array(
            'form' => $form->createView(),
            'cargamass' => true,
            'tot' => $cont,
            'entities' => $entities,
            'jsoncT' =>$json,
            'jsoncF' =>$json1,
            'resp' =>$resp,
            'resp1' =>$resp1,
        ));
    }

    /**
     * Finds and displays a Envios entity.
     *
     * @Route("/{id}", name="envios_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RsmsTrabajandoBundle:Envios')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Envios entity.');
        }

        //$deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            //'delete_form' => $deleteForm->createView(),
        );
    }
    
    
    /**
     * Insert  Envios entities.
     *
     * @Route("/api/envios", name="envios_post")
     * @Method("POST")
     * @Template()
     */
    public function postAction(Request $request) {
        
        $em = $this->getDoctrine()->getManager();
        $cont = 0;
        $entities = array();
        $jsoncontactos = array();
                     
        $logger = $this->get('logger'); 
        
        $keyr = $request->request->keys();
        $cred = array();
        $env = array();
        foreach ($keyr as $value) {
            switch ($value) {
                case 'credential':
                    $cred[]=$request->request->get($value);
                    break;

                default:
                    $env[]=array_merge((array)$request->request->get($value), (array)$value);
                    
                    break;
            }
        }
               
        $jsoncontactosstr = '';
        $jsonresultadostr = '';
        
        $postjson = json_encode($env);
        $logger->info('JSON INI DE PETICION POST  :::: '.$postjson.' ::::::'.  \date('Y-m-d H:i:s'));
        $respt = array();
        foreach ($env as $value) {
            //var_dump($value[0]);
            try {
                //ENVIOS
                $cmp = new Envios();  
                $cmp->setPersonaid($value[0]);
                $cmp->setRut($value[0]);
                $cmp->setNombre($value["nombre"]);    
                $cmp->setApellido($value["nombre"]);
                $cmp->setFono($value["telefono"]);
                $cmp->setFecha(new \DateTime());
                $mensaje = substr((html_entity_decode(trim($value["mensaje"]))),0,150);
                $cmp->setOferta($mensaje);
                $cmp->setAvisoid($value["vacante"]);
                $cmp->setEmpresaid($value["empresa"]);
                $cmp->setDominioid(0);   
                $cmp->setCodigo(Util::unique_id(3)); 
                $cmp->setfechaOferta(new \DateTime($value["fechavac"])); 
                $cmp->setStatusEnrolamiento($value["stenrolamiento"]); 
                if ($value["stenrolamiento"]=="1"):
                    $cmp->setPorEnvio(1); 
                endif;
                $cmp->setStatus(0);
                $em->persist($cmp);
                $em->flush(); 
                        
                
                If(!$em->getRepository('RsmsTrabajandoBundle:Candidatos')->findOneByTrabajandoId($value[0])):
                    //CANDIDATO + TELEFONO
                    $cand = new Candidatos();  
                    $cand->setTrabajandoId($value[0]);
                    $cand->setNombre($value["nombre"]);  
                    $cand->setApellido($value["nombre"]);                                
                    $cand->setFecha(new \DateTime());            
                    $em->persist($cand);  
                    $em->flush(); 
                    If(!$em->getRepository('RsmsTrabajandoBundle:Telefonos')->findOneByNumero($value["telefono"])):
                        $telf = new Telefonos();
                        $telf->setNumero($value["telefono"]);
                        $telf->setCandidato($cand);
                        $telf->setFecha(new \DateTime());
                        $em->persist($telf); 
                        $em->flush();
                   endif;
                     
                endif;
                
                
                If(!$em->getRepository('RsmsTrabajandoBundle:Empresas')->findOneByTrabajandoId($value["empresa"])):
                    // EMPRESA
                    $emp = new Empresas();  
                    $emp->setTrabajandoId($value["empresa"]);
                    $emp->setNombre($value["empresa"]);                  
                    $emp->setFecha(new \DateTime());            
                    $em->persist($emp);  
                    $em->flush(); 
                    $em->clear();
                endif;
                
                $entities[] = $cmp;
                $logger->info('Oferta cargada en BD: Avisoid-'.$value["vacante"].' Personaid-'.$value[0].' '.  \date('Y-m-d H:i:s'));
                $cont = $cont +1;
                //$jsoncontactos[]=array($cmp->getId()=>array("msisdn"=>$cmp->getFono(),"content"=>$cmp->getOferta().' '.$cmp->getCodigo()));
                $mensajeEnviar = $cmp->getOferta();
                if ($cmp->getPorEnvio()==1):
                    $mensajeEnviar = $this->container->getParameter('rsms.msj.enrolamiento'); 
                endif;
                $jsoncontactosstr .= '"'.$cmp->getId().'":{"msisdn":"'.$cmp->getFono().'","content":"'.$mensajeEnviar.' '.$cmp->getCodigo().'"},';
                $jsonresultadostr .= '"'.$cmp->getId().'":{"Status":"1","code":"102"},';
              }catch (\Exception $e) {                        
                $logger->error($e->getMessage());
              }
        }        
        
        
        $resp = 'False';
        $json = 'Null';
        $logger->info('PETICION : '.  \date('Y-m-d H:i:s'));
        try {
           /****PETICION DE CONTACTO*/
            if (strlen($jsoncontactosstr)>1):
                $jsoncontactosstr = substr($jsoncontactosstr, 0,strlen($jsoncontactosstr)-1);
            endif;
            $json = '{"credential":{"user": "'.$this->container->getParameter('rsms.opratel.ws.user').'","pass": "'.$this->container->getParameter('rsms.opratel.ws.passw').'"},"contact":{'.$jsoncontactosstr.'}}';
            $logger->info('PETICION JSON: '.  $json);
            $json = json_encode($json);
            
            if ($this->container->getParameter('rsms.env')=="prod"):
                $ch = curl_init(); // set the URL 
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                curl_setopt($ch, CURLOPT_URL, $this->container->getParameter('rsms.opratel.ws.url')); // return the response instead of printing 
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // set request method to POST
                curl_setopt($ch, CURLOPT_POST, true); // set the data to send 
                curl_setopt($ch, CURLOPT_POSTFIELDS, $json); // send the request and store the response in $resp 
                $resp= curl_exec($ch); // end the session
                if($errno = curl_errno($ch)) {
                    //$error_message = curl_strerror($errno);
                    echo "cURL error ({$errno}):\n ";
                }
                curl_close($ch);
                $logger->info('RESPUESTA DE PETICION CONTC : '.$resp.' '.  \date('Y-m-d H:i:s'));
            else :
                //$resp = '{"credential":{"Status":1},"response":[{"2":{"Status":1,"code":"102"}},{"3":{"Status":1,"code":"103"}},{"4":{"Status":-2,"code":"0"}}]}';
                if (strlen($jsonresultadostr)>1): $jsonresultadostr = substr($jsonresultadostr, 0,strlen($jsonresultadostr)-1);endif;
                $resp = '{"credential":{"Status":1},"response":{'.$jsonresultadostr.'}}';
            endif;
            
           
            /****ACTUALIZACION DE CONTACTO*/
           
           $jsonResp = json_decode($resp,true);  
           echo $jdres = Util::json_last_error_msg_($jsonResp);
           $logger->info($jdres.' '.  \date('Y-m-d H:i:s'));
           if (is_array($jsonResp)){
                $jsonRespk = array_keys($jsonResp);
                $cred = $conts = array();
                                
                foreach ($jsonRespk as $value) {
                     switch ($value) {
                         case 'credential':
                             $cred[]=$jsonResp[$value];
                             break;

                         default:
                             $conf = $jsonResp[$value]; 
                             
                             if (is_array($conf)){                            
                                 $idcs = array_keys($conf);
                                 
                                 foreach ($idcs as $idcu) {
                                     
                                    $valuec = $conf[$idcu];
                                    $entityE = null;
                                    
                                    if (is_array($valuec)):
                                        $idc = $idcu;
                                        $entityE = $em->getRepository('RsmsTrabajandoBundle:Envios')->find($idc);
                                        
                                        if ($entityE) {
                                            
                                            $entityE->setStatus($valuec['Status']);
                                            $entityE->setIdOpratel($valuec['code']);
                                            $em->flush();                                             
                                        }
                                    endif;
                                    
                                 }
                             }
                             
                             break;
                     }
                 }
                    
                 
    
           }
           
            
        }catch (\Exception $e) {                        
            $logger->error($e->getMessage());
           }
            
        return array(
            'status'      => array("status"=>(1)),
        );
       
        
    }

    
    
    
    
}
