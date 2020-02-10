
  <!-- Page -->
  <div class="page">
    <div class="page-header">
      <h1 class="page-title">Analytics Overview</h1>
    </div>

    <!-- Page Content -->
    <div class="page-content container-fluid">
      <div class="row" data-plugin="matchHeight" data-by-row="true">
        <!--
        <div class="col-12">
          
          <div id="productOverviewWidget" class="card card-shadow card-md">
            
            <div class="card-header card-header-transparent py-20">
              <div class="btn-group dropdown">
                <a href="#" class="text-body dropdown-toggle blue-grey-700 text-uppercase" data-toggle="dropdown">Product Sales</a>
                <div class="dropdown-menu animate" role="menu">
                  <a class="dropdown-item" href="#" role="menuitem">Sales</a>
                  <a class="dropdown-item" href="#" role="menuitem">Total sales</a>
                  <a class="dropdown-item" href="#" role="menuitem">Profit</a>
                </div>
              </div>
              <div class="card-header-actions">
                <ul class="nav nav-pills nav-pills-rounded product-filters">
                  <li class="nav-item">
                    <a class="active nav-link" href="#scoreLineToDay" data-toggle="tab">Day</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#scoreLineToWeek" data-toggle="tab">Week</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#scoreLineToMonth" data-toggle="tab">Month</a>
                  </li>
                </ul>
              </div>
            </div>
            >
            <div class="card-block p-20">
              <div class="tab-content">
                <div class="ct-chart tab-pane active" id="scoreLineToDay"></div>
                <div class="ct-chart tab-pane" id="scoreLineToWeek"></div>
                <div class="ct-chart tab-pane" id="scoreLineToMonth"></div>
              </div>
              <div id="productOptionsData" class="text-center">
                <div class="row no-space">
                  
                  <div class="col-xl-3 col-md-6">
                    <div class="counter">
                      <div class="counter-label">Vist</div>
                      <div class="counter-number-group text-truncate">
                        <span class="counter-number-related red-600">+</span>
                        <span class="counter-number">681</span>
                      </div>
                      <div class="ct-chart" data-counter-type="productVist"></div>
                    </div>
                  </div>
                  
                  <div class="col-xl-3 col-md-6">
                    <div class="counter">
                      <div class="counter-label">Unique Vistors</div>
                      <div class="counter-number-group text-truncate">
                        <span class="counter-number-related green-600">-</span>
                        <span class="counter-number">522</span>
                      </div>
                      <div class="ct-chart" data-counter-type="productVistors"></div>
                    </div>
                  </div>
                  
                  <div class="col-xl-3 col-md-6">
                    <div class="counter">
                      <div class="counter-label">Page Views</div>
                      <div class="counter-number-group text-truncate">
                        <span class="counter-number-related green-600">-</span>
                        <span class="counter-number">1,622</span>
                      </div>
                      <div class="ct-chart" data-counter-type="productPageViews"></div>
                    </div>
                  </div>
                  
                  <div class="col-xl-3 col-md-6">
                    <div class="counter">
                      <div class="counter-label">Bounce Rate</div>
                      <div class="counter-number-group text-truncate">
                        <span class="counter-number-related red-600">+</span>
                        <span class="counter-number">843</span>
                      </div>
                      <div class="ct-chart" data-counter-type="productBounceRate"></div>
                    </div>
                  </div>
                  
                </div>
              </div>
            </div>
            
          </div>
          
        </div>
        -->
        

        <div class="col-xl-6 col-12">
           <!-- Example Line -->
              <div class="example-wrap">
                <h4 class="example-title">Ερευνητικό εργο ολων των ετων</h4>
                <p>Παρακάτω βλέπουμε το ερευνητικό έργο που έχει ανέβει ανα έτος απο το προσωπικό των καθηγητών του Πανεπιστημίου μας</p>
                <div class="example text-center">
                  <canvas id="chartByYear" height="300" width="450"></canvas>
                </div>
              </div>
              <!-- End Example Line -->
        </div>

        <div class="col-xl-6 col-12">
          <!-- Example Pie -->
              <div class="example-wrap m-md-0">
                <h4 class="example-title">ΕΡΓΟ ΠΟΥ ΕΧΕΙ ΠΑΡΑΧΘΕΙ ΤΗΝ ΔΙΔΑΚΤΙΚΗ ΠΕΡΙΟΔΟ:  
                  <form method="post">
                    <select value="2019" class="custom-select" onchange="graphCurrentYear(this.value)">
                      <?php foreach($yearlist as $year): ?>
                        <option value="<?= $year->year?>"><?= intval($year->year)?>-<?= intval($year->year) + 1 ?></a>
                      <?php endforeach; ?>
                    <!-- <option value="2000">2000</option>
                    <option value="2003">2003</option>
                    <option value="2006">2006</option>
                    <option value="2008">2008</option>
                    <option value="2009">2009</option>
                    <option value="2017">2017</option>
                    <option value="2018">2018</option>
                    <option value="2019">2019</option> -->
                    </select>
                  </form>
                </h4>

                <p>Στο παρακάτω γράφημα βλέπουμε το ερευνητικό έργο που έχουν παράγει οι καθηγητές του τμήματος ανά διδακτική περίοδο.</p>
                <div class="example text-center">
                  <canvas id="chartByProfCurrentYear" height="300" width="450"></canvas>
                </div>
              </div>
              <!-- End Example Pie -->
        </div>

         <div class="col-xl-6 col-12">
              <!-- Example Bar -->
              <div class="example-wrap">
                <h4 class="example-title">ΕΡΕΥΝΗΝΙΤΚΟ ΕΡΓΟ ΑΝΑ ΜΗΝΑ ΤΟΥ ΤΩΡΙΝΟΥ ΕΤΟΥΣ</h4>
                <p>Παρακάτω βλέπουμε το ερευνητικό έργο που έχει ανέβει ανα μήνα του έτους που διανύουμε απο το προσωπικό των καθηγητών του Πανεπιστημίου μας.</p>
                <div class="example text-center">
                  <canvas id="chartByMonth" height="300" width="450"></canvas>
                </div>
              </div>
              <!-- End Example Bar -->
            </div>
      </div>
    </div>
    <!-- End Page Content -->
  </div>
  <!-- End Page -->


  