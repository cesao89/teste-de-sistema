<?php
namespace test;

class LeilaoViewTest extends \PHPUnit_Extensions_Selenium2TestCase
{
    private $leilaoNome;
    private $leilaoValorInicial;
    private $leilaoPage;
    private $usuarioPage;
    
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
    }
    
    public function testDeveCriarNovoLeilaoSemUsuario()
    {
        $this->leilaoPage
            ->acessa()
            ->novo()
            ->populaForm($this->leilaoNome, $this->leilaoValorInicial)
            ->enviaForm();
        
        $achouNome = strpos($this->source(), $this->leilaoNome) !== false;
        $achouValorInicial = strpos($this->source(), $this->leilaoValorInicial) !== false;
        
        $this->assertTrue($achouNome);
        $this->assertTrue($achouValorInicial);
    }

    public function testDeveCriarNovoLeilaoComUsuario()
    {
        $this->usuarioPage
        ->acessa()
        ->novo()
        ->populaForm($this->usuarioNome, $this->usuarioEmail)
        ->enviaForm();        
        
        $this->leilaoPage
        ->acessa()
        ->novo()
        ->populaForm($this->leilaoNome, $this->leilaoValorInicial, $this->usuarioNome)
        ->enviaForm();
        
        $achouNome = strpos($this->source(), $this->leilaoNome) !== false;
        $achouValorInicial = strpos($this->source(), $this->leilaoValorInicial) !== false;
        $achouUsuario = strpos($this->source(), $this->usuarioNome) !== false;
        
        $this->assertTrue($achouNome);
        $this->assertTrue($achouValorInicial);
        $this->assertTrue($achouUsuario);
    }
    
    public function testDeveCriarNovoLeilaoComProdutoUsado()
    {
        $this->usuarioPage
        ->acessa()
        ->novo()
        ->populaForm($this->usuarioNome, $this->usuarioEmail)
        ->enviaForm();
        
        $this->leilaoPage
        ->acessa()
        ->novo()
        ->populaForm($this->leilaoNome, $this->leilaoValorInicial, $this->usuarioNome, true)
        ->enviaForm();
        
        $achouNome = strpos($this->source(), $this->leilaoNome) !== false;
        $achouValorInicial = strpos($this->source(), $this->leilaoValorInicial) !== false;
        $achouUsuario = strpos($this->source(), $this->usuarioNome) !== false;
        $achouUsado = strpos($this->source(), "Sim") !== false;
        
        $this->assertTrue($achouNome);
        $this->assertTrue($achouValorInicial);
        $this->assertTrue($achouUsuario);
        $this->assertTrue($achouUsado);
    }
      
    public function testDeveRetornarErroSemNome()
    {
        $this->leilaoPage
            ->acessa()
            ->novo()
            ->populaForm('', $this->leilaoValorInicial)
            ->enviaForm();
        
        $achouErro = strpos($this->source(), "Nome obrigatorio!") !== false;
        
        $this->assertTrue($achouErro);
    }
    
    public function testDeveRetornarErroSemValor()
    {
        $this->leilaoPage
            ->acessa()
            ->novo()
            ->populaForm($this->leilaoNome, '')
            ->enviaForm();
        
        $achouErro = strpos($this->source(), "Valor inicial deve ser maior que zero!") !== false;
        
        $this->assertTrue($achouErro);
    }
    
    public function testDeveRetornarErroComValorMenorOuIgual0()
    {
        $this->leilaoPage
            ->acessa()
            ->novo()
            ->populaForm($this->leilaoNome, '0')
            ->enviaForm();
        
        $achouErroValor0 = strpos($this->source(), "Valor inicial deve ser maior que zero!") !== false;
        
        $this->leilaoPage
            ->populaForm($this->leilaoNome, '-1000')
            ->enviaForm();
        
        $achouErroValorNegativo = strpos($this->source(), "Valor inicial deve ser maior que zero!") !== false;
        
        $this->assertTrue($achouErroValor0);
        $this->assertTrue($achouErroValorNegativo);
    } 
    
    public function testDeveExibirLeilao()
    {
        $this->usuarioPage
            ->acessa()
            ->novo()
            ->populaForm($this->leilaoNome, $this->leilaoValorInicial)
            ->enviaForm()
            ->exibir();
        
        $achouNome = strpos($this->source(), $this->leilaoNome) !== false;
        $achouValorInicial = strpos($this->source(), $this->leilaoValorInicial) !== false;
        
        $this->assertTrue($achouNome);
        $this->assertTrue($achouValorInicial);
    }
    
    public function tearDown()
    {
        $this->url("/apenas-teste/limpa");
    }
}