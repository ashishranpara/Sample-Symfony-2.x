<?php
/**
 * Controller is used for the security of the project and login form
 * @author 
 *
 */
namespace Admin\AdminBundle\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
 
class SecurityController extends Controller
{
	/**
	 * Display the login form when user open the site
	 * @author 
	 */
    public function loginAction()
    {
    	//var_dump($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED'));
        //var_dump($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY'));
        if (true === $this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('AdminBundle_homepage'));                    
            //exit('stop here');
            //throw new AccessDeniedException();
        }
            
        if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }
 
        return $this->render('AdminBundle:Security:login.html.twig', array(
            'last_username' => $this->get('request')->getSession()->get(SecurityContext::LAST_USERNAME),
            'error' => $error
        ));
    }
    /**
     * Action is used for the unauthorise page
     * @author 
     */
    public function unauthorisedAction()
    {
    	return $this->render('AdminBundle:Security:unauthorised.html.twig');
    	
    }
}