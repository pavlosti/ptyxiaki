
  <!-- Page -->
  <div class="page">
    <div class="page-header">
      <h1 class="page-title">Analytics Overview</h1>
    </div>

    <!-- Page Content -->
    <div class="page-content container-fluid">
      <div class="row" data-plugin="matchHeight" data-by-row="true">
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
      </div>
    </div>
    <!-- End Page Content -->
  </div>
  <!-- End Page -->


  