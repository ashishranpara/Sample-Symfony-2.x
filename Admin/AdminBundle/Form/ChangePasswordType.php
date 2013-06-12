<?php
/**
 * Form class for the Change password
 * @author 
 */
namespace Admin\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
		$builder
			->add('password', 'repeated', array (
	            'type'            => 'password',
	            'first_name'      => "Password",
	            'second_name'     => "Confirm_Password",
	            'invalid_message' => "Password and Confirm Password must be same."
        	));
           
    }
    public function getName()
    {
        return 'change_password';
    }
}
