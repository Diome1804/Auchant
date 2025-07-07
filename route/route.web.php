<?php

use App\Config\Core\Router;
use App\Controller\CommandeController;
use App\Controller\SecurityController;

// Routes de sécurité
Router::get('/login', SecurityController::class, 'index');
//Router::get('/login', SecurityController::class, 'login');
Router::post('/login', SecurityController::class, 'login');


Router::get('/logout', SecurityController::class, 'logout');

// Routes des commandes (protégées)
Router::get('/list', CommandeController::class, 'index');
Router::get('/facture', CommandeController::class, 'show');
Router::get('/form', CommandeController::class, 'create');
Router::get('/commande', CommandeController::class, 'create');

// Résoudre la route
Router::resolve();
