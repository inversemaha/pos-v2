@extends('layouts.app')

@section('content')

    <div class="col-10 mx-auto" style="padding-top: 20px">
        <div class="card">
            <div class="card-body">
                <form class="form-horizontal" method="post" action="/sms/send"
                      enctype="multipart/form-data">

                    <div class="form-group row">
                        <div class="col-4">
                            <label for="email">Upload CSV:</label>
                        </div>
                        <div class="col-8">
                            <input type="file" class="form-control" id="file" name="file" required/>
                            <input class="form-control" type="hidden" value="{{csrf_token()}}" name="_token" >
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-4">
                            <label for="email">Message</label>
                        </div>
                        <div class="col-8">
                            <textarea class="form-control" id="message" name="message" required></textarea>

                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-4">
                        </div>
                        <div class="col-8">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>


                </form>
            </div>

        </div>

    </div>

@endsection