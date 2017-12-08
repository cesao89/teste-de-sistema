<?php
namespace test;

class UsuarioPage
{
    private $page;
    
    public function __construct(\PHPUnit_Extensions_Selenium2TestCase $page)
    {
        $this->page = $page;
    }
    
    public function acessa()
    {
        $this->page->url("/usuarios");
        return $this;
    }
    
    public function novo()
    {
        $this->page->byLinkText("Novo Usuário")->click();
        return $this;
    }
    
    public function exibir()
    {
        $this->page->byLinkText("exibir")->click();
        return $this;
    }
    
    public function editar()
    {
        $this->page->byLinkText("editar")->click();
        return $this;
    }
    
    public function excluir()
    {
        $this->page->byTag("button")->click();
        return $this;
    }
    
    public function confirmarExclusao()
    {
        $this->page->acceptAlert();
        return $this;
    }
    
    public function recusaExclusao()
    {
        $this->page->dismissAlert();
        return $this;
    }
    
    public function populaForm(string $nome, string $email)
    {
        $campoNome = $this->page->byName("usuario.nome");
        $campoEmail = $this->page->byName("usuario.email");
        
        $campoNome->value($nome);
        $campoEmail->value($email);
        return $this;
    }
    
    public function enviaForm()
    {
        $botaoSalvar = $this->page->byId("btnSalvar");
        $botaoSalvar->click();
        return $this;
    }
}