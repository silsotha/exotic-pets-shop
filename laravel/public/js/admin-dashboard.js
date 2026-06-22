document.addEventListener('DOMContentLoaded', () => {
    const salesDataElement = document.getElementById('dashboard-sales-data');
    const speciesDataElement = document.getElementById('dashboard-species-data');

    const salesCanvas = document.getElementById('salesChart');
    const speciesCanvas = document.getElementById('speciesChart');

    if (typeof Chart === 'undefined') {
        console.error('Chart.js не был загружен.');
        return;
    }

    const parseJsonElement = (element, fallback) => {
        if (!element) {
            return fallback;
        }

        try {
            return JSON.parse(element.textContent);
        } catch (error) {
            console.error('Не удалось прочитать данные диаграммы:', error);
            return fallback;
        }
    };

    const salesData = parseJsonElement(salesDataElement, {
        months: [],
        counts: [],
        revenue: [],
    });

    const speciesData = parseJsonElement(speciesDataElement, {
        names: [],
        counts: [],
    });

    const rootStyles = getComputedStyle(document.documentElement);
    const bodyStyles = getComputedStyle(document.body);

    const readCssVariable = (name, fallback) => {
        const value = rootStyles.getPropertyValue(name).trim();

        return value || fallback;
    };

    const textColor = readCssVariable(
        '--md-sys-color-on-surface',
        '#292a27',
    );

    const mutedColor = readCssVariable(
        '--md-sys-color-on-surface-variant',
        '#62635d',
    );

    const gridColor = readCssVariable(
        '--md-sys-color-outline-variant',
        '#d0d1ca',
    );

    Chart.defaults.color = mutedColor;
    Chart.defaults.font.family = bodyStyles.fontFamily;
    Chart.defaults.borderColor = gridColor;

    if (salesCanvas) {
        new Chart(salesCanvas, {
            type: 'bar',

            data: {
                labels: salesData.months,

                datasets: [
                    {
                        label: 'Количество продаж',
                        data: salesData.counts,
                        yAxisID: 'salesCount',
                        backgroundColor: '#cfd8d2',
                        hoverBackgroundColor: '#bcc9c1',
                        borderRadius: 8,
                        borderSkipped: false,
                        maxBarThickness: 42,
                    },
                    {
                        label: 'Выручка, ₽',
                        data: salesData.revenue,
                        type: 'line',
                        yAxisID: 'salesRevenue',
                        borderColor: '#68736a',
                        backgroundColor: 'rgba(104, 115, 106, 0.10)',
                        pointBackgroundColor: '#68736a',
                        pointBorderColor: '#f7f7f4',
                        pointBorderWidth: 3,
                        pointRadius: 4,
                        pointHoverRadius: 5,
                        tension: 0.35,
                        fill: true,
                    },
                ],
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                interaction: {
                    mode: 'index',
                    intersect: false,
                },

                plugins: {
                    legend: {
                        position: 'bottom',

                        labels: {
                            color: mutedColor,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            boxWidth: 8,
                            boxHeight: 8,
                            padding: 18,
                        },
                    },

                    tooltip: {
                        backgroundColor: textColor,
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        padding: 12,
                        cornerRadius: 12,
                        displayColors: true,

                        callbacks: {
                            label(context) {
                                const value = context.parsed.y ?? 0;

                                if (context.dataset.yAxisID === 'salesRevenue') {
                                    const formattedValue =
                                        new Intl.NumberFormat('ru-RU', {
                                            minimumFractionDigits: 0,
                                            maximumFractionDigits: 2,
                                        }).format(value);

                                    return `${context.dataset.label}: ${formattedValue} ₽`;
                                }

                                return `${context.dataset.label}: ${value}`;
                            },
                        },
                    },
                },

                scales: {
                    x: {
                        grid: {
                            display: false,
                        },

                        ticks: {
                            color: mutedColor,
                        },

                        border: {
                            display: false,
                        },
                    },

                    salesCount: {
                        type: 'linear',
                        position: 'left',
                        beginAtZero: true,

                        title: {
                            display: true,
                            text: 'Продажи',
                            color: mutedColor,
                        },

                        ticks: {
                            color: mutedColor,
                            precision: 0,
                        },

                        grid: {
                            color: gridColor,
                        },

                        border: {
                            display: false,
                        },
                    },

                    salesRevenue: {
                        type: 'linear',
                        position: 'right',
                        beginAtZero: true,

                        title: {
                            display: true,
                            text: 'Выручка, ₽',
                            color: mutedColor,
                        },

                        ticks: {
                            color: mutedColor,

                            callback(value) {
                                return new Intl.NumberFormat('ru-RU', {
                                    notation: 'compact',
                                    maximumFractionDigits: 1,
                                }).format(value);
                            },
                        },

                        grid: {
                            drawOnChartArea: false,
                        },

                        border: {
                            display: false,
                        },
                    },
                },
            },
        });
    }

    if (speciesCanvas) {
        new Chart(speciesCanvas, {
            type: 'doughnut',

            data: {
                labels: speciesData.names,

                datasets: [
                    {
                        data: speciesData.counts,

                        backgroundColor: [
                            '#c8d4cc',
                            '#ddd6c8',
                            '#ccd6da',
                            '#ded0cd',
                            '#d8d7cc',
                        ],

                        hoverBackgroundColor: [
                            '#b5c5bb',
                            '#cec4b2',
                            '#b9c9cf',
                            '#cebcb8',
                            '#c8c7b8',
                        ],

                        borderWidth: 0,
                        spacing: 3,
                        hoverOffset: 5,
                    },
                ],
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '66%',

                plugins: {
                    legend: {
                        position: 'bottom',

                        labels: {
                            color: textColor,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            boxWidth: 8,
                            boxHeight: 8,
                            padding: 14,
                        },
                    },

                    tooltip: {
                        backgroundColor: textColor,
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        padding: 12,
                        cornerRadius: 12,
                    },
                },
            },
        });
    }
});