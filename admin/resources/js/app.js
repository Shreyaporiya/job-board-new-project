import './bootstrap';

// Load jQuery first
import $ from 'jquery';
window.$ = window.jQuery = $;

// Load moment BEFORE daterangepicker
import moment from 'moment';
window.moment = moment;

// Bootstrap
import 'bootstrap';

// AdminLTE
import 'admin-lte';

// Load jQuery UI (your local file)
import './plugins/jquery-ui/jquery-ui.min.js';

// Plugins
import './plugins/summernote/summernote-bs4.min.js';
import './plugins/daterangepicker/daterangepicker.js';
import './plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js';
import './plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js';
import './plugins/chart.js/Chart.min.js';
import './plugins/jqvmap/jquery.vmap.min.js';
import './plugins/jqvmap/maps/jquery.vmap.usa.js';
import './plugins/sparklines/sparkline.js';
