<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laravel 6 Ajax CRUD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Laravel 6 Ajax CRUD</h1>
        <a href="javascript:void(0)" class="btn btn-success" id="createNewBook">Add New Book</a>
        <table class="table table-bordered data-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

    <div class="modal fade" id="ajaxModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="ModelHeading"></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="bookForm" name="bookForm" class="form-horizontal">
                  <input type="hidden" name="id" id="id">
                  <div class="form-group">
                      <label for="name">Enter Name</label>
                      <input type="text" name="name" id="name" class="form-control" placeholder="Enter Your Title">
                  </div>
                  <div class="form-group">
                      <label for="author">Enter Author</label>
                      <input type="text" name="author" id="author" class="form-control" placeholder="Enter Your Author">
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save Changes</button>
                  </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/dataTables.bootstrap4.min.js"></script>

      <script type="text/javascript">
            $(function() {
                $.ajaxSetup({
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                var table = $('.data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('books.index') }}",
                    columns: [
                        {data: 'name', name: 'name'},
                        {data: 'author', name: 'author'},
                        {data: 'action', name:'action', orderable: false, searchable: false}
                    ]
                });

                $('#createNewBook').click(function(){
                    $('#saveBtn').val('Create Book');
                    $('#id').val('');
                    $('#bookForm').trigger("reset");
                    $('#ModelHeading').html("Create New Book");
                    $('#ajaxModel').modal('show');
                });

                $('body').on('click','.editBook',function(){
                    var book_id = $(this).data('id');
                    $.get("{{ route('books.edit') }}"+ '/' + book_id , function(data){
                        $('#ModelHeading').html("Edit Book");
                        $('#saveBtn').val("edit-book");
                        $('#ajaxModel').modal('show');
                        $('#id').val(data.id);
                        $('#name').val(data.name);
                        $('#author').val(data.author);
                    });                    
                });

                $('#saveBtn').click(function(e){
                    e.preventDefault();
                    $(this).html('Save');

                    $.ajax({
                        data: $('#bookForm').serialize(),
                        url: "{{ route('books.store') }}",
                        type: "POST",
                        dataType: 'json',
                        success: function(data){
                            $('#bookForm').trigger("reset");
                            $('#ajaxModel').modal('hide');
                            table.draw();
                        },
                        error: function(data){
                            console.log('Error:', data);
                            $('#saveBtn').html('Save Changes');
                        }
                    });

                });


                $('body').on('click','.deleteBook', function(){
                    var book_id = $(this).data("id");
                    confirm("Are You Sure?");

                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('books.delete') }}"+'/'+book_id,
                        success: function(data){
                            table.draw(data);
                        },
                        error: function(data){
                            console.log('Error:', data);
                        }
                    }); 
                });

            });
      </script>

</body>
</html>