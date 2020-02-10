function submitContactForm(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var firstname = $('#firstname').val();
    var lastname = $('#lastname').val();
    var email = $('#email').val();

    if(firstname.trim() == '' ){
        alert('Please enter your name.');
        $('#firstname').focus();
        return false;
    }else if(lastname.trim() == '' ){
        alert('Please enter your lastname.');
        $('#lastname').focus();
        return false;
    }else if(email.trim() == '' || !reg.test(email)){
        alert('Please enter valid email.');
        $('#email').focus();
        return false;
    }else{
      $(document).on('click', '.insert-prof', function(e){
        e.preventDefault();
        let row = this.closest('.gradeA');
        let form = $('.prof-form');
          $.ajax({
              url: 'professors/saveProf/',
              method: 'POST',
              aynch: false,
              dataType: 'json',
              data: form.serialize(),
              success: function(res)
              {
                  if (!res || res.error)
                  {
                      alert(res.error);
                      return false;
                  }
                  if (res)
                  {

                    console.log(res.id);
                    console.log('alert from create');
                      let post = `
                          <td><span class='edit'>${res.firstname}</span><input type='text' class='txtedit' data-id='${res.id}' data-field='firstname' id='firstnametxt_${res.id}' value='${res.firstname}' ></td>
                          <td><span class='edit'>${res.lastname}</span><input type='text' class='txtedit' data-id='${res.id}' data-field='lastname' id='firstnametxt_${res.id}' value='${res.lastname}' ></td>
                          <td><span class='edit'>${res.email}</span><input type='text' class='txtedit' data-id='${res.id}' data-field='email' id='firstnametxt_${res.id}' value='${res.email}' ></td>
                          <td>${res.citation}</td>
                          <td><a href="professors/insert_scholar_account_modal/?firstname=${res.firstname}&lastname=${res.lastname}&id=${res.id}" data-toggle="modal" data-target="#mainModal">
                            <img src="https://img.icons8.com/ios-glyphs/30/000000/graduation-cap.png">
                            </a></td> 
                          <td class="actions">
                          <a href="#" class="btn btn-sm btn-icon btn-pure btn-default on-editing save-row"
                            data-toggle="tooltip" data-original-title="Save" hidden><i class="icon wb-wrench" aria-hidden="true"></i></a>
                          <a href="#" class="btn btn-sm btn-icon btn-pure btn-default on-editing cancel-row"
                            data-toggle="tooltip" data-original-title="Delete" hidden><i class="icon wb-close" aria-hidden="true"></i></a>
                          <a href="#" class="btn btn-sm btn-icon btn-pure btn-default on-default edit-row"
                            data-toggle="tooltip" data-original-title="Edit"><i class="icon wb-edit" aria-hidden="true"></i></a>
                          <a href="#" class="btn btn-sm btn-icon btn-pure btn-default on-default remove-row"
                            data-toggle="tooltip" data-original-title="Remove"><i class="icon wb-trash" aria-hidden="true"></i></a>
                        </td>
                      `;

                      //$("<tr id='prof-${res.id}' class='gradeA'></tr>").html(post).appendTo(".table");
                      $(`<tr id='prof-${res.id}' class='gradeA'></tr>`).html(post).appendTo(".table");

                  }

                  $('#mainModal').modal('hide');
            },
          failure: function(res)
          {
            console.log(res);
          }

        });
      });
    }
}


$(document).ready(function(){
  var $value = 'all';
  $('#prof_list a').on('click', function(){
    table.destroy();
    $value = $(this).data('id');
    $name = $(this).data('name');
    document.getElementById("dropdownMenuButton").innerHTML = $name;
    table = $('#memListTable').DataTable({
      "pageLength" : 10,
      "serverSide": true,
        "order": [
          [1, "asc" ]
        ],
        "columns": [
            null,
            null,
            null,
            null,
            { 
              targets: [4],
               data: null,
               render: function ( data, type, row, meta ) {

              return `<a href='articles/view_reference_modal/${row[6]}ids${row[7]}' data-toggle="modal" data-target="#mainModal"> ${row[4]} </a>`
            }},
            { orderable: false},
            null,
            null
        ],
      "ajax": {
            url : 'articles/articles_page/' + $value,
            type : 'GET'
        },
    });

});

if($value == 'all'){
  table = $('#memListTable').DataTable({
      "pageLength" : 10,
      "serverSide": true,
        "order": [
          [1, "asc" ]
        ],
        "columns": [
            null,
            null,
            null,
            null,
            { 
              targets: [4],
               data: null,
               render: function ( data, type, row, meta ) {

              return `<a href='articles/view_reference_modal/${row[6]}ids${row[7]}' data-toggle="modal" data-target="#mainModal"> ${row[4]} </a>`
            }},
            { orderable: false},
            null,
            null
        ],
      "ajax": {
            url : 'articles/articles_page/' + $value,
            type : 'GET'
        },
    });
    }

});



$(document).on('click', '.insert-scholar-id', function(e){
  e.preventDefault();

  var edit_id = $("input[type='radio']:checked").data('profId');
  var fieldname = 'scholarid';
  var fieldname1 = 'citation';
  var value = $("input[type='radio']:checked").val();
  var value1 = $("input[type='radio']:checked").data('citation');

    $.ajax({
        url: 'professors/updateProfessor/',
        method: 'POST',
        aynch: false,
        data: { field:fieldname, field1:fieldname1, value:value, value1:value1, id:edit_id },
      success: function(res)
        {
          if (!res || res.error)
          {
              return false;
          }

          if (res)
          {
            console.log('alert from insert scholar id');
          }

          $('#mainModal').modal('hide');
      },
    failure: function(res)
      {
         alert(value);
        console.log(res);
      }

  });
});



$(document).on('click','.edit',function(){
   // On text click
   $('.edit').click(function(){
      // Hide input element
      $('.txtedit').hide();

      // Show next input element
      $(this).next('.txtedit').show().focus();

      // Hide clicked element
      $(this).hide();
   });

   // Focus out from a textbox
   $('.txtedit').focusout(function(){
      // Get edit id, field name and value
      var edit_id = $(this).data('id');
      var fieldname = $(this).data('field');
      var value = $(this).val();

      // assign instance to element variable
      var element = this;

      // Send AJAX request
      $.ajax({
        url: 'professors/updateProfessor',
        type: 'post',
        data: { field:fieldname, value:value, id:edit_id },
        success:function(response){
          // Hide Input element
          $(element).hide();

          // Update viewing value and display it
          $(element).prev('.edit').show();
          $(element).prev('.edit').text(value);
          $(element).closest('td').find('.txtedit').attr("value",value);
        }
      });
    });
  });

$(document).on('click', '.remove-row', function(e){
        e.preventDefault();
        let prof_id = this.dataset.profId;
        let row = this.closest('.gradeA');
      $.ajax({
            url:'professors/deleteProfessor/' + prof_id,
            method:'POST',
            async: false,
            dataType: 'json',
            data:{
                prof_id : prof_id
            },
          success: function (res) {
             row.remove();
            },
          failure: function(err) {
                console.log(err);
            }
        });
    });

$(document).ready(function(){
  graphByYear();
  graphCurrentYear('2010');
  graphByMonth();
});


function graphByMonth()
{
  $.ajax({
    url: "articles/fetchByMonth",
    method: "GET",
    success: function(data) {
      //var obj = JSON.parse(data);
      var prof = ["june", "jule", "August", "September"];
      var count = [20, 50, 20, 10];


      // for(var i in obj) {   
      //   prof.push(obj[i].scholarid_professor);
      //   count.push(obj[i].num);
      // }

      var chartdata = {
        labels: prof,
        datasets : [
          {
            label: 'months count',
            backgroundColor: 'rgba(200, 200, 200, 0.75)',
            borderColor: 'rgba(200, 200, 200, 0.75)',
            hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
            hoverBorderColor: 'rgba(200, 200, 200, 1)',
            data: count
          }
        ]
      };

      var ctx = $("#chartByMonth");

      var pieGraph = new Chart(ctx, {
        type: 'bar',
        data: chartdata
      });
    },
    error: function(data) {
      console.log(data);
    }
  });
}




function graphCurrentYear(year)
{
  $.ajax({
    url: "articles/fetchByCurrentYear/"+ year,
    method: "GET",
    success: function(data) {
      if(data == 0){
        alert('den uparxoun dedomena')
        var prof = [];
      var count = [];
      }
      
      var obj = JSON.parse(data);
      var prof = [];
      var count = [];


      for(var i in obj) {   
        prof.push(obj[i].scholarid_professor);
        count.push(obj[i].num);
      }

      var chartdata = {
        labels: prof,
        datasets : [
          {
            label: 'year count',
            backgroundColor: ["#0074D9", "#FF4136", "#2ECC40", "#FF851B", "#7FDBFF", "#B10DC9", "#FFDC00", "#001f3f", "#39CCCC", "#01FF70", "#85144b", "#F012BE", "#3D9970", "#111111", "#AAAAAA"],
            borderColor: 'rgba(200, 200, 200, 0.75)',
            hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
            hoverBorderColor: 'rgba(200, 200, 200, 1)',
            data: count
          }
        ]
      };

      var ctx = $("#chartByProfCurrentYear");

      if(window.pieGraph != undefined){
        window.pieGraph.destroy();
      }


      window.pieGraph = new Chart(ctx, {
        type: 'pie',
        data: chartdata
      });
    },
    error: function(data) {
      console.log(data);
    }
  });
}


function graphByYear()
{
  $.ajax({
    url: "articles/fetchByYearsAnalytics",
    method: "GET",
    success: function(data) {
      var obj = JSON.parse(data);
      var year = [];
      var count = [];

      
      for(var i in obj) {   
        year.push(obj[i].year);
        count.push(obj[i].unique_years);
      }

      var chartdata = {
        labels: year,
        datasets : [
          {
            label: 'year count',
            backgroundColor: ['#5cc99a'],
            borderColor: 'rgba(200, 200, 200, 0.75)',
            hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
            hoverBorderColor: 'rgba(200, 200, 200, 1)',
            data: count
          }
        ]
      };

      var ctx = $("#chartByYear");

      if(window.bar != undefined){
        window.bar.destroy();

      }

      var barGraph = new Chart(ctx, {
        type: 'line',
        data: chartdata
      });
    },
    error: function(data) {
      console.log(data);
    }
  });
}
      

$(function(){
    $(document).on('click', 'a[data-toggle="modal"]', function(e) {
        e.preventDefault();
        let href = this.getAttribute('href');
        console.log(href);
        if (!href)
            return false;
        $('#mainModal .modal-content').load(href);
    })
})