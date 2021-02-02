<?php
namespace Application\View;

class TwigRender implements RenderInterface
{
    public static function view($templateName, $params = [])
    {
        $loader = new \Twig\Loader\FilesystemLoader(APP_DIR . '/View/Template/Twig');
        $twig = new \Twig\Environment($loader);
        $twig->addGlobal('userSession', $_SESSION['user'] ?? null);

        return $twig->render("$templateName.html.twig", $params);
    }
}