<div class="container-fluid">
    <div class="page-header">
        <h1 class="text-titles"><i class="zmdi zmdi-money-box zmdi-hc-fw"></i> Registrar <small>Servicio</small></h1>
    </div>
    <!--    <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
    --></div>

<div class="container-fluid">

    <div class="container">


        <div class="tab-content" id="contTRSSS">
            <div class="tab-pane active" id="tab_consultar">
                <div class="row form-horizontal" >
                    <div class="panel panel-default">

                        <div class="panel-body">
                            <div class="form-group">
                                <div class="col-xs-4  text-right">
                                    <label for="buscar" class="control-label">Buscar:</label>
                                </div>
                                <div class="col-xs-4">
                                    <input  type="text" name="buscar" id="buscarRS" class="form-control text-uppercase" onkeyup="listar_rs(this.value);" placeholder="Ingrese Cod. Suministro o Nombre / Calle"/>
                                </div>
                            </div>
                            <div class="form-group" id="datos-result" style="display: none;">
                                <div class="card my-4" id="containerRS">
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!--LOS DATOS DE SERVICIO-->
        <?php
        require_once "./controllers/adminController.php";
        //$insAdmin=new GestorSlidersC();
        $insAdmin=new adminController();

        ?>

        <div class="container-fluid" id="add-all" style="display: none;">
            <div class="row" >

ids
                <div class="col-lg-12 col-md-8 col-sm-8 col-xs-8 rs-asusap" style="background: rgba(25,25,25,.1);" id="cuadro">

                    <div class="col-xs-12 col-sm-12">
                        <label class="text-danger" name="nameUser">N. servicio <p id="idrs">1</p></label>
                    </div>
                    <div class="col-xs-12 col-sm-12">
                        <div class="col-xs-12 col-md-6 ">
                            <label for="staticEmail2">Servicio:</label>
                            <div class="form-group mx-sm-3 mb-3">

                                <select class="form-control"  id="servicio" name="servicios" >                                    
                                    <?php
                                    echo $insAdmin->SelectorS();
                                    ?>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-12 col-sm-12">

                        <div class="col-xs-12 col-md-6 ">
                            <div id="ids">**</div>
                            <h3 class="tile-titles text-left font-weight-bold"class="text-titles" ><b> Nombre: </b><small id="nombreSR">Ana</small></h3>
                        </div>
                        <div class="col-xs-12 col-md-6 ">
                            <h3 class="tile-titles text-left font-weight-bold"><b> Apellido: </b><small id="apellSR">Vargas Huaman</small></h3>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12" id="cuadro1">
                        <div class="col-xs-12 col-md-6 " id="cuadro12">
                            <h3 class="tile-titles text-left font-weight-bold" ><b> Cod. Suministro: </b><small id="codSR">254</small></h3>
                        </div>
                        <div class="col-xs-12 col-md-6 ">
                            <h3 class="tile-titles text-left font-weight-bold"><b> Direccion: </b><small id="direRS"></small></h3>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12">
                        <div class="col-xs-12 col-md-3 ">
                            <h3 class="tile-titles text-left font-weight-bold"><b>Año:</b> <small id="anioRS">2019</small></h3>
                        </div>
                        <div class="col-xs-12 col-md-3 ">
                            <h3 class="tile-titles text-left font-weight-bold"><b>Mes: </b><small id="mesRS">Octubre</small></h3>
                        </div>
                        <div class="col-xs-12 col-md-6 ">
                            <h3 class="tile-titles text-left font-weight-bold"><b>A nombre de: </b><small><input type="text" name="anombre" m  id="anombre"></small></h3>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12">
                        <div class="col-xs-12 col-md-6 ">

                            <h3 class="tile-titles text-left font-weight-bold"><b>Detalles</b></h3>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12">
                        <div class="row">

                            <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
                                <form action="" method="post" enctype="multipart/form-data" autocomplete="off">
                                    <div class="col-xs-12 col-sm-12">

                                        <div class="col-xs-6 col-md-9 form-group label-floating ">

                                            <label class="staticEmail2">Nombre - Descripcion</label>
                                            <input class="form-control" type="text" name="nombreDesc" required id="NomDes">

                                        </div>
                                        <div class="col-xs-6 col-md-3 form-group label-floating ">
                                            <label class="staticEmail2">Costo</label>
                                            <input class="form-control" type="number" name="Costo" id="Costo" required>
                                        </div>
                                    </div>
                                    <!-- <ul class="actions" style="text-align: center">
                                         <li><input type="button" value="Agregar" class="principal" id="add_row" onclick="newRowTable();"/></li>
                                     </ul>-->
                                    <button  type="reset"  class="btn btn-success btn-raised btn-sm  align-items-center" id="bt_add" >
                                        Agregar Item
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>





                    <div class="col-xs-12">
                    <div class="tab-pane fade" id="list">

                        <?php


                        //$pagina=explode("/",$_GET['action']);
                        //echo $insAdmin->viewsRS();


                        ?>

                        <div class="table-responsive">

                            <div id="content">

                                <!--                                           <button id="bt_add" class="btn btn-default" onclick="agregar();">Agregar</button>
                                -->                                          <p class="text-right">
                                    <label>Eliminar todo las filas AGREGADOS / Nº/Descripción/Precio</label>
                                    <button  type="reset"  class="btn btn-danger btn-raised btn-sm  align-items-center" id="bt_del" >
                                        Eliminar Todo
                                    </button>
                                </p>
                                <!--<button id="bt_delall" class="btn btn-default" onclick="eliminarTodasFilas();" >Eliminar todo</button>-->
                                <table id="tabla" class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <td>Nº</td>
                                        <td>Descripción</td>
                                        <td>Precio</td>
                                    </tr>
                                    </thead>
                                </table>
                            </div>


                        </div>

                    </div>
                    <div class="col-xs-12 col-sm-12">



                        <div class="col-xs-12 col-sm-12">

                            <p class="text-center">
                            <h3 class="tile-titles text-left font-weight-bold">
                                <b> Total: </b><small id="costTotal">00.00</small>
                            </h3>
                            </p>

                        </div>
                    </div>

                    <p class="text-center">


                        <button type="submit"  class="btn btn-danger btn-raised btn-sm" onclick="ImprimerRecibo();"><i class="zmdi zmdi-floppy"></i> IMPRIMIR</button>
                        <button type="submit"  class="btn btn-info btn-raised btn-sm pull-right" id="guardar" onclick="guardarTodo();"><i class="zmdi zmdi-floppy"></i> GUARDAR</button>

                    </p>
                </div>


            </div>
        </div>
    </div>
</div>
</div>



</div>


