<?php
namespace test;

class UsuarioViewTest extends \PHPUnit_Extensions_Selenium2TestCase
{
    private $usuarioNome;
    private $usuarioEmail;
    private $usuarioPage;
    
    /**
     * @before
     */
    protected function setUp()
    {
        $this->setBrowserUrl("localhost:8080");
        $this->usuarioPage = new UsuarioPage($this);
        
        $this->usuarioNome = "Cesar Domingos";
        $this->usuarioEmail = "cesar.domingos@fs.com.br";
    }
    
    public function testDeveCriarNovoUsuario()
    {
        $this->usuarioPage
            ->acessa()
            ->novo()
            ->populaForm($this->usuarioNome, $this->usuarioEmail)
            ->enviaForm();
        
        $achouNome = strpos($this->source(), $this->usuarioNome) !== false;
        $achouEmail = strpos($this->source(), $this->usuarioEmail) !== false;
        
        $this->assertTrue($achouNome);
        $this->assertTrue($achouEmail);
    }
    
    public function testDeveRetornarErroSemNome()
    {
        $this->usuarioPage
            ->acessa()
            ->novo()
            ->populaForm('', $this->usuarioEmail)
            ->enviaForm();
        
        $achouErro = strpos($this->source(), "Nome obrigatorio!") !== false;
        
        $this->assertTrue($achouErro);
    }
    
    public function testDeveRetornarErroSemEmail()
    {
        $this->usuarioPage
            ->acessa()
            ->novo()
            ->populaForm($this->usuarioNome, '')
            ->enviaForm();
        
        $achouErro = strpos($this->source(), "E-mail obrigatorio!") !== false;
        
        $this->assertTrue($achouErro);
    }
    
    public function testDeveRetornarErroSemNomeEEmail()
    {
        $this->usuarioPage
            ->acessa()
            ->novo()
            ->populaForm('', '')
            ->enviaForm();
        
        $achouErroNome = strpos($this->source(), "Nome obrigatorio!") !== false;
        $achouErroEmail = strpos($this->source(), "E-mail obrigatorio!") !== false;
        
        $this->assertTrue($achouErroNome);
        $this->assertTrue($achouErroEmail);
    }
    
    public function testDeveExibirInfo()
    {
        $this->usuarioPage
            ->acessa()
            ->novo()
            ->populaForm($this->usuarioNome, $this->usuarioEmail)
            ->enviaForm()
            ->exibir();
        
        $achouNome = strpos($this->source(), $this->usuarioNome) !== false;
        $achouEmail = strpos($this->source(), $this->usuarioEmail) !== false;
        
        $this->assertTrue($achouNome);
        $this->assertTrue($achouEmail);
    }
    
    public function testDeveEditar()
    {
        $this->usuarioPage
            ->acessa()
            ->novo()
            ->populaForm($this->usuarioNome, $this->usuarioEmail)
            ->enviaForm()
            ->editar()
            ->populaForm("Vitor", "vitor.cayres@fs.com.br")
            ->enviaForm();
        
        $achouNome = strpos($this->source(), "Vitor") !== false;
        $achouEmail = strpos($this->source(), "vitor.cayres@fs.com.br") !== false;
        
        $this->assertTrue($achouNome);
        $this->assertTrue($achouEmail);
    }
    
    public function testDeveExcluirQuandoConfirmado()
    {
        $this->usuarioPage
        ->acessa()
        ->novo()
        ->populaForm($this->usuarioNome, $this->usuarioEmail)
        ->enviaForm()
        ->excluir()
        ->confirmarExclusao();
        
        $achouNome = strpos($this->source(), $this->usuarioNome) !== false;
        $achouEmail = strpos($this->source(), $this->usuarioEmail) !== false;
        
        $this->assertFalse($achouNome);
        $this->assertFalse($achouEmail);
    }
    
    public function testDeveExcluirQuandoCancelado()
    {
        $this->usuarioPage
        ->acessa()
        ->novo()
        ->populaForm($this->usuarioNome, $this->usuarioEmail)
        ->enviaForm()
        ->excluir()
        ->recusaExclusao();
        
        $achouNome = strpos($this->source(), $this->usuarioNome) !== false;
        $achouEmail = strpos($this->source(), $this->usuarioEmail) !== false;
        
        $this->assertTrue($achouNome);
        $this->assertTrue($achouEmail);
    }
    
    public function tearDown()
    {
        $this->url("/apenas-teste/limpa");
    }
}