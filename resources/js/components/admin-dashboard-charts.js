import Chart from 'chart.js/auto';

const palette = {
    indigo: '#6366F1',
    sky: '#38BDF8',
    emerald: '#34D399',
    amber: '#F59E0B',
    rose: '#F43F5E',
    slate: '#1F2937',
};

function createChart(ctx, config) {
    const element = ctx instanceof HTMLCanvasElement ? ctx : document.getElementById(ctx);

    if (!element) {
        return null;
    }

    const existing = Chart.getChart(element);
    if (existing) {
        existing.destroy();
    }

    return new Chart(element, config);
}

function roleDistributionChart({ labels = [], series = [] }) {
    createChart('chartRoleDistribution', {
        type: 'doughnut',
        data: {
            labels,
            datasets: [
                {
                    data: series,
                    backgroundColor: [palette.indigo, palette.sky, palette.emerald, palette.amber, palette.rose],
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

function monthlyRegistrationsChart({ labels = [], total = [], validated = [] }) {
    createChart('chartMonthlyRegistrations', {
        type: 'bar',
        data: {
            labels,
            datasets: [
                {
                    label: 'Total inscriptions',
                    data: total,
                    backgroundColor: palette.indigo,
                    borderRadius: 12,
                    barPercentage: 0.5,
                },
                {
                    label: 'Billets validés',
                    data: validated,
                    backgroundColor: palette.emerald,
                    borderRadius: 12,
                    barPercentage: 0.5,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: palette.slate,
                    },
                },
            },
            scales: {
                x: {
                    ticks: { color: palette.slate },
                    grid: { display: false },
                    stacked: false,
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

function participationChart({ labels = [], validated = [], pending = [] }) {
    createChart('chartParticipation', {
        type: 'bar',
        data: {
            labels,
            datasets: [
                {
                    label: 'Validés',
                    data: validated,
                    backgroundColor: palette.emerald,
                    borderRadius: 8,
                    stack: 'participation',
                },
                {
                    label: 'En attente',
                    data: pending,
                    backgroundColor: palette.amber,
                    borderRadius: 8,
                    stack: 'participation',
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { color: palette.slate },
                },
            },
            scales: {
                x: {
                    stacked: true,
                    ticks: { color: palette.slate },
                    grid: { display: false },
                },
                y: {
                    stacked: true,
                    ticks: { color: palette.slate },
                    grid: { color: 'rgba(148, 163, 184, 0.2)' },
                    beginAtZero: true,
                },
            },
        },
    });
}

function capacityChart({ labels = [], registrations = [], capacities = [] }) {
    createChart('chartCapacity', {
        type: 'bar',
        data: {
            labels,
            datasets: [
                {
                    label: 'Capacité maximale',
                    data: capacities,
                    backgroundColor: 'rgba(99, 102, 241, 0.2)',
                    borderColor: palette.indigo,
                    borderWidth: 2,
                    borderRadius: 10,
                    order: 1,
                },
                {
                    label: 'Inscriptions',
                    data: registrations,
                    backgroundColor: palette.indigo,
                    borderRadius: 10,
                    order: 0,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
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

function organizerChart({ labels = [], series = [] }) {
    createChart('chartOrganizers', {
        type: 'bar',
        data: {
            labels,
            datasets: [
                {
                    data: series,
                    backgroundColor: palette.sky,
                    borderRadius: 12,
                    barPercentage: 0.6,
                },
            ],
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
            },
            scales: {
                x: {
                    ticks: { color: palette.slate },
                    grid: { color: 'rgba(148, 163, 184, 0.2)' },
                    beginAtZero: true,
                },
                y: {
                    ticks: { color: palette.slate },
                    grid: { display: false },
                },
            },
        },
    });
}

export function initAdminDashboardCharts(datasets = {}) {
    roleDistributionChart(datasets.roleDistribution ?? {});
    monthlyRegistrationsChart(datasets.monthlyRegistrations ?? {});
    participationChart(datasets.participation ?? {});
    capacityChart(datasets.capacity ?? {});
    organizerChart(datasets.organizers ?? {});
}
