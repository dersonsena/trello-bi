<?php

declare(strict_types=1);

namespace App\Shared\Adapter\Http;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

interface Controller
{
    public function execute(Request $request, Response $response, array $args = []): Response;
    public function setTemplateEngine(TemplateEngine $templateEngine): void;
}