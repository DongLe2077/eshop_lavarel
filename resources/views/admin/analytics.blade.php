@extends('layouts.admin')
@section('title', 'Phân tích dữ liệu')
@section('content')
@if(!$analyticsOnline)
<div class="p-6 bg-red-50 border border-red-200 rounded-2xl text-red-700 mb-6">
    <i class="fas fa-exclamation-triangle mr-2"></i>
    <strong>Dịch vụ phân tích Python chưa chạy!</strong> Chạy: <code class="bg-red-100 px-2 py-1 rounded">cd analytics && python app.py</code>
</div>
@else
{{-- KPI Cards --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 p-6 rounded-2xl text-white shadow-lg shadow-blue-200">
        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-3"><i class="fas fa-dollar-sign fa-lg"></i></div>
        <div class="text-blue-100 text-sm">Tổng doanh thu</div>
        <div class="text-2xl font-bold">{{ number_format($revenueOverview['total_revenue'] ?? 0, 0, ',', '.') }}đ</div>
        <div class="text-xs text-blue-200 mt-1">AOV: {{ number_format($revenueOverview['average_order_value'] ?? 0, 0, ',', '.') }}đ</div>
    </div>
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 p-6 rounded-2xl text-white shadow-lg shadow-purple-200">
        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-3"><i class="fas fa-shopping-cart fa-lg"></i></div>
        <div class="text-purple-100 text-sm">Tổng đơn hàng</div>
        <div class="text-2xl font-bold">{{ $revenueOverview['total_orders'] ?? 0 }}</div>
    </div>
    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 p-6 rounded-2xl text-white shadow-lg shadow-emerald-200">
        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-3"><i class="fas fa-box fa-lg"></i></div>
        <div class="text-emerald-100 text-sm">Tổng sản phẩm</div>
        <div class="text-2xl font-bold">{{ $productOverview['total_products'] ?? 0 }}</div>
        <div class="text-xs text-emerald-200 mt-1">Kho: {{ number_format($productOverview['total_inventory_value'] ?? 0, 0, ',', '.') }}đ</div>
    </div>
    <div class="bg-gradient-to-br from-orange-500 to-orange-600 p-6 rounded-2xl text-white shadow-lg shadow-orange-200">
        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mb-3"><i class="fas fa-users fa-lg"></i></div>
        <div class="text-orange-100 text-sm">Khách hàng</div>
        <div class="text-2xl font-bold">{{ $customerOverview['total_customers'] ?? 0 }}</div>
        <div class="text-xs text-orange-200 mt-1">Đã mua: {{ $customerOverview['buyers_count'] ?? 0 }} ({{ $customerOverview['purchase_rate'] ?? 0 }}%)</div>
    </div>
</div>

{{-- Section: DOANH THU --}}
<h2 class="text-lg font-bold text-slate-700 mb-4 flex items-center"><i class="fas fa-chart-line text-blue-500 mr-2"></i>Phân tích Doanh thu</h2>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="font-bold text-slate-800 mb-4">Doanh thu theo danh mục</h3>
        <div style="height:280px"><canvas id="chartRevCat"></canvas></div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="font-bold text-slate-800 mb-4">Trạng thái đơn hàng</h3>
        <div style="height:280px"><canvas id="chartStatus"></canvas></div>
    </div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="font-bold text-slate-800 mb-4">Doanh thu theo thành phố</h3>
        <div style="height:280px"><canvas id="chartCity"></canvas></div>
    </div>
    @if($revenueStats)
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="font-bold text-slate-800 mb-4"><i class="fas fa-calculator text-violet-500 mr-2"></i>Thống kê (Pandas)</h3>
        <div class="grid grid-cols-2 gap-3">
            @foreach(['mean'=>'Trung bình','median'=>'Trung vị','std'=>'Độ lệch chuẩn','q25'=>'Phân vị 25%','q75'=>'Phân vị 75%'] as $k=>$l)
            <div class="text-center p-3 bg-slate-50 rounded-xl">
                <div class="text-xs text-slate-400 mb-1">{{ $l }}</div>
                <div class="text-base font-bold text-slate-800">{{ number_format($revenueStats[$k] ?? 0, 0, ',', '.') }}đ</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

{{-- Section: SAN PHAM --}}
<h2 class="text-lg font-bold text-slate-700 mb-4 flex items-center"><i class="fas fa-box text-emerald-500 mr-2"></i>Phân tích Sản phẩm</h2>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="font-bold text-slate-800 mb-4">Top sản phẩm bán chạy</h3>
        <div style="height:280px"><canvas id="chartTopSell"></canvas></div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="font-bold text-slate-800 mb-4">Giá TB theo danh mục</h3>
        <div style="height:280px"><canvas id="chartPrice"></canvas></div>
    </div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    {{-- Conversion Rate --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-bold text-slate-800">Tỷ lệ chuyển đổi (Xem -> Mua)</h3></div>
        <div class="overflow-auto max-h-72">
            <table class="w-full text-left text-sm">
                <thead><tr class="bg-slate-50 text-xs font-bold text-slate-400 uppercase"><th class="px-4 py-3">Sản phẩm</th><th class="px-4 py-3">Views</th><th class="px-4 py-3">Sold</th><th class="px-4 py-3">Rate</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                @if($conversionRate && isset($conversionRate['products']))
                @foreach(array_slice($conversionRate['products'], 0, 8) as $p)
                <tr class="hover:bg-slate-50"><td class="px-4 py-2 text-slate-700">{{ Str::limit($p['name'], 22) }}</td><td class="px-4 py-2 text-slate-500">{{ $p['views'] }}</td><td class="px-4 py-2">{{ $p['sold'] }}</td>
                <td class="px-4 py-2"><span class="px-2 py-1 rounded-full text-xs font-bold {{ $p['conversion_rate'] > 5 ? 'bg-emerald-50 text-emerald-600' : 'bg-orange-50 text-orange-600' }}">{{ $p['conversion_rate'] }}%</span></td></tr>
                @endforeach @endif
                </tbody>
            </table>
        </div>
    </div>
    {{-- Stock Alerts --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between"><h3 class="font-bold text-slate-800">Cảnh báo tồn kho</h3>
        @if($stockAlerts)<span class="text-xs font-bold text-red-500 bg-red-50 px-2 py-1 rounded-lg">{{ $stockAlerts['total_alerts'] ?? 0 }} SP</span>@endif</div>
        <div class="overflow-auto max-h-72">
            <table class="w-full text-left text-sm">
                <thead><tr class="bg-slate-50 text-xs font-bold text-slate-400 uppercase"><th class="px-4 py-3">Sản phẩm</th><th class="px-4 py-3">Tồn kho</th><th class="px-4 py-3">Trạng thái</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                @if($stockAlerts && isset($stockAlerts['products']))
                @foreach($stockAlerts['products'] as $p)
                <tr class="hover:bg-slate-50"><td class="px-4 py-2 text-slate-700">{{ Str::limit($p['name'], 28) }}</td>
                <td class="px-4 py-2 font-bold {{ $p['stock'] == 0 ? 'text-red-500' : 'text-amber-500' }}">{{ $p['stock'] }}</td>
                <td class="px-4 py-2"><span class="px-2 py-1 rounded-full text-xs font-bold {{ $p['status'] === 'Hết hàng' ? 'bg-red-50 text-red-600' : 'bg-amber-50 text-amber-600' }}">{{ $p['status'] }}</span></td></tr>
                @endforeach @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- Lợi nhuận ước tính --}}
@if($profitability && isset($profitability['summary']))
<div class="mb-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 p-5 rounded-2xl text-white shadow-lg">
            <div class="text-emerald-100 text-xs">Tổng doanh thu (không hủy)</div>
            <div class="text-xl font-bold mt-1">{{ number_format($profitability['summary']['total_revenue'] ?? 0, 0, ',', '.') }}đ</div>
        </div>
        <div class="bg-gradient-to-br from-lime-500 to-green-600 p-5 rounded-2xl text-white shadow-lg">
            <div class="text-lime-100 text-xs">Lợi nhuận gộp ước tính (40%)</div>
            <div class="text-xl font-bold mt-1">{{ number_format($profitability['summary']['total_profit'] ?? 0, 0, ',', '.') }}đ</div>
        </div>
        <div class="bg-gradient-to-br from-sky-500 to-blue-600 p-5 rounded-2xl text-white shadow-lg">
            <div class="text-sky-100 text-xs">Danh mục lợi nhuận cao nhất</div>
            <div class="text-lg font-bold mt-1">{{ $profitability['summary']['most_profitable_category'] ?? 'N/A' }}</div>
            <div class="text-xs text-sky-200 mt-1">SP lãi nhất: {{ Str::limit($profitability['summary']['most_profitable_product'] ?? '', 22) }}</div>
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="font-bold text-slate-800 mb-1">Doanh thu vs. Lợi nhuận theo danh mục</h3>
        <p class="text-xs text-slate-400 mb-4">Biên lợi nhuận gộp ngành thời trang ~40% (ước tính, chưa có giá vốn thực tế)</p>
        <div style="height:250px"><canvas id="chartProfit"></canvas></div>
    </div>
</div>
@endif

{{-- Section: KHACH HANG (Phase 4) --}}
<h2 class="text-lg font-bold text-slate-700 mb-4 flex items-center"><i class="fas fa-users text-purple-500 mr-2"></i>Phân tích Khách hàng (RFM & CLV)</h2>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="font-bold text-slate-800 mb-4">Phân khúc khách hàng (RFM)</h3>
        <div style="height:280px"><canvas id="chartRFM"></canvas></div>
    </div>
    {{-- RFM Table --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100"><h3 class="font-bold text-slate-800">Chi tiết RFM</h3></div>
        <div class="overflow-auto max-h-72">
            <table class="w-full text-left text-sm">
                <thead><tr class="bg-slate-50 text-xs font-bold text-slate-400 uppercase"><th class="px-4 py-3">Email</th><th class="px-4 py-3">F</th><th class="px-4 py-3">M</th><th class="px-4 py-3">Score</th><th class="px-4 py-3">Phân khúc</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                @if($rfmSegmentation && isset($rfmSegmentation['customers']))
                @foreach(array_slice($rfmSegmentation['customers'], 0, 10) as $c)
                <tr class="hover:bg-slate-50"><td class="px-4 py-2 text-slate-700 text-xs">{{ $c['email'] }}</td>
                <td class="px-4 py-2">{{ $c['frequency'] }}</td>
                <td class="px-4 py-2">{{ number_format($c['monetary'], 0, ',', '.') }}</td>
                <td class="px-4 py-2 font-bold">{{ $c['rfm_score'] }}</td>
                <td class="px-4 py-2"><span class="px-2 py-1 rounded-full text-xs font-bold
                {{ $c['segment'] === 'VIP' ? 'bg-purple-50 text-purple-600' : ($c['segment'] === 'Trung thành' ? 'bg-blue-50 text-blue-600' : ($c['segment'] === 'Tiềm năng' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600')) }}">{{ $c['segment'] }}</span></td></tr>
                @endforeach @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- CLV --}}
@if($clv)
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-br from-violet-500 to-purple-600 p-6 rounded-2xl text-white shadow-lg">
        <div class="text-violet-200 text-sm">CLV Trung bình</div>
        <div class="text-2xl font-bold mt-1">{{ number_format($clv['avg_clv'] ?? 0, 0, ',', '.') }}đ</div>
        <div class="text-xs text-violet-200 mt-1">Dự báo {{ $clv['estimated_lifespan_months'] ?? 12 }} tháng</div>
    </div>
    <div class="bg-gradient-to-br from-pink-500 to-rose-600 p-6 rounded-2xl text-white shadow-lg">
        <div class="text-pink-200 text-sm">Tổng CLV</div>
        <div class="text-2xl font-bold mt-1">{{ number_format($clv['total_clv'] ?? 0, 0, ',', '.') }}đ</div>
    </div>
    <div class="bg-gradient-to-br from-cyan-500 to-teal-600 p-6 rounded-2xl text-white shadow-lg">
        <div class="text-cyan-200 text-sm">Số khách hàng</div>
        <div class="text-2xl font-bold mt-1">{{ count($clv['customers'] ?? []) }}</div>
        <div class="text-xs text-cyan-200 mt-1">TB: {{ $customerDistribution['avg_orders_per_customer'] ?? 0 }} đơn/KH</div>
    </div>
</div>
@endif

{{-- Section: ML & DU DOAN (Phase 5) --}}
<h2 class="text-lg font-bold text-slate-700 mb-4 flex items-center"><i class="fas fa-robot text-indigo-500 mr-2"></i>Machine Learning & Dự đoán</h2>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    {{-- Revenue Prediction Chart --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="font-bold text-slate-800 mb-2">Dự báo doanh thu (Linear Regression)</h3>
        @if($revenuePrediction && isset($revenuePrediction['model_info']))
        <div class="flex gap-2 mb-3">
            <span class="text-xs bg-indigo-50 text-indigo-600 px-2 py-1 rounded-lg font-medium">R² = {{ $revenuePrediction['model_info']['r2_score'] ?? 0 }}</span>
            <span class="text-xs bg-emerald-50 text-emerald-600 px-2 py-1 rounded-lg font-medium">Đơn tiếp: {{ number_format($revenuePrediction['model_info']['predicted_next_order'] ?? 0, 0, ',', '.') }}đ</span>
        </div>
        @endif
        <div style="height:260px"><canvas id="chartPredict"></canvas></div>
    </div>
    {{-- Anomaly Detection --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-slate-800"><i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>Phát hiện bất thường (IsolationForest)</h3>
            @if($anomalies)<span class="text-xs font-bold {{ ($anomalies['total_anomalies'] ?? 0) > 0 ? 'text-red-500 bg-red-50' : 'text-emerald-500 bg-emerald-50' }} px-2 py-1 rounded-lg">{{ $anomalies['total_anomalies'] ?? 0 }} bất thường</span>@endif
        </div>
        @if($anomalies && isset($anomalies['statistics']))
        <div class="px-6 py-3 bg-slate-50 text-xs text-slate-500 grid grid-cols-3 gap-2">
            <span>Mean: {{ number_format($anomalies['statistics']['mean'] ?? 0, 0, ',', '.') }}đ</span>
            <span>IQR: {{ number_format($anomalies['statistics']['IQR'] ?? 0, 0, ',', '.') }}đ</span>
            <span>Upper: {{ number_format($anomalies['statistics']['upper_bound'] ?? 0, 0, ',', '.') }}đ</span>
        </div>
        @endif
        <div class="overflow-auto max-h-56">
            <table class="w-full text-left text-sm">
                <thead><tr class="bg-slate-50 text-xs font-bold text-slate-400 uppercase"><th class="px-4 py-3">Mã đơn</th><th class="px-4 py-3">Giá trị</th><th class="px-4 py-3">Lý do</th></tr></thead>
                <tbody class="divide-y divide-slate-100">
                @if($anomalies && isset($anomalies['anomalies']))
                @foreach($anomalies['anomalies'] as $a)
                <tr class="hover:bg-red-50/50"><td class="px-4 py-2 font-medium text-slate-700">{{ $a['code'] }}</td>
                <td class="px-4 py-2 font-bold text-red-500">{{ number_format($a['total_price'], 0, ',', '.') }}đ</td>
                <td class="px-4 py-2 text-xs text-slate-500">{{ $a['reason'] }}</td></tr>
                @endforeach
                @else <tr><td colspan="3" class="px-4 py-6 text-center text-slate-400">Không có bất thường</td></tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- Product Recommendations --}}
@if($recommendations && isset($recommendations['pairs']) && count($recommendations['pairs']) > 0)
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-8">
    <h3 class="font-bold text-slate-800 mb-4"><i class="fas fa-handshake text-teal-500 mr-2"></i>Sản phẩm thường mua cùng nhau (Market Basket)</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($recommendations['pairs'] as $pair)
        <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
            <div class="flex items-center gap-2 mb-2"><span class="text-sm font-medium text-slate-700">{{ Str::limit($pair['product_1'], 20) }}</span><i class="fas fa-plus text-xs text-slate-400"></i><span class="text-sm font-medium text-slate-700">{{ Str::limit($pair['product_2'], 20) }}</span></div>
            <div class="flex justify-between text-xs"><span class="text-slate-400">Mua cùng {{ $pair['times_bought_together'] }} lần</span><span class="font-bold text-emerald-600">{{ number_format($pair['bundle_price'], 0, ',', '.') }}đ</span></div>
        </div>
        @endforeach
    </div>
</div>
@elseif($recommendations && isset($recommendations['popular_products']))
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 mb-8">
    <h3 class="font-bold text-slate-800 mb-4"><i class="fas fa-star text-yellow-500 mr-2"></i>Sản phẩm phổ biến nhất</h3>
    <div class="flex flex-wrap gap-3">
        @foreach($recommendations['popular_products'] as $p)
        <span class="px-4 py-2 bg-yellow-50 text-yellow-700 rounded-xl text-sm font-medium border border-yellow-100">{{ $p['product'] }} ({{ $p['times_bought'] }}x)</span>
        @endforeach
    </div>
</div>
@endif

<div class="text-center text-xs text-slate-400 mb-4">Powered by Python (Pandas + NumPy + Scikit-learn) | Flask API | Chart.js</div>
@endif
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
const C = ['#3b82f6','#8b5cf6','#10b981','#f59e0b','#ef4444','#ec4899','#06b6d4','#84cc16'];
function mk(id,type,labels,datasets,o={}){const el=document.getElementById(id);if(!el)return;new Chart(el,{type,data:{labels,datasets},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{position:o.lp||'bottom',labels:{boxWidth:12,padding:12,font:{size:11}}}},scales:o.ns?undefined:{y:{beginAtZero:true,ticks:{font:{size:10}},grid:{color:'#f1f5f9'}},x:{ticks:{font:{size:10}},grid:{display:false}}},...o.ex}});}

@if($analyticsOnline)
const sm = {'pending':'Chờ xử lý','processing':'Đang xử lý','completed':'Hoàn thành','canceled':'Đã hủy','đang xử lý':'Đang xử lý','đã giao':'Đã giao','hoàn thành':'Hoàn thành','đã hủy':'Đã hủy'};
mk('chartRevCat','doughnut',@json($revenueByCategory['labels']??[]),[{data:@json($revenueByCategory['data']??[]),backgroundColor:C,borderWidth:0,hoverOffset:8}],{ns:true,lp:'right'});
mk('chartStatus','doughnut',(@json($statusDistribution['labels']??[])).map(s=>sm[s]||s),[{data:@json($statusDistribution['data']??[]),backgroundColor:@json($statusDistribution['colors']??[]),borderWidth:0}],{ns:true,lp:'right'});
mk('chartCity','bar',@json($revenueByCity['labels']??[]),[{label:'Doanh thu',data:@json($revenueByCity['data']??[]),backgroundColor:'#3b82f622',borderColor:'#3b82f6',borderWidth:2,borderRadius:8}]);
(function(){var e=document.getElementById('chartTopSell');if(!e)return;new Chart(e,{type:'bar',data:{labels:@json($topSellers['labels']??[]),datasets:[{label:'Số lượng',data:@json($topSellers['data']??[]),backgroundColor:C.map(c=>c+'22'),borderColor:C,borderWidth:2,borderRadius:8}]},options:{indexAxis:'y',responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false}},scales:{x:{beginAtZero:true,grid:{color:'#f1f5f9'}},y:{ticks:{font:{size:10}},grid:{display:false}}}}});})();
mk('chartPrice','bar',@json($priceDistribution['categories']['labels']??[]),[{label:'Giá TB',data:@json($priceDistribution['categories']['avg_prices']??[]),backgroundColor:C.map(c=>c+'22'),borderColor:C,borderWidth:2,borderRadius:8}]);

@if($profitability && isset($profitability['by_category']))
mk('chartProfit','bar',@json($profitability['by_category']['labels']??[]),[{label:'Doanh thu',data:@json($profitability['by_category']['revenue']??[]),backgroundColor:'#3b82f622',borderColor:'#3b82f6',borderWidth:2,borderRadius:6},{label:'Lợi nhuận gộp',data:@json($profitability['by_category']['profit']??[]),backgroundColor:'#10b98122',borderColor:'#10b981',borderWidth:2,borderRadius:6}]);
@endif

@if($rfmSegmentation && isset($rfmSegmentation['segment_chart']))
mk('chartRFM','doughnut',@json($rfmSegmentation['segment_chart']['labels']??[]),[{data:@json($rfmSegmentation['segment_chart']['data']??[]),backgroundColor:@json($rfmSegmentation['segment_chart']['colors']??[]),borderWidth:0}],{ns:true,lp:'right'});
@endif

@if($revenuePrediction && isset($revenuePrediction['current_data']))
(function(){var e=document.getElementById('chartPredict');if(!e)return;
var cl=@json($revenuePrediction['current_data']['labels']??[]);
var cv=@json($revenuePrediction['current_data']['values']??[]);
var pl=@json($revenuePrediction['prediction']['labels']??[]);
var pv=@json($revenuePrediction['prediction']['incremental']??[]);
var all=cl.concat(pl),d1=cv.concat(Array(pl.length).fill(null)),d2=Array(cl.length).fill(null).concat(pv);
new Chart(e,{type:'bar',data:{labels:all,datasets:[{label:'Thực tế',data:d1,backgroundColor:'#3b82f6',borderRadius:6},{label:'Dự báo',data:d2,backgroundColor:'#f59e0b88',borderColor:'#f59e0b',borderWidth:2,borderRadius:6,borderDash:[5,5]}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{position:'bottom',labels:{boxWidth:12,font:{size:11}}}},scales:{y:{beginAtZero:true,grid:{color:'#f1f5f9'}},x:{ticks:{font:{size:9}},grid:{display:false}}}}});})();
@endif
@endif
</script>
@endsection

