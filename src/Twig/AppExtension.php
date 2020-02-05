<?php

namespace App\Twig;

use App\Entity\Menu;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class AppExtension extends AbstractExtension
{

    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public function getFunctions()
    {
        return array(
            new TwigFunction('isActive', array($this, 'isActive')),
        );

    }

    public function isActive(Menu $menu, $url)
    {
        $isActive = false;
        if ($menu->getisRouteValid()) {
            if ($menu->getRoute()) {
                if ($url == $this->router->generate($menu->getRoute())) {
                    $isActive = true;
                }
            }
        }

        if ($menu->getChildren()) {
            foreach ($menu->getChildren() as $child) {
                if ($child->getRoute()) {
                    if ($url == $this->router->generate($child->getRoute())) {
                        $isActive = true;
                    }
                }
            }
        }

        return $isActive;
    }


}