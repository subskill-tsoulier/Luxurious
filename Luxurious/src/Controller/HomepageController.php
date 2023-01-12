<?php

namespace App\Controller;

use App\Service\CryptoService;
use Codenixsv\CoinGeckoApi\CoinGeckoClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{

	/**
	 * @throws \Exception
	 */
	#[Route('/', name: 'app_homepage')]
    public function index(): Response
    {
		$service = new CryptoService;

        return $this->render('homepage/index.html.twig', [
	        'btc' => $service->get_actual_price('bitcoin', 'usd'),
	        'eth' => $service->get_actual_price('ethereum', 'usd'),
	        'xmr' => $service->get_actual_price('monero', 'usd'),
        ]);
    }
}
