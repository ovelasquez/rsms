<?php

namespace Rsms\TrabajandoBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Rsms\TrabajandoBundle\Entity\Postulacion;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializerBuilder as Ser;
use Rsms\TrabajandoBundle\Util\Util;

/**
 * Postulacion controller.
 *
 * @Route("/adm/postulacion")
 */
class PostulacionController extends Controller
{

    /**
     * Lists all Postulacion entities.
     *
     * @Route("/", name="postulacion")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
               
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RsmsTrabajandoBundle:Postulacion')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    
    /**
     * Lists all Postulacion entities by id_envio.
     *
     * @Route("/envio/{id}", name="postulacion_byenvio")
     * @Method("GET")
     * @Template()
     */
    public function byenvioAction($id)
    {
               
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RsmsTrabajandoBundle:Postulacion')->findByIdEnvio($id);

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Postulacion entity.
     *
     * @Route("/{id}", name="postulacion_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RsmsTrabajandoBundle:Postulacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Postulacion entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }
    /**
     * Lists all Postulacion entities.
     *
     * @Route("/todos", name="postulacion_todos")
     * @Method("GET")
     * @Template()
     */
    public function todosAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('RsmsTrabajandoBundle:Postulacion')->findAll();
        $entArr = array();
        foreach ($entities as $ent)
        {
            $entArr[]= get_object_vars($ent);
            var_dump(($ent));
        }
        
        die();
        return array(
            'entities'      => json_encode($entArr)
        );
    }
    
    
    /**
     * Finds and displays a Postulacion entity.
     *
     * @Route("/api/postulaciones/{id}", name="postulacion_get")
     * @Method("GET")
     * @Template()
     */
    public function getAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('RsmsTrabajandoBundle:Postulacion')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Postulacion entity.');
        }

        return array(
            'entity'      => $entity->getMensaje(),
        );
    }
    
    /**
     * Insert  Postulacion entities.
     *
     * @Route("/api/postulaciones", name="postulacion_post")
     * @Method("POST")
     * @Template()
     */
    public function postAction(Request $request) {
        
        $em = $this->getDoctrine()->getManager();
        $logger = $this->get('logger'); 
        
        $keyr = $request->request->keys();
        $cred = array();
        $post = array();
        foreach ($keyr as $value) {
            switch ($value) {
                case 'credential':
                    $cred[]=$request->request->get($value);
                    break;

                default:
                    $post[]=array_merge((array)$request->request->get($value), (array)$value);
                    
                    break;
            }
        }
               
        $jsoncontactosstr = '';
        $jsonresultadostr = '';
        
        $postjson = json_encode($post);
        $logger->info('PETICION POST  :::: '.$postjson.' ::::::'.  \date('Y-m-d H:i:s'));
        $respt = array();
        foreach ($post as $value) {
            /******** Validando CODIGO DE SMS****/
            $cod = $value["content"];
            $entityE = new \Rsms\TrabajandoBundle\Entity\Envios();
            $entityE = $em->getRepository('RsmsTrabajandoBundle:Envios')->findOneByCodigo($cod);
            //var_dump($entityE);
            $estatus = -2;
            $msjRespT = $msjResp ='';
            $statusResp='';
            
            if ($entityE) {   
                if ($entityE->getStatus()==1):
                    /******** Registrando en ENVIOS estatus *******/
                    $entityE->setStatus(2);
                    $em->flush(); 

                    if ($this->container->getParameter('rsms.env')=="prod"):
                        /******** Pasando datos a trabajando.com****/
                        $data=array("domainId"=> $entityE->getDominioid(),"personId"=> $entityE->getPersonaid(),"jobId"=> $entityE->getAvisoid(),"countryId"=> "1","country"=> "CL","client"=> "RSMS","token"=> $this->container->getParameter('rsms.trabajando.ws.token'));
                        $data1 = json_encode($data);
                        $ch = curl_init(); // set the URL 
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                        curl_setopt($ch, CURLOPT_URL, $this->container->getParameter('rsms.trabajando.ws.url')); // return the response instead of printing 
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // set request method to POST
                        curl_setopt($ch, CURLOPT_POST, true); // set the data to send 
                        $logger->info('JSON DE PETICION TRAB  :::: '.$data1.' ::::::'.  \date('Y-m-d H:i:s'));
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $data1); // send the request and store the response in $resp 
                        $respt[$entityE->getPersonaid()]= curl_exec($ch); // end the session 
                        curl_close($ch); 
                    else:
                        $respt[$entityE->getPersonaid()] = '{"status":"OK","code":0,"message":null,"data":{"success":true}}';
                    endif;
                       
                    /********GUARDANDO ESTATUS DE TRABAJANDO*****************/
                    $jsonRespT = json_decode($respt[$entityE->getPersonaid()], true);
                    $jpr = Util::json_last_error_msg_($jsonRespT).' '.  \date('Y-m-d H:i:s');
                    $logger->info($jpr);
                    if (is_array($jsonRespT)):                        
                        $msjRespT = $jsonRespT['status'].'#'.$jsonRespT['code'].'#'.$jsonRespT['message'].'#';
                        $statusResp = $jsonRespT['status'];
                    endif;
                        
                    
                    //$jsoncontactoscf[]=array($entityE->getIdOpratel()=>array("msisdn"=>$entityE->getFono(),"content"=>"Gracias por postular. Si tu perfil esta acorde con el cargo te contactaremos. En caso contrario estaras en nuestro archivo de elegibles para otra oportunidad","id"=>$entityE->getId()));
                    $jsoncontactosstr .= '"'.$value[0].'":{"msisdn":"'.$value["msisdn"].'","content":"'.$this->container->getParameter('rsms.msj.respuestapostulacion').'","id":"'.$entityE->getId().'"},';
                    $estatus = 1;
                    $msjResp = $this->container->getParameter('rsms.msj.respuestapostulacion');
                    
                elseif ($entityE->getStatus()==2):
                    $jsoncontactosstr .= '"'.$value[0].'":{"msisdn":"'.$value["msisdn"].'","content":"'.$this->container->getParameter('rsms.msj.respuestapostulacion').'","id":"'.$entityE->getId().'"},';                    
                    $msjResp = $this->container->getParameter('rsms.msj.respuestapostulacion');
                    $estatus = 2;                       
                endif;
                
            }else{
                //$jsoncontactoscf[]=array($value[0]=>array("msisdn"=>$value["msisdn"],"content"=>"Código invalido, por favor verifique el código de la oferta","id"=>"0"));
                $jsoncontactosstr .= '"'.$value[0].'":{"msisdn":"'.$value["msisdn"].'","content":"'.$this->container->getParameter('rsms.msj.codigonovalido').'","id":"0"},';                    
                $estatus = -1;
                $msjResp = $this->container->getParameter('rsms.msj.codigonovalido');
            } 
            /******** Guardando postualcion****/
            $postulacion = New Postulacion();
            $postulacion->setMensaje($value["content"]);
            $postulacion->setMensajeRepuesta($msjResp);
            $postulacion->setFechaCarga(new \DateTime());
            $postulacion->setFono($value["msisdn"]);
            $postulacion->setIdOpratel($value[0]);
            $postulacion->setStatus($estatus);
            if ($entityE) $postulacion->setIdEnvio($entityE);
            if ($msjRespT!='') $postulacion->setMensajeRepuestaTrabajando($msjRespT);  
            if ($statusResp!='') $postulacion->setStatusRepuestaTrabajando($statusResp);  
            $em->persist($postulacion);
            $em->flush();
            
            //MODO DEV
            $jsonresultadostr .= '"'.$value[0].'":{"Status":1,"id":"'.$value[0].'"},';
        }
        
        if (is_array($respt) && count($respt)>0)
            $logger->info('RESPUESTA DE PETICIONES TRABAJ  : '.  implode('|', $respt).' '.  \date('Y-m-d H:i:s'));
                
         /****PETICION DE CONFIRMACI[ON OPRATEL*/
         //$json1 = json_encode(array("credential"=>array("user"=>$this->container->getParameter('rsms.opratel.ws.user'),"passw"=>$this->container->getParameter('rsms.opratel.ws.passw')),"confirmation"=>$jsoncontactoscf));
        if (strlen($jsoncontactosstr)>1):
            $jsoncontactosstr = substr($jsoncontactosstr, 0,strlen($jsoncontactosstr)-1);
        endif;
        
        
        $json1 = '{"credential":{"user": "'.$this->container->getParameter('rsms.opratel.ws.user').'","pass": "'.$this->container->getParameter('rsms.opratel.ws.passw').'"},"confirmation":{'.$jsoncontactosstr.'}}';
        $logger->info('JSON DE PETICION CONF  :::: '.$json1.' ::::::'.  \date('Y-m-d H:i:s'));
        $json1 = json_encode($json1);   
        
        if ($this->container->getParameter('rsms.env')=="prod"):
            $ch = curl_init(); // set the URL 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_URL, $this->container->getParameter('rsms.opratel.ws.url')); // return the response instead of printing 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // set request method to POST
            curl_setopt($ch, CURLOPT_POST, true); // set the data to send 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json1); // send the request and store the response in $resp 
            $resp1= curl_exec($ch); // end the session 
            curl_close($ch);
            $logger->info('RESPUESTA DE PETICION CONF  :::: '.$resp1.' ::::::'.  \date('Y-m-d H:i:s'));
        else:
            //        $resp1 = '{"credential":{"Status":"1"},"response":[{"7":{"Status":1,"id":"1014175"}},{"8":{"Status":-2,"id":"0"}},{"9":{"Status":1,"id":"123456789"}}]}';
            if (strlen($jsonresultadostr)>1):
                $jsonresultadostr = substr($jsonresultadostr, 0,strlen($jsonresultadostr)-1);
            endif;
            $resp1 = '{"credential":{"Status":1},"response":{'.$jsonresultadostr.'}}';            
        endif;
          
        /****ACTUALIZACION DE  ESTATUS DE CONFIRMACION*/
        
        $jsonResp = json_decode($resp1, true);
        $jsond = json_last_error();
        $jpr = Util::json_last_error_msg_($jsonResp).' '.  \date('Y-m-d H:i:s');
        $logger->info($jpr);
          
        if (is_array($jsonResp)):
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
                               $entityP = null;

                               if (is_array($valuec)):
                                   $idc = $idcu;
                                   
                                   $entityP = $em->getRepository('RsmsTrabajandoBundle:Postulacion')->findOneByIdOpratel($idc);
                                    
                                   if ($entityP) {
                                       $entityP->setStatusRepuesta($valuec['Status']);
                                       $em->flush(); 
                                   }
                               endif;

                            }
                        }
                         
                         break;
                 }
             }    
        endif;
            
         
            
        return array(
            'status'      => array("status"=>($jsond+1)),
        );
       
        /*
         * STATUS DE POSTULACIÓN
         * 
         * 1  postulacion correcta
         * 2  postulación existente
         * -1 postualción inexistente (codigo invalido)
         * 
         */
    }
}
