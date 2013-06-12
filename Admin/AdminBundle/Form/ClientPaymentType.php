<?php
/**
 * Form class for the Client Payment
 * @author 
 */
namespace Admin\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ClientPaymentType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
    	$payment_mode = array('Cheque'=>'Cheque','Cash'=>'Cash');
        $builder
            ->add('paymentMode', 'choice', array('label' => 'Payment Mode','choices' => $payment_mode))
            ->add('amountReceived')
            ->add('dueAmount')  
            ->add('totalAmount');
    }

    public function getName()
    {
        return 'admin_adminbundle_client_payment_type';
    }
	public function getDefaultOptions(array $options)
    {
    	/*return array(
        	'data_class' => 'Admin\AdminBundle\Entity\ClientPayment',
        );*/
        return array(
        	'data_class' => 'Admin\AdminBundle\Entity\ClientPayment',
            'validation_groups' => array(
                'change_password','new_user'
            ),
        );
    }
}
