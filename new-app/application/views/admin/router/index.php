<?php $this->load->view('templates/router/header'); ?>
<div class="app-content">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Dashboard Mikrotik </h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-3">
                    <div class="card widget widget-stats">
                        <div class="card-body">
                            <div class="widget-stats-container d-flex">
                                <div class="widget-stats-icon widget-stats-icon-primary">
                                    <i class="material-icons-outlined">wifi</i>
                                </div>
                                <div class="widget-stats-content flex-fill">
                                    <span class="widget-stats-title">Hotspot </span>
                                    <span class="widget-stats-info">Total user : <?= $hotspotuser ?> Users</span>
                                    <span class="widget-stats-info">Total user active : <?= $hotspotactive ?>
                                        Active</span>
                                    <span class="widget-stats-info">Total hotspot profile : <?= $hotspotprofile ?>
                                        Profile</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="card widget widget-stats">
                        <div class="card-body">
                            <div class="widget-stats-container d-flex">
                                <div class="widget-stats-icon widget-stats-icon-warning">
                                    <i class="material-icons-outlined">rocket_launch</i>
                                </div>
                                <div class="widget-stats-content flex-fill">
                                    <span class="widget-stats-title">PPP </span>
                                    <span class="widget-stats-info">PPP Secret : <?= $pppuser ?> Account</span>
                                    <span class="widget-stats-info">PPP Active : <?= $pppactive ?> Active</span>
                                    <span class="widget-stats-info">PPP Profile : <?= $pppprofile ?> Profile</span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="card widget widget-stats">
                        <div class="card-body">
                            <div class="widget-stats-container d-flex">
                                <div class="widget-stats-icon widget-stats-icon-success">
                                    <i class="material-icons-outlined">calendar_month</i>
                                </div>
                                <div class="widget-stats-content flex-fill">
                                    <span class="widget-stats-title">System date & time</span>
                                    <span class="widget-stats-info">Time : <?= $clock ?> </span>
                                    <span class="widget-stats-info">Uptime : <?= formatDTM($uptime) ?> </span>
                                    <span class="widget-stats-info">Timezone : <?= $timezone ?> </span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="card widget widget-stats">
                        <div class="card-body">
                            <div class="widget-stats-container d-flex">
                                <div class="widget-stats-icon widget-stats-icon-danger">
                                    <i class="material-icons-outlined">router</i>
                                </div>
                                <div class="widget-stats-content flex-fill">
                                    <span class="widget-stats-title">Info Data Router </span>
                                    <span class="widget-stats-info">Architecture : <?= $architecture ?> </span>
                                    <span class="widget-stats-info">Model : <?= $model ?> </span>
                                    <span class="widget-stats-info">Routers OS : <?= $version ?> </span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card" style="height:419px">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="card-title"><i class="fe fe-monitor"></i> Traffic Monitor</h3>

                        </div>
                        <div class="card-body">
                            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                            <script src="<?php echo base_url() ?>assets/js/highcharts.js"></script>
                            <script src="<?php echo base_url() ?>assets/js/highcharts-theme.js"></script>
                            <script type="text/javascript">
                                var chart;
                                var interface = "<?= $traffics ?>";
                                var n = 3000;

                                function requestDatta() {
                                    $.ajax({
                                        url: '<?php echo base_url() ?>router/traffic',
                                        datatype: "json",
                                        success: function(data) {
                                            var midata = JSON.parse(data);
                                            if (midata.length > 0) {
                                                var TX = parseInt(midata[0].data);
                                                var RX = parseInt(midata[1].data);
                                                var x = (new Date()).getTime();
                                                shift = chart.series[0].data.length > 19;
                                                chart.series[0].addPoint([x, TX], true, shift);
                                                chart.series[1].addPoint([x, RX], true, shift);
                                            }
                                        },
                                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                                            console.error("Status: " + textStatus + " request: " + XMLHttpRequest);
                                            console.error("Error: " + errorThrown);
                                        }
                                    });
                                }

                                $(document).ready(function() {
                                    Highcharts.setOptions({
                                        global: {
                                            useUTC: false
                                        }
                                    });
                                    Highcharts.addEvent(Highcharts.Series, 'afterInit', function() {
                                        this.symbolUnicode = {
                                            circle: '●',
                                            diamond: '♦',
                                            square: '■',
                                            triangle: '▲',
                                            'triangle-down': '▼'
                                        } [this.symbol] || '●';
                                    });
                                    chart = new Highcharts.Chart({
                                        chart: {
                                            renderTo: 'trafficMonitor',
                                            animation: Highcharts.svg,
                                            type: 'areaspline',
                                            events: {
                                                load: function() {
                                                    setInterval(function() {
                                                        requestDatta();
                                                    }, 8000);
                                                }
                                            }
                                        },
                                        title: {
                                            text: 'Interface: ' + interface
                                        },

                                        xAxis: {
                                            type: 'datetime',
                                            tickPixelInterval: 150,
                                            maxZoom: 20 * 1000,
                                        },
                                        yAxis: {
                                            minPadding: 0.2,
                                            maxPadding: 0.2,
                                            title: {
                                                text: null
                                            },
                                            labels: {
                                                formatter: function() {
                                                    var bytes = this.value;
                                                    var sizes = ['bps', 'kbps', 'Mbps', 'Gbps', 'Tbps'];
                                                    if (bytes == 0) return '0 bps';
                                                    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                                                    return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
                                                },
                                            },
                                        },

                                        series: [{
                                            name: 'Tx',
                                            data: [],
                                            marker: {
                                                symbol: 'circle'
                                            }
                                        }, {
                                            name: 'Rx',
                                            data: [],
                                            marker: {
                                                symbol: 'circle'
                                            }
                                        }],

                                        tooltip: {
                                            formatter: function() {
                                                var tdata = ["points", "y", "bps", "kbps", "Mbps", "Gbps", "Tbps", "<span style=\"color:", "color", "series", "; font-size: 1.5em;\">", "symbolUnicode", "</span><b>", "name", ":</b> 0 bps", "push", "log", "floor", ":</b> ", "toFixed", "pow", " ", "each", "", "%d %B %Y %H:%M:%S", "x", "dateFormat", "<br />", " <br/> ", "join"];
                                                var s = [];
                                                $[tdata[22]](this[tdata[0]], function(a, b) {
                                                    var c = b[tdata[1]];
                                                    var unit = [tdata[2], tdata[3], tdata[4], tdata[5], tdata[6]];
                                                    if (c == 0) {
                                                        s[tdata[15]](tdata[7] + this[tdata[9]][tdata[8]] + tdata[10] + this[tdata[9]][tdata[11]] + tdata[12] + this[tdata[9]][tdata[13]] + tdata[14])
                                                    };
                                                    var a = parseInt(Math[tdata[17]](Math[tdata[16]](c) / Math[tdata[16]](1024)));
                                                    s[tdata[15]](tdata[7] + this[tdata[9]][tdata[8]] + tdata[10] + this[tdata[9]][tdata[11]] + tdata[12] + this[tdata[9]][tdata[13]] + tdata[18] + parseFloat((c / Math[tdata[20]](1024, a))[tdata[19]](2)) + tdata[21] + unit[a])
                                                });
                                                return tdata[23] + Highcharts[tdata[26]](tdata[24], new Date(this[tdata[25]])) + tdata[27] + s[tdata[29]](tdata[28])
                                            },
                                            shared: true
                                        },
                                    });
                                });
                            </script>


                            <div id="trafficMonitor"></div>

                        </div>

                    </div>
                </div>
                <!-- COL END -->
            </div>



        </div>
    </div>
</div>





<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
if ($this->session->flashdata('message_err')) {
?>
    <script>
        swal({
            text: "<?php echo $this->session->flashdata('message_err'); ?>",
            icon: "error",
            button: false,
            timer: 1200
        });
    </script>
<?php
} elseif ($this->session->flashdata('message_success')) {
?>
    <script>
        swal({
            text: "<?php echo $this->session->flashdata('message_success'); ?>",
            icon: "success",
            button: false,
            timer: 1200
        });
    </script>
<?php
}
?>
<?php $this->load->view('templates/router/footer'); ?>