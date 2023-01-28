@extends('layouts.admin_layout')

@section('title', 'Edit Expense')
@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <h4 class="page-title">Expense</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Edit Expense</a></li>
            </ol>

        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <h4 class="m-t-0 header-title">Edit Expense</h4>
                <hr>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>{{session('success')}}!</strong>
                    </div>
                @endif
                @if(session('failed'))
                    <div class="alert alert-danger alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>{{session('failed')}}!</strong>
                    </div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <div class="p-20">
                            <form class="form-horizontal" method="post" action="/expense/update"
                                  enctype="multipart/form-data">

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Expense Name</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="expense_name"
                                               value="{{$expense->expense_name}}">
                                        <input type="hidden" class="form-control" name="_token"
                                               value="{{csrf_token()}}">
                                        <input type="hidden" class="form-control" name="expense_id"
                                               value="{{$expense->expense_id}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Expense Amount</label>
                                    <div class="col-10">
                                        <input type="number" class="form-control" name="expense_amount"
                                               value="{{$expense->expense_amount}}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Expense Category</label>
                                    <div class="col-10">
                                        @if(isset($categories))

                                            @if(count($categories)<=0)
                                                <a href="/expense/category/create" class="btn btn-info">+ Add
                                                    Category First To Continue</a>
                                            @else
                                                <select name="expense_category_id" class="form-control"
                                                        class="required"
                                                        required="true">
                                                    @foreach( $categories as $cat)
                                                        <option value="{{ $cat->expense_category_id}}"
                                                                @if($cat->expense_category_id==$expense->expense_category_id) selected @endif>
                                                            {{ $cat->expense_category_name }}
                                                        </option>
                                                    @endforeach

                                                </select>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-2 col-form-label">Expense Description</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" name="expense_details"
                                               value="{{$expense->expense_details}}">
                                    </div>
                                </div>

                                <div class="form-group mb-0 justify-content-end row">
                                    <div class="col-10">
                                        <button type="submit" class="btn btn-info waves-effect waves-light">Save
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- end row -->

            </div> <!-- end card-box -->
        </div><!-- end col -->
    </div>
    <!-- end row -->

    {{--  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      <script>
          function readURL(input) {
              if (input.files && input.files[0]) {
                  var reader = new FileReader();

                  reader.onload = function (e) {
                      $('#blah').attr('src', e.target.result);
                  }

                  reader.readAsDataURL(input.files[0]);
              }
          }

          $("#img").change(function(){
              readURL(this);
          });
      </script>--}}
@endsection