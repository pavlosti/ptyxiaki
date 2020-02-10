<div class='modal-header text-center'>
<h4 class='modal-title w-100 font-weight-bold'><?=$title?></h4>
    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
    </button>
</div>
<div class='modal-body modal-content mx-3'>
    <table class="table table-hover" data-plugin="selectable" data-row-selectable="true">
        <thead>
          <tr>
            <th>Id</th>
            <th class="hidden-sm-down">Title</th>
            <th class="hidden-sm-down">Publishers</th>
            <th class="hidden-sm-down">Year</th>
          </tr>
        </thead>
        <tbody>

       <?php foreach($ref_list as $item): ?>
          <tr>
            <td><?= $item->id ?></td>
            <td><?= $item->title ?></td>
            <td><?= $item->publishers ?></td>
            <td><?= $item->year ?></td>
          </tr>   
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
</div>


 