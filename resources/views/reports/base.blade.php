<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <style>
            body {
                font-family: sans-serif;
                font-size: .9em;
            }
            h1, h2, th {
                text-align: center
            }

            table {
                margin-bottom: 3em;
                border-collapse: collapse;
            }
            caption {
                font-size: 1.5em;
                font-weight: bold;
                margin-bottom: .5em;
            }
            td, th {
                padding: .1em .4em;
                border: solid #000 1px;
            }
            th {
                background-color: dimgray;
                color: #FFF;
            }
        </style>
    </head>
    <body>
        <h1>{{$title}}</h1>
        @yield('content')
    </body>
</html>