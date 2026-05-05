<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class AnalyticsController extends Controller
{
    private string $analyticsBaseUrl;

    public function __construct()
    {
        $this->analyticsBaseUrl = env('ANALYTICS_URL', 'http://127.0.0.1:5000');
    }

    public function index()
    {
        try {
            // Revenue APIs
            $revenueOverview = $this->callApi('/api/revenue/overview');
            $revenueByCategory = $this->callApi('/api/revenue/by-category');
            $revenueByCity = $this->callApi('/api/revenue/by-city');
            $statusDistribution = $this->callApi('/api/revenue/status-distribution');
            $revenueStats = $this->callApi('/api/revenue/statistics');

            // Product APIs
            $productOverview = $this->callApi('/api/products/overview');
            $topSellers = $this->callApi('/api/products/top-sellers');
            $conversionRate = $this->callApi('/api/products/conversion-rate');
            $priceDistribution = $this->callApi('/api/products/price-distribution');
            $stockAlerts = $this->callApi('/api/products/stock-alerts');
            $profitability = $this->callApi('/api/products/profitability');

            // Customer APIs (Phase 4)
            $customerOverview = $this->callApi('/api/customers/overview');
            $topCustomers = $this->callApi('/api/customers/top-customers');
            $rfmSegmentation = $this->callApi('/api/customers/rfm');
            $clv = $this->callApi('/api/customers/clv');
            $customerDistribution = $this->callApi('/api/customers/distribution');

            // Prediction APIs (Phase 5)
            $revenuePrediction = $this->callApi('/api/predict/revenue');
            $recommendations = $this->callApi('/api/predict/recommendations');
            $anomalies = $this->callApi('/api/predict/anomalies');

            $analyticsOnline = true;
        } catch (\Exception $e) {
            $analyticsOnline = false;
            $revenueOverview = $revenueByCategory = $revenueByCity = null;
            $statusDistribution = $revenueStats = null;
            $productOverview = $topSellers = $conversionRate = null;
            $priceDistribution = $stockAlerts = $profitability = null;
            $customerOverview = $topCustomers = null;
            $rfmSegmentation = $clv = $customerDistribution = null;
            $revenuePrediction = $recommendations = $anomalies = null;
        }

        return view('admin.analytics', compact(
            'analyticsOnline',
            'revenueOverview', 'revenueByCategory', 'revenueByCity',
            'statusDistribution', 'revenueStats',
            'productOverview', 'topSellers', 'conversionRate',
            'priceDistribution', 'stockAlerts', 'profitability',
            'customerOverview', 'topCustomers',
            'rfmSegmentation', 'clv', 'customerDistribution',
            'revenuePrediction', 'recommendations', 'anomalies',
        ));
    }

    private function callApi(string $endpoint): ?array
    {
        $response = Http::timeout(15)->get($this->analyticsBaseUrl . $endpoint);
        return $response->successful() ? $response->json() : null;
    }
}
