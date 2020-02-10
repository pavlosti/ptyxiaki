 <!-- Page -->
  <div class="page">
    <div class="page-header">
      <h1 class="page-title"><?= $title; ?></h1>
    </div>
    <div class="page-content">

      <!-- Panel Table Add Row -->
      <div class="panel">
        <div class="panel-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-15">
                
                <a class="btn btn-outline btn-primary" href="professors/insert_professor_modal" data-toggle="modal" data-target="#mainModal">
                  <i class="icon wb-plus" aria-hidden="true"></i> Add professor
                </a>

                <button  class="btn btn-outline btn-primary" type="button">
                  <i class="icon wb-plus" aria-hidden="true"></i> Sync
                </button>
              </div>
            </div>
          </div>
          <table class="table table-bordered table-hover table-striped" cellspacing="0" id="exampleAddRow">
            <thead>
              <tr>
                <th>Όνομα</th>
                <th>Επίθετο</th>
                <th>Email</th>
                <th>Citation(db)</th>
                <th>Citation(web)</th>
                <th>ScholarId(Status)</th>
                <th>Update</th>
                <th>Last Update Articles/References</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>

              <?php foreach($professors as $prof): ?>
                <tr class="gradeA" id="prof-<?= $prof->id; ?>">
                  <td><span class="edit"><?= $prof->firstname ?></span><input type='text' class='txtedit' data-id='<?= $prof->id; ?>' data-field='firstname' id='firstnametxt_<?= $prof->id; ?>' value='<?= $prof->firstname; ?>' ></td>
                  

                  <td><span class="edit"><?= $prof->lastname ?></span><input type='text' class='txtedit' data-id='<?= $prof->id; ?>' data-field='lastname' id='lastnametxt_<?= $prof->id; ?>' value='<?= $prof->lastname; ?>' ></td>
                  

                  <td><span class="edit"><?= $prof->email ?></span><input type='text' class='txtedit' data-id='<?= $prof->id; ?>' data-field='email' id='emailtxt_<?= $prof->id; ?>' value='<?= $prof->email; ?>' ></td>
                  

                  <td><span><?= $prof->citation_on_db ?></span></td>
                  <td><span><?= $prof->citation_on_web ?></span></td>

                  <td>
                    <span>
                      <a href="professors/insert_scholar_account_modal/?firstname=<?= $prof->firstname ?>&lastname=<?= $prof->lastname ?>&id=<?= $prof->id ?>" data-toggle="modal" data-target="#mainModal">
                      <?= $prof->scholarid ? '<img src="https://img.icons8.com/ultraviolet/40/000000/graduation-cap.png">' : '<img  src="https://img.icons8.com/ios-glyphs/30/000000/graduation-cap.png">' ?>
                      </a>
                    </span>
                  </td>

                  <td class="actions">
                      <a class="btn btn-warning" href="professors/article_list/<?= $prof->scholarid; ?>" role="button">Article list</a>
                      <a class="btn btn-warning" href="professors/reference_list/<?= $prof->scholarid; ?>" role="button">Reference list</a>

                      <a class="btn btn-warning" href="professors/reference_single/<?= $prof->scholarid; ?>" role="button">Reference single</a>

                  </td>
                  <td>
                    <span><?= $prof->last_article_update_at ?> / <?= $prof->last_ref_update_at ?></span> 
                  </td>
                  <td>
                    <a href="#" class="btn btn-sm btn-icon btn-pure btn-default on-editing save-row"
                      data-toggle="tooltip" data-original-title="Save" hidden><i class="icon wb-wrench" aria-hidden="true"></i></a>
                    <a href="#" class="btn btn-sm btn-icon btn-pure btn-default on-editing cancel-row"
                      data-toggle="tooltip" data-prof-id="<?= $prof->id; ?>" data-original-title="Delete" hidden><i class="icon wb-close" aria-hidden="true"></i></a>
                    <a href="#" class="btn btn-sm btn-icon btn-pure btn-default on-default remove-row"
                      data-toggle="tooltip" data-prof-id="<?= $prof->id; ?>" data-original-title="Remove"><i class="icon wb-trash" aria-hidden="true"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- End Panel Table Add Row -->
    </div>
  </div>
  <!-- End Page -->
