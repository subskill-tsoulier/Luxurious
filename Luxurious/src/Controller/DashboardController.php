<?php

namespace App\Controller;

use App\Service\ChartService;
use Codenixsv\CoinGeckoApi\CoinGeckoClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(ChartBuilderInterface $chartBuilder): Response
	{
		$client = new CoinGeckoClient();

		$actual_date = new \DateTime();
		$nbr_day = '30';
		$timestamp_minus_30_day = new \DateTime('now - ' . $nbr_day . ' day');

		$result = $client->coins()->getMarketChartRange(
			'ethereum',
			'eur',
			$timestamp_minus_30_day->getTimestamp(),
			$actual_date->getTimestamp(),
		)['prices'];

		$label_chart = array();
		$data_chart = array();

		for ($i = 0; $i < count($result); $i++) {
			if ($i % 24 === 0) {
				$label_chart[] = $result[$i][0];
				$data_chart[] = $result[$i][1];
			}
		}


		$chart = $chartBuilder->createChart(Chart::TYPE_LINE);

		$chart->setData([
			'labels' => $label_chart,
			'datasets' => [
				[
					'label' => 'ethereum',
					'backgroundColor' => 'rgb(204, 172, 0)',
					'borderColor' => 'rgb(204, 172, 0)',
					'data' => $data_chart,
					'tension' => 0.4,
				],
			],
		]);

		$chart->setOptions([
			'scales' => [
				'y' => [
					'beginAtZero' => 0,
				],
			],
		]);

		return $this->render('dashboard/index.html.twig', [
			'chart' => $chart,
		]);
	}
}
