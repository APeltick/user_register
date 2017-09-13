
$('#register').bootstrapValidator({
  excluded: ':disabled',
  message: 'This value is not valid',
  feedbackIcons: {
    valid: 'glyphicon glyphicon-ok',
    validating: 'glyphicon glyphicon-refresh'
  },
  fields: {
    name: {
      message: 'The username is not valid',
      validators: {
        notEmpty: {
          message: 'The username can not be empty'
        },
        stringLength: {
          min: 10,
          max: 30,
          message: 'The username must be more than 10 and less than 30 characters long'
        },
        regexp: {
          regexp: /^[А-Яа-яa-zA-Z0-9_ ]+$/,
          message: 'The username can only consist of alphabetical, number and underscore'
        }
      }
    },
    email: {
      validators: {
        notEmpty: {
          message: 'The email is required and cannot be empty'
        },
        emailAddress: {
          message: 'The input is not a valid email address'
        },
        regexp: {
          regexp: /\b[a-z0-9_.]+\@+[a-z]+\.+[a-z]{2,4}\b/,
          message: 'Invalid email address'
        }
      }
    },
    reg_id: {
      validators: {
        notEmpty: {
          message: 'The region can not be empty'
        }
      }
    }
  }
}).on('success.form.bv', function(e) {
  e.preventDefault();
  var $form = $(e.target);
  var bv = $form.data('bootstrapValidator');

  var data = $(this).serialize();
  data += '&action=save';
  $.ajax({
    type: 'POST',
    url: 'index.php',
    dataType: 'json',
    data: data,
    success: function (name) {
      if (name['email'] === 'true') {
        $('#modal').addClass('in').attr({"style":"display: block;"});
        $('#modal-body').html(name['data']);
      }
      if (name['email'] === 'false') {
        $('#status').html(name['data']);
      }
    }
  });
  return false;
});

$('.chosen-select').chosen({width: "100%"});

$('#inputRegions').on('change', function () {
  $.ajax({
    type: 'POST',
    url: 'index.php',
    dataType: 'json',
    data:  {ter_id: $(this).val(), action: 'load'},
    success: function (name) {
      if (name['type'] === 'area') {
        $('#areas').attr({"style":"display: block;"});
        $('#inputAreas').html(name['data']).trigger("chosen:updated");
      } else {
        $('#cities').attr({"style":"display: block;"});
        $('#inputCities').html(name['data']).trigger("chosen:updated");
      }
    }
  });
});

$('#inputCities').on('change', function () {
  $.ajax({
    type: 'POST',
    url: 'index.php',
    dataType: 'json',
    data:  {ter_id: $(this).val(), action: 'load'},
    success: function (name) {
      $('#areas').attr({"style":"display: block;"});
      $('#inputAreas').html(name['data']).trigger("chosen:updated");
    }
  });
});

$('.close').on('click', function () {
  $('#modal').removeClass('in').attr({"style":"display: none;"});
});