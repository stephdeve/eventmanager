import Chart from 'chart.js/auto';

const palette = {
    indigo: '#6366F1',
    emerald: '#34D399',
    slate: '#1F2937',
    sky: '#38BDF8',
    amber: '#F59E0B',
};

function resolveElement(idOrElement) {
    if (idOrElement instanceof HTMLCanvasElement) {
        return idOrElement;
    }

    return document.getElementById(idOrElement);
}

function renderChart(target, config) {
    const canvas = resolveElement(target);

    if (!canvas) {
        return;
    }

    const existing = Chart.getChart(canvas);
    if (existing) {
        existing.destroy();
    }

    // eslint-disable-next-line no-new
    new Chart(canvas, config);
}

function renderRoleChart(dataset = {}) {
    const labels = dataset.labels ?? [];
    const series = dataset.series ?? [];

    if (!labels.length || !series.length) {
        return;
    }

    renderChart('adminUsersRoleChart', {
        type: 'doughnut',
        data: {
            labels,
            datasets: [
                {
                    data: series,
                    backgroundColor: [palette.indigo, palette.sky, palette.emerald, palette.amber],
                    borderWidth: 0,
                },
            ],
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: palette.slate,
                        usePointStyle: true,
                    },
                },
            },
        },
    });
}

function renderSignupChart(dataset = {}) {
    const labels = dataset.labels ?? [];
    const series = dataset.series ?? [];

    if (!labels.length) {
        return;
    }

    renderChart('adminUsersSignupChart', {
        type: 'line',
        data: {
            labels,
            datasets: [
                {
                    label: 'Nouveaux utilisateurs',
                    data: series,
                    fill: false,
                    borderColor: palette.indigo,
                    backgroundColor: palette.indigo,
                    tension: 0.35,
                    borderWidth: 3,
                    pointRadius: 4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: palette.indigo,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: { color: palette.slate },
                },
            },
            scales: {
                x: {
                    ticks: { color: palette.slate },
                    grid: { display: false },
                },
                y: {
                    ticks: { color: palette.slate },
                    grid: { color: 'rgba(148, 163, 184, 0.2)' },
                    beginAtZero: true,
                },
            },
        },
    });
}

export function initAdminUsersCharts(datasets = {}) {
    renderRoleChart(datasets.roles);
    renderSignupChart(datasets.signups);
}
