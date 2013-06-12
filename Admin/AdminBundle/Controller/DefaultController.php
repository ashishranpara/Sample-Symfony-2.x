<?php
/**
 * Desc : Controller is used for basic functionality of the user.
 * @author 
 *
 */
namespace Admin\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Admin\AdminBundle\Entity\User;
use Admin\AdminBundle\Form\ChangePasswordType;

class DefaultController extends Controller
{
    
	/**
	* Action is the entry point when user logged in 
	* @author 
	 */
    public function indexAction()
    {
    	$users = $this->get('security.context')->getToken()->getUser();
		$roles = $users->getRoles();
		$session = $this->getRequest()->getSession();
    	if(!empty($roles[0]))
    	{
			$session->set('role_name', $roles[0]->getName());
			$session->set('role_title', $roles[0]->getTitle());
    	}
    	return $this->render('AdminBundle:Default:index.html.twig');
    }
    /**
     * Desc : Method used for the change password functionality
     * @author  
     */
    public function changePasswordAction()
    {
    	$request = $this->getRequest();
    	$params = $request->get('change_password');
    	$errors = array();
    	$entity = new User();
    	
    	$form = $this->createForm(new ChangePasswordType(), $entity,array('validation_groups' => array('change_password')));
    	
		
    	if ($request->getMethod() == 'POST') {
    			 $form->bindRequest($request);
    			 if($form->isValid())
    			 {
	    			 $em = $this->getDoctrine()->getEntityManager();
	    			 $users = $this->get('security.context')->getToken()->getUser();
	    			 $loggin_user_id = $users->getId();
		    		 $entity_user = $em->getRepository('AdminBundle:User')->find($loggin_user_id);
		    		 
		    		 if($entity_user){
		    		 	$entity_user->setPassword(md5($params['password']['Password']));
		   			 	$em->flush();
		   			 	
		   			 	$this->get('session')->setFlash('success', "Password changed successfully");
		    		 }else{
		    		 	$this->get('session')->setFlash('error', "user not found");
		    		 }
		   			 return $this->redirect($this->generateUrl('AdminBundle_homepage'));   		
    			 }
    	}
    	if($request->getMethod() == 'POST'){
    			$validator = $this->get('validator', array('change_password'));
				$errors = $validator->validate($entity);
    	} 
    	//echo "<pre>";
    	//print_r($form->createView());exit;
		return $this->render('AdminBundle:Default:changePassword.html.twig', array('form' => $form->createView(),'error' => $errors));
    		
    }
    
}
