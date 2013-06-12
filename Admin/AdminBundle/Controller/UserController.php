<?php

/**
 * Controller is used for the common operation of the User
 * @author 
 */

namespace Admin\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// Entity and Form
use Admin\AdminBundle\Entity\User;
use Admin\AdminBundle\Entity\ClientPayment;
use Admin\AdminBundle\Form\UserType;
use Admin\AdminBundle\Form\ClientPaymentType;
// Pager
use MakerLabs\PagerBundle\Pager;
use MakerLabs\PagerBundle\Adapter\DoctrineOrmAdapter;
// Request and response
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 */
class UserController extends Controller {

    /**
     * Lists all User entities.
     * @author 
     */
    public function indexAction() {
        $req = $this->get('request');
        $page = $req->get('page', 1);

        $repository = $this->getDoctrine()
                ->getRepository('AdminBundle:User');

        $current_role = $this->getCurrentRole();
        if ($current_role == 'ROLE_ADMIN')
            $condition = "r.name = 'ROLE_STAFF'";
        elseif ($current_role == 'ROLE_STAFF')
            $condition = "r.name = 'ROLE_CLIENT'";
        else
            $condition = "1 = 1";

        $qb = $repository->createQueryBuilder('u')
                ->join('u.role', 'r')
                ->where($condition)
                ->AndWhere("u.status != 'Delete'")
                ->orderBy('u.id', 'ASC');

        $adapter = new DoctrineOrmAdapter($qb);
        $pager = new Pager($adapter, array('page' => $page, 'limit' => 2));

        return $this->render('AdminBundle:User:index.html.twig', array(
                    'pager' => $pager
                ));
    }

    /**
     * Finds and displays a User entity.
     * @author 
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AdminBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AdminBundle:User:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),
                ));
    }

    /**
     * Displays a form to create a new User entity.
     * @author 
     */
    public function newAction() {
        $entity = new User();
        $entityClientPayment = new ClientPayment();
        $em = $this->getDoctrine()->getEntityManager();

        $current_role = $this->getCurrentRole();

        $form = $this->get('form.factory')->createNamedBuilder(new UserType($this->getDoctrine()->getEntityManager()), 'admin_adminbundle_usertype', $entity)
                //->add('password')
                ->add('password', 'repeated', array(
            'type' => 'password',
            'first_name' => 'Password',
            'second_name' => 'Confirm_Password',
            'invalid_message' => 'Password and Confirm Password must be same.',
            'required' => false));
        if ($current_role == 'ROLE_STAFF') {
            $form = $form->add('clientPayment', new ClientPaymentType());
        }
        $form = $form->getForm();
        return $this->render('AdminBundle:User:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView()
                ));
    }

    /**
     * Creates a new User entity.
     * @author 
     */
    public function createAction() {
        $current_role = $this->getCurrentRole();
        $entity = new User();

        $entityClientPayment = new ClientPayment();
        $entity->setClientPayment($entityClientPayment);
        $request = $this->getRequest();

        $params = $request->get('admin_adminbundle_usertype');
        $params_client_payment = '';
        if (isset($params['clientPayment']))
            $params_client_payment = $params['clientPayment'];
        //$form    = $this->createForm(new UserType($this->getDoctrine()->getEntityManager()), $entity);
        //
    	$em = $this->getDoctrine()->getEntityManager();

        $form = $this->get('form.factory')->createNamedBuilder(new UserType($this->getDoctrine()->getEntityManager()), 'admin_adminbundle_usertype', $entity)
                //->add('password')
                ->add('password', 'repeated', array(
            'type' => 'password',
            'first_name' => 'Password',
            'second_name' => 'Confirm_Password',
            'invalid_message' => 'Password and Confirm Password must be same.',
            'required' => false));
        if ($current_role == 'ROLE_STAFF') {
            $form = $form->add('clientPayment', new ClientPaymentType($entityClientPayment));
        }
        $form = $form->getForm();

        $form->bindRequest($request);

        if ($form->isValid()) {

            $entity->setPassword(md5($params['password']['Password']));
            $entity->setAvailibilityStatus('N');
            $entity->setSubscribe('N');
            $entity->setStatus("Pending");
            $entity->setCreatedDate(new \DateTime('now'));
            $entity->setUpdatedDate(new \DateTime('now'));

            //$roles = $em->getRepository('AdminBundle:Role')->find($params['uroles']);
            // Fetch Staff role
            $current_role = $this->getCurrentRole();
            if ($current_role == 'ROLE_ADMIN')
                $role_id = 3;
            else
                $role_id = 4;

            $roles = $em->getRepository('AdminBundle:Role')->find($role_id);

            $entity->addRole($roles);
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();
            if ($params_client_payment != '') {
                // Save to client payment
                $user_entity = $em->getRepository('AdminBundle:User')->find($entity->getId());
                $entityClientPayment->setUser($user_entity);
                $entityClientPayment->setPaymentMode($params_client_payment['paymentMode']);
                $entityClientPayment->setAmountReceived($params_client_payment['amountReceived']);
                $em->persist($entityClientPayment);
                $em->flush();
            }
        
            $this->get('session')->setFlash('success', "Added successfully");
            // Email to user
            $message = \Swift_Message::newInstance()
                    ->setSubject('Registered to the Site')
                    ->setFrom(array('noreply@demo.com' => 'Demo Apps'))
                    ->setTo($entity->getEmail())
                    ->setBody($this->renderView('AdminBundle:Email:newuser.html.twig', array('entity' => $entity, 'password' => $params['password']['Password'])), 'text/html');
            $this->get('mailer')->send($message);

            return $this->redirect($this->generateUrl('user'));
        }
        
        return $this->render('AdminBundle:User:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView()
                ));
    }

    /**
     * Displays a form to edit an existing User entity.
     * @author 
     */
    public function editAction($id) {
        $current_role = $this->getCurrentRole();
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AdminBundle:User')->find($id);

        //$entity_client_payment = new \Admin\AdminBundle\Entity\ClientPayment();
        $entity_client_payment = $em->getRepository('AdminBundle:ClientPayment')->findOneByUser($entity->getId());
        if (!$entity_client_payment)
            $entity_client_payment = new ClientPayment();
        $entity->setClientPayment($entity_client_payment);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        $editForm = $this->get('form.factory')->createNamedBuilder(new UserType($this->getDoctrine()->getEntityManager()), 'admin_adminbundle_usertype', $entity, array('validation_groups' => array('new_user', 'change_password')));
        $is_payment_form = false;
        if ($current_role == 'ROLE_STAFF') {
            $users = $this->get('security.context')->getToken()->getUser();
            if ($entity->getId() != $users->getId()) {
                $is_payment_form = true;
                $editForm = $editForm->add('clientPayment', new ClientPaymentType());
            }
        }
        $editForm = $editForm->getForm();
        
        $deleteForm = $this->createDeleteForm($id);
        return $this->render('AdminBundle:User:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                    'is_payment_form' => $is_payment_form
                ));
    }

    /**
     * Edits an existing User entity.
     * @author 
     */
    public function updateAction($id) {
        $current_role = $this->getCurrentRole();
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('AdminBundle:User')->find($id);
        $entity_client_payment = $em->getRepository('AdminBundle:ClientPayment')->findOneByUser($entity->getId());
        if (!$entity_client_payment)
            $entity_client_payment = new ClientPayment();
        $entity->setClientPayment($entity_client_payment);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        //$editForm   = $this->createForm(new UserType($this->getDoctrine()->getEntityManager()), $entity);
        $editForm = $this->get('form.factory')->createNamedBuilder(new UserType($this->getDoctrine()->getEntityManager()), 'admin_adminbundle_usertype', $entity, array('validation_groups' => array('new_user', 'change_password')));
        $is_payment_form = false;
        if ($current_role == 'ROLE_STAFF') {
            $users = $this->get('security.context')->getToken()->getUser();
            if ($entity->getId() != $users->getId()) {
                $is_payment_form = true;
                $editForm = $editForm->add('clientPayment', new ClientPaymentType());
            }
        }
        $editForm = $editForm->getForm();

        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();
        $params = $request->get('admin_adminbundle_usertype');
        $params_client_payment = '';
        if (isset($params['clientPayment']))
            $params_client_payment = $params['clientPayment'];

        $editForm->bindRequest($request);


        if ($editForm->isValid()) {

            $em->persist($entity);
            $em->flush();

            // Save to client payment
            if ($params_client_payment != '') {
                $user_entity = $em->getRepository('AdminBundle:User')->find($entity->getId());
                $entity_client_payment->setUser($user_entity);
                $entity_client_payment->setPaymentMode($params_client_payment['paymentMode']);
                $entity_client_payment->setAmountReceived($params_client_payment['amountReceived']);
                $em->persist($entity_client_payment);
                $em->flush();
            }


            $this->get('session')->setFlash('success', "Updated successfully");

            return $this->redirect($this->generateUrl('user'));
        }

        return $this->render('AdminBundle:User:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
                    'is_payment_form' => $is_payment_form
                ));
    }

    /**
     * Deletes a User entity.
     * @author 
     */
    public function deleteAction($id) {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('AdminBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('user'));
    }

    /**
     * Create the delete form 
     * @param int $id
     * @author 
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder(array('id' => $id))
                        ->add('id', 'hidden')
                        ->getForm()
        ;
    }

    /**
     * Action used to delete the user using get method
     * @param int $id
     * @author 
     */
    public function deleteLinkAction($id) {
        $em = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('AdminBundle:User')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }
        $entity->setStatus('Delete');
        //$em->remove($entity);
        $em->persist($entity);
        $em->flush();
        $this->get('session')->setFlash('success', "Delete successfully");
        return $this->redirect($this->generateUrl('user'));
    }

    /**
     * Action used to change the User status
     * @author 
     */
    public function changeStatusAction() {
        $referer = $this->get('request')->server->get('HTTP_REFERER');
        $request = $this->getRequest();
        $params = $request->get('check_boxes');
        $status_code = $request->get('status_code');
        $em = $this->getDoctrine()->getEntityManager();
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $entity = $em->getRepository('AdminBundle:User')->find($value);
                if ($entity) {
                    if ($status_code == 1)
                        $entity->setStatus('Active');
                    else
                        $entity->setStatus('Inactive');
                    $em->persist($entity);
                    $em->flush();
                }
            }
            $this->get('session')->setFlash('success', "Status changed successfully");
        }else {
            $this->get('session')->setFlash('error', "Please select atleast one to perform operation.");
        }
        if ($referer)
            return $this->redirect($referer);
        else
            return $this->redirect($this->generateUrl('user'));
    }

    /**
     * Method used for the get current role of logged in user
     * @author 
     */
    private function getCurrentRole() {
        $session = $this->getRequest()->getSession();
        return $session->get('role_name');
    }

}
