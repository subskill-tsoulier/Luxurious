<?php

namespace App\Service;

use Codenixsv\CoinGeckoApi\CoinGeckoClient;

class CryptoService {

	private CoinGeckoClient $client;

	public function __construct() {
		$this->client = new CoinGeckoClient();
	}

	public function get_actual_price($crypto, $devise) {
		foreach ($this->client->simple()->getPrice($crypto, $devise) as $key) {
			return $key[$devise];
		}
	}
}