<?php

namespace Paysera\Util\RamlCodeGenerator\Generator;

use Paysera\Util\RamlCodeGenerator\Entity\Definition\ApiDefinition;
use Paysera\Util\RamlCodeGenerator\Entity\SourceCode;
use Twig_Environment;

class ClientFactoryGenerator implements GeneratorInterface
{
    private $twig;

    public function __construct(
        Twig_Environment $twig
    ) {
        $this->twig = $twig;
    }

    public function generate(ApiDefinition $definition)
    {
        $baseUrl = $definition->getRamlDefinition()->getBaseUrl();

        $code = $this->twig->render('Client/Client/ClientFactory.php.twig', [
            'base_url' => rtrim($baseUrl, '/') . '/',
            'api' => $definition,
        ]);

        $item = new SourceCode();
        $item
            ->setFilepath('src/ClientFactory.php')
            ->setContents($code)
        ;

        return [$item];
    }
}