<?php
namespace test;

class LeilaoPage
{
    private $page;
    
    public function __construct(\PHPUnit_Extensions_Selenium2TestCase $page)
    {
        $this->page = $page;
    }
    
    public function acessa()
    {
        $this->page->url("/leiloes");
        return $this;
    }
    
    public function novo()
    {
        $this->page->byLinkText("Novo Leilão")->click();
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
    
    public function populaForm(string $nome, string $valorInicial, string $usuario = null, bool $usado = false)
    {
        $campoNome = $this->page->byName("leilao.nome");
        $campoValorInicial = $this->page->byName("leilao.valorInicial");
        
        $campoNome->value($nome);
        $campoValorInicial->value($valorInicial);
        
        if($usuario){
            $select = $this->page->select(
                $this->page->byName("leilao.usuario.id")
            );
            $select->selectOptionByLabel($usuario);
        }
        
        if($usado){
            $ckUsado = $this->page->byName("leilao.usado")->click();
        }
        
        return $this;
    }
    
    public function enviaForm()
    {
        $this->page->byTag("button")->click();
        return $this;
    }
    
    public function novoLance(string $valor, string $usuario = null)
    {
        $campoValor = $this->page->byName("lance.valor");
        $campoValor->value($valor);
        
        if($usuario){            
            $selectUsuario = $this->page->select(
                $this->page->byName("lance.usuario.id")
            );
            $selectUsuario->selectOptionByLabel($usuario);
        }
        
        return $this;
    }
    
    public function enviaLance()
    {
        $this->page->byId("btnDarLance")->click();
        return $this;
    }
    
    public function aguardaAjax()
    {
        $this->page->waitUntil(function($page){
            return $page->byId("lancesDados");
        }, 10000);
        return $this;
    }
}