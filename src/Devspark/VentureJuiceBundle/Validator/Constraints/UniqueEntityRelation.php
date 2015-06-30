<?php
// src/Acme/DemoBundle/Validator/Constraints/ContainsAlphanumeric.php
namespace Devspark\VentureJuiceBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UniqueEntityRelation extends Constraint
{
    public $message = 'This value is already used.';

    public function validatedBy()
    {
        return 'unique_entity_relation';
    }
}
