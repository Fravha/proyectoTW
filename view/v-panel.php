<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Creative Spot - Panel Principal</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, Helvetica, sans-serif;
        }

        body{
            background:#f4f6f9;
        }

        .contenedor{
            width:100%;
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            padding:30px;
        }

        .panel{
            width:100%;
            max-width:900px;
            background:#ffffff;
            border-radius:10px;
            padding:30px;
            box-shadow:0px 0px 10px rgba(0,0,0,0.1);
        }

        .titulo{
            text-align:center;
            margin-bottom:30px;
        }

        .titulo h1{
            color:#222;
            margin-bottom:10px;
        }

        .titulo p{
            color:#777;
        }

        .modulo{
            margin-bottom:30px;
        }

        .modulo h2{
            margin-bottom:15px;
            color:#444;
            border-bottom:2px solid #eaeaea;
            padding-bottom:10px;
        }

        .menu-grid{
            display:grid;
            grid-template-columns:repeat(auto-fit, minmax(200px,1fr));
            gap:15px;
        }

        .menu-item{
            display:flex;
            justify-content:center;
            align-items:center;
            text-decoration:none;
            background:#2d89ef;
            color:white;
            height:80px;
            border-radius:8px;
            font-size:18px;
            transition:0.3s;
        }

        .menu-item:hover{
            background:#1b5fa7;
            transform:scale(1.03);
        }

        .reporte{
            background:#00a65a;
        }

        .reporte:hover{
            background:#007d43;
        }

    </style>
</head>

<body>

    <div class="contenedor">

        <div class="panel">

            <div class="titulo">
                <h1>Sistema Creative Spot</h1>
                <p>Panel principal del sistema</p>
            </div>

            <!-- MODULO MAESTRO -->
            <div class="modulo">

                <h2>Maestro</h2>

                <div class="menu-grid">

                    <a class="menu-item" href="control/c-productos.php">
                        Productos
                    </a>

                    <a class="menu-item" href="#">
                        Trabajadores
                    </a>

                    <a class="menu-item" href="#">
                        Clientes
                    </a>

                    <a class="menu-item" href="#">
                        Ventas / Delivery
                    </a>

                </div>

            </div>

            <!-- MODULO REPORTES -->
            <div class="modulo">

                <h2>Reportes</h2>

                <div class="menu-grid">

                    <a class="menu-item reporte" href="c-reporte1.php">
                        Ventas y Delivery
                    </a>

                    <a class="menu-item reporte" href="c-reporte2.php">
                        Ventas por Trabajador
                    </a>

                </div>

            </div>

        </div>

    </div>

</body>
</html>