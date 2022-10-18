var estados=$("#hiddenEstados").val().split("__");
var dientesDiastema=[];
var dientesProtesisFija=[];
var dientesProtesisRemovible=[];
var dientesOdontuloTotal=[];
var dientesAparatOrtoFijo=[];
var dientesAparatOrtoRemovible=[];

for(var i=0; i<estados.length; i++)
{
	var partesEstado=estados[i].split("_");
	var tratamiento=(estados == "") ? "0" : partesEstado[2].split("-");
	switch(tratamiento[0])
	{
		/*case "1":
		
		if(estado.split("-")[1]=="C1"){
		
			var css=
			{
				"color": "#036FAB",
				"font-weight": "bold",
				"font-size": "14px",
				"position": "absolute",
				"top": "1px",
				"left": "-14px"
			};
			
			$("#"+partesEstado[0]+"-C5").append("<span id='ENAZULDIENTEOBTURADO'>Do</span>");
			$("#"+partesEstado[0]+"-C5"+" > #ENAZULDIENTEOBTURADO").css(css);
	         
			 } else if(estado.split("-")[1]=="C2"){
				 
			var css=
			{
				"color": "#036FAB",
				"font-weight": "bold",
				"font-size": "14px",
				"position": "absolute",
				"top": "-16px",
				"left": "5px"
			};
			
			$("#"+partesEstado[0]+"-C5").append("<span id='ENAZULDIENTEOBTURADO'>Do</span>");
			$("#"+partesEstado[0]+"-C5"+" > #ENAZULDIENTEOBTURADO").css(css);	 
				 
			 }
			break;
			
			case "1":
			var arrayTratamiento=
			[
				{
					"box-shadow": "2px 2px 1px rgba(0, 0, 0, 0.2)",
	                 "border-right": "13px solid #036FAB",
                     "border-top": "13px solid #036FAB",
                     "border-left": "13px solid #036FAB",
                     "border-bottom": "13px solid #036FAB",
					"background": "#036FAB",
                     "height": " 100px",
	                 " position": "absolute",
	                 " width": "100px",
	
	                 " top": "86px !important",
	                 "left": "-81px !important",
	                 "-webkit-transform": "rotate(225deg)",
	                 "-moz-transform": "rotate(225deg)",
	                 "-ms-transform": "rotate(225deg)",
	                 "-o-transform": "rotate(225deg)",
	                 " transform": "rotate(225deg)"
	 
	 
	 /*"color": "#036FAB",
					"background": "#036FAB",
					"font-weight": "bold",
					"font-size": "10px",
					"position": "absolute",
					"top": "4px",
					"left": "5px",
					"-webkit-transform": "rotate(55deg)"
				},
				{
					"color": "#036FAB",
					"font-size": "12px",
					"position": "absolute",
					"top": "7px",
					"left": "-18px",
					"-webkit-transform": "rotate(-45deg)"
				},
				{
					"color": "#036FAB",
					"font-size": "12px",
					"position": "center",
					"top": "10px",
					"left": "-8px",
					"-webkit-transform": "rotate(35deg)"
				},
				{
					"color": "#036FAB",
					"font-size": "12px",
					"position": "absolute",
					"top": "5px",
					"left": "3px",
					"-webkit-transform": "rotate(-135deg)"
				},
				{
					"color": "#036FAB",
					"font-size": "12px",
					"position": "absolute",
					"top": "3px",
					"left": "4px",
					"-webkit-transform": "rotate(-1deg)"
				}
			];
			var css=arrayTratamiento[partesEstado[1].substring(1, 2)-1];
			$("#"+partesEstado[0]+"-"+partesEstado[1]).append("<span id='ENAZULDIENTEOBTURADO'></span>");
			$("#"+partesEstado[0]+"-"+partesEstado[1]+" > #ENAZULDIENTEOBTURADO").css(css);
			
			$("#txt"+partesEstado[0]).val("Do");

			break;*/
			
			case "1":
			var arrayTratamiento=
			[
				{
					"border-bottom": "13px solid #036FAB",
					"border-right": "13px solid transparent",
                    "border-top": "13px solid transparent",
                    "border-left": "13px solid #036FAB",
					"height": "0px",
					"position": "absolute",
					" top": "0px !important",
	                "left": "-8px !important",
					"width": "0px",
					"-webkit-transform": "rotate(225deg)",
	                "-moz-transform": "rotate(225deg)",
	                "-ms-transform": "rotate(225deg)",
	                "-o-transform": "rotate(225deg)",
	                " transform": "rotate(225deg)"
				},
				{
					"border-bottom": "13px solid #036FAB",
					"border-right": "13px solid transparent",
                    "border-top": "13px solid transparent",
                    "border-left": "13px solid #036FAB",
					"height": "0px",
					"position": "absolute",
					" top": "0px !important",
	                "left": "-8px !important",
					"width": "0px",
					"-webkit-transform": "rotate(-45deg)",
	                "-moz-transform": "rotate(-45deg)",
	                "-ms-transform": "rotate(-45deg)",
	                "-o-transform": "rotate(-45deg)",
	                " transform": "rotate(-45deg)"
				},
				{
					"box-shadow": "-2px 2px 1px rgba(0, 0, 0, 0.2)",
					"border-bottom": "13px solid #036FAB",
					"border-right": "13px solid transparent",
                    "border-top": "13px solid transparent",
                    "border-left": "13px solid #036FAB",
					"height": "0px",
					"position": "absolute",
					" top": "17px !important",
	                "left": "-11px !important",
					"width": "0px",
					"right": "-13px",
					"-webkit-transform": "rotate(45deg)",
	                "-moz-transform": "rotate(45deg)",
	                "-ms-transform": "rotate(45deg)",
	                "-o-transform": "rotate(45deg)",
	                " transform": "rotate(45deg)"
				},
				{
					"box-shadow": "-2px 2px 1px rgba(0, 0, 0, 0.2)",
					"border-bottom": "13px solid #036FAB",
					"border-right": "13px solid transparent",
                    "border-top": "13px solid transparent",
                    "border-left": "13px solid #036FAB",
					"height": "0px",
					"position": "absolute",
					" top": "7px !important",
	                "left": "-1px !important",
					"width": "0px",
					"-webkit-transform": "rotate(135deg)",
	                "-moz-transform": "rotate(135deg)",
	                "-ms-transform": "rotate(135deg)",
	                "-o-transform": "rotate(135deg)",
	                " transform": "rotate(135deg)"
				},
				{
					"box-shadow": "-2px 2px 1px rgba(0, 0, 0, 0.2)",
					"background-color": "#036FAB",
					"border": "1px solid #000000",
					"height": "20px",
					"left": "8px;",
					"position": "absolute",
					"top": "8px;",
					"width": "20px"
				}
			];
			var css=arrayTratamiento[partesEstado[1].substring(1, 2)-1];
			$("#"+partesEstado[0]+"-"+partesEstado[1]).css(css);
			$("#txt"+partesEstado[0]).val("Do");
			break;
		case "2":
			var arrayTratamiento=
			[
				{
					"color": "#FF0000",
					"font-size": "14px",
					"position": "absolute",
					"top": "-8px",
					"left": "-8px",
					"-webkit-transform": "rotate(135deg)"
				},
				{
					"color": "#FF0000",
					"font-size": "14px",
					"position": "absolute",
					"top": "-6px",
					"left": "-6px",
					"-webkit-transform": "rotate(40deg)"
				},
				{
					"color": "#FF0000",
					"font-size": "14px",
					"position": "absolute",
					"top": "-6px",
					"left": "-6px",
					"-webkit-transform": "rotate(-40deg)"
				},
				{
					"color": "#FF0000",
					"font-size": "14px",
					"position": "absolute",
					"top": "-8px",
					"left": "-8px",
					"-webkit-transform": "rotate(-142deg)"
				},
				{
					"color": "#FF0000",
					"font-size": "14px",
					"position": "absolute",
					"top": "2px",
					"left": "5px",
					"-webkit-transform": "rotate(-5deg)"
				}
			];
			var css=arrayTratamiento[partesEstado[1].substring(1, 2)-1];
			$("#"+partesEstado[0]+"-"+partesEstado[1]).append("<span id='ENROJOCARIADO'>C</span>");
			$("#"+partesEstado[0]+"-"+partesEstado[1]+" > #ENROJOCARIADO").css(css);
			break;
		case "3":
			var css=
			{
				"color": "#036FAB",
				"font-size": "80px",
				"position": "absolute",
				"top": "-78px",
				"left": "-12px",
				"-webkit-transform": "rotate(0deg)"
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='ENAZULAUSENTE'>_</span>");
			$("#"+partesEstado[0]+"-C5"+" > #ENAZULAUSENTE").css(css);
			break;
		case "4":
			var css=
			{
				"color": "red",
				"font-size": "35px",
				"position": "absolute",
				"top": "-16px",
				"left": "-2px"
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='ENROJOEXODONCIA'>X</span>");
			$("#"+partesEstado[0]+"-C5"+" > #ENROJOEXODONCIA").css(css);
			break;
		case "5":
			var css=
			{
				"color": "red",
				"font-size": "30px",
				"position": "absolute",
				"top": "-10px",
				"left": "-7px",
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='ENROJOCARIESPENETRANTE'>CP</span>");
			$("#"+partesEstado[0]+"-C5"+" > #ENROJOCARIESPENETRANTE").css(css);
			break;
		case "6":
			var css=
			{
				"color": "red",
				"font-size": "35px",
				"position": "absolute",
				"top": "-11px",
				"left": "-3px",
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='ENROJORETENIDO'>R</span>");
			$("#"+partesEstado[0]+"-C5"+" > #ENROJORETENIDO").css(css);
			break;
		case "7":
			var css=
			{
				"color": "#036FAB",
				"font-size": "35px",
				"top": "-12px",
				"left": "-8px",
				"position": "absolute",
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='ENAZULPIEZADEPUENTE'>FP</span>");
			$("#"+partesEstado[0]+"-C5"+" > #ENAZULPIEZADEPUENTE").css(css);
			break;
		case "8":
			var css=
			{
				"color": "#036FAB",
				"font-size": "30px",
				"top": "-10px",
				"left": "-8px",
				"position": "absolute",
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='ENAZULCORONA'>Co</span>");
			$("#"+partesEstado[0]+"-C5"+" > #ENAZULCORONA").css(css);
			break;
		case "9":
			var css=
			{
				"color": "#036FAB",
				"font-size": "30px",
				"top": "-10px",
				"left": "-4px",
				"position": "absolute",
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='ENAZULPROTESISREMOVIBLE'>Pr</span>");
			$("#"+partesEstado[0]+"-C5"+" > #ENAZULPROTESISREMOVIBLE").css(css);
			break;
		case "10":
			var css=
			{
				"color": "#036FAB",
				"font-size": "30px",
				"top": "-10px",
				"left": "-8px",
				"position": "absolute",
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='INSCRUSTACION'>Inc</span>");
			$("#"+partesEstado[0]+"-C5"+" > #INSCRUSTACION").css(css);
			break;
		case "11":
			var css=
			{
				"color": "red",
				"font-size": "30px",
				"top": "-10px",
				"left": "-6px",
				"position": "absolute",
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='ENROJOENFERMEDADPERIODONTAL'>Ep</span>");
			$("#"+partesEstado[0]+"-C5"+" > #ENROJOENFERMEDADPERIODONTAL").css(css);
			break;
		case "12":
			var css=
			{
				"color": "red",
				"font-size": "30px",
				"top": "-10px",
				"left": "-6px",
				"position": "absolute",
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='ENROJOFRACTURADENTARIA'>Fd</span>");
			$("#"+partesEstado[0]+"-C5"+" > #ENROJOFRACTURADENTARIA").css(css);
			break;
		case "13":
			var css=
			{
				"color": "red",
				"font-size": "20px",
				"position": "absolute",
				"top": "-2px",
				"left": "-12px",
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='ENROJOMALPOSICIONDENTARIA'>MPD</span>");
			$("#"+partesEstado[0]+"-C5"+" > #ENROJOMALPOSICIONDENTARIA").css(css);
			break;
		case "14":
			var css=
			{
				"color": "red",
				"font-size": "30px",
				"position": "absolute",
				"top": "-8px",
				"left": "-12px",
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='ENAZULPERNOMUÑON'>PM</span>");
			$("#"+partesEstado[0]+"-C5"+" > #ENAZULPERNOMUÑON").css(css);
			break;
		case "15":
			var css=
			{
				"color": "#036FAB",
				"font-size": "30px",
				"position": "absolute",
				"top": "-8px",
				"left": "-10px",
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='ENAZULTRATAMIENTODECONDUCTO'>TC</span>");
			$("#"+partesEstado[0]+"-C5"+" > #ENAZULTRATAMIENTODECONDUCTO").css(css);
			break;
		case "16":
			var css=
			{
				"color": "red",
				"font-size": "35px",
				"position": "absolute",
				"top": "-14px",
				"left": "1px",
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='ENROJOFLUOROSIS'>F</span>");
			$("#"+partesEstado[0]+"-C5"+" > #ENROJOFLUOROSIS").css(css);
			break;
		case "17":
			var css=
			{
				"color": "#036FAB",
				"font-size": "25px",
				"position": "absolute",
				"top": "-8px",
				"left": "-10px",
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='ENAZULIMPLANTEDENTAL'>Imp</span>");
			$("#"+partesEstado[0]+"-C5"+" > #ENAZULIMPLANTEDENTAL").css(css);
			break;
		case "18":
			var css=
			{
				"color": "red",
				"font-size": "25px",
				"position": "absolute",
				"top": "-5px",
				"left": "-8px",
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='ENROJOMANCHABLANCA'>MB</span>");
			$("#"+partesEstado[0]+"-C5"+" > #ENROJOMANCHABLANCA").css(css);
			break;
		case "19":
			var css=
			{
				"color": "#036FAB",
				"font-size": "30px",
				"position": "absolute",
				"top": "-10px",
				"left": "-6px",
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='ENAZULSELLADOR'>Sc</span>");
			$("#"+partesEstado[0]+"-C5"+" > #ENAZULSELLADOR").css(css);
			break;
		case "20":
			var css=
			{
				"color": "#036FAB",
				"font-size": "20px",
				"position": "absolute",
				"top": "-2px",
				"left": "-10px",
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='ENAZULSURCOPROFUNDO'>SpSR</span>");
			$("#"+partesEstado[0]+"-C5"+" > #ENAZULSURCOPROFUNDO").css(css);
			break;
		case "21":
			var css=
			{
				"color": "#036FAB",
				"font-size": "30px",
				"position": "absolute",
				"top": "-8px",
				"left": "-6px",
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='ENAZULHIPOPLASIADEESMALTE'>Hp</span>");
			$("#"+partesEstado[0]+"-C5"+" > #ENAZULHIPOPLASIADEESMALTE").css(css);
			break;
		case "22":
			$("#txt"+partesEstado[0]).val("DESG");
			break;			
		case "23":
			dientesDiastema.push(partesEstado[0]);
			break;
		case "24":
			$("#txt"+partesEstado[0]).val("MOV");
			break;
		case "25":
			var css=
			{
				/*"border": "1px solid black",
				"border-radius": "43px",
				"height": "43px",
				"left": "-16px",
				"position": "absolute",
				"top": "-13px",
				"width": "50px"*/
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='CORONATEMPORAL'></span>");
			$("#"+partesEstado[0]+"-C5"+" > #CORONATEMPORAL").css(css);
			$("#txt"+partesEstado[0]).val("CT");
			break;
		case "26":
			var css=
			{
				/*"border": "1px solid black",
				"border-radius": "43px",
				"height": "43px",
				"left": "-14px",
				"position": "absolute",
				"top": "-12px",
				"width": "50px"*/
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='CORONACOMPLETA'></span>");
			$("#"+partesEstado[0]+"-C5"+" > #CORONACOMPLETA").css(css);
			$("#txt"+partesEstado[0]).val("CC");
			break;
		case "27":
			var css=
			{
				/*"border": "1px solid black",
				"border-radius": "43px",
				"height": "43px",
				"left": "-14px",
				"position": "absolute",
				"top": "-12px",
				"width": "50px"*/
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='CORONAVEENER'></span>");
			$("#"+partesEstado[0]+"-C5"+" > #CORONAVEENER").css(css);
			$("#txt"+partesEstado[0]).val("CV");
			break;
		case "28":
			var css=
			{
				/*"border": "1px solid black",
				"border-radius": "43px",
				"height": "43px",
				"left": "-16px",
				"position": "absolute",
				"top": "-13px",
				"width": "50px"*/
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='CORONAFEXESTRADA'></span>");
			$("#"+partesEstado[0]+"-C5"+" > #CORONAFEXESTRADA").css(css);
			$("#txt"+partesEstado[0]).val("CF");
			break;
		case "29":
			var css=
			{
				/*"border": "1px solid black",
				"border-radius": "43px",
				"height": "43px",
				"left": "-16px",
				"position": "absolute",
				"top": "-13px",
				"width": "50px"*/
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='CORONATRESCUARTOS'></span>");
			$("#"+partesEstado[0]+"-C5"+" > #CORONATRESCUARTOS").css(css);
			$("#txt"+partesEstado[0]).val("3/4");
			break;
		case "30":
			var css=
			{
				/*"border": "1px solid black",
				"border-radius": "43px",
				"height": "43px",
				"left": "-16px",
				"position": "absolute",
				"top": "-13px",
				"width": "50px"*/
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='CORONAPORCELANA'></span>");
			$("#"+partesEstado[0]+"-C5"+" > #CORONAPORCELANA").css(css);
			$("#txt"+partesEstado[0]).val("CP");
			break;
		case "31":
			dientesProtesisFija.push(partesEstado[0]);
			break;
		case "32":
			dientesProtesisRemovible.push(partesEstado[0]);
			break;
		case "33":
			dientesOdontuloTotal.push(partesEstado[0]);
			break;
		case "34":
			dientesAparatOrtoFijo.push(partesEstado[0]);
			break;
		case "35":
			dientesAparatOrtoRemovible.push(partesEstado[0]);
			break;
		case "36":
			$("#txt"+partesEstado[0]).val("IMP");
			break;
		case "37":
			$("#txt"+partesEstado[0]).val("S");
			break;
		case "38":
			var css=
			{
				"color": "red",
				"font-size": "50px",
				"position": "absolute",
				"top": "-30px",
				"left": "-9px"
			};
			$("#"+partesEstado[0]+"-C5").append("<span id='DIENTEAUSENTE'>X</span>");
			$("#"+partesEstado[0]+"-C5"+" > #DIENTEAUSENTE").css(css);
			break;

		case "39":
			var arrayTratamiento=
			[
				{
					"color": "#036FAB",
					"font-size": "13px",
					"position": "absolute",
					"top": "7px",
					"left": "4px",
					"-webkit-transform": "rotate(70deg)"
				},
				{
					"color": "#036FAB",
					"font-size": "13px",
					"position": "absolute",
					"top": "8px",
					"left": "-17px",
					"-webkit-transform": "rotate(70deg)"
				},
				{
					"color": "#036FAB",
					"font-size": "13px",
					"position": "absolute",
					"top": "7px",
					"left": "-15px",
					"-webkit-transform": "rotate(70deg)"
				},
				{
					"color": "#036FAB",
					"font-size": "13px",
					"position": "absolute",
					"top": "7px",
					"left": "4px",
					"-webkit-transform": "rotate(70deg)"
				},
				{
					"color": "#036FAB",
					"font-size": "13px",
					"position": "absolute",
					"top": "1px",
					"left": "3px",
					"-webkit-transform": "rotate(70deg)"
				}
			];
			var css=arrayTratamiento[partesEstado[1].substring(1, 2)-1];
			$("#"+partesEstado[0]+"-"+partesEstado[1]).append("<span id='AMALGAMA'><b>O</b></span>");
			$("#"+partesEstado[0]+"-"+partesEstado[1]+" > #AMALGAMA").css(css);
			$("#txt"+partesEstado[0]).val("A");
			break;
		case "40":
			var arrayTratamiento=
			[
				{
					"color": "#036FAB",
					"font-size": "14px",
					"position": "absolute",
					"top": "-8px",
					"left": "-8px",
					"-webkit-transform": "rotate(135deg)"
				},
				{
					"color": "#036FAB",
					"font-size": "14px",
					"position": "absolute",
					"top": "-6px",
					"left": "-6px",
					"-webkit-transform": "rotate(40deg)"
				},
				{
					"color": "#036FAB",
					"font-size": "14px",
					"position": "absolute",
					"top": "-6px",
					"left": "-6px",
					"-webkit-transform": "rotate(-40deg)"
				},
				{
					"color": "#036FAB",
					"font-size": "14px",
					"position": "absolute",
					"top": "-8px",
					"left": "-8px",
					"-webkit-transform": "rotate(-142deg)"
				},
				{
					"color": "#036FAB",
					"font-size": "14px",
					"position": "absolute",
					"top": "2px",
					"left": "5px",
					"-webkit-transform": "rotate(-5deg)"
				}
			];
			var css=arrayTratamiento[partesEstado[1].substring(1, 2)-1];
			$("#"+partesEstado[0]+"-"+partesEstado[1]).append("<span id='RESINA'>◙</span>");
			$("#"+partesEstado[0]+"-"+partesEstado[1]+" > #RESINA").css(css);
			$("#txt"+partesEstado[0]).val("R");
			break;
	}
}

if(dientesDiastema.length>0)
{
	var cssDiastema=
	{
		"color": "#036FAB",
		"font-size": "22px",
		"position": "absolute",
		"left": "30px",
		"top": "-5px"
	};

	dientesDiastema.sort();
	for(var i=0; i<dientesDiastema.length; i++)
	{
		if(i<dientesDiastema.length-1)
		{
			if(parseInt(dientesDiastema[i].substring(1, 3))==parseInt(dientesDiastema[i+1].substring(1, 3))-1)
			{
				var posicionDienteUno=$("#"+dientesDiastema[i]).position();
				var posicionDienteDos=$("#"+dientesDiastema[i+1]).position();
				var dienteElegido=posicionDienteUno.left<posicionDienteDos.left?i:i+1;
				$("#"+dientesDiastema[dienteElegido]+"-C5").append("<span id='DIASTEMA'><span>)</span><span>(</span></span>");
				$("#"+dientesDiastema[dienteElegido]+"-C5"+" > #DIASTEMA").css(cssDiastema);
			}
		}		
	}
}

if(dientesProtesisFija.length>0)
{
	var cssProtesisFijaUno=
	{
		"border-right": "1px solid black",
		"height": "10px",
		"left": "-10px",
		"position": "absolute",
		"top": "-20px",
		"width": "0px"
	};

	var cssProtesisFijaDos=
	{
		"border-left": "1px solid black",
		"height": "10px",
		"left": "30px",
		"position": "absolute",
		"top": "-20px",
		"width": "0px"
	};

	var cssProtesisFijaConector;

	dientesProtesisFija.sort();
	var dientesProtesisFijaUno=dientesProtesisFija[0];
	var dientesProtesisFijaDos;
	for(var i=0; i<dientesProtesisFija.length; i++)
	{
		if(i<dientesProtesisFija.length-1)
		{
			if(parseInt(dientesProtesisFija[i].substring(1, 3))==parseInt(dientesProtesisFija[i+1].substring(1, 3))-1)
			{
				continue;
			}
			else
			{
				dientesProtesisFijaDos=dientesProtesisFija[i];
				var posicionDienteUno=$("#"+dientesProtesisFijaUno).position();
				var posicionDienteDos=$("#"+dientesProtesisFijaDos).position();
				var dienteInicio=posicionDienteUno.left<posicionDienteDos.left?dientesProtesisFijaUno:dientesProtesisFijaDos;
				var dienteFin=posicionDienteUno.left>posicionDienteDos.left?dientesProtesisFijaUno:dientesProtesisFijaDos;
				$("#"+dienteInicio+"-C5").append("<div id='PROTESISFIJAINICIO'></div>");
				$("#"+dienteInicio+"-C5"+" > #PROTESISFIJAINICIO").css(cssProtesisFijaUno);
				$("#"+dienteFin+"-C5").append("<div id='PROTESISFIJAFIN'></div>");
				$("#"+dienteFin+"-C5"+" > #PROTESISFIJAFIN").css(cssProtesisFijaDos);

				var topLeft1=posicionDienteUno.left;
				var topLeft2=posicionDienteDos.left;
				var topWidth=(topLeft1-topLeft2)<0?(topLeft1-topLeft2)*(-1):(topLeft1-topLeft2);
				topWidth=topWidth+40;
				cssProtesisFijaConector=
				{
					"border-top": "1px solid black",
					"height": "10px",
					"left": "-10px",
					"position": "absolute",
					"top": "-20px",
					"width": ""+topWidth.toString()+"px"
				};
				$("#"+dienteInicio+"-C5").append("<div id='PROTESISFIJACONECTOR'></div>");
				$("#"+dienteInicio+"-C5"+" > #PROTESISFIJACONECTOR").css(cssProtesisFijaConector);

				dientesProtesisFijaUno=dientesProtesisFija[i+1];
			}
		}
		else
		{
			dientesProtesisFijaDos=dientesProtesisFija[i];
			var posicionDienteUno=$("#"+dientesProtesisFijaUno).position();
			var posicionDienteDos=$("#"+dientesProtesisFijaDos).position();
			var dienteInicio=posicionDienteUno.left<posicionDienteDos.left?dientesProtesisFijaUno:dientesProtesisFijaDos;
			var dienteFin=posicionDienteUno.left>posicionDienteDos.left?dientesProtesisFijaUno:dientesProtesisFijaDos;
			$("#"+dienteInicio+"-C5").append("<div id='PROTESISFIJAINICIO'></div>");
			$("#"+dienteInicio+"-C5"+" > #PROTESISFIJAINICIO").css(cssProtesisFijaUno);
			$("#"+dienteFin+"-C5").append("<div id='PROTESISFIJAFIN'></div>");
			$("#"+dienteFin+"-C5"+" > #PROTESISFIJAFIN").css(cssProtesisFijaDos);

			var topLeft1=posicionDienteUno.left;
			var topLeft2=posicionDienteDos.left;
			var topWidth=(topLeft1-topLeft2)<0?(topLeft1-topLeft2)*(-1):(topLeft1-topLeft2);
			topWidth=topWidth+40;
			cssProtesisFijaConector=
			{
				"border-top": "1px solid black",
				"height": "10px",
				"left": "-10px",
				"position": "absolute",
				"top": "-20px",
				"width": ""+topWidth.toString()+"px"
			};
			$("#"+dienteInicio+"-C5").append("<div id='PROTESISFIJACONECTOR'></div>");
			$("#"+dienteInicio+"-C5"+" > #PROTESISFIJACONECTOR").css(cssProtesisFijaConector);
		}
	}
}

if(dientesProtesisRemovible.length>0)
{
	var cssProtesisRemovibleUno=
	{
		"border-right": "1px solid black",
		"border-top": "1px solid black",
		"height": "10px",
		"left": "-10px",
		"position": "absolute",
		"top": "-25px",
		"width": "10px"
	};

	var cssProtesisRemovibleDos=
	{
		"border-left": "1px solid black",
		"border-top": "1px solid black",
		"height": "10px",
		"left": "20px",
		"position": "absolute",
		"top": "-25px",
		"width": "10px"
	};

	var cssProtesisRemovibleConector;

	dientesProtesisRemovible.sort();
	var dientesProtesisRemovibleUno=dientesProtesisRemovible[0];
	var dientesProtesisRemovibleDos;
	for(var i=0; i<dientesProtesisRemovible.length; i++)
	{
		if(i<dientesProtesisRemovible.length-1)
		{
			if(parseInt(dientesProtesisRemovible[i].substring(1, 3))==parseInt(dientesProtesisRemovible[i+1].substring(1, 3))-1)
			{
				continue;
			}
			else
			{
				dientesProtesisRemovibleDos=dientesProtesisRemovible[i];
				var posicionDienteUno=$("#"+dientesProtesisRemovibleUno).position();
				var posicionDienteDos=$("#"+dientesProtesisRemovibleDos).position();
				var dienteInicio=posicionDienteUno.left<posicionDienteDos.left?dientesProtesisRemovibleUno:dientesProtesisRemovibleDos;
				var dienteFin=posicionDienteUno.left>posicionDienteDos.left?dientesProtesisRemovibleUno:dientesProtesisRemovibleDos;
				$("#"+dienteInicio+"-C5").append("<div id='PROTESISREMOVIBLEINICIO'></div>");
				$("#"+dienteInicio+"-C5"+" > #PROTESISREMOVIBLEINICIO").css(cssProtesisRemovibleUno);
				$("#"+dienteFin+"-C5").append("<div id='PROTESISREMOVIBLEFIN'></div>");
				$("#"+dienteFin+"-C5"+" > #PROTESISREMOVIBLEFIN").css(cssProtesisRemovibleDos);

				var topLeft1=posicionDienteUno.left;
				var topLeft2=posicionDienteDos.left;
				var topWidth=(topLeft1-topLeft2)<0?(topLeft1-topLeft2)*(-1):(topLeft1-topLeft2);
				topWidth=topWidth+20;
				cssProtesisRemovibleConector=
				{
					"border-top": "1px solid black",
					"height": "10px",
					"left": "0px",
					"position": "absolute",
					"top": "-15px",
					"width": ""+topWidth.toString()+"px"
				};
				$("#"+dienteInicio+"-C5").append("<div id='PROTESISREMOVIBLECONECTOR'></div>");
				$("#"+dienteInicio+"-C5"+" > #PROTESISREMOVIBLECONECTOR").css(cssProtesisRemovibleConector);

				dientesProtesisRemovibleUno=dientesProtesisRemovible[i+1];
			}
		}
		else
		{
			dientesProtesisRemovibleDos=dientesProtesisRemovible[i];
			var posicionDienteUno=$("#"+dientesProtesisRemovibleUno).position();
			var posicionDienteDos=$("#"+dientesProtesisRemovibleDos).position();
			var dienteInicio=posicionDienteUno.left<posicionDienteDos.left?dientesProtesisRemovibleUno:dientesProtesisRemovibleDos;
			var dienteFin=posicionDienteUno.left>posicionDienteDos.left?dientesProtesisRemovibleUno:dientesProtesisRemovibleDos;
			$("#"+dienteInicio+"-C5").append("<div id='PROTESISREMOVIBLEINICIO'></div>");
			$("#"+dienteInicio+"-C5"+" > #PROTESISREMOVIBLEINICIO").css(cssProtesisRemovibleUno);
			$("#"+dienteFin+"-C5").append("<div id='PROTESISREMOVIBLEFIN'></div>");
			$("#"+dienteFin+"-C5"+" > #PROTESISREMOVIBLEFIN").css(cssProtesisRemovibleDos);

			var topLeft1=posicionDienteUno.left;
			var topLeft2=posicionDienteDos.left;
			var topWidth=(topLeft1-topLeft2)<0?(topLeft1-topLeft2)*(-1):(topLeft1-topLeft2);
			topWidth=topWidth+20;
			cssProtesisRemovibleConector=
			{
				"border-top": "1px solid black",
				"height": "10px",
				"left": "0px",
				"position": "absolute",
				"top": "-15px",
				"width": ""+topWidth.toString()+"px"
			};
			$("#"+dienteInicio+"-C5").append("<div id='PROTESISREMOVIBLECONECTOR'></div>");
			$("#"+dienteInicio+"-C5"+" > #PROTESISREMOVIBLECONECTOR").css(cssProtesisRemovibleConector);
		}
	}
}

if(dientesOdontuloTotal.length>0)
{
	var cssOdontuloTotalUno=
	{
		"height": "10px",
		"left": "-10px",
		"position": "absolute",
		"top": "-25px",
		"width": "0px"
	};

	var cssOdontuloTotalDos=
	{
		"height": "10px",
		"left": "30px",
		"position": "absolute",
		"top": "-25px",
		"width": "0px"
	};

	var cssOdontuloTotalConector;

	dientesOdontuloTotal.sort();
	var dientesOdontuloTotalUno=dientesOdontuloTotal[0];
	var dientesOdontuloTotalDos;
	for(var i=0; i<dientesOdontuloTotal.length; i++)
	{
		if(i<dientesOdontuloTotal.length-1)
		{
			if(parseInt(dientesOdontuloTotal[i].substring(1, 3))==parseInt(dientesOdontuloTotal[i+1].substring(1, 3))-1)
			{
				continue;
			}
			else
			{
				dientesOdontuloTotalDos=dientesOdontuloTotal[i];
				var posicionDienteUno=$("#"+dientesOdontuloTotalUno).position();
				var posicionDienteDos=$("#"+dientesOdontuloTotalDos).position();
				var dienteInicio=posicionDienteUno.left<posicionDienteDos.left?dientesOdontuloTotalUno:dientesOdontuloTotalDos;
				var dienteFin=posicionDienteUno.left>posicionDienteDos.left?dientesOdontuloTotalUno:dientesOdontuloTotalDos;
				$("#"+dienteInicio+"-C5").append("<div id='ODONTULOTOTALINICIO'></div>");
				$("#"+dienteInicio+"-C5"+" > #ODONTULOTOTALINICIO").css(cssOdontuloTotalUno);
				$("#"+dienteFin+"-C5").append("<div id='ODONTULOTOTALFIN'></div>");
				$("#"+dienteFin+"-C5"+" > #ODONTULOTOTALFIN").css(cssOdontuloTotalDos);

				var topLeft1=posicionDienteUno.left;
				var topLeft2=posicionDienteDos.left;
				var topWidth=(topLeft1-topLeft2)<0?(topLeft1-topLeft2)*(-1):(topLeft1-topLeft2);
				topWidth=topWidth+40;
				cssOdontuloTotalConector=
				{
					"border-top": "1px solid black",
					"border-bottom": "1px solid black",
					"height": "5px",
					"left": "-10px",
					"position": "absolute",
					"top": "-23px",
					"width": ""+topWidth.toString()+"px"
				};
				$("#"+dienteInicio+"-C5").append("<div id='ODONTULOTOTALCONECTOR'></div>");
				$("#"+dienteInicio+"-C5"+" > #ODONTULOTOTALCONECTOR").css(cssOdontuloTotalConector);

				dientesOdontuloTotalUno=dientesOdontuloTotal[i+1];
			}
		}
		else
		{
			dientesOdontuloTotalDos=dientesOdontuloTotal[i];
			var posicionDienteUno=$("#"+dientesOdontuloTotalUno).position();
			var posicionDienteDos=$("#"+dientesOdontuloTotalDos).position();
			var dienteInicio=posicionDienteUno.left<posicionDienteDos.left?dientesOdontuloTotalUno:dientesOdontuloTotalDos;
			var dienteFin=posicionDienteUno.left>posicionDienteDos.left?dientesOdontuloTotalUno:dientesOdontuloTotalDos;
			$("#"+dienteInicio+"-C5").append("<div id='ODONTULOTOTALINICIO'></div>");
			$("#"+dienteInicio+"-C5"+" > #ODONTULOTOTALINICIO").css(cssOdontuloTotalUno);
			$("#"+dienteFin+"-C5").append("<div id='ODONTULOTOTALFIN'></div>");
			$("#"+dienteFin+"-C5"+" > #ODONTULOTOTALFIN").css(cssOdontuloTotalDos);

			var topLeft1=posicionDienteUno.left;
			var topLeft2=posicionDienteDos.left;
			var topWidth=(topLeft1-topLeft2)<0?(topLeft1-topLeft2)*(-1):(topLeft1-topLeft2);
			topWidth=topWidth+40;
			cssOdontuloTotalConector=
			{
				"border-top": "1px solid black",
				"border-bottom": "1px solid black",
				"height": "5px",
				"left": "-10px",
				"position": "absolute",
				"top": "-23px",
				"width": ""+topWidth.toString()+"px"
			};
			$("#"+dienteInicio+"-C5").append("<div id='ODONTULOTOTALCONECTOR'></div>");
			$("#"+dienteInicio+"-C5"+" > #ODONTULOTOTALCONECTOR").css(cssOdontuloTotalConector);
		}
	}
}

if(dientesAparatOrtoFijo.length>0)
{
	var cssAparatOrtoFijoUno=
	{
		"border": "1px solid black",
		"height": "10px",
		"left": "-11px",
		"position": "absolute",
		"top": "-25px",
		"width": "10px"
	};

	var cssAparatOrtoFijoDos=
	{
		"border": "1px solid black",
		"height": "10px",
		"left": "20px",
		"position": "absolute",
		"top": "-25px",
		"width": "10px"
	};

	var cssAparatOrtoFijoConector;

	dientesAparatOrtoFijo.sort();
	var dientesAparatOrtoFijoUno=dientesAparatOrtoFijo[0];
	var dientesAparatOrtoFijoDos;
	for(var i=0; i<dientesAparatOrtoFijo.length; i++)
	{
		if(i<dientesAparatOrtoFijo.length-1)
		{
			if(parseInt(dientesAparatOrtoFijo[i].substring(1, 3))==parseInt(dientesAparatOrtoFijo[i+1].substring(1, 3))-1)
			{
				continue;
			}
			else
			{
				dientesAparatOrtoFijoDos=dientesAparatOrtoFijo[i];
				var posicionDienteUno=$("#"+dientesAparatOrtoFijoUno).position();
				var posicionDienteDos=$("#"+dientesAparatOrtoFijoDos).position();
				var dienteInicio=posicionDienteUno.left<posicionDienteDos.left?dientesAparatOrtoFijoUno:dientesAparatOrtoFijoDos;
				var dienteFin=posicionDienteUno.left>posicionDienteDos.left?dientesAparatOrtoFijoUno:dientesAparatOrtoFijoDos;
				$("#"+dienteInicio+"-C5").append("<div id='APARATORTOFIJOINICIO'></div>");
				$("#"+dienteInicio+"-C5"+" > #APARATORTOFIJOINICIO").css(cssAparatOrtoFijoUno);
				$("#"+dienteFin+"-C5").append("<div id='APARATORTOFIJOFIN'></div>");
				$("#"+dienteFin+"-C5"+" > #APARATORTOFIJOFIN").css(cssAparatOrtoFijoDos);

				var topLeft1=posicionDienteUno.left;
				var topLeft2=posicionDienteDos.left;
				var topWidth=(topLeft1-topLeft2)<0?(topLeft1-topLeft2)*(-1):(topLeft1-topLeft2);
				topWidth=topWidth+20;
				cssAparatOrtoFijoConector=
				{
					"border-top": "1px solid black",
					"height": "10px",
					"left": "0px",
					"position": "absolute",
					"top": "-20px",
					"width": ""+topWidth.toString()+"px"
				};
				$("#"+dienteInicio+"-C5").append("<div id='APARATORTOFIJOCONECTOR'></div>");
				$("#"+dienteInicio+"-C5"+" > #APARATORTOFIJOCONECTOR").css(cssAparatOrtoFijoConector);

				dientesAparatOrtoFijoUno=dientesAparatOrtoFijo[i+1];
			}
		}
		else
		{
			dientesAparatOrtoFijoDos=dientesAparatOrtoFijo[i];
			var posicionDienteUno=$("#"+dientesAparatOrtoFijoUno).position();
			var posicionDienteDos=$("#"+dientesAparatOrtoFijoDos).position();
			var dienteInicio=posicionDienteUno.left<posicionDienteDos.left?dientesAparatOrtoFijoUno:dientesAparatOrtoFijoDos;
			var dienteFin=posicionDienteUno.left>posicionDienteDos.left?dientesAparatOrtoFijoUno:dientesAparatOrtoFijoDos;
			$("#"+dienteInicio+"-C5").append("<div id='APARATORTOFIJOINICIO'></div>");
			$("#"+dienteInicio+"-C5"+" > #APARATORTOFIJOINICIO").css(cssAparatOrtoFijoUno);
			$("#"+dienteFin+"-C5").append("<div id='APARATORTOFIJOFIN'></div>");
			$("#"+dienteFin+"-C5"+" > #APARATORTOFIJOFIN").css(cssAparatOrtoFijoDos);

			var topLeft1=posicionDienteUno.left;
			var topLeft2=posicionDienteDos.left;
			var topWidth=(topLeft1-topLeft2)<0?(topLeft1-topLeft2)*(-1):(topLeft1-topLeft2);
			topWidth=topWidth+20;
			cssAparatOrtoFijoConector=
			{
				"border-top": "1px solid black",
				"height": "10px",
				"left": "0px",
				"position": "absolute",
				"top": "-20px",
				"width": ""+topWidth.toString()+"px"
			};
			$("#"+dienteInicio+"-C5").append("<div id='APARATORTOFIJOCONECTOR'></div>");
			$("#"+dienteInicio+"-C5"+" > #APARATORTOFIJOCONECTOR").css(cssAparatOrtoFijoConector);
		}
	}
}

if(dientesAparatOrtoRemovible.length>0)
{
	var cssAparatOrtoRemovibleUno=
	{
		"height": "10px",
		"left": "-10px",
		"position": "absolute",
		"top": "-25px",
		"width": "0px"
	};

	var cssAparatOrtoRemovibleDos=
	{
		"height": "10px",
		"left": "30px",
		"position": "absolute",
		"top": "-25px",
		"width": "0px"
	};

	var cssAparatOrtoRemovibleConector;

	dientesAparatOrtoRemovible.sort();
	var dientesAparatOrtoRemovibleUno=dientesAparatOrtoRemovible[0];
	var dientesAparatOrtoRemovibleDos;
	for(var i=0; i<dientesAparatOrtoRemovible.length; i++)
	{
		if(i<dientesAparatOrtoRemovible.length-1)
		{
			if(parseInt(dientesAparatOrtoRemovible[i].substring(1, 3))==parseInt(dientesAparatOrtoRemovible[i+1].substring(1, 3))-1)
			{
				continue;
			}
			else
			{
				dientesAparatOrtoRemovibleDos=dientesAparatOrtoRemovible[i];
				var posicionDienteUno=$("#"+dientesAparatOrtoRemovibleUno).position();
				var posicionDienteDos=$("#"+dientesAparatOrtoRemovibleDos).position();
				var dienteInicio=posicionDienteUno.left<posicionDienteDos.left?dientesAparatOrtoRemovibleUno:dientesAparatOrtoRemovibleDos;
				var dienteFin=posicionDienteUno.left>posicionDienteDos.left?dientesAparatOrtoRemovibleUno:dientesAparatOrtoRemovibleDos;
				$("#"+dienteInicio+"-C5").append("<div id='APARATORTOREMOVIBLEINICIO'></div>");
				$("#"+dienteInicio+"-C5"+" > #APARATORTOREMOVIBLEINICIO").css(cssAparatOrtoRemovibleUno);
				$("#"+dienteFin+"-C5").append("<div id='APARATORTOREMOVIBLEFIN'></div>");
				$("#"+dienteFin+"-C5"+" > #APARATORTOREMOVIBLEFIN").css(cssAparatOrtoRemovibleDos);

				var topLeft1=posicionDienteUno.left;
				var topLeft2=posicionDienteDos.left;
				var topWidth=(topLeft1-topLeft2)<0?(topLeft1-topLeft2)*(-1):(topLeft1-topLeft2);
				topWidth=topWidth+40;
				var iteraciones=-1;
				do
				{
					var leftActual=10*iteraciones;
					cssAparatOrtoRemovibleConector=
					{
						"border-top": "1px solid black",
						"border-right": "1px solid black",
						"height": "7px",
						"left": leftActual+"px",
						"position": "absolute",
						"top": "-20px",
						"width": "7px",
						"-webkit-transform": "rotate(-45deg)"
					};
					$("#"+dienteInicio+"-C5").append("<div id='APARATORTOREMOVIBLECONECTOR"+iteraciones+"'></div>");
					$("#"+dienteInicio+"-C5"+" > #APARATORTOREMOVIBLECONECTOR"+iteraciones).css(cssAparatOrtoRemovibleConector);
					iteraciones++;
				}
				while(leftActual+$("#"+dienteInicio).position().left-15<=$("#"+dienteFin).position().left);

				dientesAparatOrtoRemovibleUno=dientesAparatOrtoRemovible[i+1];
			}
		}
		else
		{
			dientesAparatOrtoRemovibleDos=dientesAparatOrtoRemovible[i];
			var posicionDienteUno=$("#"+dientesAparatOrtoRemovibleUno).position();
			var posicionDienteDos=$("#"+dientesAparatOrtoRemovibleDos).position();
			var dienteInicio=posicionDienteUno.left<posicionDienteDos.left?dientesAparatOrtoRemovibleUno:dientesAparatOrtoRemovibleDos;
			var dienteFin=posicionDienteUno.left>posicionDienteDos.left?dientesAparatOrtoRemovibleUno:dientesAparatOrtoRemovibleDos;
			$("#"+dienteInicio+"-C5").append("<div id='APARATORTOREMOVIBLEINICIO'></div>");
			$("#"+dienteInicio+"-C5"+" > #APARATORTOREMOVIBLEINICIO").css(cssAparatOrtoRemovibleUno);
			$("#"+dienteFin+"-C5").append("<div id='APARATORTOREMOVIBLEFIN'></div>");
			$("#"+dienteFin+"-C5"+" > #APARATORTOREMOVIBLEFIN").css(cssAparatOrtoRemovibleDos);

			var topLeft1=posicionDienteUno.left;
			var topLeft2=posicionDienteDos.left;
			var topWidth=(topLeft1-topLeft2)<0?(topLeft1-topLeft2)*(-1):(topLeft1-topLeft2);
			topWidth=topWidth+40;
			var iteraciones=-1;
			do
			{
				var leftActual=10*iteraciones;
				cssAparatOrtoRemovibleConector=
				{
					"border-top": "1px solid black",
					"border-right": "1px solid black",
					"height": "7px",
					"left": leftActual+"px",
					"position": "absolute",
					"top": "-20px",
					"width": "7px",
					"-webkit-transform": "rotate(-45deg)"
				};
				$("#"+dienteInicio+"-C5").append("<div id='APARATORTOREMOVIBLECONECTOR"+iteraciones+"'></div>");
				$("#"+dienteInicio+"-C5"+" > #APARATORTOREMOVIBLECONECTOR"+iteraciones).css(cssAparatOrtoRemovibleConector);
				iteraciones++;
			}
			while(leftActual+$("#"+dienteInicio).position().left-15<=$("#"+dienteFin).position().left);
		}
	}
}