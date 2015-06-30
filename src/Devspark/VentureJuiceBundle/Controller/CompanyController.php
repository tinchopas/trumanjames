<?php

namespace Devspark\VentureJuiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Devspark\VentureJuiceBundle\Entity\Company;
use Devspark\VentureJuiceBundle\Form\CompanyType;

/**
 * Company controller.
 *
 */
class CompanyController extends Controller
{
    /**
     * Lists enabled Company entities.
     *
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DevsparkVentureJuiceBundle:Company')->findBy(array('active'=>1), array('displayOrder'=>'ASC'));

        return $this->render('DevsparkVentureJuiceBundle:Company:list.html.twig', array(
            'entities' => $entities,
        ));
    }


    /**
     * Lists all Company entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DevsparkVentureJuiceBundle:Company')->findBy(array(), array('displayOrder'=>'ASC'));

        return $this->render('DevsparkVentureJuiceBundle:Company:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Company entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Company();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('company_show', array('id' => $entity->getId())));
        }

        return $this->render('DevsparkVentureJuiceBundle:Company:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Company entity.
    *
    * @param Company $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Company $entity)
    {
        $form = $this->createForm(new CompanyType(), $entity, array(
            'action' => $this->generateUrl('company_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Company entity.
     *
     */
    public function newAction()
    {
        $entity = new Company();
        $form   = $this->createCreateForm($entity);

        return $this->render('DevsparkVentureJuiceBundle:Company:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Company entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DevsparkVentureJuiceBundle:Company')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Company entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DevsparkVentureJuiceBundle:Company:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Company entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DevsparkVentureJuiceBundle:Company')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Company entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DevsparkVentureJuiceBundle:Company:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Company entity.
    *
    * @param Company $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Company $entity)
    {
        $form = $this->createForm(new CompanyType(), $entity, array(
            'action' => $this->generateUrl('company_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Company entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DevsparkVentureJuiceBundle:Company')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Company entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            if ($editForm->get('file')->getData() != NULL) {//user have uploaded a new file
                $file = $editForm->get('file')->getData();//get 'UploadedFile' object
                $entity->setLogo($file->getClientOriginalName());//change field that holds file's path in db to a temporary value,i.e original file name uploaded by user
            }
            $em->flush();

            return $this->redirect($this->generateUrl('company_edit', array('id' => $id)));
        }

        return $this->render('DevsparkVentureJuiceBundle:Company:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Company entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DevsparkVentureJuiceBundle:Company')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Company entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('company'));
    }

    /**
     * Creates a form to delete a Company entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('company_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    private function sendCompanyMail($company, $client) {
        //->setTo($company->getEmail())

        //echo '{"result":"OKK"}'; exit;
        
        $mail = $this->renderView(
            'DevsparkVentureJuiceBundle:Company:company_email.html.twig',
            array('company' => $company,
            'client' => $client
            )
        );

        $message = \Swift_Message::newInstance()
            ->setSubject('Venture Juice Intro')
            ->setFrom('love@venturejuice.com')
            ->setTo('dnail@devspark.com')
            ->setBody( $mail, 'text/html', 'UTF-8');
        $result = $this->get('mailer')->send($message, $failures);

        echo '{"result":"OK"}'; exit;

    }


/*
authenticity_token  0RyfyvQtzsE3tRqqZUEaMqpKSaGsWbodil5Uzi92I+g=
collected_email[company]    Devspark
collected_email[email]  dnail@devspark.com
collected_email[name]   Damian Nail (testing venturejuice.com)
collected_email[recipient...    mspascal@gmail.com
collected_email[skip_emai...    false
collected_email[skip_name...    false
collected_email[website]    devspark.com
companies_email[]   1
utf8    ✓
*/
    public function sendMailAction(Request $request)
    {

        echo '{"result":"OKK"}'; exit;
        
        $em = $this->getDoctrine()->getManager();
        $collected = $request->get('collected_email');
        $companyIds = $request->get('companies_email');


        $repository = $this->getDoctrine()
            ->getRepository('DevsparkVentureJuiceBundle:Company');

        $query = $repository->createQueryBuilder('c')
            ->where('c.id IN (:companyIds)')
            ->setParameter('companyIds', $companyIds)
            ->getQuery();
        $companies = $query->getResult();

        foreach ($companies as $company) {
            // echo $company->getEmail()."\n";
            $this->sendCompanyMail($company, $collected);
            // $company->setIntroSent($company->getIntroSent() + 1);
            // $em->persist($company);
        }
        $em->flush();
        exit;
    }

}
