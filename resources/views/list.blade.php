<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajax todo list</title>
    
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/black-tie/jquery-ui.min.css



">

</head>
<body>
<br><br>
    <div class="container">
        <div class="row">
            <div class="col-lg-offset-3 col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                        <input type="text" class="form-control" name="searchItem" id="searchItem" placeholder="Search">
                        <br>
                    <h3 class="panel-title">Ajax todo list <a href="#" class="pull-right" id="addNew" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus" aria-hidden="true"></i></a></h3>
                </div>
                <div class="panel-body" id="items">
                <ul class="list-group">
                    @foreach ($items as $item)
                        <li class="list-group-item ourItem" >
                            <a href="" class="pull-right" data-toggle="modal" data-target="#myModal">
                            <button class="btn btn-success btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i></button></a>{{$item->item}}
                            <input type="hidden" id="itemId" value="{{$item->id}}"> 
                        </li>
                        
                        @endforeach
                    
                </ul>
                </div>
                </div>
            </div>
            
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="title">Add New Items</h4>
                    </div>
                    <div class="modal-body">
                        <p><input type="text" placeholder="write here" id="addItem" class="form-control"></p>
                        <input type="hidden" id="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" id="delete" style="display:none;" >Delete</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" style="display:none;" id="saveChanges">Save changes</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" id="AddButton">Add</button>
                    </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
        </div>
    </div>

    {{csrf_field()}}
<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
  <!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(document).ready(function(){
        $(document).on('click','.ourItem',function(event){
                var text = $(this).text();
                var id = $(this).find('#itemId').val();
                $('#title').text('Edit Item');
                var text = $.trim(text);
                $('#addItem').val(text);
                $('#delete').show('400');
                $('#saveChanges').show('400');
                $('#AddButton').hide('400');
                $('#id').val(id);
                console.log(text);
        });

        $(document).on('click','#addNew',function(event){
                $('#title').text('Add New Item');
                $('#addItem').val("");
                $('#delete').hide('400');
                $('#saveChanges').hide('400');
                $('#AddButton').show('400');    
            });
        
        $('#AddButton').click(function(event){
            var text = $('#addItem').val();
            if(text ==""){
                alert("please type anything for adding item");
            }
            else{
            $.post('list',{'text': text,'_token':$('input[name=_token]').val()}, function(data){
                console.log(data);
                $('#items').load(location.href + ' #items');
            });
            }
        });
        

        $('#delete').click(function(event){
            var id = $('#id').val();
            $.post('delete',{'id': id,'_token':$('input[name=_token]').val()}, function(data){
            console.log(data);
            $('#items').load(location.href + ' #items');
            });
        });

        $('#saveChanges').click(function(event){
            var id = $('#id').val();
            var value = $('#addItem').val();
            $.post('update',{'id': id,'value': value,'_token':$('input[name=_token]').val()}, function(data){
            console.log(data);
            $('#items').load(location.href + ' #items');
            });
        });

        $( function() {
            // var availableTags = [
            // "ActionScript",
            // "AppleScript",
            // "Asp",
            // "BASIC",
            // "C",
            // "C++",
            // "Clojure",
            // "COBOL",
            // "ColdFusion",
            // "Erlang",
            // "Fortran",
            // "Groovy",
            // "Haskell",
            // "Java",
            // "JavaScript",
            // "Lisp",
            // "Perl",
            // "PHP",
            // "Python",
            // "Ruby",
            // "Scala",
            // "Scheme"
            // ];
            $( "#searchItem" ).autocomplete({
            source: 'http://localhost/todolist/search'
            });
        } );
    });
    

   
</script>
</body>
</html>