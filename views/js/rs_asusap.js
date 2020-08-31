    id_fila_selected=[];
    conts=0;
    costoTot=0;
    costoTot1=0;
 seleccionServicio();
 function seleccionServicio() {
     var select = document.getElementById('servicio');
     if (select){
        select.addEventListener('click',
            function(){
                var selectedOption = this.options[select.selectedIndex];
                console.log(selectedOption.value + ': ' + selectedOption.text);
                document.getElementById("NomDes").value=selectedOption.text;

            }
        );

        $('#bt_add').click(function(){
            //se agrega los items seleccionados a la tabla y agrega en la db
            //tambien realiza la validacion de datos: descripcion y costo
            let valid = agregar();
            if(valid){
                //Se agrega input que permite realizar la impresion
                var selectedOption = select.options[select.selectedIndex];
                var fila=`<input type="hidden" id="servS" value="${selectedOption.text}">`;
                $('#ids').html(fila);
            }
        });

        $('#bt_del').click(function(){
            //elimina la validación para la impresion
            $('#ids').html("");
            //elimina los items de la tabla y limpia db
            eliminar(id_fila_selected);
        });

     }

 }


/*------------------AGRAGAR ITEMS  DEL RECIBO---------------------------------*/



function agregar(){

    // let codsu=document.getElementById("codSR").innerHTML  ;
    let idrs=document.getElementById("idrs").innerHTML

    var nomd=$("#NomDes").val();
    var cost1=$("#Costo").val();
    let cost= Number.parseFloat(cost1).toFixed(2);

    if (nomd.trim().length == 0 || isNaN(cost)){
        swal({
            title: "Campos vacios",
            type: "info",
            confirmButtonColor: '#03A9F4',
            confirmButtonText: '<i class="zmdi zmdi-run"></i> Aceptar',
            cancelButtonColor: '#F44336'
        })
        return false;
        
    }
    
    conts++;
    //alert("FALTA AGREGAR ITEMS")
    $.ajax({
        url:"../ajax/agregarRS.php",
        type:'POST',
        // data:'ids='+idf+'&monto='+cost,
        data:'NomD='+nomd+'&costD='+cost+'&CodRS='+idrs,
        success:function (resp) {
            // alert('respuesta'+resp);
        }

    });

    //console.log("has echo click"+cont+nomd)
    var fila='<tr class="selected" id="fila'+conts+'" ><td>'+conts+'</td><td>'+nomd+'</td><td>'+cost+'</td></tr>';
    $('#tabla').append(fila);

    costoTot=costoTot+parseFloat(cost);

    costoTot1= Number.parseFloat(costoTot).toFixed(2);

    document.getElementById("costTotal").innerHTML=costoTot1;

    return true;
}


function eliminar(id_fila){
    conts=0
    costoTot=0;
    document.getElementById("costTotal").innerHTML=costoTot;
    var myTable = document.getElementById("tabla");
    var rowCount = myTable.rows.length;
    for (var x=rowCount-1; x>0; x--) {
        myTable.deleteRow(x);

    }
    let idf=document.getElementById("idrs").innerHTML ;
    $.ajax({
        url:"../ajax/agregarRS.php",
        type:'POST',
        // data:'ids='+idf+'&monto='+cost,
        data: "idsF="+idf,
        success:function (resp) {

            console.log("has echo click en borrar todo los items"+resp)
            // $('#add-all').hide();
        }

    });




}

/*------------------------AL GUARDAR TODO ACTUALIZADO -----------------------------------------------*/
num1=0;
function guardarTodo(){
    let validarImpresion = document.querySelector("#servS");
    if(validarImpresion){

        /* Agregando todo los datos */
        let idf=document.getElementById("idrs").innerHTML ;
        let  nsu = document.getElementById("nombreSR").innerHTML ;
        let  asu = document.getElementById("apellSR").innerHTML  ;
        let codsu=document.getElementById("codSR").innerHTML  ;
        let anirs=  document.getElementById("anioRS").innerHTML;
        let mesrs=document.getElementById("mesRS").innerHTML  ;
        let cost=document.getElementById("costTotal").innerHTML  ;
        let anrs=document.getElementById("anombre").value;
        //$cost1 = Number(cost.toFixed(1));
        // cost = cost.replace(",",".");
        // precioto = Number(cost.toFixed(2));// determinanod la cantidad de decimales.
        // let tot= precioto ;
        tot= Number.parseFloat(cost).toFixed(2);

        console.log("Has echo click en guardar"+tot+"a nombre"+anrs)

        /*############fin###############*/
        // console.log(idf+codsu+anirs+mesrs+anrs);

        var miArray=new Array()
        var i=0
        var tabla = document.getElementById("tabla");
        var total=tabla.rows.length

        if (tot!=0){
            $.ajax({
                url:"../ajax/agregarRS.php",
                type:'POST',
                // data:'ids='+idf+'&monto='+cost,
                data: "ids="+idf+"&cost="+tot+"&anom="+anrs,
                success:function (resp) {


                    // $('#add-all').hide();
                }

            });

            window.location="http://localhost/SW-ASUSAP/aservicio/";
        }

    }else{
        console.log("Sin acción")
        alert("No seas mamon ps")
    }

}
/*----------------cuando seleccionas de id  EN LA BUSQUEDA---------------------------------------*/
function showRow(row) {

    let x=row.cells;
    // console.log(x[1]);

    //document.getElementById("idrs").innerHTML = x[0].innerHTML;
    let  n = document.getElementById("nombreSR").innerHTML = x[1].innerHTML;
    let  a = document.getElementById("apellSR").innerHTML  = x[2].innerHTML;
    let cod=document.getElementById("codSR").innerHTML  = x[3].innerHTML;
    let dr=document.getElementById("direRS").innerHTML  = x[4].innerHTML;
    let an=document.getElementById("anioRS").innerHTML  = x[5].innerHTML;
    let mes=document.getElementById("mesRS").innerHTML  = x[6].innerHTML;
    let aname=document.getElementById("anombre").value  = n+" "+a;

    $("#add-all").show();


    swal({
        title: "¿Ejecutar esta acción?",
        text: "seguro??",
        type: "info",
        confirmButtonColor: '#03A9F4',
        confirmButtonText: '<i class="zmdi zmdi-run"></i> Aceptar',
        showCancelButton: true,
        cancelButtonColor: '#F44336',
        cancelButtonText: '<i class="zmdi zmdi-close-circle"></i> Cancel'
    }).then(()=>{
        $.ajax({
            url:"../ajax/agregarRS.php",
            type:'POST',
            // data:'ids='+idf+'&monto='+cost,
            data: "aNom="+aname+"&aNio="+a+"&aMes="+mes+"&aCod="+cod,
            beforeSend:function(){},
            success:function (resp) {

                let valores = JSON.parse(resp);
                htmlSumi= document.getElementById("idrs").innerHTML=`${valores}`;

                // alert(htmlSumi);
                // $('#add-all').hide();
            }

        });
        //Cuando le da aceptar
      //  console.log("le dio aceptar");
        $("#contTRSSS").hide();
    },function(){
        //si no le da a la opcion de aceptar
      //  console.log("No le dió aceptar")
        $("#contTRSSS").show();
    });

    //let tot=document.getElementById("codSR").val;


    // var g=[cod];
    //console.log(tot)
    //  return g;
    //document.getElementById("codSR").value = x[2].innerHTML;
}
/*---------------lista al momento hacer la busqueda-------------------*/
function listar_rs(valor) {
    console.log(valor)
    if ($('#buscarRS').val()){
        $('#datos-result').show();
        $.ajax({
            url:"../ajax/buscarRS.php",
            type:'POST',
            data:'valor='+valor.trim(),
            success:function (resp) {
                let valores = JSON.parse(resp);
                // console.log(valores);
                // return 0;
                htmlSumi=`<table class='table table-bordered'><thead><tr><th>#</th><th>Nombre AS.</th><th>Apellido AS.</th><th>Suministro</th><th>Direccion</th><th>año</th><th>mes</th><th>Seleccionar </th></tr></thead><tbody>`;
                for(let i=0;i<valores.length;i++){

                    htmlSumi += `
						<tr onclick="showRow(this);">
							<td>${i+1}</td>
							<td>${valores[i]["nombreAS"]}</td>
							<td>${valores[i]["apellidoAS"]}</td>
							<td>${valores[i]["codSum"]}</td>
							<td>${valores[i]["direSR"]}</td>
							<td>${valores[i]["anio"]}</td>
							<td>${valores[i]["mes"]}</td>
                            <td><a href="#!" class="btn btn-info btn-raised btn-xs">Seleccionar</a></td>
					
						</tr>	
					`;
                }
                htmlSumi+=`</tbody></table>`
                $("#containerRS").html(htmlSumi);
                // $('#add-all').hide();
            }

        });
    }else {
        $('#datos-result').hide();
        $('#add-all').hide();
    }

}


function ImprimerRecibo() {
    a=Array();
    to=Array();
    co=Array();

    console.log("has echo click en imprimir")
    let idfRSi=document.getElementById("idrs").innerHTML ;

    let  nsu = document.getElementById("nombreSR").innerHTML ;
    let  asu = document.getElementById("apellSR").innerHTML  ;
    let tDC=nsu+" "+asu;

    let codsuI=document.getElementById("codSR").innerHTML  ;
    let anirs=  document.getElementById("anioRS").innerHTML;
    let mesrs=document.getElementById("mesRS").innerHTML  ;
    let costALL=document.getElementById("costTotal").innerHTML  ;
    let DRS=document.getElementById("direRS").innerHTML  ;
    let anIRS=document.getElementById("anombre").value;
    let servIRS=document.getElementById("servS").value;



   // document.getElementById("costTotal").innerHTML=costoTot;
    var myTable = document.getElementById("tabla");
    var rowCount = myTable.rows.length;

    var d = new Date();

    for (var x=rowCount-1;x>=1;  x--) {

        // g=myTable.cells[1];
        co[x]=myTable.rows[x].cells[0].innerText;
        a[x]=myTable.rows[x].cells[1].innerText;
        to[x]=myTable.rows[x].cells[2].innerText;
        // h =a[x];
        // console.log("datos"+h)
        // a=id_f ila_selected.push(myTable.rows[x].innerText);
    }


    window.open(`../reportes/regServ.php?anRSI=${anIRS}&codSI=${codsuI}&DRSI=${DRS}&TCSI=${tDC}&IDFSI=${idfRSi}&desNSI=${co}&descSI=${a}&desCcSI=${to}&cosTSI=${costALL}&servSI=${servIRS}`, '_blank')
   // conts++;
    //let bx=co+a;
 /*   $.ajax({
        url:`../reportes/imp.php`,
        type:'POST',
        // data:'ids='+idf+'&monto='+cost,
        data:'anRSI='+anIRS+'&codSI='+codsuI+'&desNSI='+co+'&descSI='+a+'&desCcSI='+to+'&idfSI='+idfRSi+'&costALLSI='+costALL,
        success:function (resp) {
            window.open(`../reportes/imp.php`, '_blank')
            // alert('respuesta'+resp);
        }

    });*/



   // let tot=parseFloat(cost);
    console.log(" esta en imprimir" +anirs+mesrs+"DATOS"+a+to );
}

//------------------------------------------------------REPORTES--------------------------------------------------------------------------------------------
p=Array();
v=Array();
y=0;
function ImprimerRC(){
    var myTable = document.getElementById("order_data");


    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();

    var rowCount = myTable.rows.length;

    for (var x=rowCount-1;x>=1;  x--) {

        // g=myTable.cells[1];
        p[x]=myTable.rows[x].innerText;
        y=y+parseFloat(myTable.rows[x].cells[3].innerText);
       // y=y+v[x];
        // h =a[x];
        // console.log("datos"+h)S
        // a=id_f ila_selected.push(myTable.rows[x].innerText);
    }
    window.open(`../reportes/reportesAmortizar.php?inicioDate=${start_date}&finalDate=${end_date}`,'_blank')
   // window.open(`../reportes/reportesAmortizar?RAS=${p}&codSI=${codsuI}`, '_blank')


    //let c=$('#order_data_info').innerHTML;
    console.log("total de paginas"+start_date+end_date)
   // console.log("total de paginas"+y+"  LISTA: "+v)
    //console.log("DATOS"+p)
}
function ImprimerRPR(){

    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();

    window.open(`../reportes/reportesPagosRC.php?inicioDate=${start_date}&finalDate=${end_date}`,'_blank')
   // window.open(`../reportes/reportesAmortizar?RAS=${p}&codSI=${codsuI}`, '_blank')

    console.log("total de paginas"+start_date+end_date)

}
//------------------------------------REPORTE DE ASOCIADOS-------------------------------------------------
function ImpAso() {

    var start_date = document.querySelector("#direccionAsoc").value;
    var estad = document.querySelector("#ESTADO").value;
    var catA = document.querySelector("#categoriaAsoc").value;
    var MdAsoc = document.querySelector("#medidorAsoc").value;

    window.open(`../reportes/reporteAsociados.php?ADIR=${start_date}&AEST=${estad}&ACAT=${catA}&MdAsoci=${MdAsoc}`,'_blank')
    console.log("Direccion:"+start_date+" Estado:"+estad+" Cat:"+catA+"medidor: "+MdAsoc)
    
}
function ImpAsoTotal(){
    var start_date = document.querySelector("#direccionAsoc").value;
    var estad = document.querySelector("#ESTADOt").value;

    window.open(`../reportes/reporteAsociadosTotal.php?ATDIR=${start_date}&ATEST=${estad}`,'_blank')


    console.log("Direccion:"+start_date+" Estado:"+estad)
}
