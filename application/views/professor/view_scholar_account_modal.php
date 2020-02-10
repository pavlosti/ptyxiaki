<div class='modal-header text-center'>
<h4 class='modal-title w-100 font-weight-bold'><?=$title?></h4>
    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
    </button>
</div>
<div class='modal-body mx-3'>
    <table class="table table-hover" data-plugin="selectable" data-row-selectable="true">
        <thead>
          <tr>
            <th class="w-50"></th>
            <th>Name</th>
            <th class="hidden-sm-down">ScholarId</th>
            <th class="hidden-sm-down">Επαληθευμένο από</th>
            <th class="hidden-sm-down">Citation</th>
          </tr>
        </thead>
        <tbody>

        <?php foreach($profScholarId as $item): ?>
          <tr>
            <td>
              <span class="custom-control custom-radio">
                <input type="radio" data-citation="<?= $item['citation'][0] ?>" data-prof-id="<?= $id ?>" id="row-<?= $item['scholarid'] ?>" name="<?= $item['scholarid'] ?>" value="<?= $item['scholarid'] ?>">
                <label for="row-<?= $item['scholarid'] ?>"></label>
              </span>
            </td>
            <td><?= $item['name'] ?></td>
            <td><?= $item['scholarid'] ?></td>
            <td>
              <span class=""><?= $item['description'] ?></span>
            </td>
             <td>
              <span class=""><?= $item['citation'][0] ?></span>
            </td>
          </tr>   
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class='modal-footer d-flex justify-content-center'>
    <button type='button' class='btn btn-default insert-scholar-id'>Add Scholar Id</button>
</div>


 