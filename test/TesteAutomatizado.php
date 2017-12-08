<?php
namespace test;

class TesteAutomatizado extends \PHPUnit_Extensions_Selenium2TestCase
{
    /**
     * @before
     */
    protected function setUp()
    {
        $this->setBrowserUrl("http://google.com");
    }
    
    public function testTitle()
    {
        $this->url("/");    
        $campoDePesquisa = $this->byName("q");
        $campoDePesquisa->value("cesao89");
        //$campoDePesquisa->submit();
    }
}