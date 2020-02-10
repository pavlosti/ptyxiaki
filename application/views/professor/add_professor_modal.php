<div class='modal-header text-center'>
<h4 class='modal-title w-100 font-weight-bold'><?=$title?></h4>
    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
        <span aria-hidden='true'>&times;</span>
    </button>
</div>
<div class='modal-body mx-3'>
    <form class="prof-form">
        <div class="form-group">
            <label for="title"> Name:</label>
            <input type='text' id='firstname' name='firstname' class='form-control' value="">
        </div>
        <div class="form-group">
            <label for="title"> Lastname:</label>
            <input type='text' id='lastname' name='lastname' class='form-control' value="">
        </div>
        <div class="form-group">
            <label for="title"> Email:</label>
            <input type='text' id='email' name='email' class='form-control' value="">
        </div>
    </form>
</div>
<div class='modal-footer d-flex justify-content-center'>
    <button type='button' class='btn btn-default insert-prof' onclick="submitContactForm()">Insert Professor</button>
</div>
