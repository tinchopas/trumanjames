<?php

namespace Devspark\VentureJuiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Devspark\VentureJuiceBundle\Entity\Company;
use Devspark\VentureJuiceBundle\Form\CompanyType;

use Symfony\Component\HttpFoundation\Response;


class PublicController extends Controller
{
    public function companyListAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DevsparkVentureJuiceBundle:Company')->findBy(array('active'=>1), array('displayOrder'=>'ASC'));

        return $this->render('DevsparkVentureJuiceBundle:Public:list.html.twig', array(
            'entities' => $entities,
        ));

    }

    public function companySendMailAction(Request $request)
    {

        try {

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

                $this->sendCompanyMail($company, $collected);
                $company->setIntroSent($company->getIntroSent() + 1);

                $em->persist($company);
            }
            $em->flush();
            return new Response(json_encode(array('result'=>'OK')));

        }

        catch(RuntimeException $e) {
            return new Response(
                json_encode(
                    array(
                        'result' => 'FAIL',
                        'message' => $e->getMessage()
                    )
                )
            );
        }

        catch(\PDOException $e) {
            return new Response(
                json_encode(
                    array(
                        'result' => 'FAIL',
                        'message' => $e->getMessage()
                    )
                )
            );
        }
        catch(\Swift_TransportException $e) {
            return new Response(
                json_encode(
                    array(
                        'result' => 'FAIL',
                        'message' => $e->getMessage()
                    )
                )
            );
        }
    }

    private function sendCompanyMail($company, $client) {

        $defaultMessage = $this->getDoctrine()->getRepository('DevsparkVentureJuiceBundle:EmailMessage')->findDefaultMessage();
        $companyMessage = $this->getDoctrine()->getRepository('DevsparkVentureJuiceBundle:EmailMessage')->findCompanyMessage($company);

        if (! $companyMessage) {
            $companyMessage = $defaultMessage;
        }

        $mail = $this->get('mine.twig_string')->render($companyMessage->getBody(), array('company' => $company, 'client' => $client));

        $message = \Swift_Message::newInstance()
            ->setSubject($companyMessage->getSubject())
            ->setFrom('coworking@trumanjames.com')
            ->setTo(array($company->getEmail(), $client['email']))
            ->setBody(
                $mail,
                'text/html',
                'UTF-8'
            );

        // Company Message
        $result = $this->get('mailer')->send($message, $failures);

    }
}
