<?php

declare(strict_types=1);

namespace App\Shared\Infra;

use App\Shared\Adapter\Http\TemplateEngine;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\Twig;
use Slim\Flash\Messages;
use Odan\Session\SessionInterface;

final class TwigAdapter implements TemplateEngine
{
    private Twig $twig;

    public function __construct(array $config, Messages $flash, SessionInterface $session)
    {
        $this->twig = Twig::create(
            $config['templatePath'],
            ['cache' => APP_IS_PRODUCTION ? $config['cachePath'] : false]
        );

        $this->twig->getEnvironment()->addGlobal('session', $session);
        $this->twig->getEnvironment()->addGlobal('flash', $flash);
        $this->twig->getEnvironment()->addGlobal('sessionCookieName', 'gettobi');
    }

    public function getTwig(): Twig
    {
        return $this->twig;
    }

    public function render(Response $response, string $templateFile, array $params = []): Response
    {
        if (!preg_match("/^.*\.html.twig$/D", $templateFile)) {
            $templateFile .= '.html.twig';
        }

        return $this->twig->render($response, $templateFile, $params);
    }
}