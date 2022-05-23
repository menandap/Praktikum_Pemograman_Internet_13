@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page1', 'Dashboard')
@section('page2', 'Dashboard')

@section('content')

<script src="https://www.chartjs.org/dist/2.9.3/Chart.min.js"></script>
<script src="https://www.chartjs.org/samples/latest/utils.js"></script>
<style>
    canvas {
    -moz-user-select: none;
    -webkit-user-select: none;
    -ms-user-select: none;
    }
</style>

<div class="container-fluid py-4">
      <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">style</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Product</p>
                <h4 class="mb-0">{{$product}}</h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-primary shadow-primary text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">person</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Users</p>
                <h4 class="mb-0">{{$user}}</h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-success shadow-success text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">shopping_cart</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Transaction</p>
                <h4 class="mb-0">{{$allSales}}</h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-header p-3 pt-2">
              <div class="icon icon-lg icon-shape bg-gradient-info shadow-info text-center border-radius-xl mt-n4 position-absolute">
                <i class="material-icons opacity-10">motorcycle</i>
              </div>
              <div class="text-end pt-1">
                <p class="text-sm mb-0 text-capitalize">Courier</p>
                <h4 class="mb-0">{{$courier}}</h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
          </div>
        </div>
      </div>

      <div class="grid-margin stretch-card pt-5">
        <div class="card">
            <div class="card-body">
        <div id="container" style="width: 95%;">
            <canvas id="canvas"></canvas>
            </div>
            <?php
                $bulan = ["$january", "$february","$march","$april","$may","$june","$july","$august","$september","$october","$november","$december"];
                //$bulans = ["0", "100","1","100","100","100","9","100","100","8","100","100"];
                
            ?>

            <?php 
                //misal ada 3 dealer
                $transaksi = 1;
                $k=0;
                for($d=1; $d<=$transaksi;$d++){
                //kemudian misal data dari bulan 1 hingga bulan 12
                    for($b=1;$b<=12;$b++){
                        $data[$d][$b] = $bulan[$k];
                        $k++;
                        
                    }
                }
                // echo $data[1][5];
               
               
                function random_color(){  
                    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                }
            ?>
        
        <script>
        var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        var color = Chart.helpers.color;
        var barChartData = {
            labels: MONTHS,
            datasets: [
                <?php 
                        for($d=1;$d<=$transaksi;$d++){
                            $color = random_color();
                            ?>
                            {
                                label: '<?php echo "Transaksi success ";?>',
                                backgroundColor: color('<?php echo $color;?>').alpha(0.5).rgbString(),
                                borderColor: '<?php echo $color;?>',
                                borderWidth: 1,
                                data: [
                                    <?php 
                                        for($b=1;$b<=12;$b++){
                                            echo $data[$d][$b].",";
                                        }
                                    ?>     
                                ]
                            },
                            <?php 
                        }
                ?>
            ]    
        };
        
        window.onload = function() {
            var ctx = document.getElementById('canvas').getContext('2d');
            window.myBar = new Chart(ctx, {
                type: 'bar',
                data: barChartData,
                options: {
                    responsive: true,
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Grafik Transaksi bulanan'
                    }
                }
        });
        
        };        
        </script>
        </div>
      </div>
    </div>
    
    <div class="grid-margin stretch-card pt-5">
        <div class="card">
            <div class="card-body">
            <!-- OVERVIEW -->
            <div class="panel panel-headline">
                <div class="panel-heading ">
                    <p class="panel-subtitle" style="font-weight: bold">Periode: {{ date('d-m-Y H:m:s', strtotime($now)) }}</p>
                </div>
                
                <div class="panel-body mt-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="metric">
                                <span class="icon">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                </span>
                                <p>
                                    <span class="number">{{ $monthlySales }}</span>
                                    <span class="title">Penjualan Bulanan</span>
                                </p>
                               
                                <div class="weekly-summary">
                                    <span class="number">Rp{{ number_format($incomeMonthly) }}</span>
                                    <span class="info-label">Pendapatan Bulanan</span>
                                </div>
                             
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="metric">
                                <span class="icon"><i class="fa fa-shopping-bag"></i></span>
                                <p>
                                    <span class="number">{{ $annualSales }}</span>
                                    <span class="title">Penjualan Tahunan</span>
                                    
                                </p>

                                <div class="weekly-summary ">
                                    <span class="number">Rp{{ number_format($incomeAnnual) }}</span>
                                    <span class="info-label">Pendapatan Tahunan</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="metric">
                                <span class="icon"><i class="fa fa-cart-plus" aria-hidden="true"></i>
                                </span>
                                <p>
                                    <span class="number">{{ $allSales }}</span>
                                    <span class="title">Total Penjualan</span>
                                </p>
                                <div class="weekly-summary">
                                    <span class="number">Rp{{ number_format($incomeTotal) }}</span>
                                    <span class="info-label">Total Pendapatan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END OVERVIEW -->
                </div>
            </div>
        </div>
       
      </div>
    </div>

    
@endsection