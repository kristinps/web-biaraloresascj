@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Pesan dan informasi dari admin')

@section('content')
<div class="dashboard-user-content admin-dashboard-content">
    <header class="dashboard-user-header">
        <h1 class="dashboard-user-title">Dashboard</h1>
    </header>

    {{-- Kartu statistik --}}
    <div class="admin-stats-grid">
        <div class="admin-stat-card card">
            <div class="admin-stat-icon admin-stat-icon-period" aria-hidden="true"></div>
            <div class="admin-stat-body">
                <span class="admin-stat-label">Periode Aktif</span>
                <span class="admin-stat-value">{{ $periodeAktifCount }}</span>
            </div>
        </div>
        <div class="admin-stat-card card">
            <div class="admin-stat-icon admin-stat-icon-done" aria-hidden="true"></div>
            <div class="admin-stat-body">
                <span class="admin-stat-label">Periode Selesai</span>
                <span class="admin-stat-value">{{ $periodeSelesaiCount }}</span>
            </div>
        </div>
        <div class="admin-stat-card card">
            <div class="admin-stat-icon admin-stat-icon-wait" aria-hidden="true"></div>
            <div class="admin-stat-body">
                <span class="admin-stat-label">Peserta Tanpa Periode</span>
                <span class="admin-stat-value">{{ $pesertaTanpaPeriode }}</span>
            </div>
        </div>
        <div class="admin-stat-card card">
            <div class="admin-stat-icon admin-stat-icon-active" aria-hidden="true"></div>
            <div class="admin-stat-body">
                <span class="admin-stat-label">Peserta Periode Aktif</span>
                <span class="admin-stat-value">{{ $pesertaPeriodeAktif }}</span>
            </div>
        </div>
        <div class="admin-stat-card card">
            <div class="admin-stat-icon admin-stat-icon-finished" aria-hidden="true"></div>
            <div class="admin-stat-body">
                <span class="admin-stat-label">Peserta Periode Selesai</span>
                <span class="admin-stat-value">{{ $pesertaPeriodeSelesai }}</span>
            </div>
        </div>
    </div>

    {{-- Grafik: periode aktif (pie) & periode selesai (bar) --}}
    <div class="admin-charts-grid mt-4">

        <div class="admin-chart-card admin-chart-card-full card">
            <h2 class="admin-chart-title">Jumlah Peserta pada Periode Selesai</h2>
            <div class="admin-chart-wrap admin-chart-wrap-center">
                <canvas id="chartBarPesertaPeriodeSelesai" aria-label="Grafik batang peserta per periode selesai" role="img"></canvas>
            </div>
        </div>

        <div class="admin-chart-card card">
            <h2 class="admin-chart-title">Jumlah Peserta pada Periode Selesai</h2>
            <div class="admin-chart-wrap admin-chart-wrap-center">
                <canvas id="chartPiePesertaPeriodeAktif" aria-label="Grafik lingkaran peserta per periode aktif" role="img"></canvas>
            </div>
        </div>


    </div>

</div>

@push('styles')
<style>
.admin-dashboard-content .dashboard-user-title,
.admin-dashboard-content .dashboard-user-header { color: #ffffff; }
.admin-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    gap: 1rem;
    margin-bottom: 1.75rem;
}
.admin-stat-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.25rem;
    background: linear-gradient(135deg,
        rgba(99,102,241,0.14),
        rgba(139,92,246,0.10),
        rgba(56,189,248,0.08)
    );
    border: 1px solid rgba(148,163,184,0.5);
    box-shadow: 0 8px 24px rgba(15,23,42,0.08);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}
.admin-stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    flex-shrink: 0;
}
.admin-stat-icon-period { background: linear-gradient(135deg, #3b82f6, #2563eb); }
.admin-stat-icon-done { background: linear-gradient(135deg, #10b981, #059669); }
.admin-stat-icon-wait { background: linear-gradient(135deg, #f59e0b, #d97706); }
.admin-stat-icon-active { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
.admin-stat-icon-finished { background: linear-gradient(135deg, #6366f1, #4f46e5); }
.admin-stat-body { display: flex; flex-direction: column; gap: 0.25rem; min-width: 0; }
.admin-stat-label { font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.04em; color: #ffffff; }
.admin-stat-value { font-size: 1.5rem; font-weight: 700; color: #ffffff; line-height: 1.2; }
.admin-charts-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.25rem;
}
.admin-chart-card {
    padding: 1.25rem;
    background: linear-gradient(135deg,
        rgba(99,102,241,0.14),
        rgba(139,92,246,0.10),
        rgba(56,189,248,0.08)
    );
    border: 1px solid rgba(148,163,184,0.5);
    box-shadow: 0 8px 24px rgba(15,23,42,0.08);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}
.admin-chart-card-full { grid-column: 1 / -1; }
.admin-chart-title { font-size: 0.95rem; font-weight: 700; color: #ffffff; margin-bottom: 1rem; }
.admin-chart-wrap { position: relative; width: 100%; min-height: 200px; }
.admin-chart-wrap-center { display: flex; justify-content: center; align-items: center; }
@media (max-width: 768px) {
    .admin-stats-grid { grid-template-columns: 1fr; }
    .admin-charts-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
(function() {
    const chartPeriodeAktif = @json($chartPeriodeAktif ?? ['labels' => [], 'values' => []]);
    const chartPeriodeSelesai = @json($chartPeriodeSelesai ?? ['labels' => [], 'values' => []]);
    const chartPesertaPerPeriodeAktif = @json($chartPesertaPerPeriodeAktif ?? ['labels' => [], 'values' => []]);
    const chartPesertaPerPeriodeSelesai = @json($chartPesertaPerPeriodeSelesai ?? ['labels' => [], 'values' => []]);

    const colorAktif = ['rgba(139, 92, 246, 0.85)', 'rgba(99, 102, 241, 0.85)', 'rgba(79, 70, 229, 0.85)', 'rgba(124, 58, 237, 0.85)', 'rgba(109, 40, 217, 0.85)'];
    const colorSelesai = ['rgba(16, 185, 129, 0.85)', 'rgba(5, 150, 105, 0.85)', 'rgba(4, 120, 87, 0.85)', 'rgba(6, 95, 70, 0.85)', 'rgba(6, 78, 59, 0.85)'];
    const borderAktif = ['rgb(139, 92, 246)', 'rgb(99, 102, 241)', 'rgb(79, 70, 229)', 'rgb(124, 58, 237)', 'rgb(109, 40, 217)'];
    const borderSelesai = ['rgb(16, 185, 129)', 'rgb(5, 150, 105)', 'rgb(4, 120, 87)', 'rgb(6, 95, 70)', 'rgb(6, 78, 59)'];
    function expandColors(colors, n) {
        const out = [];
        for (let i = 0; i < n; i++) out.push(colors[i % colors.length]);
        return out;
    }

    function makePie(canvasId, labels, values, colors, borders, emptyLabel, opts) {
        const ctx = document.getElementById(canvasId);
        if (!ctx) return;
        const L = labels && labels.length ? labels : [emptyLabel];
        const V = values && values.length ? values : [0];
        const bg = expandColors(colors, V.length);
        const bd = expandColors(borders, V.length);
        const textColor = '#ffffff';
        const plugins = {
            legend: opts && opts.legendLabel ? {
                position: 'bottom',
                labels: {
                    color: textColor,
                    generateLabels: function(chart) {
                        const data = chart.data;
                        return (data.labels || []).map(function(label, i) {
                            const value = (data.datasets[0] && data.datasets[0].data[i]) != null ? data.datasets[0].data[i] : 0;
                            return {
                                text: opts.legendLabel(label, value),
                                fillStyle: (data.datasets[0] && data.datasets[0].backgroundColor && data.datasets[0].backgroundColor[i]) || 'gray',
                                strokeStyle: (data.datasets[0] && data.datasets[0].borderColor && data.datasets[0].borderColor[i]) || 'gray',
                                lineWidth: 2,
                                index: i,
                                fontColor: textColor,
                                font: { color: textColor }
                            };
                        });
                    }
                }
            } : { position: 'bottom', labels: { color: textColor } },
            tooltip: {
                titleColor: textColor,
                bodyColor: textColor,
                callbacks: opts && opts.tooltipLabel ? {
                    label: function(context) {
                        const label = context.label || '';
                        const value = context.raw != null ? context.raw : 0;
                        return opts.tooltipLabel(label, value);
                    }
                } : undefined
            }
        };
        if (opts && opts.tooltipLabel && plugins.tooltip.callbacks) {
            plugins.tooltip.callbacks.label = function(context) {
                const label = context.label || '';
                const value = context.raw != null ? context.raw : 0;
                return opts.tooltipLabel(label, value);
            };
        }
        const options = {
            responsive: true,
            maintainAspectRatio: true,
            plugins: plugins
        };
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: L,
                datasets: [{ data: V, backgroundColor: bg, borderColor: bd, borderWidth: 2 }],
            },
            options: options,
        });
    }

    function makeBar(canvasId, labels, values, colors, borders, emptyLabel, opts) {
        const ctx = document.getElementById(canvasId);
        if (!ctx) return;
        const L = labels && labels.length ? labels : [emptyLabel];
        const V = values && values.length ? values : [0];
        const bg = expandColors(colors, V.length);
        const bd = expandColors(borders, V.length);
        const textColor = '#ffffff';
        const options = {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        color: textColor
                    },
                    title: opts && opts.yTitle ? { display: true, text: opts.yTitle, color: textColor } : undefined
                },
                x: {
                    ticks: { color: textColor },
                    title: opts && opts.xTitle ? { display: true, text: opts.xTitle, color: textColor } : undefined
                }
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    titleColor: textColor,
                    bodyColor: textColor,
                    callbacks: opts && opts.tooltipLabel ? {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw != null ? context.raw : 0;
                            return opts.tooltipLabel(label, value);
                        }
                    } : undefined
                }
            }
        };
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: L,
                datasets: [{
                    label: opts && opts.datasetLabel ? opts.datasetLabel : 'Jumlah Peserta',
                    data: V,
                    backgroundColor: bg,
                    borderColor: bd,
                    borderWidth: 2
                }],
            },
            options: options,
        });
    }

    function labelPeriodePesertaAktif() {
        return {
            tooltipLabel: function(label, value) {
                return 'Jumlah peserta: ' + value;
            },
            legendLabel: function(label, value) {
                return 'Jumlah peserta: ' + value;
            }
        };
    }

    function optsBarPeriodeSelesai() {
        return {
            tooltipLabel: function(label, value) {
                return 'Jumlah peserta: ' + value;
            },
            datasetLabel: 'Peserta per periode selesai',
            xTitle: 'Periode selesai',
            yTitle: 'Jumlah peserta'
        };
    }

    // 1. Jumlah periode aktif berdasarkan Periode Aktif
    makePie('chartPiePeriodeAktif', chartPeriodeAktif.labels, chartPeriodeAktif.values, colorAktif, borderAktif, 'Tidak ada periode aktif');

    // 2. Jumlah periode selesai berdasarkan Periode Selesai
    makePie('chartPiePeriodeSelesai', chartPeriodeSelesai.labels, chartPeriodeSelesai.values, colorSelesai, borderSelesai, 'Tidak ada periode selesai');

    // 3. Jumlah Peserta Periode Aktif per periode aktif (pie) dengan keterangan periode aktif + jumlah peserta
    makePie('chartPiePesertaPeriodeAktif', chartPesertaPerPeriodeAktif.labels, chartPesertaPerPeriodeAktif.values, colorAktif, borderAktif, 'Tidak ada periode aktif', labelPeriodePesertaAktif());

    // 4. Jumlah Peserta Periode Selesai per periode selesai (bar)
    makeBar('chartBarPesertaPeriodeSelesai', chartPesertaPerPeriodeSelesai.labels, chartPesertaPerPeriodeSelesai.values, colorSelesai, borderSelesai, 'Tidak ada periode selesai', optsBarPeriodeSelesai());
})();
</script>
@endpush
@endsection
