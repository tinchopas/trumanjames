<?php
// src/Acme/DemoBundle/Validator/Constraints/ContainsAlphanumericValidator.php
namespace Devspark\VentureJuiceBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueEntityRelationValidator extends ConstraintValidator
{
    private $em;

    public function __construct($entityManager) {
        $this->em = $entityManager;
    }

    public function validate($entity, Constraint $constraint)
    {
        $result = array();

        if ($entity == null) {
            $result = $this->em->getRepository('DevsparkVentureJuiceBundle:EmailMessage')->findBy(array("company" => null));
        }

        if (0 === count($result)) {
            return;
        }

        $this->context->addViolation($constraint->message);
    }
}
