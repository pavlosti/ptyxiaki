 <!-- Page -->
  <div class="page">
    <div class="page-header">
      <h1 class="page-title"><?= $title; ?></h1>
    </div>
    <div class="page-content">


    <div class="dropdown">
  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Καθηγητές
  </button>
  <div id="prof_list" class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="#" data-id="all">All</a>
    <?php foreach($prof as $prof): ?>
        <a class="dropdown-item" href="#" data-name="<?= $prof->firstname ?> <?= $prof->lastname?>" data-id="<?= $prof->scholarid?>"><?= $prof->firstname ?> <?= $prof->lastname?></a>
    <?php endforeach; ?>
  </div>
</div> 

      <table id="memListTable" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Title</th>
                <th>Publication Date</th>
                <th>Type</th>
                <th>Type_name</th>
                <th>Citation</th>
                <th>ScholarId Professor</th>
                <th>ScholarId Article</th>
                <th>References Id</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Title</th>
                <th>Publication Date</th>
                <th>Type</th>
                <th>Type_name</th>
                <th>Citation</th>
                <th>ScholarId Professor</th>
                <th>ScholarId Article</th>
                <th>References Id</th>
            </tr>
        </tfoot>
      </table>

    </div>
  </div>
  <!-- End Page -->
