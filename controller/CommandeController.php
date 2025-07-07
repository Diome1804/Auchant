<?php

namespace App\Controller;

use App\Config\Core\AbstractController;
use App\Service\CommandeService;

class CommandeController extends AbstractController
{

    //private CommandeService $commandeService;

    public function __construct()
    {
        //$this->commandeService = new CommandeService();
    }

    // public function form(){
    //     require_once '../template/commande/form.html.php';
    // }

    // public function list(){
    //     require_once '../template/commande/list.html.php';
    // }

    public function index()
    {
        //$commandes = $this->commandeService->listerCommandes();
        $this->renderHtml('commande/list.html.php');
    }
    public function store() {}
    public function create()
    {
        $this->renderHtml('commande/form.html.php');
    }

    public function destroy() {}
    public function show() {}
    public function edit() {}
    public function update() {}

    //index 
    //create 
    //store
}
