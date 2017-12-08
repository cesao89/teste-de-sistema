<?php
namespace test;

class HomeViewTest extends \PHPUnit_Extensions_Selenium2TestCase
{
    /**
     * @before
     */
    protected function setUp()
    {
        $this->setBrowserUrl("localhost:8080");
    }
    
    public function testDeveExibirMsgDeBemVindo()
    {
        $this->url('/');
        $msgBemVindo = "Bem vindo ao projeto de leilão do curso online da Caelum!";
        
        $achouMensagem = strpos($this->source(), $msgBemVindo) !== false;
        $this->assertTrue($achouMensagem);
    }
}