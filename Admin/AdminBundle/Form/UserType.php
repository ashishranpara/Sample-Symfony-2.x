<?php
/**
 * Form class for the User
 * @author 
 */
namespace Admin\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Admin\AdminBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request; 

use lib\common\commonFunction;

class UserType extends AbstractType
{
	public $em;
	
	public function __construct($em = null)
	{
		$this->em = $em;
	}
    public function buildForm(FormBuilder $builder, array $options)
    {
    	//$emRole = $this->getDoctrine()->getEntityManager();
		$entityRole = $this->em->getRepository('AdminBundle:Role')->findAll();
		
		// array of roles
    	$arrRole = array();
		foreach($entityRole as $key => $val){
			$arrRole[$val->getId()] = $val->getTitle();
    	}
    	
    	//$user_role = $this->em->getRepository('AdminBundle:UserRole')->findByUserId($options['data']->getId());
    	//print_r(get_class_methods($options['data']->getUserRoles()));
    	//exit;
    	/*$current_role = 0;
    	if(is_object($options['data']->getRole()))
    	{
    		$user_roles = $options['data']->getRole()->getValues();
    		$current_role = '';
    		if(!empty($user_roles[0]))
    			$current_role = $user_roles[0]->getId();
    	}*/
    	$arr_country = array('US'=>'US');
    	$arr_state = commonFunction::getStateArray();
        $builder
            ->add('username')
            ->add('email')
            ->add('name')
            ->add('address1')
            ->add('address2')
            ->add('country', 'choice', array('label' => 'Country','choices' => $arr_country))
            ->add('state', 'choice', array('label' => 'State','choices' => $arr_state))
            ->add('city');
            //->add('uroles', 'choice', array("property_path" => false,'label' => 'Role :','choices' =>$arrRole,'data' => $current_role,'attr'=>array('class'=>'select_fd')))
            //->add('userRoles')
            //->add('cityId','choice', array('label' => 'City : ','empty_value' => 'Select City','attr'=>array('class'=>'select_fd')))
        ;
    }

    public function getName()
    {
        return 'admin_adminbundle_usertype';
    }
	public function getDefaultOptions(array $options)
    {
        return array(
            'validation_groups' => array(
                'new_user'
            ),
        );
    }
}
