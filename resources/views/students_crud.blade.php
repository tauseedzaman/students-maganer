<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>student mamager</title>
    <link rel="stylesheet" href="../resources/css/bootstrap.css">
    <link rel="stylesheet" href="../resources/css/w3.css">
    <script src="../resources/js/jquery.js"></script>
    <script src="../resources/js/bootstrap.js"></script>
</head>
<body class="bg-secondary text-white">
<div class="container">
    <div class="row">
        <div class="col ">
            <div class=" flex-column mx-auto modal p-4 text-danger" id="loading" style="margin-top: 200px;margin-left: 550px !important;"></div>
        </div>
    </div>
    <h1 class="text-capitalize text-info text-center py-2 ">Student Manager</h1>
        </div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <table class="w3-table-all w3-hoverable text-info">
                    <thead>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Roll No</th>
                    <th>Deportment </th>
                    <th>Action<button id="add" class="float-right ml-1 btn btn-success btn-outline-danger">Add</button>
                        <button id="clear_all" class="float-right btn btn-success btn-danger">Clear all</button></th>
                    </thead>
                    <tbody id="table_body">
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal w3-animate-zoom " id="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h4 class="modal-title text-info" id="label">Add Student</h4>
                        <button class="close" onclick="close_model()">X</button>
                    </div>
                    <div class="modal-body">
                        <form class="form">
                            @csrf
                            @method('POST')
                            <label for="name" class="text-info mt-3">Enter Name</label>
                            <input autocomplete="off" type="text" value="{{old('name')}}" name="name" id="name" class="form-control" placeholder="Enter Name">
                            <label for="rollno"  class="text-info mt-3">Enter Roll No</label>
                               <input type="text" autocomplete="off" name="rollno" id="rollno" value="{{old('rollno')}}" class="form-control" placeholder="Enter Roll No">
                            <label for="dep" class="text-info mt-3">select Deportment</label>
                            <select name="deportment"  id="dep" value="{{old('deportment')}}" class="form-control my-2" id="deporment" placeholder="select option">
                                <option value="">select deportment</option>
                                <option value="CS">Computer science</option>
                                <option value="Phx">Physics</option>
                                <option value="CHM">Chemistry</option>
                                <option value="BIO">Islamyat</option>
                                <option value="ENG">English</option>
                            </select>
                        </form>
        </div>
        <div class="modal-footer bg-light">
            <button type="button" class="btn btn-primary add save_btn" id="add_btn">Add</button>
            <button type="button" class="btn btn-warning" onclick="close_model()">Close</button>
        </div>
</div>
</div>
<script>
    //show model
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#add').click(function (){
            $('#modal').modal('show');
            $('#dep').val('');
        });
    });
    //add data
    $(document).on('click','#add_btn',function (){
        var name = $('#name').val(),
            rollno = $('#rollno').val(),
            dep = $('#dep').val();
        if (dep == '' || rollno == '' || name == ''){
            alert('please fill all fields');
            return false;
        }
        $.ajax({
            url:"{{url('students-store')}}",
            type:'post',
            data:{
                name : name,
                rollno : rollno,
                deportment : dep,
            },
            beforeSend:function (){
                $('#loading').addClass('spinner-border');
            },
            success:function (){
                $('#loading').removeClass('spinner-border');
                $('#modal').modal('hide');
                $('#dep').val('null');
                $('#name').val('');
                $('#rollno').val('');
                load_data();
            }
        })
    });
    //edit data
    $(document).on('click','#edit_btn',function(){
        var id = $(this).data('id');
        $.ajax({
            url:'{{url('students-edit')}}',
            type:'post',
            data:{
                id:id,
            },
            beforeSend:function (){
                $('#loading').addClass('spinner-border');
            },
            success:function(res){
                $('#loading').removeClass('spinner-border');
                $('.modal-title').attr('data-e_id',id);
                $('.save_btn').attr('id','update_btn');
                $('.save_btn').text('Update Record');
                $('.save_btn').val(id);
                $('.modal-title').text('Update Action');
                $('#modal').modal('show');
                $('#name').val(res.data.name);
                $('#rollno').val(res.data.rollno);
                $('#dep').val(res.data.deportment);

            }
        });
    });
    //update record
    $(document).on('click','#update_btn',function(){
        var name = $('#name').val();
        var deportment= $('#dep').val();
        var rollno= $('#rollno').val();
        var id = $(".save_btn").val();
        $.ajax({
            url:'{{url('students-update')}}',
            type:'post',
            data:{
                name:name,
                rollno:rollno,
                deportment:deportment,
                id:id,
            },
            beforeSend:function (){
                $('#loading').addClass('spinner-border');
            },
            success:function(res){
                $('#loading').removeClass('spinner-border');
                $('#modal').modal('hide');
                $('.save_btn').attr('id','add_btn');
                $('.save_btn').text('Add Record');
                $('.modal-title').text('Add Action');
                $('.save_btn').val('');
                $('#name').val('');
                $('#rollno').val('');
                $('#dep').val('null');
                load_data();
            }
        });
    });
    //delete data
    $(document).on('click','#delete_btn',function(){
        var id = $(this).data('id');
        if (confirm('Delete Record!')){
            $.ajax({
                url:"{{url('students-delete')}}",
                type:'post',
                data:{id:id},
                beforeSend:function (){
                    $('#loading').addClass('spinner-border');
                },
                success:function (a) {
                    $('#loading').removeClass('spinner-border');
                    load_data();
                }

            });
        }
    });
    //delete all data
    $(document).on('click','#clear_all',function(){
        if (confirm('Delete All Records!')){
            $.ajax({
                url:"{{url('students-delete-all')}}",
                type:'post',
                beforeSend:function (){
                    $('#loading').addClass('spinner-border');
                },
                success:function () {
                    $('#loading').removeClass('spinner-border');
                    load_data();
                }

            });
        }
    });
    //close model
    function close_model(){
        $('#modal').modal('hide');
        $('#dep').val('null');
        $('#name').val('select deportment');
        $('#rollno').val('');
    }
    //load data
    function load_data(){
        $.ajax({
            url:'{{url('students-loaddata')}}',
            type: 'get',
            beforeSend:function (){
                $('#loading').addClass('spinner-border');
            },
            success:function (e){
                $('#loading').removeClass('spinner-border');
                $('#table_body').empty().append(e);
            }
        });
    }
    load_data();

</script>;
</body>
</html>
