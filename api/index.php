<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);
// timezone para São Paulo América
date_default_timezone_set('America/Sao_Paulo');

ob_start();

require  __DIR__ . "/vendor/autoload.php";

// os headers abaixo são necessários para permitir o acesso a API por clientes externos ao domínio
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header('Access-Control-Allow-Credentials: true'); // Permitir credenciais

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

use CoffeeCode\Router\Router;

$route = new Router(url("api"),":");

$route->namespace("Source\Controller");

//user 

$route->group("/users");

$route->post("/register","Users:register"); // Registrar usuário comum
$route->post("/login","Users:auth"); // login de usuário comum
$route->put("/update","Users:update"); // update de usuário comum
$route->post("/register-admin","Users:registerAdmin"); // Registrar usuário admin NÃO IMPLEMENTADO
$route->post("/login-admin","Users:authAdmin"); // login de usuário admin
$route->put("/update-admin","Users:updateAdmin"); // update de usuário admin

$route->group(null);

// portifolios
$route->group("/portfolios");

$route->get("/list", "Portfolios:listAll");
$route->post("/insert", "Portfolios:insertPortfolio");
$route->put("/update", "Portfolios:updatePortfolio");
$route->get("/select/{id}", "Portfolios:selectPortfolio");
$route->delete("/delete/{id}", "Portfolios:deletetPortfolio");

$route->group(null);

// fotos

$route->group("/photos");

$route->get("/list", "Photos:listAll");
$route->post("/insert", "Photos:insertPhoto");
$route->put("/update", "Photos:updatePhoto");
$route->get("/select/{id}", "Photos:selectPhoto");
$route->delete("/delete/{id}", "Photos:deletePhoto");

$route->group(null);


// avaliações - reviews

$route->group("/reviews");

$route->get("/list", "Reviews:listAll"); //funcionando
$route->get("/list/{review_id}", "Reviews:listById"); //funcionando
$route->post("/", "Reviews:insert");
$route->delete("/{review_id}", "Reviews:deleteById");
$route->put("/{review_id}", "Reviews:updateById");

$route->group(null);

// mensagens - message

$route->group("/messages");

$route->get("/list", "Messages:listAll");
$route->get("/list/{message_id}", "Messages:listById");
$route->post("/", "Messages:insert");
$route->delete("/{message_id}", "Messages:deleteById");
$route->put("/{message_id}", "Messages:updateById");

$route->group(null);

// contato - contact 

$route->group("/contacts");
$route->get("/list", "Contacts:listAll");
$route->get("/list/{contact_id}", "Contacts:listById");
$route->post("/", "Contacts:insert");
$route->delete("/{contact_id}", "Contacts:deleteById");
$route->put("/{contact_id}", "Contacts:updateById");

$route->group(null);

// perguntas frequentes - faqs

$route->group("/faqs");

$route->get("/list", "Faqs:listAll");
$route->post("/insert", "Faqs:insertFaq");
$route->put("/update", "Faqs:updateFaq");
$route->get("/select/{id}", "Faqs:selectFaq");
$route->delete("/delete/{id}", "Faqs:deleteFaq");

$route->group(null);

// categoria das perguntas frequentes - faqs-category

$route->group("/faqscategories");

$route->get("/list", "FaqsCategories:listAll");
$route->post("/insert", "FaqsCategories:insertFaqsCategories");
$route->put("/update", "FaqsCategories:updateFaqsCategories");
$route->get("/select/{id}", "FaqsCategories:selectFaqsCategories");
$route->delete("/delete/{id}", "FaqsCategories:deleteFaqsCategories");

$route->group(null);

// especialidade - speciality

$route->group("/specialties");

$route->get("/list", "Specialties:listAll");
$route->post("/insert", "Specialties:insertSpecialty");
$route->put("/update", "Specialties:updateSpecialty");
$route->get("/select/{id}", "Specialties:selectSpecialty");
$route->delete("/delete/{id}", "Specialties:deleteSpecialty");

$route->group(null);

// Início - Exercícios - Desafios
// Produtos
$route->group("/products");
$route->get("/list/{product_id}","Products:listById"); // select by id
$route->get("/list","Products:listAll"); // select all
$route->get("/list/paginator/{page}/{per_page}","Products:listPaginator"); // select all
$route->post("/","Products:insert"); // insert
$route->put("/{product_id}","Products:update"); // update
$route->delete("/{product_id}","Products:delete"); // update
$route->group(null);

// FAQs
// $route->group("/faqs");
// $route->get("/list", "faqs\Faqs:listAll");
// $route->get("/list/{faq_id}", "faqs\Faqs:listById");
// $route->post("/", "faqs\Faqs:insert");
// $route->put("/{faq_id}", "faqs\Faqs:update");
// $route->group(null);

// FAQs Categories
// $route->group("/faqs-categories");
// $route->get("/list", "faqs\FaqsCategories:listAll");
// $route->get("/list/{category_id}", "faqs\FaqsCategories:listById");
// $route->post("/", "faqs\FaqsCategories:insert");
// $route->group(null);


$route->dispatch();

/** ERROR REDIRECT */
if ($route->error()) {
    header('Content-Type: application/json; charset=UTF-8');
    //http_response_code(404);

    echo json_encode([
        "code" => 404,
        "status" => "not_found",
        "message" => "URL não encontrada..."
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

}

ob_end_flush();