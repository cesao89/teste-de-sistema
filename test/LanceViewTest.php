<?php
namespace test;

class LanceViewTest extends \PHPUnit_Extensions_Selenium2TestCase
{
    private $leilaoPage;
    private $leilaoNome;
    private $leilaoValorInicial;
    
    private $usuarioPage;
    private $usuarioNome;
    private $usuarioEmail;
    
    private $lanceValor;
    
    /**
     * @before
     */
    protected function setUp()
    {
        $this->setBrowserUrl("localhost:8080");
        $this->leilaoPage = new LeilaoPage($this);
        $this->usuarioPage = new UsuarioPage($this);
        
        $this->leilaoNome = "Camaro do Albertao";
        $this->leilaoValorInicial = "1000.0";
        
        $this->usuarioNome = "Cesar Domingos";
        $this->usuarioEmail = "cesar.domingos@fs.com.br";
        
        $this->lanceValor = "5340.0";
    }

    public function testDeveDaLanceSemUsuario()
    {
        $this->leilaoPage
            ->acessa()
            ->novo()
            ->populaForm($this->leilaoNome, $this->leilaoValorInicial)
            ->enviaForm()
            ->exibir();
        
        $leilaoVazio = $this->source();
        
        $this->leilaoPage
            ->novoLance($this->lanceValor)
            ->enviaLance();
        
        $leilaoComLanceSemUsuario = $this->source();
        
        $this->assertEquals($leilaoVazio, $leilaoComLanceSemUsuario);
    }

    public function testDeveDaLanceComUsuario()
    {
        $this->usuarioPage
            ->acessa()
            ->novo()
            ->populaForm($this->usuarioNome, $this->usuarioEmail)
            ->enviaForm();
        
        $this->leilaoPage
            ->acessa()
            ->novo()
            ->populaForm($this->leilaoNome, $this->leilaoValorInicial)
            ->enviaForm()
            ->exibir()
            ->novoLance($this->lanceValor)
            ->enviaLance()
            ->aguardaAjax();
        
            
        $achouUsuario = strpos($this->source(), $this->usuarioNome) !== false;
        $achouLance = strpos($this->source(), $this->lanceValor) !== false;
        
        $this->assertTrue($achouUsuario);
        $this->assertTrue($achouLance);
    }
    
    public function tearDown()
    {
        $this->url("/apenas-teste/limpa");
    }
}