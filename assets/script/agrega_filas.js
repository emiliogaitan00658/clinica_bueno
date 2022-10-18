//FUNCION PARA AGREGAR Y ELIMINAR CAMPOS DINAMICAMENTE

    var cont=1;
    
     //FUNCION AGREGA DX PRESUNTIVO
    function AddDxPresuntivo()  //Esta la funcion que agrega las filas segunda parte :
    {
    cont++;
    //autocompletar
    var indiceFila=1;
    myNewRow = document.getElementById('tabla').insertRow(-1);
    myNewRow.id=indiceFila;
    myNewCell=myNewRow.insertCell(-1);
    myNewCell.innerHTML='<div class="col-md-12"><div class="form-group has-feedback"><label class="control-label">Dx Presuntivo: <span class="symbol required"></span></label><input type="hidden" name="idciepresuntivo[]'+cont+'" id="idciepresuntivo'+cont+'"/><input type="text" class="form-control" name="presuntivo[]'+cont+'" id="presuntivo'+cont+'" onKeyUp="this.value=this.value.toUpperCase(); autocompletar(this.name);" placeholder="Ingrese Nombre de Dx para tu Búsqueda" title="Ingrese Dx Presuntivo" autocomplete="off" required="" aria-required="true"><i class="fa fa-pencil form-control-feedback"></i></div></div>';
    indiceFila++;
    }

    //FUNCION BORRAR DX PRESUNTIVO
    function DeleteDxPresuntivo() {
        var table = document.getElementById('tabla');
        if(table.rows.length > 1)
        {
            table.deleteRow(table.rows.length -1);
            cont--;
        }
    }

    //FUNCION AGREGA DX DEFINITIVO
    function AddDxDefinitivo()  //Esta la funcion que agrega las filas segunda parte :
    {
    cont++;
    //autocompletar
    var indiceFila=1;
    myNewRow = document.getElementById('tabla2').insertRow(-1);
    myNewRow.id=indiceFila;
    myNewCell=myNewRow.insertCell(-1);
    myNewCell.innerHTML='<div class="col-md-12"><div class="form-group has-feedback"><label class="control-label">Dx Definitivo: <span class="symbol required"></span></label><input type="hidden" name="idciedefinitivo[]'+cont+'" id="idciedefinitivo'+cont+'"/><input type="text" class="form-control" name="definitivo[]'+cont+'" id="definitivo'+cont+'" onKeyUp="this.value=this.value.toUpperCase(); autocompletar2(this.name);" placeholder="Ingrese Nombre de Dx para tu Búsqueda" title="Ingrese Dx Definitivo" autocomplete="off" required="" aria-required="true"><i class="fa fa-pencil form-control-feedback"></i></div></div>';
    indiceFila++;
    }

    //FUNCION BORRAR DX DEFINITIVO
    function DeleteDxDefinitivo() {
        var table = document.getElementById('tabla2');
        if(table.rows.length > 1)
        {
            table.deleteRow(table.rows.length -1);
            cont--;
        }
    }


    ////////////FUNCION ASIGNA VALOR DE CONT PARA EL FOR DE MOSTRAR DATOS MP-MOD-TT////////
    function asigna()
    {
        valor=document.form.var_cont.value=cont;
    }