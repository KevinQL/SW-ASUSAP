<script type="text/javascript">
    $(document).ready(function () {
        (function($) {
            $('#FiltrarContenido').keyup(function () {
                var ValorBusqueda = new RegExp($(this).val(), 'i');
                $('.BusquedaRapida tr').hide();
                $('.BusquedaRapida tr').filter(function () {
                    return ValorBusqueda.test($(this).text());
                }).show();
            })
        }(jQuery));
    });
</script>

<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles">
            <i class="zmdi zmdi-money-box zmdi-hc-fw"></i> Amortizar  <small>Servicio</small>
            <i class="zmdi zmdi-money-box zmdi-hc-fw"></i> Pagar  <small>Servicio</small></h1>
    </div>
<!--    <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
--></div>

<?php
require_once "./controllers/adminController.php";
$insAdmin=new adminController();

?>

<div class="container-fluid">

    <div class="container" onload="listar_as('');">
        <div class="tab-content">
            <div class="tab-pane active" id="tab_consultar">


                <div class="row form-horizontal">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-xs-4  text-right">
                                    <label for="buscar" class="control-label">Buscar:</label>
                                </div>
                                <div class="col-xs-4">
                                    <input  type="text" name="buscar" id="buscarAS" class="form-control" onkeyup="listar_as(this.value);" placeholder="Ingrese Cod. Suministro o Nombre / Calle"/>
                                </div>
                            </div>
                            <div class="form-group" id="datos-resultAS">
                                <div class="card my-4" id="containerAS">
                                </div>
                                <div id="listaAS"></div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">Buscar</span>
            </div>
            <input id="FiltrarContenido" type="text" class="form-control" placeholder="Ingrese Nombre de Alumno" aria-label="Alumno" aria-describedby="basic-addon1">
        </div>
        <div class="tab-pane fade active in" >
            <?php
            //$insAdmin->actualizarSliderController();
            $pagina=explode("/",$_GET['views']);
            echo $insAdmin->vistaAmortizarController($pagina[1],5);

            ?>


        </div>

    </div>
</div>

<!--<div class="container-fluid">

    <div class="row">
        <div class="col-xs-12 col-sm-12">
            <div class="col-xs-12 col-md-4 form-group">
                <input class="form-control" type="search" name="nameUser" placeholder="Buscar Suministro">
            </div>
            <div class="col-xs-12 col-md-4 form-group ">
                <button class="btn btn-success btn-raised btn-xs" name="nameUser">buscar</button>
            </div>

        </div>

        <div class="col-xs-12"
        <div class="tab-pane fade" id="list">
            <div class="table-responsive">
                <table class="table table-hover text-center">
                    <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Cod Suministro</th>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Año</th>
                        <th class="text-center">Mes</th>
                        <th class="text-center">Total</th>
                        <th class="text-center">Fl. pagar/Deuda</th>
                        <th class="text-center">Amortizar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>564</td>
                        <td>Carlos Alfaro</td>
                        <td>2019 </td>
                        <td>Octubre</td>
                        <td>48</td>
                        <td>25</td>
                        <td><a href="#!" class="btn btn-info btn-raised btn-xs">Amortizar</a></td>


                    </tr>
                    <tr>
                        <td>2</td>
                        <td>231</td>
                        <td>Claudia Rodriguez</td>
                        <td>2019 </td>
                        <td>Octubre</td>
                        <td>70</td>
                        <td>25</td>
                        <td><a href="#!" class="btn btn-info btn-raised btn-xs">Amortizar</a></td>

                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    </div>-->


</div>