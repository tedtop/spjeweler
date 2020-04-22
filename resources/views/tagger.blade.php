<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{csrf_token()}}">

        <title>Tagger</title>

        <!-- Styles -->
        <link href="{{asset('css/app.css')}}" rel="stylesheet" type="text/css">
        <style>
            /** { border: 1px solid red; }*/
            .container { max-width: 900px; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row my-4">
                <div class="col-10 offset-1 text-center">
                    <img class="img-fluid" src="{{ $imgUrl }}">
                </div>
            </div>
            <div class="row my-4">
                <div class="col-10 offset-1">
                    <h4 id="tags" style="display:none;">Tags:&nbsp;</h4>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-6 offset-1">
                    <form id="addTag">
                        <div class="form-row">
                            <div class="col-8">
                                <input id="newTag" type="text" class="form-control" placeholder="Add tag(s)">
                            </div>
                            <div class="col">
                                <input class="btn btn-success" type="submit" value="Add">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-4 text-right">
                    <form id="nextImage" action="{!! action('Tagger@next') !!}" method="POST">
                        @csrf

                        <input type="hidden" name="id" value="{{ $id }}">
                        <input class="btn btn-danger" type="submit" value="Next">
                    </form>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="{{asset('js/app.js')}}"></script>
        <script>
            $("#addTag").submit(function(event) {
                event.preventDefault();

                let newTag = $("#newTag").val();

                jQuery.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "{{ url('tagger/addTag') }}",
                    method: 'post',
                    data: {
                        galleryId: {{ $id }},
                        newTag: newTag,
                    },
                    success: function (result) {
                        console.log(result);
                        $("#tags").show().append(`<span class="badge badge-secondary">${newTag}</span>\n`);
                        $("#newTag").val(null);
                    }
                });
            });
        </script>
    </body>
</html>
