<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script type="text/javascript">
        function imprimir() {
            if (window.print) {
                window.print();
            } else {
                alert("La función de impresion no esta soportada por su navegador.");
            }
        }
    </script>
</head>
<body onload="imprimir();">
    <h1>Respuesta</h1>
    @if(Session::get('xml')!=null)
    {{Session::get('xml')}}
    @endif
</body>
</html>