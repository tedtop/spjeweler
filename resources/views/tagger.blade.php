<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}">

        <title>Tagger</title>

        <!-- Styles -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <style>
            /*.col, div[class^="col-"] { border: 1px solid red; }*/
            .container { max-width: 900px; }

            .tt-query {
                -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
                -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
                box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
            }

            .tt-hint {
                color: #999
            }

            .tt-menu {    /* used to be tt-dropdown-menu in older versions */
                width: 100%;
                margin-top: 4px;
                padding: 4px 0;
                background-color: #fff;
                border: 1px solid rgba(0, 0, 0, 0.2);
                -webkit-border-radius: 4px;
                -moz-border-radius: 4px;
                border-radius: 4px;
                -webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
                -moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
                box-shadow: 0 5px 10px rgba(0,0,0,.2);
            }

            .tt-suggestion {
                padding: 3px 20px;
                line-height: 24px;
            }

            .tt-suggestion.tt-cursor,.tt-suggestion:hover {
                color: #fff;
                background-color: #0097cf;
            }

            .tt-suggestion p {
                margin: 0;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row my-4">
                <div class="col text-center">
                    <img class="img-fluid" src="{{ $imgUrl }}">
                </div>
            </div>
            <div class="row my-4">
                <div class="col-8 offset-2">
                    <h4 id="tags" style="display:none;">Tags:&nbsp;</h4>
                </div>
            </div>
            <div class="row my-4">
                <div class="col-6 offset-2">
                    <form id="addTag" autocomplete="off">
                        <div class="form-row">
                            <div class="col">
                                <input id="newTag" type="text" class="form-control typeahead" placeholder="Add tag(s)">
                            </div>
                            <div class="col">
                                <input class="btn btn-success" type="submit" value="Add">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-2 text-right">
                    <form id="nextImage" action="{!! action('Tagger@next') !!}" method="POST">
                        @csrf

                        <input type="hidden" name="id" value="{{ $galleryId }}">
                        <input class="btn btn-danger" type="submit" value="Next">
                    </form>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
        <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
        </script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
        <script src="https://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.min.js"></script>
        <script type="text/javascript">
            let addTagPath = "{{ url('tagger/addTag') }}";
            let delTagPath = "{{ url('tagger/deleteTag') }}";

            $("#addTag").submit(function(event) {
                event.preventDefault();

                let newTag = $("#newTag").val();

                $.ajax({
                    url: addTagPath,
                    method: 'post',
                    data: {
                        galleryId: {{ $galleryId }},
                        newTag: newTag,
                    },
                    success: function (result) {
                        console.log(result);
                        $("#tags")
                            .show()
                            .append(
                                '<span class="badge badge-secondary">' + newTag +
                                `<button id="${result.last_insert_id}" class="delete-tag badge badge-pill badge-danger ml-2">X</button></span>\n`);
                        $("#newTag").val(null);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
            $("#tags").on('click', 'button.delete-tag', function(event) {
                $.ajax({
                    url: delTagPath,
                    method: 'delete',
                    data: {
                        id: event.target.id,
                    },
                    success: function (result) {
                        console.log(result);
                        $(event.target).parent().hide();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        </script>
        <script type="text/javascript">
            let typeaheadPath = "{{ url('tagger/autocomplete') }}";
            $('#addTag .typeahead').typeahead({
                    hint: true,
                    highlight: true,
                    minLength: 1
                },
                {
                    source: function (query, {}, process) {
                        return $.get(typeaheadPath, { query: query }, function (result) {
                            console.log(result);
                            return process(result);
                        });
                    }
                });
        </script>
    </body>
</html>
