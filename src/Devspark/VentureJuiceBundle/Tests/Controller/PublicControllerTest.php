<?php

namespace Devspark\VentureJuiceBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PublicControllerTest extends WebTestCase
{
    public function testCompanylist()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/companyList');
    }

    public function testCompanysendmail()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/companySendMail');
    }

}
