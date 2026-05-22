import $ from 'jquery';
window.$ = window.jQuery = $;

import '@popperjs/core';
import 'admin-lte/dist/js/adminlte.min.js';

import './bootstrap';
/*Imports */

// SortableJS
import Sortable from 'sortablejs';

// ApexCharts
import ApexCharts from 'apexcharts';

// jsVectorMap
import jsVectorMap from 'jsvectormap';
import 'jsvectormap/dist/maps/world.js';

// OverlayScrollbars (ESM)
import { OverlayScrollbars } from 'overlayscrollbars';
import 'overlayscrollbars/styles/overlayscrollbars.css';


/* ApexCharts - Revenue Chart */
document.addEventListener("DOMContentLoaded", () => {
    const el = document.querySelector('#revenue-chart');
    if (el) {
        const sales_options = {
            series: [
                { name: 'Digital Goods', data: [28, 48, 40, 19, 86, 27, 90] },
                { name: 'Electronics', data: [65, 59, 80, 81, 56, 55, 40] },
            ],
            chart: { type: 'area', height: 300, toolbar: { show: false } },
            legend: { show: false },
            colors: ['#0d6efd', '#20c997'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth' },
            xaxis: {
                type: 'datetime',
                categories: [
                    '2023-01-01', '2023-02-01', '2023-03-01',
                    '2023-04-01', '2023-05-01', '2023-06-01',
                    '2023-07-01',
                ],
            },
            tooltip: { x: { format: 'MMMM yyyy' } },
        };

        new ApexCharts(el, sales_options).render();
    }
});


/* jsVectorMap - World Map */
document.addEventListener("DOMContentLoaded", () => {
    const map = document.querySelector('#world-map');
    if (map) {
        new jsVectorMap({
            selector: '#world-map',
            map: 'world',
        });
    }
});


/* OverlayScrollbars - Sidebar Scroll */
document.addEventListener("DOMContentLoaded", () => {
    const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';

    const Default = {
        scrollbarTheme: 'os-theme-light',
        scrollbarAutoHide: 'leave',
        scrollbarClickScroll: true,
    };

    const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);

    // Disable OverlayScrollbars on mobile
    const isMobile = window.innerWidth <= 992;

    if (sidebarWrapper && !isMobile) {
        OverlayScrollbars(sidebarWrapper, {
            scrollbars: {
                theme: Default.scrollbarTheme,
                autoHide: Default.scrollbarAutoHide,
                clickScroll: Default.scrollbarClickScroll,
            },
        });
    }
});
