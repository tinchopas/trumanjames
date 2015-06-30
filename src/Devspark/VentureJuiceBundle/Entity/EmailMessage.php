<?php

namespace Devspark\VentureJuiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Devspark\VentureJuiceBundle\Entity\Company;

/**
 * EmailMessage
 */
class EmailMessage
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var string
     */
    private $body;

    /**
     * @var Company
     */
    private $company;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set subject
     *
     * @param string $subject
     * @return EmailMessage
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    
        return $this;
    }

    /**
     * Get subject
     *
     * @return string 
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return EmailMessage
     */
    public function setBody($body)
    {
        $this->body = $body;
    
        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set Company
     *
     * @param Company $company
     * @return EmailMessage
     */
    public function setCompany($company)
    {
        $this->company = $company;
    
        return $this;
    }

    /**
     * Get Company
     *
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }
}
