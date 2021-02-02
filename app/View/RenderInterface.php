<?php

namespace Application\View;

interface RenderInterface
{
    public static function view(string $templateName, array $params = []);
}