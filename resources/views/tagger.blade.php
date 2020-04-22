<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tagger</title>

        <!-- Styles -->
        <link href="/css/app.css" rel="stylesheet">
        <style>
            /** { border: 1px solid red; }*/
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-10 offset-1 my-5 text-center">
                    <img class="img-fluid" src="{{ $imgUrl }}">
                </div>
            </div>
            <div class="row">
                <div class="col-6 offset-1">
                    <form>
                        <div class="form-row">
                            <div class="col-8">
                                <input type="text" class="form-control" placeholder="Add tag(s)">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-success">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-4 text-right">
                    <form action="{!! action('Tagger@next') !!}" method="POST">
                        @csrf

                        <input type="hidden" name="id" value="{{ $id }}">
                        <input class="btn btn-danger" type="submit" value="Next">
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
