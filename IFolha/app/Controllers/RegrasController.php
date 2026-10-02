<?php
namespace App\Controllers;

use App\Core\Controller;

class RegrasController extends Controller
{
    public function index(): void
    {
        $this->render('regras/index', [
            'activePage'   => 'regras',
            'tituloPagina' => 'Regras do IFMT — Guia do Estudante'
        ]);
    }
}
