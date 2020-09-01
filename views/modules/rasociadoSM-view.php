

<style>
    <?php
                       require_once "./controllers/adminController.php";
                       $obj = new adminController();
                       $arrDirec = $obj->obtenerDireccionCalleController("");
                       $htmlDirecciones = "";
                       foreach ($arrDirec as $direccion) {
                           # code...
                           $htmlDirecciones .= "<option>{$direccion['nombre']}</option>";
                       }
                       ?>
    .box
    {
        width:1270px;
        padding:20px;
        background-color:#fff;
        border:1px solid #ccc;
        border-radius:5px;
        margin-top:25px;
    }
    .dataTables_info{
        display: none;
    }
</style>

<div class="container-fluid">
    <div class="page-header">
<!--        <h1 class="text-titles"><i class="zmdi zmdi-money-box zmdi-hc-fw"></i> Registrar <small>Servicio</small></h1>
-->    </div>
    <!--    <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Esse voluptas reiciendis tempora voluptatum eius porro ipsa quae voluptates officiis sapiente sunt dolorem, velit quos a qui nobis sed, dignissimos possimus!</p>
    --></div>


<div class="container box">
    <h1 align="center">REPORTE DE SUMINISTROS</h1>

    <div class="justify-content-between ">
        <p class="text-right text-al justify-content-between align-items-center">
            <button type="submit"  class="btn btn-danger btn-raised btn-sm" onclick="ImpAso();"><i class="zmdi zmdi-floppy"></i> IMPRIMIR</button>
        </p>
    </div>
    <br />
    <div class="table-responsive">
        <br />
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="col-md-3 form-group row label-floating">
                    <div class="col-md-12">
                        <label for="direccionAsoc" class="col-md-4 control-label">DIRECIÓN</label>
                        <select class="form-control" id="direccionAsoc" name="direccionAsoc">
                            <option>TODOS</option>
                            <?=$htmlDirecciones?>
                        </select>
                    </div>

                </div>
                <div class="col-md-3 form-group row label-floating">
                    <div class="col-md-12">
                        <label for="direccionAsoc" class="col-md-4 control-label">ESTADO</label>
                        <?php
                       // $indexEstado = $suministro['estado_corte'];
                        $arrEstado = [0=>'ACTIVO',2=>'INACTIVO',3=>'TODOS'];
                        ?>
                        <select class="" id="ESTADO">
                            <?php
                            //echo "<option value='TODOS' selected>TODOS</option>";
                            foreach ($arrEstado as $key => $value) {
                                # code...
                                //   if($key == $indexEstado){
                                    echo "<option value='{$key}' selected>{$value}</option>";
                                    continue;
                              //  }
                                //echo "<option value='{$key}'>{$value}</option>";
                            }
                            ?>

                        </select>
                    </div>

                </div>
                <div class="col-md-3 form-group label-floating">
                    <label for="categoriaAsoc" class="col-md-4 control-label">CATEGORIA</label>
                    <div class="col-md-12">
                        <select class="form-control" id="categoriaAsoc" name="categoriaAsoc">
                            <option>Todos</option>
                            <option>Domestico</option>
                            <option>Comercial</option>
                            <option>Estatal</option>
                            <option>Industrial</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 form-group label-floating">
                    <label for="categoriaAsoc" class="col-md-4 control-label">MEDIDOR</label>
                    <div class="col-md-12">
                        <select class="form-control" id="medidorAsoc" name="categoriaAsoc">
                            <option >Todos</option>
                            <option >C Medidor</option>
                            <option >S Medidor</option>

                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="button" name="search" id="search" value="Search" class="btn btn-success btn-raised btn-sm" />
                </div>
            </div>


        </div>

        </div>
        <br />
        <table id="order_data" class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>SUMINISTRO</th>
                <th>APELLIDO Y NOMBRE</th>
                <th>DNI</th>
                <th>DIRECCION</th>
                <th>C. SUMINISTRO</th>
                <th>Medidor</th>
            </tr>
            </thead>
        </table>

    </div>
</div>





<script type="text/javascript" language="javascript" >
    $(document).ready(function(){

       /* $('.input-daterange').datepicker({
            todayBtn:'linked',
            format: "yyyy-mm-dd",
            autoclose: true
        });*/

        fetch_data('no');

        function fetch_data(is_date_search, start_date='',estad,catA,MdAsoc){
            var dataTable = $('#order_data').DataTable({
                "language":{
                    "lengthMenu":"Mostrar _MENU_ registros por página.",
                    "zeroRecords": "Lo sentimos. No se encontraron registros.",
                  "info": "Total de _MAX_ registros",
                  //"info": "Mostrando página _PAGE_ de _PAGES_ filtrados de un total de _MAX_ registros",
                    "infoEmpty": "No hay registros aún.",
                    "infoFiltered": "( _MAX_ registros)",
                    //"infoFiltered": "(filtrados de un total de _MAX_ registros)",
                    "search" : "Búsqueda",
                    "LoadingRecords": "Cargando ...",
                    "Processing": "Procesando...",
                   // "SearchPlaceholder": "Comience a teclear...",
                    "paginate": {
                        "previous": "Anterior",
                        "next": "Siguiente",
                    }
                },

                "processing" : true,
                "serverSide" : true,
                "order" : [],
                "ajax" : {
                    url:"../ajax/reportesAsociados.php",
                    type:"POST",
                    data:{
                        is_date_search:is_date_search , start_date:start_date ,estad:estad,catA:catA,MdAsoc:MdAsoc
                    }
                }
            });
        }

        $('#search').click(function(){
            //var start_date = $('#start_date').val();

            var start_date = document.querySelector("#direccionAsoc").value;
            var estad = document.querySelector("#ESTADO").value;
            var catA = document.querySelector("#categoriaAsoc").value;
            var MdAsoc = document.querySelector("#medidorAsoc").value;

            console.log("estddo: "+estad+" la categoria es:"+catA+" Medidor: "+MdAsoc)
          //  console.log('la direccion'+direccion);

          //  var end_date = $('#end_date').val();
            if(start_date != '')
            {
                $('#order_data').DataTable().destroy();
               fetch_data('yes', start_date,estad,catA,MdAsoc);
            }
            else
            {
                alert("Both Date is Required");
            }

        });

    });
</script>

