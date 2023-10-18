<?php

namespace App\Tests;

use App\Controller\CartController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use PHPUnit\Framework\TestCase;

class CartControllerTest extends TestCase{
    public function testAddToCart()
    {
        $session = $this->createMock(SessionInterface::class);
        $session->method('get')->willReturn([]);
        $session->method('set')->willReturn([]);

        $cartController = new CartController($session);
        $cartController->addToCart(1, 2);

        $cart = $cartController->getCart();
        $this->assertEquals(2, $cart[1]);

    }
}

// vendor/bin/phpunit tests/CartControllerTest.php pour tester