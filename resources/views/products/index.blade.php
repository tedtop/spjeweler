<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{ csrf_token() }}">

        <title>Products</title>

        <!-- Styles -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <style>
            /*.col, div[class^="col-"] { border: 1px solid red; }*/
            .container { max-width: 900px; margin-top: 20px; }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Products</h1>
            @foreach ($products as $product)
                <div class="my-4 p-4 border">
                    <?php // <pre>{{ print_r($product) }}</pre> ?>
                    <p><b>Model:</b> {{ $product->model }}</p>
                    <img width="250" class="img-thumbnail" src="{{ $product->img_front }}" name="img_front">
                    <img width="250" class="img-thumbnail" src="{{ $product->img_side }}" name="img_side">
                    <img width="250" class="img-thumbnail" src="{{ $product->img_back }}" name="img_back">
                    <p><b>Stringray Options:</b> {{ $product->python_options }}</p>
                    <p><b>Python Options:</b> {{ $product->model }}</p>
                    <p><b>Base Price:</b> {{ $product->base_price }}</p>
                    <p><b>Metal Options</b> {{ $product->metal_options }}</p>
                    <p><b>Stone Options</b> {{ $product->stone_options }}</p>
                    <p><b>Notes</b> {{ $product->notes }}</p>                
                    <p><b>Created At:</b> <input type="text" value="{{ $product->created_at }}" readonly disabled></p>
                    <p><b>Updated At:</b> <input type="text" value="{{ $product->updated_at }}" readonly disabled></p>
                </div>
                <hr>
            @endforeach
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
    </body>
</html>
